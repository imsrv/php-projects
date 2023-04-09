<?
if (!$HTTP_GET_VARS['edit'])
{
?>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
<tr>
	<td align="center"><font face="helvetica"><b>Submit Your Joke</b></font></td>
</tr>
</table>
<?
}

if ($HTTP_GET_VARS['edit'])
{
	$select_joke_SQL = "select * from $bx_db_table_jokes where joke_id='".$HTTP_GET_VARS['joke_id']."'";
	$select_joke_query = bx_db_query($select_joke_SQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));	
	$select_joke_result = bx_db_fetch_array($select_joke_query);
}
?>
<form method="post" action="<?=basename($HTTP_SERVER_VARS['PHP_SELF'])?>?joke_id=<?=$HTTP_GET_VARS['joke_id']?>&from=<?=isset($from1) ? $from1 : '0'?>&display_nr=<?=$HTTP_GET_VARS['display_nr']?>&order_by=<?=$HTTP_GET_VARS['order_by']?>&order_type=<?=$HTTP_GET_VARS['order_type']?>&search=<?=$search?>" name="form1">
<input type="hidden" name="joke_form" value="1">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="90%">
<tr>
	<td bgcolor="#CC66FF">
		<table border="0" cellpadding="4" cellspacing="0" align="center" bgcolor="#FFFFef" width="100%">
	
<?
if ($name_error=="yes" || $email_error=="yes" || $joke_text_error=="yes")
{
?>
		<tr>
			<td align="center" class="text" colspan="2"><font color="red"><b>You have error</b></font></td>
		</tr>
<?	 
}
if (!isset($HTTP_POST_VARS['name']) && !$select_joke_result['name'])
{
?>
		<tr>
			<td colspan="2">
				&nbsp;&nbsp;<input type="checkbox" name="remember_values" value="1" class="radio" <?if(isset($HTTP_COOKIE_VARS['remember_values'])){echo "checked";}?>><B><SMALL> Remember name and email address</SMALL></B>
			</td>
		</tr>
<?}?>
		<tr valign="top">
			<td class="lila_bold_text" align="right" width="30%"><b>&nbsp;&nbsp;Your Name:</b>&nbsp;&nbsp;</td>
			<td width="70%"><INPUT type="text" name="name" size="30" value="<?
if (isset($HTTP_POST_VARS['name']))
	echo $HTTP_POST_VARS['name'];
elseif($select_joke_result['name'])
	echo $select_joke_result['name'];
else
	echo $HTTP_COOKIE_VARS['name_joke'];
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
			<td class="lila_bold_text" align="right"><b>&nbsp;&nbsp;Your Email:</b>&nbsp;&nbsp;</td>
			<td><INPUT type="text" name="email" size="30" value="<?
if (isset($HTTP_POST_VARS['email']))
	echo $HTTP_POST_VARS['email'];
elseif($select_joke_result['email'])
	echo $select_joke_result['email'];
else
	echo $HTTP_COOKIE_VARS['email_joke'];
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
				<b>Joke Category:</b>&nbsp;&nbsp;
			</td>
			<td>
				<select  name="category_id" class="input" >
					<option selected VALUE="0">Select a category&nbsp;</option>
<?
	$sel_cat=bx_db_query("select * from $bx_db_table_joke_categories order by category_name".$slng);
	while($res=bx_db_fetch_array($sel_cat))
	{
?>
		<option value="<?echo $res['category_id'];?>" <?if($HTTP_POST_VARS['category_id']==$res['category_id'] || $res['category_id'] == $select_joke_result['category_id']){echo "selected";}?>><?echo $res['category_name'.$slng];?>
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

if($use_censor == "yes")
{
?>
		<tr valign="top">
			<td class="lila_bold_text" align="right">
				<b>Joke Censor Type:</b>&nbsp;&nbsp;
			</td>
			<td>
				<select  name="censor_category_id" class="input" >
					<option selected VALUE="0">Select a category&nbsp;</option>
<?
	$sel_cat=bx_db_query("select * from $bx_db_table_censor_categories order by censor_category_name".$slng);
	while($res=bx_db_fetch_array($sel_cat))
	{
?>
		<option value="<?echo $res['censor_category_id'];?>" <?if($HTTP_POST_VARS['censor_category_id']==$res['censor_category_id'] || $res['censor_category_id'] == $select_joke_result['censor_type']){echo "selected";}?>><?echo $res['censor_category_name'.$slng];?>
<?
	}
?>
				</select>
			</td>
		</tr>
<?
}

if ($censor_category_error=="yes")
{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">You must select a censor category type</font></td>
		</tr>
<?
}
if (MULTILANGUAGE_SUPPORT == "on") 
{
?>
		<tr valign="top">
			<td class="lila_bold_text" align="right">
				<b>Joke Language:</b>&nbsp;&nbsp;
			</td>
			<td>
				<select  name="joke_lang" class="input" >
					<option selected VALUE="0">Select language&nbsp;</option>
<?
	$dirs = getFiles(DIR_FLAG);
   for ($i=0; $i<count($dirs); $i++) 
   {
	   $lngname = split("\.",$dirs[$i]);
?>
		<option value="<?="_".substr($lngname[0], 0,3)?>" <?
	if(("_".substr($lngname[0], 0,3)==$select_joke_result['slng']) || $HTTP_POST_VARS['joke_lang']=="_".substr($lngname[0], 0,3)) {echo "selected";}?>><?=$lngname[0];?></option>
<?
	}
?>
				</select>
			</td>
		</tr>
<?
	if ($joke_lang_error=="yes")
	{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">You must select a language</font></td>
		</tr>
<?
	}
}
?>	
		<tr valign="top">
			<td class="lila_bold_text" align="right"><b>Enter Joke Title:</b>&nbsp;</td>
			<td>
				<INPUT type="text" name="joke_title" size="20" value="<?=stripslashes( isset($HTTP_POST_VARS['joke_title']) ? $HTTP_POST_VARS['joke_title'] : $select_joke_result['joke_title']);?>" class="input">
			</td>
		</tr>
<?
if ($joke_title_error=="yes") 
{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">You must type joke title</font></td>
		</tr>
<?
}
?>
	   <tr valign="top">
			<td class="lila_bold_text" align="right"><b>Enter Joke:</b>&nbsp;</td>
			<td><TEXTAREA cols="33" id=txt_area1 name="joke_text" rows="8" class="input"><?=stripslashes( (isset($HTTP_POST_VARS['joke_text']) ? $HTTP_POST_VARS['joke_text'] : $select_joke_result['joke_text']));?></TEXTAREA></td>
	   </tr>
<?
if ($joke_text_error=="yes") 
{
?>
		<tr>
			<td>&nbsp;</td>
			<td align="left" class="smalltext"><font color="red">Joke cannot be empty</font></td>
		</tr>
<?		  
}
?>
	   <tr>
			<td align="center" colspan="2"><br><input type="submit" name="submit" value="<?
			switch($HTTP_GET_VARS['edit'])
			{
				case "edit_delete": echo "Update"; break;
				case "1": echo "Validate"; break;
				default : echo "Submit Joke"; break;
				}
			?>" class="button"></td>
		</tr>
			<td colspan="2"><font face="Verdana" size="1">Note: Joke will be added without reviewing !</font></td>
		</tr>
		</table>
	</td>
</tr>
</table>

</form>
