<?php

$templates='privatemsg,privatemsgrow,post,postrow,';
$wordbits='pm_recipient,pm_msgtitle,pm_msgcontent,pm_submit,pm_reset,pm_replymsg,deletepm,pmsent,pm_deleted,';

include('./lib/config.php');

$pmenu=getTemplate('privatemsgmenu');
$header=str_replace("<privatemsgmenu>", $pmenu, $header);
doHeader("$sitename Private Messages: $actn");

if ($action=='news') $action='inbox';
switch ($action) {
	case 'inbox':
		if ($loggedin==1) {
			if (isset($HTTP_GET_VARS['sent'])) {
				$sent="senderid=$userid";
				$page = 'Sent Messages';
			} else {
				$sent="recipientid=$userid";
				$page = 'Inbox';
			}
			$pmq=$dbr->query("SELECT privatemsgid,msgtitle,senderid,recipientid,msgdate,isread FROM arc_privatemsg WHERE $sent ORDER BY msgdate");
			$privatemsgs=str_replace('<page>', $page, getTemplate('privatemsg'));
			$pmtemp='';
			$pmrow=getTemplate('privatemsgrow');
			while ($pminfo=$dbr->getarray($pmq)) {
				if (isset($HTTP_GET_VARS['sent'])) {
					$un=$dbr->result("SELECT displayname FROM arc_user WHERE userid=$pminfo[recipientid]");
				} else {
					$un=$dbr->result("SELECT displayname FROM arc_user WHERE userid=$pminfo[senderid]");
				}

				if (isset($HTTP_GET_VARS['sent'])) {
					$sender="<a href=\"user.php?action=profile&id=$pminfo[recipientid]\">$un</a>";
				} else {
					$sender="<a href=\"user.php?action=profile&id=$pminfo[senderid]\">$un</a>";
				}

				if ($pminfo['isread']==1) {
					$isread='Yes';
				} else {
					$isread='No';
				}

				$apmrow=str_replace('<msgtitle>', "<a href=\"privatemsg.php?action=ViewMessage&id=$pminfo[privatemsgid]\">$pminfo[msgtitle]</a>", $pmrow);
				$apmrow=str_replace('<sender>', $sender, $apmrow);
				$apmrow=str_replace('<isread>', $isread, $apmrow);
				$dpm=getwordbit('deletepm');
				if ($pminfo['recipientid']==$userid) {
					$deleter="<a href=\"privatemsg.php?action=deletemessage&id=$pminfo[privatemsgid]\">$dpm</a>";
					$apmrow=str_replace('<deleter>', $deleter, $apmrow);
				}
				$apmrow=altbgcolor($apmrow);
				$pmtemp.=$apmrow;
			}
			echo str_replace('<privatemsgrow>', $pmtemp, $privatemsgs);
		} else {
			showmsg('pmnotloggedin');
		}
		break;
	case 'viewmessage':
		if (isset($HTTP_GET_VARS['id'])) {
			$n=$dbr->query("SELECT privatemsgid,senderid,recipientid,msgtitle,msgcontent,msgdate,isread FROM arc_privatemsg WHERE privatemsgid=$HTTP_GET_VARS[id]");
			$x=$dbr->getarray($n);
		} else {
			showmsg('privatemsg_noid');
			footer(1);
		}

		if (($loggedin==1 && $userid==$x['recipientid']) || ($loggedin==1 && $userid==$x['senderid'])) {
			$pmsg=getTemplate('post');
			$ptemp='';
			$privatemessagerow=getTemplate('postrow');

			if ($userid==$x['recipientid'])
				$dbr->query("UPDATE arc_privatemsg SET isread=1 WHERE privatemsgid=$HTTP_GET_VARS[id]");

			$replybtn="<form method=\"post\" action=\"privatemsg.php?action=Compose&id=$x[senderid]\">
					<input type=\"hidden\" name=\"msgid\" value=\"$x[privatemsgid]\" />
					<input type=\"hidden\" name=\"msgtitle\" value=\"$x[msgtitle]\" />
					<input type=\"submit\" value=\"" .getwordbit('pm_replymsg'). "\" /></form>";
			$pr=str_replace('<replybutton>', $replybtn, $privatemessagerow);

			$x['msgcontent']=stripslashes(nl2br(unfilter(parseurl(dehtml(bbcode_replace($x['msgcontent']))))));
			foreach($x as $key => $value) $pr=str_replace("<$key>", $value, $pr);

			$pr=altbgcolor($pr);

			$uquery=$dbr->query("SELECT * FROM arc_user WHERE userid=$x[senderid]");
			$usrinfo=$dbr->getarray($uquery);

			foreach($usrinfo as $key => $value)	$pr=str_replace("<$key>", stripslashes($value), $pr);

			$ptemp.=$pr;
			echo str_replace('<postrow>', $ptemp, $pmsg);
		}
		break;
	case 'compose':
		if ($loggedin==1) {
			if (isset($HTTP_GET_VARS['id'])) {
				$recipient=$HTTP_GET_VARS['id'];
			} else {
				$recipient='';
			}

			if (isset($msgtitle)) {
				$ptitle="Re: $msgtitle";
			} else {
				$ptitle='';
			}

			unset($pcontent);
			unset($quoteuser);

			if (isset($HTTP_POST_VARS['msgid'])) {
				$pcontent='[quote]'.$dbr->result("SELECT msgcontent FROM arc_privatemsg WHERE privatemsgid=$HTTP_POST_VARS[msgid]").'[/quote]';
				$pcontent=bbcode_replace($pcontent);
			} else {
				$pcontent='';
			}

			include('adminfunctions.php');
			$inputs[]=formtop('privatemsg.php?action=SendMessage');
			$inputs[]=inputform('users', getwordbit('pm_recipient'), 'recipientid', $recipient, 10, getwordbit('pm_recipient'));
			$inputs[]=inputform('text', getwordbit('pm_msgtitle'), 'msgtitle', stripslashes($ptitle));
			$inputs[]=inputform('textarea', getwordbit('pm_msgcontent'), 'msgcontent', stripslashes(bbcode_reverse($pcontent)));
			$inputs[]=inputform('submitreset', getwordbit('pm_submit'), getwordbit('pm_reset'), 'submit');

			foreach ($inputs as $value)
				echo "$value\n";

			formbottom();
		}
		break;

	case 'sendmessage':
		if ($loggedin==1 and $msgtitle!='' and $msgcontent!='' && $recipientid!='') {
			$doquery=1;
			if (is_numeric($recipientid)) {
				$recipientid=$recipientid;
			} else {
				$recipientid=$dbr->result("SELECT userid FROM arc_user WHERE username='$recipientid'");
			}
			if ($recipientid==0) {
				showmsg('pm_norecipient');
				$doquery=0;
			}
			if ($msgcontent=="" && $msgtitle=="") {
				showmsg('pm_emptyfields');
				$doquery=0;
			}
			if ($doquery==1) {
				$dbr->query("INSERT INTO arc_privatemsg SET
					senderid=$userid,
					recipientid=$recipientid,
					msgtitle='". insert_text($msgtitle). "',
					msgcontent='". insert_text($msgcontent). "',
					msgdate='". time(). "'");
				showmsg('pmsent');
			}
		} else {
			showmsg('cantsendpm');
		}
		break;

	case 'deletemessage':
		if ($loggedin==1) {
			if (isset($HTTP_GET_VARS['id'])) {
				$id=validate_number($HTTP_GET_VARS['id']);
			} elseif (isset($HTTP_POST_VARS['id'])) {
				$id=validate_number($HTTP_POST_VARS['id']);
			}

			$recid=$dbr->result("SELECT recipientid FROM arc_privatemsg WHERE privatemsgid=$id");
			if ($recid==$userid) {
				$dbr->query("DELETE FROM arc_privatemsg WHERE privatemsgid=$id");
				showmsg('pm_deleted');
			} else {
				showmsg('pm_nopermission');
			}
		}
		break;
}
$footer=str_replace('<privatemsgmenu>', $pmenu, $footer);

footer();

?>