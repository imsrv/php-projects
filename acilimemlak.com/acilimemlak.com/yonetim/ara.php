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

	<TITLE>A��l�m Emlak - Gayrimenkul Arama Formu</TITLE>

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


			$querystring = "";
			$empty = 1;


			if($HTTP_GET_VARS[sehir] != "")
			{
				$querystring .= "`sehir` = '" .$HTTP_GET_VARS[sehir] ."'";

				$empty = 0;
			}

		
			if($HTTP_GET_VARS[semt] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`semt` = '" .$HTTP_GET_VARS[semt] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[saticiadi] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`saticiadi` LIKE '%" .$HTTP_GET_VARS[saticiadi] ."%'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[satis] != "Se�iniz...")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`satis` = '" .$HTTP_GET_VARS[satis] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[kategori] != "Se�iniz...")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`kategori` = '" .$HTTP_GET_VARS[kategori] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[fiyatmin] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`fiyat` >= '" .$HTTP_GET_VARS[fiyatmin] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[fiyatmax] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`fiyat` <= '" .$HTTP_GET_VARS[fiyatmax] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[alanmin] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`alan` >= '" .$HTTP_GET_VARS[alanmin] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[alanmax] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`alan` <= '" .$HTTP_GET_VARS[alanmax] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[odamin] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`oda` >= '" .$HTTP_GET_VARS[odamin] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[odamax] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`oda` <= '" .$HTTP_GET_VARS[odamax] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[salonmin] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`salon` >= '" .$HTTP_GET_VARS[salonmin] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[salonmax] != "")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`salon` <= '" .$HTTP_GET_VARS[salonmax] ."'";

				$empty = 0;
			}


			if($querystring == "")
			{
				$querystring = "1";
			}


			$sayi = mysql_result(mysql_query("SELECT COUNT(*) FROM `gayrimenkul` WHERE " .$querystring, $baglanti), 0, 0);

			$sonuc = mysql_query("SELECT * FROM `gayrimenkul` WHERE " .$querystring ." ORDER BY `id` ASC", $baglanti);


			// Kay�t Bulunamazsa //

			if($sayi == 0)
			{				
				echo("<TABLE WIDTH = \"550\" BORDER = \"2\" BORDERCOLOR = \"DarkRed\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

				echo("<TR HEIGHT = \"50\" VALIGN = \"Center\">");

				echo("<TD BGCOLOR = \"#FFFFFF\">");

					echo("<FONT FACE = \"Times New Roman\" SIZE = \"+1\" COLOR = \"DarkRed\"><CENTER><B><U>GAYR�MENKUL KAYDI ARAMA SONU�LARI</U></B></CENTER></FONT>");

				echo("</TD>");

				echo("</TR>");

				echo("</TABLE>");

				echo("</FONT>");

				echo("<BR>");


				echo("<TABLE WIDTH = \"550\" BORDER = \"2\" BORDERCOLOR = \"DarkRed\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

				echo("<TR VALIGN = \"Center\">");

				echo("<TD BGCOLOR = \"#FFFFFF\">");

					echo("<CENTER>");

					echo("<FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

					echo("<BR><BR>");

					echo("Arad���n�z kriterlere g�re kay�t bulunamad�.");

					echo("<BR><BR><BR>");

					echo("</CENTER>");

				echo("</TD>");

				echo("</TR>");

				echo("</TABLE>");
			}


			// Kay�t Bulunursa //

			if($sayi > 0)
			{				
				echo("<TABLE WIDTH = \"890\" BORDER = \"2\" BORDERCOLOR = \"DarkRed\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

				echo("<TR HEIGHT = \"50\" VALIGN = \"Center\">");

				echo("<TD BGCOLOR = \"#FFFFFF\">");

					echo("<FONT FACE = \"Times New Roman\" SIZE = \"+1\" COLOR = \"DarkRed\"><CENTER><B><U>GAYR�MENKUL KAYDI ARAMA SONU�LARI</U></B></CENTER></FONT>");

				echo("</TD>");

				echo("</TR>");

				echo("</TABLE>");

				echo("</FONT>");


				echo("<BR>");


				echo("<TABLE WIDTH = \"890\" BORDER = \"2\" BORDERCOLOR = \"DarkRed\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

				echo("<TR VALIGN = \"Center\">");

				echo("<TD BGCOLOR = \"#FFFFFF\">");

					echo("<CENTER>");

					echo("<BR>");			

					echo("<TABLE WIDTH = \"840\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"60\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"840\" COLSPAN = \"11\">");

							echo("<FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

							echo("<CENTER>");

							echo("<IMG SRC = \"../images/yoneticismall.jpg\" BORDER = \"0\">&nbsp;&nbsp;<A HREF = \"yonetici.php\"><B>Y�netici Sayfas�na Git</B></A>&nbsp;&nbsp;|&nbsp;&nbsp;<IMG SRC = \"../images/yonetimlistelesmall.jpg\" BORDER = \"0\">&nbsp;&nbsp;<A HREF = \"listele.php\"><B>T�m Gayrimenkul Kay�tlar�n� Listele</B></A>&nbsp;&nbsp;|&nbsp;&nbsp;<IMG SRC = \"../images/yonetimkayiteklesmall.jpg\" BORDER = \"0\">&nbsp;&nbsp;<A HREF = \"ekleform.php\"><B>Yeni Gayrimenkul Kayd� Ekle</B></A>");

							echo("<BR><BR><BR>");

							echo("Arad���n�z kriterlere g�re <B>" .$sayi ."</B> kay�t bulundu.");

							echo("<BR><BR><BR>");

							echo("</CENTER>");

							echo("</FONT>");

						echo("</TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"10\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"840\" COLSPAN = \"11\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"25\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"40\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>ID</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"150\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>�ehir</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"150\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Semt</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"80\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Sat�� T�r�</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"80\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Kategori</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"80\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Fiyat (YTL)</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"80\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Oda</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"80\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Alan (m2)</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"60\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Detay</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"60\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>De�i�tir</U></B></CENTER></FONT></TD>");

						echo("<TD WIDTH = \"60\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"Red\"><CENTER><B><U>Sil</U></B></CENTER></FONT></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"10\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"840\" COLSPAN = \"11\"></TD>");

						echo("</TR>");


						for($count = 0; $count < $sayi; $count++)
						{
							echo("<TR HEIGHT = \"26\" VALIGN = \"Center\">");

							echo("<TD WIDTH = \"40\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER><B>" .mysql_result($sonuc, $count, "id") ."</B></CENTER></FONT></TD>");

							echo("<TD WIDTH = \"150\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "sehir") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"150\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "semt") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "satis") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "kategori") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "fiyat") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "oda") ."+"  .mysql_result($sonuc, $count, "salon") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"80\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><CENTER>" .mysql_result($sonuc, $count, "alan") ."</CENTER></FONT></TD>");

							echo("<TD WIDTH = \"60\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><A HREF = \"detay.php?id=" .mysql_result($sonuc, $count, "id") ."\"><CENTER><IMG SRC = \"../images/detay.jpg\" BORDER = \"0\"></A></CENTER></TD>");

							echo("<TD WIDTH = \"60\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><A HREF = \"degistirform.php?id=" .mysql_result($sonuc, $count, "id") ."\"><CENTER><IMG SRC = \"../images/degistir.jpg\" BORDER = \"0\"></A></CENTER></TD>");

							echo("<TD WIDTH = \"60\""); if(($count % 2) == 0) { echo(" BGCOLOR = \"#CCCCCC\""); } echo("><A HREF = \"silonay.php?id=" .mysql_result($sonuc, $count, "id") ."\"><CENTER><IMG SRC = \"../images/sil.jpg\" BORDER = \"0\"></A></CENTER></TD>");

							echo("</TR>");
						}

						echo("<TR HEIGHT = \"25\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"840\" COLSPAN = \"11\"></TD>");

						echo("</TR>");

					echo("</TABLE>");

				echo("</TD>");

				echo("</TR>");

				echo("</TABLE>");
			}
		}
	?>

</BODY>

</HTML>