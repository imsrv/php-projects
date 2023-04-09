<?
include "session.php";
include_once "config.php";

if(!isset($_REQUEST['UserName']) || ($_REQUEST['UserName']=="") || !isset($_REQUEST['Password']) || ($_REQUEST['Password']=="") )
{
 header("Location: ". "signinform.php?msg=".urlencode("Please enter login information!"));
 die();
}

$sql = "SELECT * FROM sbwmd_members WHERE username = '" . $_REQUEST['UserName'] . 
    "' AND pwd = '" . $_REQUEST['Password'] . "'" ;

$rs_query=mysql_query($sql);
if ( $rs=mysql_fetch_array($rs_query)  )
{
if($rs["pwd"]===$_REQUEST['Password'])
{
$_SESSION["name"]=$rs["username"] ;
$_SESSION["userid"]=$rs["id"] ;
header("Location: ". "userhome.php?pg=1&msg=welcome ".$_SESSION["name"]);
die();
}
}
header("Location: ". "signinform.php?msg=". urlencode("Please enter correct login information!") );
die();
?>
