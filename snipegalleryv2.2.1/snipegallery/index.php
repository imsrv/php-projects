<?php
$PAGE_TITLE="Snipe Photo Gallery";

?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo "$PAGE_TITLE"; ?></title>


<?php
include ("header.php");
$urlaction=urlencode($action);
?>
<table width="100%" border="0">
<tr>
	<td align="right"><?php
	 print_menu($cat_id); 
	?><?php make_search(); ?></td>
</tr>
<tr>
<td>

<?php
if ((!isset($action)) && (!isset($category)) &&  (!isset($id))) {
	if ($use_dropdowns!="1") {
	print "<table width=\"100%\"><tr><td align=\"left\">";
	print_text_menu($cat_id);
	print "</td></tr></table>";
	}

?>

<?php

} elseif (($action=="images") || ($action=="text listing")) {
show_me_the_images($cat_id); 
}
?>
</td></tr></table>
<?php
include ("footer.php");
?>