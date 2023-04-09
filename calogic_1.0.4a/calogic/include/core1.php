<?php

/***************************************************************
**  the first thing that gets checked for is if $submitsetup is set or not
    if it is not set and the startcalid == 0, then this is the first login after 
    conformation, therefor go directly to the calendar setup. 
***************************************************************/ 
    if(!isset($submitsetup)) {
        if($user->gsv("startcalid") == "0") {
            calsetup(1,"cg",&$user);
        } else {
        
/***************************************************************
**  this sets the selected calendar
***************************************************************/ 
            if(isset($gocalselect) || isset($goocalselect)) {
                if(isset($goocalselect)) {
                    $calselect = $ocalselect;
                }
                unset($gocalselect);
                unset($goocalselect);
                $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where calid='".$calselect."'";
                $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                $res_query1 = @mysql_num_rows($query1) ;
                if(mysql_error()) {
                    die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);    
                }
                if($res_query1 == 1) {
                    $row = mysql_fetch_array($query1);
                    if($row["userid"] == $user->gsv("cuid")) {
                        $user->ssv("curcalowner",1);
                    } else {
                        $user->ssv("curcalowner",0);
                    }
                    $user->ssv("curcaltype",$row["caltype"]);
                    if(($user->gsv("curcalowner") == 0 && $row["caltype"] < 2) || $user->gsv("curcalowner") == 1) {
                        $user->ssv("curcalid",$calselect);
                        $user->ssv("curcalname",($row["calname"]));
                        if(isset($mstdcal) && ($calselect <> $row["curcalid"]) && ($user->gsv("curcalowner") == 1)) {
                            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_reg set startcalid='".$calselect."', startcalname='".($row["calname"])."' where uid = ".$user->gsv("cuid")." limit 1";
                            $query2 = mysql_query($sqlstr) or die("Cannot update User Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $user->ssv("startcalid",$calselect);
                            $user->ssv("startcalname",($row["calname"]));
                        }
                    }
                } else {
                    die("Calendar not found in Config Table<br><br>File:".$erfilename."<br><br>Line: ".__LINE__.$GLOBALS["errep"]."<br><br>SQL String: ".$sqlstr);
                }

                mysql_free_result($query1);
                unset($csection);
                unset($calselect);
                
/***************************************************************
**  this creates a new calendar from the selected calendar
***************************************************************/ 
            } elseif(isset($prefgonc) || isset($prefgoonc)) {
                if(isset($prefgoonc)) {
                    $calselect = $ocalselect;
                }

                unset($prefgonc);
                unset($prefgoonc);

                $new_cal = getcalvals($calselect);
                srand((double)microtime()*1000000);
                $newcalid = md5(uniqid(rand()));
                $new_cal["calid"] = $newcalid;
                $new_cal["calname"] = time();
                $new_cal["caltitle"] = time();
                $new_cal["userid"] = $user->gsv("cuid");
                $new_cal["username"] = $user->gsv("uname");
                $sqlstr = "INSERT INTO ".$tabpre."_cal_ini VALUES (''"; 
                foreach($new_cal as $k1 => $v1) {
                    if($k1<>"tuid") {
                        $sqlstr .= ",'".$v1."'";
                    }
                }
                $sqlstr .= ")";
                $query1 = mysql_query($sqlstr) or die("Cannot Insert New Calendar<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                $user->ssv("curcalid",$newcalid);
                $user->ssv("curcalname",$new_cal["calname"]);
                $user->ssv("curcalowner",1);
                $user->ssv("curcaltype",$new_cal["caltype"]);
                getuserstandards(&$user);
                calsetup(0,"cg",&$user);

/***************************************************************
**  this deletes a calendar
***************************************************************/ 
            } elseif(isset($prefgodc)) {
                unset($prefgodc);
                if($user->gsv("curcalowner") == 1) {
                    $sqlstr = "DELETE FROM ".$tabpre."_cal_ini where calid='".$calselect."' and userid=".$user->gsv("cuid")." limit 1";
                    $query1 = mysql_query($sqlstr) or die("Cannot Delete Calendar<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                    
                    $sqlstr = "DELETE FROM ".$tabpre."_cal_events where calid='".$calselect."'";
                    $query1 = mysql_query($sqlstr) or die("Cannot Delete Calendar Events<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

                    $sqlstr = "DELETE FROM ".$tabpre."_cal_event_rems where calid='".$calselect."'";
                    $query1 = mysql_query($sqlstr) or die("Cannot Delete Calendar Event Reminders<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

                    if($user->gsv("startcalid") == $calselect) {
                        $sqlstr = "SELECT * FROM ".$tabpre."_cal_ini where userid=".$user->gsv("cuid")." limit 1";
                        $query1 = mysql_query($sqlstr) or die("Cannot Select Calendar<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                        $res_query1 = @mysql_num_rows($query1) ;
                        if($res_query1 == 1) {
                        	$row = mysql_fetch_array($query1) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);
                            $sqlstr = "UPDATE ".$tabpre."_user_reg set startcalid='".$row["calid"]."', startcalname='".($row["calname"])."' where uid=".$user->gsv("cuid")." limit 1";
                            $query1 = mysql_query($sqlstr) or die("Cannot Update User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $user->ssv("startcalid",$row["calid"]);
                            $user->ssv("startcalname",($row["calname"]));
                            
                            if($user->gsv("curcalid") == $calselect) {
                                $user->ssv("curcalid",$row["calid"]);
                                $user->ssv("curcalname",($row["calname"]));
                            }
                            getuserstandards(&$user);
                            calsetup(0,"cg",&$user);
    
                        } else {
                            $sqlstr = "UPDATE ".$tabpre."_user_reg set startcalid='0', startcalname='' where uid=".$user->gsv("cuid")." limit 1";
                            $query1 = mysql_query($sqlstr) or die("Cannot Update User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $user->ssv("curcalid","");
                            $user->ssv("curcalname","");
                            $user->ssv("startcalid","0");
                            $user->ssv("startcalname","");
                            calsetup(1,"cg",&$user);
                        }
                    } elseif($user->gsv("curcalid") == $calselect) {
                        $user->ssv("curcalid",$user->gsv("startcalid"));
                        $user->ssv("curcalname",$user->gsv("startcalname"));
                        getuserstandards(&$user);
                        calsetup(0,"cg",&$user);
                    }
                }
            }
            
/***************************************************************
**  as of this point, the userstandards must be set.
***************************************************************/ 
            getuserstandards(&$user);

/***************************************************************
**  this brings up the language editor, only for admins!
***************************************************************/ 
            if(isset($golangeditor) && $user->gsv("isadmin")=="1") {
                unset($golangeditor);
                unset($csection);
                langeditor($seledlang,&$user);        

/***************************************************************
**  this saves changed language entries, only for admins!
***************************************************************/ 
            } elseif(isset($savelang) && $user->gsv("isadmin")=="1") {
            
              ?>            
              <html>
              <head>
              <title><?php echo $langcfg["pwlet"]; ?></title>
              </head>
              
              <body background="<?php echo $curcalcfg["gcbgimg"]; ?>">
              
              <h3><?php echo $langcfg["pwles"]; ?></h3>
              
              <?php
              
//              $sqlstr = "select * from ".$GLOBALS["tabpre"]."_lang_".$seledlang." order by uid";
//              $query1 = mysql_query($sqlstr) or die("Cannot query Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);
              
              set_time_limit(60);
              $htmltrans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
              $transhtml = array_flip($htmltrans);
              $fcnt = 1;
              foreach($fields as $k1 => $v1) {
                  $haveupd = 0;
                  foreach ($v1 as $k2 => $v2) {
                      if(strtr($fields[$k1][$k2],$transhtml) <> strtr($prev_fields[$k1][$k2],$transhtml)) {
                          if($haveupd==0) {
                              $haveupd = 1;
                              $sqlstr = "update ".$GLOBALS["tabpre"]."_lang_".$seledlang." set ".$k2."='".(strtr((($fields[$k1][$k2])),$transhtml))."'";
                          } else {
                              $sqlstr .= ", ".$k2."='".(strtr((($fields[$k1][$k2])),$transhtml))."'"; 
                          } 
                          echo "*";
                      } else {
                          echo ".";
                      }
                              
                      flush();
                      usleep(25);
                  }
              
                  if($haveupd==1) {
                      $sqlstr .= " where uid=".$k1;
                      $query1 = mysql_query($sqlstr) or die("Cannot update Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);        
                  }
                      
                  $fcnt++;
                  if($fcnt==60) {
                      $fcnt=1;
                      echo "<br>";
                  }
                  flush();
              }
              
              ?>
              <br>
              <h3><?php echo $langcfg["pwlec"]; ?></h3>
              <br>
              <a href="<?php echo $GLOBALS["idxfile"];
                if($GLOBALS["adsid"] == true) {
                    echo "?".SID;
                }
              
               ?>"><?php echo $langcfg["butgoc"]; ?></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo $GLOBALS["idxfile"]; 

                if($GLOBALS["adsid"] == true) {
                    echo "?goprefs=1&".SID;
                }

               ?>"><?php echo $langcfg["butgoset"]; ?></a>&nbsp;&nbsp;&nbsp;<a href="<?php 
               
               echo $GLOBALS["idxfile"]; 
               
               ?>?golangeditor=1&seledlang=<?php echo $seledlang; 
                if($GLOBALS["adsid"] == true) {
                    echo "&".SID;
                }
               ?>"><?php echo $langcfg["butgoled"]; ?></a>
              <?php
echo "<br><br>";
include_once("./include/footer.php");
              exit();
            }
        }
    }
    
/***************************************************************
**  so, this is the submitsetup section, and only gets called to setup
    the first calendar
***************************************************************/ 

    if(isset($submitsetup)) {
    
        unset($submitsetup);

        $sqlstr = "select * from ".$tabpre."_cal_ini where userid = ".$user->gsv("cuid")." and calname = '".($fields["calname"])."'";

        $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $res_query1 = @mysql_num_rows($query1);
        if (mysql_error()) {
            die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>Line: ".__LINE__.$GLOBALS["errep"]."<br><br>Result: ".$res_query1);
        }
                        
        if($res_query1 > 0) {
            
            echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";
            echo "<html>\n";
            echo "<head>\n";
            
            echo "<title>".$langcfg["badcalnt"]."</title>\n";
            echo "</head>\n";
            echo "<body background=\"$standardbgimg\">\n";
            echo "<center><br><h3>".$langcfg["badcaln"]." ".stripslashes($fields["calname"])."</h3><br><a href=\"".$GLOBALS["idxfile"];
                if($GLOBALS["adsid"] == true) {
                    echo "?".SID;
                }
            echo "\">".$langcfg["pctta"]."</a></center>";
            echo "<br><br>";
            include_once("./include/footer.php");
            exit();
        
        } else {

            echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";
            echo "<html>\n";
            echo "<head>\n";
            
            echo "<title>".$langcfg["pwsnc1"]."</title>\n";
            echo "</head>\n";
            echo "<body background=\"$standardbgimg\">\n";
            echo "<center><br><h3>".$langcfg["pwsnc2"]." '".stripslashes($fields["calname"])."' ".$langcfg["pwsnc3"]."</h3><br><br><br><br>\n";
        
            srand((double)microtime()*1000000);
            $newcalid = md5(uniqid(rand()));
            $sqlstr = "INSERT INTO ".$tabpre."_cal_ini 
            VALUES ('', '$newcalid', '".($fields["calname"])."', ".$user->gsv("cuid").", '".$user->gsv("uname")."', '".($fields["caltitle"])."', ".$fields["caltype"].", ".$fields["showweek"].", '".$fields["preferedview"]."', ".$fields["weekstartonmonday"].", ".$fields["weekselreact"].", '".$fields["daybeginhour"]."', '".$fields["dayendhour"]."', ".$fields["timetype"].", 
            '".$standardbgimg."', '#0000FF', '', 'underline', '#0000FF', '', 'underline', '#0000FF', 'underline', '#FFFF00', 
            '#000000', '#B04040', '#FFFFFF', 
            'none', '#FFFFFF', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', 
            '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#FFFFFF', 'none', '#FFFFFF',
            'Lightpink', 
            '#000000', '#000000', '#B04040', '#FFFFFF', 'none', '#FFFFFF', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', 
            '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', 
            '#FFFF80', '#FFFFFF', 'Lightpink', 
            '#000000', '#000000', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 
            'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', 
            '#FFFFFF', 'none', '#FFFFFF', '#B04040', '', 'none', '#000000', '#000000', '#FF0000', '#80FFFF', 'none', '#80FFFF', 
            '#0000FF', '#FFFF80', 'none', '#FFFF80', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#008000', '#008000', 
            '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', 
            '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#FFFFFF', 
            '#FFFFFF', '#000000', '#000000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', 
            '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', 
            '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#FFFFFF', '#FFFFFF')";
            
  
            $query1 = mysql_query($sqlstr) or die("Cannot save Calendar Config<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            $sqlstr = "UPDATE ".$tabpre."_user_reg set startcalid = '$newcalid', startcalname = '".($fields["calname"])."' where uid = ".$user->gsv("cuid")." limit 1";  
            $query1 = mysql_query($sqlstr) or die("Cannot save Calendar Config in User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

            $user->ssv("startcalid",$newcalid);
            $user->ssv("startcalname",$fields["calname"]);
            $user->ssv("curcalid",$newcalid);
            $user->ssv("curcalname",$fields["calname"]);
            $user->ssv("curcaltype",$fields["caltype"]);
            $user->ssv("curcalowner",1);

            getuserstandards(&$user);

//            echo sprintf(stripslashes($langcfg["endwelc"]),$GLOBALS["idxfile"]);
    //        echo sprintf($tstr1,$tstr2,$GLOBALS["idxfile"]);
            
            $tstr1 = $langcfg["endwelc"];
            $tstr1 = str_replace("%index%",$GLOBALS["idxfile"],$tstr1);
            
            echo $tstr1;
            
            echo "</center>";
            echo "<br><br>";
            include_once("./include/footer.php");
            exit();                        
        }

        
/***************************************************************
**  this section saves the changed preferences
***************************************************************/ 
        
    } elseif(isset($submitprefs) || isset($submitgeneral) || isset($prefgocg) || isset($prefgogc) || isset($prefgomc) || isset($prefgoyv) || isset($prefgomv) || isset($prefgowv) || isset($prefgodv)) {

            set_time_limit(60);

            $haveupd = 0;
            $updcn = 0;
            foreach($fields as $k1 => $v1) {
                    if($fields[$k1] <> $prev[$k1]) {
                        if($k1=="calname") {
                            $updcn=1;
                            $newcn = $fields[$k1];
                        }
                        if($haveupd==0) {
                            $haveupd = 1;
                            $sqlstr = "update ".$GLOBALS["tabpre"]."_cal_ini set ".$k1."='".$fields[$k1]."'";
                        } else {
                            $sqlstr .= ", ".$k1."='".$fields[$k1]."'"; 
                        } 
                    }
            }
              
            if($haveupd==1) {
                $sqlstr .= " where calid='".$user->gsv("curcalid")."' and userid=".$user->gsv("cuid")." limit 1";
                $query1 = mysql_query($sqlstr) or die("Cannot update Calendar Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                if($updcn==1) {
                    $sqlstr = "update ".$GLOBALS["tabpre"]."_user_reg set startcalname='".($newcn)."' where startcalid='".$user->gsv("curcalid")."' and uid=".$user->gsv("cuid")." limit 1";
                    $query1 = mysql_query($sqlstr) or die("Cannot update user Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                    $user->ssv("curcalname",$newcn);
                }
                getuserstandards(&$user);
            }
            
/***************************************************************
**  this section returns to the preferences after saving
***************************************************************/ 

            if(isset($submitprefs)) {
                unset($submitprefs);
                calsetup(0,"$csection",&$user);
            } elseif(isset($submitgeneral)) {
                unset($submitgeneral);
                calsetup(0,"cg",&$user);
            } elseif(isset($prefgocg)) {
                unset($prefgocg);
                calsetup(0,"cg",&$user);
            } elseif(isset($prefgogc)) {
                unset($prefgogc);
                calsetup(0,"gc",&$user);
            } elseif(isset($prefgomc)) {
                unset($prefgomc);
                calsetup(0,"mc",&$user);
            } elseif(isset($prefgoyv)) {
                unset($prefgoyv);
                calsetup(0,"yv",&$user);
            } elseif(isset($prefgomv)) {
                unset($prefgomv);
                calsetup(0,"mv",&$user);
            } elseif(isset($prefgowv)) {
                unset($prefgowv);
                calsetup(0,"wv",&$user);
            } elseif(isset($prefgodv)) {
                unset($prefgodv);
                calsetup(0,"dv",&$user);
            }

/***************************************************************
**  this section goes to the prefs
***************************************************************/ 

    } elseif(isset($goprefs)) {
        unset($goprefs);
        calsetup(0,"cg",&$user);
    }
?>