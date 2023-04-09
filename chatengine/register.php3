<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

$extra_info = "onload=\"position_window(); document.register_user.nick.focus()\"";
$page_title = "Register new nick";

require("includes.php3");

function register_form($mysql_link)
{
	global $scriptname;
	?>
	<script>
	<!--
	
	function check_form()
	{
		if (document.register_user.nick.value == "")
		{
			alert("Please supply a nick");
			document.register_user.nick.focus();
			return;
		}
		
		if (document.register_user.e_mail.value == "")
		{
			alert("Please supply a valid e-mailaddress");
			document.register_user.e_mail.focus();
			return;
		}
		
		if (document.register_user.real_name.value == "")
		{
			alert("Please supply your real name");
			document.register_user.real_name.focus();
			return;
		}
		document.register_user.submit();
	}
	
	//-->
	</script>
	
	<font color="#FFFCC">
	Please enter your desired nick and the e-mailaddress where we need to send you
	your password to. If you supply a fake e-mailaddress, you will not receive your
	password and you won't be able to log in.<br>	
	</font>
	<form name="register_user" method="get" action="<? print($scriptname); ?>">
	<table border="0">
		<tr>
			<td width="150">
			<b>Nick:</b>
			</td>
			<td>
			<input type="text" name="nick" value="" class="typetext" size="17" maxlength="17">
			</td>
		</tr>
		<tr>
			<td>
			<b>E-mail address:</b>
			</td>
			<td>
			<input type="text=" name="e_mail" value="" class="typetext" size="17">
			</td>
		</tr>
		<tr>
			<td>
			<b>Real name:</b>
			</td>
			<td>
			<input type="text=" name="real_name" value="" size="17">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
			<input type="hidden" name="action" value="check_register">
			<input type="button" class="button" onClick="check_form()" value="register">
			</td>
		</tr>
		
	</table>
	</form>
	<?
}

function check_register($mysql_link, $nick, $e_mail, $real_name)
{
	// check if the nick isn't taken
	$query = "SELECT login FROM chat_users WHERE login = '$nick'";
	$result = mysql_query($query, $mysql_link);
	if (mysql_num_rows($result) != 0)
	{
		js_alert("Sorry, that nick has already been taken.");
		register_form($mysql_link);
		return;
	}
	// check if e-mailaddress already exists
	$query = "SELECT e_mail FROM chat_users WHERE e_mail = '$e_mail'";
	$result = mysql_query($query, $mysql_link);
	if (mysql_num_rows($result) != 0)
	{
		js_alert("That e-mailaddress has already been used to register a nick");
		register_form($mysql_link);
		return;
	}
	// add new user nick to database
	
	$items =  "abcdefghijklmnopqrstuvwxyz";
	$items .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$password = "";
	
	srand(time());
	
	for ($f = 1; $f < 16; $f++)
	{
		$password .= substr($items, (rand()%(strlen($items))), 1);
	}

	$nick = strip_tags($nick);
	$real_name = strip_tags($real_name);
	
	$query = "INSERT INTO chat_users (login, password, e_mail, status, realname) ";
	$query .= "VALUES ('$nick', '$password', '$e_mail', 0, '$real_name');";

	mysql_query($query, $mysql_link);

	// E-mail the new user
	
	$mailTo = $e_mail;
	$mailSubject = "Your registration for the - your chat's name here -";
	$mailBody = "Thanks for registering to the - whatever :-) -.\n\n";
	$mailBody .= "This mail has been sent to you to provide you with your log-in information. ";
	$mailBody .= "You will need the username and password listed below to access the chat. ";
	$mailBody .= "You can change your password inside the chat, but you will need at least the ";
	$mailBody .= "first time you log-in, so please keep this message stored until you change ";
	$mailBody .= "your password into something easier to remember.\n\n";
	$mailBody .= "Username: $nick \n";
	$mailBody .= "Password: $password \n\n";
	$mailBody .= "See you in the chat !\n";
	$mailBody .= "<Sender name>.";
	$mailHeaders = "From: youremail@here.com\nReply-To: youremail@here.com";
	
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders);

	js_alert("You have been registerd. An e-mail containing your password has been sent to you.");
	?>
	<script>
	<!--
	window.close();
	//-->
	</script>
	<?
	
}

// MAIN

?>
<table bgcolor="#555555" border="0" width="100%" height="100%" cellpadding="2" cellspacing="0">
<tr>
	<td valign="top">
	<table border="0" bgcolor="#000000" width="100%" height="100%" cellpadding="5">
	<tr>
		<td valign="top">
		<p><font size="1"><b>Register new nick:</b></font></p>
		<?
		
		switch($action)
		{
			case "": register_form($mysql_link); break;
			case "check_register": check_register($mysql_link, $nick, $e_mail, $real_name); break;
		}
		
		?>
	</td>
	</tr>
	</table>
	</td>
</tr>
</table>

<script>
<!--

function position_window()
{
var sAvailH = screen.availHeight;
var sAvailW = screen.availWidth;

window.moveTo( (sAvailW/2)-225, (sAvailH/2)-200);

}
//-->
</script>

<?

end_page($mysql_link);

?>


