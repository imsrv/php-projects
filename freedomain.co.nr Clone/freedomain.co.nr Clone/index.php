<?php
#### Name of this file: index.php 
#### Does the subdomain redirection and advertising

include("myred/include/vars.php");
include("myred/include/mysql.php");

// Get the hostname typed in
$subhost = $_SERVER['HTTP_HOST'];
$subhost = strtolower($subhost);

// Get away the "www." in front (in case there is one)
$subhost = str_replace("www.", "", $subhost);

// First get everything after the first slash to realize path forwarding later on
$subhost2 = strstr($subhost, "/");
// If $subhost2 contains a value, delete it from $subhost
if ($subhost2) {
	$subhost = str_replace($subhost2, "", $subhost);
	}

// In case the main domain is called, redirect to the startpage and exit
if($subhost=="$maindomain" || $subhost=="www.$maindomain") {
	header("Location: http://www.$maindomain/$startpage");
	exit;
	}

// And now lets prepare the variable $subhost2 for pathforwarding
// This is important, because if forwarding goes directly to a file (e.g. something.html), no slash must be at the end
if($_SERVER['REQUEST_URI']=="/") {
	$subhost2 = "";
	}
else {
	$subhost2 = $_SERVER['REQUEST_URI'];
	}

// Now check for results
$check = mysql_query("SELECT * FROM $redir_table WHERE host = '$subhost' and active='on'");

// If no Result is found, redirect to the predefined startpage
if (mysql_num_rows($check) != 1) {
	header("Location: http://www.$maindomain/$startpage");
	exit;
}

// Fetching results of the subdomaincheck into an array
$row = mysql_fetch_array($check);
$target_url = "$row[url]$subhost2";
$catname = "$row[cat]";

// Get info about the category where the subdomain is in
$catcheck = mysql_query("SELECT * FROM $category_table WHERE category = '$catname'");
$catrow = mysql_fetch_array($catcheck);

// The cookie and stat part - needed for counting unique visitors
$cookiename = str_replace(".","",$subhost);
if ($row[stats]=="on" && !$_COOKIE[$cookiename]) {
	SetCookie("$cookiename", "$cookiename", time()+86400); // expires 1 day from now
	$time = time();
	$date = date("Y/m/d");
	$ip = $_SERVER["REMOTE_ADDR"];
	$browser = $_SERVER["HTTP_USER_AGENT"];
	$referer = $_SERVER["HTTP_REFERER"];
	if (!$referer) {
		$referer = "none";
		}
	mysql_query("INSERT INTO $visitor_table (host, date, ip, agent, ref, timestamp) VALUES ('$subhost', '$date', '$ip', '$browser', '$referer', '$time')") or die (mysql_error());
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title><?php echo stripslashes($row[title]) ?></title>
<meta name="keywords" content="<?php echo stripslashes($row[keyw]) ?>">
<meta name="description" content="<?php echo stripslashes($row[descr]) ?>">
<meta name="revisit-after" content="<?php echo stripslashes($row[revisit]) ?>">
<meta name="robots" content="<?php echo stripslashes($row[robots]) ?>">
</head>
<?php
if ($catrow[advtype]=="adfree" || $row[adtype]=="off") {
?>
<frameset rows="100%,*" frameborder="NO" border="0" framespacing="0">
<frame name="main" src="<?php echo $target_url ?>">
<?php
}
if ($catrow[advtype]=="upperframe" &&  $row[adtype]=="on") {
?>
<frameset rows="<?php echo $catrow[height] ?>,*" frameborder="NO" border="0" framespacing="0">
<frame name="ad" src="<?php echo stripslashes($catrow[adurl]) ?>" noresize scrolling="no">
<frame name="main" src="<?php echo $target_url ?>">
<?php
}
if ($catrow[advtype]=="lowerframe" &&  $row[adtype]=="on") {
?>
<frameset rows="*,<?php echo $catrow[height] ?>" frameborder="NO" border="0" framespacing="0">
<frame name="main" src="<?php echo $target_url ?>">
<frame name="ad" src="<?php echo stripslashes($catrow[adurl]) ?>" noresize scrolling="no">
<?php
}
if ($catrow[advtype]=="popup" &&  $row[adtype]=="on") {
?>
<script language="JavaScript">
<!--
function PopUpBanner() {
var windowoptions = "location=no,scrollbars=no,menubars=no,toolbars=no,resizable=yes,left=50,top=50,width=<?php echo $catrow[width] ?>,height=<?php echo $catrow[height] ?>";
myredpopup = open('<?php echo stripslashes($catrow[adurl]) ?>',"AdPopup",windowoptions);
myredpopup.focus();
}
PopUpBanner();
//  -->
</script>
<frameset rows="100%,*" frameborder="NO" border="0" framespacing="0">
<frame name="main" src="<?php echo $target_url ?>">
<?php
}
?>
</frameset>
<noframes>
<body bgcolor="#FFFFFF" text="#000000">
<a href="<?php echo $target_url ?>">Click here to continue to <?php echo stripslashes($row[title]) ?></a>
</body>
</noframes>
</html>
<?php
// Update the user's counter and lasttime visited
$lastvisit = time();
mysql_query("UPDATE $redir_table SET counter=counter+1, lasttime=$lastvisit WHERE host='$subhost'");

// Delete old stats values...
$deadline = time()-($keepstats*86400);
mysql_query("DELETE FROM $visitor_table WHERE timestamp<$deadline");
exit;
// Just for the case something went wrong
header("Location: http://www.$maindomain/$startpage");
exit;
?>