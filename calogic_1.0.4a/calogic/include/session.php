<?php
 
/***************************************************************
** Title.........: CaLogic Session Control
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: session.php
** Last changed..: 
** Notes.........: Based upon ideas and original file from Tim Graf <tim.graf@kcs.info>
** Use...........: This class makes managing sessions and session variables
                   a whole lot easier

** Functions: clsession
              ssv
              gsv
              logon
              logoff
                                 
***************************************************************/    
 

class clsession 
{ 

/***************************************************************
** Class Constructor 
***************************************************************/    

    var $s_vars = array(); 
    function clsession($sesvar) 
    { 
        session_id($sesvar); 
        session_start();
        
        $this->s_vars["gutab"] = $GLOBALS["tabpre"]."_user_reg";
        
        foreach($GLOBALS["HTTP_SESSION_VARS"] as $key =>$value) 
            $this->s_vars[substr($key,10)] = $value; 
    } 
    

/***************************************************************
** Function ssv: registers a session variable 
***************************************************************/    

    function ssv($key, $value) 
    { 
        if(!session_is_registered("clsession_".$key)) {
            session_register("clsession_".$key);
        } 
        $GLOBALS["clsession_".$key] = $value; 
        $this->s_vars[$key] = $value; 
    } 
    
/***************************************************************
** Function gsv: retrieves a session variable 
***************************************************************/
    
    function gsv($key) 
    { 
        return $this->s_vars[$key]; 
    } 

/***************************************************************
** Function logon: checks user name and password, sets main session
                   variables if a match is found.  
***************************************************************/

    function logon($name, $pass) 
    { 
        if($name && $pass) 
        { 
            $sqlstr = "select * from ".$this->s_vars["gutab"]." where uname = '$name'";
            $qu_res = mysql_query($sqlstr) or die("Cannot query User Database<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
            $qu_nr = mysql_num_rows($qu_res);
            if($qu_nr == 1) {
            	$row = mysql_fetch_array($qu_res);
                if ($row["emok"]==1) {
                    if ($row["pw"]==md5($pass)) {

                        $this->ssv("logedin", true); 
                        
                        $this->ssv("cuid",$row["uid"]); 
                        $this->ssv("uname",$row["uname"]); 
                        $this->ssv("fullname",$row["fname"]."&nbsp;".$row["lname"]);
                        $this->ssv("fname",$row["fname"]);
                        $this->ssv("lname",$row["lname"]);
                        $this->ssv("langsel",$row["langid"]);
                        $this->ssv("langname",$row["language"]);
                        $this->ssv("email",$row["email"]);
                        $this->ssv("isadmin",$row["isadmin"]);
                        $this->ssv("startcalid",$row["startcalid"]);
                        $this->ssv("startcalname",($row["startcalname"]));
                        $this->ssv("regtime",$row["regtime"]);
                        $this->ssv("regkey",$row["regkey"]);
                        $this->ssv("conftime",$row["conftime"]);
                        $this->ssv("curview","");
                        $this->ssv("curviewdate","");
                        $this->ssv("caltzadj",$row["tzos"]);
                        
                        
                        $sqlstr = "update ".$this->s_vars["gutab"]." set session = '".session_id()."' where uid = ".$row["uid"]." limit 1";
                        $qu_res = mysql_query($sqlstr) or die("Cannot set Session ID<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

                    } else { // if pw = db PW
                        $this->ssv("logedin", false); 
                        $this->ssv("logoner", translate("wrongli",$row["langid"])); 
                    
                    }
                } else { // if emok
                    $this->ssv("logedin", false); 
                    
//                    $this->ssv("logoner", sprintf(translate("regnotconf",$row["langid"]),$row["email"]));
                    
//                    $repstr1 = $row["email"];
                    $tstr1 = translate("regnotconf",$row["langid"]);
                    $tstr1 = str_replace("%email%",$row["email"],$tstr1);
                    $this->ssv("logoner", $tstr1);

                    regresend($row["fname"],$row["lname"],$row["email"],$row["uname"],$row["language"],$row["regkey"]);

                }
            } else { // if found user name
                $this->ssv("logedin", false); 
                $this->ssv("logoner", translate("wrongli",$GLOBALS["standardlang"])); 
            }
        } else { // if name and pass
            $this->ssv("logedin", false); 
            $this->ssv("logoner", translate("wrongli",$GLOBALS["standardlang"])); 
        } // end if nam and pass 
    }  // end function
    

/***************************************************************
** Function logoff: minimal end session functions 
***************************************************************/    

    function logoff() 
    { 
        session_unset(); 
        session_destroy();
        $this->s_vars = array(); 
    } 
}?>