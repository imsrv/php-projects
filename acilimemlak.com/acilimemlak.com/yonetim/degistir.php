<?php
/*
  Script-tr.Org
  -----------------------
  T�rkiye'nin en b�y�k script sitesi
  http://www.script-tr.org
*/ 
?>
<HTML>

<HEAD>

	<TITLE>A��l�m Emlak - Gayrimenkul Bilgilerini G�ncelle</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

<?
	$baglanti = mysql_connect("localhost", "acilim", "mahmutayca");

	if(!$baglanti)
	{
		mysql_error("Veritaban� sunucusuna ba�lan�lam�yor...");
	}

	else
	{
		mysql_select_db("emlakdb", $baglanti) or die("Veritaban�na eri�ilemiyor... L�tfen daha sonra tekrar deneyiniz..." .mysql_error());


		echo("<FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

		echo("<CENTER>");


		// Bo� olmamas� gereken alan kontrol� //


		$eksikvar = 0;


		if($HTTP_POST_VARS[sehir] == "")
		{
			echo("�ehir de�eri bo�.<BR>");
			$eksikvar = 1;
		}

		if($HTTP_POST_VARS[semt] == "")
		{
			echo("Semt de�eri bo�.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[satis] == "Se�iniz...")
		{
			echo("Sat�� t�r� de�eri bo�.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[kategori] == "Se�iniz...")
		{
			echo("Kategori de�eri bo�.<BR>");
			$eksikvar = 1;
		}

		if($HTTP_POST_VARS[fiyat] == "")
		{
			echo("Fiyat de�eri bo�.<BR>");
			$eksikvar = 1;
		}

		if($HTTP_POST_VARS[saticiadi] == "")
		{
			echo("Sat�c� ad� de�eri bo�.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[saticitelefonsabit] == "")
		{
			echo("Sat�c� sabit telefon de�eri bo�.<BR>");
			$eksikvar = 1;
		}


		if($HTTP_POST_VARS[saticitelefonmobil] == "")
		{
			echo("Sat�c� mobil telefon de�eri bo�.<BR>");
			$eksikvar = 1;
		}


		if($eksikvar == 1)
		{
			echo("<BR><BR><A HREF = \"degistirform.php?id=" .$HTTP_POST_VARS[id] ."\"><B>Geri D�n</B></A>");
		}


		// Eksik yoksa formu veritaban�na yaz�yoruz. //


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

			echo("<BR><BR>Kay�t ba�ar�yla g�ncellendi.");

			echo("<BR><BR><BR><BR><A HREF = \"detay.php?id=" .$HTTP_POST_VARS[id] ."\"><B>G�ncellenen Kayd�n Detaylar�n� G�r�nt�le</B></A>");

			echo("<BR><BR><A HREF = \"listele.php\"><B>Gayrimenkul Listesini G�r�nt�le</B></A>");

			echo("<BR><BR><A HREF = \"yonetici.php\"><B>Y�netici Sayfas�na Git</B></A>");
		}
	}
?>