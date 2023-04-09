<head>
<style type="text/css">
<!--
@import url("../estilos.css");
-->
</style>
</head>
<body>
<font face=verdana size=1>

<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
include "config.php";
$action = $_GET['action'];
$el = $_GET['email'];
if($action==mandar){
echo "<form action=\"$PHP_SELF?action=manda\" method=post>";
echo "<table>";
echo "<tr>";
echo "<td><font face=verdana size=1><b>E-mail:</b></td><td><input type=text name=\"email\" value=\"$el\" class=form></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font face=verdana size=1><b>Assunto:</b></td><td><input type=text name=\"assunto\" class=form></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font face=verdana size=1><b>Mensagem:</b></td><td> <textarea name=\"msg\" class=form rows=4 cols=25></textarea></td>";
echo "</tr>";
echo "<tr>";
echo "<td>&nbsp;</td><td><input type=submit value=Enviar class=botao></td>";
echo "</tr>";
echo "</table>";
echo "</form>";
}


if ($action==manda){
$assunto = $_POST['assunto'];
$msg = $_POST['msg'];
$email = $_POST['email'];

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: $email_admin<$autor_email>";
mail("$email","$assunto","$msg","$headers");
echo "<script>alert(\"Mensagem enviada com sucesso\")</script>";
echo "<script>window.close()</script>";
}
?>
</body>
