<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_search}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">

            <tr><td width="100%" class="cellhead" colspan="2">1. {lang_head_keyword}</td></tr>

		        <form class="thin" method="post" action="result.php?search=simple">
            	<tr><td width="40%" valign="middle" class="cell">{lang_search_string}</td><td width="60%" class="cell"><input type="text" name="search_string" class="formfield"></td></tr>
            	<tr><td width="40%" valign="middle" class="cell">{lang_search_exact}</td><td width="60%" class="cell"><input type="checkbox" name="search_check" value="1"> {lang_search_exact_nfo}</td></tr>
            	<tr><td width="40%" valign="middle" class="cell">{lang_search_list}</td><td width="60%" class="cell">
            	
            	<input type="radio" name="search_list" value="name" CHECKED>{lang_search_title}
				<input type="radio" name="search_list" value="type">{lang_search_type}
            	
            	</td></tr>
            	<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_search}" class="formbutton">&nbsp;&nbsp;<INPUT type="reset" name="Reset" value="{lang_button_reset}" class="formbutton"></td></tr>
		        </form>

			<tr><td width="100%" class="cellhead" colspan="2">2. {lang_head_story}</td></tr>
			
				<form class="thin" method="post" action="result.php?search=story">
            	<tr><td width="40%" valign="middle" class="cell">{lang_search_string}</td><td width="60%" class="cell"><input type="text" name="search_string" class="formfield"></td></tr>            	
            	<tr><td width="40%" valign="middle" class="cell">{lang_option}</td><td width="60%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_search}" class="formbutton">&nbsp;&nbsp;<INPUT type="reset" name="Reset" value="{lang_button_reset}" class="formbutton"></td></tr>
		        </form>
		        
			</table>

		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>