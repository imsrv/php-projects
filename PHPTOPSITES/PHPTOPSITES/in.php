<?
include "config.php";

if (!$site) header("location: $url_to_folder");

$get_rows = mysql_db_query ($dbname,"Select title,url from top_user Where sid=$site",$db) or die (mysql_error());
if (!mysql_num_rows($get_rows) OR mysql_num_rows ($get_rows) < 1) { header("location: $url_to_folder"); }

if ($gateway == 1 AND $stat != "gate") {

	if ($use_cookies == 1) {
		setcookie ("test_cookies", "1",time()+86400);	
	}

	echo "<HTML>\n";
	echo "<HEAD>\n";
	echo "<meta name=\"robots\" content=\"all\">\n";
	echo "<meta name=\"description\" content=\"Find the most popular sites based on traffic in desktop, free stuff, games, music, celebrities, and more.\">\n";
	echo "<meta name=\"keywords\" content=\"top list sites sites links top web sites toplists top lists top list web directory the best sites webdirectory search engines searchengines portals free internet community send postcards free traffic free webpromotion linkexchange link exchange programs webmaster community webmaster affiliate programs computers free cliparts clip arts desktop themes free games free screensavers free wallpapers internet chat cool sites personal homepages webmasters animals crafts movies free mp3 music free cash freestuff free stuff greetingcards shopping women business free gsm telecom free webhosting free magazines cars celebrity celebrities free contests dogs education finance free fonts freeware free graphics health horoscopes jobs jokes free marketing midi pets free phones free free software free themes top websites top sites travel free videogames webcams webdesign webhosting entertainment\">\n";
	echo "<meta name=\"revisit-after\" content=\"14 days\">\n";
	echo "<title>Welcome to $top_name</title>\n";
	echo "</HEAD>\n";
	echo "<body bgcolor=\"#FFFFFF\" onLoad=\"if (self != top) top.location = self.location\">\n";
	echo "<FORM ACTION=\"in.php\" METHOD=\"POST\">\n";
	echo "<p align=\"center\">&nbsp;</p>\n";
	echo "<p align=\"center\">\n";
	echo "<INPUT TYPE=\"IMAGE\" NAME=\"SUBMIT_IMAGE\" WIDTH=\"347\" HEIGHT=\"33\" ALT=\"ENTER TO $top_name\" src=\"images/enter.gif\"><BR>\n";
	echo "</p>";
	echo "<p align=\"center\">&nbsp;</p>\n";
	echo "<INPUT TYPE=\"HIDDEN\" NAME=\"site\" VALUE=\"$site\">\n";
	echo "<INPUT TYPE=\"HIDDEN\" NAME=\"stat\" VALUE=\"gate\">\n";
	echo "</FORM>\n";
	echo "</body>\n";
	echo "</html>\n";
	echo "";
}
else {
	setcookie ("test_cookies", "1",time()+86400);
}

if ($gateway == 1 && $REQUEST_METHOD == "POST" && isset($site)) {

	if ($use_cookies == 1) {
		setcookie ("test_cookies", "1",time()+86400);
	}

	$cdate = date ("Ymd");

	$err = 1;

	$query = mysql_db_query ($dbname,"Select ip from top_hits Where sid=$site and cdate=$cdate and ip='$REMOTE_ADDR'",$db) or die (mysql_error());
	if ($err == 1 && @mysql_num_rows($query) >= 1) $err = 2;

	if ($err == 1 && $use_cookies == 1) {
		if ($anti_cheat[$site] == 1) $err = 2;
 		if ($test_cookies != 1) $err = 5;
	}

	if ($err == 1) {
		if ($use_cookies == 1) {
			setcookie ("anti_cheat[$site]", "1",time()+86400);
		}
		mysql_db_query ($dbname,"update top_user set hitin=hitin+1 Where sid=$site",$db) or die (mysql_error());
		mysql_db_query ($dbname,"insert into top_hits (sid,ip) values ($site,'$REMOTE_ADDR')",$db) or die (mysql_error());
	}
				
	header("location: $url_to_folder/index.php?a_m=$err");
}	

if ($gateway != 1) {

	$cdate = date ("Ymd");

	$err = 1;

	$query = mysql_db_query ($dbname,"Select ip from top_hits Where sid=$site and cdate=$cdate and ip='$REMOTE_ADDR'",$db) or die (mysql_error());
	if ($err == 1 && @mysql_num_rows($query) >= 1) {
		$err = 2;
		if ($use_cookies == 1) {
			setcookie ("anti_cheat[$site]", "1",time()+86400);
		}
	}

	if ($err == 1) {
		if ($anti_cheat[$site] == 1) $err = 2;
	}

	if ($err == 1) {
		if ($use_cookies == 1) {
			setcookie ("anti_cheat[$site]", "1",time()+86400);
		}
		mysql_db_query ($dbname,"update top_user set hitin=hitin+1 Where sid=$site",$db) or die (mysql_error());
		mysql_db_query ($dbname,"insert into top_hits (sid,ip) values ($site,'$REMOTE_ADDR')",$db) or die (mysql_error());
	}
				
	header("location: $url_to_folder/index.php?a_m=$err");
}	
?>