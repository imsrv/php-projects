<?
function get_micro() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
$start = get_micro();

require "config.class.php";
require "edit.class.php";
$e = new edit();
$e->open();
$e->headers();
$login = 1;
if ($go == "logout")
	$e->logut();

if ($l[user] && $l[pass]) {
	if (!$e->login($l[user], $l[pass]))
		$feil = 1;
}

?>
<html>
<head>
<title><?=$e->site_name?> - Admin Board</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body bgcolor="#ffcc00" text="#000000" link="#0066FF" vlink="#0066FF" alink="#0066FF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onunload=xit();>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td valign="top" height="100%" width="150"> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="#ffcc00">
        <tr bgcolor="#ffff99"> 
          <td width="150" colspan="2" height="70"> 
            <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="http://cyberddl.info" target="_blank"> 
              <font size="1">Cyberddl.info</font></a></font></b></div>
          </td>
        </tr>
        <tr> 
          <td height="1" bgcolor="#555555" colspan="2"></td>
        </tr>
        <tr> 
          <td width="10" bgcolor="#ffcc00"></td>
          <td width="140" bgcolor="#ffcc00" class="meny" valign="top"> 
            <p><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
              <a href="admin.php" class="meny">Home</a><br>
              <br>
              <a href="admin.php?go=added" class="meny">Submitted Downloads</a><br>
              <a href="admin.php?go=report" class="meny">Reported Links</a><br>
              <a href="admin.php?go=add" class="meny">Add Download</a><br>
              <a href="admin.php?go=blacklist" class="meny">Blacklist</a><br>
              <a href="admin.php?go=stats" class="meny">View/Edit Downloads</a><br>
              <br>
              <a href="admin.php?go=link&s=stats" class="meny">View/Edit Links</a><br>
              <a href="admin.php?go=link&s=add" class="meny">Add Link</a><br>
              <br>
              <a href="admin.php?go=email" class="meny">E-Mail Webmasters</a><br>
              <a href="admin.php?go=logout" class="meny">Log out</a><br>
              <br>
              <a href="http://www.ultimateddl.com/Contact" target="_blank" class="meny">Help 
              - Contact Sickboy</a><br>
              </font></p>
          </td>
        </tr>
        <tr> 
          <td></td>
          <td> 
            <div align="center"><font size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif"><small>20&copy;01 
              kaoz</small></font></b></font></div>
          </td>
        </tr>
      </table>
    </td>

    <td width="1"></td>
    <td valign="top" width="868"><br>
      <?
if ($login == false) {
	switch ($go) {
		case "report" : $e->reported($sub); break;
		case "add" : $e->add("admin.php?go=add", 1); break;
		case "added" : $e->que($sub); break;
		case "stats" : $e->stats($id); break;
		case "blacklist" : $e->edit_blacklist(); break;
		case "email" : require "email.class.php"; $mail = new email(); $mail->send(); break;
		case "link" : require "link.class.php"; $l = new linker();
			switch ($s) {
				case "add" : $l->add(); break;
				default : if ($id) $l->edit($id); else $l->stats(); break;
			}
			break;
		default : $e->main($l[user]); break;
	}
} else {

if (!$feil)
	echo "<b>Welcome to Cyberddl.info admin, please enter your username and password!<br><br>";
else
	echo "<font color=red><b>Wrong username or password!</b></font><br><br>";
?>
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="#ffcc00">
        <form name="login" action="admin.php" method="POST">
<tr>
            <td class="form2" bgcolor="#ffcc00">Username: </td>
            <td> 
              <input type="text" class="box" name="l[user]" size="20"></td></tr>
<tr>
            <td class="form2" bgcolor="#ffcc00">Password: </td>
            <td> 
              <input type="password" class="box" name="l[pass]" size="20"></td></tr>
          <tr> 
            <td bgcolor="#ffcc00"></td>
            <td bgcolor="#ffcc00"> 
              <input type="Submit" value="Log In" class="box"></td></tr></form></table>

<? } $e->close(); ?>
</td></tr>

</table>
<!-- Generated in <?=get_micro()-$start?> seconds-->
</body>
</html>