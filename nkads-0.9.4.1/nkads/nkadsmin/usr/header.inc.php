<?
//**********************************************************************************
// NKAds                                                                                           *
//**********************************************************************************
//
// Copyright (c) 2002 NKStudios S.R.L.
// http://nkads.nkstudios.net
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
//**********************************************************************************

?>
<html>
<head>
<title>Sistema de administracion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#D7AC00" valign="middle"> 
    <td colspan="2" height="55" bgcolor="#D7AC00">&nbsp;&nbsp;<a href="index.php"><img src="../imgcomunes/logo.gif" width="225" height="35" border="0" alt="Home"></a></td>
  </tr>
</table>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="100%" bordercolor="#F4C400" bgcolor="#FFCC00">
  <tr bgcolor="#FFCC00">
<?
if($acceso_usuario == 1){
?>
    <td bgcolor="#FFCC00" width="20%">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" color="#000000" size="1">
        <b>
        <? echo $nkads_traduccion[75] ?>
        </b> </font></div>
    </td>
<?
}
?>
    <td bgcolor="#FFCC00" width="20%">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000000"><b>
        <? echo $nkads_traduccion[80] ?>
        </b></font></div>
    </td>
    <td bgcolor="#FFCC00" width="20%">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000000"><b>
        <? echo $nkads_traduccion[181] ?>
        </b></font></div>
    </td>
  </tr>
  <tr bgcolor="#FFD735">
<?
if($acceso_usuario == 1){
?>
    <td width="20%" bgcolor="#FFD735">
      <div align="center"><font size="-2" color="#000000"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="banners_n.php" class="negro">
        <? echo $nkads_traduccion[76] ?>
        </a><br>
        </font><font size="-2" color="#000000"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="banners_m.php" class="negro">
        <? echo $nkads_traduccion[78] ?>
        </a><br>
        </font></font><font size="-2" color="#000000"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="banners_e.php" class="negro">
        <? echo $nkads_traduccion[79] ?>
        </a></font></font><font face="Verdana, Arial, Helvetica, sans-serif">
        </font></font></div>
    </td>
<?
}
?>
    <td width="20%" valign="top">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><a href="estadisticas_empresa.php" class="negro">
        <? echo $nkads_traduccion[203] ?>
        </a></font></div>
    </td>
    <td width="20%" valign="top">
      <div align="center"><font size="-2" color="#000000"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="password_n.php" class="negro">
        <? echo $nkads_traduccion[190] ?>
        </a></font></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
        </font></font></div>
    </td>
  </tr>
</table>
</body>
</html>
