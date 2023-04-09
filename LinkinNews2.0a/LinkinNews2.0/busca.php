<?
###########################################
#       Sistema Criado e Desenvolvido     #
#          Igor Carvalho de Escobar       #
#                LK Design©               #
#  http://igorescobar.webtutoriais.com.br #
#      Suporte em:                        #
#      http://forum.webtutoriais.com.br   #
#      Por favor, Mantenham os Créditos   #
###########################################
?>
<? include "valida_login.php"; ?>
<html>
<head>
<title>LinkinNews 2.0 [ Busca ]</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/css.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="images/top_logo.gif" width="200" height="50"></td>
  </tr>
  <tr>
    <td height="10%" bgcolor="#D64B10"></td>
  </tr>
</table>
<form action="<? echo $PHP_SELF; ?>" method="post" name="noticia" id="noticia">
  <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Chave: 
    <input name="chave" type="text" class="botoes" id="chave" value="<? echo "$chave"; ?>">
    Por: 
    <select name="tabela" class="botoes" id="tabela">
<option value="lkn_noticias">Noticias</option>
      <option value="lkn_coments">Comentarios</option>
    </select>
    <input name="Submit" type="submit" class="botoes" value="Buscar">
    </font></div>
</form>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#FF3333"> 
    <td width="5%"><strong><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">N&ordm;</font></strong></td>
    <td width="70%"><strong><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">
	<? 
	if($_POST[tabela]=="lkn_noticias")
	{ 
	echo "Titulo"; 
	} else { 
	echo "Nome/IP"; 
	} 
	?></font></strong></td>
    <td width="25%"> <div align="center"><font color="#FFFFFF"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Modera&ccedil;&atilde;o</font></strong></font></div></td>
  </tr>
</table>
<?
	$chave = $_POST['chave'];
	$tabela = $_POST['tabela'];
	$acao = $_GET['AcTion'];
	
	if($acao==45687)
	{
$n_id= $_GET['n_id'];
	removenews($n_id);
	
	}
	if(empty($chave)){
	echo "<font face=verdana size=2 color=red>Digite a Palavra-chave referente a noticia/comentário</font>";
	}else {
if($tabela=="lkn_noticias")
{
$search = "titulo";
$search2= "noticia";
}else {
$search = "nome";
$search2= "comentario";
}
	$sql = mysql_query("SELECT * FROM $tabela WHERE $search LIKE '%$chave%' OR $search2 LIKE '%$chave%' ORDER BY id DESC") or die (mysql_error());
	
	if(mysql_num_rows($sql)==0)
	{
		echo "<font face=verdana size=2 color=red>Não há noticias/comentarios com a palavra <strong>$chave</strong> até o momento.</font>";
	}
	else
	{
$bg="#ffffff";
$n=1;
	while($dados = mysql_fetch_array($sql))
	{
$titulo = $dados['titulo'];
$id = $dados['id'];
$nome = $dados['nome'];
$ip = $dados['ip'];
if ($bg=="#ffffff") //aqui faz o teste se a cor atual é branca
{
$bg = "#FBFBFB"; // se for entao ele coloca a proxima cinza
}
else
{
$bg = "#ffffff"; //se a atual fo cinza ele faz ela volvar a ser branca
}
		
	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="<? echo "$bg"; ?>">
  <tr> 
    <td width="5%" height="19"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $n; ?></font></strong></td>
    <td width="70%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? if($_POST[tabela]==lkn_noticias) { echo $titulo; } else { echo "$nome <em>[ $ip ]</em>";  }?></font></td>
    <td width="25%"> <div align="right"><strong><a href="#" onClick="window.open('edita.php?AcTion=751698&n_id=<? echo $id; ?>&tab=<? echo $_POST[tabela]; ?>','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=500,height=500'); return false;"><img src="images/bt_editar.gif" width="50" height="15" border=0></a> 
        <a href="<? echo "$PHP_SELF"; ?>?AcTion=45687&n_id=<? echo $id; ?>&tab=<? echo $_POST[tabela]; ?>"><img src="images/bt_deletar.gif" width="50" height="15" border=0></a></strong></div></td>
  </tr>
</table>
<?
	  $n++;	} // fecha o while
	  	} //fecha o if 
		close_con();
	  } // fecha o else
	  ?>
<p><br>
  &nbsp;&nbsp;&nbsp;<a href="javascript:window.close();"><img src="images/bt_close_window.gif" width="100" height="15" border="0"></a> 
</p>
</body>
</html>
