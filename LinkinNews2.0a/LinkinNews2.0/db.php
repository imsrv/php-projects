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
    <TD COLSPAN=7> <IMG SRC="images/index_05_db.gif" WIDTH=469 HEIGHT=23 ALT=""></TD>
    <TD ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0">
      <? include "menu.htm"; ?>
    </TD>
    <TD ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"><p><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Ol&aacute;, 
        Esta ferramenta lhe permite que voc&ecirc; fa&ccedil;a o backup total 
        ou da tabela que voc&ecirc; preferir do LinkinNews. <br>
        <strong><em>Obs:</em></strong> Para sua seguran&ccedil;a fa&ccedil;a o 
        backup total.<br>
        </font></p>
      <form name="form1" method="post" action="<? echo  "$PHP_SELF"; ?>?AcTion=15488">
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Tabela: 
          </font> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="tabela" class="botoes" id="tabela">
<?

$tabelas = tabelas();

for($i=0;$i<=count($tabelas)-1;$i++)
{
echo "<option value=\"$i\">$tabelas[$i]</option>";
}
?>
          </select>
          <input name="Submit" type="submit" class="botoes" value="OK">
          ou 
          <input name="Submit" type="submit" class="botoes" id="Submit" value="Backup total">
          </font> </div>
      </form>
	  <?


	  if($acao=="15488")
	  {
	  		if($submit=="OK")
			{
	  
	  			backup_table(1);
	  
	  		}
	  		else
	  		{
	  			backup_table(0);
	  		}
	  }
	  if($acao=="4687")
	  {
	  	  	if($submit=="OK")
			{
	  
	  			restore_table(0);
	  
	  		}
	  		else
	  		{
	  			restore_table(1);
	  		}
	  
	  }
	  
	  
	  ?>
      <br>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Restaura&ccedil;&atilde;o<br>
      </strong>Para efetuar o a restaura&ccedil;&atilde;o do banco de dados apenas 
      utilize o campo a abaixo selecione tabela e de ok. Ou para restaura&ccedil;&atilde;o 
      total somente clique no bot&atilde;o.<br>
      <font color="#FF0000">Aten&ccedil;&atilde;o: Para efetuar a restaura&ccedil;&atilde;o 
      total &eacute; preciso que os backups estejam na pasta 'backup' do sistema 
      LinkinNews2.0.</font><br>
      </font> 
      <form action="<? echo  "$PHP_SELF"; ?>?AcTion=4687" method="post" enctype="multipart/form-data" name="form1">
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Tabela: 
          <select name="tabela2" class="botoes" id="select2">
<?
$tabelas = tabelas();

for($i=0;$i<=count($tabelas)-1;$i++)
{
echo "<option value=\"$i\">$tabelas[$i]</option>";
}
?>
          </select>
          </font> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
          <input name="Submit" type="submit" class="botoes" id="Submit" value="OK">
          ou 
          <input name="Submit" type="submit" class="botoes" id="Submit" value="Restaura&ccedil;&atilde;o total">
          </font> </div>
      </form>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font></TD>
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
