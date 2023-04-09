#!/usr/bin/perl

#############################################################
#										#
# Leave this in please or i will be offended			#
# This script was made for 	#
#										#
# The script was fully planned and made by occy (G.Ockwell) #
# 										#
#############################################################
#					#					#
# Version 1.0			# Created By Grant Ockwell	#
# Made 27/8/99			# occy@caboolture.net.au	#
# Last Modified 30/8/99		# http://www.lithwarez.com	#
#					#					#
#############################################################
#          ALSO http://elitescripts.hypermart.net           #
#############################################################


#############################################################
# Variabals - You may edit these to suit your needs 		#
#############################################################
$path_to_data = "/usr/home/lithw/public_html/ddl";
# This is the path to all the data files such as que.txt and count.count etc.

#############################################################
# End of Variabals - You can go on if you want			#
#############################################################

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $fields{$name} = $fields{$name}.",".$value; }
	else { $in{$name} = $value; }
}


($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst)=localtime(time);
$mon++;
$year=$year+1900;
$in{'date'}="$mday/$mon/$year";


&check;

open(COUNT,"$path_to_data/count.count");
flock COUNT, 2;
$count=<COUNT>;
close(COUNT);
$count++;
open(COUNT,">$path_to_data/count.count");
flock COUNT, 2;
print COUNT "$count";
close(COUNT);

open(DATA,">>$path_to_data/que.txt");
flock DATA, 2;
print DATA "$in{'filename'}::$in{'fileurl'}::$in{'sitename'}::$in{'siteurl'}::$in{'email'}::$in{'date'}::$count\n";
close(DATA);

print "Location: thanks.html\n\n";

sub check{
@errors=("You need to enter your email.",
	   "Invalid email address. Please go back and fix it.",
    	   "Do not use weird symbols in the email feild",
         "You need to enter the name of the file",
         "Do not use weird symbols in the name of file feild",
         "You need to enter in the url of the file",
         "You enterd a invalid url",
         "Do not use weird symbols in the url of the file",
         "Do not use weird symbols in the website url feild",
         "Do not use wierd symbols in the website name feild");
         
if (!$in{'email'}){&error("@errors[0]");}
if ($in{'email'} !~ /@/){&error("@errors[1]");}
if ($in{'email'} =~ /(\;|\>|\<)/){&error("@errors[2]");}
if (!$in{'filename'}){&error("@errors[3]");}
if ($in{'filename'} =~ /(\;|\>|\<)/){&error("@errors[4]");}
if (!$in{'fileurl'}){&error("@errors[5]");}
if ($in{'fileurl'} !~ /\./){&error("@errors[6]");}
if ($in{'fileurl'} =~ /(\;|\>|\<)/){&error("@errors[7]");}
if ($in{'sitename'} =~ /(\;|\>|\<)/){&error("@errors[9]");}
if ($in{'siteurl'} =~ /(\;|\>|\<)/){&error("@errors[8]");}

}

sub error{
print "content-type:text/html\n\n";

print <<DANE;
<html>
<head>
<title>Error</title>
</head>
<!-- Begin Total CPM Affiliates NetWork Code -->
<BR><P><CENTER><IFRAME SRC="http://209.15.30.190/cpm_affiliates/exchange/ads.cgi?iframe;member=cgipromote" MARGINWIDTH=0 MARGINHEIGHT=0 HSPACE=0 VSPACE=0 FRAMEBORDER=0 SCROLLING=NO WIDTH=468 HEIGHT=60><SCRIPT LANGUAGE="JavaScript"><!--
random = parseInt(Math.random()*1000)
banner = '<A HREF="http://209.15.30.190/cpm_affiliates/exchange/ads.cgi?member=cgipromote;banner=NonSSI;'
banner += 'page=' + random + '" TARGET="_top">';
banner += '<IMG SRC="http://209.15.30.190/cpm_affiliates/exchange/ads.cgi?member=cgipromote;'
banner += 'page=' + random + '" WIDTH=468 HEIGHT=60'
banner += ' ALT="Click here to visit a sponsor" BORDER=0></A>'
document.write(banner)
// --></SCRIPT><NOSCRIPT><A HREF="http://209.15.30.190/cpm_affiliates/exchange/ads.cgi?member=cgipromote;banner=NonSSI;page=01" TARGET="_top"><IMG SRC="http://209.15.30.190/cpm_affiliates/exchange/ads.cgi?member=cgipromote;page=01" WIDTH=468 HEIGHT=60 ALT="Click here to visit a sponsor" BORDER=0></A></NOSCRIPT></IFRAME><BR><SMALL>Click here to visit a sponsor</SMALL></CENTER>
<BR><!-- End Total CPM Affiliates NetWork Code -->
<body>
<h2><b>Error</b></h2><p>
$_[0]
</body>
</html>
DANE

exit;
}


