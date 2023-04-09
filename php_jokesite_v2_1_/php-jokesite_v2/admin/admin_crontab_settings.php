<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

$page_title = "Crontab Settings for Generating Newsletters";
$database_table_name = $bx_db_table_daily_newsletters;
$nr_of_cols = 2;

?>

<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<tr>
	<td>
		<blockquote>Use "crontab -l" to edit crontab file. Write these lines into this file. Save file and newsletter will generated automatically for subscribed users.</blockquote>
	</td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
	<form method=post action="<?=$this_file_name?>">
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" colspan="2"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Copy these lines into linux crontab file</b></font></td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" valign="top" align="center">
			<td>
				<b>If php is installed as executable use these lines </b>
				<form method=post action="<?=$this_file_name?>">
				<textarea name="message" rows="8" cols="80">10 0 * * * php <?=DIR_SERVER_ADMIN?>admin_random_newsletter_jokes.php >/dev/null

20 0 * * * php <?=DIR_SERVER_ROOT?>send_newsletters.php >/dev/null
</textarea>
<br><br><b>If php is installed as a module use these lines</b> 
<textarea name="message" rows="8" cols="80">10 0 * * * lynx <?=HTTP_SERVER_ADMIN?>admin_random_newsletter_jokes.php?make=1 >/dev/null

20 0 * * * lynx <?=HTTP_SERVER?>send_newsletters.php >/dev/null
</textarea>
				</form>
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