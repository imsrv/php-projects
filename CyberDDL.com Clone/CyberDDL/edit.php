<?
$hopp = true;
require "join.php";
$c = new config();

function login() {
	echo "<br><link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\"><BODY bgColor=#ffffff text=#000000 leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\"><br>
<form name=login action=\"edit.php\" method=\"POST\">
<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" align=center><tr><td class=form><b>Username:</b> </td><td><input type=text name=user size=20 class=box></td></tr>
<tr class=form><td><b>Password:</b> </td><td><input type=password name=pass size=20 class=box></td></tr><tr><td></td>
<td><input type=submit value=\"Log In\" class=box></td></tr></table>";
}

echo "<html>\n<head>\n<title>TUNWarez DDL - Edit LE</title>\n<style type=\"text/css\">\n"
	.".form		{font-family:Verdana; font-size:10;}\n</style>\n</head>\n<body class=form>\n";
if (!$user || !$pass)
	login();
else {
	$c->open();
	$err = array();
	$user = addslashes($user);
	$pass = addslashes($pass);
	$get = mysql_query("SELECT * FROM $c->mysql_tb_le WHERE id='$user' && pass=password('$pass')");
	if (!mysql_num_rows($get)) {
		echo "<center><font face=Verdana size=2 color=red><b>Wrong username/password!</b></font><br></center>";
		login();
	} else {
		if ($le && !$le[pass] || !$le[email] || !$le[url]) {
			if (!$le[pass])
				$err[pass] = "you must enter a password!";
			if (!$le[email])
				$err[email] = "enter your real e-mail address!";
			if (!$le[name])
				$err[name] = "what is your sites name?";
			if (!$le[url])
				$err[url] = "you must enter your sites url!";
			$row = $le;
			$le[id] = $le[user];
			$le[title] = $le[name];
			$pass = $le[pass];
		} elseif ($le) {
			@mysql_query("UPDATE $c->mysql_tb_le SET pass=password('$le[pass]'), title='$le[name]', url='$le[url]', email='$le[email]' WHERE id='$user'");
			echo "<font face=Verdana size=2><b>Updated!</b></font><br><br>";
			$get = mysql_query("SELECT * FROM $c->mysql_tb_le WHERE id='$user' && pass=password('$le[pass]')");
			$pass = $le[pass];
		}
		$row = mysql_fetch_array($get);
		$row[pass] = $pass;
		$row[user] = $row[id];
		$row[name] = $row[title];
		form($err, $row, "Update!", "edit.php");
	}
	$c->close();
}
?>