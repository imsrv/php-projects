# Bid Search Engine by Done-Right Scripts
# Module Script - Web
# Version 4.3
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# None of the code below needs to be edited below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2001 Done-Right. All rights reserved.


######################################
#Search Engines - Do Not Delete
$semod{'search_engines'}="About|AOLSearch|Fast|FindWhat|GoClick|Google|Kanoodle|Lycos|MSN|Netscape|ODP|Overture|WiseNut|Yahoo";
$semod{'senumber'} = "14";
#Search Engines - Do Not Delete
######################################

sub AUTOLOAD { }
######################################
#About
sub about {
	my ($content) = @_;
	while($content =~ m|<LI><P><A HREF=\"(.*?)\">(.*?)</a><BR>(.*?)</P>|igs) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'About'} .= "$1|$2|$newdescrip\n";
	}
	$semod{'About'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Abouturl'} = "http://searchpartners.about.com/texis/metaresults?terms=[keywords used]&pgc=25&ac=n";
$semod{'Abouturldis'} = "http://search.about.com/fullsearch.htm?terms=[keywords used]&PM=59_0100_S&Action.x=15&Action.y=4";
######################################


######################################
#AOLSearch
sub aol {
	my ($content) = @_;
	while($content =~ m|return true\"><b>(.*?)</B></A>\s+- (.*?)\s+<br>\s+<font class=small>(.*?)</a></font><p>|igs) {
		my $newdescrip = "$2";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'AOLSearch'} .= "$3|$1|$newdescrip\n";
	}
	$semod{'AOLSearch'} =~ s/<[^>]*>//g;
	return (%semod);	
}
$semod{'AOLSearchurl'} = "http://search.aol.com/dirsearch.adp?query=[keywords used]&first=1&last=20&next=item&cat=0";
$semod{'AOLSearchurldis'} = "http://search.aol.com/dirsearch.adp?query=[keywords used]&first=1&last=20&next=item&cat=0";
######################################

######################################
#Fast
sub alltheweb {
	my ($content) = @_;
	while($content =~ m|href=\"(.*?)\"><b>(.*?)</b></a></dt>\s+<dd>\s+(.*?)<br><span class=path>|igmo) {
		my $newdescrip = "$3";
		my $newtitle = "$2";
		my $newurl = "$1";
		$newdescrip =~ s/[\n\r]//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'Fast'} .= "$newurl|$newtitle|$newdescrip\n";
	}
	$semod{'Fast'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Fasturl'} = "http://www.alltheweb.com/search?cat=web&lang=any&query=[keywords used]";
$semod{'Fasturldis'} = "http://www.alltheweb.com/search?cat=web&lang=any&query=[keywords used]";
######################################

######################################
#FindWhat
sub findwhat {
	my ($content) = @_;
	while($content =~ m|<record><title><\!\[CDATA\[(.*?)\]\]></title><url>(.*?)</url><description><\!\[CDATA\[(.*?)\]\]></description><bidprice>(.*?)</bidprice><clickurl>(.*?)</clickurl></record>|igmo) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'FindWhat'} .= "$5|$1|$newdescrip\n";
	}
	$semod{'FindWhat'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'FindWhaturl'} = "http://www.findwhat.com/bin/findwhat.dll?getresults&base=0&mt=[keywords used]&dc=10";
$semod{'FindWhaturldis'} = "http://www.findwhat.com/results.asp?DC=25&MT=[keywords used]&filter_pref=0";
######################################

######################################
#GoClick
sub goclick {
	my ($content) = @_;
	while($content =~ m|<td>\s+<a\s+HREF=\"(.*?)\"><FONT FACE=\"helvetica,sans-serif\" SIZE=3><B>(.*?)</B></FONT></A></B>\s+</TD></TR><TR><TD></TD><TD>\s+<FONT SIZE=-1>(.*?)</FONT><BR>|igmo) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'GoClick'} .= "$1|$2|$newdescrip\n";
	}
	$semod{'GoClick'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'GoClickurl'} = "http://www.goclick.com/search.mod?REF=1&SEARCH=[keywords used]&START=0";
$semod{'GoClickurldis'} = "http://www.goclick.com/search.mod?REF=1&SEARCH=[keywords used]&START=0";
######################################


######################################
#Google
sub netscape {
	my ($content, $url) = @_;
	if ($url =~ /cp=nsiwidsrc/) { &netscape2($content); }
	else {
		while($content =~ m|<li><a href=\"(.*?)\">(.*?)</a>\s+<br>\s+(.*?)<br>\s+(.*?)\s+<br><font size=\"1\">(.*?)</font><p>|igmo) {
			my $newdescrip = "$3";
			$newdescrip =~ s/\n//g;
			$newdescrip =~ s/\|/\:/g;
			$semod{'Google'} .= "$5|$2|$newdescrip\n";
		}
		$semod{'Google'} =~ s/<[^>]*>//g;
		return (%semod);
	}
}
$semod{'Googleurl'} = "http://search.netscape.com/search.psp?cp=nrpussag&search=[keywords used]&gr=1&pagecp=gsa";
$semod{'Googleurldis'} = "http://www.google.com/search?q=[keywords used]&btnG=Google+Search";
######################################


######################################
#Kanoodle
sub kanoodle {
	my ($content) = @_;
	while($content =~ m|<P><FONT face=\"Times New Roman, Times, serif\">([\w\W]*?)<a href=\"(.*?)\" alt=\"([\w\W]*?)\"><B>(.*?)</B></A></FONT><BR>\s+<FONT face=\"Verdana, Arial, Helvetica, sans-serif\"><FONT size=2>(.*?)</FONT></FONT><br>|igmo) {
		my $newdescrip = "$5";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'Kanoodle'} .= "http://www.kanoodle.com$2|$4|$newdescrip\n";
	}
	$semod{'Kanoodle'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Kanoodleurl'} = "http://www.kanoodle.com/return.cool?query=[keywords used]";
$semod{'Kanoodleurldis'} = "http://www.kanoodle.com/return.cool?query=[keywords used]";
######################################


######################################
#Lycos
sub lycos {
	my ($content) = @_;
	while($content =~ m|rsource=LCOSWF\">(.*?)</a>\s+-\s+(.*?)<br><font face=\"verdana\" size=\"-2\" color=\"#999999\">(.*?)</font>|igs) {
		my $newdescrip = "$2";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'Lycos'} .= "$3|$1|$newdescrip\n";
	}
	$semod{'Lycos'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Lycosurl'} = "http://search.lycos.com/main/?query=[keywords used]&first=1&cl=w&ca=w&page=more&loc=mlink_w&rd=y";
$semod{'Lycosurldis'} = "http://search.lycos.com/main/?query=[keywords used]&first=1&cl=w&ca=w&page=more&loc=mlink_w&rd=y";
######################################


######################################
#MSN
sub msn {
	my ($content) = @_;
	while($content =~ m|<nobr><a href=\"(.*?)\" class=\"clsResultTitle\">(.*?)</a></nobr><table border=\"0\" cellpadding=\"0\" cellspacing="0" width=\"560\"><tr><td>(.*?)<br>|igs) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'MSN'} .= "$1|$2|$newdescrip\n";
	}
	$semod{'MSN'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'MSNurl'} = "http://search.msn.com/results.asp?q=[keywords used]&co=30&RS=CHECKED&FORM=SMCB&ba=0&v=1&un=doc";
$semod{'MSNurldis'} = "http://search.msn.com/results.asp?q=[keywords used]&co=30&RS=CHECKED&FORM=SMCB&ba=0&v=1&un=doc";
######################################


######################################
#Netscape
sub netscape2 {
	my ($content) = @_;
	while($content =~ m|<b><LI><a href=\"([\w\W]*?)\">(.*?)</a>\s+(.*?)<br><font size=\"1\">(.*?)<br>|gs) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'Netscape'} .= "$4|$2|$newdescrip\n";
	}
	$semod{'Netscape'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Netscapeurl'} = "http://search.netscape.com/cgi-bin/search?cp=nsiwidsrc&search=[keywords used]&x=45&y=19";
$semod{'Netscapeurldis'} = "http://search.netscape.com/cgi-bin/search?cp=nsiwidsrc&search=[keywords used]&x=45&y=19";
######################################



######################################
#ODP
sub dmoz {
	my ($content) = @_;
	while($content =~ m|<li><a href=\"(.*?)\">(.*?)</a> - (.*?)<br><small><i>|igs) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'ODP'} .= "$1|$2|$newdescrip\n";
	}
	$semod{'ODP'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'ODPurl'} = "http://search.dmoz.org/cgi-bin/search?search=[keywords used]";
$semod{'ODPurldis'} = "http://search.dmoz.org/cgi-bin/search?search=[keywords used]";
######################################


######################################
#Overture
sub overture {
	my ($content) = @_;
	while($content =~ m|<li><b>(.*?)</a></b><br>(.*?)<br><em>(.*?)</em>|igs) {
		my $newdescrip = "$2";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'Overture'} .= "http://$3|$1|$newdescrip\n";
	}
	$semod{'Overture'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Overtureurl'} = "http://www.overture.com/d/search/?type=home&Keywords=[keywords used]";
$semod{'Overtureurldis'} = "http://www.overture.com/d/search/?type=home&Keywords=[keywords used]";
######################################


######################################
#WiseNut
sub wisenut {
	my ($content) = @_;
	while($content =~ m|<SPAN class =title>([\w\W]*?)<A href=\"(.*?)\">(.*?)</A></SPAN> <TABLE border = 0 cellspacing=0 cellpadding=0 cols=2 width=\"100%\"><TR> <TD width=15 nowrap>(.*?)<br>|igmo) {
		my $newdescrip = "$4";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'WiseNut'} .= "$2|$3|$newdescrip\n";
	}
	$semod{'WiseNut'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'WiseNuturl'} = "http://www.wisenut.com/search/query.dll?q=[keywords used]";
$semod{'WiseNuturldis'} = "http://www.wisenut.com/search/query.dll?q=[keywords used]";
######################################


######################################
#Yahoo
sub yahoo {
	my ($content) = @_;
	while($content =~ m|<li><big>\s+<a href=\"(.*?)\">\s+(.*?)</a>\s+</big>\s+&nbsp\;- (.*?)\s+<br><font color=006600>(.*?)</font>|igs) {
		my $newdescrip = "$3";
		$newdescrip =~ s/\n//g;
		$newdescrip =~ s/\|/\:/g;
		$semod{'Yahoo'} .= "$4|$2|$newdescrip\n";
	}
	$semod{'Yahoo'} =~ s/<[^>]*>//g;
	return (%semod);
}
$semod{'Yahoourl'} = "http://search.yahoo.com/bin/search?p=[keywords used]";
$semod{'Yahoourldis'} = "http://search.yahoo.com/bin/search?p=[keywords used]";
######################################

# End - Do Not Delete
1;
