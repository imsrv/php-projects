<!-- start of $Id: html_mail_header.php,v 1.21 2001/11/16 17:10:44 rossigee Exp $ -->
<?php
if ($verbose == 1 && $use_verbose == true)
	echo "<tr><td class=\"mail\"><a href=\"$PHP_SELF?action=aff_mail&amp;mail=$mail&amp;verbose=0&amp;lang=".$lang."&amp;sort=".$sort."&amp;sortdir=".$sortdir."\" class=\"mail\">".$html_remove_header."</a></td>";
elseif ($use_verbose == true)
	echo "<tr><td class=\"mail\"><a href=\"$PHP_SELF?action=aff_mail&amp;mail=$mail&amp;verbose=1&amp;lang=".$lang."&amp;sort=".$sort."&amp;sortdir=".$sortdir."\" class=\"mail\">".$html_view_header."</a></td>";
else
	echo "<tr><td>&nbsp;</td>";

if (($content['prev'] != '') && ($content['prev'] != 0))
	$prev = "<a href=\"$PHP_SELF?action=aff_mail&amp;mail=".$content["prev"]."&amp;verbose=".$verbose."&amp;lang=".$lang."&amp;sort=".$sort."&amp;sortdir=".$sortdir."\"><img src=\"themes/".$theme."/img/left_arrow.gif\" alt=\"$alt_prev\" title=\"$alt_prev\" border=\"0\" /></a>";
if (($content['next'] != '') && ($content['next'] != 0))
	$next =  "<a href=\"$PHP_SELF?action=aff_mail&amp;mail=".$content["next"]."&amp;verbose=".$verbose."&amp;lang=".$lang."&amp;sort=".$sort."&amp;sortdir=".$sortdir."\"><img src=\"themes/".$theme."/img/right_arrow.gif\" alt=\"$alt_next\" title=\"$alt_next\" border=\"0\" /></a>";
?>	
<td	align="right"><?php if (isset($prev)) echo $prev; ?>&nbsp;<?php if (isset($next)) echo $next; ?></td></tr>
<tr><td align="right" class="mail"><?php echo $html_from ?></td><td bgcolor="<?php echo $glob_theme->mail_properties ?>" class="mail"><b><?php echo htmlspecialchars($content["from"]) ?></b></td></tr>

<tr><td align="right" class="mail"><?php echo $html_to ?></td><td bgcolor="<?php echo $glob_theme->mail_properties ?>" class="mail"><?php echo htmlspecialchars($content["to"]) ?></td></tr>

<?php 
if ($content['cc'] != '')
{ ?>
<tr><td align="right" class="mail"><?php echo $html_cc ?></td><td bgcolor="<?php echo $glob_theme->mail_properties ?>" class="mail"><?php echo htmlspecialchars($content["cc"]) ?></td></tr>
<?php
}

if ($content['subject'] == '')
	$content['subject'] = $html_nosubject;
?>

<tr><td align="right" class="mail"><?php echo $html_subject ?></td><td bgcolor="<?php echo $glob_theme->mail_properties ?>" class="mail"><b><?php echo htmlspecialchars($content['subject']) ?></b></td></tr>

<tr><td align="right" class="mail"><?php echo $html_date?></td><td bgcolor="<?php echo $glob_theme->mail_properties ?>" class="mail"><?php echo $content['date'] ?></td></tr>

<?php echo $content['att'] ?>

<tr><td colspan="2" bgcolor="<?php echo $glob_theme->mail_color ?>" class="mail"><pre><?php echo $content['header'] ?></pre><br />
<?php //echo @convert_cyr_string($content['body'], $content['charset'], $charset); ?>
<?php echo $content['body'] ?>
<!-- end of $Id: html_mail_header.php,v 1.21 2001/11/16 17:10:44 rossigee Exp $ -->
