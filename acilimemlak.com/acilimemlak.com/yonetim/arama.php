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

	<TITLE>Açýlým Emlak - Gayrimenkul Arama Formu</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif" LINK = "#0000FF" VLINK = "#0000FF">

	<CENTER>

	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "50" VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<FONT FACE = "Times New Roman" SIZE = "+1" COLOR = "DarkRed"><CENTER><B><U>GAYRÝMENKUL ARAMA FORMU</U></B></CENTER></FONT>

	</TD>

	</TR>

	</TABLE>


	<BR>


	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<CENTER>

		<BR>

		<FORM ACTION = "araci.php" METHOD = "Post" NAME = "Ara">

		<TABLE WIDTH = "500" BORDER = "0" CELLSPACING = "2" CELLPADDING = "2">

			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "500" COLSPAN = 2>

				<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

				<CENTER>

				Tüm gayrimenkul kayýtlarýný görmek için,

				<BR>arama formuna herhangi bir veri girmeden "Aramayý Baþlat" düðmesine týklayýnýz. 

				<BR><BR>

				Satýcý ismiyle aramak istiyorsanýz, ismin sadece bir kýsmýný (adý ya da soyadý) girebilirsiniz.

				<BR><BR><BR>

				</CENTER>

				</FONT>

			</TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Þehir :</B></FONT></TD>

			<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "sehir"></TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Semt :</B></FONT></TD>

			<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "semt"></TD>

			</TR>


			<TR HEIGHT = "25" VALIGN = "Center">

			<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Satýcý Adý :</B></FONT></TD>

			<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "40" name = "saticiadi"></TD>

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

		<BR><BR>
	
		<INPUT TYPE = "Submit" VALUE = "Aramayý Baþlat" NAME = "Ara"> &nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE = "Reset" VALUE = "Formu Temizle" NAME = "Temizle">

		</FORM>

		<BR>

		</CENTER>

	</TD>

	</TR>

	</TABLE>

	</CENTER>

</BODY>

</HTML>
