<?php
$fields = array (
		"company" => array("%%employer_company%%" , "Employer Company Name", "Test Company"),
        "jobtitle" => array("%%job_jobtitle%%" , "Job Title", "Accounting Manager"),
		"jobid" => array("%%job_jobid%%" , "Job ID", "15"),
		"jobdate" => array("%%job_jobdate%%" , "Job Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"jobexpire" => array("%%job_expiredate%%" , "Job Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"job_remaining" => array("%%job_remaining%%" , "Remaining Days Until Expiration", NOTIFY_EMPLOYER_JOB_EXPIRE_DAY),
		"description" => array("%%job_description%%" , "Job Description", "The description of the job"),
		"location" => array("%%job_location%%" , "Job Location", "USA"),
		"jobcategory" => array("%%job_category%%" , "Job Category", "Customer Service"),
        "degree" => array("%%job_degree%%" , "Job Degree", "Master"),
		"jobtype" => array("%%job_jobtype%%" , "Job Employment Type", "Full Time - Part Time"),
		"job_salary" => array("%%job_salary%%" , "Job Salary", bx_format_price("10000",PRICE_CURENCY,0)),
		"city" => array("%%job_city%%" , "Job City", "City Name"),
		"province" => array("%%job_province%%" , "Job Province", "Province Name"),
		"job_skills" => array("%%job_skills%%" , "Job Skill", "manager, sales"),
		"experince" => array("%%job_experience%%" , "Job Year of experience", "2"),
		"joblink" => array("%%job_link%%" , "Job Link", "http://www.yourjobsite.com/view.php?job_id=15"),
		"resumeid" => array("%%resume_resumeid%%" , "RESUME ID", "15"),
		"resumedate" => array("%%resume_resumedate%%" , "Resume Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
		"resumeexpire" => array("%%resume_expiredate%%" , "Resume Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
        "resume_remaining" => array("%%resume_remaining%%" , "Remaining Days Until Expiration", NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager"),
        "resume" => array("%%resume_resume%%" , "Jobseeker Resume", "Jobseeker resume"),
        "resume_jobcategory" => array("%%resume_jobcategory%%" , "Resume Categories", "Administrative - Customer Service"),
        "resume_skills" => array("%%resume_skills%%" , "Resume Skills", "manager, sales"),
        "resume_jobtype" => array("%%resume_jobtype%%" , "Resume Employment Type", "Full Time - Part Time"),
        "salary" => array("%%resume_salary%%" , "Resume Preferred Salary", bx_format_price("10000",PRICE_CURENCY,0)),
        "education" => array("%%resume_education%%" , "Education", "Jobseeker Education"),
        "experience" => array("%%resume_experience%%" , "Years of Experience", "7"),
        "workexperience" => array("%%resume_workexperience%%" , "Work Experience", "Jobseeker Work Experience"),
        "resume_degree" => array("%%resume_degree%%" , "Resume Degree", "Master"),
        "resume_location" => array("%%resume_location%%" , "Preferred Location", "USA"),
		"resumelink" => array("%%resume_link%%" , "Resume Link", "http://www.yourjobsite.com/view.php?resume_id=15"),
        "resume_download" => array("%%resume_download%%" , "Resume File Download Link - If available", "http://www.yourjobsite.com/login.php?login=employer&from=downlaod&resume_id=12"),
		"today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Weekly ResumeMail!";
$html_mail = "no";
$add_mail_signature = "on";
$repeat_code = true;
$message_note = "All text between &lt;BEGIN REPEAT&gt; &lt;END REPEAT&gt; will be repeated for all the resume matches found in the database. Example: if a job has 3 resume matches, only 1 email will be sent to the employer, containing all the information about the 3 resumes. All the information regarding the matched resume have to be placed between these 2 tags (&lt;BEGIN REPEAT&gt; &lt;END REPEAT&gt;), e.g. %%resume_summary%%, %%resume_link%% etc.";
?>