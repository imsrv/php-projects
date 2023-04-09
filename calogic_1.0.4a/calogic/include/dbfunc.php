<?php

/***************************************************************
** Title.........: Calendar Database Functions
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: dbfunc.php
** Last changed..: 
** Notes.........: 
** Use...........: 
                   

** Functions: 
              
                                 
***************************************************************/ 

/***************************************************************
**  
***************************************************************/    

include_once("./include/class.html.mime.mail.inc");

function checkinput($pvar) {

    for($xl=0;$xl<strlen($pvar);$xl++) {
        if(ereg("^[^a-zA-Z0-9]$",substr($pvar,$xl,1))) {
            return false;
        }
    }
    
    return true;

}

function fmtfordb($pvar) {
    $pvar = str_replace("|"," ",$pvar);
    return $pvar;
}

//function fmtforcl($pvar) {
//    $pvar = ($pvar);
//    return $pvar;
//}

function translate($keyid,$setlang) {
//    global $tabpre,$gltab;
$erfilename = "File: ".substr(__FILE__,strrpos(__FILE__,"/")).";"; 
    
    $gltab = $GLOBALS["gltab"]; //$tabpre."_languages";
    $sqlstr = "select name from $gltab where uid=$setlang";
    $qu_res = mysql_query($sqlstr)  or die("Cannot query global language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
/*    if (mysql_error()) {
        $error = mysql_error();
        sqlerror($error, __LINE__, "$erfilename Cannot query Global Language Database", $sqlstr);
    }    

*/
    $qu_num = @mysql_num_rows($qu_res);
    if($qu_num < 1) {
        mysql_free_result($qu_res);
        $sqlstr = "select * from $gltab where uid=1";
        $qu_res = mysql_query($sqlstr) or die("Cannot query global language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
/*        if (mysql_error()) {
            $error = mysql_error();
            sqlerror($error, __LINE__, "$erfilename Cannot query Global Language Database", $sqlstr);
        }    
*/
        $qu_num = @mysql_num_rows($qu_res);
        if ($qu_num < 1) {
            sqlerror("", __LINE__, "$erfilename Database Error, nither the requested language table nor the default language table were found.",$sqlstr);
        }
        $rs_lang = mysql_fetch_array($qu_res);
        $langtab = $GLOBALS["tabpre"]."_lang_".$rs_lang["name"];
        mysql_free_result($qu_res);
        $sqlstr = "select * from $langtab where keyid='$keyid'";
        $qu_res = mysql_query($sqlstr) or die("Cannot query language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        
/*        if (mysql_error()) {
            $error = mysql_error();
            sqlerror($error, __LINE__, "$erfilename Cannot query Local Language Database [$langtab]", $sqlstr);
        }    
*/
        $qu_num = @mysql_num_rows($qu_res);
        if ($qu_num < 1) {
            sqlerror("", __LINE__, "$erfilename Database Error, requested language table not found, keyid $keyid in default language table $langtab not found.", $sqlstr);
        }
        $rs_key = mysql_fetch_array($qu_res);
        $ret_val = ($rs_key["phrase"]);
        mysql_free_result($qu_res);
        return $ret_val;
    }
    
    $rs_lang = mysql_fetch_array($qu_res);
    $langtab = $GLOBALS["tabpre"]."_lang_".$rs_lang["name"];
    $sqlstr = "select * from $langtab where keyid='$keyid'";

    $qu_res = mysql_query($sqlstr) or die("Cannot query language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
/*    if (mysql_error()) {
        $error = mysql_error();
        sqlerror($error, __LINE__, "$erfilename Cannot query Local Language Database [$langtab]", $sqlstr);
    }    
*/
    $qu_num = @mysql_num_rows($qu_res);
    
    if ($qu_num < 1) {
        sqlerror("", __LINE__, "$erfilename Database Error, keyid [$keyid] not found in requested language table $langtab.", $sqlstr);
    }
    
    $rs_key = mysql_fetch_array($qu_res);
    $ret_val = ($rs_key["phrase"]);
    mysql_free_result($qu_res);
    return $ret_val;
}

function emailok($email) {
    return( ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email));
}

function sqlerror($error="",$myerrnum=0,$errext="",$sqlstr="") {

//    include("./basicheader.inc.php");
    if($error <> "") {
        echo "MySQL Database Error: <br>$error<br><br>";
    }
    if($myerrnum <> 0) {
        echo "Program Error Line Number: $myerrnum<br><br>";
    }
    if($errext <> "") {
        echo "Program Error Message: $errext<br><br>";
    }
    if($sqlstr <> "") {
        echo "Executed SQL String: $sqlstr<br><br>";
    }
    echo "Please contact the Admin if the problem persists.";
    exit();
}

function setviewtext($langsel) {
    global $weekstartonmonday,$daytext,$daytextl,$monthtext,$monthtextl;
    global $langcfg;

    if ($weekstartonmonday==1) {
    
        $daytext[1] = $langcfg["wdns1"]; //"Mon";
        $daytext[2] = $langcfg["wdns2"]; //"Tue";
        $daytext[3] = $langcfg["wdns3"]; //"Wed";
        $daytext[4] = $langcfg["wdns4"]; //"Thu";
        $daytext[5] = $langcfg["wdns5"]; //"Fri";
        $daytext[6] = $langcfg["wdns6"]; //"Sat";
        $daytext[7] = $langcfg["wdns7"]; //"Sun";
        $daytextl[1] = $langcfg["wdnl1"]; //"Monday";
        $daytextl[2] = $langcfg["wdnl2"]; //"Tuesday";
        $daytextl[3] = $langcfg["wdnl3"]; //"Wednesday";
        $daytextl[4] = $langcfg["wdnl4"]; //"Thursday";
        $daytextl[5] = $langcfg["wdnl5"]; //"Friday";
        $daytextl[6] = $langcfg["wdnl6"]; //"Saturday";
        $daytextl[7] = $langcfg["wdnl7"]; //"Sunday";
    
    } else {
    
        $daytext[1] = $langcfg["wdns7"]; //"Sun";
        $daytext[2] = $langcfg["wdns1"]; //"Mon";
        $daytext[3] = $langcfg["wdns2"]; //"Tue";
        $daytext[4] = $langcfg["wdns3"]; //"Wed";
        $daytext[5] = $langcfg["wdns4"]; //"Thu";
        $daytext[6] = $langcfg["wdns5"]; //"Fri";
        $daytext[7] = $langcfg["wdns6"]; //"Sat";
        $daytextl[1] = $langcfg["wdnl7"]; //"Sunday";
        $daytextl[2] = $langcfg["wdnl1"]; //"Monday";
        $daytextl[3] = $langcfg["wdnl2"]; //"Tuesday";
        $daytextl[4] = $langcfg["wdnl3"]; //"Wednesday";
        $daytextl[5] = $langcfg["wdnl4"]; //"Thursday";
        $daytextl[6] = $langcfg["wdnl5"]; //"Friday";
        $daytextl[7] = $langcfg["wdnl6"]; //"Saturday";
    }
    
    $monthtext[1] = $langcfg["mns1"]; //"Jan";
    $monthtext[2] = $langcfg["mns2"]; //"Feb";
    $monthtext[3] = $langcfg["mns3"]; //"Mar";
    $monthtext[4] = $langcfg["mns4"]; //"Apr";
    $monthtext[5] = $langcfg["mns5"]; //"May";
    $monthtext[6] = $langcfg["mns6"]; //"Jun";
    $monthtext[7] = $langcfg["mns7"]; //"Jul";
    $monthtext[8] = $langcfg["mns8"]; //"Aug";
    $monthtext[9] = $langcfg["mns9"]; //"Sep";
    $monthtext[10] = $langcfg["mns10"]; //"Oct";
    $monthtext[11] = $langcfg["mns11"]; //"Nov";
    $monthtext[12] = $langcfg["mns12"]; //"Dec";
    
    $monthtextl[1] = $langcfg["mnl1"]; //"January";
    $monthtextl[2] = $langcfg["mnl2"]; //"February";
    $monthtextl[3] = $langcfg["mnl3"]; //"March";
    $monthtextl[4] = $langcfg["mnl4"]; //"April";
    $monthtextl[5] = $langcfg["mnl5"]; //"May";
    $monthtextl[6] = $langcfg["mnl6"]; //"June";
    $monthtextl[7] = $langcfg["mnl7"]; //"July";
    $monthtextl[8] = $langcfg["mnl8"]; //"August";
    $monthtextl[9] = $langcfg["mnl9"]; //"September";
    $monthtextl[10] = $langcfg["mnl10"]; //"October";
    $monthtextl[11] = $langcfg["mnl11"]; //"November";
    $monthtextl[12] = $langcfg["mnl12"]; //"December";

}


function getcurlang($langsel) {
    global $langcfg;


    $gltab = $GLOBALS["gltab"]; //$tabpre."_languages";
    $sqlstr = "select name from $gltab where uid=$langsel";
    $qu_res = mysql_query($sqlstr) or die("Cannot query global language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
/*    if (mysql_error()) {
        $error = mysql_error();
        sqlerror($error, __LINE__, "$erfilename Cannot query Global Language Database", $sqlstr);
    }    
*/
    $qu_num = @mysql_num_rows($qu_res);
    if (mysql_error()) {
        $error = mysql_error();
        sqlerror($error, __LINE__, "$erfilename Cannot query Global Language Database", $sqlstr);
    }    
    if($qu_num == 1) {
        $rs_lang = mysql_fetch_array($qu_res);
        $langtab = $GLOBALS["tabpre"]."_lang_".$rs_lang["name"];
        $sqlstr = "select * from ".$langtab;
        $query1 = mysql_query($sqlstr) or die("Cannot query Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        while($row = mysql_fetch_array($query1)) {
            $langcfg[$row["keyid"]] = ($row["phrase"]);
        }
        mysql_free_result($query1);
        mysql_free_result($qu_res);
    } else {
        die("Cannot query Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);    
    }
    
}


function getuserstandards($cuser) {
    global $curcalcfg,$csectcnt;
    $curcalcfg = array();
    $csectcnt = array();

//    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where calid = '".$cuser->gsv("curcalid")."' and calname = '".$cuser->gsv("curcalname")."' and userid = ".$cuser->gsv("cuid");
//    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where calid = '".$cuser->gsv("curcalid")."' and calname = '".$cuser->gsv("curcalname")."'";
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where calid = '".$cuser->gsv("curcalid")."'";
    $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $res_query1 = @mysql_num_rows($query1) ;
    if(mysql_error()) {
        die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);    
    }
    if($res_query1 == 1) {

        $query2 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $res_query2 = @mysql_num_rows($query2) ;
        if(mysql_error()) {
            die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);    
        }

    	$row = mysql_fetch_array($query2) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);

        $i = 0;
        
        while ($i < mysql_num_fields($query1)) {
            $meta = mysql_fetch_field($query1);
            $fname = $meta->name; 
            $curcalcfg["$fname"] = ($row["$fname"]);
            $xcsnt = substr($fname,0,2);
//            if(array_key_exists($xcsnt, $csectcnt)) {
                $csectcnt[$xcsnt]++;
//            } else {
//                $csectcnt[$xcsnt] = 1;
//            }
//            echo $xcsnt.": ".$csectcnt[$xcsnt]."<br>";

            // Trick, used to create language entries he he he.
//            echo "INSERT INTO `clw_lang_English` VALUES ('', '".$fname."', 'temp', 'Calendar Setup Form');<br>\n";
            
            $i++;
        }
        
        mysql_free_result($query1);
        mysql_free_result($query2);
        
//        exit();
        
    } else {
        die("There was an error while getting Calander Settings<br><br>SQL String: ".$sqlstr."<br><br>This could mean your calendar has been deleted or the user name you are using has been deleted.<br><br>
It could also mean your session has gone bad. Please close your browser, open a new browser window and then logon to CaLogic.<br><br>If the problem persists, please contact the Admin.<br><br>
<a href=\"".$GLOBALS["idxfile"]."?endsess=1\">Click here to continue</a>");
    }
}


function getcalvals($xcalid) {
    $calvals = array();

    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where calid = '".$xcalid."'";
    $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $res_query1 = @mysql_num_rows($query1) ;
    if(mysql_error()) {
        die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);    
    }
    if($res_query1 == 1) {

        $query2 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $res_query2 = @mysql_num_rows($query2) ;
        if(mysql_error()) {
            die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);    
        }

    	$row = mysql_fetch_array($query2) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);

        $i = 0;
        
        while ($i < mysql_num_fields($query1)) {
            $meta = mysql_fetch_field($query1);
            $fname = $meta->name; 
            $calvals["$fname"] = ($row["$fname"]);
            $i++;
        }
        
        mysql_free_result($query1);
        mysql_free_result($query2);

    } else {
        die("There is an error in the Calendar Config Table<br><br>SQL String: ".$sqlstr);
    }
    return $calvals;
}

function regresend($fname,$lname,$email,$uname,$slanguage,$key) {


    $regmail = new html_mime_mail('X-Mailer: Html Mime Mail Class');
    
    $regmbody="<HTML><BODY>Hello $fname $lname,<br><br>You just registered with the CaLogic Calendar application running at ".$GLOBALS["sitetitle"]." (".$GLOBALS["baseurl"].") <br><br>Please click the link below to confirm your registraton:<br><br><a href=\"".$GLOBALS["baseurl"].$GLOBALS["progdir"]."confirmreg.php?key=$key\" target=\"_blank\">Confirm Registration</a><br><br>Or copy and paste this address to your browser:<br><br>".$GLOBALS["baseurl"].$GLOBALS["progdir"]."confirmreg.php?key=$key<br><br>After confirming, you may begin configuring a Calendar to your likings.<br><br>I hope you enjoy working with the calendar, and wish you much success. Information given by you:<br><br><b>User Name: </B>$uname<br><B>First Name:  </B>$fname<br><B>Last Name: </B> $lname<br><B>Language Selection:  </B>$slanguage<br><br>For security reasons, your password has not been sent with this mail.<br><br>If you experience problems with the calendar, please let me know. <br><br>Thank you and best regards<br><br>".$GLOBALS["siteowner"]."<br></body></html>";
    
    $regmail->add_html($regmbody, '');
    $regmail->set_charset('iso-8859-1', TRUE);
    $regmail->build_message();
    $siteowner=$GLOBALS["siteowner"];
    $adminemail=$GLOBALS["adminemail"];
    //$mail->send('TO NAME', 'TO ADDRESS', 'FROM NAME', 'FROM ADDRESS', 'SUBJECT LINE');
    $regmail->send("$fname $lname", "$email", "$siteowner", "$adminemail", "CaLogic Registration Confirmation");


}

function senddelmail($fname,$lname,$email,$uname) {

    $delmail = new html_mime_mail('X-Mailer: Html Mime Mail Class');
    $delmbody="<HTML><BODY>Hello $fname $lname,<br><br>Your User Profile has been deleted from ".$GLOBALS["sitetitle"]." (".$GLOBALS["baseurl"].") <br><br>If you want to find out why, send me an E-Mail asking so.<br><br>".$GLOBALS["siteowner"]."<br></body></html>";
    $delmail->add_html($delmbody, '');
    $delmail->set_charset('iso-8859-1', TRUE);
    $delmail->build_message();
    $siteowner=$GLOBALS["siteowner"];
    $adminemail=$GLOBALS["adminemail"];
    //$mail->send('TO NAME', 'TO ADDRESS', 'FROM NAME', 'FROM ADDRESS', 'SUBJECT LINE');
    $delmail->send("$fname $lname", "$email", "$siteowner", "$adminemail", "CaLogic User Deletion");

}

function langeditor($seledlang,$uobj) {
    global $curcalcfg;
    global $langcfg;

    $htmltrans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
    $transhtml = array_flip($htmltrans);
    
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_lang_".$seledlang." order by uid";
    $query1 = mysql_query($sqlstr) or die("Cannot query Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        
?>
<head>
<title><?php echo $langcfg["edlang"]; ?></title>
<style type="text/css">
<!--
body          {font-family: helvetica, arial, geneva, sans-serif; font-size: small; color: #000000}
pre, tt       {font-size: small}
th            {font-family: helvetica, arial, geneva, sans-serif; font-size: small; font-weight: bold; background-color: #D3DCE3}
td            {font-family: helvetica, arial, geneva, sans-serif; font-size: small}
form          {font-family: helvetica, arial, geneva, sans-serif; font-size: small}
input         {font-family: helvetica, arial, geneva, sans-serif; font-size: small; color: #000000}
select        {font-family: helvetica, arial, geneva, sans-serif; font-size: small; color: #000000}
textarea      {font-family: helvetica, arial, geneva, sans-serif; font-size: small; color: #000000}
//-->
</style>
</head>
<body bgcolor="#F5F5F5" >
<h1><?php echo $langcfg["edlt1"]; ?> <?php echo "$seledlang"; ?> <?php echo $langcfg["edltt"]; ?></h1>

<form method="POST" action="<?php echo $GLOBALS["idxfile"]; ?>">
<input type="hidden" name="seledlang" value="<?php echo $seledlang; ?>">
<?php
$rcnt=1;
$ccnt=1;
while($row = mysql_fetch_array($query1)) {
    if($ccnt==1) {
        $ccnt=2;
        $rcolor="#DDDDDD";
    } else {
        $rcolor="#CCCCCC";
        $ccnt=1;
    }
    if($rcnt==1) {
    ?>
  <table border="1" width="100%">
    <tr>
      <th width="33%"><?php echo $langcfg["keyidt"]; ?></th>
      <th width="33%"><?php echo $langcfg["pht"]; ?></th>
      <th width="34%"><?php echo $langcfg["urrh"]; ?></th>
    </tr>
    <?php    
    }
    ?>
    <tr>
      <td width="33%" valign="top" align="center" bgcolor="<?php echo "$rcolor"; ?>"><br>
            <input type="text" disabled name="fields[<?php echo $row["uid"]; ?>][keyid]" value="<?php echo $row["keyid"]; ?>" size="30" maxlength="30" />
            <input type="hidden" name="prev_fields[<?php echo $row["uid"]; ?>][keyid]" value="<?php echo $row["keyid"]; ?>" />
      </td>
      <td width="33%" valign="top" align="center" bgcolor="<?php echo "$rcolor"; ?>">
            <textarea name="fields[<?php echo $row["uid"]; ?>][phrase]" rows="7" cols="40"><?php echo strtr(($row["phrase"]),$htmltrans); ?></textarea>
            <input type="hidden" name="prev_fields[<?php echo $row["uid"]; ?>][phrase]" value="<?php echo strtr(($row["phrase"]),$htmltrans); ?>" />
      </td>
      <td width="34%" valign="top" align="center" bgcolor="<?php echo "$rcolor"; ?>"><br>
            <input type="text" name="fields[<?php echo $row["uid"]; ?>][remark]" value="<?php echo strtr(($row["remark"]),$htmltrans); ?>" size="40" maxlength="254" />
            <input type="hidden" name="prev_fields[<?php echo $row["uid"]; ?>][remark]" value="<?php echo strtr(($row["remark"]),$htmltrans); ?>" />
      </td>
    </tr>
    <?php    
    $rcnt++;
    if($rcnt==10) {
        $rcnt=1;
        ?>
        <tr><td width="100%" valign="top" align="center" colspan="3"><br>
        <input type="submit" value="<?php echo $langcfg["butsavech"]; ?>" name="savelang">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="<?php echo $langcfg["butpv"]; ?>" name="canclechanges">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="<?php echo $langcfg["leaved"]; ?>" name="leaveeditor">  
        </td></tr>
        </table><br>
        <?php    
    }
}
if($rcnt<>1) {
?>
  <tr><td width="100%" valign="top" align="center" colspan="3"><br>
  <input type="submit" value="<?php echo $langcfg["butsavech"]; ?>" name="savelang">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="<?php echo $langcfg["butpv"]; ?>" name="canclechanges">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="<?php echo $langcfg["leaved"]; ?>" name="leaveeditor">  
  </td></tr>
  </table><br>
<?php    
}
?>
</form>
<?php
echo "<br><br>";
include_once("./include/footer.php");

    mysql_free_result($query1);
    exit();
}?>