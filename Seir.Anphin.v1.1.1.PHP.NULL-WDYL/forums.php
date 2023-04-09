<?php

$templates='forumrow,forum,forumtoolbar,categoryrow,category,forums_menu,';
$wordbits='noviewforums,nopostsinforum,nomod,new_posts_icon,old_posts_icon,';
$settings='showtotalstats,guestscanviewforums,mods_see_private_forums,';
$isforum=1;

include('./lib/config.php');

$gcvf=getSetting('guestscanviewforums');
if ($loggedin==0 && $gcvf==0) {
	$nvf=getwordbit('noviewforums');
	doHeader("$no access to $sitename forums");
	echo "$top1$nvf$top2$myspiffytrout";
	footer(1);
}

if (isset($HTTP_GET_VARS['markread']) && $loggedin==1) $dbr->query("UPDATE arc_user SET lastread=last_active WHERE userid=$userid");
if ($action=='news') $HTTP_GET_VARS['all']='';

if (isset($HTTP_GET_VARS['all']) || isset($HTTP_GET_VARS['catid'])) {
	doHeader("$sitename Forums");

	if (isset($HTTP_GET_VARS['all'])) {
		if ($HTTP_GET_VARS['all']=="") {
			$whereid="";
		} else {
			$ftype=$HTTP_GET_VARS['all'];
			$whereid="";
		}
	} else {
		$whereid="";
	}
	if (isset($HTTP_GET_VARS['catid'])) {
		$whereid=" AND arc_forum.parentid=$HTTP_GET_VARS[catid]";
	}

	$sts=getSetting('showtotalstats');

	$carrot=forumPermStr(' AND arc_forum.private=0');

	$publicforums=$dbr->query("SELECT arc_forum.* FROM arc_forum WHERE forder<>0 AND isforum=0 AND parentid=0$carrot ORDER BY forder");
	while ($moo=$dbr->getarray($publicforums)) {
		$categoryname="&nbsp;<a href=\"$webroot/forums.php?catid=$moo[forumid]\">" .stripslashes($moo['forumname']). "</a>";
		$ncategoryrow=str_replace('<categoryname>', $categoryname, getTemplate('categoryrow'));
		if (isset($moo['description'])) $ncategoryrow=str_replace('<categorydesc>', stripslashes($moo['description']), $ncategoryrow);

		echo str_replace('<categoryrow>', $ncategoryrow, getTemplate('category'));
		if (getSetting('gzcompress')==0) flush();

		$nsf=$dbr->result("SELECT COUNT(forumid) FROM arc_forum WHERE forder<>0 AND parentid=$moo[forumid] AND isforum=1$whereid");
		if ($nsf>0) {
			$f_html=getTemplate('forum');

			$query = "SELECT arc_forum.*, arc_topic.ttitle,arc_user.displayname
					  FROM arc_forum
					  LEFT JOIN arc_topic
					  ON arc_forum.lasttopicid=arc_topic.topicid
					  LEFT JOIN arc_user
					  ON arc_forum.lastposterid=arc_user.userid
					  WHERE arc_forum.forder<>0 AND arc_forum.parentid=$moo[forumid] AND arc_forum.isforum=1 $whereid$carrot
					  ORDER BY arc_forum.forder";

			$ubbsucks=$dbr->query($query);

			$fr=getTemplate('forumrow');
			$forumrows='';
			while ($meow=$dbr->getarray($ubbsucks)) {
				if (isset($meow['lasttopicid'])) {
					if ($meow['lasttopicid']=='' || $meow['lasttopicid']==0) {
						$lasttopic=getwordbit('nopostsinforum');
					}
					if($meow['lasttopicid']!="" && $meow['lasttopicid']!=0) {
						$title=stripslashes(htmlspecialchars(unfilter($meow['ttitle'])));
						$lasttopic="<a href=\"post.php?id=$meow[lasttopicid]&action=readcomments&ident=topic\">" .stripslashes($title). "</a>";
					}
				} else {
					$lasttopic='';
				}
				if (isset($meow['lastposterid'])) {
					if ($meow['lastposterid']==0) $meow['lastposterid']=="";
				}
				if (empty($meow['lastposterid'])) {
					$lastposter='';
				} else {
					if ($meow['lastposterid']==0) {
						$lastposter='';
					}
					$name=format_text($meow['displayname']);
					$lastposter="<a href=\"user.php?action=profile&id=$meow[lastposterid]\">" .stripslashes($name). "</a>";
				}
				if ($meow['modusername']!='' and $meow['modid']!='') {
					$moderator="<a href=\"user.php?action=profile&id=$meow[modid]\">" .stripslashes($meow['modusername']). "</a>";
				} else {
					$moderator=getwordbit('nomod');
				}

				$topiccount=$meow['topiccount'];

				if ($meow['linkurl']!="") {
					$meow['forumname']="<a href=\"$meow[linkurl]\">$meow[forumname]</a>";
				} else {
					$meow['forumname']="<a href=\"topic.php?action=forum&fid=$meow[forumid]\">$meow[forumname]</a>";
				}
				$nforumrow=str_replace('<forumname>', stripslashes($meow['forumname']), $fr);
				$nforumrow=str_replace('<moderator>', $moderator, $nforumrow);
				$nforumrow=str_replace('<fid>', $meow['forumid'], $nforumrow);
				$nforumrow=str_replace('<lasttopic>', $lasttopic, $nforumrow);
				$nforumrow=str_replace('<lasttopicid>', $meow['lasttopicid'], $nforumrow);
				$nforumrow=str_replace('<lastposter>', $lastposter, $nforumrow);
				if (empty($lastread)) $lastread=time();
				if ($lastread<$meow['lastposttime']) {
					$nforumrow=str_replace('<newposts>', getwordbit('new_posts_icon'), $nforumrow);
				} else {
					$nforumrow=str_replace('<newposts>', getwordbit('old_posts_icon'), $nforumrow);
				}
				$nforumrow=str_replace('<lastposttime>', $meow['lastposttime'], $nforumrow);
				$nforumrow=str_replace('<description>', $meow['description'], $nforumrow);
				$nforumrow=str_replace('<forum_topics>', $topiccount, $nforumrow);
				$nforumrow=str_replace('<forum_posts>', $meow['postcount'], $nforumrow);
				$forumrows.=$nforumrow;
			}

			$f_html=str_replace('<forumrow>', $forumrows, $f_html);
			echo $f_html;

			if (getSetting('gzcompress')==0)
				flush();
		}
	}
}

footer();

?>