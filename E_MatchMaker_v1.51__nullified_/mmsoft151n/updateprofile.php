<?
##############################################################################
#                                                                            #
#                           updateprofile.php                                #
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
<? $id = $session_vars[2]; ?>
<?

require_once("siteconfig.php");
require("login-functions.php");

$login_check = $loginlib->is_logged();

if (!$login_check) {
	if($action == create) {
	   header("Location: index.php?action=updateprofile");
	   exit;
	}
	else {
          header("Location: login.php");
          exit;
	}
}
    if(($modeofform=="u") || ($modeofform=="i")) {
        $city=addslashes($city);
        $state=addslashes($state);
        $catch=addslashes($catch);
        $about=addslashes($about);
        $looking=addslashes($looking);
        $username=addslashes($username);
        if(!empty($interest)) {
           $interest=implode(":", $interest);
        }

        if($modeofform=="u"){
            $sql="update profile
                    set
                       age=$age,
                       height=$height,
                       hair=$hair,
                       sex=$sex,
                       race=$race,
                       eyes=$eyes,
                       kids=$kids,
                       build=$build,
                       interest='$interest',
                       smoke=$smoke,
                       education=$education,
                       income=$income,
                       drink=$drink,
                       relation=$relation,
                       travel=$travel,
                       city='$city',
                       state='$state',
                       zipcode='$zipcode',
                       catch='$catch',
                       about='$about',
                       looking='$looking',
                       id=$id,
                       username='$username'
                    where username='$username'";
             if($db->Execute($sql)) {
             header("Location: index.php");
             exit;
             }
             else {
             header("Location: updateprofile.php?error_code=1");
             die;
             }
        }
        else {
            $sql="insert into profile
                 (age,height,hair,sex,race,eyes,kids,build,interest,smoke,education,income,drink,relation,travel,city,state,zipcode,catch,about,looking,id,username)
                 Values 
($age,$height,$hair,$sex,$race,$eyes,$kids,$build,'$interest',$smoke,$education,$income,$drink,$relation,$travel,'$city','$state','$zipcode','$catch','$about','$looking',$id,'$username')";
             if($db->Execute($sql)) {
	        if($action == create) {
                   header("Location: premium.php");
                   exit;
                }
                header("Location: index.php");
                exit;
             }
             else {
             header("Location: updateprofile.php?action=create&error_code=1");
             die;
             }
        }
    }
    elseif(isset($username)){
            $count=-1;
            $sql="select age,height,hair,sex,race,eyes,kids,build,interest,smoke,education,income,drink,relation,travel,city,state,zipcode,catch,about,looking,id,username from profile
                   where username='$username'";
            $recordSet = &$db->Execute($sql);
            $count = $recordSet->RecordCount();
            if(!$count) {
            $modeofform="i";
            }

          else {

            $modeofform="u";

         $age=$recordSet->Fields("age");
         $height=$recordSet->Fields("height");
         $hair=$recordSet->Fields("hair");
         $sex=$recordSet->Fields("sex");
         $race=$recordSet->Fields("race");
         $eyes=$recordSet->Fields("eyes");
         $kids=$recordSet->Fields("kids");
         $build=$recordSet->Fields("build");
         $interest=split(":", $recordSet->Fields("interest"));
         $smoke=$recordSet->Fields("smoke");
         $education=$recordSet->Fields("education");
         $income=$recordSet->Fields("income");
         $drink=$recordSet->Fields("drink");
         $relation=$recordSet->Fields("relation");
         $travel=$recordSet->Fields("travel");
         $city=$recordSet->Fields("city");
         $state=$recordSet->Fields("state");
         $zipcode=$recordSet->Fields("zipcode");
         $catch=stripslashes($recordSet->Fields("catch"));
         $about=stripslashes($recordSet->Fields("about"));
         $looking=stripslashes($recordSet->Fields("looking"));

      }

    }

$centerimage = "images/my_profile_red_big.gif";
require('select_values.php'); 
require_once('writecombo.php');
require('static/header.html');
require('static/update.html');
?>

