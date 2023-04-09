#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/metasearch/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# MetaSearch by Done-Right Scripts
# Main Script
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# None of the code below needs to be edited below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2000 Done-Right. All rights reserved.


###############################################
# Read Input
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
# Logics
if ($FORM{'keywords'}) { &results; }
else { &main; }
###############################################

###############################################
# Module Sub
sub modsub {
	require "${path}$searchmod/template/$searchmod.cgi";
	$selist = "$semod{'search_engines'}";
	$enginelist = $selist;
	@selist = split(/\|/,$enginelist);
}
###############################################

###############################################
# Main Sub, Prints Out Seach Box & Categories etc.
sub main {
require "${path}config/config.cgi";
if ($FORM{'search'} eq "") { $searchmod = "$config{'default'}"; }
else { $searchmod = "\u$FORM{'search'}"; }
&modsub;

open (FILE, "${path}$searchmod/template/defaults.txt");
@data2=<FILE>;
@adv = split(/\|/, $data2[1]);
close (FILE);
open (FILE, "${path}$searchmod/template/searchstart.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";

@defeng = split(/\|/, $data2[0]);
chomp(@defeng);
chomp(@adv);
foreach (@defeng) {
	if ($defeng[$t] eq "CHECKED") { $$selist[$t] = "CHECKED"; }
	$temp =~ s/\[$selist[$t]\]/$$selist[$t]/ig;
	$t++;
}

$temp =~ s/<\!-- \[timeout\] -->/$adv[1]/ig;
$temp =~ s/<\!-- \[perpage\] -->/$adv[0]/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;
}
###############################################

###############################################
# Search Results
sub results {
$searchmod = $FORM{'searchtype'};
if ($searchmod eq "") {
	require "${path}config/config.cgi";
	$searchmod = $config{'default'};	
}
&modsub;
&variables;

open (FILE, "${path}$searchmod/template/searchresults.txt");
@tempfile = <FILE>;
close (FILE);
$temp2="@tempfile";
@temparray = split(/<\!-- \[break\] -->/,$temp2);


$temp = "$temparray[0]";
foreach $name(@newlist) {
	$checkeng = "${name}check";
	$temp =~ s/\[$name\]/$$checkeng/ig;
}
$temp =~ s/<\!-- \[timeout\] -->/$FORM{'timeout'}/ig;
$temp =~ s/<\!-- \[perpage\] -->/$FORM{'perpage'}/ig;
$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
$temp =~ s/\[method0\]/$method0/ig;
$temp =~ s/\[method1\]/$method1/ig;
$temp =~ s/\[method2\]/$method2/ig;
$| = (@ARGV > 0);
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
if (-e "${path}$searchmod/cache/$normalkeys.txt") {
	$age = -M "$searchmod/cache/$normalkeys.txt";
	if ($age > $advanced[2]) { &gather; }
	else {
		open (FILE, "${path}$searchmod/cache/$normalkeys.txt");
		@newdata2 = <FILE>;
		close (FILE);
		$oldlist2 = "@newdata2";
		@oldlist = split(/NEXTRELATED\n/, $oldlist2);
		@oldlist2 = split(/\n/, $oldlist[1]);
		$oldlist1 = $oldlist2[0];
		$oldlist1 =~ s/^\s+//;
		$oldlist1 =~ s/\s+$//;
		$newlist1 = "@newlist $method";
		unless ($oldlist1 eq $newlist1) { &gather; }
		else {
			@newdata = @newdata2;
			foreach $line(@newdata) {
				last if ($line =~ /NEXTRELATED/);
				unless ($line =~ /SPLITTER/ || $line eq "") { $grandtotal++; }
			}
		}
	}
} else {
	&gather;
}
&display;

}    
###############################################

###############################################
sub variables {

open (FILE, "${path}$searchmod/template/defaults.txt");
@defaults = <FILE>;
close (FILE);
@advanced = split(/\|/, $defaults[1]);
@options = split(/\|/, $defaults[4]);
chomp(@options);
chomp(@advanced);
unless ($FORM{'page'}) { $FORM{'page'} = 1; }
unless ($FORM{'perpage'}) { $FORM{'perpage'} = $advanced[0]; }
unless ($FORM{'timeout'}) { $FORM{'timeout'} = $advanced[1]; } else { $timeout = $FORM{'timeout'}; }
unless ($FORM{'descrip'}) { $FORM{'descrip'} = 0; }

$last = $FORM{'perpage'}*$FORM{'page'};
$first = $last-($FORM{'perpage'}-1);
$FORM{'keywords'} =~ s/^ //g;
$FORM{'keywords'} =~ s/ $//g;
$FORM{'keywords'} =~ s/\+/%2b/g;
$displaykeys = $normalkeys = $linkkeys = $FORM{'keywords'};
$linkkeys =~ s/\"/%22/g;
$linkkeys =~ tr/ /+/;
$displaykeys =~ s/\"/&quot;/g;
$displaykeys =~ s/%2b/+/g;
$normalkeys =~ tr/A-Z/a-z/;
$displaykeys =~ s/%28/\(/g;
$displaykeys =~ s/%29/\)/g;


$searchform = $FORM{'searchform'};
if ($FORM{'page'} > 1 || $FORM{'prev'} == 1) {
	@newlist = split(/\|/, $FORM{'engines'});
	foreach $sename(@newlist) {
		$checkeng = "${sename}check";
		$$checkeng = "CHECKED";
		$count++;
	}
	$totaleng = $count;
} else {
	if ($searchmod ne $searchform && $FORM{'page'} == 1) {
		&othersearch;
	} else {
		foreach $name(@selist) {
			$checkeng = "${name}check";
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
			&othersearch;
		}
	}
	$totaleng = $count;
	@newlist = split(/\|/, $newlist);
}

@highlight = split(/ /, $normalkeys);
$advkeys = $normalkeys;
$normalkeys =~ s/%2b/+/g;
$normalkeys =~ s/%28/\(/g;
$normalkeys =~ s/%29/\)/g;
$advkeys =~ tr/ /+/;
if ($FORM{'method'} == 2) {
	$advkeys = "\"$advkeys\"";
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
$advkeys =~ s/\"/%22/g;

}
###############################################

###############################################
sub othersearch {
	$count = 0;
	@defeng = split(/\|/, $defaults[0]);
	chomp(@defeng);
	foreach (@selist) {
		$checkeng = "$selist[$t]check";
		if ($defeng[$t] eq "CHECKED") {
			if ($newlist eq "") { $newlist .= "$selist[$t]"; }
			else { $newlist .= "|$selist[$t]"; }
			$$checkeng = "CHECKED";
			$count++;
		}
		$t++;
	}
}
###############################################

###############################################
sub gather {

$new = "";
$found=0;

require LWP::Parallel::UserAgent;
use HTTP::Request;

my ($count) = 0;
my (@reqs) = ();

$dh=0;
foreach $name(@newlist) {
	$var2 = "${name}url";
	$seurl = "$semod{$var2}";
	$seurl =~ s/\[keywords used\]/$advkeys/ig;
	$reqs[$count] = HTTP::Request->new('GET', $seurl);
	if ($name eq "DirectHit") { $dh=1; }
	$count++;
}

if ($dh == 0 && $searchmod eq "Web" && $options[2] eq "CHECKED") {
	$seurl = "$semod{'DirectHiturl'}";
	$seurl =~ s/\[keywords used\]/$advkeys/ig;
	$reqs[$count] = HTTP::Request->new('GET', $seurl);	
}

my $pua = LWP::Parallel::UserAgent->new();
$pua->in_order  (1);
$pua->duplicates(1);
$pua->timeout   ($timeout);
$pua->redirect  (1);

foreach my $req (@reqs) {
	if ( my $res = $pua->register ($req) ) {
		STDERR $res->error_as_HTML;
	}
}

my $entries = $pua->wait();

foreach (keys %$entries) {
	$res=$entries->{$_}->response;
	$content=($res->content) ? $res->content : $url;
	$url=$res->request->url;
	if ($content =~ /</) {
		@url = split(/\./, $url);
		$sub = $url[1];
		&$sub;
	} else {
		$totaleng--;
		if ($engtimeout eq "") { $engtimeout .= "$newlist[$newcount]"; }
		else { $engtimeout .= ", $newlist[$newcount]"; }
		foreach $engtim(@newlist) {
			unless ($engtim eq $newlist[$newcount]) {
				if ($new eq "") { $new .= "$engtim"; }
				else { $new .= "|$engtim"; }
			} else {
				if ($new eq "") { $new .= "N"; }
				else { $new .= "|N"; }
			}
		}
		@newlist = split(/\|/, $new);
		$new = "";
	}
	$newcount++;
}

foreach $timlink(@newlist) {
	unless ($timlink eq "" || $timlink eq "N") {
		if ($new eq "") { $new .= "$timlink"; }
		else { $new .= "|$timlink"; }		
	}
}
@newlist = split(/\|/, $new);
$newlist2 = "@newlist";
$new = "";

foreach $name(@newlist) {
	$engcount2=0;
	chomp($name);
	@data = split(/\n/, $$name);
	if ($#data < 0) {
		$totaleng--;
		foreach $engtim(@newlist) {
			unless ($engtim eq $name) {
				if ($new eq "") { $new .= "$engtim"; }
				else { $new .= "|$engtim"; }
			} else {
				if ($new eq "") { $new .= "N"; }
				else { $new .= "|N"; }
			}
		}
		@newlist = split(/\|/, $new);
		$new = "";
		$engcount2++;
	} else {
		$totalcount=0;
		foreach $line(@data) {
			@data2 = split(/\|/, $line);
			unless ($data2[0] eq "" || $data2[1] eq "" || $data2[2] eq "") {
				if ($searchmod eq "Web") {
					@urlarr = split(/\|/, $urlarr);
					$found=$counter=0;
					$dupurl = $data2[0];
					$dupurl =~ s/http:\/\///;
					$dupurl =~ s/www.//;
					foreach $arr(@urlarr) {
						if ($arr eq $dupurl) {
							$found=1;
							$arrnum=$counter;
							last;
						}
						$counter++;	
					}
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
	
		unless ($engcount2 == $totaleng || $totalcount == 0) {
			$newdata[$totalcount2] = "SPLITTER\n";
			$urlarr .= "|";	
		}
		$totalcount2++;
		$grandtotal = $grandtotal+$totalcount;
	}
}
foreach $timlink(@newlist) {
	unless ($timlink eq "" || $timlink eq "N") {
		if ($new eq "") { $new .= "$timlink"; }
		else { $new .= "|$timlink"; }		
	}
}
@newlist = split(/\|/, $new);
$newlist2 = "@newlist";
$newdata[$totalcount2] = "NEXTRELATED\n";
$totalcount2++;
$newdata[$totalcount2] = "$newlist2 $method\n";
$totalcount2++;
if ($searchmod eq "Web" && $options[2] eq "CHECKED") {
	@Related = split(/\n/, $Related);
	foreach $linkline(@Related) {
		$llcount++;
		$newdata[$totalcount2] = "$linkline\n";
		$totalcount2++;
		$relfound=1;
		last if $llcount == 10;
	}
}

unless ($advanced[2] == 0 || $grandtotal == 0) {
	open (FILE, ">${path}$searchmod/cache/$normalkeys.txt");
	foreach $line(@newdata) {
		print FILE $line;
	}
	close (FILE);
}

}
###############################################

###############################################
sub display {
$ovrlim = ($FORM{'page'}*$FORM{'perpage'}) - $grandtotal;
if ($grandtotal == 0) {
	$message = "No Results Found";
	&dismess;
} elsif ($ovrlim > $FORM{'perpage'}) {
	$message = "No More Results Found";
	&dismess;
} elsif ($totaleng == 0) {
	$message = "Results Timed Out";
	&dismess;
} else {

$splitter = "@newdata";
@nextrel = split(/NEXTRELATED\n/, $splitter);
@indeng = split(/SPLITTER\n/, $nextrel[0]);
$newlist2 = "";
foreach $eng(@newlist) {
	chomp($eng);
	if ($engnum == 0) { $newlist2 .= "$eng"; }
	else { $newlist2 .= "\|$eng"; }
	$engnum++;
}
@vars = split(/\|/, $semod{'descripvars'});

if ($FORM{'descrip'} == 1) {
	$description = "<a href=\"metasearch.cgi?results&descrip=0&method=$method&timeout=$FORM{'timeout'}&keywords=$linkkeys&searchtype=$searchmod&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&engines=$newlist2\">Show Summaries</A>";
} else {
	$description = "<a href=\"metasearch.cgi?results&descrip=1&method=$method&timeout=$FORM{'timeout'}&keywords=$linkkeys&searchtype=$searchmod&page=$FORM{'page'}&perpage=$FORM{'perpage'}&prev=1&engines=$newlist2\">Hide Summaries</A>";
}

if ($searchmod eq "Web" && $found == 0 && $options[2] eq "CHECKED") {
	$llcount=0;
	@Related = split(/\n/, $nextrel[1]);
	if ($#Related >= 8) {
		foreach (@Related) {
			$llcount++;
			$linkline = $Related[$llcount];
			if ($linkline eq "") {
				$relfound=1;
				last;
			}
			$linkline =~ s/^\s+//;
			$linkline2 = $linkline;
			$linkline2 =~ tr/ /+/;
			$lline[$llcount] = "<a href=\"metasearch.cgi?results&descrip=0&timeout=$FORM{'timeout'}&keywords=$linkline2&searchtype=$searchmod&page=1&perpage=$FORM{'perpage'}&prev=1&engines=$newlist2\">$linkline</a>";
			$relfound=1;
			last if $llcount == $advanced[7];
		}
		$lline =~ s/&apos;/'/g;
	}
}

$nextpage = ($FORM{'page'} - 1) * $FORM{'perpage'};
$indnum=$newnumb=0;

if ($last > $grandtotal) { $last = $grandtotal; }
$temp = $temparray[1];
if ($relfound == 1) {
	@related = split(/<\!-- \[relatedbreak\] -->/,$temp);
	$temp = $related[0];
	$temp =~ s/<\!-- \[first\] -->/$first/ig;
	$temp =~ s/<\!-- \[last\] -->/$last/ig;
	$temp =~ s/<\!-- \[description\] -->/$description/ig;
	$temp =~ s/<\!-- \[found\] -->/$grandtotal/ig;
	$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
	unless ($lline[1] eq "") { $temp =~ s/<\!-- \[relatedtitle\] -->/Related Searches/ig; }
	print $temp;
	$divide = $advanced[7]/2;
	unless ($lline[1] eq "") {
		for $newcount(1 .. $llcount) {
			$temp = $related[1];
			$temp =~ s/<\!-- \[relatedrow\] -->/$lline[$newcount]/ig;
			$temp =~ s/&apos;/'/g;
			print $temp;
			if ($newcount == $divide) { print "</tr><tr>"; }
		}
	}
	$temp = $related[2];
	$temp =~ s/<\!-- \[first\] -->/$first/ig;
	$temp =~ s/<\!-- \[last\] -->/$last/ig;
	$temp =~ s/<\!-- \[description\] -->/$description/ig;
	$temp =~ s/<\!-- \[found\] -->/$grandtotal/ig;
	$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
	print $temp;
} else {
	$temp =~ s/<\!-- \[first\] -->/$first/ig;
	$temp =~ s/<\!-- \[last\] -->/$last/ig;
	$temp =~ s/<\!-- \[description\] -->/$description/ig;
	$temp =~ s/<\!-- \[found\] -->/$grandtotal/ig;
	$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
	print $temp;
}

&relevance;
$newpage = $FORM{'page'}+1;
$oldpage = $FORM{'page'}-1;
$totalpages = ($grandtotal/$FORM{'perpage'});
if ($FORM{'page'} == 1) {
	$prevform = " <font color=#666666>Previous</font>";
} else {
	$prevform = " <a href=\"metasearch.cgi?results&keywords=$linkkeys&searchtype=$searchmod&page=$oldpage&descrip=$FORM{'descrip'}&method=$method&perpage=$FORM{'perpage'}&prev=1&engines=$newlist2\">Previous</A>";
}
if ($FORM{'page'} > $totalpages) {
	$nextform = " <font color=#666666>Next</font>";
} else {
	$nextform = " <a href=\"metasearch.cgi?results&keywords=$linkkeys&searchtype=$searchmod&page=$newpage&descrip=$FORM{'descrip'}&method=$method&perpage=$FORM{'perpage'}&engines=$newlist2\">Next</A>";
}


until ($numform > $totalpages) {
	$numform++;
	if ($numform == $FORM{'page'}) {
		$numberform .= " <font color=#666666>$numform</font>";
	} else {
		$numberform .= " <a href=\"metasearch.cgi?results&keywords=$linkkeys&searchtype=$searchmod&page=$numform&descrip=$FORM{'descrip'}&method=$method&perpage=$FORM{'perpage'}&prev=1&engines=$newlist2\">$numform</A>";
	}
}
$temp = $temparray[3];
if ($FORM{'perpage'} >= $grandtotal && $FORM{'page'} == 1) {
	$numberform = "";
	$prevform = "";
	$nextform = "";
}
$temp =~ s/<\!-- \[numberform\] -->/$numberform/ig;
foreach (@selist) {
	$checkeng2 = "$selist[$rp]check";
	$temp =~ s/\[$selist[$rp]\]/$$checkeng2/ig;
	$rp++;	
}
if ($engtimeout) {
	$timedout = "<B>Engines that Timedout:</B> $engtimeout";
	$temp =~ s/<\!-- \[EngTimedout\] -->/$timedout/ig;
}

if ($relfound == 1) { $temp =~ s/<\!-- \[related\] -->/$lline/ig; }
$temp =~ s/<\!-- \[prevform\] -->/$prevform/ig;
$temp =~ s/<\!-- \[nextform\] -->/$nextform/ig;
$temp =~ s/<\!-- \[timeout\] -->/$FORM{'timeout'}/ig;
$temp =~ s/<\!-- \[perpage\] -->/$FORM{'perpage'}/ig;
$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
$temp =~ s/\[method0\]/$method0/ig;
$temp =~ s/\[method1\]/$method1/ig;
$temp =~ s/\[method2\]/$method2/ig;
print $temp;

} #end timeout if
}
###############################################

###############################################
sub dismess {
	$temp = $temparray[1];
	$temp =~ s/<\!-- \[first\] -->/0/ig;
	$temp =~ s/<\!-- \[last\] -->/0/ig;
	$temp =~ s/<\!-- \[found\] -->/0/ig;
	print $temp;
	print "<BR><B><font color=red>$message</font></B>";
	$temp = "$temparray[3]";
	foreach (@selist) {
		$checkeng2 = "$selist[$rp]check";
		$temp =~ s/\[$selist[$rp]\]/$$checkeng2/ig;
		$rp++;	
	}
	$temp =~ s/<\!-- \[timeout\] -->/$FORM{'timeout'}/ig;
	$temp =~ s/<\!-- \[perpage\] -->/$FORM{'perpage'}/ig;
	$temp =~ s/<\!-- \[keys\] -->/$displaykeys/ig;
	print $temp;
}
###############################################

###############################################
sub highlight {
	my $highlight = $_[0];
	foreach $term (@highlight) {
		unless (length($term) < 3) {
			$boldterm = $term;
			$boldterm =~ s/\%2b//g;
			$highlight =~ s/\b($boldterm)\b/<B>$1<\/b>/gis;
		}
	}
	return $highlight;
}
###############################################

###############################################
sub relevance {

unless ($options[8] ne "CHECKED") {
	foreach $line(@indeng) {
		@inner = split(/\n/, $line);
		foreach $line2(@inner) {
			chomp($line2);
			@inner2 = split(/\|/, $line2);
			if ($inner2[4] =~ /\^/) {
				@source = split(/\^/, $inner2[4]);
				$relcount = 0;
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
	$splitter = "@leftover";
	@indeng = split(/ SPLITTER\n/, $splitter);
	@reltop = reverse sort {$a <=> $b} @reltop;

	$indnum = 0;
	$reltop = 1;
	foreach $line(@reltop) {
		chomp($line);
		$data[$indnum] = $line;
		&displaydata;
		$indnum++;
	}
}
$star = "";
$indnum = $reltop = 0;
until ($newnumb == $FORM{'perpage'}) {
	foreach $line(@indeng) {
		@data = split(/\n/, $line);
		if ($data[$indnum] =~ /\|/) {
			&displaydata;
		} #End if ($data[$indnum] =~ /\|/) {
	} #End foreach $line(@indeng) {
	$indnum++;
} #End Until
}
###############################################

###############################################
sub displaydata {
$num++;
if ($num > $nextpage) {
	@data2 = split(/\|/, $data[$indnum]);
	$temp = $temparray[2];
	if ($reltop) {
		$star = "";
		if ($advanced[8]) {
			for (1 .. $data2[0]) {
				$star .= "<img src=\"$advanced[8]\">";
			}
		}
		$high = $data2[4];
		$source = $data2[5];
		$qtitle = $data2[3];
		$qurl = $data2[2];
		@sources = split(/\^/, $source);
	} else {
		$high = $data2[3];
		$source = $data2[4];
		$qtitle = $data2[2];
		$qurl = $data2[1];
		@sources = split(/\^/, $source);
	}
	if ($FORM{'descrip'} == 1) { $temp =~ s/<!-- \[descrip\] -->(.*?)<!-- \[descrip\] -->//si; }
	else {
		if ($data2[3] =~ /\^/) {
			$name = $sources[0];
			@subdes = split(/\^/, $data2[3]);
			$subcount=0;
			foreach $insub(@subdes) {
				$neworder = $vars[$subcount];
				$temp =~ s/<!-- \[$neworder\] -->/$insub/ig;
				$subcount++;
			}
		}
	}
	$srccount=0;
	foreach $src(@sources) {
		$var4 = "${src}urldis";
		$disurl = "$semod{$var4}";
		$disurl =~ s/\[keywords used\]/$advkeys/ig;
		if ($srccount == 0) { $source2[$newnumb] .= "<A Href =\"$disurl\" TARGET=\"new\">$src</A>"; }
		else { $source2[$newnumb] .= ", <A Href =\"$disurl\" TARGET=\"new\">$src</A>"; }
		$srccount++;
	}
	$newurl = $qurl;
	$cutoff = $advanced[3];
	$dot = $cutoff-2;
	length($qtitle) > $cutoff ? ($ptitle = substr($qtitle,0,$dot) . "..."):($ptitle = $qtitle);
	length($qurl2) > $cutoff ? ($purl = substr($qurl2,0,$dot) . "..."):($purl = $qurl2);
	if ($options[6] eq "CHECKED") {
		$high = highlight($high);
		$ptitle = highlight($ptitle);
	}
	$ptitle = translate($ptitle);
	$high = translate($high);
	$morelikethis = $data2[2];
	$morelikethis =~ tr/ /+/;
	$morelikethis = "metasearch.cgi?results&keywords=$morelikethis&searchtype=$searchmod&page=1&descrip=$FORM{'descrip'}&perpage=$FORM{'perpage'}&prev=1&engines=$newlist2";
	$temp =~ s/<!-- \[number\] -->/$num/ig;
	$temp =~ s/<!-- \[url\] -->/$newurl/ig;
	$temp =~ s/<!-- \[title\] -->/$ptitle/ig;
	if ($star) { $temp =~ s/<!-- \[image\] -->/$star/ig; }
	unless ($FORM{'descrip'} == 1) { $temp =~ s/<!-- \[description\] -->/<dd>$high/ig; }
	$temp =~ s/<!-- \[printurl\] -->/<BR>$purl/ig;
	$temp =~ s/<!-- \[source\] -->/$source2[$newnumb]/ig;
	$temp =~ s/<!-- \[morelikethis\] -->/$morelikethis/ig;
	$| = 1;
	print $temp;
	$newnumb++;
	if ($num == $grandtotal) { $newnumb = $FORM{'perpage'} }
	last if ($newnumb == $FORM{'perpage'});
} #End if ($num > $nextpage) {
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