<?
session_start();
include ("./config.php");

$time = @time();
$timer= time();

$msg= new mensagem;
$user= new perfil;

$user->conect($host,$id,$senha,$db,$sala);
$msg->conect($host,$id,$senha,$db,$sala);

$hora=date("(H:i:s)"); //Data no formato hora,minuto e segundo

$img="";
if($c != 0) {$img="<img src=img/$c.gif border=0>";}

$res="";

if($d == "ON"){
  $res="reservadamente";
  $chec="checked";
}

$a="envia imagem para";

$linha=$user->select("ip",$ip);

$perfila=$user->nick($linha[3]);

$perfilb=$user->nick($b);

$mes="$hora $perfila <i>$res $a</i> $perfilb:<br><center><img src=$e border=0></center>|foto";

$mcampo[0]="time";
$mcampo[1]="remetente";
$mcampo[2]="destinatario";
$mcampo[3]="mensagem";
$mcampo[4]="status";

$mvalor[0]="$timer";
$mvalor[1]="$linha[3]";
$mvalor[2]="$b";
$mvalor[3]="$mes";
$mvalor[4]="$d";

$msg->insere($mcampo,$mvalor,"msg");  //Insere a mensagem na tabela de mensagens

$msg->close();
$user->close();
unset($msg); //Destroi a variavel $msg
unset($user);//Destroi a variavel $user
?>
<html><head>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<script>window.close()</script>
</head></html>