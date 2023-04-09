<?php

define('GIDECEKMAIL', 'romeojulyet@hotmail.com');
define('KONU', 'Mailin Konusu');
//Mail gönderildikten sonra yönleneceði sayfa
define('YONLENECEGISAYFA', 'http://www.datakolik.com');


$deger['isimleri'] = array_keys($_POST);

for ( $i = 0; $i < count($deger['isimleri']); $i++) {
	$deger['degerleri'][$i] = $_POST[$deger['isimleri'][$i]];
	$mail .= $deger['isimleri'][$i] . ': ' . $deger['degerleri'][$i] . "\n";
}

if ( $_POST ) mail(GIDECEKMAIL, KONU, $mail);
header('Location: ' . YONLENECEGISAYFA);


?>