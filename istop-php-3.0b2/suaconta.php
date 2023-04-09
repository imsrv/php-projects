<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();
$objLay=new Layout(HTML_LAYOUT);

SESSION_START();
if(logou()){
	Header("Location: ".HTTP_CONTA);
	exit;
}

if(isset($_POST['a']) and $_POST['a']=='login'){
	$objRes=$objDB->query("SELECT Id, cadSenha, cadSnome, cadUrl FROM cadastros WHERE (Id='$_POST[login]' or cadUrl='$_POST[login]') and cadSenha='$_POST[senha]' LIMIT 1");

	$objRes->fetchinto($info,DB_FETCHMODE_ASSOC);
	$objRes->free();

	if(empty($_POST['senha']) or $info['cadSenha']!=$_POST['senha']){
		$objCad=$objLay->open(HTML_SUACONTA);
		$objCad->replace_once('erro','Id ou senha inválidos');
		$objCad->replace('f',$_POST);
	}else{
		SESSION_UNREGISTER('info');
		SESSION_REGISTER('info');
		Header("Location: ".HTTP_CONTA);
	}
}else{
	$objCad=$objLay->open(HTML_SUACONTA);
	$objCad->replace_once('erro','');
	$objCad->replace('f',$_POST);
}

$objLay->make($objCad);
$objDB->disconnect();
?>