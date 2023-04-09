# Mod eBay Auction-Search

sub eBay {
my ($Picture_html,$Picture_URL);

#$Picture_URL = '<img src="http://your.server.com/images/pic.gif" width="16" height="14" border="0" alt="Picture Available">'; 

# (Put the Picture URL as on your server as required 
#          AND uncomment the above line)

#  -------  DO NOT CHANGE ANYTHING BELOW -------------------------------------------------------------

$Picture_html = $Picture_URL || '[<b>Picture</b>]';my ($title,$url,$description);my $e_name="eBay";
my ($item,$id,$pic,$price,$bid,$time);my $e_url="<a href\=\"http://www.ebay.com\">$e_name</a>";
my $regex = '<tr><td valign="middle" width="10%"><font size=3>(.*?)</font></td><td valign="top" width="52%"><font size=3><a href=\"http:\/\/cgi\.ebay\.com\/aw\-cgi\/eBayISAPI\.dll\?ViewItem&item=(.*?)\">(.*?)</a></font>(.*?)</td><td nowrap align="right" valign="top" width="14%"><font size=3><b>(.*?)</b></font></td><td align="center" valign="top" width="6%"><font size=3>(.*?)</font></td><td align="right" valign="top" width="16%">(.*?)</td></tr>';$buf =~s/[\n\r]//g;
while($buf=~m!$regex!go){$item=$1;$id=$2;$title=$3;$pic=$4;$price=$5;$bid=$6;
$time=$7;($time=~/font.*?FF0000/)?($time=~s/<.*?>//g and $time="<font color=ff0000>$time</font>"):($time=~s/<.*?>//g);
($pic=~/\/aw\/pics\/lst\/pic\.gif/)?($pic=$Picture_html):($pic = "");$bid=~/\d+/ or $bid = "0";$url = 'http://cgi.ebay.com/aw-cgi/eBayISAPI.dll?ViewItem&item='.$id;
$description="<b>Item:</b> $item, <b>Bid-Price:</b> $currency $price, <b>Total-Bids:</b> $bid<br><b>Bidding Ends:</b> $time &nbsp; $pic";$total++;
@results=(@results,"$e_name|$e_url|0|$title|$url|$description");}
}
sub match_eBay {return 'ebay';}$TOUT=4;
sub url_eBay { my $query=$_[0];return "http://search.ebay.com/search/search.dll?MfcISAPICommand=GetResult&ht=1&SortProperty=MetaEndSort&query=$query";}
1;