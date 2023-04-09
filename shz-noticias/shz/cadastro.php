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
// Pegando data e hora.
$data = date("Y-m-d");
$hora = date("H:i:s");
//Formatando data e hora para formatos Brasileiros.
$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";

// Formulario de cadastro de noticias

echo "<table border=0 cellpadding=1 cellspacing=1>";

echo "<form action='valida.php' method='post'>";
echo "<tr><td><font color=$colortex size=$sizetex>Fonte:</font></td><td><input name='fonte' type='text' size=30><td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Site fonte: <br><i>Sem http:// (Ex. www.shz.com.br)</i></font></td><td><input name='endfonte' type='text' size=30></td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Email: <br><i>(Exemplo: david@shz.com.br)</i></td><td><input name='email' type='text' size=30><td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Título do Texto:</font></td><td><input name='titulo' type='text' size=30><td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Subtítulo do Texto:</font></td><td><textarea name='subtitulo' rows=5 cols=30></textarea><td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Texto:<br><i>Somente as quebras de linha são automaticas <br>o resto da formatação não são automaticas.<br>
Para formatação use comandos <B>html</b>!</font></td><td><textarea name='texto' rows=10 cols=30></textarea><td></tr>";
echo "<tr><td><font color=$colortex size=$sizetex>Exibir?<br><I>Se selecionar a opção NÃO a notícia será <BR>cadastrada mas não será exibida. </font>
</td><td><SELECT NAME='ver' SIZE='2'>
<OPTION VALUE='on' SELECTED>SIM
<OPTION VALUE='off'>NÃO</SELECT></td>";
echo "<input name='data' type='hidden' value='$data'><input name='hora' type='hidden' value='$hora'>";
echo "<tr><td></td><td align='right'><input type='submit' value='Cadastrar'></td></tr>";
echo "</form>";
echo "<br></table>";
echo "<font color=$colortex size=$sizetex1><i>Todos os campos são obrigatórios no cadastro.<br>";
echo "<b>Observação</b>: Será inserido no seu cadastro a data atual, bem como a hora atual do cadastro<br>";
echo "Data: $novadata - Hora: $novahora<br></font>";

?>
</html>
