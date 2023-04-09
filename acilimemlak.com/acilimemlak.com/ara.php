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

<BODY LINK = "#0000FF" VLINK = "#0000FF">

	<?
		$baglanti = mysql_connect("localhost", "acilim", "mahmutayca");

		if(!$baglanti)
		{
			mysql_error("Veritabanı sunucusuna bağlanılamıyor...");
		}

		else
		{
			mysql_select_db("emlakdb", $baglanti) or die("Veritabanına erişilemiyor... Lütfen daha sonra tekrar deneyiniz..." .mysql_error());


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


			if($HTTP_GET_VARS[satis] != "Seçiniz...")
			{
				if($empty == 0)
				{
					$querystring .= " AND ";
				}

				$querystring .= "`satis` = '" .$HTTP_GET_VARS[satis] ."'";

				$empty = 0;
			}


			if($HTTP_GET_VARS[kategori] != "Seçiniz...")
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


			// Kayıt Bulunamazsa //

			if($sayi == 0)
			{				
				echo("<TABLE WIDTH = \"600\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

					echo("<TR HEIGHT = \"20\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"600\"COLSPAN = \"9\"  BGCOLOR = \"#FFFFFF\"></TD>");

					echo("</TR>");


					echo("<TR HEIGHT = \"30\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD COLSPAN = \"8\" WIDTH = \"582\" BACKGROUND = \"images/sectionheaderright.jpg\">");

						echo("<FONT FACE = \"Tahoma\" SIZE = \"-1\" COLOR = \"#00614A\">&nbsp;&nbsp;&nbsp;<B><U>Arama Sonuçları</U></B></FONT>");

					echo("</TD>");

					echo("</TR>");


					echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD WIDTH = \"582\" COLSPAN = \"8\" BGCOLOR = \"#888888\"></TD>");

					echo("</TR>");


					echo("<TR HEIGHT = \"150\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD WIDTH = \"2\" BGCOLOR = \"#888888\"></TD>");

					echo("<TD COLSPAN = \"7\" WIDTH = \"580\" BGCOLOR = \"#CCCCCC\">");

						echo("<CENTER><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\">");

						echo("<BR><BR>Aradığınız kriterlere göre kayıt bulunamadı.<BR>");

						echo("<BR><BR><BR><A HREF = \"arama.php\">Yeni Bir Arama Başlat</A>");

						echo("<BR><BR><A HREF = \"mainright.php\">Ana Sayfaya Geri Dön</A>");

						echo("<BR><BR><BR></FONT></CENTER>");

					echo("</TD>");

					echo("</TR>");


					echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD COLSPAN = \"8\" WIDTH = \"582\" BGCOLOR = \"#888888\"></TD>");

					echo("</TR>");

				echo("</TABLE>");
			}


			// Kayıt Bulunursa //

			if($sayi > 0)
			{				
				echo("<TABLE WIDTH = \"600\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

					echo("<TR HEIGHT = \"20\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"600\" COLSPAN = \"9\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("</TR>");


					echo("<TR HEIGHT = \"30\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD COLSPAN = \"8\" WIDTH = \"582\" BACKGROUND = \"images/sectionheaderright.jpg\">");

						echo("<FONT FACE = \"Tahoma\" SIZE = \"-1\" COLOR = \"#00614A\">&nbsp;&nbsp;&nbsp;<B><U>Arama Sonuçları</U></B></FONT>");

					echo("</TD>");

					echo("</TR>");


					echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD WIDTH = \"582\" COLSPAN = \"8\" BGCOLOR = \"#888888\"></TD>");

					echo("</TR>");


					echo("<TR VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD WIDTH = \"2\" BGCOLOR = \"#888888\"></TD>");

					echo("<TD COLSPAN = \"7\" WIDTH = \"580\" BGCOLOR = \"#CCCCCC\">");

						echo("<CENTER><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><BR><BR>Aradığınız kriterlere göre <B>" .$sayi ."</B> kayıt bulundu.");


						$numpages = ceil($sayi / 12);

						if($numpages > 1)
						{
							echo("<BR><BR><BR>");

							for($count = 0; $count < $numpages; $count++)
							{
								echo("<A HREF = \"ara.php?basla=" .($count * 12) ."&sehir=" .$HTTP_GET_VARS[sehir] ."&semt=" .$HTTP_GET_VARS[semt] ."&satis=" .$HTTP_GET_VARS[satis] ."&kategori=" .$HTTP_GET_VARS[kategori] ."&fiyatmin=" .$HTTP_GET_VARS[fiyatmin]  ."&fiyatmax=" .$HTTP_GET_VARS[fiyatmax] ."&alanmin=" .$HTTP_GET_VARS[alanmin] ."&alanmax=" .$HTTP_GET_VARS[alanmax] ."&odamin=" .$HTTP_GET_VARS[odamin] ."&odamax=" .$HTTP_GET_VARS[odamax] ."&salonmin=" .$HTTP_GET_VARS[salonmin] ."&salonmax=" .$HTTP_GET_VARS[salonmax] ."\">Sayfa " .($count + 1) ."</A> ");

								if($count < ($numpages - 1))
								{
									echo(" | ");
								}
							}
						}


						echo("<BR><BR><BR>");

						echo("</FONT></CENTER>");

					echo("</TD>");

					echo("</TR>");


					// Bulunan kayıtları gösteriyoruz. Bir sayfada en fazla 12 sonuç görüntülenecektir. Sonuçlar her satırda 3 kayıt olmak üzere 4 satıra yerleştirilecektir. //


					$done = 0;

					for($count = $HTTP_GET_VARS[basla]; $count < ($HTTP_GET_VARS[basla] + 12); $count++)
					{
						// Elimizdeki tüm kayıtları gösterip göstermediğimizi kontrol ediyoruz.//
						// Eğer tüm kayıtları göstermişsek, "$done" değişkenini 1'e eşitliyoruz. //

						if($count == $sayi)
						{
							$done = 1;
						}


						// Eğer elimizdeki tüm kayıtları göstermemişsek ve bir üstteki satır dolduysa, yeni bir satıra geçiyoruz. //

						if(($count % 3) == 0)
						{
							echo("<TR HEIGHT = \"234\" VALIGN = \"Center\">");

							echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

							echo("<TD WIDTH = \"2\" BGCOLOR = \"#888888\"></TD>");

							echo("<TD WIDTH = \"22\" BGCOLOR = \"#CCCCCC\"></TD>");
						}


						// Eğer tüm kayıtları göstermişsek, yani "$done" 1'e eşitse, artık hücreleri boş bırakıyoruz. //

						if($done == 1)
						{
							echo("<TD WIDTH = \"164\" BGCOLOR = \"#CCCCCC\">");

								echo("<TABLE WIDTH = \"164\" BORDER = \"0\" BORDERCOLOR = \"#CCCCCC\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

									echo("<TR HEIGHT = \"234\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" BGCOLOR = \"#CCCCCC\"></TD>");

									echo("</TR>");

								echo("</TABLE>");

							echo("</TD>");

							echo("<TD WIDTH = \"22\" BGCOLOR = \"#CCCCCC\"></TD>");
						}


						// Eğer tüm kayıtları göstermemişsek, hücrelere kayıtları yazdırmaya devam ediyoruz. //

						else
						{
							echo("<TD WIDTH = \"164\" BGCOLOR = \"#FFFFFF\">");

								echo("<TABLE WIDTH = \"164\" BORDER = \"0\" CELLSPACING = \"0\" CELLPADDING = \"0\">");

									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"120\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									$filename = "images/gayrimenkul/" .mysql_result($sonuc, $count, "id") .".jpg";
									$handle = @fopen($filename, "r");

									if($handle == false)
									{
										echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($sonuc, $count, "id") ."\"><IMG SRC = \"images/nophoto.jpg\" BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
									}

									else
									{
										echo("<TD WIDTH = \"160\"><CENTER><A HREF = \"detay.php?id=" .mysql_result($sonuc, $count, "id") ."\"><IMG SRC = " .$filename ." BORDER = \"0\" HEIGHT = \"120\" WIDTH = \"160\"></CENTER></TD>");
									}

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"20\">");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Şehir :</B> " .mysql_result($sonuc, $count, "sehir") ."</FONT></TD>");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"20\">");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Semt :</B> " .mysql_result($sonuc, $count, "semt") ."</FONT></TD>");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"20\">");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									if((mysql_result($sonuc, $count, "oda") == "0") && (mysql_result($sonuc, $count, "salon") == "0"))
									{
										echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> Belirtilmemiş</FONT></TD>");
									}

									else
									{
										echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Oda :</B> " .mysql_result($sonuc, $count, "oda") ."+" .mysql_result($sonuc, $count, "salon") ."</FONT></TD>");
									}

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"20\">");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									if(mysql_result($sonuc, $count, "alan") == 0)
									{
										echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> Belirtilmemiş</FONT></TD>");
									}

									else
									{
										echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Alan :</B> " .mysql_result($sonuc, $count, "alan") ." m2</FONT></TD>");
									}

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"20\">");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("<TD WIDTH = \"160\"><FONT FACE = \"Verdana\" SIZE = \"-2\" COLOR = \"#000000\"><B>&nbsp;&nbsp;Fiyat :</B> " .mysql_result($sonuc, $count, "fiyat") ." YTL</FONT></TD>");

									echo("<TD WIDTH = \"2\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");


									echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

									echo("<TD WIDTH = \"164\" COLSPAN = \"3\" BGCOLOR = \"#000000\"></TD>");

									echo("</TR>");

								echo("</TABLE>");

							echo("</TD>");

							echo("<TD WIDTH = \"22\" BGCOLOR = \"#CCCCCC\"></TD>");
						}


						// Eğer gösterilen kayıt sırası 3'e erişmişse, yeni satıra geçiyoruz. //

						if(($count % 3) == 2)
						{
							echo("</TR>");

							echo("<TR HEIGHT = \"20\" VALIGN = \"Center\">");

							echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

							echo("<TD WIDTH = \"2\" BGCOLOR = \"#888888\"></TD>");

							echo("<TD COLSPAN = \"7\" WIDTH = \"580\" BGCOLOR = \"#CCCCCC\"></TD>");

							echo("</TR>");


							// Eğer elimizdeki kayıtlar bittiyse, sadece bu sıranın sonuna kadar olan hücreleri boş bırakıyoruz. //
							// Daha sonra "$count"u bitiş değerine eşitleyip, döngüden çıkıyoruz. Böylece gereksiz yere yeni bir satıra geçmiyoruz. //

							if($done == 1)
							{
								$count = $HTTP_GET_VARS[basla] + 12;
							}
						}
					}

					echo("<TR HEIGHT = \"2\" VALIGN = \"Center\">");

					echo("<TD WIDTH = \"18\" BGCOLOR = \"#FFFFFF\"></TD>");

					echo("<TD COLSPAN = \"8\" WIDTH = \"582\" BGCOLOR = \"#888888\"></TD>");

					echo("</TR>");

				echo("</TABLE>");
			}
		}
	?>

</BODY>

</HTML>
