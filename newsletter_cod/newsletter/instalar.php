<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */

include "admin/config.php"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Newsletter 1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
@import url("estilos.css");
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="F1" method="post" action="exe.php">
  <table width="75" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="4"><img src="admin/newsletter_logo.jpg" width="778" height="150"></td>
    </tr>
    <tr> 
      <td colspan="4"><img src="admin/barra.jpg" width="778" height="20"></td>
    </tr>
    <tr> 
      <td width="16%">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Ol&aacute; 
        caro usu&aacute;rio, para concluir a instala&ccedil;&atilde;o ensira os 
        dados abaixo conforme suas configura&ccedil;&otilde;es de MySQL e de Administra&ccedil;&atilde;o.</strong></font></td>
    </tr>
    <tr> 
      <td height="42" colspan="4"> <hr noshade color="#000000"></td>
    </tr>
    <tr> 
      <td colspan="4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><img src="admin/seta.jpg" width="10" height="10">Configura&ccedil;&otilde;es 
        de<font color="#FF0000"> MySQL</font>(Banco de Dados):</strong></font></td>
    </tr>
    <tr> 
      <td height="25"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Host:</font></strong></td>
      <td width="10%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <? echo "$host"; ?> </font></td>
      <td width="37%" rowspan="4" bgcolor="#FFEAE8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Caso 
        os dados ao lado n&atilde;o estiverem ao certos edite o arquivo <strong>config.php</strong> 
        e configure-o.</font></td>
      <td width="37%" rowspan="4" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="21"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Usuario:</font></strong></td>
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo "$usuariodb"; ?> 
        </font></td>
    </tr>
    <tr> 
      <td height="23"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Senha:</font></strong></td>
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> <? echo "$senhadb"; ?></font></td>
    </tr>
    <tr> 
      <td height="23"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">DB:</font></strong></td>
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> <? echo "$db"; ?> 
        </font></td>
    </tr>
    <tr> 
      <td height="43" colspan="4"> <hr noshade color="#000000"></td>
    </tr>
    <tr> 
      <td height="17" colspan="4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><img src="admin/seta.jpg" width="10" height="10">Configura&ccedil;&otilde;es 
        de <font color="#FF0000">administra&ccedil;&atilde;o</font>:</strong></font></td>
    </tr>
    <tr> 
      <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Usu&aacute;rio 
        Administrador:</font></strong></td>
      <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name="usuarioadm" type="text" class="form" id="usuarioadm">
        Nome do usuario de administracao que voce deseja usar.</font></td>
    </tr>
    <tr> 
      <td height="27"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Senha:</font></strong></td>
      <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name="senhaadm" type="text" class="form" id="senhaadm">
        Senha do usu&aacute;rio de administra&ccedil;&atilde;o.</font></td>
    </tr>
    <tr> 
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
      <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td colspan="3"><input type="submit" class="botao" value="Confirmar Instala&ccedil;&atilde;o &gt;&gt;"></td>
    </tr>
    <tr> 
      <td colspan="4"><img src="admin/barra.jpg" width="778" height="20"></td>
    </tr>
    <tr> 
      <td colspan="4"><img src="admin/redape.jpg" width="778" height="100"></td>
    </tr>
  </table>
</form>
</body>
</html>
