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

require("../../config.php");
require ("../../functions.php");
require ("strings.php");
require ("../../themes/" . $Theme . "/theme.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>About <?php echo $MailSystemTitle;?></title>
<link href="<?php echo "../../themes/" . $Theme;?>/blank.css" rel="stylesheet" type="text/css">
</head>

<body class="ML">
<H1>About <?php echohtml ($MailSystemTitle);?></H1>
<p><img src="../../documents/images/6XMailerLogo.gif" width="284" height="47" alt="" border="0"></p>
<h2>v<?php echohtml($MajorVersion);?>.<?php echohtml($MinorVersion);?>.<?php echohtml($BuildVersion);?></h2>
<p><a href="http://www.php.net"><img src="../../images/php-small-black.gif" width="88" height="31" alt="Powered by PHP" border="0" hspace="0" vspace="0" align="left"></a>
This web-based mail reader is powered by PHP 4. Graphics were borrowed from various Microsoft programs.  Developed by 6XGate Systems, Inc.  Portions of the code for this script by <a href="mailto:cleong@organic.com">cleong@organic.com</a>.</p>
<P>This server is running for the domain <B><?php echohtml($POPDomain);?></B>.</P>
<p align="right"><a href="http://www.microsoft.com/windows/ie/default.htm"><img src="../../images/getielogo.gif" width="88" height="31" alt="Get Microsoft Interner Explorer" border="0" hspace="0" vspace="0"></a>&nbsp;
<a href="http://home.netscape.com"><img src="../../images/netscape_now_anim.gif" width="90" height="30" hspace="0" vspace="0" border="0" alt="Choose Netscape Now"></a>&nbsp;
<A href="http://validator.w3.org/"><IMG alt="Valid HTML 4.0!" border="0" height="31" src="../../images/vh40.gif" width="88" hspace="0" vspace="0"></A>&nbsp;
<A href="http://jigsaw.w3.org/css-validator"><IMG alt="Valid CSS!" src="../../images/vcss.gif" hspace="0" vspace="0" border="0" width="88" height="31"></A></p>
</body>
</html>
