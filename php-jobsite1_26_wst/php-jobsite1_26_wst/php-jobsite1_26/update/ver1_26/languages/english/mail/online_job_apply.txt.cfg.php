<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
		"jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager"),
		"jobid" => array("%%job_jobid%%" , "Job ID", "15"),
        "apply_message" => array("%%cover_letter%%" , "Cover Letter", "Some message typed by the jobseeker"),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager"),
        "resume" => array("%%resume_resume%%" , "Jobseeker Resume", "Jobseeker resume"),
        "resume_jobcategory" => array("%%resume_jobcategories%%" , "Resume Categories", "Administrative - Customer Service"),
        "skills" => array("%%resume_skills%%" , "Resume Skills", "manager, sales"),
        "resume_jobtype" => array("%%resume_jobtypes%%" , "Resume Employment Type", "Full Time - Part Time"),
        "salary" => array("%%resume_salary%%" , "Resume Preferred Salary", bx_format_price("10000",PRICE_CURENCY,0)),
        "education" => array("%%resume_education%%" , "Education", "Jobseeker Education"),
        "experience" => array("%%resume_experience%%" , "Years of Experience", "7"),
        "workexperience" => array("%%resume_workexperience%%" , "Work Experience", "Jobseeker Work Experience"),
        "resume_degree" => array("%%resume_degree%%" , "Degree", "Master"),
        "resume_location" => array("%%resume_location%%" , "Preferred Location", "USA"),
        "resume_link" => array("%%resume_link%%" , "Resume Link", "http://www.yourjobsite.com/login.php?login=employer&from=view&resume_id=12"),
        "resume_download" => array("%%resume_download%%" , "Resume File Download Link - If available", "http://www.yourjobsite.com/login.php?login=employer&from=downlaod&resume_id=12")
);
$file_mail_subject = "Job Apply";
$html_mail = "no";
$add_mail_signature = "on";
?>