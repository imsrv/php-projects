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

	<TITLE>Script-tr.Org Katkýlarýyla - Gayrimenkul Kaydý Silme</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

	<CENTER>

	<?
		$baglanti = mysql_connect("localhost", "acilim", "mahmutayca");

		if(!$baglanti)
		{
			mysql_error("Veritabaný sunucusuna baðlanýlamýyor...");
		}

		else
		{
			mysql_select_db("emlakdb", $baglanti) or die("Veritabanýna eriþilemiyor... Lütfen daha sonra tekrar deneyiniz..." .mysql_error());
		}

		mysql_query("DELETE FROM `gayrimenkul` WHERE `id` = '" .$HTTP_POST_VARS[id] ."'", $baglanti);


		echo("<FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

		echo("<BR>");

		echo("<IMG SRC = \"../images/success.jpg\">");			

		echo("<BR><BR>Kayýt baþarýyla silindi.");

		echo("<BR><BR><BR><BR><A HREF = \"listele.php\"><B>Gayrimenkul Listesini Görüntüle</B></A>");

		echo("<BR><BR><A HREF = \"yonetici.php\"><B>Yönetici Sayfasýna Git</B></A>");
	?>

	</CENTER>

</BODY>

</HTML>
