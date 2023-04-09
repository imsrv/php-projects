<div align="center">
<?php
require_once"../config.php";
require_once"HTML/Table.php";
require_once"HTML/QuickForm.php";
aut_admin();

$objDB=start_db();

// Ações
if($_GET['a']=='rem')
	$objDB->query("DELETE FROM categorias WHERE Id='$_GET[id]' LIMIT 1");
elseif($_GET['a']=='edit'){
	$ar['catNome']=$objDB->getOne("SELECT catNome FROM categorias WHERE Id='$_REQUEST[id]'");

	$form = new HTML_QuickForm('edit', 'post');
	$form->addElement('header', 'header', 'Editar Informações');
	$form->addElement('text', 'catNome', 'Nome da Categoria');
	$form->addElement('hidden', 'id', $_REQUEST[id]);
	$form->addElement('hidden', 'a', 'editb');
	$form->addElement('submit','btnsend','Enviar');	
	$form->setDefaults($ar);
	$form->addrule('catNome','Preencha o campo "Nome da Categoria"','required','','client');
	$form->display(); 
	exit;
}elseif($_REQUEST['a']=='editb'){
	$objDB->query("UPDATE categorias SET catNome='$_REQUEST[catNome]' WHERE Id='$_REQUEST[id]'");
}

$form = new HTML_QuickForm('edit', 'post');

$form->addElement('header', 'header', 'Adicionar Categoria');
$fcatNome=&$form->addElement('text', 'catNome', 'Nome da Categoria');
$form->addElement('submit','btnsend','Enviar');

$fcatNome->setValue('');

if(empty($_REQUEST['a']) and $form->validate()){
	$objDB->query("INSERT INTO categorias VALUES(NULL,'$_POST[catNome]')");
	if (DB::isError($objDB)) {
		die ($objDB->getMessage());
	}
}

// Monta Tabela
$ar=$objDB->getAll("SELECT * FROM categorias");
$atr['bs']=array('style'=>"font-family: verdana, arial; font-size: 8 pt; text-align: center");
$atr['cels']=array('bgcolor'=>"#DDFFDD");
$atr['celtt']=array('bgcolor'=>"#CECEFF",
					'style'=>"font-family: verdana, arial; font-size: 8 pt;  font-weight: bold; text-align: center");
$atr['all']=array('cellpadding'=>2,'style'=>"border: 1 solid #C0C0C0, text-align: center");


$table = new HTML_Table($atr['all']);

$table->setCellContents(0,0,'Resultados da Pesquisa');

$table->setCellContents(1,0,'Id');
$table->setCellContents(1,1,'Website');

for($n=0;$n<count($ar);$n++){
	for($s=0;$s<count($ar[$n]);$s++){
		$table->setCellContents($n+2,$s,$ar[$n][$s]);
	}
	$table->setCellContents($n+2,$s,'<a href="?a=edit&id='.$ar[$n][0].'">Editar</a>');
	$table->setCellContents($n+2,$s+1,'<a href="?a=rem&id='.$ar[$n][0].'">Remover</a>');
}


$table->setAllAttributes($atr['bs']);
$table->updateAllAttributes($atr['cels']);
$table->updateCellAttributes(0,0,' colspan=4');
$table->updateCellAttributes(0,0,$atr['celtt']);
$table->updateRowAttributes(1,$atr['celtt']);

echo $table->toHtml();

$form->addrule('catNome','Preencha o campo "Nome da Categoria"','required','','client');

$form->display(); 

?>
</div>