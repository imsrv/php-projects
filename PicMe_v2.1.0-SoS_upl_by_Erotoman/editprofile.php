<?PHP
/*
#
#	$Id: EDITPROFILE.PHP
#	Version 2.1.0
#
*/
include "header.php";
$today = date("Y-m-d");

if($submit) {
	$sql2 = "update users set password='$password', email='$email', sex='$sex', hobbies='$hobbies', music='$music', chat='$chat', updated='$today', year='$yearborn', country='$country', state='$state', quote='$quote' where userid='$uname'";
	$sql_result = mysql_query($sql2); 
	echo( mysql_error());
}
 
// MAKE SURE THE USER IS LOGGED IN
if ($uname != "") {
	$sql = "SELECT * FROM users WHERE userid='$uname'";
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $proid = $row["id"];
	 $proname = $row["userid"];
	 $proemail = $row["email"];
	 $prosex = $row["sex"];
	 $prohobbies = $row["hobbies"];
	 $promusic = $row["music"];
	 $prochat = $row["chat"];
	 $proupdated = $row["updated"];
	 $provis = $row["emailvisible"];
	 $yearborn = $row["year"];
	 $country = $row["country"];
	 $state = $row["state"];
	 $quote = $row["quote"];
	 $password = $row["password"];
}

//  SUBMIT FORMS 
?>
<br><br>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td bgcolor=$menucolor>
		<b>Submit Changes:</b>
		</td>
	</tr>
</table>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td Align="right"><center>
<form name="updateuser" action="<? $PHP_SELF; ?>" method="post">		
Email:
<br><INPUT TYPE="text" NAME="email" VALUE="<? echo $proemail ?>" WIDTH=20>
<br>Password:
<br><INPUT TYPE="text" NAME="password" VALUE="<? echo $password ?>" WIDTH=20>
<br>Sex:
<br><SELECT NAME="sex" SIZE=1>
<OPTION><? echo $prosex ?>
<OPTION>Female
<OPTION>Male
</SELECT>
<br>Hobbies:
<br><INPUT TYPE="text" NAME="hobbies" VALUE="<? echo $prohobbies ?>" WIDTH=20>
<br>Music:
<br><INPUT TYPE="text" NAME="music" VALUE="<? echo $promusic ?>" WIDTH=20>
<br>Chat:
<br><INPUT TYPE="text" NAME="chat" VALUE="<? echo $prochat ?>" WIDTH=20>
<br>Year Born:
<br><INPUT TYPE="text" NAME="yearborn" VALUE="<? echo $yearborn ?>" WIDTH=20>
<br>Country:
<br><? getFlagList($country) ?>
<br>State/Prov:
<br><INPUT TYPE="text" NAME="state" VALUE="<? echo $state ?>" WIDTH=20>
<br>Favorite Quote:
<br><INPUT TYPE="text" NAME="quote" VALUE="<? echo $quote ?>" WIDTH=20>
<INPUT TYPE="hidden" NAME="id" VALUE="<? echo $proid ?>">
<INPUT TYPE="hidden" NAME="name" VALUE="<? echo $proname ?>">
<INPUT TYPE="hidden" NAME="updated" VALUE="<? echo $today ?>">
<br><br><INPUT TYPE="submit" name="submit" Value="Submit">
</FORM>
<br><br>
	</tr>
</table>



<?PHP
} else {
echo "<br><br>";
echo $accessdenied;
}

include "footer.php";
?>