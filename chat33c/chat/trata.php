<?
session_start();
include ("./config.php");
include ("./filtro.php");

$time = @time();
$timer= time();

$msg= new mensagem;
$user= new perfil;
$admin=new tab;

$user->conect($host,$id,$senha,$db,$sala);
$msg->conect($host,$id,$senha,$db,$sala);
$admin->conect($host,$id,$senha,$db,$sala);

$hora=date("(H:i:s)");

$img="";
if($c != 0) {$img="<br><center><img src=img/$c.gif border=0></center>";}

$res="";

if($d == "ON"){
  $res="reservadamente";
  $chec="checked";
}

$e=familiar($filtro,$e); //Retira as mensagens improprias

$e=strip_tags($e); //Retira os tags

$e=trim($e);//Retira as espações em branco

$e.=$img;//Acrescenta as emoctions

$valor=strlen($e); //Tamanho do string

if(($valor != 0) and (sizeof($user->select("ip",$ip)) != 1)){

  $linha=$user->select("ip",$ip);

  $perfila=$user->nick($linha[3]);

  $perfilb=$user->nick($b);

  $mes="$hora $perfila <i>$res $a</i> $perfilb : $e";

  $mes = eregi_replace("([ \\t]|^)www."," http://www.",$mes);
  $mes = eregi_replace("([ \\t]|^)ftp\\."," ftp://ftp.",$mes);
  $mes = eregi_replace("(http://[^ )\r\n]+)","<A href='\\1\\' target='_blank'>\\1</A>",$mes);
  $mes = eregi_replace("(https://[^ )\r\n]+)","<A href='\\1\\' target='_blank'>\\1</A>",$mes);
  $mes = eregi_replace("(ftp://[^ )\r\n]+)","<A href='\\1' target='_blank'>\\1</A>",$mes);
  $mes = eregi_replace("([-a-z0-9_]+(\\.[_a-z0-9-]+)*@([a-z0-9-]+(\\.[a-z0-9-]+)+))","<A HREF='mailto:\\1'>\\1</A>",$mes);

  $mes.="|$f";

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


  $msg->insere($mcampo,$mvalor,"msg"); //Insere a mensagem

  $admin->insere($mcampo,$mvalor,"log"); //Insere a mensagem no log
  $admin->atualiza ("300","log");  //Atualiza log

  $user->atualiza($tuser,"users");//Atualiza usuarios
  $msg->atualiza($tmesg,"msg");//Atualiza mensagens

  $msg->close();
  $user->close();
  $admin->close();
}
$cont++;
unset($msg);//Destroi a variavel $msg
unset($user);//Destroi a variavel $user
unset($admin);//Destroi a variavle $admin
?>
<html><head>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<script>location='form.php?sel=<? echo "$b";?>&chec=<? echo "$chec";?>&cont=<?echo "$cont";?>'</script>
</head></html>