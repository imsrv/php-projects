<?php
#### Name of this file: latest.php 
#### Shows the 10 latest users

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// Grab the 10 latest users
$latest = mysql_query("SELECT * FROM $redir_table ORDER BY time DESC LIMIT 0,10") or die (mysql_error());

while ($latest_array = mysql_fetch_array($latest)) {
	$hostname1 = stripslashes($latest_array[host]);
	if($latest_array[active] == "on") {
		$subdomains .= "<a href=\"http://$hostname1\" target=\"_blank\">$hostname1</a><br>";
		}
	else {
		$subdomains .= "(*)  $hostname1<br>";
		}
	$date=$latest_array[time];
	$date = date($dateformat, $date);
	$registrationdate .= "$date<br>";
	}

###########################
#### The latest screen       ####
###########################

$template = new MyredTemplate("html/$theme/latest.html");
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
$template->assign("text_172", $text_172);
$template->assign("text_173", $text_173);
$template->assign("subdomains", $subdomains);
$template->assign("registrationdate", $registrationdate);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
?>