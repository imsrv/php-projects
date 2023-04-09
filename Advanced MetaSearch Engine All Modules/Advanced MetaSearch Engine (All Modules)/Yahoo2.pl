# web Module: Yahoo
## ------ User Modify ALLOWED  -----

sub Yahoo {my (@tmp,$tmp,$title,$URL,$description);my $accuracy=0;
$buf=~s/[\n\r]//g;
while($buf=~m{$reg}go){$URL=&strip($1);$title=&strip($2);$description=&strip($3);$total++;@results=(@results,"Yahoo|<a href=\"http://www.yahoo.com\">Yahoo</a>|$accuracy|$title|$URL|$description");}
} 

sub url_Yahoo {my($query,$match,$rgn,$lvl)=@_;if($match eq "all"){$query=~s/\+/\+\%2B/g;$query='%2B'.$query; }
elsif($match eq "phrase"){$query='%22'.$query.'%22';}else {#
}return "http://search.yahoo.com/bin/search?p=$query&h=s";
}
sub match_Yahoo {return '<dd><li><a href=\"(.*?)\">(.*?)</a> - (.*?)<dd>'; }

1;