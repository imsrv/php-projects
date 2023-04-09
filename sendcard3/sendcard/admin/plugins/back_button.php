<?php
 
$plugin_name = "back_button";
$plugin_description = "Inserts a back button using javascript on the preview screen.";
$plugin_installed = 0;
$plugin_installed_msg = "Plugin installed successfully!";
$plugin_uninstalled_msg = "Plugin uninstalled.";

$plugin_edit = "";
$plugin_set_variables = 1;


$plugin_original_code[0] = "/*** plugin preview_send_button ***/";
$plugin_replacement_code[0] = "/*** BEGIN back_button ***/\n\$send_button .= \"<input type=\\\"button\\\" name=\\\"back_button\\\" value=\\\"$button_label\\\" onClick=\\\"javascript:history.go(-1);\\\">\";\n/*** END back_button ***/";


// Dirty hack, ut I can't think of any other way of doing it!
if(!function_exists(plugin_set_variables)) {
function plugin_set_variables() {
	echo('The label to appear on the button: <input type="text" value="Go Back" name="button_label">');
}
}

if ($action == "help") {
?>
Sorry, no help is available.

<?php
}
?>
