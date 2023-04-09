<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
include "config.php";
$usuario = $_COOKIE['username'];
$sql = @mysql_query("SELECT nivel FROM $tb1 WHERE usuario='$usuario'");
while ($reg = mysql_fetch_array($sql)){
$nivel=$reg['nivel'];
}
global $nivel;
if ($nivel==0){
include "ssr543fds.inc";
}
?>
