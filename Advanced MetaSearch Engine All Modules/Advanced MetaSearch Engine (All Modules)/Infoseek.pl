# Mod Infoseek

sub Infoseek { ## <------ User Modify ALLOWED  ----->
my ($accuracy,$title,$URL,$description);
while ($buf=~m{$reg}go){$URL=&strip($1);$title=&strip($2);$description=&strip($3);$accuracy="$4%";$URL=~s/.*?&rd\=http\%3A\/\/(.*)/http:\/\/$1/;$total++;
@results=(@results,"Infoseek|<a href=\"http://infoseek.go.com\">Infoseek</a>|$accuracy|$title|$URL|$description");}
} sub url_Infoseek {my ($query,$match,$rgn,$lvl)=@_;
if ($match eq 'all') {$query=~ s/\+/\+\%2B/g;$query='+%2B'.$query;}
elsif ($match eq 'phrase'){$query='%22'.$query.'%22';}else{$query='+'.$query;}
return "http://infoseek.go.com/Titles?qt=$query&col=WW&lk=noframes&sv=IS&ud9=advanced_www&svx=search_advweb&nh=25&rf=11";}
sub match_Infoseek {return 
'\d+\. <b><a href="(.*?)">(.*?)</a></b><br>(.*?)<br>Relevance: <font face="Helvetica,Arial" size="2">(\d+)% &nbsp;Date: .*?\, &nbsp;Size .*?,';
}
1;