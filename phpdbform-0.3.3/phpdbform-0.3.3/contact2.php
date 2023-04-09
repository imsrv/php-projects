<HTML>
<HEAD>
<TITLE>phpDBform test - only db form</TITLE>
</HEAD>
<body bgcolor="#FFFFFF">

<table width='600' align='center'>
	<tr><td>Testing an inline phpDBform... This is inside a html page, without user login.
	No index, no editing records, no select, only insert button. 
	</td></tr>
	<tr><td>
<?php
include("phpdbform/phpdbform_core.php");

$table2 = "width='400'";		// Internal tables

$db = new phpdbform_db( "phpdbform", "localhost", "root", "" );
// Now the name of the object is not important!
$testform = new phpdbform( $db, "contact", 2, "name", "email", "cod" );

$testform->show_select_form = false; // this is true for default - only here to show this new feature
$testform->show_edit_button = true;  // this is true for default - only here to show this new feature
$testform->show_delete_button = false; // this is true for default - only here to show this new feature

$testform->add_textbox( "name", "Name", "auto", 2);
$testform->add_textbox( "email", "E-mail", "auto", 1);
$testform->add_listbox( "type", "Contact type", 1, "type","cod","type","type");
$testform->add_textarea( "obs", "Notes", 40, 10, 2 );

$testform->draw();

?>
</tr></table>
</BODY>
