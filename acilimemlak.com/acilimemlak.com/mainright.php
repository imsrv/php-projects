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
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-9">
</HEAD>

<BODY>

	<TABLE WIDTH = "600" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">

		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "600" COLSPAN = "9" BGCOLOR = "#FFFFFF"></TD>

		</TR>


		<?
			$baglanti = mysql_connect("localhost", "acilim", "mahmutayca");

			if(!$baglanti)
			{
				mysql_error("Veritabanı sunucusuna bağlanılamıyor...");
			}

			else
			{
				mysql_select_db("emlakdb", $baglanti) or die("Veritabanına erişilemiyor... Lütfen daha sonra tekrar deneyiniz..." );
			
			}


			$kiralikcount = mysql_result(mysql_query("SELECT COUNT(*) FROM `gayrimenkul` WHERE `satis` = 'Kiralık'", $baglanti), 0, 0);
			$satilikcount = mysql_result(mysql_query("SELECT COUNT(*) FROM `gayrimenkul` WHERE `satis` = 'Satılık'", $baglanti), 0, 0);


			if($kiralikcount > 0)
			{
				$kiralikidquery = mysql_query("SELECT `id` FROM `gayrimenkul` WHERE `satis` = 'Kiralık'", $baglanti);

				for($count = 0; $count < $kiralikcount; $count++)
				{
					$kiralikids[$count] = mysql_result($kiralikidquery, $count, "id");
				}

				if($kiralikcount < 6)
				{
					$kiralikarray = array_rand($kiralikids, $kiralikcount);

					if($kiralikcount == 1)
					{						
						$kiralikarray = array(0);
					}
				}

				else
				{
					$kiralikarray = array_rand($kiralikids, 6);
				}
			}

			if($satilikcount > 0)
			{
				$satilikidquery = mysql_query("SELECT `id` FROM `gayrimenkul` WHERE `satis` = 'Satılık'", $baglanti);

				for($count = 0; $count < $satilikcount; $count++)
				{
					$satilikids[$count] = mysql_result($satilikidquery, $count, "id");
				}

				if($satilikcount < 6)
				{
					$satilikarray = array_rand($satilikids, $satilikcount);

					if($satilikcount == 1)
					{						
						$satilikarray = array(0);
					}
				}

				else
				{
					$satilikarray = array_rand($satilikids, 6);
				}
			}
		?>






		<? /* Kiralık Gayrimenkuller */ ?>






		<TR HEIGHT = "30" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD COLSPAN = "8" WIDTH = "582" BACKGROUND = "images/sectionheaderright.jpg">

			<FONT FACE = "Tahoma" SIZE = "-1" COLOR = "#00614A">&nbsp;&nbsp;&nbsp;<B><U>Kiralık Gayrimenkullerden Seçmeler</U></B></FONT>

		</TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "582" COLSPAN = "8" BGCOLOR = "#888888"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "580" COLSPAN = "7" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "234" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($kiralikcount >= 1)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$kiralikids[$kiralikarray[0]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($kiralikcount >= 2)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$kiralikids[$kiralikarray[1]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($kiralikcount >= 3)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$kiralikids[$kiralikarray[2]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "580" COLSPAN = "7" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "234" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($kiralikcount >= 4)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$kiralikids[$kiralikarray[3]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($kiralikcount >= 5)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$kiralikids[$kiralikarray[4]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($kiralikcount >= 6)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$kiralikids[$kiralikarray[5]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "580" COLSPAN = "7" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "582" COLSPAN = "8" BGCOLOR = "#888888"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "600" COLSPAN = "9" BGCOLOR = "#FFFFFF"></TD>

		</TR>






		<? /* Satılık Gayrimenkuller */ ?>






		<TR HEIGHT = "30" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD COLSPAN = "8" WIDTH = "582" BACKGROUND = "images/sectionheaderright.jpg">

			<FONT FACE = "Tahoma" SIZE = "-1" COLOR = "#00614A">&nbsp;&nbsp;&nbsp;<B><U>Satılık Gayrimenkullerden Seçmeler</U></B></FONT>

		</TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "582" COLSPAN = "8" BGCOLOR = "#888888"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "580" COLSPAN = "7" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "234" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($satilikcount >= 1)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$satilikids[$satilikarray[0]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($satilikcount >= 2)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$satilikids[$satilikarray[1]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($satilikcount >= 3)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$satilikids[$satilikarray[2]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "580" COLSPAN = "7" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "234" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($satilikcount >= 4)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$satilikids[$satilikarray[3]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($satilikcount >= 5)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$satilikids[$satilikarray[4]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "164" BGCOLOR = "#CCCCCC">

			<?
				if($satilikcount >= 6)
				{
					$kayit = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = '" .$satilikids[$satilikarray[5]] ."'", $baglanti);

					echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						$filename = "images/gayrimenkul/" .mysql_result($kayit, 0, "id") .".jpg";
						$handle = @fopen($filename, "r");

						if($handle == false)
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($kayit, 0, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($kayit, 0, "sehir") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($kayit, 0, "semt") ."</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if((mysql_result($kayit, 0, "oda") == "0") && (mysql_result($kayit, 0, "salon") == "0"))
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($kayit, 0, "oda") ."+" .mysql_result($kayit, 0, "salon") ."</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						if(mysql_result($kayit, 0, "alan") == 0)
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
						}

						else
						{
							echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($kayit, 0, "alan") ." m2</FONT></TD>");
						}

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"20\">");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("<TD WIDTH = \"160\" BGCOLOR = \"#FFFFFF\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($kayit, 0, "fiyat") ." YTL</FONT></TD>");

						echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");


						echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

						echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

						echo("</TR>");

					echo("</TABLE>");
				}
			?>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "580" COLSPAN = "7" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "582" COLSPAN = "8" BGCOLOR = "#888888"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "600" COLSPAN = "9" BGCOLOR = "#FFFFFF"></TD>

		</TR>

	</TABLE>

</BODY>

</HTML>
