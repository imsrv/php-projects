<?
require("config.php");
session_start();
$thisuser = $HTTP_SESSION_VARS["thisuser"];

if (!$thisuser) {
	header("Location: login.php");
	exit;
	}
	
print stripslashes($header);
?>

<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Send secretMessagex</font></b>
<p>

<form action="sendmsg.php" method=post>

	<table border=0>
	<tr>
		<td><font face=Arial size=2>Crush's Name: </font></td>
		<td><font face=Arial size=2><input type=text name=crush_name size=30 maxlength=50 style="font-family: Arial"></font></td>
	</tr>
	<tr>
		<td><font face=Arial size=2>Crush's Email: </font></td>
		<td><font face=Arial size=2><input type=text name=crush_email size=30 maxlength=50 style="font-family: Arial"></font></td>
	</tr>
	
	<tr>
		<td colspan=2><font face=Arial size=2>Your <b><font color=#000000>secret</font><font color=#ff0000>Messagex</font></b> <small>(max. 300 characters, WILL be shown in the email sent to your crush)</small>:<br>
		<textarea name=message cols=40 rows=5 style="font-family: Courier New"></textarea>
		</font></td>
	</tr>
	<tr>
		<td colspan=2><font face=Arial size=2><input type=submit value="Send" style="font-family: Arial"></font></td>
	</tr>
	</table>
</form>




<?
print stripslashes($footer);
?>