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
include "includes/config.php";
include "LKn_funcs.php";
conexao($host_db,$usuario_db,$senha_db,$BancoDeDados);
$usuario = $_POST['login'];
$senha = $_POST['senha'];

function segurity($string){
$replace="";
$funcs= array(";"=> "$replace");  // Funçoes proibidas
$string=strtr($string,$funcs);
return $string;
}


$usuario = segurity($login);
$senha = segurity($senha);

$nucaraclogin = strlen($login);
$nucaracsenha = strlen($senha);

if ($nucaraclogin > 8 || $nucaracsenha > 8){
echo "Login Incorreto";
} else {
$sqlsenha = @mysql_query ("SELECT * FROM lkn_admin WHERE senha='$senha' AND usuario='$usuario' LIMIT 1");
$nsenha = @mysql_num_rows($sqlsenha);

if($nsenha=="0"){
echo "<script>window.alert(\"Login Inexistente\");</script>";
echo "<meta http-equiv='refresh' content='0;URL=login.php'>";
exit;
}

elseif($nsenha=="1"){
setcookie("usuario","$login");
setcookie("senha","$senha");
echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
}
}
mysql_close();
?>
