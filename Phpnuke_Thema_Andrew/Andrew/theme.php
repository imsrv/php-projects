<?php

$thename = "Andrew";
$bgcolor1   = "#FF9900";
$bgcolor2   = "#F4CA8E";
$bgcolor3   = "#7E7E7E";
$bgcolor4   = "#7E7E7E";
$textcolor1 = "#FFFFFF";
$textcolor2 = "#FFFFFF";

function OpenTable() {
    global $bgcolor1, $bgcolor2;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\"><tr><td>\n";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    echo "<center>";
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\"><tr><td>\n";
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
	echo "<font size=\"2\">$thetext<br>$notes</font>\n";
    } else {
	if($informant != "") {
	    $boxstuff = "<a href=\"user.php?op=userinfo&amp;uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= ""._WRITES." <i>\"$thetext\"</i> $notes\n";
	echo "<font size=\"2\">$boxstuff</font>\n";
    }
}
function themeheader() {
echo "<LINK rel=\"StyleSheet\" HREF=\"themes/Andrew/style/style.css\" TYPE=\"text/css\">";
  echo "<body  bgcolor=#7E7E7E text=000000 topmargin=1 leftmargin=0 rightmargin=0 marginheight=3 <body link=#000000 vlink=#000000 alink=#000000>
<center><br><table cellSpacing=0 cellPadding=0 width=766 align=center bgColor=#fefefe border=0>
  <tbody>
    <tr vAlign=top bgColor=#7E7E7E>
      <td align=middle  bgColor=#7E7E7E></td>
    </tr>
  </tbody>
</table>
<table cellSpacing=0 cellPadding=0 width=766 align=center bgColor=#7E7E7E border=0 nowrap>
  <tbody>
    <tr>
      <td align=middle height=17>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";?>
<table border="0" cellspacing="0" width="97%" cellpadding="0">
  <tr>
    <td width="15%">
    </td>
    <td width="85%" bgcolor="#7E7E7E"><table border="0" width="330" cellspacing="0" cellpadding="0" bgcolor="#7E7E7E">
  <tr>
    <td width="270">
      <div align="center">
        <center>
        <table border="0" width="500" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" height="20">
              <p align="center"><img border="0" src="themes/Andrew/images/logo.jpg" ></td>
          </tr>
        </table>
        </center>
      </div>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>

</center>
<div align="center">
  <center>
<div align="center">
  <center>

<table border="0" width="700" cellspacing="0" cellpadding="0" bgcolor="#F0BF75">
  <tr>
    <td width="443" height="28"><form action=search.php method=post><img hspace=1 src=themes/Andrew/images/search.jpg border=0 width="90" height="11"><input type=text size 30 name=query style="background-color: #7E7E7E">
      <INPUT TYPE=image hspace=2 src=themes/Andrew/images/panah.jpg align=absMiddle border=0 width="19" height="18">
    </td></form>
    <td width="451"><form action="search.php" method=get><FONT size="1"><br>
      <img border=0 src=themes/Andrew/images/topic.jpg width="90" height="11">
      <?php $toplist = mysql_query("select topicid, topictext from nuke_topics order by topictext");
    echo "<SELECT NAME=\"topic\"onChange='submit()'>" ; ?>
      style="background-color: #7E7E7E"
      <?
    echo "<OPTION VALUE=\"\">"._ALLTOPICS."</option>\n";
    while(list($topicid, $topics) = mysql_fetch_row($toplist)) {
    if ($topicid==$topic) { $sel = "selected "; }
	echo "<option $sel value=\"$topicid\">$topics</option>\n";
    $sel = "";
    }
    echo "</SELECT></FONT></FORM>";?>
    </td>
  </tr>
  <tr>
    <td width="894" height="14" colspan="2" bgcolor="#FF9900">
      <p align="center">
      <img height="19" height="18" src="themes/Andrew/images/panah2.jpg" width="19" border="0"> <font size="1"><a href="mailto:<?PHP global $adminmail; echo "$adminmail" ?>"><font color="#7E7E7E">Contact</font></a>
      <img height="19" height="18" src="themes/Andrew/images/panah2.jpg" width="19"border="0"> <a href="links.php?op=AddLink"><font color="#7E7E7E"><?php echo ""._ADDLINK.""; ?></font></a>&nbsp;
      <img height="19" height="18" src="themes/Andrew/images/panah2.jpg" width="19" border="0"> <a href="user.php"><font color="#7E7E7E"><?php echo ""._USERLOGIN.""; ?></font></a>
      <img height="19" height="18" src="themes/Andrew/images/panah2.jpg" width="19" border="0"> <a href="links.php"><font color="#7E7E7E"><?php echo ""._LINKS.""; ?></font></a>
      <img height="19" height="18" src="themes/Andrew/images/panah2.jpg" width="19" border="0"> <a href="submit.php"><font color="#7E7E7E"><?php echo ""._SUBMITNEWS.""; ?></font></a></font></p>
    </td>
  </tr>
  <tr>
    <td width="700" height="14" colspan="2"><img border="0" src="themes/Andrew/images/papantanda.jpg" width="700" height="35"></td>
  </tr>
</table>



  </center>
  </div>

  </center>
  </div>
<? echo "<table border=0 cellspacing=0 cellpadding=2 width=100%><tr><td valign=top width=150 bgcolor=7E7E7E>";
        blocks(left);

echo "</td><td>&nbsp;</td><td width=100% valign=top>";
?>
<div align="center">
 
</div><? echo "<font face='verdana'size=2><br>";


}

function themefooter() {
    global $index;
    if ($index == 1) {
	echo "</td><td><img src=\"themes/NukeNews/images/pixel.gif\" width=\"15\" height=\"1\" border=\"0\" alt=\"\"></td><td valign=\"top\" width=\"150\">\n";
	blocks(right);
    }
    echo "</td><td bgcolor=\"#7E7E7E\"><img src=\"themes/NukeNews/images/pixel.gif\" width=10 height=1 border=0 alt=\"\">\n"
	."</td></tr></table>\n"
        ."<table width=\"99%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"#7E7E7E\" align=\"center\"><tr valign=\"top\">\n"
        ."<td align=\"center\" height=\"17\">\n"
        ."</td></tr></table>\n"
        ."<br>"
        ."<table width=\"99%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"#7E7E7E\" align=\"center\"><tr valign=\"top\">\n"
        ."<td width=\"100%\">&nbsp;</td>\n"
        ."</tr><tr align=\"center\">\n"
        ."<td width=\"100%\" colspan=\"3\">\n";
    footmsg();
    echo "</td>\n"
        ."</tr><tr>\n"
        ."<td width=\"100%\">&nbsp;</td>\n"
        ."</tr></table>\n";

}

function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
    global $tipath, $anonymous;
    echo "<div align=center>
  <center>

<table cellSpacing=1 cellPadding=0 width=100% border=0>
  <tr>
    <td align=middle bgcolor=#FF9900><img alt hspace=0 src=themes/Andrew/images/biru3d.jpg align=left width=6 height=17><img alt hspace=0 src=themes/Andrew/images/biru3d.jpg align=right width=5 height=17>
      <p align=left><font face='Verdana, Arial, Helvetica, sans-serif' color=#606438 size=4><b>
      &nbsp;&nbsp;&nbsp;$title</b></font></p>
    </td>
  </tr>
<tr bgColor=#C7C6C6>
    <td>
      <table cellSpacing=5 cellPadding=0 width=100% border=0>
        <tbody>
          <tr>
            <td width=105><a href=\"search.php?query=&topic=$topic\"><img src=\"$tipath$topicimage\" Alt=\"$topictext\" align=\"right\" border=\"0\"></td>
            <td vAlign=top>$thetext<br>$boxstuff<br>$morelink</td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</table>
<table cellSpacing=0 cellPadding=0 width=100% bgColor=#666666>
  <tr>
    <td bgcolor=#d9d9d9><font size=1>"._POSTEDBY." <b>";
	formatAidHeader($aid);
	echo "</b> "._ON." $time $timezone ( $counter "._READS." )<br>";
    if ($aid == $informant) {
	$boxstuff = "$thetext";
    } else {
	if ($informant != "") {
	    $boxstuff = "<a href=\"user.php?op=userinfo&uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= ""._WRITES." <i>\"$thetext\"</i> $notes";
    }
    echo "<b>"._TOPIC.":</b> <a href=\"search.php?query=&topic=$topic\">$topictext</a><br></td>
  </tr>
</table>




  </center><br>
</div>";
}


function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid, $tipath;
    echo "<center>
    <table cellSpacing=1 cellPadding=0 width=100% border=0>
  <tr>
    <td align=middle bgcolor=#FFD000>
      <p align=left><img alt hspace=0 src=themes/Andrew/images/gauche.gif align=left width=6 height=17><img alt hspace=0 src=themes/Andrew/images/droite.gif align=right width=5 height=17>&nbsp;&nbsp;&nbsp;<font size=4 color=#606438 face=helevtica,arial><b>$title</b><br>
    </td>
  </tr>
<tr><td><br>"; if ($aid == $informant) {
	$boxstuff = "$thetext";
    } else {
	if($informant != "") {
	    $boxstuff = "<a href=\"user.php?op=userinfo&uname=$informant\">$informant</a> ";
	} else {
	    $boxstuff = "$anonymous ";
	}
	$boxstuff .= ""._WRITES." <i>\"$thetext\"</i> $notes";
    }
    echo "<font size=2 color=#686868 face=helevtica,arial><a href=\"search.php?query=&topic=$topic\"><img src=\"$tipath$topicimage\" Alt=\"$topictext\" align=\"right\" border=\"0\"></a> "
	."$boxstuff"; 
   echo " </td>
  </tr>
</table><table cellSpacing=0 cellPadding=0 width=100% bgColor=#F4CA8E>
  <tr>
    <td bgcolor=#d9d9d9><font size=1>"._POSTEDON." $datetime<b>";
  if ($admin) {
        echo "&nbsp;&nbsp;[ <a href=\"admin.php?op=EditStory&sid=$sid\">"._EDIT."</a> | <a href=\"admin.php?op=RemoveStory&sid=$sid\">"._DELETE."</a> ]";
    }
    echo "<br>"._TOPIC.": <a href=\"search.php?query=&topic=$topic&author=\">$topictext</a><br></td>
  </tr>
</table>
";   
}


function themesidebox($title, $content) {
   echo "<table height=20 cellSpacing=0 cellPadding=0 width=140 bgColor=#7E7E7E border=0>
  <tr>
    <td width=140 height=40 background=themes/Andrew/images/atas2.jpg height=20><font face=Arial size=2 color=#7E7E7E>&nbsp;&nbsp;<b>&nbsp;&nbsp;&nbsp;<b>$title</b></font>
</td>
  </tr></table><table cellSpacing=0 cellPadding=0 width=140 border=0>
 <tr>
    <td>
      <table cellSpacing=0 cellPadding=0 width=140 border=0>
        <tbody>
          <tr>    <td background=themes/Andrew/images/biru.jpg width=140 height=4> </td>
            </tr><tr><td bgcolor=#F4CA8E>$content</td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td><img src=themes/Andrew/images/kelabu.gif width=140 height=4></td>
  </tr>
</table>
<br>";
}

?>
