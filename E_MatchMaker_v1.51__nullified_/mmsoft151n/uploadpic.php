<?
##############################################################################
#                                                                            #
#                             uploadpic.php                                  #
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
<? $session_vars = explode(":", $mmcookie); ?>
<? $username = $session_vars[0]; ?>
<?

require_once("siteconfig.php");
require("login-functions.php");

$login_check = $loginlib->is_logged();

if (!$login_check) {
        header("Location: login.php");
        exit;
}

require_once("mmsoft.inc.php");

$userfile_type = $HTTP_POST_FILES['userfile']['type'];
$userfile_size = $HTTP_POST_FILES['userfile']['size'] / 1024;
$userfile_tmpname = $HTTP_POST_FILES['userfile']['tmp_name'];

$allowed_types = array('GIF', 'JPG', 'JPEG', 'PJPEG');
$file_type = split("/", $userfile_type);


if($action == "upload") {
   if($userfile_size < $mmconfig->imgmaxsize) {
      if(strtoupper($file_type[0]) == "IMAGE") {
         if(!empty($userfile_tmpname) && $userfile_tmpname != "none") {
            if(in_array(strtoupper($file_type[1]), $allowed_types)) {
               $image = addslashes(fread(fopen($userfile_tmpname, "r"), filesize($userfile_tmpname)));
               $sql = "select * from profile_pic where username = '$username'";
               $recordSet = &$db->Execute($sql);
               $count = $recordSet->RecordCount();
               if($count < 1) {
                  $sqlinsert = "insert into profile_pic (username, image, image_type, sub_date) values ('$username', '$image', '$userfile_type', now())";
                  $error = $db->Execute($sqlinsert);
                  $error2 = $db->Execute("update profile set haspicture = 1 where username = '$username'");
                  if($error && $error2) {
                     include("static/header.html");
                     include("static/picupload_success.html");
                     exit;
                  }
                  else {
                     include("static/header.html");
                     include("static/picupload_error.html");
                     exit;
                  }
               } 
               else {
                  $sqlupdate = "update profile_pic set image = '$image', image_type = '$image_type', sub_date = now(), approved = 0, approval_date = '' where username = '$username'";
                  $error = $db->Execute($sqlupdate);
                  $error2 = $db->Execute("optimize table profile_pic");
                  if($error && $error2) {
                     include("static/header.html");
                     include("static/picupload_success.html");
                     exit;
                  }
                  else {
                     include("static/header.html");
                     include("static/picupload_error.html");
                     exit;
                  }
               }
            }
         }
      }
   }
}

$centerimage = "images/upload_pic_big.gif";
include("static/header.html");
include("static/uploadpic.html");

?>

