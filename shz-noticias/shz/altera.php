<?php
// Incuindo o arquivos de configurações
include "stl.php";
include "config.php";
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

// Selecionando os dados da tabela em ordem decrescente
@$sql = "SELECT * FROM $dbtb ORDER BY id DESC";

// Executando $sql e verificando se tudo ocorreu certo.
@$resultado = mysql_query($sql)

// Menssagen de erro.
or die ("<font color=$colortex size=$sizetex2><B>Não foi possível realizar a consulta ao banco de dados</B></font><font size=$sizetex><BR><BR><a href=http://$esite/admin.php?viewby=alterar>VOLTAR</a></font>");

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
echo "<td width=30><font color=$colortex size='$sizetex'><B>Ver</B></font></td>";;
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
echo "<td width=50><font color=$colortex size='$sizetex'><a href='alterar.php?id=$id'>Alterar</a></font></td>";
echo "</tr>";

}

echo "</table>";

?>
</html>
