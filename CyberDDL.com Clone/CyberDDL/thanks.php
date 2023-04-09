<?php
require "config.class.php";
require "main.class.php";
require "link.class.php";
$q = trim($q);
$ddl = new ddl();
$le = new linker();
$ddl->open();
$ddl->get($q, $types);
?>
<head>
<title>Cyberddl.info</title>
<base target="_top" />
<link rel="SHORTCUT ICON" href="/images/favicon.ico" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style1 {color: #6EAD00}
.style11 {font-size: 9px; color: #FFFFFF;}
-->
</style></head>
<script type='text/javascript'>
function TG(a, changeTo)
{
a.style.backgroundColor = changeTo;
}
</script>
<body>

<div id="container">
	<div class="logoarea">
		<img alt="" src="images/header_1.gif" /><a href="index.php" onMouseOver="document.images['home'].src = 'images/h_home_b.gif'" onMouseOut="document.images['home'].src = 'images/h_home_a.gif'" onMouseDown="document.images['home'].src = 'images/h_home_b.gif'" onMouseUp="document.images['home'].src = 'images/h_home_a.gif'"><img src="images/h_home_a.gif" alt="Home" name="home" border="0" /></a><img alt="" src="images/header_2.gif" /><a href="index.html" onMouseOver="document.images['games'].src = 'images/h_rev_b.gif'" onMouseOut="document.images['games'].src = 'images/h_rev_a.gif'" onMouseDown="document.images['games'].src = 'images/h_rev_b.gif'" onMouseUp="document.images['games'].src = 'images/h_rev_a.gif'"><img name="games" src="images/h_rev_a.gif" alt="games" /></a><img alt="" src="images/header_3.gif" /><img alt="" src="images/header_logo.gif" /><img alt="" src="images/header_4.gif" /><a href="index-5.php" onMouseOver="document.images['usercp'].src = 'images/h_con_b.gif'" onMouseOut="document.images['usercp'].src = 'images/h_con_a.gif'" onMouseDown="document.images['usercp'].src = 'images/h_con_b.gif'" onMouseUp="document.images['usercp'].src = 'images/h_con_a.gif'"><img src="images/h_con_a.gif" alt="usercp" name="usercp" border="0" /></a><img alt="" src="images/header_5.gif" /><a href="index.html" onMouseOver="document.images['forums'].src = 'images/h_forums_b.gif'" onMouseOut="document.images['forums'].src = 'images/h_forums_a.gif'" onMouseDown="document.images['forums'].src = 'images/h_forums_b.gif'" onMouseUp="document.images['forums'].src = 'images/h_forums_a.gif'"><img name="forums" src="images/h_forums_a.gif" alt="forums" /></a><img alt="" src="images/header_6.gif" /></div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td class="leftmargin"></td>
			<td class="topnav"><img alt="" src="images/container_tl.gif" /></td>
			<td class="middlemargin">
			<img alt="" src="images/middlemargin_t.gif" /></td>
			<td class="topcontent"><img alt="" src="images/container_tr.gif" /></td>
			<td class="rightmargin"></td>
		</tr>
		<tr>
			<td class="leftmargin"></td>
			<td class="nav"><div align="center"></div>
			<span id="section">Navigation</span><br />
              <img alt="" src="images/seperator.gif" /><br />
» <a href="index.php">Downloads</a><br />
» <a href="index.html">Bookmark</a><br />
» <a href="index-6.php">Disclaimer</a><br />
» <a href="index-3.php">Faqs</a><br />
» <a href="index-1.php">Top Downloads</a><br />
» <a href="index-4.php">Web Links</a><br />
» <a href="index-2.php">Affiliates</a><br />
» <a href="index.html">Join LE </a><br />
» <a href="index-7.php">Advanced Search </a><br />
<br />
<span id="section">Link Exchange </span><br />
<img alt="" src="images/seperator.gif" /><br />
<table><tr><td><? 

# First number is the number of links per column, second number is the total number of links
$le->get(15,15) 

?></td></tr></table><br />
<span id="section">Downloads</span><br />
<img alt="" src="images/seperator.gif" /><br />
<div class="blacktext"> » <a href="index.php?type=App">Apps<br />
  </a> » <a href="index.php?type=Game">Games<br />
  </a> » <a href="index.php?type=Movie">Movies<br />
  </a> » <a href="index.php?type=FullAlbum">Full Albums<br />
  </a> » <a href="index.php?type=Ftp">Free FTP<br />
  </a> » <a href="index.php?type=Script">Scripts<br />
  </a> » <a href="index.php?type=Template">Templates</a><br>
  » <a href="index.php?type=Other">Others</a><br />
  <br />
  <span id="section">Webmasters</span><br />
  <img alt="" src="images/seperator.gif" /><br />
  » <a href="index-submit.php">Submit Downloads </a><br />
  » <a href="index.html">Join Link Exchange / Edit </a><br />
  » <a href="index.html">Make $$$ </a><br />
  » <a href="index.html">Advertise<br />
  » </a><a href="index-5.php">Contact Us </a><br />
  <br />
  <span id="section">Free Porn Downloads </span><br />
  <img alt="" src="images/seperator.gif" /><br />
  » <a href="index.html">Free Adult Passes </a><br />
  » <a href="index.html">Full Porn Movies </a><br />
  » <a href="index.html">Hacked Passwords </a><br />
  » <a href="index.html">Fast Porn Ftp</a></div><br />		  </td>
			<td class="middlemargin"></td>
			<td class="content">
			<div class="reviewnav">
				<span class="style1">Sponsors</span> / Ads</div>
			<br />
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
				<tr>
					<td><img alt="" src="images/review_game_logo.gif" />					</td>
				  </tr>
				<tr>
					<td valign="top"><div align="center"><br />                      
				        <br />
                        <p class="style11"><span class="style1"><font face="Verdana, Arial, Helvetica, sans-serif">......::]-[ Thank you for submitting downloads to Giga Dls DDL!</font> ]-[::......</span></p>
                        <p class="style1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">......: Your downloads will be reviewed shortly :......<b><br>
  .....:[ </b>If you follow the rules, your downloads will be accepted!<b> ]:.....</b></font></p>  
                        <br />                      
                      </div>
					  <div class="comments"><div align="center">
                    <p> <a href="index-6.php">Disclaimer: </a> This site does not store any files on its server. <br />
      We only index and link to content provided by other sites. </p>
                      </div>
                    </div>
                  <br />				  </td>
				</tr>
			</tbody>
			</table>
			</td>
			<td class="rightmargin"></td>
		</tr>
		<tr>
			<td class="leftmargin"></td>
			<td class="botnav"><img alt="" src="images/container_bl.gif" /></td>
			<td class="middlemargin">
			<img alt="" src="images/middlemargin_b.gif" /></td>
			<td class="botcontent"><img alt="" src="images/container_br.gif" /></td>
			<td class="rightmargin"></td>
		</tr>
	</tbody>
	</table>
	<br />
	<div class="footer">
		<a href="index.html">Home</a> | <a href="index-7.php">Search</a> | <a href="index.html">Webmasters</a> | <a href="index.html">Forums</a> | <a href="index.html">Contact Us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ©Copyright 2004.<a href="index.html"> Cyberddl.info</a> </div>
</div>

</body>

</html>