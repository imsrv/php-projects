<?
include_once "config.php";

$sid=$_REQUEST["sid"];
$fname=str_replace("'","''",$_REQUEST["fname"]);
$lname=str_replace("'","''",$_REQUEST["lname"]);
$useremail=str_replace("'","''",$_REQUEST["useremail"]);
$no_of_friends=str_replace("'","''",$_REQUEST["no_of_friends"]);
$friend_list="";
$cnt=0;
while($no_of_friends>$cnt)
{
$cnt++;
 if($cnt==1)
 $friend_list.=str_replace("'","''",$_REQUEST["friend_email".$cnt]);
 else
 $friend_list.=",".str_replace("'","''",$_REQUEST["friend_email".$cnt]);
}

mysql_query("INSERT INTO sbwmd_email_id (fname,lname,useremail,friend_email,no_of_friends,sid) 
VALUES('$fname','$lname','$useremail','$friend_list',$no_of_friends,$sid)");

header("Location:"."software-description.php?id=".$sid."&msg=".urlencode("successfully sent email to ur friends"));
?>