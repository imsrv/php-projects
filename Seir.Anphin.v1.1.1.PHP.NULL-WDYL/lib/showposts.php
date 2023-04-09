<?php

function showposts($perpage, $queryextra='')
{
	GLOBAL $isadmin,$ismod,$HTTP_GET_VARS,$HTTP_POST_VARS,$loggedin,$feedback,$webroot,$sitename,$userid,$ntopic_content;
	GLOBAL $viewposttemps,$showquickreply,$seeprivate,$displayname,$title,$check,$normalfont,$cn,$modid,$access;
	GLOBAL $action,$id,$HTTP_SERVER_VARS,$profilecomments,$newreplypath,$dbr,$tdbgcolor,$alttablebgcolor,$xpreport,$userfile;

		if ($action=='profile') $ident='profile';
		$quickreplylink=stripslashes(getwordbit('quickreplylink'));


		if (empty($HTTP_GET_VARS['ident']) && empty($ident)) {
			doHeader("$sitename: Comment type not specified");
			showmsg('post_noident');
			footer(1);
		}
		if (empty($HTTP_GET_VARS['id']) && empty($id)) {
			doHeader("$sitename: Invalid id number specified");
			showmsg('post_noid');
			footer(1);
		}

		if (isset($HTTP_GET_VARS['ident'])) extract($HTTP_GET_VARS);
		if ($ident=='pagebit') {
			$t=$dbr->query("SELECT page,ptitle,porder,numcomments FROM arc_pagebit WHERE pagebitid='$id'");
			$toolbar=getTemplate('pagebittoolbar');
			$parentinfo=$dbr->getarray($t);
			$numposts=$parentinfo['numcomments'];
			$pc=getwordbit('postreply');
			$pagebitlink="<a href=\"index.php?action=$parentinfo[page]\">" .stripslashes($parentinfo['ptitle']). "</a>";
			$pagebitnumber=$parentinfo['porder'];
			$toolbar=str_replace('<pagebitlink>', $pagebitlink, $toolbar);
			$toolbar=str_replace('<newcommentlink>', $pc, $toolbar);
			$toolbar=str_replace('<numposts>', $numposts, $toolbar);
			$toolbar=str_replace('<id>', $id, $toolbar);
			$toolbar=str_replace('<ident>', 'pagebit', $toolbar);
			$toolbar=str_replace('<newreplypath>', $newreplypath, $toolbar);
			doHeader("$sitename: $parentinfo[ptitle]");
			$title=$parentinfo['ptitle'];
		} elseif ($ident=='topic') {

			$t=$dbr->query("SELECT topicid,ttitle,tdescription,tforumid,treplies,topichits,pollid,topichits,isclosed FROM arc_topic WHERE topicid=$id");
			$parentinfo=$dbr->getarray($t);
			$f=$dbr->query("SELECT forumid,forumname,description,parentid,private,fpassword,forumtype,accesslvl FROM arc_forum WHERE forumid=$parentinfo[tforumid]");
			$foruminfo=$dbr->getarray($f);

			if ($foruminfo['fpassword']=="") {
				$allowedin=1;
			} else {
				$allowedin=0;
			}

			if (isset($submitfpass) && isset($forumpass)) {
				if ($forumpass==$foruminfo['fpassword']) {
					$cookiename='forum' .$foruminfo['forumid'];
					setcookie($cookiename, md5($foruminfo['fpassword']), time()+3600);
					$allowedin=1;
				} else {
					$allowedin=0;
				}
			}

			if ($foruminfo['fpassword']!='' && $allowedin==0) {
				$cookiename='forum' .$foruminfo['forumid'];
				if (isset($_COOKIE[$cookiename])) {
					if ($_COOKIE[$cookiename]==md5($foruminfo['fpassword'])) {
						$allowedin=1;
					} else {
						$allowedin=0;
					}
				}
			}

			if (getSetting('guestscanviewforums')==1 && $loggedin==0)
				$access=1;

			if ($access<$foruminfo['accesslvl'] || ($foruminfo['accesslvl']==0 && $isadmin==0))
				$allowedin=0;

			if ($allowedin==0) {
				doHeader("$sitename: Access Denied");
				showmsg('privateforum_noaccess');
				footer(1);
			}

			$pviews=$parentinfo['topichits']+1;
			$pupdateviews=$dbr->query("UPDATE arc_topic SET topichits=$pviews WHERE topicid=$id");

			$topicname=stripslashes($parentinfo['ttitle']);
			$forumlink="<a href=\"topic.php?action=forum&fid=$foruminfo[forumid]\" title=\"$foruminfo[description]\">".stripslashes($foruminfo['forumname']).'</a>';
			$toolbar=getTemplate('topictoolbar');

			if ($foruminfo['forumtype']!=1 && $parentinfo['tdescription']!='') {
					if ($foruminfo['forumtype']==2) {
						$filename=str_replace('./lib/images/dock/', '', $parentinfo['tdescription']);
					} elseif ($foruminfo['forumtype']==3) {
						$filename=str_replace('./lib/files/dock/', '', $parentinfo['tdescription']);
					}
					$toolbar=str_replace('<downloadfile>', "<a href=\"$parentinfo[tdescription]\" target=\"_blank\">$filename</a>", $toolbar);
			}

			if ($parentinfo['pollid']!=0) {
				$phandle=$dbr->query("SELECT pollaid, answer, votes, users FROM arc_polla WHERE pollid=$parentinfo[pollid]");
				$totalvotes=$dbr->result("SELECT pvotes FROM arc_poll WHERE pollid=$parentinfo[pollid]");
				$pollhtml="<form action=\"post.php?action=readcomments&ident=topic&id=$id&vote=$parentinfo[pollid]\" method=\"post\">";
				$pollhtml.=getTemplate('threadpoll');
				$otpr=getTemplate('threadpoll_row');
				$temp='';
				while ($polls=$dbr->getarray($phandle)) {
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
					if ($loggedin==1) $tpr=str_replace('<votebutton>', "<input type=\"radio\" name=\"pollvote\" value=\"$polls[pollaid]\" />", $tpr);
					$temp.=$tpr;
				}
				$pollhtml=str_replace('<totalvotes>', $totalvotes, $pollhtml);
				$pollhtml=str_replace('<threadpoll_row>', $temp, $pollhtml);
				if ($loggedin==1 && empty($uid_{$userid})) $pollhtml.=getTemplate('pollvoteform');
				$pollhtml.='</form>';
			}

			$c=$dbr->query("SELECT forumid,forumname,fpassword,private FROM arc_forum WHERE forumid=$foruminfo[parentid]");
			$cats=$dbr->getarray($c);

			if ($foruminfo['private']==1) {
				$seeprivate=forumPermStr(0, 1);
			} else {
				$seeprivate=1;
			}

			$parentsparent=$dbr->result("SELECT parentid FROM arc_forum WHERE forumid=$cats[forumid]");
			if ($parentsparent>0) {
				$catlink="<a href=\"$webroot/topic.php?action=forum&fid=$cats[forumid]\">" .stripslashes($cats['forumname']). "</a>";
			} else {
				$catlink="<a href=\"$webroot/forums.php?catid=$cats[forumid]\">" .stripslashes($cats['forumname']). "</a>";
			}
			$title=stripslashes($parentinfo['ttitle']);
			doHeader("$sitename: $title");

			if ($seeprivate==0) {
				showmsg('privateforum_noaccess');
				footer(1);
			}

			if ($feedback!='') showmsg($feedback, 1);

			if (isset($HTTP_POST_VARS['buildtopic']) && $loggedin==1 && getSetting('rpg_flag')==1) {
				echo modexp(getSetting('topic_min_exp'), getSetting('topic_max_exp'), $userid, 1, 0, getSetting('topic_exp_report'), $ntopic_content);
			} elseif (empty($HTTP_POST_VARS['buildtopic'])  && $loggedin==1 && getSetting('rpg_flag')==1) {
				echo modexp(getSetting('readpost_min_exp'), getSetting('readpost_max_exp'), $userid, 1, '', getSetting('showreadreport'), 1);
			}

			$postcomment=str_replace('<id>', $parentinfo['topicid'], getwordbit('postreply'));
			$postcomment=str_replace('<ident>', 'topic', $postcomment);
			$postcomment=str_replace('<newreplypath>', $newreplypath, $postcomment);
			$fhl=getwordbit('forumhomelink');
			$fhl=str_replace('<sitename>', $sitename, $fhl);
			$forumhome="<a href=\"forums.php\">$fhl</a>";

			if ($isadmin==1 || $ismod==1) {
				$toolbar=str_replace('<threadcontrol>',
									 '<form action="topic.php" method="post">
									    <select name="action">
									      <option value="move">Move</option>
									      <option value="open">Open</option>
									      <option value="close">Close</option>
									      <option value="pin">Pin</option>
									      <option value="unpin">Unpin</option>
									      <option value="delete">Delete</option>
									    </select>
									    <input type="hidden" name="tpc[]" value="'.$id.'" />
									    <input type="submit" value="Go" />
									  </form>', $toolbar);
			}

			$toolbar=str_replace('<forumhome>', $forumhome, $toolbar);
			$toolbar=str_replace('<catlink>', $catlink, $toolbar);
			$toolbar=str_replace('<forumlink>', $forumlink, $toolbar);
			$toolbar=str_replace('<numposts>', $parentinfo['treplies'], $toolbar);
			$toolbar=str_replace('<numhits>', $parentinfo['topichits'], $toolbar);
			if ($parentinfo['isclosed']==0) {
				$toolbar=str_replace('<newcommentlink>', $postcomment, $toolbar);
			} else {
				$showquickreply=0;
			}
			$toolbar=str_replace('<topiclink>', $topicname, $toolbar);
		} elseif ($ident=='profile') {
			$t=$dbr->query("SELECT userid,displayname,profilehits FROM arc_user WHERE userid=$id");
			$parentinfo=$dbr->getarray($t);
			$numposts=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE parentid=$id AND parentident='profile'");
			if ($numposts=='')
				$numposts=0;

			$toolbar=getTemplate('profiletoolbar');
			$pc=getwordbit('postreply');
			$pc=str_replace('<id>', $id, $pc);
			$pc=str_replace('<ident>', 'profile', $pc);
			$userlink="<a href=\"user.php?action=profile&id=$id\">" .stripslashes($parentinfo['displayname']). "</a>";

			$toolbar=str_replace('<displayname>', $userlink, $toolbar);
			$toolbar=str_replace('<newcommentlink>', $pc, $toolbar);
			$toolbar=str_replace('<numposts>', $numposts, $toolbar);
			$toolbar=str_replace('<profilehits>', $parentinfo['profilehits'], $toolbar);
			$toolbar=str_replace('<newreplypath>', $newreplypath, $toolbar);
			$title=$parentinfo['displayname'];

			doHeader("$sitename: Viewing comments on " .stripslashes($parentinfo['displayname']));
		}

		if ($ident=='topic') {
			$check=$dbr->result("SELECT topicid FROM arc_topic WHERE topicid=$id");
		} elseif ($ident=='pagebit') {
			$check=$dbr->result("SELECT pagebitid FROM arc_pagebit WHERE pagebitid=$id");
		} elseif ($ident=='profile') {
			$check=$dbr->result("SELECT userid FROM arc_user WHERE userid=$id");
		}

		if (is_numeric($check)) { // start $check

		foreach($parentinfo as $key => $value)
			$toolbar=str_replace("<$key>", dbout($value), $toolbar);

		echo $toolbar;

		if (isset($pollhtml))
			echo $pollhtml;

		$limit=intval(getSetting('post_limit', 25));
		if (empty($offset))
			$offset='0';

		$numreplies=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE parentident='$ident' AND parentid=$id");

		if (isset($HTTP_GET_VARS['lastpage']))
			$offset=$numreplies-$limit;

		if ($offset<0)
			$offset=0;

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
				arc_user.*
					FROM arc_post,arc_user
					WHERE
				arc_post.parentident='$ident'
				AND arc_post.parentid=$id
				AND arc_user.userid=arc_post.postuserid
					ORDER BY
				arc_post.postdate
					ASC LIMIT $offset,$limit");

		if ($ident=='topic') {
			$fid=$dbr->result("SELECT tforumid FROM arc_topic WHERE topicid=$id");
			$modid=$dbr->result("SELECT modid FROM arc_forum WHERE forumid=$fid");
		}

		$theposts=getTemplate('post');
		$temp='';
		if ($ident=='pagebit') {
			$postrow=getTemplate('pagebitrow');
		} elseif ($ident=='topic') {
			$postrow=gettemplate('postrow');
		} elseif ($ident=='profile') {
			$postrow=gettemplate('profilerow');
		}

		if ($dbr->numrows($limited)>0) {

			while ($posts=$dbr->getarray($limited)) {
				$npostrow=$postrow;

				$pst=array();

				$npostrow=altbgcolor($npostrow);

				if ($viewposttemps==1) {
					if ($posts['access']>1 || getSetting('allowhtml')==1 || getSetting('allow_html_in_post_templates')==1) {
						$allowhtml=1;
					} else {
						$allowhtml=0;
					}
					$pst['post_header']=format_text($posts['post_header'], $allowhtml);
					$pst['post_footer']=format_text($posts['post_footer'], $allowhtml);
				}

				$pst['post_count']=number_format($posts['post_count']);
				$pst['note_count']=number_format($posts['note_count']);
				$pst['email']=htmlspecialchars($posts['email']);
				$pst['homepage']=htmlspecialchars($posts['homepage']);
				$pst['thread_count']=number_format($posts['topics']);
				$pst['rank']=stripslashes($posts['rank']);
				$pst['posted']=formdate($posts['postdate'], getSetting('post_timestamp'));
				$pst['postid']=$posts['postid'];
				$pst['posttitle']=stripslashes(htmlspecialchars($posts['posttitle']));
				$pst['postcontent']=stripslashes(nl2br(unfilter(parseurl(dehtml(bbcode_replace($posts['postcontent'])), $posts['parseurls']))));
				$pst['userid']=$posts['userid'];
				$pst['displayname']=stripslashes(htmlspecialchars($posts['displayname']));
				$pst['avatar']=stripslashes(htmlspecialchars($posts['avatar']));
				$pst['usertext']=stripslashes(htmlspecialchars($posts['usertext']));
				$pst['occupation']=stripslashes(htmlspecialchars($posts['occupation']));
				$pst['location']=stripslashes(htmlspecialchars($posts['location']));

				if (empty($showquickreply))
					$showquickreply=0;

				if ($showquickreply==1 && getSetting('showquickreply')==1 && $loggedin==1)
					$pst['quickreplylink']=$quickreplylink;

				foreach ($pst as $key=>$val)
					$npostrow=str_replace("<$key>", $val, $npostrow);

				if (getSetting('rpg_flag')==1) {
					$levxp=getlevxp($posts['level']);

					$levminus=getlevxp($posts['level']-1);
					if ($posts['level']==1)
						$levminus=0;
					$eexp=$posts['exp']-$levminus;
					$fexp=$levxp-$levminus;
					$rpg['hp_pct']=round(($posts['curhp'] / $posts['hp']) * 100);
					$rpg['hp_pct_leftover']=100 - $rpg['hp_pct'];
					$rpg['mp_pct']=round(($posts['curmp'] / $posts['mp']) * 100);
					$rpg['mp_pct_leftover']=100 - $rpg['mp_pct'];
					if ($fexp==0)
						$rpg['xp_pct']=0;
					else
						$rpg['xp_pct']=round(($eexp / $fexp) * 100);

					$rpg['xp_pct_leftover']=100 - $rpg['xp_pct'];

					$rpg['forlevelup']=number_format($levxp-$posts['exp']);
					$rpg['levxp']=number_format($levxp);
					$rpg['exp']=number_format($posts['exp']);
					$rpg['gold']=number_format($posts['gold']);

					$rpg['hp']=$posts['hp'];
					$rpg['mp']=$posts['mp'];
					$rpg['curhp']=$posts['curhp'];
					$rpg['curmp']=$posts['curmp'];
					$rpg['strength']=$posts['strength'];
					$rpg['endurance']=$posts['endurance'];
					$rpg['dexterity']=$posts['dexterity'];
					$rpg['intelligence']=$posts['intelligence'];
					$rpg['will']=$posts['will'];
					$rpg['level']=$posts['level'];
					$rpg['exp']=number_format($posts['exp']);
					$rpg['levxp']=number_format(getlevxp($posts['level']));
					$rpg['forlevelup']=number_format(getlevxp($posts['level'])-$posts['exp']);

					foreach ($rpg as $key=>$val)
						$npostrow=str_replace("<$key>", $val, $npostrow);

				}

				$temp.=$npostrow;
			}
			$theposts=str_replace('<pagelinks>', pagelinks($limit,$numreplies,$offset,'Post'), $theposts);
			echo str_replace('<postrow>', $temp, $theposts);
		}

		if ($numreplies>0) echo $toolbar;

		if (getSetting('showquickreply') && $showquickreply==1 && $loggedin==1) {
			$qr=str_replace('<userid>', $userid, getTemplate('quickreplyform'));
			$qr=str_replace('<username>', addslashes($displayname), $qr);
			$qr=str_replace('<parentid>', $id, $qr);
			$qr=str_replace('<parentident>', $ident, $qr);
			$qr=str_replace('<posttitle>', $title, $qr);
			echo $qr;
		}

		} else { // end $check
			showmsg('post_noid');
		}
}

?>