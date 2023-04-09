<?php
function monthview($sdate) {
    global $weekstartonmonday,$daytext,$monthtext,$daytextl,$monthtextl;
    global $user,$fsize;
    global $langcfg;

    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"0\">\n";
    echo "<TR><TD CLASS=\"mvdivider\">\n";
    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"1\">\n";
    echo "<TR>\n";
    
    
    $startyear=substr($sdate,0,4);
    $startmonth=substr($sdate,4,2);
    $startday=substr($sdate,6,2);
    
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
        echo "<TH id=\"mvhid".$ch."\" WIDTH=\"14%\" ";
            if (($weekstartonmonday==1 && $ch < 6) || ($weekstartonmonday==0 && $ch > 1 && $ch < 7)) {
            echo "class=\"mvhwdcell\"><FONT class=\"mvhwd\" >$daytext[$ch]</FONT></TH>\n";
        } else {
            echo "class=\"mvhwecell\"><FONT class=\"mvhwe\" >$daytext[$ch]</FONT></TH>\n";
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
                $tval = dateadd($cuts,0,0,0,$acelcnt,0,0);
    
                $tval = dateadd("d",$acelcnt,$cuts);
                
                $tval2 = strftime("%Y",$tval);
                $cellarr[$cellcount][0] = $tval2;
                
                $tval2 = strftime("%m",$tval);
                $cellarr[$cellcount][1] = $tval2;
                
                $tval2 = strftime("%d",$tval);
                $cellarr[$cellcount][2] = $tval2;
                $acelcnt++;
            }
            
//            echo "<TD VALIGN=\"top\" WIDTH=\"14%\" HEIGHT=75 ";
            echo "<TD VALIGN=\"top\" WIDTH=\"14%\" HEIGHT=\"75\" ";
             
            if ($startmonth == $cellarr[$cellcount][1]) {
                if ($todayday == $cellarr[$cellcount][2] && $todaymonth == $cellarr[$cellcount][1] && $todayyear == $cellarr[$cellcount][0]) {
                    echo "class=\"mvcdcell\">";
                    
mviewcellhead($cellarr[$cellcount][2],$cellarr[$cellcount][2],$cellarr[$cellcount][1],$cellarr[$cellcount][0],1,$cellcount,$sdate);

                
                } else {
                
                    if (($weekstartonmonday==1 && $cc < 6) || ($weekstartonmonday==0 && $cc > 1 && $cc < 7)) {
                        echo "class=\"mvwdcell\">"; 
                        
mviewcellhead($cellarr[$cellcount][2],$cellarr[$cellcount][2],$cellarr[$cellcount][1],$cellarr[$cellcount][0],2,$cellcount,$sdate);
                                   
                    } else {
                        echo "class=\"mvwecell\">"; 
                        
mviewcellhead($cellarr[$cellcount][2],$cellarr[$cellcount][2],$cellarr[$cellcount][1],$cellarr[$cellcount][0],3,$cellcount,$sdate);
                                   
                    }
                }
                
            } else {
    
                if(($cellarr[$cellcount][2]==1) || ($cellcount==($firstweekdaynum-1))) {
    
                    $xuts = mktime(0,0,0,$cellarr[$cellcount][1],$cellarr[$cellcount][2],$cellarr[$cellcount][0]);
     
                    $xdta = getdate ($xuts);
                    $xdtm = $xdta[ "month"];
                    echo "class=\"mvnccell\">";
                    
mviewcellhead("$xdtm&nbsp;".$cellarr[$cellcount][2], $cellarr[$cellcount][2], $cellarr[$cellcount][1], $cellarr[$cellcount][0], 4, $cellcount,$sdate);
                    
                } else {
                    echo "class=\"mvnccell\">";
                    
mviewcellhead($cellarr[$cellcount][2], $cellarr[$cellcount][2], $cellarr[$cellcount][1], $cellarr[$cellcount][0],5,$cellcount,$sdate);

                }            
            }

// events go here
// day, month, year, hour, minute

            if ($startmonth == $cellarr[$cellcount][1]) {
                
                                            // day, month , year
                $cevent = checkforevents($cellarr[$cellcount][2], $cellarr[$cellcount][1], $cellarr[$cellcount][0],0,0,"Month");
                //echo "\n<span id=\"esp[".$cellcount."]\" style=\"width: 135; height: 75; overflow: auto\">\n";
                
                if($cevent[0][0] > 0) {
                
                echo "\n<span id=\"esp\" style=\"width: 135; height: 75; overflow: auto\">\n";
                    echo "<TABLE BORDER=\"0\" WIDTH=\"100%\" CELLSPACING=\"1\" CELLPADDING=\"1\">\n";
                    for($ec=1;$ec<=$cevent[0][0];$ec++) {
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
                    echo "</table>\n";
                    echo "</span>\n";
                }
            }
            
            echo "</TD>\n";            
            
            $cellcount++;
        }
        
        echo "</TR>\n";
    }
    echo "</TABLE></TD></TR></TABLE>\n";
}
 
 
function mviewcellhead($dstr,$cday,$cmonth,$cyear,$ctyp,$ccnt,$sdate) {
    global $dispwnum,$fsize;
    global $langcfg;

$wnum = strftime("%W",mktime(0,0,0,$cmonth,$cday,$cyear));

    $bon="";
    $bof="";
    if ($ctyp==1) {
        $fclas = "calcdtext";
        $aclas = "mvcdlink";
    } else if ($ctyp==2) {
        $fclas = "calwdtext";
        $aclas = "mvwdlink";
    } else if ($ctyp==3) {
        $fclas = "calwetext";
        $aclas = "mvwelink";
    } else if ($ctyp==4) {
        $fclas = "caloomtext";
        $aclas = "mvnclink";
        $bon="<B>";
        $bof="</B>";
    } else {
        $fclas = "caloomtext";
        $aclas = "mvnclink";
    }

    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"95%\">";
    echo "<tr>";
    echo "<td width=\"10%\" nowrap><A class=\"$aclas\" HREF=\"".$GLOBALS["idxfile"]."?viewdate=$cyear$cmonth$cday&viewtype=Day";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\">$bon$dstr$bof</A></td>";
    echo "<td width=\"40%\" nowrap align=\"center\">";
    if ($dispwnum == 1 && ( $ccnt==1 || $ccnt==8 || $ccnt==15 || $ccnt==22 || $ccnt==29 || $ccnt==36 ) ) {
        echo "<A class=\"mvkwlink\" HREF=\"".$GLOBALS["idxfile"]."?viewdate=$cyear$cmonth$cday&viewtype=Week";
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\">(".$langcfg["wnl"]." $wnum)</A>";
    } else {
        echo "<font class=\"mvkwlink\">&nbsp;</font>";
    }
    echo "</td>";
    echo "<td width=\"45%\" nowrap align=\"right\"><a href=\"".$GLOBALS["idxfile"]."?viewdate=$sdate&viewtype=Month&func=Newevent&funcdate=$cyear$cmonth$cday&functime=".$curcalcfg["daybeginhour"];
    if($GLOBALS["adsid"] == true) {
        echo "&".SID;
    }
    echo "\" class=\"newlink\">";
    echo "<img border=\"0\" src=\"./img/new.jpg\" alt=\"".$langcfg["butnew"]."&nbsp;".$langcfg["event"]."\"></a></td>";        
//    <a href=\"".$GLOBALS["idxfile"]."?viewdate=$cyear$cmonth$cday&viewtype=New\" class=\"newlink\">
    echo "</tr>";
    echo "</table>";

}

?>