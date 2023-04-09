<form method="post" action="function.php?cmd=delmore" name="formList" id="5">

<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_comiclist}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">

			<table cellpadding="1" cellspacing="1" class="inline">
				<tr>
					<td width="5%" class="cellhead" align="center"></td>
	            	<td width="25%" class="cellhead" align="left">{lang_list_name}</td>
	            	<td width="30%" class="cellhead" align="left">{lang_list_story}</td>
	            	<td width="5%" class="cellhead" align="center">{lang_list_issue}</td>
	            	<td width="5%" class="cellhead" align="center">{lang_list_volume}</td>
	            	<td width="15%" class="cellhead" align="left">{lang_list_type}</td>
	            	<td width="15%" class="cellhead" align="left">{lang_list_variation}</td>
	            </tr>

	            <!-- START BLOCK : comic_list -->

	            <tr>
	            	<td width="5%" class="cell" align="center"><input type="checkbox" name="list_delete[]" value="{pmc_uid}"></td>
	            	<td width="25%" class="cell"><a href="comic.php/{pmc_uid}" class="listlink">{pmc_name}</a></td>
	            	<td width="30%" class="cell">{pmc_story}</td>
	            	<td width="5%" class="cell" align="center">{pmc_issue}{pmc_issueltr}</td>
	            	<td width="5%" class="cell" align="center">{pmc_volume}</td>
	            	<td width="15%" class="cell" align="left">{pmc_type}</td>
	            	<td width="15%" class="cell" align="left">{pmc_variation}</td>
	            </tr>
	
	            <!-- END BLOCK : comic_list -->
	            
	            <tr><td width="100%" colspan="7" class="cell" valign="middle"><input name="btn" type="button" onclick="CheckAll()" value="{lang_button_checkall}" class="formButton"> <input name="btn" type="button" onclick="UncheckAll()" value="{lang_button_checknone}" class="formButton">	            
	            <input type="button" name="delmore" value="{lang_button_delete}" class="formButton" Onclick="confirm_delete(5);">	
	            <input type="button" name="export" value="{lang_button_export}" class="formButton" Onclick="document.formList.action='exportall.php'; document.formList.submit()">            
	            </td></tr>

			</table>

		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>

<center>
<font class="page">{prev_page} {all_page} {next_page}</font><br />
</center>

</form>