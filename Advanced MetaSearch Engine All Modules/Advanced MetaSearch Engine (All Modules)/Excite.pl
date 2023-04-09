# web Module: Excite
## ------ User Modify ALLOWED  -----
sub Excite {my ($title,$URL,$description);my $accuracy=0;while($buf=~m{$reg}go){
$URL=&strip($1);$title=&strip($2);$description=&strip($3);$total++;
@results=(@results,"Excite|<a href=\"http://www.excite.com\">Excite</a>|0|$title|$URL|$description");}
}

sub url_Excite {my($query,$match,$rgn)=@_;my $lang = "";$match="w" if $match ne "phrase";return "http://search.excite.com/search.gw?search=$query&trace=a&c=web&perPage=30&FT_1=$match";}

sub match_Excite {
return '<li> <A HREF="http://search.excite.com/relocate/sr=webresult.*?id=.*?\;(.*?)\">(.*?)</A>
<br>
<font color=\"#808080\"><b>URL:</b> .*?</font><br>
<font size=-2>
(.*)
</font>';
}
1;

