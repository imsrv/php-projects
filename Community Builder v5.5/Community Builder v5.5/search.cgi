#!/usr/bin/perl
###
#######################################################
#		

#     
#    	
# 		
#		
#
#######################################################
#
#
# COPYRIGHT NOTICE:
#
# Copyright 1998 Scripts  All Rights Reserved.
#
# Selling the code for this program without prior written consent is
# expressly forbidden. In all cases
# copyright and header must remain intact.
#
#######################################################

require "variables.pl";

$time = time;
@char_set = ('a'..'z','0'..'9');
unless ($over_bg) { $over_bg= "white"; }
unless ($table_bg) { $table_bg= "white"; }
unless ($table_head_bg) { $table_head_bg= "\#003C84"; }
unless ($text_color) { $text_color= "black"; }
unless ($link_color) { $link_color= "blue"; }
unless ($text_table) { $text_table= "black"; }
unless ($text_table_head) { $text_table_head= "white"; }
unless ($text_highlight) { $text_highlight= "red"; }
unless ($font_face) { $font_face= "arial"; }
unless ($font_size) { $font_size= "-1"; }

$version = "3.13";

$temp=$ENV{'QUERY_STRING'};

print "Content-type: text/html\n\n ";

if ($temp) {
	@pairs=split(/&/,$temp);
	foreach $item(@pairs) {
		($name,$value)=split (/=/,$item,2);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
		else { $INPUT{$name} = $value; }
	}
}
else {
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
		else { $INPUT{$name} = $value; }
	}
}


$cgiurl = $ENV{'SCRIPT_NAME'};


&Header;

if ($temp eq "advanced") { $advanced=1; }
else { $advanced=0; }

if ($INPUT{'cata'}) { &cata; }
elsif ($INPUT{'search'}) { &search; }
elsif ($INPUT{'signup'}) { &signup; }
elsif ($INPUT{'letter'}) { &letter; }
else { &main; }
exit;



########## JOIN NOW SCREEN ##########
sub main {

if ($advanced) {
print <<EOF;
<table cellspacing=0 cellpadding=5 border=0 width=90%>
<TR><TD align=left colspan=2>
<form action="$cgiurl" method="GET">
<font face=$font_face size=$font_size>
Search For:&nbsp;&nbsp;<input type=text name="search" size=20>&nbsp;&nbsp;<input type=submit value="Search!">
</TD></TR>
<TR><TD align=left colspan=2><font face=$font_face size=$font_size>
Search As:&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="type" value="keywords" checked> Keywords
&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="type" value="phrase"> Phrase
</TD></TR>
<TR><TD align=left colspan=2><font face=$font_face size=$font_size>
Keyword Connector:&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="boolean" value="and" checked> AND
&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="boolean" value="or"> OR
</TD></TR>
<TR><TD align=left colspan=2><font face=$font_face size=$font_size>
Display # Hits per Page:&nbsp;&nbsp;&nbsp;&nbsp;<select name="perpage">
<option value="25">25
   <option value="50">50
   <option value="75">75
   <option value="100">100
   <option value="all">Show All
</select>
</form>
<HR NOSHADE SIZE=1>
</TD></TR><TR>
EOF

}
else {
print <<EOF;
<table cellspacing=0 cellpadding=5 border=0 width=90%>
<TR><TD align=left colspan=2>
<form action="$cgiurl" method="GET">
<input type="Text" name="search" size="20">&nbsp;&nbsp;<input type="Submit" value=" search ">
<font face=$font_face size=$font_size>&nbsp;&nbsp;&nbsp;<A HREF="$cgiurl?advanced">advanced options</a>
</form>
<HR NOSHADE SIZE=1>
</TD></TR><TR>
EOF
}
$a=0;
## IF category MAKE USER SELECT category ##
if ($category) {
	$nfont_size = $font_size - 1;
	$select_list = '';
	if ($cata_base) {
print <<EOF;
<TD>
<font face=$font_face size=$font_size>
<A HREF="$cgiurl?cata=accounts">No $cata_name</A></FONT><BR>
<font face=$font_face size=$nfont_size>
Accounts not currently in any $cata_name
<BR><BR>
</TD>
EOF
$a++;
	}
	open (ACC, "$path/categories.txt") || &error("Error reading category file");
	@acat = <ACC>;
	close (ACC);
	@acat = sort {$a cmp $b} @acat;
	foreach $cata_line(@acat) {
		chomp($cata_line);
		@catt = split(/\|/,$cata_line);
		($key,$catt[0]) = split(/\%\%/,$catt[0]);
		if ($a == 2) { print "</TR><TR>"; $a=1; }
		else { $a++; }
print <<EOF;
<TD>
<font face=$font_face size=$font_size>
<A HREF="$cgiurl?cata=$key">$catt[1]</A></FONT><BR>
<font face=$font_face size=$nfont_size>
$catt[2]
<BR><BR>
</TD>
EOF

	}
print <<EOF;
</TABLE>
EOF
&Footer;
exit;
}
## NO category STRAIT TO JOIN SCREEN ## 
else {
print <<EOF;
<TD colspan=2>
<font face=$font_face size=$font_size>
Browse sites by Alphabetical order.<BR><BR>
<A HREF="$cgiurl?letter=a">A</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=b">B</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=c">C</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=d">D</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=e">E</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=f">F</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=g">G</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=h">H</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=i">I</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=j">J</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=k">K</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=l">L</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=m">M</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=n">N</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=o">O</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=p">P</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=q">Q</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=r">R</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=s">S</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=t">T</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=u">U</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=v">V</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=w">W</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=x">X</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=y">Y</A>&nbsp;&nbsp;
<A HREF="$cgiurl?letter=z">Z</A>&nbsp;&nbsp;<BR><BR>
</TD></TR>
</TABLE>
EOF
&Footer;
exit;
}
}

########## LETTER SHOW ##########
sub letter {

$rstart=0;
$letter = $INPUT{'letter'};
$rstart = $INPUT{'start'};
$perpage = $INPUT{'perpage'};
unless ($INPUT{'perpage'}) { $perpage=25; }
$pperpage = $perpage + $rstart;

if ($search_icons) {
 $icon_head = "<TD><font face=$font_face size=$font_size color=$text_table_head>Status</FONT></TD>";
}

print <<EOF;
<TABLE cellpadding=4 cellspacing=0 border=0>
<TR BGCOLOR=$table_head_bg>
$icon_head
<TD><font face=$font_face size=$font_size color=$text_table_head>
Site Name</FONT></TD>
<TD><font face=$font_face size=$font_size color=$text_table_head>
Site Description</FONT></TD></TR>
EOF



$start=0;
opendir (DIR, "$path/members/accounts/$letter") || &error("can not open $path/members/accounts/$letter");
@acc_arr = grep {!(/^\./) && -f "$path/members/accounts/$letter/$_"}  readdir(DIR);
close (DIR); 
foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$path/members/accounts/$letter/$account") || &error("Error reading $path/members/accounts/$letter/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			$account =~ s/\.dat//;
			
			@acco = split(/\n/,$acc_data);

	&search_out("$account");
}
	
	
$num_pag = $start/$perpage;
$link = '';
$b=0;
while ($b<$num_pag) {
$b++;
$n_start= ($b-1) * $perpage;
$n_start++;
$link .= "<A HREF=\"$cgiurl\?letter=$letter\&start=$n_start\&perpage=$perpage\">$b</A> - ";
}

print <<EOF;
<TR><TD colspan=2>
<BR>
<a href="$cgiurl">Home</A> - $link
</TD></TR>

</TABLE>
EOF

exit;
}


########## CATA SHOW ##########
sub cata {

$rstart=0;
$cata = $INPUT{'cata'};
$rstart = $INPUT{'start'};
$perpage = $INPUT{'perpage'};
unless ($INPUT{'perpage'}) { $perpage=25; }
$pperpage = $perpage + $rstart;

if ($search_icons) {
 $icon_head = "<TD><font face=$font_face size=$font_size color=$text_table_head>Status</FONT></TD>";
}

print <<EOF;
<TABLE cellpadding=4 cellspacing=0 border=0>
<TR BGCOLOR=$table_head_bg>
$icon_head
<TD><font face=$font_face size=$font_size color=$text_table_head>
Site Name</FONT></TD>
<TD><font face=$font_face size=$font_size color=$text_table_head>
Site Description</FONT></TD></TR>
EOF

open (ACC, "$path/categories.txt") || &error("Error reading category file");
@cata_data = <ACC>;
close (ACC);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	if ($key eq $cata) {
	   $thepath = $abbo[0];
	}   
}


$start=0;
$dir = "$path/members";

foreach $ch(@char_set) {
	opendir (DIR, "$dir/$cata/$ch") || &error("can not open $dir/$cata/$ch");
	@acc_arr = grep {!(/^\./) && -f "$dir/$cata/$ch/$_"}  readdir(DIR);
	close (DIR); 
	foreach $account(@acc_arr) {
		undef $/;
		open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
		$acc_data = <ACC>;
		close (ACC);
		$/ = "\n";
		$account =~ s/\.dat//;
			
		@acco = split(/\n/,$acc_data);
		unless ($thepath) { $newpath = $account; }
		else { $newpath = "$thepath/$account"; }
		&search_out("$newpath");
	}
}

$num_pag = $start/$perpage;
$link = '';
$b=0;
while ($b<$num_pag) {
$b++;
$n_start= ($b-1) * $perpage;
$n_start++;
$link .= "<A HREF=\"$cgiurl\?cata=$cata\&start=$n_start\&perpage=$perpage\">$b</A> - ";
}

print <<EOF;
<TR><TD colspan=2>
<BR>
<a href="$cgiurl">Home</A> - $link
</TD></TR>

</TABLE>
EOF
&Footer;
exit;
}

########## SEARCH ##########
sub search {


unless ($INPUT{'boolean'}) { $INPUT{'boolean'} = "and"; }
unless ($INPUT{'type'}) { $INPUT{'type'} = "keywords"; }
$rstart=0;
$cata = $INPUT{'cata'};
$rstart = $INPUT{'start'};
$perpage = $INPUT{'perpage'};
unless ($INPUT{'perpage'}) { $perpage=25; }
$pperpage = $perpage + $rstart;


if ($search_icons) {
 $icon_head = "<TD><font face=$font_face size=$font_size color=$text_table_head>Status</FONT></TD>";
}

print <<EOF;
<TABLE cellpadding=4 cellspacing=0 border=0>
<TR BGCOLOR=$table_head_bg>
$icon_head
<TD><font face=$font_face size=$font_size color=$text_table_head>
Site Name</FONT></TD>
<TD><font face=$font_face size=$font_size color=$text_table_head>
Site Description</FONT></TD></TR>
EOF

open (ACC, "$path/categories.txt") || &error("Error reading category file");
@cata_data = <ACC>;
close (ACC);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	$caa{$key} = $abbo[0];
}


## GET LIST OF ALL DIRS ##
$dir = "$path/members";
opendir(DIR,"$dir") || &error("can not open $dir");
@dirs = grep {!(/^\./) && -d "$dir/$_" } readdir(DIR);
close DIR;

foreach $cats(@dirs) {
	foreach $ch(@char_set) {
		opendir (DIR, "$dir/$cats/$ch") || &error("can not open $dir/$cats/$ch");
		@acc_arr = grep {!(/^\./) && -f "$dir/$cats/$ch/$_"}  readdir(DIR);
		close (DIR); 
		foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cats/$ch/$account") || &error("Error reading $dir/$cats/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			$account =~ s/\.dat//;
			
			@acco = split(/\n/,$acc_data);
			if ($caa{$cats}) {
			   &search_site("$caa{$cats}/$account");			
			   if ($found) {
				  &search_out("$caa{$cats}/$account");
		       }
			}
			else {
			   &search_site("$account");			
			   if ($found) {
				  &search_out("$account");
		       }			
			}
		}
	}
}



$num_pag = $start/$perpage;
$link = '';
$b=0;
while ($b<$num_pag) {
$b++;
$n_start= ($b-1) * $perpage;
$n_start++;
$link .= "<A HREF=\"$cgiurl\?search=$INPUT{'search'}\&boolean=$INPUT{'boolean'}\&type=$INPUT{'type'}\&perpage=$perpage\&start=$n_start\">$b</A> - ";
}


print <<EOF;
<TR><TD colspan=2>
<BR>
<a href="$cgiurl">Home</A> - $link
</TD></TR>

</TABLE>
EOF
&Footer;
exit;

}

########## DISPLAY SEARCH RESULTS ##########
sub search_out {

$start++;
next if ($start >= $pperpage);
next if ($start < $rstart);
if ($search_show) {
	next unless ($acco[8]);
	next unless ($acco[9]);
}
print "<TR>";

if ($search_icons) {
	$ctime = ($time - $acco[4]) / 86400;	
	$ltime = ($time - $acco[5]);

	unless ($acco[5]) {
		$sicon = "<IMG SRC=\"$url_to_icons/search_never.gif\" border=0>";
	}
	elsif ($ctime < $search_new) {
		$sicon = "<IMG SRC=\"$url_to_icons/search_new.gif\" border=0>";
	}
	elsif ($ltime < 86400) {
		$sicon = "<IMG SRC=\"$url_to_icons/search_today.gif\" border=0>";
	}
	else {
		$sicon = "<IMG SRC=\"$url_to_icons/search_plain.gif\" border=0>";
	}
	if ($acco[35]) {
		unless ($acco[35] =~ /http/) {
			$acco[35] = "$url_to_icons/$acco[35]";
		}
		$sicon = "<IMG SRC=\"$acco[35]\" border=0>";
	}	
	$sicon = "<TD><A HREF=\"$url/$_[0]\">$sicon</A></TD>";
}

unless ($acco[8]) { $acco[8]="Yet to be named"; }
unless ($acco[9]) { $acco[9]="A web site by $acco[1]"; }

print "$sicon";
print "<TD><font face=$font_face size=$font_size><A HREF=\"$url/$_[0]\">$acco[8]</A></FONT></TD>\n";
print "<TD><font face=$font_face size=$font_size>&nbsp;&nbsp;&nbsp;$acco[9]</FONT></TD></TR>\n";
}


########## SEARCH SITE #########
sub search_site {

$found=0;
undef $/;
open (HEAD, "$free_path/$_[0]/index.html");
$index = <HEAD>;
close (HEAD);
$/ ="\n";

if ($INPUT{'type'} eq "phrase") {
	if ($index =~ /$INPUT{'search'}/i) { $found=1; }
	if ($acco[8] =~ /$INPUT{'search'}/i) { $found=1; }
	if ($acco[9] =~ /$INPUT{'search'}/i) { $found=1; }
}
else { # KEYWORDS #
	@words = split(/ /,$INPUT{'search'});
	$lword = @words;
	$ff=0;
	foreach $line(@words) {
		if ($index =~ /$line/i) { $ff++; next; }
		if ($acco[8] =~ /$line/i) { $ff++;  next; }
		if ($acco[9] =~ /$line/i) { $ff++;  next; }				
	}
	if ($INPUT{'boolean'} eq "and") {
		if ($ff eq $lword) { $found=1; }
	}
	else {
		if ($ff) { $found=1; }
	}	
}

}

########## CGI HEADER ##########
sub Header {

print "<HTML><HEAD><TITLE>$free_name</TITLE></HEAD>\n";
print "<body bgcolor=$over_bg text=$text_color link=$link_color alink=$link_color vlink=$link_color>\n";

if (-e "$path/$search_header") {
	open (HEAD, "$path/$search_header");
	@head = <HEAD>;
	close (HEAD);
	$head[0]='';
	foreach $line (@head) {
			print "$line";
	}
}
	print "<br><center>";
}

########## CGI FOOTER ##########
sub Footer {

print "</center>";
if (-e "$path/$search_footer") {
	open (HEAD, "$path/$search_footer");
	@foot = <HEAD>;
	close (HEAD);
	$foot[0]='';
	foreach $line (@foot) {
		print "$line";
	}
}
if ($credit) {
	print "<center><font size=$font_size><hr width=525 noshade size=1><a href=\"http://www.freedomain.com\">Community Builder</a> v$version<br>Created by <a href=\"http://www.freedomain.com\">Scripts</a><br><br>";
}
print "</BODY></HTML>\n";
}

########## ERROR ##########
sub error {
$error = $_[0] ;
print <<EOF;

<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
<B>We are sorry, the system is down at the moment, please try again later<BR><BR>
Thank you<BR><BR><BR>
To help us correct this problem, please let <A HREF="mailto:$your_email">$your_email</A> of the error.<BR><BR>
Error: <I>$error -- $!</I><BR><BR></TD></TR></TABLE>
EOF
&Footer;
exit;
}