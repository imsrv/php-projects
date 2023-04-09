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

$bgcolor1 = "#001E64";
$bgcolor2 = "#696969";
$bgcolor3 = "#001E64";
$bgcolor4 = "#696969";
$textcolor1 = "#FFD26A";
$textcolor2 = "#FFD26A";

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
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"><tr><td>\n";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"><tr><td>\n";
}

function CloseTable() {
    echo "</td></tr></table></td></tr></table>\n";
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td>\n";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" ><tr><td>\n";
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
    echo "<body text=\"\" link=\"\" vlink=\"\" alink=\"\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" background=\"themes/2Tech/images/bg2.gif\">\n"
        ."<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\"><tr><td align=\"left\">\n";
    if ($banners) {
        include("banners.php");
    }
    echo "</td></tr></table>\n"
        ."<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" align=\"center\"><tr>\n"
        ."<td><IMG src=\"themes/2Tech/images/pixel.gif\" width=\"1\" height=\"1\" alt=\"0\" border=\"0\" hspace=\"0\"></td></tr></table>\n"
        ."<table cellpadding=\"0\" cellspacing=\"0\" height=\"73\" width=\"800\" border=\"0\" align=\"center\" background=\"themes/2Tech/images/top_graphic.gif\">\n"
        ."<tr>\n"
        ."<td>\n"
        ."<a href=\"modules.php?op=modload&name=News&file=index\"><img src=\"themes/2Tech/images/logo.gif\" align=\"left\" alt=\""._WELCOMETO." $sitename\" border=\"0\"></a></td>\n"
        ."<td align=\"right\" class=\"menuehead\">\n";

     echo "<form action=\"modules.php?name=Your_Account\" method=\"post\" style=\"margin:1\">\n"
        ."<font class=\"pinktext\"><b>User: </b></font>\n"
        ."<input type=\"text\" name=\"uname\" size=\"7\" maxlength=\"25\">\n"
        ."<font class=\"pinktext\"><b>Pass: </b></font>\n"
        ."<input type=\"password\" name=\"pass\" size=\"7\" maxlength=\"20\">\n"
        ."<input type=\"hidden\" name=\"op\" value=\"login\">\n"
        ."<input type=\"submit\" value=\"login\">\n"
        ."<a href=\"modules.php?name=Your_Account&op=new_user\"><font class=\"pinktext\"><b>Join</b></font></a>\n"
        ."</form>\n";



        echo
        "</table><table width=\"800\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" height=\"15\"><tr>\n"
        ."<td align=\"center\" height=\"20\" width=\"800\" background=\"themes/2Tech/images/main-bg.gif\">\n"
        ."<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"800\" height=\"35\">\n"
        ."<param name=movie value=\"themes/2Tech/flash/main_nav.swf\">\n"
        ."<param name=quality value=high>\n"
        ."<param name=\"BGCOLOR\" value=\"#00004E\">\n"
        ."<embed src=\"themes/2Tech/flash/main_nav.swf\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"800\" height=\"35\">\n"
        ."</embed>\n"
        ."</object>\n"
        ."<table width=\"800\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\"><tr valign=\"top\">\n"
        ."<td width=\"160\" valign=\"top\">\n";
    blocks(left);
    echo "</td><td><img src=\"themes/2Tech/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"0\"></td><td width=\"100%\">\n";
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
        echo "</td><td><img src=\"themes/2Tech/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"0\"></td><td valign=\"top\" width=\"150\">\n";
        blocks(right);
    }
    echo "</td>\n"
        ."</td></tr></table>\n"
        ."<table width=\"95%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"#CCCBC0\" align=\"center\"><tr>\n"
        ."<td><IMG src=\"themes/2Tech/images/pixel.gif\" width=\"1\" height=\"1\" alt=\"\" border=\"0\" hspace=\"0\"></td>\n"
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
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" width=\"100%\">\n"
    ."<tr>\n"
    ."<td>\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
        ."<tr>\n"

        ."<td align=\"left\" valign=\"middle\" background=\"themes/2Tech/images/sidebox-title-bg.gif\" width=\"450\" height=\"16\">\n"
        ."<font class=\"option\" color=\"#00005E\"><b>&nbsp;&nbsp; $title</b></font>\n"
        ."</td>\n"

        ."</tr>\n"
        ."</table>\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
        ."<tr>\n"
        ."<td>\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
        ."<tr>\n"
        ."<td align=\"left\" valign=\"top\" width=\"15\" height=\"46\"><img src=\"themes/2Tech/images/storybox-left.gif\"></td>\n"
        ."<td align=\"left\" valign=\"middle\" background=\"themes/2Tech/images/storybox-bg.gif\" width=\"100%\" height=\"46\">\n"
        ."<font color=\"#ffffff\" size=\"2\">"._POSTEDBY." ";
    formatAidHeader($aid);
    echo " "._ON." $time</font>\n"
        ."<font color=\"#ffffff\">$morelink</font>\n"
        ."</td>\n"
    ."<td width=\"1\" align=\"left\" valign=\"top\"><img src=\"themes/2Tech/images/storybox-right.gif\"></td>\n"
        ."</tr>\n"
        ."</table>\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
        ."<tr>\n"
        ."<td width=\"1\" align=\"left\" valign=\"top\" background=\"themes/2Tech/images/sidebox-bar-left.gif\"><img src=\"themes/2Tech/images/sidebox-bar-px.gif\"></td>\n"
        ."<td>\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
        ."<tr valign=\"top\" width=\"100%\">\n"
        ."<td width=\"100%\">\n"
        ."<font color=\"#FFD26A\"><b><a href=\"modules.php?name=Search&query=&amp;topic=$topic\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"1\" vspace=\"1\"></a></B></font>\n";
    FormatStory($thetext, $notes, $aid, $informant);
    echo "</td></tr></table>\n"
    ."</td>\n"
    ."<td width=\"13\" align=\"left\" valign=\"top\" background=\"themes/2Tech/images/storybox-content-right.gif\"><img src=\"themes/2Tech/images/storybox-content-right-px.gif\"></td>\n"
    ."</tr></table>\n"

        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n"
        ."<tr valign=\"top\">\n"
        ."<td width=\"9\" height=\"15\" align=\"left\" valign=\"top\"><img src=\"themes/2Tech/images/storybox-bottom-left.gif\"></td>\n"
        ."<td width=\"100%\" height=\"15\" background=\"themes/2Tech/images/storybox-bottom-bg.gif\"></td>\n"
        ."<td width=\"120\" height=\"15\" align=\"left\" valign=\"top\"><img src=\"themes/2Tech/images/storybox-bottom-right.gif\"></td>\n"
    ."</table>\n"

    ."</td></tr></table>\n"

    ."</td></tr></table>\n";
}

/************************************************************/
/* Function themeindex()                                    */
/*                                                          */
/* This function format the stories on the story page, when */
/* you click on that "Read More..." link in the home        */
/************************************************************/

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid, $tipath;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><a href=\"search.php?query=&amp;topic=$topic\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"1\" vspace=\"0\"></a><font class=\"arthead\">$title</font>\n"
        ."<font class=\"artsubhead\">"._POSTEDON." $datetime "._BY." ";
    formatAidHeader($aid);
    if (is_admin($admin)) {
        echo "<br>[ <a href=\"admin.php?op=EditStory&amp;sid=$sid\">"._EDIT."</a> | <a href=\"admin.php?op=RemoveStory&amp;sid=$sid\">"._DELETE."</a> ]\n";
    }
    echo "</td></tr></table><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"themes/2Tech/images/line_bg.gif\"><tr><td width=\"4\" height=\"7\"><img src=\"themes/2Tech/images/corner_line_left.gif\" width=\"4\" height=\"7\"></td><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><img src=\"themes/2Tech/images/line_bg.gif\" height=\"7\"></td></tr></table></td><td width=\"4\" height=\"7\" align=\"right\"><img src=\"themes/2Tech/images/corner_line_right.gif\" width=\"4\" height=\"7\"></td></tr></table><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
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
    echo "<img src=\"themes/2Tech/images/box_head.gif\" width=\"165\" height=\"19\" alt=\"\" border=\"0\"><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" background=\"themes/2Tech/images/box_headline.gif\" width=\"165\" height=\"25\"><tr><td align=center class=\"menuehead\">\n"
        ."<font class=\"option\" color=\"#00005E\">$title</font>\n"
        ."</td></tr></table>\n"
        ."<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"165\">\n"
        ."<tr valign=\"top\"><td width=\"20\" background=\"themes/2Tech/images/box_bg_l.gif\"><img src=\"themes/2Tech/images/pixel.gif\" width=\"20\" height=\"10\"></td><td class=\"artsubhead\"><img src=\"themes/2Tech/images/pixel.gif\" width=\"115\" height=\"1\"><br>\n"
        ."$content\n"
    ."</td><td width=\"15\" background=\"themes/2Tech/images/box_bg_r.gif\"><img src=\"themes/2Tech/images/pixel.gif\" width=\"15\" height=\"10\"></td></tr></table><img src=\"themes/2Tech/images/box_foot.gif\" width=\"165\" height=\"15\" alt=\"\" border=\"0\"><br>\n";
}

?>
