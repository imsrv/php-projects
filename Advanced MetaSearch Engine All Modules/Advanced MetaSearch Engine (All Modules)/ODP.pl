# web Module: Open Directory (ODP)
## ---- User Modify ALLOWED ---
sub ODP {
my($accuracy,$title,$URL,$description);$accuracy="N/A";while ($buf=~m{$reg}go){$URL=&strip($1);$title=&strip($2);$description=&strip($3);$total++;
@results=(@results,"ODP|<a href=\"http://dmoz.org/\">ODP</a>|$accuracy|$title|$URL|$description");
}
}

sub url_ODP {my ($query,$match,$rgn,$lvl)=@_;
$query=~s/\++/\+/g;$query=~s/\%22//g;$query=~s/\%2B//g;
if ($match eq "any"){$query=~s/\+/\+or\+/g;}elsif($match eq "phrase"){$query='%22'.$query.'%22';}else{
#
}
return "http://search.dmoz.org/cgi-bin/osearch?search=$query&cat=&t=s&all=no";
}

sub match_ODP {
return 
'<LI><A HREF="(.*?)">(.*?)</A>(.*?)</LI>';
}

1;