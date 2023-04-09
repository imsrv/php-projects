<?
if (!$HTTP_GET_VARS['edit'])
{
?>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
<tr>
	<td align="center"><font face="helvetica"><b>Submit Your Picture</b></font></td>
</tr>
</table>
<?
}

if ($HTTP_GET_VARS['edit'])
{
$select_picture_SQL = "select * from $database_table_name where img_id='".$HTTP_GET_VARS['img_id']."'";
$select_picture_query = bx_db_query($select_picture_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));	
$select_picture_result = bx_db_fetch_array($select_picture_query);

}
?>
<form method="post" enctype="multipart/form-data"  action="<?=basename($HTTP_SERVER_VARS['PHP_SELF'])?>?<?=$primary_id_name?>=<?=$HTTP_GET_VARS[$primary_id_name]?>&from=<?=isset($from1) ? $from1 : '0'?>&display_nr=<?=$HTTP_GET_VARS['display_nr']?>&order_by=<?=$HTTP_GET_VARS['order_by']?>&order_type=<?=$HTTP_GET_VARS['order_type']?>" name="form1">
<input type="hidden" name="img_form" value="1">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="90%">
<tr>
	<td bgcolor="#CC66FF">
		<table border="0" cellpadding="4" cellspacing="0" align="center" bgcolor="#FFFFef" width="100%">
	
<?

if ($name_error=="yes" || $email_error=="yes" || $category_error=="yes" || $img_error =="yes")
{
?>
		<tr>
			<td align="center" class="text" colspan="2"><font color="red"><b>You have error</b></font></td>
		</tr>
<?	 
}
if (!isset($HTTP_POST_VARS['name']) && !$select_picture_result['name'])
{
?>
		<tr>
			<td colspan="2">
				&nbsp;&nbsp;<input type="checkbox" name="remember_values_img" value="1" class="radio" <?if(isset($HTTP_COOKIE_VARS['remember_values_img'])){echo "checked";}?>><B><SMALL> Remember name and email address</SMALL></B>
			</td>
		</tr>
<?}?>
		<tr valign="top">
			<td class="lila_bold_text" align="right" width="30%"><b>&nbsp;&nbsp; Name:</b>&nbsp;&nbsp;</td>
			<td width="66%"><INPUT type="text" name="name" size="30" value="<?
if (isset($HTTP_POST_VARS['name'])) 
	echo $HTTP_POST_VARS['name'];
elseif($select_picture_result['name'])
	echo $select_picture_result['name'];
else
	echo $HTTP_COOKIE_VARS['name_img'];
			?>" class="input"></td>
		</tr>
<?

if ($name_error=="yes")
{
?>
		<tr valign="top">
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">Name cannot be empty</font>
			</td>
		</tr>
<?		  
}
?>
		<tr valign="top">
			<td class="lila_bold_text" align="right"><b>&nbsp;&nbsp; Email:</b>&nbsp;&nbsp;</td>
			<td><INPUT type="text" name="email" size="30" value="<?
if (isset($HTTP_POST_VARS['email'])) 
	echo $HTTP_POST_VARS['email'];
elseif($select_picture_result['email'])
	echo $select_picture_result['email'];
else
	echo $HTTP_COOKIE_VARS['email_img'];
			?>" class="input">
			</td>
		</tr>
<?
if ($email_error=="yes") 
{
?>
		<tr valign="top">
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">Email cannot be empty and must be a valid email address</font>
			</td>
		</tr>
<?		  
}
?>
		<tr valign="top">
			<td class="lila_bold_text" align="right">
				<b>Picture Category:</b>&nbsp;&nbsp;
			</td>
			<td>
				<select  name="category_type" class="input" >
					<option selected VALUE="0">Select a category&nbsp;</option>
<?
	$sel_cat=bx_db_query("select * from $bx_db_table_image_categories order by category_name".$slng);
	while($res=bx_db_fetch_array($sel_cat))
	{
?>
		<option value="<?echo $res['category_id'];?>" <?if( $HTTP_POST_VARS['category_type']==$res['category_id'] || $res['category_id'] == $select_picture_result['category_id']){echo "selected";}?>><?echo $res['category_name'.$slng];?>
<?
	}
?>
				</select>
			</td>
		</tr>
<?
if ($category_error=="yes")
{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">You must select a category type</font></td>
		</tr>
<?
}
if (MULTILANGUAGE_SUPPORT == "on") 
{
?>
		<tr valign="top">
			<td class="lila_bold_text" align="right">
				<b>Comment Language:</b>&nbsp;&nbsp;
			</td>
			<td>
				<select  name="img_lang" class="input" >
					<option selected VALUE="0">Select language&nbsp;</option>
<?
	$dirs = getFiles(DIR_FLAG);
   for ($i=0; $i<count($dirs); $i++) 
   {
	   $lngname = split("\.",$dirs[$i]);
?>
		<option value="<?="_".substr($lngname[0], 0,3)?>" <?
	if(("_".substr($lngname[0], 0,3)==$select_picture_result['slng']) || $HTTP_POST_VARS['img_lang']=="_".substr($lngname[0], 0,3)) {echo "selected";}?>><?=$lngname[0];?></option>
<?
	}
?>
				</select> (need only for comments)
			</td>
		</tr>
<?
	if ($img_lang_error=="yes")
	{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">You must select a language or delete the comment</font></td>
		</tr>
<?
	}
}
?>	
		<tr>
			<td colspan="2" align="center">
				<br>
<?
if ($HTTP_GET_VARS['edit'])
{
?>
				<img src="<?=HTTP_INCOMING.$select_picture_result['big_img_name']?>" alt=""><br>
<?
}
?>			</td>	
		</tr>
		<tr>
			<td align="right">
				<b>
<?
if (!$HTTP_GET_VARS['edit'])
	echo "Add ";
else
	echo "Change ";
?>
big image:</b> 
			</td>
			<td>
			<input type="file" name="big_img" class="button">
				
			</td>
		</tr>
<?
if ($img_error=="yes")
{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">Picture cannot be empty and<br>
			cannot be bigger than <? echo $big_photo_width." x ".$big_photo_height;?> and it's site cannot be bigger than <?=$big_photo_size?> bytes</font></td>
		</tr>
<?
}
if ($imagemagic != "yes")
{
?>
		<tr>
			<td colspan="2" align="center">
			<br>
<?
	if ($HTTP_GET_VARS['edit'])
	{
?>
				<img src="<?=HTTP_INCOMING.$select_picture_result['little_img_name']?>" alt=""><br>
<?
	}
?>				
			</td>
		</tr>
		<tr>
			<td align="right">
				<b>
<?
	if (!$HTTP_GET_VARS['edit'])
		echo "Add ";
	else
		echo "Change ";
?>
little image:</b>
			</td>
			<td>
				<input type="file" name="little_img" class="button">
			</td>
		</tr>
		
<?
	if ($img_error=="yes")
	{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">Picture cannot be empty and<br>
			cannot be bigger than <? echo $little_photo_width." x ".$little_photo_height;?> and it's site cannot be bigger than <?=$little_photo_size?> bytes</font></td>
		</tr>
<?
	}
}
else
{?>
		<tr>
			<td colspan="2" align="center">
			<br>
			<img src="<?=HTTP_INCOMING.$select_picture_result['little_img_name']?>" alt=""><br>
			</td>
		</tr>
<?}
?>
		<tr valign="top">
			<td class="lila_bold_text" align="right"><b>Comment:</b>&nbsp;</td>
			<td><TEXTAREA cols="44" id=txt_area1 name="comment" rows="8" class="input"><?echo stripslashes((isset($select_picture_result['comment']) ? $select_picture_result['comment'] : $HTTP_POST_VARS['comment']));?></TEXTAREA></td>
	   </tr>
	   <tr>
			<td align="center" colspan="2"><br><input type="submit" name="submit" value="<?
			switch($HTTP_GET_VARS['edit'])
			{
				case "edit_delete": echo "Update"; break;
				case "1": echo "Validate"; break;
				default : echo "Submit Picture"; break;
				}
			?>" class="button"></td>
		</tr>
			<td colspan="2"><font face="Verdana" size="1">Note: Picture will be added without reviewing !</font></td>
		</tr>
		</table>
	</td>
</tr>
</table>

</form>
