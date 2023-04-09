#!/usr/bin/perl

##################################################
##                                              ##
##             AUTORESPONSE PLUS (tm)           ##
##       Sequential Autoresponder System        ##
##                Version 2.12                  ##
##                                              ##
##   Copyright Gobots Internet Solutions, 2001  ##
##             All rights reserved              ##
##                                              ##
##  For support and latest product information  ##
##    visit http://www.autoresponseplus.com.    ##
##                                              ##
##  Use of AutoResponse Plus is subject to our  ##
##   license agreement and limited warranty.    ##
##  See the file license.txt for more details.  ##
##                                              ##
##################################################

require "arp-paths.pl";
require "arp-settings.pl";
require "arp-data.pl";
require "arp-library.pl";

print "Content-type: text/html\n\n";

$cgi_dir = $ENV{"SCRIPT_NAME"};
$cgi_dir =~s/\/install.pl//g;

&ReadInput;
my($thisscript) = $ENV{"SCRIPT_NAME"};

if (! $FORM{"ok"}) {
    if (-e "$_data_path/arptest.txt") {
        print "<html>\n";
		print "<head>\n";
		print "<title>AutoResponse Plus Installer</title>\n";
		print "</head>\n";
		print "<body>\n";
		print "<p><font face='Trebuchet MS,Arial,Helvetica' size='5' color='#000080'><strong>AutoResponse Plus Version $_version</strong></font></p>\n";
		print "<p><font face='Trebuchet MS,Arial,Helvetica' size='4'><b>Installer Program</b></font></p>\n";
		print "<hr noshade size='1' color='#000080'>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2' color='#FF0000'><strong>READ THESE INSTRUCTIONS CAREFULLY</strong></font></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>Your data path has been detected as:</font></p>\n";
		print "<p><strong><font face='Verdana,Arial,Helvetica' size='2'>$_data_path</font></strong></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>This is probably correct because a test file (arptest.txt) you uploaded to this directory has been found there.</font></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>If it is not correct, do not run this installer. Instead, correct the data path in the file <strong>arp-paths.pl</strong> before running this installer.</font></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>Click the <strong>Install</strong> button below <b>once only</b> to begin the installation procedure. If you see any errors, go back through the installation instructions and double check everything before trying again.</font></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2' color='#FF0000'><strong>WARNING: All existing AutoResponse Plus data will be lost.</strong></font></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>When the installation procedure has completed successfully, immediately delete the file <strong>install.pl</strong>.</font></p>\n";
		print "<form method='POST' action='$cgi_dir/install.pl'>\n";
		print "<input type='hidden' name='ok' value='1'>\n";
		print "<div align='center'>\n";
		print "<center>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'><input type='submit' value='Install - Click Once Only'></font></p>\n";
		print "</center>\n";
		print "</div>\n";
		print "</form>\n";
		print "<hr noshade size='1' color='#000080'>\n";
        print "<p><font face='Verdana,Arial,Helvetica' size='1'>© Copyright Gobots Internet Solutions, 2001. All rights reserved.<br>\n";
        print "<a href='http://www.autoresponseplus.com'>http://www.autoresponseplus.com</a></font></p>\n";
		print "</body>\n";
		print "</html>\n";
    } # if
    else {
        print "<html>\n";
		print "<head>\n";
		print "<title>AutoResponse Plus Installer</title>\n";
		print "</head>\n";
		print "<body>\n";
		print "<p><font face='Trebuchet MS,Arial,Helvetica' size='5' color='#000080'><strong>AutoResponse Plus Version $_version</strong></font></p>\n";
		print "<p><font face='Trebuchet MS,Arial,Helvetica' size='4'><b>Installer Program</b></font></p>\n";
		print "<hr noshade size='1' color='#000080'>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>Your data path has been detected as:</font></p>\n";
		print "<p><strong><font face='Verdana,Arial,Helvetica' size='2'>$_data_path</font></strong></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>This is <strong>not</strong> correct because the test file (arptest.txt) was not found there.</font></p>\n";
		print "<p><font face='Verdana,Arial,Helvetica' size='2'>Correct the data path in the file <strong>arp-paths.pl</strong> before running this installer again.</font></p>\n";
		print "<hr noshade size='1' color='#000080'>\n";
        print "<p><font face='Verdana,Arial,Helvetica' size='1'>© Copyright Gobots Internet Solutions, 2001. All rights reserved.<br>\n";
        print "<a href='http://www.autoresponseplus.com'>http://www.autoresponseplus.com</a></font></p>\n";
		print "</body>\n";
		print "</html>\n";
    } # else

    exit;
} # if

print "<html>\n";
print "<head>\n";
print "<title>AutoResponse Plus Installer</title>\n";
print "</head>\n";
print "<body>\n";
print "<p><font face='Trebuchet MS,Arial,Helvetica' size='5' color='#000080'><strong>AutoResponse Plus Version $_version</strong></font></p>\n";
print "<p><font face='Trebuchet MS,Arial,Helvetica' size='4'><b>Installer Program</b></font></p>\n";
print "<hr noshade size='1' color='#000080'>\n";

print "<p><font face='Verdana,Arial,Helvetica' size='2'>When this procedure has completed successfully, you must delete the file <strong>install.pl</strong>.</font></p>\n";

unlink ("$_data_path/serial.txt");
open (FILE, ">$_data_path/serial.txt");
print FILE "0";
close FILE;
chmod (0666, "$_data_path/serial.txt");
print "<p><font face='Verdana,Arial,Helvetica' size='2'>\n";
print "Step 01 of 18: Serial number initialized OK<br>";

unlink (glob("$_data_path/OWN*.*"));
unlink (glob("$_data_path/OWN*"));
my(%owner) = &data_New("OWN");
$owner{"id"} = "OWN00000000";
$owner{"name"} = "owner";
$owner{"password"} = "12345";
&data_Save(%owner);
chmod(0666, "$_data_path/OWN");
print "Step 02 of 18: Owner created OK<br>";

unlink (glob("$_data_path/SET*.*"));
unlink (glob("$_data_path/SET*"));
my(%settings) = &data_New("SET");
$settings{"id"} = "SET00000000";
$settings{"file_locking"} = 1;
$settings{"sendmail"} = "/path/to/your/sendmail";
$settings{"your_domain"} = "yourdomain.com";
$settings{"cgi_arplus_url"} = "http://www.yourdomain.com" . $cgi_dir;
$settings{"support_email"} = "support\@yourdomain.com";
$settings{"system_email"} = "support\@yourdomain.com";
$settings{"attachments_path"} = "/path/to/your/attachments/directory";
$settings{"affiliate_text"} = "Proudly Powered by AutoResponse Plus";
$settings{"unsubscribe_text"} = "If you wish to cancel your subscription to this autoresponder, simply click once on the link below.";
$settings{"spam_message"} = "We do not support unsolicited e-mail (spam) in any form. If you feel you have been subscribed to this autoresponder without your permission, please contact the sender and we will investigate.";
$settings{"send_unconf"} = 1;
$settings{"tooltips"} = "1";
&data_Save(%settings);
chmod(0666, "$_data_path/SET");
print "Step 03 of 18: System setup created OK<br>";

unlink (glob("$_data_path/AUT*.*"));
unlink (glob("$_data_path/AUT*"));
dbmopen(%db_aut, "$_data_path/AUT", 0666);
dbmclose(%db_aut);
chmod(0666, "$_data_path/AUT");
print "Step 04 of 18: Autoresponder database created OK<br>";

unlink (glob("$_data_path/MES*.*"));
unlink (glob("$_data_path/MES*"));
dbmopen(%db_mes, "$_data_path/MES", 0666);
dbmclose(%db_mes);
chmod(0666, "$_data_path/MES");
print "Step 05 of 18: Message database created OK<br>";

unlink (glob("$_data_path/*.mes"));
print "Step 06 of 18: All message files deleted<br>";

unlink (glob("$_data_path/*.hed"));
print "Step 07 of 18: All header files deleted<br>";

unlink (glob("$_data_path/*.foo"));
print "Step 08 of 18: All footer files deleted<br>";

%ar = &data_New("AUT");
$ar{"listens_on"} = "test";
$ar{"description"} = "Test Autoresponder";
$ar{"reply_name"} = "AutoResponse Plus Test";
$ar{"reply_email"} = "test\@autoresponseplus.com";
$ar{"email_control"} = "1";
$ar{"form_control"} = "1";
$ar{"status"} = "A";
%message = &data_New("MES");
$ar{"message_order"} = $ar{"message_order"} . "|" . $message{"id"};
$ar{"immediate_message_id"} = $message{"id"};
&data_Save(%ar);
$message{"parent_id"} = $ar{"id"};
$message{"subject"} = "Test Subject 1";
$message{"interval"} = "1";
$message{"attachments"} = "";
$message{"default_format"} = "T";
$message{"use_header"} = "";
$message{"use_footer"} = "";
$message{"schedule"} = "IMM";
&data_Save(%message);
&SaveText("This is plain message 1", "$_data_path/$message{'plain_file_id'}.mes");
&SaveText("This is <b>HTML</b>message 1", "$_data_path/$message{'html_file_id'}.mes");
%message = &data_New("MES");
$ar{"message_order"} = $ar{"message_order"} . "|" . $message{"id"};
&data_Save(%ar);
$message{"parent_id"} = $ar{"id"};
$message{"subject"} = "Test Subject 2";
$message{"interval"} = "1";
$message{"attachments"} = "";
$message{"default_format"} = "T";
$message{"use_header"} = "";
$message{"use_footer"} = "";
$message{"schedule"} = "NEX";
&data_Save(%message);
&SaveText("This is plain message 2", "$_data_path/$message{'plain_file_id'}.mes");
&SaveText("This is <b>HTML</b>message 2", "$_data_path/$message{'html_file_id'}.mes");
%message = &data_New("MES");
$ar{"message_order"} = $ar{"message_order"} . "|" . $message{"id"};
&data_Save(%ar);
$message{"parent_id"} = $ar{"id"};
$message{"subject"} = "Test Subject 3";
$message{"interval"} = "1";
$message{"attachments"} = "";
$message{"default_format"} = "T";
$message{"use_header"} = "";
$message{"use_footer"} = "";
$message{"schedule"} = "NEX";
&data_Save(%message);
&SaveText("This is plain message 3", "$_data_path/$message{'plain_file_id'}.mes");
&SaveText("This is <b>HTML</b>message 3", "$_data_path/$message{'html_file_id'}.mes");
print "Step 09 of 18: Test autoresponder created OK<br>";

unlink (glob("$_data_path/CAM*.*"));
unlink (glob("$_data_path/CAM*"));
dbmopen(%db_cam, "$_data_path/CAM", 0666);
dbmclose(%db_cam);
chmod(0666, "$_data_path/CAM");
print "Step 10 of 18: Subscriber database created OK<br>";

unlink (glob("$_data_path/TRA*.*"));
unlink (glob("$_data_path/TRA*"));
dbmopen(%db_tra, "$_data_path/TRA", 0666);
dbmclose(%db_tra);
chmod(0666, "$_data_path/TRA");
print "Step 11 of 18: Tracking tag database created OK<br>";

unlink (glob("$_data_path/*.snd"));
print "Step 12 of 18: All daily mail queue files deleted<br>";

unlink ("$_data_path/reserve.lst");
print "Step 13 of 18: Reserved e-mail address list initialized OK<br>";

unlink ("$_data_path/ban.lst");
print "Step 14 of 18: Ban list initialized OK<br>";

unlink ("$_data_path/sig1.sig");
unlink ("$_data_path/sig2.sig");
unlink ("$_data_path/sig3.sig");
print "Step 15 of 18: Signatures initialized OK<br>";

unlink ("$_data_path/ad1.ad");
unlink ("$_data_path/ad2.ad");
unlink ("$_data_path/ad3.ad");
print "Step 16 of 18: Adverts initialized OK<br>";

unlink ("$_data_path/unsub.txt");
open (FILE, ">$_data_path/unsub.txt");
print FILE "Thank you for using our autoresponder. This is confirmation that you have unsubscribed and will not receive any more messages.";
close FILE;
print "Step 17 of 18: Unsubscribe e-mail confirmation text initialized OK<br>";

unlink (glob("$_data_path/*.pln"));
unlink (glob("$_data_path/*.htm"));
unlink (glob("$_data_path/*.queue"));
print "Step 18 of 18: Mail queue initialized OK<br>";
print "</font></p>\n";

print "<p><font face='Verdana,Arial,Helvetica' size='2'>The installation procedure has completed successfully.</font> <font face='Verdana,Arial,Helvetica' size='2' color='#FF0000'>Now delete the file <strong>install.pl</strong>.</font></p>\n";
print "<p align='center'><font face='Verdana,Arial,Helvetica' size='3'><a href='$cgi_dir/arplus.pl'>Click here to run AutoResponse Plus</a></font></p>\n";
print "<hr noshade size='1' color='#000080'>\n";
print "<p><font face='Verdana,Arial,Helvetica' size='1'>© Copyright Gobots Internet Solutions, 2001. All rights reserved.<br>\n";
print "<a href='http://www.autoresponseplus.com'>http://www.autoresponseplus.com</a></font></p>\n";
print "</body>\n";
print "</html>";

exit;
