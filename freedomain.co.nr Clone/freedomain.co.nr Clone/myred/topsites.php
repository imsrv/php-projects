<?php
#### Name of this file: topsites.php 
#### Shows the top 10 subdomains and their hits

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// Grab the top 10 users
$top = mysql_query("SELECT * FROM $redir_table WHERE active='on' ORDER BY counter DESC LIMIT 0,10") or die (mysql_error());

while ($top_array = mysql_fetch_array($top)) {
	$hostname1 = stripslashes($top_array[host]);
	$subdomains .= "<a href=\"http://$hostname1\" target=\"_blank\">$hostname1</a><br>";
	$hits .= "$top_array[counter]<br>";
	}

###########################
#### The latest screen       ####
###########################

$template = new MyredTemplate("html/$theme/topsites.html");
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
$template->assign("text_174", $text_174);
$template->assign("subdomains", $subdomains);
$template->assign("hits", $hits);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
?>