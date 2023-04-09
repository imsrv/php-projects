# MetaSearch by Done-Right Scripts
# Module Script - MP3s
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# None of the code below needs to be edited below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2000 Done-Right. All rights reserved.


######################################
#Search Engines
$semod{'search_engines'}="Audiophilez|MP3|MusicGrab|Oth|Seekmp3";
$semod{'senumber'} = "5";
$semod{'descripvars'} = "Size|";
######################################

######################################
#Search Engine Tags
######################################

######################################
#Audiophilez
sub audiophilez {
	while($content =~ m|<a href=\"/down(.*?)\" title=\"(.*?)return true\"><b>(.*?)</b></a> \W(.*?)MB\W<br>|gs) {
		$newurl = "http://www.audiophilez.com/down$1";
		$filesize = "$4";
		$filesize = sprintf("%.1f", $filesize); 
		$newdescrip = "$filesize MB^N/A";
		$newdescrip =~ s/\n//g;
		$Audiophilez .= "$newurl|$3|$newdescrip\n";
	}
	$Audiophilez=~ s/<[^>]*>//g;
}
$semod{'Audiophilezurl'} = "http://www.audiophilez.com/search.phtml?q=[keywords used]&s=on&x=52&y=3";
$semod{'Audiophilezurldis'} = "http://www.audiophilez.com/search.phtml?q=[keywords used]&s=on&x=52&y=3";
$semod{'Audiophilezorder'} = "size|";
######################################

######################################
#MP3
sub mp3 {
	while($content =~ m|<font face=\"arial,helvetica\" size=\"-1\"><a href=\"(.*?)\">\s+(.*?)\s+</a>\s+<br>|gs) {
		$newurl = "$1";
		$newdescrip = "N/A^N/A";
		$newdescrip =~ s/\n//g;
		$MP3 .= "$newurl|$2|$newdescrip\n";
	}
	$MP3=~ s/<[^>]*>//g;
}
$semod{'MP3url'} = "http://search.mp3.com/bin/search?display=artist&query=[keywords used]&section=artist&page=1";
$semod{'MP3urldis'} = "http://search.mp3.com/bin/search?display=artist&query=[keywords used]&section=artist&page=1";
$semod{'MP3order'} = "size|";
######################################

######################################
#MusicGrab
sub musicgrab {
	while($content =~ m|<span class=\"pagelinktext\"><a href=\"(.*?)\"(.*?)class=\"mp3link\">(.*?)</a>(.*?)<td align=\"right\" nowrap><span class=\"columntext\">(.*?)</span></td>\s+<td align=\"right\" nowrap><span class=\"columntext\">(.*?) MB</span></td>|gs) {
		$newurl = "http://www.musicgrab.com/$1";
		$filesize = "$6";
		$filesize = sprintf("%.1f", $filesize); 
		$newdescrip = "$filesize MB^N/A";
		$newdescrip =~ s/\n//g;
		$MusicGrab .= "$newurl|$3|$newdescrip\n";
	}
	$MusicGrab=~ s/<[^>]*>//g;
}
$semod{'MusicGraburl'} = "http://www.musicgrab.com/mp3/search/1/0/[keywords used]/0/10/";
$semod{'MusicGraburldis'} = "http://www.musicgrab.com/mp3/search/1/0/[keywords used]/0/10/";
$semod{'MusicGraborder'} = "size|";
######################################

######################################
#Oth
sub oth {
	while($content =~ m|<img border=0 height=1 width=11 src=\"/icons/11.gif\"> (.*?)k <a target=new(.*?)</a> <a href=\"(.*?)\">(.*?)-(.*?)</a>|gs) {
		$newurl = "$3";
		$filesize = "$1";
		$filesize = $filesize/1000;
		$filesize = sprintf("%.1f", $filesize); 
		$newdescrip = "$filesize MB^N/A";
		$newdescrip =~ s/\n//g;
		$Oth .= "$newurl|$5|$newdescrip\n";
	}
	$Oth=~ s/<[^>]*>//g;
}
$semod{'Othurl'} = "http://www.oth.net/cgi-bin/search?q=[keywords used]&cl=1";
$semod{'Othurldis'} = "http://www.oth.net/cgi-bin/search?q=[keywords used]&cl=1";
$semod{'Othorder'} = "size|dummy";
######################################

######################################
#Seekmp3
sub seekmp3 {
	while($content =~ m|<font face=Arial size=2><b><a href=(.*?) title=\"(.*?)\">(.*?)</a></b></font></td>(.*?)Size: (.*?)</i>|gs) {
		$newurl = "http://www.seekmp3.com/http_search/$1";
		$newdescrip = "$5^N/A";
		$newdescrip =~ s/\n//g;
		$Seekmp3 .= "$newurl|$3|$newdescrip\n";
	}
	$Seekmp3=~ s/<[^>]*>//g;
}
$semod{'Seekmp3url'} = "http://www.seekmp3.com/http_search/search.php3?search=[keywords used]";
$semod{'Seekmp3urldis'} = "http://www.seekmp3.com/http_search/search.php3?search=[keywords used]";
$semod{'Seekmp3order'} = "size|";
######################################

######################################
1;


