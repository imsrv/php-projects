<?
include ("config_file.php");
include (DIR_SERVER_ROOT."header.php");
include (DIR_SERVER_ROOT."site_settings.php");

if($newsletter_delete_query = bx_db_query("delete from $bx_db_table_newsletter_subscribers where email='".$HTTP_GET_VARS['unsub']."'"))
{
	$mailfile = $language."/mail/newsletter_unsubscribe.txt";
	include(DIR_LANGUAGES.$mailfile.".cfg.php");
	if($html_mail=="on")
	$mailfile .= ".html";
	$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

	$selectSQLnewsl = "select * from $bx_db_table_newsletter_categories where newsletter_category_id ='".$HTTP_POST_VARS['type']."'";
	$select_querynewsl = bx_db_query($selectSQLnewsl);
	$res_news = bx_db_fetch_array($select_querynewsl);
	$HTTP_POST_VARS['newsletter_type'] = $res_news['newsletter_category_name'.$slng];
	$HTTP_POST_VARS['newsletter_language'] = $language;
	$HTTP_POST_VARS['email'] = $HTTP_GET_VARS['unsub'];

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
	bx_mail($site_name,$site_mail,$HTTP_GET_VARS['unsub'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
	//echo stripslashes($mail_message);
}	
?>
<tr>
	<td>
		<br><br>
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td align="center">
				<font><?=UNSUBSCRIBE_TEXT?></font>
			</td>
		</tr>
		</table>
		<br><br><br><br>

	</td>
</tr>
<?
include(DIR_SERVER_ROOT.'footer.php');
?>