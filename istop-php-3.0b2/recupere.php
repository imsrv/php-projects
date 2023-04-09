<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();
$objLay=new Layout(HTML_LAYOUT);


if(isset($_POST['a']) and $_POST['a']=='conf'){
	$objRes=$objDB->query("SELECT Id, cadSenha, cadEmail, cadUrl FROM cadastros WHERE Id='$_POST[login]' or cadUrl='$_POST[login]' LIMIT 1");

	$objRes->fetchinto($info,DB_FETCHMODE_ASSOC);
	$objRes->free();

	if(empty($info['cadSenha'])){
		$objCad=$objLay->open(HTML_RECUPERE);
		$objCad->replace_once('erro','Nenhum website encontrado');
		$objCad->replace('f',$_POST);
	}else{
		require_once('class.mail.php');
		$laymail=Layout::open(HTML_RECUPEREMAIL);
		$laymail->replace('f',$info);
		$laymail->replace_once('url',HTTP_SUACONTA);

		$mail=new mail;
		$mail->mensagem=$laymail->code;
		$mail->settype('html');
		$mail->de(SITE_MAIL);
		$mail->setmail($info['cadEmail']);
		$mail->assunto('Recupere sua Senha');
		$mail->send();

		$objCad=new Layout(HTML_RECUPEREFINAL);
		$objCad->replace_once('mail',$info['cadEmail']);
	}
}else{
	$objCad=$objLay->open(HTML_RECUPERE);
	$objCad->replace_once('erro','');
	$objCad->replace('f',$_POST);
}

$objLay->make($objCad);
$objDB->disconnect();
?>