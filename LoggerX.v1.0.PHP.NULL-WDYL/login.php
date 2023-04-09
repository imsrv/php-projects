<?

	function error($message) {
		include("./include/top.php");
		include("./include/menu.php");
		echo "<br><table border=1 bordercolor=\"#000000\" align=center cellpadding=3>";
		echo "<tr>";
		echo "<td class=\"Header\"> ERROR </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"Table\"> $message </td>";
		echo "</tr>";
		echo "</table>";
		include("./include/down.php");
		include("./include/submenu.php");
	}

	include('./dir/config.php');
	$username = $HTTP_POST_VARS["a"];
	$password = $HTTP_POST_VARS["p"];
	mysql_pconnect($dbhost,$dbuser,$dbpasswd);
	mysql_select_db($db);
	$query = "SELECT visitors FROM users WHERE login=\"$username\" AND password=\"$password\"";
	$result = mysql_query($query);
	if (mysql_num_rows($result)) {
		list($visitors) = mysql_fetch_row($result);
		if ($visitors) {
			include('visitors.php');
		} else {
			error("There is no information about $username.");
			die();
		}
	} else {
		error('<center>Wrong login or password.<br> Please, try again.</center>');
	}

?>
