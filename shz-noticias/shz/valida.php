<?
//Arquivo de estilo de link
include "stl.php";
//Arquivo de configurações
include "config.php";
?>
<html>
<?
//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<?
//Aqui será verificado se foi digitado alguma coisa em cada campo,
//se não tiver nada em um determinado campo ele gera uma mensagem de erro
//se tiver tudo certo ele inclui o arquivo inserir.php
if (empty($fonte)){
 		print "<font color=$colortex size=$sizetex><b>Informe o local original da informação!</b><br><i>Ex. IDGNow!</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($endfonte)){
 		print "<font color=$colortex size=$sizetex><b>Informe o endereço do local original da informação!</b><br><i>Ex. www.idgnow.com.br</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($email)){
 		print "<font color=$colortex size=$sizetex><b>Informe um e-mail para contato sobre a informação!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($titulo)){
 		print "<font color=$colortex size=$sizetex><b>Informe um titulo para a informação!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($subtitulo)){
 		print "<font color=$colortex size=$sizetex><b>Informe um resumo (subtitulo) da informação!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($texto)){
 		print "<font color=$colortex size=$sizetex><b>Coloque no campo texto a informação!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

include ("inserir.php");

?>
