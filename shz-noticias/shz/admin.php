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
	error("Acesso negado! <br> Verifique se a senha digitada é a
    mesma que foi colocada no config.php");
}

?>
<html>
<?
//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<?
//Arquico com estilo de link
include "stl.php";

//Parte integrante deste
include("menuadmin.php");



// Ver Cadastro

if($viewby == "") {

include("cadastro.php");

	}

// Ver Exluir

if($viewby == "excluir") {

include("exclui.php");

       
}

// Ver Alterar

if($viewby == "alterar") {

include("altera.php");

       
}

// Ver Noticias

if($viewby == "ver") {

include("noticias.php");


}

//Ver Backups

if($viewby == "back") {

include("mysql_back.php");

}
?>
</html>
