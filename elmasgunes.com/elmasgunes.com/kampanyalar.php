<?php
	$id = $_GET["id"];
	if( !$id ) $id = "menu";
	if( $id == "menu")
	{
	echo '
:.: Yýllýk Hosting Üyeliklerinde 1 Adet Alan Adý Ücretsiz!<br>
:.: Yýllýk Hosting Üyeliklerinde Fiyatlar 10 Ay Üzerinden!<br>
:.: <a href="hosting.php?menu=hosting&paket=kucuk">Amatör Webmasterlar, E-Host Küçük Tam Size Göre!</a><br>
:.: <a href="hosting.php?menu=hosting&paket=pro">500 MB Web Alaný, 10 GB Aylýk Trafik Sadece 99.9 $/YIL!</a><br>
:.: <a href="design.php?menu=design">Sizin için internet sitenizi yapýyoruz! Ayrýntýlar için týklayýn...</a>
		 ';
	}
?>