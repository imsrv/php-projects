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

	<TITLE>Script-tr.Org Katk�lar�yla /A��l�m Emlak - Yeni Gayrimenkul Ekle</TITLE>

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
			echo("<BR><BR><A HREF = \"ekleform.php\"><B>Geri D�n</B></A>");
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


			mysql_query("INSERT INTO `gayrimenkul` (`sehir`, `semt`, `adres`, `satis`, `kategori`, `fiyat`, `alan`, `oda`, `salon`, `banyo`, `kat`, `asansor`, `isinma`, `dogalgaz`, `balkon`, `bahce`, `otopark`, `mobilya`, `insatarihi`, `aciklamalar`, `saticiadi`, `saticitelefonsabit`, `saticitelefonmobil`) VALUES ('" .$HTTP_POST_VARS[sehir] ."', '". $HTTP_POST_VARS[semt] ."', '". $HTTP_POST_VARS[adres] ."', '". $HTTP_POST_VARS[satis] ."', '". $HTTP_POST_VARS[kategori] ."', '". $HTTP_POST_VARS[fiyat] ."', '". $HTTP_POST_VARS[alan] ."', '". $HTTP_POST_VARS[oda] ."', '". $HTTP_POST_VARS[salon] ."', '". $HTTP_POST_VARS[banyo] ."', '". $HTTP_POST_VARS[kat] ."', '". $asansor ."', '". $HTTP_POST_VARS[isinma] ."', '". $dogalgaz ."', '". $balkon ."', '". $bahce ."', '". $otopark ."', '". $mobilya ."', '". $insatarihi ."', '". $HTTP_POST_VARS[aciklamalar] ."', '". $HTTP_POST_VARS[saticiadi] ."', '". $HTTP_POST_VARS[saticitelefonsabit] ."', '". $HTTP_POST_VARS[saticitelefonmobil] ."')", $baglanti);


			echo("<BR>");

			echo("<IMG SRC = \"../images/success.jpg\">");			

			echo("<BR><BR>Kay�t ba�ar�yla eklendi.");

			echo("<BR><BR><BR><BR><A HREF = \"ekleform.php\"><B>Yeni Bir Kay�t Ekle</B></A>");

			echo("<BR><BR><A HREF = \"listele.php\"><B>Gayrimenkul Listesini G�r�nt�le</B></A>");

			echo("<BR><BR><A HREF = \"yonetici.php\"><B>Y�netici Sayfas�na Git</B></A>");
		}
	}
?>

</BODY>

</HTML>