<?php

/***************************************************************
** Title.........: Calendar Functions
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: calfunc.php
** Last changed..: 
** Notes.........: 
** Use...........: 
                   

** Functions: 
 
                                 
***************************************************************/ 

/***************************************************************
** 
***************************************************************/    

function datediff ($interval, $date1,$date2) {

    // get the number of seconds between the two dates
    $timedifference =  $date2 - $date1;
    
    switch ($interval) {
        case "w":
            $retval  = bcdiv($timedifference ,604800);
            break;
        case "d":
            $retval  = bcdiv( $timedifference,86400);
            break;
        case "h":
             $retval = bcdiv ($timedifference,3600);
            break;        
        case "n":
            $retval  = bcdiv( $timedifference,60);
            break;        
        case "s":
            $retval  = $timedifference;
            break;        

    }    
    return $retval;
    
}

function dateadd ($interval,  $number, $date) {

    /*
    yyyy     year
    q	Quarter
    m	Month
    y	Day of year
    d	Day
    w	Weekday
    ww  Week of year
    h	Hour
    n	Minute
    s	Second
    
    */
    $date_time_array  = getdate($date);
        
    $hours =  $date_time_array["hours"];
    $minutes =  $date_time_array["minutes"];
    $seconds =  $date_time_array["seconds"];
    $month =  $date_time_array["mon"];
    $day =  $date_time_array["mday"];
    $year =  $date_time_array["year"];

    switch ($interval) {
    
        case "yyyy":
            $year +=$number;
            break;        
        case "q":
            $year +=($number*3);
            break;        
        case "m":
            $month +=$number;
            break;        
        case "y":
        case "d":
        case "w":
             $day+=$number;
            break;        
        case "ww":
             $day+=($number*7);
            break;        
        case "h":
             $hours+=$number;
            break;        
        case "n":
             $minutes+=$number;
            break;        
        case "s":
             $seconds+=$number;
            break;        

    }    
    $timestamp =  mktime($hours ,$minutes, $seconds,$month ,$day, $year);
    return $timestamp;
}

function minical($sday,$smonth,$syear,$swcw) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl,$wsbfd,$wsbld,$weekselreact,$fsize;
    global $langcfg;
    
    
    $startmonth = $smonth;
    $startday = $sday;
    $startyear = $syear;
    
    $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);
    
    $firstweekdaynum = strftime("%u",mktime(0,0,0,$startmonth,$startday,$startyear));
     
    $date_time_array = getdate ($cuts);
    $todayday = $date_time_array[ "mday"];
    $todaymonth = $date_time_array[ "mon"];
    $todayyear = $date_time_array[ "year"];
    
    $xuts = mktime(0,0,0,$todaymonth,$todayday,$todayyear);
     
    $xdta = getdate ($xuts);
    $xdtm = $xdta[ "month"];
    
    $lyear = strftime("%Y",$xuts);
    $lmonth = strftime("%m",$xuts);
    
    $date_time_array = getdate (time());
    $todayday = $date_time_array[ "mday"];
    $todaymonth = $date_time_array[ "mon"];
    $todayyear = $date_time_array[ "year"];
    
    
        echo "<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\"><TR><TD CLASS=\"mcdivider\">\n";
        echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"2\">\n";
        echo "<TR><TD class=\"mcmcell\" COLSPAN=7 ALIGN=\"center\">";
        echo "<A class=\"mcmlink\" HREF=\"".$GLOBALS["idxfile"]."?viewdate=$lyear$lmonth"."01&viewtype=Month"."\">$xdtm&nbsp;$lyear</A></TD></TR>";
    
    if ($weekstartonmonday==0) {
        $firstweekdaynum++;
        if($firstweekdaynum>7){$firstweekdaynum=1;}
    }
    
    $cellarr[0][0] = 0;
    $cellarr[0][1] = 0;
    $cellarr[0][2] = 0;
    $cellarr[0][3] = 0;
    $cellarr[0][4] = 0;
    $cellarr[0][5] = 0;
    
    $cellcount = 1;
    for($i=$firstweekdaynum-1;$i>0;$i--){
    
    //    $tval = datesub($cuts,0,0,0,$cellcount,0,0);
        $tval = dateadd("d",$cellcount*-1,$cuts);
        $tval2 = strftime("%Y",$tval);
        $cellarr[$i][0] = $tval2;
        
        $tval2 = strftime("%m",$tval);
        $cellarr[$i][1] = $tval2;
        
        $tval2 = strftime("%d",$tval);
        $cellarr[$i][2] = $tval2;
        
        $cellcount++;
    }
    

        for ( $ch = 1; $ch <= 7; $ch++ ) {
            echo "<TD ALIGN=\"center\"";
                if (($weekstartonmonday==1 && $ch < 6) || ($weekstartonmonday==0 && $ch > 1 && $ch < 7)) {
                echo "class=\"mchwdcell\"><FONT class=\"mchwd\" >$daytext[$ch]</FONT></TD>\n";
            } else {
                echo "class=\"mchwecell\"><FONT class=\"mchwe\" >$daytext[$ch]</FONT></TD>\n";
            }
        }
        echo "</TR>\n";
        
        $cellcount = 1;
        $acelcnt = 0;
        
        for ( $cr = 1; $cr <= 6; $cr++ ) {
            echo "<TR>\n";
            for ( $cc = 1; $cc <= 7; $cc++ ) {
            
                if ($cellcount < 10 ) {
                    $cellcounttext = "0".$cellcount;
                } else {
                    $cellcounttext = $cellcount;
                }
        
                if ($cellcount>=$firstweekdaynum) {
        //            $tval = dateadd($cuts,0,0,0,$acelcnt,0,0);
                    $tval = dateadd("d",$acelcnt,$cuts);
        
                    $tval2 = strftime("%Y",$tval);
                    $cellarr[$cellcount][0] = $tval2;
                    
                    $tval2 = strftime("%m",$tval);
                    $cellarr[$cellcount][1] = $tval2;
                    
                    $tval2 = strftime("%d",$tval);
                    $cellarr[$cellcount][2] = $tval2;
                    $acelcnt++;
                }
                
                if ($startmonth == $cellarr[$cellcount][1]) {
                    //function checkforevents($eday, $emonth, $eyear,$ehour,$emin,$eview) {
                    $cevent = checkforevents($cellarr[$cellcount][2], $cellarr[$cellcount][1], $cellarr[$cellcount][0],0,0,"Minical");
                } else {
                    $cevent = false;
                }
                
                echo "<TD VALIGN=\"top\" ALIGN=\"center\"";

                if ($startmonth == $cellarr[$cellcount][1]) {
                    if ($todayday == $cellarr[$cellcount][2] && $todaymonth == $cellarr[$cellcount][1] && $todayyear == $cellarr[$cellcount][0]) {
                        echo "class=\"mccdcell\"><A class=\"mccdlink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";            
                    
                    } else {
                        if (($weekstartonmonday==1 && $cc < 6) || ($weekstartonmonday==0 && $cc > 1 && $cc < 7)) {
                            if($cevent == true) {
                                echo "class=\"mcdwecell\"><A class=\"mcwdwelink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            } else {
                                echo "class=\"mcwdcell\"><A class=\"mcwdlink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            }
//                            echo "<A class=\"mcwdlink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";            
                        } else {
                            if($cevent == true) {
                                echo "class=\"mcdwecell\"><A class=\"mcwewelink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            } else {
                                echo "class=\"mcwecell\"><A class=\"mcwelink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            }
//                            echo "<A class=\"mcwelink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";            
                        }
                    }
                    
                } else {
        
                    if(($cellarr[$cellcount][2]==1) || ($cellcount==($firstweekdaynum-1))) {
        
                        $xuts = mktime(0,0,0,$cellarr[$cellcount][1],$cellarr[$cellcount][2],$cellarr[$cellcount][0]);
         
                        $xdta = getdate ($xuts);
                        $xdtm = $xdta[ "month"];
                            if($cevent == true) {
                                echo "class=\"mcdwecell\"><A class=\"mcncdwelink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            } else {
                                echo "class=\"mcnccell\"><A class=\"mcnclink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            }
                        
//                        echo "<A class=\"mcnclink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";
                    } else {
                            if($cevent == true) {
                                echo "class=\"mcdwecell\"><A class=\"mcncdwelink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            } else {
                                echo "class=\"mcnccell\"><A class=\"mcnclink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";    
                            }
                        
//                        echo "<A class=\"mcnclink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day\">".$cellarr[$cellcount][2]."</A></TD>\n";
                    }            
                }
                $cellcount++;
            }
            
            echo "</TR>\n";
        }
        echo "</TABLE></TD></TR></TABLE>\n";
        
        if($swcw==0) {
            $wsbfd = mktime(0,0,0,$cellarr[1][1],$cellarr[1][2],$cellarr[1][0]);
//            $wsbfd = $cellarr[1][0].$cellarr[1][1].$cellarr[1][2];
        } else {
            $wsbld = mktime(0,0,0,$cellarr[42][1],$cellarr[42][2],$cellarr[42][0]);
        }        
}

//function weekselectbox($sday,$smonth,$syear,$gobut) {
function weekselectbox($ayear,$amonth,$aday,$gobut,$ccwsel,$gyear,$gmonth,$gday) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl,$wsbfd,$wsbld,$weekselreact;
    global $langcfg;
    
    $tnow = time();
    $tyear = strftime("%Y",$tnow);
    $tmonth = strftime("%m",$tnow);
    $tday = strftime("%d",$tnow);

    $tdate = mktime(0,0,0,$tmonth,$tday,$tyear);
    
    $fcwdate = mktime(0,0,0,$amonth,1,$ayear);
    $fcwwvdate = mktime(0,0,0,$gmonth,$gday,$gyear);

//    echo strftime("%Y",$fcwwvdate).strftime("%m",$fcwwvdate).strftime("%d",$fcwwvdate)."<br>";
//    echo $gyear.$gmonth.$gday."<br>";
    
    $canselweek=0;
    if(($tnow >= $wsbfd) && ($tnow <= $wsbld)) {$canselweek = 1;}
    
//Echo "selwk: ".$canselweek."<br>";
//Echo "wsbfd: ".$wsbfd."<br>";
//Echo "wsbld: ".$wsbld."<br>";

//    echo "<font class=\"cvheadtext\" size=\"-1\"><B>Week:</b></FONT><BR><SELECT id=weeksel name=weeksel LANGUAGE=javascript onchange=\"return weeksel_onchange()\">\n";

    echo "<FORM action=\"".$GLOBALS["idxfile"]."\" method=POST id=selweek name=selweek>\n";
    echo "<INPUT type=\"submit\" value=\"".$langcfg["swvbut"]."\" id=goweek name=goweek><br>\n";
    echo "<SELECT style=\"WIDTH: 170px\" id=weeksel name=weeksel LANGUAGE=javascript onchange=\"selweek.submit();\">\n";


    if ($ccwsel==1) {

        $syear = strftime("%Y",$wsbfd);
        $smonth = strftime("%m",$wsbfd);
        $sday = strftime("%d",$wsbfd);
        
    } else {
    
        $syear = $ayear;
        $smonth = $amonth;
        $sday = $aday;
    
    }
    
//    $sdate = mktime(0,0,0,$smonth,$sday,$syear);

          
    $bdat = mktime(0,0,0,$smonth,$sday,$syear);
    $edat = dateadd("d",6,$bdat);
    
    for ($i=0;$i<=15;$i++) {
        
        $xdta = getdate ($bdat);
        $lbmn = $monthtext[$xdta["mon"]];
        
        $lbyear = strftime("%Y",$bdat);
        $lbmonth = strftime("%m",$bdat);
        $lbday = strftime("%d",$bdat);
        $lbweek = strftime("%W",$bdat);


        $xdta = getdate ($edat);
        $lemn = $monthtext[$xdta["mon"]];
    
        $leyear = strftime("%Y",$edat);
        $lemonth = strftime("%m",$edat);
        $leday = strftime("%d",$edat);
        $leweek = strftime("%W",$edat);
        
        $optstr = "".$langcfg["wns"]."&nbsp;$lbweek,&nbsp;$lbmn&nbsp;$lbday&nbsp;-&nbsp;$lemn&nbsp;$leday";
       
        echo "<OPTION value=$lbyear$lbmonth$lbday";
        
        if ($ccwsel==1) {
            if ($weekselreact==1) {
                if ($canselweek==1) {
                    if(($tdate >=  $bdat) && ($tdate <= $edat)) { echo " selected ";}
                } else {
                // select first week in actual month if possible
                    if(($fcwdate >=  $bdat) && ($fcwdate <= $edat)) { echo " selected ";}
                }
            } else {
                // select first week in actual month if possible
                    if(($fcwdate >=  $bdat) && ($fcwdate <= $edat)) { echo " selected ";}
            }
        } else {
            if(($fcwwvdate >=  $bdat) && ($fcwwvdate <= $edat)) { echo " selected ";}
        }        
        echo ">$optstr</OPTION>\n";
        
        $bdat = dateadd("d",1,$edat);
        $edat = dateadd("d",6,$bdat);
        
    }
        
    echo "</SELECT>";
//    if($gobut==1) {
    echo "</FORM>\n";
//    }
}

function monthselectbox($sday,$smonth,$syear,$eday,$emonth,$eyear,$cday,$cmonth,$cyear,$gobut) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl;
    global $langcfg;
    
    
//    echo "<font class=\"cvheadtext\" size=\"-1\"><B>Month:</b></FONT><BR><SELECT id=monthsel name=monthsel LANGUAGE=javascript onchange=\"return monthsel_onchange()\">\n";

    echo "<FORM action=\"".$GLOBALS["idxfile"]."\" method=POST id=selmonth name=selmonth>\n";
    echo "<INPUT type=\"submit\" value=\"".$langcfg["smvbut"]."\" id=gomonth name=gomonth><br>\n";
    echo "<SELECT style=\"WIDTH: 170px\" id=monthsel name=monthsel LANGUAGE=javascript onchange=\"selmonth.submit();\">\n";
    
    $suts = mktime(0,0,0,$smonth,$sday,$syear);
    $cuts = mktime(0,0,0,$cmonth,$cday,$cyear);
    $euts = mktime(0,0,0,$emonth,$eday,$eyear);
    
    $xuts = $suts;
    
    while ($xuts <= $euts) {
     
        $xdta = getdate ($xuts);
        $xdtm = $xdta["month"];
        
        $lyear = strftime("%Y",$xuts);
        $lmonth = strftime("%m",$xuts);
    
       
        echo "<OPTION value=$lyear$lmonth"."01";
        if($lyear==$cyear && $lmonth==$cmonth) { echo " selected ";}
        echo ">$xdtm&nbsp;$lyear</OPTION>\n";
    
    //    $xuts = dateadd($xuts,0,0,0,0,1,0);
        $xuts = dateadd("m",1,$xuts);
        
    }
        
    echo "</SELECT>";
//    if($gobut==1) {
//    }
    echo "</FORM>\n";
}

function yearselectbox($syear,$eyear,$cyear,$gobut) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl;
    global $langcfg;
    
//    echo "<font class=\"cvheadtext\" size=\"-1\"><B>Year:</b></FONT><BR><SELECT id=yearsel name=yearsel LANGUAGE=javascript onchange=\"return yearsel_onchange()\">\n";
    

    echo "<FORM action=\"".$GLOBALS["idxfile"]."\" method=POST id=selyear name=selyear>\n";
    echo "<INPUT type=\"submit\" value=\"".$langcfg["syvbut"]."\" id=goyear name=goyear><br>\n";
    echo "<SELECT style=\"WIDTH: 170px\" id=yearsel name=yearsel LANGUAGE=javascript onchange=\"selyear.submit();\">\n";

    $suts = mktime(0,0,0,1,1,$syear);
    $cuts = mktime(0,0,0,1,1,$cyear);
    $euts = mktime(0,0,0,1,1,$eyear);
    
    $xuts = $suts;
    
    while ($xuts <= $euts) {
     
        $lyear = strftime("%Y",$xuts);
       
        echo "<OPTION value=$lyear"."0101";
        if($lyear==$cyear) { echo " selected ";}
        echo ">&nbsp;$lyear&nbsp;</OPTION>\n";
    
    //    $xuts = dateadd($xuts,0,0,0,1,0,1);
        $xuts = dateadd("yyyy",1,$xuts);
        
    }
        
    echo "</SELECT>";
//    if($gobut==1) {
    echo "</FORM>\n";
//    }
}
 

function editcats($cuser) {
    global $timear,$timeara,$curcalcfg,$monthtext,$monthtextl,$langcfg;

?>

<html>
<head>
<title>Categories</title>
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

    var curfeld = "";
    var aclr = "";


    function setcolor_ondblclick(cname) {
//    	alert(cname);
        if(curfeld != "") {
            catform.item(curfeld).value = cname;
        }
//        ikey = "ifld_" + curfeld.substring(4);
//        document.all(ikey).bgColor = cname;

//        curfeld = "";
    }

    function cfld_onfocus(cfield) {
//        alert(cfield);
        curfeld = cfield;
//        nkey = "nfld_" + cfield.substring(4);
//        aclr = document.all(nkey).bgColor;

	}

    function cfld_onfocusout(nfield) {
//        document.all(nkey).bgColor = aclr;
//        curfeld = "";
	}
            
   
function catform_onsubmit() {
    if(catform.nosave.value == "1") {
        return true;
    } else {
    
	    catform.catname.value = trim(catform.catname.value);
        if(catform.catname.value == "") {
            alert("The name must not be blank!");
            return false;
        }
    }
}

function donecat_onclick() {
    catform.nosave.value = "1";
}
    
function catlist_onchange() {
	var curcatval = catform.catlist.options(catform.catlist.selectedIndex).value;
	var curcat = curcatval.split("|");
	catform.catname.value = curcat[3];
	catform.catcolortext.value = curcat[4];
	catform.catcolorbg.value = curcat[5];
	for(i=0;i<catform.catcal.length;i++) {
		if(catform.catcal.options(i).value == curcat[1]) {
			catform.catcal.selectedIndex = i;
		}
	}
}

function newcat_onclick() {
	catform.catlist.selectedIndex = -1;
	catform.catcal.selectedIndex = -1;
	catform.catname.value = "";
	catform.catcolortext.value = "";
	catform.catcolorbg.value = "";
}

    function trim(value) {
     startpos=0;
     while((value.charAt(startpos)==" ")&&(startpos<value.length)) {
       startpos++;
     }
     if(startpos==value.length) {
       value="";
     } else {
       value=value.substring(startpos,value.length);
       endpos=(value.length)-1;
       while(value.charAt(endpos)==" ") {
         endpos--;
       }
       value=value.substring(0,endpos+1);
     }
     return(value);
    }


//-->
</SCRIPT>
</head>

<body background="<?php echo $curcalcfg["gcbgimg"]; ?>">

<form id="catform" name="catform" method="post" action="<?php echo $GLOBALS["idxfile"]; ?>" LANGUAGE=javascript onsubmit="return catform_onsubmit()">
<INPUT type="hidden" id="nosave" name="nosave" value="0">
<h1>Categories</h1>
  <table border="1" width="50%">
    <tr>
      <td width="20%" valign="top" align="middle">
      <select tabindex="1" size="10" id="catlist" name="catlist" style="WIDTH: 140px" LANGUAGE=javascript onchange="return catlist_onchange()">
<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_cat where uid = '".$cuser->gsv("cuid")."'";
    $query1 = mysql_query($sqlstr) or die("Cannot query User Category Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
		echo "        <option ";
        echo "value = \"".$row["catid"]."|".$row["calid"]."|".($row["calname"])."|".$row["catname"]."|".$row["catcolortext"]."|".$row["catcolorbg"]."\">".$row["catname"]."</option>\n";
     }
     mysql_free_result($query1);

?>
      </select>
      </td>
      <td width="30%" valign="top">
      Name:<BR>
      <INPUT tabindex="2" id="catname" name="catname">
      <BR>Text Color:<BR>
      <INPUT tabindex="3" id="catcolortext" name="catcolortext" LANGUAGE=javascript onfocus="return cfld_onfocus('catcolortext')" onfocusout="return cfld_onfocusout('catcolortext')">
      <BR>Background Color:<BR>
      <INPUT tabindex="4" id="catcolorbg" name="catcolorbg" LANGUAGE=javascript onfocus="return cfld_onfocus('catcolorbg')" onfocusout="return cfld_onfocusout('catcolorbg')">
      <BR>Calendar:<BR>
      <SELECT tabindex="5" id="catcal" style="WIDTH: 154px" name="catcal">
      <option value="0">All of my Calendars</option> 
<?php
    $sqlstr = "select calid, calname from ".$GLOBALS["tabpre"]."_cal_ini where userid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query Calendar ini Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
		echo "        <option ";
        echo "value = \"".$row["calid"]."\">".($row["calname"])."</option>\n";
     }
     mysql_free_result($query1);

?>
      </SELECT>
      </td>
      <td width="50%" valign="top">
      
<?php

                echo "\n<span id=\"esp\" style=\"width: 100%; height: 170;overflow: auto\">\n";
                
                echo "<table border=\"1\" width=\"100%\">";
                $csqlstr = "SELECT  * FROM ".$GLOBALS["tabpre"]."_color_table group by nicename,rgbplus order by cnum,rgbplus";
                $cquery = mysql_query($csqlstr) or die("Cannot query color Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$csqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                
                while($crow=mysql_fetch_array($cquery)) { 
                    echo"<tr>\n";
                    echo"<td width=\"10%\">".$crow["cname"]."</td>\n";
                    echo"<td id=\"".$crow["id"]."\" bgcolor=\"".$crow["cname"]."\"  LANGUAGE=javascript ondblclick=\"return setcolor_ondblclick('".$crow["cname"]."')\">&nbsp;</td>\n";
                    echo"</tr>\n";
                }
                echo "</table></span></td>";


?>      
      
      </td>      
    </tr>
  </table>
  To use the Color Picker, click in one of the color fields, then double click the color you want.
<table border="1" width="50%">
  <tr>
    <td width="12%" align="center">
    <INPUT type="button" tabindex="6" value="New" id="newcat" name="newcat" LANGUAGE=javascript onclick="return newcat_onclick()">
    </td>
    <td width="13%" align="center">
    <INPUT type="submit" tabindex="7" value="Save" id="savecat" name="savecat">
    </td>
    <td width="13%" align="center">
    <INPUT type="submit" tabindex="8" value="Delete" id="deletecat" name="deletecat">
    </td>
    <td width="12%" align="center">
    <INPUT type="submit" tabindex="9" value="Done" id="catdone" name="catdone" LANGUAGE=javascript onclick="return donecat_onclick()">
    </td>
  </tr>
</table>
  
</form>

<?php
echo "<br><br>";
include_once("./include/footer.php");
exit();
}

function editcons($cuser) {
    global $timear,$timeara,$curcalcfg,$monthtext,$monthtextl,$langcfg;

        
        $xdservertz = $cuser->gsv("servertz") / 60 / 60;
        $xdusertz = $cuser->gsv("usertz");
        $xdadjtz = $cuser->gsv("caltzadj") / 60 / 60;
        
        if($xdservertz > 0) {
            $xdservertz = "+".$xdservertz;
        }

/*        if($xdusertz < 0) {
            $xdusertz = "-".$xdusertz;
        } elseif($xdusertz > 0) {
            $xdusertz = "+".$xdusertz;
        }
*/
        if($xdadjtz > 0) {
            $xdadjtz = "+".$xdadjtz;
        }

?>

<html>

<head>
<title>Contacts</title>
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

function conlist_onchange() {
	var curconval = conform.conlist.options(conform.conlist.selectedIndex).value;
	var curcon = curconval.split("|");
	conform.confname.value = curcon[2];
	conform.conlname.value = curcon[3];
	conform.conemail.value = curcon[4];
	conform.conbday.value = curcon[5];
	conform.contzos.value = curcon[6];
	conform.contel1.value = curcon[7];
	conform.contel2.value = curcon[8];
	conform.contel3.value = curcon[9];
	conform.confax.value = curcon[10];
	conform.conadr.innerText = curcon[11];
	for(i=0;i<conform.congp.length;i++) {
		if(conform.congp.options(i).value == curcon[1]) {
			conform.congp.selectedIndex = i;
		}
	}
    
	umes.style.display="none";
    conform.newcongp.disabled = false;
    conform.editcongp.disabled = false;
    conform.deletecongp.disabled = false;
	conform.newcon.disabled = false;
	conform.donecon.disabled = false;
    conform.deletecon.disabled = false;
}

function newcon_onclick() {
	conform.conlist.selectedIndex = -1;
	conform.congp.selectedIndex = 0;
	conform.confname.value = "";
	conform.conlname.value = "";
	conform.conemail.value = "";
	conform.conbday.value = "";
	conform.contzos.value = "<?php echo $xdusertz; ?>";
	conform.contel1.value = "";
	conform.contel2.value = "";
	conform.contel3.value = "";
	conform.confax.value = "";
	conform.conadr.innerText = "";
    conform.confname.focus;
//	umes.style.display="inline";
    divdelcon.style.display="none";
    divcannewcon.style.display="inline";
    
    conform.newcongp.disabled = true;
    conform.editcongp.disabled = true;
    conform.deletecongp.disabled = true;
	conform.newcon.disabled = true;
	conform.donecon.disabled = true;
    conform.deletecon.disabled = true;
}

function cancelnewcon_onclick() {
    conform.grped.value = "0";
    divdelcon.style.display="inline";
    divcannewcon.style.display="none";
    
    conform.newcongp.disabled = false;
    conform.editcongp.disabled = false;
    conform.deletecongp.disabled = false;
	conform.newcon.disabled = false;
	conform.donecon.disabled = false;
    conform.deletecon.disabled = false;

}

function newcongp_onclick() {
    conform.grped.value = "1";
    divcongp.style.display="none";
    divnewcongp.style.display="inline";
    divnewsavebut.style.display="inline";
    divcansavebut.style.display="inline";
    conform.newcongp.disabled = true;
    conform.editcongp.disabled = true;
    conform.deletecongp.disabled = true;
    
	conform.congp.selectedIndex = -1;
	conform.conlist.selectedIndex = -1;
	conform.confname.value = "";
	conform.conlname.value = "";
	conform.conemail.value = "";
	conform.conbday.value = "";
	conform.contzos.value = "";
	conform.contel1.value = "";
	conform.contel2.value = "";
	conform.contel3.value = "";
	conform.confax.value = "";
	conform.conadr.innerText = "";

	conform.conlist.disabled = true;
	conform.confname.disabled = true;
	conform.conlname.disabled = true;
	conform.conemail.disabled = true;
	conform.conbday.disabled = true;
	conform.contzos.disabled = true;
	conform.contel1.disabled = true;
	conform.contel2.disabled = true;
	conform.contel3.disabled = true;
	conform.confax.disabled = true;
	conform.conadr.disabled = true;
	conform.newcon.disabled = true;
	conform.savecon.disabled = true;
	conform.donecon.disabled = true;
    conform.deletecon.disabled = true;
    conform.connewgp.focus;
}

function editcongp_onclick() {
    conform.grped.value = "1";
    if(conform.congp.selectedIndex < 1) {
        return false;
    }
    conform.connewgp.value = conform.congp.options(conform.congp.selectedIndex).innerText;
    divcongp.style.display="none";
    divnewcongp.style.display="inline";
    diveditsavebut.style.display="inline";
    divcansavebut.style.display="inline";
    conform.newcongp.disabled = true;
    conform.editcongp.disabled = true;
    conform.deletecongp.disabled = true;
    
	conform.conlist.selectedIndex = -1;
	conform.confname.value = "";
	conform.conlname.value = "";
	conform.conemail.value = "";
	conform.conbday.value = "";
	conform.contzos.value = "";
	conform.contel1.value = "";
	conform.contel2.value = "";
	conform.contel3.value = "";
	conform.confax.value = "";
	conform.conadr.innerText = "";

	conform.conlist.disabled = true;
	conform.confname.disabled = true;
	conform.conlname.disabled = true;
	conform.conemail.disabled = true;
	conform.conbday.disabled = true;
	conform.contzos.disabled = true;
	conform.contel1.disabled = true;
	conform.contel2.disabled = true;
	conform.contel3.disabled = true;
	conform.confax.disabled = true;
	conform.conadr.disabled = true;
	conform.newcon.disabled = true;
	conform.savecon.disabled = true;
	conform.donecon.disabled = true;
    conform.deletecon.disabled = true;
    conform.connewgp.focus;
}

function nonewcongp_onclick() {
    conform.grped.value = "0";
    divcongp.style.display="inline";
    divnewcongp.style.display="none";
    divnewsavebut.style.display="none";
    diveditsavebut.style.display="none";
    divcansavebut.style.display="none";
    conform.newcongp.disabled = false;
    conform.editcongp.disabled = false;
    conform.deletecongp.disabled = false;

	conform.conlist.disabled = false;
	conform.confname.disabled = false;
	conform.conlname.disabled = false;
	conform.conemail.disabled = false;
	conform.conbday.disabled = false;
	conform.contzos.disabled = false;
	conform.contel1.disabled = false;
	conform.contel2.disabled = false;
	conform.contel3.disabled = false;
	conform.confax.disabled = false;
	conform.conadr.disabled = false;
	conform.newcon.disabled = false;
	conform.savecon.disabled = false;
    conform.deletecon.disabled = false;
	conform.donecon.disabled = false;
    
}

function deletecongp_onclick() {
    if(conform.congp.selectedIndex != 0) {
        alert("Note: Deleting a Group will not delete the Contacts in the Group however,\nContacts in the deleted Group will be in no Group after the deletion.\nAlso, the group will be deleted out of any Event Reminders that include the Group."); 
        if(confirm("Do you really want to delete the selected Group?")==true) {
            conform.deletecongpok.value="1";
            conform.grped.value = "1";
            conform.submit();    
        }
    }
}

function conform_onsubmit() {

    if(conform.nosave.value == "1" || conform.grped.value == "1") {
        return true;
    } else {
    
	    conform.confname.value = trim(conform.confname.value);
    	conform.conlname.value = trim(conform.conlname.value);
        if(conform.confname.value == "" && conform.conlname.value == "") {
            alert("Either the First or Last name must be filled!");
            return false;
        }
    }

}


function donecon_onclick() {
    conform.nosave.value = "1";
}



    function trim(value) {
     startpos=0;
     while((value.charAt(startpos)==" ")&&(startpos<value.length)) {
       startpos++;
     }
     if(startpos==value.length) {
       value="";
     } else {
       value=value.substring(startpos,value.length);
       endpos=(value.length)-1;
       while(value.charAt(endpos)==" ") {
         endpos--;
       }
       value=value.substring(0,endpos+1);
     }
     return(value);
    }


//-->
</SCRIPT>
</head>

<body background="<?php echo $curcalcfg["gcbgimg"]; ?>">

<h1>Contacts</h1>
<form method="post" action="<?php echo $GLOBALS["idxfile"]; ?>" name="conform" id="conform" LANGUAGE=javascript onsubmit="return conform_onsubmit()">
<input type="hidden" name="nosave" id="nosave" value="0">
<input type="hidden" name="grped" id="grped" value="0">
<input type="hidden" name="deletecongpok" id="deletecongpok" value="0">
  <table border="1" width="100%">
    <tr>
      <td width="18%" valign="center" align="middle" nowrap>
      <select size="18" tabindex="1" name="conlist" style="WIDTH: 170px" LANGUAGE=javascript onchange="return conlist_onchange()">
<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_con where uid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query User Contact Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
        $xcontz = ($row["tzos"] / 60 / 60) + ($cuser->gsv("servertz") / 60 / 60);
        if($xcontz > 0) {
            $xcontz = "+".$xcontz;
        }
        
    
		echo "        <option ";
        echo "value = \"".$row["conid"]."|".$row["congp"]."|".$row["fname"]."|".$row["lname"]."|".$row["email"]."|".$row["bday"]."|".$xcontz."|".$row["tel1"]."|".$row["tel2"]."|".$row["tel3"]."|".$row["fax"]."|".$row["address"]."\">".$row["fname"]." ".$row["lname"]."</option>\n";
     }
     mysql_free_result($query1);

?>      </select>
      </td>
      <td width="82%" valign="top" align="left" nowrap>
          <table border="0" width="100%">
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Group:</td>
              <td width="86%" valign="top" align="left" nowrap>
<div id="divcongp" style="display: inline">              
              <SELECT tabindex="2" id="congp" name="congp" style="WIDTH: 212px">
              <OPTION value="0" selected>None</OPTION>
<?php
    $sqlstr = "select congpid,gpname from ".$GLOBALS["tabpre"]."_user_con_grp where uid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query User Contact Group Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
		echo "        <option ";
        echo "value = \"".$row["congpid"]."\">".$row["gpname"]."</option>\n";
     }
     mysql_free_result($query1);

?>              </SELECT>
</div>
<div id="divnewcongp" style="display: none">              
              <input tabindex="20" name="connewgp" id="connewgp" size="30" >
</div>
&nbsp;<INPUT type="button" tabindex="21" value="New Grp" id="newcongp" name="newcongp" LANGUAGE=javascript onclick="return newcongp_onclick()">
&nbsp;<INPUT type="button" tabindex="22" value="Edit Grp" id="editcongp" name="editcongp" LANGUAGE=javascript onclick="return editcongp_onclick()">
&nbsp;<INPUT type="button" tabindex="23" value="Delete Grp" id="deletecongp" name="deletecongp" LANGUAGE=javascript onclick="return deletecongp_onclick()">
<div id="divnewsavebut" style="display: none">
&nbsp;<INPUT tabindex="24" type="submit" value="Save Grp" id="savenewcongp" name="savenewcongp">
</div>
<div id="diveditsavebut" style="display: none">
&nbsp;<INPUT tabindex="25" type="submit" value="Save Grp" id="saveeditcongp" name="saveeditcongp">
</div>
<div id="divcansavebut" style="display: none">
&nbsp;<INPUT tabindex="26" type="button" value="Cancel" id="nonewcongp" name="nonewcongp" LANGUAGE=javascript onclick="return nonewcongp_onclick()">
</div>
<hr size="1">              
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>First Name:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="3" name="confname" id="confname" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Last Name:</td>
              <td width="86%" valign="top" align="left" nowrap> 
              <input tabindex="4" name="conlname" id="conlname" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>E-Mail:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="5" name="conemail" id="conemail" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Birthday:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="6" name="conbday" id="conbday" size="30" >
              </td>
            </tr>

            <tr>
              <td width="14%" valign="top" align="right" nowrap>Time Zone Offset from GMT:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="7" name="contzos" id="contzos" size="30" >
              </td>
            </tr>

            <tr>
              <td width="14%" valign="top" align="right" nowrap>Telephone 1:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="8" name="contel1" id="contel1" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Telephone 2:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="9" name="contel2" id="contel2" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Telephone 3:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="10" name="contel3" id="contel3" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Fax:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <input tabindex="11" name="confax" id="confax" size="30" >
              </td>
            </tr>
            <tr>
              <td width="14%" valign="top" align="right" nowrap>Address:</td>
              <td width="86%" valign="top" align="left" nowrap>
              <TEXTAREA tabindex="12" id="conadr" name="conadr" rows="6" cols="30">
              </TEXTAREA>
              </td>
            </tr>
          </table><br>
          <b>Note: If you are not sure what the contacts Time Zone is, then leave it set to yours.<br>
          The Servers Time Zone Offset from GMT is: <?php echo $xdservertz; ?><br>
          Your Time Zone Offset from the Server is: <?php echo $xdadjtz; ?>
          </b>
      </td>
    </tr>
  </table>
  <table border="1" width="60%">
  <tr>
    <td width="15%" align="middle">
    <INPUT type="button" tabindex="13" value="New Contact" id="newcon" name="newcon" LANGUAGE=javascript onclick="return newcon_onclick()">
    </td>
    <td width="15%" align="middle">
    <INPUT type="submit" tabindex="14" value="Save" id="savecon" name="savecon">
    </td>
    <td width="15%" align="middle">
<div id="divdelcon" style="display: inline">
    <INPUT type="submit" tabindex="15" value="Delete Contact" id="deletecon" name="deletecon">
</div>
<div id="divcannewcon" style="display: none">
    <INPUT type="button" tabindex="16" value="Cancel" id="cancelnewcon" name="cancelnewcon" LANGUAGE=javascript onclick="return cancelnewcon_onclick()">
</div>
    </td>
    <td width="15%" align="middle">
    <INPUT type="submit" tabindex="17" value="Done" id="donecon" name="donecon" LANGUAGE=javascript onclick="return donecon_onclick()">
    </td>
  </tr>
</table>
</form>
<div id="umes" style="display: none">
<center><h3>To cancel out of NEW mode, just click on a Contact.</h3></center>
</div>
<?php
echo "<br><br>";
include_once("./include/footer.php");
exit();
} 
?>