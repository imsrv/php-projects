<?
include "includes/config.php";
include "LKn_funcs.php";
conexao($host_db,$usuario_db,$senha_db,$BancoDeDados);

$sql = mysql_query("SELECT preview FROM lkn_configs");

while ($d =  mysql_fetch_array($sql)){
$preview = $d['preview'];
}
$preview = bbcode($preview,1);
echo "$preview";


?>
