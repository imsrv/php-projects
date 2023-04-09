<?php
$fields = array (
        "name" => array("%%jobseeker_name%%" , "Jobseeker Name", "John Doe"),
        "resumedate" => array("%%resume_resumedate%%" , "Resume Post Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
        "resumeexpire" => array("%%resume_expiredate%%" , "Resume Expire Date", bx_format_date(date('Y-m-d'), DATE_FORMAT)),
        "resume_remaining" => array("%%resume_remaining%%" , "Remaining Days Until Expiration", NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY),
        "summary" => array("%%resume_summary%%" , "Resume Summary", "Account manager"),
        "today" => array("%%today_date%%" , "Today's Date", bx_format_date(date('Y-m-d'), DATE_FORMAT))
);
$file_mail_subject = "Curriculum enviado adecuadamente!";
$html_mail = "no";
$add_mail_signature = "on";
?>