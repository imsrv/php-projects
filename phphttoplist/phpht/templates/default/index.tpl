<br>
<table class="gen" cellspacing="0" cellpadding="0" width="75%">
<tr>
<td width="100%" valign="top" align="center" bgcolor="#CCCCCC"><center><a href="add_link.php">Add Link</a> | <a href="edit_link.php">Edit Link</a><br>
<table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="10%" valign="top" align="center" background="templates/default/images/header.gif"><font class="block-title">#</font></td>
<td width="70%" valign="top" align="center" background="templates/default/images/header.gif"><font class="block-title">{SITE}</font></td>
<td width="10%" valign="top" align="center" background="templates/default/images/header.gif"><font class="block-title">{HITS_IN}</font></td>
<td width="10%" valign="top" align="center" background="templates/default/images/header.gif"><font class="block-title">{HITS_OUT}</font></td>
</tr>
<!-- BEGIN topsites -->
<tr>
<td width="10%" align="center" bgcolor="#FFFFFF"><font class="text">{topsites.NUMBER}</font></td>
<td width="70%" valign="top" align="center" bgcolor="#FFFFFF"><a href="link.php?id={topsites.ID}" target="_blank">{topsites.BANNER}</a><br><a href="link.php?id={topsites.ID}" target="_blank">{topsites.NAME}</a><br><center><font class="text">{topsites.DESC}</font></center></td>
<td width="10%" align="center" bgcolor="#FFFFFF"><font class="text">{topsites.HITS_IN}</font></td>
<td width="70%" align="center" bgcolor="#FFFFFF"><font class="text">{topsites.HITS_OUT}</font></td>
</tr>
<!-- END topsites -->
</table>
<br>
{PREV} {PAGENUM} {NEXT}
<br>
{ADMIN}
</td>
</tr>
</table>