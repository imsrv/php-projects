<table align="center" width="300" border="0">
<!-- an Ask the Webmaster tip --><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: xx-small;
	color: #000000;
}
.style1 {color: #FF0000}
body {
	background-color: #E9E9E9;
}
-->
</style>

<p>Send Us Your Comments ....</p>
  <form action="ask.php" method="post">
<input type="hidden" name="to" value="admin@halilwarez.com">
<table width=400>
<tr><td>Name</td><td><input type="text" size=20 name="name"></td></tr>
<tr><td>E-Mail</td><td><input type="text" size=20 name="email"></td></tr>
<tr><td>Subject</td><td><input type="text" size=20 name="subject"></td></tr>
<tr><td valign="top">Message</td><td><textarea cols=30 rows=5 name="message"></textarea></td></tr>
<tr><td colspan=2><input type="submit" value="Send"></td></tr></table>
</form>
<p><?


$atdomain = ""; // use to specify domain name, ex. @yourdomain.com NOT just yourdomain.com
// If above domain name is not specified, it must be specified in the form with the address!



$site_header = ""; // If you want to use your own site header, enter the URL to that here.
$site_footer = ""; // If you want to use your own site footer, enter the URL to that here.
$default_subject = "Results from Ask the Webmaster";

// Required editing finished.

if(!$atdomain) {
$to = strtr($to,":","@");
}

if(!$subject) {
$subject = $default_subject;
}

if($name == "" || $email == "" || $message == "") {
die("");
}

$body = "Name: $name\n\nE-Mail: $email\n\nMessage:\n$message";

mail($to . $atdomain, $subject, $body . "\n\n\n\nPowered by sickboy contact form", "From: $email");

# Build thanks page
if($site_header) {
include($site_header);
}
else {
echo "<html><head><title>Halilwarez</title></head><body bgcolor=\"#262626\" text=\"#CCCCCC\">";
}
print "\n<b>Mail sent.</b><br>Thanks, the webmaster will reply soon and make changes if possible.<p>\n";
print "You said:<br>$body<br>";
if($site_footer) {
include($site_footer);
}

?></table>