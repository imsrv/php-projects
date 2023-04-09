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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=$e->site_name?> - Admin Board</title>
<style type="text/css">
.meny			{text-decoration:none; font-family:Verdana; font-size:10; font-weight:bold; color:#000000;}
.meny:hover		{text-decoration:underline; color:#000000}
.meny:active	{text-decoration:none; color:#000000}
td				{font-family:Verdana; font-size:12; color:#000000}
.form			{font-family:Verdana; font-size:10;}
.form2			{font-family:Verdana; font-size:10; font-weight:bold;}
a				{text-decoration:underline; color:#000000}
a:hover			{text-decoration:none; color:#000000}
a:active		{text-decoration:none; color:#000000}
</style>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#F1F1F1">

<table border="0" cellspacing="0" cellpadding="0">
<tr><td valign="top" height="100%"><table border="0" cellspacing="0" cellpadding="0">
<tr><td width="150" colspan="2" height="70">
  <a href="http://www.ddlcenter.com" target="_blank">
<img src="admin.gif" alt="QualityDDL.com" border="0"></a></td></tr>
<tr><td height="1" bgcolor="#F1F1F1" colspan="2"></td></tr>
<tr><td width="10" bgcolor="#F1F1F1"></td>
  <td width="140" bgcolor="#F1F1F1" class="meny" valign="top" align="left">
  <table border="0" width="100%">
    <tr>
      <td width="100%">
<a href="admin.php" class="meny"><font face="Verdana" size="1"><img border="0" src="shape.gif" align="left"><font color="#000000">Home</font></font></a></td>
    </tr>
    <tr>
      <td width="100%">Download Stuff</td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=added" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">Que</font></a></td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=report" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">Reported Links</font></a></td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=add" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">Add Download</font></a></td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=blacklist" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">Blacklist</font></a></td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=stats" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">View/Edit
        Downloads</font></a></td>
    </tr>
    <tr>
      <td width="100%">LE Stuff</td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=link&s=stats" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">View/Edit Links</font></a></td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=link&s=add" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">Add Link</font></a></td>
    </tr>
    <tr>
      <td width="100%">Other Stuff</td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=email" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">E-Mail Webmasters</font></a></td>
    </tr>
    <tr>
      <td width="100%"><a href="admin.php?go=logout" class="meny"><img border="0" src="shape.gif" align="left"><font color="#000000">Log out</font></a></td>
    </tr>
  </table>
  </td></tr><tr><td height="2" bgcolor="#C0C0C0" colspan="2"></td></tr><tr>
<td height="1" bgcolor="#000000" colspan="2"></td></tr><tr><td></td><td>
<font color="#000000">
<small>2002 </font>
<a target="_blank" href="http://ddlnetwork.net">DDLNetwork.net</a></small></td></tr></table></td>

<td width="8"></td><td valign="top"><br>
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
	echo "<b>Welcome to the kDDL Admin Board, please enter your username and password!<br><br>";
else
	echo "<font color=red>Wrong username or password!</font><br><br>";
?>

<table border="0" cellspacing="2" cellpadding="2"><form name="login" action="admin.php" method="POST">
<tr><td class="form2">Username: </td><td><input type="text" class="form" name="l[user]" size="20"></td></tr>
<tr><td class="form2">Password: </td><td><input type="password" class="form" name="l[pass]" size="20"></td></tr>
<tr><td></td><td><input type="Submit" value="Log In" class="form"></td></tr></table>

<? } $e->close(); ?>
</td></tr>

</table>
<!-- Generated in <?=get_micro()-$start?> seconds-->
</body>
</html>