<ul>
<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// empass.php3
// This file is used to display the results of an email the password request
// If the email address is found in the database, Success is displayed.
// If the email address is not found, user is prompted to create an account.

if($empass == "True"){
	echo "Your Account Information has been sent to your email address.<br>\n";
	echo "Please press the Login button once you have recieved your info.<br>\n";
}else if ($empass == "False"){
	echo "Sorry, you do not have an account with that email address.<br>\n";
	echo "Please choose the Create Account option below.<br>\n";
	?>
	<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
	<p><input type="submit" name="action" value="Create Account"> If this is your first time here, press the Create Account button to continue.</p>
	</form>
	<?
}
?>
</ul>