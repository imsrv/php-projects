<!-- start of $Id: menu_inbox_opts.php,v 1.4 2001/11/07 23:03:54 rossigee Exp $ -->
<tr>
 <td colspan="7">
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="<?php echo $glob_theme->tr_color ?>">
		<td align="left">
			<input type="button" value="<?php echo $html_select_all; ?>" onselect="SelectAll()" onClick="SelectAll()" />
		</td>
		<td align="right">
			<? if ($delete_button_icon) { ?>
				<input type="image" src="themes/<?php echo $theme ?>/img/delete.gif" alt="<?php echo $alt_delete ?>" />
			<? } else { ?>
				<input type="submit" value="<?php echo $html_delete ?>" />
			<? } ?>
		</td>
	</tr>
</table>
 </td>
</tr>
<!-- end of $Id: menu_inbox_opts.php,v 1.4 2001/11/07 23:03:54 rossigee Exp $ -->
