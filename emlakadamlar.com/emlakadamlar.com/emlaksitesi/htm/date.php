<? 

function tarih($zaman) { 
$gunler = array( 
"Pazar", 
"Pazartesi", 
"Sal�", 
"�ar�amba", 
"Per�embe", 
"Cuma", 
"Cumartesi" 
); 

$aylar =array( 
NULL, 
"Ocak", 
"�ubat", 
"Mart", 
"Nisan", 
"May�s", 
"Haziran", 
"Temmuz", 
"A�ustos", 
"Eyl�l", 
"Ekim", 
"Kas�m", 
"Aral�k" 
); 
$tarih = date("d",$zaman)." ".$aylar[date("n",$zaman)]." ".date("Y",$zaman)." ".$gunler[date("w",$zaman)]." ".date("H:i",$zaman); 
return $tarih; 
} 
?> 