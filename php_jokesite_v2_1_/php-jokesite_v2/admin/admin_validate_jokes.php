<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");


$database_table_name = $bx_db_table_jokes;
$this_file_name = HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF']);
$page_title = "Validate New Jokes";
$primary_id_name = "joke_id";
$primary_id = &$HTTP_GET_VARS[$primary_id_name];			

$condition = " where validate!='1'";

$get_vars = $HTTP_POST_VARS['display_nr'] ? "display_nr=".$display_nr=$HTTP_POST_VARS['display_nr'] : ($HTTP_GET_VARS['display_nr'] ? "display_nr=".$display_nr=$HTTP_GET_VARS['display_nr'] : "display_nr=".$display_nr);

if ($HTTP_POST_VARS['submit'])
{
	if ($HTTP_POST_VARS['name']=="") 
		$name_error="yes";        
	else 
		$name_error="no";

	$email_error="no";
	if ($HTTP_POST_VARS['joke_text']=="") 
		$joke_text_error="yes";        
	else 
		$joke_text_error="no";
	if ($HTTP_POST_VARS['category_id'] == '0' )
		$category_error = "yes";
	else
		$category_error = "no";
	if ($HTTP_POST_VARS['censor_category_id'] == '0' && $use_censor !="yes")
		$censor_category_error = "yes";
	else
		$censor_category_error = "no";
	if ($HTTP_POST_VARS['joke_title']=="") 
		$joke_title_error="yes";        
	else 
		$joke_title_error="no";
	if ($HTTP_POST_VARS['joke_lang']=="0"  && MULTILANGUAGE_SUPPORT=="on") 
		$joke_lang_error="yes";        
	else 
		$joke_lang_error="no";


	if ($name_error=="no" && $email_error=="no" && $category_error=="no" && $joke_title_error == "no"  && $joke_text_error=="no" && $censor_category_error=="no" && $joke_lang_error=="no")
	{

		if (strlen($HTTP_POST_VARS['joke_text'])<=$mini_jokes_length)
				$joke_type="mini";
			elseif(strlen($HTTP_POST_VARS['joke_text'])>=$mini_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$short_jokes_length)
				$joke_type="short";
			elseif(strlen($HTTP_POST_VARS['joke_text'])>=$short_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$medium_jokes_length)
				$joke_type="medium";
			elseif(strlen($HTTP_POST_VARS['joke_text'])>=$medium_jokes_length)
				$joke_type="long";
			else{}
		$update_SQL = "update $database_table_name set category_id='".$HTTP_POST_VARS['category_id']."', name='".$HTTP_POST_VARS['name']."', email='".$HTTP_POST_VARS['email']."', joke_text='".$HTTP_POST_VARS['joke_text']."',  joke_type='".$joke_type."'".($use_censor=="yes" ? ",censor_type='".$HTTP_POST_VARS['censor_category_id']."'" : "").", validate='1', joke_title='".$HTTP_POST_VARS['joke_title']."' where $primary_id_name='".$HTTP_GET_VARS[$primary_id_name]."'";
		$update_joke = bx_db_query($update_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

		$selectSQL = "select * from $database_table_name where ".$primary_id_name."='".$HTTP_GET_VARS[$primary_id_name]."'";
		$select_query = bx_db_query($selectSQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$select_result = bx_db_fetch_array($select_query);
		/*
		confirm joke
		*/
		if (MULTILANGUAGE_SUPPORT == "on") 
		{
		   $dirs = getFiles(DIR_FLAG);
		   for ($i=0; $i<count($dirs); $i++) 
		   {
			   $lngname = split("\.",$dirs[$i]);
			   if($select_result['slng'] == "_".substr($lngname[0], 0,3))
			   {
				   $use_language = $lngname[0];
				   break;
			   }
		   }
		}
		
		if($use_language =='')
			$use_language = DEFAULT_LANGUAGE;

		$mailfile = $use_language."/mail/confirm_joke_validation.txt";
		include(DIR_LANGUAGES.$mailfile.".cfg.php");
		if($html_mail=="on")
		$mailfile .= ".html";
		$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

		$HTTP_POST_VARS['joke_title'] = $select_result['joke_title'];
		$HTTP_POST_VARS['joke_text'] = $select_result['joke_text'];
		$HTTP_POST_VARS['name'] = $select_result['name'];
		$HTTP_POST_VARS['site_name'] = $site_name;

		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		while (list($h, $v) = each($fields))
		{
			$mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
			$file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
		}

		if($html_mail=="on")
		{
			if ($add_html_header == "on") {
				$mail_message = fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html")).$mail_message;
			} 
			if ($add_html_footer == "on") {
				$mail_message .= fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html"));
			} 
			$html_mail="yes";
		}
		else
		{
			if ($add_mail_signature == "on")
				$mail_message .= "\n".SITE_SIGNATURE;
			$html_mail="no";
		}

		if (empty($select_result['email'])  || (!eregi("(@)(.*)",$select_result['email'],$regs)) || (!eregi("([.])(.*)",$select_result['email'],$regs)) || (verify($select_result['email'],"string_int_email")==1))
			;
		else
			bx_mail($site_name,$site_mail,$select_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
		//echo stripslashes($mail_message);

	}
	else
		$HTTP_GET_VARS['edit'] = "edit_delete";
}


if ($HTTP_POST_VARS['delete_button'] == "Delete Checked" || $HTTP_GET_VARS['delete_this'])								//delete via ID
{
	for( $i = 0 ; $i < sizeof($$primary_id_name); $i++ )
	{
		if (${cycle_id.$i} == "on")
		{
			$delete_SQL = "delete from $database_table_name where $primary_id_name='".${$primary_id_name}[$i]."'";
			$delete_query = bx_db_query($delete_SQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}
	if ($HTTP_GET_VARS['delete_this'])
	{
		$delete_SQL = "delete from $database_table_name where $primary_id_name='".$primary_id."'";
		$delete_query = bx_db_query($delete_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}
}
elseif ($HTTP_POST_VARS['validate_button'] || $HTTP_GET_VARS['validate_this'] )	//update via ID
{
	if (!$HTTP_GET_VARS['validate_this'])
	{
		for( $i = 0 ; $i < sizeof($$primary_id_name) ; $i++ )
		{
			$selectSQL = "select * from $database_table_name where ".$primary_id_name."='".${$primary_id_name}[$i]."'";
			$select_query = bx_db_query($selectSQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			$select_result = bx_db_fetch_array($select_query);
			
//			mail($select_result['email'], "Confirmation", JOKE_CONFIRMED_MESSAGE,"From: ".$site_mail);
			/*
			confirm joke
			*/
			if (MULTILANGUAGE_SUPPORT == "on") 
			{
			   $dirs = getFiles(DIR_FLAG);
			   for ($i=0; $i<count($dirs); $i++) 
			   {
				   $lngname = split("\.",$dirs[$i]);
				   if($select_result['slng'] == "_".substr($lngname[0], 0,3))
				   {
					   $use_language = $lngname[0];
					   break;
				   }
			   }
			}
			
			if($use_language =='')
				$use_language = DEFAULT_LANGUAGE;

			$mailfile = $use_language."/mail/confirm_joke_validation.txt";
			include(DIR_LANGUAGES.$mailfile.".cfg.php");
			if($html_mail=="on")
			$mailfile .= ".html";
			$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

			$HTTP_POST_VARS['joke_title'] = $select_result['joke_title'];
			$HTTP_POST_VARS['joke_text'] = $select_result['joke_text'];
			$HTTP_POST_VARS['name'] = $select_result['name'];
			$HTTP_POST_VARS['site_name'] = $site_name;

			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			while (list($h, $v) = each($fields))
			{
				$mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
				$file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
			}

			if($html_mail=="on")
			{
				if ($add_html_header == "on") {
					$mail_message = fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html")).$mail_message;
				} 
				if ($add_html_footer == "on") {
					$mail_message .= fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html"));
				} 
				$html_mail="yes";
			}
			else
			{
				if ($add_mail_signature == "on")
					$mail_message .= "\n".SITE_SIGNATURE;
				$html_mail="no";
			}
			
			if (empty($select_result['email'])  || (!eregi("(@)(.*)",$select_result['email'],$regs)) || (!eregi("([.])(.*)",$select_result['email'],$regs)) || (verify($select_result['email'],"string_int_email")==1))
				;
			else
				bx_mail($site_name,$site_mail,$select_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
			//echo stripslashes($mail_message);

			$update_SQL = "update $database_table_name set validate='1' where $primary_id_name='".${$primary_id_name}[$i]."'";
			$update_query = bx_db_query($update_SQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}

	if ($HTTP_GET_VARS['validate_this'])
	{
		$selectSQL = "select * from $database_table_name where ".$primary_id_name."='".$primary_id."'";
		$select_query = bx_db_query($selectSQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$select_result = bx_db_fetch_array($select_query);
		//mail($select_result['email'], "Confirmation", JOKE_CONFIRMED_MESSAGE,"From: ".$site_mail);
		
		/*
		confirm joke
		*/
		if (MULTILANGUAGE_SUPPORT == "on") 
		{
		   $dirs = getFiles(DIR_FLAG);
		   for ($i=0; $i<count($dirs); $i++) 
		   {
			   $lngname = split("\.",$dirs[$i]);
			   if($select_result['slng'] == "_".substr($lngname[0], 0,3))
			   {
				   $use_language = $lngname[0];
				   break;
			   }
		   }
		}
		
		if($use_language =='')
			$use_language = DEFAULT_LANGUAGE;

		$mailfile = $use_language."/mail/confirm_joke_validation.txt";
		include(DIR_LANGUAGES.$mailfile.".cfg.php");
		if($html_mail=="on")
		$mailfile .= ".html";
		$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

		$HTTP_POST_VARS['joke_title'] = $select_result['joke_title'];
		$HTTP_POST_VARS['joke_text'] = $select_result['joke_text'];
		$HTTP_POST_VARS['name'] = $select_result['name'];
		$HTTP_POST_VARS['site_name'] = $site_name;

		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		while (list($h, $v) = each($fields))
		{
			$mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
			$file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
		}

		if($html_mail=="on")
		{
			if ($add_html_header == "on") {
				$mail_message = fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html")).$mail_message;
			} 
			if ($add_html_footer == "on") {
				$mail_message .= fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html"));
			} 
			$html_mail="yes";
		}
		else
		{
			if ($add_mail_signature == "on")
				$mail_message .= "\n".SITE_SIGNATURE;
			$html_mail="no";
		}
		
		if (empty($select_result['email'])  || (!eregi("(@)(.*)",$select_result['email'],$regs)) || (!eregi("([.])(.*)",$select_result['email'],$regs)) || (verify($select_result['email'],"string_int_email")==1))
			;
		else
			bx_mail($site_name,$site_mail,$select_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
		//echo stripslashes($mail_message);

		$update_SQL = "update $database_table_name set validate='1' where $primary_id_name='".$primary_id."'";

		$update_query = bx_db_query($update_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}
}
else{}

$select_position_SQL = "select * from $database_table_name where validate='0'";
$select_position_query = bx_db_query($select_position_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

if ($HTTP_GET_VARS['from'] > floor((bx_db_num_rows($select_position_query)-1)/$display_nr)*$display_nr)
{
	$from = $HTTP_GET_VARS['from'] = $HTTP_GET_VARS['from'] - $display_nr;
} 

$always_get_vars = "&amp;from=".$always_get_vars= $HTTP_POST_VARS['from'] ? $HTTP_POST_VARS['from'] : ($HTTP_GET_VARS['from'] ? $HTTP_GET_VARS['from'] : $from)."&".$get_vars;

$SQL = "select * from $database_table_name ".$condition." order by $primary_id_name";
$from1 = $from;
$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);

?>


<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<?
if($HTTP_GET_VARS['edit'])
{
?>
<tr>
	<td>
		<? include (DIR_SERVER_ADMIN."admin_joke_form.php");?><br>
	</td>
</tr>
<?
}
?>
<tr>
	<td>
<?
$count_query = bx_db_query($SQL);
echo "Total number of ".$page_title." <b>".bx_db_num_rows($count_query)."</b>.<br><br>";
?>
	</td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" width="5%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>ID</b></font></td>
			<td align="center" width="45%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>New Jokes Title</b></font></td>
			<td align="center" width="50%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Action</b></font></td>
		</tr>
		<form method=post action="<?=$this_file_name?>?from=<?=$item_back_from?>" name="forms">
<?
if(sizeof($result_array) == 0)
	echo "<tr bgcolor=\"".INSIDE_TABLE_BG_COLOR."\" align=\"center\"><td colspan=\"6\"><b>There are no new jokes!</b></td></tr>";

for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td class="text">
				<?=$result_array[$i][$primary_id_name];?>
			</td>
			<td class="text">
				<?=substr($result_array[$i]['joke_title'], 0, 50);?>
				<input type="hidden" name="display_nr" value="<?=$display_nr?>">

				<input type="hidden" name="<?=$primary_id_name?>[]" value="<?=$result_array[$i][$primary_id_name]?>">

			</td>
			<td align="center">
				&nbsp;&nbsp;&nbsp;&nbsp;
				[<a  href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&edit=1">View/Edit</a>]&nbsp;&nbsp;&nbsp;
				
				[<a  href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&validate_this=1">Validate</a>]&nbsp;&nbsp;&nbsp;
				[<a href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&delete_this=1" onClick="return confirm('Are you sure you want delete this entry?')">Delete</a>]
				
				&nbsp;&nbsp;<input type="checkbox" name="cycle_id<?=$i?>">
			</td>
		 </tr>
<?
}
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td colspan="3" height="3"><font style="font-size:1pt">&nbsp;</font></td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td>
				&nbsp;
			</td>
			<td align="center">
				<input type="submit" name="validate_button" value="Validate All" class="button">
			</td>
			<td align="right">
				<input type="submit" name="delete_button" value="Delete Checked" class="button"  onClick="return confirm('Are you sure want delete these entries?\n');">
			</td>
			</form>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td colspan="3">
				&nbsp;
			</td>
		</tr>

 		<tr>
			<td bgcolor="#efefef" colspan="3">
<?
make_next_previous_with_number( $from, $SQL, $this_file_name, $get_vars ,$display_nr);
?>
			</td>
		</tr>   
		</table>
	</td>
</tr>
<tr>
	<td>
		<form method=post action="<?=$this_file_name?>">
		<br>Total number display: <input type="text" name="display_nr" value="<?=$display_nr?>" class="">
		&nbsp;<input type="submit" name="go" value="Go" class="button">
		</form>
	</td>
</tr>
</table>
<br>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");

?>