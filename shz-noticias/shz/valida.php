<?
//Arquivo de estilo de link
include "stl.php";
//Arquivo de configura��es
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
//Aqui ser� verificado se foi digitado alguma coisa em cada campo,
//se n�o tiver nada em um determinado campo ele gera uma mensagem de erro
//se tiver tudo certo ele inclui o arquivo inserir.php
if (empty($fonte)){
 		print "<font color=$colortex size=$sizetex><b>Informe o local original da informa��o!</b><br><i>Ex. IDGNow!</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($endfonte)){
 		print "<font color=$colortex size=$sizetex><b>Informe o endere�o do local original da informa��o!</b><br><i>Ex. www.idgnow.com.br</i><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($email)){
 		print "<font color=$colortex size=$sizetex><b>Informe um e-mail para contato sobre a informa��o!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($titulo)){
 		print "<font color=$colortex size=$sizetex><b>Informe um titulo para a informa��o!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($subtitulo)){
 		print "<font color=$colortex size=$sizetex><b>Informe um resumo (subtitulo) da informa��o!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

if (empty($texto)){
 		print "<font color=$colortex size=$sizetex><b>Coloque no campo texto a informa��o!</b><br><br>
	 	Clique <a href=\"javascript:history.back()\">aqui</a> para Voltar</font>";
 		Exit();
	}

include ("inserir.php");

?>
