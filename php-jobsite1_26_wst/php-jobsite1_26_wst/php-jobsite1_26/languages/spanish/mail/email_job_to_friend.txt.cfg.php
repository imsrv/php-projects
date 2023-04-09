<?php
$fields = array (
		"visitor_name" => array("%%visitor_name%%" , "VisItor Name", "John Doe"),
		"visitor_email" => array("%%visitor_email%%" , "VisItor Email", "johndoe@test.com"),
		"visitor_message" => array("%%visitor_message%%" , "VisItor typed message", "Message to my friend."),
		"friend_name" => array("%%friend_name%%" , "Friend Name", "Doe Friend"),
		"friend_email" => array("%%friend_email%%" , "Friend Email", "doefriend@test.com"),
		"jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager"),
		"jobid" => array("%%job_jobid%%" , "Job ID", "15"),
		"jobdate" => array("%%job_jobdate%%" , "Job Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"jobexpire" => array("%%job_expiredate%%" , "Job Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"remaining" => array("%%job_remaining%%" , "Remaining Days Until Expiration", NOTIFY_EMPLOYER_JOB_EXPIRE_DAY),
		"description" => array("%%job_description%%" , "Job Description", "The description of the job"),
		"location" => array("%%job_location%%" , "Job Location", "USA"),
		"jobcategory" => array("%%job_category%%" , "Job Category", "Customer Service"),
		"degree" => array("%%job_degree%%" , "Job Degree", "Master"),
		"jobtype" => array("%%job_jobtype%%" , "Job Employment Type", "Full Time - Part Time"),
		"salary" => array("%%job_salary%%" , "Job Salary", bx_format_price("10000",PRICE_CURENCY,0)),
		"city" => array("%%job_city%%" , "Job City", "City Name"),
		"province" => array("%%job_province%%" , "Job Province", "Province Name"),
		"skills" => array("%%job_skills%%" , "Job Skill", "manager, sales"),
		"experince" => array("%%job_experience%%" , "Job Year of experience", "2"),
		"joblink" => array("%%job_link%%" , "Job Link", "http://www.yourjobsite.com/view.php?job_id=15"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Su amigo \"%%visitor_name%%\" encontró un empleo qu etal vez le interese!";
$html_mail = "no";
$add_mail_signature = "on";
?>
