<?

include_once "logincheck.php";
include_once "../config.php";
if ($_REQUEST["yes"]<>"")
{
$id=$_REQUEST["id"];
mysql_query("Delete from sbwmd_softwares where uid =".$id); 
mysql_query("Delete from sbwmd_members  where id =".$id);
$msg=urlencode("Member Deleted Successfully");
}
else
$msg=urlencode("Member cannot be deleted");

header("Location:"."members.php?msg=".$msg);
?>