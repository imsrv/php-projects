<?php
	$id = $_GET["id"];
	if( !$id ) $id = "menu";
	if( $id == "menu")
	{
	echo '
:.: Y�ll�k Hosting �yeliklerinde 1 Adet Alan Ad� �cretsiz!<br>
:.: Y�ll�k Hosting �yeliklerinde Fiyatlar 10 Ay �zerinden!<br>
:.: <a href="hosting.php?menu=hosting&paket=kucuk">Amat�r Webmasterlar, E-Host K���k Tam Size G�re!</a><br>
:.: <a href="hosting.php?menu=hosting&paket=pro">500 MB Web Alan�, 10 GB Ayl�k Trafik Sadece 99.9 $/YIL!</a><br>
:.: <a href="design.php?menu=design">Sizin i�in internet sitenizi yap�yoruz! Ayr�nt�lar i�in t�klay�n...</a>
		 ';
	}
?>