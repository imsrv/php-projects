<div align="center">
<?php
require_once"../config.php";
require_once "HTML/QuickForm.php";
aut_admin();

$objDB=start_db();
$res=$objDB->query("SELECT * FROM categorias");
$arRes=sql_assoc_ar($res);
$res->free();

$form = new HTML_QuickForm('edit', 'post');
$form->registerRule('dburl',NULL,'dburlcls');

$header=&$form->addElement('header', 'header', 'Editar Informações');
$form->addElement('hidden', 'Id', 'Nome');
$form->addElement('text', 'cadNome', 'Nome');
$form->addElement('text', 'cadEmail', 'E-Mail');
$form->addElement('text', 'cadSnome', 'Nome do Site');
$form->addElement('text', 'cadUrl', 'Url');
$form->addElement('textarea', 'cadDesc', 'Descrição',"rows=9");
$form->addElement('select', 'cadCategoria', 'Categoria',$arRes);
$form->addElement('text', 'cadSenha', 'Senha','maxlength=10');

$form->addRule('cadEmail','E-Mail inválido','email','','client');
$form->addRule('cadUrl','Já existe outro site com esta url','dburl','','server');

if ($form->validate()) {
	$objDB->autoExecute('cadastros', $_POST, DB_AUTOQUERY_UPDATE," Id='".$_POST['Id']."' ");

	if (DB::isError($objDB)) {
		die ($objDB->getMessage());
	}
	$header->setText('Informações Salvas') ;
	$form->freeze();
}else {
	$res=$objDB->query("SELECT Id, cadNome, cadEmail, cadSnome, cadDesc,cadUrl, cadCategoria, cadSenha FROM cadastros WHERE Id='".$_GET[id]."'");
	$res->fetchInto($arInfo,DB_FETCHMODE_ASSOC);
	$res->free();
	$form->setdefaults($arInfo);
	$form->addElement('submit', '', 'Enviar');
}

for($n=1;$n<count($form->_elements)-1;$n++){
	$v=$form->_elements[$n]->getname();
	$el=$form->getElement($v);
	$form->addRule($v, 'Preencha o campo "'.$el->getLabel().'"', 'required', '', 'client');
}

$form->display(); 

class dburlcls{
    var $name;
    function validate($value){
		GLOBAL $objDB;
		$url=trim($_POST[cadUrl]);
		$url=strtolower($url);

		$numres=$objDB->getOne("SELECT COUNT(*) FROM cadastros WHERE Id!='$_POST[Id]' and cadUrl='$url'");
		if($numres>0)
			return false;	
		else
			return true;
    }
    function setName($ruleName){
        $this->name = $ruleName;
    }
}

?>
</div>