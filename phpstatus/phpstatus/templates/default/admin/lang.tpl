<table border="0" cellspacing="5" cellpadding="0" width="100%">
<tr>
<td width="15%" valign="top">
<table class="borderline" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_NAV}</font></td>
</tr>
<tr>
<td width="100%" valign="top">
<a href="../index.php">Home</a><br>
<a href="index.php">Admin Home</a><br>
<a href="groups.php">Groups</a><br>
<a href="services.php">Services</a><br>
<a href="servers.php">Servers</a><br>
<a href="settings.php">Settings</a><br>
<a href="lang.php">Languages</a><br>
<a href="themes.php">Themes</a><br>
<a href="../logout.php">Logout</a><br>
</td>
</tr>
</table></td>
<td width="85%" valign="top">
<table class="borderline" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_LANG}</td>
</tr>
<tr>
<td width="100%" valign="top">
<table border="1" bordercolor="#003399" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="33%" valign="top" align="center"><font class="text">{L_LANGID}</font></td>
<td width="33%" valign="top" align="center"><font class="text">{L_LANGNAME}</font></td>
<td width="33%" valign="top" align="center"><font class="text">{L_ACTION}</font></td>
</tr>
<!-- BEGIN lang -->
<tr>
<td width="33%" valign="top" align="center"><font class="text">{lang.ID}</font></td>
<td width="33%" valign="top" align="center"><font class="text">{lang.NAME}</font></td>
<td width="33%" valign="top"><a href="edit_lang.php?id={lang.ID}">Edit</a> | <a href="delete_lang.php?id={lang.ID}">Delete</a></td>
</tr>
<!-- END lang -->
</table>
</td>
</tr>
</table>
<br>
<table class="borderline" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_ADDLANG}</td>
</tr>
<tr>
<td width="100%" valign="top">
<form action="add_lang.php" method="post">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_LANGNAME}:</font></td>
<td width="50%" valign="top" align="left"><input type="text" name="name" id="name"></td>
</tr>
</table>
<br>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="10%" valign="top" align="center"><input type="submit" name="submit" value="Add Language"></td>
</tr>
</table>
</form>
</td>
</tr>
</table></td>
</tr>
</table>
<br>