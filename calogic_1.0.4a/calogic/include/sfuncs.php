<?php
/***************************************************************
**  this section brings up the special functions forms
***************************************************************/ 

    if(isset($gosfuncs)) {
        if($qjump=="categories") {
            unset($gosfuncs);
            editcats(&$user);
        } elseif($qjump=="contacts") {
            unset($gosfuncs);
            editcons(&$user);
        } elseif($qjump=="usersettings") {
            unset($gosfuncs);
            edituser(&$user);
        } elseif($qjump=="subscriptions") {
            unset($gosfuncs);
//            editabos(&$user);
        }
    }
    
/***************************************************************
**  go to categories
***************************************************************/ 
    if(isset($gocatprefs)) {
        unset($gocatprefs);
        editcats(&$user);
    }
     
/***************************************************************
**  save category
***************************************************************/ 



    if(isset($savecat)) {


       $catcal = fmtfordb($catcal);
       $catname = fmtfordb($catname);
       $catcolortext = fmtfordb($catcolortext);
       $catcolorbg = fmtfordb($catcolorbg);

        if(!isset($catlist)) {
            if(!isset($catcal)) {$catcal = "0";}
            $sqlstr = "insert into ".$GLOBALS["tabpre"]."_user_cat (uid,calid,catname,catcolortext,catcolorbg) values(".$user->gsv("cuid").",'$catcal','".$catname."','".$catcolortext."','".$catcolorbg."')"; 
        } else {
            $catpars = explode("|",$catlist);
            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_cat set calid='$catcal',catname='".$catname."',catcolortext='".$catcolortext."',catcolorbg='".$catcolorbg."' where uid=".$user->gsv("cuid")." and catid='".$catpars[0]."' limit 1"; 
        }
        $query1 = mysql_query($sqlstr) or die("Cannot update Category Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        editcats(&$user);
    }   

/***************************************************************
**  delete category
***************************************************************/ 
    if(isset($deletecat)) {
        if(isset($catlist)) {
            $catpars = explode("|",$catlist);
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_cat where uid=".$user->gsv("cuid")." and catid='".$catpars[0]."' limit 1"; 
            $query1 = mysql_query($sqlstr) or die("Cannot delete from Category Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            if($catpars[1] == 0) {
                $sqlstr = "update ".$GLOBALS["tabpre"]."_cal_events set catid = 0 where uid=".$user->gsv("cuid")." and catid='".$catpars[0]."'";
            } else {
                $sqlstr = "update ".$GLOBALS["tabpre"]."_cal_events set catid = 0 where uid=".$user->gsv("cuid")." and catid='".$catpars[0]."' and calid='".$catpars[1]."'";
            }
            $query1 = mysql_query($sqlstr) or die("Cannot update catid in cal events Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        }
        editcats(&$user);
    }   

/***************************************************************
**  save contact
***************************************************************/ 
    if(isset($savecon)) {


        $congp = fmtfordb($congp);
        $confname = fmtfordb($confname);
        $conlname = fmtfordb($conlname);
        $conemail = fmtfordb($conemail);
        $conbday = fmtfordb($conbday);
        $ucaltzadj = fmtfordb($ucaltzadj);
        $contel1 = fmtfordb($contel1);
        $contel2 = fmtfordb($contel2);
        $contel3 = fmtfordb($contel3);
        $confax = fmtfordb($confax);
        $conadr = fmtfordb($conadr);
        
        $ucaltzadj = ($contzos * 60 * 60) - $user->gsv("servertz");
    
        if(!isset($conlist)) {
            if(!isset($congp)) {$congp = "0";}
            $sqlstr = "insert into ".$GLOBALS["tabpre"]."_user_con (uid,congp,fname,lname,email,bday,tzos,tel1,tel2,tel3,fax,address) values(".$user->gsv("cuid").",$congp,'".$confname."','".$conlname."','".$conemail."','".$conbday."',".$ucaltzadj.",'".$contel1."','".$contel2."','".$contel3."','".$confax."','".$conadr."')"; 
        } else {
            $conpars = explode("|",$conlist);
            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_con set congp=$congp,fname='$confname',lname='$conlname',email='$conemail',bday='$conbday',tzos=$ucaltzadj,tel1='$contel1',tel2='$contel2',tel3='$contel3',fax='$confax',address='$conadr' where uid=".$user->gsv("cuid")." and conid=".$conpars[0]." limit 1"; 
        }
        $query1 = mysql_query($sqlstr) or die("Cannot update Contacts Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        editcons(&$user);
    }   

/***************************************************************
**  delete contact
***************************************************************/ 
    if(isset($deletecon)) {
        if(isset($conlist)) {
            $conpars = explode("|",$conlist);
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_con where conid=".$conpars[0]." and uid=".$user->gsv("cuid")." limit 1"; 
            $query1 = mysql_query($sqlstr) or die("Cannot delete from Contacts Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_event_rems where conid=".$conpars[0]." and uid=".$user->gsv("cuid")." and contyp='C'"; 
            $query1 = mysql_query($sqlstr) or die("Cannot delete from event reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        }
        editcons(&$user);
    }   
        
/***************************************************************
**  save new contact group
***************************************************************/ 
    if(isset($savenewcongp)) {
        $connewgp = fmtfordb($connewgp);
        $sqlstr = "insert into ".$GLOBALS["tabpre"]."_user_con_grp (uid,gpname) values(".$user->gsv("cuid").",'$connewgp')"; 
        $query1 = mysql_query($sqlstr) or die("Cannot Insert into Contact Groups Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        editcons(&$user);
    }   

/***************************************************************
**  save changed contact group
***************************************************************/ 
    if(isset($saveeditcongp)) {
        if($congp > 0) {
            $connewgp = fmtfordb($connewgp);
            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_con_grp set gpname='$connewgp' where congpid=$congp and uid=".$user->gsv("cuid")." limit 1"; 
            $query1 = mysql_query($sqlstr) or die("Cannot update Contact Groups Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        }
        editcons(&$user);
    }   

/***************************************************************
**  delete contact group
***************************************************************/ 
    if(isset($deletecongpok)) {
        if($congp > 0 && $deletecongpok=="1") {
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_con_grp where congpid=$congp and uid=".$user->gsv("cuid")." limit 1"; 
            $query1 = mysql_query($sqlstr) or die("Cannot delete from Contact Groups Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_con set congp=0 where congp=$congp and uid=".$user->gsv("cuid"); 
            $query1 = mysql_query($sqlstr) or die("Cannot update Contacts Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            
            $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_event_rems where conid=".$congp." and uid=".$user->gsv("cuid")." and contyp='G'"; 
            $query1 = mysql_query($sqlstr) or die("Cannot delete from event reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

            editcons(&$user);
        }
    }   

/***************************************************************
**  delete a user and everything associated with it.
***************************************************************/ 
    if(isset($deluserok) && $deluserok=="1") {
        if(isset($ccxid) && $user->gsv("isadmin") == 1) {
            $currentuser = $ccxid;
        }
        
        if($senddelmail == "1") {
            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$currentuser." limit 1";
            $query1 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            while($row = mysql_fetch_array($query1)) {
                senddelmail($row["fname"],$row["lname"],$row["email"],$row["uname"]);
            }            
        }
        
        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_cat where uid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from category table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        
        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_con where uid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from contacts table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_con_grp where uid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from contact groups table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_ini where userid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from calendar table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_events where uid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from calendar events table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from calendar event reminders table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        $sqlstr = "delete from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$currentuser;
        $query1 = mysql_query($sqlstr) or die("Cannot delete from user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        
/***************************************************************
**  if deleting self, logoff
***************************************************************/ 
        if($user->gsv("cuid") == $currentuser) {

            $user->ssv("logedin",false);
            foreach($user->s_vars as $k1 => $v1) {
                session_unregister("clsession_".$k1);
                unset($GLOBALS["clsession_".$k1]);
            }    
            $user->logoff;
            session_unset(); 
            session_destroy();
            $user->s_vars = array();
            unset($PHPSESSID);
            unset($xsesid);
            unset($user);
            $GLOBALS["HTTP_SESSION_VARS"] = array();
            $HTTP_SESSION_VARS = array();
            $_SESSION = array();
            gologin(); 
        } else {
            echo "<h3>User has been deleted.</h3>";
            edituser(&$user);
        }
    }
    
/***************************************************************
**  check and save changed user info
***************************************************************/ 
    if(isset($saveuser)) {
        $uncheckfailed = false;
        $emcheckfailed = false;
        if(isset($ccxid) && $user->gsv("isadmin") == 1) {
        
            if($ccxid <> "") {
                $currentuser = $ccxid;
            }

/***************************************************************
**  bring an error if trying to cheat
***************************************************************/ 
        } elseif(isset($ccxid) && $ccxid <> "") {
//            die("YOU ARE NOT AN ADMIN!");

            echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";
            echo "<html>\n";
            echo "<head>\n";
            
            echo "<title>Error</title>\n";
            echo "</head>\n";
            echo "<body background=\"$standardbgimg\">\n";
            echo "<center><br><h3>You are not an Admin!</h3></center>";
echo "<br><br>";
include_once("./include/footer.php");
            exit();
        }

/***************************************************************
**  check if changed user name is unique
***************************************************************/ 
        if($fields["username"] != $prev_fields["username"]) {
            if(checkinput($fields["username"]) == false) {
                echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";
                echo "<html>\n";
                echo "<head>\n";
                echo "<title>Error</title>\n";
                echo "</head>\n";
                echo "<body background=\"$standardbgimg\">\n";
                echo "<center><br><h3>The User Name you entered has invalid characters, only leters and numbers are allowed.</h3><br><br><a href=\"".$GLOBALS["idxfile"];
                if($GLOBALS["adsid"] == true) {
                    echo "?".SID;
                }
                echo "\">Go to Calendar</a></center>";
                echo "<br><br>";
                include_once("./include/footer.php");
                exit();                
            }
            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where uname = '".$fields["username"]."'";
            $query1 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            $res_query1 = @mysql_num_rows($query1) ;
            if($res_query1 > 0) {
                $uncheckfailed = true;
                echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";
                echo "<html>\n";
                echo "<head>\n";
                echo "<title>Error</title>\n";
                echo "</head>\n";
                echo "<body background=\"$standardbgimg\">\n";
                echo "<center><br><h3>The User Name you have entered is already in use.</h3><br><br><a href=\"".$GLOBALS["idxfile"];
                if($GLOBALS["adsid"] == true) {
                    echo "?".SID;
                }
                echo "\">Go to Calendar</a></center>";
                echo "<br><br>";
                include_once("./include/footer.php");
                mysql_free_result($query1);
                exit();                
            }
            mysql_free_result($query1);
        }

/***************************************************************
**  check if changed user email is unique
***************************************************************/ 
        if($fields["useremail"] != $prev_fields["useremail"]) {
            $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg where email = '".$fields["useremail"]."'";
            $query1 = mysql_query($sqlstr) or die("Cannot query user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            $res_query1 = @mysql_num_rows($query1) ;
            if($res_query1 > 0) {
                $emcheckfailed = true;
                echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";
                echo "<html>\n";
                echo "<head>\n";
                echo "<title>Error</title>\n";
                echo "</head>\n";
                echo "<body background=\"$standardbgimg\">\n";
                echo "<center><br><h3>The Email you have entered is already in use.</h3><br><br><a href=\"".$GLOBALS["idxfile"];
                if($GLOBALS["adsid"] == true) {
                    echo "?".SID;
                }
                echo "\">Go to Calendar</a></center>";
                echo "<br><br>";
                include_once("./include/footer.php");
                mysql_free_result($query1);
                exit();                
            }
            mysql_free_result($query1);
        }

/***************************************************************
**  save if all is ok
***************************************************************/ 
            set_time_limit(60);
            $haveupd = 0;
            $upduls = 0;
            $updusc = 0;
            $cxuo = array();
            foreach($fields as $k1 => $v1) {
                    if($fields[$k1] <> $prev_fields[$k1]) {
                        if($k1=="userlangsel") {
                            $upduls=1;
                            $newuls = $fields[$k1];
                            $xsqlstr = "select name from ".$GLOBALS["tabpre"]."_languages where uid=".$fields[$k1];
                            $xquery1 = mysql_query($xsqlstr) or die("Cannot query global language table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$xsqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $res_query1 = @mysql_num_rows($query1) ;
                            if($res_query1 < 1) {
                                die("Cannot locate language");
                            }
                            $xrow = mysql_fetch_array($xquery1);
                            $newuln = $xrow["name"];
                            mysql_free_result($xquery1);
                            $qfield = "langid";
                            $cxuo["langsel"] = $fields[$k1];
                            $cxuo["langname"] = $newuln;
                        }elseif($k1=="usercalsel") {
                            $updusc=1;
                            $newusc = $fields[$k1];
                            $xsqlstr = "select calname from ".$GLOBALS["tabpre"]."_cal_ini where calid='".$fields[$k1]."'";
                            $xquery1 = mysql_query($xsqlstr) or die("Cannot query calendar ini table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$xsqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                            $res_query1 = @mysql_num_rows($query1) ;
                            if($res_query1 < 1) {
                                die("Cannot locate calendar");
                            }
                            $xrow = mysql_fetch_array($xquery1);
                            $newusn = ($xrow["calname"]);
                            mysql_free_result($xquery1);
                            $qfield = "startcalid";
                            $cxuo["startcalid"] = $fields[$k1];
                            $cxuo["startcalname"] = $newusn;
                        }elseif($k1=="username") {
                            $qfield = "uname";
                            $cxuo["uname"] = $fields[$k1];
                        }elseif($k1=="firstname") {
                            $qfield = "fname";
                            $cxuo["fname"] = $fields[$k1];
                        }elseif($k1=="lastname") {
                            $qfield = "lname";
                            $cxuo["lname"] = $fields[$k1];
                        }elseif($k1=="useremail") {
                            $qfield = "email";
                            $cxuo["email"] = $fields[$k1];
                        }elseif($k1=="userisadmin") {
                            $qfield = "isadmin";
                            $cxuo["isadmin"] = $fields[$k1];
                        }
                        
                        $fields[$k1] = fmtfordb($fields[$k1]);
                        if($haveupd==0) {
                            $haveupd = 1;
                            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_reg set ".$qfield."='".$fields[$k1]."'";
                        } else {
                            $sqlstr .= ", ".$qfield."='".$fields[$k1]."'"; 
                        } 
                    }
            }
            if($upduls==1) {
                $sqlstr .= ", language='".$newuln."'"; 
            }
            if($updusc==1) {
                $sqlstr .= ", startcalname='".$newusn."'"; 
            }
            if(isset($userpw) && isset($newuserpw) && isset($newuserpw2) && $userpw != "" && $newuserpw != "" && $newuserpw2 != "") {
                $xsqlstr = "select pw from ".$GLOBALS["tabpre"]."_user_reg where uid = $currentuser";
                $xqu_res = mysql_query($xsqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$xsqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                $xqu_nr = @mysql_num_rows($xqu_res);
                if($xqu_nr == 1) {
                	$xrow = mysql_fetch_array($xqu_res);
                    if ($xrow["pw"]==md5($userpw)) {
                        $xmdpw = md5($newuserpw); 
                        if($haveupd==0) {
                            $haveupd = 1;
                            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_reg set pw='".$xmdpw."'";
                        } else {
                            $sqlstr .= ", pw='".$xmdpw."'"; 
                        } 
                    }
                }
                mysql_free_result($xqu_res);
            }
            if($haveupd==1) {
                $sqlstr .= " where uid=".$currentuser." limit 1";
                $query1 = mysql_query($sqlstr) or die("Cannot update user table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                if($currentuser == $user->gsv("cuid")) {
                    foreach($cxuo as $k1 => $v1) {
                        $user->ssv($k1,$cxuo[$k1]);
                    }
                    $user->ssv("fullname",$user->gsv("fname")."&nbsp;".$user->gsv("lname"));
                }
                echo "<h3>Changes have been saved.</h3>";
                getuserstandards(&$user);
            }
        edituser(&$user);
    }       
    

?> 