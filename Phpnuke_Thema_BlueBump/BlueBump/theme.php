<?php

/************************************************************/
/* IMPORTANT NOTE FOR THEMES DEVELOPERS!                    */
/*                                                          */
/* When you start coding your theme, if you want to         */
/* distribute it, please double check it to fit the HTML    */
/* 4.01 Transitional Standard. You can use the W3 validator */
/* located at http://validator.w3.org                       */
/* If you don't know where to start with your theme, just   */
/* start modifying this theme, it's validate and is cool ;) */
/************************************************************/

/************************************************************/
/* Theme Colors Definition                                  */
/*                                                          */
/* Define colors for your web site. $bgcolor2 is generaly   */
/* used for the tables border as you can see on OpenTable() */
/* function, $bgcolor1 is for the table background and the  */
/* other two bgcolor variables follows the same criteria.   */
/* $texcolor1 and 2 are for tables internal texts           */
/************************************************************/

$bgcolor1 = "#DEDEE6";
$bgcolor2 = "#BCBCCB";
$bgcolor3 = "#DEDEE6";
$bgcolor4 = "#DEDEE6";
$textcolor1 = "#660000";
$textcolor2 = "#660000";

/************************************************************/
/* OpenTable Functions                                      */
/*                                                          */
/* Define the tables look&feel for you whole site. For this */
/* we have two options: OpenTable and OpenTable2 functions. */
/* Then we have CloseTable and CloseTable2 function to      */
/* properly close our tables. The difference is that        */
/* OpenTable has a 100% width and OpenTable2 has a width    */
/* according with the table content                         */
/************************************************************/

function OpenTable() {
    global $bgcolor1, $bgcolor2;
    echo "<table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\"><tr><td>\n";
    echo "<table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
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
/* FormatStory                                              */
/*                                                          */
/* Here we'll format the look of the stories in our site.   */
/* If you dig a little on the function you will notice that */
/* we set different stuff for anonymous, admin and users    */
/* when displaying the story.                               */
/************************************************************/

function FormatStory($thetext, $notes, $aid, $informant) {
    global $anonymous;
    if ($notes != "") {
	$notes = "<br><br><b>"._NOTE."</b> <i>$notes</i>\n";
    } else {
	$notes = "";
    }
    if ("$aid" == "$informant") {
	echo "$thetext$notes\n";
    } else {
	if($informant != "") {
	    $boxstuff = "<a href=\"user.php?op=userinfo&amp;uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= ""._WRITES." <i>\"$thetext\"</i>$notes\n";
	echo "$boxstuff\n";
    }
}

/************************************************************/
/* Function themeheader()                                   */
/*                                                          */
/* Control the header for your site. You need to define the */
/* BODY tag and in some part of the code call the blocks    */
/* function for left side with: blocks(left);               */
/************************************************************/

function themeheader() {
    global $user, $banners, $sitename, $slogan, $cookie, $prefix;
    cookiedecode($user);
    $username = $cookie[1];
    if ($username == "") {
        $username = "Anonymous";
    }
    echo "<body bgcolor=\"#DEDEE6\" text=\"\" link=\"\" vlink=\"\" alink=\"\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">\n"
	."<table cellpadding=\"5\" cellspacing=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#9999cc\"><tr><td align=\"right\">\n";
    if ($banners) {
	include("banners.php");
    }
    echo "</td></tr></table>\n"
	."<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" align=\"center\" bgcolor=\"#DEDEE6\"><tr>\n"
	."<td bgcolor=\"#DEDEE6\"><IMG src=\"themes/BlueBump/images/pixel.gif\" width=\"1\" height=\"1\" alt=\"\" border=\"0\" hspace=\"0\"></td></tr></table>\n"
	."<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" align=\"center\" bgcolor=\"#BCBCCB\">\n"
	."<tr>\n"
	."<td>\n"
	."<a href=\"index.php\"><img src=\"themes/BlueBump/images/logo.gif\" align=\"left\" alt=\""._WELCOMETO." $sitename\" border=\"0\"></a></td>\n"
	."<td align=\"center\" class=\"menuehead\">\n"
	."<center><form action=\"search.php\" method=\"post\">"._SEARCH." \n"
	."<input type=\"text\" name=\"query\" size=\"14\"></form></center></td>\n"
	."<td align=\"center\" class=\"menuehead\">\n"
	."<center><form action=\"search.php\" method=\"get\">"._TOPICS." \n";
    $toplist = mysql_query("select topicid, topictext from $prefix"._topics." order by topictext");
    echo "<select name=\"topic\"onChange='submit()'>\n"
	."<option value=\"\">"._ALLTOPICS."</option>\n";
    while(list($topicid, $topics) = mysql_fetch_row($toplist)) {
    if ($topicid==$topic) { $sel = "selected "; }
	echo "<option $sel value=\"$topicid\">$topics</option>\n";
	$sel = "";
    }
    echo "</select></form></center></td>\n"
	."</tr></table>\n"
	."<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" align=\"center\" bgcolor=\"#7373A4\" background=\"themes/BlueBump/images/headerline.gif\" height=\"30\">\n"
	."<tr valign=\"middle\"><td><IMG src=\"themes/BlueBump/images/pixel.gif\" width=\"24\" height=\"30\" border=\"0\" hspace=\"0\"></td><td><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"themes/BlueBump/images/toplight_bg.gif\"><tr><td width=\"4\" height=\"30\"><img src=\"themes/BlueBump/images/toplight_left.gif\" width=\"4\" height=\"30\"></td>\n"
	."<td nowrap class=\"artsubhead\" align=\"left\">\n";
    if ($username == "Anonymous") {
	echo "<a href=\"user.php\">create</a> an account\n";
    } else {
	echo " moin $username! | <a href=\"user.php?op=logout\">logout</a> | ";
    }
    echo "<script type=\"text/javascript\">\n"
        ."<!--   // Array ofmonth Names\n"
        ."var monthNames = new Array( \"January\",\"February\",\"March\",\"April\",\"May\",\"June\",\"July\",\"August\",\"September\",\"October\",\"November\",\"December\");\n"
        ."var now = new Date();\n"
        ."thisYear = now.getYear();\n"
        ."if(thisYear < 1900) {thisYear += 1900}; // corrections if Y2K display problem\n"
        ."document.write(monthNames[now.getMonth()] + \" \" + now.getDate() + \", \" + thisYear) ;\n"
        ."// -->\n"
        ."</script></td><td width=\"4\" height=\"30\"><img src=\"themes/BlueBump/images/toplight_right.gif\" width=\"4\" height=\"30\"></td></tr></table>\n"
	."<td align=\"left\" height=\"30\" width=\"70%\"><IMG src=\"themes/BlueBump/images/pixel.gif\" width=\"24\" height=\"30\" border=\"0\" hspace=\"0\"><A href=\"/\"><IMG src=\"themes/BlueBump/images/home.gif\" width=\"24\" height=\"30\" alt=\"Home\" border=\"0\" hspace=\"5\"></a><A href=\"topics.php\"><IMG src=\"themes/BlueBump/images/themes.gif\" width=\"24\" height=\"30\" alt=\"Themen\" border=\"0\" hspace=\"5\"></a><A href=\"download.php\"><IMG src=\"themes/BlueBump/images/downloads.gif\" width=\"24\" height=\"30\" alt=\"Download\" border=\"0\" hspace=\"5\"><A href=\"user.php\"><IMG src=\"themes/BlueBump/images/account.gif\" width=\"24\" height=\"30\" alt=\"Dein Account\" border=\"0\" hspace=\"5\"></a><A href=\"submit.php\"><IMG src=\"themes/BlueBump/images/submitnews.gif\" width=\"24\" height=\"30\" alt=\"Schreibe News\" border=\"0\" hspace=\"5\"></a><A href=\"top.php\"><IMG src=\"themes/BlueBump/images/topten.gif\" width=\"24\" height=\"30\" alt=\"Top10\" border=\"0\" hspace=\"5\"></a></td>\n"
        ."<td align=\"right\" width=\"10%\">&nbsp;</td>\n"
        ."</tr>\n"
        ."</table><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"\" align=\"center\" background=\"themes/BlueBump/images/under_hl.gif\" height=\"15\"><tr>\n"
	."<td><IMG src=\"themes/BlueBump/images/under_hl.gif\" height=\"15\" alt=\"\" border=\"0\" hspace=\"0\"></td></tr></table>\n"
	."<!-- FIN DEL TITULO -->\n"
	."<table width=\"95%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"#DEDEE6\" align=\"center\"><tr valign=\"top\">\n"
	."<td bgcolor=\"#DEDEE6\" width=\"150\" valign=\"top\">\n";
    blocks(left);
    echo "</td><td><img src=\"themes/BlueBump/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"\"></td><td width=\"100%\">\n";
}

/************************************************************/
/* Function themefooter()                                   */
/*                                                          */
/* Control the footer for your site. You don't need to      */
/* close BODY and HTML tags at the end. In some part call   */
/* the function for right blocks with: blocks(right);       */
/* Also, $index variable need to be global and is used to   */
/* determine if the page your're viewing is the Homepage or */
/* and internal one.                                        */
/************************************************************/

function themefooter() {
    global $index;
    if ($index == 1) {
	echo "</td><td><img src=\"themes/BlueBump/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"\"></td><td valign=\"top\" width=\"150\">\n";
	blocks(right);
    }
    echo "</td>\n"
	."</td></tr></table>\n"
        ."<table width=\"95%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"#DEDEE6\" align=\"center\"><tr>\n"
        ."<td bgcolor=\"#DEDEE6\"><IMG src=\"themes/BlueBump/images/pixel.gif\" width=\"1\" height=\"1\" alt=\"\" border=\"0\" hspace=\"0\"></td>\n"
        ."</tr></table><br>\n"
        ."<table width=\"95%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\"><tr align=\"center\">\n"
        ."<td width=\"100%\" colspan=\"3\" class=\"artsubhead\">\n";
    footmsg();
    echo "</td>\n"
        ."</tr></table>\n";
}

/************************************************************/
/* Function themeindex()                                    */
/*                                                          */
/* This function format the stories on the Homepage         */
/************************************************************/

function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
    global $anonymous, $tipath;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#FFFFFF\"><tr><td width=\"9\" height=\"10\"><img src=\"themes/BlueBump/images/corner-top-left.gif\" width=\"9\" height=\"10\"></td><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"themes/BlueBump/images/bottom_bg.gif\"><tr><td><img src=\"themes/BlueBump/images/pixel.gif\" width=\"10\" height=\"10\"></td></tr></table></td><td width=\"9\" height=\"10\" align=\"right\"><img src=\"themes/BlueBump/images/corner-top-right.gif\" width=\"9\" height=\"10\"></td></tr><tr><td><img src=\"themes/BlueBump/images/pixel.gif\" width=\"9\" height=\"10\"></td><td width=\"100%\" align=\"left\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><a href=\"search.php?query=&amp;topic=$topic\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"left\" hspace=\"5\" vspace=\"1\"></a><font class=\"arthead\">$title</font><br><font class=\"artsubhead\">"._POSTEDBY." ";
    formatAidHeader($aid);
    echo " "._ON." $time ($counter "._READS.")</font></td></tr></table>\n"
	."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"4\" height=\"7\" align=\"right\"><img src=\"themes/BlueBump/images/corner_line_left.gif\" width=\"4\" height=\"7\"></td><td width=\"100%\" background=\"themes/BlueBump/images/line_bg.gif\"><img src=\"themes/BlueBump/images/line_bg.gif\" width=\"50\" height=\"7\"></td><td width=\"4\" height=\"7\"><img src=\"themes/BlueBump/images/corner_line_right.gif\" width=\"4\" height=\"7\"></td></tr></table><table><tr><td class=\"art\">\n";
    FormatStory($thetext, $notes, $aid, $informant);
    echo "</td></tr></table>\n"
	."<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\"><tr><td align=\"right\" class=\"artsubhead\">\n"
	."$morelink\n"
	."</td></tr></table>\n"
	."</td><td><img src=\"themes/BlueBump/images/pixel.gif\" width=\"9\" height=\"10\"></td></tr><tr><td><img src=\"themes/BlueBump/images/corner-bottom-left.gif\" width=\"9\" height=\"7\"></td><td><img src=\"themes/BlueBump/images/pixel.gif\" width=\"10\" height=\"7\"></td><td><img src=\"themes/BlueBump/images/corner-bottom-right.gif\" width=\"9\" height=\"7\"></td></tr></table>\n"
	."<br>\n";
}

/************************************************************/
/* Function themeindex()                                    */
/*                                                          */
/* This function format the stories on the story page, when */
/* you click on that "Read More..." link in the home        */
/************************************************************/

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid, $tipath;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><a href=\"search.php?query=&amp;topic=$topic\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"1\" vspace=\"3\"></a><font class=\"arthead\">$title</font><br>\n"
        ."<font class=\"artsubhead\">"._POSTEDON." $datetime "._BY." ";
    formatAidHeader($aid);
    if (is_admin($admin)) {
	echo "<br>[ <a href=\"admin.php?op=EditStory&amp;sid=$sid\">"._EDIT."</a> | <a href=\"admin.php?op=RemoveStory&amp;sid=$sid\">"._DELETE."</a> ]\n";
    }
    echo "</td></tr></table><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"themes/BlueBump/images/line_bg.gif\"><tr><td width=\"4\" height=\"7\"><img src=\"themes/BlueBump/images/corner_line_left.gif\" width=\"4\" height=\"7\"></td><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><img src=\"themes/BlueBump/images/line_bg.gif\" height=\"7\"></td></tr></table></td><td width=\"4\" height=\"7\" align=\"right\"><img src=\"themes/BlueBump/images/corner_line_right.gif\" width=\"4\" height=\"7\"></td></tr></table><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    echo "<tr><td class=\"art\"><br>\n";
    FormatStory($thetext, $notes="", $aid, $informant);
    echo "</td></tr></table><br>\n";
}

/************************************************************/
/* Function themesidebox()                                  */
/*                                                          */
/* Control look of your blocks. Just simple.                */
/************************************************************/

function themesidebox($title, $content) {
    echo "<img src=\"themes/BlueBump/images/box_head.gif\" width=\"150\" height=\"19\" alt=\"\" border=\"0\"><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#9999CC\" background=\"themes/BlueBump/images/box_headline.gif\" width=\"150\" height=\"21\"><tr><td align=center class=\"menuehead\">\n"
	."$title\n"
	."</td></tr></table>\n"
	."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#9999CC\" width=\"150\">\n"
	."<tr valign=\"top\"><td width=\"20\" background=\"themes/BlueBump/images/box_bg_l.gif\"><img src=\"themes/BlueBump/images/pixel.gif\" width=\"20\" height=\"10\"></td><td class=\"artsubhead\"><img src=\"themes/BlueBump/images/pixel.gif\" width=\"115\" height=\"1\"><br>\n"
	."$content\n"
    ."</td><td width=\"15\" background=\"themes/BlueBump/images/box_bg_r.gif\"><img src=\"themes/BlueBump/images/pixel.gif\" width=\"15\" height=\"10\"></td></tr></table><img src=\"themes/BlueBump/images/box_foot.gif\" width=\"150\" height=\"30\" alt=\"\" border=\"0\"><br>\n";
}

?>