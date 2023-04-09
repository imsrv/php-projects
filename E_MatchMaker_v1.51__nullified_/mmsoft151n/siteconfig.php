<?
##############################################################################
#                                                                            #
#                             siteconfig.php                                 #
#                                                                            #
##############################################################################
# PROGRAM : E-MatchMaker                                                     #
# VERSION : 1.51                                                             #
#                                                                            #
# NOTES   : site using default site layout and graphics                      #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2001-2002                                                    #
# Supplied by          : CyKuH [WTN]                                         #
# Nullified by         : CyKuH [WTN]                                         #
# Distribution:        : via WebForum and xCGI Forums File Dumps             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of MatchMakerSoftware             #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?

include('mmsoft.inc.php');
include('errorvals.inc.php');

class mmconfig {
      var $secret = "This is a secret phrase used to make the hash value.";  // you can make this any string you want
      var $webmaster = "support@you-site.com";  // your support email address
      var $webaddress = "http://www.your-site.com";   // note this must be the full URL to your site
      var $website = "Your Dating Site Name";  // used for the title of html pages and in user emails
      var $logout_url = "/"; 
      var $createprofileimage = "images/createprofileimage.gif";
      var $updateprofileimage = "images/updateprofileimage.gif";
      var $imgmaxsize = 50;  // max allowed image size in KB for user to upload
      var $domain = "your-site.com";  // your site's domain used in emails
      var $adminusername = "administrator";
      var $adminpassword = "password";
	var $paymenturl = "";
	var $paypalemail = "payments@your-site.com";
      var $vmembercost = "5.95";   // the cost for users to become verified
      var $securemode = 0;    // set this to '0' to require single login 
                              // set this to '1' to require you to login twice with the same L/P (old method)
      var $max_free_emails = "4";             // This is where you set the max number of emails allowed without being a paid member
      var $payed_email = "0";                 // Set this to 0 to allow unlimited free email sending. Set this to 1 to charge after the number above as been reached;
      var $premiummember = "0";               // Set this to 1 to require users to be a premium member to access mailbox
      var $ibillpaymenturl = "http://ibillurl"; // set this to your ibill payment URL


}

$mmconfig = new mmconfig;

### register_globals = off ### +++
//HTTP_GET_VARS
while (list($key, $val) = @each($HTTP_GET_VARS)) {
$GLOBALS[$key] = $val;
}
//HTTP_POST_VARS
while (list($key, $val) = @each($HTTP_POST_VARS)) {
$GLOBALS[$key] = $val;
}
//HTTP_POST_FILES
while (list($key, $val) = @each($HTTP_POST_FILES)) {
$GLOBALS[$key] = $val;
}
//$HTTP_SESSION_VARS
while (list($key, $val) = @each($HTTP_SESSION_VARS)) {
$GLOBALS[$key] = $val;
}
### register_globals = off ### ---


?>
