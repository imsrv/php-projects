<?php

/***************************************************************
** Title.........: CaLogic main program file
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: index.php (variable, see config.php)
** Last changed..: 
** Notes.........: Other than the registering process files, this is the only file
                   that ever gets called in a url.
** Use...........: This is the main decision making / process branching program

** Functions: this is more of a "sectioned" program, that gets executed on
              a logical basis. (hence the name CaLogic (CAlendar LOGICal)
              the relevant sections are marked. The sections could probably easily
              be made into functions, but that wouldn't be logical now would it? :)
              It does have one function though: gologin, it is the login form, and I
              only made it a function because I needed to call it at different parts
              of the program.
                                 
***************************************************************/ 

  
/***************************************************************
** included files
** NOTE: do not change the order of appearance  
***************************************************************/    
require_once("./include/config.php");
include_once("./include/dbfunc.php");
include_once("./include/useredit.php");
include_once("./include/session.php");
include_once("./include/calfunc.php");
include_once("./include/calsetup.php");
include_once("./include/gfunc.php");
include_once("./include/remcfg.php");
include_once("./include/eventform.php");
include_once("./include/editeventform.php");

if($rinterval > 3) {
    $rinterval = 3;
    $rfrequency = 1;
}
if($rinterval < 1) {
    $rinterval = 1;
    $rfrequency = 5;
}
if($rfrequency < 1) {
    $rfrequency = 1;
}
if($rdahead < 1) {$rdahead = 1;}
if($rdahead > 365) {$rdahead = 365;}

if($rinterval == 1) {
    $rminmin = $rfrequency;
    $rminmax = 60;
    $rhourmin = 1;
    $rhourmax = 24;
    $rdaymin = 1;
    $rdaymax = $rdahead;
    $rfrtval = "Minute(s)";
} elseif($rinterval == 2) {
    $rminmin = 0;
    $rminmax = 0;
    $rhourmin = $rfrequency;
    $rhourmax = 24;
    $rdaymin = 1;
    $rdaymax = $rdahead;
    $rfrtval = "Hour(s)";
} elseif($rinterval == 3) {
    $rminmin = 0;
    $rminmax = 0;
    $rhourmin = 0;
    $rhourmax = 0;
    $rdaymin = $rfrequency;
    $rdaymax = $rdahead;
    $rfrtval = "Day(s)";
}

$erfilename = "File: ".substr(__FILE__,strrpos(__FILE__,"/")).";"; 
$loger = "";

/***************************************************************
**  This checks if the PHPSESSID has already been set, if not, it sets it
***************************************************************/ 

//if(!isset($PHPSESSID) || isset($login) ) {
if(!isset($PHPSESSID)) {
    srand((double)microtime()*1000000);
    $xsesid = md5(uniqid(rand()));
} else {
    $xsesid = $PHPSESSID ;
}

/***************************************************************
**  clsession is the session class
***************************************************************/ 
$user = new clsession($xsesid);


/***************************************************************
**  this sets the current or selected language, it must be here
    because a user can select a language before logging in on the
    login page
***************************************************************/ 
if (!isset($langsel)) {
    $user->ssv("langsel","$standardlang");
} else {
    $user->ssv("langsel","$langesl");
}
$langsel = $user->gsv("langsel");
getcurlang($langsel);



/***************************************************************
**  this is the log out portion
***************************************************************/ 
if (isset($endsess)) {
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
}



/***************************************************************
**  this is the login portion, it gets executed at login
***************************************************************/ 
if (isset($login)) {

    $user->logon($uname,$pw);
    if(!$user->gsv("logedin")) {
        $loger = $user->gsv("logoner");
    } else {

      // server time zone in seconds
        $servertz = date("Z",time());
        $user->ssv("servertz",$servertz);
    
        if($usertz != "no") {    

        // user time zone in hours made to seconds minus the servers time zone = time zone adjustment    
            $user->ssv("usertz",$usertz);
            $caltzadj = ($usertz * 60 * 60) - $servertz;
            $user->ssv("caltzadj",$caltzadj);
        //    $user->ssv("caltzsadj",$caltzadj * 60 * 60);

            $sqlstr = "update ".$GLOBALS["tabpre"]."_user_reg set tzos = $caltzadj where uid = ".$user->gsv("cuid")." limit 1";
            $query = mysql_query($sqlstr) or die("Cannot update User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

        } else {
        
        // user time zone in hours made from the currently saved tzos    
            $user->ssv("usertz",($user->gsv("caltzadj") / 60 / 60));
            $caltzadj = $user->gsv("caltzadj");
        }
        

        if($user->gsv("startcalid")<>"0") {
            $user->ssv("curcalid",$user->gsv("startcalid"));
            $user->ssv("curcalname",$user->gsv("startcalname"));
            $gocalselect = 1;
            $calselect = $user->gsv("startcalid");
        }
    }
}

/***************************************************************
**  the next portion only gets executed if the user is logged in,
    if not everything gets skipped, and the login form is called.
    If a use often lands at the login form even if they are loggeg in,
    it usually means there is a problem with the session or session variables.
***************************************************************/ 
if($user->gsv("logedin")) {

    // the index.php got to be to large, so I ported some of it out to different core files
    // do not move the position of this include!!!
    include_once("./include/core1.php");


/***************************************************************
**  if none of the above sections gets called, these variables
    must be set for all other functions to work
***************************************************************/ 

    $weekstartonmonday = $curcalcfg["weekstartonmonday"];
    $dispwnum =  $curcalcfg["showweek"];
    $weekselreact =  $curcalcfg["weekselreact"];
    $daybeginhour =  $curcalcfg["daybeginhour"];
    $dayendhour =  $curcalcfg["dayendhour"];
    $dayhourcount = ($dayendhour - $daybeginhour)+1;
    setviewtext($langsel);
    
    // the index.php got to be to large, so I ported some of it out to different core files
    // do not move the position of thesw includes!!!
    include_once("./include/efuncs.php");
    include_once("./include/sfuncs.php");
        
/***************************************************************
**  so, if we make it this far, then time to show the calendar
***************************************************************/ 

    include_once("./include/dvfunc.php");
    include_once("./include/wvfunc.php");
    include_once("./include/mvfunc.php");
    include_once("./include/yvfunc.php");
    include_once("./include/vhfunc.php");

    
    if(isset($weeksel)) {
        $viewtype="Week";
        $viewdate = $weeksel;
    } elseif(isset($monthsel)) {
        $viewtype="Month";
        $viewdate = $monthsel;
    } elseif(isset($yearsel)) {
        $viewtype="Year";
        $viewdate = $yearsel;
    } else {
        if(!isset($viewtype)) {
            if($user->gsv("curview") == "") {   
                $user->ssv("curview",$curcalcfg["preferedview"]) ;
                $viewtype=$curcalcfg["preferedview"]; //"Month";
            } else {
                $viewtype=$user->gsv("curview");
            }
        }
        if(!isset($viewdate)) {
            $sdtx = time() + $user->gsv("caltzadj");
            $txvd = strftime("%Y",$sdtx).strftime("%m",$sdtx)."01";

            if($user->gsv("curviewdate") == "") {   
                $user->ssv("curviewdate",$txvd); 
                $viewdate = strftime("%Y",$sdtx).strftime("%m",$sdtx)."01";
            } else {
                $viewdate = $user->gsv("curviewdate");
            }
        }
    }
    $user->ssv("curview",$viewtype) ;
    $user->ssv("curviewdate",$viewdate);
    
//    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">\n";


/***************************************************************
**  begin calendar html
***************************************************************/ 

    echo "<html>\n";
    echo "<head>\n";
    
    echo "<title>$viewtype&nbsp;View - ".$GLOBALS["sitetitle"]."</title>\n";
    
    include("./include/style.php");
    include("./include/jscript.php");
    
    echo "</head>\n";
    echo "<body background=\"".$curcalcfg["gcbgimg"]."\" LANGUAGE=javascript onload=\"return window_onload()\" onresize=\"return window_onresize()\">\n";
//    echo SID;
    echo "<center>\n";
    echo "<table id=\"cvtab\" border=\"0\" width=\"96%\" LANGUAGE=javascript onresize=\"return cvtab_onresize()\">\n";
    echo "<tr>\n";
    echo "<td>\n";
    
/***************************************************************
**  show header
***************************************************************/ 
    viewheader($viewdate,$viewtype);
    
/***************************************************************
**  decide which view and date etc. and show it
***************************************************************/ 
    if ($viewtype == "Day") {
        dayview($viewdate);
    } else if ($viewtype == "Week") {
        weekview($viewdate);
    } else if ($viewtype == "Month") {
        monthview($viewdate);
    } else if ($viewtype == "Year") {
        yearview($viewdate);
    } else {
        $viewtype = "Month";
        monthview($viewdate);
    }
    
    echo "</tr>\n";
    echo "</td>\n";
    echo "</table>\n";
    echo "</center>\n";
    include_once("./include/footer.php");
    flush();
    exit();
} else {

/***************************************************************
**  thats it! if we make it here, must go to login form
***************************************************************/ 

    gologin();
}
exit();


/***************************************************************
**  
***************************************************************/ 

function gologin() {

global $langcfg,$gltab,$standardbgimg,$loger,$langsel;
// login form

    $wptitle = $langcfg["liw"];
    ?>
    
    <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\">
    <html>
    
    <head>
    <title><?php echo $GLOBALS["sitetitle"]; ?> - <?php echo "$wptitle"; ?></title>
    <SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
    <!--
    
    function submit_onclick() {
        document.loginform.uname.value=trim(document.loginform.uname.value);
        document.loginform.pw.value=trim(document.loginform.pw.value);
        if(document.loginform.uname.value == "") {
            alert("<?php echo $langcfg["linff"]; ?>");
            document.loginform.uname.focus();
            return false;
        }
        if(document.loginform.pw.value == "") {
            alert("<?php echo $langcfg["lipff"]; ?>");
            document.loginform.pw.focus();
            return false;
        }
    }
    
    function trim(value) {
     startpos=0;
     while((value.charAt(startpos)==" ")&&(startpos<value.length)) {
       startpos++;
     }
     if(startpos==value.length) {
       value="";
     } else {
       value=value.substring(startpos,value.length);
       endpos=(value.length)-1;
       while(value.charAt(endpos)==" ") {
         endpos--;
       }
       value=value.substring(0,endpos+1);
     }
     return(value);
    }
    
    function langsel_onchange() {
    xurl = "<?php echo $GLOBALS["idxfile"]; ?>?langsel=" + langsel.value;
    location.href=xurl;
    
    }
    
    function window_onload() {
        document.loginform.uname.focus();
        
        var d, tz, utz;
        d = new Date();
        tz = d.getTimezoneOffset();
        if (tz < 0)
            utz = "+" + Math.abs(tz) / 60;
        else if (tz == 0)
            uzz = "0";
        else
            utz = "-" + Math.abs(tz) / 60;
            
        loginform.usertz.value = utz;
    }
    
    //-->
    </SCRIPT>
    </head>
    
    <body LANGUAGE=javascript onload="return window_onload()" background="<?php echo $standardbgimg; ?>">

    <h1><b><?php echo $GLOBALS["sitetitle"]; ?> - <?php echo $langcfg["liw"]; ?></b></h1>
    <p><b><?php echo $langcfg["lsel"]; ?> </b>
    <select size="1" id=langsel name=langsel LANGUAGE=javascript onchange="return langsel_onchange()" tabIndex=7>
    <?php
    
    $sqlstr = "select * from ".$gltab." order by name";
    $qu_res = mysql_query($sqlstr) or die("Cannot query Global Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

/*    if (mysql_error()) {
        $error = mysql_error();
        sqlerror($error, -1, "$erfilename Cannot query Global Language Database", $sqlstr);
    }
   */    
    while ($rs_lang = mysql_fetch_array($qu_res)) {
        echo "<OPTION Value=".$rs_lang["uid"];
        if ($rs_lang["uid"] == $langsel ) {echo " selected ";}
        echo ">".$rs_lang["name"]."</OPTION>\n";
    }
    
    mysql_free_result($qu_res);
    
    ?>
    
    </select></p>
    <p><b><?php echo $langcfg["pli"]; ?></b></p>
    <form method="POST" name="loginform" id="loginform" action="<?php echo $GLOBALS["idxfile"]; ?>">
      <table border="0" width="100%">
        <tr>
          <th width="12%" valign="top"><?php echo $langcfg["un"]; ?></th>
          <td width="15%" nowrap valign="top">
          <input type="text" name="uname" size="20" maxlength=10 tabIndex=1>
          </td>
          <td width="73%" rowspan="2" valign="top" >
          <?php echo nl2br($langcfg["nyrt"]); ?><a href="userreg.php?langsel=<?php echo $langsel; 
                if($GLOBALS["adsid"] == true) {
                    echo "&".SID;
                }
          ?>" tabIndex=6><?php echo $langcfg["rlnk"]; ?></a>
          </td>
        </tr>
        <tr>
          <th width="12%" valign="top"><?php echo $langcfg["pw"]; ?></th>
          <td width="15%" valign="top">
          <input type="password" name="pw" size="20" id=pw maxlength=10 tabIndex=2>
          </td>
        </tr>
        <tr>
        <th width="12%" valign="top"><br>
            <?php echo $langcfg["tzofword"]; ?></th>
        <td width="15%" nowrap valign="top"><br>
            <input type="text" name="usertz" size="20" maxlength=5 tabIndex=3>
        </td>
        <td width="73%" valign="top"><br>
            <?php echo $langcfg["tztext"]; ?>
        </td>
        </tr>
      </table>
      <input type="submit" value="<?php echo $langcfg["subut"]; ?>" name="login" id=login LANGUAGE=javascript onclick="return submit_onclick()" tabIndex=4>&nbsp;&nbsp;&nbsp;<input type="reset" value="<?php echo $langcfg["rebut"]; ?>" name="reset" id=reset tabIndex=5>
    </form>
    <br><br>
    <center>
    <?php
    if (isset($endsess)) {
        echo "<h2>".$langcfg["userlo"]."</h2>";
    } else {
        echo "<h2>$loger</h2>";
    }
    ?>
    </center>
<?php
echo "<br><br>";
include_once("./include/footer.php");
exit();
}
?>
