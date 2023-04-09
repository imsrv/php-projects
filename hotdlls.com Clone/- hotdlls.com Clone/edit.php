<?
$hopp = true;
require "join.php";
$c = new config();

function login() {
	echo "<form name=login action=\"edit.php\" method=\"POST\">
<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\"><tr><td><b>Username:</b> </td><td><input type=text name=user size=20 class=form></td></tr>
<tr><td><b>Password:</b> </td><td><input type=password name=pass size=20 class=form></td></tr><tr><td></td>
<td><input type=submit value=\"Log In\" class=form></td></tr></table>";
}

function toppen() {
	echo "<html>\n<head>\n<title>DailyX</title>
<style type=\"text/css\">
.form {
	border-collapse: collapse;
	border-style: solid; 
	border-width: 1; 
	border-color: #000000; 
	background-color: #F1F1F1; 
	font-family: Verdana; 
	font-size: 9px;
}
td {
	font-family: Verdana, Arial, Sans-Serif;
	font-size: 9px;
}
.td2 {
</style>
</head>\n<body class=form>\n";
}

if (!$user || !$pass) {
	toppen();
	login();
} else {
	$c->open();
	$err = array();
	$user = addslashes($user);
	$pass = addslashes($pass);
	$get = mysql_query("SELECT * FROM $c->mysql_tb_le WHERE id='$user' && pass=password('$pass')");
	if (!mysql_num_rows($get)) {
		toppen();
		echo "<font face=Verdana size=2 color=red><b>Wrong username/password!</b></font><br>";
		login();
	} else {
		setCookie("user", $user);
		setCookie("pass", $pass);
		if ($le && (!$le[email] || !$le[url] || !$le[name] || !$le[pass])) {
			if (!$le[pass])
				$err[pass] = "you must have a password!";
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
			$pass = $le[pass];
			@mysql_query("UPDATE $c->mysql_tb_le SET pass=password('$le[pass]'), title='$le[name]', url='$le[url]', email='$le[email]' WHERE id='$user'");
			setCookie("pass", $pass);
			echo "<font face=Verdana size=2><b>Updated!</b></font><br><br>";
			$get = mysql_query("SELECT * FROM $c->mysql_tb_le WHERE id='$user' && pass=password('$pass')");
		} else

			$err = 0;
		$row = mysql_fetch_array($get);
		$row[pass] = $pass;
		$row[user] = $row[id];
		$row[name] = $row[title];
		toppen();
		form($err, $row, "Update!", "edit.php");
	}
	$c->close();
}
?>