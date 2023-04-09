<?PHP
/*
#
#	$Id: FAQ.PHP
#	Version 2.1.0
#
*/

 include "header.php";
	$sql = "select * from faq order by id"; 
	$sql_result = mysql_query($sql); 
echo "<br><br>$FaqinfoText";
	echo "<br><br><table border=0 cellpadding=0 cellspacing=1 width=400>";
	while ($row = mysql_fetch_array($sql_result)) { 
	 $faq_q = $row["faq_q"];	 
	 $faq_a = $row["faq_a"];
		echo "<tr>";
		echo "<td><font face=Verdana size=2><b>$faq_q</b><br>";
		echo "$faq_a<br><br>";
		echo "</font>";
		echo "</td></tr>";
	} 
		echo "</table>";

	
 include "footer.php";
?>
