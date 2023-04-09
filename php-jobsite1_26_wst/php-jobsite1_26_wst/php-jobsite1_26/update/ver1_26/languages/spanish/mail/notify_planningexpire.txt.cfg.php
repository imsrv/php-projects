<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
		"pricing_title" => array("%%planning_title%%" , "Deleted Planning Title", "Standard Plan"),
		"pricing_price" => array("%%planning_price%%" , "Deleted Planning Price", bx_format_price("50",PRICE_CURENCY)),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Ha caducado su Plan de Empleo";
$html_mail = "no";
$add_mail_signature = "on";
?>