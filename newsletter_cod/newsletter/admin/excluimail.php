<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
$email = $_GET['email'];
$action = $_GET['action'];
if($action==excluir){
include "config.php";
$sql= mysql_query ("DELETE FROM $tb3 WHERE email='$email' LIMIT 1");
if (!$sql){
echo "Nao foi possivel Excluir o E-mail";
}
else{
echo "Aguarde....";
echo "<meta http-equiv='refresh' content='0;URL=todos.php'>";
}  }

?>
