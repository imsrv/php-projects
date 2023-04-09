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
<HTML>
<HEAD>
<TITLE>LinkinNews 2.0 [ New Version] </TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="css/css.css" rel="stylesheet" type="text/css">
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
    <TD COLSPAN=7> <IMG SRC="images/index_05_configs.gif" WIDTH=469 HEIGHT=23 ALT=""></TD>
    <TD ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0">
      <? include "menu.htm"; ?>
    </TD>
    <TD ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"> <form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>?AcTion=1538">
        <?
include "includes/config.php";
include "LKn_funcs.php";
conexao($host_db,$usuario_db,$senha_db,$BancoDeDados); 		
$acao = $_GET['AcTion'];
if($acao==1538)
{
	
	update_configs($npaginas,$desej_coment);
	
}
		
?>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <strong><br>
        <br>
        </strong></font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Endere&ccedil;o 
        do seu site + a pasta do sistema <font color="#FF0000">atencao</font>:</font></strong> 
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">(com barra 
        no final)</font><br>
        <input name="url_admin" type="text" class="botoes" id="url_admin" value="<?  mostra_config(3); ?>" size="40">
        <br>
        <br>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">No 
        caso neste filtro estar ativado as palavras abaixo ser&atilde;o sensuradas:<br>
        <font color="#FF0000" size="1">Aten&ccedil;&atilde;o</font><font size="1">, 
        Caso for adicionar alguma palavra, adicioneas uma abaixo da outra.</font><br>
        <textarea name="palavras" cols="50" rows="8" class="botoes" id="palavras">
<?
$file = "filtro.txt";
$p = file($file);
		
for($i = 0; $i<=count($p); $i++)
{
echo "$p[$i]";
}
		
?>
</textarea>
        <br>
        <br>
        Para bloquear um determinado visitante que comentem as noticias digite 
        abaixo o endere&ccedil;o ip do mesmo, caso nao souber endere&ccedil;o 
        ip cosulte no buscador buscando por um determinado comentario.<br>
        <br>
        <font size="1">Ips Bloqueados:</font><br>
        <textarea name="ips" cols="50" rows="8" class="botoes" id="ips">
<?
$file = "ips.txt";
$ip = file($file);
		
for($i = 0; $i<=count($p); $i++)
{
echo "$ip[$i]";
}
		
?>
</textarea>
        <br>
        </font></strong><br>
        <input name="Submit" type="submit" class="botoes" value="Pronto, Configurei!">
      </form>
      
    </TD>
    <TD ROWSPAN=7 background="images/index_10.jpg">&nbsp; </TD>
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
