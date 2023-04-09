#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Admin Script
# Version 2.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2002 Done-Right. All rights reserved.
###############################################


###############################################
use vars qw(%config %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value);
use CGI::Carp qw(fatalsToBrowser);
undef %config;
local %config = ();
do "${path}config/config.cgi";
if ($config{'modperl'} == 1) {
	eval("use Apache"); if ($@) { die "The Apache module used for mod_perl appears to not be installed"; }
}
my $file_ext = "$config{'extension'}";
if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
else { do "${path}functions_text.$file_ext"; }
do "${path}functions.$file_ext";
&main_functions::checkpath('addons', $path);
###############################################

 
###############################################
#Read Input
local (%FORM, $inbuffer, $qsbuffer, $buffer, @pairs, $pair, $name, $value);
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

#Logics
if ($FORM{'tab'} eq "tracker") { &tracker(); }
elsif ($FORM{'tab'} eq "resettracker") { &resettracker(); }
elsif ($FORM{'tab'} eq "options") { &options(); }
elsif ($FORM{'tab'} eq "banset") { &banset(); }
elsif ($FORM{'tab'} eq "bantarget") { &bantarget(); }
elsif ($FORM{'tab'} eq "editbantarget") { &editbantarget(); }
###############################################


###############################################
#Top Keywords
sub tracker {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my $message = $_[0];
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
#print "Location: #top\n\n";
print <<EOF;
<font face="verdana" size="-1"><B><U>Statistics</U></b>
<P>
<CENTER>$message<BR>
<font face="verdana" size="-1"><a href="#options">Statistic Options</a> | <a href="#daily">Daily Stats</a> | <a href="#top">Top Searches</a> | <a href="#bids">Top Bid Terms</a>
<BR><BR><a name="options">
<table width=50% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#CCCCCC">
   	<tr><td colspan=2><form METHOD="POST" ACTION="addons.$file_ext?tab=options&user=$FORM{'user'}&file=bidsearchengine">
<font face="verdana" size="-1" color="#000066"><B><center>Statistic Options</center></B></font></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="keepdaystats" $opt[4]> Track Daily Stats</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="popsearches" $opt[5]> Log Search Terms <BR><font size=-2>(used for related results, popular searches and search term suggestion tool)</font></td>
</tr>
<tr><td colspan=2><input type=submit value="Set Options"></td></tr>
</table></td></tr></table></td></tr></table></form><P>
EOF


unless ($FORM{'start'}) { $FORM{'start'} = 1; }
my $count = &database_functions::count_top_searches;
my $end = $FORM{'start'}+49;
if ($end > $count) { $end = $count; }

print <<EOF;
<a name="top">
<table width=50% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#CCCCCC">
   	<tr><td colspan=3><font face="verdana" size="-1" color="#000066"><B><center>Top Searches</B> - $FORM{'start'} to $end of $count</center></font></td></tr>
   	<tr>
   	<td width="5%"><font face="verdana" size="-1"><B>#</B></font></td>
   	<td width="80%"><font face="verdana" size="-1"><B>Keyword(s)</B></font></td>
   	<td width="15%" align=right><font face="verdana" size="-1"><B>Searches</B></font></td></tr>
EOF

&database_functions::get_top_searches($FORM{'start'});

print "<tr><td colspan=2><font face=\"verdana\" size=\"-1\"><B>";
if ($FORM{'start'} == 1) { print "Previous"; }
else {
	my $prev = $FORM{'start'}-50;
	print "<a href=\"addons.$file_ext?tab=tracker&user=$FORM{'user'}&start=$prev#top\">Previous</A>";
}
print "</td><td align=right><font face=\"verdana\" size=\"-1\"><B>";	
if ($end == $count) { print "Next "; }
else {
	$end++;
	print "<a href=\"addons.$file_ext?tab=tracker&user=$FORM{'user'}&start=$end#top\">Next</A> ";
}


print <<EOF;
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<form METHOD="POST" ACTION="addons.$file_ext?tab=resettracker&user=$FORM{'user'}&file=bidsearchengine">
<font face="verdana" size="-1"><center><B>Clean up search log</B> (affects related & popular searches)</B><BR>
<input type=radio name=type value="1" CHECKED> Delete terms that have only been searched once 
 <input type=radio name=type value="2"> Delete all search terms
<BR><input type=submit value="Submit"></form><BR>
<a name="daily">
<table width=50% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#CCCCCC">
   	<tr><td colspan=2><font face="verdana" size="-1" color="#000066"><B><center>Daily Statistics</center></B></font></td></tr>
   	<tr>
   	<td width="70%"><font face="verdana" size="-1"><B>Date</B></font></td>
   	<td width="30%" align=right><font face="verdana" size="-1"><B>Searches</B></font></td>
	</tr>
EOF
&database_functions::get_daily_stats;
print <<EOF;
</table></td></tr></table></td></tr></table><P>
<a name="bids">
<table width=50% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#CCCCCC">
   	<tr><td colspan=3><font face="verdana" size="-1" color="#000066"><B><center>Top Bid Terms</center></B></font></td></tr>
   	<tr>
   	<td width="5%"><font face="verdana" size="-1"><B>#</B></font></td>
   	<td width="80%"><font face="verdana" size="-1"><B>Keyword(s)</B></font></td>
   	<td width="15%" align=right><font face="verdana" size="-1"><B>Bid</B></font></td></tr>
EOF
&database_functions::get_top_bids;

print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
</font><P>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Reset/Delete Top Keywords
sub resettracker {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	&database_functions::delete_top_searches($FORM{'type'});

	my $innermes;
	if ($FORM{'type'} == 1) { $innermes = "Deleted terms that have only beens searched for once"; }
	else { $innermes = "Search log deleted"; }
	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>$innermes</B></font></font>";
	&tracker($message);
	&main_functions::exit;
}
###############################################


###############################################
#Set Options
sub options {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);

	if ($FORM{'keepdaystats'} eq "on") { $FORM{'keepdaystats'} = "CHECKED"; }
	else { $FORM{'keepdaystats'} = ""; }
	if ($FORM{'popsearches'} eq "on") { $FORM{'popsearches'} = "CHECKED"; }
	else { $FORM{'popsearches'} = ""; }
	my @newarray2 = splice(@opt,4,1,$FORM{'keepdaystats'});
	@newarray2 = splice(@opt,5,1,$FORM{'popsearches'});
	my ($opt);
	my $a = 0;
	foreach my $new2(@opt) {
		chomp($new2);
		if ($a == 0) { $opt = "$new2"; }
		else { $opt .= "|$new2"; }
		$a++;
	}

	open (FILE, "${path}config/defaults.txt");
	my @data = <FILE>;
	close (FILE);
	chomp(@data);
open (FILE, ">${path}config/defaults.txt");
print FILE <<EOF;
$data[0]
$data[1]
$data[2]
$data[3]
$opt
EOF
	close (FILE);

	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Statistic Options Set</B></font></font>";
	&tracker($message);
	&main_functions::exit;
}
###############################################


###############################################
#Targetted Banners
sub bantarget {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my $message = $_[0];
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Target Banner</U></b>
<center><P>
$message<BR>
<form METHOD="POST" ACTION="addons.$file_ext?tab=banset&user=$FORM{'user'}&file=bidsearchengine">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
   
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Create New Target</B><BR>You can specify more than one keyword by separating them by comma's (ex. keyword1,keyword2)</font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Keyword(s):</td>
<td width=70%><input type=text name=keywordtarget size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banners Image Src:</td>
<td width=70%><input type=text name=imgtarget size=45 value="http://"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banners URL:</td>
<td width=70%><input type=text name=urltarget size=45 value="http://"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Alternative Text (ALT):</td>
<td width=70%><input type=text name=alttarget size=45></td></tr>
<tr>
<td colspan=2><input type=submit name=type value="Create"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form>
<P>

<form METHOD="POST" ACTION="addons.$file_ext?tab=editbantarget&user=$FORM{'user'}&file=bidsearchengine">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
   
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Edit Existing Target</B></font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banner Target Keyword:</td>
<td width=70%>
<SELECT NAME="edit" SIZE="1">
<OPTION SELECTED>Select Keyword Target To Edit
EOF
opendir(FILE,"${path}banner");
my @products = grep { /.txt/ } readdir(FILE);
close (FILE);
my @sort = sort(@products);
foreach my $line(@sort) {
	chomp($line);
	unless ($line eq "notfound.txt" || $line eq "mod.txt") {
		open (FILE, "${path}banner/$line");
		my @data = <FILE>;
		close (FILE);
		my $a=0;
		foreach (@data) {
			my @target = split(/\|/,$data[$a]);
			print "<OPTION>$target[0]";
			$a++;
		}
	}
}

print <<EOF;
</SELECT>
</td></tr>
<tr>
<td colspan=2><input type=submit value="Edit"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form><P>
<form METHOD="POST" ACTION="addons.$file_ext?tab=banset&user=$FORM{'user'}&file=bidsearchengine">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
   
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Delete Existing Target</B></font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banner Target Keyword:</td>
<td width=70%>
<SELECT NAME="keywordtarget" SIZE="1">
<OPTION SELECTED>Select Keyword Target To Delete
EOF
opendir(FILE,"${path}banner");
@products = grep { /.txt/ } readdir(FILE);
close (FILE);
@sort = sort(@products);
foreach my $line(@sort) {
	chomp($line);
	unless ($line eq "notfound.txt" || $line eq "mod.txt") {
		open (FILE, "${path}banner/$line");
		my @data = <FILE>;
		close (FILE);
		my $a=0;
		foreach (@data) {
			my @target = split(/\|/,$data[$a]);
			print "<OPTION>$target[0]";
			$a++;
		}
	}
}
print <<EOF;
</SELECT>
</td></tr>
<tr>
<td colspan=2><input type=submit name=type value="Delete"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form><P>
EOF
my @imageban = ();
if (-e "${path}banner/notfound.txt") {
	open (FILE, "${path}banner/notfound.txt");
	my @data = <FILE>;
	my $images = "@data";
	@imageban = split(/\|/, $images);
} else {
	$imageban[1] = "http://";
	$imageban[2] = "http://";
	$imageban[3] = "";
}

print <<EOF;
<form METHOD="POST" ACTION="addons.$file_ext?tab=banset&user=$FORM{'user'}&file=bidsearchengine">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Set Default Banner</B><BR>This is the banner to be display if the search does not yield a targeted banner</B></font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banners Image Src:</td>
<td width=70%><input type=text name=imgtarget size=45 value="$imageban[1]"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banners URL:</td>
<td width=70%><input type=text name=urltarget size=45 value="$imageban[2]"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Alternative Text (ALT):</td>
<td width=70%><input type=text name=alttarget size=45 value="$imageban[3]"></td></tr>
<tr>
<td colspan=2><input type=submit name=type value="Set Default Banner"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form>
</font>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Edit Targetted Banner
sub editbantarget {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my $keyword = $FORM{'edit'};
my @keywords = split('', $keyword);
my $var=$keywords[0];
open (FILE, "${path}banner/$var.txt");
my @data = <FILE>;
close (FILE);
my ($img, $url, $alt, $a);
foreach (@data) {
	my @target = split(/\|/,$data[$a]);
	if ($target[0] eq $FORM{'edit'}) {
		$keyword = "$target[0]";
		$img = "$target[1]";
		$url = "$target[2]";
		$alt = "$target[3]";
	}
	$a++;
}

print <<EOF;
<font face="verdana" size="-1"><B><U>Target Banner</U></b><P>
<form METHOD="POST" ACTION="addons.$file_ext?tab=banset&user=$FORM{'user'}&file=bidsearchengine">
<input type=hidden name=oldkeyword size=45 value=$FORM{'edit'}>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
   
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Edit Target</B><BR>You can specify more than one keyword by separating them by comma's (ex. keyword1,keyword2)</font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Keyword(s):</td>
<td width=70%><input type=text name=keywordtarget size=45 value="$keyword"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banners Image Src:</td>
<td width=70%><input type=text name=imgtarget size=45 value="$img"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Banners URL:</td>
<td width=70%><input type=text name=urltarget size=45 value="$url"></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Alternative Text (ALT):</td>
<td width=70%><input type=text name=alttarget size=45 value="$alt"></td></tr>
<tr>
<td colspan=2><input type=submit name=type value="Edit"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form>
<P>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write to text file
sub banset {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
$FORM{'keywordtarget'} =~ s/^ //g;
$FORM{'keywordtarget'} =~ s/ $//g;
$FORM{'keywordtarget'} =~ tr/A-Z/a-z/;
my $keyword = $FORM{'keywordtarget'};
my $url = $FORM{'urltarget'};
my $img = $FORM{'imgtarget'};
my $alt = $FORM{'alttarget'};
chomp($keyword);
chomp($url);
chomp($img);
chomp($alt);
my @multikeys = split(/\,/, $keyword);
my @keywords = split('', $keyword);
my $var=$keywords[0];

if ($FORM{'type'} eq "Edit") {
	&edit2($keyword, $url, $img, $alt, @multikeys);
} elsif ($FORM{'type'} eq "Delete") {
	&deletetar2($keyword, $var);
} elsif ($FORM{'type'} eq "Set Default Banner") {
	&default2($url, $img, $alt);
} else {
	&create2($url, $img, $alt, @multikeys);
}
sub edit2 {
	my ($keyword, $url, $img, $alt, @multikeys) = @_;
	my ($numtars, $loop);
	my @oldkey = split('', $FORM{'oldkeyword'});
	my $var3=$oldkey[0];
	open (FILE, "${path}banner/$var3.txt");
	my @data = <FILE>;
	close (FILE);
	foreach (@data) { $numtars++; }
	if ($numtars < 2) {
		unlink("${path}banner/$var3.txt");
	} else {
		open (FILE, ">${path}banner/$var3.txt");
		foreach my $line(@data) {
			my @target = split(/\|/, $line);
			unless ($target[0] eq $FORM{'oldkeyword'}) {
				chomp($line);
				if ($loop == 0) {
					print FILE "$line";
				} else {
					print FILE "\n$line";
				}
				$loop++;
			}
		}
		close (FILE);
	}

	foreach my $key(@multikeys) {
		chomp($key);
		my @keywords = split('', $key);
		my $var2=$keywords[0];
		unless (-e "${path}banner/$var2.txt") {
			open (FILE, ">${path}banner/$var2.txt");
			print FILE "$key|$img|$url|$alt";
		} else {
			open (FILE, ">>${path}banner/$var2.txt");
			print FILE "\n$key|$img|$url|$alt";
		}
		close (FILE);
	}
	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Banner Target Edited</B></font></font>";
	&bantarget($message);
}

sub deletetar2 {
	my ($keyword, $var) = @_;
	my ($numtars, $loop);
	open (FILE, "${path}banner/$var.txt");
	my @data = <FILE>;
	close (FILE);
	foreach (@data) { $numtars++; }
	if ($numtars < 2) {
		unlink("${path}banner/$var.txt");
	} else {
		open (FILE, ">${path}banner/$var.txt");
		foreach my $line(@data) {
			my @target = split(/\|/, $line);
			unless ($target[0] eq $keyword) {
				chomp($line);
				if ($loop == 0) {
					print FILE "$line";
				} else {
					print FILE "\n$line";
				}
				$loop++;
			}
		}
		close (FILE);
	}
	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Banner Target Deleted</B></font></font>";
	&bantarget($message);
}

sub create2 {
	my ($url, $img, $alt, @multikeys) = @_;
	foreach my $key(@multikeys) {
		chomp($key);
		my @keywords = split('', $key);
		my $var2=$keywords[0];
		open (FILE, ">test.txt");
		print FILE "$var2, $key, @keywords";
		close (FILE);
		unless (-e "${path}banner/$var2.txt") {
			open (FILE, ">${path}banner/$var2.txt");
			print FILE "$key|$img|$url|$alt";
		} else {
			open (FILE, ">>${path}banner/$var2.txt");
			print FILE "\n$key|$img|$url|$alt";
		}
		close (FILE);
	}
	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Banner Target Created</B></font></font>";
	&bantarget($message);
}

sub default2 {
	my ($url, $img, $alt) = @_;
	open (FILE, ">${path}banner/notfound.txt");
	print FILE "|$img|$url|$alt";
	close (FILE);
	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Default Banner Set</B></font></font>";
	&bantarget($message);
}

&main_functions::exit;
}
###############################################