<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE
<!-- Template site_header -->

<html>

<head>
<title>$insert[page_title]</title>

<meta name="GENERATOR" content="CMS" />
<meta name="KEYWORDS" content="$insert[page_keywords]" />
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />

<style type="text/css">
.textbox {
        SCROLLBAR-FACE-COLOR: #cccccc; FONT-SIZE: x-small; BACKGROUND: white; SCROLLBAR-HIGHLIGHT-COLOR: #ffffff; SCROLLBAR-SHADOW-COLOR: #ffffff; COLOR: #000000; SCROLLBAR-3DLIGHT-COLOR: #ffffff; SCROLLBAR-ARROW-COLOR: #000000; SCROLLBAR-TRACK-COLOR: #ffffff; FONT-FAMILY: Verdana,Arial,Helvetica; SCROLLBAR-DARKSHADOW-COLOR: #ffffff; TEXT-ALIGN: left
}
TD {
        FONT-SIZE: 10pt; FONT-FAMILY: Verdana,Arial,Helvetica
}
BODY {
        FONT-SIZE: 10pt; FONT-FAMILY: Verdana,Arial,Helvetica
}
</style>

</head>

<body text="#000000" vlink="#004364" alink="#004364" link="#004364" bgcolor="#66ff99" leftmargin="0" topmargin="5" rightmargin="0">

<script language="JavaScript">
<!--
function FullWin(tag) {
   var newWinObj = window.open(tag,'newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=950,height=680')
}
function addNetscapePanel() {
   if ((typeof window.sidebar == "object") && (typeof window.sidebar.addPanel == "function"))
   {
       window.sidebar.addPanel ("$insert[site_name]", "$insert[site_url]/sidebar.php","");
   }
   else
   {
       var rv = window.confirm ("This page is enhanced for use with Mozilla.  " + "Would you like to upgrade now?");
   if (rv)
       document.location.href = "http://www.mozilla.org";
   }
   }
//-->
</script>

<br />
<br />
<table cellspacing="0" cellpadding="3" width="90%" align="center" bgcolor="#33ccff" border="0">
        <tr>
                <td>
                <table cellspacing="0" cellpadding="1" width="100%" bgcolor="#33ccff" border="0">
                        <tr>
                                <td>
                                <table cellspacing="0" cellpadding="2" width="100%" bgcolor="#33ccff" border="0">
                                        <tr>
                                                <td>
                                                <img src="images/logo.png" alt="Esselbach Storyteller CMS System" border="0" /></a>
                                                </td>
                                        </tr>
                                </table>
                                </td>
                        </tr>
                </table>
                </td>
        </tr>
        <tr bgcolor="#000000">
                <td bgcolor="#000080" colspan="2">
                <font face="Arial" color="#ffffff" size="2"><b>STORYTELLER CMS SYSTEM</b></font></td>
        </tr>
        <tr>
                <td valign="top" width="100%" bgcolor="#0066ff">
                <table cellspacing="0" cellpadding="2" width="100%" border="0">
                        <tr>
                                <td valign="top" width="160" bgcolor="#0066ff">
                                <table cellspacing="0" cellpadding="0" width="160" bgcolor="#000000" border="0">
                                        <tr>
                                                <td>
                                                <table cellspacing="1" cellpadding="3" width="100%" border="0">
                                                        <tr>
                                                                <td bgcolor="#008000">
                                                                <font face="Arial" color="#ffffff" size="2"><b>Main Menu</b></font></td>
                                                        </tr>
                                                        <tr>
                                                                <td bgcolor="#ffffff"><font size="2">
                                                                <li><a href="index.php">Home Page</a><br /></li>
                                                                <li><a href="category.php">News Category</a><br /></li>
                                                                <li><a href="archive.php">News Archive</a><br /></li>
                                                                <li><a href="mailinglist.php">Mailing List</a><br /></li>
                                                                <li><a href="comments.php">Comments</a><br /></li>
                                                                <li><a href="review.php">Reviews</a></li>
                                                                <li><a href="faq.php">FAQ</a><br /></li>
                                                                <li><a href="poll.php">Polls</a></li>
                                                                <li><a href="download.php">Downloads</a></li>
                                                                <li><a href="glossary.php">Glossary</a></li>
                                                                <li><a href="link.php">Web Links</a><br /></li>
                                                                <li><a href="search.php">Search</a></li>
                                                                <li><a href="ticket.php">Trouble Ticket</a></li>
                                                                <li><a href="submitstory.php">Submit News</a></li>
                                                                <li><a href="submitdownload.php">Submit File</a></li>
                                                                <li><a href="page.php">Pages</a></li>
                                                                <li><a href="plan.php">Plans</a></li>
                                                                </font></td>
                                                        </tr>
                                                </table>
                                                </td>
                                        </tr>
                                </table>
                                <br />
                                <table cellspacing="0" cellpadding="0" width="160" bgcolor="#000000" border="0">
                                        <tr>
                                                <td>
                                                <table cellspacing="1" cellpadding="3" width="100%" border="0">
                                                        <tr>
                                                                <td bgcolor="#008000">
                                                                <font face="Arial" color="#ffffff" size="2"><b>User</b></font></td>
                                                        </tr>
                                                        <tr>
                                                                <td bgcolor="#ffffff"><font size="2">
                                                                <li><a href="register.php">Register</a><br /></li>
                                                                <li><a href="login.php">Login</a><br /></li>
                                                                <li><a href="logout.php">Logout</a><br /></li>
                                                                <li><a href="upanel.php">Profile</a><br /></li>
                                                                </font></td>
                                                        </tr>
                                                </table>
                                                </td>
                                        </tr>
                                </table>
                                <br />
                                <table cellspacing="0" cellpadding="0" width="160" bgcolor="#000000" border="0">
                                        <tr>
                                                <td>
                                                <table cellspacing="1" cellpadding="3" width="100%" border="0">
                                                        <tr>
                                                                <td bgcolor="#008000">
                                                                <font face="Arial" color="#ffffff" size="2"><b>News Feeds</b></font></td>
                                                        </tr>
                                                        <tr>
                                                                <td bgcolor="#ffffff"><font size="2">
                                                                <li><a href="mobile.php">Handheld/PDA</a><br /></li>
                                                                <li><a href="backend.php?action=help">XML News Feeds</a><br /></li>
                                                                <li><a href="sidebar.php" target="_blank">View Sidebar</a><br /></li>
                                                                <li><a href="javascript:addNetscapePanel();">Mozilla Sidebar</a><br /></li>
                                                                </font></td>
                                                        </tr>
                                                </table>
                                                </td>
                                        </tr>
                                </table>

                        </td>
                        <td>&nbsp; </td>
                        <td valign="top" width="85%">

TEMPLATE;
?>
