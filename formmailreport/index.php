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
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*
* For latest version, visit:
* http://www.home-port.net/formmail/
***************************************************************/

//Run Auth if passwd.php file exists
if (file_exists("passwd.php")) {
$auth = false; // Assume user is not authenticated 

if (isset( $PHP_AUTH_USER ) && isset($PHP_AUTH_PW)) { 

    // Read the entire file into the variable $file_contents 

    $filename = 'passwd.php'; 
    $fp = fopen( $filename, 'r' ); 
    $file_contents = fread( $fp, filesize( $filename ) ); 
    fclose( $fp ); 

    // Place the individual lines from the file contents into an array. 

    $lines = explode ( "\n", $file_contents ); 

    // Split each of the lines into a username and a password pair 
    // and attempt to match them to $PHP_AUTH_USER and $PHP_AUTH_PW. 

    foreach ( $lines as $line ) { 

        list( $username, $password ) = explode( ':', $line ); 

        if ( ( $username == "$PHP_AUTH_USER" ) && 
             (md5($PHP_AUTH_PW) == $password) ) { 

            // A match is found, meaning the user is authenticated. 
            // Stop the search. 

            $auth = true; 
            break; 

        } 
    } 

} 

if ( ! $auth ) { 

    header( 'WWW-Authenticate: Basic realm="Private"' ); 
    header( 'HTTP/1.0 401 Unauthorized' ); 
    echo 'Authorization Required.'; 
    exit; 
}

}else{

// Create passwd.php file if none is available
echo "<html>\n";
echo "<head>\n";
echo "<title>Log in Setup</title>\n";
echo "</head>\n";
echo "<body bgcolor=\"Aqua\">\n";

// Check files for write ability

if (is_writeable ("abuse.txt")){

}else{
echo "Please <b>chmod <font color=\"Red\">abuse.txt</font> 0777</b> before continuing.<br>";
die;
}
if (is_writeable ("complaint.php")){

}else{
echo "Please <b>chmod <font color=\"Red\">complaint.php</font> 0777</b> before continuing.<br>";
die;
}
if (is_writeable ("ip.txt")){

}else{
echo "Please <b>chmod <font color=\"Red\">ip.txt</font> 0777</b> before continuing.<br>";
die;
}
if (is_writeable ("to.php")){

}else{
echo "Please <b>chmod <font color=\"Red\">to.php</font> 0777</b> before continuing.<br>";
die;
}

echo "<table width=\"50%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">\n";
  echo "<tr>\n";
    echo "<td>\n";
	  echo "It appears this is the first time you have accessed this page. Please enter a login name and password below. Once this is done the web page will reload and you will need to authorize the login name and password you just placed in the form below.";
	echo "</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
    echo "<td>\n";
      echo "<form action=\"func.php?setup\" method=\"post\">\n";
      echo "Choose a login name:<br>\n";
      echo "<input type=\"text\" name=\"login\" size=\"30\"><br>\n";
      echo "Choose a password:<br>\n";
      echo "<input type=\"password\" name=\"passwd\" size=\"30\"><br>\n";
      echo "<input type=\"submit\" name=\"setup\" value=\"Click to setup Login\">\n";
      echo "</form>\n";
      echo "<b>Note:</b> If you have auto complete turned on for either NS or IE, you may have to reload this web page and enter the information again.";
	echo "</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
return;
  
	  }
	   
?>
<html>
<head>
	<title>Formmail Abuse Report</title>
</head>

<body bgcolor="Aqua">

<?php
require("config.php");

    echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\">\n";
      echo "<tr>\n";
      echo "<td colspan=\"2\"><a href=http://www.home-port.net/formmail/><img src=images/sm_logo.gif width=\"200\" height=\"80\" border=\"0\"></a><br><br></td>\n";
      echo "</tr>\n";
	echo "<tr>\n";
    echo "<td valign=\"top\" width=\"40%\">\n";
// Open to.php and get lines
$fd = fopen ("to.php", "r"); 

$txt = ""; 
while (!feof($fd)) { 
$txt .= fread($fd, 4096); 
}
$item = array(); 
$item = explode('";', $txt);
// Get test address remove extras
$txt0 = ($item[1]);
$t2o = str_replace('$to1="','',$txt0);
$t2 = str_replace('#','',$t2o);
// Get abuse address remove extras
$txt2 = ($item[3]);
$t3o = str_replace('$to1="','',$txt2);		
$t3 = str_replace('#','',$t3o);


// Make changes to to.php file
      echo "<form action=func.php?tooo method=\"post\">\n";
	  echo "Enter your <b>testing e-mail address</b> below:<br>\n";
	  echo "for example yourname@someisp.com<br>\n";
	  echo "<input type=\"text\" name=\"test_name\" value='$t2'><br>\n";
// Check for "#" in front of test address return correct radio button
if ($t2 == $t2o ) { 
      echo "<input type=\"radio\" value='#' name=\"test\" checked>\n";
	  echo "Formmail Report is in <b>test</b> mode<br>\n";
} else { 
      echo "<input type=\"radio\" value='#' name=\"active\" >\n";
	  echo "Click to activate <b>test</b> mode<br>\n";
}	  

// Check for "#" in front of abuse address return correct radio button
if ($t3 == $t3o) { 
      echo "<input type=\"radio\" value='#' name=\"active\" checked>\n";
	  echo "Formmail Report is in <b>active</b> mode<br>\n"; 
} else { 
      echo "<input type=\"radio\" value='#' name=\"test\" >\n";
	  echo "Click to run in <b>active</b> mode<br>\n";
} 
      echo "<input type=\"submit\" name=tooo value=\"Press to change above\">\n";
      echo "</form><br>\n";
      echo "</td>\n";
	  
      echo "<td valign=\"top\">\n";
      echo "<font color=\"Red\"><b>Important:</b></font> Make sure that <br><--\"Formmail Report is in <b>test</b> mode\"<br> and your correct e-mail address is listed<br> below before clicking any of the <b>test buttons</b>!<br><br>";
if ($t2 == $t2o) {
      echo "<img src=images/warning.gif width=\"30\" height=\"30\" border=\"0\">WARNING<br>The Recipient for these tests is:<br><b>$to1</b><br>\n";
	  }else{
      echo "<img src=images/stop.gif width=\"30\" height=\"30\" border=\"0\">STOP<br>The Recipient for these tests is:<br><b>$abuse</b><br>\n";
	  }
      echo "</td>\n";
      echo "</tr>\n";
	  
	  
      echo "<tr>\n";
      echo "<td valign=\"top\">\n";
// Test formmail.php script Innocent Surfer.      
      echo "<form action=\"formmail.php\" method=\"post\">\n";
      echo "<input type=\"submit\" value=\"Innocent Surfer Test\">\n";
      echo "</form>\n";
      echo "</td>\n";
	  
      echo "<td valign=\"top\">\n";
// Test formmail.php script, Only one Recipient.
      echo "<form action='formmail.php?recipient=$to1&subject=Formmail%20Report%20Test%20Single%20Address&email=$from2&=Hello,%20This%20is%20a%20test%20of%20Home-port.nets%20formmail%20abuse%20reporting%20script.%20If%20this%20e-mail%20was%20not%20intended%20for%20you,%20please%20reply%20to%20this%20e-mail%20and%20let%20the%20user%20of%20this%20script%20know%20about%20the%20mistake.%20So%20they%20can%20correct%20their%20setup.' method=\"post\">\n";
      echo "<input type=\"submit\" name=one value=\"One Recipient Test\">\n";
      echo "</form>\n";
      echo "</td>\n";
      echo "</tr>\n";
	  
	  
      echo "<tr>\n";
      echo "<td valign=\"top\">\n";
// Test formmail.php script, Multiple Recipients.
      echo "<form action=formmail.php?recipient=someone@someisp.net,someone@someisp.com&subject=Formmail%20Report%20Test%20Multiple%20Address&email=$from2&=Hello,%20This%20is%20a%20test%20of%20Home-port.net's%20formmail%20abuse%20reporting%20script.%20If%20this%20e-mail%20was%20not%20intended%20for%20you,%20please%20reply%20to%20this%20e-mail%20and%20let%20the%20user%20of%20this%20script%20know%20about%20the%20mistake.%20So%20they%20can%20correct%20their%20setup. method=\"post\">\n";
      echo "<input type=\"submit\" value=\"Multiple Recipients Test\">\n";
      echo "</form>\n";
      echo "</td>\n";
	  
      echo "<td valign=\"top\">\n";
// Clean ip.txt file.
      echo "<form action=\"func.php?iptxt\" method=\"post\">\n";
      echo "<input type=\"submit\" name=iptxt value=\"Press to Clean ip.txt File\"><br>\n";      
	  echo "Last IP number in ip.txt file:<br> <b>$now</b><br>\n";
  
fclose ($fd);
      echo "</td>\n";
      echo "</tr>\n";
      echo "</table>\n";

// Open complaint.php and extract items
$fp = fopen ("complaint.php", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array(); 

$items = explode('<?php $complaint = "', $text);
$last = end($items);

$center = explode('";?>', $last);
$last2 = current($center);
$file = str_replace("\'","'",$last2); 
$file2 = str_replace('\"','"',$file);
// Complaint form changes.
echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">\n";
 
	  
    echo "<tr>\n"; 
      echo "<th>Complaint Form\n"; 
	  echo "</th>\n"; 
      echo "<th>Legend of Variable's\n"; 
	  echo "</th>\n"; 
    echo "</tr>\n";
	
	 
  echo "<tr>\n";
    echo "<td>\n"; 
      echo "<form action=func.php?comp method=\"post\">\n";
      echo "<textarea cols=55 rows=17 name=area wrap=virtual>\n";
      echo "$file2";
      echo "</textarea><br><br>\n";
      echo "<input type=\"submit\" name=comp value=\"Modify Complaint Letter\">\n";
      echo "</form>\n";
	echo "</td>\n";
	
	echo "<td valign=\"top\">\n";
	echo "1. \$count1. = prefix i.e. microsoft.<br>\n";
	echo "2. \$count2 = TLD use in conjunction with above. Note DOT between each<br>\n";
	echo "3. \$T = Server Time.<br>\n";
	echo "4. \$Toff = GMT offset of time above.<br>\n";
	echo "5. \$company = Your company or web site name.<br>\n";
	echo "6. \$ip = Visitors IP number.<br>\n";
	echo "</td>\n";
	echo "</tr>\n";
echo "</table>\n";
fclose ($fp);




?>
</body>
</html>