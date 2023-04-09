<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Newsletter :: Atualiza&ccedil;&otilde;es em www.web-tools.kit.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
include "config.php";
$sql= mysql_query("SELECT * FROM $tb3");
$linhas = mysql_num_rows($sql);
if (!$sql){
echo "Não foi possivel a conexao";}
else{
if ($linhas==0){
echo "<font face=verdana size=2 color=red>Não há E-mails Cadastrados</font>";
}
if ($linhas>0){
echo "<table>";
echo "<td  bgcolor=#F8F8F8><font face=verdana size=1><b>E-mail:</b></font>";
echo "<td  bgcolor=#F8F8F8> <font face=verdana size=1><b>Deletar:</b></font>";
echo "<td  bgcolor=#F8F8F8> <font face=verdana size=1><b>Contato:</b></font>";
$busca = "SELECT * FROM $tb3 ORDER BY email DESC";
$total_reg = "10"; // número de registros por página
$pagina = $_GET['pagina'];
if (!$pagina) {
    $pc = "1";
} else {
    $pc = $pagina;
}
$inicio = $pc - 1;
$inicio = $inicio * $total_reg;

$limite = mysql_query("$busca LIMIT $inicio,$total_reg");
$todos = mysql_query("$busca");

$tr = mysql_num_rows($todos); // verifica o número total de registros
$tp = $tr / $total_reg; // verifica o número total de páginas
// vamos criar a visualização
while ($dados = mysql_fetch_array($limite)) {
$email = $dados['email'];
echo "<tr>";
echo "<td width=\"200\"><font face=verdana size=1>$email</font></td>";
echo "<td> <font face=verdana size=1 color=red><strong><a href=excluimail.php?action=excluir&email=$email><p align=\"center\"><img src=trash.gif border=0></p></a></strong></font></td>";
echo "<td> <font face=verdana size=1 color=red><strong><a href=\"#\" onClick=\"window.open('contactos.php?action=mandar&email=$email','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=300,height=150'); return false;\">Enviar uma Mensagem</a></strong></font></td>";
echo "</tr>";
}
echo "</table>";

// agora vamos criar os botões "Anterior e próximo"
$anterior = $pc -1;
$proximo = $pc +1;
if ($pc>1) {
    echo " <a href='?pagina=$anterior'><font face=verdana size=1><- Anterior</font></a> ";
}
if ($pc<$tp) {
    echo " <a href='?pagina=$proximo'><font face=verdana size=1>Próxima -></font></a>";
}
}
}


?>
</div></td>
        </tr>
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
