<?php

// Incuindo o arquivo de configuração
include("config.php");
//Arquivo de estilo de link
include "stl.php";

?>
<html>
<?
//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">
<?// Conectando com o banco de dados.
@$conexao = mysql_connect($dbserver, $dbuser, $dbpass);

// Selecionando a base de dados.
@$db = mysql_select_db($dbname);

// Buscar dados em ordem de id Decrescente no banco de dados
@$sql = "SELECT * FROM $dbtb WHERE ver = 'on' ORDER BY id DESC LIMIT 15";

// Irá selecionar as últimas 15 notícias inseridas

// O curioso aqui, é que ele só irá selecionar os campos onde
// estiver o ver=on, e esse campo pode ser mudado com o
// controle de notícias pelo webmaster.

//Executando $sql
@$resultado = mysql_query($sql)

//Mensagem de erro
or die ("<font color=$colortex size=$sizetex2><B>Não foi possível realizar a consulta ao banco de dados</B></font><font size=$sizetex><BR><BR><a href=javascript:history.back()>VOLTAR</a></font>");

// Agora iremos "pegar" cada campo da notícia
// e organizar no HTML
echo "<img src='img/noticias.gif'><BR>";
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

//Formatando data e hora para formato Brasileiro
$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";


// Procurando e inserindo quebras de linha.
$subtitulo = nl2br( $subtitulo );
echo "<br>";
echo "<b><font color=$colortex size=$sizetex><a href='#1'";?> onClick="javascript:window.open('<? echo "http://$esite/not.php?id=$id"; ?>','anteriores','width=450,height=300,scrollbars=yes')"><? echo "$titulo</a></font></b>";
if ($atualiza > 1) {
echo "<img src=http://$esite/img/a.gif>"; }
echo "<br>";
echo "<font color=$colortex size=$sizetex1>$novadata - $novahora </font><br>";
echo "<font color=$colortex size=$sizetex>$subtitulo</font>";
echo "<br><br>";
echo "<font color=$colortex size=$sizetex1><I>Fonte: <a target=endfonte href=http://$endfonte>$fonte</a> <br>Contato
(<a href=mailto:$email>$email</a>)</I></font>";
echo "<hr>";
}
echo "<font color=$colortex size=$sizetex><a href='#1'";?> onClick="javascript:window.open('<? echo "http://$esite/list.php"; ?>','anteriores','width=450,height=300,scrollbars=yes')"<? echo "<B><font size=2>LISTAR TODAS</font></B></a></font>";
echo "<hr>";
?>
</html>
