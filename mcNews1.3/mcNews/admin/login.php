<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net

include ("../conf.inc.php");
if ( $log == $admin_login && $password == $admin_pass )
{
session_start();
session_register("log");
session_register("password");
header ('Location:index.php');
}
else
{
header ('Location:sess.php');
}
?>
