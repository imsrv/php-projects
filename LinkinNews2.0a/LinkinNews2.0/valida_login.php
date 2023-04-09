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
<?
$usuario = $_COOKIE['usuario'];
$senhau = $_COOKIE['senha'];
include "includes/config.php";
include "LKn_funcs.php";
mysql_connect ("$host_db", "$usuario_db", "$senha_db") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("$BancoDeDados") or die("Não foi possivel completa a conexao com o banco de dados $BancoDeDados");

$sqlsenha = @mysql_query ("SELECT senha FROM lkn_admin WHERE senha='$senhau' AND usuario='$usuario' LIMIT 1");
$nsenha = @mysql_num_rows($sqlsenha);

if($nsenha=="0"){
setcookie("usuario");
setcookie("senha");
echo "<script>window.alert(\"Você não Efetuou o Login\");</script>";
echo "<meta http-equiv='refresh' content='0;URL=login.php'>";
exit;
} elseif(empty($usuario) || empty($senhau)){
setcookie("usuario");
setcookie("senha");
echo "<meta http-equiv='refresh' content='0;URL=login.php'>";
echo "<script>window.alert(\"Você não Efetuou o Login\");</script>";
exit;
}

?>
