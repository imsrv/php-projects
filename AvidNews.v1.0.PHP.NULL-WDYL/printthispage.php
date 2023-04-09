<?php 
include './config.php';

echo $PHPrint; 


//Do you want to strip images from the printable output?
// If no, change to "no". Otherwise, images are stripped by default.
$stripImages = "yes";

//what's the base domain name of your site, without trailing slash? 
// Just the domain itself, so we can fix any relative image and link problems.
$baseURL="$CONF[domain]"; 

// That's it! No need to go below here. Upload it and test by going to yoursite.com/page.php
// (The page containing the two tags and a link to this script)
// -----------------------------------------------------

$startingpoint = "<!-- startprint -->";
$endingpoint = "<!-- stopprint -->";
// let's turn off any ugly errors for a sec so we can use our own if necessary...
error_reporting(0);
// $read = fopen($HTTP_REFERER, "rb") ... this line may work better if you're using NT, or even FreeBSD
$read = fopen($HTTP_REFERER, "r") or die("<br /><font face=\"Verdana\">Sorry! There is no access to this file directly. You must follow a link. <br /><br />Please click your browser's back button. </font><br><br><a href=\"http://miracle2.net/\"><img src=\"http://miracle2.net/i.gif\" alt=\"miracle 2\" border=\"0\"></a>");
// let's turn errors back on so we can debug if necessary
error_reporting(1);

$value = "";
while(!feof($read)){
$value .= fread($read, 10000); // reduce number to save server load
}
fclose($read);
$start= strpos($value, "$startingpoint"); 
$finish= strpos($value, "$endingpoint"); 
$length= $finish-$start;
$value = str_replace("%newpage%", "<P>", $value);
$value=substr($value, $start, $length);

function i_denude($variable) {
return(eregi_replace("<img src=[^>]*>", "", $variable));
}
function i_denudef($variable) {
return(eregi_replace("<font[^>]*>", "", $variable));
}

$PHPrint = ("$value");
if ($stripImages == "yes") {
$PHPrint = i_denude("$PHPrint");
}

$PHPrint = i_denudef("$PHPrint");
$PHPrint = str_replace( "</font>", "", $PHPrint );
$PHPrint = stripslashes("$PHPrint"); 

echo "<base href=\"$baseURL\">";

echo $PHPrint; 
echo "<br/><br/>This page printed from: $HTTP_REFERER";
flush (); 
?>
