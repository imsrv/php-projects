<?php
// Please do not edit --- BEGIN
include("phpdbform/phpdbform_core.php");
check_auth();
// Please do not edit --- END

$table1 = "width='500'";		// External table
$table2 = "width='400'";		// Internal tables

$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
$formdb = new phpdbform( $db, "photos", 1, "name", "name", "cod" );

// Uncomment these to don't show
//$formdb->show_select_form = false;
//$formdb->show_edit_button = false;
//$formdb->show_delete_button = false;

$formdb->add_textbox( "name", "Name", "auto", 1 );
$formdb->add_image( "image", "Image", 1 );

print_header("photos");
$formdb->draw();
echo "<hr>";
print_logos();
print_tail();

?>
