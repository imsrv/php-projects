<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
include "stop.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Newsletter :: Atualiza&ccedil;&otilde;es em www.web-tools.kit.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
@import url("../estilos.css");
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="778" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="3"><img src="newsletter_logo.jpg" width="778" height="150"></td>
  </tr>
  <tr> 
    <td colspan="3"><img src="barra.jpg" width="778" height="20"></td>
  </tr>
  <tr> 
    <td width="17" bgcolor="#F7F7F7">&nbsp;</td>
    <td width="613" bgcolor="#F7F7F7">&nbsp;</td>
    <td width="148" bgcolor="#F7F7F7">&nbsp;</td>
  </tr>
  <tr> 
    <td width="17" height="200"> 
      <? include "menu.php"; ?>
    </td>
    <td><table border="0" cellpadding="0" cellspacing="0">
<tr>
          <td width="600" height="200"> 
		  <div align="center"> 

<?
$op = $_GET['op'];
if ($op==cadastro){
echo "<table>";
echo "<font face=verdana size=1><form name=F1 action=usuarios_cad.php?acao=cadastrar method=POST>
<tr>
<td><font face=verdana size=1><strong>Usuário:</strong></td> 
<td><input type=text name=\"usuario\" class=form></td>
</tr>
<tr>
<td><font face=verdana size=1><strong>Senha:</strong> </td>
<td><input type=text name=\"senha\" class=form></td>
</tr>
<tr>
<td><font face=verdana size=1><strong>Nivel:</strong> </td>
<td><SELECT name=\"nivel\" class=form>
		 <option value=1>Administrador</option>
		 <option value=0>Normal</option>
		 </select></td>
		 </tr>
		 <tr>
<td><input type=submit value=\"Cadastra >>\" class=botao></td>
		 </tr>
		 </table>

</form>";
}
$op = $_GET['op'];
if ($op==editar){
include "config.php";
$sql = mysql_query("SELECT * FROM $tb1");
if (!$sql){
echo "Não foi possivel a Conexao";
}
else{
echo "<table>";
echo "<form action=usuarios_cad.php?acao=editar method=POST>";
echo "<tr>";
echo "<td><strong><font face=verdana size=1>Quem deseja editar?</font></strong></td>";
echo "<td><SELECT name=usuario class=form>";
while ($sel = mysql_fetch_array($sql)){
$user = $sel['usuario'];
echo "<option value=$user>$user</option>";
}
echo "</select>";
echo "</td>";
}
echo "<td><center><input type=submit value=OK! class=botao></center>";
echo "</form>";
echo "</tr>";
echo "</table>";
}
$op = $_GET['op'];
$acao = $_GET['acao'];
if ($op==excluir){

include "config.php";
$sql = mysql_query("SELECT * FROM $tb1");
if (!$sql){
echo "<script>alert(\"Erro, Não foi possivel fazer a consulta\")</script>";
}
else{
echo "<table>";
echo "<tr>";
echo "<td bgcolor=#F8F8F8><font face=verdana size=1><b>Nome:</b></font></td>";
echo "<td bgcolor=#F8F8F8><font face=verdana size=1><b>Deletar:</b></font></td>";
echo "</tr>";
while ($reg = mysql_fetch_array($sql)){
$usuario = $reg['usuario'];
echo "<tr>";
echo "<td width=\"200\"><font face=verdana size=1>$usuario</font></td>";
echo "<td><font face=verdana size=1><a href=$PHP_SELF?acao=exclui&user=$usuario><b><p align=\"center\"><img src=trash.gif border=0></p></b></a></font></td>";
echo "</tr>";
}
echo "</table>";
}

}

$acao = $_GET['acao'];
$user = $_GET['user'];

if ($acao==exclui){
include "config.php";
$sql = mysql_query("DELETE FROM $tb1 WHERE usuario='$user' LIMIT 1;");
$sql .= mysql_query("DELETE FROM $tb2 WHERE autor='$user' LIMIT 1;");
if (!$sql){
echo "<script>alert(\"Erro, Não foi possivel fazer a consulta\")</script>";
}
else{
echo "<script>alert(\"Usuario Excluido com Sucesso, Precione ok e Aguarde....!\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=usuarios.php?op=excluir'>";
}
}

?>
</div>
</td>


      </table></td>
    <td width="160" bgcolor="#F7F7F7"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Updates 
      Web-Tools</strong></font><br> 

    </td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#F7F7F7">&nbsp;</td>
    <td bgcolor="#F7F7F7">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"><img src="barra.jpg" width="778" height="20"></td>
  </tr>
  <tr> 
    <td colspan="3"><img src="redape.jpg" width="778" height="100"></td>
  </tr>
</table>
</body>
</html>
