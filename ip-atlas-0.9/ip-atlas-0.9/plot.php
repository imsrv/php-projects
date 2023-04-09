<? 

error_reporting(E_ALL);

include("plotconf.inc");
include("plot.inc");
include($language);

// check if it is the user's ip, or another host

if(!isset($HTTP_GET_VARS["address"]) || ($HTTP_GET_VARS["address"] == "")) { 
    $address = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    $local = 1; 
} else {
    $address = $HTTP_GET_VARS["address"];
    $local = 0; 
}

// this is the most important function, gets lat/lon and description of location
$values = getstuff($address, $local) or die("Error in plot.inc");

if(isset($logging) && is_writable("plotlog.txt")) {
  $log = @fopen("plotlog.txt", "a") or print "";
  @fputs($log, $HTTP_SERVER_VARS["REMOTE_ADDR"] ."\t". date("F j, Y, g:i a") . "\t$address\t$values[address]\t$values[lat]\t$values[lon]\n") or print "";
@fclose($log);
}

if(isset($HTTP_COOKIE_VARS["atlasprefs"]) && validcookie($HTTP_COOKIE_VARS["atlasprefs"])) {
list( , , , $imagething) = split(":", $HTTP_COOKIE_VARS["atlasprefs"]);
$earthimage = isvalidimage($imagething, $earthimages, $defaultimage);
} else {
$earthimage = $earthimages[$defaultimage];
}

if(strstr($earthimage, ":")) {
    list($earthimage, , , ) = split(":", $earthimage);
}

if(!shouldrun($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {

list($width, $height) = getimagecoords($earthimages, $earthimage);
list($x, $y) = getlocationcoords($values["lat"], $values["lon"], $width, $height);

if(isset($HTTP_COOKIE_VARS["atlasprefs"])) {
list( , , , , $dotname) = split(":", $HTTP_COOKIE_VARS["atlasprefs"]);
list($thedot, $dotwidth, $dotheight) = finddot($dotname, $cssdots, $defaultdot);
} else {
$dotname = $cssdots[$defaultdot];
list($dotname, , , ) = split(":", $dotname);
list($thedot, $dotwidth, $dotheight) = finddot($dotname, $cssdots, $defaultdot);
}

$x = ($x - floor($dotwidth / 2));
$y = ($y - floor($dotheight / 2));

$extracss = "<style>
#dotDiv { padding-left:$x; padding-top:$y; }
</style>";
$display = "<div id=\"dotDiv\"><img width=\"$dotwidth\" height=\"$dotheight\" src=\"$thedot\">";

} else {

list($width, $height) = getimagecoords($earthimages, $earthimage) or die("Unable to find width/height for image $earthimage in config file");
$extracss = "";
$display = "<img src=\"plotimage.php?lat=$values[lat]&lon=$values[lon]\" width=\"$width\" height=\"$height\">";

}

# START HTML

print <<<END

<html><head><title>$phrase[plotting] $values[address]</title>
$extracss

<!-- your head tags here -->
<link rel="Stylesheet" href="ip-atlas.css">
</head><body bgcolor="#ffffff">


<a name="map">

<table valign="top" cellpadding=0 cellspacing=0 border=0 background="$earthimage" width="$width" height="$height"><tr><td valign="top">$display</td></tr></table>


<br>
END;
if(isset($address)) {
print "$values[desc]";
}

$PHP_SELF = $HTTP_SERVER_VARS['PHP_SELF'];

print <<<END
<br><br>
<form method="GET" action="$PHP_SELF#map">
<table width="100%"><tr><td nowrap align="left">
$phrase[iphostname] <input value="$values[address]" type="text" size="30" name="address"><input type="Submit" value="Submit"></td><td align="right" width="100%">
[ <a href="ip-atlas_prefs.php">$phrase[preferences]</a> ]
[ <a href="$PHP_SELF">$phrase[locateme]</a> ]
</td></tr></table>
</form>
END;

include("footer.inc");

print "</body></html>";

?>
