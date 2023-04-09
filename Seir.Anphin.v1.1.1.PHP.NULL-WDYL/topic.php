<?php

$templates='forumtoolbar,forumheader,forumfooter,forumrow,topicheader,topicrow,topicfooter,forum,topic,itopic,ftopic,latestposts,';
$templates.='forums_menu,latestpostrow,itopicrow,ftopicrow,';
$wordbits='newtopic,forumhomelink,nopostsinforum,nomod,topicclosed,nolastposter,notloggedin,newtopictitle,topicnamedefault,new_posts_icon,old_posts_icon,';
$wordbits.='topictitleunchanged,newtopic_emptyfields,newtopic,forumhomelink,topic_name,topic_desc,topic_content,normaliconpath,hoticonpath,closediconpath,';
$wordbits.='topic_imgname,topic_image,topic_imgdesc,topic_you,topicnamedefault,topic_submit,topic_reset,privateforum_noaccess,old_posts_icon,';
$wordbits.='new_posts_icon,closediconpath,normaliconpath,hoticonpath,passwordforum_noaccess,topic_poll,topic_pinned,forum_notopics,';
$wordbits.='topic_filename,topic_filepath,newtopic_icon,topic_filedesc,makepoll,confirm_topic_delete,guests_not_allowed_in_forum,';
$settings='topic_limit,postextras,max_image_size,post_limit,max_topic_chars,inputwidth,number_latest_posts,latest_post_timestamp,topicoldestfirst,';
$settings.='guestscanviewforums,show_latest_posts,replies_for_hot_topic,topicoldestfirst,topic_limit,post_limit,show_total_stats,postextras,';
$settings.='max_topic_chars,inputwidth,max_poll_options,max_file_size,max_image_size,mods_see_private_forums,max_file_size,max_image_size,';
$isforum=1;

include('./lib/config.php');

////////////////////////////////////////////////// LATEST POSTS
if ($loggedin==1 || getSetting('guestscanviewforums')==1) {
	if (getSetting('show_latest_posts')==1) {
		$latestpost=$dbr->query("SELECT topicid,
							   topicdate,
							   tlastposter,
							   tlastposterid,
							   ttitle
							  FROM  arc_topic
							  ORDER BY topicdate DESC LIMIT 0," .getSetting('number_latest_posts'));

		$lp_html=str_replace('<number_latest_posts>', getSetting('number_latest_posts'), getTemplate('latestposts'));
		$lp_temp='';
		$lprow=getTemplate('latestpostrow');
		while ($lp=$dbr->getarray($latestpost)) {
			$lrow=$lprow;
			$lrow=str_replace('<ttitle>', htmlspecialchars(unfilter(stripslashes($lp['ttitle']))), $lrow);
			$lrow=str_replace('<ident>', 'topic', $lrow);
			if (empty($lastread)) $lastread=time();
			if ($lastread<$lp['topicdate']) $lrow=str_replace('<newposts>', getwordbit('new_posts_icon'), $lrow);
			$lrow=str_replace('<postuserid>', $lp['tlastposterid'], $lrow);
			$lrow=str_replace('<postusername>', format_text($lp['tlastposter']), $lrow);
			$lrow=str_replace('<postdate>', formdate($lp['topicdate'], getSetting('latest_post_timestamp')), $lrow);
			$lrow=str_replace('<topicid>', $lp['topicid'], $lrow);
			$lp_temp.=$lrow;
		}
		$lp_html=str_replace('<latestpostrow>', $lp_temp, $lp_html);
		$header=str_replace('<latest>', $lp_html, $header);
		$footer=str_replace('<latest>', $lp_html, $footer);
	}
}

// thread control options
if ((isset($HTTP_POST_VARS['movewhere']) || $action=='move') && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Choose forum for multiple topic move");
	$thesetopics='';
	$tpc=$HTTP_POST_VARS['tpc'];

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b>
		  <input type=\"checkbox\" name=\"tpc[]\" value=\"$val\" checked=\"checked\" /><br>\n";
	}
	$thesetopics .= "<br><select name=\"forum\">";
	$forums=$dbr->query("SELECT forumid,forumname FROM arc_forum WHERE isforum=1 ORDER BY forumid");
    while ($finfo=$dbr->getarray($forums)) {
    	$thesetopics .= "<option value=\"$finfo[forumid]\">$finfo[forumid]: " .stripslashes($finfo['forumname']). "<br>\n";
    }
	showmsg("<form action=\"topic.php\" method=\"post\">Please choose where to move the following topics:<br>$thesetopics</select><br><br><input type=\"submit\" name=\"movetopics\" value=\"Yes, move these topics\" /></form>", 1);
}

if (isset($HTTP_POST_VARS['movetopics']) && isset($HTTP_POST_VARS['tpc']) && isset($HTTP_POST_VARS['forum']) && $loggedin==1) {

	$tpc=$HTTP_POST_VARS['tpc'];
	$forum=$HTTP_POST_VARS['forum'];

	doHeader("$sitename: Topics moved");
	$thesetopics='';
	$fname=$dbr->result("SELECT forumname FROM arc_forum WHERE forumid='$forum'");
	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b> has been moved to forum <b>" .stripslashes($fname). "</b>.<br>";
		$dbr->query("UPDATE arc_topic SET tforumid=$forum WHERE topicid=$val");
	}
	showmsg($thesetopics, 1);
}

if ((isset($closethese) || $action=='close') && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Choose forum for multiple topic close");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b>
		  <input type=\"checkbox\" name=\"tpc[]\" value=\"$val\" checked=\"checked\" /><br>\n";
	}
	showmsg("<form action=\"topic.php\" method=\"post\">Please choose which topics to close:<br>$thesetopics<br><br><input type=\"submit\" name=\"closetopics\" value=\"Yes, close these topics\" /></form>", 1);
}

if (isset($HTTP_POST_VARS['closetopics']) && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Topics closed");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b> has been closed.<br>";
		$dbr->query("UPDATE arc_topic SET isclosed=1 WHERE topicid=$val");
	}
	showmsg($thesetopics, 1);
}

if ((isset($HTTP_POST_VARS['openthese']) || $action=='open') && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Opening one or more topics");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b>
		  <input type=\"checkbox\" name=\"tpc[]\" value=\"$val\" checked=\"checked\" /><br>\n";
	}
	showmsg("<form action=\"topic.php\" method=\"post\">Please choose which topics to open:<br>$thesetopics<br><br><input type=\"submit\" name=\"opentopics\" value=\"Yes, open these topics\" /></form>", 1);
}

if (isset($HTTP_POST_VARS['opentopics']) && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: One or more topics have been opened");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b> has been opened.<br>";
		$dbr->query("UPDATE arc_topic SET isclosed=0 WHERE topicid=$val");
	}
	showmsg($thesetopics, 1);
}

if ((isset($HTTP_POST_VARS['pinthese']) || $action=='pin') && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Pin one or more topics");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b>
		  <input type=\"checkbox\" name=\"tpc[]\" value=\"$val\" checked=\"checked\" /><br>\n";
	}
	showmsg("<form action=\"topic.php\" method=\"post\">Please choose which topics to pin up:<br>$thesetopics<br><input type=\"submit\" name=\"pintopics\" value=\"Yes, pin these topics\" /></form>", 1);
}

if (isset($HTTP_POST_VARS['pintopics']) && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Topics pinned");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b> has been pinned.<br>";
		$dbr->query("UPDATE arc_topic SET ispinned=1 WHERE topicid=$val");
	}
	showmsg($thesetopics, 1);
}

if ((isset($HTTP_POST_VARS['unpinthese']) || $action=='unpin') && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Unpinning one or more topics");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b>
		  <input type=\"checkbox\" name=\"tpc[]\" value=\"$val\" checked=\"checked\" /><br>\n";
	}
	showmsg("<form action=\"topic.php\" method=\"post\"><br>Please choose which topics to unpin:<br>$thesetopics<br><input type=\"submit\" name=\"unpintopics\" value=\"Yes, unpin these topics\" /></form>", 1);
}

if (isset($HTTP_POST_VARS['unpintopics']) && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Topics unpinned");

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics='';

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$thesetopics .= "<b>" .stripslashes($topicname). "</b> has been unpinned.<br>";
		$dbr->query("UPDATE arc_topic SET ispinned=0 WHERE topicid=$val");
	}
	showmsg($thesetopics, 1);
}

if ((isset($HTTP_POST_VARS['deletetopics']) || $action=='delete') && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Confirm multiple topic delete");
	echo "<form action=\"topic.php\" method=\"post\">" .getwordbit('confirm_topic_delete');

	$tpc=$HTTP_POST_VARS['tpc'];
	$thesetopics="";

	foreach($tpc as $zed) {
		$tname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$zed LIMIT 0,1");
		$thesetopics .= "<b>" .stripslashes($tname). "</b>";
		if ($tname!='') $thesetopics .="<input type=\"checkbox\" name=\"tpc[]\" value=\"$zed\" checked=\"checked\" /><br />\n";
	}
	showmsg("$thesetopics<input type=\"submit\" name=\"exterminatetopics\" value=\"Yes, Delete these topics\" /></form>", 1);
}

if (isset($HTTP_POST_VARS['exterminatetopics']) && isset($HTTP_POST_VARS['tpc']) && $loggedin==1) {
	doHeader("$sitename: Confirm multiple topic delete");

	$tpc=$HTTP_POST_VARS['tpc'];
	$htm="Topic(s):<br>";

	while (list($key, $val)=each($tpc)) {
		$topicname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$val");
		$htm.="Topic <b>". stripslashes($topicname). "</b> has been deleted.<br>";
		$htm.="Deleting any child posts automatically.<br>";
		$dbr->query("DELETE FROM arc_topic WHERE topicid=$val");
		$dbr->query("DELETE FROM arc_post WHERE parentid=$val");
	}
	$htm.="have been deleted.<br>\n";
	showmsg($htm, 1);
}

if ($action=='forum') {
	if (isset($HTTP_GET_VARS['fid'])) {
		$fid=$HTTP_GET_VARS['fid'];
	} else {
		$fid=1;
	}

	$toolbar=getTemplate('forumtoolbar');
	$normaliconpath=getwordbit('normaliconpath');
	$hoticonpath=getwordbit('hoticonpath');
	$closediconpath=getwordbit('closediconpath');
	$hottopicreplies=getSetting('replies_for_hot_topic');
	$newpostsicon=getwordbit('new_posts_icon');
	$oldpostsicon=getwordbit('old_posts_icon');
	$allowedin=0;
	$offset=getoffset();


	$fquery=$dbr->query("SELECT * FROM arc_forum WHERE forumid=$fid");
	$foruminfo=$dbr->getarray($fquery);

	if (!is_numeric($foruminfo['forumid'])) {
		doHeader("$sitename: Error: Invalid ForumID Specified");
		showmsg('invalid_forum_id');
		footer(1);
	}

	doHeader("$sitename: ".stripslashes($foruminfo['forumname']));

	if ($foruminfo['private']==1) {
		$seeprivate=forumPermStr(0, 1);
	} else {
		$seeprivate=1;
	}

	if (isset($submitfpass) && isset($forumpass)) {
		if ($forumpass===$foruminfo['fpassword']) {
			$cookiename='forum' .$foruminfo['forumid'];
			setcookie($cookiename, md5($foruminfo['fpassword']), time()+3600, '/');
			$allowedin=1;
		}
	}

	if ($foruminfo['fpassword']!='' && $allowedin==0) {
		$cookiename='forum' .$foruminfo['forumid'];
		if (isset($HTTP_COOKIE_VARS[$cookiename])) {
			if ($HTTP_COOKIE_VARS[$cookiename]==md5($foruminfo['fpassword'])) {
				$allowedin=1;
			} else {
				$allowedin=0;
			}
		}
	} else {
		$allowedin=1;
	}

	if ($loggedin==0 && getSetting('guestscanviewforums')==0) {
		doHeader("$sitename: ".getwordbit('guests_not_allowed_in_forum'));
		showmsg('guests_not_allowed_in_forum');
		footer(1);
	}

	if ($allowedin!=1 || $seeprivate!=1) {
		doHeader("$sitename: ".stripslashes($foruminfo['forumname']));
		if ($allowedin==0) showmsg(str_replace('<fid>', $fid, getwordbit('passwordforum_noaccess')), 1);
		if ($seeprivate==0) showmsg(str_replace('<fid>', $fid, getwordbit('privateforum_noaccess')), 1);
		footer(1);
	}

	$catname=$dbr->result("SELECT forumname FROM arc_forum WHERE forumid=$foruminfo[parentid]");
	$parentsparent=$dbr->result("SELECT parentid FROM arc_forum WHERE forumid=$foruminfo[parentid]");
	if ($parentsparent>0)
		$catlink="<a href=\"$webroot/topic.php?action=forum&fid=$foruminfo[parentid]\">$catname</a>";
	else
		$catlink="<a href=\"$webroot/forums.php?catid=$foruminfo[parentid]\">$catname</a>";

	$topics=$foruminfo['topiccount'];
	$posts=$foruminfo['postcount'];
	$newtopic=str_replace('<newtopicpath>', $newtopicpath, getwordbit('newtopic'));
	$newtopiclink="<a href=\"topic.php?action=newtopic&fid=$foruminfo[forumid]\">$newtopic</a>";
	$fhl=getwordbit('forumhomelink');
	$fhl=str_replace('<sitename>', $sitename, $fhl);
	$forumhome="<a href=\"forums.php\">$fhl</a>";
	$toolbar=str_replace('<forumhome>', $forumhome, $toolbar);
	$toolbar=str_replace('<catlink>', $catlink, $toolbar);
	$toolbar=str_replace('<fid>', $foruminfo['forumid'], $toolbar);
	$toolbar=str_replace('<forumname>', stripslashes($foruminfo['forumname']), $toolbar);
	$toolbar=str_replace('<topics>', $topics, $toolbar);
	$toolbar=str_replace('<posts>', $posts, $toolbar);
	$toolbar=str_replace('<newtopiclink>', $newtopiclink, $toolbar);
	echo $toolbar;

	$numforums=$dbr->result("SELECT COUNT(forumid) AS numf FROM arc_forum WHERE forder<>0 AND parentid=$fid AND isforum=1 ORDER BY forder");
	if ($numforums>0) {
		$f_html=getTemplate('forum');

		$query = "SELECT arc_forum.*, arc_topic.ttitle,arc_user.displayname
				  FROM arc_forum
				  LEFT JOIN arc_topic
				  ON arc_forum.lasttopicid=arc_topic.topicid
				  LEFT JOIN arc_user
				  ON arc_forum.lastposterid=arc_user.userid
				  WHERE arc_forum.forder<>0 AND arc_forum.parentid=$fid AND arc_forum.isforum=1
				  ORDER BY arc_forum.forder";

		$ubbsucks=$dbr->query($query);
		$fr=getTemplate('forumrow');
		$forumrows='';
		while ($forumarray=$dbr->getarray($ubbsucks)) {
			if (isset($forumarray['lasttopicid'])) {
				if ($forumarray['lasttopicid']=='' || $forumarray['lasttopicid']==0) {
					$lasttopic=getwordbit('nopostsinforum');
				}

				if($forumarray['lasttopicid']!="" && $forumarray['lasttopicid']!=0) {
					$title=format_text($forumarray['ttitle']);
					$lasttopic="<a href=\"post.php?id=$forumarray[lasttopicid]&action=readcomments&ident=topic\">" .stripslashes($title). "</a>";
				}
			} else {
				$lasttopic='';
			}

			if (isset($forumarray['lastposterid'])) {
				if ($forumarray['lastposterid']==0) $forumarray['lastposterid']=="";
			}

			if (empty($forumarray['lastposterid'])) {
				$lastposter='';
			} else {
				if ($forumarray['lastposterid']==0) {
					$lastposter='';
				}

				$name=format_text($forumarray['displayname']);
				$lastposter="<a href=\"user.php?action=profile&id=$forumarray[lastposterid]\">$name</a>";
			}
			if ($forumarray['modusername']!='' and $forumarray['modid']!='') {
				$moderator="<a href=\"user.php?action=profile&id=$forumarray[modid]\">" .stripslashes($forumarray['modusername']). "</a>";
			} else {
				$moderator=getwordbit('nomod');
			}

			$topiccount=$forumarray['topiccount'];

			if ($forumarray['linkurl']!="") {
				$forumarray['forumname']="<a href=\"$forumarray[linkurl]\">$forumarray[forumname]</a>";
			} else {
				$forumarray['forumname']="<a href=\"topic.php?action=forum&fid=$forumarray[forumid]\">$forumarray[forumname]</a>";
			}
			$nforumrow=str_replace('<forumname>', stripslashes($forumarray['forumname']), $fr);
			$nforumrow=str_replace('<moderator>', $moderator, $nforumrow);
			$nforumrow=str_replace('<fid>', $forumarray['forumid'], $nforumrow);
			$nforumrow=str_replace('<lasttopic>', $lasttopic, $nforumrow);
			$nforumrow=str_replace('<lasttopicid>', $forumarray['lasttopicid'], $nforumrow);
			$nforumrow=str_replace('<lastposter>', $lastposter, $nforumrow);
			$nforumrow=str_replace('<lastposttime>', $forumarray['lastposttime'], $nforumrow);
			$nforumrow=str_replace('<description>', format_text($forumarray['description']), $nforumrow);
			$nforumrow=str_replace('<forum_topics>', $topiccount, $nforumrow);
			$nforumrow=str_replace('<forum_posts>', $forumarray['postcount'], $nforumrow);
			if (empty($lastread)) $lastread=time();
			if ($lastread<$forumarray['lastposttime']) {
				$nforumrow=str_replace('<newposts>', getwordbit('new_posts_icon'), $nforumrow);
			} else {
				$nforumrow=str_replace('<newposts>', getwordbit('old_posts_icon'), $nforumrow);
			}

			$forumrows.=$nforumrow;
		}
		$f_html=str_replace('<forumrow>', $forumrows, $f_html);
		echo $f_html;
	}

	if ($isadmin==1 || $foruminfo['modid']==$userid)
		echo '<form action="topic.php" method="post">';

	$topicoldestfirst=getsetting('topicoldestfirst');
	if ($topicoldestfirst=='1')
		$topicoldestfirst='ASC';
	elseif ($topicoldestfirst=='0')
		$topicoldestfirst='DESC';

	$numrows=$dbr->result("SELECT COUNT(topicid) FROM arc_topic WHERE tforumid=$fid");
	$topics=$dbr->query("SELECT
						  arc_topic.topicid,
						  arc_topic.ttitle,
						  arc_topic.tdescription,
						  arc_topic.treplies,
						  arc_topic.topichits,
						  arc_topic.tuserid,
						  arc_topic.tusername,
						  arc_topic.topicopen,
						  arc_topic.topicdate,
						  arc_topic.tlastposterid,
						  arc_topic.tlastposter,
						  arc_topic.isclosed,
						  arc_topic.ispinned,
						  arc_topic.pollid,
						  arc_topic.topicicon,
						  arc_user.displayname as starter
						 FROM arc_topic,arc_user
						 WHERE arc_topic.tforumid=$fid
						 AND arc_user.userid=arc_topic.tuserid
						 ORDER BY arc_topic.ispinned DESC,arc_topic.topicdate $topicoldestfirst
						 LIMIT $offset," .getsetting('topic_limit'));

	if (mysql_num_rows($topics)<1) {
		showmsg('forum_notopics');
		footer(1);
	}

	if ($foruminfo['forumtype']==1) {
		$topicrow=getTemplate('topicrow');
	} elseif ($foruminfo['forumtype']==2) {
		$topicrow=getTemplate('itopicrow');
	} elseif ($foruminfo['forumtype']==3) {
		$topicrow=getTemplate('ftopicrow');
	}

	if ($foruminfo['forumtype']==1) {
		$t_html=getTemplate('topic');
	} elseif ($foruminfo['forumtype']==2) {
		$t_html=getTemplate('itopic');
	} elseif ($foruminfo['forumtype']==3) {
		$t_html=getTemplate('ftopic');
	}

	$limit=getSetting('post_limit');
	$trow='';
	$atopicrow=getTemplate('topicrow');
	while ($x=$dbr->getarray($topics)) {

		$nav='';
		if (($x['treplies']+1)>$limit) {
			$nav.='(Pages: ';
			$pages=ceil(($x['treplies']+1)/$limit);
			for ($i=1;$i<=$pages;$i++) {
				$newoffset=$limit*($i-1);
				if ($pages>1 && $i!=1) $nav .="<a href=\"post.php?action=readcomments&id=$x[topicid]&ident=topic&offset=$newoffset\">$i</a> \n";
			}
			$nav=trim($nav).')';
		}

		$ntopicrow=str_replace('<pagelinks>', avatardecode($nav), $atopicrow);

		if (($isadmin==1 || $foruminfo['modid']==$userid) && $loggedin==1) $ntopicrow=str_replace('<selectbox>', "<input type=\"checkbox\" name=\"tpc[]\" value=\"$x[topicid]\" />", $ntopicrow);

		if (empty($lastread)) $lastread=time();
		if ($lastread<$x['topicdate']) {
			$ntopicrow=str_replace('<newposts>', $newpostsicon, $ntopicrow);
		} else {
			$ntopicrow=str_replace('<newposts>', $oldpostsicon, $ntopicrow);
		}


		if ($x['treplies']>=$hottopicreplies && $x['isclosed']==0) {
			$ntopicrow=str_replace('<topicicon>', "<img src=\"$hoticonpath\" border=\"0\" />", $ntopicrow);
		} elseif ($x['isclosed']==1) {
			$ntopicrow=str_replace('<topicicon>', "<img src=\"$closediconpath\" border=\"0\" />", $ntopicrow);
		} elseif ($x['isclosed']==0) {
			$ntopicrow=str_replace('<topicicon>', "<img src=\"$normaliconpath\" border=\"0\" />", $ntopicrow);
		}

		if ($x['pollid']!=0) $ntopicrow=str_replace('<topic_poll>', getwordbit('topic_poll'), $ntopicrow);
		if ($x['isclosed']==1) $ntopicrow=str_replace('<topic_closed>', getwordbit('topic_closed'), $ntopicrow);
		if ($x['ispinned']==1) $ntopicrow=str_replace('<topic_pinned>', getwordbit('topic_pinned'), $ntopicrow);

		$ntopicrow=str_replace('<topic_starter>', stripslashes(htmlspecialchars($x['starter'])), $ntopicrow);
		$ntopicrow=str_replace('<topic_starterid>', $x['tuserid'], $ntopicrow);
		$ntopicrow=str_replace('<topicname>', stripslashes($x['ttitle']), $ntopicrow);
		$ntopicrow=str_replace('<topicid>', $x['topicid'], $ntopicrow);
		$ntopicrow=str_replace('<description>', format_text($x['tdescription']), $ntopicrow);
		$ntopicrow=str_replace('<replies>', $x['treplies'], $ntopicrow);
		$ntopicrow=str_replace('<hits>', $x['topichits'], $ntopicrow);
		$ntopicrow=str_replace('<last_poster>', stripslashes(htmlspecialchars($x['tlastposter'])), $ntopicrow);
		$ntopicrow=str_replace('<last_posterid>', $x['tlastposterid'], $ntopicrow);
		$ntopicrow=str_replace('<threadicon>', "<img src=\"$x[topicicon]\" border=\"0\" />", $ntopicrow);
		$trow.=$ntopicrow;
	}

	$t_html=str_replace('<pagelinks>', pagelinks(getSetting('topic_limit'),$numrows,$offset,'Topic'), $t_html);
	echo str_replace('<topicrow>', $trow, $t_html);

	if (($isadmin==1 || $foruminfo['modid']==$userid) && $loggedin==1)
		echo '
		      <input type="submit" name="movewhere" value="Move" />
		      <input type="submit" name="openthese" value="Open" />
		      <input type="submit" name="closethese" value="Close" />
		      <input type="submit" name="pinthese" value="Pin" />
		      <input type="submit" name="unpinthese" value="Unpin" />
	          <input type="submit" name="deletetopics" value="Delete" /></form>';
}

if ($action=='newtopic') {
	if ($loggedin==0) {
		doHeader($sitename);
		showmsg('notloggedin');
	} elseif($loggedin==1) {
		if (isset($HTTP_GET_VARS['fid'])) {
			$fid=htmlspecialchars($HTTP_GET_VARS['fid']);
		} else {
			$fid=1;
		}
		$fcheck=$dbr->result("SELECT forumid FROM arc_forum WHERE forumid=$fid");
		if (is_numeric($fcheck)) {
		include('adminfunctions.php');
		$toolbar=getTemplate('forumtoolbar');
		$fquery=$dbr->query("SELECT * FROM arc_forum WHERE forumid=$fid");
		$foruminfo=$dbr->getarray($fquery);
		$js="
<script language=\"javascript\" type=\"text/javascript\">
<!--
function check(frm)
{
  if (frm.ntopic_name.value==\"" .getwordbit('topicnamedefault'). "\") {
    alert(\"" .getwordbit('topictitleunchanged'). "\");
    return false;
  }
  if (frm.ntopic_content.value==\"\" || frm.ntopic_name.value==\"\") {
	alert(\"" .getwordbit('newtopic_emptyfields'). "\");
	return false;
  }
}
//-->
</script>
";
		$header=str_replace('<js>', $js, $header);
		doHeader("$sitename" .str_replace('<forumname>', stripslashes($foruminfo['forumname']), getwordbit('newtopictitle')));

		$catname=stripslashes($dbr->result("SELECT forumname FROM arc_forum WHERE forumid=$foruminfo[parentid]"));
		$parentsparent=$dbr->result("SELECT parentid FROM arc_forum WHERE forumid=$foruminfo[parentid]");
		if ($parentsparent>0) {
			$catlink="<a href=\"$webroot/topic.php?action=forum&fid=$foruminfo[parentid]\">$catname</a>";
		} else {
			$catlink="<a href=\"$webroot/forums.php?catid=$foruminfo[parentid]\">$catname</a>";
		}
		$topics=$foruminfo['topiccount'];
		$posts=$foruminfo['postcount'];
		$newtopiclink="<a href=\"$webroot/topic.php?action=newtopic&fid=$foruminfo[forumid]\">" .stripslashes(str_replace('<newtopicpath>', $newtopicpath, getwordbit('newtopic'))). "</a>";
		$fhl=getwordbit('forumhomelink');
		$fhl=str_replace('<sitename>', $sitename, $fhl);
		$forumhome="<a href=\"forums.php\">$fhl</a>";
		$toolbar=str_replace('<forumhome>', $forumhome, $toolbar);
		$toolbar=str_replace('<catlink>', $catlink, $toolbar);
		$toolbar=str_replace('<fid>', $foruminfo['forumid'], $toolbar);
		$toolbar=str_replace('<forumname>', stripslashes($foruminfo['forumname']), $toolbar);
		$toolbar=str_replace('<topics>', $topics, $toolbar);
		$toolbar=str_replace('<posts>', $posts, $toolbar);
		$toolbar=str_replace('<newtopiclink>', $newtopiclink, $toolbar);
		echo $toolbar;
		$adminpostextras=getSetting('postextras');

		if ($foruminfo['forumtype']==1) {
			$topic_name=getwordbit('topic_name');
			$topic_desc=getwordbit('topic_desc');
			$topic_content=getwordbit('topic_content');
			$tc='text';
			$max=80;
		} elseif ($foruminfo['forumtype']==2) {
			$topic_name=getwordbit('topic_imgname');
			$topic_desc=getwordbit('topic_image');
			$topic_content=getwordbit('topic_imgdesc');
			$tc='file';
			$max=getSetting('max_image_size');
		} elseif ($foruminfo['forumtype']==3) {
			$topic_name=getwordbit('topic_filename');
			$topic_desc=getwordbit('topic_filepath');
			$topic_content=getwordbit('topic_filedesc');
			$tc='file';
			$max=getSetting('max_file_size');
		} elseif ($foruminfo['forumtype']==4) {
			$topic_name=getwordbit('topic_name');
			$topic_desc=getwordbit('topic_desc');
			$topic_content=getwordbit('topic_ccontent');
			$tc='text';
			$max=80;
		}

		$inputs[]=str_replace('<form', '<form onSubmit="return check(this)"', formtop('post.php?action=readcomments&ident=topic'));
		$inputs[]=inputform('hidden', '', 'userid', $userid);
		$inputs[]=inputform('hidden', '', 'parentident', 'topic');
		$inputs[]=inputform('hidden', '', 'parentid', $fid);
		$inputs[]=inputform('display', getwordbit('topic_you'), 'username', $displayname);
		$inputs[]=str_replace('"text"', "\"text\"
			onFocus=\"if (this.value=='" .getwordbit('topicnamedefault'). "') {
				this.value='';
			}\"
			onBlur=\"if (this.value=='') {
				this.value='" .getwordbit('topicnamedefault'). "';
			}\"", inputform('text', $topic_name, 'ntopic_name', getwordbit('topicnamedefault'), getSetting('inputwidth'), getSetting('max_topic_chars')));
		if (isset($HTTP_GET_VARS['poll'])) {
			if ($HTTP_GET_VARS['poll']>getSetting('max_poll_options')) {
				$poll=getSetting('max_poll_options');
			} else {
				$poll=$HTTP_GET_VARS['poll'];
			}
			$thisindex=0;
			$inputs[]=inputform('display', '', '', getwordbit('makepoll'));
			while ($thisindex<$poll) {
				$inputs[]=inputform('polltext', '', "polloption[$thisindex]");
				$thisindex++;
			}
		}
		$inputs[]=inputform($tc, $topic_desc, 'ntopic_desc', '', $formwidth, $max);
		$inputs[]=inputform('threadicons', getwordbit('newtopic_icon'), 'ntopic_icon');
		$inputs[]=inputform('textarea', $topic_content, 'ntopic_content');
		$inputs[]=inputform('hidden', '', 'forumid', $foruminfo['forumid']);
		$inputs[]=inputform('submitreset', getwordbit('topic_submit'), getwordbit('topic_reset'), 'buildtopic');
		doinputs();
		formbottom();
		} else {
			echo $header;
			showmsg('invalid_forum');
		}
	}
}

footer();

?>