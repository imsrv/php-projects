<?
require_once('config.php');
require_once('layout.php');
$objDB=start_db();

$objLay=new Layout(HTML_LAYOUT);
$objCad=new Layout(HTML_VENCEDORES);

$objLay->make($objCad);

?>