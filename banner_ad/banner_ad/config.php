<?
/* TH-Rotating Banner Ad is copyright toddhost.com
   You may use this script free as long as you do not remove this notice
   or the link to our website.
*/
// Change to your password
$DPass="your_password";
// Change to your username
$DUser="user";
// Enter host name if localhost doesn't work on your sever
$DHost="localhost";
//Change to name of your database
$DBase="database_name";

$dbID = mysql_pconnect($DHost, $DUser, $DPass);
mysql_select_db($DBase, $dbID);

?>
