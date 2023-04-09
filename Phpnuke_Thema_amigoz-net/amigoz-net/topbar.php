<?php
$topbar = 1; // Set $topbar to 0 (zero) if you want to disable it.

if ($topbar == 1) {
?>
&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="index.php"><?PHP echo ""._MAIN.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="topics.php"><?PHP echo ""._TOPICS.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="sections.php"><?PHP echo ""._SECTIONS.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="links.php"><?PHP echo ""._LINKS.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="download.php"><?PHP echo ""._DOWNLOAD.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="user.php"><?PHP echo ""._ACCOUNT.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="stats.php"><?PHP echo ""._STATS.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div.gif" alt="">
<a href="top.php"><?PHP echo ""._TOP10.""; ?></a>

&nbsp;&nbsp;&nbsp;
<img src="themes/amigoz-net/images/div_mail.gif" alt="">
<a href="mailto:<?PHP global $adminmal; echo $adminmail; ?>"><?PHP echo ""._EMAIL.""; ?></a>
<?php
  }
?>