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
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_SERVERS}</font></td>
</tr>
<tr>
<td width="100%" valign="top">
<table border="1" bordercolor="#003399" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="25%" valign="top" align="center"><font class="text">{L_SERVERID}</font></td>
<td width="25%" valign="top" align="center"><font class="text">{L_SERVERIP}</font></td>
<td width="25%" valign="top" align="center"><font class="text">{L_SERVERNAME}</font></td>
<td width="25%" valign="top" align="center"><font class="text">{L_ACTION}</font></td>
</tr>
<!-- BEGIN servers -->
<tr>
<td width="25%" valign="top" align="center"><font class="text">{servers.ID}</font></td>
<td width="25%" valign="top" align="center"><font class="text">{servers.IP}</font></td>
<td width="25%" valign="top"><font class="text">{servers.NAME}</font></td>
<td width="25%" valign="top"><a href="edit_server.php?id={servers.ID}">Edit</a> | <a href="delete_server.php?id={servers.ID}">Delete</a></td>
</tr>
<!-- END servers -->
</table>
</td>
</tr>
</table>
<br>
<table class="borderline" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="100%" valign="top" align="center" class="block-header"><font class="header">{L_ADDSERVER}</font></td>
</tr>
<tr>
<td width="100%" valign="top">
<form action="add_server.php" method="post">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_SERVERNAME}:</font></td>
<td width="50%" valign="top" align="left"><input type="text" name="name" id="name"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_SERVERIP}:</font></td>
<td width="50%" valign="top" align="left"><input type="text" name="ip" id="ip"></td>
</tr>
<tr>
<td width="50%" valign="top" align="right"><font class="text">{L_GROUP}:</font></td>
<td width="50%" valign="top" align="left">
<select name="group">
<!-- BEGIN groups -->
<option value="{groups.ID}">{groups.NAME}</option>
<!-- END groups -->
</select></td>
</tr>
</table>
<br>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="10%" valign="top" align="center"><input type="submit" name="submit" value="Add Server"></td>
</tr>
</table>
</form>
</td>
</tr>
</table></td>
</tr>
</table>
<br>