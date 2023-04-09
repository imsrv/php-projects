<?
##############################################################################
#                                                                            #
#                             mailhide.php                                   #
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

require_once("siteconfig.php");
require_once("login-functions.php");

$login_check = $loginlib->is_logged();

if (!$login_check) {
   header("Location: register.php");
   exit;
}
  
$session_vars = explode(":", $mmcookie);
$username = $session_vars[0];

if(isset($msg_id)) {
foreach($msg_id as $id) {
  
  $db->Execute("update messages set hidesender = 1 where sending_user = '$username' and id = '$id'");
  $db->Execute("update messages set hidereceiver = 1 where receiving_user = '$username' and id = '$id'");
  $db->Execute("delete from messages where hidesender = 1 AND hidereceiver = 1");

}
}

header("Location: mailbox.php");

?>
