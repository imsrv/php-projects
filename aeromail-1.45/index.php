<?php	
	Header("Cache-Control: no-cache");
	Header("Pragma: no-cache");
	Header("Expires: Sat, Jan 01 2000 01:01:01 GMT");

	include("global.inc");
?>

<script>

function do_action(act)
{
	flag = 0;
	for(i=0 ; i<document.delmov.elements.length; i++)
	{
		//alert(document.delmov.elements[i].type);
		if(document.delmov.elements[i].type == "checkbox")
		{
			if(document.delmov.elements[i].checked)
			{
				flag = 1;
			}
		}
	}
	if(flag != 0)
	{
		document.delmov.what.value = act;
		document.delmov.submit();
	}
	else
	{
		alert("<?php echo $L_SELECT_ERROR ?>");
		document.delmov.tofolder.selectedIndex = 0;
	}
}

function check_all()
{

	for(i=0 ; i<document.delmov.elements.length; i++)
	{
		if(document.delmov.elements[i].type == "checkbox")
		{
			if(document.delmov.elements[i].checked)
			{
				document.delmov.elements[i].checked = false;
			}
			else
			{
				document.delmov.elements[i].checked = true;
			}
		}
	}
}

</script>

<?php include("style.inc"); ?>

<title><?php echo "$folder - $PROG_NAME" ?></title>

<form name="switchbox" action="index.php" method=GET>

<table border=0 cellpadding=0 cellspacing=0 width=100%><tr>
<td bgcolor=<?php echo $COLOR_HEAD ?>><table border=0 cellpadding=5 cellspacing=1 width=100%>
  <tr><td colspan=5 bgcolor=<?php echo $COLOR_HEAD ?>>
	<table border=0 cellpadding=0 cellspacing=1 width=100%>
	  <tr><td>
	  <font size=3 face=<?php echo $FONT ?> color=<?php echo $COLOR_FONT_HEAD ?>><b><?php echo "$folder - $PROG_NAME" ?> - 

<?php

	$issentmail = (($folder == $SENT_MAIL) && is_string($SENT_MAIL));

	$nummsg = imap_num_msg($mailbox);
        if ($nummsg > 0)
        {
                $msg_array = imap_sort($mailbox, 1, 1);
                echo "$nummsg";
        }
	else
	{
		echo "$nummsg";
	}

	$out = $nummsg == 1 ? " $L_MESSAGE" : " $L_MESSAGES";
	echo $out;

	// code to display start to count

	$msg_start = $start ? $start : 1;
	$msg_start--;
	$tmp_count = $count ? $count : $MSG_COUNT;
	$tmp_display = $tmp_count > $nummsg ? $nummsg : $tmp_count;
	$nummsg_display = $tmp_display > ($nummsg - $msg_start) ? ($nummsg - $msg_start) : $tmp_display;

	echo
?>

	</b></font></td><td align=right><table border=0 cellpadding=0 cellspacing=0><tr><td>
		<select name=folder onChange="document.switchbox.submit()">
		<option><?php echo $L_FOLDER_SWITCH ?>:
		<?php list_folders($mailbox); ?>
		</select></td><td>
		&nbsp;&nbsp;<input type=button value="<?php echo $L_FOLDER_BTN ?>" onClick="window.location='folder.php?folder=<?php echo urlencode($folder) ?>'"></td></tr></table></td></tr></table></td></tr>

<tr></form><form name=delmov action="action.php" method=GET>
<td align=center bgcolor=<?php echo $COLOR_TITLE ?>><input type=hidden name=what value=""><input type=hidden name=folder value="<?php echo "$folder" ?>"><a href="javascript:location.reload()"><img src="images/refresh.gif" border=0 height=16 width=21></a></td>
<td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_SUBJECT_HDR ?></b></font></td>
<td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b><?php 

echo $issentmail ? $L_TO_HDR : $L_FROM_HDR 

?></b></font></td>
<td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b><?php

echo $issentmail ? $L_SENT_HDR : $L_RECEIVED_HDR

?></b></font></td>
<td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_SIZE_HDR ?></b></font></td></tr>

<?php
	if($nummsg == 0)
	{
		echo "<tr><td bgcolor=$COLOR_ROW_ON>&nbsp;</td><td bgcolor=$COLOR_ROW_ON>";
		echo "<font size=2 face=$FONT><b>$L_FOLDER_EMPTY</b></font></td>";
		echo "<td bgcolor=$COLOR_ROW_ON>&nbsp;</td><td bgcolor=$COLOR_ROW_ON>&nbsp;</td>";
		echo "<td bgcolor=$COLOR_ROW_ON>&nbsp;</td></tr>";
	}

	$flipflop = 0;

	for( $i=$msg_start ; $i < $msg_start + $nummsg_display ; $i++ )
	{

		$struct = imap_fetchstructure($mailbox, $msg_array[$i]);
		$attach = "&nbsp;";

		for($j = 0; $j < count($struct->parts); $j++)
		{
			if(!$struct->parts[$j])	{
				$part = $struct;
			}
			else {
				$part = $struct->parts[$j];
			}

			$att_name = get_att_name($part);
			if ($att_name != "Unknown")
			{
				$attach = "&nbsp;<font face=$FONT size=1><b>@</b></font>";
			}
		}


		$msg = imap_header($mailbox, $msg_array[$i]);

		$subject = !$msg->Subject ? $L_NO_SUBJECT : $msg->Subject;
		$subject = htmlspecialchars(decode_header_string($subject));

		$ksize = round(10*($msg->Size/1000))/10;
		$size = $msg->Size > 1000 ? "$ksize k" : $msg->Size;

		if($flipflop == 0)
		{
			$bg = $COLOR_ROW_ON;
			$flipflop = 1;
		}
		else
		{
			$bg = $COLOR_ROW_OFF;
			$flipflop = 0;
		}

		$the_date = getdate($msg->udate);
		$weekday = substr($the_date[weekday], 0, 3);
		$year = substr($the_date[year], 2, 2);
		$minutes = $the_date[minutes] < 10 ? "0$the_date[minutes]" : $the_date[minutes];
			
		echo "<tr><td bgcolor=$bg align=center>";
		echo "<input type=checkbox name=\"msglist[]\" value=$msg_array[$i]></td>\n";
		echo "<td bgcolor=$bg><font size=2 face=$FONT>";
		echo "<a href=\"message.php?folder=" . urlencode($folder) . "&msgnum=$msg_array[$i]\">";
		echo $subject . "</a></font>$attach</td>\n";
		echo "<td bgcolor=$bg><font size=2 face=$FONT>";

		if($issentmail)
		{
			if ($msg->to)
			{
				$topeople = $msg->to[0];
				$personal = !$topeople->personal ? "$topeople->mailbox@$topeople->host" : $topeople->personal;

				echo "<a href=\"compose.php?folder=" . urlencode($folder) . "&to=$topeople->mailbox";
				echo "@$topeople->host\">" . decode_header_string($personal) . "</a>";
			}
			else
			{
				echo $L_NO_TO;
			}
		}
		else
		{
			if($msg->from)
			{
				$from = $msg->from[0];
				$personal = !$from->personal ? "$from->mailbox@$from->host" : $from->personal;

				echo "<a href=\"compose.php?folder=" . urlencode($folder) . "&to=$from->mailbox@$from->host\">";
				echo decode_header_string($personal) . "</a>";
			}
			else
			{
				echo $L_NO_FROM;
			}
		}

		echo "</font></td>\n";
		echo "<td bgcolor=$bg><font size=1 face=$FONT>$weekday $the_date[mon]/$the_date[mday]/$year";
		echo " $the_date[hours]:$minutes</font></td>\n";
		echo "<td bgcolor=$bg><font size=1 face=$FONT>$size</font></td></tr>\n";
	}
?>

<tr><td bgcolor=<?php echo $COLOR_TITLE ?> align=center><a href="javascript:check_all()"><img src="images/check.gif" border=0 height=16 width=21></a></td>

<td bgcolor=<?php echo $COLOR_TITLE ?> colspan=4>
<font size=2 face=<?php echo $FONT ?>><b>
<?php

$location = $msg_start + 1;

for($k=1; $k <= $nummsg; $k += $tmp_count)
{
	$end_tmp = $k + $tmp_count - 1;
	$end = $end_tmp >= $nummsg ? $nummsg : $end_tmp;

	$newlink = "<a class=noline href=\"index.php?folder=$folder&start=$k&count=$tmp_count\">";
	$link = (($k <= $location) and ($location <= $end)) ?  "" : $newlink;
	echo $link . "[$k-" . $end;
	$link = (($k <= $location) and ($location <= $end)) ?  "" : "</a>";
	echo "]" . $link;

	echo "&nbsp;&nbsp;&nbsp;";
}

?>
</b></font>
</td></tr>

<tr><td bgcolor=<?php echo $COLOR_HEAD ?> colspan=5>

	<table width=100% border=0 cellpadding=0 cellspacing=0>
	<tr>
	<td>
		<input type=button value="<?php echo $L_DELETE_BTN ?>" onClick="do_action('delall')">
		<input type=button value="<?php echo $L_COMPOSE_BTN ?>" onClick="window.location='compose.php?folder=<?php echo urlencode($folder) ?>'">
		<input type=button value="<?php echo $L_LOGOUT_BTN ?>" onClick="window.location='logout.php'">
	</td>
	<td align=right>
		<select name=tofolder onChange="do_action('move')">
		<option><?php echo $L_FOLDER_MOVE ?>:
		<?php list_folders($mailbox); imap_close($mailbox); ?>
		</select>
	</td></tr></table>

</td></tr>

</form>
</table>
</td></tr></table>