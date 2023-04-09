# Mod eMusic
$TOUT=3;
sub eMusic{my($title,$url,$description,$type,$author);
my $regex='<TD align=left colspan=3><br>&nbsp;&nbsp;(.*?)<br>&nbsp;(.*?)<A href=\"(.*?)\">(.*?)</A>
<br>&nbsp;&nbsp;(.*)
</td>';my $e_name='eMusic';my $e_url="<a href\=\"http://www.emusic.com\">$e_name</a>";
while($buf=~m!$regex!g){$title=$1;$author=$2;$url=$3;$type=$5;$author=~s/<.*?>//g;$author=~s/\&nbsp\;//g;($author=~/^$/)?($author=""):($author.=',');$description="$author $type";
@results=(@results,"$e_name\|$e_url\|0\|$title\|$url\|$description");$total++;}}
sub url_eMusic{return "http://www.altavista.com/cgi-bin/query?q=$_[0]&amp3=1&mmdurrlt=1&mmdurrgt=1&mmW=1&mmF=1&macat=EMUSIC&audset=1&stype=saudio&pg=q&Translate=on&search.x=27&search.y=14";}
sub match_eMusic{return "1";}
1;