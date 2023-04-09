<?
   $DB_SERVER="xxxxxx";                             // Database Server machine
   $DB_LOGIN="xxxxxx";                             // Database login
   $DB_PASSWORD="xxxxxxxx";                       // Database password
   $DB="xxxxxx";                                 // Database containing the tables
   $HTTP_HOST="http://xxxxxxxxx";               // HTTP Host
   $DOCROOT="banner";                          // Path, where application is installed
$connection = mysql_connect($DB_SERVER, $DB_LOGIN, $DB_PASSWORD)
          or die ("Couldn't connect to server.");

$db = mysql_select_db($DB, $connection)
        or die ("Couldn't select database.");


?>
