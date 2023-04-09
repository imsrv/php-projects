<style type="text/css">
<!--
body {
	background-color: #F0ECF0;
}
-->
</style><?
require "config.class.php";
$c = new config();

function form($err="", $val="", $txt="Join Link-Exchange!", $action="join.php") {
	global $user, $pass;
	echo "<br><link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\"><BODY bgColor=#ffffff text=#000000 leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\"><br><table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"form\" align=center>
	<form name=\"le\" action=\"".$action."\" method=\"POST\">\n<tr><td><b>Username: </b></td><td>";
	if ($txt != "Join Link-Exchange!")
		echo "$val[user]";
	else
		echo "<input type=\"text\" name=\"le[user]\" size=\"30\" class=box value=\"$val[user]\" maxlength=\"20\"> $err[user]";
	echo "</td></tr>
	<tr><td><b>Password: </b></td><td><input type=\"password\" name=\"le[pass]\" size=\"30\" class=box maxlength=\"15\" value=\"$val[pass]\"> $err[pass]</td></tr>
	<tr><td><b>Email: </b></td><td><input type=\"text\" name=\"le[email]\" size=\"30\" class=box value=\"$val[email]\"> $err[email]</td></tr>
	<tr><td><b>Site Name: </b></td><td><input type=\"text\" name=\"le[name]\" size=\"30\" class=box value=\"$val[name]\" maxlength=\"20\"> $err[name]</td></tr>
	<tr><td><b>Site Url: </b></td><td><input type=\"text\" name=\"le[url]\" size=\"30\" class=box value=\"$val[url]\"> $err[url]</td></tr>
	<tr><td></td><td><input type=\"Submit\" value=\"".$txt."\" class=box></td></tr>";
	if ($txt != "Join Link-Exchange!")
		echo "\n<input type=Hidden name=user value=\"$user\"><input type=Hidden name=pass value=\"$pass\">\n";
	echo "</form></table>";
}

if (!$hopp) {


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
		$err[email] = "enter your real e-mail address!";
	if (!$le[name])
		$err[name] = "what is your sites name?";
	if (!$le[url])
		$err[url] = "you must enter your sites url!";
	form ($err, $le);

} else {
	$c->open();
	if (@mysql_query("INSERT INTO $c->mysql_tb_le (id, pass, title, url, email) VALUES ('$le[user]',password('$le[pass]'),'$le[name]','$le[url]','$le[email]')")) {
		mail("$le[email]", "$c->site_name Link Exchange", "Username: $le[user]\nPassword: $le[pass]\nSitename: $le[name]
Url: $le[url]\n\nLink to: ", "FROM: $c->site_mail");
echo "<big><b>Your site has been added!</big><br><br>\nLink to:</b> http://www.halilwarez.com/in.php?id=$le[user]";
	} else {
		$err[user] = "selected username is allready in use!";
		form($err, $le);
	}
	$c->close();
}

echo "\n</body>\n</html>";

}
?>