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

	<TITLE>Script-tr.Org Katk�lar�yla  - Yeni Gayrimenkul Ekle</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif">

	<CENTER>

	<FORM ACTION = "ekle.php" METHOD = "Post" NAME = "Ekle">


	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "50" VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<FONT FACE = "Times New Roman" SIZE = "+1" COLOR = "DarkRed"><CENTER><B><U>GAYR�MENKUL EKLEME FORMU</U></B></CENTER></FONT>

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


		<TR HEIGHT = "60" VALIGN = "Center">

		<TD WIDTH = "500" COLSPAN = "2"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><FONT COLOR = "Red">*</FONT> i�areti doldurulmas� zorunlu alanlar� g�sterir.<BR><BR></FONT></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>�ehir <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "sehir"></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Semt <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "semt"></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Adres :</B></FONT></TD>

		<TD WIDTH = "300"><TEXTAREA NAME = "adres" ROWS = "4" COLS = "35" MAXLENGTH = "300"></TEXTAREA>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�c� Ad� <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "saticiadi"></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�c� Telefon (Sabit) <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "saticitelefonsabit"></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�c� Telefon (Mobil) <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" name = "saticitelefonmobil"></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�� T�r� <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "satis" SIZE = "1">

				<OPTION SELECTED>Se�iniz...</OPTION>
				<OPTION>Kiral�k</OPTION>
				<OPTION>Sat�l�k</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kategori <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "kategori" SIZE = "1">

				<OPTION SELECTED>Se�iniz...</OPTION>
				<OPTION>Daire</OPTION>
				<OPTION>Ev</OPTION>
				<OPTION>��yeri</OPTION>
				<OPTION>Yazl�k</OPTION>
				<OPTION>Arsa</OPTION>
				<OPTION>Depo</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Fiyat (YTL) <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "10" name = "fiyat">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Alan (Metrekare) :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "10" name = "alan">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Oda :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "5" name = "oda">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Salon :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "5" name = "salon">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Banyo :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "5" name = "banyo">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Is�nma :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "15" name = "isinma">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kat :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "15" name = "kat">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Asans�r :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "asansor" SIZE = "1">

				<OPTION SELECTED>-</OPTION>
				<OPTION>Var</OPTION>
				<OPTION>Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Balkon :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "balkon" SIZE = "1">

				<OPTION SELECTED>-</OPTION>
				<OPTION>Var</OPTION>
				<OPTION>Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Bah�e :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "bahce" SIZE = "1">

				<OPTION SELECTED>-</OPTION>
				<OPTION>Var</OPTION>
				<OPTION>Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Do�algaz :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "dogalgaz" SIZE = "1">

				<OPTION SELECTED>-</OPTION>
				<OPTION>Var</OPTION>
				<OPTION>Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Otopark :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "otopark" SIZE = "1">

				<OPTION SELECTED>-</OPTION>
				<OPTION>Yok</OPTION>
				<OPTION>Otopark</OPTION>
				<OPTION>Kapal� Garaj</OPTION>
				<OPTION>Otopark Ve Kapal� Garaj</OPTION

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Mobilya :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "mobilya" SIZE = "1">

				<OPTION SELECTED>-</OPTION>
				<OPTION>Var</OPTION>
				<OPTION>Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>�n�a Tarihi (G�n / Ay / Y�l) :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "2" MAXLENGTH = "2" name = "insagun">&nbsp;<INPUT TYPE = "Text" SIZE = "2" MAXLENGTH = "2" name = "insaay">&nbsp;<INPUT TYPE = "Text" SIZE = "4" MAXLENGTH = "4" name = "insayil">

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>A��klamalar :</B></FONT></TD>

		<TD WIDTH = "300"><TEXTAREA NAME = "aciklamalar" ROWS = "4" COLS = "35" MAXLENGTH = "300"></TEXTAREA>

		</TR>

		</TABLE>


		<BR>
	
		<INPUT TYPE = "Submit" VALUE = "Ekle" NAME = "Ekle"> &nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE = "Reset" VALUE = "Temizle" NAME = "Temizle">

		</FORM>

		</CENTER>

		<BR>

	</TD>

	</TR>

	</TABLE>

	</CENTER>

</BODY>

</HTML>
