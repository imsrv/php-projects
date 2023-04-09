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
<? include "valida_login.php"; ?>
<html>
<head>
<title>LinkinNews 2.0 [ Edi&ccedil;&atilde;o ]</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/css.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script language=javascript>

function bbcode2(acao){
var revisedMessage;
var currentMessage = document.F1.noticia.value;
if (acao == "URL") {
var thisURL = prompt("Entre com a URL que você gostaria de adicionar", "http://");
var thisTitle = prompt("Entre com o titulo da URL", "Seu Titulo");
var urlBBCode = "[URL="+thisURL+"]"+thisTitle+"[/URL]";
revisedMessage = currentMessage+urlBBCode;
document.F1.noticia.value=revisedMessage;
document.F1.noticia.focus();
return;
}
if (acao == "MAIL") {
var thisURL = prompt("Entre com o E-MAIL que você gostaria de adicionar", "");
var thisTitle = prompt("Entre com o titulo do E_MAIL", "Seu Titulo");
var urlBBCode = "[MAIL="+thisURL+"]"+thisTitle+"[/MAIL]";
revisedMessage = currentMessage+urlBBCode;
document.F1.noticia.value=revisedMessage;
document.F1.noticia.focus();
return;
}
if (acao == "IMG") {
var thisURL = prompt("Entre com endereço da imagem que você gostaria de adicionar", "http://");
var urlBBCode = "[IMG]"+thisURL+"[/IMG]";
revisedMessage = currentMessage+urlBBCode;
document.F1.noticia.value=revisedMessage;
document.F1.noticia.focus();
return;
}
}
function SelText(acao){
// pegando o texto selecionado
var meuTexto = document.selection.createRange().text;

//texto original
var textoOriginal = document.F1.noticia.value;

//novo texto
var meuNTexto = "";

var textoFormatado = "";
var meuNTextoI = "";
var meuNTextoF = "";

// verifica se tem algo selecionado
if (meuTexto.length == 0 && acao!="URL" && acao!="IMG" && acao!="MAIL" ){
alert ("Selecione algo");
}else{

//aplica a formatacao escolhida

//negrito
if (acao=='negrito') {
meuNTextoI = "[B]";
meuNTextoF = "[/B]";
}

if (acao=='italico') {
meuNTextoI = "[I]";
meuNTextoF = "[/I]";
}

if (acao=='sublinhado') {
meuNTextoI = "[U]";
meuNTextoF = "[/U]";
}

if (acao=='QUOTE') {
meuNTextoI = "[QUOTE]";
meuNTextoF = "[/QUOTE]";
}


if (acao=='MAIL'){
var Email = prompt("Entre com o Endereço de Email.", "");
var Titulo = prompt("Dê um titulo a este E-mail.", "Meu E- mail");

meuNTextoI = "[MAIL="+Email+"]"
meuNTextoF = Titulo+"[/MAIL]";
}

if (acao=='big') {
meuNTextoI = "[Tgrande]";
meuNTextoF = "[/Tgrande]";
}
if (acao=='medio') {
meuNTextoI = "[Tmedio]";
meuNTextoF = "[/Tmedio]";
}
if (acao=='pequeno') {
meuNTextoI = "[Tpequeno]";
meuNTextoF = "[/Tpequeno]";
}
if (acao=='RIGHT') {
meuNTextoI = "[RIGHT]";
meuNTextoF = "[/RIGHT]";
}
if (acao=='CENTER') {
meuNTextoI = "[CENTER]";
meuNTextoF = "[/CENTER]";
}
if (acao=='LEFT') {
meuNTextoI = "[LEFT]";
meuNTextoF = "[/LEFT]";
}
if (acao=='IMG') {
var URL = prompt("Entre com o Endereço da Imagem.", "");
meuNTextoI = "[IMG]"+URL;
meuNTextoF = "[/IMG]";
}
meuNTexto = meuNTextoI + meuTexto + meuNTextoF;

textoFormatado = (textoOriginal.replace(meuTexto, meuNTexto));
document.F1.noticia.value = textoFormatado;

}
}
function emoticon(text) {
	text = ' ' + text + ' ';
	if (document.F1.noticia.createTextRange && document.F1.noticia.caretPos) {
		var caretPos = document.F1.noticia.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		document.F1.noticia.focus();
	} else {
	document.F1.noticia.value  += text;
	document.F1.noticia.focus();
	}
}
</script>
<div id="Layer1" style="position:absolute; left:230px; top:156px; width:129px; height:129px; z-index:1; visibility: visible;"> 
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr> 
      <td bgcolor="#F2F2F2"> <div align="justify"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Emoticons</font></strong></div></td>
    </tr>
    <tr> 
      <td height="45"> 
        <?php

// variável que define o diretório das imagens
$dir = "smyles";

// esse seria o "handler" do diretório
$dh = opendir($dir);
$n=1;
echo "<table>";
echo "<tr>";

while (false !== ($filename = readdir($dh)))
 {
	if (substr($filename,-4) == ".jpg" || substr($filename,-4) == ".gif" || substr($filename,-4) == ".png" || substr($filename,-5) == ".jpeg" || substr($filename,-4) == ".bmp") {
	$bbcode = explode("." , $filename);
	if($n==8){ echo "</tr><tr>"; $n=1;}
	echo "<td><center><img src='$dir/$filename' onclick=\"javascript:emoticon('[$bbcode[0]]')\"></center></td>";
	
	$n++;
	}

}
echo "</table>";
?>
      </td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="images/top_logo.gif" width="200" height="50"></td>
  </tr>
  <tr>
    <td height="10%" bgcolor="#D64B10"></td>
  </tr>
</table>
<p> 
  <?
		$tab = $_GET['tab'];
		
		$id = $_GET['n_id'];
		$acao = $_GET['AcTion'];
		if($acao==78435745)
		{		
	    update_news($id,$tab);
	    }
		if($acao==751698)
		{
		

			$sql = mysql_query("SELECT * FROM $tab WHERE id='$n_id'");
			
		while ($dados = mysql_fetch_array($sql))
		{
		$titulo = $dados['titulo'];
		$noticia = $dados['noticia'];
		$id= $dados['id'];
		$area = $dados['area'];
		$nome = $dados['nome'];
		$comentario = $dados['comentario'];
			
         ?>
  <br>
  <input name="Button" type="button" class="botoes" value="[U]" onclick="javascript:SelText('sublinhado')" onMouseOver="window.status='Serve para deixar o texto Sublinhado';" onMouseOut="window.status='';";>
  <input name="Submit2" type="button" class="botoes" value="[B]"  onclick="javascript:SelText('negrito')" onMouseOver="window.status='Para texto em NEGRITO';" onMouseOut="window.status='';";>
  <input name="Submit3" type="button" class="botoes" value="[I]"  onclick="javascript:SelText('italico')"onMouseOver="window.status='Serve para deixar o texto em ITALICO';" onMouseOut="window.status='';";>
  <input name="Submit4" type="button" class="botoes" value="[Tgrande]" onclick="javascript:SelText('big')" onMouseOver="window.status='Serve para deixar seu texto bem GRANDE';" onMouseOut="window.status='';";>
  <input name="Submit5" type="button" class="botoes" value="[Tmedio]" onclick="javascript:SelText('medio')" onMouseOver="window.status='Serve para deixar o texto com tamanho MEDIO';" onMouseOut="window.status='';";>
  <input name="Submit6" type="button" class="botoes" value="[Tpequeno]"  onclick="javascript:SelText('pequeno')" onMouseOver="window.status='Serve para deixar o texto em tamanho PEQUENO';" onMouseOut="window.status='';";>
  <input name="Submit7" type="button" class="botoes" value="[URL]"  onclick="javascript:bbcode2('URL')" onMouseOver="window.status='Clique para adicionar uma URL em sua noticia';" onMouseOut="window.status='';";>
  <input name="Submit8" type="button" class="botoes" value="[EMAIL]"  onclick="javascript:bbcode2('MAIL')" onMouseOver="window.status='Clique para colocar um endereço de E-MAIL';" onMouseOut="window.status='';";>
  <input name="Submit9" type="button" class="botoes" value="[IMG]"  onclick="javascript:bbcode2('IMG')" onMouseOver="window.status='Serve para inserir uma imagem em sua noticia';" onMouseOut="window.status='';";>
  <input name="Submit94" type="button" class="botoes" value="[LEFT]"  onClick="javascript:SelText('LEFT')" onMouseOver="window.status='Use-o quando quiser alinhar algo a ESQUERDA da noticia';" onMouseOut="window.status='';";>
  <input name="Submit93" type="button" class="botoes" value="[CENTER]"  onclick="javascript:SelText('CENTER')" onMouseOver="window.status='Use-o quando quiser alinhar algo ao CENTRO da noticia';" onMouseOut="window.status='';";>
  <input name="Submit92" type="button" class="botoes" value="[RIGHT]"  onClick="javascript:SelText('RIGHT')" onMouseOver="window.status='Use-o quando quiser alinhar algo a DIREITA da noticia';" onMouseOut="window.status='';";>
</p>
<form action="<? echo "$PHP_SELF"; ?>?AcTion=78435745&n_id=<? echo "$n_id"; ?>&tab=<? echo $_GET['tab']; ?>" method="post" name="F1" id="F1">
  <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;
  <? 
	if($_POST[tabela]=="lkn_noticias")
	{ 
	echo "Titulo"; 
	} else { 
	echo "Nome"; 
	} 
	?>
  <br>
  &nbsp;&nbsp; 
  <input name="titulo" type="text" class="botoes" id="titulo2" value="<? 
	if($_POST[tabela]=="lkn_noticias")
	{ 
	echo "$titulo"; 
	} else { 
	echo "$nome"; 
	} 
	?>">

  <? 
	if($_POST[tabela]=="lkn_noticias")
	{ 
  ?>
    Area:<select name="area" class="botoes" id="area">
    <?
    
	$sql = mysql_query("SELECT * FROM lkn_zonas ORDER BY id ASC");
	while ($z = mysql_fetch_array($sql))
	{
		$zona = $z['area'];
		$check="";
		if($area==$zona){
		$check="SELECTED";
		}
		echo "<option value=\"$zona\" $check>$zona</option>";
	}

		?>
		<?
		
		}
		
		?>
  </select>
  <br>
  &nbsp;&nbsp;<? 
	if($_POST[tabela]=="lkn_noticias")
	{ 
	echo "Noticia"; 
	} else { 
	echo "Comentario"; 
	} 
	?><br>
  &nbsp;&nbsp; 
  <textarea name="noticia" cols="40" rows="8" class="botoes" id="textarea"><? 
	if($_POST[tabela]=="lkn_noticias")
	{ 
	echo "$noticia"; 
	} else { 
	echo "$comentario"; 
	} 
	?></textarea>
  <br>
  &nbsp;&nbsp;
  <input name="Submit" type="submit" class="botoes" value="Pronto Editei!">
  </font></strong> 
</form>
<p align="left"> 
  <? } } 
close_con();
?>
  <br>
  &nbsp;&nbsp;&nbsp;<a href="javascript:window.close();"><img src="images/bt_close_window.gif" width="100" height="15" border="0"></a> 
</p>
</body>
</html>
