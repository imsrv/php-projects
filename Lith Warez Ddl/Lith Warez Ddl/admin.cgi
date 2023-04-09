#!/usr/bin/perl

#############################################################
#										#
# Leave this in please or i will be offended			#
# This script was made for				#
#										#
# The script was fully planned and made by occy (G.Ockwell) #
# 										#
#############################################################
#					#					#
# Version 1.1			# Created By Grant Ockwell	#
# Made 27/8/99			# occy@caboolture.net.au	#
# Last Modified 30/8/99		# 	#
#					#					#
#############################################################
#          ALSO http://elitescripts.hypermart.net           #
#############################################################

#############################################################
# Variabals - You may edit these to suit your needs 		#
#############################################################
$mail_prog = "/usr/sbin/sendmail";
# Now what the fuck do you think this could be

$your_email = "technical\@lithwarez.com";
# I think you can work that one out for yourself

$path_to_data = "/usr/home/lithw/public_html/ddl";
# This is the path to all the data files such as que.txt and count.count etc.

$path_to_html = "/usr/home/lithw/public_html/ddl/1.html";
# This is the path to the downloads.html, thanks.html, leeched.html 

$password = "cj5yx90";
#password to log into admin

$per_page = "30";

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
if($in{'check'}){&checklinkque;}
elsif($in{'add'}){&addfile;}
elsif($in{'remove'}){&removeque;}
elsif($in{'check1'}){&checklinkdb;}
elsif($in{'remove1'}){&removedb;}
elsif($in{'edit'}){&editque;}
elsif($in{'editfinal'}){&editfinalque;}
elsif($in{'edit1'}){&editdb;}
elsif($in{'editfinal1'}){&editfinaldb;}
elsif($in{'write'}){&writehtml;}
elsif($in{'login'}){&main;}
else{&login;}

sub login {
print "content-type:text/html\n\n";
print <<DANE;
<html>
<head>
<title></title>
</head>
<body bgcolor="#000000">
<form action="admin.cgi" method="post">
<input type="hidden" name="login" value="login">
<input type="text" name="pass">
</form>
</body>
</html>
DANE

exit;
}

sub main{
print "content-type:text/html\n\n";

if($in{'pass'} ne $password){
print "WRONG PASSWORD";
exit;
}
open(DATA,"$path_to_data/que.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);
$count=@data;


print <<DANE;
<html>
<head>
<title>que</title>
</head>
<body>
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
<b>Number of Files in que</b> <font color="red">$count</font>
DANE
print "<font size=2>";
print "<form method=\"post\" action=\"admin.cgi\">\n";
print "<select name=\"user\" size=\"7\" multiple>\n";


foreach $line (@data){
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
print "<option value=\"$id\" name=\"$id\">$filename - $fileurl - $sitename - $siteurl - $email - $date - $id</option>\n";
}
print "</select></font>\n";
print "<br><input type=\"submit\" name=\"check\" value=\"check link\"> - <input type=\"submit\" name=\"add\" value=\"add file\"> - <input type=\"submit\" name=\"remove\" value=\"remove from que\"> - <input type=\"submit\" name=\"edit\" value=\"edit\">\n";
print "<p><p>";

open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data1=<DATA>;
close(DATA);
@data = reverse(@data1);
$count=@data;
print <<DANE;
<html>
<head>
<title>que</title>
</head>
<body>
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
<b>Number of Files in database</b> <font color="red">$count</font>
DANE
print "<font size=2>";
print "<form method=\"post\" action=\"admin.cgi\">\n";
print "<select name=\"user1\" size=\"7\" multiple>\n";

foreach $line (@data){
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
print "<option value=\"$id\">$filename - $fileurl - $sitename - $siteurl - $email - $date - $id</option>\n";
}
print "</select></font><br>\n";
print "<input type=\"submit\" name=\"check1\" value=\"check link\"> - <input type=\"submit\" name=\"remove1\" value=\"remove from database\"> - <input type=\"submit\" name=\"edit1\" value=\"edit\"> - <input type=\"submit\" name=\"write\" value=\"write html\">\n";
print "</form>";



}




sub checklinkque{
open(DATA,"$path_to_data/que.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

foreach $line (@data){
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'user'}){
print "Location: $fileurl\n\n";
exit;
}
}
}

sub addfile {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/que.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

foreach $line (@data){
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
	if ($id == $in{'user'}){
		open(DATA,">>$path_to_data/files.txt");
		print DATA "$filename\:\:$fileurl\:\:$sitename\:\:$siteurl\:\:$email\:\:$date\:\:$id";
		close(DATA);
  		$filename1 = $filename;
    		$id1 = $id;	
    		$xxx = 1;
	}
 }
if ($xxx){
open(QUE,">$path_to_data/que.txt");
flock QUE, 2;
foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $id1){
print QUE "";
}
else {
print QUE "$line";
}	
}
} 
close(QUE);


print <<DANE;
<html>
<head>
<title>File Added</title>
</head>
<body>
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
<h2><b>File Added</b></h2><p>
<b>$filename1</b> has been added<p>
<a href="admin.cgi"><b><i>GO BACK<i></b></a>

DANE

exit; 
}

sub removeque {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/que.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

open(QUE,">$path_to_data/que.txt");
flock QUE, 2;
foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'user'}){
print QUE ""; 
$filename1=$filename; 
$email1=$email;
}
else {print QUE "$line";}	
}
close(QUE);

open(MAIL,"|$mail_prog -t");
 print MAIL "To: $email1\n";
 print MAIL "From: $your_email\n";
 print MAIL "Subject: Link Rejected \n\n";
 print MAIL "Dear Sir, your Submition to Lithwarez's DL ARCHIVE Ddlz was rejected. You probbably\ndid something wrong. If you feel that you would like to retry, please do so. \nThanks.\n\n";
 print MAIL "\n\n";
close (MAIL);


print <<DANE;
<html>
<head>
<title>File Deleted</title>
</head>
<body>
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
<h2><b>File Deleted</b></h2><p>
<b>$filename1</b> has been deleted from the que
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a><hr>
$in{'user'}
DANE

exit;
}

sub checklinkdb{
open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

foreach $line (@data){
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'user1'}){
print "Location: $fileurl\n\n";
exit;
}
}
}

sub removedb {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

open(QUE,">$path_to_data/files.txt");
flock QUE, 2;
foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'user1'}){print QUE ""; $filename1=$filename;}
else {print QUE "$line";}	
}
close(QUE);
print <<DANE;
<html>
<head>
<title>File Deleted</title>
</head>
<body>
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
<h2><b>File Deleted</b></h2><p>
<b>$filename1</b> has been deleted from the database
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a>

DANE

exit;
}

sub editque {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/que.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'user'}){
print <<DANE;
<html>
<head>
<title>Edit</title>
</head>
<body>
<form action="admin.cgi" method="post">
File Name:<input type="text" name="filename" value="$filename"><br>
File Url:<input type="text" name="fileurl" value="$fileurl"><br>
Site Name:<input type="text" name="sitename" value="$sitename"><br>
Site Url:<input type="text" name="siteurl" value="$siteurl"><br>
Email:<input type="text" name="email" value="$email"><br>
Date Added:<input type="text" name="date" value="$date"><br>
<input type="hidden" name="id" value="$id">
<input type="submit" name="editfinal" value="Save info">
</form>
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a>

DANE
exit;
}
}

}

sub editfinalque {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/que.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

open(QUE,">$path_to_data/que.txt");
flock QUE, 2;
foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'id'}){
print QUE "$in{'filename'}::$in{'fileurl'}::$in{'sitename'}::$in{'siteurl'}::$in{'email'}::$in{'date'}::$in{'id'}"; 
$filename1=$filename; 
}
else {print QUE "$line";}	
}
close(QUE);


print <<DANE;
<html>
<head>
<title>Edit</title>
</head>
<body>
<b>$filename1</b><br>
has been edited while in the que.
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a>

DANE
exit;
}

sub editdb {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'user1'}){
print <<DANE;
<html>
<head>
<title>Edit</title>
</head>
<body>
<form action="admin.cgi" method="post">
File Name:<input type="text" name="filename" value="$filename"><br>
File Url:<input type="text" name="fileurl" value="$fileurl"><br>
Site Name:<input type="text" name="sitename" value="$sitename"><br>
Site Url:<input type="text" name="siteurl" value="$siteurl"><br>
Email:<input type="text" name="email" value="$email"><br>
Date Added:<input type="text" name="date" value="$date"><br>
<input type="hidden" name="id" value="$id">
<input type="submit" name="editfinal1" value="Save info">
</form>
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a>
DANE
exit;
}
}

}

sub editfinaldb {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

open(QUE,">$path_to_data/files.txt");
flock QUE, 2;
foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $in{'id'}){
print QUE "$in{'filename'}::$in{'fileurl'}::$in{'sitename'}::$in{'siteurl'}::$in{'email'}::$in{'date'}::$in{'id'}"; 
$filename1=$filename; 
}
else {print QUE "$line";}	
}
close(QUE);


print <<DANE;
<html>
<head>
<title>Edit</title>
</head>
<body>
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
<b>$filename1</b><br>
has been edited while in the data base.
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a>
DANE
exit;
}

sub writehtml {
print "content-type:text/html\n\n";
open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data1=<DATA>;
close(DATA);
@data = reverse(@data1);
@file=@data;
$count=@file;
$a=0;
$b=0;
while (@data) {
open(HTML,">$path_to_html/downloads$a.html"); 
flock HTML, 2;
&header;
print HTML <<DANE;
<div align="center"><center>
<table BORDER=0 CELLSPACING=1 CELLPADDING=2 WIDTH="100%" BGCOLOR="#000000" align="center">
<tr BGCOLOR="#FFFFFF"> 
<td><b><i><font face="Arial,Helvetica">FILE NAME:</font></i></b></td>
<td><b><i><font face="Arial,Helvetica">Date Added:</font></i></b></td>
<td><b><i><font face="Arial,Helvetica">Provider:</font></i></b></td>
<td><b><i><font face="Arial,Helvetica">Please Vote:</font></i></b></td>
</tr>
DANE

$perpage=$per_page - 1;

for ($i = 0; $i <= $perpage; $i++) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/,$file[$b]);
$b++;

if(length($filename)==0){$filename="<\/a><center>-<\/center>";}
if(length($date)==0){$date="<center>-<\/center>";}
if(length($sitename)==0){$sitename="<\/a><center>-<\/center>";}

if($date =~ /100/){
($day,$month,$year)=split(/\//,$date,3);
$year=$year+1900;
$date="$day/$month/$year";
}

print HTML <<DANE;
<tr BGCOLOR="#FFFFFF"> 
<td><b><font face="Arial,Helvetica"size=-1><a href="dont-rip.cgi?$id">$filename</a></font></b></td><td> 
<center><font face="Arial,Helvetica" size=-1>$date</font></center></td>
<td><b><font face="Arial,Helvetica" size=-1><a href="$siteurl">$sitename</a></font></b></td>
<td><center><font face="Arial,Helvetica" font size=-1><a href="http://www.t100.to/cgi-bin/top/topsites.cgi?downloadcom">ENABLE DLZ</a></font></center></td>
</tr>
DANE
shift(@data);

}
$a++;
print HTML "</TABLE></div><font face=\"arial\" size=\"1\">";
if(!-e "downloads$a.html"){print HTML "";}
else {print HTML "<a href=\"downloads$a.html\"><font size=\"3\"><b>Next</a> Page</b></font>";}
print HTML " - Total Files:<font color=red>$count</font></font></center><p>";
&footer;

close(HTML);

}

print <<DANE;
<html>
<head>
<title>Done</title>
</head>
<body>
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
<b>download.html</b><br>
has been re-wrote with all new files in the db.
<p><a href="downloads0.html" target="_blank"><b><i>GO SEE<i></b></a>
<p><a href="admin.cgi"><b><i>GO BACK<i></b></a>

DANE


exit;
}



sub footer {
open (footer, "<$path_to_data/footer.txt");
flock footer, 2;
@footer=<footer>;
close(footer);
	foreach $footer(@footer) {
print HTML "$footer\n";
}
print HTML "<p><div align=\"center\"><font face=\"arial\" size=\"1\"><small>All cgi done by <a href=\"mailto:occy\@caboolture.net.au\">Occy</a>, Email for custom scripts";

}
sub header {
open (header,"$path_to_data/header.txt");
flock header, 2;
@header=<header>;
close(header);
foreach $header(@header) {
print HTML "$header\n";
}
}