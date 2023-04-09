<form class="thin" method="post" action="function.php?cmd=adminindex">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_index}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">
                <tr><td width="100%" class="cellhead" colspan="2">1. {lang_index_head}</td></tr>

				<tr><td width="50%" class="cell">{lang_index_stats}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_enable" value="Yes" {enableyes}> {lang_yes}
                <input type="radio" name="admin_enable" value="No" {enableno}> {lang_no}

		        </td></tr><tr><td width="50%" class="cell">{lang_index_statstype}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_stats" value="Short" {stat_short}> {lang_stats_short}
                <input type="radio" name="admin_stats" value="Full" {stat_full}> {lang_stats_full}

		        </td></tr><tr><td width="50%" class="cell">{lang_index_list}</td>
		        <td width="50%" class="cell">

                <input type="radio" name="admin_fav" value="Latest" {list_latest}> {lang_list_latest}
                <input type="radio" name="admin_fav" value="Favorite" {list_fav}> {lang_list_favs}

		        </td></tr><tr><td width="50%" class="cell">{lang_index_number}</td>
                <td width="50%" class="cell"><input type="text" name="admin_numlines" class="formfield" value="{rownumber}"></td></tr>
                <tr><td width="50%" class="cell">{lang_option}</td>
		        <td width="50%" class="cell"><INPUT type="submit" name="Submit" value="{lang_button_change}" class="formbutton"></td></tr>
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

</form>