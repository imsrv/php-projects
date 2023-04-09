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

	<TITLE>Script-tr.Org Katkýlarýyla - Kiralýk / Satýlýk Gayrimenkul Listesi</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

	<CENTER>
	
	<TABLE WIDTH = "890" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "50" VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<FONT FACE = "Times New Roman" SIZE = "+1" COLOR = "DarkRed"><CENTER><B><U>GAYRÝMENKUL LÝSTESÝ</U></B></CENTER></FONT>

	</TD>

	</TR>

	</TABLE>


	<BR>


	<TABLE WIDTH = "890" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<CENTER>

		<BR>

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

			$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `gayrimenkul` ORDER BY `id` ASC", $baglanti), 0, 0);
		?>


		<TABLE WIDTH = "840" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">


		<TR HEIGHT = "120" VALIGN = "Center">

			<TD WIDTH = "840" COLSPAN = "11">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<CENTER>

				<IMG SRC = "../images/yoneticismall.jpg" BORDER = "0">&nbsp;&nbsp;<A HREF = "yonetici.php"><B>Yönetici Sayfasýna Git</B></A>&nbsp;&nbsp;|&nbsp;&nbsp;<IMG SRC = "../images/yonetimaramasmall.jpg" BORDER = "0">&nbsp;&nbsp;<A HREF = "arama.php"><B>Gayrimenkul Kaydý Ara</B></A>&nbsp;&nbsp;|&nbsp;&nbsp;<IMG SRC = "../images/yonetimkayiteklesmall.jpg" BORDER = "0">&nbsp;&nbsp;<A HREF = "ekleform.php"><B>Yeni Gayrimenkul Kaydý Ekle</B></A>

				<BR><BR><BR>

				<A HREF = "listele.php?sirala=id"><B>Gayrimenkul Koduna Göre Sýrala</B></A> | <A HREF = "listele.php?sirala=sehir"><B>Þehre Göre Sýrala</B></A> | <A HREF = "listele.php?sirala=satis"><B>Satýþ Türüne Göre Sýrala</B></A> | <A HREF = "listele.php?sirala=kategori"><B>Kategoriye Göre Sýrala</B></A> | <A HREF = "listele.php?sirala=fiyat"><B>Fiyata Göre Sýrala</B></A> | <A HREF = "listele.php?sirala=alan"><B>Alana Göre Sýrala</B></A>

				<BR><BR><BR>

				Toplam Kayýt Sayýsý : <B><? echo($total); ?></B>

				<BR><BR><BR>

				</CENTER>

				</FONT>

			</TD>

		</TR>


		<TR HEIGHT = "10" VALIGN = "Center">

			<TD WIDTH = "840" COLSPAN = "11"></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "40"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>ID</U></B></CENTER></FONT></TD>

			<TD WIDTH = "150"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Þehir</U></B></CENTER></FONT></TD>

			<TD WIDTH = "150"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Semt</U></B></CENTER></FONT></TD>

			<TD WIDTH = "80"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Satýþ Türü</U></B></CENTER></FONT></TD>

			<TD WIDTH = "80"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Kategori</U></B></CENTER></FONT></TD>

			<TD WIDTH = "80"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Fiyat (YTL)</U></B></CENTER></FONT></TD>

			<TD WIDTH = "80"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Oda</U></B></CENTER></FONT></TD>

			<TD WIDTH = "80"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Alan (m2)</U></B></CENTER></FONT></TD>

			<TD WIDTH = "60"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Detay</U></B></CENTER></FONT></TD>

			<TD WIDTH = "60"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Deðiþtir</U></B></CENTER></FONT></TD>

			<TD WIDTH = "60"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "Red"><CENTER><B><U>Sil</U></B></CENTER></FONT></TD>

		</TR>


		<TR HEIGHT = "10" VALIGN = "Center">

			<TD WIDTH = "840" COLSPAN = "11"></TD>

		</TR>


		<?
			if($total == 0)
			{
				echo("<TR HEIGHT = \"25\" VALIGN = \"Center\">");

				echo("<TD WIDTH = \"840\" COLSPAN = \"8\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">Satýlýk ya da kiralýk herhangi bir gayrimenkul bulunmamaktadýr.</FONT></TD>");

				echo("</TR>");
			}

			else
			{
				if(($HTTP_GET_VARS[sirala] == "") || ($HTTP_GET_VARS[sirala] == "id"))
				{
					$resultset = mysql_query("SELECT * FROM `gayrimenkul` ORDER BY `id` ASC", $baglanti);
				}

				if($HTTP_GET_VARS[sirala] == "sehir")
				{
					$resultset = mysql_query("SELECT * FROM `gayrimenkul` ORDER BY `sehir`, `id` ASC", $baglanti);
				}

				if($HTTP_GET_VARS[sirala] == "satis")
				{
					$resultset = mysql_query("SELECT * FROM `gayrimenkul` ORDER BY `satis`, `id` ASC", $baglanti);
				}

				if($HTTP_GET_VARS[sirala] == "kategori")
				{
					$resultset = mysql_query("SELECT * FROM `gayrimenkul` ORDER BY `kategori`, `id` ASC", $baglanti);
				}

				if($HTTP_GET_VARS[sirala] == "fiyat")
				{
					$resultset = mysql_query("SELECT * FROM `gayrimenkul` ORDER BY `fiyat`, `id` ASC", $baglanti);
				}

				if($HTTP_GET_VARS[sirala] == "alan")
				{
					$resultset = mysql_query("SELECT * FROM `gayrimenkul` ORDER BY `alan`, `id` ASC", $baglanti);
				}


				for($count = 0; $count < $total; $count++)
				{
					echo("<TR HEIGHT = \"26\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"40\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER><B>" .mysql_result($resultset, $count, "id") ."</B></CENTER></FONT></TD>");

					echo("<TD WIDTH = \"150\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "sehir") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"150\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "semt") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "satis") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "kategori") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "fiyat") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "oda") ."+"  .mysql_result($resultset, $count, "salon") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($resultset, $count, "alan") ."</CENTER></FONT></TD>");

					echo("<TD WIDTH = \"60\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><A HREF = \"detay.php?id=" .mysql_result($resultset, $count, "id") ."\"><CENTER><IMG SRC = \"../images/detay.jpg\" BORDER = \"0\"></A></CENTER></TD>");

					echo("<TD WIDTH = \"60\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><A HREF = \"degistirform.php?id=" .mysql_result($resultset, $count, "id") ."\"><CENTER><IMG SRC = \"../images/degistir.jpg\" BORDER = \"0\"></A></CENTER></TD>");

					echo("<TD WIDTH = \"60\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><A HREF = \"silonay.php?id=" .mysql_result($resultset, $count, "id") ."\"><CENTER><IMG SRC = \"../images/sil.jpg\" BORDER = \"0\"></A></CENTER></TD>");

					echo("</TR>");
				}
			}			
		?>


		<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "840" COLSPAN = "11"></TD>

		</TR>


		</TABLE>

	</TD>

	</TR>

	</TABLE>

	</CENTER>

</BODY>

</HTML>
