<FORM method="post" action="{get_form}" class="thin">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_loan}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="100%" class="cellhead" colspan="2">1. {lang_comic_info}</td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_comic_name}</td><td width="60%" class="cell"><b>{comic_name} #{comic_issue}{comic_issueltr}</b></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_comic_story}</td><td width="60%" class="cell">{comic_story}</td></tr>
		        <tr><td width="100%" class="cellhead" colspan="2">2. {lang_loan_info}</td></tr>
		        <tr><td width="40%" valign="middle" class="cell">{lang_lend_name}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_name" class="formfield" value=""></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_lend_date}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_date" id="data1" class="formfield" value="{loan_date}">
				<button id="trigger1" class="formbutton">{lang_button_calender}</button>
				<script type="text/javascript">
				Calendar.setup(
				{
				inputField : "data1", // ID of the input field
				ifFormat : "%Y-%m-%d", // the date format
				button : "trigger1" // ID of the button
				}
				);
				</script></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_lend_due}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_due" id="data2" class="formfield" value="">
				<button class="formbutton" id="trigger2">{lang_button_calender}</button>
				<script type="text/javascript">
				Calendar.setup(
				{
				inputField : "data2", // ID of the input field
				ifFormat : "%Y-%m-%d", // the date format
				button : "trigger2" // ID of the button
				}
				);
				</script></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_lend_notes}</td><td width="60%" class="cell"><INPUT TYPE="text" name="loan_notes" class="formfield" value=""><input type="hidden" name="loan_uid" value="{comic_id}"><input type="hidden" name="titleid" value="{title_id}"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_loan}" class="formbutton"></td></tr>	
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>