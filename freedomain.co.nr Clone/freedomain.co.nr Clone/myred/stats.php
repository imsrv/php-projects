<?php
#### Name of this file: stats.php 
#### Shows number of users per subdomain, total number of users and total hits

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// Select the tlds
$tld = mysql_query("SELECT domain FROM $domain_table") or die (mysql_error());

while ($tld_array = mysql_fetch_array($tld)) {
	$tld_1= $tld_array[0];
	$tld_count = mysql_num_rows(mysql_query("SELECT host FROM $redir_table WHERE host LIKE '%$tld_1%'"));
	$subdomains .= "$tld_1<br>";
	$members .= "$tld_count<br>";
	}

// Count all members
$members_total = mysql_query("SELECT COUNT(host) FROM $redir_table") or die (mysql_error());
$members_total = mysql_fetch_array($members_total);
$members_total = $members_total[0];

// Count total hits
$hits_total = 0;
$hits_query = mysql_query("SELECT counter FROM $redir_table") or die (mysql_error());
while ($hits_array = mysql_fetch_array($hits_query)) {
	$hits_total += $hits_array[0];
	}

###########################
#### The stats screen              ####
###########################

$template = new MyredTemplate("html/$theme/stats.html");
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
$template->assign("text_35", $text_35);
$template->assign("text_166", $text_166);
$template->assign("text_167", $text_167);
$template->assign("text_168", $text_168);
$template->assign("text_169", $text_169);
$template->assign("text_170", $text_170);
$template->assign("text_171", $text_171);
$template->assign("subdomains", $subdomains);
$template->assign("members", $members);
$template->assign("members_total", $members_total);
$template->assign("hits_total", $hits_total);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
?>