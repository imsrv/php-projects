<?include(DIR_LNG.'footer.php');?>

				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center" valign="bottom">

<? 
if ($random_bottom) 
{
?>
				<table valign="bottom" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
				<tr>
					<!-- <td width="17%">&nbsp;</td> -->
					<td align="center"><?echo fread(fopen(BANNER_DIR."bottom_banner".$random_bottom.".html","r"), filesize(BANNER_DIR."bottom_banner".$random_bottom.".html"));?></td>
				</tr>
				</table>
				<br>
<?
}
?>
			</td>
		</tr>
		</table>

	</td>
	<td bgcolor="#cccccc" width="1"></td>
	<td bgcolor="<?=RIGHT_PART_BGCOLOR?>"  valign="top" width="<?=RIGHT_PART_WIDTH?>">
		<table valign="bottom" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
		<tr>
			<td align="center">
<? if ($show_the_joke_and_picture_of_the_day)
{
?>
<!-- Start	code for random	joke/picture -->
<script	language="Javascript" src="<?=HTTP_SERVER?>daily_joke_picture.php?type=js">
</script>
<noscript>
<img src="<?=HTTP_SERVER?>daily_joke_picture.php?type=img" border="0" alt="">
</noscript>
<!-- End code for random joke/picture -->
<a href="content_channel.php" style="color:<?=CONTENT_CHANNEL_TEXT_COLOR?>;text-decoration:none;font-family:helvetica,arial"><?=TEXT_ADD_TO_YOUR_SITE?></a><br><br>
<?
}
if ($random_right)
{
?>
			<?echo fread(fopen(BANNER_DIR."right_banner".$random_right.".html","r"), filesize(BANNER_DIR."right_banner".$random_right.".html"));?>
<?
}
?>			
			</td>
		</tr>
		</table>

	     </td></tr></table>
	</td>
</tr>
</table>

<? if(USE_EXTRA_FOOTER=='yes'){?>
<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=HTML_WIDTH?>"><tr><td colspan="2"><?=EXTRA_FOOTER;?></td></tr></table>
<?}?>
<br>

</body>
</html>
<?
	include (DIR_SERVER_ROOT.'application_parse_time_log.php');
?>