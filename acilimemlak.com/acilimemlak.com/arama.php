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

			<FONT FACE = "Tahoma" SIZE = "-1" COLOR = "#00614A">&nbsp;&nbsp;&nbsp;<B><U>Arama Formu</U></B></FONT>

		</TD>

		</TR>


		<TR HEIGHT = "2" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "582" COLSPAN = "8" BGCOLOR = "#888888"></TD>

		</TR>


		<TR HEIGHT = "60" VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD COLSPAN = "3" WIDTH = "580" BGCOLOR = "#CCCCCC">

			<CENTER>

			<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

			Tüm gayrimenkul kayýtlarýný görmek için,

			<BR>arama formuna herhangi bir veri girmeden "Aramayý Baþlat" düðmesine týklayýnýz.

			</FONT>

			</CENTER>

		</TD>

		</TR>


		<TR VALIGN = "Center">

		<TD WIDTH = "18" BGCOLOR = "#FFFFFF"></TD>

		<TD WIDTH = "2" BGCOLOR = "#888888"></TD>

		<TD WIDTH = "22" BGCOLOR = "#CCCCCC"></TD>

		<TD WIDTH = "536" BGCOLOR = "#FFFFFF">

			<TABLE WIDTH = "536" BORDER = "1" BORDERCOLOR = "#000000" CELLSPACING = "0" CELLPADDING = "0">

				<FORM ACTION = "araci.php" METHOD = "Post" NAME = "Ara">

				<TR VALIGN = "Center">

				<TD>

					<CENTER>

					<BR>

					<TABLE WIDTH = "500" BORDER = "0" CELLSPACING = "2" CELLPADDING = "2">

						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Þehir :</B></FONT></TD>

						<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "sehir"></TD>

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Semt :</B></FONT></TD>

						<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "semt"></TD>

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Satýþ Türü :</B></FONT></TD>

						<TD WIDTH = "300">

							<SELECT NAME = "satis" SIZE = "1">

								<OPTION SELECTED>Seçiniz...</OPTION>
								<OPTION>Kiralýk</OPTION>
								<OPTION>Satýlýk</OPTION>

							</SELECT>

						</TD>

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kategori :</B></FONT></TD>

						<TD WIDTH = "300">

							<SELECT NAME = "kategori" SIZE = "1">

								<OPTION SELECTED>Seçiniz...</OPTION>
								<OPTION>Daire</OPTION>
								<OPTION>Ev</OPTION>
								<OPTION>Ýþyeri</OPTION>
								<OPTION>Yazlýk</OPTION>
								<OPTION>Arsa</OPTION>
								<OPTION>Depo</OPTION>

							</SELECT>

						</TD>

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Fiyat (YTL) :</B></FONT></TD>

						<TD WIDTH = "300"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">Minimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "10" name = "fiyatmin">&nbsp;&nbsp;&nbsp;Maksimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "10" name = "fiyatmax">

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Alan (Metrekare) :</B></FONT></TD>

						<TD WIDTH = "300"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">Minimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "10" name = "alanmin">&nbsp;&nbsp;&nbsp;Maksimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "10" name = "alanmax">

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Oda :</B></FONT></TD>

						<TD WIDTH = "300"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">Minimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "2" name = "odamin">&nbsp;&nbsp;&nbsp;Maksimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "2" name = "odamax">

						</TR>


						<TR HEIGHT = "25" VALIGN = "Center">

						<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Salon :</B></FONT></TD>

						<TD WIDTH = "300"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">Minimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "2" name = "salonmin">&nbsp;&nbsp;&nbsp;Maksimum : <INPUT TYPE = "Text" SIZE = "3" MAXLENGTH = "2" name = "salonmax">

						</TR>

					</TABLE>

					<BR>
	
					<INPUT TYPE = "Submit" VALUE = "Aramayý Baþlat" NAME = "Ara"> &nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE = "Reset" VALUE = "Formu Temizle" NAME = "Temizle">

					</FORM>

					</CENTER>

					<BR>

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