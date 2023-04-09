<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
		"jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager"),
		"jobid" => array("%%job_jobid%%" , "Job ID", "15"),
		"jobdate" => array("%%job_jobdate%%" , "Job Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"viewed" => array("%%job_viewed%%" , "Job Viewed Number", "120"),
		"lastdate" => array("%%job_lastdate%%" , "Job LAST Viewed Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"description" => array("%%job_description%%" , "Job Description", "The description of the job"),
		"location" => array("%%job_location%%" , "Job Location", "USA"),
		"jobcategory" => array("%%job_category%%" , "Job Category", "Administrative"),
		"degree" => array("%%job_degree%%" , "Job Degree", "Master"),
		"jobtype" => array("%%job_jobtype%%" , "Job Employment Type", "Full Time - Part Time"),
		"salary" => array("%%job_salary%%" , "Job Salary", bx_format_price("10000",PRICE_CURENCY,0)),
		"city" => array("%%job_city%%" , "Job City", "City Name"),
		"province" => array("%%job_province%%" , "Job Province", "Province Name"),
		"skills" => array("%%job_skills%%" , "Job Skill", "manager, sales"),
		"experince" => array("%%job_experience%%" , "Job Year of experience", "2"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Ha caducado su empleo enviado!";
$html_mail = "no";
$add_mail_signature = "on";
?>