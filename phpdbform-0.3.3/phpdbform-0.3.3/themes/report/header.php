<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title><?php print "$site_title - $page_title"; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php print CHARSET; ?>">
	<style type="text/css">
	<?php include("themes/$theme/adm.css"); ?>
	</style>
</head>
<body bgcolor="<?php print $body_color; ?>" background="<?php print $body_background; ?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr><td valign="middle" align="center">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td background="themes/templ01/templ01_hbar_bg.gif">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="left" valign="bottom"><?php
if($page_title=="login") { 
  print "<img src=\"themes/templ01/templ01_hbar_left.gif\" width=50 height=20 border=0 alt=\"\">";
} else {
  print "<span class='bar'>&nbsp;$page_title</span>";
}
?></td>
<td align="right"><a href="logout.php"><img src="themes/templ01/templ01_hbar_right.gif" width="15" height="20" border="0" alt="logout"></a></td>
</tr>
</table>
</td>
</tr>
<tr>
<td bgcolor="Blue">
<table cellpadding="2" cellspacing="2" width="100%" height="100%">
<tr bgcolor="Silver">
<td align="left" valign="middle">
<br>