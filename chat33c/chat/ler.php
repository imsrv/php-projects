<?
session_start();
include ("./config.php");

clearstatcache();

$tempo=1000*$refresh;

$time = @time();
$timer= time();

$user = new perfil;
$men = new mensagem;
$block= new tab;

$user->conect($host,$id,$senha,$db,$sala);
$men->conect($host,$id,$senha,$db,$sala);

$linha=$user->select("ip",$ip);

$nome=$linha[3];
$valor=$linha[6];

$msg=$men->imprimir($nome,$valor,$som); //Mensagens do chat

$user->update ("time",$timer,"ip",$ip);
$user->update ("last",$valor,"ip",$ip);

$men->close();

$cont++;
?>
<html><head>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<?if(sizeof($user->select("ip",$ip)) != 1){ ?>
<script language="JavaScript">
   function abre (){
     if (parent.superior.document.TCheck.som.checked){
       if(navigator.userAgent.indexOf("MSIE") != -1){
          location='ler.php?cont=<?echo $cont;?>&som=msom';
       }else{
          location='ler.php?cont=<?echo $cont;?>&som=nsom';
       }
     }else{
        location='ler.php?cont=<?echo $cont;?>&som=semsom';
     }
   }

   function escrever (){
      <?if ($msg != ""){ ?>
      parent.principal.document.writeln("<? echo $msg;?>");
      <?}?>
      setTimeout("abre();", <?echo $tempo;?>);
   }
</script>
</head>
<?
$user->close();
unset($men);//Destroi a variavel $men
unset($user);//Destroi a variavel $user
clearstatcache();
flush();
?>
<script>escrever();</script>
</html>
<?}else{?>
<script language="javascript">
parent.principal.document.writeln("<p><font color=#FF0000><b>Alerta:Você foi chutado da sala ou entrou de maneira errada no chat.</b></font></p> ");
<?sleep(5);?>
window.top.location='sair.php';
</script>
</head>
</html>
<?}?>