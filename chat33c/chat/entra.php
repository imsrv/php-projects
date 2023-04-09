<?
session_start();
session_register("sala");
include ("./config.php");

$sala=$vsala;

function randow ($ini,$fim)
{
  $time = @time();
  $timer= time();
  $rand = $timer%($fim-$ini +1)+$ini;
  return $rand ;
}

$user= new perfil;
$msg=  new mensagem;
$block= new tab;

$user->conect($host,$id,$senha,$db,$sala);
$msg->conect($host,$id,$senha,$db,$sala);
$block->conect($host,$id,$senha,$db);

if(($apelido == "")||($apelido == "TODOS")){
  $apelido="Guest";
}
//Se sizeof retornar um valor igual a igual o nick não esta registrado
if(sizeof($user->select("nome",$apelido)) != 1){
  $apelido.=randow(1,1000);
}

//Se sizeof retornar um valor igual a igual o ip não esta registrado
if(sizeof($user->select("ip",$ip)) != 1){
  $user->remove ("ip",$ip);
}

$time = @time();
$timer= time();

$campo[0]="time";
$campo[1]="ip";
$campo[2]="nome";
$campo[3]="careta";
$campo[4]="cor";
$campo[5]="last";

$valor[0]="$timer";
$valor[1]="$ip";
$valor[2]="$apelido";
$valor[3]="$careta";
$valor[4]="$cor";
$valor[5]="0";

if(sizeof($block->select("ip",$ip,"block")) == 1){
  $user->insere($campo,$valor,"users");
}

$mcampo[0]="time";
$mcampo[1]="remetente";
$mcampo[2]="destinatario";
$mcampo[3]="mensagem";

$nome=$block->select("codigo",$sala,"salas");

$mvalor[0]="$timer";
$mvalor[1]="$apelido";
$mvalor[2]="TODOS";
$mvalor[3]=$user->nick($apelido)." entra na Sala $nome[1]|entra";

if(sizeof($block->select("ip",$ip,"block")) == 1){
  $msg->insere($mcampo,$mvalor,"msg");//Envia uma mensagens de boas vindas no chat
}

$user->close();
$msg->close();
$block->close();
unset($user); //Destroi a variavel $user
unset($msg); //Destroi a variavel $msg
unset($block);//Destroi a variavel $block
$time = @time();
?>
<html>
<head>
<title>Sala <?echo $nome[1];?></title>
</head>
<frameset rows="0,70,*,75" framespacing="0" frameborder=0 border="0">
   <frame name="conteudo" scrolling="no" noresize target="principal" src="ler.php?time=<?echo $time;?>&som=semsom"> 
<frame name="superior" scrolling="no" noresize target="conteudo" src="sup.php?time=<?echo $time;?>">
  <frame name="principal" src="princ.htm?time=<?echo $time;?>">
  <frame name="inferior" scrolling="no" noresize target="conteudo" src="form.php?time=<?echo $time;?>">
  <noframes>
  <body>

  <p>Esta página está usando frames mas o seu navegador não suporta.</p>

  </body>
  </noframes>
</frameset>
</html>