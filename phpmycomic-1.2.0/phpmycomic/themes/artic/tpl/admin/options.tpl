<form class="thin" method="post" action="function.php?cmd=adminoption">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_personal}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="50%" class="cell">{lang_user_name}</td>
		        <td width="50%" class="cell"><input type="text" name="admin_name" class="formfield" value="{pmcuser}"></td></tr>
		        <tr><td width="50%" class="cell">{lang_user_mail}</td>
		        <td width="50%" class="cell"><input type="text" name="admin_mail" class="formfield" value="{pmcmail}"></td></tr>
		        <tr><td width="50%" class="cell">{lang_user_user}</td>
		        <td width="50%" class="cell"><b>Admin</b></td></tr>
		        <tr><td width="50%" class="cell">{lang_user_pass1}</td>
		        <td width="50%" class="cell"><input type="password" name="admin_pass1" class="formfield" value=""></td></tr>
		        <tr><td width="50%" class="cell">{lang_user_pass2}</td>
		        <td width="50%" class="cell"><input type="password" name="admin_pass2" class="formfield" value=""></td></tr>
		        <tr><td width="50%" class="cell">{lang_option}</td>
		        <td width="50%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_change}" class="formbutton"><font class="error"><b>{errormsg}</b></font></td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>