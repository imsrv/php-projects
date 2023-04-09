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
// Executando $sql e verificando se tudo ocorreu certo.
include "stl.php";
// Muda de 1 para 2 o valor do arualiza
$atualiza_novo = 2;

// Conectando com o banco de dados.
@$conexao = mysql_connect($dbserver, $dbuser, $dbpass);

// Selecionando a base de dados.
@$db = mysql_select_db($dbname);


// Atualizando os dados.
@$sql = "UPDATE $dbtb SET id='$id_novo',fonte='$fonte_novo',endfonte='$endfonte_novo'
,email='$email_novo',titulo='$titulo_novo',subtitulo='$subtitulo_novo'
,texto='$texto_novo',ver='$ver_novo',atualiza='$atualiza_novo' WHERE id='$id'";

// Executando $sql e verificando se tudo ocorreu certo.
@$resultado = mysql_query($sql)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2><B>Não foi possível atualizar banco de dados</B></font><font size=$sizetex><BR><BR><a href=http://$esite/admin.php?viewby=alterar>VOLTAR</a></font>");

// Menssagem de exito.
echo "<font color=$colortex size=$sizetex2><B>Notícia alterada com sucesso!</B></font><font size=$sizetex><BR><BR><a href=http://$esite/admin.php?viewby=alterar>VOLTAR</a></font>";

?>
</html>
