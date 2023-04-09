<?php	
	Header("Cache-Control: no-cache");
	Header("Pragma: no-cache");
	Header("Expires: Sat, Jan 01 2000 01:01:01 GMT");

	include("global.inc");
?>

<title><?php echo "$L_FOLDERS - $PROG_NAME" ?></title>

<?php include("style.inc"); ?>

<table border=0 cellpadding=0 cellspacing=0 width=700><tr><td bgcolor=<?php echo $COLOR_HEAD ?>>
<table border=0 cellpadding=5 cellspacing=1 width=700>
<form action="folder.php">
<tr><td colspan=2 bgcolor=<?php echo $COLOR_HEAD ?>>

	<table border=0 cellpadding=0 cellspacing=1 width=100%>
	 <tr>
          <td>
		<font size=3 face=<?php echo $FONT ?> color=<?php echo $COLOR_FONT_HEAD ?>><b>Folders - <?php echo "$PROG_NAME" ?></b></font>
	  </td>
	  <td align=right>
		<table border=0 cellpadding=0 cellspacing=0>
		 <tr>
		  <td>
		    &nbsp;&nbsp;<input type=button value="<?php echo $L_GO_BACK_BTN ?>" onClick="window.location='index.php?folder=<?php echo urlencode($folder) ?>'">
		  </td>
		 </tr>
		</table>
	  </td>
	 </tr>
	</table>
</td></tr>

<td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_FOLDER_NAME ?></b></font></td>
<td bgcolor=<?php echo $COLOR_TITLE ?>><font size=2 face=<?php echo $FONT ?>><b><?php echo $L_NUM_MESSAGES ?></b></font></td>


<?php
	$fold_str = $IMAP_SERVER_TYPE == "Cyrus" ? "INBOX." : $PROG_DIR;
	if($action == "create")
	{
		imap_createmailbox($mailbox, "$IMAP_STR$fold_str$name");
	}
	if($action == "delete")
	{
		imap_deletemailbox($mailbox, "$IMAP_STR$fold_str$name");
	}
		$mailboxes = imap_listmailbox($mailbox, "$IMAP_STR", "$FILTER*");
		if($mailboxes)
		{
			sort($mailboxes);
			$first = "ffffff"; $second = "ddeebb";
			if ($FILTER != "INBOX")
			{
				echo "<tr><td bgcolor=$COLOR_ROW_ON><font size=2 face=$FONT>";
				echo "<a href=\"index.php?folder=INBOX\">INBOX</a></font></td>";
				echo "<td bgcolor=$COLOR_ROW_ON width=20%><font size=2 face=$FONT>";
				echo imap_num_msg($mailbox) . "</font></td></tr>\n";
				$first = $COLOR_ROW_ON; $second = $COLOR_ROW_OFF;
			}
			for ($i = 0; $i < count($mailboxes); $i++)
			{
				$bg = (($i + 1)/2 == floor(($i + 1)/2)) ? $first : $second;
				imap_reopen($mailbox, $mailboxes[$i]);
				$nm = substr($mailboxes[$i], strrpos($mailboxes[$i], "}") + 1, strlen($mailboxes[$i]));
				echo "<tr><td bgcolor=$bg><font size=2 face=$FONT>";

				if ($nm != "INBOX")
				{
					$nm = deconstruct_folder_str($nm);
				}
				else
				{
					$nm = "INBOX";
				}

				$url_nm = urlencode($nm);

				echo "<a href=\"index.php?folder=$url_nm\">$nm</a></font></td>";
				echo "<td bgcolor=$bg width=20%><font size=2 face=$FONT>";
				echo imap_num_msg($mailbox) . "</font></td></tr>\n";
			}
		}
		else
		{
			echo "<tr><td bgcolor=$COLOR_ROW_ON><font size=2 face=$FONT>";
			echo "<a href=\"index.php?folder=INBOX\">INBOX</a></font></td>";
			echo "<td bgcolor=$COLOR_ROW_ON width=20%><font size=2 face=$FONT>";
			echo imap_num_msg($mailbox) . "</font></td></tr>\n";
		}
	imap_close($mailbox);

?>

<tr><td colspan=2 align=right bgcolor=<?php echo $COLOR_TITLE ?>>
<select name="action">
<option value="create"><?php echo $L_FOLDER_CREATE ?>
<option value="delete"><?php echo $L_FOLDER_DELETE ?>
</select> <font size=2 face=<?php echo $FONT ?>><b><?php echo $L_NAMED ?></b></font>
<input type=text name="name"><input type=hidden name=folder value="<?php echo $folder ?>">
<input type=submit value="<?php echo $L_SUBMIT_BTN ?>"></td></tr></form>
</table></td></tr></table>

<p>

