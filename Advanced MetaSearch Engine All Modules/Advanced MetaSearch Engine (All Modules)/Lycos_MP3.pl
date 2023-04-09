# Mod Lycos MP3
$TOUT=4;
sub Lycos_MP3 {my($title,$url,$description,$reliability,$date,$source_url,$source);
my $regex='<a href=\"(.*?)\">(.*?)</a>.*?<br> Reliability:<font face=verdana,geneva,arial size=1 color="#339933"><b>(.*?)</b></font>(.*?)<br><font size=1><a href="(.*?)">(.*?)</a>.*?</font><br>';
my $e_name='Lycos_MP3';my $e_url="<a href\=\"http://mp3.lycos.com\">$e_name</a>";
$buf=~s/.*?<font color\=\#666666\>\- \- \- \- \-<\/font>(.*?)/$1/s;
$buf=&remove_garbage($buf);while($buf=~m{$regex}g){$url=$1;$title=strip($2);$reliability=$3;$date=$4;$source_url=$5;$source=$6;
$url='http://music.lycos.com' . $url;$source_url='http://music.lycos.com'.$source_url;($date=~s/Date: (.*?)/$1/)?($date=", <b>Date:</b> $date"):($date = "");
$description="<b>Confidence: </b> <font color=ff8000>$reliability</font>$date<br><b>Origin: </b> <a href=\"$source_url\">$source</a>";$total++;
@results=(@results,"$e_name\|$e_url\|0\|$title\|$url\|$description");}}
sub url_Lycos_MP3{return "http://music.lycos.com/default.asp?QT=S&QW=$_[0]&submit1=Search%21";}
sub match_Lycos_MP3{return "1";}sub remove_garbage {my $html=shift;$html=~s/\|//g;$html=~s/\n/ /g;$html=~s/\r/ /g;$html=~s/\t//g;$html=~s/\f//g;$html=~s/\n\n//g;$html=~s/\r\r//g;$html=~s/^\s+//g;$html=~s/\s+$//g;$html=~s/\s+/ /g;$html;}
1;