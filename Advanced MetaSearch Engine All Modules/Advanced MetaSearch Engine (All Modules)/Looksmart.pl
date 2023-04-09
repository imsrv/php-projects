# web Module: Looksmart
##  --- User Modify ALLOWED ----
sub Looksmart {my ($title,$url,$description); my $tmp;$buf =~s/[\n\r]//g;
for (1..10){if ($buf =~s/<dl><dt>(.*?)<\/dl>//) { 
$tmp=$1;
if($tmp=~m{$reg}g){$url=$1;$title=strip($2);$description=$3;$description=~s/<br><a.*?<\/dd>//g;$description=&strip($description);$url=~/^http/i or $url='http://www.looksmart.com'.$url;
$total++;@results=(@results,"Looksmart|<a href=\"http://www.looksmart.com\">Looksmart</a>|0|$title|$url|$description");}}}
}
sub url_Looksmart {
my ($query,$match,$rgn,$lvl) = @_;
return "http://www.looksmart.com/r_search?look=&key=$query";}

sub match_Looksmart {return '<a href=(.*?)>(.*?)</a></dt><dd>(.*)';}
1;