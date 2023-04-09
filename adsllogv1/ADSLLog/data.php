<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

/* this is a module to show ADSL statistics as collected by PvE's logger */
/*                                                                       */
/* version 1.0      06 Jun 2002  Release version with status display     */
/*                  Courtesy of Jasper Boot, http://boot.xs4all.nl/      */
/*                                                                       */
/* version 0.3      01 Oct 2001, Improvements                            */
/*                  Show last 31 days in this month overview             */
/*                  Show last 12 months in year overview                 */
/*                                                                       */
/* version 0.2      24 Sep 2001, Improvements                            */
/*                  Better Konqueror compatibility                       */
/*                  Changes for use with php 4.0                         */
/*                                                                       */
/*                                                                       */
/* version 0.1      31 Aug 2001, Initial release                         */
/*                                                                       */
/*                                                                       */
/* Install this file under phpNuke in                                    */
/* /home/httpd/html/modules/ADSLLog/data.php                             */
/* Ensure "display_errors" in php.ini is "Off"                           */
/*                                                                       */
/* Copyright Peter van Es, 2002                                          */
/*                                                                       */

/* store these variables and replace them with your details */
$db_user = "username";
$db_pass = "password";

if (!eregi("modules.php", $PHP_SELF)) {
    die ("You can't access this file directly...");
}

/* this function plots labels, rx and tx with as largest elememt $mx and $title */
/* it uses the theme currently in use at phpNuke */
function plotarray ($label, $drx, $dtx, $size, $mx, $title) {

    OpenTable2();
    echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\"><tr><td colspan=\"2\">\n";
    echo "<center><font color=\"$textcolor2\"><b> ";
    echo  $title;
    echo " </b></font></center><br></td></tr>\n";
    
    for ($i = 0; $i < $size; $i++) {
        /* calculate the scaled values */
	$sc_rx = (int) round($drx[$i] / $mx * 300);
	$sc_tx = (int) round($dtx[$i] / $mx * 300);
        /* print the line, one each for rx and tx */
        echo "<tr><td>&nbsp; $label[$i]</td><td> rx:</td><td>";
        echo "<img src=\"themes/Bali/images/leftbar.gif\" height=\"15\" width=\"7\">";
#       echo "<img src=\"themes/Bali/images/mainbar.gif\" height=\"15\" width=\" $sc_rx \">";
        echo "<img src=\"themes/Bali/images/mainbar.gif\" height=\"15\" width= $sc_rx >";
        echo "<img src=\"themes/Bali/images/rightbar.gif\" height=\"15\" width=\"7\">";
        echo  $drx[$i];
        echo "</td></tr>\n";

        echo "<tr><td>&nbsp;        </td><td> tx:</td><td>";
        echo "<img src=\"themes/NukeNews/images/leftbar.gif\" height=\"15\" width=\"7\">";
#       echo "<img src=\"themes/NukeNews/images/mainbar.gif\" height=\"15\" width=\" $sc_tx \">";
        echo "<img src=\"themes/NukeNews/images/mainbar.gif\" height=\"15\" width= $sc_tx >";
        echo "<img src=\"themes/NukeNews/images/rightbar.gif\" height=\"15\" width=\"7\">";
        echo $dtx[$i];
        echo "</td></tr>\n";
    }
    echo "</td></tr></table>";
    CloseTable2();
    echo "<br><br>\n";
}


function plot_today () {
    global $year, $month, $day;

    /* check number of records */
    $query = "SELECT COUNT(*) FROM adsl_log";
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }
    $max_rows =(int) mysql_result ($adslresult, 0);
    mysql_free_result($adslresult);

    /* first we collect todays number of records */
    $query = "SELECT day, hour, rx, tx FROM adsl_log ";
    $query .= " ORDER BY year, month, day, hour";
    if ($max_rows >24) {
        /* add a limit statement */
	$start_row = $max_rows - 24;
	$query .= " LIMIT $start_row, 24";
    }
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }

    /* this should have yielded up to 24 records, now create an array with */
    /* the results and get the largest values */
    $max_rtx = 0;
    $rows = mysql_numrows($adslresult);

    /* we create three arrays for the data */
    $rx = array();
    $tx = array();
    $lbl = array();

    for ($j = 0; $j < $rows; $j++) {
	$d = (int) mysql_result ($adslresult, $j, 'day');
        $time = (int) mysql_result ($adslresult, $j, 'hour');
        $t2=$time+1;
        $lbl[$j] = "Day $d: $time:00 - $t2:00";
        $rx[$j] = (int) mysql_result ($adslresult, $j, 'rx');
        $tx[$j] = (int) mysql_result ($adslresult, $j, 'tx');
        if ($rx[$j] > $max_rtx) $max_rtx = $rx[$j];
        if ($tx[$j] > $max_rtx) $max_rtx = $tx[$j];
    }

    mysql_free_result($adslresult);
    /* Now we have array $data and $max_rtx with the largest value, plot it */
    plotarray ($lbl, $rx, $tx, $j, $max_rtx, "ADSL transfers today in Bytes");
}

function plot_average () {
    global $year, $month, $day;

    /* first we collect todays number of records */
    $query = "SELECT hour, rx, tx FROM adsl_hour ORDER BY hour";
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }

    /* this should have yielded up to 24 records, now create an array with */
    /* the results and get the largest values */
    $max_rtx = 0;
    $rows = mysql_numrows($adslresult);

    /* we create three arrays for the data */
    $rx = array();
    $tx = array();
    $lbl = array();

    for ($j = 0; $j < $rows; $j++) {
        $time = (int) mysql_result ($adslresult, $j, 'hour');
        $t2=$time+1;
        $lbl[$j] = "$time:00 - $t2:00";
        $rx[$j] = (int) mysql_result ($adslresult, $j, 'rx');
        $tx[$j] = (int) mysql_result ($adslresult, $j, 'tx');
        if ($rx[$j] > $max_rtx) $max_rtx = $rx[$j];
        if ($tx[$j] > $max_rtx) $max_rtx = $tx[$j];
    }

    mysql_free_result($adslresult);
    /* Now we have array $data and $max_rtx with the largest value, plot it */
    plotarray ($lbl, $rx, $tx, $j, $max_rtx, "Average ADSL per hour in KBytes");
}

function plot_month () {
    global $year, $month, $day;
    global $months;

    /* check number of records */
    $query = "SELECT COUNT(*) FROM adsl_day";
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }
    $max_rows =(int) mysql_result ($adslresult, 0);
    mysql_free_result($adslresult);

    $query = "SELECT month, day, rx, tx FROM adsl_day ";
    $query .= " ORDER BY year, month, day";
    if ($max_rows >31) {
        /* add a limit statement */
	$start_row = $max_rows - 31;
	$query .= " LIMIT $start_row, 31";
    }
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }

    /* this should have yielded up to 31 records, now create an array with */
    /* the results and get the largest values */
    $max_rtx = 0;
    $rows = mysql_numrows($adslresult);

    /* we create three arrays for the data */
    $rx = array();
    $tx = array();
    $lbl = array();

    for ($j = 0; $j < $rows; $j++) {
        $day = (int) mysql_result ($adslresult, $j, 'day');
	$month = (int) mysql_result ($adslresult, $j, 'month');
        $lbl[$j] = $months[(int) $month];
        $lbl[$j] .= "&nbsp;$day";
        $rx[$j] = (int) mysql_result ($adslresult, $j, 'rx');
        $tx[$j] = (int) mysql_result ($adslresult, $j, 'tx');
        if ($rx[$j] > $max_rtx) $max_rtx = $rx[$j];
        if ($tx[$j] > $max_rtx) $max_rtx = $tx[$j];
    }

    mysql_free_result($adslresult);
    /* Now we have array $data and $max_rtx with the largest value, plot it */
    plotarray ($lbl, $rx, $tx, $j, $max_rtx, "ADSL per day in KBytes");
}

function plot_year () {
    global $year, $month, $day;
    global $months;

    /* check number of records */
    $query = "SELECT COUNT(*) FROM adsl_month";
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }
    $max_rows =(int) mysql_result ($adslresult, 0);
    mysql_free_result($adslresult);

    $query = "SELECT month, rx, tx FROM adsl_month ";
    $query .= " ORDER BY year, month";
    if ($max_rows >12) {
        /* add a limit statement */
	$start_row = $max_rows - 12;
	$query .= " LIMIT $start_row, 12";
    }
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }

    /* the results and get the largest values */
    $max_rtx = 0;
    $rows = mysql_numrows($adslresult);

    /* we create three arrays for the data */
    $rx = array();
    $tx = array();
    $lbl = array();

    for ($j = 0; $j < $rows; $j++) {
        $m = (int) mysql_result ($adslresult, $j, 'month');
        $lbl[$j] = $months[$m];
        $rx[$j] = (int) mysql_result ($adslresult, $j, 'rx');
        $tx[$j] = (int) mysql_result ($adslresult, $j, 'tx');
        if ($rx[$j] > $max_rtx) $max_rtx = $rx[$j];
        if ($tx[$j] > $max_rtx) $max_rtx = $tx[$j];
    }

    mysql_free_result($adslresult);
    /* Now we have array $data and $max_rtx with the largest value, plot it */
    plotarray ($lbl, $rx, $tx, $j, $max_rtx, "ADSL per month in MBytes");
}

function Menu() {
    /* first get total statistics todate */
    $query = "SELECT rx, tx FROM lastrec";
    $adslresult = mysql_query($query);
    if (!$adslresult) { echo mysql_errno(). ": ".mysql_error(). "<br>";	exit(); }
    $rx = mysql_result ($adslresult, 0, 0);
    $tx = mysql_result ($adslresult, 0, 1);
    mysql_free_result($adslresult);

    OpenTable();
    echo "<center><b>ADSL Statistics</b><br><br>";
    echo "Received:&nbsp;";
    echo $rx;
    echo "&nbsp; bytes, Transmitted:&nbsp;";
    echo $tx;
    echo "&nbsp; bytes.</center><br><br>";
    CloseTable();
}



/* start of main program */
/* get the current time */

include("header.php");

$index=1;
$now = time();
$year = date("Y",$now);
$month = date("m", $now);
$day = date("d", $now);
$hour = date("H", $now); # 24 hour format
$months = array ( 1 => 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul',
                       'aug', 'sep', 'oct', 'nov', 'dec');

/*  Open the database */

$link = mysql_connect("localhost", $db_user, $db_pass);
if (!$link) {
    echo "Could not connect to MySQL\n";
    exit();
}
mysql_select_db ("adsl");


switch($func) {

    case "today":
    plot_today();
    break;

    case "month":
    plot_month();
    break;

    case "year":
    plot_year();
    break;

    case "average":
    plot_average();
    break;

    default:
    Menu();
    break;

}

/* Print the menu choices at the bottom of each page */
echo "<br><br>\n";
OpenTable2();
echo "<table cellspacing=\"4\" cellpadding=\"2\" border=\"0\" align=\"center\"><tr>\n";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=today\">Today's statistics</a>";
echo "</td>";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=month\">This month's statistics</a>";
echo "</td>";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=year\">This year's statistics</a>";
echo "</td>";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=average\">Average daily profile</a>";
echo "</td>";
echo "</tr></table><br><br>\n";
CloseTable2();


mysql_close($link);
include ("footer.php");

?>
