<?php

$bgcolor1 = "#ffffff";
$bgcolor2 = "#839B83";
$bgcolor3 = "#ffffff";
$bgcolor4 = "#eeeeee";
$textcolor1 = "#ffffff";
$textcolor2 = "#000000";

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
	$notes = "<b>"._NOTE."</b> <i>$notes</i>\n";
    } else {
	$notes = "";
    }
    if ("$aid" == "$informant") {
	echo "<font class=\"content\">$thetext<br>$notes</font>\n";
    } else {
	if($informant != "") {
	    $boxstuff = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= ""._WRITES." <i>\"$thetext\"</i> $notes\n";
	echo "<font class=\"content\">$boxstuff</font>\n";
    }
}

function themeheader() {
    global $banners, $username, $sitename;
    echo "<body bgcolor=\"ffffff\" text=\"000000\" link=\"0000ff\" vlink=\"0000ff\" topmargin=\"0\" leftmargin=\"0\"><table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" style=\"background-image:url('themes/Cellshade/images/leftlogo.gif'); background-repeat:no-repeat\"><tr><td width=\"133\"></td><td><table border=\"0\" height=\"100\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><td height=\"3\"></td></tr><tr><td height=\"60\" valign=\"middle\" background=\"themes/Cellshade/images/topback.gif\"><center><table cellpadding=\"0\" cellspacing=\"0\" width=\"470\" border=\"2\" bordercolor=\"839B83\"><tr><td>"
	."";
    if ($banners) {
	include("banners.php");
    }
    echo "</td></tr></table></center></td></tr><tr><td height\"\" valign=\"bottom\"><center><table width=\"480\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\"><tr><td width=\"60\"><a href=\"index.php\"><center>home</center></a></td><td width=\"60\"><a href=\"modules.php?name=Reviews\"><center>reviews</center></a></td><td width=\"60\"><a href=\"modules.php?name=Your_Account\"><center>accounts</center></a></td><td width=\"60\"><a href=\"modules.php?name=Downloads\"><center>files</center></a></td><td width=\"60\"><a href=\"modules.php?name=Sections\"><center>sections</center></a></td><td width=\"60\"><center><a href=\"modules.php?name=Topics\">topics</a></center></td><td><center><a href=\"modules.php?name=Web_Links\">links</a></center></td><td width=\"60\"><center><a href=\"mailto:cidtalk@hotmail.com?subject=cidtalk\">email</a></center></td><tr></table></center></td><tr></table></tr></td><td width=\"133\">"
        ."<a href=\"index.php\"><img src=\"themes/Cellshade/images/comp-right.gif\" Alt=\"".translate("Welcome to")." $sitename\" border=\"0\"></a></td></tr><tr><td colspan=\"4\" bgcolor=\"839B83\" height=\"3\"></table>"
        ."</td></tr><tr><td valign=\"top\" width=\"100%\" bgcolor=\"ffffff\">"
        ."<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\"><tr><td valign=\"top\" width=\"150\" bgcolor=\"839B83\">";
    blocks(left);
    echo "</td><td width=\"100%\" valign=\"top\" bgcolor=\"5F7B97\">";
}

function themefooter() {
    global $index;
    if ($index == 1) {
	echo "</td><td valign=\"top\" bgcolor=\"#839B83\">";
	blocks(right);
	echo "</td>";
    }
    echo "</td></tr></table></td></tr></table>";
    footmsg();
}

function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
    global $anonymous, $tipath, $topicimage;
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"839B83\" width=\"100%\"><tr><td>"
        ."<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\"><tr><td bgcolor=\"ffffff\">"
        ."<font class=title>$title</font><br>"
        ."<font class=\"tiny\">"
        ."<b>";
    formatAidHeader($aid);
    echo "</b>"
	."<b> "._TOPIC. "</b> <a href=\"modules.php?name=Search&amp;query=&amp;topic=$topic&amp;author=\">$topictext</a><br>"
	."</font></td></tr><tr><td bgcolor=\"ffffff\"><a href=\"modules.php?name=Search&amp;query=&amp;topic=$topic&amp;author=\"><img src=\"$tipath$topicimage\" border=\"0\" Alt=\"$topictext\" align=\"right\" hspace=\"10\" vspace=\"10\"></a>";
    FormatStory($thetext, $notes, $aid, $informant);
    echo ""
        ."</td></tr><tr><td bgcolor=\"ffffff\" align=\"right\">"
        ."<font class=\"content\">$morelink</font>"
        ."</td></tr></table></td></tr></table>"
	."<br>";
}

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid;
    if ("$aid" == "$informant") {
	echo"
	<table border=0 cellpadding=0 cellspacing=0 align=center bgcolor=000000 width=100%><tr><td>
	<table border=0 cellpadding=3 cellspacing=1 width=100%><tr><td bgcolor=FFFFFF>
	<b>$title</b><br><font class=tiny>".translate("Posted on ")." $datetime";
	if ($admin) {
	    echo "&nbsp;&nbsp; $font2 [ <a href=admin.php?op=EditStory&sid=$sid>".translate("Edit")."</a> | <a href=admin.php?op=RemoveStory&sid=$sid>".translate("Delete")."</a> ]";
	}
	echo "
	<br>".translate("Topic").": <a href=modules.php?name=Search&amp;query=&topic=$topic&author=>$topictext</a>
	</td></tr><tr><td bgcolor=ffffff>
	$thetext
	</td></tr></table></td></tr></table><br>";
    } else {
	if($informant != "") $informant = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&uname=$informant\">$informant</a> ";
	else $boxstuff = "$anonymous ";
	$boxstuff .= "".translate("writes")." <i>\"$thetext\"</i> $notes";
	echo "
	<table border=0 cellpadding=0 cellspacing=0 align=center bgcolor=000000 width=100%><tr><td>
	<table border=0 cellpadding=3 cellspacing=1 width=100%><tr><td bgcolor=FFFFFF>
	<b>$title</b><br><font class=content>".translate("Contributed by ")." $informant ".translate("on")." $datetime</font>";
	if ($admin) {
	    echo "&nbsp;&nbsp; $font2 [ <a href=admin.php?op=EditStory&sid=$sid>".translate("Edit")."</a> | <a href=admin.php?op=RemoveStory&sid=$sid>".translate("Delete")."</a> ]";
	}
	echo "
	<br>".translate("Topic").": <a href=modules.php?name=Search&amp;query=&topic=$topic&author=>$topictext</a>
	</td></tr><tr><td bgcolor=ffffff>
	$thetext
	</td></tr></table></td></tr></table>";
    }
}

function themesidebox($title, $content) {
    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"150\" bgcolor=\"839B83\"><tr><td>"
        ."<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\"><tr><td bgcolor=\"\">"
        ."<font class=\"side\"><img src=\"themes/Cellshade/images/boxdot.gif\">$title</font></td></tr><tr><td bgcolor=\"ffffff\"><font class=\"content\">"
        ."$content"
	."</font></td></tr></table></td></tr></table><br>";
}

?>
