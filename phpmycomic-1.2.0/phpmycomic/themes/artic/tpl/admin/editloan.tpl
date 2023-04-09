<FORM method="post" action="{get_form}" class="thin">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_loanedit}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="100%" class="cellhead" colspan="2">1. {lang_comic_info}</td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_comic_name}</td><td width="60%" class="cell"><b>{comic_name} #{comic_issue}{comic_issueltr}</b></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_comic_story}</td><td width="60%" class="cell">{comic_story}</td></tr>
		        <tr><td width="100%" class="cellhead" colspan="2">2. {lang_loan_info}</td></tr>
		        <tr><td width="40%" valign="middle" class="cell">{lang_lend_name}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_name" class="formfield" value="{loan_name}"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_lend_date}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_date" class="formfield" value="{loan_date}"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_lend_due}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_due" class="formfield" value="{loan_due}"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_lend_notes}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_notes" class="formfield" value="{loan_notes}"><input type="hidden" name="loan_uid" value="{loan_uid}"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_change}" class="formbutton"></td></tr>	
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>