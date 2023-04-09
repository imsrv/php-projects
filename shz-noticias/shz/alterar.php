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

// Conectando ao banco de dados.
@$conexao = mysql_connect($dbserver, $dbuser, $dbpass);

// Selecionando a base de dados.
@$db = mysql_select_db("$dbname");

// Selecionando na tablela os dados necessarios.
@$sql = "SELECT * FROM $dbtb WHERE id='$id'";

// Executando $sql e verificando se tudo ocorreu certo.
@$resultado = mysql_query($sql)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2><B>Não foi possível realizar a consulta ao banco de dados</B></font><font size=$sizetex><BR><BR><a href=http://$esite/admin.php?viewby=alterar>VOLTAR</a></font>");

// Pegando os dados.
while ($linha=mysql_fetch_array($resultado)) {
$id = $linha["id"];
$fonte = $linha["fonte"];
$endfonte = $linha["endfonte"];
$email = $linha["email"];
$data = $linha["data"];
$hora = $linha["hora"];
$titulo = $linha["titulo"];
$subtitulo = $linha["subtitulo"];
$texto = $linha["texto"];
$ver = $linha["ver"];

$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";

// Formulario de alteração dos dados com os dados antigos como defaut.
echo "<font size=$sizetex2><b>Alterar Cadastro...</b></font>";
echo "<hr>";
echo "<table border=0 cellpadding=1 cellspacing=1>";
echo "<form action='alterar_db.php?id=$id' method='post'>";
echo "<tr><td><font color=$colortex size=$sizetex>Código da Notícia: </font></td><td><input name='id_novo' type='text' value='$id' size=20></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Data: </font></td><td><font size=$sizetex>$novadata</font></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Hora: </font></td><td><font size=$sizetex>$novahora</font></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Fonte:</font></td><td><input name='fonte_novo' type='text' value='$fonte' size=30> </td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Site fonte:</font></td><td><input name='endfonte_novo' type='text' value='$endfonte' size=30> </td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Email: <i>(Exemplo: david@shz.com.br)</i></font></td><td><input name='email_novo' type='text'
value='$email' size=30><br></font></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Título do Texto:</font></td><td><input name='titulo_novo' type='text' value='$titulo' size=30></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Subtítulo do Texto:</font></td><td><textarea name='subtitulo_novo' rows=5 cols=30>$subtitulo</textarea></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Texto:</font></td><td><textarea name='texto_novo' rows=10 cols=30>$texto</textarea> </td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Disponibilizar? (on ou off): </font></td><td><input name='ver_novo' type='text' value='$ver' size=5></td></tr>";
echo "<tr><td><input type='submit' value='Alterar'></td></tr>";
echo "</form></table>";
echo "<br><hr>";
}
echo "<font color=$colortex size=$sizetex><a href=javascript:history.back()><b>VOLTAR</b></a></font></center>";
?>
