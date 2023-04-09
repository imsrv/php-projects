<?php
$fields = array (
		"name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
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
$file_mail_subject = "JobMail semanal!";
$html_mail = "no";
$add_mail_signature = "on";
$repeat_code = true;
$message_note = "All text between &lt;BEGIN REPEAT&gt; &lt;END REPEAT&gt; will be repeated for all the job matches found in the database. Example: if a resume has 3 job matches, only 1 email will be sent to the jobseeker, containing all the information about the 3 jobs. All the information regarding the matched job have to be placed between these 2 tags (&lt;BEGIN REPEAT&gt; &lt;END REPEAT&gt;), e.g. %%job_title%%, %%job_link%% etc.";
?>