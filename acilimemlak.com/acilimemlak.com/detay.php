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

</HEAD>

<BODY>

	<TABLE WIDTH = "600" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">

		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD COLSPAN = "4" WIDTH = "582" BGCOLOR = "#FFFFFF"></TD>

		</TR>


		<TR HEIGHT = "30" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD COLSPAN = "4" WIDTH = "582" BACKGROUND = "images/sectionheaderright.jpg">

			<FONT FACE = "Tahoma" SIZE = "-1" COLOR = "#00614A">&nbsp;&nbsp;&nbsp;<B><U>Gayrimenkul Detay Bilgileri</U></B></FONT>

		</TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "582" COLSPAN = "8" BGCOLOR = "#888888"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD COLSPAN = "3" WIDTH = "580" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "536" BGCOLOR = "#FFFFFF">

			<TABLE WIDTH = "536" BORDER = "1" BORDERCOLOR = "#000000" CELLSPACING = "0" CELLPADDING = "0">

				<TR VALIGN = "Center">

				<TD>

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

					<CENTER>

					<BR>

					<TABLE WIDTH = "500" BORDER = "0" CELLSPACING = "2" CELLPADDING = "2">

						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Resim :</B></FONT></TD>

						<TD WIDTH = "300">

							<?
								$filename = "images/gayrimenkul/" .mysql_result($sonuc, $count, "id") .".jpg";
								$handle = @fopen($filename, "r");

								if($handle == false)
								{
									echo("<IMG SRC = \"images/nophoto.jpg\" BORDER = \"2\" BORDERCOLOR = \"#000000\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER><BR></TD>");
								}

								else
								{
									echo("<IMG SRC = " .$filename ." BORDER = \"2\" BORDERCOLOR = \"#000000\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER><BR></TD>");
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

							<? echo(mysql_result($sonuc, 0, "semt")); ?>

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

					<BR>

					</CENTER>

				</TD>

				</TR>

			</TABLE>

		</TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "20" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD COLSPAN = "3" WIDTH = "580" BGCOLOR = "#CCCCCC"></TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD COLSPAN = "4" WIDTH = "582" BGCOLOR = "#888888"></TD>

		</TR>

	</TABLE>

</BODY>

</HTML>