<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();

$objLay=new Layout(HTML_LAYOUT);
$objCad=$objLay->open(DIR_HTML.$_GET['loc'].'.htm');

$objLay->make($objCad);
?>