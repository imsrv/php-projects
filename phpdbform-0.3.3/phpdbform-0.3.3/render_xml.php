<?php 

$stack = array();
$depth = 0;
$db_handle = 0;
$form_handle = 0;

$callback_init = array(
		"project" => "project_init",
		"db" => "db_init",
		"page" => "page_init",
		"form" => "form_init",
		"control" => "control_init"
		);

$callback_exit = array(
		"form" => "form_exit"
		);

function code_exec($args)
{
	$newfunc = create_function('', $args);
	$newfunc();
}

function project_init($args)
{
	global $db_handle, $AuthName, $AuthPasswd;
	global $theme, $site_title, $img_header, $body_color, $body_background;

#$img_header = "logo.jpg";
#$body_color = "#FFFFFF";
#$body_background = "back.jpg";

	$db_handle = new phpdbform_db( $args["dbname"], $args["dbhost"], $AuthName, $AuthPasswd);
	$db_handle->connect($args["dbname"]);
	include("phpdbform/msg_".$args["language"].".inc.php");

	if ($args["logo"] == "true")
		define("SHOW_LOGO", true);

	if ($args["tailmsg"])
		define("TAIL_MSG", $args["tailmsg"]);

	if ($args["authtype"])
		define("AUTHDBFORM", $args["authtype"]);

	if ($args["title"])
		$site_title=$args["title"];

	if ($args["theme"])
		$theme=$args["theme"];
}

function db_init()
{}

function page_init()
{}

function form_init($args)
{
	global $form_handle, $db_handle;

	if ($args["datasource"])
	{
		$form_handle = new phpdbform( $db_handle, $args["datasource"], $args["columns"], $args["fields"], $args["sortby"], $args["keyfield"]);
	}
	else //render form without data
	{
		$form_handle = new phpdbform( $db_handle, "", $args["columns"], "", "", "");
		$form_handle->show_select_form = false;
		$form_handle->show_edit_button = false;
		$form_handle->show_delete_button = false;
	}
	print_header($args["caption"]);

}

function form_exit($args)
{
	global $form_handle;

	$form_handle->draw();
	echo "<hr>";
	print_logos();
	print_tail();
}

function control_init($args)
{
	global $form_handle;


	switch($args["type"])
	{
		case "link":
			$handle = $form_handle->add_link_button( $args["caption"], $args["target"], $args["description"], $args["size"], $args["span"]);break;
		case "textbox":
			$handle = $form_handle->add_textbox( $args["field"], $args["caption"], $args["size"], 48, $args["span"]);break;
		case "listbox":
			$handle = $form_handle->add_listbox( $args["field"], $args["caption"], $args["span"], $args["fieldselection"], $args["keyfield"], $args["sortby"], $args["rowsource"] );break;
		case "fixed_combobox":
			$handle = $form_handle->add_combobox_fixed( $args["field"], $args["caption"], $args["options"], $args["span"]);break;
		case "textarea":
			$handle = $form_handle->add_textarea( $args["field"], $args["caption"], $args["columns"], $args["rows"], $args["span"] );break;
		case "checkbox":
			$handle = $form_handle->add_checkbox( $args["field"], $args["caption"], $args["span"] );break;
		default:
			echo "APP error:Unknown control type: ". $args["type"]."<br>";break;
	}
	if ($args["disabled"] == true)
		$form_handle->set_control_disabled($handle, true);
                        
	if ($args["readonly"] == true)
		$form_handle->set_control_readonly($handle,true);

}

function startElement($parser, $name, $attrs)
{
	global $depth;
	global $stack;
	global $callback_init;
	global $pagename;

	$skip_element = false;
/*
	print "Start: $name (".$callback_init[$name].") <br>";
	if ($depth)
	{
		print "Parent type: ".$stack[$depth-1]["element"];
		while (list ($key, $val) = each ($stack[$depth-1]["attributes"])) {
    			echo "$key => $val<br>";
	}
	print "<br>";
}
*/

#TODO: more elegant solution, less global variables

	if ($name == "page" && $attrs["name"] != $pagename)
		$skip_element = true;

	if (($name == "form") && ($stack[$depth-1]["attributes"]["name"] != $pagename))
		$skip_element = true;

	if (($name == "control") && ($stack[$depth-2]["attributes"]["name"] != $pagename))
		$skip_element = true;

//These are both the same;
	if ($callback_init[$name] && !$skip_element)
		$callback_init[$name]($attrs);
#		call_user_func($callback_init[$name], $attrs);


//	array_push($stack, $name);
	$stack[$depth]=array("element" => $name, "attributes" => $attrs);
	$depth++;
}

function endElement($parser, $name)
{
	global $depth;
	global $stack;
	global $callback_exit;
	global $pagename;

	$skip_element = false;

	if ($name == "page" && $attrs["name"] != $pagename)
		$skip_element = true;
	
	if (($name == "form") && ($stack[$depth-1]["attributes"]["name"] != $pagename))
		$skip_element = true;

	if (($name == "control") && ($stack[$depth-2]["attributes"]["name"] != $pagename))
		$skip_element = true;


//	print "$name (".$callback_exit[$name].") ";
	if ($callback_exit[$name] && !$skip_element)
		call_user_func($callback_exit[$name], $attrs);

	$stack[$depth]="";
	$depth--;
//	array_pop($stack);
}

function unknownElement($parser, $name)
{
	global $depth;
	print "Unknown element:$name<br>";
}	

function cData($parser, $data)
{
	global $depth;
	global $stack;
	global $pagename;

	if (($stack[$depth-1]["element"] == "code") && ($stack[$depth-2]["attributes"]["name"] == $pagename)) code_exec($data);

#	if ($data[0] > chr(13))
#		print "Data=$data<br>";
}

function fail()
{
#	echo "fail";
}

function ok()
{
#	Header("Location:index.php");
}

include("phpdbform/phpdbform_core.php");
check_auth("fail", "ok");

//$table1 = "width='20'";               // External table
//$table2 = "width='10'";               // Internal tables

if (!isset($filename))
	$filename = "default.xml";

if (!isset($pagename))
	$pagename = "main";

$xml_parser = xml_parser_create();
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0);
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "cData");
if (!($fp = @fopen($filename, "r"))) {
    die("APP error: could not open XML input file: $file");
}

while ($data = fread($fp, 4096)) {
    if (!xml_parse($xml_parser, $data, feof($fp))) {
        die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}
xml_parser_free($xml_parser);
       
?>