<?
$cikti=@file_get_contents("http://www.canliskorlar.net/index.asp");
$cikti=str_replace("BASKETBOL CANLI SONU?LAR", "Otomatik olarak Guncellenmektedir. Sayfayi Yenilemenize Gerek yok", $cikti);
$cikti=explode ('<html>', $cikti);
$cikti=explode ('</html>', $cikti[1]);
echo $cikti[0]; 
?>

