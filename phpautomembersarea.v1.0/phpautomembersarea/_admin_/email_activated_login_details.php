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
if (eregi("email_activated_login_details.php",$_SERVER['PHP_SELF']))
{
 Header("Location: index.php");
 exit;
}
$coname=CO_NAME;

$thesubject="Account activated on $coname - login details enclosed.";
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
?>
