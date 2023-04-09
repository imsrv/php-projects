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
	$post=form_info('cad',$_POST);

	$er=array();

	if(empty($_POST['cadNome']))
		$er[count($er)]='Preencha o campo nome';

	if(empty($_POST['cadEmail']) or !valid_mail($_POST['cadEmail']))
		$er[count($er)]='E-mail invсlido';

	if(empty($_POST['cadSnome']))
		$er[count($er)]='Preencha o campo nome do site';

	if(empty($_POST['cadUrl']) or $_POST['cadUrl']=='http://' or !ereg("http://(.+)",$_POST['cadUrl']))
		$er[count($er)]='Url do website invсlida';

	if(empty($_POST['cadDesc']))
		$er[count($er)]='Preencha o campo descriчуo';

	if($objDB->getOne("SELECT COUNT(*) FROM cadastros WHERE cadUrl='".$post['cadUrl']."' and Id!='".$_SESSION['info']['Id']."'")>0)
		$er[count($er)]='Jс existe outro website cadastrado com esta mesma URL';

	if(count($er)>0){
		$objCad=$objLay->open(HTML_DADOSWEBSITE);
		$objCad->replace('f',$post);
		$objCad->var_loop_replace(0,$er);
	}else{
		unset($post['cadCategoria']);

		$objDB->autoExecute('cadastros', $post, DB_AUTOQUERY_UPDATE," Id='".$_SESSION['info']['Id']."' ");

		if (DB::isError($objDB)) {
			die ($objDB->getMessage());
		}
		
		$objCad=$objLay->open(HTML_DADOSWEBSITE_FINAL);
		$objCad->replace_once('suaconta',HTTP_SUACONTA);
		$objCad->replace('f',$post);
	}
}else{
	$objCad=$objLay->open(HTML_DADOSWEBSITE);
	$resDB=$objDB->query("SELECT cadNome, cadEmail, cadSnome, cadDesc, cadUrl, catNome, cadDesc FROM cadastros LEFT JOIN categorias ON cadastros.cadCategoria=categorias.Id WHERE cadastros.Id='".$_SESSION['info']['Id']."'");
	$resDB->fetchinto($arDados,DB_FETCHMODE_ASSOC);
	$resDB->free();
	
	$objCad->replace('f',$arDados);
}

$objLay->make($objCad);

$objDB->disconnect();
?>