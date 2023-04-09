<form class="thin" method="post" action="function.php?cmd=adminsystem">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_system}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">
                <tr><td width="100%" class="cellhead" colspan="2">1. {lang_sql_option}</td></tr>

				<tr><td width="50%" class="cell">{lang_sql_host}</td>
		        <td width="50%" class="cell"><input type="text" name="admin_host" class="formfield" value="{host}"></td></tr>
		        <tr><td width="50%" class="cell">{lang_sql_user}</td>
		        <td width="50%" class="cell"><input type="text" name="admin_user" class="formfield" value="{username}"></td></tr>
		        <tr><td width="50%" class="cell">{lang_sql_pass}</td>
		        <td width="50%" class="cell"><input type="password" name="admin_pass" class="formfield" value="{password}"></td></tr>
		        <tr><td width="50%" class="cell">{lang_sql_data}</td>
		        <td width="50%" class="cell"><input type="text" name="admin_data" class="formfield" value="{database}"></td></tr>

                <tr><td width="100%" class="cellhead" colspan="2">2. {lang_sys_option}</td></tr>

                <tr><td width="50%" class="cell">{lang_sys_title}</td>
                <td width="50%" class="cell"><input type="text" name="admin_sitetitle" class="formfield" value="{sitetitle}"></td></tr>
                
                <tr><td width="50%" class="cell">{lang_sys_site}</td>
                <td width="50%" class="cell"><input type="text" name="admin_siteurl" class="formfield" value="{siteurl}"></td></tr>

                <tr><td width="50%" class="cell">{lang_sys_theme}</td>
		        <td width="50%" class="cell">

		        <SELECT name="admin_theme" class="formselect">
		        <!-- START BLOCK : admin_theme -->

		  	    <option{selected}>{pmc_name}</option>

		  	    <!-- END BLOCK : admin_theme -->
		        </select>

		        </td></tr><tr><td width="50%" class="cell">{lang_sys_lang}</td>
                <td width="50%" class="cell">

                <select name="admin_language" class="formselect">
                <!-- START BLOCK : admin_lang -->

                <option{selected}>{pmc_name}</option>

                <!-- END BLOCK : admin_lang -->
                </select>

                </td></tr><tr><td width="50%" class="cell">{lang_sys_paginate}</td>
                <td width="50%" class="cell"><input type="text" name="admin_paginate" class="formfield" value="{paginate}"></td></tr>
                
                <tr><td width="50%" class="cell">{lang_sys_pdf}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_pdf" value="Yes" {pdfyes}> {lang_yes}
                <input type="radio" name="admin_pdf" value="No" {pdfno}> {lang_no}

		        </td></tr>
		        <tr><td width="50%" class="cell">{lang_sys_print}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_print" value="Yes" {printyes}> {lang_yes}
                <input type="radio" name="admin_print" value="No" {printno}> {lang_no}

		        </td></tr><tr><td width="50%" class="cell">{lang_sys_loan}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_loan" value="Yes" {loanyes}> {lang_yes}
                <input type="radio" name="admin_loan" value="No" {loanno}> {lang_no}

		        </td></tr><tr><td width="50%" class="cell">{lang_sys_rss}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_rss" value="Yes" {rssyes}> {lang_yes}
                <input type="radio" name="admin_rss" value="No" {rssno}> {lang_no}

		        </td></tr><tr><td width="50%" class="cell">{lang_sys_fav}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_fav" value="Yes" {favyes}> {lang_yes}
                <input type="radio" name="admin_fav" value="No" {favno}> {lang_no}

		        </td></tr>


<tr><td width="100%" class="cellhead" colspan="2">3. {lang_img_option}</td></tr>

      <tr><td width="50%" class="cell">{lang_img_width}</td>
                <td width="50%" class="cell"><input type="text" name="admin_width" class="formfield" value="{maxwidth}"></td></tr>
                <tr><td width="50%" class="cell">{lang_img_height}</td>
                <td width="50%" class="cell"><input type="text" name="admin_height" class="formfield" value="{maxheight}"></td></tr>
                <tr><td width="50%" class="cell">{lang_img_size}</td>
                <td width="50%" class="cell"><input type="text" name="admin_size" class="formfield" value="{maxsize}"></td></tr>


<tr><td width="100%" class="cellhead" colspan="2">4. {lang_date_option}</td></tr>

                <tr><td width="50%" class="cell">{lang_date_format}</td>
		        <td width="50%" class="cell"><input type="text" name="admin_time" class="formfield" value="{dateoption}">&nbsp;&nbsp;{lang_date_alt}</td></tr>
		        <tr><td width="50%" class="cell">{lang_option}</td>
		        <td width="50%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_change}" class="formbutton"></td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>