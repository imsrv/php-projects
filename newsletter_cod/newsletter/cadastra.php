<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
$desejo = $_POST['desejo'];
$email = $_POST['email'];
include "admin/config.php";

if($desejo==cadastra){
$n = mysql_query("SELECT * FROM $tb3 WHERE email='$email'");
$linhas = mysql_num_rows($n);
if ($linhas==1){
echo "<script>alert(\"Desculpe mas este e-mail já está cadastrado, Não foi possivel concluir o cadastro.\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=cadastro.html'>";
} else{
$sql = mysql_query("INSERT INTO $tb3 (email) VALUES ('$email')");
if (!$sql){
echo "Não foi possivel a consulta.";}
else{
echo "<script> alert(\"E-Mail Cadastrado com sucesso\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=cadastro.html'>";
}
}
}
if($desejo==remover){
$sql = mysql_query("DELETE FROM $tb3 WHERE email='$email'");
if (!$sql){
echo "Não foi possivel Excluir o Usuario.";}
else{
echo "<script> alert(\"E-Mail Removido com sucesso\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=cadastro.html'>";
}
}
?>
