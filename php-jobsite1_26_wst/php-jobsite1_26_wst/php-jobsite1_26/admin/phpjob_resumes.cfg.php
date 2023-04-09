<?php
$fields = array (
        "resumeid" => array("%%resume_resumeid%%" , "Resume ID", "12",""),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager",""),
        "resume" => array("%%resume_resume%%" , "Jobseeker Resume", "Jobseeker resume",""),
        "jobcategoryids" => array("%%resume_jobcategories%%" , "Resume Categories", "Administrative - Customer Service","jobcategoryids"),
        "skills" => array("%%resume_skills%%" , "Resume Skills", "manager, sales",""),
        "jobtypeids" => array("%%resume_jobtypes%%" , "Resume Employment Type", "Full Time - Part Time","jobtypeids"),
        "salary" => array("%%resume_salary%%" , "Jobseeker Preferred Salary", bx_format_price("10000",PRICE_CURENCY,0),"price"),
        "education" => array("%%resume_education%%" , "Jobseeker Education", "Jobseeker Education",""),
        "experience" => array("%%resume_experience%%" , "Jobseeker Years of Experience", "7",""),
        "workexperience" => array("%%resume_workexperience%%" , "Jobseeker Work Experience", "Jobseeker Work Experience",""),
        "degreeid" => array("%%resume_degree%%" , "Resume Degree", "Master","degree"),
        "locationids" => array("%%resume_location%%" , "Resume Preferred Location", "USA","locationids"),
        "resume_city" => array("%%resume_city%%" , "Resume Preferred City", "City Name",""),
        "resume_province" => array("%%resume_province%%" , "Resume Preferred Province", "Province Name",""),
        "resumedate" => array("%%resume_resumedate%%" , "Resume Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT),"date"),
        "resumeexpire" => array("%%resume_expiredate%%" , "Resume Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT),"date")
);
$db_name = "Resumes";
?>