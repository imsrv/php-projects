<?

if(empty($_POST['passo'])){
	echo'<h3>Passo 1</h3>';
	echo <<<END
<br>Informações do Mysql
<form method="post">
<input type="hidden" name="passo" value="2">
Servidor:&nbsp;<input type="text" name="DB_HOST" value="localhost"><br>
Usuário:&nbsp;<input type="text" name="DB_USER" value=""><br>
Senha:&nbsp;<input type="text" name="DB_PASS" value=""><br>
Banco de Dados&nbsp;<input type="text" name="DB_NAME" value="istop"><br>
<input type="submit">
</form><br><br>
O instalador tentará criar o banco de dados para a instalação, caso não consiga, você deverá criá-lo manualmente pela administração de seu servidor
END;
}

if($_POST['passo']==2){
	$arq=fopen('config.php',"r+");
	while(!feof($arq)){
		$lin=fgets($arq,1024);
		foreach($_POST as $k=>$v)
			$lin=ereg_replace("'$k','(.+)'","'$k','$v'",$lin);
		$lines.=$lin;
	}
	fclose($arq);

	$arq=fopen('config.php',"w+");
	fseek($arq,0);
	fwrite($arq,$lines);
	fclose($arq);

	mysql_pconnect($_POST['DB_HOST'],$_POST['DB_USER'],$_POST['DB_PASS']);
	mysql_query("CREATE DATABASE ".$_POST['DB_NAME']); 
	echo (mysql_error().'<br><br><br>');

	echo'<h3>Passo 2</h3>';
	echo <<<END
<br>Informações Adicionais
<form method="post">
<input type="hidden" name="DB_NAME" value="$_POST[DB_NAME]">
<input type="hidden" name="passo" value="3">
Username da Administração:&nbsp;<input type="text" name="ADMIN_USER" value="istop"><br>
Senha da Administração:&nbsp;<input type="text" name="ADMIN_SENHA" value="senha"><br>
Url do Topsites:&nbsp;<input type="text" name="HTTP_URL" value="http://www.top.com/">(utilize / no final)<br>

E-Mail:&nbsp;<input type="text" name="SITE_MAIL" value="top@top.com"><br>
Selos:&nbsp;<input type="text" name="HTTP_SELOS" value="http://www.top.com/top/html/imagens/selos/"><br>

<input type="submit">
</form><br><br>

END;
}

if($_POST['passo']=='3'){
	$arq=fopen('config.php',"r+");
	while(!feof($arq)){
		$lin=fgets($arq,1024);
		foreach($_POST as $k=>$v)
			$lin=ereg_replace("'$k','(.+)'","'$k','$v'",$lin);
		$lines.=$lin;
	}
	fclose($arq);

	$arq=fopen('config.php',"w+");
	fseek($arq,0);
	fwrite($arq,$lines);
	fclose($arq);

	$lines=join('',file('istop.sql'));

	mysql_connect($_POST['DB_HOST'],$_POST['DB_USER'],$_POST['DB_PASS']);
	mysql_select_db($_POST['DB_NAME']);
	$lines=ereg_replace("\n\r",'',$lines);
	$lines=ereg_replace("\r\n",'',$lines);
	$lines=ereg_replace("\n",'',$lines);
	$lines=ereg_replace("\r",'',$lines);
	$lines=ereg_replace('"',"'",$lines);

	$aComandos=explode(";",$lines);

	foreach($aComandos as $comando){
		if(!empty($comando))
			mysql_query($comando) or die(mysql_error());
	}
	
	echo"Instalação Concluída";
}

?>