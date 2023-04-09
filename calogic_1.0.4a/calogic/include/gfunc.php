<?php

function checkforevents($eday, $emonth, $eyear,$ehour,$emin,$eview) {
// day, month, year, hour, minute
    global $weekstartonmonday;
    global $user,$curcalcfg;
    global $langcfg;
    $eventcnt = 0;
    $eventar = array();
    $sortar = array();
    
//        $sqlstr = "Select * from ".$GLOBALS["tabpre"]."_cal_events where iseventseries=0 and startday='".$eday."' and startmonth='".$emonth."' and startyear='".$eyear."' and uid=".$user->gsv("cuid")." and calid='".$user->gsv("curcalid")."' order by isallday,starthour,startmin";
//        $sqlstr = "Select * from ".$GLOBALS["tabpre"]."_cal_events where iseventseries=0 and startday='".$eday."' and startmonth='".$emonth."' and startyear='".$eyear."' and uid=".$user->gsv("cuid")." and calid='".$user->gsv("curcalid")."' order by isallday desc,starthour,startmin";
        $sqlstr = "Select * from ".$GLOBALS["tabpre"]."_cal_events where iseventseries=0 and startday='".$eday."' and 
        startmonth='".$emonth."' and startyear='".$eyear."' and uid=".$user->gsv("cuid")." and 
        calid='".$user->gsv("curcalid")."' order by isallday desc,starthour,startmin";
        $query1 = mysql_query($sqlstr) or die("Cannot query calendar events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
/*
        $qu_num = @mysql_num_rows($query1);
        if($qu_num < 1) {
            @mysql_free_result($query1);
            $eventar[0][0] = 0;
            return $eventar;
        }
*/        
        $trcntn = @mysql_num_rows($query1);
//        echo "<br>rc1: ".$trcntn."<br />";

        while($row = mysql_fetch_array($query1)) {
            $eventcnt++;

                $eventar[$eventcnt]["id"] = $row["evid"];
                if($row["isallday"] == 1) {
                    $eventar[$eventcnt]["isallday"] = "1";
                    $eventar[$eventcnt]["sorttime"] = "0";
                    $sortar[$eventcnt] = "0";
                    $eventar[$eventcnt]["starttimet"] = "";
                    $eventar[$eventcnt]["endtimet"] = "";
                } else {
                    $eventar[$eventcnt]["isallday"] = "0";
                    $eventar[$eventcnt]["sorttime"] = $row["starthour"].$row["startmin"].$row["endhour"].$row["endmin"];
                    $sortar[$eventcnt] = $row["starthour"].$row["startmin"].$row["endhour"].$row["endmin"];
                    $eventar[$eventcnt]["starttimet"] = $row["starthour"].":".$row["startmin"];
                    $eventar[$eventcnt]["endtimet"] = $row["endhour"].":".$row["endmin"];
                }
                $eventar[$eventcnt]["title"] = $row["title"];
                $eventar[$eventcnt]["sendreminder"] = $row["sendreminder"];
                $eventar[$eventcnt]["description"] = $row["description"];
                if($row["catid"] != 0) {
                    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_cat where catid = ".$row["catid"];
                    $query2 = mysql_query($sqlstr) or die("Cannot query user categories table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                    $row2 = mysql_fetch_array($query2);
                    $eventar[$eventcnt]["catcolorbg"] = $row2["catcolorbg"];
                    if($row2["catcolortext"] == "") {
                        $eventar[$eventcnt]["catcolortext"] = "black";
                    } else {
                        $eventar[$eventcnt]["catcolortext"] = $row2["catcolortext"];
                    }
                    @mysql_free_result($query2);
                } else {
                    $eventar[$eventcnt]["catcolorbg"] = "";
                    $eventar[$eventcnt]["catcolortext"] = "black";
                }
     
        }
        
        @mysql_free_result($query1);

//        $eventar[0][0] = $eventcnt;
//        return $eventar;

        $sqlstr = "Select * from ".$GLOBALS["tabpre"]."_cal_events t where (t.iseventseries=1 and t.uid=".$user->gsv("cuid")." and t.calid='".$user->gsv("curcalid")."' and to_days(CONCAT_WS('-', t.startyear, t.startmonth,t.startday)) <= to_days('".$eyear."-".$emonth."-".$eday."'))
and ((ese = 2 and to_days('".$eyear."-".$emonth."-".$eday."') <= to_days(CONCAT_WS('-', t.esey, t.esem,t.esed))) or
(t.ese=0) or (t.ese=1 and to_days('".$eyear."-".$emonth."-".$eday."') <= endafterdays)) order by t.isallday desc,t.starthour,t.startmin";

        $query1 = mysql_query($sqlstr) or die("Cannot query calendar series in events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
//Select where to_days(CONCAT_WS('-', t.startyear, t.startmonth,t.startday)) from clw_cal_events t
 
 //       $trcntn = @mysql_num_rows($query1);
//        echo "<br>rc2: ".$trcntn."<br />".$sqlstr."<br>";
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
                $eventcnt++;
                $eventar[$eventcnt]["id"] = $row["evid"];
                if($row["isallday"] == 1) {
                    $eventar[$eventcnt]["isallday"] = "1";
                    $eventar[$eventcnt]["sorttime"] = "0";
                    $sortar[$eventcnt] = "0";
                    $eventar[$eventcnt]["starttimet"] = "";
                    $eventar[$eventcnt]["endtimet"] = "";
                } else {
                    $eventar[$eventcnt]["isallday"] = "0";
                    $eventar[$eventcnt]["sorttime"] = $row["starthour"].$row["startmin"].$row["endhour"].$row["endmin"];
                    $sortar[$eventcnt] = $row["starthour"].$row["startmin"].$row["endhour"].$row["endmin"];
                    $eventar[$eventcnt]["starttimet"] = $row["starthour"].":".$row["startmin"];
                    $eventar[$eventcnt]["endtimet"] = $row["endhour"].":".$row["endmin"];
                }
                $eventar[$eventcnt]["title"] = $row["title"];
                $eventar[$eventcnt]["sendreminder"] = $row["sendreminder"];
                $eventar[$eventcnt]["description"] = $row["description"];
                if($row["catid"] != 0) {
                    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_cat where catid = ".$row["catid"];
                    $query2 = mysql_query($sqlstr) or die("Cannot query user categories table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                    $row2 = mysql_fetch_array($query2);
                    $eventar[$eventcnt]["catcolorbg"] = $row2["catcolorbg"];
                    if($row2["catcolortext"] == "") {
                        $eventar[$eventcnt]["catcolortext"] = "black";
                    } else {
                        $eventar[$eventcnt]["catcolortext"] = $row2["catcolortext"];
                    }
                    @mysql_free_result($query2);
                } else {
                    $eventar[$eventcnt]["catcolorbg"] = "";
                    $eventar[$eventcnt]["catcolortext"] = "black";
                }
            }
        }
        
        @mysql_free_result($query1);
        
/*        foreach ($eventar as $val) {
            $sortarray[] = $val["sorttime"];
        }
        
        array_multisort($eventar, $sortarray);
*/
        asort($sortar);
        $revar[0][0] = $eventcnt;
        $revcnt = 1;
        foreach($sortar as $key => $val) {
            $revar[$revcnt]["id"] = $eventar[$key]["id"];
            $revar[$revcnt]["isallday"] = $eventar[$key]["isallday"];
            $revar[$revcnt]["sorttime"] = $eventar[$key]["sorttime"];
            $revar[$revcnt]["starttimet"] = $eventar[$key]["starttimet"];
            $revar[$revcnt]["endtimet"] = $eventar[$key]["endtimet"];
            $revar[$revcnt]["title"] = $eventar[$key]["title"];
            $revar[$revcnt]["sendreminder"] = $eventar[$key]["sendreminder"];
            $revar[$revcnt]["catcolorbg"] = $eventar[$key]["catcolorbg"];
            $revar[$revcnt]["catcolortext"] = $eventar[$key]["catcolortext"];
            $revar[$revcnt]["description"] = $eventar[$key]["description"];
            $revcnt++;
        }
//        $eventar[0][0] = $eventcnt;
        

        if($eview == "Day") {
            return $revar;
        }
        if($eview == "Week") {
            return $revar;
        }
        if($eview == "Month") {
            return $revar;
        }
        if($eview == "Year") {
            if($haveevent == true || $eventcnt > 0) {
                return true;
            } else {
                return false;
            }
        }
        if($eview == "Minical") {
            if($haveevent == true || $eventcnt > 0) {
                return true;
            } else {
                return false;
            }
        }
        
        

}

function evtcmp($a, $b) {
    return strcmp($a["sorttime"], $b["sorttime"]);
}


?>