<table class="window" cellspacing="0" cellpadding="0">
	<tr><td class="topbar" align="left"><img src="{imgfolder}/bar_left.jpg"></td><td class="topbarhead" nowrap="nowrap">{lang_head_images}</td><td class="topbar" align="right"><img src="{imgfolder}/bar_right.jpg"></td></tr><tr>
		<td class="windowborder" colspan="3">
		
			<table cellpadding="1" cellspacing="1" class="inline">
				<tr>
		        <td width="50%" class="cellhead">{lang_image_name}</td>
		        <td width="15%" class="cellhead">{lang_image_image}</td>
		        <td width="15%" class="cellhead">{lang_image_file}</td>
		        <td width="20%" class="cellhead">{lang_image_option}</td></tr>
		
		        <!-- START BLOCK : file_list -->
		
		        <tr>
		        <td width="50%" class="cell"><a href=javascript:void(window.open('coverview.php?image=image/{file_name}','end','location=no,history=no,width={comic_width},height={comic_height},menubar=no,resizable=no,status=no,toolbar=no')) class="listlink">{file_name}</a></td>
		        <td width="15%" class="cell">{file_size}</td>
		        <td width="15%" class="cell">{file_file}</td>
		        <td width="20%" class="cell">{options}</td></tr>
		
		        <!-- END BLOCK : file_list -->
			</table>
			
		</td>
	</tr><tr><td class="bottombar" align="left"><img src="{imgfolder}/bottom_left.jpg"></td><td class="bottombar"></td><td class="bottombar" align="right"><img src="{imgfolder}/bottom_right.jpg"></td></tr>
</table>