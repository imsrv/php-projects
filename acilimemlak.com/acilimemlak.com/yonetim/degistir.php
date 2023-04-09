<?php
/*
  Script-tr.Org
  -----------------------
  Türkiye'nin en büyük script sitesi
  http://www.script-tr.org
*/ 
?>
<HTML>

<HEAD>

	<TITLE>Açýlým Emlak - Gayrimenkul Bilgilerini Güncelle</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

<?
	$baglanti = mysql_connect("localhost", "acilim", "mahmutayca");

	if(!$baglanti)
	{
		mysql_error("Veritabaný sunucusuna baðlanýlamýyor...");
	}

	else
	{
		mysql_select_db("emlakdb", $baglanti) or die("Veritabanýna eriþilemiyor... Lütfen daha sonra tekrar deneyiniz..." .mysql_error());


		echo("<FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

		echo("<CENTER>");


		// Boþ olmamasý gereken alan kontrolü //


		$eksikvar = 0;


		if($HTTP_POST_VARS[sehir] == "")
		{
			echo("Þehir deðeri boþ.<BR>");
			$eksikvar = 1;
		}

		if($HTTP_POST_VARS[semt] == "")
		{
			echo("Semt deðeri boþ.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[satis] == "Seçiniz...")
		{
			echo("Satýþ türü deðeri boþ.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[kategori] == "Seçiniz...")
		{
			echo("Kategori deðeri boþ.<BR>");
			$eksikvar = 1;
		}

		if($HTTP_POST_VARS[fiyat] == "")
		{
			echo("Fiyat deðeri boþ.<BR>");
			$eksikvar = 1;
		}

		if($HTTP_POST_VARS[saticiadi] == "")
		{
			echo("Satýcý adý deðeri boþ.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[saticitelefonsabit] == "")
		{
			echo("Satýcý sabit telefon deðeri boþ.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[saticitelefonmobil] == "")
		{
			echo("Satýcý mobil telefon deðeri boþ.<BR>");
			$eksikvar = 1;
		}


		if($eksikvar == 1)
		{
			echo("<BR><BR><A HREF = \"degistirform.php?id=" .$HTTP_POST_VARS[id] ."\"><B>Geri Dön</B></A>");
		}


		// Eksik yoksa formu veritabanýna yazýyoruz. //


		else
		{
			if($HTTP_POST_VARS[asansor] == "-")
			{
				$asansor = "";
			}

			else
			{
				$asansor = $HTTP_POST_VARS[asansor];
			}


			if($HTTP_POST_VARS[balkon] == "-")
			{
				$balkon = "";
			}

			else
			{
				$balkon = $HTTP_POST_VARS[balkon];
			}


			if($HTTP_POST_VARS[bahce] == "-")
			{
				$bahce = "";
			}

			else
			{
				$bahce = $HTTP_POST_VARS[bahce];
			}


			if($HTTP_POST_VARS[dogalgaz] == "-")
			{
				$dogalgaz = "";
			}

			else
			{
				$dogalgaz = $HTTP_POST_VARS[dogalgaz];
			}


			if($HTTP_POST_VARS[otopark] == "-")
			{
				$otopark = "";
			}

			else
			{
				$otopark = $HTTP_POST_VARS[otopark];
			}



			if($HTTP_POST_VARS[mobilya] == "-")
			{
				$mobilya = "";
			}

			else
			{
				$mobilya = $HTTP_POST_VARS[mobilya];
			}


			$insatarihi = $HTTP_POST_VARS[insayil] ."-" .$HTTP_POST_VARS[insaay] ."-" .$HTTP_POST_VARS[insagun];


			mysql_query("UPDATE `gayrimenkul` SET `sehir` = '" .$HTTP_POST_VARS[sehir] ."', `semt` = '" .$HTTP_POST_VARS[semt] ."', `adres` = '" .$HTTP_POST_VARS[adres] ."', `satis` = '" .$HTTP_POST_VARS[satis] ."', `kategori` = '" .$HTTP_POST_VARS[kategori] ."', `fiyat` = '" .$HTTP_POST_VARS[fiyat] ."', `alan` = '" .$HTTP_POST_VARS[alan] ."', `oda` = '" .$HTTP_POST_VARS[oda] ."', `salon` = '" .$HTTP_POST_VARS[salon] ."', `banyo` = '" .$HTTP_POST_VARS[banyo] ."', `kat` = '" .$HTTP_POST_VARS[kat] ."', `asansor` = '" .$asansor ."', `isinma` = '" .$HTTP_POST_VARS[isinma] ."', `dogalgaz` = '" .$dogalgaz ."', `balkon` = '" .$balkon ."', `bahce` = '" .$bahce ."', `otopark` = '" .$otopark ."', `mobilya` = '" .$mobilya ."', `insatarihi` = '" .$insatarihi ."', `aciklamalar` = '" .$HTTP_POST_VARS[aciklamalar] ."', `saticiadi` = '" .$HTTP_POST_VARS[saticiadi] ."', `saticitelefonsabit` = '" .$HTTP_POST_VARS[saticitelefonsabit] ."', `saticitelefonmobil` = '" .$HTTP_POST_VARS[saticitelefonmobil] ."' WHERE `id` = '" .$HTTP_POST_VARS[id] ."'", $baglanti);


			echo("<BR>");

			echo("<IMG SRC = \"../images/success.jpg\">");			

			echo("<BR><BR>Kayýt baþarýyla güncellendi.");

			echo("<BR><BR><BR><BR><A HREF = \"detay.php?id=" .$HTTP_POST_VARS[id] ."\"><B>Güncellenen Kaydýn Detaylarýný Görüntüle</B></A>");

			echo("<BR><BR><A HREF = \"listele.php\"><B>Gayrimenkul Listesini Görüntüle</B></A>");

			echo("<BR><BR><A HREF = \"yonetici.php\"><B>Yönetici Sayfasýna Git</B></A>");
		}
	}
?>