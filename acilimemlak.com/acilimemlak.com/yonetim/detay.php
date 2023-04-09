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

	<TITLE>Script-tr.org katkýlarýyla - Gayrimenkul Detaylý Bilgi Formu</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

	<CENTER>

	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "50" VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<FONT FACE = "Times New Roman" SIZE = "+1" COLOR = "DarkRed"><CENTER><B><U>GAYRÝMENKUL DETAYLI BÝLGÝ FORMU</U></B></CENTER></FONT>

	</TD>

	</TR>

	</TABLE>


	<BR>


	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<CENTER>

		<BR>

		<TABLE WIDTH = "500" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">


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

			$sonuc = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = " .$HTTP_GET_VARS["id"], $baglanti);
		?>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Resim :</B></FONT></TD>

			<TD WIDTH = "300">

			<?

				$filename = "../images/gayrimenkul/" .mysql_result($sonuc, $count, "id") .".jpg";
				$handle = @fopen($filename, "r");

				if($handle == false)
				{
						echo("<IMG SRC = \"../images/nophoto.jpg\" BORDER = \"2\" BORDERCOLOR = \"#000000\"></CENTER><BR></TD>");
				}

				else
				{
						echo("<IMG SRC = " .$filename ." BORDER = \"2\" BORDERCOLOR = \"#000000\"></CENTER><BR></TD>");
				}
			?>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Þehir :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<? echo(mysql_result($sonuc, 0, "sehir")); ?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Semt :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?

					echo(mysql_result($sonuc, 0, "semt"));

				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Adres :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "adres") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "adres"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Satýcý Adý :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?

					echo(mysql_result($sonuc, 0, "saticiadi"));

				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Satýcý Telefon (Sabit) :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?

					echo(mysql_result($sonuc, 0, "saticitelefonsabit"));

				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Satýcý Telefon (Mobil) :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?

					echo(mysql_result($sonuc, 0, "saticitelefonmobil"));

				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Satýþ Türü :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<? echo(mysql_result($sonuc, 0, "satis")); ?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kategori :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<? echo(mysql_result($sonuc, 0, "kategori")); ?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Fiyat :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<? echo(mysql_result($sonuc, 0, "fiyat") ." YTL"); ?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Alan :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "alan") == 0)
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "alan") ." metrekare");
					}
				?>

				</FONT>

			</TD>

			</TR>



			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Oda :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "oda") == 0)
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "oda"));
					}
				?>

				</FONT>

			</TD>

			</TR>



			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Salon :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "salon") == 0)
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "salon"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Banyo :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "banyo") == 0)
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "banyo"));
					}
				?>

				</FONT>

			</TD>

			</TR>



			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Isýnma :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "isinma") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "isinma"));
					}
				?>

				</FONT>

			</TD>

			</TR>



			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kat :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "kat") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "kat"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Asansör :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "asansor") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "asansor"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Balkon :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "balkon") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "balkon"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Bahçe :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "bahce") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "bahce"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Doðalgaz :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "dogalgaz") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "dogalgaz"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Otopark :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "otopark") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "otopark"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Mobilya :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "mobilya") == "")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "mobilya"));
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Ýnþa Tarihi :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "insatarihi") == "0000-00-00")
					{
						echo("Belirtilmemiþ");
					}

					else
					{
						$tarih = mysql_result($sonuc, 0, "insatarihi");

						echo($tarih[8] .$tarih[9] ."/" .$tarih[5] .$tarih[6] ."/" .$tarih[0] .$tarih[1] .$tarih[2] .$tarih[3]);
					}
				?>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Açýklamalar :</B></FONT></TD>

			<TD WIDTH = "300">

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<?
					if(mysql_result($sonuc, 0, "aciklamalar") == "")
					{
						echo("-");
					}

					else
					{
						echo(mysql_result($sonuc, 0, "aciklamalar"));
					}
				?>

				</FONT>

			</TD>

			</TR>

		</TABLE>

		<BR><BR>

		<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

		<A HREF = "listele.php"><B>Gayrimenkul Listesine Geri Dön</B></A>

		<BR><BR>

		<A HREF = "degistirform.php?id=<? echo($HTTP_GET_VARS["id"]); ?>"><B>Kaydý Güncelle</B></A>

		<BR><BR>

		<A HREF = "silonay.php?id=<? echo($HTTP_GET_VARS["id"]); ?>"><B>Kaydý Sil</B></A>

		</FONT>

		<BR><BR>

	</TD>

	</TR>

	</TABLE>

	</CENTER>

</BODY>

</HTML>
