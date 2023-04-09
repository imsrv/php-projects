<?php
#### Name of this file: dir.php 
#### Shows a member directory sorted by category with clickable links

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// If no "do" is specified, go to the main page
if (!$do) {
	$do = "main";
	}
###########################
#### Browsing categories       ####
###########################
if ($do == 'browse') {
$cat = $_GET["cat"];
$start = $_GET["start"];
// This is the variable for the mysql-query (where to start the query)
if(empty($start) || $start<0) {
	$start=0;
}
// get the number of links in this category
$result=mysql_query("SELECT * FROM $redir_table where cat = '$cat' and active='on'");
$num_links = mysql_num_rows($result);

// the page-forward and backward links, and the pages to click on
$back=$start-$perpage; 
$linkback="<a href=\"dir.php?do=browse&start=$back&cat=$cat\"><b>$text_193</b></a>";
if($back < 0) { 
	$back=0;
	$linkback="$text_193"; 
	}
$forward=$start+$perpage;
$linkforward="<a href=\"dir.php?do=browse&start=$forward&cat=$cat\"><b>$text_194</b></a>";
if($forward>=($num_links)) {
	$linkforward="$text_194";
	}
// The first part of the navigation menu
$menu = "<b>$num_links</b> $text_195</div><br><div align=\"right\">$text_198 $linkback || ";

// the last part of the navigation menu
$menu .=" $linkforward</div>";

if($num_links>0) {
// if links are found, loop for them
$result1=mysql_query("SELECT * FROM $redir_table where cat='$cat' and active='on' ORDER BY counter DESC LIMIT $start, $perpage") or die (mysql_error());

while($row=mysql_fetch_array($result1,MYSQL_ASSOC)) {

// ----- strip the C escape-slashes -----
$host = stripslashes($row[host]);
$descr = stripslashes($row[descr]);
$counter = stripslashes($row[counter]);

$links .= "<p><a href=\"http://www.$host\" target=\"_blank\"><b>www.$host</b></a> $text_89 $counter<br><br><i>$text_45</i> $descr</p><hr width=\"60%\" align=\"left\" noshade>";
	}
} // End links found

else {
// no links found
	$menu = "";
	$links = "$text_196";
}
// Show the links pages
$template = new MyredTemplate("html/$theme/dir2.html");
$template->assign("text_1", $text_1);
$template->assign("text_2", $text_2);
$template->assign("text_3", $text_3);
$template->assign("text_4", $text_4);
$template->assign("text_5", $text_5);
$template->assign("text_6", $text_6);
$template->assign("text_7", $text_7);
$template->assign("text_8", $text_8);
$template->assign("text_9", $text_9);
$template->assign("text_10", $text_10);
$template->assign("text_11", $text_11);
$template->assign("text_12", $text_12);
$template->assign("text_191", $text_191);
$template->assign("text_192", $text_192);
$template->assign("text_197", $text_197);
$template->assign("cat", $cat);
$template->assign("menu", $menu);
$template->assign("links", $links);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
###########################
#### The category overview  ####
###########################
if ($do == 'main') {
// get the categories
$result=mysql_query("SELECT category FROM $category_table order by category");
$num_cats = mysql_num_rows($result);

// display categories in columns 
$categories = "<table width=\"$table_width\" cellpadding=\"0\" cellspacing=\"2\"><tr>";

// loop for columns
for ($k=1; $k<$col_counts+1; $k++) {
	$tdwidth=100/$col_counts;
	$categories .= "<td width=\"$tdwidth%\" valign=\"top\">";
	for ($i=$k-1; $i<$num_cats; $i=$i+$col_counts) {
		$cat_name = stripslashes(mysql_result($result,$i,"category"));
		$links_num=GetNumberOfLinks($cat_name);
		$categories .= "<p><b><a href=\"dir.php?do=browse&cat=$cat_name\">$cat_name</a></b><font size=\"1\"> ($links_num)</font><br>\n";
		$categories .= "</p>\n";
		}
	$categories .= "</td>";
	}
$categories .= "<tr></table>";

// Show the main page, where categories are listed
$template = new MyredTemplate("html/$theme/dir1.html");
$template->assign("text_1", $text_1);
$template->assign("text_2", $text_2);
$template->assign("text_3", $text_3);
$template->assign("text_4", $text_4);
$template->assign("text_5", $text_5);
$template->assign("text_6", $text_6);
$template->assign("text_7", $text_7);
$template->assign("text_8", $text_8);
$template->assign("text_9", $text_9);
$template->assign("text_10", $text_10);
$template->assign("text_11", $text_11);
$template->assign("text_12", $text_12);
$template->assign("text_191", $text_191);
$template->assign("text_192", $text_192);
$template->assign("showcategories", $categories);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>