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
    <td height="100"><!-- Start Adhearus.com Ad Code -->
<script type='text/javascript'>
<!--
var adhearus_webmaster_id = 14810;
var adhearus_site_id = 21826;
var adhearus_ad_size = '468x60';
var adhearus_link_color = '#FFFFFF';
var adhearus_text_color = '#FFFFFF';
var adhearus_bgcolor = '#000000';
var adhearus_border_color = '#FF0000';
var adhearus_text_ads = '1';
//-->
</script>
<script type='text/javascript'
       src='http://adhearus.com/display_ad.js'>
</script>
<!-- End Adhearus.com Ad Code --></td>
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
            <br> <form name="form1" method="post" action="index.php">
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
                  <td height="277"><p align="center"><a href="http://www.full-ddlz.com/in.php?id=FULLa%20" target=_blank><img src="http://www.full-ddlz.com/logobx.gif" width="92" height="36" border="0"></a><br>
                      <br>
                      <!-- Start Adhearus.com Ad Code -->
                      <script language="" type='text/javascript'>
<!--
var adhearus_webmaster_id = 14810;
var adhearus_site_id = 21826;
var adhearus_ad_size = '88x31';
var adhearus_link_color = '#FFFFFF';
var adhearus_text_color = '#FFFFFF';
var adhearus_bgcolor = '#FFFFFF';
var adhearus_border_color = '#000000';
var adhearus_text_ads = '0';
//-->
</script>
<script type='text/javascript'
       src='http://adhearus.com/display_ad.js'>
</script>
<!-- End Adhearus.com Ad Code -->
					  <br>
                      <br>
                      <a href="mailto:punkais80@hotmail.com" target=_blank><img src="http://www.full-ddlz.com/banner_here.gif" width="92" height="36" border="0"></a><br>
                      <br>
                      <a href="mailto:punkais80@hotmail.com" target=_blank><img src="http://www.full-ddlz.com/banner_here.gif" width="92" height="36" border="0"></a><br>
                      <br>
                      <a href="mailto:punkais80@hotmail.com" target=_blank><img src="http://www.full-ddlz.com/banner_here.gif" width="92" height="36" border="0"></a><br>
                      <br>
                      YOUR BANNER
                  </td>
                </tr>
              </table>
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
$le->get(25, 25) 
?>
                  <div align="center"></div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
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
<!-- Begin Nedstat Basic code -->
<!-- Title: X-DDL.com -->
<!-- URL: http://www.x-ddl.com/ -->
<script language="JavaScript" type="text/javascript" 
src="http://m1.nedstatbasic.net/basic.js">
</script>
<script language="JavaScript" type="text/javascript" >
<!--
  nedstatbasic("ADC1TgMXxchowe8JjzEUB8h7KbRQ", 0);
// -->
</script>
<noscript>
<a target="_blank" 
href="http://www.nedstatbasic.net/stats?ADC1TgMXxchowe8JjzEUB8h7KbRQ"><img
src="http://m1.nedstatbasic.net/n?id=ADC1TgMXxchowe8JjzEUB8h7KbRQ"
border="0" width="18" height="18"
alt="Nedstat Basic - Free web site statistics
Personal homepage website counter"></a><br>
<a target="_blank" href="http://www.nedstatbasic.net/">Free counter</a>
</noscript>
<!-- End Nedstat Basic code -->
</div>
</body>
</html>

