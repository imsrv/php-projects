<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
		"subject" => array("%%employer_subject%%" , "Employer subject", "Very interesting resume"),
        "resume_comment" => array("%%employer_comment%%" , "Employer comment", "This jobseeker can apply to my Designer job"),
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
		"address" => array("%%jobseeker_address%%" , "Jobseeker Address", "Some street #No"),
		"city" => array("%%jobseeker_city%%" , "Jobseeker City", "City Name"),
		"province" => array("%%jobseeker_province%%" , "Jobseeker Province", "My Province"),
		"postalcode" => array("%%jobseeker_zipcode%%" , "Jobseeker Zip Code", "90054"),
		"location" => array("%%jobseeker_location%%" , "Jobseeker Location", "USA"),
		"phone" => array("%%jobseeker_phone%%" , "Jobseeker Telephone", "0312999111"),
		"email" => array("%%jobseeker_email%%" , "Jobseeker Email Address", "john@doe.com"),
		"url" => array("%%jobseeker_url%%" , "Jobseeker URL/Website", "http://www.johndoe.com"),
		"resume" => array("%%resume_resumeid%%" , "RESUME ID", "15"),
		"resumedate" => array("%%resume_resumedate%%" , "Resume Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"resumeexpire" => array("%%resume_expiredate%%" , "Resume Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager"),
        "resume" => array("%%resume_resume%%" , "Jobseeker Resume", "Jobseeker resume"),
        "resume_jobcategory" => array("%%resume_jobcategories%%" , "Resume Categories", "Administrative - Customer Service"),
        "skills" => array("%%resume_skills%%" , "Resume Skills", "manager, sales"),
        "resume_jobtype" => array("%%resume_jobtypes%%" , "Resume Employment Type", "Full Time - Part Time"),
        "salary" => array("%%resume_salary%%" , "Resume Preferred Salary", bx_format_price("10000",PRICE_CURENCY,0)),
        "education" => array("%%resume_education%%" , "Education", "Jobseeker Education"),
        "experience" => array("%%resume_experience%%" , "Years of Experience", "7"),
        "workexperience" => array("%%resume_workexperience%%" , "Work Experience", "Jobseeker Work Experience"),
        "degree" => array("%%resume_degree%%" , "Resume Degree", "Master"),
        "resume_location" => array("%%resume_location%%" , "Preferred Location", "USA"),
		"resumelink" => array("%%resume_link%%" , "Resume Link", "http://www.yourjobsite.com/view.php?resume_id=15"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Resume details - %%jobseeker_name%%";
$html_mail = "no";
$add_mail_signature = "";
?>