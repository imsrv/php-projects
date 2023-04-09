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
<title>LinkinNews 2.0 [ Comentarios] </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onmouseover="MM_showHideLayers('Layer1','','show')">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="images/top_logo.gif" width="200" height="50"></td>
  </tr>
  <tr>
    <td height="10%" bgcolor="#D64B10"></td>
  </tr>
</table>
  
<?php 

// variável que define o diretório das imagens 
$dir = "Minhas Imagens"; 

// esse seria o "handler" do diretório 
$dh = opendir($dir); 

// loop que busca todos os arquivos até que não encontre mais nada 

	
	$sql = mysql_query("SELECT url_admin FROM lkn_configs LIMIT 1");
	while ($d = mysql_fetch_array($sql)){
	$url_admin = $d['url_admin'];
	}
	$dir= "Minhas Imagens";
echo "<font face=verdana size=1>Para adicionar essas imagens nas noticias apenas copie o endereço da imagem que lhe enteressa Clique sobre o botao <strong>[IMG]</strong> cole o endereço na caixa de dialogo e pronto.<br>
<br>
";
$n=1;
while (false !== ($filename = readdir($dh))) { 
// verificando se o arquivo é .jpg 
if (substr($filename,-4) == ".jpg" || substr($filename,-4) == ".gif" || substr($filename,-4) == ".png" || substr($filename,-5) == ".jpeg" || substr($filename,-4) == ".bmp") { 
// mostra o nome do arquivo e um link para ele - pode ser mudado para mostrar diretamente a imagem :) 
echo "<font face=verdana size=1><strong>$n -</strong> $url_admin$dir/$filename<br>"; 
$n++;
} 

} 
close_con();
?>
  <center>
  <a href="javascript:window.close();"><br>
  <img src="images/bt_close_window.gif" width="100" height="15" border="0"></a> 
</center> 

</body>
</html>
