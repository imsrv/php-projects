<?php

$templates='onlinepage,onlinepagerow,onlineusers,onlineusersrow,onlinemenu,';
$wordbits='nousersonline,noguestsonline,guestusername,';
$settings='onlinepage_refresh,onlineusers_timestamp,';

include('./lib/config.php');

$header=str_replace('<pagemenu>', getTemplate('onlinemenu'), $header);

$registered_users='';
$guests='';

if ($action=='showonlineusers' || $action=='news') {
	if (isset($HTTP_GET_VARS['todays_users'])) {
		doHeader("$sitename: Online Users", 1, getSetting('onlinepage_refresh'), 'online.php?todays_users=1');
		$u=$dbr->query("SELECT userid,displayname,last_page,last_active,access FROM arc_user WHERE last_active > " .(time() - 60*60*24));
		$unum=$dbr->result("SELECT COUNT(userid) AS numu FROM arc_user WHERE last_active > " .(time() - 60*60*24));
	} else {
		doHeader("$sitename: Online Users", 1, getSetting('onlinepage_refresh'), 'online.php');
		$u=$dbr->query("SELECT userid,displayname,last_page,last_active,access FROM arc_user WHERE last_active > " .(time() - $logouttime));
		$unum=$dbr->result("SELECT COUNT(userid) AS numu FROM arc_user WHERE last_active > " .(time() - $logouttime));
	}
	if ($unum>0) {
		while ($uinfo=$dbr->getarray($u)) {
			$uinfo['last_page'] = str_replace($cookiepath, '', $uinfo['last_page']);
			$where="<a href=\"$webroot$uinfo[last_page]\">$uinfo[last_page]</a>";
			if ($uinfo['access']==3 && getSetting('hideadmins')==1) $where=getwordbit('adminonline');

			$onlineprow=str_replace('<username>', "<a href=\"user.php?action=profile&id=$uinfo[userid]\">" .stripslashes($uinfo['displayname']). "</a>", $onlinepagerow);
			$onlineprow=str_replace('<where>', $where, $onlineprow);
			$onlineprow=str_replace('<last_active>', formdate($uinfo['last_active'], getSetting('onlineusers_timestamp')), $onlineprow);
			$registered_users.=$onlineprow;
		}
	} else {
		showmsg('nousersonline');
		echo '<br>';
	}
	if (isset($HTTP_GET_VARS['todays_users'])) {
		$v=$dbr->query("SELECT * FROM arc_visitor WHERE visitortimestamp > " .(time() - 60*60*24));
		$vnum=$dbr->result("SELECT COUNT(visitorid) AS numv FROM arc_visitor WHERE visitortimestamp > " .(time() - 60*60*24));
	} else {
		$v=$dbr->query("SELECT * FROM arc_visitor WHERE visitortimestamp > " .(time() - $logouttime));
		$vnum=$dbr->result("SELECT COUNT(visitorid) AS numv FROM arc_visitor WHERE visitortimestamp > " .(time() - $logouttime));
	}
	if ($vnum>0) {
		$vonlinerow=getTemplate('onlinepagerow');
		while ($vinfo=$dbr->getarray($v)) {
			$vinfo['visitorlastpage'] = str_replace($cookiepath, '', $vinfo['visitorlastpage']);
			$nonlinerow=str_replace('<username>', getwordbit('guestusername'), $vonlinerow);
			$nonlinerow=str_replace('<where>', "<a href=\"$webroot$vinfo[visitorlastpage]\">$vinfo[visitorlastpage]</a>", $nonlinerow);
			$nonlinerow=str_replace('<last_active>', formdate($vinfo['visitortimestamp'], getSetting('onlineusers_timestamp')), $nonlinerow);
			$guests.=$nonlinerow;
		}
	} else {
		showmsg('noguestsonline');
	}
}

echo str_replace('<onlinepagerow>', "$registered_users\n$guests", getTemplate('onlinepage'));

footer();

?>