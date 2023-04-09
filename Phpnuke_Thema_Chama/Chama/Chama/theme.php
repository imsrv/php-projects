<?php

// THEME NAME: Chama for PHP-Nuke 5.5
// Copyright (c) 2001-2002 Chama Naoufal (http://www.Chama.fr.fm)
// Based On MT theme

// Some theme color definitions 1 bordure
$bgcolor1 = "#FFFFFF";
$bgcolor2 = "#E2E2E2";
$bgcolor3 = "#FFFFFF";
$bgcolor4 = "#FFFFFF";
$textcolor1 = "#000000";
$textcolor2 = "#000000";

/************************************************************/


function OpenTable() {
    global $bgcolor1, $bgcolor2;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\"><tr><td>\n";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
}

function CloseTable() {
    echo "</td></tr></table></td></tr></table>\n";
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\" align=\"center\"><tr><td>\n";
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
}

function CloseTable2() {
    echo "</td></tr></table></td></tr></table>\n";
}

/************************************************************/


function FormatStory($thetext, $notes, $aid, $informant) {
    global $anonymous;
    if ($notes != "") {
	$notes = "<br><br><b>"._NOTE."</b> <i>$notes</i>\n";
    } else {
	$notes = "";
    }
    if ("$aid" == "$informant") {
	echo "<font class=\"content\" color=\"#000000\">$thetext$notes</font>\n";
    } else {
	if($informant != "") {
	    $boxstuff = "<a href=\"user.php?op=userinfo&amp;uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= "".translate("writes")." <i>\"$thetext\"</i>$notes\n";
	echo "<font class=\"content\" color=\"#000000\">$boxstuff</font>\n";
    }
}

/************************************************************/


function themeheader() {
    global $user, $banners, $sitename, $slogan, $cookie, $prefix;
    cookiedecode($user);
    $username = $cookie[1];
    if ($username == "") {
        $username = "Anonymous";
    }
    echo "<body topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" background=\"#000000\" bgcolor=\"#FFFFFF\" link=\"#000000\" vlink=\"#999999\" alink=\"#FFFFFF\">\n\n\n";
    if ($banners) {
	include("banners.php");
    }
    echo "<!----- Logo, Search and Topic Selection Table ----->\n"
    ."<table cellpadding=\"0\" cellspacing=\"0\" width=\"762\" border=\"0\" bgcolor=\"#ffffff\">\n"

	."<tr>\n"
	."<td bgcolor=\"#ffffff\" align=\"left\" width=\"33%\">\n"
	."<a href=\"index.php\"><img src=\"themes/Chama/images/logo.gif\" align=\"left\" alt=\""._WELCOMETO." $sitename\" border=\"0\"></a>\n"
	."</td>\n\n\n"

// Search Form
    ."<form action=\"modules.php?name=Search\" method=\"post\"><font class=\"content\" color=\"#000000\">\n"
    ."<td bgcolor=\"#ffffff\" align=\"right\" width=\"66%\">\n"
    ."<input type=\"text\" name=\"query\" size=\"14\">\n"
    ."<input type=\"submit\" value=\"Recherche\"></font>\n"
    ."</td>\n"
    ."</form>\n\n\n"
    ."</form>\n"
	."</tr>\n"
	."</table>\n\n\n"

	."<table width=\"762\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
	."<table border=\"0\" width=\"100%\" cellspacing=\"0\"><tr><td width=\"100%\"><a href=\"index.php\"><img border=\"0\" src=\"themes/Chama/images/accueil.gif\" width=\"50\" height=\"14\"></a><a href=\"modules.php?name=Topics\"><img border=\"0\" src=\"themes/Chama/images/journal.gif\" width=\"53\" height=\"14\"></a><a href=\"modules.php?name=Web_Links\"><img border=\"0\" src=\"themes/Chama/images/annuaire.gif\" width=\"60\" height=\"14\"></a></td></tr></table>\n"
	."</table>\n\n\n"
	."<p></p>\n"
	."<table width=\"762\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\" border=\"0\">\n"
	."<tr>\n"
	."<td width=\"50%\" nowrap><font class=\"content\" color=\"#FFFFFF\">\n";
    if ($username == "Anonymous") {
	echo "&nbsp;&nbsp;<font color=\"#ffffff\"><a href=\"modules.php?name=Your_Account\">Devenez</a></font> membre\n";
    } else {
	echo "&nbsp;&nbsp;Bienvenue $username!";
    }
    echo "</font></td>\n"
    ."<td align=\"right\" width=\"50%\"><font class=\"content\">\n"
    ."<script type=\"text/javascript\">\n\n"
    ."<!--   // Array ofmonth Names\n"
    ."var monthNames = new Array( \"Janvier\",\"Février\",\"Mars\",\"Avril\",\"Mai\",\"Juin\",\"Juillet\",\"Août\",\"Septembre\",\"Octobre\",\"Novembre\",\"Décembre\");\n"
    ."var now = new Date();\n"
    ."thisYear = now.getYear();\n"
    ."if(thisYear < 1900) {thisYear += 1900}; // corrections if Y2K display problem\n"
    ."document.write(\"Le \" + now.getDate() + \" \" + monthNames[now.getMonth()] +\" \" + thisYear);\n"
    ."// -->\n\n"
    ."</script></font>&nbsp;&nbsp;</td>\n"
	."</tr>\n"
	."</table>\n\n\n"

	."<table width=\"762\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
	
	."</table>\n\n\n"
	."<table width=\"762\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
	."<tr valign=\"top\">\n"
	."<td width=\"150\" valign=\"top\">\n";
    blocks(left);
    echo "</td><td><img src=\"themes/Chama/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"\"></td><td width=\"100%\">\n";
}

/************************************************************/

function themefooter() {
    global $index;
    if ($index == 1) {
	echo "</td><td><img src=\"themes/Chama/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"\"></td><td valign=\"top\" width=\"150\">\n";
	blocks(right);
    }
    echo "</td></tr></table>\n"
        ."<br><br><br><br>\n"

    	."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"762\">\n"
		."<tr>\n"
		."<td align=\"left\" background=\"themes/Chama/images/metalbar.gif\"><img src=\"themes/Chama/images/metalbar.gif\" width=\"2\" height=\"10\"></td>\n"
		."</tr>\n"
	    ."</table>\n"
        ."<table width=\"762\" bgcolor=\"#FFFFFF\" cellpadding=\"10\" cellspacing=\"0\" border=\"0\">\n"
        ."<tr align=\"center\">\n"
        ."<td width=\"100%\" colspan=\"3\">\n";
    footmsg();
    echo "</td>\n"
        ."</tr><tr>\n"
        ."</tr></table>\n\n\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"762\">\n"
		."<tr>\n"
		."<td align=\"left\" background=\"themes/Chama/images/metalbar.gif\"><img src=\"themes/Chama/images/metalbar.gif\" width=\"2\" height=\"10\"></td>\n"
		."</tr>\n"
	    ."</table>\n";
}

/************************************************************/


function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
    global $anonymous, $tipath;
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
	."<tr>\n"
	."<td align=\"left\" background=\"themes/Chama/images/metalbar.gif\"><img src=\"themes/Chama/images/metalbar.gif\" width=\"2\" height=\"10\"></td>\n"
	."</tr>\n"
	."</table>\n"

    ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td>\n"
	."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\"><tr><td>\n"
	."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n"
	."<tr>\n"
	."<td align=\"left\"><font class=\"option\" color=\"#000000\"><b>:: $title</b></font>\n"
	."</td></tr></table></td></tr></table>\n";
    FormatStory($thetext, $notes, $aid, $informant);
    echo "</td></tr></table>\n"
	."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\"><tr><td>\n"
	."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\"><tr><td align=\"center\">\n"
	."<br>--------------------------------------------------------\n"
	."<br><font color=\"#999999\" size=\"1\">"._POSTEDBY." ";
    formatAidHeader($aid);
    echo " "._ON." $time $timezone ($counter "._READS.")<br></font>\n"
	."<font class=\"content\">$morelink</font>\n"
	."</td></tr></table></td></tr></table>\n"
	."<br>\n\n\n";
}

/************************************************************/


function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid, $tipath;
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"423\"><tr><td>\n"
        ."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\"><tr><td>\n"
        ."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\"><tr><td align=\"left\">\n"
        ."<font class=\"option\" color=\"#000000\"><b>$title</b></font><br>\n"
        ."<font class=\"content\">"._POSTEDON." $datetime "._BY." ";
    formatAidHeader($aid);
    if (is_admin($admin)) {
	echo "<br>[ <a href=\"admin.php?op=EditStory&amp;sid=$sid\">"._EDIT."</a> | <a href=\"admin.php?op=RemoveStory&amp;sid=$sid\">"._DELETE."</a> ]\n";
    }
    echo "</td></tr></table></td></tr></table><br>";
    echo "<a href=\"modules.php?name=News&amp;new_topic=$topic\"><img src=\"images/topics/$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"10\" vspace=\"10\"></a>\n";
    FormatStory($thetext, $notes="", $aid, $informant);
    echo "</td></tr></table><br>\n\n\n";
}

/************************************************************/


function themesidebox($title, $content) {
    echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"155\">\n"
    ."<tr>\n"
    ."<td>\n"
    ."<!----- SideBox Metal Bar ----->\n"
	."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
	."<tr>\n"
	."<td align=\"left\" background=\"themes/Chama/images/metalbar.gif\"><img src=\"themes/Chama/images/metalbar.gif\" width=\"2\" height=\"10\"></td>\n"
	."</tr>\n"
	."</table>\n"
    ."<!----- SideBox Title ----->\n"
	."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n"
	."<tr>\n"
	."<td align=\"left\"><font class=\"content\" color=\"#000000\"><b>:: $title</b></font></td>\n"
	."</tr>\n"
	."</table>\n"
	."</td>\n"
	."</tr>\n"
	."</table>\n"
    ."<!----- SideBox Content ----->\n"
	."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"155\">\n"
	."<tr valign=\"top\">\n"
	."<td>\n"
	."$content\n"
	."</td>\n"
	."</tr>\n"
	."</table>\n"
	."<br>\n\n\n";
}

?>
