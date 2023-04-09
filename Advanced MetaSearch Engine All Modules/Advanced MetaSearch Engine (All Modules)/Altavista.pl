# web Module: Altavista
## ------ User Modify ALLOWED  -----
sub Altavista {my($accuracy,$title,$url,$description);$buf=~s/[\n\r]//g;
while ($buf=~m{$reg}go){$url=&strip($1);$title=&strip($2);$description=&strip($3);$total++;
@results=(@results,"Altavista|<a href=\"http://www.altavista.com\">Altavista</a>|0|$title|$url|$description");}
}
sub url_Altavista {my ($query,$match,$rgn,$lvl)=@_;if($match eq "all"){$query =~s/\+/\+\%2B/g; $query = '%2B'.$query;} elsif ($match eq "phrase") { $query = '%22'.$query.'%22'; } else { 
#
}return "http://www.altavista.com/cgi-bin/query?pg=q&sc=on&q=$query&kl=XX&stype=stext";
} 
sub match_Altavista {return '<dl><dt><b class=txt2>\d+\.</b><b><a href=\"(.*?)\">(.*?)</a></b><dd>(.*?)<br><span class=ft> URL:';}
1;