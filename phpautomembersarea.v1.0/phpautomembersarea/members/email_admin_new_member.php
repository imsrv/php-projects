<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea � Copyright 2003 Seiretto.com    *
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
if (eregi("email_admin_new_member.php",$_SERVER['PHP_SELF']))
{
 Header("Location: index.php");
 exit;
}
$coname=CO_NAME;
$IP_Number = getenv("REMOTE_ADDR");
$User_Agent = getenv("HTTP_USER_AGENT");
$admin_url = "http://$thedomain/phpautomembersarea/".ADMIN_FOLDER."/";
$themessage="This new member is waiting for login details
as the system is set to MANUAL activation.

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
pama_mail($contact_email,"New member just joined - ACTIVATION required",$themessage,$contact_email,$contact_email,$thedomain);
?>
