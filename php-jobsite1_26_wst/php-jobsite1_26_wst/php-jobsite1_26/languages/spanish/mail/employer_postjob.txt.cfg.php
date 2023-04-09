<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
		"jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager"),
		"jobid" => array("%%job_jobid%%" , "Job ID", "15"),
		"jobdate" => array("%%job_jobdate%%" , "Job Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"jobexpire" => array("%%job_expiredate%%" , "Job Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"remaining" => array("%%job_remaining%%" , "Remaining Days Until Expiration", NOTIFY_EMPLOYER_JOB_EXPIRE_DAY),
		"joblink" => array("%%job_link%%" , "Job Link", "http://www.yourjobsite.com/view.php?job_id=15"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Se ha enviado su Empleo adecuadamente!";
$html_mail = "no";
$add_mail_signature = "on";
?>