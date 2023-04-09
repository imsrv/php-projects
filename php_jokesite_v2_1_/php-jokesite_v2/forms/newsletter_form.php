<?
include(DIR_LNG.'newsletter_form.php');
if ($HTTP_POST_VARS['submit_newsletter'])
{
	$selectSQL = "select * from $bx_db_table_newsletter_subscribers where email='".$HTTP_POST_VARS['email']."' and slng='".$slng."'";
	$select_query = bx_db_query($selectSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	if (bx_db_num_rows($select_query) )
	{
		$message_to_user = TEXT_EMAIL_ALREADY_EXIST;
	}
	elseif (!empty($HTTP_POST_VARS['email']) && (eregi("(@)(.*)",$HTTP_POST_VARS['email'],$regs)) && (eregi("([.])(.*)",$HTTP_POST_VARS['email'],$regs)) && (verify($HTTP_POST_VARS['email'],"string_int_email")==0))
	{
		bx_db_insert($bx_db_table_newsletter_subscribers,"type,email,slng","'".$HTTP_POST_VARS['type']."', '".$HTTP_POST_VARS['email']."', '".$slng."'");
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	
		$message_to_user = TEXT_SUBSCRIBED;


	 //send mail to registered company
		$mailfile = $language."/mail/newsletter_subscribe.txt";
		include(DIR_LANGUAGES.$mailfile.".cfg.php");
		if($html_mail=="on")
		$mailfile .= ".html";
		$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
		$HTTP_POST_VARS['confirmation_link'] = HTTP_SERVER."registration_confirmation.php?t=e&cs=".md5($HTTP_POST_VARS['email']."1974");
		reset($fields);
		$selectSQLnewsl = "select * from $bx_db_table_newsletter_categories where newsletter_category_id ='".$HTTP_POST_VARS['type']."'";
		$select_querynewsl = bx_db_query($selectSQLnewsl);
		$res_news = bx_db_fetch_array($select_querynewsl);
		$HTTP_POST_VARS['newsletter_type'] = $res_news['newsletter_category_name'.$slng];
		$HTTP_POST_VARS['newsletter_language'] = $language;

		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		while (list($h, $v) = each($fields))
		{
			$mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
			$file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
		}
		
		if($html_mail=="on")
		{
			if ($add_html_header == "on") {
				$mail_message = fread(fopen(DIR_LANGUAGES.$language."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$language."/html/html_email_message_header.html")).$mail_message;
			} 
			if ($add_html_footer == "on") {
				$mail_message .= fread(fopen(DIR_LANGUAGES.$language."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$language."/html/html_email_message_footer.html"));
			} 
			$html_mail="yes";
		}
		else
		{
			if ($add_mail_signature == "on")
				$mail_message .= "\n".SITE_SIGNATURE;
			$html_mail="no";
		}
		bx_mail($site_name,$site_mail,$HTTP_POST_VARS['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
			
	}
	else
	{
		$message_to_user = TEXT_SPECIFY_EMAIL_ADDRESS;
	}
?>
<script language="Javascript">
<!--
alert('<?=$message_to_user?>');
//-->
</script>
<?
	refresh(HTTP_SERVER);
	exit;
}
?>

<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=NEWSLETTER_TABLE_WIDTH?>">
<tr>
	<td bgcolor="<?=NEWSLETTER_BORDERCOLOR?>"><form method=post action="<?=$this_file_name?>" name="form1" onSubmit="if(document.form1.email.value=='<?=TEXT_DEFAULT_EMAIL_ADDRESS?>') {alert('<?=TEXT_SPECIFY_EMAIL_ADDRESS?>');return false;}else{return true;}" style="margin-top: 0px;margin-bottom: 0px;">
	<table align="center" border="0" cellspacing="<?=NEWSLETTER_TABLE_CELLSPACING?>" cellpadding="<?=NEWSLETTER_TABLE_CELLPADDING?>" width="100%" bgcolor="<?=NEWSLETTER_BGCOLOR?>" height="60">
	<tr>
		<td width="100%" align="center" colspan="3"><img src="<?=HTTP_LANG_IMAGES?>newsletter.gif" border="0"></td>
	</tr>
	<tr>
		<td width="100%" align="center" colspan="3"><img src="<?=DIR_IMAGES?>lines2.gif" border="0"></td>
	</tr>
	<tr>
		<td align="center" bgcolor="<?=SUBSCRIBE_TEXT_BGCOLOR?>"><font size="1" face=" verdana, helvetica, arial" color="<?=SUBSCRIBE_TEXT_COLOR?>"><b><b><?=TEXT_SUBSCRIBE_TO?></b></font>
<?
$selectSQL = "select * from $bx_db_table_newsletter_categories where active='on'";
$select_query = bx_db_query($selectSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if (bx_db_num_rows($select_query) == '1')
{
	$select_result = bx_db_fetch_array($select_query);
	echo $select_result['newsletter_category_name'.$slng];
	echo "<input type=\"hidden\" name=\"type\" value=\"".$select_result['newsletter_category_id']."\">";
}
else
{
	echo "<select name=\"type\" style=\"font-size:10px;font-family:verdana;\">";
	while($select_result = bx_db_fetch_array($select_query))
	{
		echo "<option value=\"".$select_result['newsletter_category_id']."\">".$select_result['newsletter_category_name'.$slng]."</option>";
	}
	echo "</select>";
}
?>
				</font>
		</td>
	</tr>
	<tr>
		<td align="center" bgcolor="<?=SUBSCRIBE_TEXT_BGCOLOR?>"><font size="1" face=" verdana, helvetica, arial" color="<?=SUBSCRIBE_TEXT_COLOR?>"><b><b><?=TEXT_NEWSLETTER?></b></font>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" border="0" cellspacing="<?=NEWSLETTER_TABLE_CELLSPACING?>" cellpadding="<?=NEWSLETTER_TABLE_CELLPADDING?>" width="100%">
			<tr>
				<td align="center"><input type="hidden" name="submit_newsletter" value="1"><input type="text" name="email" value="<?=TEXT_DEFAULT_EMAIL_ADDRESS?>" onFocus="if(document.form1.email.value == '<?=TEXT_DEFAULT_EMAIL_ADDRESS?>'){this.value='';}" onBlur="if(document.form1.email.value==''){this.value='<?=TEXT_DEFAULT_EMAIL_ADDRESS?>';}" size="10" style="width:140px"></td>
			</tr>
			<tr>
				<td align="center"><input type="submit" name="submit1" value="<?=TEXT_SUBMIT?>" class="button"><br><br></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</form>