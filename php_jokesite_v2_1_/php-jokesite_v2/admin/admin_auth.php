<?php
session_start();
include(DIR_SERVER_ADMIN."auth_pass.php");

if ( ((md5($HTTP_POST_VARS['adm_user']."Php-Jokesite admin authorization") != $admin_user_f) && (md5($HTTP_SESSION_VARS['adm_user']."Php-Jokesite admin authorization") != $admin_user_f)) || ((md5($HTTP_POST_VARS['adm_pass']."Php-Jokesite admin authorization") != $admin_pass_f) && (md5($HTTP_SESSION_VARS['adm_pass']."Php-Jokesite admin authorization") != $admin_pass_f)) ) {
?>
	<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
	<HTML>
	<HEAD>
		<TITLE>401 Authorization Required - release WST </TITLE>
		<style type="text/css" title="">
		td		{font-family: verdana, arial, geneva, sans-serif; font-size: 13px}
		</style>
	</HEAD>
	<BODY onLoad="document.admin_login.adm_user.focus();">
	<center>
	<font color="#FF0000"><H1>Authorization Required WST rulez</H1></font>
	<br><br>
	<form method="post" action="index.php" name="admin_login">
	<input type="hidden" name="todo" value="login">
	<table width="60%" align="center" border="0">
	<?if($HTTP_POST_VARS['adm_user'] || $HTTP_POST_VARS['adm_pass']){?>
	<tr>
		<td align="center" colspan="2" nowrap><b><font color="#FF0000">Invalid Username or password. Please try again!</font></b></td>
	</tr>
	<?}?>
	<tr>
		<td align="right" width="40%"><B>Username :</B></td><td align="left" width="60%"><input type="text" name="adm_user" size="20" value="<?=$HTTP_POST_VARS['adm_user']?>"></td>
	</tr>
	<tr>
		<td align="right" width="40%"><B>Password :</B></td><td align="left" width="60%"><input type="password" name="adm_pass" size="20" value=""></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit"  name="Go" value="Enter"></td>
	</tr>
	</table>
	</form>
	</center>
	<HR size="1">
	</BODY>
	</HTML>
	<?
	exit;
}
if($HTTP_POST_VARS['todo'] == "login")
{
	$adm_user = $HTTP_POST_VARS['adm_user'];
	session_register("adm_user");
	$adm_pass = $HTTP_POST_VARS['adm_pass'];
	session_register("adm_pass");
	refresh($HTTP_SERVER_VARS['HTTP_REFERER']);
	exit;
}
else {}
?>