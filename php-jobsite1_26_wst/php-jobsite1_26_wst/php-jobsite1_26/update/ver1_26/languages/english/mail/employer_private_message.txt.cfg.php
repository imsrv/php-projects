<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
		"jemail" => array("%%jobseeker_email%%" , "Jobseeker Email Address", "john@doe.com"),
		"jaddress" => array("%%jobseeker_address%%" , "Jobseeker Address", "Some address"),
		"jcity" => array("%%jobseeker_city%%" , "Jobseeker City", "Mycity"),
		"jprovince" => array("%%jobseeker_province%%" , "Jobseeker Province", "MyProvince"),
		"jpostalcode" => array("%%jobseeker_postalcode%%" , "Jobseeker PostalCode", "123456"),
		"jphone" => array("%%jobseeker_phone%%" , "Jobseeker Phone Number", "123456789"),
		"jlocation" => array("%%jobseeker_country%%" , "Jobseeker Country", "USA"),
		"jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager"),
		"jobid" => array("%%job_jobid%%" , "Job ID", "15"),
        "private_message" => array("%%private_message%%" , "Jobseeker Private Message", "Some message typed by the jobseeker"),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager"),
        "resume" => array("%%resume_resume%%" , "Jobseeker Resume", "Jobseeker resume"),
        "resume_jobcategory" => array("%%resume_jobcategories%%" , "Resume Categories", "Administrative - Customer Service"),
        "skills" => array("%%resume_skills%%" , "Resume Skills", "manager, sales"),
        "resume_jobtype" => array("%%resume_jobtypes%%" , "Resume Employment Type", "Full Time - Part Time"),
        "salary" => array("%%resume_salary%%" , "Resume Preferred Salary", bx_format_price("10000",PRICE_CURENCY)),
        "education" => array("%%resume_education%%" , "Education", "Jobseeker Education"),
        "experience" => array("%%resume_experience%%" , "Years of Experience", "7"),
        "workexperience" => array("%%resume_workexperience%%" , "Work Experience", "Jobseeker Work Experience"),
        "resume_degree" => array("%%resume_degree%%" , "Degree", "Master"),
        "resume_location" => array("%%resume_location%%" , "Preferred Location", "USA"),
        "resume_link" => array("%%resume_link%%" , "Resume Link", "http://www.yourjobsite.com/login.php?login=employer&from=view&resume_id=12")
);
$file_mail_subject = "Private Message from Jobseeker - %%jobseeker_name%%";
$html_mail = "no";
$add_mail_signature = "on";
?>