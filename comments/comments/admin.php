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

$auth = is_auth();
main();

function main() {

	global $auth;

        if ($_REQUEST['action'] == 'delete' && $auth){
        	delete();
        }
        elseif ($_REQUEST['action'] == 'list' && $auth){
        	view_list();
        }
        elseif ($_REQUEST['action'] == 'banip' && $auth){
        	banip();
        }
        elseif ($_REQUEST['action'] == 'search' && $auth){
        	search();
        }
        elseif ($_REQUEST['action'] == 'bannedlist' && $auth){
        	bannedlist();
        }
        elseif ($_REQUEST['action'] == 'unbanip' && $auth){
        	unbanip();
        }
        elseif ($_REQUEST['action'] == 'logout'){
        	logout();
        }
	elseif (1) {
		login_screen();
	}

}

function is_auth() {

	global $COM_CONF;

	if ($_COOKIE['login']) {
		$login = $_COOKIE['login'];
	}
	if ($_POST['login']) {
		$login = $_POST['login'];
	}
	if ($_COOKIE['passw']) {
		$passw = $_COOKIE['passw'];
	}
	if ($_POST['passw']) {
		$passw = $_POST['passw'];
	}

	if ($login == $COM_CONF['admin_name'] && $passw == $COM_CONF['admin_passw'] && $_REQUEST['action'] != 'logout') {
		setcookie("login", $login, time()+999999, "{$COM_CONF['script_dir']}/");
		setcookie("passw", $passw, time()+999999, "{$COM_CONF['script_dir']}/");
		return 1;
	}
	else {
		return 0;
	}

}

function login_screen() {

	global $auth, $COM_CONF, $COM_LANG;

	if ($auth) {
		search();
		return 0;
	}
	else {
		require("./templates/admin/default_login.php");
	}

}

function search() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$query = mysql_escape_string($_REQUEST['query']);

	$result = mysql_query("select href from {$COM_CONF['dbmaintable']} WHERE href like '%{$query}%' GROUP BY href");
	$all_count = mysql_num_rows($result);
	$records_per_page = 30;
	if ($all_count > $records_per_page) { 
		$page = $_REQUEST['page'];
		if ($page > 0) { $page=$page-1; }
		$first_record = ($page) * $records_per_page;
		$limit_string = "LIMIT $first_record, $records_per_page";
		$pages=$all_count/$records_per_page;
		if ($pages > (int) $pages) { $pages=(int)$pages+1; }
	}

	if ($pages>1) {
		$pages_string.="Page: ";
		if ($page>10 && $pages>20) { $first_page=$page-9; }
		else { $first_page=1; }
		if ($pages>20 && ($page+10)<$pages) { $last_page=$first_page+19; } 
		else { $last_page=$pages; }
		if ($page+1>1) {
			$prev=$page;
			$pages_string.="<a href='{$COM_CONF['admin_script_url']}?action=search&query=$query&page=$prev'>&lt</a>&nbsp;&nbsp;";
		}
		for ($i=$first_page; $i<=$last_page; $i++){
			if ($i != $page+1) {
				$pages_string.="<a href='{$COM_CONF['admin_script_url']}?action=search&query=$query&page=$i'>$i</a>&nbsp; ";
			}
			else {
				$pages_string.="<b>$i</b>&nbsp; ";
			}
		}
		if ($page+1<$pages) {
			$next=$page+2;
				$pages_string.="<a href='{$COM_CONF['admin_script_url']}?action=search&query=$query&page=$next'>&gt</a>&nbsp&nbsp";
			}


	}

	$result = mysql_query("select href, COUNT(*) as count, MAX(time) as maxtime from {$COM_CONF['dbmaintable']} WHERE href like '%{$query}%' GROUP BY href ORDER BY maxtime DESC {$limit_string}", $comments_db_link);
	$href=$count=array();
	$hrefs_count=0;
	while (list($href[$hrefs_count], $count[$hrefs_count]) = mysql_fetch_row($result)){
		$hrefs_count++;
	}

	require("./templates/admin/default_search.php");


}

function view_list() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$request_uri = mysql_escape_string($_REQUEST['href']);
	$result = mysql_query("select id, time, text, author, email, dont_show_email, ip from {$COM_CONF['dbmaintable']} where href='$request_uri' order by time {$COM_CONF['sort_order']}", $comments_db_link);

	$comments_count=0;
	$id=$time=$text=$author=$email=$dont_show_email=$ip=array();
	while (list($id[$comments_count], $time[$comments_count], $text[$comments_count], $author[$comments_count], $email[$comments_count], $dont_show_email[$comments_count], $ip[$comments_count])=mysql_fetch_array($result)) {
		$comments_count++;
	}

	require("./templates/admin/default_list.php");

}

function delete() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$id = mysql_escape_string($_REQUEST['id']);

	mysql_query("delete from {$COM_CONF['dbmaintable']} where id='$id'", $comments_db_link);

	header("HTTP/1.1 302");
	header("Location: {$COM_CONF['site_url']}{$COM_CONF['admin_script_url']}?action=list&href={$_REQUEST['from']}");
	print "Comment has been deleted.<br><a href=\"{$COM_CONF['site_url']}{$COM_CONF['admin_script_url']}?action=list&href={$_REQUEST['from']}\">Click here to get back.</a>";


}

function banip() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$ip = mysql_escape_string($_REQUEST['ip']);

	mysql_query("INSERT INTO {$COM_CONF['dbbannedipstable']} SET ip='$ip'", $comments_db_link);

	print "IP {$_REQUEST['ip']} has been banned.<br><a href=\"{$COM_CONF['site_url']}{$COM_CONF['admin_script_url']}?action=list&href={$_REQUEST['from']}\">Click here to get back.</a>";


}

function bannedlist() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$result = mysql_query("SELECT ip FROM {$COM_CONF['dbbannedipstable']}", $comments_db_link);

	$ips_count=0;
	while (list($ip[$ips_count]) = mysql_fetch_row($result)) {
		$ips_count++;
	}

	require ("./templates/admin/default_blist.php");

}

function unbanip() {

	global $comments_db_link, $COM_CONF, $COM_LANG;

	$ip = mysql_escape_string($_REQUEST['ip']);

	mysql_query("DELETE FROM {$COM_CONF['dbbannedipstable']} WHERE ip='$ip'", $comments_db_link);

	header("HTTP/1.1 302");
	header("Location: {$COM_CONF['site_url']}{$COM_CONF['admin_script_url']}?action=bannedlist");


}


function logout() {

	global $comments_db_link, $COM_CONF;

	setcookie("login", "", time()-999999, "{$COM_CONF['script_dir']}/");
	setcookie("passw", "", time()-999999, "{$COM_CONF['script_dir']}/");

	mysql_query("OPTIMIZE TABLE {$COM_CONF['dbbannedipstable']}");
	mysql_query("OPTIMIZE TABLE {$COM_CONF['dbmaintable']}");
	mysql_query("OPTIMIZE TABLE {$COM_CONF['dbemailstable']}");

	header("HTTP/1.1 302");
	header("Location: {$COM_CONF['site_url']}{$COM_CONF['admin_script_url']}");


}

?>