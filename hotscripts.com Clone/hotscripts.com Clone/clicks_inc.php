<?
include_once "config.php";
if(isset($_REQUEST["id"]))
{
$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_softwares where id=" . $_REQUEST["id"] ));
if($_REQUEST["click"]==1)
{
mysql_query("update sbwmd_softwares set downloads=".($rst["downloads"]+1)." where id=" . $_REQUEST["id"] );
header("Location:"."".$_REQUEST["url"]);
}
if($_REQUEST["click"]==2)
{
mysql_query("update sbwmd_softwares set hits_dev_site=".($rst["hits_dev_site"]+1)." where id=" . $_REQUEST["id"] );
header("Location:"."".$_REQUEST["url"]);
}

}

?>