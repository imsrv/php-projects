<?PHP
/*
#
#	$Id: MENU.PHP
#	Version 2.1.0
#
*/

// GET USERS ID FROM LOGIN NAME
	$sql = "select * from menu";
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) {
	$menuname = $row["site"];
	$menuurl = $row["url"];
	echo " <IMG SRC=images/dent.gif BORDER=0> <a href=$menuurl>$menuname</a><br>";
	}

?>