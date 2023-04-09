<?php
 
$plugin_name = "join_mailinglist";
$plugin_description = 'SAMPLE PLUGIN!!! This will install code adding the sender of the postcard to the mailing list.';
$plugin_installed = 0;
$plugin_installed_msg = "Plugin installed successfully!";
$plugin_uninstalled_msg = "Plugin uninstalled.";

$plugin_edit = "";
$plugin_set_variables = 1;


$plugin_original_code[0] = "/*** plugin after_send ***/";
$plugin_replacement_code[0] = "/*** BEGIN join_mailinglist ***/\nif( isset(\$join_mailinglist) ){\n\$sql = \"INSERT INTO $join_mailinglist_table VALUES ('\$from', '\$from_email')\";\n\$db->query(\$sql);\n}\n/*** END join_mailinglist ***/";

// Very dirty hack, but I can't think of a better way of doing it!
if(!function_exists(plugin_set_variables)) {
function plugin_set_variables() {
	echo('The name of your mailing list table: <input type="text" value="" name="join_mailinglist_table">');
}
}
if ($action == "help") {
?>
Sorry, no help is available.

<?php
}
?>