<?php	
	include("global.inc");

	$msg = imap_header($mailbox, $msgnum);
	$struct = imap_fetchstructure($mailbox, $msgnum);

	$subject = !$msg->Subject ? $L_NO_SUBJECT : $msg->Subject;
	$subject = htmlspecialchars(decode_header_string($subject));
	$from = $msg->from[0];
	$the_date = getdate($msg->udate);
	$minutes = $the_date[minutes] < 10 ? "0$the_date[minutes]" : $the_date[minutes];
	$weekday = substr($the_date[weekday], 0, 3);
	$year = substr($the_date[year], 2, 2);
	$personal = !$from->personal ? "$from->mailbox@$from->host" : $from->personal;
?>

<title><?php echo "$subject - $PROG_NAME" ?></title>

<?php include("style.inc"); ?>

<table border=0 cellpadding=0 cellspacing=0 width=700><tr><td bgcolor=<?php echo $COLOR_HEAD ?>>
<table border=0 cellpadding=5 cellspacing=1 width=700><form>
<tr><td colspan=2 bgcolor=<?php echo $COLOR_HEAD ?>>

	<table border=0 cellpadding=0 cellspacing=1 width=100%><tr><td>
	<font size=3 face=<?php echo "$FONT color=$COLOR_FONT_HEAD" ?>><b><?php echo "$folder - $PROG_NAME" ?></b></font></td>
	<td align=right bgcolor=<?php echo $COLOR_HEAD ?>>
	<input type=button value="<?php echo $L_REPLY_BTN ?>" onClick="window.location='compose.php?action=reply&folder=<?php echo urlencode($folder) . "&msgnum=$msgnum"; ?>'">
	<input type=button value="<?php echo $L_REPLYALL_BTN ?>" onClick="window.location='compose.php?action=replyall&folder=<?php echo urlencode($folder) . "&msgnum=$msgnum"; ?>'">
	<input type=button value="<?php echo $L_FORWARD_BTN ?>" onClick="window.location='compose.php?action=forward&folder=<?php echo urlencode($folder) . "&msgnum=$msgnum"; ?>'">
	<input type=button value="<?php echo $L_DELETE_BTN ?>" onClick="window.location='action.php?folder=<?php echo urlencode($folder) . "&what=delete&msgnum=$msgnum"; ?>'">
	</td></tr></table>

</td>

<?php

$issentmail = (($folder == $SENT_MAIL) && is_string($SENT_MAIL));
if(!$issentmail)
{
	echo "<tr><td bgcolor=$COLOR_TITLE valign=top><font size=2 face=$FONT><b>$L_FROM_HDR:</b></td>";
	echo "<td bgcolor=$COLOR_ROW_ON width=570><font size=2 face=$FONT>";

	if($msg->from)
	{
		echo "<a href=\"compose.php?folder=" . urlencode($folder) . "&to=$from->mailbox@$from->host\">" . decode_header_string($personal) . "</a>"; 
	}	
	else
	{
		echo $L_NO_FROM;
	}

	echo "</td></tr>";
}

?>

<tr><td bgcolor=<?php echo $COLOR_TITLE ?> valign=top><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_TO_HDR ?>:</b></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><font size=2 face=<?php echo $FONT ?>>
<?php

if ($msg->to)
{

	for($i = 0; $i < count($msg->to); $i++)
	{
		$topeople = $msg->to[$i];
		$personal = !$topeople->personal ? "$topeople->mailbox@$topeople->host" : $topeople->personal;
		$personal = decode_header_string($personal);
		$tolist[$i] = "<a href=\"compose.php?folder=" . urlencode($folder) . "&to=$topeople->mailbox@$topeople->host\">$personal</a>";
	}

	echo implode(", ", $tolist);
}
else
{
	echo $L_NO_TO;
}


?></td></tr>

<?php

if($msg->cc)
{

	?>

	<tr><td bgcolor=<?php echo $COLOR_TITLE ?> valign=top><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_CC_HDR ?>:</b></td>
	<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><font size=2 face=<?php echo $FONT ?>>

	<?php

	for($i = 0; $i < count($msg->cc); $i++)
	{
		$ccpeople = $msg->cc[$i];
		$personal = !$ccpeople->personal ? "$ccpeople->mailbox@$ccpeople->host" : $ccpeople->personal;
		$personal = decode_header_string($personal);
		$cclist[$i] = "<a href=\"compose.php?folder=" . urlencode($folder) . "&to=$ccpeople->mailbox@$ccpeople->host\">$personal</a>";
	}

	echo implode(", ", $cclist);

	?></td></tr>

<?php } ?>

<tr><td bgcolor=<?php echo $COLOR_TITLE ?> valign=top><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_DATE_HDR ?>:</b></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><font size=2 face=<?php echo $FONT ?>><?php echo "$weekday $the_date[mon]/$the_date[mday]/$year $the_date[hours]:$minutes"; ?></td></tr><?php

	$flag = 0;
	for($z = 0; $z < count($struct->parts); $z++)
	{
		$part = !$struct->parts[$z] ? $part = $struct : $part = $struct->parts[$z];

		$att_name = get_att_name($part);

		if ($att_name != "Unknown")
		{
			// if it has a name, it's an attachment
			$f_name[$flag] = attach_display($part, $z+1);
			$flag++;
		}
	}
	if ($flag != 0)
	{
		echo "<tr><td bgcolor=$COLOR_TITLE valign=top><font size=2 face=$FONT><b>";
		echo "$L_FILES_HDR:</b></td><td bgcolor=$COLOR_ROW_ON width=570><font size=2 face=$FONT>";
		echo implode(", ", $f_name);
		echo "</td></tr>";
	}


?><tr><td bgcolor=<?php echo $COLOR_TITLE ?> valign=top><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_SUBJECT_HDR ?>:</b></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><font size=2 face=<?php echo $FONT ?>><?php echo $subject; ?></td></tr></table></td></tr></table>
<br>
<table border=0 cellpadding=2 cellspacing=0 width=100%>
<tr><td>

<?php

	$numparts = !$struct->parts ? "1" : count($struct->parts);
	//echo "<!-- This message has " . $numparts . " part(s) -->\n";

	for($i = 0; $i < $numparts; $i++)
	{
		$part = !$struct->parts[$i] ? $part = $struct : $part = $struct->parts[$i];

		$att_name = get_att_name($part);
		if ($att_name == "Unknown")
		{
			if (strtoupper(get_mime_type($part)) == "MESSAGE")
			{
				inline_display($part, $i+1);
				echo "\n<p>";
			}
			else
			{
				inline_display($part, $i+1);
				echo "\n<p>";
			}
		}

		$mime_encoding = get_mime_encoding($part);
		if(($mime_encoding == "base64") and ($part->subtype == "JPEG" or $part->subtype == "GIF" or $part->subtype == "PJPEG"))
		{
			// we want to display images here, even though they are attachments.
			echo "<p>" . image_display($folder, $msgnum, $part, $i+1, $att_name) . "<p>\n";
		}

	}

?>

</td></form></tr></table>

<?php  imap_close($mailbox);  ?>
