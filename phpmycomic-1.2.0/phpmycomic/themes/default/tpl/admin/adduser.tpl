<form class="thin" method="post" action="function.php?cmd=adduser">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_newuser}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="50%" class="cell">{lang_add_name}</td>
		        <td width="50%" class="cell"><input type="text" name="usr_name" class="formfield" value=""></td></tr>
		        <tr><td width="50%" class="cell">{lang_add_user}</td>
		        <td width="50%" class="cell"><input type="text" name="usr_user" class="formfield" value=""></td></tr>
		        <tr><td width="50%" class="cell">{lang_add_pass1}</td>
		        <td width="50%" class="cell"><input type="password" name="usr_pass1" class="formfield" value=""></td></tr>
		        <tr><td width="50%" class="cell">{lang_add_pass2}</td>
		        <td width="50%" class="cell"><input type="password" name="usr_pass2" class="formfield"></td></tr>
		        <tr><td width="50%" class="cell">{lang_add_mail}</td>
		        <td width="50%" class="cell"><input type="text" name="usr_mail" class="formfield" value=""></td></tr>
		        <tr><td width="50%" class="cell">{lang_option}</td>
		        <td width="50%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_adduser}" class="formbutton"><font class="error"><b>{errormsg}</b></font></td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>