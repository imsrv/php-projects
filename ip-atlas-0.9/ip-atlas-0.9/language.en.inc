<?

# leave the $phrase[] alone, but edit the value.
# email new language.inc files to ivan@xpenguin.com

$phrase = array();

// main page
$phrase["plotting"] = "Plotting";
$phrase["preferences"] = "preferences";
$phrase["locateme"] = "locate me";
$phrase["iphostname"] = "IP/Hostname:";

// plot.inc
$phrase["youat"] = "You at";
$phrase["is"] = "is"; # Used in context "(host) is located in"
$phrase["are"] = "are"; # Used in context "You at (host) are located in"
$phrase["locatedin"] = "located in";

// errors
$phrase["cbl"] = "cannot be located.";
$phrase["cbr"] = "cannot be resolved.";
$phrase["pir"] = "is a host in the private IP address range.";
$phrase["dnr"] = "does not resolve.";
$phrase["iip"] = "is not a valid IP address.";
$phrase["tlf"] = "Temporary lookup failure.";

// preferences page
$phrase["prefs"] = "IP-Atlas Preferences";
$phrase["lprefs"] = "IP-Atlas preferences";
$phrase["cookiebased"] = "(cookie based)";
$phrase["saved"] = "Your settings have been saved. 
                    You can now try
                    <a href=\"plot.php\">plotting something</a>";

$phrase["ppf"] = "Pointer Preferences for"; # CSS/GD
$phrase["dot"] = "mode (the dot that marks lat/lon):";
$phrase["shape"] = "Shape:";
$phrase["size"] = "Size:";
$phrase["color"] = "Color:";
$phrase["pointer"] = "Pointer:";

?>