<?php
function dayview($sdate) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl;
    global $daybeginhour,$dayendhour,$dayhourcount;
    global $user,$curcalcfg,$fsize;
    global $langcfg;
        
    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    echo "<TR><TD CLASS=\"dvdivider\">\n";
    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"2\" BORDER=\"0\">\n";
    echo "<TR>\n";
    
    
    $startyear=substr($sdate,0,4);
    $startmonth=substr($sdate,4,2);
    $startday=substr($sdate,6,2);

// check for events        
    $wdxar = checkforevents($startday, $startmonth, $startyear,0,0,"Day");

    $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);

    $firstweekdaynum = strftime("%u",$cuts);
     
    if ($weekstartonmonday==0) {
        $firstweekdaynum++;
        if($firstweekdaynum>7){$firstweekdaynum=1;}
    }
    
    
    $date_time_array = getdate (time() + $user->gsv("caltzadj"));
    $todayday = $date_time_array[ "mday"];
    $todaymonth = $date_time_array[ "mon"];
    $todayyear = $date_time_array[ "year"];

    $today = time() + $user->gsv("caltzadj");
    $ltyear = strftime("%Y",$today);
    $ltmonth = strftime("%m",$today);
    $ltday = strftime("%d",$today);
    $ltweek = strftime("%W",$today);
    
    $ttday = mktime(0,0,0,$ltmonth,$ltday,$ltyear);

    if ($cuts == $ttday) {
        $fclas = "cd";
    } else if (($weekstartonmonday==1 && $firstweekdaynum < 6) || ($weekstartonmonday==0 && $firstweekdaynum > 1 && $firstweekdaynum < 7)) {
        $fclas = "wd";        
    } else {
        $fclas = "we";        
    }    
    echo "<TD VALIGN=\"top\" WIDTH=\"10%\" class=\"dvadcell\" HEIGHT=\"75\">\n";
    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr>
    <td valign=\"top\" align=\"left\" width=\"15%\" class=\"dvadcell\">";
    echo "<a href=\"".$GLOBALS["idxfile"]."?viewdate=$sdate&viewtype=Day&func=Newevent&funcdate=$sdate&functime=".$curcalcfg["daybeginhour"];
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\" class=\"newlink\"><img border=\"0\" src=\"./img/new.jpg\" alt=\"".$langcfg["butnew"]."&nbsp;".$langcfg["event"]."\"></a></td>";
    echo "<TH VALIGN=\"top\" WIDTH=\"70%\" class=\"dvadcell\" HEIGHT=\"75\">
    <FONT class=\"dvadtext\" >".$langcfg["allday"]."<br>".$langcfg["events"]."</FONT></TH>\n";
    echo "<td width=\"15%\" class=\"dvadcell\">&nbsp;</td></tr></table>";
    echo "</TD>\n";
    
    echo "<TD VALIGN=\"top\" WIDTH=\"85%\" class=\"dva".$fclas."cell\">\n";
    


        $cevent = $wdxar;

            if($cevent[0][0] > 0) {
            
                for($xzc1=1;$xzc1<=$cevent[0][0];$xzc1++) {
                
                    if($cevent[$xzc1]["isallday"]=="1") {

                        echo "\n<span id=\"esp\" style=\"width: 100%; height: 75; overflow: auto\">\n";
                        echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"1\">\n";
                        
                        for($ec=$xzc1;$ec<=$cevent[0][0];$ec++,$xzc1++) {
                        
                            if($cevent[$ec]["isallday"]=="1") {
                        
                                echo "<TR>";
                                if($cevent[$ec]["sendreminder"]==1) {
                                    echo "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"2%\">
                                    <font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt;\">R</font>
                                    </td>";
                                } else {
                                    echo "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"2%\">
                                    <font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt; \">&nbsp;</font>
                                    </td>";
                                }
                                if($cevent[$ec]["isallday"]=="1") {
                                    echo "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"98%\">
                                    <a title=\"".htmlentities($cevent[$ec]["description"],ENT_QUOTES)."\" style=\"text-decoration: none; 
                                    cursor: hand; color: ".$cevent[$ec]["catcolortext"]."\" href=\"".$GLOBALS["idxfile"].
                                    "?func=showevent&evid=".$cevent[$ec]["id"]."&evdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2];
                                    if($GLOBALS["adsid"] == true) {
                                        echo "&".SID;
                                    }
                                    echo "\">";
                                    echo "<font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt; \">".$cevent[$ec]["title"]."</font></a>
                                    <hr noshade color=\"black\" size=\"1\" >
                                    </td>";
                                } else {
                                    echo "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"98%\">
                                    <a title=\"".htmlentities($cevent[$ec]["description"],ENT_QUOTES)."\" style=\"text-decoration: none; 
                                    cursor: hand; color: ".$cevent[$ec]["catcolortext"]."\" href=\"".
                                    $GLOBALS["idxfile"]."?func=showevent&evid=".$cevent[$ec]["id"]."&evdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2];
                                    if($GLOBALS["adsid"] == true) {
                                        echo "&".SID;
                                    }
                                    echo "\">";
                                    echo "<font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt; \">".
                                    $cevent[$ec]["starttimet"]." - ".$cevent[$ec]["endtimet"]."<br>".
                                    $cevent[$ec]["title"]."</font></a><hr noshade color=\"black\" size=\"1\" width=\"95%\" ></td>";
                                }
                                echo "</tr>\n";
                            }
                        }
                        echo "</table>\n";
                        echo "</span>\n";
                    }
                }
            } else {
                echo "&nbsp;";
            }

    echo "</TD>\n";
    echo "</TR>\n";

/*
    $starttime = $curcalcfg["daybeginhour"];
    $sth = substr($curcalcfg["daybeginhour"],0,2);
    $stm = substr($curcalcfg["daybeginhour"],2,2);
    
    $endtime = $curcalcfg["dayendhour"];
    $enh = substr($curcalcfg["dayendhour"],0,2);
    $enm = substr($curcalcfg["dayendhour"],2,2);
    
    $curtime = $curcalcfg["daybeginhour"];
    $curh = substr($curcalcfg["daybeginhour"],0,2);
    $curm = substr($curcalcfg["daybeginhour"],2,2);
*/

// calculate min and max hour    

    $starttime = $curcalcfg["daybeginhour"];
    $endtime = $curcalcfg["dayendhour"];

    $wdxmin = $starttime;
    $wdxmax = $endtime;
    
        $wdxinf = $wdxar;
        if($wdxinf[0][0] != 0) {
            foreach($wdxinf as $xk => $xv) {
                if($wdxinf[$xk]["sorttime"] != 0) {
                    $wdxst = substr($wdxinf[$xk]["sorttime"],0,4);
                    $wdxet = substr($wdxinf[$xk]["sorttime"],4,4);
                    if($wdxst < $wdxmin) {
                        $wdxmin = $wdxst;
                    }
                    if($wdxet > $wdxmax) {
                        $wdxmax = $wdxet;
                    }
                }
            }
        }
        
    $wdxminh = substr($wdxmin,0,2);
    $wdxminm = substr($wdxmin,2,2);

    $wdxmaxh = substr($wdxmax,0,2);
    $wdxmaxm = substr($wdxmax,2,2);

    if($wdxminm < 30) {
        $wdxminm = "00";
    } elseif($wdxminm > 30) {
        $wdxminm = "30";
    }
    

    if($wdxmaxm < 30) {
        $wdxmaxm = "30";
    } elseif($wdxmaxm > 30) {
        $wdxmaxm = "00";
        $wdxmaxh++;
    }

    $wdxmin = sprintf("%02d%02d", $wdxminh,$wdxminm);
    $wdxmax = sprintf("%02d%02d", $wdxmaxh,$wdxmaxm);

    $starttime = $wdxmin;
    $sth = substr($starttime,0,2);
    $stm =substr($starttime,2,2);

    $endtime = $wdxmax;
    $enh = substr($endtime,0,2);
    $enm = substr($endtime,2,2);

    $curtime = $starttime;
    $curh = substr($starttime,0,2);
    $curm = substr($starttime,2,2);

    
    if($curcalcfg["timetype"] == 1 ) {
        $timeout = date("H:i",mktime($curh,$curm,0,3,3,1973));
    } else {
        $timeout = date("g:i A",mktime($curh,$curm,0,3,3,1973));
    }
    $functimeout = date("Hi",mktime($curh,$curm,0,3,3,1973));
    
    
    
    $ckd1 = date("d",mktime($curh,$curm,0,3,3,1973));
    $ckd2 = date("d",mktime($curh,$curm,0,3,3,1973));
    $safetycounter = 60;
    $amimrs = 0;
    
    while(($curtime <= $endtime) && ($ckd1 == $ckd2) && ($safetycounter > 0)) {
        $safetycounter--;
        
        $ckd3 = date("Y-m-d",mktime($curh,$curm,0,$startmonth,$startday,$startyear));

        if($ckd3 == "1970-01-01") {
            $nofunc=1;
        } else {
            $nofunc=0;
        }
  
        echo "<TD VALIGN=\"top\" WIDTH=\"10%\" class=\"dvtccell\" HEIGHT=\"75\">\n";
        echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr>
        <td valign=\"top\" align=\"left\" width=\"15%\" class=\"dvtccell\">";
        if($nofunc==0) {
            echo "<a href=\"".$GLOBALS["idxfile"]."?viewdate=$sdate&viewtype=Day&func=Newevent&funcdate=$sdate&functime=$functimeout";
            if($GLOBALS["adsid"] == true) {
                echo "&".SID;
            }
            echo "\" class=\"newlink\"><img border=\"0\" src=\"./img/new.jpg\" alt=\"".$langcfg["butnew"]."&nbsp;".$langcfg["event"]."\"></a>";
        } else {
            echo "&nbsp;";
        }
        echo "</td>\n";
        echo "<TH VALIGN=\"top\" WIDTH=\"70%\" class=\"dvtccell\" HEIGHT=\"75\">
        <FONT class=\"dvtctext\" >$timeout</FONT></TH>\n";
        echo "<td width=\"15%\" class=\"dvtccell\">&nbsp;</td></tr></table>";
        echo "</TD>\n";    


            $cevent = $wdxar;
            $conflict = false;
            $ccellt = "";
//            if($amimrs[$ch] = 0;

            if($cevent[0][0] > 0) {
            
                for($xzc1=1;$xzc1<=$cevent[0][0];$xzc1++) {
                
//                    echo "S1";
                    
                    if($cevent[$xzc1]["isallday"] != 1) {
                    
//                    echo "S2";
                    
                        $xcurt = $curh.$curm;
                        $xcevt = substr($cevent[$xzc1]["starttimet"],0,2).substr($cevent[$xzc1]["starttimet"],3,2);
                        $xcurtime = date("Hi",mktime($curh,$curm+29,0,3,3,1973));
                        
                        if($xcevt >= $xcurt && $xcevt <= $xcurtime) {

//                    echo "S3";
                        
                            
                            for($ec=$xzc1;$ec<=$cevent[0][0];$ec++,$xzc1++) {

                                if($cevent[$ec]["isallday"] != 1) {
                            
                                    $xcurt = $curh.$curm;
                                    $xcevt = substr($cevent[$ec]["starttimet"],0,2).substr($cevent[$ec]["starttimet"],3,2);
                                    $xcurtime = date("Hi",mktime($curh,$curm+29,0,3,3,1973));

                                    if($xcevt >= $xcurt && $xcevt <= $xcurtime) {
                                    
                                        
                                        $zxcevth = substr($cevent[$ec]["endtimet"],0,2);
                                        $zxcevtm = substr($cevent[$ec]["endtimet"],3,2);
                                        
                                        if($zxcevth != substr($cevent[$ec]["starttimet"],0,2)) {
                                            if($zxcevtm > 29) {
                                                $zxcevtm = "29";
                                            } else {
                                                $zxcevtm = "59";
                                                $zxcevth--;
                                            }
                                            $zct1 = mktime(substr($cevent[$ec]["starttimet"],0,2),substr($cevent[$ec]["starttimet"],3,2),0,3,3,1973);
                                            $zct2 = mktime($zxcevth,$zxcevtm,0,3,3,1973);
                                            while($zct2 >= $zct1) {
                                                $zct2 = dateadd("n",-30,$zct2);
                                                $amimrs++;
                                                for($xxzc1=1;$xxzc1<=$cevent[0][0];$xxzc1++) {
                                                    $xzct1 = mktime(substr($cevent[$xxzc1]["starttimet"],0,2),substr($cevent[$xxzc1]["starttimet"],3,2),0,3,3,1973);
                                                    $xzct2 = mktime(substr($cevent[$xxzc1]["endtimet"],0,2),substr($cevent[$xxzc1]["endtimet"],3,2),0,3,3,1973);
                                                    if($xxzc1 != $ec) {
                                                        if($xzct1 >= $zct1 && $xzct1 <= $zct2) {
                                                            $conflict = true;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        
                                        $fxevlp = 1;

                                        $ccellt .=  "<TR>";
                                        if($cevent[$ec]["sendreminder"]==1) {
                                            $ccellt .=  "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"2%\">
                                            <font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt;\">R</font>
                                            </td>";
                                        } else {
                                            $ccellt .=  "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"2%\">
                                            <font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt; \">&nbsp;</font>
                                            </td>";
                                        }
                                        if($cevent[$ec]["isallday"]=="1") {
                                            $ccellt .=  "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"98%\">
                                            <a title=\"".htmlentities($cevent[$ec]["description"],ENT_QUOTES)."\" style=\"text-decoration: none; 
                                            cursor: hand; color: ".$cevent[$ec]["catcolortext"]."\" href=\"".$GLOBALS["idxfile"].
                                            "?func=showevent&evid=".$cevent[$ec]["id"]."&evdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2];
                                            if($GLOBALS["adsid"] == true) {
                                                $ccellt .=  "&".SID;
                                            }
                                            $ccellt .=  "\">";
                                            $ccellt .=  "<font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt; \">".$cevent[$ec]["title"]."</font></a>
                                            <hr noshade color=\"black\" size=\"1\" >
                                            </td>";
                                        } else {
                                            $ccellt .=  "<td valign=\"top\" bgcolor=\"".$cevent[$ec]["catcolorbg"]."\" width=\"98%\">
                                            <a title=\"".htmlentities($cevent[$ec]["description"],ENT_QUOTES)."\" style=\"text-decoration: none; 
                                            cursor: hand; color: ".$cevent[$ec]["catcolortext"]."\" href=\"".
                                            $GLOBALS["idxfile"]."?func=showevent&evid=".$cevent[$ec]["id"]."&evdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2];
                                            if($GLOBALS["adsid"] == true) {
                                                $ccellt .= "&".SID;
                                            }
                                            $ccellt .=  "\">";
                                            $ccellt .=  "<font color=\"".$cevent[$ec]["catcolortext"]."\" style=\"FONT-SIZE: 9pt; \">".
                                            $cevent[$ec]["starttimet"]." - ".$cevent[$ec]["endtimet"]."<br>".
                                            $cevent[$ec]["title"]."</font></a><hr noshade color=\"black\" size=\"1\" width=\"95%\" ></td>";
                                        }
                                        $ccellt .=  "</tr>\n";
                                    }
                                }
                            }
                            $ccellt .=  "</table>\n";
                            $ccellt .=  "</span>\n";

                                        if($conflict == false) {
                                            if($amimrs > 1) {
                                                $nesrs = $amimrs * 75;
                                            } else {
                                                $nesrs = 75;
                                            }
                                        } else {
                                            $nesrs = 75;
                                        }
                            
                            $ccellt = "\n<span id=\"esp\" style=\"width: 100%; height: ".$nesrs."; overflow: auto\">\n"."<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"1\">\n".$ccellt;
                            
                            
                        }
                    }
                }
            }
        


            if($conflict == true) {
                $amimrs = 0;
            }
            if($amimrs == 0 || $fxevlp == 1) {
//                $fxevlp = 0;

                echo "<TD align=\"left\" VALIGN=\"top\" WIDTH=\"85%\" class=\"dv".$fclas."cell\" ";

                if($amimrs > 0) {
                    echo "rowspan=\"".$amimrs."\"";
                    $amimrs--;
                }
                echo ">\n";
                
            } else {
                $amimrs--;
            }
            

// HEIGHT=\"75\" 


            if($amimrs == 0 || $fxevlp == 1) {
                $fxevlp = 0;

                if($chktime1 == "1970-01-01") {
                    echo "<B>&nbsp;".$langcfg["dtss"]."&nbsp;</B><hr>\n";
                    $nofunc=1;
                } else {
                    $nofunc=0;
                }
    
                echo $ccellt;
    
                echo "</TD>\n";
            }

        echo "</TR>\n";

        $curtime = date("Hi",mktime($curh,$curm+30,0,3,3,1973));
        $ckd2 = date("d",mktime($curh,$curm+30,0,3,3,1973));
        $curh = substr($curtime,0,2);
        $curm = substr($curtime,2,2);
        
        if($curcalcfg["timetype"] == 1 ) {
            $timeout = date("H:i",mktime($curh,$curm,0,3,3,1973));
        } else {
            $timeout = date("g:i A",mktime($curh,$curm,0,3,3,1973));
        }
        $functimeout = date("Hi",mktime($curh,$curm,0,3,3,1973));
        
    }
    
    echo "</TABLE></TD></TR></TABLE>\n";
    if($safetycounter == 0) {
        echo "<br><b>Some kind of Time error has occured in the Day View.</b>";
    }
}?>