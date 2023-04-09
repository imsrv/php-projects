<?

// print out the sql statements for error checking purposes
// ----------------------------------------------
// ERROR CHECKING
// ----------------------------------------------
function error_checking($sql="")
{
        global $sql;
		global $print_sql;
       if ($print_sql=="1") 
print "<span class=\"query\"><b>Query Statement</b>: $sql<br></span>";
}


// ----------------------------------------------
// SEARCH BOX
// ----------------------------------------------

// create the search box
function make_search($id="")
{
global $keyword;
print '<table><form method="get" action="search.php"><tr><td><b>Keyword Search</b><br><input type="text" name="keyword" value="'.$keyword.'">&nbsp;<input type="submit" name="action" value="search"></td></tr></form></table>';       
}

// ----------------------------------------------
// PRINT OUT THUMBNAIL ALBUMS
// ----------------------------------------------

function show_me_the_images($cat_id="")
{
global $cfg_site_home, $cfg_admin_home, $action, $cfg_per_page, $cfg_max_cols, $is_admin, $cfg_thumb_width, $cfg_table_width, $sql, $cfg_thumb_path, $cfg_resize_gifs, $cfg_use_resampling, $screen, $pages;
global $HTTP_GET_VARS; 
extract ($GLOBALS); 
$GLOBALS["cat_id"];


if ($is_admin=="1") {
$cfg_site_home=$cfg_admin_home;
}

// find out what category we're in
$sql = "SELECT name, description FROM snipe_gallery_cat";
	if (!empty($cat_id)) {
	$sql .=	" where id='$cat_id'";
	}
				
	$getcat = mysql_query($sql);
	list($cat_name, $cat_description) = mysql_fetch_row($getcat);
	mysql_free_result($getcat);
	// if we're in a category, print out the name, otherwise print "view all"
		if (!empty($cat_id)){ 
		echo "<h4>$cat_name</h4><p>$cat_description";
		} else {
		echo "<h4>View All</h4> ";
		}
	
$sql = "SELECT * FROM snipe_gallery_data";
	if (!empty($cat_id)) {
	$sql .=	" where cat_id='$cat_id'";
	}

$result = mysql_query($sql);
$total_records = mysql_num_rows($result);
$pages = ceil($total_records / $cfg_per_page);

mysql_free_result($result);
// DEBUGGING CODE - UNCOMMENT TO VIEW QUERY
// print "<br>$sql<br>Total: $total_records ";


		// get the image information
		if (!isset($screen)){
		  $screen = 0;
		}
		$start = $screen * $cfg_per_page;
		$sql =	'SELECT id, title, filename, cat_id, publish FROM snipe_gallery_data';
			if ($cat_id!="") {
			$sql .=	" where cat_id='$cat_id'";
				if ($is_admin!="1") {
				$sql .=	" and publish='y'";
				}
			} else	if ($cat_id=="") {
			// if we're in admin mode, print out the suppressed images too
			if ($is_admin!="1") {
				$sql .=	" where publish='y'";
				}
			}
		$sql .=	" order by cat_id asc, date desc, title asc";
		$sql .= " LIMIT $start, $cfg_per_page";

		$photo = mysql_query($sql);
	//	print "$sql";
		$x = 1;
?>
		<center><table border="0" cellpadding="0" cellspacing="4" width="<?php echo "$cfg_table_width"; ?>">
<?php
		print_pages_list($screen);

		error_checking($sql);
		?>
		</p></td></tr><tr><td align="center" valign="top">
			<?php


	$total_images=mysql_num_rows($photo);
	if ($total_images=="0") {
		print "There are no images currently loaded into this category";
		} else {
			if (($action=="text listing") || ($action=="text+listing")) {
		print "<b>Title</b></td><td><b>Filename</b></td><td><b>File Size</b></td>";
		if ($is_admin=="1") {
		print "<td><b>Action</b></td>";
		}
		print "</tr>";
		}
		
		while (list($photo_id, $photo_title, $photo_filename, $photo_cat_id, $photo_published) = mysql_fetch_row($photo)) {
		$picweight=filesize($cfg_fullsizepics_path."/".$photo_filename);
		if ($picweight >= 1073741824) { 
		$picweight = round($picweight / 1073741824 * 100) / 100 . "g"; 
		} elseif ($picweight >= 1048576) { 
		$picweight = round($picweight / 1048576 * 100) / 100 . "m"; 
		} elseif ($picweight >= 1024) { 
		$picweight = round($picweight / 1024 * 100) / 100 . "k"; 
		} else { 
		$picweight = $picweight . "b"; 
		} 
		
		// if the view is the text only listing, print out the titles and links
		if (($action=="text listing") || ($action=="text+listing")) {
		echo '<tr><td><b><span align="left"><a href="view.php?photo_id='.$photo_id.'&screen='.$screen.'&cat_id='.$cat_id.'&action=text+listing">'.$photo_title.'</a></span></b>&nbsp;&nbsp;&nbsp;</td><td><span class="imgtitle">'.$photo_filename.'</span></td><td><span class="imgtitle">'.$picweight.' </span></td><td>';
				if ($is_admin=="1") {
				print '<a href="index.php?photo_id='.$photo_id.'&action=edit&cat_id='.$cat_id.'"><img src="img/mag.gif" width="18" height="18" border=0 alt="edit"></a> <a href="index.php?photo_id='.$photo_id.'&action=delete&cat_id='.$cat_id.'"><img src="img/delete.gif" width="24" height="11" border=0 alt="delete"></a>';
				}
	print '&nbsp;</td></tr>'; 
		} else {
		// otherwise, print out the thumbnails
						if (file_exists($cfg_thumb_path."/".$photo_filename)) {
						$image_stats = GetImageSize($cfg_thumb_path."/".$photo_filename); 
						$new_w = $image_stats[0]; 
						$new_h = $image_stats[1]; 
						$if_thumb="yes";
						} elseif ((!file_exists($cfg_thumb_path."/".$photo_filename)) && (file_exists($cfg_fullsizepics_path."/".$photo_filename))) {
						$image_stats = GetImageSize($cfg_fullsizepics_path."/".$photo_filename); 
						$imagewidth = $image_stats[0]; 
						$imageheight = $image_stats[1]; 
						$img_type = $image_stats[2]; 
						$new_w = $cfg_thumb_width; 
						$ratio = ($imagewidth / $cfg_thumb_width);
						$new_h = round($imageheight / $ratio);
						$cfg_thumb_url=$cfg_fullsizepics_url;				
						$if_thumb="no";
						} elseif ((!file_exists($cfg_thumb_path."/".$photo_filename)) && (!file_exists($cfg_fullsizepics_path."/".$photo_filename))) {
						$photo_filename="none.gif";
						}	// end if file exists		
				echo '<br><a href="view.php?photo_id='.$photo_id.'&screen='.$screen.'&cat_id='.$cat_id.'&action=images"><img src="'.$cfg_thumb_url.'/'.$photo_filename.'" border="'.$cfg_img_border.'" height="'.$new_h.'" width="'.$new_w.'" alt="'.$photo_title.'" class="photos"></a><br><span class="imgtitle" align="center">'.$photo_title.'&nbsp;';
							if (($show_thumb_stats=="1") && ($is_admin=="1"))  {
								print '<br>H:'.$new_h.' x W:'.$new_w.'<br>Thumb? '.$if_thumb.'<br>';
							}
							if ($photo_published=="y"){
							$published="yes";
							} else {
							$published="no";
							}				
							// if we're in admin mode, print out the admin links to edit, delete, etc, and whether
							// or not it's a published image
							if ($is_admin=="1") {
							print "Published:$published<br>";
							print '[<a href="index.php?photo_id='.$photo_id.'&action=edit&cat_id='.$cat_id.'">edit</a>] [<a href="index.php?photo_id='.$photo_id.'&action=delete&cat_id='.$cat_id.'">delete</a>]';
							}
						print ' </span>'; 


		} // end list vs text listing
		if (($action!="text listing") && ($action!="text+listing")) {
					if (($x % $cfg_max_cols) == 0) {
							echo "</td></tr>\n<tr><td valign=\"top\" align=\"center\">&nbsp;";
						} else {
							echo "&nbsp;</td><td valign=\"top\" align=\"center\">&nbsp;";
						}
						$x++;
		} // endif action
			}

		}

		?>
		</td></tr><tr><td colspan="<?php echo "$cfg_max_cols"; ?>"><b><span class="smallnote"><?php if ($is_admin=="1") print "** some thumbnails may not be generated, due to system limitations. The fullsize image is being used it's place for preview.  (May the fleas of 1000 camels infest the armpits of the jerks at Unisys.)";  ?></span></b></td></tr>
		<?php

		print_pages_list($cat_id);

		error_checking($sql);
		?>
		</p></td></tr></table></center><br>
		<?php

			if ($cat_id=="0") {
			print "<p class=\"error\">Sorry!  This is a top level category, and does not contain images.  Please choose a subcategory.</p>";
			print_text_menu($cat_id);
			}

}
  
// ----------------------------------------------
// PRINT OUT DROP DOWN MENU
// ----------------------------------------------

function print_menu($cat_id="")
{

global $cfg_site_home;
global $is_admin;
			print "<table>\n<form method=get action=\"index.php\"><tr><td><b>Select A Category</b>:\n<tr><td align=\"right\">";
			$sql =	"SELECT id, name FROM snipe_gallery_cat where cat_parent='0' order by name";
			$cat = mysql_query($sql);
				
			print "<select name=\"cat_id\"><option value=\"\">View All</option>\n";
			while (list($cat_id, $cat_name) = mysql_fetch_row($cat)) {
					$cat_name=strtoupper($cat_name);
					echo "<option value=\"\">---$cat_name---</option>\n";
					$sql =	"SELECT id, name FROM snipe_gallery_cat where cat_parent='$cat_id' order by name ";
					// print "$sql";
					$subcat = mysql_query($sql);					
					while (list($subcat_id, $subcat_name) = mysql_fetch_row($subcat)) {
					$subcat_num=mysql_num_rows($subcat);
							if ($subcat_num!="0"){
							echo "<option value=\"$subcat_id\">";
							echo "&nbsp;&#149; $subcat_name</option>\n";
							}
					

					}
					mysql_free_result($subcat);
			}
			print "</select>\n<input type=\"submit\" value=\"images\" name=\"action\">&nbsp;<input type=\"submit\" value=\"text listing\" name=\"action\"></td></tr></form></table>\n";
			
			mysql_free_result($cat);
}


// ----------------------------------------------
// PRINT ADMIN MENU
// ----------------------------------------------

function print_admin_menu($cat_id="")
{
global $cat_id;
		if ($cat_id!="") {
		print "<table class=\"subadmin\"><tr><td><h4>Section Admin</h4><b><a href=\"index.php?action=add&cat_id=$cat_id\">Add Image to This Category</a></b><br>";
		print "</td><tr></table>";
		}

		make_search();

return $cat_id;

}

// ----------------------------------------------
// PRINT TEXT MENU
// ----------------------------------------------
function print_text_menu($cat_id="")
{  

global $is_admin;
global $cfg_site_home;
			$sql =	"SELECT id, name FROM snipe_gallery_cat where cat_parent='0' order by name";
			$cat = mysql_query($sql);
			while (list($cat_id, $cat_name) = mysql_fetch_row($cat)) {

					echo "<h3>$cat_name  ";
					if ($is_admin=="1") {
					print "<a href=\"index.php?action=edit+cat&cat_id=$cat_id\"><img src=\"img/mag.gif\" width=\"18\" height=\"18\" border=0 alt=\"edit\"></a><a href=\"index.php?action=delete+cat&cat_id=$cat_id\"><img src=\"img/delete.gif\" width=\"24\" height=\"11\" border=0 alt=\"delete\"></a>";
					}	
					print "</h3>  \n";
					$sql =	"SELECT id, name, description FROM snipe_gallery_cat where cat_parent='$cat_id' order by name ";
					// print "$sql";
					$subcat = mysql_query($sql);					
					while (list($subcat_id, $subcat_name, $subcat_description) = mysql_fetch_row($subcat)) {
					$subcat_num=mysql_num_rows($subcat);
							if ($subcat_num!="0"){
							echo "<li><b><a href=\"index.php?cat_id=$subcat_id&action=images\">$subcat_name</a></b>";
							if ($is_admin=="1") {
							print " - <a href=\"index.php?action=edit+cat&cat_id=$subcat_id\"><img src=\"img/mag.gif\" width=\"18\" height=\"18\" border=0 alt=\"edit\"></a><a href=\"index.php?action=delete+cat&cat_id=$subcat_id\"><img src=\"img/delete.gif\" width=\"24\" height=\"11\" border=0 alt=\"delete\"></a>";
							}
							print " <br>$subcat_description<br><br>";
							}
					

					}
					mysql_free_result($subcat);
			}
			mysql_free_result($cat);

}

// ----------------------------------------------
// PRINT IMAGE UPLOAD FORM
// ----------------------------------------------
function print_image_form($photo_id="")
{

        global $cat_id;
		global $photo_id;
		global $action;
		global $cfg_fullsizepics_url;
		global $cfg_fullsizepics_path;
		global $cfg_thumb_path;
		
		// if we're editing, get the image details

		if ($action=="edit") {
			$sql =	"SELECT id, title, filename, details, author, location, date, keywords, publish FROM snipe_gallery_data where id='$photo_id'";
			$getpic = mysql_query($sql);
			list($photo_id, $photo_title, $photo_filename, $photo_details, $photo_author, $photo_location, $photo_date, $photo_keywords, $photo_publish) = 			mysql_fetch_row($getpic);
		}

		print "<form action=\"index.php\" method=\"post\"  enctype=\"multipart/form-data\">\n";
		print "<table border=\"0\">";
		
		// if we're adding an image, print the browse box
		if ($action=="add"){
		print "<tr><td align=\"right\"><b>Upload Image:</b></td><td><input type=\"file\" name=\"filename\" size=\"35\"></td></tr>\n";
		

		} elseif (($action=="edit") && (file_exists($cfg_fullsizepics_path.'/'.$photo_filename))){
		// if we're editing, and there is a thumbnail, let's get some info about it.
		// the code below gets the image size and filesize
		$image_stats = GetImageSize($cfg_fullsizepics_path."/".$photo_filename); 
		$imagesize = $image_stats[3];
		$image_height = round($image_stats[1]);
		$image_width = round ($image_stats[0]);
		$picweight=filesize($cfg_fullsizepics_path."/".$photo_filename);
		if ($picweight >= 1073741824) { 
		$picweight = round($picweight / 1073741824 * 100) / 100 . "g"; 
		} elseif ($picweight >= 1048576) { 
		$picweight = round($picweight / 1048576 * 100) / 100 . "m"; 
		} elseif ($picweight >= 1024) { 
		$picweight = round($picweight / 1024 * 100) / 100 . "k"; 
		} else { 
		$picweight = $picweight . "b"; 
		} 
		print '<tr><td align="center" colspan="2"><img src="'.$cfg_fullsizepics_url.'/'.$photo_filename.'" '.$imagesize.' alt="'.$photo_title.'"></td></tr>';
		}
		print '<tr><td align="right"><b>Date:</b></td><td><input type="text" name="date" size="10" value="'.$photo_date.'"> (yyyy-mm-dd)</td></tr>';
		print '<tr><td align="right"><b>Title:</b></td><td><input type="text" name="title" size="30" value="'.$photo_title.'"></td></tr>';
		print '<tr><td align="right"><b>Details:</b><br><font size="-2" face="arial, helvetica">[<A HREF="javascript:alert(\'HTML QUICK HELP MENU\n\nBOLD - <b>text</b>\nITALIC - <i>text</i>\nCENTER - <center>text</center>\nHARD SPACES - &amp;nbsp; &amp;nbsp;\nLINE BREAK - <br>\nDOUBLE BREAK - <p>text text</p>\')")">HTML QuickHelp</A>]</font></td><td><textarea name="details" cols="30" rows="5" wrap="virtual">' .$photo_details.'</textarea></td></tr>';
		print '<tr><td align="right"><b>Location:</b></td><td><input type="text" name="location" size="30" value="'.$photo_location.'"></td></tr>';
		print '<tr><td align="right"><b>Photographer:</b></td><td><input type="text" name="author" size="30" value="'.$photo_author.'"></td></tr>';
		print '<tr><td align="right"><b>Search Keywords:</b></td><td><input type="text" name="keywords" size="30" value="'.$photo_keywords.'"> (hidden)</td></tr>';

			if ($action=="edit") {
			
			print '<tr><td align="right"><b>Image Stats:</b></td><td><i>Height: '.$image_height.' <br>Width: '.$image_width.'<br>Filesize: '.$picweight.'</i></td></tr>';
			
			print "<tr><td align=\"right\"><b>Thumbnail Status:</b></td><td>";

					// check if thumbnail exists
					if (!file_exists($cfg_thumb_path.'/'.$photo_filename)) {
					
					}
		print "<i>created</i>";	
		}
		print "<tr><td align=\"right\"><b>Publish:</b></td><td><input type=\"checkbox\" name=\"publish\" value=\"y\"";
		
		// check if image is currently live
		if ($action=="edit"){
			if ($photo_publish=="y"){
			print " checked> (currently online)\n";
			} else {
			print "> (currently offline)\n";
			}
		} elseif ($action=="add") {
		print " checked>\n";
		}

		print "</td></tr><tr><td align=\"right\">&nbsp;</td><td>";
		if ($action=="add") {
		print "<input type=\"submit\" name=\"action\" value=\"save new image\">";
		} elseif ($action=="edit") {
		print "<input type=\"submit\" name=\"action\" value=\"update image data\">";
		}
		print '<input type="hidden" name="photo_id" value="'.$photo_id.'"><input type="hidden" name="cat_id" value="'.$cat_id.'"></td></tr></table></form>';
		
}


// ----------------------------------------------
// SAVE IMAGE DATA
// ----------------------------------------------
// saves the image information
function save_image($photo_id="")
{

        global $photo_id;
		global $title;
		global $date;
		global $details;
		global $author;
		global $location;
		global $action;
		global $publish;
		global $filename;
		global $cat_id;
		global $keywords;
		global $cfg_fullsizepics_url;
		global $cfg_thumb_url;
		global $cfg_fullsizepics_path;
		global $cfg_site_home, $cfg_admin_home, $cfg_per_page, $cfg_max_cols, $is_admin, $cfg_thumb_width, $cfg_table_width, $cfg_thumb_path, $cfg_resize_gifs, $cfg_use_resampling;

		if (empty($photo_id)) {
		$sql =	"INSERT INTO snipe_gallery_data (title, date, details, author, location, publish, cat_id, keywords) " .
			"VALUES ('$title', '$date', '$details', '$author', '$location', '$publish', '$cat_id', '$keywords')";
		$addpic=mysql_query($sql);
		$sql2 =	"select last_insert_id() from snipe_gallery_data";
		$getid=mysql_query($sql2);
		list($new_id) = mysql_fetch_row($getid); 
		mysql_free_result($getid);
		
				// upload image data
				IF (($filename!="none") || ($filename!="")) {
				copy($filename,"$cfg_fullsizepics_path"."/"."$new_id".".gif");
				$size = GetImageSize("$cfg_fullsizepics_path"."/"."$new_id".".gif");
				IF ($size[2]=="2") {
				$imagename="$new_id".".jpg";
				} ELSEIF ($size[2]=="1") {
				$imagename = "$new_id".".gif";
				} ELSEIF ($size[2]=="3") {
				$imagename = "$new_id".".png";
				} 
		rename("$cfg_fullsizepics_path"."/"."$new_id".".gif", "$cfg_fullsizepics_path"."/"."$imagename");
		$sql3 =	"UPDATE snipe_gallery_data SET filename = '$imagename' WHERE id = '$new_id'";
		$addimage=mysql_query($sql3);
		// print "$sql3<br>";
		unlink($filename);
		
		$sql2 =	"select filename from snipe_gallery_data where id='$new_id'";
		$getid=mysql_query($sql2);
		list($photo_filename) = mysql_fetch_row($getid); 
		mysql_free_result($getid);


		$image_stats = GetImageSize($cfg_fullsizepics_path."/".$photo_filename); 
		$imagewidth = $image_stats[0]; 
		$imageheight = $image_stats[1]; 
		$img_type = $image_stats[2]; 
		$new_w = $cfg_thumb_width; 
		$ratio = ($imagewidth / $cfg_thumb_width);
		$new_h = round($imageheight / $ratio);
						
		// if the page is designated admin, AND the thumbnail does not already exist, start the dynamic thumbnailing routines

		/* ------------------------------------------------------------------------------------------------
		/* NOTE: 5/15/2001 - AG
		/* ------------------------------------------------------------------------------------------------
		/* add variable for imageresizedbicubic
		/* ------------------------------------------------------------------------------------------------
		*/

				if (($is_admin=="1") && (!file_exists($cfg_thumb_path."/".$photo_filename)))  {	
					// if image is a jpeg, copy it as a jpeg
						if ($img_type=="2") {
						// dynamic thumbnailing
						$src_img = imagecreatefromjpeg($cfg_fullsizepics_path."/".$photo_filename); 
						$dst_img = imagecreate($new_w,$new_h); 
						imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img)); 
						imagejpeg($dst_img, "$cfg_thumb_path"."/$photo_filename"); 

						// if image is a png, copy it as a png
						} elseif  ($img_type=="3") {
						// print "png! ";
						$dst_img=ImageCreate($new_w,$new_h); 
						$src_img=ImageCreateFrompng($cfg_fullsizepics_path."/".$photo_filename); 						ImageCopyResized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,ImageSX($src_img),ImageSY($src_img)); 
						Imagepng($dst_img, "$cfg_thumb_path"."/$photo_filename"); 

						// if image is neither png nor jpeg (ie, invalid image or a gif file), use the fullsize as the thumbnail
						} elseif  ($img_type=="1") {
						// if you have set the config to use gif resizing, copy thumbnail gif
								if ($cfg_resize_gifs=="1") {
								$dst_img=ImageCreate($new_w,$new_h); 
								$src_img=ImageCreateFromGif($cfg_fullsizepics_path."/".$photo_filename); 	
							ImageCopyResized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,ImageSX($src_img),ImageSY($src_img)); 
								ImageGif($dst_img, "$cfg_thumb_path"."/$photo_filename"); 
								print "grr!!";
								} else {
								$cfg_thumb_url=$cfg_fullsizepics_url;
								}
							} else {
							$cfg_thumb_url=$cfg_fullsizepics_url;
							} // end if resize_gif
					} // end image_type
					} // end is_admin
			
				

		} elseif (!empty($photo_id)) {
		$sql =	"UPDATE snipe_gallery_data SET title='$title', date='$date', details='$details', author='$author', location='$location', publish='$publish', keywords='$keywords' where id='$photo_id'";
		mysql_query($sql);
// print "$sql";
		}
		

		// print "<br><br>$sql";
		print "<p class=\"error\">Your image information has been saved in the database.</p>";
		if (empty($photo_id)) {
		print "<b>Your <a href=\"$cfg_fullsizepics_url/$imagename\" target=\"_new\">image</a> and <a href=\"$cfg_thumb_url/$imagename\" target=\"_new\">thumbnail</a> has been created.</b>";
		}
		show_me_the_images($cat_id); 
		
}

// ----------------------------------------------
// DELETE IMAGE
// ----------------------------------------------

function print_delete_image($photo_id="")
{

global $screen;
global $cat_id;
global $photo_id;
global $action;
global $cfg_thumb_path;
global $cfg_fullsizepics_path;
			if ($action=="delete") {
			print "<p class=\"error\">Are you SURE you wish to delete this image from the server and remove its information from the database?  (This deletion is irreversible)<br><br><a href=\"index.php?photo_id=$photo_id&action=confirm+delete&cat_id=$cat_id\">Yes, Nuke it!</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?cat_id=$cat_id&action=images&screen=$screen&cat_id=$cat_id\">Ack! No</a></p>";
			} elseif ($action=="confirm delete") {
			$sql1 =	"select filename from snipe_gallery_data where (id='$photo_id')";
			$getfilename=mysql_query($sql1);
			list($photo_filename) = mysql_fetch_row($getfilename); 
			$sql =	"delete from snipe_gallery_data where (id='$photo_id')";
			$delpic=mysql_query($sql);
			$fullsize=$cfg_fullsizepics_path.'/'.$photo_filename;
			$thumb=$cfg_thumb_path.'/'.$photo_filename;

					if (unlink($fullsize)) {
					print "<b>Fullsize image deleted.<b></b><br>";
					}
					if (unlink($thumb)) {
					print "<b>Thumbnail image deleted.<b><br></b>";
					}
			print "<p class=\"error\">Deletion completed successfully.  All associated images and database information has been removed.</p>";
			mysql_free_result($getfilename);
			show_me_the_images($cat_id);
			}
}
// ----------------------------------------------
// PAGE NUMBERING
// ----------------------------------------------

function print_pages_list($screen="")
{
global $screen, $pages, $cfg_site_home, $cfg_admin_home, $action, $cfg_per_page, $cfg_max_cols, $is_admin, $cfg_thumb_width, $cfg_table_width, $sql, $cfg_thumb_path, $cfg_resize_gifs, $cfg_use_resampling, $urlaction, $x;
global $HTTP_GET_VARS; 
extract ($GLOBALS); 
$GLOBALS["cat_id"];
$GLOBALS["screen"];
$GLOBALS["pages"];
	?>
		<tr><td colspan="<?php echo "$cfg_max_cols"; ?>" align="right"><p class="pagenums">Pages: 
<?php
// let's create the dynamic links now
$action=urldecode($action);
$action=urlencode($action);
if (!isset($screen)){
		  $screen = 0;
		}
		if ($screen > 0) {
		  $prev= $screen - 1;
		  echo "<a href=\"$cfg_site_home?screen=$prev&action=$action&cat_id=$cat_id\">&lt;&lt;</a>\n";
		} 

		// page numbering links now
		for ($i = 0; $i < $pages; $i++) {
		  $display_num= ($i + 1);
			if ($screen==$i){
			 echo " | <b>$display_num</b> | ";
			} else {
		  echo " | <a href=\"$cfg_site_home?screen=$i&action=$action&cat_id=$cat_id\">$display_num</a> | ";
			}

		}
		if ($screen < $pages) {
		  $next = $screen + 1;
		  if ($next < $pages ){
		  echo "<a href=\"$cfg_site_home?screen=$next&action=$action&cat_id=$cat_id\">&gt;&gt;</a>\n";
		  }
		}
		if ($pages > 1){
		echo "<br>($pages pages)<br>";
		} elseif ($pages=="1") {
		echo "<br>($pages page)<br>";
		}

}

// ----------------------------------------------
// PRINT THE CATEGORY FORM
// ----------------------------------------------
function print_cat_form($cat_id="")
{
        global $cat_id;
		global $action;
		if (!empty($cat_id)) {
		$sql =	"SELECT name, description, date, cat_parent FROM snipe_gallery_cat where id='$cat_id'";
			$cat = mysql_query($sql);
			list($cat_name, $cat_desc, $cat_date, $cat_parent_id) = mysql_fetch_row($cat);
			mysql_free_result($cat);
			$cat_name=ereg_replace('"','&quot;',$cat_name);
		} 
		
		print "<form method=post action=\"index.php\">";
		print "<table border=0><tr><td>Category Name:</td><td><input type=\"text\" name=\"name\" value=\"$cat_name\"></td></tr>\n";
		print "<tr><td>Date:</td><td><input type=\"text\" name=\"date\" value=\"$cat_date\"></td></tr>\n";
		print "<tr><td>Description:</td><td><textarea name=\"description\" rows=\"6\" cols=\"40\">$cat_desc</textarea></td></tr>\n";

		print "<tr><td>Category:</td><td><select name=\"cat_parent\">\n";
						$sql =	"SELECT id, name FROM snipe_gallery_cat where cat_parent='0' order by name";
						$catlist = mysql_query($sql);
							if (!empty($cat_id)) {
							print "><option value=\"$cat_parent_id\">Do Not Change</option>";
							} else {
							print "<option value=\"0\">Top Level (No pics)</option>";
							}
								while (list($catlist_id, $catlist_name) = mysql_fetch_row($catlist)){
								print "<option value=\"$catlist_id\">$catlist_name</option>";
								}
						mysql_free_result($catlist);
						if (!empty($cat_id)) {
							print "<option value=\"0\">Switch To Top Level (No Pics)</option>";
							}
			print "</select></td></tr><tr><td>&nbsp;</td><td>\n";
			

		if (!empty($cat_id)) {
		print "<input type=\"submit\" name=\"action\" value=\"save category edits\">";
		print "<input type=\"hidden\" name=\"cat_id\" value=\"$cat_id\">";
		} elseif (empty($cat_id)) {
		
		print "<input type=\"submit\" name=\"action\" value=\"save new category\">";
		}
		print "</td></tr>\n";

		print "</tr></table>";
		print "</form>";

}

// ----------------------------------------------
// SAVE CATEGORY DATA
// ----------------------------------------------

function save_cat($cat_id="")
{
        global $cat_id;
		global $cat_parent;
		global $action;
		global $name;
		global $description;
		global $date;
		if (!empty($cat_id)) {
		$sql =	"update snipe_gallery_cat set name='$name', description='$description', date='$date', cat_parent='$cat_parent' where id='$cat_id'";
		} else {
		$sql =	"insert snipe_gallery_cat (name, description, date, cat_parent) values ('$name', '$description','$date', '$cat_parent')";
		}
		$cat = mysql_query($sql);
//		 print "$sql<br><br>";
print " Your data has been saved.";
print "<br><br><b><a href=\"index.php\">Back</a></b>";
		
		

}

// ----------------------------------------------
// DELETE CATEGORY
// ----------------------------------------------
function print_delete_cat($cat_id="")
{

global $cat_id;
global $action;
global $cfg_fullsizepics_path;
global $cfg_thumb_path;


			if ($action=="delete cat") {

			// determine if the category is empty and notify the user if the category is not empty
			$sql =	"SELECT id FROM snipe_gallery_data where cat_id='$cat_id'";
			$cat = mysql_query($sql);
			$number=mysql_num_rows($cat);
				if ($number > 0) {
				print "<p class=\"error\">STOP!! This category is not empty!  If you choose to delete this category, you will delete all of the images within it!<br><br><a href=\"index.php?action=delete+all+images&cat_id=$cat_id\">I know, delete them all!</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php\">Ack!  No!!!</a></p>";
				show_me_the_images($cat_id);
				} else {
				$sql =	"SELECT id FROM snipe_gallery_cat where cat_parent='$cat_id'";
				$subcat = mysql_query($sql);
				$subcatnumber=mysql_num_rows($subcat);
						if ($subcatnumber > 0) {
						print "<p class=\"error\">STOP!! This category has subcategories!  You must delete all subcategories within this category before you can delete it.<br><br><br><br> </p><p><b><a href=\"index.php\">Back</a></b></p>";
						} else {
						print "<p class=\"error\">Are you SURE you wish to delete this category?  (This deletion is irreversible)<br><br><a href=\"index.php?action=delete+cat+confirmed&cat_id=$cat_id\">Yes, Nuke it</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php\">No</a></p>";
						}
				}
			} elseif ($action=="delete cat confirmed") {
			$sql =	"delete from snipe_gallery_cat where (id='$cat_id')";
			$delcat=mysql_query($sql);
			print "<b>Your category was successfully deleted.</b><br><br><br><b><a href=\"index.php\">Back</a></b>";
			} elseif ($action=="delete all images") {
			$sql =	"SELECT id, filename FROM snipe_gallery_data where cat_id='$cat_id'";
			$cat = mysql_query($sql);

			$sql1 =	"select id, filename from snipe_gallery_data where (cat_id='$cat_id')";
			$getfilename=mysql_query($sql1);
			while (list($photo_id, $photo_filename) = mysql_fetch_row($getfilename)){ 
	//		print "$sql1";
			$sql =	"delete from snipe_gallery_data where (id='$photo_id')";
			$delpic=mysql_query($sql);
			$fullsize=$cfg_fullsizepics_path.'/'.$photo_filename;
			$thumb=$cfg_thumb_path.'/'.$photo_filename;
		//	print "$photo_filename";
		//	print "$fullsize, $thumb";
					if (unlink($fullsize)) {
					print "<b>$photo_filename image deleted.<b></b> - ";
					}
					if (unlink($thumb)) {
					print "<b>$photo_filename thumbnail image deleted.<b><br></b>";
					}
			}
			print "<p class=\"error\">Deletion completed successfully.  All associated images and database information has been removed.</p><p><a href=\"index.php\">Back</a>";
			mysql_free_result($getfilename);
			$sql =	"delete from snipe_gallery_cat where (id='$cat_id')";
			$delcat=mysql_query($sql);

			}

}
?>