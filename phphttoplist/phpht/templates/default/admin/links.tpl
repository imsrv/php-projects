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
<td width="90%" valign="top">
<center>
<table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" width="75%">
<tr>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_NAME}</font></td>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_USERNAME}</font></td>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ACT}</font></td>
<td width="25%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ACTION}</font></td>
</tr>
<!-- BEGIN links -->
<tr>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{links.NAME}</font></td>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{links.USER}</font></td>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{links.ACTIVATED}</font></td>
<td width="25%" valign="top" align="center" bgcolor="#FFFFFF"><a href="edit_link.php?link_id={links.ID}">Edit</a> | <a href="delete_link.php?link_id={links.ID}">Delete</a>{links.ACTIVATE} | <a href="resend.php?link_id={links.ID}">Resend vote URL</a></td>
</tr>
<!-- END links -->
</table>
</center>
<center>{PREV} {PAGENUM} {NEXT}</center><br>
<center>
<table border="0" cellspacing="0" cellpadding="0" width="75%">
<tr>
<td width="100%" valign="top" align="center" background="../templates/default/images/header.gif"><font class="block-title">{L_ADD}</font></td>
</tr>
<tr>
<td width="100%" valign="top" align="center">
<form method="post" action="add_link.php">
<table border="1" cellsapcing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_WEB}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="name" id="name"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_URL}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="url" id="url"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_BANNER}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="banner" id="banner"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_WIDTH}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="width" id="width"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right" bgcolor="#FFFFFF"><font class="text">{L_HEIGHT}:</font></td>
<td width="50%" valign="top" align="left" bgcolor="#FFFFFF"><input type="text" name="height" id="height"></td>
</tr>
</table>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center" bgcolor="#FFFFFF"><font class="text">{L_DESC}:</font></td>
</tr>
<tr>
<td width="100%" valign="top" align="center" bgcolor="#FFFFFF"><textarea name="desc" id="desc" cols="40" rows="8"></textarea></td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center"><input class="mainoption" type="submit" name="submit" value="Add Website"> <input class="mainoption" type="reset" name="reset" value="Reset Form"></td>
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