<div align="center">
<?php
require_once"../config.php";
require_once"HTML/Table.php";
require_once"HTML/QuickForm.php";
aut_admin();

$objDB=start_db();
$resList=$objDB->query("SELECT cadEmail FROM cadastros ORDER BY 1 ASC");
$eList[0]='Todos';
while(list($val)=$resList->fetchRow()){
	$eList[$val]=$val;
}

$resList->free();

$objForm=new HTML_QuickForm('ml','post');
$objForm->addElement('Header','tt','Enviar E-mails');
$list=&$objForm->addElement('Select','list','Para:',$eList,' size="12" ');
$objForm->addElement('Text','assunto','Assunto:');
$objForm->addElement('Textarea','msg','Mensagem:','cols="45" rows="15"');
$radio[0]=&$objForm->createElement('Radio','tipo',NULL,'Texto','txt');
$radio[1]=&$objForm->createElement('Radio','tipo',NULL,'HTML','html');

$list->setSelected(0);
$objForm->addgroup($radio,NULL,'Tipo:','&nbsp;');
$objForm->addElement('Submit',NULL,'Enviar');
$objForm->addRule('assunto','Preencha o campo "assunto"','required',NULL,'client');
$objForm->addRule('msg','Preencha o campo "mensagem"','required',NULL,'client');

if($objForm->validate()){
	require_once("../class.mail.php");
	$objMail=new mail;
	$objMail->de(SITE_MAIL);
	if($_POST['list']=='Todos'){
		$objMail->setlist("SELECT cadEmail FROM cadastros");
	}else{
		$objMail->setmail($_POST['list']);
	}
	$objMail->assunto($_POST['assunto']);
	if($_POST['tipo']=='html')
		$objMail->settype('html');

	$objMail->send();
	echo"<Br><br><center>E-mail enviados</center>";
	exit;
}else
	$radio[1]->setChecked(True);

$objForm->display();
$objDB->disconnect();
?>
</div>