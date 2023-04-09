<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_artist}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">

				<FORM method="post" action="{get_form}" class="thin">
				<tr><td width="40%" valign="middle" class="cell">{lang_edit_artist}</td><td width="60%" class="cell">
                <INPUT TYPE="text" name="art_name" class="formfield" value="{get_name}" accesskey="1">{edit_link}&nbsp;&nbsp;
                <INPUT TYPE="hidden" name="art_hidden1" value="{get_name}">
                <INPUT TYPE="hidden" name="art_hidden2" value="{get_type}">
                </td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_submit}" class="formbutton"></td></tr>
				</form>
		
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>