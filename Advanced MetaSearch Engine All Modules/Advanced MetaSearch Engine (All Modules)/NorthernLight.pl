# web Module: NorthernLight
##  ------ User Modify ALLOWED  -----

$TOUT=$TIMEOUT || 3;

sub NorthernLight {my($title,$url,$description,$accuracy);
while($buf=~m{$reg}g){$url=&strip($1);$title=&strip($2);$accuracy="$3%";$description=&strip($4);$total++;
@results=(@results,"NorthernLight|<a href=\"http://www.northernlight.com\">NorthernLight</a>|$accuracy|$title|$url|$description");
}
}
sub url_NorthernLight {my($query,$match,$rgn,$lvl)=@_;if ($match eq "all") {
$query =~s/\+/\+\%2B/g; $query = '%2B'.$query;} elsif ($match eq "phrase") { $query = '%22'.$query.'%22'; } else { #
} return "http://www.northernlight.com/nlquery.fcg?cb=0&qr=$query&orl=2%3A1&search.x=37&search.y=15";
} 
sub match_NorthernLight {return 
'<td align=right valign=top><FONT size=2 face=arial,helvetica>\d+\.&nbsp;</font></td>
<td valign=top><FONT size=2 face=arial,helvetica><\!-- Misc Block --><a href=\"(.*?)\">(.*?)</a><br>
<b><\!--NLResultRelevanceStart-->(\d+)\% -<\!--NLResultRelevanceEnd-->.*?</b>(.*?)<br>';}$TOUT++;

1;