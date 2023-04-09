<?php
// Please do not edit --- BEGIN
include("phpdbform/phpdbform_core.php");
check_auth();
// Please do not edit --- END

// database and db_host come from siteconfig.inc
// AuthName and AuthPasswd come from menu.php (cookies)

$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
$formdb = new phpdbform( $db, "type", 1, "type", "type", "cod" );

// Uncomment these to don't show
//$formdb->show_select_form = false;
//$formdb->show_edit_button = false;
//$formdb->show_delete_button = false;

$formdb->add_textbox( "type", "Type", "auto", 1 );
$formdb->add_checkbox( "business", "Business Related ?", 1 );

print_header("types");
$formdb->draw();
echo "<hr>";
print_logos();
print_tail();

?>