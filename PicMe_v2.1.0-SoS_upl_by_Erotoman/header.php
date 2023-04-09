<?PHP
/*
#
#	$Id: HEADER.PHP
#	Version 2.1.0
#
*/

session_name("picme");
session_start(); 
header("Cache-control: private"); // IE 6 Fix. 
$uname = $_SESSION["picme"];
session_register("count");
$votesleft = 30-$count;

include "settings.php";
include "functions.php";
?>

<html>
<head>
<title> .: <? echo $sitename ?> :.</title>
<META NAME="keywords" CONTENT="">
<link rel="stylesheet" href="style.css">
</head>
<body bgcolor="<? echo $pagecolor ?>">
<TABLE BORDER=0 Width=100%>
<TR><!-- Row 1 -->
	<TD Width=50%><IMG SRC="images/logow.gif" BORDER="0">
	</TD>
	<?
	if ($displaybanners == "1") {
	echo "<TD ALIGN=right Width=50%>";
	$level=1;
	include("getbanner.php"); 
	} else {
	echo "<TD ALIGN=right Width=50%>";
	}
	?>
	
	</TD>
</TR>
</TABLE>

<table cellpadding="0" cellspacing="0" border="0" width="620" align="center">
	<tr>
		<td align="left" valign="top">
<table cellpadding="2" cellspacing="0" border="0" width="98%">
	<tr>
		<td><CENTER>
<table border="0" cellspacing="0" width="99%" cellpadding="0">
<TBODY>
	<tr>
		<td width="100%" bgcolor="<? echo $backcolor ?>">
<table border="0" color="#000000" cellpadding="2" cellspacing="1" width="100%">
<TBODY>
	<tr>
		<td width="100%" bgcolor="<? echo $menucolor ?>" class="title"><CENTER><B><CENTER><? echo $sitename ?></CENTER></B></CENTER>
		</td></td>
	</tr>
	</tr>
</table>
		
<table border="0" cellpadding="0" cellspacing="0" width="780" align="center">
	<tr>
		<td width="145" valign="top">
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
	<tr>
		<td valign="top"><table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
<table border="0" cellspacing="0" width="100%" cellpadding="0">
	<tr>
		<td width="100%" bgcolor="<? echo $backcolor ?>">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr>
		<td width="100%" bgcolor="<? echo $menucolor ?>" class="title"><B><CENTER>.: Site Menu :.</CENTER></B></td>
	</tr>
	<tr>
		<td width="100%" bgcolor="<? echo $boxcolor ?>">
		<? include "menu.php" ?>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td valign="top"><table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
<table border="0" cellspacing="0" width="100%" cellpadding="0">
	<tr>
		<td width="100%" bgcolor="<? echo $backcolor ?>">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr>
		<td width="100%" bgcolor="<? echo $menucolor ?>" class="title"><B><CENTER>.: Link Partners :.</CENTER></B></td>
	</tr>
	<tr>
		<td width="100%" bgcolor="<? echo $boxcolor ?>">
		<? include "links.php" ?>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td valign="top"><table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
<table border="0" cellspacing="0" width="100%" cellpadding="0">
	<tr>
		<td width="100%" bgcolor="<? echo $backcolor ?>">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr>
		<td width="100%" bgcolor="<? echo $menucolor ?>" class="title"><B><CENTER>.: Login :.</CENTER></B></td>
	</tr>
	<tr>
		<td width="100%" bgcolor="<? echo $boxcolor ?>">
		<? include "login.php" ?>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td valign="top"><table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
<table border="0" cellspacing="0" width="100%" cellpadding="0">
	<tr>
		<td width="100%" bgcolor="<? echo $backcolor ?>">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr>
		<td width="100%" bgcolor="<? echo $menucolor ?>" class="title"><B><CENTER>.: Visitors Online :.</CENTER></B></td>
	</tr>
	<tr>
		<td width="100%" bgcolor="<? echo $boxcolor ?>"><CENTER><? echo getUsersOnline() ?></CENTER>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
		<td width="490" valign="top">
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center"><tr>
		<td align="left" valign="top">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
<table border="0" cellspacing="0" width="100%" cellpadding="0">
	<tr>
		<td width="100%" bgcolor="<? echo $backcolor ?>">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr>
		<td width="100%" bgcolor="<? echo $menucolor ?>" class="title"><B><CENTER>.: <? echo $slogan ?> :.</CENTER></B></td>
	</tr>
	<tr>
		<td width="100%" bgcolor="<? echo $boxcolor ?>">