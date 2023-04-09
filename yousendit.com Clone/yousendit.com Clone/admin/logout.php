<?php
session_start();
if(!isset($_SESSION["auid"]) || $_SESSION["auid"]<=0)
{
	header("Location: index.php"); exit;
}
else $auid=$_SESSION["auid"];

require_once("../include/db.php");

$qry="SELECT MAX(timein) FROM ".$db->tb("adminlog")." WHERE uid=$auid";
$db->query($qry);
$row=$db->getrow();
$qry="UPDATE ".$db->tb("adminlog")." SET timeout=".time()." WHERE uid=$auid and timein=".$row[0];
$db->query($qry);
session_unregister("auid");
header("Location: index.php"); exit;
?>