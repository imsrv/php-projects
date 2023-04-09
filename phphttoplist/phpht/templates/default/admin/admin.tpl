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
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_USERNAME}</font></td>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_EMAIL}</font></td>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ACT}</font></td>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ACTION}</font></td>
</tr>
<!-- BEGIN admins -->
<tr>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{admins.USER}</font></td>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><a href="mailto:{admins.EMAIL}">{admins.EMAIL}</a></td>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{admins.ACTIVATED}</font></td>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><a href="edit_admin.php?userid={admins.USERID}">Edit</a> | <a href="delete_admin.php?userid={admins.USERID}">Delete</a></td>
</tr>
<!-- END admins -->
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
<form method="post" action="add_admin.php">
<table border="1" cellsapcing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_USERNAME}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="username" id="username"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_EMAIL}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="email" id="email"></td>
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
<td width="100%" valign="top" align="center"><input class="mainoption" type="submit" name="submit" value="Add Admin"> <input class="mainoption" type="reset" name="reset" value="Reset Form"></td>
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