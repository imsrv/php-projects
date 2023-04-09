<? 

error_reporting(E_ALL);

include("plotconf.inc"); 
include("plot.inc"); 
include($language);

?>
<?
if(isset($HTTP_POST_VARS["button"])) {
// save data from the POST
setcookie ("atlasprefs", "", time() - 36000000);
setcookie ("atlasprefs", "$HTTP_POST_VARS[shape]:$HTTP_POST_VARS[color]:$HTTP_POST_VARS[size]:$HTTP_POST_VARS[earthimage]:$HTTP_POST_VARS[cssdot]", time() + 36000000, $cookiepath);

$setshape = $HTTP_POST_VARS["shape"];
$setcolor = $HTTP_POST_VARS["color"];
$setsize = $HTTP_POST_VARS["size"];
$setearthimage = $HTTP_POST_VARS["earthimage"];
$setcssdot = $HTTP_POST_VARS["cssdot"];

} elseif(isset($HTTP_COOKIE_VARS["atlasprefs"]) && validcookie($HTTP_COOKIE_VARS["atlasprefs"])) {
// get data from the cookie
list($setshape, $setcolor, $setsize, $setearthimage, $setcssdot) = split(":", $HTTP_COOKIE_VARS["atlasprefs"]);
} else {
$setshape = "Diamond";
$setsize = "3";
$setcolor = "red";
$setearthimage = $earthimages[$defaultimage];
$setcssdot = "reddot.gif";
}

?>

<? # START HTML
 ?>

<html><head><title><? echo $phrase["prefs"]; ?></title>

<!-- your head tags here -->
<link rel="Stylesheet" href="ip-atlas.css">
</head><body bgcolor="#ffffff">

</head><body>

<b><? echo $phrase["lprefs"]; ?></b> <? echo $phrase["cookiebased"]; ?><br><br>

<?
if(isset($HTTP_POST_VARS["button"])) {
print "$phrase[saved]<br><br>";
}

if(shouldrun($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) { 
   $drawmode = "GD";
} else {
   $drawmode = "CSS";
}

?>

<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="POST">
<? echo $phrase["ppf"]; ?> <? echo $drawmode; ?> <? echo $phrase["dot"]; ?><br>
<?
if($drawmode == "GD") {
print <<<END
<input type="hidden" name="cssdot" value="reddot.gif">

<table><tr>

<td>$phrase[shape]</td><td><select name="shape">
END;

$shapes = array("Diamond", "Diamond Outline", "Square", "Square Outline", "Cross");
foreach($shapes as $curshape) {

if($setshape == $curshape) {
print "<option value=\"$curshape\" selected>$curshape";
} else {
print "<option value=\"$curshape\">$curshape";
}

}

print "</select></td></tr><tr><td>$phrase[size]</td><td><select name=\"size\">";

$sizes = array("2", "3", "4", "5", "6", "7", "8");
foreach($sizes as $cursize) {

if($setsize == $cursize) {
print "<option value=\"$cursize\" selected>$cursize";
} else {
print "<option value=\"$cursize\">$cursize";
}

}

print "</select></td></tr><tr><td>$phrase[color]</td><td><select name=\"color\">";

$colors = array("red", "white", "yellow", "magenta", "cyan", "green", "violet");
foreach($colors as $curcolor) {

if($setcolor == $curcolor) {
print "<option value=\"$curcolor\" selected>$curcolor";
} else {
print "<option value=\"$curcolor\">$curcolor";
}

}

print "
</select></td></tr></table>
";

} else {

print "$phrase[pointer] <select name=\"cssdot\">";

foreach($cssdots as $curdot) {

list($filename, $curdot, , ) = split(":", $curdot);

if($setcssdot == $curdot) {
print "<option value=\"$filename\" selected>$curdot";
} else {
print "<option value=\"$filename\">$curdot";
}

}

print "</select><br>";

print <<<END
<input type="hidden" name="shape" value="Diamond">
<input type="hidden" name="color" value="Red">
<input type="hidden" name="size" value="3">
END;

}

?>

<br>



Other Preferences:<br>
Earth Image: 
<select name="earthimage">

<?

foreach($earthimages as $curentry) {

list($curfile, $curname, , ) = split(":", $curentry);

if($setearthimage == $curfile) {
print "<option value=\"$curfile\" selected>$curname";
} else {
print "<option value=\"$curfile\">$curname";
}

}


?>

</select>
<br><br>
<input type="Submit" name="button" value="Save">

<div align="right">
[ <a href="plot.php">IP-Atlas</a> ]<br><br>
</div>
<? include("footer.inc"); ?>
</body></html>
