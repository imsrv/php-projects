<?PHP
/*
#
#	$Id: PRIVATE.PHP
#	Version 2.1.0
#
*/

include "header.php";

// MAKE SURE THE USER IS LOGGED IN
if ($uname != "") {

if($Submit == "Submit") {
	
// SUBMIT THE INFO TO THE DATABASE

	$sql = "insert into messages values('','$ptouser','$uname','$psubject','$pmessage','0','$pdate')";  	
	$sql_result = mysql_query($sql); 

?>	
<br><br>The below message has been sent to <? echo $ptouser ?>
<br><br><table Width=400 Border=1><tr><td bgcolor=FFFFC0><b>Date:</b> <? echo $pdate ?>
<br><b>To:</b> <? echo $ptouser ?>
<br><b>From:</b> <? echo $uname ?>
<br><b>Subject:</b> <? echo $psubject ?>
<hr>
<b>Message:</b> <? echo $pmessage ?>
</td></tr></table>
<?PHP
include "footer.php";
exit;
}
// SHOW THE FORM
?>

<br><br><form name="private" Action="<? $PHP_SELF; ?>" method="submit">
<h3>Send a private message to <? echo $touser ?></h3>
<b>Date: </b><? echo $today ?>
<input type=hidden value=<? echo $today ?> name=pdate>
<br><b>To: </b><? echo $touser ?>
<input type=hidden value=<? echo $touser ?> name=ptouser>
<br><b>From: </b><? echo $uname ?>
<br><br><b>Subject: </b><br>&nbsp;&nbsp;&nbsp;&nbsp;
<input type=text name=psubject size=50>
<br><br><b>Message:</b> <br>&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name=pmessage cols=38 rows=5></textarea>
<br><br><input type=submit name=Submit value=Submit>
</form>

<?PHP
} else {
// KICK THEM OUT IF THEY ARE NOT LOGGED IN
echo "<br><br>";
echo "<center><font color=red><b>You are not logged in...</b></font>";
echo "<br>Please log in with your UserID and Password to access this page.";
echo "<br>If you have fogoten your information, please submit to the FORGOT link on the left.";
echo "<br><br>If you are not a member of this site, please feel free to creat a profile,";
echo "<br>by visiting the Sign Up link on the left.";
echo "<br><br><b>Go ahead!  It is FREE and fun!</b>";
}

include "footer.php";
?>