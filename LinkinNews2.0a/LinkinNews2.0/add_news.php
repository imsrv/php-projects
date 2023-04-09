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
<HTML>
<HEAD>
<TITLE>LinkinNews 2.0 [ New Version] </TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="css/css" rel="stylesheet" type="text/css">
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
<link href="css/css.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<div id="Layer1" style="position:absolute; left:606px; top:285px; width:129px; height:129px; z-index:1; visibility: visible;"> 
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
	if($n==5){ echo "</tr><tr>"; $n=1;}
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
<TABLE WIDTH=778 height="400" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  <TR> 
    <TD COLSPAN=4 align="left"> <IMG SRC="images/index_01.gif" WIDTH=273 HEIGHT=240 ALT=""></TD>
    <TD width="294" align="left"> <IMG SRC="images/index_02.gif" WIDTH=294 HEIGHT=240 ALT=""></TD>
    <TD COLSPAN=4 align="left"> <img src="images/index_03.gif" width=211 height=240 alt=""></TD>
    <TD width="1"> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=240 ALT=""></TD>
  </TR>
  <TR> 
    <TD width="144" bgcolor="#F0F0F0">&nbsp; </TD>
    <TD COLSPAN=7 bgcolor="F0F0F0"> <IMG SRC="images/index_05_addnews.gif" WIDTH=469 HEIGHT=23 ALT=""></TD>
    <TD width="166" ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0">
      <? include "menu.htm"; ?>
    </TD>
    <TD width="12" ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"> 
      <form action="<? echo "$PHP_SELF"; ?>?AcTion=1111" method="post" name="F1" id="F1">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr> 
            <td height="12" bgcolor="#F2F2F2"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">BBCode</font></strong></td>
          </tr>
          <tr> 
            <td height="46"><div align="justify">
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
              </div></td>
          </tr>
        </table>
        <img src="includes/box.gif" width="11" height="10"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="#" onClick="window.open('imagens.php','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=360'); return false;">Ver 
        minhas Imagens</a></font><br>
        <img src="includes/box.gif" width="11" height="10"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="new_zone.php" >Criar 
        nova area</a></font> <br>
        <img src="includes/box.gif" width="11" height="10"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="#" onClick="window.open('smyles.php','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=360'); return false;">Adicionar 
        Smyles </a></font> <br>
        <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Titulo 
        da Noticia: <br>
        <input name="titulo" type="text" class="botoes" id="titulo" value="<? echo $_POST['titulo']; ?>">
        <br>
        Noticia:<br>
        <textarea name="noticia" cols="70" rows="13" class="botoes" id="noticia"><? echo $_POST['noticia']; ?></textarea>
        <br>
        Postar esta noticia somente no dia:<br>
        <select name="dia" class="botoes">
          <option value="" selected>-</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        / 
        <select name="mes" class="botoes">
          <option value="" selected>-</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
        </select>
        / 
        <select name="ano" class="botoes">
          <option value="-" selected>-</option>
          <?
					 $anoatual= date("Y");
					  for ($n=1; $n<=6;$n++){ 
					  
					   echo "<option value=$anoatual>$anoatual</option>";
					   $anoatual++;
					   }
					  ?>
        </select>
        as 
        <select name="hora" class="botoes" id="hora">
          <option value="" selected>-</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
        </select>
        : 
        <select name="minuto" class="botoes" id="minuto">
          <option value="" selected>-</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
          <option value="32">32</option>
          <option value="33">33</option>
          <option value="34">34</option>
          <option value="35">35</option>
          <option value="36">36</option>
          <option value="37">37</option>
          <option value="38">38</option>
          <option value="39">39</option>
          <option value="40">40</option>
          <option value="41">41</option>
          <option value="42">42</option>
          <option value="43">43</option>
          <option value="44">44</option>
          <option value="45">45</option>
          <option value="46">46</option>
          <option value="47">47</option>
          <option value="48">48</option>
          <option value="49">49</option>
          <option value="50">50</option>
          <option value="51">51</option>
          <option value="52">52</option>
          <option value="53">53</option>
          <option value="54">54</option>
          <option value="55">55</option>
          <option value="56">56</option>
          <option value="57">57</option>
          <option value="58">58</option>
          <option value="59">59</option>
        </select>
        : 
        <select name="segundo" class="botoes" id="segundo">
          <option value="" selected>-</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
          <option value="32">32</option>
          <option value="33">33</option>
          <option value="34">34</option>
          <option value="35">35</option>
          <option value="36">36</option>
          <option value="37">37</option>
          <option value="38">38</option>
          <option value="39">39</option>
          <option value="40">40</option>
          <option value="41">41</option>
          <option value="42">42</option>
          <option value="43">43</option>
          <option value="44">44</option>
          <option value="45">45</option>
          <option value="46">46</option>
          <option value="47">47</option>
          <option value="48">48</option>
          <option value="49">49</option>
          <option value="50">50</option>
          <option value="51">51</option>
          <option value="52">52</option>
          <option value="53">53</option>
          <option value="54">54</option>
          <option value="55">55</option>
          <option value="56">56</option>
          <option value="57">57</option>
          <option value="58">58</option>
          <option value="59">59</option>
        </select>
        <br>
        <input name="concordo" type="checkbox" class="botoes" id="concordo" value="1">
        Marque esta caixa se deseje que este noticia seja incluida ao site na 
        data marcada.<br>
        Em qual area deseja que esta noticia seja visualizada ?:<br>
        <select name="area" class="botoes" id="area">
          <?

    
	$sql = mysql_query("SELECT * FROM lkn_zonas ORDER BY id ASC");
	while ($z = mysql_fetch_array($sql))
	{
		$zona = $z['area'];
		echo "<option value=\"$zona\">$zona</option>";
	}

		?>
        </select>
        <br>
        <br>
        <input name="Submit" type="submit" class="botoes" id="Submit" value="VISUALIZAR">
        <input name="Submit" type="submit" class="botoes" value="ADICIONAR&gt;&gt;">
        </font></strong> 
      </form></TD>
    <TD width="10" ROWSPAN=7 background="images/index_10.jpg">&nbsp; </TD>
    <TD width="13" ROWSPAN=6 bgcolor="#F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=32 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=32 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=32 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=31 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=33 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=19 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 ROWSPAN=2 bgcolor="F0F0F0"> <a href="http://igorescobar.webtutoriais.com.br" target="_blank"><IMG SRC="images/index_17.gif" ALT="" WIDTH=178 HEIGHT=58 border="0"></a></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=42 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=5> <IMG SRC="images/index_18.gif" WIDTH=438 HEIGHT=16 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=16 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=144 HEIGHT=1 ALT=""></TD>
    <TD width="18"> <IMG SRC="images/spacer.gif" WIDTH=18 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=12 HEIGHT=1 ALT=""></TD>
    <TD width="99"> <IMG SRC="images/spacer.gif" WIDTH=99 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=294 HEIGHT=1 ALT=""></TD>
    <TD width="24"> <IMG SRC="images/spacer.gif" WIDTH=24 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=9 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=13 HEIGHT=8 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=165 HEIGHT=1 ALT=""></TD>
    <TD></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
<?

$acao = $_GET['AcTion'];
$submit = $_POST['Submit'];
verify_zone();
if($submit=="VISUALIZAR")
{


	$noticia = $_POST['noticia'];
	$titulo = $_POST['titulo'];

	
$preview = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr> 
    <td><img src=\"images/top_logo.gif\" width=\"200\" height=\"50\"></td>
  </tr>
  <tr>
    <td height=\"10%\" bgcolor=\"#D64B10\"></td>
  </tr>
</table><br><font face=verdana size=1><strong>$titulo</strong><br><br>$noticia<br><br><br><br><a href=\"javascript:window.close();\"><img src=\"images/bt_close_window.gif\" width=\"100\" height=\"15\" border=\"0\"></a>";

$s = mysql_query("UPDATE lkn_configs SET preview='$preview'");
	echo "<script>
	window.open('tmp.php','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=360');
	</script>";

	


} elseif($submit=="ADICIONAR>>")
{
               include "includes/config.php";


    conexao($host_db,$usuario_db,$senha_db,$BancoDeDados);

	$titulo  = $_POST['titulo'];
	$noticia = $_POST['noticia'];
	

    
	add_news($titulo,$noticia,$data = date ("d/m/Y",time()),$hora = strftime("%H:%M:%S"),$autor);

	close_con();

}
?>
