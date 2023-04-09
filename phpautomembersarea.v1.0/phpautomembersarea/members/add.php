<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------
include("../functions.php");
include_once("../".$installed_config_file);
db_connect();
// check account type - auto or manual activation?
$result = mysql_query("select * from pama_admin");
$auto_activate = mysql_result($result,0, "auto_activate");
$contact_email = mysql_result($result,0, "contact_email");
$result = mysql_query("select * from pama_members where their_username='$email'");
if (mysql_num_rows($result))
{
 js_msg("Your email address $email is already within our database, please wait for notification.");
 exit;
}
$join_date = time();
if ($auto_activate==1) $activated_date=$join_date;
else $activated_date=-1;
$name = addslashes($name);
$companyname = addslashes($companyname);
$email = addslashes($email);
$address = addslashes($address1." ".$address2);
$country = $country;
$postcode = addslashes($postcode);
$tel = addslashes($tel);
$fax = addslashes($fax);
$heardaboutusfrom = $heardaboutusfrom;
$comments = addslashes($comments);
$their_username = $email;
$their_password = random_password(8);
$md5_password = md5($their_password);
$query = "
   INSERT INTO pama_members VALUES
   ('$join_date',
    '$name',
    '$companyname',
    '$email',
    '$address',
    '$country',
    '$postcode',
    '$tel',
    '$fax',
    '$heardaboutusfrom',
    '$their_username',
    '$md5_password',
    '$comments',
    '$auto_activate',
    '$activated_date')";
$result = mysql_query($query);
if (!$result) js_msg("There has been an error: ".mysql_error() );
db_close();
include("header.html");
$auto_activate_msg="<br><br><br><br><center><strong><big>Your details have been successfully added
 to our database,<br><br>and your account details have been to sent to:<br><br>$email <br>
 <br></big>Please check your email box in the next few moments.<br>
 If your mail server, or ours, is busy the email can take several minutes<br>
 before it is delivered. Please be patient. <br>
 <big><br><br>Thank You for taking the time to join us.</big></strong><br><br></center>";
$other_msg="<br><br><br><br><center><strong><big>Your details have been successfully added
 to our database. <br><br>We will contact you shortly via email to:<br><br> $email <br><br><br><br>
 <br>Thank You for taking the time to join us.</big></strong><br><br><hr width=\"60%\"><br><br>";
if ($auto_activate==1)
{
 include("email_login_details.php");
 echo $auto_activate_msg;
}
else
{
 echo $other_msg;
 include("email_admin_new_member.php");
}
include("footer.html");
?>