<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

function update_timer($mysql_link, $session)
{
	// update timer
	$query = "UPDATE chat_session_ids SET last_action = now() WHERE session_id = '$session';";
	mysql_query($query, $mysql_link);
}

// speak.php3
// This is the actual text-typing module
if ($session != "") $extra_info = "onload=\"document.typetext.typed_text.focus();\"";

require("includes.php3");

function show_form($mysql_link)
{
	global $scriptname, $session, $users, $keep;
	$userlevel = user_level($mysql_link, $session);

	if ($session != ""): 
	?>
	<script language="JavaScript">
	var speakState = 0;
	var teller = 0;
	
	function check_speakstate()
	{
		if (speakState == 0)
		{
			speakState = 1;
			return true;
		}
		else
		{
			alert("You are flooding........ \n\n\nSystem will be kicking you in "+(5-teller)+" more submit(s)")
			{
			teller++;
			if (teller > 5) { }
			document.typetext.typed_text.value = "";
			return false;
			}
		}
	}
	
	</script>
	
	
	<form onSubmit="check_speakstate()" name="typetext" action="<? print($scriptname); ?>" method="post" style="margin-top : 0px ; margin-right : 0px ; margin-left : 0px ; margin-bottom : 0px ;">
	<table height="90%" width="100%" border="0" bgcolor="#555555" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%" valign="top" align="left" bgcolor="#000000" cellpadding="0" cellspacing="5">
			<table width="100%" border="0">
			<tr>
			<td width="200">
			
			<?
				$login = user($mysql_link, $session);
				$query2 = "SELECT color FROM chat_users WHERE login = '".addslashes($login)."';";
				$result2 = mysql_fetch_array(mysql_query($query2, $mysql_link));
			
				$kleur = $result2["color"];
			
				if ($kleur == "") $kleur = "gray";
			?>
			
			<font color="<?print($kleur);?>" style="font-size: 8pt; font-weight : bold"><?print($login);?></font><br>
			<input class="text" type="text" maxlength="250" size="35" name="typed_text" value="">
			</td>
			<td>
				<font style="font-size: 8pt; font-weight : bold">to:</font><br>
				<select name="users" class="typetext">
					<?
					$add = "";
					if (($users == "0") and ($keep == "on")){ $add = " SELECTED"; }
					?>
					<option value="0"<? print($add); ?>>all users</option>
					<?
					$add = "";
					if (($users == "1") and ($keep == "on")) { $add = "SELECTED"; }
					if (validate($userlevel, _modmessages)):
					?>
					<option value="1"<? print($add); ?>>moderators</option>
					<?
					endif;
					$add = "";
					if (($users == "2") and ($keep == "on")) { $add = "SELECTED"; }
					if (validate($userlevel, sysops)):
					?>
					<option value="2"<? print($add); ?>>system</option>
					<?
					endif;
					
					// show other users
						$query = "SELECT login FROM chat_session_ids WHERE status_online <> 99 ORDER BY login;";
						$result = mysql_query($query, $mysql_link);
						while ($rec = mysql_fetch_array($result))
						{
							$add = "";
							if (($users == $rec["login"]) and ($keep == "on")) { $add = " SELECTED"; }
							print("<option value=\"".$rec["login"]."\"$add>".$rec["login"]."</option>");
						}
					?>
				</select>
				<?
				// check input
				$add_keep = "";
				if ($keep == "on") $add_keep = " CHECKED";
				?>
				<input type="checkbox" name="keep"<? print($add_keep); ?>>lock
			</td>
			<td>
				<font style="font-size: 8pt; font-weight : bold">action:</font><br>
				<input class="button" type="submit" value="speak">
				<input type="hidden" name="action" value="speak">
				<input type="hidden" name="session" value="<? print($session); ?>">
				
			</td>
			<td>
			<?
				if (validate($userlevel, _cankick)):
				?>
				<font style="font-size: 8pt; font-weight : bold">&nbsp;</font><br>
				<input class="button" type="button" value="kick" onClick="kick_user()">
				<?
				endif;
				?>
			</td>
			<?	
				if (validate($userlevel, _allowsilentlogin))
				{
					if (status_online($mysql_link, $session) != 99)
					{
						?>
						<td>
							<font style="font-size: 8pt; font-weight : bold">&nbsp;</font><br>
							<input class="button" type="button" value="hide yourself" onClick="change_status(0)">
						</td>
						<?
					}
					else
					{
						?>
						<td>
							<font style="font-size: 8pt; font-weight : bold">&nbsp;</font><br>
							<input class="button" type="button" value="show yourself" onClick="change_status(1)">
						</td>
						<?
					}
				}
				if (validate($userlevel, sysops))
				{
					?>
					<td>
						<font style="font-size: 8pt; font-weight : bold">&nbsp;</font><br>
						<input class="button" type="button" value="chat message" onClick="sendmessage()">
					</td>
					<?
				}
				
				
			?>							
				
		</tr>
		</table>
		</td>
	</tr>
	</table>
	</form>
	<script>
	<!--
	function kick_user()
	{
		tempvar = document.typetext.users.value;
		document.kickuser.username.value = tempvar;
		document.kickuser.submit();
	}
	
	function change_status(hi)
	{
		document.status_online.submit();
	}
	
	function sendmessage()
	{
		var waarde = document.typetext.typed_text.value;
		if (waarde == "")
		{
			alert("You cannot send an empty chat message");
			return;
		}
		
		document.chat_message.chat_mesg.value = waarde;
		document.chat_message.submit();
	}
	
	function updatecontrol()
	{	
		waarde = parent.control.update_this.page_loaded.value;
		if (waarde != 0)
		{
			parent.control.update_this.submit();	
		}
		else
		{
			turn_timer_on();
		}
	}
	
	function turn_timer_on()
	{
		self.setTimeout('updatecontrol()', 500);
	}
	
	

	//-->
	</script>

	<form name="kickuser" action="<? print($scriptname); ?>" method="post" style="margin-top : 0px ; margin-right : 0px ; margin-left : 0px ; margin-bottom : 0px ;">
	<input type="hidden" name="username" value="">
	<input type="hidden" name="action" value="kick">
	<input type="hidden" name="session" value="<? print($session); ?>">
	</form>
	
	<form name="status_online" action="<? print($scriptname); ?>" method="post" style="margin-top : 0px ; margin-right : 0px ; margin-left : 0px ; margin-bottom : 0px ;">
	<input type="hidden" name="status" value="<? print(status_online($mysql_link, $session)); ?>">
	<input type="hidden" name="action" value="status_online">
	<input type="hidden" name="session" value="<? print($session); ?>">
	</form>
	
	<form name="chat_message" action="<? print($scriptname); ?>" method="post" style="margin-top : 0px ; margin-right : 0px ; margin-left : 0px ; margin-bottom : 0px ;">
	<input type="hidden" name="chat_mesg" value="">
	<input type="hidden" name="action" value="chat_message">
	<input type="hidden" name="session" value="<? print($session); ?>">
	</form>
	
			</td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	</form>
	
	<?
	check_secure($mysql_link, $session); 
	endif;
}

require("process_speak.php3");

function image_scan($mysql_link, $text, $session)
{
	// retrieve all images
	$query = "SELECT * FROM chat_images;";
	$result = mysql_query($query, $mysql_link);
	// store in array
	while ($rec = mysql_fetch_array($result))
	{
		$paths[] = $rec["filename"];
		$commands[] = $rec["command"];
		$userlevels[] = $rec["userlevels"];
	}
	// check text for matches
	$aantal = count($paths);
	$counter = 0;
	
	$username = user($mysql_link, $session);
	
	for ($f = 0; $f < $aantal; $f++)
	{
		// see if command is present
		$check = eregi($commands[$f], $text);
		if ($check)
		{
			// command is present
			// determine if userlevel has to be used
			if ($userlevels[$f] != "")
			{
				// userlevel is not "any"
				// get own userlevel
				$userlevel = user_level($mysql_link, $session);
				if ($userlevel == $userlevels[$f])
				{
					$go = TRUE;
				}
				else
				{
					$go = FALSE;
				}
				if ($go)
				{
					// add image
					$text = eregi_replace($commands[$f], "<img src=\"images/".$paths[$f]."\">", $text);
					update_stats($mysql_link, $username, "icons", 1);
					$counter++;
					
				} // end go check
				else
				{
					$text = "<font color=\"red\">***unauthorized use of icon***</font>";
				}
			} // end userlevel check
			else
			{
				// no userlevel check necessary, display image
				$split_text = split(strtoupper($commands[$f]), strtoupper($text));
				if (count($split_text) > 2)
				{
					$text = "<font color=\"red\">***1 icon of a kind per line***</font>";
				}
				else
				{
					$text = eregi_replace($commands[$f], "<img align=\"absmiddle\" src=\"images/".$paths[$f]."\">", $text);
					update_stats($mysql_link, $username, "icons", 1);					
				}
				$counter++;
				
			}
		} // end check if
		
		
		if ($counter > 1) { return $text; }
		
	}
	
	return $text;
}
		

function process($mysql_link, $session, $typed_text)
{
	$userlevel = user_level($mysql_link, $session);
	
	check_secure($mysql_link, $session); 
	
	// strip html 
	if (validate($userlevel, _striphtml)):
	
		$typed_text = htmlentities($typed_text);
		
	endif;
	// end strip
	
	// detect modes
	// determine on-line status
	$query = "SELECT status_online FROM chat_session_ids WHERE session_id = '$session';";
	$record = mysql_fetch_array(mysql_query($query, $mysql_link));
	
	switch ($record["status_online"])
	{
		case "10": $typed_text = crap($typed_text); break; // total crap
		case "11": $typed_text = no_spaces($typed_text); break; // no spaces
		case "12": $typed_text = reverse($typed_text); break; // reverse
		case "13": $typed_text = yell($typed_text); break; // yell
		case "14": $typed_text = stutter($typed_text); break; // stutter
		case "15": $typed_text = nerdie($typed_text); break; // nerdie
		case "16": $typed_text = swear($typed_text); break; // swear
		case "17": $typed_text = porn($typed_text); break; // porn
		case "18": $typed_text = no_vowels($typed_text); break; // no vowels
		case "19": $typed_text = ome_jo($typed_text); break; // ome jo
		case "20": $typed_text = nazi($typed_text); break; // nazi
		case "21": $typed_text = shut_up($typed_text); break; // shut up
		case "22": $typed_text = maroc($typed_text); break; // maroc
		case "23": $typed_text = southpark($typed_text); break; // southpark
	}
	
	// look for image replacements
	
	$typed_text = image_scan($mysql_link, $typed_text, $session);
	
	return $typed_text;
}
		

function speak($mysql_link, $session, $typed_text, $users)
{
	// do processing
	$typed_text = process($mysql_link, $session, $typed_text);
	$user_name = user($mysql_link, $session);
	
	$my_userlevel = user_level($mysql_link, $session);

	check_secure($mysql_link, $session); 
	
	if (($users == "2") and ($my_userlevel > 1))
	{
		$user_name = "system";
		$users = "0";
	}
	
	// add to database
	$status = 0;
	
	// check for !me tags
	$check = eregi("!me", $typed_text);
	if ($check):
	
	$status = 1;
	
	endif;
	// end check
	
	// check for !brb tags
	$check = eregi("!brb", $typed_text);
	if ($check):
	
	$status = 2;
	
	endif;
	// end check
	
	// check for !back tags
	$check = eregi("!back", $typed_text);
	if ($check):
	
	$status = 3;
	
	endif;
	// end check
	
	// check for !greet tags
	$check = eregi("!greet", $typed_text);
	if ($check):
	
	$status = 4;
	
	endif;
	// end check
	
	
	if ($typed_text != "")
	{
		// update linez counter
		update_stats($mysql_link, $user_name, "linez", 1);
		// count words
		$wordsarray = split(" ", $typed_text);
		update_stats($mysql_link, $user_name, "words", count($wordsarray));
		// count chars
		update_stats($mysql_link, $user_name, "chars", strlen($typed_text));
		
		$user_name = addslashes($user_name);
		$users = addslashes($users);
		
		$query = "SELECT id FROM chat_text_db WHERE text = '$typed_text';";
		$res = mysql_query($query, $mysql_link);
		if (mysql_num_rows($res) > 2)
		{
			mysql_query("INSERT INTO chat_text_db(saidby, saidto, status, text, date) VALUES ('system', '0', 0, '$user_name is flooding and will therefore be killed', now());", $mysql_link);
			?>			
			<script languague="JavaScript">
			alert("You are flooding. Goodbye !");
			window.parent.close();
			</script>
			<?
			mysql_query("DELETE FROM chat_session_ids WHERE session_id = '$session';", $mysql_link);
		}
		else
		{
			$user_name = strip_tags($user_name);
			$query = "INSERT INTO chat_text_db (saidby, saidto, status, text, date) ";
			$query .="VALUES ('$user_name', '$users', $status, '$typed_text', now());";
			mysql_query($query, $mysql_link);
		}
	}
	
	show_form($mysql_link);

	?>
	<script>
	<!--

	updatecontrol();
	
	//-->
	</script>
	<?
	// update timer
	update_timer($mysql_link, $session);
	
}

function kick($mysql_link, $username, $session)
{
	
	check_secure($mysql_link, $session); 
	
	update_timer($mysql_link, $session);
	
	$my_username = user($mysql_link, $session);
	$my_userlevel = user_level($mysql_link, $session);

	if ($my_userlevel < 1)
	{
		show_form($mysql_link);
		?>
		<script>
		<!--
		updatecontrol();
		//-->
		</script>
		<?
		return;
	}
	
	if (validate($my_userlevel, _god))
	{
		$query = "DELETE FROM chat_session_ids WHERE login = '$username';";
		mysql_query($query, $mysql_link);
		system_message($mysql_link, $username." was kicked by ".$my_username);
		update_stats($mysql_link, $username, "kicks", 1);
		show_form($mysql_link);
		
		?>
		<script>
		<!--

		updatecontrol();		
		
		//-->
		</script>
		<?
		return;		
	}	
	
	// do not kick moderators
	if ($username == "1")
	{
		js_alert("You cannot kick the moderators");
		show_form($mysql_link);
		return;
	}
	
	if ($username == "2")
	{
		js_alert("You cannot kick the system");
		show_form($mysql_link);
		return;
	}
	
	if ($username != '0')
	{
		// check if user is still logged in
		$query = "SELECT * FROM chat_session_ids WHERE login ='$username';";
		$ress = mysql_query($query, $mysql_link);
		
		if (mysql_num_rows($ress) != 0)
		{
			$usrec = mysql_fetch_array($ress);
			
			if (validate($usrec["userlevel"], _god)) 
			{
				js_alert("No");
				show_form($mysql_link);
				?>
				<script>
				<!--
				
				updatecontrol();
				
				//-->
				</script>
				<?
				return;
			}
			
			
			if (validate($usrec["userlevel"], sysops))
			{
				system_message($mysql_link, $my_username." cannot kick $username");
			}
			else
			{
				$query = "DELETE FROM chat_session_ids WHERE login = '$username';";
				mysql_query($query, $mysql_link);
				system_message($mysql_link, $username." was kicked by ".$my_username);
				update_stats($mysql_link, $username, "kicks", 1);
			}
		}
		else
		{
			js_alert("User has already left the chat and cannot be kicked... Damn !");
		}
	}
	else
	{
		js_alert("You cannot kick all users at once...");
	}
	show_form($mysql_link);
	
	?>
	<script>
	<!--
	
	updatecontrol();
	
	//-->
	</script>
	<?
}

function change_status_online($mysql_link, $status, $session)
{
	check_secure($mysql_link, $session); 
	
	$my_userlevel = user_level($mysql_link, $session);

	if ($my_userlevel < 2)
	{
		show_form($mysql_link);
		?>
		<script>
		<!--
		updatecontrol();
		//-->
		</script>
		<?
		return;
	}

	$username = user($mysql_link, $session);
	$c_status = status_online($mysql_link, $session);
	if ($c_status == 0) $new_status = 99;
	if ($c_status == 99) $new_status = 0;
	$query = "UPDATE chat_session_ids SET status_online = $new_status WHERE session_id = '$session';";
	mysql_query($query, $mysql_link);
	if ($new_status == 0) js_alert("You are now visible");
	if ($new_status == 99) js_alert("You are now invisible");		
	show_form($mysql_link);
	
	?>
	<script>
	<!--
	
	updatecontrol();
	
	//-->
	</script>
	<?
	if ($new_status == 0) system_message($mysql_link, "<font color=lightgreen>$username goes ***POOF*** and is now visible</font>");
	if ($new_status == 99) system_message($mysql_link, "<font color=lightgreen>$username goes ***POOF*** and is now invisible</font>");
	
	$query = "INSERT INTO chat_text_db (saidby, saidto, status, text, date) ";
	$query .= "VALUES ('$username', 'ask_for_refresh', 50, '', now());";
	mysql_query($query, $mysql_link);
	
	
	update_timer($mysql_link, $session);
}

function chat_message($mysql_link, $chat_mesg, $session)
{

	$my_userlevel = user_level($mysql_link, $session);

	if ($my_userlevel < 2)
	{
		show_form($mysql_link);
		?>
		<script>
		<!--
		updatecontrol();
		//-->
		</script>
		<?
		return;
	}
	
	$userlevel = user_level($mysql_link, $session);
	$username = user($mysql_link, $session);
	
	check_secure($mysql_link, $session); 
	
	if (validate($userlevel, sysops))
	{
		$query = "INSERT INTO chat_text_db (saidby, saidto, status, text, date) ";
		$query .= "VALUES ('$username', 'chatmessage', 50, '$chat_mesg', now());";
		mysql_query($query, $mysql_link);
	}
	show_form($mysql_link);
	
	?>
	<script>
	<!--
	
	updatecontrol();
	
	//-->
	</script>
	<?
	update_timer($mysql_link, $session);
}

// ****** MAIN

// determine action

switch ($action)
{
	case "": show_form($mysql_link); break;
	case "speak": speak($mysql_link, $session, $typed_text, $users); break;
	case "kick": kick($mysql_link, $username, $session); break;
	case "status_online": change_status_online($mysql_link, $status, $session); break;
	case "chat_message": chat_message($mysql_link, $chat_mesg, $session); break;
	
}

end_page($mysql_link);

?>


