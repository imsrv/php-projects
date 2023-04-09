<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_custom}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr><td width="5%" class="cellhead" align="center"></td>
		        <td width="30%" class="cellhead" align="left">{lang_list_title}</td>
		        <td width="35%" class="cellhead" align="left">{lang_list_story}</td>
		        <td width="5%" class="cellhead" align="center">{lang_list_issue}</td>
		        <td width="5%" class="cellhead" align="center">{lang_list_volume}</td>
		        <td width="20%" class="cellhead" align="left">{lang_list_added}</td></tr>
		
		        <!-- START BLOCK : comic_latest -->
		
		        <tr><td width="5%" class="cell" align="center"><img src="{imgfolder}/icon_browse.gif"></td>
		        <td width="30%" class="cell"><a href="comic.php/{pmc_uid}" class="listlink">{pmc_name}</a></td>
		        <td width="35%" class="cell" align="left">{pmc_story}</td>
		        <td width="4%" class="cell" align="center">{pmc_issue}{pmc_issueltr}</td>
		        <td width="5%" class="cell" align="center">{pmc_volume}</td>
		        <td width="20%" class="cell">{pmc_date}</td></tr>
		
		        <!-- END BLOCK : comic_latest -->
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<!-- INCLUDE BLOCK : stats -->