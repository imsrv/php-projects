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

session_start();
if (session_is_registered ('From') and session_is_registered ('Subject') 
and session_is_registered ('Time') and session_is_registered ('IsAttach')
and session_is_registered ('MsgNum') and session_is_registered('MessageText')) {

$MSubject = $HTTP_SESSION_VARS['Subject'];
$MText = $HTTP_SESSION_VARS['MessageText'];
$mnum = $HTTP_SESSION_VARS['MsgNum'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Message</title>
<link href="<?php echo "themes/" . $Theme . "/";?>message.css" rel="stylesheet" type="text/css"></head>
<body>
<table border="0" cellspacing="0" cellpadding="0" style="height: 100%;">
<tr>
	<td align="left" valign="middle">
		<form action="send.php" method="post" target="Message" style="border: 0pt; margin: 2px; padding: 0pt;">
			<input type="hidden" name="MSG" value="<?php echo (htmlentities (addcslashes ($MText, "\0..\37!@\177..\377")));?>">
			<input type="hidden" name="TO" value="<?php echohtml ($HTTP_SESSION_VARS['From']);?>">
			<input type="hidden" name="SUB" value="<?php echohtml ($MSubject);?>">
			<input type="submit" value="<?php echo $BUTTON_Reply;?>" onMouseOver="window.status = '<?php echo $STATBAR_Reply;?>'; return true;" onMouseOut="window.status = ''; return true;">
		</form>
	</td>
	<td align="left" valign="middle">
		<form action="send.php" method="post" target="Message" style="border: 0pt; margin: 2px; padding: 0pt;">
			<input type="hidden" name="MSG" value="<?php echo (htmlentities (addcslashes ($MText, "\0..\37!@\177..\377")));?>">
			<input type="hidden" name="TO" value="">
			<input type="hidden" name="SUB" value="<?php echo $MSubject;?>">
			<input type="submit" value="<?php echo $BUTTON_Forward;?>" onMouseOver="window.status = '<?php echo $STATBAR_Forward;?>'; return true;" onMouseOut="window.status = ''; return true;">
		</form>
	</td>
	<td align="left" valign="middle">
		<form action="delete.php" method="post" target="List" style="border: 0pt; margin: 2px; padding: 0pt;">
			<input type="hidden" name="MSG" value="<?php echo $mnum;?>">
			<input type="submit" value="<?php echo $BUTTON_Delete;?>" onMouseOver="window.status = '<?php echo $STATBAR_Delete;?>'; return true;" onMouseOut="window.status = ''; return true;">
		</form>
	</td>
	<td align="left" valign="middle">
		<form action="sourceview.php" method="post" target="msg" style="border: 0pt; margin: 2px; padding: 0pt;">
			<input type="hidden" name="MSG" value="<?php echo $mnum;?>">
			<input type="submit" value="<?php echo $BUTTON_Source;?>" onMouseOver="window.status = '<?php echo $STATBAR_Source;?>'; return true;" onMouseOut="window.status = ''; return true;">
		</form>
	</td>
	<?php if ($HTTP_SESSION_VARS['IsAttach']) {?>
	<td align="left" valign="middle">
		<form action="viewattach.php" method="post" target="msg" style="border: 0pt; margin: 2px; padding: 0pt;">
			<input type="hidden" name="MSG" value="<?php echo $mnum;?>">
			<input type="submit" value="<?php echo $BUTTON_Attachments;?>" onMouseOver="window.status = '<?php echo $STATBAR_Attachments;?>'; return true;" onMouseOut="window.status = ''; return true;">
		</form>
	</td>
	<?php } ?>
</tr>
</table>

</body>
</html>
<?php
} else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
