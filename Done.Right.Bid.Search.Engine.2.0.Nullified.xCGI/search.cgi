#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

# If you are running the script under mod_perl, uncomment the 'use lib' code and specify the absolute data path
# to your bidsearch folder.  This is the same path as inputted as in the $path variable above without the forward
# slash at the end.
# Example:
# use lib "/www/root/website/cgi-bin/bidsearch";
#use lib ""; #Without a foward slash at the end

# If you would like to run the search script under FastCGI, set the below variable to 1.
# Example: my $fastcgi = 1;
my $fastcgi = 0;

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Search Script
# Version 2.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# None of the code below needs to be edited below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2002 Done-Right. All rights reserved.
###############################################


###############################################
if ($fastcgi) {
	eval("use FCGI"); if ($@) { die "The FCGI module used for FastCGI appears to not be installed"; }
	while(FCGI::accept() >= 0) {
		&init;
	}
} else {
	&init;
}
###############################################


###############################################
sub init {
	use vars qw(%config $file_ext @eng @adv @opt %semod @selist %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value);	
	use CGI::Carp qw(fatalsToBrowser);
	undef %config;
	local %config = ();
	do "${path}config/config.cgi";
	if ($config{'modperl'} == 1) {
		eval("use Apache"); if ($@) { die "The Apache module used for mod_perl appears to not be installed"; }
	}
	local $file_ext = "$config{'extension'}";
	if ($file_ext eq "") { $file_ext = "cgi"; }
	if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
	else { do "${path}functions_text.$file_ext"; }
	do "${path}functions.$file_ext";
	&main_functions::checkpath('search', $path);
	local (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	undef %semod;
	local %semod = ();
	do "${path}template/Web.cgi";
	local @selist = split(/\|/,$semod{'search_engines'});

	# Read Input
	local (%FORM, $inbuffer, $qsbuffer, $buffer, @pairs, $pair, $name, $value);
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
			if ($config{'data'} eq "mysql") { $value = &database_functions::escape($value); }
			$FORM{$name} = $value;
		}
	}

	# Logics
	if ($FORM{'tab'} eq "bidclick") { &bidclick(); }
	elsif ($FORM{'tab'} eq "checkbid") { &checkbid(); }
	elsif ($FORM{'tab'} eq "suggest") { &suggest(); }
	elsif ($FORM{'tab'} eq "popular") { &popular(); }
	elsif ($FORM{'tab'} eq "displaybids") { &displaybids(); }
	elsif ($FORM{'keywords'}) {
		if ($FORM{'url'}) { &frame(); }
		elsif ($FORM{'frame'}) { &topframe(); }
		else { &results(); }
	} else { &main(); }
}
###############################################


###############################################
sub checkbid {
open (FILE, "${path}template/checkbid.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";

unless ($FORM{'searched'}) {
	$temp =~ s/\[searchterm\]//ig;
	$temp =~ s/\[ext\]/$file_ext/ig;
	my @temparray = split(/<\!-- \[list\] -->/,$temp);
	print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
$temparray[2]
EOF
} else {
	my $searchterm = $FORM{'searchterm'};
	$searchterm = lc($searchterm);
	$searchterm =~ s/, / /g;
	$searchterm =~ tr/,/ /;
	$searchterm =~ s/ +/ /g;
	$searchterm =~ tr/+/ /;
	$searchterm =~ tr/"//;
	$searchterm =~ s/^ //g;
	$searchterm =~ s/ $//g;
	$temp =~ s/\[searchterm\]/$searchterm/ig;
	$temp =~ s/\[ext\]/$file_ext/ig;
	my @temparray = split(/<\!-- \[displaylistings\] -->/,$temp);
	&database_functions::get_bids($searchterm, $temp, @temparray);
}
&main_functions::exit;
}
###############################################


###############################################
sub suggest {
open (FILE, "${path}template/suggestion.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";

unless ($FORM{'searched'}) {
	$temp =~ s/\[searchterm\]//ig;
	$temp =~ s/\[ext\]/$file_ext/ig;
	my @temparray = split(/<\!-- \[list\] -->/,$temp);
	print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
$temparray[2]
EOF
} else {
	my $searchterm = $FORM{'searchterm'};
	$searchterm = lc($searchterm);
	$searchterm =~ s/, / /g;
	$searchterm =~ tr/,/ /;
	$searchterm =~ s/ +/ /g;
	$searchterm =~ tr/+/ /;
	$searchterm =~ tr/"//;
	$searchterm =~ s/^ //g;
	$searchterm =~ s/ $//g;
	$temp =~ s/\[searchterm\]/$searchterm/ig;
	$temp =~ s/\[ext\]/$file_ext/ig;
	
	#related
	my @search_keys = split(/ /, $searchterm);
	my ($match);
	foreach (@search_keys) {
		$match .= "m/\Q$_\E/oi||";	
	}
	$match =~s/..$//;
	$match = eval "sub{$match}";
	
	my @related = &database_functions::get_related($match, $searchterm, '50', '1');
	print "Content-type: text/html\n\n";
	if (@related) {
		my @temparray = split(/<\!-- \[displaylistings\] -->/,$temp);
		print "$temparray[0]";
		foreach my $line(@related) {
			chomp($line);
			my $temp = "$temparray[1]";
			my ($count, $term) = split(/\|/, $line);
			$temp =~ s/<\!-- \[count\] -->/$count/ig;
			$temp =~ s/<\!-- \[term\] -->/$term/ig;
			print "$temp";	
		}
		print "$temparray[2]";
	} else {
		my @temparray = split(/<\!-- \[list\] -->/,$temp);
		$temparray[0] =~ s/<\!-- \[error\] -->/No related terms found for keyword/ig;
		print "$temparray[0]";
		print "$temparray[2]";
	}	
}
&main_functions::exit;
}
###############################################


###############################################
sub displaybids {
my $bidkeys = $FORM{'keywords'};
my ($bidcount, $non, $num);
my @result = &database_functions::open_listings($bidkeys, $FORM{'method'}, $adv[17]);
foreach (@result) { $bidcount++; }
if ($bidcount == 0 && $non == 0 && $opt[13] eq "CHECKED") {
	$bidkeys = "Non-Targeted Listing";
	$non = 1;
	@result = &database_functions::open_listings($bidkeys, undef, $adv[17]);
	foreach (@result) { $bidcount++; }
}

open (FILE, "${path}template/searchresults.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp2="@tempfile";
$temp2 =~ s/\[ext\]/$file_ext/ig;
my @temparray = split(/<\!-- \[break\] -->/,$temp2);
print "Content-type: text/html\n\n";

foreach my $line(@result) {
	chomp($line);
	my @data2 = split(/\|/, $line);
	my $temp = $temparray[2];
	my $high = $data2[4];
	my $qtitle = $data2[2];
	my $morelikethis = $data2[2];
	$bidkeys =~ tr/ /+/;
	my $site_id = $data2[6];
	my ($biduser, $bidurl) = ($data2[1], $data2[3]);
	my $biduser2 = $biduser;
	my $encryptkey = "drbidsearch";
	$biduser = &main_functions::Encrypt($biduser,$encryptkey,'asdfhzxcvnmpoiyk');
	$bidurl = &main_functions::Encrypt($bidurl,$encryptkey,'asdfhzxcvnmpoiyk');
	my ($qurl);
	if ($opt[3] eq "CHECKED" && -e "${path}template/frame.txt") {
		$qurl = "$config{'adminurl'}search.$file_ext?tab=bidclick&url=$bidurl&biduser=$biduser&keywords=$bidkeys&id=$site_id&page=1&perpage=$FORM{'perpage'}";
	} else {
		$qurl = "$config{'adminurl'}search.$file_ext?tab=bidclick&url=$bidurl&biduser=$biduser&keywords=$bidkeys&id=$site_id";
	}
	$bidurl = $data2[3];
	my $source2 = "Cost to Advertise: <a href='$config{'secureurl'}signup.$file_ext'>$adv[15]$data2[0]</a>";
	my $bidsearch = 1;
	my ($ptitle, $purl, $burl);
	($morelikethis, $ptitle, $high, $purl, $burl) = &edit_vars($qurl, $qtitle, 'bidsearch', $high, $bidurl, $morelikethis);
	$num++;
	unless ($FORM{'biduser'} eq "false") { $temp =~ s/<!-- \[biduser\] -->/$biduser2/ig; }
	unless ($FORM{'number'} eq "false") { $temp =~ s/<!-- \[number\] -->/$num/ig; }
	unless ($FORM{'url'} eq "false") { $temp =~ s/<!-- \[url\] -->/$qurl/ig; }
	unless ($FORM{'title'} eq "false") { $temp =~ s/<!-- \[title\] -->/$ptitle/ig; }
	unless ($FORM{'descrip'} eq "false") { $temp =~ s/<!-- \[description\] -->/<dd>$high/ig; }
	unless ($FORM{'printurl'} eq "false") { $temp =~ s/<!-- \[printurl\] -->/<BR>$burl/ig; }
	unless ($FORM{'source'} eq "false") { $temp =~ s/<!-- \[source\] -->/$source2/ig; }
	unless ($FORM{'morelikethis'} eq "false") { $temp =~ s/<!-- \[morelikethis\] -->/$morelikethis/ig; }
	print $temp;
	last if ($num == $FORM{'perpage'});
}
&main_functions::exit;
}
###############################################


###############################################
sub popular {
my (@wordfilter, $gg, $tracked);
if ($opt[1] eq "CHECKED") {
	open(FILE, "${path}template/wordfilter.txt");
	@wordfilter = <FILE>;
	close(FILE);
}

my @data = &database_functions::popular;
foreach my $trac(@data) {
	my @track = split(/\|/,$trac);
	my $found=0;
	if ($opt[1] eq "CHECKED") {
		foreach my $word(@wordfilter) {
			chomp($word);
			$word =~ s/\r+//;
			if ($track[1] =~ /\b$word\b/i) {
				$found=1;
				last;
			}
		}
	}
	unless ($found == 1) {
		$gg++;
		chomp($track[1]);
		my $trackkeys = $track[1];
		$trackkeys =~ tr/ /+/;
		$trackkeys =~ s/'/%22/g;
		$tracked .= "$gg. <a href='$config{'adminurl'}search.$file_ext?keywords=$trackkeys'>$track[1]</a><BR>\n";
		last if $gg == $adv[4];
	}
}

if ($FORM{'ssi'}) {
	print "Content-type: text/html\n\n";
	print "$tracked";
}
return ($tracked);
}
###############################################


###############################################
# Main Sub, Prints Out Seach Box & Categories etc.
sub main {
	open (FILE, "${path}template/searchstart.txt");
	my @tempfile = <FILE>;
	close (FILE);
	my $temp="@tempfile";

	my ($t, $c, $dis_eng);
	if ($temp =~ /<\!-- \[display engines\] -->/) {
        $dis_eng .= "<table BORDER=0 CELLSPACING=0 CELLPADDING=0>\n<tr>\n<td colspan=\"5\"><b><font face=\"verdana, helvetica\" size=-1 color=#000099>Search Engines</font></b></td>\n</tr>\n";
		foreach (@selist) {
			if ($c == 0) { $dis_eng .= "<tr>\n"; }
			$dis_eng .= "<td><font size=-1><input TYPE=\"checkbox\" NAME=\"$selist[$t]\"";
			if ($eng[$t] eq "CHECKED") { $dis_eng .= " CHECKED"; }
			$dis_eng .= ">&nbsp;$selist[$t]</td>\n";
			if ($c == 0) { $dis_eng .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>\n"; }
			if ($c == 1) {
				$dis_eng .= "</tr>\n";
				$c = -1;
			}
			$t++;
			$c++;
		}
		$dis_eng .= "</table>";
		$temp =~ s/<\!-- \[display engines\] -->/$dis_eng/ig;	
	}
	my $tracked = &popular;
	$temp =~ s/\[ext\]/$file_ext/ig;
	$temp =~ s/<\!-- \[Popular Searches\] -->/$tracked/ig;
	$temp =~ s/<\!-- \[timeout\] -->/$adv[1]/ig;
	$temp =~ s/<\!-- \[perpage\] -->/$adv[0]/ig;
	print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
	&main_functions::exit;
}
###############################################

###############################################
# Frame Redirection
sub frame {
	open (FILE, "${path}template/frame.txt");
	my @DATA = <FILE>;
	close (FILE);

	my $tempdata = "@DATA";
	$FORM{'url'} =~ s/[',"]/%22/g;
	$FORM{'keywords'} =~ s/[',"]/%22/g;
	$tempdata =~ s/\[frameurl\]/$FORM{'url'}/ig;
	$FORM{'url'} =~ s/\&/%26/g;
	$FORM{'url'} =~ s/\?/%3F/g;
	$FORM{'url'} =~ s/\=/%3D/g;
	my $newurl = "search.$file_ext?keywords=$FORM{'keywords'}&siteurl=$FORM{'url'}&frame=top&engines=$FORM{'engines'}&page=$FORM{'page'}&perpage=$FORM{'perpage'}&wordfilter=$FORM{'wordfilter'}&timeout=$FORM{'timeout'}&method=$FORM{'method'}";
	$tempdata =~ s/\[topframe\]/$newurl/ig;
	print "Content-type: text/html\n\n";
print <<EOF;
$tempdata
EOF
}
###############################################

###############################################
# Print Top Frame
sub topframe {
	open (FILE, "${path}template/topframe.txt");
	my @DATA = <FILE>;
	close (FILE);
	my $newurl = "search.$file_ext?keywords=$FORM{'keywords'}&engines=$FORM{'engines'}&page=$FORM{'page'}&perpage=$FORM{'perpage'}&wordfilter=$FORM{'wordfilter'}&timeout=$FORM{'timeout'}&method=$FORM{'method'}&prev=1";
	my $tempdata = "@DATA";
	$FORM{'keywords'} =~ s/^\s+//;
	$FORM{'keywords'} =~ s/\s+$//;
	my $keys2 = $FORM{'keywords'};
	$keys2 =~ tr/+/ /;
	my $displaykeys = $keys2;
	my $framebanner = "target='_top'";
	my $banner = &banner($displaykeys, $framebanner);
	$tempdata =~ s/<\!-- \[banner\] -->/$banner/ig;
	$tempdata =~ s/\[topframe\]/$newurl/ig;
	$tempdata =~ s/\[frameurl\]/$FORM{'siteurl'}/ig;
	print "Content-type: text/html\n\n";
print <<EOF;
$tempdata
EOF
	&main_functions::exit;
}
###############################################

###############################################
# Search Results
sub results {
	# Variables
	my ($timeout, $displaykeys, $normalkeys, $linkkeys, $withintag, $oldkeys);
	unless ($FORM{'page'}) { $FORM{'page'} = 1; }
	unless ($FORM{'perpage'}) { $FORM{'perpage'} = $adv[0]; }
	unless ($FORM{'timeout'}) { $FORM{'timeout'} = $adv[1]; }
	unless ($FORM{'descrip'}) { $FORM{'descrip'} = 0; }

	my $last = $FORM{'perpage'}*$FORM{'page'};
	my $first = $last-($FORM{'perpage'}-1);
	$FORM{'keywords'} =~ s/^ //g;
	$FORM{'keywords'} =~ s/ $//g;
	$FORM{'keywords'} =~ s/\+/%2b/g;
	$FORM{'keywords'} =~ s/  / /g;
	if ($FORM{'searchwithin'} eq "on") {
		my $withinkeys = $FORM{'keywords'};
		if ($FORM{'page'} == 1) {
			$FORM{'keywords'} = $FORM{'oldkeys'};
			$FORM{'oldkeys'} = $withinkeys;
		}
		$displaykeys = "$FORM{'keywords'} $FORM{'oldkeys'}";
		$normalkeys = $linkkeys = $FORM{'keywords'};
		my $oldkeys2 =	$FORM{'oldkeys'};
		$oldkeys2 =~ s/'/%22/g;
		$withintag = "&searchwithin=on&oldkeys=$oldkeys2";
		$oldkeys = $FORM{'keywords'};
	} else { $oldkeys = $displaykeys = $normalkeys = $linkkeys = $FORM{'keywords'}; }
	$oldkeys =~ s/\\'/'/g;
	$oldkeys =~ s/[',"]/&quot;/g;

	$linkkeys =~ s/[',"]/%22/g;
	$linkkeys =~ tr/ /+/;
	$displaykeys =~ s/%2b/+/g;
	$displaykeys =~ s/%28/\(/g;
	$displaykeys =~ s/%29/\)/g;
	$displaykeys =~ s/\\'/'/g;
	$displaykeys =~ s/[',"]/&quot;/g;
	$normalkeys =~ tr/A-Z/a-z/;
	open(FILE, "${path}template/wordfilter.txt");
	my @wordfilter = <FILE>;
	close(FILE);
	
	my ($purefilter, @newlist, $totaleng);
	if ($FORM{'wordfilter'} eq "on" && -e "${path}template/wordfilter.txt") {
		foreach my $word(@wordfilter) {
			chomp($word);
			$word =~ s/\r+//;
			if ($normalkeys =~ /\b$word\b/i) {
				$purefilter=1;
				last;
			}
		}
	}

	($totaleng, @newlist) = &get_engines;
	$normalkeys = &question($normalkeys);

	my ($normalkeys2, @highlight);
	if ($FORM{'searchwithin'} eq "on") {
		$normalkeys2 = "$normalkeys $FORM{'oldkeys'}";
		@highlight = split(/ /, $normalkeys2);
	} else {
		@highlight = split(/ /, $normalkeys);
	}
	my ($bidkeys,$advkeys) = ($normalkeys) x 2;
	$normalkeys =~ s/%2b/+/g;
	$normalkeys =~ s/%28/\(/g;
	$normalkeys =~ s/%29/\)/g;
	$advkeys =~ tr/ /+/;
	my ($method, $method0, $method1, $method2);
	($method, $advkeys, $method0, $method1, $method2) = &method($advkeys);
	$advkeys =~ s/[',"]/%22/g;
	# End Variables
	
	open (FILE, "${path}template/searchresults.txt");
	my @tempfile = <FILE>;
	close (FILE);
	my $temp2="@tempfile";
	$temp2 =~ s/\[ext\]/$file_ext/ig;
	my ($t, $c, $dis_eng);
	if ($temp2 =~ /<\!-- \[display engines\] -->/) {
		$dis_eng .= "<table BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
		foreach my $name(@selist) {
			my $checkeng = "${name}check";
			if ($c == 0) { $dis_eng .= "<tr>\n"; }
			$dis_eng .= "<td>";
			if ($c == 0) { $dis_eng .= "&nbsp;&nbsp;"; }
			$dis_eng .= "<font size=-2><input TYPE=\"checkbox\" NAME=\"$selist[$t]\" $$checkeng>&nbsp;$selist[$t]</td>\n";
			if ($c == 0) { $dis_eng .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>\n"; }
			if ($c == 3) {
				$dis_eng .= "</tr>\n";
				$c = -1;
			}
			$t++;
			$c++;
		}
		$dis_eng .= "</table>";
		$temp2 =~ s/<\!-- \[display engines\] -->/$dis_eng/ig;	
	}
	$temp2 =~ s/<\!-- \[timeout\] -->/$FORM{'timeout'}/ig;
	$temp2 =~ s/<\!-- \[perpage\] -->/$FORM{'perpage'}/ig;
	$temp2 =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
	$temp2 =~ s/<\!-- \[oldkeys\] -->/$oldkeys/ig;
	$temp2 =~ s/\[member\]/$FORM{'member'}/ig;
	$temp2 =~ s/\[method0\]/$method0/ig;
	$temp2 =~ s/\[method1\]/$method1/ig;
	$temp2 =~ s/\[method2\]/$method2/ig;
	my @temparray = split(/<\!-- \[break\] -->/,$temp2);

	my $temp = "$temparray[0]";
	my $banner = &banner($displaykeys);

	$temp =~ s/<\!-- \[banner\] -->/$banner/ig;
	$| = 1;
	if ($FORM{'xml'}) { print "Content-type: text/xml\n\n"; }
	else {
		print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
	}
	my ($engtimeout, $grandtotal, @gatherlist, @newdata);
	foreach my $line(@newlist) {
		chomp($line);
		@gatherlist = &cache_check($normalkeys, $line, @gatherlist);
	}
	@gatherlist = &cache_check($normalkeys, 'Related', @gatherlist);
	sub cache_check {
		my ($normalkeys, $line, @gatherlist) = @_;
		if (-e "${path}cache/$normalkeys-$line.txt") {
			my $age = -M "${path}cache/$normalkeys-$line.txt";
			if ($age > $adv[2]) {
				push(@gatherlist, $line);
			}
		} else {
			push(@gatherlist, $line);
		}
		return(@gatherlist);
	}
	if (@gatherlist) {
		($engtimeout, $totaleng, @newlist) = &gather($advkeys, $totaleng, $normalkeys, \@gatherlist, \@newlist);
	}

	($grandtotal, @newdata) = &sort_gathered($totaleng, $method, $normalkeys, @newlist);
	#Formily display sub
	$bidkeys =~ tr/A-Z/a-z/;
	$bidkeys =~ s/, / /g;
	$bidkeys =~ tr/,/ /;
	$bidkeys =~ tr/+/ /;
	$bidkeys =~ s/"//g;
	my ($non, $bidcount, $affpay);
	my @result = &database_functions::open_listings($bidkeys, $method, $adv[17]);
	foreach (@result) { $bidcount++; }
	if ($bidcount == 0 && $non == 0 && $opt[13] eq "CHECKED") {
		my $bidkeys = "Non-Targeted Listing";
		$non = 1;
		@result = &database_functions::open_listings($bidkeys, undef, $adv[17]);
		foreach (@result) { $bidcount++; }
	}
	$grandtotal = $grandtotal + $bidcount;
	#affiliate
	if ($FORM{'member'} && $bidkeys) {
		do "${path}affiliate/config/config.cgi";
		my %config = %::config;
		do "${path}affiliate/click.$config{'extension'}";
		&click_functions::add_search(%FORM);
		if ($config{'pay'} == 1) {
			$affpay = 1;
			$FORM{'keyword'} = $bidkeys;
			&click_functions::add_click(%FORM);
		}
		do "${path}config/config.cgi";
		if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
		else { do "${path}functions_text.$file_ext"; }
		do "${path}functions.$file_ext";
	}

	my $ovrlim = ($FORM{'page'}*$FORM{'perpage'}) - $grandtotal;
	if ($purefilter) {
		my $message = "Results have been Family Filtered";
		&dismess($message, $displaykeys, @temparray);
	}
	if ($grandtotal == 0 && $bidcount == 0) {
		my $message = "No Results Found";
		&dismess($message, $displaykeys, @temparray);
	} elsif ($ovrlim > $FORM{'perpage'}) {
		my $message = "No More Results Found";
		&dismess($message, $displaykeys, @temparray);
	} elsif ($totaleng == 0 && $bidcount == 0) {
		my $message = "Results Timed Out";
		&dismess($message, $displaykeys, @temparray);
	} else {
		my $splitter = "@newdata";
		my @nextrel = split(/NEXTRELATED\n/, $splitter);
		my @indeng = split(/SPLITTER\n/, $nextrel[0]);
		my ($engnum, $newlist2);
		foreach my $eng(@newlist) {
			chomp($eng);
			if ($engnum == 0) { $newlist2 .= "$eng"; }
			else { $newlist2 .= "\|$eng"; }
			$engnum++;
		}
		my ($view, $titlesort, $description) = &sort_by($method, $withintag, $linkkeys, $newlist2);
		my ($llcount, @lline) = &related($nextrel[1], $normalkeys, $newlist2, @wordfilter);
		my $nextpage = ($FORM{'page'} - 1) * $FORM{'perpage'};
		my ($indnum, $newnumb);

		if ($FORM{'searchwithin'} eq "on") { ($grandtotal) = &searchwithin($displaykeys, \@indeng, \@temparray, \@result); }
		my ($allfilter, $filtered, $indeng);
		if ($FORM{'wordfilter'} eq "on" && -e "${path}template/wordfilter.txt") {
			($allfilter, $filtered, @result) = &wordfilter($grandtotal, \@indeng, \@wordfilter, \@result);
		}
		if ($opt[0] eq "CHECKED" && -e "${path}template/domainfilter.txt") {
			($grandtotal, @indeng) = &domainfilter($grandtotal, @indeng);
		}
		if ($last > $grandtotal) { $last = $grandtotal; }
		my $temp = $temparray[1];
		unless ($FORM{'xml'}) {
			if (@lline) {
				my @related = split(/<\!-- \[relatedbreak\] -->/,$temp);
				my $temp = $related[0];
				$temp =~ s/<\!-- \[first\] -->/$first/ig;
				$temp =~ s/<\!-- \[last\] -->/$last/ig;
				$temp =~ s/<\!-- \[description\] -->/$description/ig;
				$temp =~ s/<\!-- \[found\] -->/$grandtotal/ig;
				$temp =~ s/<\!-- \[view\] -->/$view/ig;
				$temp =~ s/<\!-- \[wordfilter\] -->/<BR>$filtered/ig;
				$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
				$temp =~ s/<\!-- \[banner\] -->/$banner/ig;
				unless ($lline[1] eq "") { $temp =~ s/<\!-- \[relatedtitle\] -->/Related Searches/ig; }
				print $temp;
				my $divide = $llcount/2;
				unless ($lline[1] eq "") {
					my ($done);
					for my $newcount(1 .. $llcount) {
						my $temp = $related[1];
						if ($newcount > $divide && $done <=> 1) {
							$done = 1;
							print "</tr><tr>";
						}						
						$temp =~ s/<\!-- \[relatedrow\] -->/$lline[$newcount]/ig;
						$temp =~ s/&apos;/'/g;
						print $temp;

					}
				}
				$temp = $related[2];
				$temp =~ s/<\!-- \[banner\] -->/$banner/ig;
				$temp =~ s/<\!-- \[wordfilter\] -->/<BR>$filtered/ig;
				$temp =~ s/<\!-- \[first\] -->/$first/ig;
				$temp =~ s/<\!-- \[last\] -->/$last/ig;
				$temp =~ s/<\!-- \[description\] -->/$description/ig;
				$temp =~ s/<\!-- \[found\] -->/$grandtotal/ig;
				$temp =~ s/<\!-- \[view\] -->/$view/ig;
				$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
				print $temp;
			} else {
				$temp =~ s/<\!-- \[banner\] -->/$banner/ig;
				$temp =~ s/<\!-- \[first\] -->/$first/ig;
				$temp =~ s/<\!-- \[last\] -->/$last/ig;
				$temp =~ s/<\!-- \[description\] -->/$description/ig;
				$temp =~ s/<\!-- \[found\] -->/$grandtotal/ig;
				$temp =~ s/<\!-- \[view\] -->/$view/ig;
				$temp =~ s/<\!-- \[wordfilter\] -->/<BR>$filtered/ig;
				$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
				print $temp;
			}
		}
		if ($FORM{'xml'}) {	&XML_Head($grandtotal, $first, $last); }
		unless ($allfilter) {
			if ($titlesort) { &sortresults($nextrel[0], $temparray[2], $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, \@highlight, \@result); }
			elsif ($FORM{'viewby'} eq "Source") { &source($nextrel[0], $temparray[2], $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, \@highlight, \@result, \@indeng); }
			elsif ($FORM{'viewby'} eq "Relevance") { &relevance(undef, $temparray[2], $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, \@highlight, \@result, \@indeng); }
			elsif ($FORM{'viewby'} eq "") { &relevance(undef, $temparray[2], $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, \@highlight, \@result, \@indeng); }
		}
		if ($FORM{'xml'}) { &XML_Footer; }

		my ($prevform, $nextform, $numberform) = &linkcode($linkkeys, $method, $withintag, $grandtotal, $newlist2);

		$temp = $temparray[3];
		if ($FORM{'perpage'} >= $grandtotal && $FORM{'page'} == 1) {
			undef $numberform;
			undef $prevform;
			undef $nextform;
		}
		$temp =~ s/<\!-- \[numberform\] -->/$numberform/ig;
		my $rp;
		foreach (@selist) {
			my $checkeng2 = "$selist[$rp]check";
			$temp =~ s/\[$selist[$rp]\]/$$checkeng2/ig;
			$rp++;	
		}
		if ($engtimeout) {
			my $timedout = "<B>Engines that Timedout:</B> $engtimeout";
			$temp =~ s/<\!-- \[EngTimedout\] -->/$timedout/ig;
		}
		$temp =~ s/<\!-- \[prevform\] -->/$prevform/ig;
		$temp =~ s/<\!-- \[nextform\] -->/$nextform/ig;
		$temp =~ s/<\!-- \[banner\] -->/$banner/ig;
		unless ($FORM{'xml'}) { print $temp; }

	} #end timeout if
	if ($FORM{'page'} == 1 && $FORM{'prev'} <=> 1) { &tracker($displaykeys); }
	&main_functions::exit;
}    
###############################################


###############################################
sub get_engines {
	my (@newlist, $totaleng);
	if ($FORM{'page'} > 1 || $FORM{'prev'} == 1) {
		@newlist = split(/\|/, $FORM{'engines'});
		my ($count);
		foreach my $sename(@newlist) {
			my $checkeng = "${sename}check";
			$$checkeng = "CHECKED";
			$count++;
		}
		$totaleng = $count;
	} else {
		my ($newlist, $count, $notsel);
		foreach my $name(@selist) {
			my $checkeng = "${name}check";
			if ($FORM{$name} eq "on") {
				if ($newlist eq "") { $newlist .= "$name"; }
				else { $newlist .= "|$name"; }
				$$checkeng = "CHECKED";
				$count++;
			} else {
				$notsel++;
			}
		}
		if ($notsel == $semod{'senumber'}) {
			my ($t) = 0;
			foreach (@selist) {
				my $checkeng = "$selist[$t]check";
				if ($eng[$t] eq "CHECKED") {
					if ($newlist eq "") { $newlist .= "$selist[$t]"; }
					else { $newlist .= "|$selist[$t]"; }
					$$checkeng = "CHECKED";
					$count++;
				}
				$t++;
			}
		}
		$totaleng = $count;
		@newlist = split(/\|/, $newlist);
	}
	return ($totaleng, @newlist);
}
###############################################


###############################################
sub question {
	my ($normalkeys) = @_;
	my @question = ('how \w+ (.*?)','how \w+ i (.*?)','who \w+ (.*?)','what \w+ (.*?)','where \w+ i \w+ (.*?)','when (.*?)','show me (.*?)','do we (.*?)','help \w\w (.*?)','do i (.*?)');
	my $ignore = ' a about am an and are at be been find for from had has i in me of on or out over shall she sites some them they the to we were will you ';
	my $found = 0;
	foreach (@question){
		if ($normalkeys =~ s/$_/$1/i) {
			$normalkeys =~ s/(.*?)\W+$/$1/i;
			$found=1;
			last;
		}
	}

	if ($found == 1) {
		my @sepkeys = split(' ',$normalkeys);
		undef $normalkeys;
		foreach(@sepkeys){
			unless($ignore =~ / $_ /){
				$normalkeys .= "$_ ";
			}
		}
		$normalkeys =~ s/\b\w\b//;
		$normalkeys =~ s/^\s+//;
		$normalkeys =~ s/\s+$//;
		$normalkeys =~ s/\s+/ /;
	}
	return ($normalkeys);
}
###############################################


###############################################
sub method {
	my ($advkeys) = @_;
	my ($method, $method0, $method1, $method2);
	if ($FORM{'method'} == 2) {
		$advkeys = "'$advkeys'";
		$method2 = "CHECKED";
		$method = "2";
	} elsif ($FORM{'method'} == 1) {
		$advkeys =~ s/\+/\+OR\+/g;
		$method1 = "CHECKED";
		$method = "1";
	} else {
		$method0 = "CHECKED";
		$method = "0";
	}
	return ($method, $advkeys, $method0, $method1, $method2);
}
###############################################


###############################################
sub sort_by {
	my ($method, $withintag, $linkkeys, $newlist2) = @_;
	my ($view, $titlesort, $description);

	if ($FORM{'viewby'} eq "Relevance") { $view .= "<font color=#666666>Relevance</font>"; }
	elsif ($FORM{'viewby'} eq "") { $view .= "<font color=#666666>Relevance</font>"; }
	else { $view .= "<a href='search.$file_ext?results&descrip=0&method=$method&timeout=$FORM{'timeout'}$withintag&keywords=$linkkeys&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&viewby=Relevance&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Relevance</A>"; }
	if ($FORM{'viewby'} eq "Source") { $view .= " | <font color=#666666>Source</font>"; }
	else { $view .= " | <a href='search.$file_ext?results&descrip=0&method=$method&timeout=$FORM{'timeout'}$withintag&keywords=$linkkeys&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&viewby=Source&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Source</A>"; }
	if ($FORM{'viewby'} eq "Title") {
		$view .= " | <font color=#666666>Title</font>";
		$titlesort = 1;
	} else { $view .= " | <a href='search.$file_ext?results&descrip=0&method=$method&timeout=$FORM{'timeout'}$withintag&keywords=$linkkeys&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&viewby=Title&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Title</A>"; }
		if ($FORM{'descrip'} == 1) {
		$description = "<a href='search.$file_ext?results&descrip=0&method=$method&timeout=$FORM{'timeout'}$withintag&keywords=$linkkeys&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&viewby=$FORM{'viewby'}&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Show Summaries</A>";
	} else {
		$description = "<a href='search.$file_ext?results&descrip=1&method=$method&timeout=$FORM{'timeout'}$withintag&keywords=$linkkeys&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&viewby=$FORM{'viewby'}&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Hide Summaries</A>";
	}
	return ($view, $titlesort, $description);
}
###############################################


###############################################
sub linkcode {
	my ($linkkeys, $method, $withintag, $grandtotal, $newlist2) = @_;
	my ($prevform, $nextform, $numberform, $numform, $totalpages);
	my $newpage = $FORM{'page'}+1;
	my $oldpage = $FORM{'page'}-1;
	unless ($grandtotal == 0 || $FORM{'perpage'} == 0) {
		$totalpages = ($grandtotal/$FORM{'perpage'});
	}
	if ($FORM{'page'} == 1) {
		$prevform = " <font color=#666666>Previous</font>";
	} else {
		$prevform = " <a href='search.$file_ext?results&keywords=$linkkeys&page=$oldpage&descrip=$FORM{'descrip'}&method=$method$withintag&perpage=$FORM{'perpage'}&viewby=$FORM{'viewby'}&prev=1&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Previous</A>";
	}
	if ($FORM{'page'} > $totalpages) {
		$nextform = " <font color=#666666>Next</font>";
	} else {
		$nextform = " <a href='search.$file_ext?results&keywords=$linkkeys&page=$newpage&descrip=$FORM{'descrip'}&method=$method$withintag&perpage=$FORM{'perpage'}&viewby=$FORM{'viewby'}&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>Next</A>";
	}
	until ($numform >= $totalpages) {
		$numform++;
		if ($numform == $FORM{'page'}) {
			$numberform .= " <font color=#666666>$numform</font>";
		} else {
			$numberform .= " <a href='search.$file_ext?results&keywords=$linkkeys&page=$numform&descrip=$FORM{'descrip'}&method=$method$withintag&perpage=$FORM{'perpage'}&viewby=$FORM{'viewby'}&prev=1&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>$numform</A>";
		}
	}
	return ($prevform, $nextform, $numberform);
}
###############################################


###############################################
sub gather {
	my ($advkeys, $totaleng, $normalkeys, $gatherlist, $newlist) = @_;
	my ($new, $found, $count, @reqs);
	if ($config{'searchmodule'} eq "LWP") {
		eval("require HTTP::Request"); if ($@) { die "The HTTP::Request module used to connect to search engines appears to not be installed"; }
	}
	
	foreach my $name(@{$gatherlist}) {
		unless ($name eq "Related") {
			my $var2 = "${name}url";
			my $seurl = "$semod{$var2}";
			$seurl =~ s/\[keywords used\]/$advkeys/ig;
			if ($seurl ne '') {
				if ($config{'searchmodule'} eq "LWP") {
					$reqs[$count] = HTTP::Request->new('GET', $seurl);
				} else {
					$reqs[$count] = $seurl;
				}
			}
			$count++;
		}
	}
	my ($engtimeout);
	if ($config{'searchmodule'} eq "LWP") {
		eval("require LWP::Parallel::UserAgent"); if ($@) { die "The LWP::Parallel::UserAgent module used to connect to search engines appears to not be installed"; }
		my $pua = LWP::Parallel::UserAgent->new();
		$pua->in_order  (1);
		$pua->duplicates(1);
		$pua->timeout   ($FORM{'timeout'});
		$pua->redirect  (1);

		foreach my $req (@reqs) {
			if ( my $res = $pua->register ($req) ) {
				STDERR $res->error_as_HTML;
			}
		}
		my $entries = $pua->wait();
		foreach (keys %$entries) {
			my $url;
			my $res=$entries->{$_}->response;
			my $content=($res->content) ? $res->content : $url;
			$url=$res->request->url;
			&get_data($content, $url);
		}
	} else {
		eval("use IO::Socket"); if ($@) { die "The IO::Socket module used to connect to search engines appears to not be installed"; }
		my %entries = &main_functions::my_forker($FORM{'timeout'}, @reqs);
		foreach my $url (keys(%entries)){
			my $content = $entries{"$url"};
			&get_data($content, $url);
		}
	}
	
	sub get_data {
		my ($content, $url) = @_;
		if ($content =~ /</) {
			my @url = split(/\./, $url);
			my $sub = $url[1];
			&$sub($content, $url, %semod);
		}
	}

	#related
	my @search_keys = split(/ /, $normalkeys);
	my ($match);
	foreach (@search_keys) {
		$match .= "m/\Q$_\E/oi||";	
	}
	$match =~s/..$//;
	$match = eval "sub{$match}";
	
	my @related = &database_functions::get_related($match, $normalkeys, $adv[6]);
	
	foreach my $line(@related) {
		chomp($line);
		$semod{'Related'} .= "$line\n";
	}

	foreach my $name(@{$gatherlist}) {
		my @raw_data = split(/\n/, $semod{$name});
		if ($raw_data[0] eq "") {
			($engtimeout, @{$newlist}) = &timeout($name, $totaleng, $engtimeout, @{$newlist});
		} else {
			unless ($name eq "Related" && scalar @raw_data < $adv[5] || $adv[2] == 0) {
				open (FILE, ">${path}cache/$normalkeys-$name.txt");
				foreach my $line(@raw_data) {
					chomp($line);
					unless ($line eq "") {
						print FILE "$line\n";
					}
				}
				close (FILE);
			}
		}
	}
	my ($newlist2);
	($newlist2, @{$newlist}) = &timelink(@{$newlist});
	return ($engtimeout, $totaleng, @{$newlist});
}
###############################################


###############################################
sub timeout {
	my ($name, $totaleng, $engtimeout, @newlist) = @_;
	$totaleng--;
	my ($new);
	foreach my $engtim(@newlist) {
		unless ($engtim eq $name) {
			if ($new eq "") { $new .= "$engtim"; }
			else { $new .= "|$engtim"; }
		} else {
			if ($new eq "") { $new .= "N"; }
			else { $new .= "|N"; }
			if ($engtimeout eq "") { $engtimeout .= "$name"; }
			else { $engtimeout .= ", $name"; }
		}
	}
	@newlist = split(/\|/, $new);
	return ($engtimeout, @newlist);
}
###############################################

###############################################
sub timelink {
	my (@newlist) = @_;
	my ($new);
	foreach my $timlink(@newlist) {
		unless ($timlink eq "" || $timlink eq "N") {
			if ($new eq "") { $new .= "$timlink"; }
			else { $new .= "|$timlink"; }		
		}
	}
	@newlist = split(/\|/, $new);
	my $newlist2 = "@newlist";
	return($newlist2, @newlist);
}
###############################################

###############################################
sub sort_gathered {
	my ($totaleng, $method, $normalkeys, @newlist) = @_;
	my (@newdata, $grandtotal, $totalcount2, $newlist2, $urlarr);
	foreach my $name(@newlist) {
		my $engcount2=0;
		chomp($name);
		my @data;
		if ($adv[2] == 0) { @data = split(/\n/, $semod{$name}); }
		else {
			open (FILE, "${path}cache/$normalkeys-$name.txt");
			@data = <FILE>;
			close (FILE);
		}
		my $totalcount;
		foreach my $line(@data) {
			chomp($line);
			my @data2 = split(/\|/, $line);
			unless ($data2[0] eq "" || $data2[1] eq "" || $data2[2] eq "") {
				my @urlarr = split(/\|/, $urlarr);
				my ($found, $counter, $arrnum);
				my $dupurl = $data2[0];
				$dupurl =~ s/http:\/\///;
				$dupurl =~ s/www.//;
				foreach my $arr(@urlarr) {
					if ($arr eq $dupurl) {
						$found=1;
						$arrnum=$counter;
						last;
					}
					$counter++;
				}
				unless ($found) {
					$newdata[$totalcount2] = "$name|$data2[0]|$data2[1]|$data2[2]|$name\n";
					$urlarr .= "$dupurl|";
					$totalcount++;
					$totalcount2++;
				} else {
					unless ($newdata[$arrnum] =~ /$name/) {
						chomp($newdata[$arrnum]);
						$newdata[$arrnum] = "$newdata[$arrnum]\^$name\n";
					}
				}
			}
		}
		$engcount2++;
		unless ($totalcount == 0) {
			$newdata[$totalcount2] = "SPLITTER\n";
			$urlarr .= "|";
			$totalcount2++;
			$grandtotal = $grandtotal+$totalcount;	
		}
	}
	($newlist2, @newlist) = &timelink(@newlist);
	$newdata[$totalcount2] = "NEXTRELATED\n";
	$totalcount2++;
	$newdata[$totalcount2] = "$newlist2 $method\n";
	$totalcount2++;
	if ($opt[2] eq "CHECKED") {
		my @Related;
		if ($adv[2] == 0) { @Related = split(/\n/, $semod{'Related'}); }
		else {
			open (FILE, "${path}cache/$normalkeys-Related.txt");
			@Related = <FILE>;
			close (FILE);
		}
		my ($llcount);
		foreach my $linkline(@Related) {
			chomp($linkline);
			$llcount++;
			$newdata[$totalcount2] = "$linkline\n";
			$totalcount2++;
		}
	}
	return ($grandtotal, @newdata);
}
###############################################


###############################################
sub searchwithin {
	my ($displaykeys, $indeng, $temparray, $result) = @_;
	my (@within, @within2, $newtotal, $bidnewtotal, @indeng, $grandtotal);
	foreach my $line(@{$indeng}) {
		my @inner = split(/\n/, $line);
		foreach my $line2(@inner) {
			chomp($line2);
			my @newdata = split(/\|/, $line2);
			if ($newdata[1] =~ /$FORM{'oldkeys'}/i || $newdata[2] =~ /$FORM{'oldkeys'}/i || $newdata[3] =~ /$FORM{'oldkeys'}/i) {
				$within[$newtotal] = "$line2\n";
				$newtotal++;
				$grandtotal++;
			} 	
		}
		$within[$newtotal] = "SPLITTER\n";
		$newtotal++;
	}
	foreach my $line(@{$result}) {
		chomp($line);
		my @newdata = split(/\|/, $line);
		if ($newdata[2] =~ /$FORM{'oldkeys'}/i || $newdata[3] =~ /$FORM{'oldkeys'}/i || $newdata[4] =~ /$FORM{'oldkeys'}/i) {
			$within2[$bidnewtotal] = "$line\n";
			$bidnewtotal++;
			$grandtotal++;
		}
	}
	my $ovrlim = ($FORM{'page'}*$FORM{'perpage'}) - $grandtotal;
	if ($grandtotal == 0) {
		my $message = "No Results Found";
		&dismess($message, $displaykeys, @{$temparray});
	} elsif ($ovrlim > $FORM{'perpage'}) {
		my $message = "No More Results Found";
		&dismess($message, $displaykeys, @{$temparray});
	} else {
		@{$result} = @within2;
		my $splitter = "@within";
		@{$indeng} = split(/ SPLITTER\n/, $splitter);
	}
	return ($grandtotal);
}
###############################################

###############################################
sub related {
	my ($nextrel1, $normalkeys, $newlist2, @wordfilter) = @_;
	my $found=0;
	if ($FORM{'wordfilter'} eq "on" && -e "${path}template/wordfilter.txt") {
		foreach my $word(@wordfilter) {
			chomp($word);
			if ($normalkeys =~ /$word/i) {
				$found=1;
				last;
			}
		}
	}
	my (@lline, $llcount);
	if ($found == 0 && $opt[2] eq "CHECKED") {
		my @Related = split(/\n/, $nextrel1);
		if ($#Related >= $adv[5]) {
			foreach (@Related) {
				$llcount++;
				my $linkline = $Related[$llcount];
				if ($linkline eq "") {
					last;
				}
				$linkline =~ s/^\s+//;
				my $linkline2 = $linkline;
				$linkline2 =~ tr/ /+/;
				$lline[$llcount] = "<a href='search.$file_ext?results&descrip=0&timeout=$FORM{'timeout'}&keywords=$linkline2&page=1&perpage=$FORM{'perpage'}&prev=1&wordfilter=$FORM{'wordfilter'}&engines=$newlist2'>$linkline</a>";
				last if $llcount == $adv[6];
			}
		}
	}
	$llcount--;
	return ($llcount, @lline);
}
###############################################

###############################################
sub dismess {
	my ($message, $displaykeys, @temparray) = @_;
	if ($FORM{'xml'}) {
		&XML_Head(0, 0, 0);
		&XML_Footer;
		&main_functions::exit;
	}
	my $temp = $temparray[1];
	$temp =~ s/<\!-- \[first\] -->/0/ig;
	$temp =~ s/<\!-- \[last\] -->/0/ig;
	$temp =~ s/<\!-- \[found\] -->/0/ig;
	print $temp;
	print "<BR><B><font color=red>$message</font></B>";
	$temp = "$temparray[3]";
	foreach my $line(@selist) {
		my $checkeng2 = "${line}check";
		$temp =~ s/\[$line\]/$$checkeng2/ig;
	}
	$temp =~ s/<\!-- \[timeout\] -->/$FORM{'timeout'}/ig;
	$temp =~ s/<\!-- \[perpage\] -->/$FORM{'perpage'}/ig;
	$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
	print $temp;
	&main_functions::exit;
}
###############################################

###############################################
sub highlight {
	my ($highlight, $highlight2) = @_;
	foreach my $term(@{$highlight2}) {
		unless (length($term) < 3) {
			my $boldterm = $term;
			$boldterm =~ s/\%2b//g;
			$highlight =~ s/\b($boldterm)\b/<b>$1<\/b>/gis;
		}
	}
	return $highlight;
}
###############################################

###############################################
sub wordfilter {
	my ($grandtotal2, $indeng, $wordfilter, $result) = @_;
	my ($grandtotal, @wfilter, $newtotal2, $bidnewtotal2, $filtered, $allfilter);
	foreach my $line(@{$indeng}) {
		my @inner = split(/\n/, $line);
		foreach my $line2(@inner) {
			chomp($line2);
			if ($line2 =~ /\|/) {
				my @newdata = split(/\|/, $line2);
				my $found=0;
				for my $word(@{$wordfilter}) {
					chomp($word);
					$word =~ s/\r+//;
					if ($newdata[2] =~ /\b$word\b/i || $newdata[3] =~ /\b$word\b/i) {
						$found=1;
						last;
					}
				}
				unless ($found == 1) {
					$wfilter[$newtotal2] = "$line2\n";
					$newtotal2++;
					$grandtotal++;
				}
			}
		}
		$wfilter[$newtotal2] = "SPLITTER\n";
		$newtotal2++;
	}
	my $splitter = "@wfilter";
	@{$indeng} = split(/ SPLITTER\n/, $splitter);
	my (@wfilter2, @result);
	if (@{$result}) {
		foreach my $line(@{$result}) {
			chomp($line);
			my @newdata = split(/\|/, $line);
			my $found=0;
			for my $word(@{$wordfilter}) {
				chomp($word);
				$word =~ s/\r+//;
				if ($newdata[2] =~ /\b$word\b/i || $newdata[4] =~ /\b$word\b/i) {
					$found=1;
					last;
				}
			}
			unless ($found == 1) {
				$wfilter2[$bidnewtotal2] = "$line\n";
				$bidnewtotal2++;
				$grandtotal++;
			}
		}
		@result = @wfilter2;
	}
	my $filtercount = $grandtotal2-$grandtotal;
	unless ($filtercount == 0) { $filtered = "Family Filtered $filtercount Results"; }
	if ($filtercount == $grandtotal2) {
		$filtered .= "<BR><B><font color=red>All of the Results have been Filtered</font></B>";
		$allfilter = 1;
	}
	return ($allfilter, $filtered, @result);
}
###############################################

###############################################
sub domainfilter {
	my ($grandtotal2, @indeng) = @_;
	my ($grandtotal, @dfilter, $newtotal2);
	open(FILE, "${path}template/domainfilter.txt");
	my @domainfilter = <FILE>;
	close(FILE);
	foreach my $line(@indeng) {
		my @inner = split(/\n/, $line);
		foreach my $line2(@inner) {
			chomp($line2);
			if ($line2 =~ /\|/) {
				my @newdata = split(/\|/, $line2);
				my $found=0;
				foreach my $domain(@domainfilter) {
					chomp($domain);
					$domain =~ s/\r+//;
					if ($newdata[1] =~ /$domain/i) {
						$found=1;
						last;
					}
				}
				unless ($found == 1) {
					$dfilter[$newtotal2] = "$line2\n";
					$newtotal2++;
					$grandtotal++;
				}
			}
		}
		$dfilter[$newtotal2] = "SPLITTER\n";
		$newtotal2++;
	}
	my $splitter = "@dfilter";
	@indeng = split(/ SPLITTER\n/, $splitter);
	return ($grandtotal, @indeng);
}
###############################################

###############################################
sub sortresults {
	my ($nextrel0, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, $highlight, $result) = @_;
	my ($newtotal2, @indeng);
	my $sortcount = 1;
	my @sorted = split(/\n/, $nextrel0);
	my @sorted_links =
	sort {
		my @field_a = split /\|/, $a;
		my @field_b = split /\|/, $b;
			$field_a[2] cmp $field_b[2]
			;
		} @sorted; 
			
	foreach my $line(@sorted_links) {
		chomp($line);
		$indeng[$newtotal2] = "$line\n";
		$newtotal2++;
	}
	&relevance($sortcount, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, $highlight, $result, \@indeng);
}
###############################################

###############################################
sub relevance {
	my ($sortcount, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, $highlight, $result, $indeng) = @_;
	my ($newnumb, $indnum, @data, $num);
	if (@{$result} >= 0) {
		foreach my $line(@{$result}) {
			$num++;
			if ($num > $nextpage) {
				chomp($line);
				last if ($newnumb >= $FORM{'perpage'}); 
				$data[$indnum] = $line;
				&displaydata('bidsearch', $num, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $affpay, $advkeys, $non, $indnum, $newnumb, $data[$indnum], $highlight);
				$newnumb++;
				if ($num == $grandtotal) { $newnumb = $FORM{'perpage'} }
			}
			$indnum++;
		}
	}

	unless ($sortcount) {
		my ($reltotal, $leftcount, @leftover, @reltop);
		foreach my $line(@{$indeng}) {
			my @inner = split(/\n/, $line);
			foreach my $line2(@inner) {
				chomp($line2);
				my @inner2 = split(/\|/, $line2);
				if ($inner2[4] =~ /\^/) {
					my @source = split(/\^/, $inner2[4]);
					my $relcount = 0;
					foreach (@source) { $relcount++; }
					$reltop[$reltotal] = "$relcount|$line2\n";
					$reltotal++;
				} else {
					$leftover[$leftcount] = "$line2\n";
				}
				$leftcount++;
			}
			$leftover[$leftcount] = "SPLITTER\n";
			$leftcount++;
		}
		my $splitter = "@leftover";
		@{$indeng} = split(/ SPLITTER\n/, $splitter);
		@reltop = reverse sort {$a <=> $b} @reltop;
		my ($indnum) = 0;
		foreach my $line(@reltop) {
			$num++;
			if ($num > $nextpage) {
				chomp($line);
				$data[$indnum] = $line;
				last if ($newnumb >= $FORM{'perpage'}); 
				&displaydata('reltop', $num, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $affpay, $advkeys, $non, $indnum, $newnumb, $data[$indnum], $highlight);
				$newnumb++;
				if ($num == $grandtotal) { $newnumb = $FORM{'perpage'} }
			}
			$indnum++;
		}
	}
	$indnum = 0;
	my $iloop_exit =  0;
	until ($newnumb == $FORM{'perpage'}) {
		foreach my $line(@{$indeng}) {
			my @data = split(/\n/, $line);
			if ($data[$indnum] =~ /\|/) {
				$num++;
				if ($num > $nextpage) {
					&displaydata(undef, $num, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $affpay, $advkeys, $non, $indnum, $newnumb, $data[$indnum], $highlight);
					$newnumb++;
					if ($num == $grandtotal) { $newnumb = $FORM{'perpage'} }
					last if ($newnumb == $FORM{'perpage'});
				}
				##they have found a result so reset infinite loop counter
				$iloop_exit = 0;
 		 	} else {
				##the index was large enough that they did not find any results
				$iloop_exit++;
			}
		} #End foreach $line(@indeng) {
		$indnum++;
		return if ($iloop_exit > scalar(@{$indeng}));
	} #End Until
}
###############################################


###############################################
sub source {
	my ($nextrel0, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $nextpage, $affpay, $advkeys, $non, $highlight, $result, $indeng) = @_;
	my ($newnumb, $indnum, @data, $num);
	if (@{$result} >= 0) {
		foreach my $line(@{$result}) {
			$num++;
			if ($num > $nextpage) {
				chomp($line);
				$data[$indnum] = $line;
				$newnumb = &displaydata('bidsearch', $num, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $affpay, $advkeys, $non, $indnum, $newnumb, $data[$indnum], $highlight);
				$newnumb++;
				if ($num == $grandtotal) { $newnumb = $FORM{'perpage'} }
				last if ($newnumb == $FORM{'perpage'});
			}
			$indnum++;
		}
	}
	$indnum = 0;
	my $iloop_exit = 0;
	my @ealine = split(/\n/, $nextrel0);
	until ($newnumb == $FORM{'perpage'}) {
		foreach my $line(@ealine) {
			if ($line =~ /\|/ && $line !~ /SPLITTER/) {
				$num++;
				if ($num > $nextpage) {
					$data[$indnum] = $line;
					&displaydata(undef, $num, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $affpay, $advkeys, $non, $indnum, $newnumb, $data[$indnum], $highlight);
					$newnumb++;
					if ($num == $grandtotal) { $newnumb = $FORM{'perpage'} }
					last if ($newnumb == $FORM{'perpage'});
				}
				$indnum++;
				$iloop_exit = 0;
			} else {
				$iloop_exit++;
			}
		}
		return if($iloop_exit > scalar(@{$indeng}));
	}
}
###############################################


###############################################
sub displaydata {
	my ($type, $num, $temparray2, $grandtotal, $bidkeys, $linkkeys, $method, $newlist2, $affpay, $advkeys, $non, $indnum, $newnumb, $data, $highlight) = @_;
	my ($high, $qtitle, $morelikethis, $biduser2, $qurl, @source2, @sources, $bidurl);
	my @data2 = split(/\|/, $data);
	my $temp = $temparray2;
	if ($type eq "bidsearch") {
		$high = $data2[4];
		$qtitle = $data2[2];
		$morelikethis = $data2[2];
		$bidkeys =~ tr/ /+/;
		my $site_id = $data2[6];
		my ($biduser);
		($biduser, $bidurl) = ($data2[1], $data2[3]);
		$biduser2 = $biduser;
		my $encryptkey = "drbidsearch";
		$biduser = &main_functions::Encrypt($biduser,$encryptkey,'asdfhzxcvnmpoiyk');
		$bidurl = &main_functions::Encrypt($bidurl,$encryptkey,'asdfhzxcvnmpoiyk');
		if ($opt[3] eq "CHECKED" && -e "${path}template/frame.txt") {
			$qurl = "search.$file_ext?tab=bidclick&url=$bidurl&biduser=$biduser&keywords=$bidkeys&id=$site_id&page=$FORM{'page'}&method=$method&perpage=$FORM{'perpage'}&engines=$newlist2";
		} else {
			$qurl = "search.$file_ext?tab=bidclick&url=$bidurl&biduser=$biduser&keywords=$bidkeys&id=$site_id";
		}
		if ($FORM{'member'} && $affpay <=> 1) { $qurl .= "&member=$FORM{'member'}"; }
		if ($non) { $qurl = "$qurl&non=1"; }
		$bidurl = $data2[3];
		$source2[$newnumb] = "Cost to Advertise: <a href='$config{'secureurl'}signup.$file_ext'>$adv[15]$data2[0]</a>";
	} elsif ($type eq "reltop") {
		$high = $data2[4];
		my $source	 = $data2[5];
		$qtitle = $data2[3];
		$morelikethis = $data2[3];
		$qurl = $data2[2];
		@sources = split(/\^/, $source);
	} else {
		$high = $data2[3];
		my $source = $data2[4];
		$qtitle = $data2[2];
		$morelikethis = $data2[2];
		$qurl = $data2[1];
		@sources = split(/\^/, $source);
	}
	if ($FORM{'descrip'} == 1) {
		$temp =~ s/<!-- \[descrip\] -->(.*?)<!-- \[descrip\] -->//si;
	}
	my $srccount=0;
	unless ($type eq "bidsearch") {
		foreach my $src(@sources) {
			my $var4 = "${src}urldis";
			my $disurl = "$semod{$var4}";
			$disurl =~ s/\[keywords used\]/$advkeys/ig;
			if ($opt[3] eq "CHECKED" && -e "${path}template/frame.txt") {
				my $frameurl1 = $disurl;
				$frameurl1 =~ s/\&/%26/g;
				$frameurl1 =~ s/\?/%3F/g;
				$frameurl1 =~ s/\=/%3D/g;
				$disurl = "search.$file_ext?keywords=$linkkeys&url=$frameurl1&page=$FORM{'page'}&method=$method&perpage=$FORM{'perpage'}&engines=$newlist2";
			}
			if ($srccount == 0) { $source2[$newnumb] .= "<A Href ='$disurl' TARGET='new'>$src</A>"; }
			else { $source2[$newnumb] .= ", <A Href ='$disurl' TARGET='new'>$src</A>"; }
			$srccount++;
		}
	}
	my ($newurl);
	if ($opt[3] eq "CHECKED" && -e "${path}template/frame.txt" && $type ne "bidsearch") {
		my $frameurl1 = $qurl;
		$frameurl1 =~ s/\&/%26/g;
		$frameurl1 =~ s/\?/%3F/g;
		$frameurl1 =~ s/\=/%3D/g;
		$newurl = "search.$file_ext?keywords=$linkkeys&url=$frameurl1&page=$FORM{'page'}&method=$method&perpage=$FORM{'perpage'}&engines=$newlist2";
	} else { $newurl = $qurl; }
	my ($ptitle, $purl, $burl);
	($morelikethis, $ptitle, $high, $purl, $burl) = &edit_vars($qurl, $qtitle, $type, $high, $bidurl, $morelikethis, $highlight);
	$temp =~ s/<!-- \[number\] -->/$num/ig;
	$temp =~ s/<!-- \[url\] -->/$newurl/ig;
	$temp =~ s/<!-- \[title\] -->/$ptitle/ig;
	$temp =~ s/<!-- \[biduser\] -->/$biduser2/ig;
	if ($type eq "bidsearch" && $adv[12] ne "") { $temp =~ s/<!-- \[image\] -->/<img src=$adv[12]>/ig; }				
	unless ($FORM{'descrip'} == 1) { $temp =~ s/<!-- \[description\] -->/<dd>$high/ig; }
	if ($type eq "bidsearch") { $temp =~ s/<!-- \[printurl\] -->/<BR>$burl/ig; }
	else { $temp =~ s/<!-- \[printurl\] -->/<BR>$purl/ig; }
	$temp =~ s/<!-- \[source\] -->/$source2[$newnumb]/ig;
	$temp =~ s/<!-- \[morelikethis\] -->/$morelikethis/ig;
	$| = 1;
	unless ($FORM{'xml'}) {
		print $temp;
	} else {
		&XML_Record($num, $newurl, $ptitle, $adv[12], $high, $burl, $purl, $source2[$newnumb], $morelikethis);
	}
}
###############################################


###############################################
sub edit_vars {
	my ($qurl, $qtitle, $type, $high, $bidurl, $morelikethis, $highlight) = @_;
	my $cutoff = $adv[3];
	my $dot = $cutoff-2;
	my ($ptitle, $purl, $burl);
	length($qtitle) > $cutoff ? ($ptitle = substr($qtitle,0,$dot) . "..."):($ptitle = $qtitle);
	length($qurl) > $cutoff ? ($purl = substr($qurl,0,$dot) . "..."):($purl = $qurl);
	if ($type eq "bidsearch") { length($bidurl) > $cutoff ? ($burl = substr($bidurl,0,$dot) . "..."):($burl = $bidurl); }
	if ($opt[6] eq "CHECKED") {
		$high = highlight($high, $highlight);
		$ptitle = highlight($ptitle, $highlight);
	}
	$ptitle = translate($ptitle);
	$high = translate($high);
	$morelikethis =~ tr/ /+/;
	$morelikethis = "$config{'adminurl'}search.$file_ext?results&keywords=$morelikethis&page=1&descrip=$FORM{'descrip'}&perpage=$FORM{'perpage'}";
	return ($morelikethis, $ptitle, $high, $purl, $burl);
}
###############################################


###############################################
sub XML_Footer {
	print "</results>";
}
###############################################

###############################################
sub XML_Head {
	my ($grandtotal, $first, $last) = @_;
	print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
	print "<results total=\"$grandtotal\" start=\"$first\" end=\"$last\">";
}
###############################################

###############################################
sub XML_Record {
	my @data = @_;
	my $mybid;
	
	##remove the highlited words
	$data[4] =~ s/<b>|<\/b>//ig;
	$data[2] =~ s/<b>|<\/b>//ig;
	##now we replace illegal characters and spaces
	for(my $i = 0; $i < @data; $i++) {
		$data[$i] =~ s/&/&amp;/g;
		$data[$i] =~ s/</&lt;/g;
		$data[$i] =~ s/>/&gt;/g;	
	}
	
	print 
"<record>
	<id>$data[0]</id>
	<title>$data[2]</title>
	<description>$data[4]</description>
	<url>$data[5]</url>
	<bidUrl>$data[1]</bidUrl>
	<sources>
";
	if($data[7] =~ /Cost to Advertise:.*\$([\d\.]+)/) {
		$mybid = $1;
		$data[7] = '';	
	} else {
		##we need to parse out the source links
		my $count = 0;
		
		#lets split the sources by the commas that the other inserted
		my @refs = split(/,/, $data[7]);
		foreach my $ref (@refs) {
			$count++;
			##pull out the url
			$ref =~ /'(.+?)'/;
			print "		<sourceUrl id='$count'>$1</sourceUrl>";
		}
		
	}
	##xml info
	
	###pad the bid.  Remove if you wish
	if (!$mybid) {
		$mybid = "0.00";	
	}
	print 
"	</sources>
	<bid>$mybid</bid>
	<moreLikeThis>$data[8]</moreLikeThis>
</record>\n";
}
###############################################

###############################################
sub translate {
	my $translate = $_[0];
	$translate =~ s/(&#34|&quot);/"/og;
	$translate =~ s/&#35;/#/og;
	$translate =~ s/&#36;/\$/og;
	$translate =~ s/&#37;/\%/og;
	$translate =~ s/(&#38|&amp);/&/og;
	$translate =~ s/&apos;/'/og;
	return $translate;
}
###############################################
	
###############################################
# Get Banner Targets
sub banner {
	my ($displaykeys, $framebanner) = @_;
	$displaykeys =~ s/&quot;/'/g;
	$displaykeys = lc($displaykeys);
	my @keywords = split('', $displaykeys);
	my $var=$keywords[0];
	open (FILE, "${path}banner/$var.txt");
	my @data = <FILE>;
	close (FILE);
	my $found=0;
	my ($banner);
	foreach my $tar(@data) {
		my @target = split(/\|/,$tar);
		chomp($target[0]);
		if ($displaykeys eq "$target[0]") {
			chomp($target[3]);
			$found=1;
			$banner = "<a href='$target[2]' $framebanner border=0><img src='$target[1]' alt='$target[3]' border=0></a>";
			last;
		}
	}
	if ($found == 0) {
		if (-e "${path}banner/notfound.txt") {
			open (FILE, "${path}banner/notfound.txt");
			my @dat = <FILE>;
			close (FILE);
			my @target = split(/\|/,$dat[0]);
			$banner = "<a href='$target[2]' $framebanner border=0><img src='$target[1]' alt='$target[3]' border=0></a>";
		}
	}
	return ($banner);
} # end banner sub
###############################################

###############################################
# Get Tracked Keywords
sub tracker {
	my ($displaykeys2) = @_;
	$displaykeys2 =~ s/&quot;/\"/g;
	if ($opt[5] eq "CHECKED") { &database_functions::searcheslog($displaykeys2); }
	if ($opt[4] eq "CHECKED") { &database_functions::dailystats; }
}
###############################################

###############################################
sub bidclick {
	my $account = $FORM{'biduser'};
	my $url = $FORM{'url'};
	my $encryptkey = "drbidsearch";
	$url = &main_functions::Decrypt($url,$encryptkey,'asdfhzxcvnmpoiyk');
	$FORM{'url'} = $url;
	$account = &main_functions::Decrypt($account,$encryptkey,'asdfhzxcvnmpoiyk');
	my $keywords = $FORM{'keywords'};
	$keywords =~ tr/+/ /;
	$keywords = lc($keywords);

	if ($FORM{'non'}) {	$keywords = "Non-Targeted Listing"; }

	my @listing = &database_functions::GetSearch($keywords);
	my ($urlfound, $bid, $cookiefound);
	foreach my $line(@listing) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($FORM{'id'}) {
			if ($inner[1] eq $account && $inner[6] eq $FORM{'id'}) {
				$bid = $inner[0];
				$urlfound = 1;
			}
		} else {
			if ($inner[1] eq $account) {
				$bid = $inner[0];
				$urlfound = 1;
			}
		}
	}

	if ($config{'data'} eq "mysql") {
		$account = &database_functions::escape($account);
		my $statement = "select id from users where username='$account'";
		my $sth = &database_functions::mySQL($statement);
		if ($sth->rows == 0) { $urlfound = 0 }
	} else {
		 if (not(-e "${path}data/users/$account.txt")) { $urlfound = 0 }
	}

	if ($urlfound == 0) {
		if ($FORM{'page'}) { &frame; }
		else { print "Location: $url\n\n"; }
		&main_functions::exit;
	}

	if ($opt[7] eq "CHECKED") {
		$cookiefound = &database_functions::unique_click($keywords, $account);
	}

	if ($FORM{'member'}) {
		$FORM{'keyword'} = $keywords;
		$FORM{'biduser'} = $account;
		$FORM{'bid'} = $bid;
		do "${path}affiliate/click.$config{'extension'}";
		&click_functions::add_click(%FORM);
		do "${path}config/config.cgi";
		if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
		else { do "${path}functions_text.$file_ext"; }
		do "${path}functions.$file_ext";
	}

	if ($FORM{'member'}) {
		$FORM{'keyword'} = $keywords;
		$FORM{'biduser'} = $account;
		$FORM{'bid'} = $bid;
		do "${path}affiliate/click.cgi";
	#	&click_functions::add_click(%FORM);
	#	do "${path}config/config.cgi";
	#	if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
	#	else { do "${path}functions_text.$file_ext"; }
	#	do "${path}functions.$file_ext";
	}

	if ($FORM{'page'}) { &frame; }
	else { print "Location: $url\n\n"; }

	if ($urlfound == 1 && $cookiefound == 0) {
		my $newdate = &main_functions::getdate;
		my ($grand, $avg, $balance, $oldbalance) = &database_functions::update_stats($keywords, $account, $newdate, $bid, $FORM{'id'});
		my ($daysleft2, $daysleft);
		if ($grand) {
			$daysleft2 = $oldbalance/$avg;
			$daysleft2 = sprintf("%.0f", $daysleft2);
			$daysleft = $balance/$avg;
			$daysleft = sprintf("%.0f", $daysleft);
			$avg = sprintf("%.2f", $avg);
		}

		if ($balance < 0.01) { &remove($account); }
		elsif ($oldbalance >= $adv[11] && $balance < $adv[11]) { &warning($avg, $daysleft, $balance, $account); }
		elsif ($daysleft2 > $adv[10] && $daysleft <= $adv[10] && $grand) { &warning($avg, $daysleft, $balance, $account); }
	}
	&main_functions::exit;
}
###############################################


###############################################
sub warning {
	my ($avg, $daysleft, $balance, $account) = @_;
	my ($memurl, $emailtemp);
	my @info = &database_functions::GetUser($account);
	open (FILE, "${path}template/emailwarning.txt");
	my @emailmess = <FILE>;
	close (FILE);
	foreach my $emailtemp2(@emailmess) {
		chomp($emailtemp2);
		$emailtemp .= "$emailtemp2\n";
	}
	my $newdate = &main_functions::getdate;
	unless ($config{'secureurl'} eq "") { $memurl = $config{'secureurl'}; }
	else { $memurl = $config{'adminurl'}; }
	$emailtemp =~ s/\[name\]/$info[0]/ig;
	$emailtemp =~ s/\[balance\]/$balance/ig;
	$emailtemp =~ s/\[date\]/$newdate/ig;
	$emailtemp =~ s/\[avg\]/$adv[15]$avg/ig;
	$emailtemp =~ s/\[days\]/$daysleft/ig;
	$emailtemp =~ s/\[members\]/${memurl}members.$file_ext/ig;
	$emailtemp =~ s/\[company\]/$config{'company'}/ig;
	$emailtemp =~ s/\[url\]/$config{'websiteurl'}/ig;
	my $subject = "$config{'company'} - Balance Low";
	&main_functions::send_email($config{'adminemail'}, $info[8], $subject, $emailtemp);
}
###############################################


###############################################
sub remove {
	my ($account) = @_;
	&database_functions::make_inactive($account);
	my ($memurl, $emailtemp);
	my @info = &database_functions::GetUser($account);
	open (FILE, "${path}template/emailremove.txt");
	my @emailmess = <FILE>;
	close (FILE);
	foreach my $emailtemp2(@emailmess) {
		chomp($emailtemp2);
		$emailtemp .= "$emailtemp2\n";
	}
	unless ($config{'secureurl'} eq "") { $memurl = $config{'secureurl'}; }
	else { $memurl = $config{'adminurl'}; }
	$emailtemp =~ s/\[name\]/$info[0]/ig;
	$emailtemp =~ s/\[members\]/${memurl}members.$file_ext/ig;
	$emailtemp =~ s/\[company\]/$config{'company'}/ig;
	$emailtemp =~ s/\[url\]/$config{'websiteurl'}/ig;
	my $subject = "$config{'company'} - Account Offline";
	&main_functions::send_email($config{'adminemail'}, $info[8], $subject, $emailtemp);
}
###############################################