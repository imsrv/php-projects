<?php
$PAGE_TITLE="Search Results";
?><!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Snipe Gallery Admin- <?php echo "$PAGE_TITLE"; ?></title>
<?php
include ("header.php");
$urlaction=urlencode($action);
$keywordencode= urlencode($keyword);

// if no action
if ($action!="search") {
?>
<table width="100%" border="0">
<tr>
	<td><h3><?php echo "$PAGE_TITLE";?></h3></td></tr><tr>
	<td align="right"><?php print_menu(); ?><?php make_search(); ?></td>
</tr>
</table>
<?php

} elseif ($action=="search") {
?>
<table width="100%" border="0">
<tr>
	<td><h3>Show Images In Category</h3></td>
	<td align="right"><?php print_menu(); ?><?php make_search(); ?></td>
</tr>
</table>

<?php
	
$sql = "SELECT * FROM snipe_gallery_data";
		$sql .=	" where (keywords LIKE '%$keyword%') OR (title LIKE '%$keyword%') OR (details LIKE '%$keyword%') OR (location LIKE '%$keyword%') OR (date LIKE '%$keyword%') OR (author LIKE '%$keyword%')";
$result = mysql_query($sql);
$total_records = mysql_num_rows($result);
$pages = ceil($total_records / $cfg_per_page);
mysql_free_result($result);
// DEBUGGING CODE - UNCOMMENT TO VIEW QUERY
// print "<br>$sql<br>Total: $total_records ";
		if ($total_records!="0"){
		if (!isset($screen)){
		  $screen = 0;
		}
		$start = $screen * $cfg_per_page;
		$sql =	"SELECT id, title, filename, cat_id FROM snipe_gallery_data";
		$sql .=	" where (keywords LIKE '%$keyword%') OR (title LIKE '%$keyword%') OR (details LIKE '%$keyword%') OR (location LIKE '%$keyword%') OR (date LIKE '%$keyword%') OR (author LIKE '%$keyword%')";
		$sql .=	" order by cat_id";
		$sql .= " LIMIT $start, $cfg_per_page";

		$photo = mysql_query($sql);
		//print "<br>$sql<br>";
		 

		$y = 0;
		$x = 1;
		?>
		<center><table border="0" cellpadding="0" cellspacing="4" width=<?php echo "$cfg_table_width"; ?>">
		<tr><td colspan="<?php echo "$cfg_max_cols"; ?>" align="right"><p class="pagenums">Pages: 
		<?php

		// let's create the dynamic links now
		if ($screen > 0) {
		  $prev= $screen - 1;
		  echo "<a href=\"search.php?screen=$prev&action=$urlaction&keyword=$keywordencode\">&lt;&lt;</a>\n";
		}
		// page numbering links now
		for ($i = 0; $i < $pages; $i++) {
		  $display_num= ($i + 1);
			if ($screen==$i){
			 echo " | <b>$display_num</b> | ";
			} else {
		  echo " | <a href=\"search.php?screen=$i&action=$urlaction&keyword=$keywordencode\">$display_num</a> | ";
			}

		}
		if ($screen < $pages) {
		  $next = $screen + 1;
		  if ($next < $pages ){
		  echo "<a href=\"search.php?screen=$next&action=$urlaction&keyword=$keywordencode\">&gt;&gt;</a>\n";
		  }
		}
		if ($pages > 1){
		echo "<br>($pages pages)<br>";
		} elseif ($pages=="1") {
		echo "<br>($pages page)<br>";
		}


		error_checking($sql);
		?>
		</p></td></tr>
			<?php
			if ($action!="text listing") {
	print "<tr><td>";
		}

	$total_images=mysql_num_rows($photo);
	if ($total_images=="0") {
		print "There are no images currently loaded into this category";
		} else {
		
		while (list($photo_id, $photo_title, $photo_filename) = mysql_fetch_row($photo)) {

		if ($action=="text listing") {
		echo '<tr><td><b><span class="imgtitle"><a href="view.php?photo_id='.$photo_id.'&screen='.$screen.'&cat_id='.$cat_id.'&action='.$urlaction.'">'.$photo_title.'</a></span></b>&nbsp;&nbsp;&nbsp;</td><td><span class="imgtitle">'.$photo_filename.'</span></td><td>&nbsp;</td><td>&nbsp;</td></tr>'; 
		} else {
				if (file_exists($cfg_thumb_path."/".$photo_filename)) {
				$image_stats = GetImageSize($cfg_thumb_path."/".$photo_filename); 
				$imagesize = $image_stats[3]; 

				}	// end if file exists
						echo '<a href="view.php?photo_id='.$photo_id.'&screen='.$screen.'&action='.$urlaction.'&keyword='.$keywordencode.'"><img src="'.$cfg_thumb_url.'/'.$photo_filename.'" border="'.$cfg_img_border.'" alt="'.$photo_title.'" class="photos" '.$imagesize.'></a><br><span class="imgtitle" align="center">'.$photo_title.'<br> [<a href="edit.php?photo_id='.$photo_id.'&action=edit">edit</a>] [<a href="edit.php?photo_id='.$photo_id.'&action=delete">delete</a>]</b></span>'; 

		} // end list vs text listing
		if ($action!="text listing") {
		if (($x % $cfg_max_cols) == 0) {
					echo "</td></tr>\n<tr><td valign=\"top\" align=\"center\">&nbsp;";
				} else {
					echo "&nbsp;</td><td valign=\"top\" align=\"center\">&nbsp;";
				}
				$x++;
		}
			}

		}

		?>
		</td></tr><tr><td colspan="<?php echo "$cfg_max_cols"; ?>" align="right"><p class="pagenums">Pages:
		<?php

		// let's create the dynamic links now
		if ($screen > 0) {
		  $prev= $screen - 1;
		  echo "<a href=\"search.php?screen=$prev&action=$urlaction&keyword=$keywordencode\">&lt;&lt;</a>\n";
		}
		// page numbering links now
		for ($i = 0; $i < $pages; $i++) {
		  $display_num= ($i + 1);
			if ($screen==$i){
			 echo " | <b>$display_num</b> | ";
			} else {
		  echo " | <a href=\"search.php?screen=$i&action=$urlaction&keyword=$keywordencode\">$display_num</a> | ";
			}

		}
	if ($screen < $pages) {
		  $next = $screen + 1;
		  if ($next < $pages ){
		  echo "<a href=\"search.php?screen=$next&action=$urlaction&keyword=$keywordencode\">&gt;&gt;</a>\n";
		  }
		}
		if ($pages > 1){
		echo "<br>($pages pages)<br>";
		} elseif ($pages=="1") {
		echo "<br>($pages page)<br>";
		}
		mysql_free_result($photo);

		error_checking($sql);
		?>
		</p></td></tr></table></center><br>
		<?php
			} else {
			print "<p class=\"error\">Sorry!  There does not appear to be any images that match that criteria!  Please search again.<br><!-- $sql --></p>";
		}
		}  
include ("footer.php");
?>