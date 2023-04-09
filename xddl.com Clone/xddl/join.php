<?
require "config.class.php";
$c = new config();

function form($err="", $val="", $txt="Join Link-Exchange!", $action="join.php") {
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
	<form name=\"le\" action=\"".$action."\" method=\"POST\">\n<tr><td><b>Username: </b></td><td>";
	if ($txt != "Join Link-Exchange!")
		echo "$val[user]";
	else
		echo "<input type=\"text\" name=\"le[user]\" size=\"30\" class=\"form\" value=\"$val[user]\" maxlength=\"20\"> $err[user]";
	echo "</td></tr>
	<tr><td><b>Password: </b></td><td><input type=\"password\" name=\"le[pass]\" size=\"30\" class=\"form\" maxlength=\"15\" value=\"$val[pass]\"> $err[pass]</td></tr>
	<tr><td><b>Email: </b></td><td><input type=\"text\" name=\"le[email]\" size=\"30\" class=\"form\" value=\"$val[email]\" maxlength=\"100\"> $err[email]</td></tr>
	<tr><td><b>Site Name: </b></td><td><input type=\"text\" name=\"le[name]\" size=\"30\" class=\"form\" value=\"$val[name]\" maxlength=\"15\"> $err[name]</td></tr>
	<tr><td><b>Site Url: </b></td><td><input type=\"text\" name=\"le[url]\" size=\"30\" class=\"form\" value=\"$val[url]\" maxlength=\"100\"> $err[url]</td></tr>
	<tr><td></td><td><input type=\"Submit\" value=\"".$txt."\" class=\"form\"></td></tr>";
	echo "</form></table>";
}

if (!$hopp) {

echo "<html>\n<head>\n<title>$c->site_name - Link Exchange</title>
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
</style>\n</head>\n<body class=form>\n";

$err = false;

function email($email) {
	$exp = explode("@", $email);
	if ($exp[0] && $exp[1] && !$exp[2]) {
		$expo = explode(".", $exp[1]);
		if ($expo[1])
			return true;
		else
			return false;
	} else
		return false;
}

if (!$le)
	form();

elseif (!$le[user] || !$le[pass] || !email($le[email]) || !$le[name] || !$le[url]) {
	if (!$le[user])
		$err[user] = "you must provide a username!";
	if (!$le[pass])
		$err[pass] = "you must enter a password!";
	if (!email($le[email]))
		$err[email] = "your e-mail address!";
	if (!$le[name])
		$err[name] = "your sites name";
	if (!$le[url])
		$err[url] = "your sites url";
	form ($err, $le);

} else {
	$c->open();
	if (@mysql_query("INSERT INTO $c->mysql_tb_le (id, pass, title, url, email) VALUES ('$le[user]',password('$le[pass]'),'$le[name]','$le[url]','$le[email]')")) {
		mail("$le[email]", "$c->site_name Link Exchange", "Username: $le[user]\nPassword: $le[pass]\nSitename: $le[name]
Url: $le[url]\n\nLink to: ", "FROM: $c->site_mail");
		echo "<big><b>Your site has been added!</big><br><br>\nLink to:</b> ".$c->site_url."in.php?id=$le[user]";
	} else {
		$err[user] = "selected username is allready in use!";
		form($err, $le);
	}
	$c->close();
}

echo "\n</body>\n</html>";

}
?>