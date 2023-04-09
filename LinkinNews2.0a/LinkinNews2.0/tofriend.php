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
</table>  <? $n_id = $_GET['n_id'];?>
<form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>?AcTion=4517&n_id=<? echo $n_id; ?>&u=<? echo $palavrao; ?>">
  <blockquote>
    <p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Nome 
      de destino(do amigo(a)):<br>
      <input name="nome" type="text" class="botoes" id="nome">
      <br>
      E-mail de destino:<br>
      <input name="email" type="text" class="botoes" id="email">
      </font><br>
      <input name="Submit" type="submit" class="botoes" value="Recomende !">
    </p>
    <p>
      <center>
        <a href="javascript:window.close();"><img src="images/bt_close_window.gif" width="100" height="15" border="0"></a> 
      </center>
    </p>
  </blockquote>
</form>

<?
$acao = $_GET['AcTion'];

include "includes/config.php";
include "LKn_funcs.php";
mysql_connect ("$host_db", "$usuario_db", "$senha_db") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("$BancoDeDados") or die("Não foi possivel completa a conexao com o banco de dados $BancoDeDados");
if($acao==4517)
{

to_friend($email,$n_id);

}




?>
</body>
</html>
