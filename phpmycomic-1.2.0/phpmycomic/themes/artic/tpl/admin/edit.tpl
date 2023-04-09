<form class="thin" method="post" action="{form}">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_edit}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="40%" class="cell">{lang_edit_info}</td>
	        	<td width="60%" class="cell"><input type="text" name="new_file" class="formfield" value="{new_name}"><input type="hidden" name="old_file" value="{old_name}"><input type="hidden" name="number" value="{old_type}"></td></tr>
	        	<tr><td width="40%" class="cell">{lang_option}</td>
	        	<td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_edit}" class="formbutton"><font class="error"><b>{errormsg}</b></font></td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>