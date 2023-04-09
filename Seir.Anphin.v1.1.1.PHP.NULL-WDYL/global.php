<?php

error_reporting(E_ALL);

$t=gettimeofday();
$startload=$t['usec']/1000000+$t['sec'];

set_magic_quotes_runtime(0);

$numqueries=0;
$switch=1;

require($path.'functions.php');

if (function_exists('get_cfg_var')) {
	$reg_globals=get_cfg_var('register_globals');
} else {
	$reg_globals=ini_get('register_globals');
}

if ($reg_globals!=1) {
	extract($HTTP_POST_VARS, EXTR_OVERWRITE);
	extract($HTTP_SERVER_VARS, EXTR_OVERWRITE);
	extract($HTTP_ENV_VARS, EXTR_OVERWRITE);
}

$db=new dbcontrol;

$db->host=$dbhost;
$db->name=$dbname;
$db->user=$dbuser;
$db->pass=$dbpass;
$dbr->error_reporting=1;

$db->connect();
$db->select();

$dbr=new dbresults;

$dbr->troubleshooting=0;

if (isset($HTTP_GET_VARS['bug'])) $dbr->troubleshooting=1;

$misc=$dbr->query('SELECT * FROM arc_misc');
$misc=$dbr->getarray($misc);

$safe=array('userid', 'isadmin', 'ismod', 'loggedin', 'u_userid');

foreach ($safe as $var) {
	if (isset($HTTP_GET_VARS[$var])) {
		echo 'I sincerely hope you die a slow and horrible death.';
		exit();
	}
}

if (isset($HTTP_GET_VARS['offset'])) { // get offset for page number links
	$offset=$HTTP_GET_VARS['offset'];
} else {
	$offset=0;
}

if (empty($settings)) $settings='';
$settings.='alternatetdbgcolors,rpg_flag,explevelmultiplier,levelup,level_factor,character_exp_value,experience_type,exp_up,exp_down,gold_exp_ratio,sp_exp_ratio,min_hp_gain,max_hp_gain,min_mp_gain,max_mp_gain,sitetimeoffset,showforumjump,deletevisitors,donotes,doquotes,note_timestamp,notesoldestfirst,adminshowonlineusers,default_colorset,default_templateset,webroot,sitename,maxusersonline,notesperpage,noteoldestfirst,notetimestamp,addnocacheheaders,gzcompress,logging_enabled,showlatestuser,dopms,noteboxsize,logouttime,timeoffset,show_latest_posts,show_admin_online,showpoll,allowhtml,site_is_on,';
setcache($settings, 'setting');

if (empty($wordbits)) $wordbits='';
$wordbits.='version,bad_link,nousersonline,oldnestnotesfirst,newestnotesfirst,nonotesyet,submitnote,cantpostnote,newpms,latestuser,userphptitletext,newestnotemessage,oldestnotemessage,exp_up,';
setcache($wordbits, 'wordbit');


// GET USER DATA
$REMOTE_ADDR=isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']) ? $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'] : $HTTP_SERVER_VARS['REMOTE_ADDR'];
if (empty($REMOTE_HOST)) $REMOTE_HOST='hostnotfound';
if (empty($REMOTE_ADDR)) $REMOTE_ADDR='10.0.0.1';

$admin=$misc['adminname'];
$mod=$misc['modname'];
if (isset($HTTP_COOKIE_VARS['arcuserid']) || isset($arcuserid)) {
	if (isset($HTTP_COOKIE_VARS['arcuserid'])) {
		$arcuserid=$HTTP_COOKIE_VARS['arcuserid'];
		$arcpass=$HTTP_COOKIE_VARS['arcpass'];
	}

	$userquery=$dbr->query("SELECT * FROM arc_user WHERE userid='$arcuserid'");
	$userinfo=$dbr->getarray($userquery);

	$passhash=$userinfo['password'];
//	echo "passhash = $passhash<br>arcpass = $arcpass";

	if ($passhash==$arcpass) {
	//	$userquery=$dbr->query("SELECT * FROM arc_user WHERE userid='$arcuserid'");
	//	$userinfo=$dbr->getarray($userquery);
		extract($userinfo, EXTR_SKIP);
		$loggedin='1';
		$autologouttime=time()-(60*getSetting('logouttime'));
		if ($last_active<$autologouttime) { // is first visit since last login
			$lastread=$last_active;
		}
		if (time()-$last_active<(60*30)) {
			$newtimeonline=$timeonline+(time()-$last_active);
		} else {
			$newtimeonline=$timeonline;
		}
		$updateuser=$dbr->query("UPDATE arc_user SET last_page='$REQUEST_URI', timeonline='$newtimeonline', last_active='" .time(). "', lastread=$lastread, user_ip='$REMOTE_ADDR' WHERE userid=$userid AND password='$arcpass'");

		if (substr($avatar,0,7)!='http://')
			$avatar=$webroot.'/'.$avatar;

		if (getSetting('rpg_flag')==1)
			if (substr($spritepath,0,7)!='http://')
				$spritepath=$webroot.'/'.$spritepath;

		if ($access==3) {
			$isadmin=1;
			$ismod=1;
		} elseif ($access==2) {
			$isadmin=0;
			$ismod=1;
		} else {
			$isadmin=0;
			$ismod=0;
		}
	} elseif ($passhash!=$arcpass && $arcpass!='') {
		setcookie('arcuserid', $arcuserid, time()-9999999, $cookiepath);
		setcookie('arcpass', $arcpass, time()-9999999, $cookiepath);
		$userid=0;
		$showonlineusers=1;
		$shownotes=getSetting('donotes');
		$showquotes=getSetting('doquotes');
		echo "The password in your cookie does not match that specified by the user account corresponding to the ID in your cookie. The cookie has been deleted.";
	}
} else { // do visitors
	$v=$dbr->result("SELECT visitorid FROM arc_visitor WHERE visitorip='$REMOTE_ADDR'");
	if (!is_numeric($v)) {
		$dbr->query("INSERT INTO arc_visitor SET visitorip='$REMOTE_ADDR', visitorhost='$REMOTE_HOST', visitorlastpage='$REQUEST_URI', visitortimestamp='" .time(). "'");
	}
	$visitor=$dbr->query("SELECT * FROM arc_visitor WHERE visitorip='$REMOTE_ADDR'");
	$vinfo=$dbr->getarray($visitor);
	$dbr->query("UPDATE arc_visitor SET visitorlastpage='$REQUEST_URI', visitortimestamp='" .time(). "' WHERE visitorip='$REMOTE_ADDR'");
	$isadmin=0;
	$ismod=0;
	$loggedin=0;
	$userid=0;
	$timeoffset=0;
	$viewposttemps=1;
	$isbanned=0;
	$access=0;
	$level=1;
	$layout=getSetting('default_templateset');
	$rank=$dbr->result("SELECT rank FROM arc_rank WHERE minlvl=0");
	$showonlineusers=getSetting('adminshowonlineusers');
	$shownotes=getSetting('donotes');
	$showquotes=getSetting('doquotes');
}

if (empty($isbanned)) $isbanned=0;

// CHECK BANNED
if(isset($REMOTE_ADDR)) {
	$banned=explode(',' , $misc['banned_ips']);
	foreach ($banned as $value) {
		if ($value==$REMOTE_ADDR || $isbanned==1) {
			header('Location: banned.php');
		}
	}
} else {
	showmsg('no_ip');
	exit();
}


if (isset($colorset)) {
	if(is_numeric($colorset)) {
		$colorset=$colorset;
	} else {
		$colorset=getSetting('default_colorset');
	}
} else {
	$colorset=getSetting('default_colorset');
}

if (empty($loggedin)) $loggedin=0;
if (empty($lastread)) $lastread=time()-(60*60*24);

////////////////////////////////////////////////// TEMPLATES
if (empty($templates)) $templates='';
if (empty($layout)) $layout=getSetting('default_templateset');

$templates.='common_message,header,footer,noterow,notetable,onlinetable,onlinerow,adminmenu,usermenu,privatemsgmenu,onlinedisplay,notes,guestmenu,stafflink,level_up,';
$templates.='global_fighter,expchanged,';
$tmplt=explode(',',$templates);
$tempname='';
$c=count($tmplt);
$n=0;
foreach ($tmplt as $val) { // form sql query
    $tempname .= " templatename='$val' AND templategroup='$layout'";
    $n++;
    if ($n<$c) $tempname .= ' OR';
}
$query=$dbr->query("SELECT templatename,templatevalue FROM arc_template WHERE$tempname");

if (isset($HTTP_GET_VARS['colorset'])) $colorset=validate_number($HTTP_GET_VARS['colorset']);
$stylequery=$dbr->query("SELECT * FROM arc_styleset WHERE stylesetid='$colorset'");
$styles=$dbr->getarray($stylequery);
$styles['webroot']=getSetting('webroot');
$styles['sitename']=getSetting('sitename');
$styles['version']=getwordbit('version');

while ($row=$dbr->getarray($query)) {
	$tname=$row['templatename'];
	$$tname=stripslashes($row['templatevalue']);
	foreach($styles as $n => $v) $$row['templatename']=str_replace("<$n>", $v, $$row['templatename']);
}

unset($query);

extract($styles, EXTR_SKIP);

$header=getTemplate('header');
$footer=getTemplate('footer');


//////////////////////////////////////////////// load info
if (isset($HTTP_GET_VARS['action'])) {
	$action=urlencode(strtolower($HTTP_GET_VARS['action']));
	$actn=avatardecode($HTTP_GET_VARS['action']);
} elseif (empty($action)) {
	$actn='News';
	$action=strtolower($actn);
} elseif (isset($HTTP_POST_VARS['action'])) {
	$action=urlencode(strtolower($HTTP_POST_VARS['action']));
	$actn=avatardecode($HTTP_POST_VARS['action']);
}

$feedback='';

// clean visitors
$logouttime=round(60 * getSetting('logouttime'));
if ($deletevisitors==1) {
	$dbr->query("DELETE FROM arc_visitor WHERE visitortimestamp < " .(time() - $logouttime));
}
if (empty($isforum)) $isforum=0;

// fix TextPads annoying syntax highlighting: "

// check for battle
if ($loggedin==1 && getSetting('rpg_flag')==1) {
	if ($battleid!=0 && empty($battlefile)) {
		$header=str_replace('<battlemsg>', "You are currently in a battle. <a href=\"$webroot/rpg/battle.php?id=$battleid\">Click here to fight it out</a>", $header);
	}
}


////////////////////////////////////////////////// WHOSE ONLINE
if ($showonlineusers==1 && getSetting('adminshowonlineusers')==1) {
	$onlineusers='';
	$result=$dbr->query("SELECT userid,displayname FROM arc_user WHERE last_active > " .(time() - $logouttime). " LIMIT 0, " .getSetting('maxusersonline'));
	$onlinecount=number_format(mysql_num_rows($result));
	$whilecount='1';
	if ($onlinecount>0) {
		while ($row=$dbr->getarray($result)) {
			$onlineusers .= "<a href=\"$webroot/user.php?action=profile&id=$row[userid]\">" .stripslashes($row['displayname']). '</a>';
			if ($whilecount < $onlinecount) {
				$onlineusers .= ', ';
			} else {
				$onlineusers .= '.';
			}
			$whilecount++;
		}
	}
} else {
	$onlineusers="";
}

$header=str_replace('<numusers>', number_format($misc['numusers']), $header);
$footer=str_replace('<numusers>', number_format($misc['numusers']), $footer);
$header=str_replace('<numposts>', number_format($misc['numposts']), $header);
$footer=str_replace('<numposts>', number_format($misc['numposts']), $footer);
$header=str_replace('<numtopics>', number_format($misc['numtopics']), $header);
$footer=str_replace('<numtopics>', number_format($misc['numtopics']), $footer);
$header=str_replace('<numnotes>', number_format($misc['numnotes']), $header);
$footer=str_replace('<numnotes>', number_format($misc['numnotes']), $footer);
$header=str_replace('<mostusersonline>', number_format($misc['mostusersonline']), $header);
$footer=str_replace('<mostusersonline>', number_format($misc['mostusersonline']), $footer);

if ($showonlineusers==1 && $adminshowonlineusers==1) {
	$no_users_online=getwordbit('nousersonline');
	if (!$onlineusers) $onlineusers="$smallfont$no_users_online$cs";

	$visitorcount=$dbr->result("SELECT COUNT(visitorid) FROM arc_visitor WHERE visitortimestamp > " .(time() - $logouttime));
	$header=str_replace('<visitorcount>', $visitorcount, $header);
	$footer=str_replace('<visitorcount>', $visitorcount, $footer);

	$onlinecount=$dbr->result("SELECT COUNT(userid) AS onlinecount FROM arc_user WHERE  last_active > " .(time() - $logouttime));
	$onlinedisplay=getTemplate('onlinedisplay');
	$onlinedisplay=str_replace('<users_online>', $onlineusers, $onlinedisplay);
	$onlinedisplay=str_replace('<onlinecount>', $onlinecount, $onlinedisplay);
	$onlinedisplay=str_replace('<visitorcount>', $visitorcount, $onlinedisplay);

	if ($onlinecount>$misc['mostusersonline'])
		$dbr->query("UPDATE arc_misc SET mostusersonline=$onlinecount");

	if ($showonlineusers==0 or $adminshowonlineusers==0)
		$onlinedisplay='';

	$header=str_replace('<onlinedisplay>', $onlinedisplay, $header);
	$header=str_replace('<onlinecount>', $onlinecount, $header);
	$footer=str_replace('<onlinedisplay>', $onlinedisplay, $footer);
	$footer=str_replace('<onlinecount>', $onlinecount, $footer);
}

////////////////////////////////////////////////// QUOTES
$admindoquotes=getSetting('doquotes');
if ($admindoquotes==1 && $showquotes==1) {
	$upper=$misc['maxquote'];
	$random=mt_rand(0, $upper);
	$quotesql=$dbr->query("SELECT MIN(quoteid),quote FROM arc_quote WHERE quoteid>=$random GROUP BY quoteid");
	$randomquote = $dbr->getarray($quotesql);
	$header=str_replace('<randomquote>', nl2br($randomquote['quote']), $header);
	$footer=str_replace('<randomquote>', nl2br($randomquote['quote']), $footer);
}

////////////////////////////////////////////////// NOTES
if (isset($notepage)) {
	$adminshownotes=0;
} else {
	$adminshownotes=getSetting('donotes');
}
if ($adminshownotes==1 and $shownotes==1 && empty($suppressnotes)) {
	$totalnotes=str_replace(',', '', $misc['numnotes']);
	$notesperpage=getSetting('notesperpage');
	$offset=$totalnotes-$notesperpage;
	if ($offset<0)
		$offset=0;

	if (getsetting('notesoldestfirst')==1) {
		$sort='ASC';
		$status=getwordbit('oldestnotemessage');
	} else {
		$sort='DESC';
		$status=getwordbit('newestnotemessage');
	}

	if (isset($HTTP_REFERER)) {
		$referer=$HTTP_REFERER;
	} else {
		$referer=$webroot;
	}
	if ($totalnotes>0) {
		$notequery=$dbr->query("SELECT arc_note.*, arc_user.displayname FROM arc_note LEFT JOIN arc_user ON arc_user.userid=arc_note.noteuserid ORDER BY arc_note.noteid $sort LIMIT $offset, $notesperpage");
		$ntimestamp=getSetting('note_timestamp');
		$notebox=str_replace("<status>", $status, str_replace('<notesperpage>', $notesperpage, getTemplate('notes')));
		$notebox=str_replace('<totalnotes>', number_format($totalnotes), $notebox);
		$notebox=str_replace('<offset>', number_format($offset), $notebox);
		$notebox=str_replace('<offsetplus>', number_format($totalnotes), $notebox);
		$ntemp='';
		$thenoterow=getTemplate('noterow');

		while ($this=$dbr->getarray($notequery)) {
			$nnoterow=str_replace('<username>', "<a href=\"$webroot/user.php?action=profile&id=$this[noteuserid]\">". dehtml($this['displayname']). "</a>", $thenoterow);
			$nnoterow=str_replace('<noteid>', $this['noteid'], $nnoterow);
			$nnoterow=str_replace('<timestamp>', formdate($this['ntimestamp'], $ntimestamp), $nnoterow);
			$nnoterow=str_replace('<content>', bbcode_replace(parseurl(htmlspecialchars(stripslashes($this['notemessage'])))), $nnoterow);
			$ntemp.=$nnoterow;
		}

		if ($loggedin==1) {
			$nbs=getSetting('noteboxsize');
			$formhtml="<form name=\"postnote\" action=\"$webroot/post.php?action=postnote\" method=\"post\"><input type=\"hidden\" name=\"saction\" value=\"$referer\" /><input type=\"text\" name=\"notemsg\" value=\"\" size=\"$nbs\" maxlength=\"150\" /><input type=\"submit\" value=\"" .getwordbit('submitnote'). "\" name=\"postnote\" /></form>";
		} else {
			$cpn=getwordbit('cantpostnote');
			$formhtml="$smallfont$cpn$cs";
		}

		$notebox=str_replace('<submitbutton>', $formhtml, $notebox);
		$notebox=str_replace('<noterow>', $ntemp, $notebox);
	} elseif ($totalnotes==0 && $loggedin==1) {
		$nonotesyet=getwordbit('nonotesyet');
		$notebox="<form name=\"postnote\" action=\"post.php?action=postnote\" method=\"post\"><input type=\"hidden\" name=\"saction\" value=\"$referer\" /><input type=\"text\" name=\"notemsg\" value=\"\" size=\"" .getSetting('noteboxsize'). "\" maxlength=\"150\" /><input type=\"submit\" value=\"" .getwordbit('submitnote'). "\" name=\"postnote\" /></form>$smallfont$nonotesyet $cs";
	} else {
		$notebox=$normalfont . getwordbit('nonotesyet') . $cn;
	}
	$header=str_replace('<notes>', $notebox, $header);
	$footer=str_replace('<notes>', $notebox, $footer);
}

////////////////////////////////////////////////// CHECK PM
if ($loggedin==1 && getSetting('dopms')==1) {
	$totalpms=$dbr->result("SELECT COUNT(privatemsgid) FROM arc_privatemsg WHERE recipientid=$userid");
	$numunread=$dbr->result("SELECT COUNT(privatemsgid) FROM arc_privatemsg WHERE recipientid=$userid AND isread=0");
	if ($numunread>0) {
		$newpms=getwordbit('newpms');
		$newpms=str_replace('<numunread>', $numunread, $newpms);
		$newpms=str_replace('<totalpms>', $totalpms, $newpms);
		$header=str_replace('<newpms>', $newpms, $header);
		$footer=str_replace('<newpms>', $newpms, $footer);
	} else {
		$newpms='';
	}
} else {
	$newpms='';
}

////////////////////////////////////////////////// LATEST USER
if (getSetting('showlatestuser')==1) {
	$thislink="<a href=\"$webroot/user.php?action=profile&id=$misc[lastuserid]\">" .stripslashes(htmlspecialchars($misc['lastusername'])). '</a>';
	$header=str_replace('<latestuser>', $thislink, $header);
	$footer=str_replace('<latestuser>', $thislink, $footer);
}

////////////////////////////////////////////////// LOGGED IN MENU
if ($loggedin==1) {
	$um=getTemplate('usermenu');
	$um=str_replace('<displayname>', $displayname, $um);
	$um=str_replace('<userid>', $userid, $um);
	$um=str_replace('<newpms>', $newpms, $um);
	$header=str_replace('<usermenu>', $um, $header);
	$footer=str_replace('<usermenu>', $um, $footer);
	if ($isadmin==1) {
		$am=str_replace('<userid>', $userid, getTemplate('adminmenu'));
		$header=str_replace('<adminmenu>', $am, $header);
		$header=str_replace('<adminmenu>', $am, $header);
	} else {
		$header=str_replace('<adminmenu>', '', $header);
		$footer=str_replace('<adminmenu>', '', $footer);
	}
	$ns=$dbr->result("SELECT COUNT(shrineid) AS numshrines FROM arc_shrine WHERE suserid=$userid");
	if ($ns>=1)
		$header=str_replace('<stafflink>', getTemplate('stafflink'), $header);
} else {
	$um=getTemplate('guestmenu');
	if (isset($HTTP_REFERER)) {
		$um=str_replace('<referer>', $HTTP_REFERER, $um);
	} else {
		$um=str_replace('<referer>', $webroot, $um);
	}
	$header=str_replace('<guestmenu>', $um, $header);
	$footer=str_replace('<guestmenu>', $um, $footer);
}

////////////////////////////////////////////////// GLOBAL FIGHTER
if  ($loggedin==1) {
	$gf=getTemplate('global_fighter');
	$gf=str_replace('<name>', "<a href=\"$webroot/user.php?action=profile&id=$userid\">".stripslashes($displayname).'</a>', $gf);
	$gf=str_replace('<userid>', $userid, $gf);
	$gf=str_replace('<avatar>', $avatar, $gf);
	$gf=str_replace('<rank>', $rank, $gf);
	if (getSetting('rpg_flag')==1) {
		$gf=str_replace('<hp>', $hp, $gf);
		$gf=str_replace('<mp>', $mp, $gf);
		$gf=str_replace('<curhp>', $curhp, $gf);
		$gf=str_replace('<curmp>', $curmp, $gf);
		$gf=str_replace('<sp>', number_format($sp), $gf);
		$gf=str_replace('<gold>', number_format($gold), $gf);
		$gf=str_replace('<exp>', number_format($exp), $gf);
		$gf=str_replace('<level>', $level, $gf);
		$gf=str_replace('<spritepath>', $spritepath, $gf);
	}
	$header=str_replace('<global_fighter>', $gf, $header);
	$footer=str_replace('<global_fighter>', $gf, $footer);
}

////////////////////////////////////////////////// FORUMS MENU
if ($isforum==1) {
	$header=str_replace('<forums_menu>', getTemplate('forums_menu'), $header);
	if (getSetting('showforumjump')==1) {
		$allforums=$dbr->query("SELECT forumid,forumname,forder,parentid,isforum FROM arc_forum WHERE private=0 AND open=1 AND isforum=1 ORDER BY forumname");
		$fjump="<select class=\"selects\" name=\"action\" onChange=\"window.location=('$webroot/'+this.options[this.selectedIndex].value);\">
				<option value=\"forums.php\" selected=\"selected\">Forum Jump</option>";
		while ($f=$dbr->getarray($allforums)) {
			$fjump.="<option value=\"topic.php?action=forum&fid=$f[forumid]\">".stripslashes($f['forumname']).'</option>';
		}
		$fjump.='</select>';
		$header=str_replace('<forumjump>', $fjump, $header);
		$footer=str_replace('<forumjump>', $fjump, $footer);
	}
}

if (getSetting('gzcompress')==1) ob_start('ob_gzhandler');

if (getSetting('site_is_on')==0 && $isadmin==0 && empty($userfile)) {
	doHeader("$sitename is currently offline");
	showmsg("This site has been disabled by the webmaster. Please try again later.", 1);
	footer(1);
}

if (getSetting('addnocacheheaders')==1) {
	header("HTTP/1.0 200 OK");
	header("HTTP/1.1 200 OK");
	header("Content-type: text/html");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
}

?>