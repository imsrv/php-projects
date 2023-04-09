<?
	##############################################################################
	# PROGRAM : ePay                                                          #
	# VERSION : 1.55                                                             #
	#                                                                            #
	##############################################################################
	# All source code, images, programs, files included in this distribution     #
	# Copyright (c) 2002-2003                                                    #
	#		  Todd M. Findley       										  #
	#           All Rights Reserved.                                             #
	##############################################################################
	#                                                                            #
	#    While we distribute the source code for our scripts and you are         #
	#    allowed to edit them to better suit your needs, we do not               #
	#    support modified code.  Please see the license prior to changing        #
	#    anything. You must agree to the license terms before using this         #
	#    software package or any code contained herein.                          #
	#                                                                            #
	#    Any redistribution without permission of Todd M. Findley                      #
	#    is strictly forbidden.                                                  #
	#                                                                            #
	##############################################################################

	chdir('..');
	require('config.php');

	session_start();
	if($_SESSION['suid']){$suid = $_SESSION['suid'];$id = "suid=$suid";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?=$sitename?> Admin Menu.</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
	<!--
	a:hover {  font-weight: bold; text-decoration: none; text-transform: capitalize}
	a:link {  font-weight: bold; text-decoration: none; text-transform: capitalize}
	a:visited {  font-weight: bold; text-decoration: none; text-transform: capitalize}
	a:active {  font-weight: bold; text-decoration: none; text-transform: capitalize}
	.menu {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; color: #FFFFFF; background-color: #000099; text-decoration: none}
	.label {  font-family: Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; text-decoration: none}
	.fields {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000099; text-decoration: none; background-color: #F3F3F3; border-color: #666666 #333333 #333333 #999999; font-style: normal; padding-top: 0px; padding-right: 2px; padding-bottom: 0px; padding-left: 2px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
	.fields_text {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000; background-color: #E5E5E5; border-color: #000099 #000099 #000099 #000033 border-top-width: thin; border-right-width: thin}
	.fields_text2 {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000; background-color: #DBDBDB; border-color: #000099 #000099 #000099 #000033 border-top-width: thin; border-right-width: thin}
	.fields_back {  background-color: #000099; font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #FFFFFF}
	.main {  font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000099; background-color: #F9F9F9}
	-->
</style>
</head>
<body bgcolor="#EFEFEF" rightmargin="0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="70%">
		<table width="95%" border="0" cellspacing="0" cellpadding="2" class="label">
		<tr>
			<td>
				<FONT FACE=VERDANA  size=5 color="#006699"><B>e<FONT color="#FFBB00">Pay</font> Admin</B>
			</td>
		</tr>
		</table>
	</td>
	<td width="30%" valign="middle" align=right style="padding-right:10px">
		<table width="100%" border="0" cellspacing="0" cellpadding="2" class="label">
		<tr>
			<td class="label">
				<a href=<?=$siteurl?>?<?=$id?> target=mainsite><font color="#5A6782"><?=strtoupper($sitename)?> HOME PAGE</font></a>
			</td>
			<td>
				<div align="right"><a href="index.php?logout=1" target=_top><font color="#5A6782">LOGOUT</font></a></div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<a href=right.php?<?=$id?> target=right><font color="#5A6782">ADMINISTRATIVE INDEX</font></a>
			</td>
			<td>
				<div align="right">
				<a href=# onClick="parent.menu.location.reload();" target="menu"><font color="#5A6782">RELOAD MENU</font></a>
				</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>