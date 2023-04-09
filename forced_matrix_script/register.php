<?php
/* nulled by [GTT] :) */    

include("functions.php");
db_connect();
include ('header.php');
if(@$password&&$email&&$frstname&&$lstname&&$city&&$address&&$zip&&$country)
{
$result=mysql_query("select * from users where email='$email'");
$result=mysql_fetch_array($result);
if($result['email']!=$email){
mysql_query ("insert into users (id,password,email,frstname,lstname, compname, country,city,state,phone,socsec,website,zip,address,referer, signupdate) values('','$password','$email','$frstname','$lstname', '$compname','$country','$city','$state','$phone','$socsec','$website','$zip','$address','".$refid."', '".time()."')");

//adding to the martix
$user_id=mysql_insert_id();
add_new_matrix_entry($user_id);

$result=db_result_to_array("select fromperson, fromemail, subject, message from letters where action='welcome'");
$fromperson=$result[0][0];
$fromemail=$result[0][1];
$subject=$result[0][2];
$message=$result[0][3];
$message=str_replace("[fullname]", "$frstname $lstname", $message);
$message=str_replace("[fname]", $frstname, $message);
$message=str_replace("[lname]", $lstname, $message);
$result=db_result_to_array("select id from users where email='$email'");
$usid=$result[0][0];
$message=str_replace("[maxid]", "$usid", $message);
$message=str_replace("[password]", "$password", $message);
mail($email, $subject, $message, "FROM: $fromperson <$fromemail>");
echo "Registration is completed. You will be notified by e-mail.";

if ($refid)
{
$email=db_result_to_array("select email from users where id='$refid'");
$email=$email[0][0];
$result=db_result_to_array("select fromperson, fromemail, subject, message from letters where action='signbelow'");
$fromperson=$result[0][0];
$fromemail=$result[0][1];
$subject=$result[0][2];
$message=$result[0][3];
$message=str_replace("[fullname]", "$frstname $lstname", $message);
$message=str_replace("[fname]", $frstname, $message);
$message=str_replace("[lname]", $lstname, $message);
mail($email, $subject, $message, "FROM: $fromperson <$fromemail>");
}

}
else echo "You are already registered!";
}
else{
?>


<center>


<b>Complete this form:</b><br>
(** - are required fields)
<br>

<form name="registration" method="get" action="register.php">
<table>
<tr>
        <td>**Email</td>
        <td> <input name="email" type="Text"></td>
</tr>
<tr>
        <td>**Password </td>
        <td> <input name="password" type="Text"></td>
</tr>
<tr>
        <td>**First name </td>
        <td><input name="frstname" type="Text"></td>
</tr>
<tr>
        <td>**Last name</td>
        <td><input name="lstname" type="Text"></td>
</tr>
<tr>
        <td>Company name</td>
        <td><input name="compname" type="Text"></td>
</tr>
<tr>
        <td>**Address</td>
        <td> <input name="address" type="Text"></td>
</tr>
<tr>
        <td>**City</td>
        <td> <input name="city" type="Text"></td>
</tr>
<tr>
        <td>State/**Zip</td>
        <td><input name="state" type="Text"> / <input name="zip" type="Text" size=5></td>
</tr>
<tr>
        <td>**Country</td>
        <td><input name="country" type="Text"></td>
</tr>
<tr>
        <td>Social Security:</td>
        <td><input name="socsec" type="Text"></td>
</tr>
<tr>
        <td>Phone:</td>
        <td><input name="phone" type="Text"></td>
</tr>
<tr>
        <td>Website:</td>
        <td>http://<input name="website" type="Text"></td>
</tr>
</table>

<?
if ($affid&&!$refid)
{
  $cookex=db_result_to_array("select cookex from admininfo");
  $cookex=$cookex[0][0];
  setcookie("refid", $affid, time() + 60*60*24*$cookex, "", "");
}
?>
<br>
<input name="enter" type="Submit" value="Register">
</form></center>
<?}
include ('footer.php');
?>