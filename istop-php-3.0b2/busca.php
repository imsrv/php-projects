<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();
$objLay=new Layout(HTML_LAYOUT);
$objCad=new Layout(HTML_BUSCA);

$arRes=$objDB->getAll("SELECT Id, cadSnome, cadDesc, cliques, votos FROM cadastros
WHERE MATCH(cadSnome,cadDesc,cadUrl) AGAINST('$_POST[str]')");

$objCad->replace_once('str',$_POST['str']);
$objCad->replace_once('numres',count($arRes));

for($n=1;$n<count($arRes)+1;$n++){
	$arRes[$n-1]['n']=(string)$n;
	$arRes[$n-1][2]=ereg_replace("\n",'',$arRes[$n-1][2]);
	$arRes[$n-1][2]=ereg_replace("\r",'',$arRes[$n-1][2]);
	$arRes[$n-1][1]=htmlspecialchars($arRes[$n-1][1]);
	$arRes[$n-1][2]=htmlspecialchars($arRes[$n-1][2]);
}

$objCad->loop_replace(0,$arRes);

$objLay->make($objCad);
$objDB->disconnect();

?>