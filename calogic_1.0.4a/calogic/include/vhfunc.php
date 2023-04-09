<?php
/***************************************************************
** Title.........: Header View
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: vhfunc.php
** Last changed..: 
** Notes.........: 
** Use...........: This builds the header of every view
                   

***************************************************************/ 

/***************************************************************
**  
***************************************************************/    

function viewheader($vdate,$vtype) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl,$wsbfd,$wsbld,$weekselreact;
    global $user,$fsize,$curcalcfg;
    global $langcfg;

    
    echo "<center>\n";    
    echo "<TABLE BORDER=0 WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    echo "<TR>\n";
    echo "<TD ALIGN=\"left\"  width=\"15%\" rowspan=\"2\">\n";
    
    
    $startyear=substr($vdate,0,4);
    $startmonth=substr($vdate,4,2);
    $startday=substr($vdate,6,2);
    
    if ($vtype=="Year") {
        echo "&nbsp;";
//        $startyear--;
    } else if ($vtype=="Month") {
        $startmonth--;
        if($startmonth == 0){$startmonth = 12; $startyear--;}

        minical($startday,$startmonth,$startyear,0);

    } else {
        minical("01",$startmonth,$startyear,0);
    }
    
//    $startmonth--;
//    if($startmonth == 0){$startmonth = 12; $startyear--;}
    
    
    echo "</TD>\n";
    echo "<TD valign=\"top\" ALIGN=\"center\" width=\"70%\">\n";
    
    echo "<table border=\"0\" width=\"99%\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    echo "<tr>\n";
    echo "<td nowrap align=\"center\" width=\"20%\">\n";

    $startyear=substr($vdate,0,4);
    $startmonth=substr($vdate,4,2);
    $startday=substr($vdate,6,2);
    
    $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);
    
    if ($vtype == "Day") {
        $preview = dateadd("d",-1,$cuts);
            
    } else if ($vtype == "Week") {
        $preview = dateadd("d",-7,$cuts); 
    
    } else if ($vtype == "Month") {
        $preview = dateadd("m",-1,$cuts);    
        
    } else if ($vtype == "Year") {
        $preview = dateadd("yyyy",-1,$cuts);    
    }
    
    $lyear = strftime("%Y",$preview);
    $lmonth = strftime("%m",$preview);
    $lday = strftime("%d",$preview);
    
    echo "<A class=\"gcprevlink\" HREF=\"".$GLOBALS["idxfile"]."?viewdate=$lyear$lmonth$lday&viewtype=$vtype";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\">".$langcfg["prev"]."&nbsp;$vtype</A>\n";
        
    echo "</td>\n";
    echo "<td nowrap align=\"center\" width=\"60%\">\n";
    echo $user->gsv("fullname")." - ".$curcalcfg["caltitle"]."<br>";        
    
    $xdta = getdate ($cuts);
    $xtday = strftime("%w",$cuts);
    if ($weekstartonmonday==0) {
        $xtday++;
    } else {
        if($xtday==0){$xtday=7;}
    }
    
    $daynames = $daytext[$xtday];
    $daynamel = $daytextl[$xtday];
    $daynums = strftime("%d",$cuts);
    $kwnums = strftime("%W",$cuts);
    $monthnames = $monthtext[$xdta["mon"]];
    $monthnamel = $monthtextl[$xdta["mon"]];
    $monthnums = strftime("%m",$cuts);
    $yearnums = strftime("%Y",$cuts);
    
    
    // user name / Calendar name
    //echo "<FONT COLOR=\"#000000\" SIZE=\"+1\">Philip Boone - </FONT><FONT SIZE=\"+2\" COLOR=\"#000000\"><B><br>\n";
    
//    echo "<B><font class=\"cvheadtext\" size=\"+2\">";  
    
    if ($vtype == "Day") {
        echo "<B><font class=\"dvhead\" size=\"+2\">";  
        $optstr = "$daynamel, $monthnamel&nbsp;$daynums,&nbsp;$yearnums";
    
    } else if ($vtype == "Week") {
        echo "<B><font class=\"wvhead\" size=\"+2\">";  
    
        $euts = dateadd("d",6,$cuts);
        $xdta = getdate ($euts);
        $xtday = strftime("%w",$euts);
        if ($weekstartonmonday==0) {
            $xtday++;
        } else {
            if($xtday==0){$xtday=7;}
        }
    
        $daynamese = $daytext[$xtday];
        $daynamele = $daytextl[$xtday];
        $daynumse = strftime("%d",$euts);
        $kwnumse = strftime("%W",$euts);
        $monthnamese = $monthtext[$xdta["mon"]];
        $monthnamele = $monthtextl[$xdta["mon"]];
        $monthnumse = strftime("%m",$euts);
        $yearnumse = strftime("%Y",$euts);      
        
        $optstr = $langcfg["wns"]."&nbsp;$kwnums,&nbsp;$monthnames&nbsp;$daynums,&nbsp;$yearnums&nbsp;-&nbsp;$monthnamese&nbsp;$daynumse,&nbsp;$yearnumse";
    
    } else if ($vtype == "Month") {
        echo "<B><font class=\"mvhead\" size=\"+2\">";  
        $optstr = "$monthnamel&nbsp;$yearnums";
    
    } else if ($vtype == "Year") {
        echo "<B><font class=\"yvhead\" size=\"+2\">";  
        $optstr = "$yearnums";
    }
    
    echo "$optstr\n";
        
    
    echo "</font></B>\n";
    echo "</td>\n";
    echo "<td nowrap align=\"center\" width=\"20%\">\n";
    
    
    if ($vtype == "Day") {
        $nextview = dateadd("d",1,$cuts);
            
    } else if ($vtype == "Week") {
        $nextview = dateadd("d",7,$cuts); 
    
    } else if ($vtype == "Month") {
        $nextview = dateadd("m",1,$cuts);    
        
    } else if ($vtype == "Year") {
        $nextview = dateadd("yyyy",1,$cuts);    
    }
    
    $lyear = strftime("%Y",$nextview);
    $lmonth = strftime("%m",$nextview);
    $lday = strftime("%d",$nextview);
    
    echo "<A class=\"gcnextlink\"HREF=\"".$GLOBALS["idxfile"]."?viewdate=$lyear$lmonth$lday&viewtype=$vtype";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\">".$langcfg["next"]."&nbsp;$vtype</A>\n";
        
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "<HR CLEAR=\"all\">\n";

    echo "<table border=\"0\" width=\"70%\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "<tr>\n";
    echo "<td width=\"23%\" align=\"center\" valign=\"middle\"><A class=\"gcpreflink\" HREF=\"".$GLOBALS["idxfile"]."?goprefs=1";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\">".$langcfg["prefl"]."</A></td>\n";
    echo "<td width=\"23%\" align=\"center\" valign=\"middle\">";
    echo "<form method=\"POST\" action=\"".$GLOBALS["idxfile"]."\" name=\"gosfuncs\" id=\"gosfuncs\">";
    echo "<SELECT id=\"qjump\" style=\"WIDTH: 120px\" name=\"qjump\">\n"; 
    echo "<OPTION selected value=\"contacts\">Contacts</OPTION>\n";
    echo "<OPTION value=\"categories\">Categories</OPTION>\n";
    echo "<OPTION value=\"subscriptions\">Subscriptions</OPTION>\n";
    echo "<OPTION value=\"usersettings\">User Settings</OPTION>\n";
    echo "</SELECT>&nbsp;<INPUT type=\"submit\" value=\"".$langcfg["butgo"]."\" id=\"gosfuncs\" name=\"gosfuncs\">\n";
    
//    <A class=\"gcpreflink\" HREF=\"".$GLOBALS["idxfile"]."?goprefs=1\">".$langcfg["prefl"]."</A>
    echo "</form></td>\n";
    echo "<td width=\"23%\" align=\"center\" valign=\"middle\"><A class=\"gcpreflink\" HREF=\"".$GLOBALS["idxfile"]."?endsess=1";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\">".$langcfg["low"]."</A></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "<HR CLEAR=\"all\">\n";
    echo "</TD>\n";
    echo "<TD ALIGN=\"right\" width=\"15%\" rowspan=\"2\">\n\n";
    
    
    $startyear=substr($vdate,0,4);
    $startmonth=substr($vdate,4,2);
    $startday=substr($vdate,6,2);
    
    if ($vtype=="Year") {
        echo "&nbsp;";

    } else if ($vtype=="Month") {
        $startmonth++;
        if($startmonth == 13){$startmonth = 1; $startyear++;}
        minical($startday,$startmonth,$startyear,1);
    } else {
        echo "&nbsp;";
    }
    
    
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width=\"70%\" align=\"center\" valign=\"bottom\">\n";
    
    
    echo "<table border=\"0\" width=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    echo "<tr>\n";
   
    
    $startyear=substr($vdate,0,4);
    $startmonth=substr($vdate,4,2);
    $startday=substr($vdate,6,2);
    $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);
    
    if ($vtype == "Day") {
        echo "<td width=\"33%\" align=\"center\" valign=\"bottom\">\n";
        $firstweekdaynum = strftime("%u",mktime(0,0,0,$startmonth,$startday,$startyear));
        if ($weekstartonmonday==0) {
            $firstweekdaynum++;
            if($firstweekdaynum>7){$firstweekdaynum=1;}
        }
        $firstweekdaynum--;
        $tval = dateadd("d",$firstweekdaynum*-1,$cuts);
        $tvaly = strftime("%Y",$tval);
        $tvalm = strftime("%m",$tval);
        $tvald = strftime("%d",$tval);
        $xws = dateadd("d",-56,$tval);
        $strty = strftime("%Y",$xws);
        $strtm = strftime("%m",$xws);
        $strtd = strftime("%d",$xws);    
        
        weekselectbox($strty,$strtm,$strtd,1,0,$startyear,$startmonth,$startday);
            
    } else if ($vtype == "Week") {
        echo "<td width=\"33%\" align=\"center\" valign=\"bottom\">\n";
    
        $xws = dateadd("d",-56,$cuts);
        $strty = strftime("%Y",$xws);
        $strtm = strftime("%m",$xws);
        $strtd = strftime("%d",$xws);
        
        weekselectbox($strty,$strtm,$strtd,0,0,$startyear,$startmonth,$startday);
    
    } else if ($vtype == "Month") {
        echo "<td width=\"33%\" align=\"center\" valign=\"bottom\">\n";
    
        weekselectbox($startyear,$startmonth,$startday,1,1,0,0,0); 
        
    } else if ($vtype == "Year") {
        echo "<td width=\"100%\" align=\"center\" valign=\"bottom\">\n";
    
    }

    if ($vtype <> "Year") {

        echo "</td>\n";
        echo "<td width=\"33%\" align=\"center\" valign=\"bottom\">\n";
        
        $startyear=substr($vdate,0,4);
        $startmonth=substr($vdate,4,2);
        $startday=substr($vdate,6,2);
        $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);
        
        $tval = dateadd("m",-12,$cuts);
        $strty = strftime("%Y",$tval);
        $strtm = strftime("%m",$tval);
        $strtd = strftime("%d",$tval);
        if ($strty == "" || $strty < 1971) {
            $strty = "1971";
            $strtm = "01";
            $strtd = "01";
        }
        $tval = dateadd("m",12,$cuts);
        $endy = strftime("%Y",$tval);
        $endm = strftime("%m",$tval);
        $endd = strftime("%d",$tval);
        
        if ($vtype == "Day") {
            monthselectbox($strtd,$strtm,$strty,$endd,$endm,$endy,$startday,$startmonth,$startyear,1);
        } else if ($vtype == "Week") {
            monthselectbox($strtd,$strtm,$strty,$endd,$endm,$endy,$startday,$startmonth,$startyear,1);
        } else if ($vtype == "Month") {
            monthselectbox($strtd,$strtm,$strty,$endd,$endm,$endy,$startday,$startmonth,$startyear,0);
        }
        echo "</td>\n";
        echo "<td width=\"33%\" align=\"center\" valign=\"bottom\">\n";
        
    }
        
    $cyuts = mktime(0,0,0,1,1,$startyear);
    if($startyear-5 >1970){
        $tval = dateadd("yyyy",-5,$cyuts);
        $strty = strftime("%Y",$tval);
    } else {
        $strty = "1971";
    }
    $tval = dateadd("yyyy",5,$cyuts);
    $endy = strftime("%Y",$tval);

    if ($vtype == "Year") {
        yearselectbox($strty,$endy,$startyear,0);
    } else {
        yearselectbox($strty,$endy,$startyear,1);
    }
    
//echo "</TABLE>\n";    
        
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "</TABLE>\n";

/*    
    if ($vtype == "Day") {
        
        dayview($vdate);
    
    } else if ($vtype == "Week") {
        
        weekview($vdate);
    
    } else if ($vtype == "Month") {
    
        monthview($vdate);
        
    } else if ($vtype == "Year") {
    
        yeariew($vdate);
    
    }
    
*/

}
?>