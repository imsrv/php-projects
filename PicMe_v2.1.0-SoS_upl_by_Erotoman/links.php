<?PHP
/*
#
#	$Id: LINKS.PHP
#	Version 2.1.0
#
*/


// GET USERS ID FROM LOGIN NAME
	$sql = "select * from links";
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) {
	$linkid = $row["id"];
	$linkname = $row["site"];
	$linkurl = $row["url"];
	echo " <IMG SRC=images/dent.gif BORDER=0> <a href=$linkurl target=_balnk>$linkname</a><br> ";
	}

?>