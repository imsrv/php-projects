<?php

// Please do not edit --- BEGIN
include("phpdbform/phpdbform_core.php");
check_auth();
// Please do not edit --- END

//$table1 = "width='20'";               // External table
//$table2 = "width='10'";               // Internal tables

	function print_controls(&$dblink, &$formdb, $formid)
	{
		global $database, $db_host, $AuthName, $AuthPasswd;
		$qry = "select * from __controls where formid=" . $formid ." and visible='y' order by vertorder;";
		$result = $dblink->query($qry, "Error querying database");

		$totalcontrols = $dblink->num_rows($result);

		// Find out how many kinds of controls are there so that we don't query the
		// database for each control only once for each type.

		$i = 0;
		while ($row = $dblink->fetch_array ($result))
		{		
			$controls[$i++] = $row;
			$types[] = $row["controltype"];
		}      

		$dblink->free_result ($result);

		array_unique($types);

		// Now that we have the types, extract the properties.

		while (list ($key, $val) = each ($types))
		{
			$qry = "select * from __controls_".$val.";";	
			$result = $dblink->query($qry, "Error querying database");
			while ($row = $dblink->fetch_array ($result))
			{
				$controldata[$val][$row["id"]] = $row;
			}
			$dblink->free_result($result);
		}

		// Display the controls		

		for ($idx = 0; $idx < $totalcontrols; $idx++)
		{
			$ctrl = $controldata[$controls[$idx]["controltype"]][$controls[$idx]["ctrlid"]];

			if ($controls[$idx]["controltype"] == "textbox")
			{
				$handle = $formdb->add_textbox( $ctrl["fieldname"], $ctrl["caption"], $ctrl["size"], 48, $ctrl["colspan"] );
			}
			else if ($controls[$idx]["controltype"] == "listbox")
			{
				$handle = $formdb->add_listbox( $ctrl["fieldname"], $ctrl["caption"], $ctrl["colspan"], $ctrl["fieldselection"], $ctrl["keyfield"], $ctrl["orderedby"], $ctrl["rowsource"] );
			}
			else if ($controls[$idx]["controltype"] == "fixed_combo")
			{
				$handle = $formdb->add_combobox_fixed( $ctrl["fieldname"], $ctrl["caption"], $ctrl["options"], $ctrl["colspan"]);
			}
			else if ($controls[$idx]["controltype"] == "textarea")
                        {
                                $handle = $formdb->add_textarea( $ctrl["fieldname"], $ctrl["caption"], $ctrl["cols"], $ctrl["rows"], $ctrl["colspan"] );
                        }
			else if ($controls[$idx]["controltype"] == "link_button")
			{
				$handle = $formdb->add_link_button( $ctrl["caption"],$ctrl["target"],$ctrl["description"],$ctrl["size"],$ctrl["colspan"]);
			}
			else 
			{
				echo "Unknown control type:". $control[$idx]["controltype"]."<br>";
			}

			if ($controls[$idx]["disabled"] == 'y')
				$formdb->set_control_disabled($handle,true);

			if ($controls[$idx]["readonly"] == 'y')
				$formdb->set_control_readonly($handle,true);

		}
	}

function render_form($form,&$link)
{
	global $database, $db_host, $AuthName, $AuthPasswd;

	$qry = "select * from __forms where name = '".$form."';";
	$result = $link->query($qry, "Error query database");

	switch ($link->num_rows($result))
	{
		case 1:
			$row = $link->fetch_array ($result);

			$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
			$formdb = new phpdbform( $db, $row["datasource"], $row["formcolumns"], $row["fieldselection"], $row["sortby"], $row["keyfield"] );
			print_controls($link, $formdb, $row["id"]);
			print_header($row["caption"]);
			$formdb->draw();
			echo "<hr>";
			print_logos();
			print_tail();
		break;
		case 0:
			echo "Form not found<br>\n";
		break;
		default:
			echo "Ambigious form name<br>\n";
		break;
	}

	// Uncomment these to don't show
	//$formdb->show_select_form = false;
	//$formdb->show_edit_button = false;
	//$formdb->show_delete_button = false;
	$link->free_result($result);

}

function render_form_bynum($formnum,&$link)
{
	global $database, $db_host, $AuthName, $AuthPasswd;

	$qry = "select * from __forms where id = '".$formnum."';";
	$result = $link->query($qry, "Error query database");

	switch ($link->num_rows($result))
	{
		case 1:
			$row = $link->fetch_array ($result);
			$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
			if ($row["datasource"])
			{
				$formdb = new phpdbform( $db, $row["datasource"], $row["formcolumns"], $row["fieldselection"], $row["sortby"], $row["keyfield"] );
			}
			else
			{
				$formdb = new phpdbform( $db, "", 2, "", "", "" );
				$formdb->show_select_form = false;
				$formdb->show_edit_button = false;
				$formdb->show_delete_button = false;
			}
			print_controls($link, $formdb, $row["id"]);
			print_header($row["caption"]);
			$formdb->draw();
			echo "<hr>";
			print_logos();
			print_tail();
		break;
		case 0:
			echo "Form not found<br>\n";
		break;
		default:
			echo "Duplicate/Ambigious form name<br>\n";
		break;
	}

	// Uncomment these to don't show
	//$formdb->show_select_form = false;
	//$formdb->show_edit_button = false;
	//$formdb->show_delete_button = false;
	$link->free_result($result);
}

/***********
**  Start **
***********/

	if (!isset($pagename))
	{
//		$pagename = "default";
		$pagename = "menu";
	}	

	$link = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd);
	$link->connect("phpdbform");


// General config
include("phpdbform/msg_enus.inc.php");  // English
//include("phpdbform/msg_ptbr.inc.php");        // Portuguese Brazil
//include("phpdbform/msg_fr.inc.php");  // French
//include("phpdbform/msg_de.inc.php");  // German
//include("phpdbform/msg_it.inc.php");  // Italian
//include("phpdbform/msg_pl.inc.php");  // Polish

// comment these to don't show
define("SHOW_LOGO", true);                              // Shows phpDBform logo
define("TAIL_MSG", "Look at siteconfig.inc for configuration"); // tail message
// comment below to don't use cookies, but php auth.
// *** not working yet ***
//define("AUTHDBFORM", "cookies");
// *** not working yet ***

// Site config
$site_title = "Test Site";
$img_header = "logo.jpg";
$body_color = "#FFFFFF";
$body_background = "back.jpg";
$theme = "templ01";
//$theme = "simple";

$db_engine = "phpdbform_dp.php"; // MySQL
//$db_engine = "phpdbform_db_psql.php"; // PostgreSQL

$db_host = "localhost:3306";
$database = "phpdbform";
$show_errors = true; // set to false to don't print the db errors messages, only phpdbform msgs

	$qry = "select * from __pages where name = '".$pagename."';";
	$result = $link->query($qry, "Error query database");
	$row = $link->fetch_array($result);
	$qry = "select * from __page_forms where pageid='". $row["id"] ."' and enabled='y';";
	$link->free_result($result);
	$result2 = $link->query($qry, "Error querying database");

	while ($row = $link->fetch_array ($result2))
	{
		// TODO: figure something for form positioning.
		render_form_bynum($row["formid"],$link);
//		render_form($row["name"],$link);
	}

	$link->close();

?>
     
