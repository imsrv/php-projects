<? 
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
function UserForm () {
	global $new_user_id,$new_upass,$new_email;
?>

<ul>
	<p>User ID: <br><input type="text" name="new_user_id" size="9" maxlength="8" value="<? print($new_user_id) ?>"><br>
	<small>Please choose a user name, no longer than 8 alpha-numeric characters.</small></p>
	<p>Password: <br><input type="text" name="new_upass" size="8" maxlength="8" value="<? print($new_upass) ?>"><br>
	<small>Please choose a password up to 8 characters long.</small></p>
	<p>Email: <br><input type="text" name="new_email" size="32" maxlength="64" value="<? print($new_email) ?>"><br>
	<small>This email address will be used to send you your account settings if you lose them later on.</small></p>
	<center><p><input type="submit" value="Create Account" name="action"></p></center>
</ul>
<?
}
?>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<? EchoFormVars() ?>
<input type="hidden" name="create_account" value="Yes">
<table border="0" cellpadding="3" cellspacing="0" width="90%">
<tr>
<td colspan="3">
<? if($create_account == ""){ ?>
<br><p>Before we can proceed, we need to create an account for you in our database. 
Please fill out the following form and press the Create Account button. 
Once your account has been created, we will E-Mail you your Account ID and 
Password to the E-Mail address you specify here.</p>
<? UserForm() ?>
</form>
<? }else if($create_account == "False"){ ?>
<ul>
	<p><font color="red"><big>Error: </big></font>An Error Occurred trying to set up your account. The error message is displayed below.</p>
	<p><? print($message) ?></p>
	<p>Please correct your error and try again...</p>
</ul>
<? UserForm() ?>
</form>
<? } else if($create_account == "True"){ ?>
     <h2 align="center">Account Created</h2>
	<ul>
	<p>An account for you has been set up.</p>
	<p>The details for your account are as follows:<br>
	<ul>
	 <li>User Name: <? echo $new_user_id ?>
	 <li>Password: <? echo $new_upass ?>
	 <li>E-Mail: <? echo $new_email ?>
	</ul>
	<p>Please save this information for next time you place your order!</p>
	<p>In order to use this account, you must now log in. In the future, you may proceed directly to the Log In screen.</p>
	<center><p><input type="hidden" name="action" value="Log In"><input type="submit" value="Click Here to Log In"></p></center>
	</ul>
<?
$message = "Here is the account details for the account you have set up with $merchant_name\n\n";
$message .= "--------------<Account Details>------------\n";
$message .= "\tUser Name: $new_user_id\n";
$message .= "\tPassword: $new_upass\n\n";
$message .= "Please save this information for the next time you\n";
$message .= "place an order with $merchant_name.\n";
$message .= "----------------<Thank You!>---------------\n";
$headers = "Reply To: $merchant_email\nFrom: \"EZShop Account Manager\" <ezshop@eyekon.com>\n";
mail($new_email,"Your EZShop Account Details",$message,$headers);
?>
<? } ?>
</td>
</tr>
</table>
</form>
