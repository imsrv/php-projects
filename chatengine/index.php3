<?/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

require("mysql.php3");$mysql_link = mysql_connect(_hostname, _username, _userpassword);mysql_select_db(_database, $mysql_link);
// check for banned IP
$ipbanned = false;$query = "SELECT * FROM ipbans WHERE ip LIKE '%$REMOTE_ADDR%'";$result = mysql_query($query, $mysql_link);if (mysql_num_rows($result) != 0){	$ipbanned = TRUE;}
mysql_close($mysql_link);
// do browser check, IE only$browser= $HTTP_USER_AGENT;if (!eregi("MSIE", $browser)){	?>	<html>	<script>	<!--	alert("Sorry, your browser is not able to view this chatbox, since I use kind of advanced techniques (D-HTML and loads of frames, which SHOULD work on other browsers, but as you guessed, they don't work...).\n\n You will need Internet Explorer (yeahyeah, it's MS, I know...) to be able to chat.\n\n\nLife's a bitch....");	//-->	</script>	You're amongst the 9% of internet users that doesn't use Internet Explorer... Sorry, but this chat won't work...	</html>	<?	exit;}?><html><title>Your chat title here</title><frameset rows="20,*, 15" frameborder="no" border="0">	<frame src="title.php3" name="title" frameborder="no" border="0" scrolling="no" noresize>	<frameset cols="10, 2, * ,150" border="0">		<frame src="empty.htm" name="links" frameborder="no" border="0" scrolling="no" noresize>		<frame src="ruler.php3" name="links" frameborder="no" border="0" scrolling="no" noresize>		<frameset rows="15, *, 15, 100, 15, 50, 15, 0" border="0">			<frame src="ruler.php3?txt=Public+messages:&type=0" name="publicheader" frameborder="no" border="0" scrolling="no" noresize>			<frame src="security.php3" name="content" frameborder="no" border="0" noresize>			<frame src="ruler.php3?txt=Private+messages:&type=1" name="privateheader" frameborder="no" border="0" scrolling="no" noresize>			<frame src="private.php3" name="private" frameborder="no" border="0" noresize>			<frame src="ruler.php3?txt=Controls:" name="header" frameborder="no" border="0" scrolling="no" noresize>			<frame src="speak.php3" name="type" frameborder="no" border="0" noresize>			<frame src="ruler.php3" name="header" frameborder="no" border="0" scrolling="no" noresize>			<frame src="control.php3" name="control" frameborder="no" border="0" noresize>		</frameset>		<frameset rows="50%, 50%" frameborder="no" border="0">			<frame src="users.php3" name="users" frameborder="no" border="0">			<frame src="help.php3" name="help" frameborder="no" border="0">		</frameset>	</frameset>	<frame src="empty.htm" name="empty" frameborder="no" border="0" scrolling="no"></frameset></html>

<?

?>