#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/metasearch/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# MetaSearch by Done-Right Scripts
# Settings Script (Part of the admin)
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# None of the code below needs to be edited below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2000 Done-Right. All rights reserved.


###############################################
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		#$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		#$value =~ s/<([^>]|\n)*>//g;
		$FORM{$name} = $value;
	}
}
###############################################


###############################################
#logics
if ($FORM{'tab'} eq "categories") { &categories; }
elsif ($FORM{'tab'} eq "defaults") { &defaults; }
elsif ($FORM{'tab'} eq "setdefaults") { &setdefaults; }
elsif ($FORM{'tab'} eq "set") { &set; }
elsif ($FORM{'tab'} eq "cache") { &cache; }
elsif ($FORM{'tab'} eq "clearcache") { &clearcache; }
elsif ($FORM{'tab'} eq "affiliate") { &affiliate; }
elsif ($FORM{'tab'} eq "setaffiliate") { &setaffiliate; }
else { &settings; }
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
sub mods {
require "${path}config/config.cgi";
$mods = $config{'mods'};
@modules = split(/\|/, $mods);
$count=0;
foreach (@modules) { $count++; }
if ($FORM{'searchmod'} eq "") { $searchmod = $config{'default'}; }
else { $searchmod = $FORM{'searchmod'}; }
$gg=0;
if ($count > 1) {
	$modtitle3 = "$searchmod Search";
	$modtitle = " - <font color=red>$searchmod Search</font>";
	$modtitle2 = "for <font color=red>$searchmod</font> Search";
	$link = "<font face=verdana size=-1>Other $linktype<BR><font color=\"#000099\">$searchmod</font>";
	foreach (@modules) {
		$modreg = $modules[$gg];
		$modreg = $config{$modreg};
		unless ($searchmod eq $modules[$gg]) {
			$link .= "&nbsp;|&nbsp;<a href=\"settings.cgi?tab=$linktype2&user=$modreg&file=metasearch&searchmod=$modules[$gg]\">$modules[$gg]</A>";
		}
		$gg++;
	}
}
}
###############################################


###############################################
#Main Sub
sub settings {
&checklogin;
&mods;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Settings</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
EOF

foreach $line(@modules) {
	require "${path}$line/template/$line.cgi";
	if ($semod{'affiliate'} == 1) { $affound = 1; }
}
if ($affound) {
print <<EOF;
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.cgi?tab=affiliate&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Affiliate Codes</a></td>
<td width="65%"><font face="verdana" size="-1">Setup your affiliate ids to earn money through the search results.</font></td>
</tr>
EOF
}

print <<EOF;
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.cgi?tab=categories&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Add Categories</a></td>
<td width="65%"><font face="verdana" size="-1">Create your own search categories.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.cgi?tab=defaults&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Set Defaults</a></td>
<td width="65%"><font face="verdana" size="-1">Select default options to use.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.cgi?tab=cache&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Cache Details</a></td>
<td width="65%"><font face="verdana" size="-1">View the amount of caches searches among other things.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
#Get Defaults
sub getdefaults {
	open (FILE, "${path}$searchmod/template/defaults.txt");
	@data = <FILE>;
	close (FILE);
	chomp(@data);
	@eng = split(/\|/, $data[0]);
	@adv = split(/\|/, $data[1]);
	@opt = split(/\|/, $data[4]);
}
###############################################


###############################################
#Affiliate
sub affiliate {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Affiliate IDs";
$linktype2 = "affiliate";
&mods;
&getdefaults;
open (FILE, "${path}$searchmod/template/affiliate.txt");
@data = <FILE>;
close (FILE);
require "${path}$searchmod/template/$searchmod.cgi";
@selist = split(/\|/, $semod{'search_engines'});
print <<EOF;
<font face="verdana" size="-1"><B><U>Affiliate IDs</U>$modtitle</B></font>
<center>$link<P>
<form METHOD="POST" ACTION="settings.cgi?tab=setaffiliate&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td><center>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
EOF
foreach $line(@selist) {
$signup = "${line}signup";
if ($semod{$signup}) {
print <<EOF;
<tr>
<td width=30%><font face="verdana" size="-1">$line ID:</td>
<td width=70%><input type=text name=$line size=30 value=\"$data[$idval]\">
&nbsp;<font face=verdana size=-1><a href="$semod{$signup}">Sign Up</a></font>
</td></tr>
EOF
$ad=1;
}
$idval++;
}
if ($ad) {
print <<EOF;
<tr><td colspan=2>
<input type=submit value="Save">
</form>
</td>
</tr>
EOF
} else {
print <<EOF;
<tr><td colspan=2>
<font face="verdana" size="-1">No affiliate setup available for $searchmod search.</font>
</td>
</tr>
EOF
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
#Write to affiliate file
sub setaffiliate {
&checklogin;
&mods;
require "${path}$searchmod/template/$searchmod.cgi";
@selist = split(/\|/, $semod{'search_engines'});
open (FILE, ">${path}$searchmod/template/affiliate.txt");
foreach $line(@selist) {
print FILE <<EOF;
$FORM{$line}
EOF
}
close (FILE);

$text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Affiliate IDs Set</B></font></font>";
&settings;
}
###############################################


###############################################
#Add Categories
sub categories {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Categories";
$linktype2 = "categories";
&mods;
print <<EOF;
<font face="verdana" size="-1"><B><U>Categories</U>$modtitle</B></font><BR>
<center>$link<P>
<form METHOD="POST" ACTION="settings.cgi?tab=set&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">
<center>$message
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Create New Category</B><BR>(You don't have to fill out all the sub categories)</font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Category:</td>
<td width=70%><input type=text name=category size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 1:</td>
<td width=70%><input type=text name=sub1 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 2:</td>
<td width=70%><input type=text name=sub2 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 3:</td>
<td width=70%><input type=text name=sub3 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 4:</td>
<td width=70%><input type=text name=sub4 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 5:</td>
<td width=70%><input type=text name=sub5 size=45></td></tr>
<tr>
<td colspan=2><input type=submit name=type value="Submit"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form>
<P>
EOF
&footer;
}
###############################################


###############################################
#Write to Categories Page (categories.txt & searchstart.txt)
sub set {
&checklogin;
&mods;
$category = $FORM{'category'};
$sub1 = $FORM{'sub1'};
$sub2 = $FORM{'sub2'};
$sub3 = $FORM{'sub3'};
$sub4 = $FORM{'sub4'};
$sub5 = $FORM{'sub5'};
chomp($category);
chomp($sub1);
chomp($sub2);
chomp($sub3);
chomp($sub4);
chomp($sub5);
&create;

sub create {
$catfile = "$category";
if ($sub1 ne "") { $catfile .= "|$sub1"; }
if ($sub2 ne "") { $catfile .= "|$sub2"; }
if ($sub3 ne "") { $catfile .= "|$sub3"; }
if ($sub4 ne "") { $catfile .= "|$sub4"; }
if ($sub5 ne "") { $catfile .= "|$sub5"; }
open (FILE, "${path}$searchmod/template/categories.txt");
@data = <FILE>;
close(FILE);
$a=0;
foreach (@data) {
	$a++;
}
$data[$a] = "$catfile";
@sort = sort(@data);
$printhtml .= "<!-- [Categories] -->\n<table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH=90%><tr>\n";
open (FILE, ">${path}$searchmod/template/categories.txt");
foreach (@data) {
	chomp($sort[$c]);
print FILE <<EOF;
$sort[$c]
EOF
	if ($f == 3) {
		$f=0;
		$printhtml .= "</tr><tr>";	
	}
	@htmldata = split(/\|/, $sort[$c]);
	$linkurl = $htmldata[0];
	$linkurl =~ tr/ /+/;
	$printhtml .= "<td><b><font face=verdana size=-1><a href=\"metasearch.cgi?keywords=$linkurl&searchtype=$searchmod\">$htmldata[0]</a></b><BR><font size=-2>\n";
	$d=0;
	foreach (@htmldata) {
		unless ($d == 0) {
			$linkurl = $htmldata[$d];
			$linkurl =~ tr/ /+/;
			$printhtml .= "<a href=\"metasearch.cgi?keywords=$linkurl&searchtype=$searchmod\">$htmldata[$d]</a>\n";
		}
		$d++;
	}
	$printhtml .= "<BR>&nbsp;</td>\n";
	$c++;
	$f++;
}
$printhtml .= "</table>\n<!-- [Categories] -->\n";
close (FILE);

open (FILE, "${path}$searchmod/template/searchstart.txt");
@catgy = <FILE>;
close (FILE);
$catvar = "@catgy";
@catsplit = split(/<!-- \[Categories\] -->/, $catvar);
open (FILE, ">${path}$searchmod/template/searchstart.txt");
print FILE <<EOF;
$catsplit[0]
$printhtml
$catsplit[2]
EOF

$message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Category Created</B></font></font>";
}
&categories;
exit;
}
###############################################


###############################################
#Set Defaults
sub defaults {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Default Options";
$linktype2 = "defaults";
&mods;
&getdefaults;
require "${path}$searchmod/template/$searchmod.cgi";
$engines = "$semod{'search_engines'}";
@se = split(/\|/, $engines);
print <<EOF;
<font face="verdana" size="-1"><B><U>Set Defaults</U>$modtitle</B></font><BR>
<center>$link<P>
$message<BR>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><form METHOD="POST" ACTION="settings.cgi?tab=setdefaults&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">
<font face="verdana" size="-1" color="#000066"><b>Default Values</b></font></td></tr>
<tr>
<td width=30% valign=top><font face="verdana" size="-1">Default Engines:</td>
<td width=70%>
<table BORDER=0 CELLSPACING=0 CELLPADDING=0><tr>
EOF
foreach (@se) {
	if ($innernum == 4) {
		print "</tr><tr>";
		$innernum = 0;
	}
print <<EOF;
<td><input TYPE="checkbox" NAME="eng$senum" $eng[$senum]></td>
<td><font size=-2>&nbsp;$se[$senum]</td>
EOF
	$innernum++;
	$senum++;	
}
print <<EOF;
</tr></table>
</td></tr>

<tr>
<td width=30%><font face="verdana" size="-1">Default Resuls per page:</td>
<td width=70%><select NAME="perpage" SIZE="1"><option SELECTED>$adv[0]<option>---<option>10<option>20<option>30<option>40<option>50</select></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Default Timeout:</td>
<td width=70%><select NAME="timeout" SIZE="1"><option SELECTED>$adv[1]<option>---<option>2<option>5<option>7<option>15</select></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Number of days to keep cache:</td>
<td width=70%><font face="verdana" size="-1"><input TYPE="text" NAME="cache" size="2" value="$adv[2]"> days <font face="verdana" size="-2">(Specify 0 if you do not want to use cache results)</font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Amount of Characters before Cutoff:</td>
<td width=70%><input TYPE="text" NAME="cutoff" size="2" value="$adv[3]">
&nbsp;<font face="verdana" size="-2">(ex. if the title of a search result is over 50 characters, it will print the first 50 characters of the title and cut the end of with ...)</font></td></tr>
EOF
if ($searchmod eq "Web") {
print <<EOF;
<tr>
<td width=30%><font face="verdana" size="-1">Number of Related Searches to Display:</td>
<td width=70%><font face="verdana" size="-1"><select NAME="amtrelated" SIZE="1"><option SELECTED>$adv[7]<option>---<option>1<option>2<option>3<option>4<option>5<option>6<option>7<option>8<option>9<option>10</select></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Image used when there is more than one source for the result:</td>
<td width=70%><font face="verdana" size="-1"><input TYPE="text" NAME="rankimage" size="45" value="$adv[8]"></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="ranking" $opt[8]> Rank results by displaying results with the most sources first</td></tr>

EOF
}
print <<EOF;
<tr>
<td width=30%>&nbsp;</td>
<td width=70%>&nbsp;</td>
</tr>
<tr><td colspan=2><font face="verdana" size="-1" color="#000066"><b>Default Options</b></font></td></tr>
EOF
if ($searchmod eq "Web") {
print <<EOF;
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="related" $opt[2]> Enable Related Searches</td>
</tr>
EOF
}
print <<EOF;
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="highlight" $opt[6]> Enable Highlighted Terms</td>
</tr>
<tr><td colspan=2>
<input type=submit name=setdef value="Submit">
</form></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
EOF
&footer;
}
###############################################


###############################################
#Write to Defaults.txt
sub setdefaults {
&checklogin;
&mods;
require "${path}$searchmod/template/$searchmod.cgi";
$engines = "$semod{'search_engines'}";
@se = split(/\|/, $engines);
foreach (@se) {
	$eng = "eng$aaa";
	if ($FORM{$eng} eq "on") {
		if ($aaa == 0) { $engfile .= "CHECKED"; }
		else { $engfile .= "|CHECKED"; }
	} else {
		if ($aaa == 0) { $engfile .= ""; }
		else { $engfile .= "|"; }	
	}
	$aaa++;
}
if ($FORM{'rankimage'}) { $FORM{'ranking'} = "on"; }
$adv = "$FORM{'perpage'}|$FORM{'timeout'}|$FORM{'cache'}|$FORM{'cutoff'}||||$FORM{'amtrelated'}|$FORM{'rankimage'}";
$opt = "||$FORM{'related'}||||$FORM{'highlight'}||$FORM{'ranking'}";
$opt =~ s/on/CHECKED/ig;
$opt =~ s/off//ig;
$searchmod = $FORM{'searchmod'};
open (FILE, "${path}$searchmod/template/defaults.txt");
@data = <FILE>;
close (FILE);
chomp($data[2]);
chomp($data[3]);
open (FILE, ">${path}$searchmod/template/defaults.txt");
print FILE <<EOF;
$engfile
$adv
$data[2]
$data[3]
$opt
EOF
close (FILE);

$text .= "<font face=verdana size=-1><B>Message:</B> <font color=red>Defaults Set</B></font></font>";
&settings;
&footer;
}
###############################################


###############################################
#Cache
sub cache {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Cache Options";
$linktype2 = "cache";
&mods;
opendir(FILE,"${path}$searchmod/cache");
@products = grep { /.txt/ } readdir(FILE);
closedir (FILE);
$number=0;
foreach (@products) { $number++; }

print <<EOF;
<font face="verdana" size="-1"><B><U>Cache</U>$modtitle</B></font><BR>
<center>$link<P>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<form METHOD="POST" ACTION="settings.cgi?tab=clearcache&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod"><BR></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000066"><center><B>Currently $number Cached Searches</B></td>
</tr><tr>
<td colspan=2><font face="verdana" size="-1"><center>Cached Searches: 
<select NAME="caches" SIZE="1"><option SELECTED>------- Cache Searches -------
EOF
@sort = sort(@products);
foreach $line(@sort) {
	$line =~ s/.txt//;
	print "<option>$line";
}
print <<EOF;
</td></tr>
<tr><td colspan=2><center>
<input type=submit name=setdef value="Clear Expired Cache"> <input type=submit name=setdef value=" Clear All Cache ">
</form></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
EOF
&footer;
}
###############################################


###############################################
#Clear Cache
sub clearcache {
&checklogin;
&mods;
opendir(FILE,"${path}$searchmod/cache");
@products = grep { /.txt/ } readdir(FILE);
closedir (FILE);
if ($FORM{'setdef'} eq " Clear All Cache ") {
	foreach $line(@products) {
		unlink("${path}$searchmod/cache/$line");
	}
} else {
	foreach $line(@products) {
		$age = -M "${path}$searchmod/cache/$line";
		if ($age > $adv[2]) {
			unlink("${path}$searchmod/cache/$line");
		}
	}
}
$text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Cache Cleared</B></font></font>";
&settings;
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
<a href="settings.cgi?tab=settings&user=$FORM{'user'}&file=metasearch&searchmod=$FORM{'searchmod'}"><font color="white">Settings</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
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