<?php
$fields = array (
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
		"resumeid" => array("%%resume_resumeid%%" , "RESUME ID", "15"),
		"resumedate" => array("%%resume_resumedate%%" , "Resume Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"resumeexpire" => array("%%resume_expiredate%%" , "Resume Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
        "remaining" => array("%%resume_remaining%%" , "Remaining Days Until Expiration", NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager"),
        "resume" => array("%%resume_resume%%" , "Jobseeker Resume", "Jobseeker resume"),
        "resume_jobcategory" => array("%%resume_jobcategory%%" , "Resume Categories", "Administrative - Customer Service"),
        "skills" => array("%%resume_skills%%" , "Resume Skills", "manager, sales"),
        "resume_jobtype" => array("%%resume_jobtype%%" , "Resume Employment Type", "Full Time - Part Time"),
        "salary" => array("%%resume_salary%%" , "Resume Preferred Salary", bx_format_price("10000",PRICE_CURENCY,0)),
        "education" => array("%%resume_education%%" , "Education", "Jobseeker Education"),
        "experience" => array("%%resume_experience%%" , "Years of Experience", "7"),
        "workexperience" => array("%%resume_workexperience%%" , "Work Experience", "Jobseeker Work Experience"),
        "resume_degree" => array("%%resume_degree%%" , "Degree", "Master"),
        "resume_location" => array("%%resume_location%%" , "Preferred Location", "USA"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Va a caducar su curriculum";
$html_mail = "no";
$add_mail_signature = "on";
?>