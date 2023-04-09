<?php
$plugin_name = "stats_plugin";
$plugin_description = 'Install the code necessary to use the statistics plugin';
$plugin_installed = 0;
$plugin_installed_msg = "Plugin installed successfully!";
$plugin_uninstalled_msg = "Plugin uninstalled.";

$plugin_edit = "";
$plugin_set_variables = 0;

$plugin_original_code[0] = "/*** plugin send_loop ***/";
$plugin_replacement_code[0] = "/*** BEGIN stats_plugin ***/\n	if(\$use_stats == 1){\n	     \$stat_date = date(\"Ymd:His\");\n	     \$sql = \"INSERT INTO \" . \$tbl_name . \"_stats (date, image, fontcolor, fontface, bgcolor, template, des, music, notify, immediate_send, applet_name) VALUES ('\$stat_date','\$image','\$fontcolor','\$fontface', '\$bgcolor', '\$template', '\$des', '\$music', '\$notify', '\$emailsent', '\$applet_name')\";\n	     \$db->query(\$sql);\n		}\n/*** END stats_plugin ***/";

if ($action == "help") {
?>
Sorry, no help is available.

<?php
}
?>
