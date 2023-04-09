<?
##############################################################################
#                                                                            #
#                            showprofile.php                                 #
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

if(!login_check && $hash != "2434e44d9x9330a0d30c6e6cec33195393319525718283efadb1f5a") {
     header("Location: index.php");
     exit;
} 



$sql="select age,height,hair,sex,race,eyes,kids,build,interest,smoke,education,income,drink,relation,travel,city,state,zipcode,catch,about,looking,isverified
        from profile where username='$user'";
$recordSet = &$db->Execute($sql);
$count = $recordSet->RecordCount();
if(!$count) {
   header("Location: browseprofiles.php");
   die;
}
else {
   require("select_values.php");
   $age=$age_values[$recordSet->Fields("age")];
   $height=$height_values[$recordSet->Fields("height")];
   $hair=$hair_values[$recordSet->Fields("hair")];
   $sex=$sex_values[$recordSet->Fields("sex")];
   $race=$race_values[$recordSet->Fields("race")];
   $eyes=$eyes_values[$recordSet->Fields("eyes")];
   $kids=$kids_values[$recordSet->Fields("kids")];
   $build=$build_values[$recordSet->Fields("build")];
   $interest_array = split(":", $recordSet->Fields("interest"));
   for($i = 0; $i < count($interest_array); $i++) {
      $num = $interest_array[$i];
      $interest .= "$interest_values[$num]";
      if($i < (count($interest_array) - 1))
         $interest .= ", ";
   }
   $smoke=$smoke_values[$recordSet->Fields("smoke")];
   $education=$education_values[$recordSet->Fields("education")];
   $income=$income_values[$recordSet->Fields("income")];
   $drink=$drink_values[$recordSet->Fields("drink")];
   $relation=$relation_values[$recordSet->Fields("relation")];
   $travel=$travel_values[$recordSet->Fields("travel")];
   $city=$recordSet->Fields("city");
   $state=$state_values[$recordSet->Fields("state")];
   $zipcode=$zipcode_values[$recordSet->Fields("zipcode")];
   $catch=stripslashes($recordSet->Fields("catch"));
   $about=stripslashes($recordSet->Fields("about"));
   $looking=stripslashes($recordSet->Fields("looking"));
   $isverified=$recordSet->Fields("isverified");
}

include("static/header.html");
include("static/showuser.html"); 

?>
