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
    <TD COLSPAN=7> <IMG SRC="images/index_05.gif" WIDTH=469 HEIGHT=23 ALT=""></TD>
    <TD ROWSPAN=7 bgcolor="F0F0F0">&nbsp; </TD>
    <TD> <IMG SRC="images/spacer.gif" WIDTH=1 HEIGHT=23 ALT=""></TD>
  </TR>
  <TR> 
    <TD COLSPAN=2 rowspan="8" valign="top" bgcolor="F0F0F0">
      <? include "menu.htm"; ?>
    </TD>
    <TD ROWSPAN=7 background="images/index_08.gif">&nbsp; </TD>
    <TD COLSPAN=3 ROWSPAN=7 valign="top" background="images/index_09.gif"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
      <?	

	  $acao = $_GET['AcTion'];
	  if($acao==753415)
	 {
	  	$area = $_POST['area'];
	  	$x = $_POST['x'];
      	$y = $_POST['y'];
      	$xy = $x."x".$y;
		$noticias_por_pagina = $_POST['noticias_por_pagina'];
		$paginacao = $_POST['paginacao'];
		$template = $_POST['template'];
		$desej = $_POST['desej'];
		$palavrao = $_POST['palavrao'];
		

		$sql = mysql_query("SELECT * FROM lkn_configs");
		
		$d = mysql_fetch_row($sql);
		$url_admin = $d[0];
        $urlpath2= explode("/",$url_admin);
		$size = count($urlpath2)-2;
		
		echo "
		Para as noticias aparecerem dinamicamente em seu site, copie(CTRL + C) e cóle(CTRL + V) Em qualquer lugar do seu website<br>
		<textarea name=\"codigo\" rows=\"8\" cols=75 class=botoes>
&lt;?
\$url = \"$url_admin\";
\$url_path = explode(\"/\", \$url);

include \"\$url_path[$size]/includes/config.php\";
include \"\$url_path[$size]/LKn_funcs.php\";
conexao(\$host_db,\$usuario_db,\$senha_db,\$BancoDeDados);		
mostra_news(\"$area\",$noticias_por_pagina,$desej,\"$template\",$paginacao,\"$xy\",$palavrao);
close_con();
?&gt;
</textarea>";
}
?>
      <br>
      Preencha os campos abaixo corretamente antes de confirmar o formul&aacute;rio: 
      <br>
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> </font></strong></font> 
      <form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>?AcTion=753415">
        <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
        qual se&ccedil;&atilde;o &eacute; o codigo?<br>
        </font></strong> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        <select name="area" class="botoes" id="select">
          <?
	$sql = mysql_query("SELECT * FROM lkn_zonas ORDER BY id DESC");
	while ($z = mysql_fetch_array($sql))
	{
		$zona = $z['area'];
		echo "<option value=\"$zona\">$zona</option>";
	}
		?>
        </select>
        </strong></font> <font size="1"><br>
        <strong><font face="Verdana, Arial, Helvetica, sans-serif">Qual template 
        gostaria que fosse usado nesta area ?</font></strong><br>
        </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>
        <select name="template" class="botoes" id="select2">
          <?
	$sql = mysql_query("SELECT * FROM lkn_templates") or die (mysql_error());
	while ($z = mysql_fetch_array($sql))
	{
		$tp_name = $z['Template_name'];
		echo "<option value=\"$tp_name\">$tp_name</option>";
	}
	close_con();
		?>
</select>
        </strong></font><font size="1"><br>
        <strong><font face="Verdana, Arial, Helvetica, sans-serif">Quantas noticias 
        por pagina voc&ecirc; gost&aacute;ria?<br>
        <input name="noticias_por_pagina" type="text" class="botoes" id="noticias_por_pagina">
        <br>
        Qual tipo de pagina&ccedil;&atilde;o voc&ecirc; deseja?</font></strong><br>
        <select name="paginacao" class="botoes" id="paginacao">
<option value="1">&lt;&lt; 
          Anterior 1 | 2 | 3 | .... Proximo &gt;&gt;</option>
          <option value="2">&lt;&lt;Anterior 
          [ 1 ] | 2 | 3 |....Proximo &gt;&gt;</option>
          <option value="3">&lt;&lt; 
          Anterior Proxima &gt;&gt;</option>
          <option value="4">&lt;&lt; 
          &lt; [ 1 ] &gt; &gt;&gt;</option>
        </select>
        <br>
        <font face="Verdana, Arial, Helvetica, sans-serif"><strong>Permitir que 
        os visitantes comentem as noticias ?</strong></font><br>
        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
        <select name="desej" class="botoes" id="desej">
          
          <option value="1">N&atilde;o</option>
          <option value="0">Sim</option>
        </select>
        </strong></font><font size="1"> <br>
        <font face="Verdana, Arial, Helvetica, sans-serif"><strong>Permitir palavr&otilde;es 
        nos coment&aacute;rios desta noticia?</strong></font><br>
        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        <select name="palavrao" class="botoes" id="select3">
<option value="0">N&atilde;o</option>
          <option value="1" selected>Sim</option>
        </select>
        </strong></font><font size="1"> <br>
        <font face="Verdana, Arial, Helvetica, sans-serif"><strong>Qual a largura 
        ea altura que deseja para sua pop-up?</strong></font></font> <font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Certifique-se 
        de que as medidas abaixo estejam em pixels</font><br>
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">Largura : 
        <input name="x" type="text" class="botoes" id="x" size="8">
        Altura: 
        <input name="y" type="text" class="botoes" id="y" size="8">
        </font> <br>
        <input name="Submit" type="submit" class="botoes" value="Gerar Codigo !">
      </form>

      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
      </font> </strong></font></TD>
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
