<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

$page_title = "Bulk Email";
$database_table_name = $bx_db_table_newsletter_subscribers;
$this_file_name = basename($HTTP_SERVER_VARS['PHP_SELF']);
$nr_of_cols = 2;
if ($HTTP_POST_VARS['send_now'] == '1' && ($HTTP_POST_VARS['daily'] || $HTTP_POST_VARS['monthly'] || $HTTP_POST_VARS['weekly']))
{
	if ($HTTP_POST_VARS['daily'] || $HTTP_POST_VARS['monthly'] || $HTTP_POST_VARS['weekly'])
	{
		$condition = " where ";
	}
	if ($HTTP_POST_VARS['daily'])
	{
		$condition .= " type='1' ";
		$not_first = "or";
	}
	if ($HTTP_POST_VARS['weekly'])
	{
		$condition .= " $not_first type='2' ";
		$not_first = "or";
	}
	if ($HTTP_POST_VARS['monthly'])
	{
		$condition .= " $not_first type='3' ";
	}
 	$select_subscribers_SQL = "select * from $database_table_name".$condition;
	$select_subscribers_query = bx_db_query($select_subscribers_SQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));	
	if (bx_db_num_rows($select_subscribers_query) != '0')
		while ($select_subscribers_result = bx_db_fetch_array($select_subscribers_query))
		{
			//mail($select_subscribers_result['email'], $HTTP_POST_VARS['subject'], $HTTP_POST_VARS['message'], "From: ".$newsletter_mail);
			bx_mail($site_name, $site_mail, $select_subscribers_result['email'], $HTTP_POST_VARS['subject'], nl2br($HTTP_POST_VARS['message']), $HTTP_POST_VARS['bulk_type']);
		}
?>
	<script language="Javascript">
	<!--
	alert('Bulk email sent to users');
	//-->
	</script>
<?
}
?>

<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
	<form method=post action="<?=$this_file_name?>">
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" colspan="3"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Send Bulk Email</b></font></td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" valign="top">
			<td>
				&nbsp;
			</td>
			<td>
				Email Format Type
			</td>
			<td>
				<input type="radio" class="radio" name="bulk_type" value="no" checked>Plain text &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="radio" name="bulk_type" value="yes">HTML
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" valign="top">
			<td>
				&nbsp;
			</td>
			<td>
				Email to:
			</td>
			<td>
<?
$selectSQL = "select * from $bx_db_table_newsletter_categories where active='on'";
$select_query = bx_db_query($selectSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
while($select_result = bx_db_fetch_array($select_query)){
	switch ($select_result['newsletter_category_id'])
	{
		case '1':	$daily = 1; break;	
		case '2':	$weekly = 1; break;
		case '3':	$monthly = 1; break;
	}
}
if($daily)
	echo "<input type=\"checkbox\" class=\"radio\" name=\"daily\" value=\"1\" checked>Daily &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if($weekly)
	echo "<input type=\"checkbox\" class=\"radio\" name=\"weekly\" value=\"2\" checked>Weekly &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if($monthly)
	echo "<input type=\"checkbox\" class=\"radio\" name=\"monthly\" value=\"3\" checked>Monthly &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
			Subscribers
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" valign="top">
			<td>
				&nbsp;
			</td>
			<td>
				Subject
			</td>
			<td>
				<input type="text" name="subject" value="" class="">
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" valign="top">
			<td>
				&nbsp;
			</td>
			<td>
				Message
			</td>
			<td>
				<textarea name="message" rows="10" cols="40"></textarea>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" valign="top">
			<td colspan="3" align="center">
				<input type="hidden" name="send_now" value="1">
				<input type="submit" name="send" value="Send" class="button">
			</td>
		</tr>
		</table>
	</form>
	</td>
</tr>

</table>
<br>

<?
include(DIR_SERVER_ADMIN."admin_footer.php");
?>