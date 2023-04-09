<?php


/************************************************************/
/* Theme Name: Amalfi (v1.0)                               */
/* Theme Developer: Dezina(http://www.dezina.com)           */
/*							                  */
/* Suitable for PHP Nuke 5.3/5.4                           */
/* Created: 13th February 2002                             */
/* Updated to PHPNuke 5.5 by dezina.com 29th March 2002     */
/************************************************************/


$thename = "Amalfi";
$lnkcolor = "#336699";
$bgcolor1 = "#FFFFFF";
$bgcolor2 = "#A8CEEE";
$bgcolor3 = "#808080";
$textcolor1 = "#000000";
$textcolor2 = "#000000";
$hr = 1; # 1 to have horizonal rule in comments instead of table bgcolor

function OpenTable() {
    global $bgcolor1, $bgcolor2;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\"><tr><td>\n";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\" align=\"center\"><tr><td>\n";
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
}

function CloseTable() {
    echo "</td></tr></table></td></tr></table>\n";
}

function CloseTable2() {
    echo "</td></tr></table></td></tr></table>\n";
}

function FormatStory($thetext, $notes, $aid, $informant) {
    global $anonymous;
    if ($notes != "") {
	$notes = "<br><br><b>"._NOTE."</b> $notes\n";
    } else {
	$notes = "";
    }
    if ("$aid" == "$informant") {
	echo "<font class=\"content\" color=\"#505050\">$thetext$notes</font>\n";
    } else {
	if($informant != "") {
	    $boxstuff = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= "".translate("writes")." \"$thetext\"$notes\n";
	echo "<font class=\"content\" color=\"#505050\">$boxstuff</font>\n";
    }
}

function themeheader() {
    global $user,$banners, $sitename, $slogan, $cookie, $prefix,$bgcolor1, $bgcolor2, $bgcolor3, $dbi;
    cookiedecode($user);
    $username = $cookie[1];
    if ($username == "") {
        $username = "Anonymous";
    }
// COPYRIGHTS
    echo "<!----- PLEASE DO NOT REMOVE COPYRIGHT NOTICE ----->\n";
    echo "<!----- NEED CUSTOM DESIGNS? VISIT WWW.DEZINA.COM ----->\n";
    echo "<!----- Copyright (c) 2002 Dezina.com ----->\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";

    echo "<body bgcolor=$bgcolor1 text=\"000000\" link=\"363636\" vlink=\"363636\">";


echo ""
."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"themes/Amalfi/images/LogoMiddle.gif\">
  <tr>
    <td rowspan=\"2\" width=\"210\"><img src=\"themes/Amalfi/images/LogoLeft.gif\" width=\"210\" height=\"100\"></td>
    <td rowspan=\"2\" width=\"10\"><img src=\"themes/Amalfi/images/LogoMiddle.gif\" width=\"30\" height=\"100\"></td>
    <td height=\"30\">
	<font class=\"content\" size=\"4\" color=\"808080\">


	    </td>
  </tr>
  <tr>
    <td height=\"70\">";

    if ($banners) {
	include("banners.php");
    }

echo "
    </td>
  </tr>
  <tr>
    <td colspan=\"2\" background=\"themes/Amalfi/images/MenuBack.gif\">
	<img src=\"themes/Amalfi/images/LogoBottom.gif\" width=\"220\" height=\"50\"></td>
    <td align=\"right\" background=\"themes/Amalfi/images/MenuBack.gif\">
      <table width=\"475\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td width=\"95\"><a href=\"index.php\"><img src=\"themes/Amalfi/images/MenuIndex.gif\" width=\"95\" height=\"50\" border=\"0\" alt=\"Home\"></a></td>
	<td width=\"95\"><a href=\"modules.php?name=Your_Account\"><img src=\"themes/Amalfi/images/MenuAccount.gif\" width=\"95\" height=\"50\" border=\"0\" alt=\"Account\"></a></td>
	<td width=\"95\"><a href=\"modules.php?name=Topics\"><img src=\"themes/Amalfi/images/MenuTopics.gif\" width=\"95\" height=\"50\" border=\"0\" alt=\"Topics\"></a></td>
	<td width=\"95\"><a href=\"modules.php?name=Submit_News\"><img src=\"themes/Amalfi/images/MenuNews.gif\" width=\"95\" height=\"50\" border=\"0\" alt=\"Submit News\"></a></td>
	<td width=\"95\"><a href=\"modules.php?name=Downloads\"><img src=\"themes/Amalfi/images/MenuDownload.gif\" width=\"95\" height=\"50\" border=\"0\" alt=\"Downloads\"></a></td>
	</tr>
      </table>
    </td>
  </tr>
</table>";
/**************************/
/*	Start Calendar	*/
/*		           */
/***********************/

echo "</tr></table>\n"
	."<table cellpadding=\"0\" cellspacing=\"0\" width=\"750\" border=\"0\" align=\"center\" bgcolor=\"#fefefe\">\n"
	."<tr>\n"
	."<td bgcolor=\"#FFFFFF\" colspan=\"4\"><IMG src=\"themes/Amalfi/images/pixel.gif\" width=\"1\" height=1 alt=\"\" border=\"0\" hspace=\"0\"></td>\n"
	."</tr>\n"
	."<tr valign=\"middle\" bgcolor=\"#FFFFFF\">\n"
	."<td width=\"15%\" nowrap><font class=\"content\" color=\"#363636\">\n";

       if ($username == "Anonymous") {
		echo "&nbsp;&nbsp;<font color=\"#363636\"><a href=\"modules.php?name=Your_Account\">Create</a></font> an account\n";
	    } else {
			echo "&nbsp;&nbsp;Welcome $username! &nbsp;&nbsp;<a href=\"modules.php?name=Your_Account&op=logout\">logout</a>";
	    }
    echo "</font></td>\n"
	."<td align=\"center\" height=\"20\" width=\"60%\"><font class=\"content\">\n"
        ."&nbsp;\n"
        ."</td>\n"
        ."<td align=\"right\" width=\"25%\"><font class=\"content\">\n"
        ."<script type=\"text/javascript\">\n\n"
        ."<!--   // Array ofmonth Names\n"
        ."var monthNames = new Array( \"January\",\"February\",\"March\",\"April\",\"May\",\"June\",\"July\",\"August\",\"September\",\"October\",\"November\",\"December\");\n"
        ."var now = new Date();\n"
        ."thisYear = now.getYear();\n"
        ."if(thisYear < 1900) {thisYear += 1900}; // corrections if Y2K display problem\n"
        ."document.write(monthNames[now.getMonth()] + \" \" + now.getDate() + \", \" + thisYear);\n"
        ."// -->\n\n"
        ."</script></font></td>\n"
        ."<td>&nbsp;</td>\n"
        ."</tr>\n";
/**************************/
/*	End Calendar	*/
/*		           */
/***********************/


echo "<table border=\"0 cellpadding=\"4\" cellspacing=\"0\" width=\"100%\" align=\"center\">\n"
	."<tr><td bgcolor=$bgcolor3 height=1></td></tr>\n"
        ."<tr><td valign=\"top\" width=\"100%\">\n"
        ."<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\"><tr><td valign=\"top\" width=\"150\" bgcolor=$bgcolor1>";
	blocks(left);
	echo "<img src=\"images/pix.gif\" border=\"0\" width=\"150\" height=\"1\"></td><td>&nbsp;&nbsp;</td><td width=\"100%\" valign=\"top\">";
}

function themefooter() {
    global $index, $bgcolor1, $bgcolor2, $bgcolor3;
    if ($index == 1) {
	echo "</td><td>&nbsp;&nbsp;</td><td valign=\"top\" bgcolor=$bgcolor1>";
	blocks(right);
	echo "</td>";
    }
    echo "</td></tr></table></td></tr></table>";

    footmsg();

}

/************************************************************/
/* Function themeindex()                                    */
/*                                                          */
/* This function format the stories on the Homepage         */
/************************************************************/

function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
    global $anonymous, $tipath;
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#ffffff\" width=\"420\"><tr><td>\n"
	."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" bgcolor=\"#000000\" width=\"100%\"><tr><td>\n"
	."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" bgcolor=\"#CEE4F6\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\" color=\"#363636\"><b>$title</b></font>\n"
	."</td></tr></table></td></tr></table>\n"
	."<font color=\"#999999\"><b><a href=\"modules.php?name=News&amp;new_topic=$topic\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"10\" vspace=\"10\"></a></B></font>\n";
    FormatStory($thetext, $notes, $aid, $informant);
    echo "</td></tr></table><br>\n"
	."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" bgcolor=\"#eeeeee\" width=\"100%\"><tr><td>\n"
	."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" bgcolor=\"#ffffff\" width=\"100%\"><tr><td align=\"center\">\n"
	."<font color=\"#999999\" size=\"1\">"._POSTEDBY." ";
    formatAidHeader($aid);
    echo " "._ON." $time $timezone ($counter "._READS.")<br></font>\n"
	."<font class=\"content\">$morelink</font>\n"
	."</td></tr></table></td></tr></table>\n"
	."<br>\n\n\n";
}

/************************************************************/
/* Function themeindex()                                    */
/*                                                          */
/* This function format the stories on the story page, when */
/* you click on that "Read More..." link in the home        */
/************************************************************/

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid, $tipath;
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#ffffff\" width=\"100%\"><tr><td>\n"
        ."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" bgcolor=\"#000000\" width=\"100%\"><tr><td>\n"
        ."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" bgcolor=\"#C6C6C6\" width=\"100%\"><tr><td align=\"left\">\n"
        ."<font class=\"option\" color=\"#363636\"><b>$title</b></font><br>\n"
        ."<font class=\"content\">"._POSTEDON." $datetime "._BY." ";
    formatAidHeader($aid);
    if (is_admin($admin)) {
	echo "<br>[ <a href=\"admin.php?op=EditStory&amp;sid=$sid\">"._EDIT."</a> | <a href=\"admin.php?op=RemoveStory&amp;sid=$sid\">"._DELETE."</a> ]\n";
    }
    echo "</td></tr></table></td></tr></table><br>";
    echo "<a href=\"modules.php?name=Search&query=&topic=$topic\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"10\" vspace=\"10\"></a>\n";
    FormatStory($thetext, $notes="", $aid, $informant);
    echo "</td></tr></table><br>\n\n\n";
}
function themesidebox($title, $content) {
	global $bgcolor1, $bgcolor2, $bgcolor3;
    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"150\" bgcolor=$bgcolor3>\n"
	."<tr><td>\n"
        ."<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n"
	."<tr><td bgcolor=$bgcolor2>"
        ."<h3>$title</h3></td></tr><tr><td bgcolor=$bgcolor1><font class=\"content\">\n"
        ."$content"
	."</font></td></tr></table></td></tr></table><br>";
}

?>