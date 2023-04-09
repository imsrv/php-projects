<?PHP
/*
#
#	$Id: COMMENT.PHP
#	Version 2.1.0
#
*/
include "header.php";
// MAKE SURE THE USER IS LOGGED IN
if ($uname != "") {

if($Submit == "Submit") {

// SUBMIT THE INFO TO THE DATABASE

	$sql = "insert into comments values('','$pid','$sendername','$text')";  	
	$sql_result = mysql_query($sql); 

?>
<br><br>The below message has been sent!
<br><br><table Width=400 Border=1><tr><td bgcolor=FFFFC0>
<br><b>Message:</b> <? echo $text ?>
</td></tr></table>
<?PHP
include "footer.php";
exit;

} else {

?>
<br><br>
<form name="feedback" action="<? $PHP_SELF; ?>" method="post">
<table border="0" cellpadding="0" cellspacing="1" width="370" align="left">
<td valign="top" align="left">Message:</td>
<td valign="top" align="left"><textarea name="text" cols="40" rows="4"></textarea></td>
<tr>
<input type=hidden value=<? echo $pid ?> name=pid>
<input type=hidden value=<? echo $uname ?> name=sendername>
<td valign="top" align="left" width="25%"><input type="submit" name="Submit" value="Submit"></td>
</form>
</tr>
</table>
<?PHP
}
} else {
echo "<center><br><br><h3>Sorry, you are not a member of this site, or you are not loged in.<br>Go ahead and sign up...<br>It is FREE, and it is FUN!<br><br><a href=join.php>Click Here</a>";
}
include "footer.php";
?>	