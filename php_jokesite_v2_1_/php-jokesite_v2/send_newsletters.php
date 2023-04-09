<?
	include('config_file.php');
	include(DIR_LNG.'send_newsletters.php');
	$today = date("Y-m-d");
	$joke_query = bx_db_query("select * from $bx_db_table_daily_newsletters where date='".$today."'");
	$joke_result = bx_db_fetch_array($joke_query);	

/***********************************************************/
$dirs = getFiles(DIR_FLAG);
for ($startType=1;$startType<4;$startType++)
{
	for ($i=0; $i<count($dirs); $i++) 
	{
		$lngname = split("\.",$dirs[$i]);
		$slng = "_".substr($lngname[0],0,3);
		if (MULTILANGUAGE_SUPPORT != "on") 
		{
			$slng = "_".substr(DEFAULT_LANGUAGE,0,3);
			$i=count($dirs);
		}

		if($startType == 1)
			$SQL = "select * from $bx_db_table_newsletter_subscribers where lastdate < '".date('Y-m-d')."' and type='".$startType."' and slng='".$slng."'";
		elseif($startType==2)
			$SQL = "select * from $bx_db_table_newsletter_subscribers where lastdate  <= '".date('Y-m-d', mktime(0,0,0,date('m'), date('d')-7,date('Y')))."' and type='".$startType."' and slng='".$slng."'";
		elseif($startType==3)
			$SQL = "select * from $bx_db_table_newsletter_subscribers where lastdate  <= '".date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30,date('Y')))."' and type='".$startType."' and slng='".$slng."'";
		else{}

		$newsletters_query = bx_db_query($SQL);
		while($newsletters_result = bx_db_fetch_array($newsletters_query))
		{
			$mailfile = $lngname[0]."/mail/newsletter.txt";
			include(DIR_LANGUAGES.$mailfile.".cfg.php");
			if($html_mail=="on")
				$mailfile .= ".html";
			$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

			$selectSQLnewsl = "select * from $bx_db_table_newsletter_categories where newsletter_category_id ='".$newsletters_result['type']."'";
			$select_querynewsl = bx_db_query($selectSQLnewsl);
			$res_news = bx_db_fetch_array($select_querynewsl);
			
			$HTTP_POST_VARS['newsletter_type'] = $res_news['newsletter_category_name'.$slng];
			$HTTP_POST_VARS['joke_title'] = $joke_result['joke_title'.$slng];
			$HTTP_POST_VARS['joke_text'] = nl2br($joke_result['joke_text'.$slng]);
			$HTTP_POST_VARS['newsletter_language'] = $language;
			$HTTP_POST_VARS['unsubscribe_link'] = " <a href='".HTTP_SERVER."newsletters.php?unsub=".$newsletters_result['email']."'>".HTTP_SERVER."newsletters.php?unsub=".$newsletters_result['email']."</a>";
			
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
			bx_mail($site_name,$newsletter_mail,$newsletters_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
			$update_lastdate_query = bx_db_query("update $bx_db_table_newsletter_subscribers set lastdate='".$today."' where id='".$newsletters_result['id']."'");
			//echo nl2br(stripslashes($mail_message));
		}
	}
}

?>