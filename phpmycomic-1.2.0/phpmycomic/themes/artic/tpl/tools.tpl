<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_tools}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">

            <tr><td width="100%" class="cellhead" colspan="2">1. {lang_head_upload}</td></tr>

			    <form class="thin" action="function.php?cmd=upload" method="post" ENCTYPE="multipart/form-data">
	
	            <tr><td width="40%" valign="middle" class="cell" colspan="2">{lang_upload_text}</td></tr>
	            <tr><td width="40%" valign="middle" class="cell">{lang_upload_file}</td><td width="60%" class="cell"><input type="file" name="file" size="30"></td></tr>
	            <tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_upload}" class="formbutton">&nbsp;&nbsp;<INPUT type="reset" name="Reset" value="{lang_button_reset}" class="formbutton"></td></tr>
	
			    </form>

			<tr><td width="100%" class="cellhead" colspan="2">2. {lang_head_import}</td></tr>

	      		<form class="thin" action="import.php" method="post" ENCTYPE="multipart/form-data">
	
	            <tr><td width="40%" valign="middle" class="cell" colspan="2">{lang_import_text}</td></tr>
	            <tr><td width="40%" valign="middle" class="cell">{lang_import_file}</td><td width="60%" class="cell"><input type="file" name="imfile" size="30"></td></tr>
	            <tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_import}" class="formbutton">&nbsp;&nbsp;<INPUT type="reset" name="Reset" value="{lang_button_reset}" class="formbutton"></td></tr>
	
	         	</form>
         	
         	<tr><td width="100%" class="cellhead" colspan="2">3. {lang_head_checklist}</td></tr>
         	
	         	<form class="thin" action="checklist.php" method="post" target="_blank">
	         	
	         	<tr><td width="40%" valign="middle" class="cell">{lang_select_name}</td><td width="60%" class="cell">
	         	<SELECT name="check_name" class="formselect">
	            <!-- START BLOCK : name_series -->
	
	            <option{selected}>{pmc_name}</option>
	
	            <!-- END BLOCK : name_series -->
	            </select>
	         	</td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_select_vol}</td><td width="60%" class="cell"><input type="text" name="check_volume" class="formfield" value="1"></td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_select_start}</td><td width="60%" class="cell"><input type="text" name="check_start" class="formfield" value="0"></td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_select_end}</td><td width="60%" class="cell"><input type="text" name="check_end" class="formfield" value="0"></td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_ok}" class="formbutton">&nbsp;&nbsp;<INPUT type="reset" name="Reset" value="{lang_button_reset}" class="formbutton"></td></tr>
	         	
	         	</form>
         	
         	<tr><td width="100%" class="cellhead" colspan="2">4. {lang_head_comicreport}</td></tr>
         	
         		<form class="thin" action="comicreport.php" method="post" target="_blank">
	         	
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option_1}</td><td width="60%" class="cell">
	         	<SELECT name="list_option1" class="formselect">
	         	<option selected>title</option>
	         	<option>story</option>	       
	         	<option>volume</option>
	         	<option>issue</option>
	         	<option>publisher</option>
	         	<option>price</option>
	         	<option>value</option>
	         	<option>type</option>
	         	<option>genre</option>
	         	<option>none</option>
	         	</select>
	         	</td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option_2}</td><td width="60%" class="cell">
	         	<SELECT name="list_option2" class="formselect">
	         	<option>title</option>
	         	<option selected>story</option>	       
	         	<option>volume</option>
	         	<option>issue</option>
	         	<option>publisher</option>
	         	<option>price</option>
	         	<option>value</option>
	         	<option>type</option>
	         	<option>genre</option>
	         	<option>none</option>
	         	</select>
	         	</td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option_3}</td><td width="60%" class="cell">
	         	<SELECT name="list_option3" class="formselect">
	         	<option>title</option>
	         	<option>story</option>	       
	         	<option selected>volume</option>
	         	<option>issue</option>
	         	<option>publisher</option>
	         	<option>price</option>
	         	<option>value</option>
	         	<option>type</option>
	         	<option>genre</option>
	         	<option>none</option>
	         	</select>
	         	</td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option_4}</td><td width="60%" class="cell">
	         	<SELECT name="list_option4" class="formselect">
	         	<option>title</option>
	         	<option>story</option>	       
	         	<option>volume</option>
	         	<option selected>issue</option>
	         	<option>publisher</option>
	         	<option>price</option>
	         	<option>value</option>
	         	<option>type</option>
	         	<option>genre</option>
	         	<option>none</option>
	         	</select>
	         	</td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option_5}</td><td width="60%" class="cell">
	         	<SELECT name="list_option5" class="formselect">
	         	<option>title</option>
	         	<option>story</option>	       
	         	<option>volume</option>
	         	<option>issue</option>
	         	<option selected>publisher</option>
	         	<option>price</option>
	         	<option>value</option>
	         	<option>type</option>
	         	<option>genre</option>
	         	<option>none</option>
	         	</select>
	         	</td></tr>
	         	<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_ok}" class="formbutton">&nbsp;&nbsp;<INPUT type="reset" name="Reset" value="{lang_button_reset}" class="formbutton"></td></tr>
	         	
	         	</form>

			</table>

		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>