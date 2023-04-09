<?
//Arquico com estilo de link
include "stl.php";
// Incuindo o arquivo de configuração
include("config.php");

//Script de autenticação de usuários
$LOGIN = $nome;
$PASSWORD = $senha;

function error ($error_message) {
	echo $error_message."<BR>";
	exit;
}

$atualiza = "1";
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

<?

@$sql = "INSERT INTO $dbtb (fonte, endfonte, email, data, hora, titulo, subtitulo, texto, atualiza, ver) VALUES ('$fonte', '$endfonte',
'$email', '$data', '$hora', '$titulo', '$subtitulo', '$texto', '$atualiza', '$ver')";

//Agora é hora de contatar o mysql

// Conectando com o banco de dados.
@$conexao = mysql_connect($dbserver, $dbuser, $dbpass)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2>Configuração de Banco de Dados Errada!</font>
<a href=http://$esite/admin.php><font size=$sizetex><B>Voltar!</B></font>");

// Selecionando a base de dados.
@$db = mysql_select_db($dbname)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2>Banco de Dados Inexistente!</font>
<a href=http://$esite/admin.php><font color=$colortex size=$sizetex><B>Voltar!</B></font>");

//Inserindo os dados
@$sql = mysql_query($sql)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2>Houve erro na gravação dos dados, por favor, clique em voltar e verifique os campos obrigatórios!</font>
<a href=http://$esite/admin.php><font size=$sizetex><B>Voltar!</B></font>");


// Menssagem de exito.
echo "<font color=$colortex size=$sizetex2><b>Cadastro efetuado com sucesso!</b></font><br>
<a href=http://$esite/admin.php><font size=$sizetex><B>Voltar!</B></font></a>";


?>
