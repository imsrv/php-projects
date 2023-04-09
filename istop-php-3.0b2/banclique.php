<?
require_once('config.php');

$objDB=start_db();

$objDB->query("UPDATE banners SET banCl=banCl+1 WHERE Id='$_GET[id]'");
$url=$objDB->getOne("SELECT banUrl FROM banners WHERE Id='$_GET[id]' LIMIT 1");
Header("Location: $url");
?>