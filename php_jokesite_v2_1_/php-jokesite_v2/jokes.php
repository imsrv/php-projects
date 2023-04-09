<?
include ("config_file.php");
include(DIR_LNG.'jokes.php');

/**********************************************************
Joke rating
**********************************************************/
if($HTTP_POST_VARS['rate_form'] == '1' && $HTTP_POST_VARS['rating_value'])
{
	//here was a problem, but now is fixed
	$rated_joke_id = $HTTP_GET_VARS['joke_id'] ? $HTTP_GET_VARS['joke_id'] : ($HTTP_POST_VARS['joke_id'] ? $HTTP_POST_VARS['joke_id'] : "");
	
	$cook_vote = unserialize(stripslashes($HTTP_COOKIE_VARS['cook_vote']));

	if (is_array($cook_vote) && isset($cook_vote))
	{
		while (list(,$val) = each($cook_vote)) 
		{
			if ($val == $rated_joke_id)
			{
				$message_to_user = TEXT_ALREADY_VOTED;
				$was_voted = 'yes';
			}
		}
	}
	
	if($was_voted != 'yes')
	{
		$cook_vote[] = $rated_joke_id;
		setcookie("cook_vote",serialize($cook_vote),(time()+$cookie_limit),"/");

		$message_to_user = TEXT_THANKS_FOR_RATING;
		$was_voted = 'no';
	}
}
else if($HTTP_POST_VARS['rate_form'] == '1' && !$HTTP_POST_VARS['new_rate_it'])
	$message_to_user = TEXT_SELECT_RATE_NUMBER;
else{}

if($was_voted == 'no' && $HTTP_POST_VARS['rating_value'])		
{
	$SQL = "select * from $bx_db_table_rating where joke_id ='".$HTTP_GET_VARS['joke_id']."'";
	$rate_read_query = bx_db_query($SQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$rate_read_result = bx_db_fetch_array($rate_read_query);
	$rate_nr = $rate_read_result['rate_nr'] + 1;
	$total_value = $rate_read_result['total_value'] + $HTTP_POST_VARS['rating_value'];
 	$rating_value = $total_value / $rate_nr;

	if($rate_read_result['id'])
	{
		$SQL = "update $bx_db_table_rating set rate_nr='".$rate_nr."', total_value='".$total_value."', rating_value='".$rating_value."' where joke_id='".$HTTP_GET_VARS['joke_id']."'";
		$update_query = bx_db_query($SQL);
	}
	else
	{
		bx_db_insert($bx_db_table_rating ," joke_id,rate_nr,total_value,rating_value,emailed_nr", "'".$HTTP_POST_VARS['joke_id']."', '1', '".$HTTP_POST_VARS['rating_value']."','".$HTTP_POST_VARS['rating_value']."','0'");
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}

	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	bx_db_insert($bx_db_table_votes ," joke_id,ip ", "'".$HTTP_GET_VARS['joke_id']."', '".$REMOTE_ADDR."'");
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	
	$SQL = "update $bx_db_table_jokes set rating_value='".number_format($rating_value,0)."' where joke_id='".$HTTP_GET_VARS['joke_id']."'";
	$update_query = bx_db_query($SQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
}



/*******************************************************************
Joke to friend
*******************************************************************/
if ($HTTP_POST_VARS['joke2friend_form'] == "1")
{
	if ($HTTP_POST_VARS['your_name']=="") 
		$name_error="yes";        
	else 
		$name_error="no";

	if ($HTTP_POST_VARS['to_name']=="") 
		$toname_error="yes";        
	else 
		$toname_error="no";

	if (empty($HTTP_POST_VARS['your_email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['your_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['your_email'],$regs)) || (verify($HTTP_POST_VARS['your_email'],"string_int_email")==1))
		$email_error="yes";
	else
		$email_error="no";

	if (empty($HTTP_POST_VARS['to_email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['to_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['to_email'],$regs)) || (verify($HTTP_POST_VARS['to_email'],"string_int_email")==1))
		$toemail_error="yes";
	else
		$toemail_error="no";


	if ($name_error=="no" && $toname_error=="no" && $email_error=="no" && $toemail_error=="no" && $HTTP_POST_VARS['submit'])
	{

	$mailfile = $language."/mail/joke_to_friend.txt";
	include(DIR_LANGUAGES.$mailfile.".cfg.php");
	if($html_mail=="on")
	$mailfile .= ".html";
	$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

	$selectSQLnewsl = "select * from $bx_db_table_newsletter_categories where newsletter_category_id ='".$HTTP_POST_VARS['type']."'";
	$select_querynewsl = bx_db_query($selectSQLnewsl);
	$res_news = bx_db_fetch_array($select_querynewsl);
	
	$HTTP_POST_VARS['from_email'] = $HTTP_POST_VARS['your_email'];
	$HTTP_POST_VARS['from_name'] = $HTTP_POST_VARS['your_name'];
	$HTTP_POST_VARS['to_email'] = $HTTP_POST_VARS['to_email'];
	$HTTP_POST_VARS['to_name'] = $HTTP_POST_VARS['to_name'];
	$HTTP_POST_VARS['joke_text'] = nl2br($HTTP_POST_VARS['joke_text']);
	$HTTP_POST_VARS['joke_title'] = $HTTP_POST_VARS['joke_title'];

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

	bx_mail($site_name,$HTTP_POST_VARS['your_email'],$HTTP_POST_VARS['to_email'], ereg_replace("&quot;", "\"", stripslashes($file_mail_subject)), ereg_replace("&quot;", "\"", stripslashes($mail_message)), $html_mail);
	//echo stripslashes($mail_message);
	
	//exit;
		$email_sent = "success";
		$message_to_user = TEXT_JOKE_WAS_SENT_TO." ".$email;
		
		$voted_nr_query = bx_db_query("select emailed_nr, joke_id from $bx_db_table_rating where joke_id='".$HTTP_GET_VARS['joke_id']."'");
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$voted_nr_result = bx_db_fetch_array($voted_nr_query);

		$new_voted_nr = $voted_nr_result['emailed_nr']+1;

		if($voted_nr_result['joke_id'])
		{
			$query = bx_db_query("update $bx_db_table_rating set emailed_nr='".$new_voted_nr."' where joke_id='".$HTTP_GET_VARS['joke_id']."'");
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			$updateSQL = "update $bx_db_table_jokes set emailed_value='".$new_voted_nr."' where joke_id='".$HTTP_GET_VARS['joke_id']."'";
			$update_query = bx_db_query($updateSQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
		else
		{
			$new_voted_nr = 0;
			bx_db_insert($bx_db_table_rating ," joke_id,rate_nr,total_value,rating_value,emailed_nr", "'".$HTTP_POST_VARS['joke_id']."', '0', '0','0','1'");
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

			$updateSQL = "update $bx_db_table_jokes set emailed_value='1' where joke_id='".$HTTP_GET_VARS['joke_id']."'";
			$update_query = bx_db_query($updateSQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}
	else if(($name_error=="yes" || $email_error=="yes" || $visitor_email_error=="yes") && $HTTP_POST_VARS['submit'])
	{
		$message = TEXT_ERROR." ";

		
		if($name_error == "yes" && $email_error == "yes")
			$message_to_user .= TEXT_ENTER_NAME_AND_EMAIL;
		else if($name_error == "yes")
			$message_to_user .= TEXT_ENTER_YOUR_NAME;
		else if($email_error == "yes")
			$message_to_user .= TEXT_ENTER_VALID_EMAIL;
		else if($visitor_email_error == "yes")
			$message_to_user .= TEXT_ERROR_EMAIL;
		else{}

	}
	else{}
}
	
$database_table_name1 = $bx_db_table_joke_categories;
$database_table_name2 = $bx_db_table_jokes;

$show_joke_categories="yes";
include (DIR_SERVER_ROOT."header.php");

include (DIR_FORMS."joke_form.php");
include (DIR_FORMS."rate_form.php");
include (DIR_FORMS."joke_to_friend_form.php");
include (DIR_SERVER_ROOT."footer.php");
?>