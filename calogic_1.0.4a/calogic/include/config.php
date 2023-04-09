<?php

/***************************************************************
** Title.........: CaLogic Base Configuration
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: config.php
** Last changed..: 
** Notes.........: read the explanations of the variables you need to set 
** Use...........: This file sets up a few of the global variables

** Functions: none

***************************************************************/ 
/***************************************************************
** CaLogic Version Variable and error reporting variable
***************************************************************/    
$calogicversion = "1.0.4a";
$errep = "<br><br>Version Info<br><br>CaLogic: ".$calogicversion."<br><br>MySQL: ".mysql_get_client_info()."<br><br>PHP: ".PHP_VERSION."<br><br><br>Please send this information to me, Philip Boone, so that I may correct this error.<br>My adress is philip@calogic.de, thank you";


/***************************************************************
** included files
** NOTE: You must set variables in the dbloader.php file  
***************************************************************/    
require_once("./include/dbloader.php");

/***************************************************************
** session_save_path
** NOTE: this usually should not be used. your web server should
         take care of this it self. If you do set it, it should
         be set to a path not accessible to a web browser.
         Remove the # to use this setting  
***************************************************************/    
/*** SET VARIABLE HERE *****/ 
#session_save_path("/home/etc/sess/tmp");

/***************************************************************
** $adsid
** NOTE: set this to true to have CaLogic add the Session SID
**       to each link.
         This is needed if you have PHP compiled without the
         enable-trans-sid option.  
***************************************************************/    
/*** SET VARIABLE HERE *****/ 
$adsid = FALSE;


/***************************************************************
** $seiyv
** NOTE: set this to false to have CaLogic NOT highlight
         days with events in the year view. This may be neccessary
         if you find CaLogic not being able to complete the yaar view. 
***************************************************************/    
/*** SET VARIABLE HERE *****/ 
$seiyv = true;



/***************************************************************
** standard global variables
** NOTE: you shoulden't have to edit any thing below this line!
***************************************************************/

if(get_magic_quotes_gpc() != 1) {
    set_magic_quotes_runtime(1);
}

    $sqlstr = "select * from ".$tabpre."_setup";
    $query1 = mysql_query($sqlstr) or die("Cannot query Standard Setup Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $res_query1 = @mysql_num_rows($query1); //or die("Cannot query Setup Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    if($res_query1 == 1) {
    	$row = mysql_fetch_array($query1) or die("Cannot query Setup Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);
        $siteowner = $row["siteowner"];
        $adminemail = $row["email"];
        $sitetitle =  $row["sitetitle"];
        $baseurl =  $row["baseurl"];
        $progdir =  $row["progdir"];
        $standardlang =  $row["standardlangid"];
        $standardlangname =  $row["standardlangname"];
        $standardbgimg =  $row["standardbgimg"];
        $allowopen =  $row["allowopen"];
        $allowpublic =  $row["allowpublic"];
        $allowprivate =  $row["allowprivate"];
        $allowreminders =  $row["allowreminders"];
    } else {
        die("There is an error in the Setup Table<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    }

$servertzos = ((date("Z") / 60) / 60);

if($servertzos > 0) {
    $servertzos = "+$servertzos";
} elseif($servertzos < 0) {
    $servertzos = "-$servertzos";
}

$curcalcfg = array();
$langcfg = array();
$csectcnt = array();

$sesname="";
$sesvar="";
$gltab = $tabpre."_languages";
$gutab = $tabpre."_user_reg";
$lstyle[1]="underline";
$lstyle[2]="overline";
$lstyle[3]="line-through";

$fsize["medium"] = "1";
$fsize["small"] = "-1";
$fsize["xsmall"] = "-2";

$timear = array();
$timear[0] = "0000";
$timear[1] = "0030";
$timear[2] = "0100";
$timear[3] = "0130";
$timear[4] = "0200";
$timear[5] = "0230";
$timear[6] = "0300";
$timear[7] = "0330";
$timear[8] = "0400";
$timear[9] = "0430";
$timear[10] = "0500";
$timear[11] = "0530";
$timear[12] = "0600";
$timear[13] = "0630";
$timear[14] = "0700";
$timear[15] = "0730";
$timear[16] = "0800";
$timear[17] = "0830";
$timear[18] = "0900";
$timear[19] = "0930";
$timear[20] = "1000";
$timear[21] = "1030";
$timear[22] = "1100";
$timear[23] = "1130"; 
$timear[24] = "1200";
$timear[25] = "1230";
$timear[26] = "1300";
$timear[27] = "1330";
$timear[28] = "1400";
$timear[29] = "1430";
$timear[30] = "1500"; 
$timear[31] = "1530";
$timear[32] = "1600";
$timear[33] = "1630";
$timear[34] = "1700";
$timear[35] = "1730"; 
$timear[36] = "1800"; 
$timear[37] = "1830"; 
$timear[38] = "1900";
$timear[39] = "1930"; 
$timear[40] = "2000"; 
$timear[41] = "2030"; 
$timear[42] = "2100"; 
$timear[43] = "2130"; 
$timear[44] = "2200"; 
$timear[45] = "2230"; 
$timear[46] = "2300"; 
$timear[47] = "2330";

$timeara = array();
$timeara[0]="12:00 AM";
$timeara[1]="12:30 AM";
$timeara[2]="1:00 AM";
$timeara[3]="1:30 AM";
$timeara[4]="2:00 AM";
$timeara[5]="2:30 AM";
$timeara[6]="3:00 AM";
$timeara[7]="3:30 AM";
$timeara[8]="4:00 AM";
$timeara[9]="4:30 AM";
$timeara[10]="5:00 AM";
$timeara[11]="5:30 AM";
$timeara[12]="6:00 AM";
$timeara[13]="6:30 AM";
$timeara[14]="7:00 AM";
$timeara[15]="7:30 AM";
$timeara[16]="8:00 AM";
$timeara[17]="8:30 AM";
$timeara[18]="9:00 AM";
$timeara[19]="9:30 AM";
$timeara[20]="10:00 AM";
$timeara[21]="10:30 AM";
$timeara[22]="11:00 AM";
$timeara[23]="11:30 AM";
$timeara[24]="12:00 PM";
$timeara[25]="12:30 PM";
$timeara[26]="1:00 PM";
$timeara[27]="1:30 PM";
$timeara[28]="2:00 PM";
$timeara[29]="2:30 PM";
$timeara[30]="3:00 PM";
$timeara[31]="3:30 PM";
$timeara[32]="4:00 PM";
$timeara[33]="4:30 PM";
$timeara[34]="5:00 PM";
$timeara[35]="5:30 PM";
$timeara[36]="6:00 PM";
$timeara[37]="6:30 PM";
$timeara[38]="7:00 PM";
$timeara[39]="7:30 PM";
$timeara[40]="8:00 PM";
$timeara[41]="8:30 PM";
$timeara[42]="9:00 PM";
$timeara[43]="9:30 PM";
$timeara[44]="10:00 PM";
$timeara[45]="10:30 PM";
$timeara[46]="11:00 PM";
$timeara[47]="11:30 PM";

?>