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

// setup file
require("config.php");

#********************************************************************
# Protect innocent return formmail web page, and also report to admin.    * 
#********************************************************************
if  ( empty ( $query ) )
   {
// Trimmed down e-mail for personal records.
$to = "$to2";
$subject = "Possible Mistake for $ip";
$body = "$mistake";
$from = "From: $from2\r\n";

mail($to,$subject,$body,$from)  or print "Could not send mail"; 

//check IP text file
$fp = fopen ("ip.txt", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array(); 
$items = explode("|", $text); 

$last = end($items);
 
if ($last == $ip )
{ 
// Returns Cobalt RAQ type 404, web page not found.

include "404.php";

}
else{
$fp = fopen("ip.txt", "a" ) or die ("Couldn't open $filename");
fputs ( $fp, "|$ip" );
fclose ( $fp );
// Returns formmail web page.
   echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
   echo "<html>\n";
   echo "<head>\n";
   echo "<title>FormMail v1.6</title>\n";
   echo "</head>\n";
   echo "<body>\n";
   echo "<center>\n";
   echo "<table border=0 width=600 bgcolor=#9C9C9C>\n";
   echo "<tr><th><font size=+2>FormMail</font></th></tr>\n";
   echo "</table>\n";
   echo "<table border=0 width=600 bgcolor=#CFCFCF>\n";
   echo "<tr><th><tt><font size=+1>Copyright 1995 - 2000 Matt Wright<br> Version 1.6 - Released April 21, 2000<br> A Free Product of <a href=\"http://www.worldwidemart.com/scripts/\">Matt's Script Archive, Inc.</a></font></tt></th></tr>\n";
   echo "</table>\n";
   echo "</center>\n";
   echo "</body>\n";
   echo "</html>\n";
 } }
   
// E-mail Trap if only one recipient is used   
elseif ( $recipient == $count5 )
   {
   
//check IP text file
$fp = fopen ("ip.txt", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array(); 
$items = explode("|", $text); 

$last = end($items);
 
if ($last == $ip )
{
#********************************************************************
# If IP is listed in ip.txt file, report and return formmail.pl     * 
# error message                                                     *
#********************************************************************

// Trimmed down e-mail for personal records.
$to = "$to2";
$subject = "Trap Set for $ip";
$body = "$record";
$from = "From: $from2\r\n";

mail($to,$subject,$body,$from)  or print "Could not send mail";

// Returns Cobalt RAQ type 404, web page not found.
include "404.php";
   }
else {

#********************************************
# Append IP to file and Return e-mail trap. *
#********************************************

$fp = fopen("ip.txt", "a" ) or die ("Couldn't open $filename");
fputs ( $fp, "|$ip" );
fclose ( $fp );

// One time e-mail trap.
$to = "$recipient";
$subject = "$count7";
$body = "Below is the result of your feedback form.  It was submitted by\r\n($count9) on $T2 at $T3\r\n---------------------------------------------------------------------------\r\n\r\n$message7\r\n\r\n---------------------------------------------------------------------------";
$from = "From: $count9\r\n";

mail($to,$subject,$body,$from)  or print "Could not send mail";

// Trimmed down e-mail for personal records.
$to = "$to2";
$subject = "Trap sent for $ip";
$body = "$record";
$from = "From: $from2\r\n";

mail($to,$subject,$body,$from)  or print "Could not send mail"; 

// Returned web page that looks like the e-mail attempt was sent, just like
// the regular formmail.pl script returns.
   echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
   echo "<html>\n";
   echo "<head>\n";
   echo "<title>Thank You</title>\n";
   echo "</head>\n";
   echo "<body>\n";
   echo "<center>\n";
   echo "<h1>Thank You For Filling Out This Form</h1>\n";
   echo "</center>\n";
   echo "Below is what you submitted to $count5 on $T2 at $T3<p><hr size=1 width=75%><p>\n";
   $text =  (  stripslashes ( $count3 ) );
   $file = str_replace("%20"," ",$text);
   $file2 = str_replace("%3D","=",$file);
   echo "<b>:</b>&nbsp;\n";
   echo "$file2 \n";
   echo "</b><p><hr size=1 width=75%><p>\n";
   echo "<hr size=1 width=75%><p>\n";
   echo "<center><font size=-1><a href=http://www.worldwidemart.com/scripts/formmail.shtml>FormMail</a> V1.6 &copy; 1995 - 2002  Matt Wright\n";
   echo "A Free Product of <a href=http://www.worldwidemart.com/scripts/>Matts Script Archive, Inc.</a></font></center>\n";
   echo "</body>\n";
   echo "</html>\n";
   }


 }
 
#********************************************************************
# Complaint and personal report if more than one recipient is used. *
#********************************************************************
elseif ( $recipient != $list2 ){
//check IP text file
$fp = fopen ("ip.txt", "r"); 

$text = ""; 
while (!feof($fp)) { 
$text .= fread($fp, 4096); 
}
$items = array(); 
$items = explode("|", $text); 

$last = end($items);

if ($last != $ip )
$fp = fopen("ip.txt", "a" ) or die ("Couldn't open $filename");
fputs ( $fp, "|$ip" );
fclose ( $fp );
 
// Complaint e-mail
if ( $abuse == "" ) {
echo "<h2>Go Away, An e-mail complaint has been sent to the IP block owner of $ip</h2><br><br><PRE style=word-wrap:break-word>$record</pre>";
}else {
$to = "$to1";
$subject = "Network Abuse from $ip";
$body = "$complaint$record";
$from = "From: $from2\r\n";

mail($to,$subject,$body,$from,"-f$from2")  or print "Could not send mail";

// Trimmed down e-mail for personal records.
$to = "$to2";
$subject = "Network Abuse from $ip";
$body = "$record";
$from = "From: $from2\r\n";

mail($to,$subject,$body,$from)  or print "Could not send mail"; 

// Returned web page that looks like the e-mail attempt was sent, just like
// the regular formmail.pl script returns.
   echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
   echo "<html>\n";
   echo "<head>\n";
   echo "<title>Thank You</title>\n";
   echo "</head>\n";
   echo "<body>\n";
   echo "<center>\n";
   echo "<h1>Thank You For Filling Out This Form</h1>\n";
   echo "</center>\n";
   echo "Below is what you submitted to $count5 on $T2 at $T3<p><hr size=1 width=75%><p>\n";
   $text =  (  stripslashes ( $count3 ) );
   $file = str_replace("%20"," ",$text);
   $file2 = str_replace("%3D","=",$file);
   echo "<b>:</b>&nbsp;\n";
   echo "$file2 \n";
   echo "</b><p><hr size=1 width=75%><p>\n";
   echo "<hr size=1 width=75%><p>\n";
   echo "<center><font size=-1><a href=http://www.worldwidemart.com/scripts/formmail.shtml>FormMail</a> V1.6 &copy; 1995 - 2002  Matt Wright\n";
   echo "A Free Product of <a href=http://www.worldwidemart.com/scripts/>Matts Script Archive, Inc.</a></font></center>\n";
   echo "</body>\n";
   echo "</html>\n";
   }   
}   
?>

