<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_artist}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="100%" class="cellhead" colspan="2">1. {lang_head_addartist}</td></tr>

				<FORM method="post" action="{form_artist}" class="thin">
				<tr><td width="40%" valign="middle" class="cell">{lang_add_artist}</td><td width="60%" class="cell"><INPUT TYPE="text" name="art_name" class="formfield" value="" accesskey="1"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_select_artisttype}</td><td width="60%" class="cell"><input type="checkbox" name="check_writer" value="1">{lang_type_writer}&nbsp;&nbsp;<input type="checkbox" name="check_inker" value="1">{lang_type_inker}&nbsp;&nbsp;<input type="checkbox" name="check_penciler" value="1">{lang_type_penciler}&nbsp;&nbsp;<input type="checkbox" name="check_colorist" value="1">{lang_type_colorist}&nbsp;&nbsp;<input type="checkbox" name="check_letterer" value="1">{lang_type_letterer}&nbsp;&nbsp;<input type="checkbox" name="check_cover" value="1">{lang_type_cover}</td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_submit}" class="formbutton"></td></tr>
				</form>

		        <tr><td width="100%" class="cellhead" colspan="2">2. {lang_head_addseries}</td></tr>

		        <FORM method="post" action="{form_series}" class="thin">
		        <tr><td width="40%" valign="middle" class="cell">{lang_add_series}</td><td width="60%" class="cell"><INPUT TYPE="text" name="art_name" class="formfield" value="" accesskey="2"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_url_series}</td><td width="60%" class="cell"><INPUT TYPE="text" name="art_link" class="formfield" value="http://www."></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_add_year}</td><td width="60%" class="cell"><INPUT type="text" name="art_year" class="formfield" value=""></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_submit}" class="formbutton"></td></tr>
				</form>

				<tr><td width="100%" class="cellhead" colspan="2">3. {lang_head_addpublisher}</td></tr>

				<FORM method="post" action="{form_publisher}" class="thin">
				<tr><td width="40%" valign="middle" class="cell">{lang_add_publisher}</td><td width="60%" class="cell"><INPUT TYPE="text" name="art_name" class="formfield" value="" accesskey="3"></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_url_publisher}</td><td width="60%" class="cell"><INPUT TYPE="text" name="art_link" class="formfield" value="http://www."></td></tr>
				<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_submit}" class="formbutton"></td></tr>
				</form>

				<tr><td width="100%" class="cellhead" colspan="2">4. {lang_head_addgenre}</td></tr>

				<FORM method="post" action="{form_genre}" class="thin">
				<tr><td width="40%" valign="middle" class="cell">{lang_add_genre}</td><td width="60%" class="cell"><INPUT TYPE="text" name="art_name" class="formfield" value="" accesskey="4"></td></tr>
		        <tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_submit}" class="formbutton"></td></tr>
		        </form>
		
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>