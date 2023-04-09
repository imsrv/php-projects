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
<?

$acao = $_GET['AcTion'];
if($acao=="45687")
{

$n_id = $_GET['n_id'];
removenews($n_id);

}


?>
<HTML>
<HEAD>
<TITLE>LinkinNews 2.0 [ New Version] </TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
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
    <TD COLSPAN=7> <img src="images/index_05.gif" width=469 height=23 alt=""></TD>
    <TD ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0"> 
      <? include "menu.htm"; ?>
    </TD>
    <TD ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FF3333"> 
          <td width="5%"><strong><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">N&ordm;</font></strong></td>
          <td width="70%"><strong><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">Titulo</font></strong></td>
          <td width="25%"> <div align="center"><font color="#FFFFFF"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Modera&ccedil;&atilde;o</font></strong></font></div></td>
        </tr>
      </table>
	  
      <?
		
	$sql = mysql_query("SELECT * FROM lkn_noticias ORDER BY id DESC LIMIT 15") or die (mysql_error());
	
	if(mysql_num_rows($sql)==0)
	{
		echo "Não há noticias cadastradas até o momento.";
	}
	else
	{
$bg="#ffffff";
$n=1;
	while($dados = mysql_fetch_array($sql))
	{
$titulo = $dados['titulo'];
$id= $dados['id'];
if ($bg=="#ffffff") //aqui faz o teste se a cor atual é branca
{
$bg = "#FBFBFB"; // se for entao ele coloca a proxima cinza
}
else
{
$bg = "#ffffff"; //se a atual fo cinza ele faz ela volvar a ser branca
}
		
	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="<? echo "$bg"; ?>">      
<tr> 
          <td width="5%" height="19"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $n; ?></font></strong></td>
          <td width="70%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $titulo; ?></font></td>
          <td width="25%">
            <div align="right"><strong><a href="#" onClick="window.open('edita.php?AcTion=751698&n_id=<? echo $id; ?>','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=500,height=500'); return false;"><img src="images/bt_editar.gif" width="50" height="15" border=0></a> 
              <a href="<? echo "$PHP_SELF"; ?>?AcTion=45687&n_id=<? echo $id; ?>"><img src="images/bt_deletar.gif" width="50" height="15" border=0></a></strong></div></td>
        </tr>
      </table>
      <?
	  $n++;	} // fecha o while
	  } // fecha o else
	  close_con();?>
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
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=42 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=5 valign="top"> <IMG SRC="images/index_18.gif" WIDTH=438 HEIGHT=16 ALT=""></TD>
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
