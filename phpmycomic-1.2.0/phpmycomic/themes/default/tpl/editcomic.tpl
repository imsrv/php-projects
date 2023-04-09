<FORM method="post" action="{get_form}">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_comic}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="60%" align="left" class="cell">{lang_name_series}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_name" class="formselect">
	            <!-- START BLOCK : addc_series -->
	
	            <option{selected}>{pmc_name}</option>
	
	            <!-- END BLOCK : addc_series -->
	            </select>

	            </td></tr><tr><td width="60%" align="left" class="cell">{lang_story}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_story" class="formfield" value="{get_story}">
	
	            </td></tr><tr><td width="60%" class="cell">{lang_issue_volume}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_issue" class="passfield" value="{get_issue}{get_issueltr}">&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" name="com_volume" class="passfield" value="{get_volume}">
	
	            </td></tr><tr><td width="60%" class="cell">{lang_publisher}</td>
	            <td width="40%" valign="middle" class="cell">

	            <SELECT name="com_publisher" class="formselect">
	            <!-- START BLOCK : addc_publisher -->
	
	            <option{selected}>{pmc_publisher}</option>
	
	            <!-- END BLOCK : addc_publisher -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_type}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_type" class="formselect" id="com_type" onchange="togglePartComic();">
	            <!-- START BLOCK : addc_type -->
	
	            <option{selected} value="{pmc_type}">{pmc_type}</option>
	
	            <!-- END BLOCK : addc_type -->
	            </select>

	            </td></tr><tr id="showhide"><td width="60%" class="cellselect">{lang_miniseries}</td>
	            <td width="40%" valign="middle" class="cellselect">
	
	            <INPUT TYPE="text" name="com_total" class="formfield" value="{get_part2}">
	
	            </td></tr><tr><td width="60%" class="cell">{lang_genre}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_genre" class="formselect"v>
	            <!-- START BLOCK : addc_genre -->
	
	            <option{selected}>{pmc_genre}</option>
	
	            <!-- END BLOCK : addc_genre -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_format}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_format" class="formselect">
	            <!-- START BLOCK : addc_format -->
	
	            <option{selected}>{pmc_format}</option>
	
	            <!-- END BLOCK : addc_format -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_condition}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_condition" class="formselect">
	            <!-- START BLOCK : addc_condition -->
	
	            <option{selected}>{pmc_condition}</option>
	
	            <!-- END BLOCK : addc_condition -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_currency}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_currency" class="formselect">
	            <!-- START BLOCK : addc_currency -->
	
	            <option{selected}>{pmc_currency}</option>
	
	            <!-- END BLOCK : addc_currency -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_price_value}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_price" class="passfield" value="{get_price}">&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" name="com_value" class="passfield" value="{get_value}">
	
	            </td></tr><tr><td width="60%" class="cell">{lang_variation}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_variation" class="formselect">
	            <!-- START BLOCK : addc_variation -->
	
	            <option{selected}>{pmc_variation}</option>
	
	            <!-- END BLOCK : addc_variation -->
	            </select>

            	</td></tr><tr><td width="60%" class="cell">{lang_pubdate}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_pubdate" class="formfield" value="{get_pubdate}" id="data1">
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
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_artist}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="60%" class="cell">{lang_type_writer}</td>
	            <td width="40%" valign="middle" class="cell">

	            {comic_writer}
	            {writer_option}

	            </td></tr><tr><td width="60%" class="cell">{lang_type_penciler}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            {comic_penciler}
	            {penciler_option}
	
	            </td></tr><tr><td width="60%" class="cell">{lang_type_inker}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            {comic_inker}
	            {inker_option}
	
	            </td></tr><tr><td width="60%" class="cell">{lang_type_colorist}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            {comic_colorist}
	            {colorist_option}
	
				</td></tr><tr><td width="60%" class="cell">{lang_type_letterer}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            {comic_letterer}
	            {letterer_option}
	
	            </td></tr><tr><td width="60%" class="cell">{lang_type_cover}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            {comic_cover}
	            {cover_option}
	
	            </td></tr>		
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_other}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="60%" valign="middle" class="cell">Quantity</td>
				<td width="40% valign="middle" class="cell">
				
				<INPUT TYPE="text" name="com_qty" class="formfield" value="{get_qty}">
				
				</td></tr><tr><td width="60%" valign="middle" class="cell">{lang_language}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_language" class="formfield" value="{get_language}">
	
	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_translator}</td>
	            <td width="40%" valign="middle" class="cell">

	            <INPUT TYPE="text" name="com_translator" class="formfield" value="{get_translator}">

	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_useroption}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_user1" class="formfield" value="{get_user1}">
	
	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_userinput}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_user2" class="formfield" value="{get_user2}">
	
	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_coverimage}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_image" class="formfield" value="{get_image}">
	
	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_enable_ebay}</td>
	            <td width="40%" valign="middle" class="cell">
	
				<input type="radio" name="com_ebay" value="yes" onclick="toggleEbayInput(0);" {ebayyes}> {lang_ebay_yes}
          		<input type="radio" name="com_ebay" value="no" onclick="toggleEbayInput(1);" {ebayno}> {lang_ebay_no}
	
	            </td></tr><tr id="ebayshowhide"><td width="60%" valign="middle" class="cell">{lang_ebay_link}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_ebaylink" class="formfield" value="{get_ebaylink}">
	
	            </td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_storyline}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="100%" valign="middle">

	            <textarea name="com_plot" rows="8" class="formtext">{get_plot}</textarea>
	
	            </td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<center><br><INPUT type=submit name="Submit" value="{lang_button_submit}" class="formbutton">&nbsp;&nbsp;<INPUT type=reset name="Reset" value="{lang_button_reset}" class="formbutton"></center>

</form><br />