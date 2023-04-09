<?
##############################################################################
#                                                                            #
#                                search.php                                  #
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

require_once("login-functions.php");
require_once("select_values.php");
require_once("siteconfig.php");

$login_check = $loginlib->is_logged();

if(!isset($page)) $page = 0;
$sql = "select profile.username, age, state, catch, isverified from profile, login_data where";

// The following line must be removed after all HTML is updated
$numshow = 5;


if($sex)
   $sql .= " sex = $sex";
else
  $sql .= " sex <> 0";

if($agerange) {
   if($agerange == 1)
      $sql .= " AND age < 5 AND age > 0";
   elseif($agerange == 2)
      $sql .= " AND age < 9 AND age > 4";
   elseif($agerange == 3)
      $sql .= " AND age < 13 AND age > 8";
   elseif($agerange == 4)
      $sql .= " AND age < 23 AND age > 12";
   elseif($agerange == 5)
      $sql .= " AND age < 33 AND age > 22";
   elseif($agerange == 6)
      $sql .= " AND age < 43 AND age > 32";
   elseif($agerange == 7)
      $sql .= " AND age < 53 AND age > 42";
   elseif($agerange == 8)
      $sql .= " AND age > 52";
}

if($race) 
   $sql .= " AND race = $race";

if($state) 
   $sql .= " AND state = $state";

if ($login_check) {

if($relation) 
   $sql .= " AND relation = $relation";

if($heightrange) {
   if($heightrange == 1)
      $sql .= " AND height < 5 AND height > 0";
   elseif($heightrange == 2)
      $sql .= " AND height < 9 AND height > 4";
   elseif($heightrange == 3)
      $sql .= " AND height < 13 AND height > 9";
   elseif($heightrange == 4)
      $sql .= " AND height < 17 AND height > 12";
   elseif($heightrange == 5)
      $sql .= " AND height < 20 AND height > 16";
}

if($build) 
   $sql .= " AND build = $build";

if($eyes) 
   $sql .= " AND eyes = $eyes";

if($hair) 
   $sql .= " AND hair = $hair";

if($education) 
   $sql .= " AND education = $education";

if($income) 
   $sql .= " AND income = $income";

if($travel) 
   $sql .= " AND travel = $travel";

if($smoke) 
   $sql .= " AND smoke = $smoke";

if($drink) 
   $sql .= " AND drink = $drink";

if($kids) 
   $sql .= " AND kids = $kids";

if($reqphoto) 
   $sql .= " AND haspicture = $reqphoto";

}
if($login_check) {
  if($numshow) {
     $startvalue = $numshow * $page;
     $sql .= " and profile.username = login_data.username ORDER BY login_data.lastlogin LIMIT $startvalue,$numshow";
  }
}
else {
  if($numshow) {
     $startvalue = $numshow * $page;
     $sql .= " and profile.username = login_data.username ORDER BY login_data.lastlogin LIMIT $numshow";
  }
}
$recordSet = $db->Execute($sql);
$count = $recordSet->RecordCount();

$FrecordSet1 = $db->Execute("select profile.username from profile, profile_pic where
profile.username = profile_pic.username and profile_pic.approved = '1' and profile.sex = '1' and profile.haspicture = '1'
 LIMIT 1");
$Fuser1 = $FrecordSet1->fields('username');
$MrecordSet1 = $db->Execute("select profile.username from profile, profile_pic where
profile.username = profile_pic.username and profile_pic.approved = '1' and profile.sex = '2' and profile.haspicture = '1'
LIMIT 1");
$Muser1 = $MrecordSet1->fields('username');
$FrecordSet2 = $db->Execute("select profile.username from profile, profile_pic where
profile.username = profile_pic.username and profile_pic.approved = '1' and profile.sex = '1' and profile.haspicture = '1'
and profile.username != '$Fuser1' LIMIT 1");
$Fuser2 = $FrecordSet2->fields('username');
$MrecordSet2 = $db->Execute("select profile.username from profile, profile_pic where
profile.username = profile_pic.username and profile_pic.approved = '1' and profile.sex = '2' and profile.haspicture = '1'
and profile.username != '$Muser1' LIMIT 1");
$Muser2 = $MrecordSet2->fields('username');

$centerimage = "images/search_red_dot_big.gif";
require("static/header.html");
require("static/search-middle.html");

if($count) {
  while (!$recordSet->EOF) {
    $user = $recordSet->fields('username');
    $age = $age_values[$recordSet->fields('age')];
    $statename = $state_values[$recordSet->fields('state')];
    $catch = stripslashes($recordSet->fields('catch'));
    $isverified = $recordSet->fields('isverified');
    $photo = "showpic.php?user=$user";

    require("static/searchloop.html");
    $recordSet->MoveNext();
  }
if($login_check) {
$page++;
echo "<p align=right><font face=\"verdana, arial, helvetica, san-serial\" size=3><a href='search.php?sex=$sex&agerange=$agerange&race=$race&state=$state&relation=$relation&heightrange=$heightrange&build=$build&eyes=$eyes&hair=$hair&education=$education&income=$income&travel=$travel&smoke=$smoke&drink=$drink&kids=$kids&reqphot=$reqphoto&numshow=$numshow&page=$page'>Next Page</a></font></p>";
echo "<BR><BR><BR><BR>";
}
else
echo "<p align=right><font face=\"verdana, arial, helvetica, san-serial\" size=3><a href=register.php>Click here and register to see more results</a></font></p><BR><BR><BR><BR><BR>";
}
else {
echo "<center><font face=\"verdana, arial, helvetica, sans-serial\"><h1>No Profiles match search criteria</h1></center>";
}
?>


