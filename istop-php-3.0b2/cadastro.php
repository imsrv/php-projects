<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();
$objLay=new Layout(HTML_LAYOUT);

if(isset($_REQUEST['a']) and $_REQUEST['a']=='conf'){
	$post=form_info('cad',$_POST);

	$er=array();

	if(empty($_POST['cadNome']))
		$er[count($er)]='Preencha o campo nome';

	if(empty($_POST['cadEmail']) or !valid_mail($_POST['cadEmail']))
		$er[count($er)]='E-mail inválido';

	if(empty($_POST['cadSnome']))
		$er[count($er)]='Preencha o campo nome do site';

	if(empty($_POST['cadUrl']) or $_POST['cadUrl']=='http://' or !ereg("http://(.+)",$_POST['cadUrl']))
		$er[count($er)]='Url do website inválida';

	if(empty($_POST['cadDesc']))
		$er[count($er)]='Preencha o campo descrição';

	if(strlen($_POST['cadSenha'])<5  or strlen($_POST['cadSenha'])>10)
		$er[count($er)]='A senha deve conter no mínimo 5 e no máximo 10 caracteres';

	if($_POST['cadSenha']!=$_POST['conf'])
		$er[count($er)]='A senha e sua confirmação devem estar iguais';

	if($_POST['regras']!='sim')
		$er[count($er)]='Você deve marcar a caixa de concordância com as regras';

	if($objDB->getOne("SELECT COUNT(*) FROM cadastros WHERE cadUrl='".$post['cadUrl']."'")>0)
		$er[count($er)]='Já existe outro website cadastrado com esta mesma URL';

	if(count($er)>0){
		$objCad=$objLay->open(HTML_CADASTRO);
		$objCad->replace('f',$post);
		$objCad->var_loop_replace(0,$er);
	}else{
		$objDB->autoExecute('cadastros', $post, DB_AUTOQUERY_INSERT);

		if (DB::isError($objDB)) {
			die ($objDB->getMessage());
		}
		
		$post['newid']=$objDB->getOne("SELECT Id FROM cadastros WHERE cadUrl='".$post['cadUrl']."'");

		$objCad=$objLay->open(HTML_CADASTRO_FINAL);
		$objCad->replace_once('suaconta',HTTP_SUACONTA);
		$objCad->replace('f',$post);
	}
}else{
	$objCad=$objLay->open(HTML_CADASTRO);
	$objCad->replace('f',array('cadUrl'=>'http://'));
}

$arCats=$objDB->getAll("SELECT Id, catNome FROM categorias ORDER BY 2 ASC");

for($s=0;$s<count($arCats);$s++){ 
	if(isset($_POST['cadCategoria']) and $_POST['cadCategoria']==$arCats[$s][0])
		$arCats[$s]['s']='selected';
	else
		$arCats[$s]['s']='';
}

$objCad->loop_replace(1,$arCats);
$objLay->make($objCad);

$objDB->disconnect();
?>