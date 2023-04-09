<?php

// print page titles
if ($action=="images") { $PAGE_TITLE="ADMIN: List Images";
} elseif ($action=="text listing") { $PAGE_TITLE="ADMIN: Text Listing";
} elseif ($action=="edit") { $PAGE_TITLE="ADMIN: Edit Image Details";
} elseif ($action=="delete") { $PAGE_TITLE="ADMIN: Delete Image?";
} elseif ($action=="confirm delete") { $PAGE_TITLE="ADMIN: Image Deleted";
} elseif ($action=="add") { $PAGE_TITLE="ADMIN: Add New Image";
} elseif ($action=="save new image") { $PAGE_TITLE="ADMIN: Image Saved";
} elseif ($action=="update image data") { $PAGE_TITLE="ADMIN: Image Data Updated";
} elseif ($action=="") { $PAGE_TITLE="ADMIN: Control Panel";
} elseif ($action=="add cat") { $PAGE_TITLE="ADMIN: Add New Category";
} elseif ($action=="delete cat") { $PAGE_TITLE="ADMIN: Delete Category";
} elseif ($action=="delete all images") { $PAGE_TITLE="ADMIN: Recursive Delete Successful";
} elseif ($action=="delete cat confirmed") { $PAGE_TITLE="ADMIN: Category Deleted";
} elseif ($action=="save new category") { $PAGE_TITLE="ADMIN: New Category Created";
} elseif ($action=="save category edits") { $PAGE_TITLE="ADMIN: Category Updated";
}

// state that the page is an admin page
$is_admin="1";
?><!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo "$PAGE_TITLE"; ?></title>
<?php
include ("header.php");
$urlaction=urlencode($action);

/*------------------------
 if no action print homepage
--------------------------*/
?>

<table width="100%"><tr><td><h3><?php echo "$PAGE_TITLE"; ?></h3><?php 			print_menu($cat_id); ?></b></td><td align="right">
<?php print_admin_menu($cat_id);?><br><b><a href="index.php?action=add+cat">Add New Category</a> | <a href="index.php">Admin Home</a></td></tr></table>
<?php
if ((!isset($action)) && (!isset($category)) &&  (!isset($id))) {
?>
<?php print_text_menu($cat_id); ?></td>
</tr>
</table>
<?php
/*------------------------
get image listings
--------------------------*/

} else {
?>
<?php
}
if (($action=="images") || ($action=="text listing")) {
show_me_the_images($cat_id); 
} elseif (($action=="add") || ($action=="edit")) {
print_image_form($cat_id); 
} elseif (($action=="save new image") || ($action=="update image data")) {
save_image($photo_id); 
} elseif (($action=="delete") || ($action=="confirm delete")) {
print_delete_image($photo_id); 
} elseif (($action=="add cat") || ($action=="edit cat")) {
print_cat_form($cat_id); 
} elseif (($action=="save new category") || ($action=="save category edits")) {
save_cat($cat_id);
} elseif (($action=="delete cat") || ($action=="delete cat confirmed") || ($action=="delete all images")) {
print_delete_cat($cat_id); 
}
include ("footer.php");
?>