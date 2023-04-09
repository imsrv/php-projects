<br>
<table class="gen" cellspacing="5" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<td width="20%" valign="top">
<table class="gen" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_NAV}</font></td>
</tr>
<tr>
<td width="100%" valign="top" bgcolor="#FFFFFF">
<a href="../index.php">Home</a><br>
<a href="links.php">Links</a><br>
<a href="admin.php">Admins</a><br>
<a href="reset.php">Reset Stats</a><br>
<a href="settings.php">Settings</a><br>
<a href="theme.php">Edit/Add Themes</a><br>
<a href="lang.php">Edit/Add Languages</a><br>
<a href="../logout.php">Logout</a></td>
</tr>
</table></td>
<td width="95%" valign="top">
<center>
<table class="gen" cellspacing="0" cellpadding="0" width="75%">
<tr>
<td width="100%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_EDIT}</font></td>
</tr>
<tr>
<td width="100%" valign="top" bgcolor="#FFFFFF">
<form method="post" action="admin_edited.php">
{HIDDEN}
<table border="1" cellsapcing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_USERNAME}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><font class="text">{USER}</font></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_EMAIL}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF">{EMAIL}</td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_PASSWORD}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="password" name="password" id="password"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_PASSWORD2}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="password" name="password2" id="password2"></td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center"><input class="mainoption" type="submit" name="submit" value="Edit Admin"> <input class="mainoption" type="reset" name="reset" value="Reset Form"></td>
</tr>
</table></center>
</form></td>
</tr>
</table>
</center>
</td>
</tr>
</table>
</td>
</tr>
</table>