<?php
// Please do not edit --- BEGIN
include("phpdbform/phpdbreport_core.php");
check_auth();
// Please do not edit --- END

$table1 = "width='500'";		// External table
$table2 = "width='400'";		// Internal tables

$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
$report = new phpdbreport( $db, "select * from contact", 4);

// header
$handle = $report->add_label( "Name:", 1);
$report->set_control_inheader($handle);

$handle = $report->add_label( "E-mail:", 1);
$report->set_control_inheader($handle);

$handle = $report->add_label( "Sex:", 1);
$report->set_control_inheader($handle);

$handle = $report->add_label( "Type:", 1);
$report->set_control_inheader($handle);

$handle = $report->add_ruler();
$report->set_control_inheader($handle);

//detail
$report->add_textbox( "name", "Name", "auto", 1 );
$report->add_textbox( "email", "E-mail", "auto", 1 );
$report->add_combobox_fixed( "sex", "Sex", "male,female", 1 );
$report->add_listbox( "type", "Contact type", 1, "cod,type","cod","type","type" );

//footer
$handle = $report->add_ruler();
$report->set_control_infooter($handle);

$handle = $report->add_label( "Footer goes here", 1);
$report->set_control_infooter($handle);


print_header("contacts");
$report->draw();
echo "<hr>";
print_logos();
print_tail();

?>
