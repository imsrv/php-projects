<?php
$fields = array (
		"persid" => array("%%jobseeker_persid%%" , "Jobseeker ID", "11",""),
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe",""),
		"gender" => array("%%jobseeker_gender%%" , "Jobseeker Gender", "M",""),
		"birthyear" => array("%%jobseeker_birthyear%%" , "Jobseeker Birthyear", "1970",""),
		"address" => array("%%jobseeker_address%%" , "Jobseeker Address", "Some street #No",""),
		"city" => array("%%jobseeker_city%%" , "Jobseeker City", "City Name",""),
		"province" => array("%%jobseeker_province%%" , "Jobseeker Province", "My Province",""),
		"postalcode" => array("%%jobseeker_zipcode%%" , "Jobseeker Zip Code", "90054",""),
		"locationid" => array("%%jobseeker_location%%" , "Jobseeker Location", "USA","location"),
		"phone" => array("%%jobseeker_phone%%" , "Jobseeker Telephone", "0312999111",""),
		"url" => array("%%jobseeker_url%%" , "Jobseeker URL/Website", "http://www.johndoe.com",""),
        "email" => array("%%jobseeker_email%%" , "Jobseeker Email Address", "john@doe.com",""),
		"password" => array("%%jobseeker_password%%" , "Jobseeker Password", "password",""),
		"signupdate" => array("%%jobseeker_signupdate%%" , "Jobseeker Signup Date", bx_format_date(date('Y-m-d'), DATE_FORMAT),"date")
);
$db_name = "Jobseekers";
?>