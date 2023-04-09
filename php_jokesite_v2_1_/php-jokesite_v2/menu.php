<?include(DIR_LNG.'menu.php');?>
<table border="0" cellpadding="<?=MENU_CELLPADDING?>" cellspacing="1" width="100%" align="center">
<tr>
	<td width="7%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_HOME?></a><a href="" style="font-family:Verdana, Arial; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:#CC00FF;font-weight:bold"></a></td>
	
	<td width="7%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>jokes_category.php" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_JOKES?></a></td>

	<td width="10%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>top_ten_jokes.php?jtype=ten" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_TOP_10_JOKES?></a></td>
	
	<td width="13%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>top_random_jokes.php?jtype=random" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_RANDOM_JOKES?></a></td>
	
	<td width="13%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>top_emailed_jokes.php?jtype=emailed" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_TOP_EMAILED_JOKES?></a></td>
	
	<td width="8%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>new_jokes.php?jtype=new" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_NEW_JOKES?></a></td>

	<td width="11%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>pictures_category.php" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_FUNNY_PICTURES?></a></td>
	
	<td width="11%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>submit_joke.php" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_SUBMIT_JOKE?></a></td>
	
	<td width="11%" bgcolor="<?=MENU_BGCOLOR?>" align="center" onMouseover="this.bgColor='<?=MOUSE_OVER_COLOR?>'"  onMouseout="this.bgColor='<?=MENU_BGCOLOR?>'"><a href="<?=HTTP_SERVER?>submit_picture.php" style="font-family:<?=MENU_FONT_FACE?>; font-size:<?=MENU_FONT_SIZE?>px; text-decoration:none;color:<?=MENU_FONT_COLOR?>;font-weight:bold"><?=TEXT_SUBMIT_PICTURE?></a></td>
</tr>
</table>
