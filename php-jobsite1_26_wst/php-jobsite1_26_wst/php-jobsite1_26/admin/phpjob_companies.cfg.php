<?php
$fields = array (
		"compid" => array("%%employer_compid%%" , "Employer Company ID", "11",""),
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company",""),
		"description" => array("%%employer_description%%" , "Employer Description", "Some description",""),
		"address" => array("%%employer_address%%" , "Employer Address", "Some street #No",""),
		"city" => array("%%employer_city%%" , "Employer City", "City Name",""),
		"province" => array("%%employer_province%%" , "Employer Province", "Province Name",""),
		"postalcode" => array("%%employer_postalcode%%" , "Employer Postal Code", "90054",""),
        "locationid" => array("%%employer_location%%" , "Employer Country/Location", "USA","location"),
        "phone" => array("%%employer_phone%%" , "Employer Phone", "0312999111",""),
        "fax" => array("%%employer_fax%%" , "Employer Fax", "0312999111",""),
        "url" => array("%%employer_url%%" , "Employer URL/Website", "http://www.yourcompany.com",""),
        "email" => array("%%employer_email%%" , "Employer Email Address", "mycompany@whatever.com",""),
        "password" => array("%%employer_password%%" , "Employer Password", "password",""),
        "signupdate" => array("%%employer_signupdate%%" , "Employer Signup Date", bx_format_date(date('Y-m-d'), DATE_FORMAT),"date")
);
$db_name = "Employers";
?>