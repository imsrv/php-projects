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
if (eregi("email_login_details.php",$_SERVER['PHP_SELF']))
{
 Header("Location: index.php");
 exit;
}
$coname=CO_NAME;

$thesubject="Account setup on $coname - login details enclosed.";
$themessage="Hi

Welcome to $coname, below are your login details for your account with us.

  http://$thedomain/phpautomembersarea/

Click on, or Cut and paste the above Internet address (URL) into the address
bar of your browser and press return (ENTER) on your keyboard.

   Then login using:
 Username:  $their_username
 Password:  $their_password

Please note that these details are CAsE SenSItiVE!

Thank You for taking the time to join us.";
pama_mail($email,$thesubject,$themessage,$contact_email,$contact_email,$thedomain);

$IP_Number = getenv("REMOTE_ADDR");
$User_Agent = getenv("HTTP_USER_AGENT");
$admin_url = "http://$thedomain/phpautomembersarea/".ADMIN_FOLDER."/";
$themessage="This new member has already received login details
as the system is set to auto activate new members.

To administer this new member Login at: $admin_url

 Their IP Address:  $IP_Number
 Their User agent: $User_Agent
 Their name and address:
 $name
 $companyname
 $address
 $state
 $postcode
 $country
 Tel: $tel
 email: $email

 Their comments: $comments";
pama_mail($contact_email,"New member just joined",$themessage,$contact_email,$contact_email,$thedomain);
?>
