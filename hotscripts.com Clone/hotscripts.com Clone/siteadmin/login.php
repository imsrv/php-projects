<?
include "session.php";
include_once "../config.php";

if(!isset($_REQUEST['UserName']) || ($_REQUEST['UserName']=="") || !isset($_REQUEST['Password']) || ($_REQUEST['Password']=="") )
{
 header("Location: ". "signinform.php?msg=".urlencode("Please enter login information!"));
 die();
}

$sql = "SELECT * FROM sbwmd_admin WHERE admin_name = '" . $_REQUEST['UserName'] . 
    "' AND pwd = '" . $_REQUEST['Password'] . "'" ;

$rs_query=mysql_query($sql);
if ( $rs=mysql_fetch_array($rs_query)  )
{
if($rs["pwd"]===$_REQUEST['Password'])
{
$_SESSION["name"]=$rs["admin_name"] ;
$_SESSION["adminid"]=$rs["id"] ;
header("Location: ". "adminhome.php?pg=1&msg=welcome ".$_SESSION["name"]);
die();
}
}
header("Location: ". "signinform.php?msg=". urlencode("Please enter correct login information!") );
die();
?>
