<?

$cikti=file_get_contents("http://www.livexscores.com/index.php?p=&dlzka=4560");
$cikti=str_replace("updated every min., don't refresh", "Otamatik olarak güncellenmektedir...Rehresh Yapmaniza Gerek Yok", $cikti);
$cikti=str_replace("Free Bet", "Bet-At-Home", $cikti); 
$cikti=str_replace("http://www.betrescue.com/free_bet.shtml", "http://www.bet-at-home.com/campaign.aspx?cid=1463&lang=TR", $cikti);
$cikti=explode ('<td style=background:#fafafa;color:black;text-align:left;height:3px>', $cikti);
$cikti=explode ('</form>', $cikti[1]);
echo $cikti[0]; 

