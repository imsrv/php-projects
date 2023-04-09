<?
include ("config_file.php");
include (DIR_SERVER_ROOT."header.php");
include(DIR_LNG.'view_retrieve_postcard.php');
$database_table_name = $bx_db_table_postcard_messages;
$database_table_name1 = $bx_db_table_images;

$selectSQL = "select * from $database_table_name";
$select_postcard_query = bx_db_query($selectSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
while ($select_postcard_result = bx_db_fetch_array($select_postcard_query))
{
	if (md5($select_postcard_result['pm_id']) == $HTTP_GET_VARS['pm_id'])
	{
		$success = 1;
		$img_id = $select_postcard_result['image_id'];
		$postcard_result = $select_postcard_result;
	}
}

if ($success != 1)
{
	refresh(HTTP_SERVER);
	exit;
}

$selectSQL = "select * from $database_table_name1 where img_id='".$img_id."'";
$select_image_query = bx_db_query($selectSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$select_image_result = bx_db_fetch_array($select_image_query)

?>

<tr valign="top">
	<td>
		<table cellpadding="0" cellspacing="5" width="70%" align="center" border="0">
		<tr align="center">
			<td><font size="4" face="helvetica" color="#990000"><u><?=ucwords($postcard_result['title'])?></u></font></td>
		</tr>
		<tr align="center">
			<td><a href="<?=HTTP_SERVER?>"><img src="<?=HTTP_INCOMING?><?=$select_image_result['big_img_name']?>" alt="" border="1"></a></td>
		</tr>
		<tr>
			<td>
				
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=$image_result['comment']?><br><br>
			</td>
		</tr>
		<tr>
			<td><?=MESSAGE_TO?> <b><?=$postcard_result['to_name']?>:</b><br></td>
		</tr>
		<tr>
			<td>
				<?=$postcard_result['message']?>
			</td>
		</tr>
		<tr>
			<td align="center">
				<?=TEXT_BY?> <?=$postcard_result['your_name']?> (<?=$postcard_result['your_email']?>)
			</td>
		</tr>
		<tr>
			<td><br><br><?=TEXT_POSTCARD_FROM?> <b><?=$site_name?></b></td>
		</tr>
		<tr>
			<td><a href="<?=HTTP_SERVER?>pictures_category.php" style="text_decoration:none;color:#3300FF"><?=TEXT_CREATE_YOUR_POSTCARD?></a></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		</table>
	</td>
</tr>

<?
include (DIR_SERVER_ROOT."footer.php");
?>