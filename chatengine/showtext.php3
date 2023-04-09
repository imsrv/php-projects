<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

setcookie("chatSessionCookie", $session, time()+3600); // not really necessary, but
													   // maybe you can think of a use ?

require("includes.php3");

check_secure($mysql_link, $session);

// trigger other frames
?>
<form name="triggerspeak" action="speak.php3" method="post" target="type">
<input type="hidden" name="session" value="<? print($session); ?>">
</form>

<form name="triggercontrol" action="control.php3" method="post" target="control">
<input type="hidden" name="session" value="<? print($session); ?>">
</form>

<form name="titlecontrol" action="title.php3" method="post" target="title">
<input type="hidden" name="session" value="<? print($session); ?>">
</form>

<form name="usercontrol" action="users.php3" method="post" target="users">
<input type="hidden" name="session" value="<? print($session); ?>">
</form>

<form name="headercontrol1" action="ruler.php3" method="post" target="privateheader">
<input type="hidden" name="txt" value="Private messages:">
<input type="hidden" name="type" value="1">
<input type="hidden" name="session" value="<? print($session); ?>">
</form>

<form name="headercontrol2" action="ruler.php3" method="post" target="publicheader">
<input type="hidden" name="txt" value="Public messages:">
<input type="hidden" name="type" value="0">
<input type="hidden" name="session" value="<? print($session); ?>">
</form>



<script>
<!--
document.usercontrol.submit();
document.triggerspeak.submit();
document.triggercontrol.submit();
document.titlecontrol.submit();
document.headercontrol1.submit();
document.headercontrol2.submit();

//-->
</script>

<?

// the end

?>
