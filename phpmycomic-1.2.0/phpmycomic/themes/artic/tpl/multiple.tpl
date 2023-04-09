<FORM method="post" action="{get_form}">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_addmulti}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="60%" align="left" class="cell">{lang_name_series}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_name" class="formselect">
	            <!-- START BLOCK : addc_series -->
	
	            <option{selected}>{pmc_name}</option>
	
	            <!-- END BLOCK : addc_series -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_multi_startend} (<i><font class="blue">{lang_multi_startend_nfo}</font></i>)</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="multi_start" class="passfield" value="0">&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" name="multi_end" class="passfield" value="0">
	
	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_add_volume}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_volume" class="formfield" value="1">
	
	            </td></tr><tr><td width="60%" class="cell">{lang_publisher}</td>
	            <td width="40%" valign="middle" class="cell">

	            <SELECT name="com_publisher" class="formselect">
	            <!-- START BLOCK : addc_publisher -->
	
	            <option{selected}>{pmc_publisher}</option>
	
	            <!-- END BLOCK : addc_publisher -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_type}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_type" class="formselect" id="type" onchange="togglePartComic();">
	            <!-- START BLOCK : addc_type -->
	
	            <option{selected}>{pmc_type}</option>
	
	            <!-- END BLOCK : addc_type -->
	            </select>

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

	            </td></tr><tr><td width="60%" class="cell">{lang_currency}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <SELECT name="com_currency" class="formselect">
	            <!-- START BLOCK : addc_currency -->
	
	            <option{selected}>{pmc_currency}</option>
	
	            <!-- END BLOCK : addc_currency -->
	            </select>

	            </td></tr><tr><td width="60%" class="cell">{lang_price_value}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_price" class="passfield" value="0.00">&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" name="com_value" class="passfield" value="0.00">
	
	            </td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_other}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="60%" valign="middle" class="cell">{lang_language}</td>
	            <td width="40%" valign="middle" class="cell">
	
	            <INPUT TYPE="text" name="com_language" class="formfield" value="{get_language}">
	
	            </td></tr><tr><td width="60%" valign="middle" class="cell">{lang_translator} (<i><font class="blue">{lang_translator_nfo}</font></i>)</td>
	            <td width="40%" valign="middle" class="cell">

	            <INPUT TYPE="text" name="com_translator" class="formfield" value="{get_translator}">

	            </td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<center><INPUT type=submit name="Submit" value="{lang_button_submit}" class="formbutton">&nbsp;&nbsp;<INPUT type=reset name="Reset" value="{lang_button_reset}" class="formbutton"></center>

</form>