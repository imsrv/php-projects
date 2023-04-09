<?PHP
/*
#
#	$Id: LOGINCHECK.PHP
#	Version 2.1.0
#
*/

// start the session 
session_name("picme"); 
session_start();
header("Cache-control: private"); // IE 6 Fix. 
include "settings.php";
	$sql = "select * from users where userid='$uname'";  	
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
	 $op = $row["password"];
	}
	 if ($op == "$password") {

	 $HTTP_SESSION_VARS["picme"] = "$uname";
	echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL=index.php>";
	
} else {
include "header.php";
echo "<br><br><center><font color=red><b>Wrong!</b></font> Password not correct or username not found.";
include "footer.php";
}
?>