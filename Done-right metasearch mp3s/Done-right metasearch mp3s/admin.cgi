#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/metasearch/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# MetaSearch by Done-Right Scripts
# Admin Script
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# None of the code below needs to be edited below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2000 Done-Right. All rights reserved.


###############################################
#Read Input
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		$value =~ s/<([^>]|\n)*>//g;
		$FORM{$name} = $value;
	}
}
###############################################


###############################################
#Logics
if ($FORM{'tab'} eq "login") { &login; }
elsif ($FORM{'tab'} eq "config") { &config; }
elsif ($FORM{'tab'} eq "update") { &update; }
elsif ($FORM{'tab'} eq "startupdate") { &startupdate; }
elsif ($FORM{'tab'} eq "setconfig") { &setconfig; }
elsif ($FORM{'tab'} eq "download") { &download; }
else { &main; }
###############################################


###############################################
sub getversions {
	$version{'Web'} = "1.0";
	$version{'Auctions'} = "1.0";
	$version{'Books'} = "1.0";
	$version{'Electronics'} = "1.0";
	$version{'Forums'} = "1.0";
	$version{'Hardware'} = "1.0";
	$version{'Jobs'} = "1.0";
	$version{'MP3s'} = "1.0";
	$version{'Music'} = "1.0";
	$version{'News'} = "1.0";
	$version{'Software'} = "1.0";
	$version{'Toys'} = "1.0";
	$version{'Videos'} = "1.0";
}
###############################################


###############################################
#Main
sub main {
if (-e "${path}config/config.cgi") {
print "Content-type: text/html\n\n";
$nolink=1;
&header;
print <<EOF;
<font face="verdana" size="-1"><B>Please enter your Registration Code:</B><P>
<form METHOD="POST" ACTION="admin.cgi?tab=login">
Registration Code:&nbsp;<input type=text name=user size=45><BR>
<input type=submit value="Login">
</form>
</font>
EOF
&footer;
exit;
} else {
$created=1;
&config;
}
}
###############################################


###############################################
#Security Check
sub checklogin {
	require "${path}config/config.cgi";
	$mods = $config{'mods'};
	if ($mods =~ /\|/) {
		@modules = split(/\|/, $mods);
		foreach (@modules) {
			$modreg = $modules[$mr];
			if ($FORM{'user'} eq $config{$modreg}) {
				$verified=1;
				$sm = $modreg;
				last;
			}
			$mr++;
		}
	} else {
		if ($FORM{'user'} eq $config{$mods}) {
			$verified=1;
			$sm = $mods;
		}
	}
	unless ($verified) {
		print "Content-type: text/html\n\n";
		$nolink=1;
		&header;
		print "Access Denied";
		&footer;
		exit;
	}
}
###############################################


###############################################
#Login Area
sub login {
&checklogin;
print "Content-type: text/html\n\n";
$nolink=1;
&header;
print <<EOF;
<center><font face="verdana" size="-1"><B><U>Main</U></B></font><P>
<table width=70% border="0" cellspacing="0" cellpadding="0"><tr><td>
<center><font face="verdana" size="-1">Welcome to your personal admin section for your script.  The admin section lets you easily take control over your script.  Please choose from a link below to begin:<P>
</td></tr></table>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.cgi?tab=config&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Configure Variables</a></td>
<td width="65%"><font face="verdana" size="-1">Set admin password among other variables to run the script.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.cgi?tab=update&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Update</a></td>
<td width="65%"><font face="verdana" size="-1">Receive automatic installation of updated files with just a click of a button.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.cgi?tab=download&file=metasearch&user=$FORM{'user'}&searchmod=$FORM{'searchmod'}">Download</a></td>
<td width="65%"><font face="verdana" size="-1">Download the scripts zip file.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="http://www.done-right.net/cgi-bin/members/support.cgi?file=metasearch&user=$FORM{'user'}&url=$url">Support</a></td>
<td width="65%"><font face="verdana" size="-1">Obtain support for your scripts via your usermanual, email or FAQ.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="http://www.done-right.net/cgi-bin/members/feedback.cgi?file=metasearch&user=$FORM{'user'}&url=$url">Feedback</a></td>
<td width="65%"><font face="verdana" size="-1">Send us testimonials about this script and we will put a link to your site on done-right.net</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="http://www.done-right.net/cgi-bin/orderadd.cgi?file=metasearch&user=$FORM{'user'}">Order Addons</a></td>
<td width="65%"><font face="verdana" size="-1">Purchase addons for your metasearch such as extra engines.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
<center><font face="verdana" size="-1" color="#000066"><B>Other Options</B></font></center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Customize Templates</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the look of your metasearch engine by editting html code.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.cgi?tab=settings&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Settings</a></td>
<td width="65%"><font face="verdana" size="-1">Set default settings and other configurations.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&footer;
}
###############################################


###############################################
#Variable Configuration
sub config {
if ($created == 1) {
	$verified = 1;
	$nolink=1;
	$unix = "CHECKED";
} else {
	&checklogin;
	if ($config{'server'} eq "nt") { $nt = "CHECKED"; }
	else { $unix = "CHECKED"; }
	$def = $config{'default'};
	$regcode = $config{$def};
}
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Variable Configuration</U></b><P>
<form METHOD="POST" ACTION="admin.cgi?tab=setconfig&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">
<input type=hidden name=created value="$created">
EOF

$mods="";
opendir(FILE, "${path}.");
while ($myfile = readdir(FILE)) {
	$line=telldir(FILE);
	unless ($myfile =~ /\./ || $myfile eq "config") {
		if (-e "${path}$myfile/template/$myfile.cgi") {
			$filver = "${myfile}version";
			unless ($created == 1) {
				if ($config{$myfile}) {
					$$myfile=$config{$myfile};
					$$filver=$config{$filver};
				} else {
					$$filver="new";
				}
			}
			if ($mods eq "") { $mods .= "$myfile"; } else { $mods .= "|$myfile"; }
			print "<input type=hidden name=$filver value=$$filver>";
		}
	}
}
closedir(FILE);
print <<EOF;
<table width=90% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td width=60%><font face=verdana size=-1>Registration Code:&nbsp;</td>
<td width=40%><input type=text name=regcode size=45 value=\"$regcode\"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Server Type:&nbsp;</td>
<td width=40%><font face="verdana" size="-1">Unix:<INPUT TYPE="radio" NAME="server" VALUE="unix" $unix>&nbsp;&nbsp;NT:<INPUT TYPE="radio" NAME="server" VALUE="nt" $nt></td></tr>
EOF
if ($mods =~ /\|/) {
	$default = $config{'default'};
print "
<tr><td width=60%><font face=verdana size=-1>Default Search Type:&nbsp;</td>
<td width=40%><select NAME=\"default\" SIZE=\"1\"><option SELECTED>$default";
	@newmods = split(/\|/, $mods);
	foreach $new(@newmods) {
		chomp($new);
		unless ($new eq $default) {
			print "<option>$new";
		}	
	}
	print "</select></td></tr>";
} else { print "<input type=hidden name=default value=\"$mods\">"; }
print <<EOF;
</table>
</td></tr></table>
</td></tr></table><BR>
<input type=hidden name=mods size=45 value="$mods">
<input type=submit value="Set Configuration">
</form>
<P></font>
EOF
&footer;
exit;
}
###############################################


###############################################
sub standard {
	unless (-e "${path}$new/cache") { mkdir("${path}$new/cache", 0777) || ($error .= "Create Directory: $new/cache<BR>"); }
}
###############################################


###############################################
sub standard2 {
unless ($FORM{'server'} eq "nt") {
	chmod (0777,"$new/cache") || ($error .= "Chmod Directory 777: $new/cache<BR>");
	chmod (0777,"$new/template") || ($error .= "Chmod Directory 777: $new/template<BR>");
}
	open (FILE, ">${path}$new/template/categories.txt");
	if ($new eq "Auctions") {
print FILE <<EOF;
Antiques|Folk Art|Instruments
Automobiles|Car Audio|Car Parts
Coins and Stamps|US Coins|US Stamps
Collectibles|Dolls|Jewelry
Electronics|Computers|Television
Movies|DVD|VHS
Music|Sheet Music|Tapes
Sports|Racket Sports|Water Sports
Toys|Action Figures|Beanbags
EOF
	} elsif ($new eq "Books") {
print FILE <<EOF;
Art|Fashion|Photography
Business|Accounting|Finance
Computers|Programming|Software
Food|Baking|Diet
Entertainment|Movies|Music
Reference|Encyclopedias|Education
Science|Astronomy|Physics
Sports|Football|Hockey
Travel|Africa|Europe
EOF
	} elsif ($new eq "Electronics") {
print FILE <<EOF;
Cameras|Camcorders|Projectors
Communication|CB Radios|Phones
Gadgets|Calculators|Telescopes
Handhelds|Handheld PCs|Palm
Home Audio|CD Player|Speakers
Home Theater|DVD Player|TV
Music|Digital Drums|Keyboards
Portable Music|Boombox|MP3 Player
Printers|Ink Jet|Laser Printer
EOF
	} elsif ($new eq "Web" || $new eq "Forums") {
print FILE <<EOF;
Business|Investing|Jobs
Computers|Internet|Software
Entertainment|Movies|Music
Games|Video Games|Roleplaying
News|Newspapers|Weather
Reference|Encyclopedias|Education
Shopping|Automobiles|Clothing
Sports|Football|Hockey
Travel|Food|Recreation
EOF
	} elsif ($new eq "Hardware") {
print FILE <<EOF;
Accessories|Keyboard|Mouse
CD Drives|DVD|Writable
Memory|64 MB Ram|128 MB Ram
Monitors|17 Monitors|19 Monitors
Multimedia|Microphones|MP3 Player
Networking|Ethernet|USB Hubs
Scanners|Flatbed Scanners|OCR Scanners
Sound|Sound Blaster|Speakers
Storage|Floppy Drives|Hard Drives
EOF
	} elsif ($new eq "News") {
print FILE <<EOF;
Business|Investing|Jobs
Computers|Internet|Software
Education|High School|University
Entertainment|Movies|Music
Health|Disease|Medicine
Politics|Election|Taxes
Sports|Football|Hockey
Travel|Food|Recreation
World|Natural Disaster|War
EOF
	} elsif ($new eq "Jobs") {
print FILE <<EOF;
Accounting|Consumer Banking|Tax Management
Advertising|Copywriter|Public Relations
Educator|Teacher|Trainer
Engineer|Industrial Engineer|Stuctural Engineer
Health Care|Nurse|Therapist
Manufacturing|Plant Management|Warehouse Management
Retail|Buyer|Sales Management
Sales|Client Services|Telemarketing
Technology|Programmer|Systems Engineer
EOF
	} elsif ($new eq "Music" || $new eq "MP3s") {
print FILE <<EOF;
Alternative|Industrial|Punk
Blues|Acoustic|Rock
Classical|Piano|Symphonic
Country|Bluegrass|New Country
Rap|East Side|West Side
Latin|Rock En Espanol|Salsa
Metal|Gothic|Heavy Metal
Pop|Psychedelic|Acoustic
World|Folk|Reggae
EOF
	} elsif ($new eq "Software") {
print FILE <<EOF;
Business|Accounting|Office
Child Software|Eductional|Kids Games
Communication|E-mail|Fax
Games|Action Games|Strategy Games
Graphics|Animation|Clip Art
Networking|Firewalls|Netware
Programming|Database|Development Tools
Utilities|Anit-Virus|Internet Tools
Web Development|Web Browsers|Web Design
EOF
	} elsif ($new eq "Videos") {
print FILE <<EOF;
Action|Criminal Activity|War
Comedy|British Comedy|Teen Comedy
Disney|Mickey Mouse|Goofy
Documentary|Ancient World|Space Exploration
Drama|Crime|Romance
Horror|Ghosts|Vampires
Family|Animation|Dinosaurs
Sports|Basketball|Wrestling
Western|Cowboys|Musicals
EOF
	}
	close(FILE);

	open (FILE, ">${path}$new/template/defaults.txt");
	print FILE "CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED||||\n";
	print FILE "10|2|5|54||||8|\n";
	print FILE "CHECKED|CHECKED|CHECKED|CHECKED\n";
	print FILE "CHECKED|CHECKED|CHECKED|CHECKED\n";
	print FILE "||CHECKED||||CHECKED||CHECKED";
	close(FILE);

	unless ($new eq "Web") {
		open (FILE, ">${path}$new/template/affiliate.txt");
		close (FILE);
		unless ($FORM{'server'} eq "nt") {
			chmod (0777,"$new/template/affiliate.txt") || ($error .= "Chmod File 777: $new/template/affiliate.txt<BR>");
		}
	}
	unless ($FORM{'server'} eq "nt") {
		chmod (0777,"$new/template/categories.txt") || ($error .= "Chmod File 777: $new/template/categories.txt<BR>");
		chmod (0777,"$new/template/defaults.txt") || ($error .= "Chmod File 777: $new/template/defaults.txt<BR>");
		chmod (0777,"$new/template/$new.cgi") || ($error .= "Chmod File 777: $new/template/$new.cgi<BR>");
		chmod (0777,"$new/template/searchstart.txt") || ($error .= "Chmod File 777: $new/template/searchstart.txt<BR>");
		chmod (0777,"$new/template/searchresults.txt") || ($error .= "Chmod File 777: $new/template/searchresults.txt<BR>");
	}
}
###############################################


###############################################
#Write to config.cgi
sub setconfig {
print "Content-type: text/html\n\n";
if ($FORM{'created'} == 1) { $nolink=1; }
&header;
@newmods = split(/\|/, $FORM{'mods'});
if ($FORM{'created'} == 1) {
#Create and chmod directories and files
unless (-e "${path}config") { mkdir("${path}config", 0777) || ($error .= "Create Directory: config<BR>"); }

foreach $new(@newmods) {
	chomp($new);
	&standard;
}

unless ($error) {
foreach $new(@newmods) {
	chomp($new);
	&standard2;
}
unless ($FORM{'server'} eq "nt") {
chmod (0777,"config") || ($error .= "<BR>Chmod Directory 777: config<BR>");
}
open(FILE, ">${path}config/config.cgi");
close (FILE);
unless ($FORM{'server'} eq "nt") {
chmod (0777,"config/config.cgi") || ($error .= "Chmod File 777: config/config.cgi<BR>");
chmod (0755,"LWP/Parallel/UserAgent.pm") || ($error .= "Chmod File 755: LWP/Parallel/UserAgent.pm<BR>");
chmod (0755,"LWP/Parallel/Protocol.pm") || ($error .= "Chmod File 755: LWP/Parallel/Protocol.pm<BR>");
chmod (0755,"LWP/Parallel/Protocol/http.pm") || ($error .= "Chmod File 755: LWP/Parallel/Protocol/http.pm<BR>");
chmod (0755,"metasearch.cgi") || ($error .= "Chmod File 755: metasearch.cgi<BR>");
chmod (0755,"customize.cgi") || ($error .= "Chmod File 755: customize.cgi<BR>");
chmod (0755,"settings.cgi") || ($error .= "Chmod File 755: settings.cgi<BR>");
}
} else {
$errmess = "Please Create the following directories and then run the configuration again.";
}

$def = $FORM{'default'};
$user2 = $FORM{$def};
#LWP modules
use LWP::UserAgent;
$url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
$search = "http://www.done-right.net/cgi-bin/siteurl.cgi?siteurl=$url&regcode=$user2";
my $ua = new LWP::UserAgent;
my $request = new HTTP::Request 'GET', $search;
my $response = $ua->request ($request);
$response_body = $response->content();
$resultid = $response_body;

} else {
&checklogin;
foreach $new(@newmods) {
	chomp($new);
	$filver = "${new}version";
	if ($FORM{$filver} eq "new") {
		&standard;
		unless ($error) {
			&standard2;
		} else {
			$errmess = "Please Create the following directories and then run the configuration again.";
		}
	}
}
}

$mods = "@newmods";
open(FILE, ">${path}config/config.cgi");
print FILE <<EOF;

\$config{'default'} = "$FORM{'default'}";
\$config{'mods'} = "$FORM{'mods'}";
EOF

&getversions;
foreach $new(@newmods) {
	chomp($new);
	$mods = $new;
	$modsver = "${mods}version";
	if ($FORM{$modsver} eq "" || $FORM{$modsver} eq "new") { $FORM{$modsver} = "$version{$mods}" }
print FILE <<EOF;
\$config{'$mods'} = "$FORM{$mods}";
\$config{'$modsver'} = "$FORM{$modsver}";
EOF
}
print FILE <<EOF;
\$config{'server'} = "$FORM{'server'}";
1;
EOF
close (FILE);
$def = $FORM{'default'};
$user = $FORM{'regcode'};
if ($error) {
print <<EOF;
<center><font face="verdana" size="-1"><B><U>Error</U></B></font><P>
<font face="verdana" size="-1">
EOF
if ($errmess) {
print "$errmess<BR>";
} else {
print "There was an error in the installation.  Please do the folowing manually and then login.  If you have problems logging in, please run the configuration again.<BR>";
}
print <<EOF;
$error
<form METHOD="POST" ACTION="admin.cgi?tab=login&file=metasearch&searchmod=$FORM{'searchmod'}">
Registration Code:&nbsp;<input type=text name=user size=45 value="$user"><BR>
<input type=submit value="Login">
</form>
</font>
EOF
} else {
print <<EOF;
<center><font face="verdana" size="-1"><B><U>Variables Successfully Configured.  Please Re-Login:</U></B></font><P>
<form METHOD="POST" ACTION="admin.cgi?tab=login&file=metasearch&searchmod=$FORM{'searchmod'}">
Registration Code:&nbsp;<input type=text name=user size=45 value="$user"><BR>
<input type=submit value="Login">
</form>
</font>
EOF
}

&footer;
exit;
}
###############################################


###############################################
#Auto-Update
sub update {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$mods = $config{'mods'};
@modules = split(/\|/, $mods);
foreach (@modules) {
	$mods = $modules[$mt];
	$$mods = $config{$mods};
	$modsver = "${mods}version";
	$$modsver = $config{$modsver};
	$version[$mt] = "$modsver";
	$update[$mt] = $$modsver;
	$mt++;
}

&getpage;
foreach (@result) {
	$version[$p] =~ s/version//;
	chomp($result[$p]);
	$fil = $version[$p];
	$res = $result[$p];
	if ($result[$p] > $update[$p]) {
$display[$p] = "
<tr>
<td WIDTH=\"40%\" bgcolor=\"#CCCCCC\"><font face=\"verdana\" size=\"-1\">$version[$p].cgi</td>
<td WIDTH=\"60%\" bgcolor=\"#CCCCCC\"><B><font face=\"verdana\" size=\"-1\" color=\"red\">Update Available</B><input type=hidden name=$fil value=\"$res\"><BR></td></tr>";
	} else {
$display[$p] = "
<tr>
<td WIDTH=\"40%\" bgcolor=\"#CCCCCC\"><font face=\"verdana\" size=\"-1\">$version[$p].cgi</td>
<td WIDTH=\"60%\" bgcolor=\"#CCCCCC\"><B><font face=\"verdana\" size=\"-1\">Latest Version Installed</B><BR></td></tr>";
	}
$p++;
}
print <<EOF;
<font face="verdana" size="-1"><B><U>Auto-Update</U></b><P>
<form METHOD="POST" ACTION="admin.cgi?tab=startupdate&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">
<table width=50% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
EOF
foreach (@display) {
	print "$display[$g]";
	$g++;
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR><input type=submit value="Update">
</form>
</font>
EOF
&footer;
exit;	
}
###############################################


###############################################
#Get Updated Data
sub startupdate {
&checklogin;
#LWP modules
use LWP::UserAgent;
$mods = $mods2 = $config{'mods'};
@modules = split(/\|/, $mods);
foreach (@modules) {
	$mods = $modules[$mt];
	$modsver = "${mods}version";
	if ($FORM{$mods} ne "") {
		$moduser = $config{$mods};
		@reg = split(/\-/, $moduser);
		$reg1=$reg[0];
		$reg2=$reg[1];
		$reg3=$reg[2];
		$fil = "$mods";
		$res1=$FORM{$mods};
		chomp($res1);
		&updatefile;
	} else {
		$res1 = "$config{$modsver}";
		chomp($res1);
	}
	$mt++;
} #end foreach statement

sub updatefile {
$search = "http://www.done-right.net/cgi-bin/update/update.cgi?reg1=$reg1&reg2=$reg2&reg3=$reg3&file=$fil";
my $ua = new LWP::UserAgent;
my $request = new HTTP::Request 'GET', $search;
my $response = $ua->request ($request);
$response_body = $response->content();
$result = $result2 = $response_body;
chomp($result2);
if ($result2 eq "error") {
	$message .= "$fil.cgi was not updated due to an error<BR>";	
} else {
$onefound=1;

open (FILE, ">${path}$mods/template/$fil.cgi");
print FILE <<EOF;
$result
EOF
close(FILE);
$message .= "$fil.cgi Successfully Updated<BR>";
}
}	

if ($onefound) {
open (FILE, ">${path}config/config.cgi");
print FILE <<EOF;

\$config{'default'} = "$config{'default'}";
\$config{'mods'} = "$mods2";
EOF
foreach (@modules) {
	$mods = $modules[$mi];
	$modsver = "${mods}version";
print FILE <<EOF;
\$config{'$mods'} = "$config{$mods}";
\$config{'$modsver'} = "$res1";
EOF
	$mi++;
}
print FILE <<EOF;
\$config{'server'} = "$config{'server'}";
1;
EOF
close(FILE);
}

&display;
}
###############################################


###############################################
#Check For Updates
sub getpage {
#LWP modules
use LWP::UserAgent;
@reg = split(/\-/,$FORM{'user'});
$reg1=$reg[0];
$reg2=$reg[1];
$reg3=$reg[2];
foreach(@version) {
$ver=$version[$t];
$search = "http://www.done-right.net/cgi-bin/update/update.cgi?reg1=$reg1&reg2=$reg2&reg3=$reg3&file=$ver";
my $ua = new LWP::UserAgent;
my $request = new HTTP::Request 'GET', $search;
my $response = $ua->request ($request);
$response_body = $response->content();
$result[$t] = $response_body;
$t++;
}	
}
###############################################


###############################################
#Print Success Messages
sub display {
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B>
$message
</b></font>
EOF
&footer;
exit;
}
###############################################


###############################################
#Download
sub download {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<center><font face="verdana"><B><U>Download</U></B></font><P></CENTER>
<center><font face="verdana" size="-1">Please Choose the file you wish to download:</font><P></CENTER>
<font face="verdana" size="-1">
EOF
require "${path}config/config.cgi";
$mods=$config{'mods'};
@modules = split(/\|/, $mods);
foreach $line3(@modules) {
	$modfile=$config{$line3};
	print "<a href=http://www.done-right.net/cgi-bin/members/download.cgi?file=metasearch&user=$modfile&url=$url>$line3 Search</a><BR>";
}
print "<BR><BR>";
&footer;
exit;	
}
###############################################


###############################################
#Header HTML
sub header {
print <<EOF;
<html>
 <head>
 
 <title>Admin Area</title>
 <style>
 <!--
 BODY      {font-family:verdana;}
 A:link    {text-decoration: underline;  color: #000099}
 A:visited {text-decoration: underline;  color: #000099}
 A:hover   {text-decoration: none;  color: #000099}
 A:active  {text-decoration: underline;  color: #000099}
 -->
 </style> 
 <body text="#000000" bgcolor="#333333" link="#000099" vlink="#000099" alink="#000099">
 
 <!-- start top table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td width="1"><img SRC="http://www.done-right.net/images/place.gif" height=1 width=5></td>
 
 <td><img SRC="http://www.done-right.net/images/place.gif" height=5 width=1></td>
 
 <td width="1"><img SRC="http://www.done-right.net/images/place.gif" height=1 width=5></td> </tr>
 
 <tr>
 <td width="10%"><img SRC="http://www.done-right.net/images/place.gif" height=1 width=5></td>
 
 <td>
 
 <!-- start logo table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=2 WIDTH="100%" BGCOLOR="#000066" >
 <tr>
 <td width="15%">
<img src="http://www.done-right.net/images/smalllogo.gif" ALT="Done-Right Scripts" WIDTH="130" HEIGHT="83">
</td>
 <td valign=bottom><center><img src="http://www.done-right.net/images/adminarea.gif" width=351 height=60></center>
 </td>
 <td width="15%">
<img src="http://www.done-right.net/images/smalllogo.gif" ALT="Done-Right Scripts" ALIGN="RIGHT" WIDTH="130" HEIGHT="83">
</td>
 </tr>
 </center></table>
 <!-- end logo table -->
 
 <!-- start border table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td><img SRC="http://www.done-right.net/images/place.gif" height=5 width=1></td>
 </tr>
 </center></table>
 <!-- end border table -->

 <!-- start home and date table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <tr><td>
EOF
$url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
unless ($nolink == 1) {
print <<EOF;
<center><font face="verdana" size="-1"><B><a href="admin.cgi?tab=login&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Main</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=config&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Configure Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=update&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}">Update</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=download&file=metasearch&user=$FORM{'user'}&searchmod=$FORM{'searchmod'}">Download</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://www.done-right.net/cgi-bin/members/support.cgi?file=metasearch&user=$FORM{'user'}&url=$url&searchmod=$FORM{'searchmod'}">Support</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://www.done-right.net/cgi-bin/members/feedback.cgi?file=metasearch&user=$FORM{'user'}&url=$url&searchmod=$FORM{'searchmod'}">Feedback</a>
<BR><font face="verdana" size="-1"><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}"><font color="white">Customize Templates</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="settings.cgi?tab=settings&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}"><font color="white">Settings</font></a>
EOF
} else {
	print "&nbsp;";
}
print <<EOF;
 </td>
 </TR>
 </TABLE></CENTER>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="http://www.done-right.net/images/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=4 COLS=1 WIDTH="100%" BGCOLOR="#FFFFFF" >
 <TR>
 <TD>
<P><BR><center>
EOF
}
###############################################


###############################################
#Footer HTML
sub footer {
print <<EOF;

 </td></tr></table>
 <TD><IMG SRC="http://www.done-right.net/images/place.gif" height=1 width=5></TD>
 </TR>
 
 <TR>
 <TD><IMG SRC="http://www.done-right.net/images/place.gif" height=1 width=5></TD>
 
 <TD>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 ADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="http://www.done-right.net/images/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <TR><TD>
 <CENTER>&nbsp;</CENTER>
 </TD>
 <TD align="center"><FONT color="#000066" FACE=verdana size="-1"><a href="http://www.done-right.net">www.done-right.net</a>
 </TD>
 </TR>
 </TABLE></CENTER>
 
 <IMG SRC="http://www.done-right.net/images/place.gif" height=5 width=1></TD>
 
 <TD><IMG SRC="http://www.done-right.net/images/place.gif" height=1 width=5></TD>
 </TR>
 
 </TABLE></CENTER>
  
 </BODY>
 </HTML>
</body></html>
EOF
}
###############################################
