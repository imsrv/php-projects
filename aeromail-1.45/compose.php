<?php
	Header("Cache-Control: no-cache");
	Header("Pragma: no-cache");
	Header("Expires: Sat, Jan 01 2000 01:01:01 GMT");

	include("global.inc");

	if($msgnum)
	{
		$msg = imap_header($mailbox, $msgnum);
		$struct = imap_fetchstructure($mailbox, $msgnum);
		$from = $msg->from[0];

		if($action == "reply")
		{
			$to = "$from->mailbox@$from->host";
			$subject = !$msg->Subject ? $L_NO_SUBJECT : decode_header_string($msg->Subject);
			$begin = strtoupper(substr($subject, 0, 3)) != "RE:" ? "Re: " : "";
			$subject = $begin . $subject;
		}
		if($action == "replyall")
		{
			if($msg->to)
			{
				for($i = 0; $i < count($msg->to); $i++)
				{
					$topeople = $msg->to[$i];
					$tolist[$i] = "$topeople->mailbox@$topeople->host";
				}
				$to = "$from->mailbox@$from->host, " . implode(", ", $tolist);
			}

			if($msg->cc)
			{
				for($i = 0; $i < count($msg->cc); $i++)
				{
					$ccpeople = $msg->cc[$i];
					$cclist[$i] = "$ccpeople->mailbox@$ccpeople->host";
				}
				$cc = implode(", ", $cclist);
			}

			$subject = !$msg->Subject ? $L_NO_SUBJECT : decode_header_string($msg->Subject);
			$begin = strtoupper(substr($subject, 0, 3)) != "RE:" ? "Re: " : "";
			$subject = $begin . $subject;
		}
		if($action == "forward")
		{
			$subject = !$msg->Subject ? $L_NO_SUBJECT : decode_header_string($msg->Subject);
			$begin = strtoupper(substr($subject, 0, 3)) != "FW:" ? "Fw: " : "";
			$subject = $begin . $subject;
		}

		$personal = !$from->personal ? "$from->mailbox@$from->host" : $from->personal;
		$the_date = getdate($msg->udate);
		$minutes = $the_date[minutes] < 10 ? "0$the_date[minutes]" : $the_date[minutes];
		$weekday = substr($the_date[weekday], 0, 3);
		$year = substr($the_date[year], 2, 2);
		$de_subject = !$msg->Subject ? $L_NO_SUBJECT : $msg->Subject;
		$de_subject = decode_header_string($de_subject);

		$body = "\n\n\n$L_ORIG_MSG\n";
		$body .= "$L_FROM_HDR:\t\t$personal\n";
		$body .= "$L_DATE_HDR:\t\t$weekday $the_date[mon]/$the_date[mday]/$year $the_date[hours]:$minutes\n";
		$body .= "$L_TO_HDR:\t\t";

		if ($msg->to)
		{
			for($i = 0; $i < count($msg->to); $i++)
			{
				$topeople = $msg->to[$i];
				$personal = !$topeople->personal ? "$topeople->mailbox@$topeople->host" : $topeople->personal;
				$personal = decode_header_string($personal);
				$tolist[$i] = $personal;
			}
			$body .= implode(", ", $tolist) . "\n";
		}
		else
		{
			$body .= "$L_NO_TO\n";
		}

		if ($msg->cc)
		{
			for($i = 0; $i < count($msg->cc); $i++)
			{
				$ccpeople = $msg->cc[$i];
				$personal = !$ccpeople->personal ? "$ccpeople->mailbox@$ccpeople->host" : $ccpeople->personal;
				$personal = decode_header_string($personal);
				$cclist[$i] = $personal;
			}
			$body .= "$L_CC_HDR:\t\t" . implode(", ", $cclist) . "\n";
		}
		$body .= "$L_SUBJECT_HDR:\t$de_subject\n\n";


		$numparts = !$struct->parts ? "1" : count($struct->parts);
		for($i = 0; $i < $numparts; $i++)
		{
			$part = !$struct->parts[$i] ? $part = $struct : $part = $struct->parts[$i];
			if (get_att_name($part) == "Unknown")
			{
				if (strtoupper($part->subtype) == "PLAIN")
				{
					$body .= imap_fetchbody($mailbox, $msgnum, $i+1);
				}
			}
		}

	}
?>

<?php include("style.inc"); ?>

<title><?php echo "$L_MESSAGE_COMPOSE - $PROG_NAME" ?></title>

<table border=0 cellpadding=0 cellspacing=0 width=700><tr><td bgcolor=<?php echo $COLOR_HEAD ?>>
<table border=0 cellpadding=1 cellspacing=1 width=700>

<form enctype="multipart/form-data" name=doit action="send_message.php" method=POST>
<input type=hidden name=return value="<?php echo $folder ?>"><tr><td colspan=2 bgcolor=<?php echo $COLOR_HEAD ?>>

	<table border=0 cellpadding=4 cellspacing=1 width=100%>
	<tr><td>
	<font size=3 face=<?php echo "$FONT color=$COLOR_FONT_HEAD" ?>><b><?php echo "$L_MESSAGE_COMPOSE - $PROG_NAME" ?></b></font></td>

	<td align=right bgcolor=<?php echo $COLOR_HEAD ?>>
	<input type=submit value="<?php echo $L_SEND_BTN ?>">

	</td></tr></table>

</td>

<tr><?php echo "<td bgcolor=$COLOR_TITLE><font size=2 face=$FONT><b>&nbsp;$L_TO_HDR:</b>" ?></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><input type=text name=to size=80 value="<?php

if ($mailto)
{
	echo substr($mailto, 7, strlen($mailto));
}
else
{
	echo $to;
}

?>"></td></tr>
<tr><td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b>&nbsp;<?php echo $L_CC_HDR ?>:</b></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><input type=text name=cc size=80 value="<?php echo $cc ?>"></td></tr>

<tr><td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b>&nbsp;<?php echo $L_FILE_HDR ?>:</b></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?>><input type=file name=attach size=68></td></tr>

<tr><td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b>&nbsp;<?php echo $L_SUBJECT_HDR ?>:&nbsp;</b></td>
<td bgcolor=<?php echo $COLOR_ROW_ON ?> width=570><input type=text name=subject size=80 value="<?php echo $subject; ?>"></td></tr>


</table></td></tr></table>

<br>
<!--<table border=0 cellpadding=0 cellspacing=3 width=700>


<tr><td--><textarea name=body cols=85 rows=25 wrap=hard><?php echo $body; ?></textarea><!--/td></tr-->
</form><!--/table-->

<script>

document.doit.body.focus();
if(document.doit.subject.value == "") document.doit.subject.focus();
if(document.doit.to.value == "") document.doit.to.focus();

</script>
