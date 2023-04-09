<?

// Incuindo o arquivo de configuração
include("config.php");

//Script de autenticação de usuários
$LOGIN = $nome;
$PASSWORD = $senha;

function error ($error_message) {
	echo $error_message."<BR>";
	exit;
}

if ( (!isset($PHP_AUTH_USER)) || ! (($PHP_AUTH_USER == $LOGIN) && ( $PHP_AUTH_PW == "$PASSWORD" )) ) {
	header("WWW-Authenticate: Basic entrer=\"Form2txt admin\"");
	header("HTTP/1.0 401 Unauthorized");
	error("Acesso negado!");
}

?>
<html>
<?
//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<?php
//Arquico com estilo de link
include "stl.php";

// Conectando com o banco de dados.
@$conexao = mysql_connect($dbserver, $dbuser, $dbpass);

// Selecionando a base de dados.
@$db = mysql_select_db($dbname);

// Deletando os dados selecionados
@$sql = "DELETE FROM $dbtb WHERE id='$id'";

// Executando $sql e verificando se tudo correu certo.
@$resultado = mysql_query($sql)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2>Não foi possível realizar a exclusão dos dados.</font>
<a href=http://$esite/admin.php><font size=$sizetex><B>Voltar!</B></font>");

// Menssagem de exito.
echo "<font color=$colortex size=$sizetex>A notícia foi excluída com êxito!<br><br>
<a href=http://$esite/admin.php?viewby=excluir><B>Voltar!</B></a></font>";

?>
