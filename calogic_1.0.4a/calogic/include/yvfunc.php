<?php
function yearview($sdate) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl;
    global $user,$fsize;
    global $langcfg;
    
//$smonth,$sday,$syear
     set_time_limit(60);
//    ob_start();
    $startyear=substr($sdate,0,4);
    $startmonth=substr($sdate,4,2);
    $startday=substr($sdate,6,2);

    $syear=substr($sdate,0,4);
    $smonth=substr($sdate,4,2);
    $sday=substr($sdate,6,2);
    
//echo "Begin View Table\n\n\n";
    
    echo "<TABLE BORDER=\"0\" ALIGN=\"Center\"CELLSPACING=\"4\" CELLPADDING=\"4\" WIDTH=\"98%\">\n";
    
    
    for ( $hcr = 1; $hcr <= 3; $hcr++ ) {
//        flush();

        echo "<TR>\n";
        
        for ( $hcc = 1; $hcc <= 4; $hcc++ ) {
//            flush();
        
            $suts = mktime(0,0,0,$smonth,1,$syear);
            $xdta = getdate ($suts);
            $xdtm = $xdta["month"];
                
            $lyear = strftime("%Y",$suts);
            $lmonth = strftime("%m",$suts);
            $lday = "01";
        
            echo "<TD VALIGN=\"top\">\n";
            
            echo "<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
            echo "<TR>\n";
            echo "<TD class=\"yvdivider\">\n";
        
            echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"2\">\n";
            echo "<TR>\n";
        
            echo "<TD COLSPAN=7 ALIGN=\"center\" class=\"yvmcell\">\n";
            echo "<A HREF=\"".$GLOBALS["idxfile"]."?viewdate=$lyear$lmonth$lday&viewtype=Month";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\" CLASS=\"yvmlink\">$xdtm</A>\n";
            echo "</TD>\n";
            echo "</TR>\n";
            
            //header
            echo "<TR>\n";
            
            $startmonth=$smonth;
            $startday=$sday;
            $startyear=$syear;
            
            $cuts = mktime(0,0,0,$startmonth,$startday,$startyear);
            
            $firstweekdaynum = strftime("%u",mktime(0,0,0,$startmonth,$startday,$startyear));
             
            $date_time_array = getdate (time() + $user->gsv("caltzadj"));
            $todayday = $date_time_array[ "mday"];
            $todaymonth = $date_time_array[ "mon"];
            $todayyear = $date_time_array[ "year"];
            
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
                    echo "class=\"yvhwdcell\"><FONT class=\"yvhwd\" >$daytext[$ch]</FONT></TD>\n";
                } else {
                    echo "class=\"yvhwecell\"><FONT class=\"yvhwe\">$daytext[$ch]</FONT></TD>\n";
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
                    
    //function checkforevents($eday, $emonth, $eyear,$ehour,$emin,$eview) {

                    if ($startmonth == $cellarr[$cellcount][1]) {
    
                        if($GLOBALS["seiyv"] == true) {
                            $cevent = checkforevents($cellarr[$cellcount][2], $cellarr[$cellcount][1], $cellarr[$cellcount][0],0,0,"Year");
                        } else {
                            $cevent=false;
                        }
                        
                    } else {
                            $cevent=false;
                    }
                    echo "<TD VALIGN=\"middle\" ALIGN=\"center\" width=\"25\" height=\"25\" ";
                    if ($startmonth == $cellarr[$cellcount][1]) {
                        if ($todayday == $cellarr[$cellcount][2] && $todaymonth == $cellarr[$cellcount][1] && $todayyear == $cellarr[$cellcount][0]) {
                            echo "class=\"yvcdcell\"><A class=\"yvcdlink\"  HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day";
                            if($GLOBALS["adsid"] == true) {
                                echo "&".SID;
                            }
                            echo "\">".$cellarr[$cellcount][2]."</A></TD>\n";            
        
        
                        
                        } else {
                            if (($weekstartonmonday==1 && $cc < 6) || ($weekstartonmonday==0 && $cc > 1 && $cc < 7)) {
                                if($cevent == true) {
                                    echo "class=\"yvdwecell\"><A class=\"yvwdwelink\"  ";
                                } else {
                                    echo "class=\"yvwdcell\"><A class=\"yvwdlink\"  ";
                                }
                                echo "HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day";
                                if($GLOBALS["adsid"] == true) {
                                    echo "&".SID;
                                }
                                echo "\">".$cellarr[$cellcount][2]."</A></TD>\n";            
                            } else {
                            
                                if($cevent == true) {
                                    echo "class=\"yvdwecell\"><A class=\"yvwewelink\"  ";
                                } else {
                                    echo "class=\"yvwecell\"><A class=\"yvwelink\"  ";
                                }
                                echo "HREF=\"".$GLOBALS["idxfile"]."?viewdate=".$cellarr[$cellcount][0].$cellarr[$cellcount][1].$cellarr[$cellcount][2]."&viewtype=Day";
                                if($GLOBALS["adsid"] == true) {
                                    echo "&".SID;
                                }
                                echo "\">".$cellarr[$cellcount][2]."</A></TD>\n";            
                            }
                        }
                        
                    } else {
            
                        if(($cellarr[$cellcount][2]==1) || ($cellcount==($firstweekdaynum-1))) {
            
                            $xuts = mktime(0,0,0,$cellarr[$cellcount][1],$cellarr[$cellcount][2],$cellarr[$cellcount][0]);
             
                            $xdta = getdate ($xuts);
                            $xdtm = $xdta[ "month"];
                            echo "class=\"yvnccell\">&nbsp;</TD>\n";
                        } else {
                            echo "class=\"yvnccell\">&nbsp;</TD>\n";
                        }            
                    }
                    $cellcount++;
                }
                
                echo "</TR>\n";
            }
            
            echo "</TABLE>\n";
//            flush();
//            usleep(25);
        
    //        yearviewmonth($startmonth,$startday,$startyear);
            
            $smonth++;
                                
            echo "</TR></TD></TABLE>\n";
//            flush();
//            usleep(25);
            
        }
        echo "</td></TR>\n";
    }
    
    echo "</TABLE>\n";  
//    ob_end_flush();  
}

?>