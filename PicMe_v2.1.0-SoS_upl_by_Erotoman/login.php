<?php
/*
#
#	$Id: LOGIN.PHP
#	Version 2.1.0
#
*/

if ($uname != "") {
// CHECK FOR NEW MESSAGES
		$sql = "select * from messages where touserid ='$uname' AND isread = '0'"; 
		$sql_result = mysql_query($sql); 
		$totmsgs = 0;
		while ($row = mysql_fetch_array($sql_result)) { 
		 $isread = $row["isread"];
		 $totmsgs++;
		} 

// COUNT TOTAL MESSAGES
		$sql = "select * from messages where touserid ='$uname'"; 
		$sql_result = mysql_query($sql); 
		$msgs = 0;
		while ($row = mysql_fetch_array($sql_result)) { 
		 $msgs++;
		}

		$sql = "SELECT * FROM picuploads WHERE approved='1' and userid='$name'";
		$sql_result = mysql_query($sql);
		while ($row = mysql_fetch_array($sql_result)) { 
		$picid = $row["id"];
		$photo = $row["name"];
		$points = $row["points"];
		$votes = $row["votes"];
		}

		if ($points == "") {
		$rate = 0;
		} else {
		$rate = round($points / $votes,3);
		}
		
echo "Welcome $uname!";
echo "<br><a href=profile.php>Your Profile</a>";
echo "<hr>";
echo "<b>Your Rate:</b><font color=red> $rate</font>";
echo "<br><b>New Messages:</b> $totmsgs";
echo "<br><b>Total Messages:</b> $msgs";
echo "<br><b>Total Comments: ";


} else {

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		<form name="login" action="logincheck.php" method="get">
<table border="0" cellpadding="0" cellspacing="0" width="100">
	<tr>
		<td><B><CENTER>UserID:</B>
		<br><input type="text" name="uname" size="10" maxlength="20"></CENTER></td>
	</tr>
	<tr>
		<td><B><CENTER>Password:</B>
		<br><input type="password" name="password" size="10" maxlength="20"></CENTER></td>
	</tr>
	<tr>
		<td><center><input type="submit" name="submit" value="Login"></center>
		</td>
	</tr>
</table>
		</form>
		</td>
	</tr>
</table>
<?PHP
}
?>