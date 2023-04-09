<?
session_start();
include ("./config.php");
$cria= new tab;
$cria->conect($host,$id,$senha,$db);
$target=$cria->imprimir($vsala);//Imprime log da sala
$cria->close();
unset($cria);
echo $target;
?>