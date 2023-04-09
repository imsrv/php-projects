<?php

include("./include/config.php");
include("./include/dbfunc.php");
//include("./include/class.html.mime.mail.inc");

$gltab = $tabpre."_languages";
$wptitel = translate("urth",$langsel);
?>

<html>

<head>
<title><?php echo $GLOBALS["sitetitle"]; ?> - <?php echo $wptitel; ?></title>

<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--
function goback_onclick() {
    window.history.go(-1);
}
//-->
</SCRIPT>
</head>

<body background="<?php echo $standardbgimg; ?>">

<h3><?php echo translate("pwreg",$langsel); ?></h3><br><br>

<?php
$leave = 0;

$email=strtolower($email);

$sqlstr = "select * from ".$tabpre."_user_reg where email = '$email'";
$qu_res = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
$qu_num = @mysql_num_rows($qu_res);

if($qu_num <> 0) {
//if (mysql_query($sqlstr)) {
    echo translate("emar",$langsel);
    echo "<br><br>\n";
    $leave=1;
} else {
    if(!EmailOK($email)) {
        echo translate("badem",$langsel);
        echo "<br><br>\n";
        $leave=1;
    }
}

@mysql_free_result($qu_res);

    $badun = false;

    for($xl=0;$xl<strlen($uname);$xl++) {
        if(ereg("^[^a-zA-Z0-9]$",substr($uname,$xl,1))) {
            $badun = true;
            $leave = 1;
            echo "<b>User name has invalid characters, only leters and numers are allowed</b><br><br>";
        }
    }
    
    if($badun==false && $leave == 0) {

        $sqlstr = "select * from ".$tabpre."_user_reg where uname = '$uname'";
        $qu_res = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $qu_num = @mysql_num_rows($qu_res);

        if($qu_num <> 0) {
        //if(mysql_query($sqlstr)) {
            echo translate("badun",$langsel);
            echo "<br><br>\n";
            $leave=1;
        }
        @mysql_free_result($qu_res);
    }

//echo "Lang: $langsel<br>";

$sqlstr = "select * from $gltab where uid = $langsel";
$qu_res = mysql_query($sqlstr) or die("Cannot query global language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
//$qu_num = mysql_num_rows($qu_res);

if (!$qu_res) {
    echo translate("ldbp",$langsel);
    echo "<br><br>\n";
    $leave=1;
}

if ($leave==1) {

echo "<br><br>\n";
echo "<center><A HREF=\"".$GLOBALS["idxfile"]."\">Click here for the Logon Screen</A></center><br><br>\n";
echo "<center><input type=\"button\" value=\"Back to Registration Form\" name=\"goback\" id=\"goback\" LANGUAGE=javascript onclick=\"return goback_onclick()\"></center>\n";
echo "<br><br>";
include_once("./include/footer.php");
@mysql_free_result($qu_res);
exit();

}

$lsel = mysql_fetch_array($qu_res);
$slanguage = $lsel["name"];

@mysql_free_result($qu_res);

$chars = array( 
 "a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
 "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
 "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8",
 "9","0"
 );
$max_elements = count($chars) - 1;
srand((double)microtime()*1000000);
$newpw = $chars[rand(0,$max_elements)];
$newpw .= $chars[rand(0,$max_elements)];
$newpw .= $chars[rand(0,$max_elements)];  
$newpw .= $chars[rand(0,$max_elements)]; 
$newpw .= $chars[rand(0,$max_elements)]; 
$newpw .= $chars[rand(0,$max_elements)]; 
$newpw .= $chars[rand(0,$max_elements)]; 
$newpw .= $chars[rand(0,$max_elements)];
$newpw_enc = md5($newpw);

// Don't ask...
$key = md5(md5(md5($newpw_enc)));

$regtime = time();

$xmdpw = md5($pw); 


$sqlstr = "select * from ".$tabpre."_user_reg";
$qu_res = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
$qu_num = @mysql_num_rows($qu_res);

if($qu_num == 0) {
    // is first user so make admin
    $istfadmin = 1;
} else {
// is not first user, so no admin.
    $istfadmin = 0;
}

@mysql_free_result($qu_res);

$sqlstr = "insert into ".$tabpre."_user_reg (uname,fname,lname,email,pw,emok,langid,language,regtime,regkey,isadmin) 
values('$uname','$fname','$lname','$email','$xmdpw',0,$langsel,'$slanguage',$regtime,'$key',$istfadmin)";
 
if(!mysql_query($sqlstr)) {
    echo "<br><br>";
    echo translate("pier",$langsel);
} else {
    $regmail = new html_mime_mail('X-Mailer: Html Mime Mail Class');
    
    $regmbody="<HTML><BODY>Hello $fname $lname,<br><br>You just registered with the CaLogic Calendar application running at ".$GLOBALS["sitetitle"]." (".$GLOBALS["baseurl"].$GLOBALS["progdir"].") <br><br>Please click the link below to confirm your registraton:<br><br><a href=\"".$GLOBALS["baseurl"].$GLOBALS["progdir"]."confirmreg.php?key=$key\" target=\"_blank\">Confirm Registration</a><br><br>Or copy and paste this address to your browser:<br><br>".$GLOBALS["baseurl"].$GLOBALS["progdir"]."confirmreg.php?key=$key<br><br>After confirming, you may begin configuring a Calendar to your likings.<br><br>I hope you enjoy working with the calendar, and wish you much success. Information given by you:<br><br><b>User Name: </B>$uname<br><B>First Name:  </B>$fname<br><B>Last Name: </B> $lname<br><B>Language Selection:  </B>$slanguage<br><br>For security reasons, your password has not been sent with this mail.<br><br>If you experience problems with the calendar, please let me know. <br><br>Thank you and best regards<br><br>".$GLOBALS["siteowner"]."<br></body></html>";
    
    $regmail->add_html($regmbody, '');
    $regmail->set_charset('iso-8859-1', TRUE);
    $regmail->build_message();
    
    //$mail->send('TO NAME', 'TO ADDRESS', 'FROM NAME', 'FROM ADDRESS', 'SUBJECT LINE');
    $regmail->send("$fname $lname", "$email", "$siteowner", "$adminemail", "CaLogic Registration Confirmation");
    
    echo translate("regok",$langsel);

}


?>
<br><br>
<center>
<?php
/*
<A HREF="<?php echo $GLOBALS["idxfile"]; ?>">Click here for the Logon Screen</A></center>
*/
?>
<b>Please close this browser window before you confirm your registration.</b>
<?php
echo "<br><br>";
include_once("./include/footer.php");
?>

