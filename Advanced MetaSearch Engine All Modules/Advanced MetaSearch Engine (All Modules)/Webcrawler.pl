# web Module: Webcrawler
## ------ User Modify ALLOWED  -----
sub Webcrawler {my ($accuracy,$title,$URL,$description);
while($buf=~m{$reg}go){$accuracy="$1%";$URL=&strip($2);$title=&strip($3);$description=&strip($4);$total++;
@results=(@results,"Webcrawler|<a href=\"http://www.webcrawler.com\">Webcrawler</a>|$accuracy|$title|$URL|$description");}
}
sub url_Webcrawler {my($query,$match,$rgn,$lvl)=@_;
if ($match eq "all"){$query =~s/\+/\+AND\+/g; $query='%28'.$query.'%29';}
elsif($match eq "phrase"){$query='%22'.$query.'%22'; }else{$query=~s/\+/\+OR\+/g;$query='%28'.$query.'%29';}
return "http://www.webcrawler.com/cgi-bin/WebQuery?searchText=$query&showSummary=true";
}
sub match_Webcrawler {return 
'<DT><FONT FACE="Times" COLOR="#006699"><B>(\d+)% </B></FONT>
&nbsp;&nbsp;
<A HREF=(.+)>(.*?)</A>
<DD>(.*?)<NOBR><A HREF=".*?">Similar Pages</A></NOBR>';
}
1;