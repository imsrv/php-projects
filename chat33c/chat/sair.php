<?
session_start();
session_unregister("sala");
include ("./config.php");

$time = @time();
$timer= time();

$user= new perfil;
$msg=  new mensagem;

$user->conect($host,$id,$senha,$db,$vsala);
$msg->conect($host,$id,$senha,$db,$vsala);

$linha=$user->select("ip",$ip);

if($linha[3]!= ""){

   $mcampo[0]="time";
   $mcampo[1]="remetente";
   $mcampo[2]="destinatario";
   $mcampo[3]="mensagem";

   $mvalor[0]="$timer";
   $mvalor[1]="$apelido";
   $mvalor[2]="TODOS";
   $mvalor[3]=$user->nick($linha[3])." sai do Chat|saida";

   $msg->insere($mcampo,$mvalor,"msg");  //Mensagem informando a saida do chat

   $user->remove ("ip",$ip); //Remove usuario

   $user->close();
   $msg->close();

   unset($user);//Destroi a variavel $user
   unset($msg); //Destroi a variavel $msg
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<? if ($troca==0){/*Retorna para pagina com as salas*/ ?>
<body onload="window.parent.location='salas.php?vsala=<? echo $troca;?>&apelido=<? echo $linha[3];?>&cor=<? echo $linha[5];?>&careta=<? echo $linha[4];?>'">
<? }else{/*Vai para outra sala*/ ?>
<body onload="window.parent.location='entra.php?vsala=<? echo $troca;?>&apelido=<? echo $linha[3];?>&cor=<? echo $linha[5];?>&careta=<? echo $linha[4];?>'">
<? } ?>
</body>
</html>