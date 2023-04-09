<?
include_once "config.php";

$fname=str_replace("'","''",$_REQUEST["fname"]);
$lname=str_replace("'","''",$_REQUEST["lname"]);
$email=str_replace("'","''",$_REQUEST["email"]);
if(isset($_REQUEST["url"])&&$_REQUEST["url"]<>"")
$url=str_replace("'","''",$_REQUEST["url"]);
else
$url=" ";
$title=str_replace("'","''",$_REQUEST["title"]);
$comments=str_replace("'","''",$_REQUEST["comments"]);

mysql_query("INSERT INTO sbwmd_feedback (fname,lname,email,url,title,comment) 
VALUES('$fname','$lname','$email','$url','$title','$comments')");

header("Location:"."feedback.php?msg=".urlencode("Your message has been Forwarded to the administrator. We will very shortly get back to you."));
?>