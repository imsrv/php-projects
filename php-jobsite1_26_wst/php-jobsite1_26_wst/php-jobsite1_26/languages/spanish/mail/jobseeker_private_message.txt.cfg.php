<?php
$fields = array (
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
		"email" => array("%%jobseeker_email%%" , "Jobseeker Email Address", "johndoe@whatever.com"),
        "company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
        "cemail" => array("%%employer_email%%" , "Employer Email Address", "mycompany@whatever.com"),
        "private_message" => array("%%private_message%%" , "Employer Private Message", "Private message typed by employer"),
        "company_link" => array("%%employer_link%%" , "Company Details Link", "http://www.yourjobsite.com/view.php?company_id=15"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Private Message from - %%employer_company%%";
$html_mail = "no";
$add_mail_signature = "on";
?>
