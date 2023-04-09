# Mod Lycos MP3
$TOUT=4;
sub Lycos_MP3_2 {my ($title,$URL,$description,$reliability,$size,$type);
my $regex = '(Song|Directory)\: <a href=\"(.*?)\">(.*?)</a><br> Reliability:<font face=verdana,geneva,arial size=1 color=\"\#339933\"><b>(.*?)</b></font>(.*?)<br>';
my $e_name='Lycos_MP3';
my $e_url="<a href\=\"http://mp3.lycos.com\">$e_name</a>";
$buf=&remove_garbage($buf);
while($buf=~m{$regex}g) {$type=$1;$URL=$2;$title=$3;$reliability=$4;$size=$5;
($size=~/File Size: <b>(.*?)<\/b>/)?($size="<b>Size:</b> $1 M,"):($size="");
$description="<b>Type:</b> $type, $size <b>Reliability:</b> <font color=ff8000>$reliability</font>";$total++;
@results=(@results,"$e_name\|$e_url\|0\|$title\|$URL\|$description");
}}
sub url_Lycos_MP3_2 {return "http://music.lycos.com/default.asp?DA=0&QT=S&QW=$_[0]&MFI=20&MFS=&AID=";}
sub match_Lycos_MP3_2 {return "1";}
sub remove_garbage {my $html=shift;$html=~s/\|//g;$html=~s/\n/ /g;$html=~s/\r/ /g;$html=~s/\t//g;$html=~s/\f//g;$html=~s/\n\n//g;$html=~s/\r\r//g;$html=~s/^\s+//g;$html=~s/\s+$//g;$html=~s/\s+/ /g;$html;}
1;