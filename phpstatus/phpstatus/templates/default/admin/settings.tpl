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
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_SETTINGS}</font></td>
</tr>
<tr>
<td width="100%" valign="top">
<form action="edit_settings.php" method="post">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_SITETITLE}:</font></td>
<td width="50%" valign="top" align="left"><input type="text" name="site_title" id="site_title" value="{SITE_TITLE}"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_DOMAIN}:</font></td>
<td width="50%" valign="top" align="left"><input type="text" name="domain" id="domain" value="{DOMAIN}"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_SCRIPTPATH}:</font></td>
<td width="50%" valign="top" align="left"><input type="text" name="script_path" id="script_path" value="{SCRIPT_PATH}"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_DEFAULTLANG}:</font></td>
<td width="50%" valign="top" align="left">
<select name="default_lang">
<!-- BEGIN lang -->
<option value="{lang.NAME}" {lang.SELECTED}>{lang.NAME}</option>
<!-- END lang -->
</select></td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_DEFAULTTHEME}:</font></td>
<td width="50%" valign="top" align="left">
<select name="default_theme">
<!-- BEGIN theme -->
<option value="{theme.NAME}">{theme.NAME}</option>
<!-- END theme -->
</select></td>
</tr>
</table>
<br>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="10%" valign="top" align="center"><input type="submit" name="submit" value="Edit"></td>
</tr>
</table>
</form>
</td>
</tr>
</table></td>
</tr>
</table>
<br>