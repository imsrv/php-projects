<?
##############################################################################
#                                                                            #
#                               showpic.php                                  #
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

include("siteconfig.php");

$recordSet = &$db->Execute("select haspicture from profile where username = '$user'");
$haspicture = $recordSet->Fields("haspicture");

if($haspicture) {
   $recordSet = &$db->Execute("select image, image_type from profile_pic where username = '$user' AND approved = 1");
   $count = $recordSet->RecordCount();
   if($count) {
      $image = $recordSet->Fields("image");
      $image_type = $recordSet->Fields("image_type");
      header("Content-type: $image_type");
      echo $image;
      exit;
   }
}

header("Location: images/nophoto.gif");

?>
