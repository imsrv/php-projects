# Mod Amazon Auction-Search

sub Amazon {
my ($Picture_html,$Picture_URL);

#$Picture_URL = '<img src="http://your.server.com/images/pic.gif" width="16" height="14" border="0" alt="Picture Available">'; 

# (Put the Picture URL as on your server as required 
#          AND uncomment the above line)

#  -------  DO NOT CHANGE ANYTHING BELOW -------------------------------------------------------------

$Picture_html = $Picture_URL || '[<b>Picture</b>]';my ($title,$url,$description);my $e_name="Amazon-Auction";
my ($id,$pic,$price,$bid,$time);my $e_name="Amazon";my $e_url="<a href\=\"http://s1.amazon.com\">$e_name</a>";
my $regex1 = '<hr noshade size=1>(.*?)<br clear=all>';my $regex2 = '<a href=/exec/varzea/glance-browse/(.*?)/ix=auction.*?>(.*?)</a><font face=verdana,arial,helvetica size=-1>.*?<br><b> Current bid:<font color=#A00000>(.*?)</font></b>, <b> Bids: <font color=#A00000>(.*?)</font></b><br> <b>Time left:</b>(.*?)</font>';$buf =~s/[\n\r]//g;$buf =~s/\s+/ /g;
while($buf=~m!$regex1!g){$description=$1;$description=~s/<img src=\/g\/icons\/.*?\.gif .*?>//g;
$pic=($description=~s/<a href=\/exec\/varzea\/glance\-browse\/.*?><img src=\"http:\/\/s1\-images\.amazon\.com\/images\/A\/.*?><\/a>//);$pic = $pic || ($description=~s/<img src=\"http:\/\/s1\-images\.amazon\.com\/images\/A\/.*?>//);
if($description=~m!$regex2!g){$id=$1;$title=$2;$price=$3;$bid=$4;$time=$5;$pic and $pic=$Picture_html;
$description="<b>Item:</b> $id, <b>Bid-Price:</b> $price, <b>Total-Bids:</b> $bid<br><b>Bidding Ends:</b> $time &nbsp; $pic";
$url='http://s1.amazon.com/exec/varzea/glance-browse/'.$id.'/ix=auction&rank=%2Dbar&fqp=org-unit-id%014%02keywords%01&sz=50&pg=1/2/12/qid=';
$description="<b>Item:</b> $id, <b>Bid-Price:</b> $price, <b>Total-Bids:</b> $bid<br><b>Bidding Ends:</b> $time &nbsp; $pic";
$total++;@results=(@results,"$e_name|$e_url|0|$title|$url|$description");}}
}
sub match_Amazon {return 'a_z';}$TOUT=4;
sub url_Amazon {return "http://s1.amazon.com/exec/varzea/search-handle-form/?index=auction&query-0=$_[0]&field-0=titledesc&field-browse=&field-enddate=0a-&field-geo=ship-to&field-areaid=&field-zipcode=&field-org-unit-id=4&rank=%2Benddate";}$METHOD='POST';

1;