<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_users}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="5%" align="center" class="cellhead"></td>
		        <td width="25%" class="cellhead">{lang_list_user}</td>
		        <td width="25%" class="cellhead">{lang_list_name}</td>
		        <td width="25%" class="cellhead">{lang_list_mail}</td>
		        <td width="10%" class="cellhead">{lang_list_edit}</td>
		        <td width="10%" class="cellhead">{lang_list_delete}</td></tr>
		
		  	    <!-- START BLOCK : admin_userlist -->
		
				<tr>
		        <td width="5%" align="center" class="cell"><img src="{imgfolder}/icon_user.jpg"><br></td>
		        <td width="25%" class="cell">{usr_user}</td>
		        <td width="25%" class="cell">{usr_name}</td>
		        <td width="25%" class="cell">{usr_mail}</td>
		        <td width="10%" class="cell"><a href="admin.php?action=edituser&id={usr_id}" class="listlink">{lang_edit}</a></td>
		        <td width="10%" class="cell"><a href="function.php?cmd=deluser&id={usr_id}" class="listlink">{lang_delete}</a></td></tr>
		
		        <!-- END BLOCK : admin_userlist -->
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>