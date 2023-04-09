<?php
function weekview($sdate) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl;
    global $daybeginhour,$dayendhour,$dayhourcount;
    global $user,$curcalcfg,$fsize;
    global $langcfg;
    
    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    echo "<TR><TD CLASS=\"wvdivider\">\n";
    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"2\">\n";
    echo "<TR>\n";
    
    
    $startyear=substr($sdate,0,4);
    $startmonth=substr($sdate,4,2);
    $startday=substr($sdate,6,2);
    
    $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);
    
    $date_time_array = getdate (time() + $user->gsv("caltzadj"));
    $todayday = $date_time_array[ "mday"];
    $todaymonth = $date_time_array[ "mon"];
    $todayyear = $date_time_array[ "year"];

    $today = time() + $user->gsv("caltzadj");
    $ltyear = strftime("%Y",$today);
    $ltmonth = strftime("%m",$today);
    $ltday = strftime("%d",$today);
    $ltweek = strftime("%W",$today);

    $cdc = 0;

    echo "<TH WIDTH=\"10%\" >&nbsp;</TH>\n";
    for ( $ch = 1; $ch <= 7; $ch++ ) {
    
        $xdta = getdate ($cuts);
        $lcmn = $monthtext[$xdta["mon"]];
        $lcdn = $daytext[$xdta["mday"]];
    
        $lcyear = strftime("%Y",$cuts);
        $lcmonth = strftime("%m",$cuts);
        $lcday = strftime("%d",$cuts);
        $lcweek = strftime("%W",$cuts);
        
        $hdr = $lcmn."&nbsp;".$lcday;  
        
        if (($weekstartonmonday==1 && $ch < 6) || ($weekstartonmonday==0 && $ch > 1 && $ch < 7)) {
            $vclass="wd";
        } else {
            $vclass="we";
        }
        if ($ltyear == $lcyear && $ltmonth == $lcmonth && $ltday == $lcday){
            $cdc = $ch;
        }

        echo "<td width=\"12%\" align=\"center\" class=\"wvh".$vclass."cell\">";
        echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr>
        <td width=\"30%\" class=\"wvh".$vclass."cell\">&nbsp;</td>";
        echo "<TH WIDTH=\"40%\" align=\"center\" class=\"wvh".$vclass."cell\">";
        echo "<A class=\"wvh".$vclass."link\" HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$lcyear.$lcmonth.$lcday."&viewtype=Day";
            if($GLOBALS["adsid"] == true) {
                echo "&".SID;
            }
        echo "\">$daytext[$ch]<br>$hdr</A></TH>\n";
    
        echo "<td width=\"30%\" valign=\"top\" align=\"right\" class=\"wvh".$vclass."cell\">";
        echo "<a href=\"".$GLOBALS["idxfile"]."?viewdate=$sdate&viewtype=Week&func=Newevent&funcdate=$lcyear$lcmonth$lcday&functime=".$curcalcfg["daybeginhour"];
            if($GLOBALS["adsid"] == true) {
            echo "&".SID;
            }
        echo "\" class=\"newlink\"><img border=\"0\" src=\"./img/new.jpg\" alt=\"".$langcfg["butnew"]."&nbsp;".$langcfg["event"]."\"></a></td>";
        echo "</tr></table>";
        echo "</td>";
// check for events        
        $wdxar[$ch] = checkforevents($lcday, $lcmonth, $lcyear,0,0,"Week");
        $cuts = dateadd("d",1,$cuts);
    }
    echo "</TR>\n";

// calculate min and max hour    

    $starttime = $curcalcfg["daybeginhour"];
    $endtime = $curcalcfg["dayendhour"];

    $wdxmin = $starttime;
    $wdxmax = $endtime;
    
    for ( $ch = 1; $ch <= 7; $ch++ ) {
        $wdxinf = $wdxar[$ch];
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

    
    
    echo "<TR><TH VALIGN=\"top\" WIDTH=\"10%\" class=\"wvhadcell\" HEIGHT=\"40\">
    <FONT class=\"wvhadtext\" >".$langcfg["allday"]."<br>".$langcfg["events"]."</FONT></TH>\n";

// all day events row
    for ( $ch = 1; $ch <= 7; $ch++ ) {


        if ($ch == $cdc) {
            echo "<TD VALIGN=\"top\" WIDTH=\"12%\"  HEIGHT=\"75\" class=\"wvacdcell\">\n";
        } else {
            if (($weekstartonmonday==1 && $ch < 6) || ($weekstartonmonday==0 && $ch > 1 && $ch < 7)) {
                echo "<TD VALIGN=\"top\" WIDTH=\"12%\"  HEIGHT=\"75\" class=\"wvawdcell\">\n";
            } else {
                echo "<TD VALIGN=\"top\" WIDTH=\"12%\"  HEIGHT=\"75\" class=\"wvawecell\">\n";
            }
        }

        
        $cevent = $wdxar[$ch];

            if($cevent[0][0] > 0) {
            
                for($xzc1=1;$xzc1<=$cevent[0][0];$xzc1++) {
                
                    if($cevent[$xzc1]["isallday"]=="1") {

                        echo "\n<span id=\"esp\" style=\"width: 140; height: 75; overflow: auto\">\n";
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

//        echo "&nbsp;</TD>\n";   
        echo "</TD>\n";   
    }
    
    echo "</TR>\n";

    $startyear=substr($sdate,0,4);
    $startmonth=substr($sdate,4,2);
    $startday=substr($sdate,6,2);
    
    $cuts = mktime(0,0,0,3,3,1973);
    
    $curtime = $starttime;
    $curh = substr($starttime,0,2);
    $curm = substr($starttime,2,2);

    if($curcalcfg["timetype"] == 1 ) {
        $timeout = date("H:i",mktime($curh,$curm,0,3,3,1973));
    } else {
        $timeout = date("g:i A",mktime($curh,$curm,0,3,3,1973));
    }
    
    $functimeout = date("Hi",mktime($curh,$curm,0,3,3,1973));

    $ckd1 = date("d",$cuts);
    $ckd2 = date("d",$cuts);
    $safetycounter = 60;
    

// half hourly rows

    $amimrs = array();
    for($xersc=1;$xersc<=7;$xersc++) {
        $amimrs[$xersc] = 0;
    }

    

// start of originlal    
    while(($curtime <= $endtime) && ($ckd1 == $ckd2) && ($safetycounter > 0)) {
        $safetycounter--;

        echo "<TR><TH VALIGN=\"top\" WIDTH=\"10%\" class=\"wvtccell\"  HEIGHT=\"75\" >
                <FONT class=\"wvtctext\" >$timeout</FONT></TH>\n";
        
        for ( $ch = 1; $ch <= 7; $ch++ ) {

            $chktime1 = date("Y-m-d",mktime($curh,$curm,0,$startmonth,$startday+($ch-1),$startyear));

            $chktime2 = date("Y-m-d, H:i",mktime($curh,$curm,0,$startmonth,$startday+($ch-1),$startyear));
            
// original start of block



            $cevent = $wdxar[$ch];
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
                                                $amimrs[$ch]++;
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
                                            if($amimrs[$ch] > 1) {
                                                $nesrs = $amimrs[$ch] * 75;
                                            } else {
                                                $nesrs = 75;
                                            }
                                        } else {
                                            $nesrs = 75;
                                        }
                            
                            $ccellt = "\n<span id=\"esp\" style=\"width: 140; height: ".$nesrs."; overflow: auto\">\n".
                            "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"1\">\n".$ccellt;
                        }
                    }
                }
            }



// original start of block
            if($conflict == true) {
                $amimrs[$ch] = 0;
            }
            if($amimrs[$ch] == 0 || $fxevlp == 1) {
//                $fxevlp = 0;
                if ($ch == $cdc) {
                    echo "<TD VALIGN=\"top\" WIDTH=\"12%\" class=\"wvcdcell\" ";
                } else {
                    if (($weekstartonmonday==1 && $ch < 6) || ($weekstartonmonday==0 && $ch > 1 && $ch < 7)) {
                        echo "<TD VALIGN=\"top\" WIDTH=\"12%\" class=\"wvwdcell\" ";
                    } else {
                        echo "<TD VALIGN=\"top\" WIDTH=\"12%\" class=\"wvwecell\" ";
                    }
                }
                if($amimrs[$ch] > 0) {
                    echo "rowspan=\"".$amimrs[$ch]."\"";
                    $amimrs[$ch]--;
                }
                echo ">\n";
            } else {
                $amimrs[$ch]--;
            }
            

// HEIGHT=\"75\" 



            if($amimrs[$ch] == 0 || $fxevlp == 1) {
                $fxevlp = 0;
                if($chktime1 == "1970-01-01") {
                    echo "<B>&nbsp;".$langcfg["dtss"]."&nbsp;</B><hr>\n";
                }
    
                echo $ccellt;
                
                echo "</TD>\n";
            }
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
        echo "<br><b>Some kind of Time error has occured in the Week View.</b>";
    }
}

?>