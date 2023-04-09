<?php
/*
  Script-tr.Org
  -----------------------
  Türkiye'nin en büyük script sitesi
  http://www.script-tr.org
*/ 
?>
<?
	header("location: ./ara.php?sehir=" .$HTTP_POST_VARS[sehir] ."&semt=" .$HTTP_POST_VARS[semt] ."&saticiadi=" .$HTTP_POST_VARS[saticiadi] ."&satis=" .$HTTP_POST_VARS[satis] ."&kategori=" .$HTTP_POST_VARS[kategori] ."&fiyatmin=" .$HTTP_POST_VARS[fiyatmin]  ."&fiyatmax=" .$HTTP_POST_VARS[fiyatmax] ."&alanmin=" .$HTTP_POST_VARS[alanmin] ."&alanmax=" .$HTTP_POST_VARS[alanmax] ."&odamin=" .$HTTP_POST_VARS[odamin] ."&odamax=" .$HTTP_POST_VARS[odamax] ."&salonmin=" .$HTTP_POST_VARS[salonmin] ."&salonmax=" .$HTTP_POST_VARS[salonmax]);
?>