<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();
$objLay=new Layout(HTML_LAYOUT);

SESSION_START();

if(!logou()){
	Header("Location: ".HTTP_SUACONTA);
	exit;
}

$objCad=new Layout(HTML_CODE);
$objCad->replace_once('url',HTTP_VOTAR."?id=".$_SESSION['info']['Id']);
$objCad->replace_once('selo',HTTP_SELOS.IMG_SELO);

$objLay->make($objCad);
$objDB->disconnect();
?>