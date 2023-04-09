<?php
require "config.class.php";
require "main.class.php";
require "link.class.php";
$q = stripslashes($q);
$q = eregi_replace("\"", " ", $q);
$q = eregi_replace("\'", " ", $q);
$q = trim($q);
$ddl = new ddl();
$le = new linker();
$ddl->open();
$ddl->get($q, $types);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>X-ddl.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
style {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	text-decoration: none;
	background-color: #000000;
	color: #FFFFFF;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
ol {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
font {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
-->
</style>
<style type="text/css">
<!--
td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
	text-align: center;
}
form {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	text-decoration: none;
}
input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #993333;
	text-decoration: none;
}
tr {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
-->
</style>
</head>

<body bgcolor="#000000" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF" topmargin="0">
<table width="748" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><img src="logo.jpg" width="748" height="85"></td>
  </tr>
  <tr bordercolor="#FF99CC"> 
    <td vAlign="center" noWrap align="middle" background="catbg3.gif" height="19" style="font-family: Verdana, Arial, Helvetica, sans-serif"> 
      <span class="mainmenu"> 
      <p align="center"><a href="http://www.x-ddl.com"><font size="1" color="#FFFFFF">Home</font></a><font color="#000000" size="1"> 
        || </font><a href="javascript:bookmark();"><font color="#FFFFFF" size="1"> 
        Add to Favorites</font></a><font color="#000000" size="1"> || 
        <!--[if IE]>
<font face="Verdana" size="1">
<A HREF="#"
onClick="this.style.behavior='url(#default#homepage)';
this.setHomePage('http://www.x-ddl.com');">
    <font color="#FFFFFF">Set as Home Page </font>
</A>
</font>
<![endif]-->
        || <a href="mailto:punkais80@hotmail.com"><font color="#FFFFFF">Contact 
        Us</font></a> || <a target="main" href="mailto:punkais80@hotmail.com"><font color="#FFFFFF">Advertising</font></a> 
        || <a href="http://forum.x-ddl.com">FORUMS</a></font></p>
      </span></td>
  </tr>
  <tr> 
    <td height="100"><a href="http://www.myforuma.com"><img src="myforuma.gif" width="700" height="90" border="0"></a>



  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="16%" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#993333">
              <tr> 
                <td height="14" background="catbg3.gif">Webmasters</td>
              </tr>
              <tr> 
                <td height="80"><a href="submit.php" target="_blank">Submit Downloads</a><br> 
                  <a href="join.php" target="_blank">Join Link Exchange</a><br> 
                  <a href="edit.php" target="_blank">Edit Link Exchange</a> <br> 
                  <a href="disclaimer.php" target="_blank"> Disclaimer </a><br> 
                  <a href="mailto:punkais80@hotmail.com" target="_blank">Contact 
                  Us</a> <br> </td>
              </tr>
            </table>
            <br> <form action="index.php" method="post" name="form1" target="_blank">
              <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#993333" background="catbg3.gif">
                <tr> 
                  <td height="52"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td>Search Our Downloads</td>
                      </tr>
                      <tr> 
                        <td><input name="q" type="text" id="q" size="20"></td>
                      </tr>
                      <tr> 
                        <td><input type="submit" name="Submit" value="Searsh"></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <br>
              <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#993333">
                <tr> 
                  <td height="14" background="catbg3.gif">Friends</td>
                </tr>
                <tr> 
                  <td height="277" valign="top"><p align="center"><a href="http://www.full-ddlz.com/in.php?id=FULLa" target=_blank><img src="http://www.full-ddlz.com/logobx.gif" width="92" height="36" border="0"></a><br>
                      <br>
                      <!-- Start Adhearus.com Ad Code -->

                      <a href="http://www.warez-zone.net/in.php?id=xddl" target=_blank><img src="warezzone.GIF" width="88" height="31" border="0"></a><br>
                      <br>
                      <a href="http://www.netsurf.ru" target=_blank><img src="netsurf2.gif" width="88" height="31" border="0"></a><br>
                      <br>
                      <a href="http://www.hotfiles.tk" target="_blank"><img src="hotfiles.png" width="88" height="31" border="0"></a><br>
                      <br>
                      <a href="http://www.katz.ws/in.php?id=kimahoua8">KATZ </a><br>
                      <a href="http://www.ddl2.com/in.php?id=kimahoua8">DDL2 </a><br>
                      <a href="http://www.ddlworld.com/in.php?id=kimahoua8">DDLLWORLD</a><br>
                      <a href="http://www.gotwarez.net/in.php?id=kimahoua8">GotWarez.net </a><br>
                      <a href="http://www.ddlspot.com/in.php?id=kimahoua8">DdlSpot </a><br>
                      <a href="http://www.ddloutpost.com/in.php?id=kimahoua8">ddloutpost </a><br>
                      <a href="http://www.phazeddl.com/in.php?id=kimahoua8">phazeddl </a><br>
                      <a href="http://www.gotwarez.net/in.php?id=kimahoua8">gotwarez.net </a><br>
                      <a href="http://www.directwarez.com/in.php?id=kimahoua8">directwarez </a><br>
                      <a href="http://www.warezpost.org/in.php?id=kimahoua8">warezpost.org </a><br>
                      <a href="http://www.ddlporn.com/in.php?id=kimahoua8">ddlporn </a><br>
                      <a href="http://www.ddlnetwork.net/in.php?id=kimahoua8">ddlnetwork.net </a><br>
                      <a href="http://www.ddldirect.com/in.php?id=kimahoua8">ddldirect </a><br>
                      <a href="http://ddl.220volt.info/in.php?id=kimahoua8">ddl.220volt.info </a><br>
                      <a href="http://www.ultimateddl.com/in.php?id=kimahoua8">ultimateddl </a><br>
                      <a href="http://www.qualityddl.com/in.php?id=kimahoua8">qualityddl </a><br>
                      <a href="http://www.grizzlyddl.com/in.php?id=kimahoua8">grizzlyddl </a><br>
                      <a href="http://www.warezcollector.com/in.php?id=kimahoua8">warezcollector </a><br>
                      <a href="http://www.ddlplanet.com/in.php?id=kimahoua8">ddlplanet </a><br>
                      <a href="http://www.ultimateddl.com/in.php?id=kimahoua8">ultimateddl </a><br>
                      <a href="http://www.warezlist.com/vote-gateway/vote.php?account=12747">warezlist </a><br>
                      <a href="http://www.freeserials.com/url/click.php?login=kddk&direct=in">FreeSerial </a><br>
                      <a href="http://topsites.andr.net/in.php?sid=8352">ANDER TOPZ </a><br>
                      <a href="http://www.topz.org/cgi-bin/in.cgi?id=11">TOPZ </a><br>
                      <a href="http://nwow.free.fr/in.php?id=9147">Frensh warez </a><br>
                      <a href="http://www.toplistxp.com/cgi-bin/rankem.cgi?id=xdddl">TOP LIST XP </a><br>
                      <a href="http://www.oday-warez.com/cgi-bin/intellilink/in.cgi?id=1102385643">0 DAY warez </a><br>
                      <a href="http://www.fulldls.com/Directdl/in.php?id=punkais78">Full DDLl</a><br>
                      <a href="http://ddproduction.epsylon.org">DDPRODUCTION </a>                      <br>
                  </td>
                </tr>
              </table>
              <br>
           <form action="http://www.questseek.com/search.cgi" target="_blank">
                      <div align="center">
                        <input type="hidden" name="acc" value="punkais">
                        <input name="web" type="text" style="font-family: Verdana" value="xxx">
                        <input type="submit" value="Search" style="font-family: Verdana" name="submit">
                      </div>
                    </form>
              <br>
          
            </form></td>
          <td width="66%" align="left" valign="top"><table width="91%" height="15" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#993333">
              <tr> 
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#993333">
                    <tr> 
                      <td background="catbg3.gif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Download 
                        Name</font></td>
                      <td background="catbg3.gif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Added</font></td>
                      <td background="catbg3.gif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Provider</font></td>
                      <td background="catbg3.gif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Bad 
                        Link?</font></td>
                    </tr>
                    <?    while(list($id, $type, $title, $url, $sname, $surl, $date, $views) = mysql_fetch_row($ddl->get)) {
	echo "<tr> 
                <td ><a href=\"go.php?go=Download&id=$id\" target=\"_blank\">$title</a></td>
                <td >$date</td>
                <td ><a href=\"$surl\" target=\"_blank\">$sname</a></td>
				<td ><a href=\"go.php?go=Download&id=$id&go=Report\" target=\"_blank\">Report it</a></td>
              </tr>";
}
?>
                  </table></td>
              </tr>
            </table></td>
          <td width="18%" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#993333">
              <tr> 
                <td background="catbg3.gif"><div align="center">Best Warez Sites</div></td>
              </tr>
              <tr> 
                <td> 
                  <?
$le->get(25,25) 
?>
                  <div align="center"></div></td>
              </tr>
            </table>
            <br>
            <a href="http://www.x-ddl.com/ut.php?id=illegallist"><img src="illegallist.gif" width="88" height="31" border="0"></a> <br>
            <br>
          </td>
        </tr>
      </table>
		  </td>
  </tr>
</table>
<br>
<table width="748" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>Page: 
      <? if (!$q) $ddl->page("index.php?page="); else $ddl->page("ddl.php?q=$q&page="); ?>
    </td>
  </tr>
</table>

<div align="center"><br>
  X- DDL.com does not store any of the files listed on its server. We are just 
  indexing other sites contents :<a href="disclaimer.php" target="_blank"> Disclaimer 
  </a>.<br>
  &copy; Copyright 2004 . X-DDL.com. 
<br>
<br>

<!-- Start Gamma Entertainment Banner Code -->
<!-- End Gamma Entertainment Banner Code -->



<!--ONESTAT SCRIPTCODE START-->
<!--
// Modification of this code is not allowed and will permanently disable your account!
// Account ID : 215986
// Website URL: http://www.x-ddl.com
// Copyright (C) 2002-2004 OneStat.com All Rights Reserved
-->
<div id="OneStatTag"></div>
<!--ONESTAT SCRIPTCODE END-->



</div>



</body>
</html>