<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

if ($item == "") $item = 0;

$extra_info = "style=\"scrollbar-base-color:black;scrollbar-arrow-color:black\"";
require("includes.php3");

function show_main()
{
	?>
	<b>Main topics:</b><br><br>
	<a href="help.php3?item=1">General chatting</a><br>
	<a href="help.php3?item=2">Special commands</a><br>
	<a href="help.php3?item=3">Logging out</a><br>
	<a href="help.php3?item=5">Using icons</a><br>
	<br>
	<a href="help.php3?item=4">Credits</a><br>
	<br>
	<br>
	<?
}

function back_to_main()
{
	?>
	<br><br>
	<a href="help.php3?item=0">back to main</a>
	<?
}

function show_general()
{
	?>
	<b>General chatting:</b><br><br>
	<font color="#FFFFCC">
	Chatting is easy. Just type your sentence into the text box and press enter or click speak.
	If you want to send a message to somebody special, select that person's name in the "to" list.
	</font>
	<?
	back_to_main();
}

function show_commands()
{
	?>
	<b>Special commands:</b><br><br>
	<font color="#FFFFCC">
	Right now you can use:<br><br>
	-<b><span style="color:red">!brb</span></b> to show an "away" message<br>
	-<b><span style="color:red">!back</span></b> to show a "back" message<br>
	-<b><span style="color:red">!me</span></b> to speak as "third person"<br>
	-<b><span style="color:red">!greet</span></b> to greet the chat<br>
	</font>
	<?
	back_to_main();
}

function show_loggingout()
{
	?>
	<b>Logging out:</b><br><br>
	<font color="#FFFFCC">
	Logging out doesn't require you to do anything special. Just close the chatwindow and you're done.
	</font>
	<?
	back_to_main();
}

function using_icons()
{
	?>
	<b>Using icons:</b><br><br>
	<font color="#FFFFCC">
	You can use icons (see <a href="help.php3?item=2">Special commands</a>) to show small icons.
	But there are limits to the use of these icons: you can use a maximum of two icons (that are not
	the same) per line you write. If you use more than one icon of the same kind, you will get an 
	error message. This was merely implemented to keep users from flooding.
	</font>
	<?
	back_to_main();
}


function credits()
{
	?>
	<b>Credits:</b><br><br>
	<font color="#FFFFCC">
	Programming:<br><b>Michiel Papenhove</b><br>
	<a href="mailto:mipa@we-h8-u.com">e-mail</a><br><br>
	</font>
	<?
	back_to_main();
}

function show_help($mysql_link, $item)
{
	switch ($item)
	{
		case "0": show_main(); break;
		case "1": show_general(); break;
		case "2": show_commands(); break;
		case "3": show_loggingout(); break;
		case "4": credits(); break;
		case "5": using_icons(); break;
	}
}

?>
<table bgcolor="#555555" border="0" width="100%" height="100%" cellpadding="2" cellspacing="0">
<tr>
	<td valign="top">
	<table border="0" bgcolor="#000000" width="100%" height="100%" cellpadding="5">
	<tr>
		<td valign="top">
		<p><font size="1">Help:</font></p>
		<? show_help($mysql_link, $item); ?>
	</td>
	</tr>
	</table>
	</td>
</tr>
</table>

<?

// end

?>
