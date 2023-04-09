<?php
// General config
include("phpdbform/msg_common.inc.php");

include("phpdbform/msg_enus.inc.php");	// English
//include("phpdbform/msg_sp.inc.php");	// Spanish
//include("phpdbform/msg_ptbr.inc.php");	// Portuguese Brazil
//include("phpdbform/msg_fr.inc.php");	// French
//include("phpdbform/msg_de.inc.php");	// German
//include("phpdbform/msg_it.inc.php");	// Italian
//include("phpdbform/msg_pl.inc.php");	// Polish
//include("phpdbform/msg_pt.inc.php");	// Portuguese Portugal
//include("phpdbform/msg_da.inc.php");	// Danish

// comment these to don't show
define("SHOW_LOGO", true);				// Shows phpDBform logo
define("TAIL_MSG", "Look at siteconfig.inc for configuration"); // tail message
// uncomment below to use cookies instead of php sessions.
define("AUTHDBFORM","session");
//define("AUTHDBFORM", "cookies");


// Site config
$site_title = "Test Site";
$img_header = "logo.jpg";
$theme = "templ01";
//$theme = "simple";

$db_engine = "phpdbform_dp.php"; // MySQL
//$db_engine = "phpdbform_db_psql.php"; // PostgreSQL

$db_host = "localhost:3306";
$database = "phpdbform";
$show_errors = true; // set to false to don't print the db errors messages, only phpdbform msgs
?>
