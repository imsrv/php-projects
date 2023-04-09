#!/usr/bin/php -q
<?php
#
# A php script to handle ADSL logging. This script is run every so often
# and stores ADSL transfer statistics in a MySQL database for further
# processing.
# 
# This script is meant to be run from the command line, not from a webpage
#
# Peter van Es, 06 June 2002
# version 1.0
#

# table for storing hourly rates
# create table adsl_log (
#  year  integer DEFAULT '0' NOT NULL,
#  month integer DEFAULT '0' NOT NULL,
#  day   integer DEFAULT '0' NOT NULL,
#  hour  integer DEFAULT '0' NOT NULL,
#  rx    bigint UNSIGNED DEFAULT '0',
#  tx    bigint UNSIGNED DEFAULT '0'
#);
#
# Note: table lastrec (same layout) contains a record of the last logged
# action 

# change these values to adjust for your database
$db_user = "username";
$db_pass = "password";

# Returns an array of all network devices
# and their tx/rx stats.
function sys_netdevs ()
{
    $results = array();
 
    if ($fd = fopen('/proc/net/dev', 'r')) {
        while ($buf = fgets($fd, 4096)) {
            if (preg_match('/:/', $buf)) {
                list($dev_name, $stats_list) = preg_split('/:/', $buf, 2);
                $stats = preg_split('/\s+/', trim($stats_list));
                $results[$dev_name] = array();
 
                $results[$dev_name]['rx_bytes'] = $stats[0];
                $results[$dev_name]['rx_packets'] = $stats[1];
                $results[$dev_name]['rx_errs'] = $stats[2];
                $results[$dev_name]['rx_drop'] = $stats[3];
 
                $results[$dev_name]['tx_bytes'] = $stats[8];
                $results[$dev_name]['tx_packets'] = $stats[9];
                $results[$dev_name]['tx_errs'] = $stats[10];
                $results[$dev_name]['tx_drop'] = $stats[11];
 
                $results[$dev_name]['errs'] = $stats[2] + $stats[10];
                $results[$dev_name]['drop'] = $stats[3] + $stats[11];
            }
        }
    }
    return $results;
}

# main program

# First get the values we want, using cat /proc/net/dev
# and sys_netdevs
#

$net = sys_netdevs();
$newrx = 0;
$newtx = 0;

# get the numbers for the ppp0 device 
while (list($dev, $stats) = each($net)) {
    $d = trim($dev);
    $rx = $stats['rx_bytes'];
    $tx = $stats['tx_bytes'];
    if ($d == "ppp0") {
	$newrx = $rx;
	$newtx = $tx;
    }
}
 

# get the current time
$now = time();
$year = date("Y",$now);
$month = date("m", $now);
$day = date("d", $now);
$hour = date("H", $now); # 24 hour format

# debug
# print ("Date: $year $month $day $hour\n");

# Open the database

$link = mysql_connect("localhost", $db_user, $db_pass)
        or die ("Could not connect to MySQL\n");
mysql_select_db ("adsl")
        or die ("Could not select database adsl\n");

# First get the last record from the lastrec table.    
$query = "SELECT * FROM lastrec";
$result = mysql_query ($query)
          or die ("Query failed\n");

# Note: to supress MySQL error messages prefix functions with @

if (mysql_num_rows($result) == 0) {
   # this is the first time we run this, or the database is corrupted
   # just add the current information and exit
   $query = "INSERT INTO lastrec VALUES ($year, $month, $day, $hour, $newrx, $newtx)";
   print ("Query string: $query\n");
   $result = mysql_query ($query)
        or die ("Insert of lastrec failed\n");
   if (mysql_affected_rows($link) != 1)
	die ("Failed to insert new lastrec\n");
} else {
   # get the information from the current record, to do our sums
   while ($r = mysql_fetch_array($result)) {
       extract($r, EXTR_PREFIX_ALL, "r");
   }
   # now we have variables $r_rx etc available 
   # Verify if at least an hour has passed
   if (($day != $r_day) or ($hour > $r_hour)) {
       # an hour has passed, calculate the deltas
       if ($newrx > $r_rx) {
		$delta_rx = $newrx - $r_rx;
       } else {
		$delta_rx = $newrx;
       }
       if ($newtx > $r_tx) {
		$delta_tx = $newtx - $r_tx;
       } else {
		$delta_tx = $newtx;
       }
       # insert the new record in the adsl_log database
       $query = "INSERT INTO adsl_log VALUES ($year, $month, $day, $hour, $delta_rx, $delta_tx)";
       $result = mysql_query ($query)
             or die ("Insert of adsl_log failed\n");
       if (mysql_affected_rows($link) != 1)
             die ("Failed to insert new adsl_log record\n");

       # delete the lastrec record
       $query = "DELETE FROM lastrec";
       $result = mysql_query ($query)
             or die ("Delete of lastrec failed\n");
       $query = "INSERT INTO lastrec VALUES ($year, $month, $day, $hour, $newrx, $newtx)";
       $result = mysql_query ($query)
             or die ("Insert of lastrec failed\n");
       if (mysql_affected_rows($link) != 1)
             die ("Failed to insert new lastrec\n");
   } else die ("adsllog run within one hour of previous run\n");
}
mysql_close($link);

?>
