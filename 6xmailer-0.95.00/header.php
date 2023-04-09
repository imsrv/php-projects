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
if (session_is_registered ('From') and session_is_registered ('Subject') and session_is_registered ('Time')) {

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Message</title>
<link href="<?php echo "themes/" . $Theme;?>/message.css" rel="stylesheet" type="text/css"></head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" align="center">
<TR><td align="left" valign="middle"><strong><?php echo $HEAD_From;?>:</strong> <?php echohtml ($HTTP_SESSION_VARS['From']);?></td></TR>
<TR><td align="left" valign="middle"><strong><?php echo $HEAD_Subject;?>:</strong> <?php echohtml ($HTTP_SESSION_VARS['Subject']);?></td></TR>
<TR><td align="left" valign="middle"><strong><?php echo $HEAD_When;?>:</strong> <?php echohtml ($HTTP_SESSION_VARS['Time']);?></td></TR>
</table>
</body>
</html>
<?php 
} else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
