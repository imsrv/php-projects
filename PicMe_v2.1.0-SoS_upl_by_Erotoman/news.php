<?PHP
/*
#
#	$Id: NEWS.PHP
#	Version 2.1.0
#
*/

include "header.php";

echo "<table><td width=500>";
echo "<br><br>";
echo "<h3>Site News!</h3>";

	$sql = "SELECT * FROM news order by id desc";
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $ndate = $row["date"];
	 $ntopic = $row["topic"];
	 $nnews = $row["news"];
	 echo "<br><b>$ndate</b><br><b><dd>$ntopic</b><br><br>$nnews<br><hr>";
	}

echo "<br><br>";
echo "</td></table>";

include "footer.php";
?>