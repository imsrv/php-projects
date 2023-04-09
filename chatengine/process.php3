<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// process.php3
// included in control.php3

function bre()
{
	return("<br>");
}

function process_normal($mysql_link, $session, $saidby, $saidto, $text, $status)
{
	
	// pre-process
	
	if ($status == 1)
	{
		$text = eregi_replace("!me", "", $text);
		$total = "<b class=\"pr\" style=\"position: relative; left:0px\">".$saidby.$text."</b>";
		return $total."<br>";
	}
	
	if ($status == 2)
	{
		$text = eregi_replace("!me", "", $text);
		$total = "<b style=\"color:lightblue; position: relative; left:0px\">".$saidby." will be right back</b>";
		return $total."<br>";
	}
	
	if ($status == 3)
	{
		$text = eregi_replace("!back", "", $text);
		$total = "<b style=\"color:lightblue; position: relative; left:0px\"\">".$saidby." is back</b>";
		return $total."<br>";
	}
	
	if ($status == 4)
	{
		$text = eregi_replace("!greet", "", $text);
		$total = "<b style=\"color:blue; position: relative; left:0px\"\">".$saidby." greets the chat</b>";
		return $total."<br>";
	}

	if ($saidby == "system")
	{
		$total = "<b class=\"system\" style=\"position: relative; left:0px\">".$text."</b>";
		return $total."<br>";
	}
	
	// 
	
	$userlevel = user_level($mysql_link, $session);
	
	// make line
	$name = "<b class=\"user\">$saidby: </b><b class=\"text\">";
	$total = $name.$text."</b><br>";
	
	return $total;
}

function process_private($mysql_link, $session, $saidby, $saidto, $text)
{
	$userlevel = user_level($mysql_link, $session);
	
	$text = strip_tags($text);
	
	$query = "SELECT color FROM chat_users WHERE login='$saidby'";
	$bcolors = mysql_fetch_array(mysql_query($query, $mysql_link));
	$query = "SELECT color FROM chat_users WHERE login='$saidto'";
	$tcolors = mysql_fetch_array(mysql_query($query, $mysql_link));

	// make line
	$name = "<b style=\"position : relative; left:0px\">Private by <b style=\"color:".$bcolors["color"]."\">$saidby</b> to <b style=\"color:".$tcolors["color"]."\">".stripslashes($saidto).": </b>";
	$total = $name."<b class=\"pr\">".$text."</b></b><br>";
	
	return $total;
}

function process_mod($mysql_link, $session, $saidby, $saidto, $text)
{
	$userlevel = user_level($mysql_link, $session);
	
	$text = strip_tags($text);
	
	$query = "SELECT color FROM chat_users WHERE login='$saidby'";
	$bcolors = mysql_fetch_array(mysql_query($query, $mysql_link));

	// make line
	$total = "<b style=\"position: relative; left:0px\"><b style=\"color:green\">Modmessage by</b> <b style=\"color:".$bcolors["color"]."\">$saidby</b>: ".$text."</b></b><br>";
	
	return $total;
}



?>
