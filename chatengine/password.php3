<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// password.php3
// change user's password

$extra_info = "onLoad=\"position_window();\"";
$page_title = "Change your password";


require("includes.php3");

function show_form($mysql_link)
{
	global $scriptname, $session;
	?>
	<script>
	<!--
	
	function check_form()
	{
		if (document.password_form.c_password.value == "")
		{
			alert("Please supply your old password");
			document.password_form.c_password.focus();
			return;
		}
		
		if (document.password_form.n_password.value == "")
		{
			alert("Please supply your new password");
			document.password_form.n_password.focus();
			return;
		}
		
		document.password_form.submit();
	}
	
	//-->
	</script>

	<form name="password_form" action="<? print($scriptname); ?>">
	<table border="0">
		<tr>
			<td width="150">
			<b>Current password:</b>
			</td>
			<td>
			<input type="password" name="c_password" value="" class="typetext" size="17" maxlength="50">
			</td>
		</tr>
		<tr>
			<td>
			<b>New password:</b>
			</td>
			<td>
			<input type="password" name="n_password" value="" class="typetext" size="17" maxlength="50">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
			<input type="hidden" name="action" value="change_password">
			<input type="hidden" name="session" value="<? print($session); ?>">
			<input type="button" class="button" onClick="check_form()" value="register">
			</td>
		</tr>
	</table>
	
	
	<?
}

function change_password($mysql_link, $c_password, $n_password, $session)
{
	// check if old password matches database entry
	$username = user($mysql_link, $session);
	$username = addslashes($username);
	$query = "SELECT password FROM chat_users WHERE login = '$username'";
	$record = mysql_fetch_array(mysql_query($query, $mysql_link));
	
	if ($record["password"] != $c_password)
	{
		js_alert("The password you entered as your old password is not valid !");
		show_form($mysql_link);
		return;
	}
	// valid, change password
	$query = "UPDATE chat_users SET password = '$n_password' WHERE login = '$username';";
	mysql_query($query, $mysql_link);
	{
		js_alert("Your password has been changed.");
		?>
		<script>
		<!--
		window.close();
		//-->
		</script>
		<?
		return;
	}
}

?>
<table bgcolor="#555555" border="0" width="100%" height="100%" cellpadding="2" cellspacing="0">
<tr>
	<td valign="top">
	<table border="0" bgcolor="#000000" width="100%" height="100%" cellpadding="5">
	<tr>
		<td valign="top">
		<p><font size="1"><b>Change your password:</b></font></p>
		<?
		
		switch($action)
		{
			case "": show_form($mysql_link); break;
			case "change_password": change_password($mysql_link, $c_password, $n_password, $session); break;
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

window.moveTo( (sAvailW/2)-225, (sAvailH/2)-100);

}
//-->
</script>
<?

end_page($mysql_link);

?>
