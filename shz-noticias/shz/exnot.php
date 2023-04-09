<?php
//Arquico com estilo de link
include "stl.php";
// Incuindo o arquivo de configuração
include("config.php");
?>
<html>
<?
//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<?
// Conectando com o banco de dados.
@$conexao = mysql_connect($dbserver, $dbuser, $dbpass);

// Selecionando a base de dados.
@$db = mysql_select_db("$dbname");

// Selecionando todos dados.
@$sql = "SELECT * FROM $dbtb WHERE id='$id'";
@$resultado = mysql_query($sql)
or die ("<font color=$colortex size=$sizetex2>Não foi possível realizar a consulta ao banco de dados</font>
<a href=http://$esite/admin.php><font size=$sizetex><B>Voltar!</B></font>");

// Organizando os dados.
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

//Formatando data e hora para formatos Brasileiros
$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";

// Transformando tudo em HTML.
echo "<hr>";
echo "<b><font color=$colortex size=$sizetex>$titulo</font></b>";
echo "<BR> <font color=$colortex size=$sizetex>$novadata - $novahora </font><br>";
echo "<font color=$colortex size=$sizetex>$texto</font>";
echo "<br><br>";
echo "<font color=$colortex size=$sizetex1><I>Fonte: $fonte <br><a href=http://$endfonte>$endfonte</a> <br>Contato com SHZ ($email)</I></font>";
echo "<hr><CENTER>";
echo "<font size=$sizetex><a href=javascript:history.back()>VOLTAR <=</a>
<a href='excluir.php?id=$id'>=> EXCLUIR</a></font>";

}

?>
</html>
