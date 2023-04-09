<?php
/**************************************************************
* Formmail Abuse Reporting - Version 1.1
*
* (C)Copyright 2002 Home-port.net, Inc. All Rights Reserved 
* By using this software you release Home-port.net, Inc. from 
* all liability relating to this product.
*
* This module is released under the GNU General Public License. 
* See: http://www.gnu.org/copyleft/gpl.html
*
* For latest version, visit:
* http://www.home-port.net/formmail/
***************************************************************/
//Write new to.php script with information from index.php form.
if ($tooo) { 

$email ="to.php";
$fd = fopen($email, "w") or die ( "Couldn't open $email");

      fputs ( $fd, "<?PHP\n");
      fputs ( $fd, "//break//\";\n");
      fputs ( $fd, "$test\$to1=\"$test_name\";\n");
      fputs ( $fd, "//break//\";\n");
      fputs ( $fd, "$active\$to1=\"\$abuse\";\n");
      fputs ( $fd, "?>");
fclose ( $fd );  
// Return to index.php
header("Location: $HTTP_REFERER");
}

if ($comp) {
//Write new complaint.php script with information from index.php form.
$complain ="complaint.php";
$fp = fopen($complain, "w") or die ( "Couldn't open $complain");
$file2 = str_replace('"','\"',$area); 
fputs  ( $fp, stripslashes ( "<?php \$complaint = \"$file2\";?>" ) );
fclose ( $fp );  
// Return to index.php
header("Location: $HTTP_REFERER");
}

if ($iptxt) {
//Clean up ip.txt file and start over.
$txt ="ip.txt";
$fp = fopen($txt, "w") or die ( "Couldn't open $txt");
fputs ( $fp, "127.0.0.1|127.0.0.1");
fclose ( $fp );  
// Return to index.php
header("Location: $HTTP_REFERER");
}

if ($setup) {

//Create passwd.php file with user name and password from index.php.
if (isset( $login ) && isset($passwd) or die () ){ 
    
	  touch ( "passwd.php" ); 
	  exec  ("chmod 0766 passwd.php" );
	  $fd = fopen("passwd.php", "w+"); 
	  fputs ( $fd, "<?php die(\"You may not access this file.\"); ?>\r\n");
	  fputs ( $fd, $login); 
	  fputs ( $fd, ":"); 
	  fputs ( $fd, md5($passwd));
	  fclose( $fd );
	  
if (file_exists("CHANGES.txt")) {
	  unlink( "CHANGES.txt" );
	  }
if (file_exists("GNU_GPL.txt")) {
	  unlink( "GNU_GPL.txt" );
	  }
if (file_exists("readme.txt")) {
	  unlink( "readme.txt" );
	  }
if (file_exists("TODO.txt")) {
	  unlink( "TODO.txt" );
	  }

header("Location: $HTTP_REFERER");
}
}

// Four major variables
$ip = $REMOTE_ADDR;
$host = gethostbyaddr ($ip);
$query = $QUERY_STRING;
$refer = $HTTP_REFERER;

//check IP text file
$fp = fopen ("ip.txt", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array(); 
$items = explode("|", $text); 
$now = end($items);
	fclose ($fp);
if ( $now == $ip )
{ 
//check abuse file
$fp = fopen ("abuse.txt", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array();
$abuse = $text;
	fclose ($fp);
}
else{

$filename = "http://spamcop.net/sc?action=trackhost&host=$ip";
$fp = fopen ("$filename", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array(); 

$items = explode('Found abuse address:', $text);
$last = end($items);
if (eregi('<a href="mailto:.*">(.*)</a>', $last, $out)) {
$abuse = $out[1];
}
$fa = fopen("abuse.txt", "w" ) or die ("Couldn't open abuse.txt");
fputs ( $fa, "$abuse" );
    fclose ($fa);



}


// Email Message Body extraction & clean up
$text =  (  stripslashes ( $query ) );
$query2 = str_replace("%20"," ",$text);
$email_body = str_replace("%3D","=",$query2);
$e_mail = explode ( "&=", $email_body );
$message = $e_mail[count($e_mail)-1];
$message2 = str_replace("<BR>","\r\n",$message);
$message3 = str_replace("<br>","\r\n",$message2);
$message4 = str_replace("<b>","",$message3);
$message5 = str_replace("</b>","",$message4);
$message6 = str_replace("<B>","",$message5);
$message7 = str_replace("</B>","",$message6);

// Recipient extraction
$email = explode ( "&=", $query );
$count3 = $email[count($email)-1];
$email1 = explode ( "&subject", $query );
$count4 = $email1[count($email1)-2];
$email2 = explode ( "=", $count4 );
$count5 = $email2[count($email2)-1];

// Subject extraction
$subj = explode ( "&email", $query2 );
$count6 = $subj[count($subj)-2];
$subj2 = explode ( "&subject=", $count6 );
$count7 = $subj2[count($subj2)-1];

// From e-mail extraction
$fromspam = explode ( "&=", $query2 );
$count8 = $fromspam[count($fromspam)-2];
$fromspam2 = explode ( "&email=", $count8 );
$count9 = $fromspam2[count($fromspam2)-1];

// Url extraction
$url1 = $SERVER_NAME;
$url2 = (  stripslashes ( $REQUEST_URI ) );

// Time / Date format for e-mail and returned web page
$T = date ("m/d/y G:i:s", time());
$T2 = date ("l, F d, Y", time());
$T3 = date ("G:i:s", time());
$Toff = date ("O", time());

// Host extraction for sending complaint
$addr = explode ( ".", $host );
$count1 = $addr[count($addr)-2];
$count2 = $addr[count($addr)-1];

// if statements
$list = explode ( ",", $count5 );
$list2 = $list[count($list)-2];
$recipient = $list[count($list)-1];

// **** Record Information & Complaint message body bottom ****
   $record = "********************\r\n\r\nDate / Time = $T PST/PDT (GMT $Toff)\r\n\r\nAbuse address listed at SpamCop.net: $abuse\r\n\r\nHost = $host\r\n\r\nIP Number = $ip\r\n\r\nRequest URL = $url1$url2\r\n\r\nSo you can read the URL above, we have split it up to reflect how the e-mail would have looked if it was sent.\r\n\r\nRecipients =\r\n$count5\r\n\r\n(May Be Forged) From Address = $count9\r\n\r\nSubject = $count7\r\n\r\nE-mail Message Body =\r\n$message7\r\n\r\n********************\r\n\r\n";

// **** Possible Mistake message ****
   $mistake = "********************\r\n\r\nDate / Time = $T PST/PDT (GMT $Toff)\r\n\r\nAbuse address listed at SpamCop.net: $abuse\r\n\r\nHost = $host\r\n\r\nIP Number = $ip\r\n\r\nReferrer =\r\n$refer\r\n\r\nRequest URL = $url1$url2\r\n\r\n********************\r\n";

?>