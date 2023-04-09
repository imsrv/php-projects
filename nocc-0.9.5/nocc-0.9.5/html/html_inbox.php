<!-- start of $Id: html_inbox.php,v 1.25 2001/11/16 17:10:46 rossigee Exp $ -->
<tr bgcolor="<?php echo $glob_theme->inbox_color ?>">
	<td align="center">
		<input type="checkbox" name="msg-<?php echo $tmp['number'] ?>" value="Y" />
	</td>
	<?php if (($is_Imap) || ($have_ucb_pop_server)) { ?>
	<td align="center">
		<?php echo $tmp['new'] ?>
	</td>
	<?php } ?>
	<td align="center">
		<?php echo $tmp['attach'] ?>
	</td>
	<td class="inbox" align="left">
		<a href="<?php echo $PHP_SELF ?>?action=aff_mail&amp;mail=<?php echo $tmp['number'] ?>&amp;sort=<?php echo $sort ?>&amp;sortdir=<?php echo $sortdir?>&amp;verbose=0&amp;lang=<?php echo $lang ?>" title="<?php echo htmlspecialchars($tmp['from']); ?>"><?php echo htmlspecialchars(display_address ($tmp['from'])); ?></a>
	</td>
	<td class="inbox" align="left">
		<a href="<?php echo $PHP_SELF ?>?action=aff_mail&amp;mail=<?php echo $tmp['number'] ?>&amp;sort=<?php echo $sort ?>&amp;sortdir=<?php echo $sortdir?>&amp;verbose=0&amp;lang=<?php echo $lang ?>"><?php echo $tmp['subject']? htmlspecialchars($tmp['subject']) : $html_nosubject; ?></a>
	</td>
	<td class="inbox" align="left">
		<?php echo $tmp['date'] ?>
	</td>
	<td class="inbox">
		<?php echo $tmp['size'] ?> <?php echo $html_kb ?>
	</td>
</tr>
<!-- end of $Id: html_inbox.php,v 1.25 2001/11/16 17:10:46 rossigee Exp $ -->
