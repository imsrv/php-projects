<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
        "expire" => array("%%planning_expiredate%%" , "Planning Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
  		"remaining" => array("%%planning_remaining%%" , "Remaining Days Until Expiration", NOTIFY_EMPLOYER_PLANNING_EXPIRE_DAY),
  		"jobs" => array("%%employer_jobs%%" , "Available Jobs Number", "2"),
  		"featuredjobs" => array("%%employer_featuredjobs%%" , "Available Featured Jobs Number", "0"),
  		"contacts" => array("%%employer_consult%%" , "Available Resume Consult Number", "50"),
        "pricing_title" => array("%%planning_title%%" , "Expiring Planning Title", "Standard Plan"),
		"pricing_price" => array("%%planning_price%%" , "Expiring Planning Price", bx_format_price("50",PRICE_CURENCY)),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Va a caducar su Plan de Empleo";
$html_mail = "no";
$add_mail_signature = "on";
?>