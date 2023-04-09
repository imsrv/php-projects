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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Folder List</title>
<link href="<?php echo "themes/" . $Theme . "/";?>folder.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" align="center" class="OutlookHead"><TR><td align="center" valign="top"><strong><?php echohtml ($HEAD_Folders);?></strong></td></TR></TABLE>
<p align="center"><A HREF="list.php" target="List"><img src="<?php echo "themes/" . $Theme;?>/images/folder/inbox.gif" width="32" height="32" alt="X" border="0" hspace="0" vspace="0"><BR><?php echohtml ($ICON_Inbox);?></A></p>
<p align="center"><a href="<?php echo "lang/" . $Language . "/help";?>" target="List"><img src="<?php echo "themes/" . $Theme;?>/images/folder/help.gif" width="32" height="32" alt="X" border="0" hspace="0" vspace="0"><BR><?php echohtml ($ICON_Help);?></a></p>
<p align="center"><a href="./" target="_top"><img src="<?php echo "themes/" . $Theme;?>/images/folder/logout.gif" width="32" height="32" alt="X" border="0" hspace="0" vspace="0"><BR><?php echohtml ($ICON_Logout);?></a></p>
</body>
</html>
