<br>
<table class="gen" cellspacing="5" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<td width="20%" valign="top">
<table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" width="100%">
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
<table border="1" cellspacing="0" cellpadding="0" width="75%">
<tr>
<td width="50%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_NAME}</font></td>
<td width="50%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ACTION}</font></td>
</tr>
<!-- BEGIN themes -->
<tr>
<td width="50%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{themes.NAME}</font></td>
<td width="50%" valign="top" align="center" bgcolor="#FFFFFF"><a href="edit_theme.php?id={themes.ID}">Edit</a> | <a href="delete_theme.php?id={themes.ID}">Delete</a></td>
</tr>
<!-- END themes -->
</table>
</center>
<br>
<center>
<table border="0" cellspacing="0" cellpadding="0" width="75%">
<tr>
<td width="100%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ADD}</font></td>
</tr>
<tr>
<td width="100%" valign="top" align="center">
<form method="post" action="add_theme.php">
<table border="1" cellsapcing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_NAME}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="theme" id="theme"></td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center"><input class="mainoption" type="submit" name="submit" value="Add Theme"> <input class="mainoption" type="reset" name="reset" value="Reset Form"></td>
</tr>
</table></center>
</form></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>