<html>
<head>
<title>elmasgunes.net - Web Hosting, Web Design</title>
<meta name="description" content="elmasgunes.net - E-Mail Servisi, Web Hosting, Web Design">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="stylesheet" type="text/css" href="stil.css">
</head>
<body bgcolor="#FFFFFF" style="margin: 0px" onMouseOver="status='elmasgunes.net'; return true" onLoad="preloadImages('images/menu_host_ust_kucuk.gif');preloadImages('images/menu_host_ust_midi.gif');preloadImages('images/menu_host_ust_buyuk.gif');preloadImages('images/menu_host_ust_pro.gif');preloadImages('images/menu_host_ust_ozel.gif');preloadImages('images/menu_design_ust_kisisel.gif');preloadImages('images/menu_design_ust_katalog.gif');preloadImages('images/menu_design_ust_sirket.gif');preloadImages('images/menu_design_ust_ozel.gif');window.defaultStatus='elmasgunes.net';" onSelectStart="return false">
<div align="center">
<TABLE border="0" cellpadding="0" cellspacing="0" width="740">
<TR>
	<TD width="740" height="10"><img src="images/tasarim_ust.gif" width="740" height="10"><div style="position:absolute; left: 0px"><img src="images/tasarim_devam_ust.gif" width="700" height="10"></div></TD>
</TR>
<TR>
	<TD height="80">
		<?php /* MENU INDEX */ ?>
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td width="310" height="80" valign="middle"><a href="index.php"><img src="images/logo.gif" width="310" height="78" border="0"></a></td>
			<td width="420" align="right" valign="bottom"><?php if ( !@include("menu_index.php") ){ require("hata.php"); exit(); } ?></td>
			<td width="10"><table></table></td>
			</tr>
		</table>

	</TD>
</TR>
<TR>
	<TD height="28"><table border="0" cellpadding="0" cellspacing="0"><tr>
		<td width="500"><img src="images/tasarim_orta_sol.gif" width="500" height="28"></td>
		<td width="240"><img src="images/tasarim_orta_sag.gif" width="240" height="28"></td>
	</tr></table></TD>
</TR>
<TR>
	<TD>
		
	<TABLE border="0" cellpadding="0" cellspacing="0" height="100%"> 
	<TR>
	<TD width="127" height="100%" background="images/tasarim_menu_arka.gif" valign="top" style="line-height: 18px; padding: 10px">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%"><tr><td width="100%" valign="top"><?php if ( !@include("sol_menu.php") ){ require("hata.php"); exit(); } ?></td></tr><tr><td height="100%" align="center" valign="bottom"></td></tr></table>
	</TD>
	<TD width="576" style="padding: 8px" valign="top">
		<table border="0" cellpadding="0" cellspacing="0"> 
		<tr height="114" valign="middle">
			<td width="186" align="center"><img src="images/slogan_dogruyer.gif" width="186" height="110" border="0"></td>
			<td width="9"><table></table></td>
			<td width="381" colspan="3" valign="top">
					<?php /* KAMPANYALAR */ ?>
					<table border="0" cellpadding="0" cellspacing="0"> 
					<tr>
					<td height="9" valign="middle"><img src="images/baslik_kampanya.gif" width="186" height="9" border="0"></td>
					</tr>
					<tr>
					<td valign="top">
					<?php if ( !@include("kampanyalar.php") ){ require("hata.php"); exit(); } ?>
					</td>
					</tr>
					</table> 

			</td>
		</tr>
   		<tr height="19">
			<td colspan="5" background="images/tasarim_ara_yatay2.gif"></td>
		</tr>
		</table>