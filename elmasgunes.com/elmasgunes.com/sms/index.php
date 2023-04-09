<html>
<head>
<title>SMS Sistemleri</title>
<meta name="description" content="SMS Sistemleri">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="stylesheet" type="text/css" href="_gerekli/style.css">
</head>
<body bgcolor="#FFFFFF" background="_image/back.gif" style="margin: 0px; cursor:default" onMouseOver="window.defaultStatus='SMS Sistemleri'; return true" onLoad="window.defaultStatus='SMS Sistemleri'">
<div align="center">
<TABLE bgcolor="#FFFFFF" align="center" border="0" cellpadding="0" cellspacing="0" width="374" height="100%" style="border: 2px dotted #666666; border-top: 0px; border-bottom: 0px">
 <TR>
  <TD width="374" height="150" align="center" valign="bottom">
   <img src="_logo/270-100.gif" width="270" height="100" border="0">
  </TD>
 </TR>
 <TR>
  <TD height="100" align="center" valign="middle">
   <font class="baslik">Lütfen giriş yapınız</font>
  </TD>
 </TR>
 <TR>
  <TD height="100%" align="center" valign="top">

<font color="red"><b><? echo $_GET["hata"] ?></b></font>

<form action="giris.php" method="post">
<table cellpadding="0" cellspacing="5" border="0">
 <tr><td>Kullanıcı Adı:</td><td><input name="kullaniciadi" type="text" size="14" class="form" maxlength="32"></td></tr>
 <tr><td>Şifre:</td><td><input name="sifre" type="password" size="14" class="form" maxlength="32"></td></tr>
 <tr><td colspan="2" align="center"><input name="giris" type="submit" value="  Giriş Yap  " class="buton"></td></tr>
</table>
</form>

  </TD>
 </TR>
 <TR>
  <TD height="20" align="right" valign="top">
   <font class="kucuk">host: <a href="http://www.elmasgunes.net" target="_blank" style="font-size: 9px">elmasgunes.net</a>   |   © 2004 SMS Sistemleri   </font>
  </TD>
 </TR>
</TABLE>
</div>
</body>
</html>
