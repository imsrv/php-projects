<?php
/***************************************************************
**  this section brings up the new event form
***************************************************************/ 

    if(isset($func)) {
        if($func=="Newevent") {
            neweventform(&$user,$viewdate,$viewtype,$func,$funcdate,$functime);
        }
    }
    
/***************************************************************
**  this saves a new event
***************************************************************/ 

    if(isset($saveevent)) {
/***************************************************************
**  this is used for debugging
***************************************************************/ 
/*    
            foreach($nef as $k1 => $v1) {
                echo $k1." = ".$nef[$k1]."<br>";
                if($k1 == "srcons") {
                    $xsrcons = explode("|",$nef[$k1]);
                    foreach($xsrcons as $x1 => $y1) {
                        echo $x1." = ".$xsrcons[$x1]."<br>";
                    }
                }
            }
            
        if(!isset($nef["eventrepeat"])) {
        
        
        } else {
        
            if($nef["estype"] == "1") {
                echo "daily";
            } elseif($nef["estype"] == "2") {
                echo "weekly";
        
            } elseif($nef["estype"] == "3") {
                echo "monthly";

            } elseif($nef["estype"] == "4") {
                echo "yearly";
            
            }
        }
*/

        if(isset($edevid)) {
        
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_events where evid = ".$edevid." and uid = ".$user->gsv("cuid")." and calid='".$user->gsv("curcalid")."'";
            $query1 = mysql_query($sqlstr) or die("Cannot update calendar events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_event_rems where evid = ".$edevid." and uid = ".$user->gsv("cuid")." and calid='".$user->gsv("curcalid")."'";
            $query1 = mysql_query($sqlstr) or die("Cannot update event reminder table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_rem_log where evid = ".$edevid." and calid='".$user->gsv("curcalid")."'";
            $query1 = mysql_query($sqlstr) or die("Cannot update event reminder log table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        }
        
        $htmltrans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
        $transhtml = array_flip($htmltrans);

        $sqlstr1 = "insert into ".$GLOBALS["tabpre"]."_cal_events (uid,calid,title,description,catid,startday,startmonth,
                    startyear,isallday,starthour,startmin,endhour,endmin,sendreminder,srint,srval,iseventseries ";
                    
        $sqlstr2 = " values(".$user->gsv("cuid").",'".$user->gsv("curcalid")."','".fmtfordb($nef["eventtitle"])."','";
        $sqlstr2 .= strtr(($nef["desc"]),$transhtml)."',".$nef["cat"].",'".$nef["eventday"]."','".$nef["eventmonth"]."','".$nef["eventyear"]."',";
                 
        if($nef["alldayevent"]=="0") {
            $sqlstr2 .= "0,'".$nef["eventstarttimehour"]."','".$nef["eventstarttimemin"]."','".$nef["eventendtimehour"]."','".$nef["eventendtimemin"]."',";
        } else {
            $sqlstr2 .= "1,'00','00','00','00',";
        }
        if(isset($nef["sendreminder"])) {
            $sqlstr2 .= "1,".$nef["srint"].",".$nef["srval"];
        } else {
            $sqlstr2 .= "0,0,0";
        }
        
        if(!isset($nef["eventrepeat"])) {
// this is the easy part, no repeat
// calculate the end date and mysql days
/*
            $sqlstrx = "select to_days('".$nef["eventyear"]."-".$nef["eventmonth"]."-".$nef["eventday"]."') as evdays";
            $queryx = mysql_query($sqlstrx) or die("Cannot connect to database<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);
            $rowx = mysql_fetch_array($queryx);
            $evdays = $rowx["evdays"];  
            mysql_free_result($queryx);    
*/                
            $sqlstr1 .= ",endafterdate,endafterdays) ";
            $sqlstr2 .= ",0,'".$nef["eventyear"]."-".$nef["eventmonth"]."-".$nef["eventday"]."',to_days('".$nef["eventyear"]."-".$nef["eventmonth"]."-".$nef["eventday"]."'))";
            
        } else {
// now begins the really hard (fun) stuff.
            $sqlstr1 .= ",estype";
            $sqlstr2 .= ",1,".$nef["estype"];
            if($nef["estype"] == "1") {
// daily
                $sqlstr1 .= ",estd";
                $sqlstr2 .= ",".$nef["daytype"];
                if($nef["daytype"]=="1") {
                    $sqlstr1 .= ",estdint";
                    $sqlstr2 .= ",".$nef["eachdaycount"];
                }

            } elseif($nef["estype"] == "2") {
// weekly
                $sqlstr1 .= ",estwint,estwd";
                $sqlstr2 .= ",".$nef["eachweekcount"].",'";
                $tstr="";
                if(isset($nef["weekday1"])) {$tstr .= "1";} else {$tstr .= "0";} //mon
                if(isset($nef["weekday2"])) {$tstr .= "1";} else {$tstr .= "0";} //tue
                if(isset($nef["weekday3"])) {$tstr .= "1";} else {$tstr .= "0";} //wed
                if(isset($nef["weekday4"])) {$tstr .= "1";} else {$tstr .= "0";} //thu
                if(isset($nef["weekday5"])) {$tstr .= "1";} else {$tstr .= "0";} //fri
                if(isset($nef["weekday6"])) {$tstr .= "1";} else {$tstr .= "0";} //sat
                if(isset($nef["weekday7"])) {$tstr .= "1";} else {$tstr .= "0";} //sun
                $sqlstr2 .= $tstr ."'";
                
                
            } elseif($nef["estype"] == "3") {
// monthly
                $sqlstr1 .= ",estm";
                $sqlstr2 .= ",".$nef["dayofmonth"];
                if($nef["dayofmonth"] == "1") {
                    $sqlstr1 .= ",estm1d,estm1int";
                    $sqlstr2 .= ",'".$nef["dayofmonthday"]."',".$nef["dayofmonthcount"];
                } else {
                    $sqlstr1 .= ",estm2dp,estm2wd,estm2int";
                    $sqlstr2 .= ",".$nef["whichdayofmonth"].",".$nef["whichdayofmonthday"].",".$nef["whichdayofmonthcount"];
                }
                
                
            } elseif($nef["estype"] == "4") {
// yearly
                $sqlstr1 .= ",esty";
                $sqlstr2 .= ",".$nef["dayofmonthyear"];
                if($nef["dayofmonthyear"] == "1") {
                    $sqlstr1 .= ",esty1d,esty1m";
                    $sqlstr2 .= ",'".$nef["dayofmonthyearday"]."','".$nef["dayofmonthyearmonth"]."'";
                } else {
                    $sqlstr1 .= ",esty2dp,esty2wd,esty2m";
                    $sqlstr2 .= ",".$nef["whichdayofmonthyear"].",".$nef["whichdayofmonthyearday"].",'".$nef["whichdayofmonthyearmonth"]."'";
                }
            }
            
            
            if($nef["eventend"] == "0") {
                $sqlstr1 .= ")";
                $sqlstr2 .= ")";
                
            } elseif($nef["eventend"] == "1") {
// end after a certain number of occurances
            
//                $sqlstr1 .= ",ese,eseaoint,endafterdate,endafterdays)";
                
                $cevdate = mktime(0,0,0,$nef["eventmonth"],$nef["eventday"],$nef["eventyear"]);
                $cevdinf = getdate($cevdate);
                $xev = 0;
                
                    if($nef["estype"] == "1") {
// daily
                        if($nef["daytype"]=="1") {
                            $xev++;
                            while($xev<$nef["eventendafter"]) {
                                $cevdate = dateadd("d",$nef["eachdaycount"],$cevdate);
                                $xev++;
                            }
                        } else {
                            while($cevdinf["wday"] == 0 || $cevdinf["wday"] == 6) {
                                $cevdate = dateadd("d",1,$cevdate);
                                $cevdinf = getdate($cevdate);
                            }
                            $xev++;
                            while($xev<$nef["eventendafter"]) {
                                $cevdate = dateadd("d",$nef["eachdaycount"],$cevdate);
                                $cevdinf = getdate($cevdate);
                                if($cevdinf["wday"] > 0 && $cevdinf["wday"] < 6) {
                                    $xev++;
                                }
                            }
                        }
                        
                        $xmaxdate = $cevdate;
                        
                    } elseif($nef["estype"] == "2") {
// weekly
                        $xwcnt = $nef["eachweekcount"] * 7;

                        if(isset($nef["weekday1"])) {$xwar[1]= 1;} else {$xwar[1]= 0;} //mon
                        if(isset($nef["weekday2"])) {$xwar[2]= 1;} else {$xwar[2]= 0;} //tue
                        if(isset($nef["weekday3"])) {$xwar[3]= 1;} else {$xwar[3]= 0;} //wed
                        if(isset($nef["weekday4"])) {$xwar[4]= 1;} else {$xwar[4]= 0;} //thu
                        if(isset($nef["weekday5"])) {$xwar[5]= 1;} else {$xwar[5]= 0;} //fri
                        if(isset($nef["weekday6"])) {$xwar[6]= 1;} else {$xwar[6]= 0;} //sat
                        if(isset($nef["weekday7"])) {$xwar[0]= 1;} else {$xwar[0]= 0;} //sun
                        
                        $tcevdate = $cevdate;
                        
                        while($xev<$nef["eventendafter"]) {
                            for($cxva=1;$cxva<=7;$cxva++) {
                                $xtvar = $cevdinf["wday"];
                                 if($xwar[$xtvar] == 1) {
                                    $xmaxdate = $cevdate;
                                 }
                                $cevdate = dateadd("d",1,$cevdate);
                                $cevdinf = getdate($cevdate);
                            }
                            $cevdate = dateadd("d",$xwcnt,$tcevdate);
                            $tcevdate = $cevdate;
                            $xev++;
                        }

                    } elseif($nef["estype"] == "3") {
// monthly
                        if($nef["dayofmonth"] == "1") {
                        
// same day every month increment                        
//                            $sqlstr1 .= ",estm1d,estm1int";
//                            $sqlstr2 .= ",'".$nef["dayofmonthday"]."',".$nef["dayofmonthcount"];
                            $cevdate = mktime(0,0,0,$nef["eventmonth"],$nef["dayofmonthday"],$nef["eventyear"]);
                            $xev = 1;
                            $xwcnt = $nef["dayofmonthcount"];
                            while($xev<$nef["eventendafter"]) {
                                $cevdate = dateadd("m",$xwcnt,$cevdate);
                                $xev++;
                            }
                            $xmaxdate = $cevdate;

                        } else {
                        
// same day pos every month increment                      
//                            $sqlstr1 .= ",estm2dp,estm2wd,estm2int";
//                            $sqlstr2 .= ",".$nef["whichdayofmonth"].",".$nef["whichdayofmonthday"].",".$nef["whichdayofmonthcount"];

                            $xwcnt = $nef["whichdayofmonthcount"];
                            $ckdpos = $nef["whichdayofmonth"];

                            if($nef["whichdayofmonthday"] == 1) {
                                $ckday = 1;
                            } elseif($nef["whichdayofmonthday"] == 2) {                            
                                $ckday = 2;
                            } elseif($nef["whichdayofmonthday"] == 3) {                            
                                $ckday = 3;
                            } elseif($nef["whichdayofmonthday"] == 4) {                            
                                $ckday = 4;
                            } elseif($nef["whichdayofmonthday"] == 5) {                            
                                $ckday = 5;
                            } elseif($nef["whichdayofmonthday"] == 6) {                            
                                $ckday = 6;
                            } elseif($nef["whichdayofmonthday"] == 7) { 
                                $ckday = 0;
                            } elseif($nef["whichdayofmonthday"] == 8) {                            
                                $ckday = 8;
                            } elseif($nef["whichdayofmonthday"] == 9) {                            
                                $ckday = 9;
                            } elseif($nef["whichdayofmonthday"] == 10) {                            
                                $ckday = 10;
                            }
                            
                            if($ckdpos < 5) {
// first - fourth whatever                            
                                $cevdate = mktime(0,0,0,$nef["eventmonth"],1,$nef["eventyear"]);
                                $cevdinf = getdate($cevdate);
                                $xwdc = 0;
                                while($xev<$nef["eventendafter"]) {
                                    if($ckday < 7) {
                                        if($cevdinf["wday"] == $ckday) {
                                            $xwdc++;
                                        }
                                    } elseif($ckday == 8) {
                                        if($cevdinf["wday"] >= 0 && $cevdinf["wday"] <= 6) {
                                            $xwdc++;
                                        }
                                    } elseif($ckday == 9) {
                                        if($cevdinf["wday"] == 0 || $cevdinf["wday"] == 6) {
                                            $xwdc++;
                                        }
                                    } elseif($ckday == 10) {
                                        $xwdc++;
                                    }
                                    if($xwdc == $ckdpos) {
                                        $xev++;
                                        $xwdc = 0;
                                        $xmaxdate = $cevdate;
                                        $cevdate = mktime(0,0,0,$cevdinf["mon"],1,$cevdinf["year"]);
                                        $cevdate = dateadd("m",$xwcnt,$cevdate);
                                        $cevdinf = getdate($cevdate);
                                    } else {
                                        $cevdate = dateadd("d",1,$cevdate);
                                        $cevdinf = getdate($cevdate);
                                    }
                                }

                            } else {
// last whatever                            
                                $cevdate = mktime(0,0,0,$nef["eventmonth"],1,$nef["eventyear"]);
                                $cevdate = dateadd("m",1,$cevdate);
                                $cevdate = dateadd("d",-1,$cevdate);
                                $cevdinf = getdate($cevdate);
                                $xwdc = 0;
                                $ckdpos = 1;
                                while($xev < $nef["eventendafter"]) {
                                    if($ckday < 7) {
                                        if($cevdinf["wday"] == $ckday) {
                                            $xwdc++;
                                        }
                                    } elseif($ckday == 8) {
                                        if($cevdinf["wday"] >= 0 && $cevdinf["wday"] <= 6) {
                                            $xwdc++;
                                        }
                                    } elseif($ckday == 9) {
                                        if($cevdinf["wday"] = 0 || $cevdinf["wday"] == 6) {
                                            $xwdc++;
                                        }
                                    } elseif($ckday == 10) {
                                        $xwdc++;
                                    }
                                    if($xwdc == $ckdpos) {
                                        $xev++;
                                        $xwdc = 0;
                                        $xmaxdate = $cevdate;
                                        $cevdate = mktime(0,0,0,$cevdinf["mon"],1,$cevdinf["year"]);
                                        $cevdate = dateadd("m",2,$cevdate);
                                        $cevdate = dateadd("d",-1,$cevdate);
                                        $cevdinf = getdate($cevdate);
                                    } else {
                                        $cevdate = dateadd("d",-1,$cevdate);
                                        $cevdinf = getdate($cevdate);
                                    }
                                }
                            }

                            $xmaxdate = $cevdate;
                        }
                        
                    } elseif($nef["estype"] == "4") {

                        $xycnt = $nef["eventendafter"] - 1;
  
                        if($nef["dayofmonthyear"] == 1) {
                            $cevdate = mktime(0,0,0,$nef["dayofmonthyearmonth"],$nef["dayofmonthyearday"],$cevdinf["year"]);                            
                            $cevdate = dateadd("yyyy",$xycnt,$cevdate);
                            $xmaxdate = $cevdate;
                            
                        } else {
                            $cevdate = mktime(0,0,0,$nef["whichdayofmonthyearmonth"],1,$cevdinf["year"]);                            
                            $cevdate = dateadd("m",1,$cevdate);
                            $cevdate = dateadd("d",-1,$cevdate);
                            $cevdate = dateadd("yyyy",$xycnt,$cevdate);
                            $xmaxdate = $cevdate;
                        }
                    }
//                }  // end for loop event counter

                $sqlstr1 .= ",ese,eseaoint,endafterdate,endafterdays)";

                $xmdi = getdate($xmaxdate);
                $sqlstr2 .= ",1,".$nef["eventendafter"].",'".$xmdi["year"]."-".$xmdi["mon"]."-".$xmdi["mday"]."',to_days('".$xmdi["year"]."-".$xmdi["mon"]."-".$xmdi["mday"]."'))";
                
            } else {
            
                $sqlstr1 .= ",ese,esed,esem,esey";
                $sqlstr2 .= ",2,'".$nef["eventendday"]."','".$nef["eventendmonth"]."','".$nef["eventendyear"]."'";

                $sqlstr1 .= ",endafterdate,endafterdays)";
                $sqlstr2 .= ",'".$nef["eventendyear"]."-".$nef["eventendmonth"]."-".$nef["eventendday"]."',to_days('".$nef["eventendyear"]."-".$nef["eventendmonth"]."-".$nef["eventendday"]."'))";
            }
        }
        



        $sqlstr = $sqlstr1.$sqlstr2;
        $query1 = mysql_query($sqlstr) or die("Cannot insert to calendar events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        
        if(isset($nef["sendreminder"])) {
            $sqlstr = "select LAST_INSERT_ID() as neid";
            $query1 = mysql_query($sqlstr) or die("Cannot get new calendar event id<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            $row = mysql_fetch_array($query1);
            $neid = $row["neid"];
            @mysql_free_result($query1);
            if($neid == 0) {
                die("New Event ID = 0, this is an error.");
            }
            $conlist = explode("|",$nef["srcons"]);
            foreach($conlist as $k1 => $v1) {
                $contyp = substr($conlist[$k1],0,1);
                if($contyp == "M") {
                    $conid = $user->gsv("cuid");
                } else {
                    $conid = substr($conlist[$k1],1);
                }
                $sqlstr = "INSERT INTO ".$GLOBALS["tabpre"]."_cal_event_rems (calid,uid,evid,contyp,conid) values('".$user->gsv("curcalid")."',".$user->gsv("cuid").",".$neid.",'".$contyp."',".$conid.")";
                $query1 = mysql_query($sqlstr) or die("Cannot insert into calendar event reminder table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            }
        }
    }    


    if(isset($func)) {
    
        global $weekstartonmonday,$daytext,$daytextl,$monthtext,$monthtextl;
        global $langcfg;
    
        $dptxt[1] = "First";
        $dptxt[2] = "Second";
        $dptxt[3] = "Third";
        $dptxt[4] = "Fourth";
        $dptxt[5] = "Last";
    
        $wdtxt[8] = "Weekday";
        $wdtxt[9] = "Weekend day";
        $wdtxt[10] = "Day";
        
/***************************************************************
**  this deletes an event
***************************************************************/ 

        if($func=="deleteevent") {
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_events where uid=".$user->gsv("cuid")." and calid = '".$user->gsv("curcalid")."' and evid=".$evid." limit 1";
            $query1 = mysql_query($sqlstr) or die("Cannot delete calendar event<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_event_rems where uid=".$user->gsv("cuid")." and calid = '".$user->gsv("curcalid")."' and evid=".$evid;
            $query1 = mysql_query($sqlstr) or die("Cannot delete calendar event reminders<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        }
    
/***************************************************************
**  this brings up the edit event form
***************************************************************/ 

        if($func=="editevent") {
            editeventform(&$user,$evid);
        }
    
/***************************************************************
**  this brings up the show event page
***************************************************************/ 



        if($func=="showevent") {
        
            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_events where uid=".$user->gsv("cuid")." and calid = '".$user->gsv("curcalid")."' and evid=".$evid;
            $query1 = mysql_query($sqlstr) or die("Cannot query calendar events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            echo "<html>\n";
            echo "<head>\n";
            echo "<title>Event Info</title>\n";
?>
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

function gocal_onclick() {
	eevent.evid.value="";
	eevent.evdate.value="";
	eevent.func.value="";
	eevent.submit();
}

function eved_onclick() {
	eevent.func.value="editevent";
	eevent.submit();
}

function evdel_onclick() {
	if(eevent.evies.value == "1") {
		if(confirm("Are you sure you wish to delete this series event?\nDeleteing it will also delete all occurances of the series.\nIf you wish only to delete this occurance of the series,\nyou can do so by useing the edit feature.") == true) {
			eevent.func.value="deleteevent";
			eevent.submit();
		}
		
	} else {
		if(confirm("Are you sure you wish to delete this event?") == true) {
			eevent.func.value="deleteevent";
			eevent.submit();
		}
	}
}

//-->
</SCRIPT>
<?php
            echo "</head>\n";
            echo "<body background=\"".$curcalcfg["gcbgimg"]."\" >\n";
            echo "<h1>Event Information</h1>\n";
            
            while($row = mysql_fetch_array($query1)) {
            
                echo "<table border=\"1\" width=\"100%\">\n";
                echo "<tr>\n";
                echo "<th align=\"left\" width=\"12%\" valign=\"top\">Title:</th>\n";
                echo "<td width=\"88%\" valign=\"top\">\n";
                echo ($row["title"]);
                echo "</td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<th align=\"left\" width=\"12%\" valign=\"top\">Category:</th>\n";
                echo "<td width=\"88%\" valign=\"top\">\n";
                if($row["catid"] != 0) {
                    $sqlstrc = "select * from ".$GLOBALS["tabpre"]."_user_cat where uid=".$user->gsv("cuid")." and (calid = '".$user->gsv("curcalid")."' or calid='0') and catid=".$row["catid"];
                    $queryc = mysql_query($sqlstrc) or die("Cannot query user cats table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstrc."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                    if($rowc = mysql_fetch_array($queryc)) {
                        echo $rowc["catname"];
                    }
                    @mysql_free_result($queryc);
                } else {
                    echo "None assigned";
                }
                echo "</td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<th align=\"left\" width=\"12%\" valign=\"top\">\n";
                if($row["iseventseries"] != 0) {
                    if($row["estype"] == 1) {
                        echo "Daily, starting on:";
                    } elseif($row["estype"] == 2) {
                        echo "Weekly, starting on:";
                    } elseif($row["estype"] == 3) {
                        echo "Monthly, starting on:";
                    } elseif($row["estype"] == 4) {
                        echo "Yearly, starting on:";
                    }
                } else {
                    echo "Date:";
                }
                echo "</th>\n";
                echo "<td width=\"88%\" valign=\"top\">\n";
                $tmtxt = $row["startmonth"];
                if(substr($tmtxt,0,1) == "0") {$tmtxt = substr($tmtxt,1,1);}
                echo $row["startday"].".".$monthtextl[$tmtxt].".".$row["startyear"];
    
                if($row["iseventseries"] != 0) {
                
                    echo "<br>";
                    if($row["estype"] == 1) {
                        if($row["estd"] == 1) {
                            if($row["estdint"] == 1) {
                                echo "Every day.";
                            } else {
                                echo "Every ".$row["estdint"]." days.";
                            }
                        } else {
                            echo "Every weekday.";
                        }
                    } elseif($row["estype"] == 2) {
                    
                        if($row["estwint"] == 1) {
                            echo "Every week on:<br>";
                            $have1day = false;
                            for($wa=0;$wa<7;$wa++) {
                                $twa = substr($row["estwd"],$wa,1);
                                if($twa == 1) {
                                    if($have1day == true) {
                                        echo ", ";
                                    }
                                    echo $daytextl[$wa+1];
                                    $have1day = true;
                                }
                            }
                        } else {
                            echo "Every ".$row["estwint"]." weeks on: ";
                            $have1day = false;
                            for($wa=0;$wa<7;$wa++) {
                                $twa = substr($row["estwd"],$wa,1);
                                if($twa == 1) {
                                    if($have1day == true) {
                                        echo ", ";
                                    }
                                    echo $daytextl[$wa+1];
                                    $have1day = true;
                                }
                            }
                        }
                    } elseif($row["estype"] == 3) {
                        if($row["estm"] == 1) {
                            if($row["estm1int"] == 1) {
                                echo "Every month on the: ";
                            } else {
                                echo "Every ".$row["estm1int"]." months on the: ";
                            }
                            echo $row["estm1d"];
                        } else {
                            if($row["estm2int"] == 1) {
                                echo "Every month on the: ";
                            } else {
                                echo "Every ".$row["estm2int"]." months on the: ";
                            }
                            $twa = $row["estm2dp"];
                            echo $dptxt[$twa]."&nbsp;";
                            $twa = $row["estm2wd"];
                            if($row["estm2wd"] > 7) {
                                $wdtxt[$twa];
                            } else {
                                $daytextl[$twa];
                            }
                        }

                    } elseif($row["estype"] == 4) {

                        if($row["esty"] == 1) {
                           echo "Every year on: ".$row["esty1d"].".";
                           $tmtxt = $row["esty1m"];
                           if(substr($tmtxt,0,1) == "0") {$tmtxt = substr($tmtxt,1,1);}
                           echo $monthtextl[$tmtxt];
                        } else {
                           echo "Every year on the: ";
                            $twa = $row["esty2dp"];
                            echo $dptxt[$twa]."&nbsp;";
                            $twa = $row["esty2wd"];
                            if($row["esty2wd"] > 7) {
                                $wdtxt[$twa];
                            } else {
                                $daytextl[$twa];
                            }
                            echo "&nbsp;in&nbsp;";
                           $tmtxt = $row["esty2m"];
                           if(substr($tmtxt,0,1) == "0") {$tmtxt = substr($tmtxt,1,1);}
                           echo $monthtextl[$tmtxt];
                        }
                    }
                    if($row["ese"] == 0) {
                        echo "<br>Series has no end date.";
                    } else {
                        if($row["ese"] == 1) {
                            echo "<br>Series will end after ".$row["eseaoint"]." occurances.";
                        } else {
                           $tmtxt = $row["esem"];
                           if(substr($tmtxt,0,1) == "0") {$tmtxt = substr($tmtxt,1,1);}
                           echo "<br>Series will end after the ".$row["esed"].".".$monthtextl[$tmtxt].".".$row["esed"];
                        }
                    }
                }
                echo "</td>\n";
                echo "</tr>\n";
                
                echo "<tr>\n";
                echo "<th align=\"left\" width=\"12%\" valign=\"top\">\n";
                echo "Time:</th>\n";
                echo "<td width=\"88%\" valign=\"top\">\n";
                if($row["isallday"] == 1) {
                    echo "This is an all day event\n";
                } else {
                    echo "From: ".$row["starthour"].":".$row["startmin"]."&nbsp;&nbsp;To: ".$row["endhour"].":".$row["endmin"];
                }
                echo "</td>\n";
                echo "</tr>\n";
                
                echo "<tr>\n";
                echo "<th align=\"left\" width=\"12%\" valign=\"top\">Description:</th>\n";
                echo "<td width=\"88%\" valign=\"top\">\n";
                echo nl2br($row["description"]);
                echo "&nbsp;";
                echo "</td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<th align=\"left\" width=\"12%\" valign=\"top\">Reminder:</th>\n";
                echo "<td width=\"88%\" valign=\"top\">\n";
                if($row["sendreminder"] == 0) {
                    echo "None";
                } else {
                    echo "A Reminder will be sent to the following contacts, ".$row["srval"]."&nbsp;";
                    if($row["srval"] == 1) {
                        if($row["srint"] == 1) {
                            echo "minute ";
                        } elseif($row["srint"] == 2) {
                            echo "hour ";
                        } else {
                            echo "day ";
                        }
                    } else {
                        if($row["srint"] == 1) {
                            echo "minutes ";
                        } elseif($row["srint"] == 2) {
                            echo "hours ";
                        } else {
                            echo "days ";
                        }
                    }
                    echo "before the event takes place.<br>\n";
                    $sqlstrc = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid=".$user->gsv("cuid")." and calid = '".$user->gsv("curcalid")."' and evid=".$evid." order by contyp";
                    $queryc = mysql_query($sqlstrc) or die("Cannot query event reminder contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstrc."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                    $amatc = false;
                    $amatg = false;
                    $amatm = false;
                    $haveme = false;
                    while($rowc = mysql_fetch_array($queryc)) {
                        if($rowc["contyp"] == "M") {
                            echo "<br>Your self\n";
                            $haveme = true;
                        }elseif($rowc["contyp"] == "C") {
                            if($amatc == false) {
                                $amatc = true;
                                echo "<b>Individuals:</b><br>\n";
                            }
                            $sqlstrd = "select * from ".$GLOBALS["tabpre"]."_user_con where uid=".$user->gsv("cuid")." and conid = ".$rowc["conid"];
                            $queryd = mysql_query($sqlstrd) or die("Cannot query user contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstrd."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $rowd = mysql_fetch_array($queryd);
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"mailto:".$rowd["email"]."\">".$rowd["fname"]."&nbsp;".$rowd["lname"]."</a>&nbsp;";
                            if($rowd["tel1"] != "") {
                                echo "Tel: ".$rowd["tel1"];
                            } else {
                                echo "Tel: Not entered.";
                            }
                            echo "<br>\n";
                            @mysql_free_result($queryd);
                        }elseif($rowc["contyp"] == "G") {
                            if($amatg == false) {
                                $amatg = true;
                                echo "<b>Groups:</b><br>\n";
                            }
                            $sqlstrd = "select * from ".$GLOBALS["tabpre"]."_user_con_grp where uid=".$user->gsv("cuid")." and congpid = ".$rowc["conid"];
                            $queryd = mysql_query($sqlstrd) or die("Cannot query user contact groups table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstrd."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $rowd = mysql_fetch_array($queryd);
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$rowd["gpname"]."</b><br>\n";

                            $sqlstre = "select * from ".$GLOBALS["tabpre"]."_user_con where uid=".$user->gsv("cuid")." and congp = ".$rowd["congpid"];
                            $querye = mysql_query($sqlstre) or die("Cannot query user contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstre."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            while($rowe = mysql_fetch_array($querye)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"mailto:".$rowe["email"]."\">".$rowe["fname"]."&nbsp;".$rowe["lname"]."</a>&nbsp;";
                                if($rowe["tel1"] != "") {
                                    echo "Tel: ".$rowe["tel1"];
                                } else {
                                    echo "Tel: Not entered.";
                                }
                                echo "<br>\n";
                            }
                            @mysql_free_result($querye);
                            @mysql_free_result($queryd);
                        }
                    }
                    @mysql_free_result($queryc);
                    if($haveme == false) {
                        echo "<br><b>You are not on the list of contacts to receive a reminder for this event.</b>\n";
                    }
                }
                echo "&nbsp;</td>\n";
                echo "</tr>\n";
                echo "</table>\n";
                echo "<br>\n";

?>

<form method="POST" name="eevent" id="eevent" action="<?php echo $GLOBALS["idxfile"]; ?>">
<input type="hidden" name="evies" id="evies" value="<?php echo $row["iseventseries"]; ?>">
<input type="hidden" name="evid" id="evid" value="<?php echo $evid; ?>">
<input type="hidden" name="evdate" id="evdate" value="<?php echo $evdate; ?>">
<input type="hidden" name="func" id="func" value="">
<table border="1" width="50%">
<tr>
<td width="33%" align="center">
<INPUT type="button" value="Edit Event" id="eved" name="eved" LANGUAGE=javascript onclick="return eved_onclick()">
</td><td width="33%" align="center">
<INPUT type="button" value="Delete Event" id="evdel" name="evdel" LANGUAGE=javascript onclick="return evdel_onclick()">
</td><td width="34%" align="center">
<INPUT type="button" value="Go To Calendar" id="gocal" name="gocal" LANGUAGE=javascript onclick="return gocal_onclick()">
</td>
</tr>
</table>
</form>

<?php                
                
/*                
                echo "<table border=\"1\" width=\"50%\">\n";
                echo "<tr>\n";
                echo "<td width=\"33%\" align=\"center\">\n";
                echo "<A class=\"gcprevlink\" HREF=\"".$GLOBALS["idxfile"]."?func=editevent&evid=".$evid;
                if($GLOBALS["adsid"] == true) {
                    echo "&".SID;
                }
                echo "\">Edit Event</A>\n";
                echo "</td>";
                echo "<td width=\"33%\" align=\"center\">\n";
                
                echo "<A class=\"gcprevlink\" HREF=\"".$GLOBALS["idxfile"]."?func=deleteevent&evid=".$evid;
                if($GLOBALS["adsid"] == true) {
                    echo "&".SID;
                }
                echo "\">Delete Event</A>\n";
                
                echo "</td>";
                echo "<td width=\"34%\" align=\"center\">\n";
                
                echo "<A class=\"gcprevlink\" HREF=\"".$GLOBALS["idxfile"];
                if($GLOBALS["adsid"] == true) {
                    echo "?".SID;
                }
                echo "\">Go To Calendar</A>\n";
                
                echo "</td>\n";
                echo "</tr>\n";
                echo "</table>\n";
*/                
            }
            @mysql_free_result($query1);
            
            echo "<br>\n";

            include_once("./include/footer.php");

            exit();
        }
    }
?> 