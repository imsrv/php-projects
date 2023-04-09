<?
session_start();
include ("./config.php");

function randow ($ini,$fim)
{
  $time = @time();
  $timer= time();
  $rand = $timer%($fim-$ini +1)+$ini;
  return $rand ;
}

$user= new perfil;
$msg=  new mensagem;

$user->conect($host,$id,$senha,$db,$sala);
$msg->conect($host,$id,$senha,$db,$sala);

$time = @time();
$timer= time();

if(($apelido == "") ||($apelido == "TODOS")){
  $apelido="Guest";
}

$linha=$user->select("ip",$ip);
$antigo=$user->nick($linha[3]);

//Se sizeof retornar um valor igual esse nick não está registrado.
if(sizeof($user->select("nome",$apelido)) != 1){
  if($apelido != $linha[3]){
   $apelido.=randow(1,1000);
  }
}
//Atualiza o nick
$user->update("time",$timer,"ip",$ip);
$user->update("nome",$apelido,"ip",$ip);
$user->update("careta",$careta,"ip",$ip);
$user->update("cor",$cor,"ip",$ip);

$mcampo[0]="time";
$mcampo[1]="remetente";
$mcampo[2]="destinatario";
$mcampo[3]="mensagem";

$mvalor[0]="$timer";
$mvalor[1]="$apelido";
$mvalor[2]="TODOS";
$mvalor[3]=$antigo." muda seu perfil para ".$user->nick($apelido)."|nada";

$msg->insere($mcampo,$mvalor,"msg"); //Envia uma mensagem sofre a mudança de nick

$user->close();
$msg->close();

unset($user); //Destroi a variavel $user
unset($msg); //Destroi a variavel $msg
?>
<HTML>
<HEAD>
<TITLE> Romano Chat </TITLE>
<script language=javascript>
function fecha(){
window.close();
}
</script>
</HEAD>
<BODY BGCOLOR=#999999 onLoad="fecha();">
</BODY>
</HTML>