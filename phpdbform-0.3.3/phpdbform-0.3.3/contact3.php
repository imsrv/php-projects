<?php
// Please do not edit --- BEGIN
include("phpdbform/phpdbform_core.php");
check_auth();
// Please do not edit --- END

$table1 = "width='500'";		// External table
$table2 = "width='400'";		// Internal tables

$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
$formdb = new phpdbform( $db, "contact", 2, "name", "email", "cod" );

// Uncomment these to don't show
//$formdb->show_select_form = false;
//$formdb->show_edit_button = false;
//$formdb->show_delete_button = false;

$formdb->add_filter_textbox( "name LIKE '%%val%%'", "Filter name", 20, 40, 2);
$formdb->add_textbox( "name", "Name", "auto", 2);
$formdb->add_textbox( "email", "E-mail", "auto", 1);
$formdb->add_listbox( "type", "Contact type", 1, "type","cod","type","type");
$formdb->add_textarea( "obs", "Notes", 40, 10, 2 );

print_header("contacts");
$formdb->draw();
echo "<hr>";
print_logos();
print_tail();

?>
