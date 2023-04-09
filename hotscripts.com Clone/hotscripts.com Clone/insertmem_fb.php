<?
include_once "config.php";
/////////////getting null char
$null_char=mysql_fetch_array(mysql_query("select null_char from sbwmd_config"));

$uid=$_REQUEST["uid"];
$fname=str_replace("'","''",$_REQUEST["fname"]);
$lname=str_replace("'","''",$_REQUEST["lname"]);
$email=str_replace("'","''",$_REQUEST["email"]);
if(isset($_REQUEST["url"])&&$_REQUEST["url"]<>"")
$url=str_replace("'","''",$_REQUEST["url"]);
else
$url="";
$title=str_replace("'","''",$_REQUEST["title"]);
$comments=str_replace("'","''",$_REQUEST["comments"]);

mysql_query("INSERT INTO sbwmd_member_feedback (fname,lname,email,url,title,comment,uid) 
VALUES('$fname','$lname','$email','$url','$title','$comments',$uid)");

header("Location:"."userhome.php?msg=".urlencode("Your message has been Forwarded to the administrator we will very shortly get back to you."));
?>