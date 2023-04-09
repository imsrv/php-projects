<?
##############################################################################
#                                                                            #
#                            mailbox.php                                     #
#                                                                            #
##############################################################################
# PROGRAM : E-MatchMaker                                                     #
# VERSION : 1.51                                                             #
#                                                                            #
# NOTES   : site using default site layout and graphics                      #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 20012-2002                                                   #
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


if($mmconfig->premiummember) {
  $recordSet = $db->Execute("select pmember from login_data");
  if($recordSet->Fields("pmember")) {
    header("Location: premium.php");
    exit;
  }
}

$session_vars = explode(":", $mmcookie);
$username = $session_vars[0]; 

include("static/header.html");
include("static/mailbox-top.html");

$bgcolorcodes[0] = "#9A3430";
$bgcolorcodes[1] = "#CD9593";
$colorcounter = 0;

$recordSet = $db->Execute("select * from messages where receiving_user = '$username' and hidereceiver = '0'");

while(!$recordSet->EOF) {

  $bgcolor = $bgcolorcodes[$colorcounter];
  list($db_date, $scrap) = explode(" ", $recordSet->Fields("date"));
  list($year, $month, $day) = explode("-", $db_date);
  $msg_date = "$month-$day-$year";
  $msg_clip = substr($recordSet->Fields("message"), 0, 40);
  $msg_id = $recordSet->Fields("id");
  $user = $recordSet->Fields("sending_user");
  include("static/mailbox-loop.html");
  $colorcounter++;
  if($colorcounter == '2')
    $colorcounter = 0;
  $recordSet->MoveNext();

}


include("static/mailbox-middle.html");

$colorcounter = 0;

$recordSet = $db->Execute("select * from messages where sending_user = '$username' and hidesender = '0'");

while(!$recordSet->EOF) {

  $bgcolor = $bgcolorcodes[$colorcounter];
  list($db_date, $scrap) = explode(" ", $recordSet->Fields("date"));
  list($year, $month, $day) = explode("-", $db_date);
  $msg_date = "$month-$day-$year";
  $msg_clip = substr($recordSet->Fields("message"), 0, 40);
  $msg_id = $recordSet->Fields("id");
  $user = $recordSet->Fields("receiving_user");
  include("static/mailbox-loop.html");
  $colorcounter++;
  if($colorcounter == '2')
    $colorcounter = 0;
  $recordSet->MoveNext();

}

include("static/mailbox-end.html");

?>
