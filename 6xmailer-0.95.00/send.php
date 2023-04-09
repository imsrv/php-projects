<?php
// =============================================================================
//	6XMailer - A PHP POP3 mail reader.
//	Copyright (C) 2001  6XGate Systems, Inc.
//	
//	This program is free software; you can redistribute it and/or
//	modify it under the terms of the GNU General Public License
//	as published by the Free Software Foundation; either version 2
//	of the License, or (at your option) any later version.
//	
//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.
//	
//	You should have received a copy of the GNU General Public License
//	along with this program; if not, write to the Free Software
//	Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
// ==============================================================================

require("config.php");
require ("functions.php");
require ("lang/" . $Language . "/strings.php");
require ("themes/" . $Theme . "/theme.php");

if ($DemoMode) {
	?><HTML><HEAD><TITLE></TITLE></HEAD><BODY><?php echo $ERROR_DemoMode; ?></BODY></HTML><?php
	return false;
}

session_start();
if (session_is_registered('Username') and session_is_registered('Password')) {

set_time_limit (0);

$Username = $HTTP_SESSION_VARS['Username'];
$Password = $HTTP_SESSION_VARS['Password'];

if (session_is_registered ('POPEMail') and session_is_registered ('DisName')) {
	$POPEMail = $HTTP_SESSION_VARS['POPEMail'];
	$DisName = $HTTP_SESSION_VARS['DisName'];
} else {?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
	<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML><?php
	exit ();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Sending a Message</title>
<link href="<?php echo "themes/" . $Theme;?>/send.css" rel="stylesheet" type="text/css"></head>
<body>
<?php
$mimesep = "6XG-6XG07-SXGSXGSXG=:-sxgsxg";
$mimeheader = "From: \"" . $DisName . "\" <" . $POPEMail . ">\r\n";

$mimeheader .= "MIME-Version: 1.0\r\n";
$mimeheader .= "Content-Type: multipart/mixed; BOUNDARY=\"" . $mimesep . "\"\r\n";
$mimeheader .= "X-Mailer: 6XMalier, Build " . $MajorVersion . "." . $MinorVersion . "." . $BuildVersion . "\r\n\r\n"; 

$newmessage = "--" . $mimesep . "\r\n";
$newmessage .= "Content-Type: text/plain ; CHARSET=US-ASCII\r\n";
$newmessage .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
$newmessage .= imap_8bit (stripslashes ($HTTP_POST_VARS['MSG']));

if ($HTTP_POST_FILES['FILE']['name']) {
	if ($AttachmentSize) {
		$izer = strtolower (substr ($AttachmentSize, strlen($AttachmentSize - 1), 1));
		switch ($izer) {
			case "m":
				$ASize = intval ($AttachmentSize) * 1048576;
				break;
			case "k";
				$ASize = intval ($AttachmentSize) * 1024;
				break;
			default:
				$ASize = intval ($AttachmentSize);
		}
		if ($HTTP_POST_FILES['FILE']['size'] > $ASize) {
			echo "<p>" . $FileTooBig . "</p>";
			exit ();
		} elseif ($HTTP_POST_FILES['FILE']['size'] == 0) {
			echo "<p>" . $FileTooBig . "</p>";
			exit ();
		}
	}

	if ($HTTP_POST_FILES['FILE']['size'] == 0) {
			echo "No File!?";
			exit ();
	}
	
	$fp = fopen ($HTTP_POST_FILES['FILE']['tmp_name'], "rb");
	$contents = fread ($fp, filesize ($HTTP_POST_FILES['FILE']['tmp_name']));
	fclose ($fp);

	$newmessage .= "\r\n\r\n--" . $mimesep . "\r\n";
	$newmessage .= "Content-Type: " . stripslashes ($HTTP_POST_FILES['FILE']['type']) . "; name=\"" . $HTTP_POST_FILES['FILE']['name'] . "\"\r\n";
	$newmessage .= "Content-Transfer-Encoding: base64\r\n";
	$newmessage .= "Content-Disposition: ATTACHMENT; filename=\"" . $HTTP_POST_FILES['FILE']['name'] . "\"\r\n\r\n";
	$newmessage .= imap_binary ($contents);
}

$newmessage .= "\r\n--" . $mimesep . "--\r\n\r\n";

if (stripslashes ($HTTP_POST_VARS['SEND'])) {
	mail(stripslashes ($HTTP_POST_VARS['TO']), stripslashes ($HTTP_POST_VARS['SUB']), $newmessage, $mimeheader );

?>
<P><?php echohtml($MISC_Sent);?></P>
<script language="JavaScript" type="text/javascript">
<!--
window.top.frames['List'].location='list.php';
//-->
</script>
<?php
} else {

	if (session_is_registered ('Signature')) {
		$body = "\r\n\r\n" . stripcslashes ($HTTP_SESSION_VARS['Signature']);
	}
	if ($HTTP_POST_VARS['TO']) {
		$to_array = imap_rfc822_parse_adrlist ($HTTP_POST_VARS['TO'], $POPDomain);
		$to = $to_array[0]->mailbox . "@" . $to_array[0]->host;
		if ($HTTP_POST_VARS['SUB']) {
			$subject = "Re: " . $HTTP_POST_VARS['SUB'];
		} else {
			$subject = "";
		}
	} else {
		$to = "";
		if ($HTTP_POST_VARS['SUB']) {
			$subject = "Fwd: " . $HTTP_POST_VARS['SUB'];
		} else {
			$subject = "";
		}
	}
	if ($HTTP_POST_VARS['MSG']) {
		$body .= "\r\n\r\n". $QuoteInReply . "\r\n" . $HTTP_POST_VARS['MSG'];
	} else {
		$body .= "";
	}
?>
<form action="send.php" method="post" enctype="multipart/form-data" name="sendform" id="sendform">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%;">

<tr><td><strong><?php echo $HEAD_From; ?></strong></td><td>&nbsp;&nbsp;<?php echo $DisName . " [" . $POPEMail . "]";?></td><td align="right" valign="middle"><input type="hidden" name="SEND" value="Ok"><input type="submit" value="<?php echo $BUTTON_Send;?>" title="<?php echo $STATBAR_Send;?>" onMouseOver="window.status = '<?php echo $STATBAR_Send;?>'; return true;" onMouseOut="window.status = ''; return true;"></td></tr>
<tr><td><strong><?php echo $HEAD_Attachment;?></strong></td><td colspan="2" align="left" valign="middle" style="width: 100%;">&nbsp;&nbsp;<input type="file" name="FILE" size="30" style="width: 98%;"></td></tr>
<tr><td><strong><?php echo $HEAD_To;?></strong></td><td align="left" width="100%" valign="middle" style="width: 100%;">&nbsp;&nbsp;<input type="text" name="TO" id="TO" size="30" value="<?php echo $to;?>" style="width: 95%;"></td><td nowrap><a href="addressbook.php" target="List"><?php echo $MISC_AddressBook; ?></a></td></tr>
<tr><td><strong><?php echo $HEAD_Subject;?></strong></td><td colspan="2">&nbsp;&nbsp;<input type="text" name="SUB" value="<?php echo htmlentities (stripcslashes ($subject));?>" size="30" style="width: 95%;"></td></tr>
<tr><td colspan="3" align="left" valign="top" style="height: 100%;"><?php
	if (stristr ($HTTP_SERVER_VARS['HTTP_USER_AGENT'], "msie")) { ?>
<textarea name="MSG" cols="60" rows="6" style="width: 100%; height: 95%;"><?php echo stripcslashes ($body);?></textarea>
<?php	} else {?>
<textarea cols="30" rows="6" name="MSG" style="width: 95%;"><?php echo stripcslashes ($body);?></textarea>
<?php	} 
?></td></tr>
</table>
</FORM>
<?php } ?>
</body>
</html>

<?php } else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
