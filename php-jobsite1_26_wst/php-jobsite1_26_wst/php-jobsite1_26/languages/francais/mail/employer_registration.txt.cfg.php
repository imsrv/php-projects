<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
        "email" => array("%%employer_email%%" , "Employer Email Address", "mycompany@whatever.com"),
        "password" => array("%%employer_password%%" , "Employer Password", "password")
);
$file_mail_subject = "Registration Confirmation - %%employer_company%%";
$html_mail = "no";
$add_mail_signature = "on";
?>