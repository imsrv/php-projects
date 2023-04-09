<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
ini_set("max_execution_time",0);
$username = $_COOKIE['username'];
if ($username){
$autor = $_COOKIE['username'];
include "config.php";

$soma = mysql_query("SELECT * FROM $tb2 where autor='$autor' ORDER BY posts DESC");
if (!$soma){
echo "Não foi possivel a consulta";
}
else{
while ($reg = mysql_fetch_array($soma)){
$numero = $reg['posts'];
}
global $numero;
$maisum=1;
$novonumero= $numero + $maisum;
$novosql = mysql_query("UPDATE $tb2 SET posts='$novonumero' where autor='$autor'");

$assunto = $_POST['titulo'];
$formatacao = $_POST['formatacao'];
$msg = $_POST['msg'];


if ($formatacao==html){

include "config.php";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: $email_admin<$autor_email>";
$sql = mysql_query("SELECT * FROM $tb3");

while ($reg = mysql_fetch_array($sql)){
global $assunto;
$emails = $reg['email'];

$msg = stripslashes($msg);
$msg = str_replace('"',"", $msg);

mail("$emails","$assunto","$msg","$headers");
flush();

}
echo "<script>alert(\"Sua Mensagem foi enviada com sucesso.\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=Msg_form.php'>";
}
if ($formatacao==texto){
include "config.php";
$headers = "From: $email_admin<$autor_email>";
$sql2 = mysql_query("SELECT * FROM $tb3");
global $assunto;
while ($reg1 = mysql_fetch_array($sql2)){

$emails = $reg1['email'];
mail("$emails","$assunto","$msg","$headers");
}
echo "<script>alert(\"Sua Mensagem foi enviada com sucesso.\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=Msg_form.php'>";
}

}
}
?>
