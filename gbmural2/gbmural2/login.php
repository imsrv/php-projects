<?php
require("conf.php");
mysql_connect($db[host], $db[user], $db[pass]);
mysql_select_db($db[nome]);

if(empty($act)){
echo "
<html>
<head>
<title>Logar-se</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>

<body>
<form action=\"login.php?act=logando\" method=\"post\" name=\"form\" id=\"form\">
  <table width=\"300\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
    <tr>
	 <td colspan=\"2\"><center><font size=\"2\" face=\"Verdana\"><b>[ Login $titulo ]</b></font></center><br><br></td>
	</tr>
    <tr>
      <td width=\"35\"><font size=\"1\" face=\"Verdana\">Login:</font></td>
      <td><input name=\"hllogin\" type=\"text\" id=\"hllogin\" size=\"20\" maxlength=\"15\" class=\"form\"></td>
    </tr>
    <tr>
      <td><font size=\"1\" face=\"Verdana\">Senha:</font></td>
      <td><input name=\"hlpass\" type=\"text\" id=\"hlpass\" size=\"20\" maxlength=\"8\" class=\"form\"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type=\"submit\" name=\"Submit\" value=\"Login...\" class=\"form\"></td>
    </tr>
  </table>
  </form>
</body>
</html>";
###
}
if($act == "logando") {

require("conf.php");

$hlpass = crypt($hlpass,"xxxhuanklomnrppdsa");
$sql = "SELECT * FROM $td[user] WHERE login = '$hllogin' and pass = '$hlpass'";
$sql = mysql_query($sql) or die (mysql_error());
if(mysql_num_rows($sql) == 0){
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>Erro</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>

<body>
<script> alert(\"O usuário ou senha informados estão incorretos!\"); window.location = 'javascript:history.go(-1)'; </script>
</body>
</html>";
exit;
}
else {
####
// Gravar o cookie
####
setcookie("login_pass",$hlpass,time()+7200);
setcookie("login_login",$hllogin,time()+7200);
header("Location: admin.php");
}
}
?>
