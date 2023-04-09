<?php
// General config
include("phpdbform/msg_enus.inc.php");	// English

// comment these to don't show
define("SHOW_LOGO", true);				// Shows phpDBform logo
define("TAIL_MSG", "Look at reportconfig.inc for configuration"); // tail message
// uncomment below to use cookies instead of php sessions.
define("AUTHDBFORM","session");
//define("AUTHDBFORM", "cookies");


// Site config
$site_title = "Test Report";
$img_header = "logo.jpg";
$body_color = "#FFFFFF";
//$body_background = "back.jpg";
$theme = "report";

$db_engine = "phpdbform_dp.php"; // MySQL
//$db_engine = "phpdbform_db_psql.php"; // PostgreSQL

$db_host = "localhost:3306";
$database = "phpdbform";
$show_errors = true; // set to false to don't print the db errors messages, only phpdbform msgs
?>
