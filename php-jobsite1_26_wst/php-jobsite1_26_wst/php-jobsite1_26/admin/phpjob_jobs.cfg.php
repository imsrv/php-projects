<?php
$fields = array (
        "jobid" => array("%%job_jobid%%" , "Job ID", "15",""),
        "jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager",""),
		"description" => array("%%job_description%%" , "Job Description", "The description of the job",""),
		"locationid" => array("%%job_location%%" , "Job Location", "USA","location"),
		"jobcategoryid" => array("%%job_category%%" , "Job Category", "Customer Service","jobcategory"),
        "degreeid" => array("%%job_degree%%" , "Job Degree", "Master","degree"),
		"jobtypeids" => array("%%job_jobtype%%" , "Job Employment Type", "Full Time - Part Time","jobtypeids"),
		"salary" => array("%%job_salary%%" , "Job Salary", bx_format_price("10000",PRICE_CURENCY,0),"price"),
		"city" => array("%%job_city%%" , "Job City", "City Name",""),
		"province" => array("%%job_province%%" , "Job Province", "Province Name",""),
		"skills" => array("%%job_skills%%" , "Job Skills", "manager, sales",""),
		"experience" => array("%%job_experience%%" , "Job Years of experience", "2",""),
		"jobdate" => array("%%job_jobdate%%" , "Job Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT),"date"),
		"jobexpire" => array("%%job_expiredate%%" , "Job Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT),"date"),
		"featuredjob" => array("%%job_featured%%" , "Job Featured", "Y" ,""),
		"contact_name" => array("%%job_contactname%%" , "Job Contact Name", "John Doe" ,""),
		"contact_email" => array("%%job_contactemail%%" , "Job Contact Email", "mycompany@whatever.com" ,""),
		"contact_phone" => array("%%job_contactphone%%" , "Job Contact Phone", "0312999111" ,""),
		"contact_fax" => array("%%job_contactfax%%" , "Job Contact Fax", "0312999111" ,""),
		"job_link" => array("%%job_link%%" , "Job Link", "http://www.yourjobsite.com/view.php?job_id=1" ,"")
);
$db_name = "Jobs";
?>