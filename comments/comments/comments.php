<?

/*


	Copyright (C) 2005 ScriptsMill

	E-Mail: info@scriptsmill.com
	URL: http://www.scriptsmill.com
	
    This file is part of ScriptsMill Comments.

    ScriptsMill Comments is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or
    (at your option) any later version.

    ScriptsMill Comments is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ScriptsMill Comments; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


*/


include("./config.php");
include("./lang/lang_{$COM_CONF['lang']}.php");

$comments_db_link = mysql_connect($COM_CONF['dbhost'],$COM_CONF['dbuser'],$COM_CONF['dbpassword']);
mysql_select_db($COM_CONF['dbname'], $comments_db_link);

main();

function main() {

        if ($_REQUEST['action'] == 'add'){
        	add();
        }
        elseif ($_REQUEST['action'] == 'unsub'){
        	unsub();
        }
	elseif (1) {
		view();
	}


}

function check_for_errors() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

        $ip = mysql_escape_string($_SERVER['REMOTE_ADDR']);
	$result = mysql_query("SELECT ip FROM {$COM_CONF['dbbannedipstable']} WHERE ip='$ip'", $comments_db_link);

	if (mysql_num_rows($result)>0) {
		$error_message.=$COM_LANG['not_allowed'] . "<br />";
	}
	if ($_REQUEST['disc_name'] == '') {
		$error_message.=$_REQUEST['r_disc_name'] . "<br />";
	}
	if ($_REQUEST['disc_body'] == '') {
		$error_message.=$_REQUEST['r_disc_body'] . "<br />";
	}

	return $error_message;

}

function flood_protection($INPUT) {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$result = mysql_query("select time from {$COM_CONF['dbmaintable']} where ip='{$_SERVER['REMOTE_ADDR']}' AND  (UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( time )) < {$COM_CONF['anti_flood_pause']}", $comments_db_link);
	if (mysql_num_rows($result)>0) {
		$error_message="Flood detected";
		return $error_message;
	}
	$result = mysql_query("select ID from {$COM_CONF['dbmaintable']} where text='{$INPUT['disc_body']}' AND author='{$INPUT['disc_name']}' AND href='{$INPUT['href']}'", $comments_db_link);
	if (mysql_num_rows($result)>0) {
		$error_message="Flood detected";
		return $error_message;
	}

	return "";
}

function add() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	foreach ($_REQUEST as $key => $value) {
		$_REQUEST[$key] = str_replace('<', '&lt;', $_REQUEST[$key]);
		$_REQUEST[$key] = str_replace('>', '&gt;', $_REQUEST[$key]);
		if (get_magic_quotes_gpc()) {
			$_REQUEST[$key] = stripslashes($_REQUEST[$key]);
		}
		$_REQUEST[$key] = mysql_escape_string($_REQUEST[$key]);
	}

	$error_message = check_for_errors();
	$error_message .= flood_protection($_REQUEST);	

	if ($error_message) {
		print "The following errors occured:<br>$error_message";
		return 0;
	}

	if ($_REQUEST['dont_show_email'] != '') { $dont_show="1"; }
	else { $dont_show="0"; }

	mysql_query("INSERT INTO {$COM_CONF['dbmaintable']} VALUES (NULL, NOW(), '{$_REQUEST['href']}', '{$_REQUEST['disc_body']}', '{$_REQUEST['disc_name']}', '{$_REQUEST['disc_email']}', '$dont_show', '{$_SERVER['REMOTE_ADDR']}')", $comments_db_link);

	if ($_REQUEST['email_me'] != '' && $_REQUEST['disc_email'] != '') {
		$result = mysql_query("select COUNT(*) from {$COM_CONF['dbemailstable']} where href='{$_REQUEST['href']}' AND email='{$_REQUEST['disc_email']}'", $comments_db_link);
		list ($count) = mysql_fetch_row($result);
		if ($count == 0) {
			$hash=md5($email . $COM_CONF['copy_random_seed']);
			mysql_query("INSERT INTO {$COM_CONF['dbemailstable']} VALUES (NULL, '{$_REQUEST['disc_email']}', '{$_REQUEST['href']}', '$hash')", $comments_db_link);
		}
	}

	if ($COM_CONF['email_admin']) {
		notify_admin($_REQUEST['href'], $_REQUEST['disc_name'], $_REQUEST['disc_email'], stripslashes($_REQUEST['disc_body']), "{$_SERVER['REMOTE_ADDR']}, {$_SERVER['HTTP_USER_AGENT']}");
	}
	notify_users($_REQUEST['href'], $_REQUEST['disc_name'], $_REQUEST['disc_email']);

	header("HTTP/1.1 302");
	header("Location: {$COM_CONF['site_url']}{$_REQUEST['href']}");
	print "<a href=\"{$COM_CONF['site_url']}{$_REQUEST['href']}\">Click here to get back.</a>";

}


function notify_admin($href, $name, $email, $text, $ip) {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$headers = "From: Comments <{$COM_CONF['email_from']}>\r\n";
	$text_of_message="
{$COM_LANG['email_new_comment']} {$COM_CONF['site_url']}$href
{$COM_LANG['email_from']}: $name <$email>
 
$text

$ip
		";

		mail($COM_CONF['email_admin'], "{$COM_LANG['email_new_comment']} $href", $text_of_message, $headers);


}

function notify_users($href, $name, $email_from) {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$headers = "From: Comments <{$COM_CONF['email_from']}>\n";

	$result=mysql_query("select email, hash from {$COM_CONF['dbemailstable']} where href='$href'", $comments_db_link);
	while (list($email, $hash) = mysql_fetch_row($result)) {
	  if ($email != $email_from) {
		$text_of_message="
{$COM_LANG['email_new_comment']} {$COM_CONF['site_url']}$href
{$COM_LANG['email_from']}: $name

{$COM_LANG['email_to_unsubscribe']}
{$COM_CONF['site_url']}{$COM_CONF['script_url']}?action=unsub&page=$href&id=$hash

			";
		mail($email, "{$COM_LANG['email_new_comment']} $href",$text_of_message, $headers);
	  }
	}


}

function unsub() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$id=mysql_escape_string($_REQUEST['id']);
	$href=mysql_escape_string($_REQUEST['page']);

	mysql_query("delete from {$COM_CONF['dbemailstable']} where href='$href' AND hash='$id'", $comments_db_link);

	if (mysql_affected_rows() > 0) {
		print "{$COM_LANG['unsubscribed']}";
	}
	else {
		print "{$COM_LANG['not_unsubscribed']}";
	}

}


function view() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$request_uri = mysql_escape_string($_SERVER['REQUEST_URI']);
	$result = mysql_query("select time, text, author, email, dont_show_email from {$COM_CONF['dbmaintable']} where href='$request_uri' order by time {$COM_CONF['sort_order']}", $comments_db_link);

	$comments_count=0;
	$time=$text=$author=$email=$dont_show_email=array();
	while (list($time[$comments_count], $text[$comments_count], $author[$comments_count], $email[$comments_count], $dont_show_email[$comments_count])=mysql_fetch_array($result)) {
		$time[$comments_count] = format_date($time[$comments_count]);
		$comments_count++;
	}

	require("./templates/{$COM_CONF['template']}.php");

}

function format_date ($date) {

	global $COM_LANG;

	$year = substr($date, 0, 4);
	$month = intval(substr($date, 5, 2)) - 1;
	$day = substr($date, 8, 2);
	$hour = substr($date, 11, 2);
	$min = substr($date, 14, 2);

//	return "$day $month $year, $hour:$min";
	return "$day {$COM_LANG['months'][$month]} $year, $hour:$min";

}

?>