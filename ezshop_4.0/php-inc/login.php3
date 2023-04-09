<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
function LoginForm (){
	Global $PHP_AUTH_USER,$PHP_AUTH_PW;
?>
<ul>
	<p>User Name:<br>
	<input type="text" name="PHP_AUTH_USER" size="29" value="<? print($PHP_AUTH_USER) ?>"></p>
	<p>Password<br>
	<input type="password" name="PHP_AUTH_PW" size="29" value="<? print($PHP_AUTH_PW) ?>"></p>
	<p><input type="submit" value="Log In" name="action"></p>
</ul>
<?
}
?>
<table border="0" cellpadding="3" cellspacing="0" width="95%"  bgcolor="<? print($bdy_bgcolor)?>">
<tr>
<td colspan="3">
<? include("create_account");?>
<? if($login == ""){ ?>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<? EchoFormVars(); ?>
<p>To log in, fill out the form and press the Log In button</p>
<? LoginForm() ?>
</form>

<? } else if($login == "False"){ ?>
<br><p><font color="red">Error: </font>An Error Occurred trying to log in to your account. The error message is displayed below.</p>
<ul>
	<p><? print($message) ?></p>
	<p>Please correct your error and try again...</p>
</ul>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<? EchoFormVars(); ?>
<? LoginForm() ?>
</form>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<? EchoFormVars(); ?>
<ul>
	<p>If you have lost your username and password, please enter your email address in the box below and press the Email Me My Password button.</p>
	<p>E-Mail Address:<input type="Text" name="email" size="32" maxlength="128" value="<? print($email)?>"></p>
	<p><input type="Submit" name="action" value="Email Me My Password"></p>
</ul>
</form>
<? } else if($login== "True"){ ?>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<? EchoFormVars(); ?>
<? 
	$query = "select name from soldto where user_id = '$PHP_AUTH_USER'";
	$select = mysql($database,$query);
	if($select != 0){
	$name = mysql_result($select,0,"name");
	}
?>
     <p>You are currently logged in with the following information:</p>
	<ul>
		<p>User Name: <? print($PHP_AUTH_USER) ?></p>
		<p>Password: ******</p>
	<center><p><input type="hidden" name="action" value="Invoice"><input type="submit" value="Click Here to Continue"></p></center>
	</ul>
<? } ?>
</td>
</tr>
</table>
</form>
