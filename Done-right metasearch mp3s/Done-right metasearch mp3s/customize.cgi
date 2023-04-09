#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/metasearch/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# MetaSearch by Done-Right Scripts
# Customize Script (Part of the admin)
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
if ($FORM{'tab'} eq "custpage") { &custpage; }
elsif ($FORM{'tab'} eq "startpage") { &startpage; }
elsif ($FORM{'tab'} eq "resultspage") { &resultspage; }
elsif ($FORM{'tab'} eq "searchbox") { &searchbox; }
else { &customize; }
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
				last;
			}
			$mr++;
		}
	} else {
		if ($FORM{'user'} eq $config{$mods}) {
			$verified=1;
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
			$link .= "&nbsp;|&nbsp;<a href=\"customize.cgi?tab=$linktype2&user=$modreg&file=metasearch&searchmod=$modules[$gg]\">$modules[$gg]</A>";
		}
		$gg++;
	}
}
}
###############################################


###############################################
#Main Sub
sub customize {
&checklogin;
&mods;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Templates</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=startpage&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Start Page</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the html code for your start page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=resultspage&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Results Page</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the html code for your results page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=searchbox&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">Search Box</a></td>
<td width="65%"><font face="verdana" size="-1">Create a small search box that can be put anywhere on your site or your visitors sites.</font></td>
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
#Customize Start Page
sub startpage {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Customizable Start Pages";
$linktype2 = "startpage";
&mods;
open (FILE, "${path}$searchmod/template/searchstart.txt");
@data = <FILE>;
close (FILE);
open (FILE, "${path}$searchmod/template/defaults.txt");
@defs = <FILE>;
close (FILE);
@disopt = split(/\|/, $defs[2]);
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize $modtitle Start Page</U></B></font>
<center>$link<P>
<form METHOD="POST" ACTION="customize.cgi?tab=custpage&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><center>
<table width="30%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><center><font face="verdana" size="-1" color="#000066"><B>Display Options</td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Advanced Options:
<td width=5% align=right><input TYPE="checkbox" NAME="Advanced" $disopt[0]></td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Selectable Engines:</td>
<td width=5% align=right><input TYPE="checkbox" NAME="Engines" $disopt[1]></td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Categories:</td>
<td width=5% align=right><input TYPE="checkbox" NAME="Categories" $disopt[3]></td></tr>

<tr><td colspan=2><center><input TYPE="submit" VALUE="Save"></td></tr>

</table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<input type=hidden name=type value="display">
<input type=hidden name=file2 value="searchstart">
<input type=hidden name=filename value="Start">
</form>
</font></B><P>
<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<form METHOD="POST" ACTION="customize.cgi?tab=custpage&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod"><BR>
<center><font face="verdana" size="-1"><TEXTAREA NAME="code" ROWS=40 COLS=100 WRAP="Off">
EOF

foreach $line(@data) {
	chomp($line);
	print "$line\n";
}

print <<EOF;
</TEXTAREA><BR><BR>
<input type=hidden name=file2 value="searchstart">
<input type=hidden name=filename value="Start">
<input type=submit value="Save">
</form>
<BR>
<table width=90% border="0" cellspacing="2" cellpadding="0">
<tr><td colspan=2><b><font face="verdana" size="-1"><center>The following html tags are used to display a specific item.  Usually the tags look like this &lt;!-- [tag] --&gt; or [tag].
<BR><font color="#000066"></center>It is not recommended you delete these tags.  You can choose not to display a certain item by using the display options that are above.</b></td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [timeout] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays the Default Timeout Value</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [perpage] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays the Default Results per Page Value</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Engines] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Selectable Engines in between the &lt;!-- [Engines] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Advanced] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Advanced Options in between the &lt;!-- [Advanced] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Categories] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Search Categories in between the &lt;!-- [Categories] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">[EngineName]</td>
<td width="55%"><font face="verdana" size="-1">Displays the Whether this Engine is Defaultly Checked</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><B><font face="verdana" size="-1" color="#000066">Important Form Inputs</font></B></td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;form METHOD="POST" ACTION="metasearch.cgi?page=1"&gt;</td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;input type="hidden" name="searchform" value="$searchmod"&gt;</td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;select NAME="searchtype" SIZE="1"&gt;&lt;option SELECTED&gt;$searchmod&lt;/select&gt;</td></tr>
<tr><td colspan=2><font face="verdana" size="-2">You can add more selections by inserting &lt;option&gt;Search Type. Or use this tag if there is only one search type:</td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;input type="hidden" name="searchtype" value="$searchmod"&gt;</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><B><font face="verdana" size="-1" color="#000066">Linking (only if you have more than one searchtype/module installed)</font></B></td></tr>
<tr><td colspan=2><font face="verdana" size="-1">To display another modules start page use the link metasearch.cgi?search=searchtype<BR>(replace "searchtype" with the modules name)</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td>
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
#Customize Results Page
sub resultspage {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Customizable Results Pages";
$linktype2 = "resultspage";
&mods;
open (FILE, "${path}$searchmod/template/searchresults.txt");
@data = <FILE>;
close (FILE);
$break = "@data";
@break = split(/<\!-- \[break\] -->/, $break);
open (FILE, "${path}$searchmod/template/defaults.txt");
@defs = <FILE>;
close (FILE);
@disopt = split(/\|/, $defs[3]);
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize $modtitle Results Page</U></B></font>
<center>$link<P>
<form METHOD="POST" ACTION="customize.cgi?tab=custpage&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><center>
<table width="40%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><center><font face="verdana" size="-1" color="#000066"><B>Display Options</td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Selectable Engines (top of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="EnginesTop" $disopt[0]></td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Search Box (top of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="BoxTop" $disopt[1]></td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Selectable Engines (bottom of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="EnginesBottom" $disopt[2]></td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Search Box (bottom of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="BoxBottom" $disopt[3]></td></tr>

<tr><td colspan=2><center><input TYPE="submit" VALUE="Save"></td></tr>

</table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<input type=hidden name=page value="results">
<input type=hidden name=type value="display">
<input type=hidden name=file2 value="searchresults">
<input type=hidden name=filename value="Results">
</form>
</font></B><P>
<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<form METHOD="POST" ACTION="customize.cgi?tab=custpage&user=$FORM{'user'}&file=metasearch&searchmod=$searchmod"><BR>
<center><font face="verdana" size="-1" color="#000066"><B>Top Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="topcode" ROWS=30 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[0]);
foreach $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
if ($searchmod eq "Web") { $infotitle = "Result Information & Related Search"; }
else { $infotitle = "Result Information"; }
print <<EOF;
</TEXTAREA><P>
<center><font face="verdana" size="-1" color="#000066"><B>$infotitle Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="infocode" ROWS=10 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[1]);
foreach $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><P>
<center><font face="verdana" size="-1" color="#000066"><B>Search Results Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="resultscode" ROWS=10 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[2]);
foreach $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><P>
<center><font face="verdana" size="-1" color="#000066"><B>Bottom Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="bottomcode" ROWS=30 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[3]);
foreach $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><P>
<input type=hidden name=file2 value="searchresults">
<input type=hidden name=filename value="Results">
<input type=submit value="Save">
</form>
<table width=90% border="0" cellspacing="0" cellpadding="1">
<tr><td colspan=2><b><font face="verdana" size="-1"><center>The following html tags are used to display a specific item.  Usually the tags look like this &lt;!-- [tag] --&gt; or [tag].
<BR>You can choose to delete any tag in order to not display the item.</b></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">$infotitle Tags:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [first] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Start of your Search</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [last] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the End of your Search</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [found] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the number of results found</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [description] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Hide/Show Results Link</td></tr>
EOF
if ($searchmod eq "Web") {
print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [relatedtitle] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">If Related words are found, it displays "Related:"</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [relatedrow] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the related keywords in between the <font color=red>&lt;!-- [relatedbreak] --&gt;</font> tags</td></tr>
EOF
}
print <<EOF;
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">Search Results Tags:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [number] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results Number</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [url] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results URL</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [title] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results Title</td></tr>
EOF
require "${path}$searchmod/template/$searchmod.cgi";
$desvals = "$semod{'descripvars'}";
@des = split(/\|/, $desvals);
unless ($des[0] eq "") {
	foreach $line2(@des) {
print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [$line2] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results $line2</td></tr>
EOF
	}
} else {
print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [description] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results description</td></tr>
EOF
}

print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [Source] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results Source</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">More Results Links & Timeout:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [nextform] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Link Code for Next Results</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [prevform] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Link Code for Previous Results</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [numberform] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Link Code for Numbered Results</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [EngTimedout] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Engines that Timedout</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">These tags can be placed anywhere but it is not recommended you delete these tags.  You can choose not to display a certain item by using the display options that are above.</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [timeout] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Default Timeout Value</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [perpage] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Used to display the page</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [BoxTop] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the top Search Box between the &lt;!-- [BoxTop] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [BoxBottom] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the bottom Search Box between the &lt;!-- [BoxBottom] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [EnginesTop] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the top Selectable Engines between the &lt;!-- [EnginesTop] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [EnginesBottom] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the bottom Selectable Engines between the &lt;!-- [EnginesBottom] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">[EngineName]</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Whether this Engine is Defaultly Checked</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">The following tag can be placed anywhere:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [keys] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Keywords Used</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><B><font face="verdana" size="-1" color="#000066">Important Form Inputs</font></B></td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;form METHOD="POST" ACTION="metasearch.cgi?page=1"&gt;</td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;input type="hidden" name="searchform" value="$searchmod"&gt;</td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;select NAME="searchtype" SIZE="1"&gt;&lt;option SELECTED&gt;$searchmod&lt;/select&gt;</td></tr>
<tr><td colspan=2><font face="verdana" size="-2">You can add more selections by inserting &lt;option&gt;Search Type. Or use this tag if there is only one search type:</td></tr>
<tr><td colspan=2><font face="verdana" size="-1">&lt;input type="hidden" name="searchtype" value="$searchmod"&gt;</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
}
###############################################


###############################################
#Write to Customized Page
sub custpage {
&checklogin;
&mods;
if ($FORM{'type'} eq "display") {

open (FILE, "${path}$searchmod/template/defaults.txt");
@data2 = <FILE>;
close (FILE);
if ($FORM{'filename'} eq "Start") {
	@defaults = split(/\|/, $data2[2]);
	$array = "Advanced|Engines|Popular|Categories";
}
else {
	@defaults = split(/\|/, $data2[3]);
	$array = "EnginesTop|BoxTop|EnginesBottom|BoxBottom";
}
foreach (@defaults) {
	chomp;
}
@array2 = split(/\|/, $array);
foreach (@array2) {
	
	$distype = "$array2[$p]";
	if ($FORM{$distype} eq "on") {
		$$distype = "CHECKED";
	} else {
		$$distype = "";
	}
	
	unless ($defaults[$p] eq $$distype) {
		$defaults[$p] = "$$distype";
		$page="";
		open (FILE, "${path}$searchmod/template/$FORM{'file2'}.txt");
		@data = <FILE>;
		close (FILE);
		foreach $line(@data) {
			chomp;
			$page .= $line;
		}
		@split = split(/<\!-- \[$distype\] -->/, $page);
		&$distype;
	}
	if ($p == 0) { $newdef .= "$defaults[$p]"; }
	else { $newdef .= "|$defaults[$p]"; }
	$p++;
}
foreach (@data2) {
	chomp;
}
open (FILE, ">${path}$searchmod/template/defaults.txt");
print FILE "$data2[0]\n";
print FILE "$data2[1]\n";
if ($FORM{'filename'} eq "Start") {
	print FILE "$newdef\n";
	print FILE "$data2[3]";
} else {
	print FILE "$data2[2]\n";
	print FILE "$newdef";
}
print FILE "$data2[4]";
close (FILE);

sub EnginesTop {
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesTop] -->
                  <table BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <tr>
EOF
&geteng;
print FILE2 <<EOF;
                    </tr>
                  </table>
                  <!-- [EnginesTop] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesTop] -->

                  <!-- [EnginesTop] -->
$split[2]
EOF
	}
	close (FILE2);
}

sub EnginesBottom {
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesBottom] -->
                  <table BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <tr>
EOF
&geteng;
print FILE2 <<EOF;
                    </tr>
                  </table>
                  <!-- [EnginesBottom] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesBottom] -->

                  <!-- [EnginesBottom] -->
$split[2]
EOF
	}
	close (FILE2);
}

sub geteng {
require "${path}$searchmod/template/$searchmod.cgi";
$engines = "$semod{'search_engines'}";
@se = split(/\|/, $engines);
$innernum=0;
$senum=0;
foreach (@se) {
	$engname = "$se[$senum]";
	if ($innernum == 4) {
print FILE2 <<EOF;
                    </tr>
                    <tr>
EOF
		$innernum = 0;
	}
if ($innernum == 0) {
print FILE2 <<EOF;
                      <td>&nbsp;&nbsp;<input TYPE="checkbox" NAME="$engname" [$engname]></td>
                      <td><font size=-2>&nbsp;$engname</td>
EOF
} else {
print FILE2 <<EOF;
                      <td><input TYPE="checkbox" NAME="$engname" [$engname]></td>
                      <td><font size=-2>&nbsp;$engname</td>
EOF
}
$innernum++;
$senum++;	
}
}

sub BoxTop {
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxTop] -->
                  <form METHOD="POST" ACTION="metasearch.cgi?results&page=1">
                  <input type=text name=keywords size=25 value="<!-- [keys] -->">
                  &nbsp;&nbsp;&nbsp;<input type=submit value=" Search "><BR>
                  <font face="verdana, helvetica" size="-1">
                  <input type="hidden" name="searchtype" value="$searchmod">
                  <input type="hidden" name="searchform" value="$searchmod">
                  <input type="radio" name="method" value="1"> any 
                  <input type="radio" name="method" value="0" checked> all 
                  <input type="radio" name="method" value="2"> phrase 
                  </font><BR><BR>
                  <!-- [BoxTop] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxTop] -->

                  <!-- [BoxTop] -->
$split[2]
EOF
	}
	close (FILE2);
}

sub BoxBottom {
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxBottom] -->
                  <form METHOD="POST" ACTION="metasearch.cgi?results&page=1">
                  <input type=text name=keywords size=25 value="<!-- [keys] -->">
                  &nbsp;&nbsp;&nbsp;<input type=submit value=" Search "><BR>
                  <font face="verdana, helvetica" size="-1">
                  <input type="hidden" name="searchtype" value="$searchmod">
                  <input type="hidden" name="searchform" value="$searchmod">
                  <input type="radio" name="method" value="1"> any 
                  <input type="radio" name="method" value="0" checked> all 
                  <input type="radio" name="method" value="2"> phrase 
                  </font><BR><BR>
                  <!-- [BoxBottom] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxBottom] -->

                  <!-- [BoxBottom] -->
$split[2]
EOF
	}
	close (FILE2);
}

sub Advanced {
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                <!-- [Advanced] -->
                <table BORDER=0 CELLSPACING=0 CELLPADDING=0 >
                  <tr>
                    <td>
                      <b><font face="verdana, helvetica" color="#000099" size=-1>
                      Advanced</font></b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <font face="verdana, helvetica" size=-1>Show Summaries
                      <input TYPE="radio" NAME="descrip" VALUE="0" CHECKED>
                      <br><font face="verdana, helvetica" size=-1>
                      Hide Summaries<input TYPE="radio" NAME="descrip" VALUE="1"><BR>
                      <br><font face="verdana, helvetica" size=-1>
                      Timeout&nbsp;<select NAME="timeout" SIZE="1">
                      <option SELECTED><!-- [timeout] --><option>---<option>2<option>5<option>7<option>15
                      </select><BR>
                      <font face="verdana, helvetica" size=-1>
                      Results Per Page&nbsp;<select NAME="perpage" SIZE="1">
                      <option SELECTED><!-- [perpage] --><option>---<option>10<option>20<option>30<option>40<option>50
                      </select>
                    </td>
                  </tr>
                </table>
                <!-- [Advanced] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
                <!-- [Advanced] -->
                <input TYPE="hidden" NAME="descrip" VALUE="0">
                <input TYPE="hidden" NAME="timeout" VALUE="<!-- [timeout] -->">
                <input TYPE="hidden" NAME="perpage" VALUE="<!-- [perpage] -->">
                <!-- [Advanced] -->
$split[2]
EOF
	}
	close (FILE2);
}
sub Engines {
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
		require "${path}$searchmod/template/$searchmod.cgi";
		$engines = "$semod{'search_engines'}";
		@se = split(/\|/, $engines);
print FILE2 <<EOF;
$split[0]
                <!-- [Engines] -->
                <table BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <tr>
                    <td colspan="5">
                      <b><font face="verdana, helvetica" size=-1 color=#000099>Search Engines</font></b>
                    </td>
                  </tr>
                  <tr>
EOF
$innernum=0;
$senum=0;
foreach (@se) {
	$engname="$se[$senum]";
	if ($innernum == 2) {
		print FILE2 "                  </tr>";
		print FILE2 "                  <tr>";
		$innernum = 0;
	}
print FILE2 <<EOF;
                    <td><input TYPE="checkbox" NAME="$engname" [$engname]></td>
                    <td><font size=-1>&nbsp;$engname</font></td>
EOF

if ($innernum == 0) {
print FILE2 <<EOF;
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
EOF
}

	$innernum++;
	$senum++;	
}
print FILE2 <<EOF;
                  </tr>
                </table></center>
                <!-- [Engines] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
                <!-- [Engines] -->

                <!-- [Engines] -->
$split[2]
EOF
	}
	close (FILE2);
}
sub Categories {
	open (FILE4, "${path}$searchmod/template/categories.txt");
	@data3 = <FILE4>;
	close(FILE4);
	open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
	if ($$distype eq "CHECKED") {
foreach (@data3) {
	if ($f == 3) {
		$f=0;
		$printhtml .= "</tr><tr>";	
	}
	@htmldata = split(/\|/, $data3[$c]);
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
print FILE2 <<EOF;
$split[0]
<!-- [Categories] -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH=90%><tr>
$printhtml
</table>
<!-- [Categories] -->
$split[2]
EOF
	} else {
print FILE2 <<EOF;
$split[0]
<!-- [Categories] -->

<!-- [Categories] -->
$split[2]
EOF
	}
	close (FILE2);
}

$text = "<font face=verdana size=-1><B>Message:</B> <font color=red>$FORM{'filename'} Page Customized</B></font></font>";
&customize;
} else {
open (FILE2, ">${path}$searchmod/template/$FORM{'file2'}.txt");
if ($FORM{'file2'} eq "searchresults") {
$FORM{'topcode'} =~ s/\r//g;
$FORM{'infocode'} =~ s/\r//g;
$FORM{'resultscode'} =~ s/\r//g;
$FORM{'bottomcode'} =~ s/\r//g;
print FILE2 <<EOF;
$FORM{'topcode'}
<!-- [break] -->
$FORM{'infocode'}
<!-- [break] -->
$FORM{'resultscode'}
<!-- [break] -->
$FORM{'bottomcode'}
EOF
} else {
$FORM{'code'} =~ s/\r//g;
print FILE2 <<EOF;
$FORM{'code'}
EOF
}
close (FILE2);
$text = "<font face=verdana size=-1><B>Message:</B> <font color=red>$FORM{'filename'} Page Customized</B></font></font>";
&customize;
}
}
###############################################


###############################################
#Search Box
sub searchbox {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$linktype = "Search Boxes";
$linktype2 = "searchbox";
&mods;
print <<EOF;
<font face="verdana" size="-1"><B><U>Search Box</U>$modtitle</B></font><BR>
<center>$link<P>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<form><BR><center>
<table width="90%"><tr><td>
<font face="verdana" size="-1"><center>Copy & paste the following to display a search box.  This search box can also 
be used for your visitors to put on their site.  Remember to replace http://url_to_metasearch.cgi with the direct url to metasearch.cgi<BR>
</td></tr></table><font face="verdana" size="-1"><center><TEXTAREA NAME="code" ROWS=11 COLS=100>
<!-- Search Box -->
<form METHOD="POST" ACTION="http://url_to_metasearch.cgi/metasearch.cgi">
<input type=text name=keywords size=25><input type=submit value=" Search ">
EOF
if ($count > 1) {
	print "\n<!-- Start Search Type -->\n<select NAME=\"searchtype\" SIZE=\"1\"><option SELECTED>$searchmod";
	foreach (@modules) {
		unless ($modules[$tt] eq $searchmod) {
			print "<OPTION>$modules[$tt]";
		}
		$tt++;
	}
	print "</select><input type=\"hidden\" name=\"searchform\" value=\"$searchmod\">\n<!-- End Search Type -->";
}
print <<EOF;
</form>
<!-- Search Box -->
</TEXTAREA><BR><BR>
</form>
<BR>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
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