<?php

$templates='pagebit,pagebitfull,pagebit_header,pagebit_footer,globalpoll,latest_articles,';
$templates.='globalpoll_row,latest_articlerow,pollvoteform,shrine,shrinerow,';
$wordbits='front_page_title,shrine_noaccess,nousersonline,noguestsonline,readcomments,postcomment,';
$settings='shrinesorder,shrine_timestamp,pagebit_timestamp,shrine_limit,webroot,latest_articles_limit,guestscanread,showpoll,';

include('./lib/config.php');

// latest articles
$latest_articles=getTemplate('latest_articles');
$latest_articlerow=getTemplate('latest_articlerow');
$temp='';
$lrquery=$dbr->query("SELECT pagebitid,ptitle,pdate,page FROM arc_pagebit WHERE porder<>0 ORDER BY pagebitid DESC LIMIT 0, ".getSetting('latest_articles_limit'));
while ($lr=$dbr->getarray($lrquery)) {
	$row=$latest_articlerow;
	$row=str_replace('<pagebitid>', $lr['pagebitid'], $row);
	$row=str_replace('<page>', $lr['page'], $row);
	$row=str_replace('<ptitle>', stripslashes($lr['ptitle']), $row);
	$row=str_replace('<pdate>', formdate($lr['pdate'], getSetting('pagebit_timestamp')), $row);
	$temp.=$row;
}
$latest_articles=str_replace('<number_articles>', getSetting('latest_articles_limit'), $latest_articles);
$latest_articles=str_replace('<latest_articlerows>', $temp, $latest_articles);
$header=str_replace('<latest>', $latest_articles, $header);
$footer=str_replace('<latest>', $latest_articles, $footer);


// POLL
if (getSetting('showpoll')==1) {
	$numpolls=$misc['numpolls'];
	if ($numpolls>0) {
		$polls=$dbr->query("SELECT arc_poll.pollid,arc_poll.question,arc_poll.pvotes,arc_topic.topicid FROM arc_poll,arc_topic WHERE arc_topic.pollid=arc_poll.pollid ORDER BY pollid DESC LIMIT 0,1");
		$pinfo=$dbr->getarray($polls);
		$pollid=$pinfo['pollid'];
		$totalvotes=$pinfo['pvotes'];
		$pollquery=$dbr->query("SELECT pollaid, answer, votes, users FROM arc_polla WHERE pollid=$pollid");
		$topicid=$pinfo['topicid'];
		$pollhtml="<form action=\"post.php?action=readcomments&ident=topic&id=$topicid&vote=$pollid\" method=\"post\">";
		$pollhtml.=getTemplate('globalpoll');
		$pollhtml=str_replace('<question>', stripslashes($pinfo['question']), $pollhtml);
		$otpr=getTemplate('globalpoll_row');
		$temp='';
		while ($polls=$dbr->getarray($pollquery)) {
			$voters=explode(',', $polls['users']);
			foreach ($voters as $thisid) $uid_{$thisid}=$thisid;
			$tpr=str_replace('<answer>', stripslashes($polls['answer']), $otpr);
			$tpr=str_replace('<votesnum>', number_format($polls['votes']), $tpr);
			if ($polls['votes']>0) {
				$votepercent=round( ($polls['votes'] / $totalvotes) * 100 );
				$tpr=str_replace('<votepercent>', $votepercent, $tpr);
				$tpr=str_replace('<leftover>', (100 - $votepercent), $tpr);
			} else {
				$tpr=str_replace('<votepercent>', $polls['votes'], $tpr);
				$tpr=str_replace('<leftover>', 100, $tpr);
			}
			if ($loggedin==1 && empty($uid_{$userid}))
				$tpr=str_replace('<votebutton>', "<input type=\"radio\" name=\"pollvote\" value=\"$polls[pollaid]\" />", $tpr);
			$tpr=altbgcolor($tpr);
			$temp.=$tpr;
		}
		$pollhtml=str_replace('<totalvotes>', $totalvotes, $pollhtml);
		$pollhtml=str_replace('<globalpoll_row>', $temp, $pollhtml);
		if ($loggedin==1 && empty($uid_{$userid})) $pollhtml.=getTemplate('pollvoteform');
		$pollhtml.='</form>';
		$header=str_replace('<poll>', $pollhtml, $header);
		$footer=str_replace('<poll>', $pollhtml, $footer);
	}
}

if (isset($HTTP_GET_VARS['id'])) {
	$idtoo="pagebitid=$HTTP_GET_VARS[id]";
} else {
	$idtoo="page='$action'";
}

if ($idtoo!="")
	$skey=$dbr->result("SELECT shrinekey FROM arc_pagebit WHERE $idtoo");

if ($skey!="") {
	$isshrine=1;
	$old=$dbr->query("SELECT shrineid,shits,saccesslvl,header,footer,pagebit FROM arc_shrine WHERE shrinekey='$skey' LIMIT 0,1");
	$i=$dbr->getarray($old);
	$new=$i['shits']+1;

	if (is_numeric($i['shrineid']))
		$dbr->query("UPDATE arc_shrine SET shits=$new WHERE shrineid=$i[shrineid]");

	if ($i['header']!="") {
		$shrineheader=$i['header'];
	} else {
		$shrineheader=$header;
	}
	if ($i['footer']!="") {
		$shrinefooter=$i['footer'];
	} else {
		$shrinefooter=$footer;
	}
	$sheader=str_replace('<shrinekey>', $skey, $shrineheader);
	$sheader=str_replace('<views>', $new, $sheader);
	$sfooter=str_replace('<views>', $new, $shrinefooter);
	$sfooter=str_replace('<shrinekey>', $skey, $sfooter);
	if ($i['saccesslvl']>$level) {
		$halt=1;
	} else {
		$halt=0;
	}
} else {
	$isshrine=0;
}

if ($isshrine==1 && $halt==0) {
	$header=$sheader;
	$footer=$sfooter;
}

if ($action!='news') {
	if (empty($HTTP_GET_VARS['id']) && empty($HTTP_GET_VARS['code']))
		doHeader("$sitename: $actn");
} else {
	if (empty($HTTP_GET_VARS['id']) && empty($HTTP_GET_VARS['code']))
		doHeader(str_replace('<sitename>', $sitename, getwordbit('front_page_title')));
}

if (empty($halt)) $halt=0;
if ($halt==1 && $isadmin==0) {
	doHeader("$sitename: Access denied");
	showmsg('shrine_noaccess');
	footer(1);
}

if ($action=='shrines') { //////////////////////////////////////// SHRINES
	$offset=getoffset();
	$s=$dbr->query("SELECT * FROM arc_shrine ORDER BY '" .getSetting('shrinesorder'). "' LIMIT $offset, ". getSetting('shrine_limit'));
	$numrows=$dbr->result("SELECT COUNT(shrineid) as sid FROM arc_shrine");

	$shrine_html=getTemplate('shrine');
	$temp='';

	while ($arr=$dbr->getarray($s)) {
		$arow=str_replace('<shrinekey>', dbPrep($arr['shrinekey']), getTemplate('shrinerow'));
		$row=str_replace('<lastmodified>', formdate($arr['lastmodified'], getSetting('shrine_timestamp')), $arow);
		$row=str_replace('<suserid>', $arr['suserid'], $row);
		$row=str_replace('<susername>', $arr['susername'], $row);
		$row=str_replace('<stitle>', $arr['stitle'], $row);
		$row=str_replace('<summary>', $arr['summary'], $row);
		$row=str_replace('<saccesslvl>', $arr['saccesslvl'], $row);
		$row=str_replace('<scomments>', $arr['scomments'], $row);
		$temp.=str_replace('<shits>', $arr['shits'], $row);
	}

	$shrine_html=str_replace('<pagelinks>', pagelinks(getSetting('shrine_limit'), $numrows, $offset, 'Shrine'), $shrine_html);
	echo str_replace('<shrinerow>', $temp, $shrine_html);
} else { //////////////////////////////////////// NEWS
	if (isset($HTTP_GET_VARS['code'])) {
		$porder="AND porder=0";
	} else {
		$porder="AND porder <> 0";
	}
	$pagebits=$dbr->query("SELECT arc_pagebit.*,arc_user.displayname,arc_user.avatar,arc_user.usertext,arc_user.rank FROM arc_pagebit,arc_user WHERE arc_user.userid=arc_pagebit.puserid AND $idtoo $porder ORDER BY porder,pdate DESC");
	$ptemp='';

	if (empty($i['pagebit'])) $i['pagebit']='';

	if ($isshrine==1 && $i['pagebit']!="") {
		$thispage='<pagebitrow>';
	} else {
		$thispage=getTemplate('pagebitfull');
	}

	if ($isshrine==1 && $i['pagebit']!="") {
		$thispagebit=$i['pagebit'];
	} else {
		$thispagebit=getTemplate('pagebit');
	}

	while ($array=$dbr->getarray($pagebits)) {

		if (isset($HTTP_GET_VARS['code'])) {

			$str=stripslashes($array['pcontent']);
			eval($str);
		} else {

			if (isset($HTTP_GET_VARS['id'])) {
				if ($array['convertnewline']==0) {
					echo stripslashes($array['pcontent']);
				} else {
					echo stripslashes(nl2br($array['pcontent']));
				}

			} else {
				$array['pcontent'] = stripslashes(bbcode_replace($array['pcontent']));
				$npagebit=str_replace('<pagebit_title>', stripslashes($array['ptitle']), $thispagebit);
				if ($array['convertnewline']==0) {
					$npagebit=str_replace('<pagebit_content>', $array['pcontent'], $npagebit);
				} else {
					$npagebit=str_replace('<pagebit_content>', nl2br($array['pcontent']), $npagebit);
				}

				$rc=getwordbit('readcomments');
				$rc=str_replace('<id>', $array['pagebitid'], $rc);

				$npagebit=str_replace('<pdate>', formdate($array['pdate'], getSetting('pagebit_timestamp')), $npagebit);
				$npagebit=str_replace('<numreplies>', number_format($array['numcomments']), $npagebit);
				$npagebit=str_replace('<readcomments>', $rc, $npagebit);

				$npagebit=str_replace('<username>', stripslashes(htmlspecialchars($array['displayname'])), $npagebit);
				$npagebit=str_replace('<avatar>', stripslashes(htmlspecialchars($array['avatar'])), $npagebit);
				$npagebit=str_replace('<usertext>', stripslashes($array['usertext']), $npagebit);
				$npagebit=str_replace('<userid>', stripslashes(htmlspecialchars($array['puserid'])), $npagebit);

				foreach($styles as $name => $value)
				$npagebit=str_replace("<$name>", $value, $npagebit);

				$pc=str_replace('<id>', $array['pagebitid'], getwordbit('postcomment'));
				$pc=str_replace('<ident>', 'pagebit', $pc);

				if ($loggedin==1)
					$npagebit=str_replace('<postcomment>', $pc, $npagebit);

				$ptemp.=$npagebit;
			}
		}
	}
	if (mysql_num_rows($pagebits)<1) {
		showmsg("There are no pagebits to display on this page.", 1);
	} else {
		echo str_replace('<pagebitrow>', $ptemp, $thispage);
	}
}

if ($isshrine==1) $footer=$sfooter;
if (empty($HTTP_GET_VARS['id']) && empty($HTTP_GET_VARS['code']))
	footer();


?>