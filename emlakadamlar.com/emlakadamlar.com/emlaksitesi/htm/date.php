<? 

function tarih($zaman) { 
$gunler = array( 
"Pazar", 
"Pazartesi", 
"Salý", 
"Çarþamba", 
"Perþembe", 
"Cuma", 
"Cumartesi" 
); 

$aylar =array( 
NULL, 
"Ocak", 
"Þubat", 
"Mart", 
"Nisan", 
"Mayýs", 
"Haziran", 
"Temmuz", 
"Aðustos", 
"Eylül", 
"Ekim", 
"Kasým", 
"Aralýk" 
); 
$tarih = date("d",$zaman)." ".$aylar[date("n",$zaman)]." ".date("Y",$zaman)." ".$gunler[date("w",$zaman)]." ".date("H:i",$zaman); 
return $tarih; 
} 
?> 