<?php

$templates='pagebittoolbar,topictoolbar,posts,pagebitrow,postrow,quoteuser,quickreplyform,forums_menu,post,profilerow,profiletoolbar,';
$templates.='threadpoll,threadpoll_row,pollvoteform,';
$wordbits='topicnamedefault,file_copied,file_not_copied,post_noident,post_noid,postreply,forumhomelink,quickreplylink,';
$wordbits.='editpost,editcomment,sendpm,sendpmalt,quoteuser,noreplies,replybit,guestusername,post_author,post_title,notepostedmsg,';
$wordbits.='post_content,post_submit,post_reset,post_save_notepad,reviewdesc,gotoforum,gototopic,reviewdesc,gotoforum,parseurls,';
$wordbits.='post_added,edit_submit,edit_reset,editedbymsg,postedited,newtopic_emptyfields,cantpostnote,floodcheck,noeditpermission,';
$wordbits.='file_already_exists,privateforum_noaccess,topic_name_exists,file_not_uploaded,nodoubleposting,guests_not_allowed_in_topic,';
$wordbits.='mustregister,';
$settings='note_min_exp,note_max_exp,topic_min_exp,topic_max_exp,readpost_min_exp,readpost_max_exp,post_limit,max_file_size,rpg_flag,';
$settings.='showquickreply,post_timestamp,postsintopicreview,reviewoldestfirst,post_min_exp,post_max_exp,replyprefix,chars_to_wrap,allowhtml,';
$settings.='allow_html_in_post_templates,guestscanviewforums,';
$isforum=1;

include('./lib/config.php');

if ($action=='postnote') {  ////////////////////////////////////// POST NOTE
	if (isset($notemsg) && $loggedin==1 && $notemsg!='' && $isbanned==0) {
		$note_count=$dbr->result("SELECT COUNT(noteid) FROM arc_note WHERE noteuserid=$userid");

		if (getSetting('note_max_exp')!=0 || getSetting('experience_type')=='characters' && getSetting('rpg_flag')==1)
			$expreport=modexp(getSetting('note_min_exp'), getSetting('note_max_exp'), $userid, 1, 0, 1, $notemsg);

		$eating_babies=$dbr->query("INSERT INTO arc_note SET noteuserid=$userid, notemessage='" .insert_text($notemsg). "', ntimestamp='" .time(). "'");
		$noteid=$dbr->result("SELECT MAX(noteid) FROM arc_note WHERE noteuserid=$userid");

		if ($noteid=='')
			$noteid=0;

		$totalnotes=$dbr->result("SELECT COUNT(noteid) FROM arc_note");
		$dbr->query("UPDATE arc_misc SET numnotes=$totalnotes");
		$dbr->query("UPDATE arc_user SET note_count=$note_count,lastnoteid=$noteid WHERE userid=$userid");
		if (isset($HTTP_REFERER)) {
			doHeader("$sitename: Note Posted", 1, 1, $HTTP_REFERER);
			$themsg=str_replace('<referer>', $HTTP_REFERER, getwordbit('notepostedmsg'));
			showmsg($themsg, 1);
		}
		if (getSetting('rpg_flag')==1) echo modexp(getSetting('note_min_exp'), getSetting('note_max_exp'), $userid);

	} else {
		doHeader("$sitename: Error");
		showmsg('cantpostnote');
	}
}
if (isset($HTTP_GET_VARS['vote'])) {
	$pid=htmlspecialchars($HTTP_GET_VARS['vote']);
	$polls_suck=$dbr->query("SELECT arc_polla.users, arc_polla.votes, arc_poll.pvotes, arc_poll.pollclosed FROM arc_poll, arc_polla WHERE arc_polla.pollaid=$pollvote AND arc_poll.pollid=$pid LIMIT 0,1");
	$ps=$dbr->getarray($polls_suck);
	$pollusers=explode(',', $ps['users']);
	if ($ps['pollclosed']==0 && empty($pollusers[$userid])) {
		$ps['users'].="$userid,";
		$ps['votes']++;
		$ps['pvotes']++;
		$dbr->query("UPDATE arc_poll SET pvotes=$ps[pvotes] WHERE pollid=$pid");
		$dbr->query("UPDATE arc_polla SET users='$ps[users]', votes=$ps[votes] WHERE pollaid=$pollvote");
	}
}
$feedback='';

if ($action=='news') $action='readcomments';

switch ($action) {
	case 'readcomments': ////////////////////////////////////// READ COMMENTS & POST NEW TOPIC
		if (isset($buildtopic) && $loggedin==1 && $isbanned==0) { // build new topic

			floodcheck(1);

			$post_count=$post_count+1;
			$lpostid=$dbr->result("SELECT MAX(postid) FROM arc_post LIMIT 0,1");
			$lpostid=$lpostid+1;
			$ltopics=$dbr->result("SELECT topics FROM arc_user WHERE userid=$userid");
			$ltopics=$ltopics+1;
			$atc=$dbr->query("SELECT topiccount,forumtype,fpassword,private FROM arc_forum WHERE forumid=$parentid");
			$ta=$dbr->getarray($atc, MYSQL_ASSOC);

			if ($ntopic_name=='' || $ntopic_content=='' || $ntopic_name==getwordbit('topicnamedefault')) {
				doHeader(getwordbit('newtopic_emptyfields'));
				showmsg('newtopic_emptyfields');
				footer(1);
			}

			if ($ta['private']==1) {
				$seeprivate=forumPermStr(0, 1);
			} else {
				$seeprivate=1;
			}

			if ($loggedin==0 && getSetting('guestscanviewforums')==0) {
				doHeader("$sitename: ".getwordbit('guests_not_allowed_in_forum'));
				showmsg('guests_not_allowed_in_forum');
				footer(1);
			}

			if ($seeprivate==0) {
				doHeader(getwordbit('privateforum_noaccess'));
				showmsg('privateforum_noaccess');
				footer(1);
			}

			$topicnamecheck=$dbr->result("SELECT topicid FROM arc_topic WHERE ttitle='$ntopic_name'");
			$stop=0;

			if (is_numeric($topicnamecheck)) {
				$stop=1;
				doHeader(getwordbit('topic_name_exists'));
				showmsg('topic_name_exists');
				require('./adminfunctions.php');
				$inputs[]=formtop('');
				$inputs[]=inputform('display', '', '', $ntopic_name);
				$inputs[]=inputform('display', '', '', $ntopic_desc);
				$inputs[]=inputform('display', '', '', $ntopic_content);
				doinputs();
				formbottom();
				footer(1);
			}

			if ($ta['forumtype']==2) { // image forums
				$thefile=$HTTP_POST_FILES['ntopic_desc']['tmp_name'];
				$thefiletype=$HTTP_POST_FILES['ntopic_desc']['type'];

				$thefileext=strrchr($HTTP_POST_FILES['ntopic_desc']['name'], ".");

				$thefilename=str_replace($thefileext, '', $HTTP_POST_FILES['ntopic_desc']['name']);

				if ($thefileext=='.php' || $thefileext=='.php3' || $thefileext=='.phtml')
					$thefileext='.phps';

				$thefilename=$thefilename.$thefileext;


				$filepath='./lib/images/dock/';
				$filename=$filepath . $thefilename;

				if (file_exists($filename) && $thefilename!="") {
					doHeader("$sitename: Error");
					showmsg('file_already_exists');
					footer(1);
				}

				if (is_uploaded_file($thefile)) {
					if (copy($thefile, $filename)) {
						$feedback=str_replace('<thefilename>', $thefilename, getwordbit('file_copied'));
					} else {
						$feedback=str_replace('<thefilename>', $thefilename, getwordbit('file_not_copied'));
					}
				} else {
					$feedback=str_replace('<thefilename>', avatardecode($thefilename), getwordbit('file_not_uploaded'));
				}

				$ntopic_desc=$filepath . $thefilename;
			} elseif ($ta['forumtype']==3) {  // file forums
				$thefile=$HTTP_POST_FILES['ntopic_desc']['tmp_name'];
				$thefiletype=$HTTP_POST_FILES['ntopic_desc']['type'];

				$thefileext=strrchr($HTTP_POST_FILES['ntopic_desc']['name'], ".");

				$thefilename=str_replace($thefileext, '', $HTTP_POST_FILES['ntopic_desc']['name']);

				if ($thefileext=='.php' || $thefileext=='.php3' || $thefileext=='.phtml')
					$thefileext='.phps';

				$thefilename=$thefilename.$thefileext;

				$thefilesize=$HTTP_POST_FILES['ntopic_desc']['size'];
				$filepath='./lib/files/dock/';
				$filename=$filepath . $thefilename;

//				echo "thefilesize = $thefilesize<br>max_file_size = " .getSetting('max_file_size');

				if ($thefilesize > getSetting('max_file_size')) {
					$feedback=getwordbit('filesizeexceeded');
					$stop=1;
				}

				if (file_exists($filename) && $thefilename!="") {
					doHeader("$sitename: Error");
					showmsg('file_already_exists');
					footer(1);
				}

				if (is_uploaded_file($thefile) && $stop==0) {
					if (copy($thefile, $filename)) {
						$feedback=str_replace('<thefilename>', $thefilename, getwordbit('file_copied'));
//						$dbr->query("INSERT INTO arc_file SET filepath='$filepath" .$HTTP_POST_FILES['ntopic_desc']['name']. "', filedate='" .time(). "', fuserid=$userid, fusername='" .stripslashes($displayname). "'");
					} else {
						$feedback=str_replace('<thefilename>', $thefilename, getwordbit('file_not_copied'));
					}
				} else {
					$feedback=str_replace('<thefilename>', $thefilename, getwordbit('file_not_uploaded'));
				}
				$ntopic_desc=$filepath . $thefilename;
			}

			if ($stop==0) {

				$dbr->query("UPDATE arc_user SET
						 post_count=$post_count,
						 lastpostid=$lpostid,
						 topics=$ltopics,
						 last_post=" .time(). "
						 WHERE userid=$userid");

				if (isset($polloption)) {
					$numpolls=$dbr->result("SELECT COUNT(pollid) FROM arc_poll")+1;
					$dbr->query("UPDATE arc_misc SET numpolls=$numpolls");
					$dbr->query("INSERT INTO arc_poll SET question='" .dbPrep(htmlspecialchars($ntopic_name)). "', pollstart='" .time(). "'");
					$lastid=mysql_insert_id();
					$pollinsert="pollid=$lastid,";
					foreach ($polloption as $val) {
						$dbr->query("INSERT INTO arc_polla SET answer='" .dbPrep(htmlspecialchars($val)). "', pollid=$lastid");
					}

				} else {
					$pollinsert='';
				}

				$dbr->query("INSERT INTO arc_topic SET
						 ttitle='" .insert_text($ntopic_name). "',
						 tdescription='" .insert_text($ntopic_desc). "',
						 tusername='" .insert_text($displayname). "',
						 tuserid=$userid,
						 tlastposter='".htmlspecialchars(insert_text($displayname))."',
						 tlastposterid='$userid',
						 topicicon='$ntopic_icon',
						 $pollinsert
						 tforumid=$forumid,
						 topicdate='" .time(). "'");

				$numtopics=$misc['numtopics']+1;
				$numposts=$misc['numposts']+1;

				$dbr->query("UPDATE arc_misc SET numtopics=$numtopics, numposts=$numposts");
				$id=$dbr->result("SELECT MAX(topicid) FROM arc_topic");
				$dbr->query("INSERT INTO arc_post SET
						 parentident='topic',
						 parentid=$id,
						 postuserid=$userid,
						 postusername='" .htmlspecialchars(insert_text($displayname)). "',
						 posttitle='" .insert_text($ntopic_name). "',
						 postdate='" .time(). "',
						 postcontent='" .insert_text($ntopic_content). "'");

				updatesearchindex($ntopic_content, mysql_insert_id(), 'arc_post');

				$tc=$dbr->result("SELECT COUNT(topicid) FROM arc_topic WHERE tforumid=$parentid");
				$dbr->query("UPDATE arc_forum SET topiccount=$tc, lasttopicid='$id', lastposterid='$userid',lastposttime='".time()."' WHERE forumid=$parentid");
				$ident='topic';
			}
		}

		require('./lib/showposts.php');

		showposts(getSetting('post_limit'));

	break;

	case 'postcomment': ////////////////////////////////////// REPLY FORM
		$ident=$HTTP_GET_VARS['ident'];
		$id=getid();
		$posthtml=getTemplate('post');
		$temp='';

		if (empty($ident)) {
			doHeader("$sitename: Invalid parent identifier");
			$stop='post_noident';
		} elseif (empty($id)) {
			doHeader("$sitename: Invalid $ident number specified");
			$stop='post_noid';
		} elseif (empty($loggedin)) {
			doHeader("$sitename: Access denied");
			$stop='mustregister';
		}

		$pd=$dbr->result("SELECT MAX(postid) FROM arc_post WHERE parentid=$id LIMIT 0,1");
		$pd = is_numeric($pd) ? $pd : '0';
		if ($pd != 0) {
			$lastuserid=$dbr->result("SELECT postuserid FROM arc_post WHERE postid=$pd");
		} else {
			$lastuserid=0;
		}

		if ($lastuserid==$userid && $isadmin==0)
			$stop='nodoubleposting';
		if (isset($stop)) {
			doHeader(getwordbit('nodoubleposting'));
			showmsg($stop);
			footer(1);
		}
		if ($ident=='pagebit') {
			$t=$dbr->query("SELECT * FROM arc_pagebit WHERE pagebitid='$id'");

			$toolbar=getTemplate('pagebittoolbar');
			$parentinfo=$dbr->getarray($t);
			$pagebitlink="<a href=\"index.php?action=$parentinfo[page]\">$parentinfo[ptitle]</a>";
			$postreply="<a href=\"post.php?action=postcomment&ident=pagebit&id=$id\">" .getwordbit('replybit'). "</a>";
			$toolbar=str_replace('<newreply>', $postreply, $toolbar);
			$toolbar=str_replace('<pagebitlink>', $pagebitlink, $toolbar);
			$toolbar=str_replace('<newreplypath>', $newreplypath, $toolbar);

			$title=$parentinfo['ptitle'];
			doHeader("$sitename: Commenting on: $parentinfo[ptitle]");
		} elseif ($ident=='topic') {
			$t=$dbr->query("SELECT * FROM arc_topic WHERE topicid='$id'");
			$toolbar=getTemplate('topictoolbar');
			$parentinfo=$dbr->getarray($t);
			$title=stripslashes($parentinfo['ttitle']);
			$topiclink="<a href=\"post.php?action=readcomments&ident=topic&id=$parentinfo[topicid]\">$title</a>";

			$f=$dbr->query("SELECT forumid,forumname,description,parentid FROM arc_forum WHERE forumid=$parentinfo[tforumid]");
			$foruminfo=$dbr->getarray($f);
			$forumlink="<a href=\"topic.php?action=forum&fid=$foruminfo[forumid]\" title=\"$foruminfo[description]\">".stripslashes($foruminfo['forumname']).'</a>';

			$c=$dbr->query("SELECT forumid,forumname FROM arc_forum WHERE forumid=$foruminfo[parentid]");
			$catinfo=$dbr->getarray($c);
			$catlink="<a href=\"forums.php?action=forumdisplay&catid=$catinfo[forumid]\">".stripslashes($catinfo['forumname']).'</a>';

			doHeader("$sitename: $title");
			if ($parentinfo['isclosed']==1) {
				showmsg('topic_closed');
				footer(1);
			}
			$topicname="<a href=\"post.php?action=readcomments&ident=$ident&id=$id\">$title</a>";

			$forumhome="<a href=\"forums.php?all=\">" .getwordbit('forumhomelink'). "</a>";
			$toolbar=str_replace('<sitename>', $sitename, $toolbar);
			$toolbar=str_replace('<forumhome>', $forumhome, $toolbar);
			$toolbar=str_replace('<catlink>', $catlink, $toolbar);
			$toolbar=str_replace('<numposts>', $parentinfo['treplies'], $toolbar);
			$toolbar=str_replace('<numhits>', $parentinfo['topichits'], $toolbar);
			$toolbar=str_replace('<forumlink>', $forumlink, $toolbar);
			$toolbar=str_replace('<topiclink>', $topiclink, $toolbar);

			echo $toolbar;
		} elseif ($ident=='profile') {
			$toolbar=getTemplate('profiletoolbar');

			$t=$dbr->query("SELECT userid,displayname,profilehits FROM arc_user WHERE userid=$id");
			$parentinfo=$dbr->getarray($t);
			$numposts=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE parentident='profile' AND parentid=$id");

			if ($numposts=='') $numposts=0;

			$userlink="<a href=\"user.php?action=profile&id=$id\">" .stripslashes($parentinfo['displayname']). "</a>";

			$toolbar=str_replace('<displayname>', $userlink, $toolbar);
			$toolbar=str_replace('<newcommentlink>', getwordbit('postreply'), $toolbar);
			$toolbar=str_replace('<numposts>', number_format($numposts), $toolbar);
			$toolbar=str_replace('<profilehits>', $parentinfo['profilehits'], $toolbar);
			$toolbar=str_replace('<id>', $id, $toolbar);
			$toolbar=str_replace('<ident>', 'profile', $toolbar);
			$toolbar=str_replace('<newreplypath>', $newreplypath, $toolbar);

			doHeader("$sitename: Viewing comments on " .stripslashes($parentinfo['displayname']));
			$title=$parentinfo['displayname'];
		}

		if (getSetting('guestscanpost')==1 && $loggedin==0) {
			$loggedin=1;
			$username=getwordbit('guestusername');
			$last_active=time();
		}

		if ($loggedin==1 && empty($HTTP_COOKIE_VARS['floodtime'])) {
			require('adminfunctions.php');

			if (isset($HTTP_GET_VARS['content'])) {
				$pcontent=getTemplate('quoteuser');
				$pcontent=str_replace("<content>", urldecode($HTTP_GET_VARS['content']), $pcontent);
			} else {
				$pcontent='';
			}

			$postextras=getsetting('postextras');

			$query=$dbr->query("SELECT * FROM arc_user WHERE userid=$id");
			$user=$dbr->getarray($query);

			$inputs[]=formtop('post.php?action=newcomment');
			$inputs[]=inputform('hidden', '', 'parentident', $ident);
			$inputs[]=inputform('hidden', '', 'parentid', $id);
			$inputs[]=inputform('display', getwordbit('post_author'), 'postusername', $displayname);
			$inputs[]=inputform('text', getwordbit('post_title'), 'posttitle', getSetting('replyprefix'). $title);
			$inputs[]=inputform('textarea', getwordbit('post_content'), 'postcontent', stripslashes(bbcode_reverse($pcontent)), 70, 10);
			$inputs[]=inputform('hidden', '', 'postextras', $postextras);
			$inputs[]=inputform('yesno', getwordbit('parseurls'), 'pparseurls', 1);
			$inputs[]=inputform('submitreset', getwordbit('post_submit'), getwordbit('post_reset'));
			$inputs[]=inputform('submit', 'Or', 'savetonotepad', getwordbit('post_save_notepad'));

			foreach ($inputs as $value)
				echo "$value\n";

			formbottom();
		} elseif (isset($HTTP_COOKIE_VARS['floodtime'])) {
			showmsg('floodcheck');
		}

		if ($ident=='topic') {
			$fid=$dbr->result("SELECT tforumid FROM arc_topic WHERE topicid=$id");
			$modid=$dbr->result("SELECT modid FROM arc_forum WHERE forumid=$fid");
		} else {
			$fid=0;
			$modid=0;
		}

		$limit=getSetting('postsintopicreview');
		$rof=getSetting('reviewoldestfirst');

		if ($rof==1) {
			$total=$dbr->result("SELECT COUNT(postid) AS numposts FROM arc_post WHERE parentident='$ident' AND parentid=$id");
			$offset=$total - $limit;
			$sort='ASC';
		} else {
			$offset=0;
			$sort='DESC';
		}

		if ($offset<0)
			$offset=0;

		if (getSetting('rpg_flag')==1) {
			$limited=$dbr->query("SELECT
						arc_post.postid,
						arc_post.parentident,
						arc_post.parentid,
						arc_post.postuserid,
						arc_post.postusername,
						arc_post.posttitle,
						arc_post.postcontent,
						arc_post.postdate,
						arc_post.parseurls,
						arc_user.userid,
						arc_user.displayname,
						arc_user.hp,
						arc_user.mp,
						arc_user.curhp,
						arc_user.curmp,
						arc_user.level,
						arc_user.exp,
						arc_user.avatar,
						arc_user.post_count,
						arc_user.note_count,
						arc_user.usertext,
						arc_user.rank,
						arc_user.post_header,
						arc_user.post_footer
							FROM arc_post,arc_user
							WHERE
						arc_post.parentident='$ident'
						AND arc_post.parentid=$id
						AND arc_user.userid=arc_post.postuserid
							ORDER BY
						arc_post.postdate
							ASC LIMIT $offset,$limit");
		} else {
			$limited=$dbr->query("SELECT
						arc_post.postid,
						arc_post.parentident,
						arc_post.parentid,
						arc_post.postuserid,
						arc_post.postusername,
						arc_post.posttitle,
						arc_post.postcontent,
						arc_post.postdate,
						arc_post.parseurls,
						arc_user.userid,
						arc_user.displayname,
						arc_user.avatar,
						arc_user.post_count,
						arc_user.note_count,
						arc_user.usertext,
						arc_user.rank,
						arc_user.post_header,
						arc_user.post_footer
							FROM arc_post,arc_user
							WHERE
						arc_post.parentident='$ident'
						AND arc_post.parentid=$id
						AND arc_user.userid=arc_post.postuserid
							ORDER BY
						arc_post.postdate
							ASC LIMIT $offset,$limit");
		}

		$posthtml=str_replace("<reviewdesc>", getwordbit('reviewdesc'), $posthtml);
		$posthtml=str_replace("<limit>", $limit, $posthtml);

		while ($posts=$dbr->getarray($limited)) {
			if ($posts['parseurls']==1) $posts['postcontent']=parseurl($posts['postcontent']);
			if ($ident=='pagebit') {
				$postrow=getTemplate('pagebitrow');
			} else {
				$postrow=gettemplate('postrow');
			}

			$row=str_replace('<posttitle>', stripslashes(htmlspecialchars($posts['posttitle'])), $postrow);

			if (getSetting('alternatetdbgcolors')==1) {
				$row=str_replace('<alt_bg>', rowswitch($tdbgcolor, $alttablebgcolor), $row);
			} else {
				$row=str_replace('<alt_bg>', $tdbgcolor, $row);
			}

			if (getSetting('rpg_flag')==1) {
				$row=str_replace('<hp>', $posts['hp'], $row);
				$row=str_replace('<curhp>', $posts['curhp'], $row);
				$row=str_replace('<mp>', $posts['mp'], $row);
				$row=str_replace('<curmp>', $posts['curmp'], $row);
			}

			$row=str_replace('<postcontent>', stripslashes(nl2br(dehtml($posts['postcontent']))), $row);
			$row=str_replace('<userid>', stripslashes($posts['userid']), $row);
			$row=str_replace('<displayname>', stripslashes($posts['displayname']), $row);
			$row=str_replace('<avatar>', stripslashes(htmlspecialchars($posts['avatar'])), $row);
			$row=str_replace('<postid>', $posts['postid'], $row);

			$temp.=$row;
		}

		echo str_replace('<postrow>', $temp, $posthtml);

	break;

	case 'newcomment': ////////////////////////////////////// NEW COMMENT
			doHeader("$sitename: Thank you for posting");
			if ($loggedin==1 && isset($HTTP_POST_VARS['parentident']) && isset($HTTP_POST_VARS['parentid']) && $isbanned==0) {
				floodcheck();

				if ($parentident=='topic') {
					$replies=$dbr->result("SELECT treplies FROM arc_topic WHERE topicid=$parentid");
					$isclosed=$dbr->result("SELECT isclosed FROM arc_topic WHERE topicid=$parentid");
					if ($isclosed==1) {
						showmsg('topic_closed');
						footer();
						exit();
					}
					$replies=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE parentident='topic' AND parentid=$parentid");
					$dbr->query("UPDATE arc_topic SET treplies=$replies WHERE topicid=$parentid");
				} elseif ($parentident=='pagebit') {
					$psk=$dbr->result("SELECT shrinekey FROM arc_pagebit WHERE pagebitid=$parentid");
					$posts=$dbr->result("SELECT scomments FROM arc_shrine WHERE shrinekey='$psk'");
					$posts++;
					if (is_numeric($posts)) $dbr->query("UPDATE arc_shrine SET scomments=$posts WHERE shrinekey='$psk'");
				}

				if ($postcontent=='')
					$stop='post_emptyfields';
				if (isset($savetonotepad)) {
					$dbr->query("UPDATE arc_user SET notepad='$postcontent' WHERE userid=$userid");
					$stop='postsaved';
				}

				$pd=$dbr->result("SELECT MAX(postid) FROM arc_post WHERE parentid=$parentid LIMIT 0,1");
				if (is_numeric($pd))
					$lastuserid=$dbr->result("SELECT postuserid FROM arc_post WHERE postid=$pd");
				else
					$lastuserid=0;

				if ($lastuserid==$userid)
					$stop='nodoubleposting';
				if (isset($stop)) {
					showmsg($stop);
					footer(1);
				}
				if (isset($HTTP_POST_VARS['posttitle']) && getSetting('rpg_flag')==1)
					echo modexp(getSetting('post_min_exp'), getSetting('post_max_exp'), $userid, 1, 0, 1, $postcontent);

				$postcount=$post_count+1;

				$lpostid=$dbr->result("SELECT MAX(postid) FROM arc_post LIMIT 0,1");
				$lpostid=$lpostid+1;

				if (empty($pparseurls)) $pparseurls=1;

				$dbr->query("UPDATE arc_user SET post_count=$postcount,lastpostid=$lpostid,last_post=" .time(). " WHERE userid='$userid'");
				$dbr->query("INSERT INTO arc_post SET parentident='$parentident',
						 parentid='$parentid',
						 postuserid='$userid',
						 postusername='" .htmlspecialchars(insert_text($displayname)). "',
						 posttitle='" .insert_text($posttitle). "',
						 postcontent='" .insert_text($postcontent). "',
						 parseurls='" .insert_text($pparseurls). "',
						 postdate='" .time(). "',
						 ipaddr='$REMOTE_ADDR'");
				updatesearchindex($postcontent, mysql_insert_id(), 'arc_post');
				$numposts=$dbr->result("SELECT COUNT(postid) FROM arc_post");
				$dbr->query("UPDATE arc_misc SET numposts=$numposts");

				if ($parentident=='topic') {
					$fid=$dbr->result("SELECT tforumid FROM arc_topic WHERE topicid=$parentid");
					$pc=$dbr->result("SELECT postcount FROM arc_forum WHERE forumid=$fid");
					$pc=$pc+1;

					$dbr->query("UPDATE arc_forum SET postcount=$pc, lasttopicid='$parentid', lastposterid='$userid', lastposttime=" .time(). " WHERE forumid=$fid");
					$dbr->query("UPDATE arc_topic SET tlastposter='" .htmlspecialchars(insert_text($displayname)). "', tlastposterid=$userid, topicdate=" .time(). " WHERE topicid=$parentid");

					$forumname=$dbr->result("SELECT forumname FROM arc_forum WHERE forumid=$fid");
					$gtf=getwordbit('gotoforum');
					$gtf=str_replace('<forum>', $forumname, $gtf);
					$forumlink="<a href=\"topic.php?action=forum&fid=$fid\">$gtf</a>";
				} else {
					$forumlink='';
					$topiclink='';
				}

				if ($parentident=='topic') {
					$t=$dbr->query("SELECT ttitle,tforumid FROM arc_topic WHERE topicid=$parentid");
					$r=$dbr->getarray($t);
					$gtt=str_replace('<topic>', $r['ttitle'], getwordbit('gototopic'));
					$topiclink="<a href=\"post.php?action=readcomments&ident=$parentident&id=$parentid\">$gtt</a>";
				} elseif($parentident=='pagebit') {
					$numreplies=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE parentident='pagebit' AND parentid=$parentid");
					$dbr->query("UPDATE arc_pagebit SET numcomments=$numreplies WHERE pagebitid=$parentid");
					$pagebitquery=$dbr->query("SELECT page,ptitle FROM arc_pagebit WHERE pagebitid=$parentid");
					$pagebit=$dbr->getarray($pagebitquery);
					$gtt=str_replace('<topic>', $pagebit['ptitle'], getwordbit('gototopic'));
					$topiclink="<a href=\"index.php?action=$pagebit[page]\">$gtt</a>";
				} elseif($parentident=='profile') {
					$name=stripslashes($dbr->result("SELECT displayname FROM arc_user WHERE userid=$parentid"));
					$gtt=str_replace('<topic>', $name, getwordbit('gototopic'));
					$topiclink="<a href=\"post.php?action=readcomments&ident=$parentident&id=$parentid\">$gtt</a>";
				}

				$gtf=getwordbit('gotoforum');
				$post_added=getwordbit('post_added');
				$npost_added=str_replace('<topiclink>', $topiclink, $post_added);
				$npost_added=str_replace('<forumlink>', $forumlink, $npost_added);
				$npost_added=str_replace('<post_count>', $postcount, $npost_added);

				showmsg($npost_added, 1);
			}
	break;

	case 'editcomment':  ////////////////////////////////////// EDIT COMMENT

		if (empty($HTTP_GET_VARS['id'])) {
			doHeader("$sitename: Invalid $ident number specified");
			showmsg('post_noid');
			footer(1);
		} elseif ($loggedin==0) {
			doHeader("$sitename: Access denied.");
			showmsg('mustregister');
			footer(1);
		}

		$id=$HTTP_GET_VARS['id'];

		$q=$dbr->query("SELECT parentid,parentident,postuserid FROM arc_post WHERE postid=$id");
		$qa=$dbr->getarray($q);

		if ($qa['parentident']=="topic") {
			$fid=$dbr->result("SELECT tforumid FROM arc_topic WHERE topicid=$qa[parentid]");
			$modid=$dbr->result("SELECT modid FROM arc_forum WHERE forumid=$fid");
		} else {
			$modid=0;
		}

		if ($qa['postuserid']==$userid || $userid==$modid || $isadmin==1) {
			require('adminfunctions.php');

			$id=htmlspecialchars($HTTP_GET_VARS['id']);
			$pq=$dbr->query("SELECT * FROM arc_post WHERE postid=$id");
			$pinfo=$dbr->getarray($pq);

			doHeader("$sitename: Editing Post " .stripslashes($pinfo['posttitle']));

			$query=$dbr->query("SELECT * FROM arc_user WHERE userid=$id");
			$user=$dbr->getarray($query);

			$inputs[]=formtop('post.php?action=modify');
			$inputs[]=inputform('hidden', '', 'postid', $pinfo['postid']);
			$inputs[]=inputform('hidden', '', 'edituserid', $userid);
			$inputs[]=inputform('hidden', '', 'editusername', $username);
			$inputs[]=inputform('display', getwordbit('post_author'), 'postusername', $pinfo['postusername']);
			$inputs[]=inputform('text', getwordbit('post_title'), 'posttitle', stripslashes(bbcode_reverse($pinfo['posttitle'])));
			$inputs[]=inputform('textarea', getwordbit('post_content'), 'postcontent', stripslashes(bbcode_reverse($pinfo['postcontent'])), $formwidth, 10);
			$inputs[]=inputform('yesno', getwordbit('parseurls'), 'editparseurls', $pinfo['parseurls']);
			$inputs[]=inputform('submitreset', getwordbit('edit_submit'), getwordbit('edit_reset'));
			foreach ($inputs as $value)
				echo "$value\n";
			formbottom();
		} else {
			doHeader("$sitename: You do not have permission to edit this post");
			showmsg('noeditpermission');
			footer();
		}

	break;

	case 'modify':  ////////////////////////////////////// SAVE CHANGES
		if ($loggedin==1 && isset($postid)) {
			// add edited by message if not admin
			if ($isadmin==0) {
				$ebm=str_replace('<username>', stripslashes(htmlspecialchars($displayname)), getwordbit('editedbymsg'));
			} else {
				$ebm='';
			}

			$q=$dbr->query("SELECT parentid,parentident,postuserid FROM arc_post WHERE postid=$postid");
			$qa=$dbr->getarray($q);

			if ($qa['parentident']=="topic") {
				$fid=$dbr->result("SELECT tforumid FROM arc_topic WHERE topicid=$qa[parentid]");
				$modid=$dbr->result("SELECT modid FROM arc_forum WHERE forumid=$fid");

				// is this the last reply in the topic? If so, update the timestamp
				$lastidintopic = $dbr->result("SELECT MAX(postid) FROM arc_post WHERE parentident='topic' AND parentid='$qa[parentid]'");
				if ($lastidintopic == $postid)
					$dbr->query("UPDATE arc_topic SET topicdate='".time()."' WHERE topicid='$qa[parentid]'");

			} else {
				$modid=0;
			}

			if ($qa['postuserid']==$userid or $userid==$modid or $isadmin==1) {
				$postcontent.=$ebm;

				$dbr->query("UPDATE arc_post SET
						 posttitle='" .insert_text($posttitle). "',
						 postcontent='" .insert_text($postcontent). "',
						 parseurls='" .insert_text($editparseurls). "',
						 editusername='".htmlspecialchars(insert_text($displayname))."' WHERE postid=$postid");

				updatesearchindex($postcontent, $postid, 'arc_post', 1);

				$topic_start_post=$dbr->result("SELECT MIN(postid) AS minpostid FROM arc_post WHERE parentid=$qa[parentid] && parentident='topic'");
				if ($postid==$topic_start_post) $dbr->query("UPDATE arc_topic SET ttitle='" .insert_text($posttitle). "' WHERE topicid=$qa[parentid]");

				doHeader("$sitename Post Edited");

				$pe=str_replace('<parentident>', $qa['parentident'], getwordbit('postedited'));
				$pe=str_replace('<parentid>', $qa['parentid'], $pe);
				$pe=str_replace('<postid>', $postid, $pe);

				showmsg($pe, 1);
			}
		}
	break;
}

footer();

?>