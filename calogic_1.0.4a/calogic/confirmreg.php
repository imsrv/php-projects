<?php

require_once("./include/config.php");
include_once("./include/dbfunc.php");
//include_once("./include/class.html.mime.mail.inc");

//$gltab = $tabpre."_languages";
//$gutab = $tabpre."_user_reg";
$sqlstr = "select * from $gutab where regkey = '$key'";
$query1 = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$res_query1 = @mysql_num_rows($query1); // or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

if($res_query1 == 1) {

	$row = mysql_fetch_array($query1) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $wptitle = translate("urth",$row["langid"]);

    ?>
    
    <html>
    
    <head>
    <title><?php echo $GLOBALS["sitetitle"]; ?> - <?php echo $wptitle; ?></title>
    
    </head>
    
    <body background="<?php echo $standardbgimg; ?>">
    <br>
    <?php

    if ($row["emok"]==1) {
//        echo sprintf(translate("rereg",$row["langid"]),$GLOBALS["idxfile"]);

        $tstr1 = translate("rereg",$row["langid"]);
        $tstr1 = str_replace("%index%",$GLOBALS["idxfile"],$tstr1);
        echo $tstr1;
        
        
    } else {
        $conftime = time();
        $sqlstr = "update $gutab set emok=1, conftime=$conftime where regkey = '$key' limit 1";
        $query2 = mysql_query($sqlstr) or die("Cannot update User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

//        echo sprintf($tstr1,$tstr2,$GLOBALS["idxfile"]);

        $repstr1 = $row["fname"]." ".$row["lname"];
        $tstr1 = translate("regconf",$row["langid"]);
        $tstr1 = str_replace("%index%",$GLOBALS["idxfile"],$tstr1);
        $tstr1 = str_replace("%name%",$repstr1,$tstr1);
        
        echo $tstr1;


    }
} else {
    echo translate("regfu",$standardlang);
}
echo "<br><br>";
include_once("./include/footer.php");

?>


 