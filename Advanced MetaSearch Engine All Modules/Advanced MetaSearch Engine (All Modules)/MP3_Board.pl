# Mod MP3_Board
sub MP3_Board{my ($title,$url,$description,$size,$date);
my $regex='<TR><TD><A HREF=\"(.*?)\">(.*?)</A>.*?<BR><FONT Color=#909090>.*?</FONT></TD><TD><FONT Color=#909090>(.*?)</FONT><BR></TD><TD><FONT Color=#909090>(.*?)</FONT></TD></TR>';
my $e_name='MP3_Board';my $e_url="<a href\=\"http://www.mp3board.com\">$e_name</a>";
while($buf=~m{$regex}g){$title=$2;$url=$1;$size=$3;$date=$4;$description="<b>Size: </b> $size, <b>Date: </b> $date";$total++;@results=(@results,"$e_name\|$e_url\|0\|$title\|$url\|$description");
}}
sub url_MP3_Board {return "http://www.mp3board.com/ddsearch.smx?search=$_[0]";}$TOUT=3;
sub match_MP3_Board {return "1";}
1;