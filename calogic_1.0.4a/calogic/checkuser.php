<?php require_once("./include/config.php"); ?>
<html>
<head>
<title>User Name Check</title>
</head>
<body background="<?php echo $GLOBALS["standardbgimg"]; ?>">
<center>
<?php
if(!isset($username)) {
    echo "<h3>No User Name was given.</h3>";
} else {
    $badun = false;

    for($xl=0;$xl<strlen($username);$xl++) {
        if(ereg("^[^a-zA-Z0-9]$",substr($username,$xl,1))) {
            $badun = true;
        }
    }
    if($badun==true) {
        echo "<b>User name has invalid characters, only leters and numers are allowed</b><br><br>";
    } else {
    
        $sqlstr = "select uname from ".$GLOBALS["tabpre"]."_user_reg where uname = '".$username."'";
        $query1 = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $qu_num = @mysql_num_rows($query1);
        if($qu_num < 1) {
            echo "<h3>The User Name \"$username\" is not in use.</h3>";
        } else {
            echo "<h3>The User Name \"$username\" has already been taken.</h3>";
        }
        mysql_free_result($query1);
    }
}
echo "<br><br>";
include_once("./include/footer.php");
?>

 