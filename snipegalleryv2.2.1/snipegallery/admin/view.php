<?php
$PAGE_TITLE="List Image Data";
?><!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>View Image - <?php echo "$PAGE_TITLE"; ?></title>
<?php
include ("header.php");
$urlaction=urlencode($action);
?>
</td></tr>
<tr><td>
<table width="100%">
<tr>
	<td><h3>Image Details</h3></td>
	<td align="right"><?php print_menu($cat_id); ?><?php make_search(); ?></td>
</tr>
</table>
			<center><table width="500">
<tr><td colspan="2">
			<?php
	$sql =	"SELECT id, title, filename, details, author, location, date FROM snipe_gallery_data where id='$photo_id'";
	$getpic = mysql_query($sql);
	list($photo_id, $photo_title, $photo_filename, $photo_details, $photo_author, $photo_location, $photo_date) = mysql_fetch_row($getpic);
		
	// get the height and width tags for the image
	$image_stats = GetImageSize($cfg_fullsizepics_path."/".$photo_filename); 
	$imagesize = $image_stats[3]; 
		echo '<h4>'.$photo_title.'</h4>&nbsp;</td></tr><tr><td colspan="2"><center><img src="'.$cfg_fullsizepics_url.'/'.$photo_filename.'" '.$imagesize.' alt="'.$photo_title.'"></td></center></tr><tr><td colspan="2"><p>'.$photo_details.'&nbsp;</p></td></tr>';
	if ($photo_author!="") {
	echo "<tr><td><b>Photographer:</b></td><td>$photo_author</td><tr>";
	}
	if ($photo_location!="") {
	echo "<tr><td><b>Location:</b></td><td>$photo_location</td><tr>";
	}
	if (($photo_date!="") && ($photo_date!="0000-00-00")){
	echo "<tr><td><b>Date:</b></td><td>$photo_date</td><tr>";
	} 
	echo "<tr><td>&nbsp;</td><td>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;</td><tr>";


			mysql_free_result($getpic);
?>

</table></center>
<br><br>
<?php
$urlaction= urlencode($action);
$keywordencode= urlencode($keyword);
if ($action=="search"){
$cfg_site_home="search.php";
}
?>
<b><a href="index.php?screen=<?php echo "$screen"; ?>&cat_id=<?php echo "$cat_id"; ?>&action=<?php echo "$urlaction"; ?>&keyword=<?php echo "$keywordencode"; ?>">&lt;&lt; Back</a></b>
<?php
include ("footer.php");
?>