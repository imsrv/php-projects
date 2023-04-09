# web Module: Hotbot
# --- User Modify Allowed

sub Hotbot {my($accuracy,$title,$URL,$description);$accuracy="N/A";
while($buf=~m{$reg}go){$URL=$1;$title=&strip($2);$description=&strip($3);$URL=~s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;$total++;
@results=(@results,"Hotbot|<a href=\"http://www.hotbot.com/\">Hotbot</a>|$accuracy|$title|http://$URL|$description");
}
}
sub url_Hotbot {my ($query,$match,$rgn)=@_;if($match eq "phrase"){$match="phrase";} 
#elsif($match eq "all"){$match="MC";}
else{$match="SC";}

return "http://hotbot.lycos.com/?MT=$query&SM=$match&DV=0&LG=any&DC=25&DE=2&x=46&y=9";
}
sub match_Hotbot {return 
'<P><b>\d+\.&nbsp;<a href=/director\.asp\?target=http\%3A\%2F\%2F(.*?)\&id=.*?>(.*?)</a></b><br>(.*?)<br>';
}
1;