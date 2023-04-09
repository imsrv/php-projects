<?php

$templates='forums_menu,findpostlist,findpostlistrow,';
$settings='find_postsperpage,find_truncatewords,post_timestamp,';
$wordbits='find_noposts,find_msg_parent_pagebit,find_msg_parent_topic,find_msg_parent_profile,find_msg_postsbyid,find_title_postbyid,';
$wordbits.='text_truncated,';

if (isset($HTTP_GET_VARS['todays_posts']) || isset($HTTP_GET_VARS['unread_posts'])) $isforum=1;
include('./lib/config.php');

if (isset($HTTP_GET_VARS['postid'])) {
	$postuserid=validate_number($HTTP_GET_VARS['postid']);
	$action='posts';
	$titletext=getwordbit('find_title_postbyid');
	$listmsg=str_replace('<displayname>', getdisplayname($postuserid), getwordbit('find_msg_postsbyid'));
	$findpostlist=str_replace('<findpostlist>', $listmsg, getTemplate('findpostlist'));
	$numrows=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE postuserid=$postuserid");
} elseif(isset($HTTP_GET_VARS['todays_posts'])) {
	$listmsg='Viewing Posts From the Last 24 Hours';
	$findpostlist=getTemplate('findpostlist');
	$titletext="$sitename: Viewing Posts From the Last 24 Hours";
} elseif(isset($HTTP_GET_VARS['unread_posts'])) {
	$listmsg='Viewing Posts Since Your Last Visit';
	$findpostlist=getTemplate('findpostlist');
	$titletext="$sitename: Viewing Posts Since Your Last Visit";
}

doHeader(str_replace('<sitename>', $sitename, $titletext));

switch ($action) {
	case 'posts':
		$posthtml='';
		$row=getTemplate('findpostlistrow');

		$limit=getSetting('find_postsperpage');
		$offset=getoffset();
		if (isset($HTTP_GET_VARS['todays_posts'])) {
			$handle=$dbr->query("SELECT * FROM arc_post WHERE postdate>=".(time()-60*60*24)." ORDER BY postdate DESC LIMIT $offset,$limit");
			$numrows=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE postdate>=".(time()-60*60*24));
		} elseif (isset($HTTP_GET_VARS['unread_posts'])) {
			$handle=$dbr->query("SELECT * FROM arc_post WHERE postdate>=$lastread ORDER BY postdate DESC LIMIT $offset,$limit");
			$numrows=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE postdate>=$lastread");
		} else {
			$handle=$dbr->query("SELECT * FROM arc_post WHERE postuserid=$postuserid ORDER BY postdate DESC LIMIT $offset,$limit");
		}

		while ($data=$dbr->getarray($handle)) {
			$prow=str_replace('<postuserid>', $data['postuserid'], $row);
			$prow=str_replace('<postcontent>', truncatewords(format_text($data['postcontent']), getSetting('find_truncatewords')), $prow);
			$prow=str_replace('<postdate>', formdate($data['postdate'], getSetting('post_timestamp')), $prow);
			$prow=str_replace('<displayname>', htmlspecialchars(stripslashes($data['postusername'])), $prow);

			switch ($data['parentident']) {
				case 'topic':
					$msg=str_replace('<postid>', $data['postid'], getwordbit('find_msg_parent_topic'));
					$msg=str_replace('<topicid>', $data['parentid'], $msg);
					break;

				case 'pagebit':
					$msg=str_replace('<postid>', $data['postid'], getwordbit('find_msg_parent_pagebit'));
					$msg=str_replace('<topicid>', $data['parentid'], $msg);
					break;

				case 'profile':
					$msg=str_replace('<postid>', $data['postid'], getwordbit('find_msg_parent_profile'));
					$msg=str_replace('<topicid>', $data['parentid'], $msg);
					break;
			}
			$prow=str_replace('<msg>', stripslashes($msg), $prow);
			$prow=altbgcolor($prow);
			$posthtml.=$prow;
		}
		if ($numrows==0) {
			showmsg('find_noposts');
		} else {
			$findpostlist=str_replace('<msg>', $listmsg, $findpostlist);
			$findpostlist=str_replace('<pagelinks>', pagelinks($limit,$numrows,$offset, 'post'), $findpostlist);
			$findpostlist=str_replace('<totalposts>', number_format($numrows), $findpostlist);
			echo str_replace('<findpostlistrows>', $posthtml, $findpostlist);
		}
		break;

	default:
		showmsg('find_noarguments');
		break;

}


footer();

?>