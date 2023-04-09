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
<html>
<head>
<title>LinkinNews 2.0 [ Comentarios] </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/css.css" rel="stylesheet" type="text/css">
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
<br>
<?
include "includes/config.php";
include "LKn_funcs.php";
		conexao($host_db,$usuario_db,$senha_db,$BancoDeDados);
		$id = $_GET['n_id'];
		add_views();
		$sql = mysql_query("SELECT * FROM lkn_noticias WHERE id='$id'") or die(mysql_error());
		$n = @mysql_num_rows($sql);
		if($n=="0")
		{
			echo "<font face=verdana size=2>Noticia indisponivel</a>";
		} else {
		
		while ($dados = mysql_fetch_array($sql))
		{
		
 			$id = $dados['id'];
           $titulo  = $dados['titulo'];
           $noticia = $dados['noticia'];
           $data = $dados['data'];
           $hora = $dados['hora'];
           $template = $dados['template'];
           $coment = $dados['desej_coment'];
           $views = $dados['views'];
           
           $noticia= nl2br($noticia);
           $noticia = bbcode($noticia,1);
?>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Titulo: 
      </strong> <? echo "$titulo"; ?> </font></td>
  </tr>
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo "$noticia"; ?></font></td>
  </tr>
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Data:</strong> 
      <? echo "$data"; ?> <strong> Hora: </strong> <? echo "$hora"; ?></font></td>
  </tr>
</table>
<? } } 
close_con();?>
<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
  Esta noticia foi vista <? echo "$views"; ?> vez(es)</font></div>
<div align="right"><br>
  <a href="javascript:window.close();"><img src="images/bt_close_window.gif" width="100" height="15" border="0"></a> 
</div>
</body>
</html>
