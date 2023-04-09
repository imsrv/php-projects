<? 
require "config.class.php";
$c = new config();
require "submitted.php"; 
# To get the list of types of downloads - just use <?=$c->option_list()? > (without the space between the last ? and >)
require "main.class.php";
require "link.class.php";
$q = trim($q);
$ddl = new ddl();
$le = new linker();
$ddl->open();
$ddl->get($q, $types);
?>
<head>
<title>submit downloads</title>
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
.style2 {
	font-size: 11px;
	color: #6EAD00;
}
.style3 {
	font-size: 11px;
	font-weight: bold;
}
.style5 {font-size: 11px}
-->
</style></head>
<script type='text/javascript'>
function TG(a, changeTo)
{
a.style.backgroundColor = changeTo;
}
</script>
<body bgcolor="#E8E8E8">

<body bgcolor="#E8E8E8">

<div align="center">
  <center>
  <table border="0" width="58%">
    <tr>
      <td width="100%">
        <p align="center"><b><font size="3" face="Arial" color="#FF0000">RULES -
        READ THEM; FOLLOW THEM OR GET BANNED</font></b></p>
        <div align="center">
          <center><table border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
					<td><p><span class="style5"><font face="Arial" color="#000000" size="2"><b>01-</b> Link
directly to the download page, not to your download section !<br>
<b>
02-</b> NO ActiveX or autohome scripts<br>
<b>
03- </b> NO forced Voting or signup for sponsors to get password, crack or whatever !<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If the file is password protected, the pass must
be visible on your ddl page !<br>
<b>
04-</b> Don't change the download page after youre are listed ( Direct blacklist )<br>
<b>
05-</b> Do not submit the same download again within one week !<br>
<b>
06-</b> Do NOT submit anything childporn / racist or hate content !<br>
<b>
07-</b> NO popups on paid hosting </font><font face="Arial" size="2" color="#FF0000"><b>(freehost
popups only 1 allowed )</b></font><font face="Arial" color="#000000" size="2"><br>
<b>
08-</b> NO DEMOS or SHAREWARE without CRACK. or SERIAL<br>
<b>
09-</b> </font><b><font face="Arial" size="2" color="#FF0000">NO /Kazaa/Emule,
Bittorrent or any kind of p2p downloads !!!<br>
</font></b><font face="Arial" size="2" color="#000000"><b>10-</b> Porn Downloads
are OK, but you need to add our affiliate box</font><font face="Arial" color="#000000" size="2"><br>
<b>11-</b> You may submit up to 5 DOWNLOADS without our AFFILIATE BOX<br>
<br>
</font><b><font face="Arial" size="2" color="#FF0000">NOTE:</font><font face="Arial" color="#000000" size="2">
Sites that add our Affiliate Box, or send traffic through our Link Exchange,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Have better chances
to be listed in a Good possition !!!</font></b><font face="Arial" color="#000000" size="2"><br>
<strong><br>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</strong></font>
<strong><font face="Arial" color="#000000" size="4">AFFILIATE BOX</font>
</strong></span></p>

                      <div align="center">
                        <center>

<table bordercolor="#E9E9E9" bgcolor="#E9E9E9">
  <tr>
    <td width="50%">
      <!-- Start Cyberddl Code -->
<a href=http://www.cyberddl.info><script src=http://www.cyberddl.com.ar/affiliate.js></script></a>
<!-- End Cyberddl Code -->
    </td>
    <td width="50%"><textarea rows="2" name="S1" cols="20"><!-- Start Cyberddl Code -->
<a href=http://www.cyberddl.com.ar><script src=http://www.cyberddl.com.ar/affiliate.js></script></a>
<!-- End Cyberddl Code --></textarea></td>
  </tr>
</table>

                        </center>
                      </div>

<p><span class="style5"><font face="Arial" color="#000000" size="2">
<strong>
<br>
</strong></font></span></p>
			</td>
				  </tr>
				<tr>
					<td valign="top"><div align="center"><span class="recentlinks style2"><span class="recentlinks  style3"><span class="recentlinks  style5"><font face="Verdana, Arial, Helvetica, sans-serif">..: Disclaimer :..</font></span></span></span><br />                      
			            <br>
		           <table width="620">
                    <form name="add" action="submit.php" method="POST"><tr><td width="120" class="form"><font size=1px>Dl Name 1*</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td width="120" class="form">&nbsp;&nbsp;Dl Url 1*</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 2</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 2</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 3</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 3</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 4</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 4</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 5</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 5</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 6</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 6</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 7</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 7</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 8</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 8</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 9</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 9</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>
<tr><td class="form" width="120">Dl Name 10</td><td width="186"><input type="text" name="title[]" class="box" size="20">
</td><td class="form" width="120">&nbsp;&nbsp;Dl Url 10</td><td width="174"><input type="text" name="url[]" class="box" size="20">
</td><td width="97"><select name="type[]" class=box>
        <option>Game</option>
        <option>App</option>
        <option>Movie</option>
        <option>MP3</option>
        <option>Ftp</option>
        <option>Script</option>
		<option>Template</option>
        <option>Other</option>
      </select></tr>

<tr><td class="form" width="120"><br>Site Name*</td><td width="186"><br><input type="text" name="sname" class="form" size="20">
</td><td class="form" width="120"><br>&nbsp;&nbsp;Site Url*</td>
<td width="174"><br><input type="text" name="surl" class="form" size="20"></td></tr><tr><td class="form" width="120">E-mail</td>
<td colspan="4" width="595"><input type="text" name="email" class="form" size="20"></td></tr>
<tr><td width="120"></td><td colspan="4" class="form" width="595"><br><input type="Submit" value="Submit Download" class="form">
&nbsp;&nbsp; - Press Only Once!! Submission May Take A While</td></tr></form></table>
                </div>
              </td>
    </tr>
  </table>
          </center>
        </div>
  </center>
  </table>


</body>

</html>