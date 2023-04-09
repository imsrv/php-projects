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

if(isset($_REQUEST['a']) and $_REQUEST['a']=='conf'){
	$er=array();
	$senha=$objDB->getOne("SELECT cadSenha FROM cadastros WHERE Id='".$_SESSION['info']['Id']."'");

	if($_POST['atual']!=$senha)
		$er[count($er)]='Sua senha atual está incorreta';

	if(strlen($_POST['nova'])<5  or strlen($_POST['nova'])>10)
		$er[count($er)]='Sua nova senha deve conter no mínimo 5 e no máximo 10 caracteres';

	if(count($er)>0){
		$objCad=$objLay->open(HTML_ALTSENHA);
		$objCad->var_loop_replace(0,$er);
	}else{
		$objDB->autoExecute('cadastros', array('cadSenha'=>$_POST['nova']), DB_AUTOQUERY_UPDATE," Id='".$_SESSION['info']['Id']."' ");

		if (DB::isError($objDB)) {
			die ($objDB->getMessage());
		}
		
		$objCad=$objLay->open(HTML_ALTSENHAFIM);
		$objCad->replace_once('suaconta',HTTP_SUACONTA);
	}
}else
	$objCad=$objLay->open(HTML_ALTSENHA);

$objLay->make($objCad);

$objDB->disconnect();
?>