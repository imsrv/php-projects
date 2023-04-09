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
    <TD COLSPAN=7> <IMG SRC="images/index_05_env_arquivos.gif" WIDTH=469 HEIGHT=23 ALT=""></TD>
    <TD ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0"> 
      <? include "menu.htm"; ?>
    </TD>
    <TD ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Est&aacute; 
      ferramente &eacute; muito util para que voc&ecirc; possa enviar fotos para 
      o seu servidor sem ter que ligar aqueles programas chatos de FTP.<br>
      Abaixo digite o numero de arquivos que deseja fazer upload e em seguida 
      clique em ok. Para adicionalas em sua noticia &eacute; muito simples, Ir&aacute; 
      ter um link na pagina onde apos clicado o sistema ira passar a relacao dos 
      arquivos que contem na pasta Minhas Imagens do sistema. Voc&ecirc; copia 
      o link e utilizando o bbcode para Inserir imagens cole o link na caixa de 
      dialogo e d&ecirc; ok.<br>
      <strong><br>
      </strong></font> <form action="<? echo "$PHP_SELF"; ?>?gera_form=ok" method="post" enctype="multipart/form-data" name="form1">
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Quantos 
          arquivos gostaria de fazer upload ?</strong></font><br>
          <input name="numero" type="text" class="botoes" id="numero" value="<? echo "$_POST[numero]"; ?>">
          <input name="hiddenField" type="hidden" value="<? $i=1; ?>">
          <br>
          <input name="Submit" type="submit" class="botoes" value="OK">
        </div>
        <?

	  
	  $forms = $_POST['numero'];
	  $perms = $_GET['gera_form'];
	  $submit = $_POST['Submit'];

	    
	  if($submit=="OK")
      {
	  	  geraform($forms);
      }
      if($submit=="Enviar Arquivos")
	  {
	  upload($forms);
	  }


	  ?>
      </form></TD>
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
