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

// Selecionando os dados pedido no banco de dados.
@$sql = "SELECT * FROM $dbtb WHERE id='$id'";

//Executando $sql
@$resultado = mysql_query($sql)

//Mensagem de erro
or die ("<font color=$colortex size=$sizetex2><B>Não foi possível realizar a consulta ao banco de dados</B></font><font size=$sizetex><BR><BR>
<font color=$colortex size=$sizetex><a href=javascript:window.close()><b>FECHAR</b></a></font>");

echo "<img src='img/noticias.gif'><br>";
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
$atualiza = $linha["atualiza"];

$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";

// Formatando o que vai ser exibido ao usuario.
echo "<hr>";
$texto = nl2br( $texto );
echo "<b><font color=$colortex size=$sizetex>$titulo</font></b>";
if ($atualiza > 1) {
echo "<img src=http://$esite/img/a.gif>"; }
echo "<BR><font color=$colortex size=$sizetex> $novadata - $novahora </font><br><br>";
echo "<font color=$colortex size=$sizetex>$texto</font>";
echo "<br><br>";
echo "<font color=$colortex size=$sizetex1><I>Fonte: <a href=http://$endfonte>$fonte</a> <br>Contato ($email)</I></font>";
echo "<hr>";
echo "<center><font color=$colortex size=$sizetex><a href=javascript:window.close()><b>FECHAR</b></a> - </font>";
echo "<font color=$colortex size=$sizetex><a href=http://$esite/list.php><B><font size=2>LISTAR TODAS</font></B></a></font></center>";
}

?>
</html>
