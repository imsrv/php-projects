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
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_EDITSERVER}</font></td>
</tr>
<tr>
<td width="100%" valign="top">
<form action="server_edited.php" method="post">
{HIDDEN}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_SERVERNAME}:</font></td>
<td width="50%" valign="top" align="left">{NAME}</td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_SERVERIP}:</font></td>
<td width="50%" valign="top" align="left">{IP}</td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_GROUP}:</font></td>
<td width="50%" valign="top" align="left">
<select name="group">
<!-- BEGIN groups -->
<option value="{groups.ID}" {groups.SELECT}>{groups.NAME}</option>
<!-- END groups -->
</select>
</td>
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