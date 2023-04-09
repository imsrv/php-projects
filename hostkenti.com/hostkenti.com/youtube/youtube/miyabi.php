<?php
if($_GET['url']){
	require_once("youtube.php");
	error_reporting(0);
	ini_set("max_execution_time",0);
	if($cek = download_youtube($_GET['url'])){
		$link = $cek;
	}
	else{
		$link = "Dosya Acilamadi";
	}
}
else{
	$link = "Lutfen baska bir link giriniz.!";
}
$a = file("im/itung.txt");
$now = $a[0];
$next = $now+1;
$b = fopen("im/itung.txt","w");
fputs($b,$next);
fclose($b);

echo $link."|".number_format($next);
?>