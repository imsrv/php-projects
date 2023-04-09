# web Module: Fast
## ------ User Modify ALLOWED  -----
sub Fast {my($accuracy,$title,$URL,$description);

while($buf=~m{$reg}go){
$URL=&strip($1);$title=&strip($2);
$description=&strip($3);$total++;
@results=(@results,"Fast|<a href=\"http://www.ussc.alltheweb.com\">Fast</a>|0|$title|$URL|$description");
}
}

sub url_Fast{
my($query,$match,$rgn,$lvl)=@_;
return "http://www.ussc.alltheweb.com/cgi-bin/search?exec=FAST+Search&type=$match&query=$query&exec=FAST+Search";
}

sub match_Fast{return 
'<dt>\d+&nbsp;&nbsp;<a href=\"(.*?)\">(.*)
</a>
<dd><span class=\"teaser\">(.*)
</span><br>';
}
1;