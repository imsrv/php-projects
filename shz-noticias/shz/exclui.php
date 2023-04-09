<?php
//Arquico com estilo de link
include "stl.php";
//Arquivo de configuração
include "config.php";

//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<html>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<?
// Conectando com o banco de dados.
$conexao = mysql_connect($dbserver, $dbuser, $dbpass);

// Selecionando a base de dados.
$db = mysql_select_db("$dbname");

// Selecionando os dados da tabela em ordem decrescente
$sql = "SELECT * FROM $dbtb ORDER BY id DESC";

// Executando $sql e verificando se tudo correu certo.
$resultado = mysql_query($sql)

// Menssagen de erro.
or die ("Não foi possível realizar a consulta ao banco de dados");

// Tabela de para exibição dos dados selecionados.
echo "<table width=640 border=1 cellpadding=1 cellspacing=1>";
echo "<tr>";
echo "<td width=15><font color=$colortex size='$sizetex'><B>ID:</B></font></td>";
echo "<td width=35><font color=$colortex size='$sizetex'><B>Fonte:</B></font></td>";
echo "<td width=50><font color=$colortex size='$sizetex'><B>Email:</B></font></td>";
echo "<td width=30><font color=$colortex size='$sizetex'><B>Data:</B></font></td>";
echo "<td width=30><font color=$colortex size='$sizetex'><B>Hora:</B></font></td>";
echo "<td width=100><font color=$colortex size='$sizetex'><B>Título:</B></font></td>";
echo "<td width=15><font color=$colortex size='$sizetex'><B>Disponível?</B></font></td>";
echo "<td width=30><font color=$colortex size='$sizetex'><B>Ver</B></font></td>";
echo "<td width=30><font color=$colortex size='$sizetex'><B>Excluir</B></font></td>";
echo "</tr>";

//Realizando um loop para exibição de todos os dados 
while ($linha=mysql_fetch_array($resultado)) {
$id = $linha["id"];
$fonte = $linha["fonte"];
$endfonte = $linha["endfonte"];
$email = $linha["email"];
$data = $linha["data"];
$hora = $linha["hora"];
$titulo = $linha["titulo"];
$ver = $linha["ver"];
$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";


echo "<tr>";
echo "<td width=15><font color=$colortex size='$sizetex'>$id</font><br></td>";
echo "<td width=35><font color=$colortex size='$sizetex'>$fonte</font><br></td>";
echo "<td width=50><font color=$colortex size='$sizetex'>$email</font><br></td>";
echo "<td width=30><font color=$colortex size='$sizetex'>$novadata</font><br></td>";
echo "<td width=30><font color=$colortex size='$sizetex'>$novahora</font><br></td>";
echo "<td width=100><font color=$colortex size='$sizetex1'>$titulo</font><br></td>";
echo "<td width=15><font color=$colortex size='$sizetex'>$ver</font><br></td>";
echo "<td width=50><font color=$colortex size='$sizetex'><a href='exnot.php?id=$id'>Ver</a></font></td>";
echo "<td width=50><font color=$colortex size='$sizetex'><a href='excluir.php?id=$id'>Excluir</a></font></td>";
echo "</tr>";

}

echo "</table>";

?>
</html>
