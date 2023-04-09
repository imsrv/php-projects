<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

if ($session != "") $extra_info = " marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 onUnload=\"do_log_out();\"";
if ($session == "") $extra_info = " marginwidth=0 marginheight=0 topmargin=0 leftmargin=0";

require("includes.php3");

?>
<table border="0" cellspacing="0" cellpadding="0" height="100%">
<tr>
	<td width="11">	&nbsp;</td>
	<td align="left" valign="middle" width="350">
		<b style="letter-spacing:.75px; font-weight:800"><? print(_chatboxname); ?> <b style="font-weight:normal; font-size: 10px; color: gray; letter-spacing:0.25px">version <? print(_version); ?></b>
	</td>
	<td align="left" valign="top" width="90">
		<a href="mailto:bugreport@within-temptation.com?subject=BugReport%20WTchat">report a bug</a></b>
	</td>

<? // special options, only when not logged in
	if ($session == ""):
	?>

	<td align="left" valign="top">
		<a class="b1" href="#" onClick="window.open('register.php3', 'registerwindow', config='height=450,width=400,toolbar=no,resizable=no,menubar=no,scrollbars=no,location=no,directories=no,status=no');">register new nick</a>
	</td>

<? endif; // end special options, not logged in
	
// special options, only when logged in
if ($session != ""):
?>
	
	<td align="left" valign="top">
		<a href="#" onClick="window.open('password.php3?session=<? print($session); ?>', 'passwordwindow', config='height=200,width=400,toolbar=no,resizable=no,menubar=no,scrollbars=no,location=no,directories=no,status=no');">change your password</a>
	</td>
<?
$userlevel = user_level($mysql_link, $session);
if (validate($userlevel, sysops))
{
	?>
	<td align="left" valign="top">
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="window.open('special_options.php3?session=<? print($session); ?>', 'passwordwindow', config='height=400,width=600,toolbar=no,resizable=yes,menubar=no,scrollbars=yes,location=no,directories=no,status=no');">special sysop options</a>
	</td>
	
	<?
}

endif; // end special options, logged in

//	<td align="middle" valign="top">
//		&nbsp;&nbsp;&nbsp;<a href="javascript:re_login()">fast re-login</a>
//	</td>



?>
</tr>
</table>
<?

if ($session != ""):

$add_message = urlencode($add_message);

?>
<script>
<!--

function do_log_out()
{
	sessionid = '<? print($session); ?>';
	testwindow = window.open("logout.php3?session="+sessionid+"&add_message=<? print($add_message); ?>", '', config='height=50,width=400,toolbar=no,resizable=yes,menubar=no,scrollbars=yes,location=no,directories=no,status=no');
}

function re_login()
{
	parent.content.document.location.href = 'security.php3?action=relogin&session=<? print($session); ?>';
}



function clean_frame(framenr)
{
	if (framenr == 0)
	{
		parent.content.document.location.href = 'blank.php3';
	}
	if (framenr == 1)
	{
		parent.private.document.location.href = 'blank.php3';
	}
	
	parent.control.document.location = 'control.php3?started=&session=<? print($session); ?>&lijst=no';
}

//-->
</script>

<?
endif;

end_page($mysql_link);

?>
