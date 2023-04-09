<?
	include("./dir/config.php");
	mysql_connect($dbhost,$dbuser,$dbpasswd);
	mysql_select_db($db);
	$login=$HTTP_GET_VARS["a"];
	$query = "SELECT access_level FROM users WHERE login='$login'";
	$result = mysql_query($query);
	if (!($result)) {
		echo "Can't execute query";
	}
	list($accesslevel) = mysql_fetch_row($result);
	if ($accesslevel == "2") {
		include("./include/t-top.php");
		include("./include/t-menu.php");
		include("./content/visitors.php");
		include("./include/t-down.php");
	} else {
		include("./include/top.php");
		include("./include/menu.php");
		if ($accesslevel == "1") {
			include("./login.htmlt");
		} else {
			echo "<br><br><b>You can't use your statistics</b>";
		}
		include("./include/down.php");
		include("./include/submenu.php");
	}

?>

