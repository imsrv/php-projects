<?php require_once("./include/config.php"); ?>
<html>
<head>
<title>User Email Check</title>
</head>
<body background="<?php echo $GLOBALS["standardbgimg"]; ?>">
<center>
<?php
if(!isset($useremail)) {
    echo "<h3>No E-Mail Address was given.</h3>";
} else {
    $sqlstr = "select email from ".$GLOBALS["tabpre"]."_user_reg where email = '".$useremail."'";
    $query1 = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $qu_num = @mysql_num_rows($query1);
    if($qu_num < 1) {
        echo "<h3>The E-Mail Address \"$useremail\" is not in use.</h3>";
    } else {
        echo "<h3>The E-Mail Address \"$useremail\" has already been taken.</h3>";
    }
    mysql_free_result($query1);
}
echo "<br><br>";
include_once("./include/footer.php");
?>
 