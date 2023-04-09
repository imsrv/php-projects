<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_manage}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr>
		        <td width="20%" align="center" class="cell"><a href="admin.php?action=artist&type=type" class="defaultlink">{lang_comictype}</a></td>
		        <td width="20%" align="center" class="cell"><a href="admin.php?action=artist&type=format" class="defaultlink">{lang_format}</a></td>
		        <td width="20%" align="center" class="cell"><a href="admin.php?action=artist&type=condition" class="defaultlink">{lang_condition}</a></td>
		        <td width="20%" align="center" class="cell"><a href="admin.php?action=artist&type=variation" class="defaultlink">{lang_variation}</a></td>
		        <td width="20%" align="center" class="cell"><a href="admin.php?action=artist&type=currency" class="defaultlink">{lang_currency}</a></td>
		        </tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<br />

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{type}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr>
		        <td width="80%" class="cellhead">{lang_manage_name}</td>
		        <td width="20%" class="cellhead">{lang_manage_option}</td></tr>
		
		        <!-- START BLOCK : artist_list -->
		
		        <tr>
		        <td width="80%" class="cell">{pmc_name}</td>
		        <td width="20%" class="cell">{options}</td></tr>
		
		        <!-- END BLOCK : artist_list -->
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<br />

<form class="thin" method="post" action="function.php?cmd=admartist&type={type}">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_newoption}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="50%" class="cell">{lang_add_new} {type}</td>
        		<td width="50%" class="cell"><input type="text" name="new_option" class="formfield" value=""></td></tr>
        		<tr><td width="50%" class="cell">{lang_option}</td>
        		<td width="50%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_artist}" class="formbutton"><font class="error"><b>{errormsg}</b></font></td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>