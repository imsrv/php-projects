<?
require("config.php");
print stripslashes($header);
?>

	<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Login</font></b>
	<p>
	<form action="myaccount.php" method=post>
	Username: <input type=text name=username size=12 maxlength=12 style="font-family: Arial"><br>
	Password: <input type=password name=password size=12 maxlength=12 style="font-family: Arial"><br>
	<input type=submit value=Login style="font-family: Arial">
	<input type=hidden name="action" value=login>
	</form>
	</p>
	<p>
	You need an account to send <b><font color=#000000>secret</font><font color=#ff0000>Messagex</font></b>.<br>
	Do not have one?<br>
	<a href="register.php">Register now!</a> Absolutely free!<br>
	<!--Forgot your password? <a href="retrieve.php">Retrieve password</a>-->
	</p>

<? 
print stripslashes($footer);
?>