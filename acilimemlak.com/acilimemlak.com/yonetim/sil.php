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

	<TITLE>Script-tr.Org Katk�lar�yla - Gayrimenkul Kayd� Silme</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

	<CENTER>

	<?
		$baglanti = mysql_connect("localhost", "acilim", "mahmutayca");

		if(!$baglanti)
		{
			mysql_error("Veritaban� sunucusuna ba�lan�lam�yor...");
		}

		else
		{
			mysql_select_db("emlakdb", $baglanti) or die("Veritaban�na eri�ilemiyor... L�tfen daha sonra tekrar deneyiniz..." .mysql_error());
		}

		mysql_query("DELETE FROM `gayrimenkul` WHERE `id` = '" .$HTTP_POST_VARS[id] ."'", $baglanti);


		echo("<FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

		echo("<BR>");

		echo("<IMG SRC = \"../images/success.jpg\">");			

		echo("<BR><BR>Kay�t ba�ar�yla silindi.");

		echo("<BR><BR><BR><BR><A HREF = \"listele.php\"><B>Gayrimenkul Listesini G�r�nt�le</B></A>");

		echo("<BR><BR><A HREF = \"yonetici.php\"><B>Y�netici Sayfas�na Git</B></A>");
	?>

	</CENTER>

</BODY>

</HTML>
