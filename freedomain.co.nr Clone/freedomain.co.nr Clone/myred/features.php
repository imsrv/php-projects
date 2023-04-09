<?php
#### Name of this file: features.php 
#### simply parses the file "features.html", no other functions included

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

###########################
#### The features.html file              ####
###########################

$template = new MyredTemplate("html/$theme/features.html");
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
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
?>