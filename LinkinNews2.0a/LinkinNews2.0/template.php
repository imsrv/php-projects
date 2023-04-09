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
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<TABLE WIDTH=778 BORDER=0 CELLPADDING=0 CELLSPACING=0>
  <TR> 
    <TD COLSPAN=4> <IMG SRC="images/index_01.gif" WIDTH=273 HEIGHT=240 ALT=""></TD>
    <TD> <IMG SRC="images/index_02.gif" WIDTH=294 HEIGHT=240 ALT=""></TD>
    <TD COLSPAN=4> <IMG SRC="images/index_03.gif" WIDTH=211 HEIGHT=240 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=240 ALT=""></TD>
  </TR>
  <TR> 
    <TD bgcolor="#F0F0F0">&nbsp; </TD>
    <TD COLSPAN=7> <IMG SRC="images/index_05_template.gif" WIDTH=469 HEIGHT=23 ALT=""></TD>
    <TD ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0"> 
      <? include "menu.htm"; ?>
    </TD>
    <TD ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>O 
        que deseja fazer ?</strong></font></p>
      <form name="form1" method="post" action="">
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong> <img src="includes/box.gif" width="11" height="10"> 
        Editar uma template:<br>
        <select name="template" class="botoes" id="select">
          <?
;
		
		$sql = mysql_query("SELECT * FROM lkn_templates") or die (mysql_error());
		while ($z = mysql_fetch_array($sql))
		{
			$tp_name = $z['Template_name'];
			echo "<option value=\"$tp_name\">$tp_name</option>";
		}
		
		?>
        </select>
        </strong></font> 
        <input name="Submit" type="submit" class="botoes" value="Editar">
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
        <?	 

		$acao = $_GET['AcTion'];
		$submit = $_POST['Submit'];
		$t = $_POST['template'];
	if($submit=="Editar")
	{
		$template = $_POST['template'];
		$sql = mysql_query("SELECT * FROM lkn_templates WHERE Template_name='$t'");
		
		while ($d = mysql_fetch_array($sql))
		{
		$tp = $d['template'];
		echo "<textarea name=\"template\" cols=\"70\" rows=\"5\" class=\"botoes\" id=\"template\">$tp</textarea>
		<br><input name=\"Submit\" type=\"submit\" class=\"botoes\" value=\"Pronto, Editei !\">";
		}
		
	}
	if($submit=="Pronto, Editei !")
	{
	
	update_template();
		
	}
	if($submit=="Pronto, Meu template ta show!")
	{
	$template = $_POST['template_new'];
	$name_tp= $_POST['nome_tp'];
	
	$sql = mysql_query("INSERT INTO lkn_templates (Template_name,template) VALUES ('$name_tp','$template')");


    if($sql)
              {
                 echo "<script>window.alert(\"Template criada com sucesso\");</script>";
                 echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
              }	
	}

		?>
        </font> <br>
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong> <img src="includes/box.gif" width="11" height="10"> 
        Criar uma nova template:</strong></font> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font><br>
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para fazer 
        a edi&ccedil;&atilde;o ou cria&ccedil;&atilde;o da sua template &eacute; 
        muito simples. Apenas crie sua template no bloco de notas ou dreamweaver 
        ou qualquer outro editor html copie e cole o codigo aqui</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif">. 
        <br>
        &Eacute; ai que vem a duvida. Poxa, Como vou fazer para que meu simples 
        template em HTML apareca as minhas noticias, e pra que tudo isso ? Este 
        recurso serve para que as noticias sejam exibidas a seu gosto. Se voce 
        quer que suas noticias aparecam assim:<br>
        <br>
        Titulo da noticia<br>
        Noticia<br>
        Data &amp; Hora<br>
        <strong>Seu template vai ficar assim:</strong><br>
        [#TITULO#]&lt;br&gt;<br>
        [#NOTICIA#]&lt;br&gt;<br>
        [#D#] - [#H#]</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
        <br>
        <a href="#" onClick="window.open('recursos.htm','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=360'); return false;"><img src="includes/box.gif" width="11" height="10" border="0"> 
        Clique aqui para exibir a lista completa dos codigos/recursos</a></font><br>
        <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">D&ecirc; 
        um nome &agrave; esta template:</font></strong><br>
        <input name="nome_tp" type="text" class="botoes" id="nome_tp">
        <br>
        <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Template: 
        </font></strong><br>
        <textarea name="template_new" cols="70" rows="5" class="botoes" id="template">
</textarea>
        <br>
        <input name="Submit" type="submit" class="botoes" id="Submit" value="Pronto, Meu template ta show!">
      </form>
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        </strong></font></p>
      </TD>
    <TD ROWSPAN=7 background="images/index_09.jpg">&nbsp; </TD>
    <TD ROWSPAN=6 bgcolor="#F0F0F0">&nbsp; </TD>
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
    <TD height="42"> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=42 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=5> <IMG SRC="images/index_18.gif" WIDTH=438 HEIGHT=16 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=16 ALT=""></TD>
  </TR>
  <TR> 
    <TD> <IMG SRC="images/spacer.gif" WIDTH=144 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=18 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=12 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=99 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=294 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=24 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=9 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=13 HEIGHT=1 ALT=""></TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=165 HEIGHT=1 ALT=""></TD>
    <TD></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
