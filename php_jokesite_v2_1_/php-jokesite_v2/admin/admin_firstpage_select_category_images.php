<?

include ("../config_file.php");
$selectSQL = "select * from $bx_db_table_images where category_id='".$HTTP_GET_VARS['cat_id']."'";
$select_query = bx_db_query($selectSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

if ($HTTP_GET_VARS['insert']=='1')
{
	$updateSQL = "update $bx_db_table_images set show_images_at_home='0' where category_id='".$HTTP_GET_VARS['cat_id']."'";
	$update_query = bx_db_query($updateSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	$updateSQL = "update $bx_db_table_images set show_images_at_home='1' where img_id='".$HTTP_GET_VARS['img_id']."'";
	$update_query = bx_db_query($updateSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
?>
	<script language="JavaScript" type="text/javascript">
  <!--
    //opener.location.reload(true);
    window.opener.location ='admin_firstpage_images.php';
	//opener.location.reload(true);
    self.close();
  // -->
</script>

<?
}
$http_image = HTTP_INCOMING;
$dir_image = INCOMING;

$not_iview = urldecode($HTTP_GET_VARS['not_iview']) ? urldecode($HTTP_GET_VARS['not_iview']) : urldecode($HTTP_POST_VARS['not_iview']);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META content="text/html; charset=windows-1252" http-equiv=Content-Type>
<STYLE>
INPUT{ font-size:10px; color:#330099; height:20; border-color:#000000; border-width:1}
</STYLE>
<BODY>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
<tr>
	<td>
		
<?
while ($select_res = bx_db_fetch_array($select_query))
{
?>
		<table align="center" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff" width="100%">
		<tr>
			<td align="center">
				<a href="<?=HTTP_SERVER_ADMIN."admin_firstpage_select_category_images.php?cat_id=".$HTTP_GET_VARS['cat_id']."&insert=1&img_id=".$select_res['img_id']?>"><img src="<?=HTTP_INCOMING.$select_res['little_img_name']?>" border="0" alt=""></a>
			</td>
			<td align="center">
<?
if($select_res = bx_db_fetch_array($select_query)){
?>
				<a href="<?=HTTP_SERVER_ADMIN."admin_firstpage_select_category_images.php?cat_id=".$HTTP_GET_VARS['cat_id']."&insert=1&img_id=".$select_res['img_id']?>"><img src="<?=HTTP_INCOMING.$select_res['little_img_name']?>" border="0" alt=""></a>
<?}else
{
	echo "&nbsp;";
}?>
			</td>
		</tr>
		<table>
<?
}
?>
	</td>
</tr>
<table>
