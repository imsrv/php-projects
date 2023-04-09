# Mod Yahoo Auction-Search

sub Yahoo {
my ($Picture_html,$Picture_URL);

# $Picture_URL = '<img src="http://your.server.com/images/pic.gif" width="16" height="14" border="0" alt="Picture Available">'; 

# (Put the Picture URL as on your server as required 
#          AND uncomment the above line)

#  -------  DO NOT CHANGE ANYTHING BELOW -------------------------------------------------------------

$Picture_html = $Picture_URL || '[<b>Picture</b>]';my ($title,$URL,$description,$accuracy);$accuracy="N/A";
my ($id,$pic,$price,$bid,$time);my $e_name="Yahoo";my $e_url="<a href\=\"http://auctions.yahoo.com\">$e_name</a>";
while ($buf =~m!$reg!go){$pic=$1;$id=$2;$title=$3;$price=$4;$bid=$5;$time=$6;$time = 'within '.$time;
($pic =~/http\:\/\/us\.yimg\.com\/i\/auctions\/cam\.gif/)?($pic=$Picture_html):($pic = "");
if ($bid =~m{<A HREF=\"http\:\/\/auctions\.yahoo\.com/show/bid_hist\?aID=\d+\">(\d+)<\/A>}g){$bid=$1;} 
else {$bid="0";}$URL='http://auctions.yahoo.com/auction/'.$id;$description="<b>Item:</b> $id, <b>Bid-Price:</b> $price, <b>Total-Bids:</b> $bid<br><b>Bidding Ends:</b> $time &nbsp; $pic";
$total++; @results=(@results,"$e_name|$e_url|$accuracy|$title|$URL|$description");}}
sub url_Yahoo {return "http://search.auctions.yahoo.com/search/auc?p=$_[0]&alocale=1us&acc=us";}
sub match_Yahoo {return '<tr.*?><td.*?>(.*?)</td><td>.*?<a href=\"http://page\.auctions\.yahoo\.com/auction/(\d+)\">(.*?)</a>.*?</td><td align=right><b>(.*?)</b></td><td align=center>(.*?)</td><td align=right>(.*?)</td></tr>';} $TOUT=4;
1;