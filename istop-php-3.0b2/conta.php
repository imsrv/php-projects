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

if(@$_GET['a']=='logout'){
	SESSION_UNSET();
	SESSION_DESTROY();
	Header("Location: ".HTTP_SUACONTA);
	exit;
}

$resDB=$objDB->query("SELECT cadSnome, Votos, catNome, cadCategoria, Votos FROM cadastros LEFT JOIN categorias ON cadCategoria=categorias.Id WHERE cadastros.Id='".$_SESSION['info']['Id']."'");

$resDB->fetchinto($arDados);
$resDB->free();

$vthj=0;
$lines=array();
if(file_exists(DIR_LOG.date('d-m-Y')))
	$lines=@file(DIR_LOG.date('d-m-Y'));

if(count($lines)>0){
	foreach($lines as $li){
		list($a,$b,$c)=explode("|",$li);
		if($_SESSION['info']['Id']==(int)trim($a))
			$vthj++;
	}
}

$posge=$objDB->getOne("SELECT count(*)+1 FROM cadastros WHERE votos>'".$arDados[1]."'");

$poscat=$objDB->getOne("SELECT count(*)+1 FROM cadastros WHERE votos>'".$arDados[1]."' and cadCategoria='".$arDados[3]."'");

$objCad=$objLay->open(HTML_CONTA);
$objCad->replace(1,$arDados);
$objCad->replace_once('vthj',$vthj);
$objCad->replace_once('poscat',$poscat);
$objCad->replace_once('posge',$posge);
$objLay->make($objCad);
$objDB->disconnect();
?>