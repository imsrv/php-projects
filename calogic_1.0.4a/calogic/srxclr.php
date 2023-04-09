<?php
/***************************************************************
** Title.........: CaLogic Send Reminder program
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: srxclr.php
** Last changed..: 
** Use...........: This file will send reminders when called
** Notes.........: 

You must set up some kind of crontab that will call this file
as often as you want reminders to be checked.

You must set variables and read the information in the file
/include/remcfg.php
and in the file readme_reminders.txt

You can rename this file and relocate it if you want.
If you relocate it, you must change the relative paths below
to full paths,. See examples below
***************************************************************/ 

  
/***************************************************************
** included files
** NOTE: do not change the order of appearance  
***************************************************************/    
require_once("./include/config.php");
include_once("./include/dbfunc.php");
include_once("./include/calfunc.php");
include_once("./include/gfunc.php");
include_once("./include/remcfg.php");

# EXAMPLES FOR A RELOCATED REMINDERS SCRIPT
# To use this method, place pound signs in front of
# the require_once and include_once commands above,
# and remove the pound signs from the same commnds below.
# 
# require_once("/home/user/htdocs/calogic/include/config.php");
# include_once("/home/user/htdocs/calogic/include/dbfunc.php");
# include_once("/home/user/htdocs/calogic/include/calfunc.php");
# include_once("/home/user/htdocs/calogic/include/gfunc.php");
# include_once("/home/user/htdocs/calogic/include/remcfg.php");
#
# I have not tested this method, so let me know if you have problems with it.
#
#


global $weekstartonmonday,$daytext,$daytextl,$monthtext,$monthtextl;
global $langcfg;


$remtesting = false;

$numckd = 2;
$mailsent = 0;

if($rinterval > 3) {
    $rinterval = 3;
    $rfrequency = 1;
}
if($rinterval < 1) {
    $rinterval = 1;
    $rfrequency = 5;
}
if($rfrequency < 1) {
    $rfrequency = 1;
}
if($rdahead < 1) {$rdahead = 1;}
if($rdahead > 365) {$rdahead = 365;}

if($rinterval == 1) {
    $rminmin = $rfrequency;
    $rminmax = 60;
    $rhourmin = 1;
    $rhourmax = 24;
    $rdaymin = 1;
    $rdaymax = $rdahead;
    $rfrtval = "Minute(s)";
} elseif($rinterval == 2) {
    $rminmin = 0;
    $rminmax = 0;
    $rhourmin = $rfrequency;
    $rhourmax = 24;
    $rdaymin = 1;
    $rdaymax = $rdahead;
    $rfrtval = "Hour(s)";
} elseif($rinterval == 3) {
    $rminmin = 0;
    $rminmax = 0;
    $rhourmin = 0;
    $rhourmax = 0;
    $rdaymin = $rfrequency;
    $rdaymax = $rdahead;
    $rfrtval = "Day(s)";
    $numckd = $rfrequency + 2;

}

$numckd = $numckd * -1;

//echo $numckd;

//exit();

$chkdate = time();

$chkead = dateadd("d",$numckd,$chkdate);

$chkdar = getdate($chkead);
$chkyear = $chkdar["year"];
$chkmonth = $chkdar["mon"];
$chkday = $chkdar["mday"];
$chkhour = $chkdar["hours"];
$chkmin = $chkdar["minutes"];

//$chkead = $chkyear."-".$chkmonth."-".$chkday;

$chkead = sprintf("%04d-%02d-%02d", $chkyear,$chkmonth,$chkday);

$chkdar = getdate($chkdate);
$chkyear = $chkdar["year"];
$chkmonth = $chkdar["mon"];
$chkday = $chkdar["mday"];
$chkhour = $chkdar["hours"];
$chkmin = $chkdar["minutes"];

$chksaved = sprintf("%04d-%02d-%02d", $chkyear,$chkmonth,$chkday);

//echo "CHKEAD: ".$chkead."<br><br>";
//echo "CHKSAVE: ".$chksaved."<br><br>";

$rdcnt = 0;

// int mktime ( int hour, int minute, int second, int month, int day, int year [, int is_dst])

// first get non repeating events that have not passed since last reminder check

$sqlstr = "Select * from ".$GLOBALS["tabpre"]."_cal_events where sendreminder = 1 and iseventseries = 0 and (to_days('".$chkead."') <= endafterdays or endafterdays = 0) order by calid";
$query1 = mysql_query($sqlstr) or die("Cannot query calendar events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

//echo "Rem SQL: ".$sqlstr."<br><br>";

while($row = mysql_fetch_array($query1)) {
    
// check if event is due to be reminded

    $rcar = array();
    $rcarcnt = 0;
    $evdate = sprintf("%04d-%02d-%02d", $row["startyear"],$row["startmonth"],$row["startday"]);
//echo "reminder loop<br><br>";

// get time zone adjustment of event creator.
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$row["uid"];
    $query2 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $row2 = mysql_fetch_array($query2);
    $evcname = $row2["fname"]." ".$row2["lname"];
    $evcemail = $row2["email"];
    $evctzadj = $row2["tzos"];
    $evclang = $row2["langid"];

    @mysql_free_result($query2);
    

    getcurlang($evclang);
    setviewtext($evclang);


    $chkevdate = mktime($row["starthour"],$row["startmin"],0,$row["startmonth"],$row["startday"],$row["startyear"]);
    
//echo "CHKEVDATE ".$chkevdate."<br><br>";
    
// actual time
            $chkrdate = mktime($chkhour,$chkmin,0,$chkmonth,$chkday,$chkyear);
// event creator adjusted actual time            
            $chkrdate = $chkrdate + $evctzadj;
// reminder adjusted time            
//            $chkrdate = dateadd("n",$row["srval"],$chkrdate);
    
            $chkrdar = getdate($chkrdate);
            $chkryear = $chkrdar["year"];
            $chkrmonth = $chkrdar["mon"];
            $chkrday = $chkrdar["mday"];
            $chkrhour = $chkrdar["hours"];
            $chkrmin = $chkrdar["minutes"];
    
            if($row["srint"] == 1){
            
        // minutes
//                $chkrdate = dateadd("n",$row["srval"],$chkrdate);
                
                $chkevadj = $row["srval"] * 60;
                                
            } elseif($row["srint"] == 2){
        // hours
                $chkevadj = $row["srval"] * 60 * 60;
        
            } elseif($row["srint"] == 3){
        // days
                $chkevadj = $row["srval"] * 24 * 60 * 60;
            
            } else {
            // insert a record in reminder log that states there is a bad reminder interval for event {evid}
                
            }

        
//            if($chkevdate <= $chkrdate && $chkevdate >= $chkdate

//echo "CHKEVDATE ADJUST ".$chkevadj."<br><br>";

            if($chkrdate + $chkevadj >= $chkevdate) {

//echo "checking log<br><br>";
            
                // check reminder log
                
                $sqlstr = "SELECT count(*) as rlcnt FROM ".$GLOBALS["tabpre"]."_rem_log WHERE calid = '".$row["calid"]."' and evid = ".$row["evid"]." and ev_date = '".$evdate."'"; 
                $query2 = mysql_query($sqlstr) or die("Cannot query calendar event reminder log table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                $row2 = mysql_fetch_array($query2);
                $rlcnt = $row2["rlcnt"];

//echo "log count: ".$rlcnt."<br><br>";

                @mysql_free_result($query2);
                
                if($rlcnt < 1) {
                
                // get contacts for the reminder
                
                    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where calid = '".$row["calid"]."' and evid = ".$row["evid"];
                    $query2 = mysql_query($sqlstr) or die("Cannot query calendar event reminders table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                
                    while($row2 = mysql_fetch_array($query2)) {
                    
                //echo "reminder contacts loop<br><br>";
                
                        if($row2["contyp"] == "M") {
                
                            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$row2["conid"];
                            $query3 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                
                            while($row3 = mysql_fetch_array($query3)) {
                            
                                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                                $rcar[$rcarcnt]["email"] = $row3["email"];
                                $rcar[$rcarcnt]["tzos"] = $row3["tzos"];
                                $rcar[$rcarcnt]["ctype"] = "M";
                //                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                
                                $rcarcnt++;
                                break;
                            } 
                            
                            @mysql_free_result($query3);
                
                        } elseif($row2["contyp"] == "C") {
                    
                            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_con where conid = ".$row2["conid"];
                            $query3 = mysql_query($sqlstr) or die("Cannot query user contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                
                            while($row3 = mysql_fetch_array($query3)) {
                            
                                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                                $rcar[$rcarcnt]["email"] = $row3["email"];
                                $rcar[$rcarcnt]["tzos"] = $row3["tzos"];
                                $rcar[$rcarcnt]["ctype"] = "C";
                //                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                
                                $rcarcnt++;
                                break;
                            } 
                            
                            @mysql_free_result($query3);
                
                        } elseif($row2["contyp"] == "G") {
                
                            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_con where uid = ".$row2["uid"]." and congp = ".$row2["conid"];
                            $query3 = mysql_query($sqlstr) or die("Cannot query user contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                
                            while($row3 = mysql_fetch_array($query3)) {
                            
                                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                                $rcar[$rcarcnt]["email"] = $row3["email"];
                                $rcar[$rcarcnt]["tzos"] = $row3["tzos"];
                                $rcar[$rcarcnt]["ctype"] = "G";
                //                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                
                                $rcarcnt++;
                            } 
                            
                            @mysql_free_result($query3);
                        }
                    }
                
                    @mysql_free_result($query2);


                    foreach($rcar as $k1 => $v1) {
                    
                        $regmail = new html_mime_mail('X-Mailer: Html Mime Mail Class');

                // send reminder
                
                        $regembody="<HTML><BODY>Hello ".$rcar[$k1]["name"].",<br><br>
                        This is an Event Reminder being sent to you by the CaLogic Calendar application running at 
                        ".$GLOBALS["sitetitle"]." (<a href=\"".$GLOBALS["baseurl"]."\">".$GLOBALS["baseurl"]."</a>).<br><br>
                        This event was created by: <a href=\"mailto:".$evcemail."\">".$evcname."</a><br><br>
                        <h3>Event Information</h3>
                        <table border=\"0\" width=\"100%\">
                        <tr>
                        <th align=\"left\" width=\"12%\" valign=\"top\">Title:</th>
                        <td width=\"88%\" valign=\"top\">
                        
                        ".$row["title"]."
                        
                        </td>
                        </tr>
                        <tr>
                        <th align=\"left\" width=\"12%\" valign=\"top\">Category:</th>
                        <td width=\"88%\" valign=\"top\">";
                        
                        if($row["catid"] == 0) {
                            $regembody .= "None assigned";
                        } else {
                            $sqlstr = "SELECT * FROM ".$GLOBALS["tabpre"]."_user_cat WHERE catid = ".$row["catid"]; 
                            $query2 = mysql_query($sqlstr) or die("Cannot query user category table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $row2 = mysql_fetch_array($query2);
                            $regembody .= $row2["catname"];
                            @mysql_free_result($query2);
                        }
                        
                        $regembody .= "</td>
                        </tr>
                        <tr>
                        <th align=\"left\" width=\"12%\" valign=\"top\">Description:</th>
                        <td width=\"88%\" valign=\"top\">
                        
                        ".nl2br($row["description"])."
                        
                        </td>
                        </tr>
                        <tr>
                        <th align=\"left\" width=\"12%\" valign=\"top\">
                        Date:</th>
                        <td width=\"88%\" valign=\"top\">";
                        

                        $tmtxt = $row["startmonth"];
                        if(substr($tmtxt,0,1) == "0") {$tmtxt = substr($tmtxt,1,1);}
                        $regembody .= $row["startday"].".".$monthtextl[$tmtxt].".".$row["startyear"];
                        $regembody .= "</td>
                        </tr>
                        <tr>
                        <th align=\"left\" width=\"12%\" valign=\"top\">
                        Time:</th>
                        <td width=\"88%\" valign=\"top\">";

                        if($row["isallday"] == 1) {
                            $regembody .= "This is an all day event\n";
                        } else {
                            $regembody .= "From: ".$row["starthour"].":".$row["startmin"]."&nbsp;&nbsp;To: ".$row["endhour"].":".$row["endmin"];
                        }
                        
                        $regembody .= "</td>
                        </tr>
                        <tr>
                        </table>";
                                    
if($remtesting == true) {
                                    $regembody .= "<br><br><br><b>
            This is a test, you are receiving this mail because you created a Calendar and or event with reminder 
            at the demo calendar web site of CaLogic, or the person who created this event with reminder has you as his/her contact, 
            and has included you in the reminder.
            </b>";       
}                            
                                    $regembody .= "</body></html>";                        


    
                        $regmail->add_html($regembody, '');
                        $regmail->set_charset('iso-8859-1', TRUE);
                        $regmail->build_message();
                        //$mail->send('TO NAME', 'TO ADDRESS', 'FROM NAME', 'FROM ADDRESS', 'SUBJECT LINE');
                        $toname = $rcar[$k1]["name"];
                        $tomail = $rcar[$k1]["email"];
                        if(strlen(trim($tomail)) > 0) {
                            $regmail->send("$toname", "$tomail", "$evcname", "$evcemail","Event Reminder");
//                            $regmail->send("Philip", "philip@boone.at", "$evcname", "$evcemail","Event Reminder");
                            $mailsent++;
                        }
                    }

                    $sqlstr = "insert into ".$GLOBALS["tabpre"]."_rem_log (calid,evid,chk_date,ev_date) values('".$row["calid"]."',".$row["evid"].",'".$chksaved."','".$evdate."')"; 
                    $query2 = mysql_query($sqlstr) or die("Cannot insert into calendar event reminder log table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                }
            } else {
// time is passed, check if event was reminded i.e. a late reminder

                
            }

} // end while reminder select
 
@mysql_free_result($query1);

$chksedate = $chkdate;

for($exd=0;$exd<=$rdahead;$exd++) {

$chksedar = getdate($chksedate);
$chkseyear = $chksedar["year"];
$chksemonth = $chksedar["mon"];
$chkseday = $chksedar["mday"];
$chksehour = $chksedar["hours"];
$chksemin = $chksedar["minutes"];

$chksedate = mktime(0,0,0,$chksemonth,$chkseday,$chkseyear);
$chksedate = dateadd("d",$exd,$chksedate);

$chksedar = getdate($chksedate);
$chkseyear = $chksedar["year"];
$chksemonth = $chksedar["mon"];
$chkseday = $chksedar["mday"];

$chksead = sprintf("%04d-%02d-%02d", $chkseyear,$chksemonth,$chkseday);

$eyear = $chkseyear;
$emonth = $chksemonth;
$eday = $chkseday;

$sqlstr = "Select * from ".$GLOBALS["tabpre"]."_cal_events t where 
(sendreminder = 1 and t.iseventseries = 1 and to_days(CONCAT_WS('-', t.startyear, t.startmonth,t.startday)) <= to_days('".$chksead."'))
and ((ese = 2 and to_days('".$chksead."') <= to_days(CONCAT_WS('-', t.esey, t.esem,t.esed))) or (t.ese=0) or (t.ese=1 and to_days('".$chksead."') <= endafterdays)) order by t.isallday desc,t.starthour,t.startmin";

        $query1 = mysql_query($sqlstr) or die("Cannot query calendar series in events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
        $endint = 0;
        
        while($row = mysql_fetch_array($query1)) {
        
            $haveevent = false;
            $xuts1 = mktime(0,0,0,$emonth,$eday,$eyear);
            $xuts2 = mktime(0,0,0,$row["startmonth"],$row["startday"],$row["startyear"]);
            $xdinf = getdate($xuts1);
            $xsdinf = getdate($xuts2);

            if($xuts1 >= $xuts2) {
// is passed date >= check date (event)           
                if($row["estype"] == 1) {
// daily            
                    if($row["ese"] == 1) {
// end interval
                        $endint = $row["eseaoint"];
                        
                        if($row["estd"] == 1) {
// every day interval
                            if(((datediff("d", $xuts2,$xuts1)) % ($row["estdint"])) == 0) {
                                if( ((datediff("d", $xuts2,$xuts1)) / $row["estdint"] ) < $endint) {
                                    $haveevent = true;
                                }
                            }
                                                        
                        } elseif($xdinf["wday"] > 0 && $xdinf["wday"] < 6) {
// every week day
                            if( (datediff("d", $xuts2,$xuts1)) < $endint) {
                                $haveevent = true;
                            }
                        }
                        
                    } elseif($row["ese"] == 2) {
                    
// end on a certain date
                        $xuts3 = mktime(0,0,0,$row["esem"],$row["esed"],$row["esey"]);
                        
                        if($xuts1 <= $xuts3) {

                            if($row["estd"] == 1) {
    // interval
                                if(((datediff("d", $xuts2,$xuts1)) % ($row["estdint"])) == 0) {
                                    $haveevent = true;
                                }
                                                            
                            } elseif($xdinf["wday"] > 0 && $xdinf["wday"] < 6) {
    // every day
                                $haveevent = true;
                            }
                        }
                        
                    } else {
// no end
                        if($row["estd"] == 1) {
// interval
                            if(((datediff("d", $xuts2,$xuts1)) % ($row["estdint"])) == 0) {
                                $haveevent = true;
                            }
                                                        
                        } elseif($xdinf["wday"] > 0 && $xdinf["wday"] < 6) {
// every day
                            $haveevent = true;
                        }
                    }
                    
                } elseif($row["estype"] == 2) {
// weekly    
                    if($xdinf["wday"] == 0) {
                        $wdgt = 7;
                    } else {
                        $wdgt = $xdinf["wday"];
                    }
                    $wdgt--;
// check week array
                    if(substr($row["estwd"],$wdgt,1) == "1") {
                    
                        if($row["ese"] == 1) {
    // end interval
                            $endint = $row["eseaoint"];
                            if(((datediff("w", $xuts2,$xuts1)) % ($row["estwint"])) == 0) {
    // interval
                                if( ((datediff("w", $xuts2,$xuts1)) / $row["estwint"] ) < $endint) {
    // end occur
                                    $haveevent = true;
                                }
                            }
                        } elseif($row["ese"] == 2) {
    // end on a certain date
                            $xuts3 = mktime(0,0,0,$row["esem"],$row["esed"],$row["esey"]);
                            if($xuts1 <= $xuts3) {
                                if(((datediff("w", $xuts2,$xuts1)) % ($row["estwint"])) == 0) {
                                    $haveevent = true;
                                }
                            }
                        } else {
    // no end
                            if(((datediff("w", $xuts2,$xuts1)) % ($row["estwint"])) == 0) {
                                $haveevent = true;
                            }
                        }
                    } // day not in week array
                            
                } elseif($row["estype"] == 3) {
// monthly    

// Monthly type 1
                    if($row["estm"] == 1) {

                        $mint = $row["estm1int"];

                        $xuts4 = mktime(0,0,0,$emonth,$eday,$eyear);
                        $xuts4 = dateadd("d",1,$xuts4);
                        $dtinf4 = getdate($xuts4);

                        if($xdinf["mon"] != $dtinf4["mon"]) {$islastday = 1;} else {$islastday = 0;}
                        if($row["estm1d"] > 28 ) {$eild = 1;} else {$eild = 0;}
                        $xkd3 = date("Y-m-d",mktime(0,0,0,$emonth,$row["estm1d"],$eyear));
                        $xkd4 = mktime(0,0,0,$emonth,$row["estm1d"],$eyear);
                        $xkdinf = getdate($xkd4);
                        if($xkd3 == "1970-01-01" || $xkdinf["mon"] != $xdinf["mon"]) {$okild = 1;} else {$okild = 0;}

                        if(($row["estm1d"] == $xdinf["mday"]) || ($eild == 1 && $islastday == 1 && $okild == 1)) {
// first check, is day the same, or if 
// the day falls on 29 - 31,
// is this the last day of month                            
                            $xuts4 = mktime(0,0,0,$row["startmonth"],1,$row["startyear"]);
                            $dtinf4 = getdate($xuts4);
                            $ckint = 0;
                            
                            if($row["ese"] == 1) {
// event end after so many
                                while($xuts4 <= $xuts1 && $ckint <= $row["eseaoint"]) {
                                    $ckint++;
//                                    if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"])) {
                                    if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"]) && ($ckint <= $row["eseaoint"])) {
                                        $haveevent = true;
                                        break;
                                    }
                                    $xuts4 = dateadd("m",$mint,$xuts4);
                                    $dtinf4 = getdate($xuts4);
                                }
                                
                            } elseif($row["ese"] == 2) {
// end after date                            
                                $eoint = mktime(0,0,0,$row["esem"],$row["esed"],$row["esey"]);
                                $xuts5 = mktime(0,0,0,$emonth,$row["estm1d"],$eyear);
                                if($xuts5 <= $eoint) {
                                    while($xuts4 <= $xuts1) {
                                        if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"])) {
                                            $haveevent = true;
                                            break;
                                        }
                                        $xuts4 = dateadd("m",$mint,$xuts4);
                                        $dtinf4 = getdate($xuts4);
                                    }
                                }
                            
                            } else {
//no end
                                while($xuts4 <= $xuts1) {
                                    if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"])) {
                                        $haveevent = true;
                                        break;
                                    }
                                    $xuts4 = dateadd("m",$mint,$xuts4);
                                    $dtinf4 = getdate($xuts4);
                                }
                            }
                        }

                    } else {
// Month type 2
// same day pos
// every so many mnths
                        $mint = $row["estm2int"];
                        
                        $yuts1 = mktime(0,0,0,$emonth,$eday,$eyear);
//                            $yuts2 = mktime(0,0,0,$row["esty2m"],1,$eyear);
                        
                        $ydinf1 = getdate($yuts1);
//                            $ydinf2 = getdate($yuts2);

                        $wdc = array();
                        $wddc = 0;
                        $wedc = 0;
                        
                        
                        $fyear=$eyear;
                        $fmonth=$emonth;
                        $fday=$eday;
                      
                        $cuts = mktime(0,0,0,$fmonth,$fday,$fyear);
                      
//                            $zuts = dateadd("yyyy",1,$cuts);
//                            $zxfdate = getdate($zuts);
                      
                        $xfuncdate = getdate($cuts);
                        $fdow = $xfuncdate["wday"];
                        $xfdow = $fdow;
                        $rfdow = $fdow;
                        if($fdow==0) {$fdow=7;}
                        if($fdow < 6) {$isweekday = 1;} else {$isweekday = 0;}
                        $zfcday = 1;                    
                        $tuts = mktime(0,0,0,$fmonth,$zfcday,$fyear);
                        $zfuncdate = getdate($tuts);
                        $weekdaypos = 0;
                        $weekdayposcnt = 0;
                        $islastpos = 1;
                        $islastposcnt = 0;
                        $wddnum = 0;
                        $wednum = 0;
                        $islastwe = 1;
                        $islastwd = 1;
                                              
                        while(($zfuncdate["mon"] == $xfuncdate["mon"])) {
                            if(($zfuncdate["wday"] == $rfdow) && ($zfuncdate["mday"] <= $xfuncdate["mday"])) {
                                $weekdaypos++;
                                $weekdayposcnt++;
                            }
                            if($zfuncdate["mday"] <= $xfuncdate["mday"]) {
                                if($zfuncdate["wday"] == 0 || $zfuncdate["wday"] == 6) {
                                    $wednum++;
                                } else {
                                    $wddnum++;
                                }
                            }
                      
                            
                            if($zfuncdate["mday"] > $xfuncdate["mday"]) {
                                if($zfuncdate["wday"] == 0 || $zfuncdate["wday"] == 6) {
                                    $islastwe = 0;
                                } else {
                                    $islastwd = 0;
                                }
                                if($zfuncdate["wday"] == $rfdow) {
                                    $islastpos = 0;
                                    $islastposcnt++;
                                }
                            }
                      
                            $zfcday++;
                            $tuts = mktime(0,0,0,$fmonth,$zfcday,$fyear);
                            $zfuncdate = getdate($tuts);
                        }
                        
                        $xuts4 = mktime(0,0,0,$emonth,$eday,$eyear);
                        $xuts4 = dateadd("d",1,$xuts4);
                        $dtinf4 = getdate($xuts4);
                        if($xdinf["mon"] != $dtinf4["mon"]) {$islastday = 1;} else {$islastday = 0;}


                        if(($row["estm2dp"] == 5 && $islastpos == 1 && $fdow == $row["estm2wd"]) || 
                           ($row["estm2dp"] == $weekdaypos && $fdow == $row["estm2wd"]) ||
                           ($row["estm2dp"] == $wednum && $row["estm2wd"] == 9 && $isweekday == 0 && $row["estm2dp"] < 5) ||
                           ($row["estm2dp"] == $wddnum && $row["estm2wd"] == 8 && $isweekday == 1 && $row["estm2dp"] < 5) ||
                           ($row["estm2dp"] == 1 && $row["estm2wd"] == 10 && $eday == "01") ||
                           ($row["estm2dp"] == 1 && $row["estm2wd"] == 9 && $wednum == 1 && $isweekday == 0) ||
                           ($row["estm2dp"] == 1 && $row["estm2wd"] == 8 && $wddnum == 1 && $isweekday == 1) ||
                           ($row["estm2dp"] == 5 && $row["estm2wd"] == 10 && $islastday == 1) ||
                           ($row["estm2dp"] == 5 && $row["estm2wd"] == 9 && $islastwe == 1 && $isweekday == 0) ||
                           ($row["estm2dp"] == 5 && $row["estm2wd"] == 8 && $islastwd == 1 && $isweekday == 1)) {
                    
                            $xuts4 = mktime(0,0,0,$row["startmonth"],1,$row["startyear"]);
                            $dtinf4 = getdate($xuts4);
                            $ckint = 0;
                            
                            if($row["ese"] == 1) {
// event end after so many
                                while($xuts4 <= $xuts1 && $ckint <= $row["eseaoint"]) {
                                    $ckint++;
                                    if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"]) && ($ckint <= $row["eseaoint"])) {
                                        $haveevent = true;
                                        break;
                                    }
                                    $xuts4 = dateadd("m",$mint,$xuts4);
                                    $dtinf4 = getdate($xuts4);
                                }
                                
                            } elseif($row["ese"] == 2) {
// end after date                            
                                $eoint = mktime(0,0,0,$row["esem"],$row["esed"],$row["esey"]);
                                $xuts5 = mktime(0,0,0,$emonth,$row["estm1d"],$eyear);
                                if($xuts5 <= $eoint) {
                                    while($xuts4 <= $xuts1) {
                                        if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"])) {
                                            $haveevent = true;
                                            break;
                                        }
                                        $xuts4 = dateadd("m",$mint,$xuts4);
                                        $dtinf4 = getdate($xuts4);
                                    }
                                }
                            
                            } else {
//no end
                                while($xuts4 <= $xuts1) {
                                    if(($xdinf["mon"] == $dtinf4["mon"]) && ($xdinf["year"] == $dtinf4["year"])) {
                                        $haveevent = true;
                                        break;
                                    }
                                    $xuts4 = dateadd("m",$mint,$xuts4);
                                    $dtinf4 = getdate($xuts4);
                                }
                            }
                                
                        }
// end month type 2                    
                    }

                } elseif($row["estype"] == 4) {
// yearly                
                    if($row["esty"] == 1) {
// same day every year                        
                        if(($row["esty1d"] == $eday) && ($row["esty1m"] == $emonth) && ($row["startyear"] <= $eyear) ) { 
                            if($row["ese"] == 1) {
// end interval
                                $endint = $row["eseaoint"];
                                if($eyear < ($row["startyear"] + $endint)) {
                                    $haveevent = true;
                                }

                            } elseif($row["ese"] == 2) {
// end date
                                $xuts3 = mktime(0,0,0,$row["esem"],$row["esed"],$row["esey"]);
                                if($xuts1 <= $xuts3) {
                                    $haveevent = true;
                                }
                            } else {
//no end
                                $haveevent = true;
                            }
                        }
                        
                    } else {
//same day pos                         
                        if($row["esty2m"] == $emonth) {
// is same month                        
                            $yuts1 = mktime(0,0,0,$emonth,$eday,$eyear);
                            $yuts2 = mktime(0,0,0,$row["esty2m"],1,$eyear);
                            $ydinf1 = getdate($yuts1);
                            $ydinf2 = getdate($yuts2);
                            $wdc = array();
                            $wddc = 0;
                            $wedc = 0;
                            
                            
                            $fyear=$eyear;
                            $fmonth=$emonth;
                            $fday=$eday;
                          
                            $cuts = mktime(0,0,0,$fmonth,$fday,$fyear);
                          
                            $zuts = dateadd("yyyy",1,$cuts);
                            $zxfdate = getdate($zuts);
                          
                            $xfuncdate = getdate($cuts);
                            $fdow = $xfuncdate["wday"];
                            $xfdow = $fdow;
                            $rfdow = $fdow;
                            if($fdow==0) {$fdow=7;}
                            if($fdow < 6) {$isweekday = 1;} else {$isweekday = 0;}
                            $zfcday = 1;                    
                            $tuts = mktime(0,0,0,$fmonth,$zfcday,$fyear);
                            $zfuncdate = getdate($tuts);
                            $weekdaypos = 0;
                            $weekdayposcnt = 0;
                            $islastpos = 1;
                            $islastposcnt = 0;
                            $wddnum = 0;
                            $wednum = 0;
                            $islastwe = 1;
                            $islastwd = 1;
                                                  
                            while(($zfuncdate["mon"] == $xfuncdate["mon"])) {
                                if(($zfuncdate["wday"] == $rfdow) && ($zfuncdate["mday"] <= $xfuncdate["mday"])) {
                                    $weekdaypos++;
                                    $weekdayposcnt++;
                                }
                                if($zfuncdate["mday"] <= $xfuncdate["mday"]) {
                                    if($zfuncdate["wday"] == 0 || $zfuncdate["wday"] == 6) {
                                        $wednum++;
                                    } else {
                                        $wddnum++;
                                    }
                                }
                          
                                
                                if($zfuncdate["mday"] > $xfuncdate["mday"]) {
                                    if($zfuncdate["wday"] == 0 || $zfuncdate["wday"] == 6) {
                                        $islastwe = 0;
                                    } else {
                                        $islastwd = 0;
                                    }
                                    if($zfuncdate["wday"] == $rfdow) {
                                        $islastpos = 0;
                                        $islastposcnt++;
                                    }
                                }
                          
                                $zfcday++;
                                $tuts = mktime(0,0,0,$fmonth,$zfcday,$fyear);
                                $zfuncdate = getdate($tuts);
                            }
                            
                            $xuts4 = mktime(0,0,0,$emonth,$eday,$eyear);
                            $xuts4 = dateadd("d",1,$xuts4);
                            $dtinf4 = getdate($xuts4);
                            if($xdinf["mon"] != $dtinf4["mon"]) {$islastday = 1;} else {$islastday = 0;}

                            if(($row["esty2dp"] == 5 && $islastpos == 1 && $fdow == $row["esty2wd"]) || 
                               ($row["esty2dp"] == $weekdaypos && $fdow == $row["esty2wd"]) ||
                               ($row["esty2dp"] == $wednum && $row["esty2wd"] == 9 && $isweekday == 0 && $row["esty2dp"] < 5) ||
                               ($row["esty2dp"] == $wddnum && $row["esty2wd"] == 8 && $isweekday == 1 && $row["esty2dp"] < 5) ||
                               ($row["esty2dp"] == 1 && $row["esty2wd"] == 10 && $eday == "01") ||
                               ($row["esty2dp"] == 1 && $row["esty2wd"] == 9 && $wednum == 1 && $isweekday == 0) ||
                               ($row["esty2dp"] == 1 && $row["esty2wd"] == 8 && $wddnum == 1 && $isweekday == 1) ||
                               ($row["esty2dp"] == 5 && $row["esty2wd"] == 10 && $islastday == 1) ||
                               ($row["esty2dp"] == 5 && $row["esty2wd"] == 9 && $islastwe == 1 && $isweekday == 0) ||
                               ($row["esty2dp"] == 5 && $row["esty2wd"] == 8 && $islastwd == 1 && $isweekday == 1)) {
                    
                                if($row["ese"] == 1) {
        // end after so many
                                    $endint = $row["eseaoint"];
                                    if($eyear < ($row["startyear"] + $endint)) {
                                        $haveevent = true;
                                    }
                                    
                                } elseif($row["ese"] == 2) {
        // end on date                        
                                    $xuts3 = mktime(0,0,0,$row["esem"],$row["esed"],$row["esey"]);
                                    if($xuts1 <= $xuts3) {
                                        $haveevent = true;
                                    }
                                } else {
        // no end                        
                                    $haveevent = true;
                                }
                            }
                        }
                    }
                }
                
            }  // is passed date >= check date
            

            if($haveevent == true) {  
            
// the day checks, now the time                  


                $rcar = array();
                $rcarcnt = 0;
                $evdate = sprintf("%04d-%02d-%02d", $chkseyear,$chksemonth,$chkseday);

/*
$chkseyear = $chksedar["year"];
$chksemonth = $chksedar["mon"];
$chkseday = $chksedar["mday"];
$chksehour = $chksedar["hours"];
$chksemin = $chksedar["minutes"];

$chksedate = mktime(0,0,0,$chksemonth,$chkseday,$chkseyear);
$chksedate = dateadd("d",$exd,$chksedate);

$chksedar = getdate($chksedate);
$chkseyear = $chksedar["year"];
$chksemonth = $chksedar["mon"];
$chkseday = $chksedar["mday"];

$chksead = sprintf("%04d-%02d-%02d", $chkseyear,$chksemonth,$chkseday);

*/

            //echo "reminder loop<br><br>";
            
            // get time zone adjustment of event creator.
                $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$row["uid"];
                $query2 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                $row2 = mysql_fetch_array($query2);
                $evcname = $row2["fname"]." ".$row2["lname"];
                $evcemail = $row2["email"];
                $evctzadj = $row2["tzos"];
                $evclang = $row2["langid"];
            
                @mysql_free_result($query2);
                
            
                getcurlang($evclang);
                setviewtext($evclang);
            
            
                $chkevdate = mktime($row["starthour"],$row["startmin"],0,$chksemonth,$chkseday,$chkseyear);
                
            //echo "CHKEVDATE ".$chkevdate."<br><br>";
                
            // actual time
                        $chkrdate = mktime($chkhour,$chkmin,0,$chkmonth,$chkday,$chkyear);
            // event creator adjusted actual time            
                        $chkrdate = $chkrdate + $evctzadj;
            // reminder adjusted time            
            //            $chkrdate = dateadd("n",$row["srval"],$chkrdate);
                
                        $chkrdar = getdate($chkrdate);
                        $chkryear = $chkrdar["year"];
                        $chkrmonth = $chkrdar["mon"];
                        $chkrday = $chkrdar["mday"];
                        $chkrhour = $chkrdar["hours"];
                        $chkrmin = $chkrdar["minutes"];
                
                        if($row["srint"] == 1){
                        
                    // minutes
            //                $chkrdate = dateadd("n",$row["srval"],$chkrdate);
                            
                            $chkevadj = $row["srval"] * 60;
                                            
                        } elseif($row["srint"] == 2){
                    // hours
                            $chkevadj = $row["srval"] * 60 * 60;
                    
                        } elseif($row["srint"] == 3){
                    // days
                            $chkevadj = $row["srval"] * 24 * 60 * 60;
                        
                        } else {
                        // insert a record in reminder log that states there is a bad reminder interval for event {evid}
                            
                        }
            
                    
            //            if($chkevdate <= $chkrdate && $chkevdate >= $chkdate
            
            //echo "CHKEVDATE ADJUST ".$chkevadj."<br><br>";
            
                        if($chkrdate + $chkevadj >= $chkevdate) {
            
            //echo "checking log<br><br>";
                        
                            // check reminder log
                            
                            $sqlstr = "SELECT count(*) as rlcnt FROM ".$GLOBALS["tabpre"]."_rem_log WHERE calid = '".$row["calid"]."' and evid = ".$row["evid"]." and ev_date = '".$evdate."'"; 
                            $query2 = mysql_query($sqlstr) or die("Cannot query calendar event reminder log table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $row2 = mysql_fetch_array($query2);
                            $rlcnt = $row2["rlcnt"];
            
            //echo "log count: ".$rlcnt."<br><br>";
            
                            @mysql_free_result($query2);
                            
                            if($rlcnt < 1) {
                            
                            // get contacts for the reminder
                            
                                $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where calid = '".$row["calid"]."' and evid = ".$row["evid"];
                                $query2 = mysql_query($sqlstr) or die("Cannot query calendar event reminders table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            
                                while($row2 = mysql_fetch_array($query2)) {
                                
                            //echo "reminder contacts loop<br><br>";
                            
                                    if($row2["contyp"] == "M") {
                            
                                        $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$row2["conid"];
                                        $query3 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            
                                        while($row3 = mysql_fetch_array($query3)) {
                                        
                                            $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                                            $rcar[$rcarcnt]["email"] = $row3["email"];
                                            $rcar[$rcarcnt]["tzos"] = $row3["tzos"];
                                            $rcar[$rcarcnt]["ctype"] = "M";
                            //                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                            
                                            $rcarcnt++;
                                            break;
                                        } 
                                        
                                        @mysql_free_result($query3);
                            
                                    } elseif($row2["contyp"] == "C") {
                                
                                        $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_con where conid = ".$row2["conid"];
                                        $query3 = mysql_query($sqlstr) or die("Cannot query user contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            
                                        while($row3 = mysql_fetch_array($query3)) {
                                        
                                            $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                                            $rcar[$rcarcnt]["email"] = $row3["email"];
                                            $rcar[$rcarcnt]["tzos"] = $row3["tzos"];
                                            $rcar[$rcarcnt]["ctype"] = "C";
                            //                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                            
                                            $rcarcnt++;
                                            break;
                                        } 
                                        
                                        @mysql_free_result($query3);
                            
                                    } elseif($row2["contyp"] == "G") {
                            
                                        $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_con where uid = ".$row2["uid"]." and congp = ".$row2["conid"];
                                        $query3 = mysql_query($sqlstr) or die("Cannot query user contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            
                                        while($row3 = mysql_fetch_array($query3)) {
                                        
                                            $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                                            $rcar[$rcarcnt]["email"] = $row3["email"];
                                            $rcar[$rcarcnt]["tzos"] = $row3["tzos"];
                                            $rcar[$rcarcnt]["ctype"] = "G";
                            //                $rcar[$rcarcnt]["name"] = $row3["fname"]." ".$row3["lname"];
                            
                                            $rcarcnt++;
                                        } 
                                        
                                        @mysql_free_result($query3);
                                    }
                                }
                            
                                @mysql_free_result($query2);
            
            
                                foreach($rcar as $k1 => $v1) {
                                
                                    $regmail = new html_mime_mail('X-Mailer: Html Mime Mail Class');
            
                            // send reminder
                            
                                    $regembody="<HTML><BODY>Hello ".$rcar[$k1]["name"].",<br><br>
                                    This is an Event Reminder being sent to you by the CaLogic Calendar application running at 
                                    ".$GLOBALS["sitetitle"]." (<a href=\"".$GLOBALS["baseurl"]."\">".$GLOBALS["baseurl"]."</a>).<br><br>
                                    This event was created by: <a href=\"mailto:".$evcemail."\">".$evcname."</a><br><br>
                                    <h3>Event Information</h3>
                                    <table border=\"0\" width=\"100%\">
                                    <tr>
                                    <th align=\"left\" width=\"12%\" valign=\"top\">Title:</th>
                                    <td width=\"88%\" valign=\"top\">
                                    
                                    ".$row["title"]."
                                    
                                    </td>
                                    </tr>
                                    <tr>
                                    <th align=\"left\" width=\"12%\" valign=\"top\">Category:</th>
                                    <td width=\"88%\" valign=\"top\">";
                                    
                                    if($row["catid"] == 0) {
                                        $regembody .= "None assigned";
                                    } else {
                                        $sqlstr = "SELECT * FROM ".$GLOBALS["tabpre"]."_user_cat WHERE catid = ".$row["catid"]; 
                                        $query2 = mysql_query($sqlstr) or die("Cannot query user category table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                                        $row2 = mysql_fetch_array($query2);
                                        $regembody .= $row2["catname"];
                                        @mysql_free_result($query2);
                                    }
                                    
                                    $regembody .= "</td>
                                    </tr>
                                    <tr>
                                    <th align=\"left\" width=\"12%\" valign=\"top\">Description:</th>
                                    <td width=\"88%\" valign=\"top\">
                                    
                                    ".nl2br($row["description"])."
                                    
                                    </td>
                                    </tr>
                                    <tr>
                                    <th align=\"left\" width=\"12%\" valign=\"top\">
                                    Date:</th>
                                    <td width=\"88%\" valign=\"top\">";
                                    
            
                                    $tmtxt = $row["startmonth"];
                                    if(substr($tmtxt,0,1) == "0") {$tmtxt = substr($tmtxt,1,1);}
                                    $regembody .= $row["startday"].".".$monthtextl[$tmtxt].".".$row["startyear"];
                                    $regembody .= "</td>
                                    </tr>
                                    <tr>
                                    <th align=\"left\" width=\"12%\" valign=\"top\">
                                    Time:</th>
                                    <td width=\"88%\" valign=\"top\">";
            
                                    if($row["isallday"] == 1) {
                                        $regembody .= "This is an all day event\n";
                                    } else {
                                        $regembody .= "From: ".$row["starthour"].":".$row["startmin"]."&nbsp;&nbsp;To: ".$row["endhour"].":".$row["endmin"];
                                    }
                                    
                                    $regembody .= "</td>
                                    </tr>
                                    <tr>
                                    </table>";
                                    
if($remtesting == true) {
                                    $regembody .= "<br><br><br><b>
            This is a test, you are receiving this mail because you created a Calendar and or event with reminder 
            at the demo calendar web site of CaLogic, or the person who created this event with reminder has you as his/her contact, 
            and has included you in the reminder.
            </b>";       
}                            
                                    $regembody .= "</body></html>";                        

                                    $regmail->add_html($regembody, '');
                                    $regmail->set_charset('iso-8859-1', TRUE);
                                    $regmail->build_message();
                                    //$mail->send('TO NAME', 'TO ADDRESS', 'FROM NAME', 'FROM ADDRESS', 'SUBJECT LINE');
                                    $toname = $rcar[$k1]["name"];
                                    $tomail = $rcar[$k1]["email"];
                                    if(strlen(trim($tomail)) > 0) {
                                        $regmail->send("$toname", "$tomail", "$evcname", "$evcemail","Event Reminder");
            //                            $regmail->send("Philip", "philip@boone.at", "$evcname", "$evcemail","Event Reminder");
                                        $mailsent++;
                                    }
                                }
            
                                $sqlstr = "insert into ".$GLOBALS["tabpre"]."_rem_log (calid,evid,chk_date,ev_date) values('".$row["calid"]."',".$row["evid"].",'".$chksaved."','".$evdate."')"; 
                                $query2 = mysql_query($sqlstr) or die("Cannot insert into calendar event reminder log table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            }
                        } else {
            // time is passed, check if event was reminded i.e. a late reminder
            
                            
                        }

            }
        }
        
        @mysql_free_result($query1);

} // end for days in the future        


echo "Reminders check finished.<br><br>\n";
echo $mailsent." Reminder mails sent.";

?>