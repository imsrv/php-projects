<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
?>
<head>
<STYLE TYPE="text/css">
<!-- a:link {color:#000000;text-decoration:none}
a:active {color:none;text-decoration:none}
a:visited {color:#000000;text-decoration:none}
a:hover {color:#cccccc;text-decoration:none} -->
</STYLE> 

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="75" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="icon_menu.jpg" width="150" height="16"></td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="15" height="15">
        <param name="movie" value="quadrado.swf">
        <param name="quality" value="high">
        <embed src="quadrado.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="15" height="15"></embed></object>
      <a href="usuarios.php?op=cadastro">Inserir</a> <br>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="15" height="15">
        <param name="movie" value="quadrado.swf">
        <param name="quality" value="high">
        <embed src="quadrado.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="15" height="15"></embed></object>
      <a href="usuarios.php?op=editar">Editar</a><br>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="15" height="15">
        <param name="movie" value="quadrado.swf">
        <param name="quality" value="high">
        <embed src="quadrado.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="15" height="15"></embed></object>
      <a href="usuarios.php?op=excluir">Excluir</a></font></td>
  </tr>
  <tr> 
    <td><img src="icon_msgs.jpg" width="150" height="16"></td>
  </tr>
  <tr> 
    <td height="16" bgcolor="#F9F9F9"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="15" height="15">
        <param name="movie" value="quadrado.swf">
        <param name="quality" value="high">
        <embed src="quadrado.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="15" height="15"></embed></object>
      <a href="Msg_form.php"> Escrever mensagem</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"><img src="icon_emails.jpg" width="150" height="16"></td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="15" height="15">
        <param name="movie" value="quadrado.swf">
        <param name="quality" value="high">
        <embed src="quadrado.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="15" height="15"></embed></object>
      <a href="todos.php">Visualizar / Excluir</a><br>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="15" height="15">
        <param name="movie" value="quadrado.swf">
        <param name="quality" value="high">
        <embed src="quadrado.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="15" height="15"></embed></object>
     <a href="#" onClick="window.open('../cadastro.html','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=200,height=80'); return false;">Cadastrar E-mail</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"><img src="icon_stats.jpg" width="150" height="16"></td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"> 
      <? include "stats.php"; ?>
    </td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"><img src="icon_defalt.jpg" width="150" height="16"></td>
  </tr>
  <tr> 
    <td height="10" bgcolor="#F9F9F9"><p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Logado 
        como:</strong> 
        <? $usuario= $_COOKIE['username']; echo "$usuario"; ?>
        <? include "valida_cookies.php";?>
        <br>
        </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> </font></p></td>
  </tr>
  <tr>
    <td height="10" bgcolor="#F9F9F9"><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="logout.php"><strong>Logout</strong></a><img src="seta.jpg" width="10" height="10"></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#F9F9F9"><img src="icon_defalt.jpg" width="150" height="16"></td>
  </tr>
</table>
