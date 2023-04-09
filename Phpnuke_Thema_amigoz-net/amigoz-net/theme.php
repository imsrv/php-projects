<?php

$bgcolor1 = "#C4CEDB";
$bgcolor2 = "#B0C1D3";
$bgcolor3 = "#E5E6DE";
$bgcolor4 = "#92A0AE";
$textcolor1 = "#000000";
$textcolor2 = "#000000";

function OpenTable() {
    global $bgcolor1, $bgcolor2;
    ?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"><TR><TD>
<TABLE border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
  <TR>
    <TD height="8" width="8" class=top-left><IMG src="themes/amigoz-net/images/pix.gif" height="8" width="8" alt=""></TD>
    <TD height="8" class=top-center><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
    <TD width="8" height="8" class=top-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
  </TR>
  <TR>
    <TD width="8" class=tab-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
    <TD class=tab-center>
<?php
}

function CloseTable() {
?>
    </TD>
    <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
  </TR>
  <TR>
    <TD width="8" height="8" class=bottom-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
    <TD height="8" class=bottom-center><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
    <TD width="8" height="8" class=bottom-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
  </TR>
</TABLE>
</TD></TR></TABLE>
<?php
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"><TR><TD>
<TABLE border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
  <TR>
    <TD height="8" width="8" class=top-left><IMG src="themes/amigoz-net/images/pix.gif" height="8" width="8" alt=""></TD>
    <TD height="8" class=top-center><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
    <TD width="8" height="8" class=top-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
  </TR>
  <TR>
    <TD width="8" class=tab-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
    <TD class=tab-center>
<?php
}

function CloseTable2() {
?>
    </TD>
    <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
  </TR>
  <TR>
    <TD width="8" height="8" class=bottom-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
    <TD height="8" class=bottom-center><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
    <TD width="8" height="8" class=bottom-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
  </TR>
</TABLE>
</TD></TR></TABLE>
<?php
}

function FormatStory($thetext, $notes, $aid, $informant) {
    global $anonymous, $index;
    if ($notes != "") {
        $notes = "<FONT size=\"1\"><b>"._NOTE."</b> <i>$notes</i></FONT>\n";
    } else {
        $notes = "";
    }
    if ("$aid" == "$informant") {
        echo "$thetext<br>$notes\n";
    } else {
        if($informant != "") {
            $boxstuff = "<a href=\"user.php?op=userinfo&amp;uname=$informant\">$informant</a> ";
        } else {
            $boxstuff = "$anonymous ";
        }
          if ($index == 1) {
           $boxstuff .= ""._WRITES." <i>\"$thetext\"</i> <BR>$notes\n";
           } else {
           $boxstuff = "$thetext<BR>$notes\n";
           }
        echo "$boxstuff\n";
    }
}

function themeheader() {
    global $sitename, $banners, $anonymous, $username, $user, $cookie;
cookiedecode($user);
$username = $cookie[1];
if ($username == "") {
$username = "Anonymous";
}
?>
<BODY>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD height="24" colspan="2" class=topbar nowrap><IMG src="themes/amigoz-net/images/pix.gif" alt=""><?php include ("themes/amigoz-net/topbar.php"); ?></TD>
  </TR>
</TABLE>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD height="8" colspan="2"><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
  </TR>
  <?php
      if ($banners) {
  ?>
  <TR>
    <TD height="60" align="left" nowrap>
      <P><IMG src="themes/amigoz-net/images/logo.gif" alt=""></P>
    </TD>
    <TD>
    <?php
      include("banners.php");
    ?>
    </TD>
  </TR>

  <?php
     }else{
  ?>
  <TR>
    <TD height="60" align="center" colspan="2" nowrap>
      <IMG src="themes/amigoz-net/images/logo.gif" alt="">
    </TD>
  </TR>
  <?php
  }
  ?>
  <TR>
    <TD height="16" colspan="2"><IMG src="themes/amigoz-net/images/pix.gif" height="16" alt=""></TD>
  </TR>
</TABLE>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD width="80%" align="left" valign="middle" class=title nowrap>
<?php
  if ($username == "Anonymous") {
?>
      <form action=user.php method=post>
        &nbsp; <?PHP echo ""._LOGIN.""; ?>&nbsp;
        <input class=textbox type=text name=uname size=12 maxlength=25>
        &nbsp; <?PHP echo ""._PASSWORD.""; ?>&nbsp;
        <input class=textbox type=password name=pass size=12 maxlength=20>
        &nbsp;&nbsp;
        <input type=image src="themes/amigoz-net/images/buttons/login.gif">
        <a href="user.php"><img src="themes/amigoz-net/images/buttons/register.gif" alt="" border="0"></a>
        <input type=hidden name=op value=login>
      </form>
<?php     } else { ?>
<B>&nbsp;&nbsp;<?PHP echo ""._HELLO.""; ?>, <?php echo $username; ?>!</B>
&nbsp;<a href="user.php"><img src="themes/amigoz-net/images/menu/users.gif" alt="<?PHP echo ""._ACCOUNT.""; ?>" border="0"></a>
&nbsp;<a href="index.php"><img src="themes/amigoz-net/images/menu/home.gif" alt="<?PHP echo ""._MAIN.""; ?>" border="0"></a>
&nbsp;<a href="submit.php"><img src="themes/amigoz-net/images/menu/submit.gif" alt="<?PHP echo ""._SUBMITNEWS.""; ?>" border="0"></a>
&nbsp;<a href="download.php"><img src="themes/amigoz-net/images/menu/download.gif" alt="<?PHP echo ""._DOWNLOADS.""; ?>" border="0"></a>
&nbsp;<a href="links.php"><img src="themes/amigoz-net/images/menu/links.gif" alt="<?PHP echo ""._LINKS.""; ?>" border="0"></a>
&nbsp;<a href="mailto:mrhemp@amigoz.net"><img src="themes/amigoz-net/images/menu/mail.gif" alt="<?PHP echo ""._EMAIL.""; ?>" border="0"></a>
&nbsp;<a href="user.php?op=logout"><img src="themes/amigoz-net/images/menu/logout.gif" alt="<?PHP echo ""._LOGOUT.""; ?>" border="0"></a>
<?php
  }
?>

    </TD>
    <TD width="20%" align=right valign="middle" nowrap>
       <form action=search.php method=post>
       <input type=text name=query size=12>
       <input type=image src="themes/amigoz-net/images/buttons/search.gif">
       <input type=hidden value=submit>&nbsp;&nbsp;
       </form>
    </TD>
  </TR>
  <TR>
    <TD height="16" colspan="2"><IMG src="themes/amigoz-net/images/pix.gif" height="16" alt=""></TD>
  </TR>
</TABLE>
&nbsp;<BR>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
    <TD width="146" valign="top">
       <?php blocks(left); ?>
    </TD>
    <TD width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
    <TD valign="top">
<?php
}

function themefooter() {
    global $index; ?>
<?php
  if ($index == 1) {
?>
    </TD>
    <TD width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
    <TD width="146" valign="top">
    <?php blocks(right); ?>
    </TD>
<?php
}
?>
    <TD width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
  </TR>
</TABLE>
<?php
  footmsg();
}

function themeindex ($aid, $informant, $datetime, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
        global $tipath, $anonymous, $admin, $sid;
        ?>
        <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <TR>
          <TD height="8" width="8" class=top-left><IMG src="themes/amigoz-net/images/pix.gif" height="8" width="8" alt=""></TD>
          <TD height="8" class=top-center><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
          <TD width="8" height="8" class=top-right><IMG src="themes/amigoz-net/images/pix.gif" height="8" width="8" alt=""></TD>
        </TR>
        <TR>
          <TD class=middle-left width="8" height="16"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
          <TD class=middle-center2 height="16" nowrap>
            &nbsp;&nbsp;&nbsp;&nbsp;<B><?php echo "$title"; ?></B></TD>
          <TD width="8" class=middle-right height="16"><IMG src="themes/amigoz-net/images/pix.gif" alt=""></TD>
        </TR>
        <TR>
          <TD class=tab-left width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
          <TD class=tab-center-posted>
           <?php echo ""._POSTEDBY.""; ?> <?php formatAidHeader($aid); ?> <?php echo _ON." $datetime $timezone "."($counter "._READS.")"; ?>
          </TD>
          <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
        </TR>
        <TR>
          <TD class=tab-left width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
          <TD class=tab-center>
            <a href="search.php?query=&amp;topic=<?php echo"$topic"; ?>&amp;author="><img src="<?php echo "$tipath$topicimage"; ?>" border=0 Alt=<?php echo"\"$topictext\""; ?> align=right hspace=10 vspace=10></a>
            <?php FormatStory($thetext, $notes, $aid, $informant); ?>
            &nbsp;<BR>
          </TD>
          <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
        </TR>
        <TR>
          <TD class=middle-left width="8" height="16"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
          <TD class=middle-center3 height="16" nowrap>
            <img src="themes/amigoz-net/images/menu.gif" alt="" border=0>
            <?php echo "$morelink"; ?>
          </TD>
          <TD width="8" class=middle-right height="16"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
        </TR>
        <TR>
          <TD class=bottom-left width="8" height="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
          <TD class=bottom-center height="8"><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
          <TD class=bottom-right width="8" height="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
        </TR>
        <TR>
          <TD height="8"><IMG src="themes/amigoz-net/images/pix.gif" alt=""></TD>
        </TR>
      </TABLE>
<?php
}

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
        global $admin, $sid, $tipath;
?>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <TR>
          <TD height="8" width="8" class=top-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
          <TD class=top-center height="8"><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
          <TD width="8" height="8" class=top-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
        </TR>
        <TR>
          <TD class=middle-left width="8" height="16"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
          <TD class=middle-center2 height="16" nowrap>
            &nbsp;&nbsp;&nbsp;&nbsp;<B><?php echo "$title"; ?></B></TD>
          <TD width="8" class=middle-right height="16"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
        </TR>
        <TR>
          <TD class=tab-left width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
          <TD class=tab-center-posted>
            <?php echo _POSTEDON." $datetime "._BY; ?> <?php formatAidHeader($aid); ?>
            <?php if ($admin) {
                    echo "&nbsp;&nbsp;[ <a href=admin.php?op=EditStory&amp;sid=$sid>"._EDIT."</a> | <a href=admin.php?op=RemoveStory&amp;sid=$sid>"._DELETE."</a> ]";
                      } ?>
            <BR>
            <?php echo ""._CONTRIBUTEDBY." <a href=\"user.php?op=userinfo&amp;uname=$informant\">$informant</a>"; ?>
          </TD>
          <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
        </TR>
        <TR>
          <TD class=tab-left width="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
          <TD class=tab-center>
            <a href="search.php?query=&amp;topic=<?php echo"$topic"; ?>&amp;author="><img src="<?php echo "$tipath$topicimage"; ?>" border=0 Alt=<?php echo"\"$topictext\""; ?> align=right hspace=10 vspace=10></a>
            <?php FormatStory($thetext, $notes, $aid, $informant); ?>
            <BR><BR>
          </TD>
          <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
        </TR>
        <TR>
          <TD class=bottom-left width="8" height="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
          <TD class=bottom-center height="8"><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
          <TD width="8" class=bottom-right height="8"><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
        </TR>
        <TR>
          <TD height="8"><IMG src="themes/amigoz-net/images/pix.gif" alt="" height="8"></TD>
        </TR>
      </TABLE>
<?php
}

function themesidebox($title, $content) {
?>
      <TABLE width="160" border="0" cellspacing="0" cellpadding="0">
        <TR>
          <TD height="8" width="8" class=top-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
          <TD height="8" width="144" class=top-center><IMG src="themes/amigoz-net/images/pix.gif" width="144" height="8" alt=""></TD>
          <TD width="8" height="8" class=top-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
        </TR>
        <TR>
          <TD width="8" height="16" class=middle-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
          <TD height="16" width="144" nowrap class=middle-center>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo"$title"; ?></b></TD>
          <TD width="8" height="16" class=middle-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="16" alt=""></TD>
        </TR>
        <TR>
          <TD width="8" class=tab-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
          <TD width="144" class=tab-center><?php echo"$content"; ?></TD>
          <TD width="8" class=tab-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" alt=""></TD>
        </TR>
        <TR>
          <TD width="8" height="8" class=bottom-left><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
          <TD height="8" width="144" class=bottom-center><IMG src="themes/amigoz-net/images/pix.gif" width="144" height="8" alt=""></TD>
          <TD width="8" height="8" class=bottom-right><IMG src="themes/amigoz-net/images/pix.gif" width="8" height="8" alt=""></TD>
        </TR>
        <TR>
          <TD height="8"><IMG src="themes/amigoz-net/images/pix.gif" height="8" alt=""></TD>
        </TR>
      </TABLE>

<?php
}
?>
