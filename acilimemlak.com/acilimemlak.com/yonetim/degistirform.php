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

	<TITLE>A��l�m Emlak - Gayrimenkul Bilgilerini G�ncelle</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif">

	<CENTER>

	<FORM ACTION = "degistir.php" METHOD = "Post" NAME = "Degistir">


	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "50" VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<FONT FACE = "Times New Roman" SIZE = "+1" COLOR = "DarkRed"><CENTER><B><U>GAYR�MENKUL B�LG� G�NCELLEME FORMU</U></B></CENTER></FONT>

	</TD>

	</TR>

	</TABLE>


	<BR>


	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<CENTER>

		<BR>

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

			$sonuc = mysql_query("SELECT * FROM `gayrimenkul` WHERE `id` = " .$HTTP_GET_VARS["id"], $baglanti);
		?>


		<TABLE WIDTH = "500" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">


		<TR HEIGHT = "60" VALIGN = "Center">

		<TD WIDTH = "500" COLSPAN = "2"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><FONT COLOR = "Red">*</FONT> i�areti doldurulmas� zorunlu alanlar� g�sterir.<BR><BR></FONT></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>�ehir <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" NAME = "sehir" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "sehir") ."\""); ?> ></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Semt <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" NAME = "semt" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "semt") ."\""); ?> ></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Adres :</B></FONT></TD>

		<TD WIDTH = "300"><TEXTAREA NAME = "adres" ROWS = "4" COLS = "35" MAXLENGTH = "300"><? echo(mysql_result($sonuc, 0, "adres")); ?></TEXTAREA>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�c� Ad� <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" NAME = "saticiadi" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "saticiadi") ."\""); ?> ></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�c� Telefon (Sabit) <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" NAME = "saticitelefonsabit" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "saticitelefonsabit") ."\""); ?> ></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�c� Telefon (Mobil) <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "25" MAXLENGTH = "20" NAME = "saticitelefonmobil" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "saticitelefonmobil") ."\""); ?> ></TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Sat�� T�r� <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "satis" SIZE = "1">

				<OPTION>Se�iniz...</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "satis") == "Kiral�k") { echo("SELECTED"); } ?> >Kiral�k</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "satis") == "Sat�l�k") { echo("SELECTED"); } ?> >Sat�l�k</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kategori <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "kategori" SIZE = "1">

				<OPTION>Se�iniz...</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "kategori") == "Daire") { echo("SELECTED"); } ?> >Daire</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "kategori") == "Ev") { echo("SELECTED"); } ?> >Ev</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "kategori") == "��yeri") { echo("SELECTED"); } ?> >��yeri</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "kategori") == "Yazl�k") { echo("SELECTED"); } ?> >Yazl�k</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "kategori") == "Arsa") { echo("SELECTED"); } ?> >Arsa</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "kategori") == "Depo") { echo("SELECTED"); } ?> >Depo</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Fiyat (YTL) <FONT COLOR = "Red">*</FONT> :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "10" NAME = "fiyat" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "fiyat") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Alan (Metrekare) :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "10" NAME = "alan" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "alan") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Oda :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "5" NAME = "oda" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "oda") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Salon :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "5" NAME = "salon" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "salon") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Banyo :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "5" NAME = "banyo" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "banyo") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Is�nma :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "15" NAME = "isinma" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "isinma") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Kat :</B></FONT></TD>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "10" MAXLENGTH = "15" NAME = "kat" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "kat") ."\""); ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Asans�r :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "asansor" SIZE = "1">

				<OPTION <? if(mysql_result($sonuc, 0, "asansor") == "") { echo("SELECTED"); } ?> >-</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "asansor") == "Var") { echo("SELECTED"); } ?> >Var</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "asansor") == "Yok") { echo("SELECTED"); } ?> >Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Balkon :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "balkon" SIZE = "1">

				<OPTION <? if(mysql_result($sonuc, 0, "balkon") == "") { echo("SELECTED"); } ?> >-</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "balkon") == "Var") { echo("SELECTED"); } ?> >Var</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "balkon") == "Yok") { echo("SELECTED"); } ?> >Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Bah�e :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "bahce" SIZE = "1">

				<OPTION <? if(mysql_result($sonuc, 0, "bahce") == "") { echo("SELECTED"); } ?> >-</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "bahce") == "Var") { echo("SELECTED"); } ?> >Var</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "bahce") == "Yok") { echo("SELECTED"); } ?> >Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Do�algaz :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "dogalgaz" SIZE = "1">

				<OPTION <? if(mysql_result($sonuc, 0, "dogalgaz") == "") { echo("SELECTED"); } ?> >-</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "dogalgaz") == "Var") { echo("SELECTED"); } ?> >Var</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "dogalgaz") == "Yok") { echo("SELECTED"); } ?> >Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Otopark :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "otopark" SIZE = "1">

				<OPTION <? if(mysql_result($sonuc, 0, "otopark") == "") { echo("SELECTED"); } ?> >-</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "otopark") == "Yok") { echo("SELECTED"); } ?> >Yok</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "otopark") == "Otopark") { echo("SELECTED"); } ?> >Otopark</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "otopark") == "Kapal� Garaj") { echo("SELECTED"); } ?> >Kapal� Garaj</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "otopark") == "Otopark Ve Kapal� Garaj") { echo("SELECTED"); } ?> >Otopark Ve Kapal� Garaj</OPTION

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>Mobilya :</B></FONT></TD>

		<TD WIDTH = "300">

			<SELECT NAME = "mobilya" SIZE = "1">

				<OPTION <? if(mysql_result($sonuc, 0, "mobilya") == "") { echo("SELECTED"); } ?> >-</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "mobilya") == "Var") { echo("SELECTED"); } ?> >Var</OPTION>
				<OPTION <? if(mysql_result($sonuc, 0, "mobilya") == "Yok") { echo("SELECTED"); } ?> >Yok</OPTION>

			</SELECT>

		</TD>

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>�n�a Tarihi (G�n / Ay / Y�l) :</B></FONT></TD>

		<?
			$tarih = mysql_result($sonuc, 0, "insatarihi");

			$gun = $tarih[8] .$tarih[9];
			$ay = $tarih[5] .$tarih[6];
			$yil = $tarih[0] .$tarih[1] .$tarih[2] .$tarih[3];
		?>

		<TD WIDTH = "300"><INPUT TYPE = "Text" SIZE = "2" MAXLENGTH = "2" NAME = "insagun" <? if($gun != "00") { echo("VALUE = \"" .$gun ."\""); } ?> >&nbsp;<INPUT TYPE = "Text" SIZE = "2" MAXLENGTH = "2" NAME = "insaay" <? if($ay != "00") { echo("VALUE = \"" .$ay ."\""); } ?> >&nbsp;<INPUT TYPE = "Text" SIZE = "4" MAXLENGTH = "4" NAME = "insayil" <? if($yil != "00") { echo("VALUE = \"" .$yil ."\""); } ?> >

		</TR>


		<TR HEIGHT = "25" VALIGN = "Center">

		<TD WIDTH = "200"><FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000"><B>A��klamalar :</B></FONT></TD>

		<TD WIDTH = "300"><TEXTAREA NAME = "aciklamalar" ROWS = "4" COLS = "35" MAXLENGTH = "300"><? echo(mysql_result($sonuc, 0, "aciklamalar")); ?></TEXTAREA>

		</TR>

		</TABLE>


		<BR>

		<INPUT TYPE = "Hidden" NAME = "id" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "id") ."\">"); ?>

		<INPUT TYPE = "Submit" VALUE = "De�i�iklikleri Kaydet" NAME = "Degistir"> &nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE = "Reset" VALUE = "De�i�iklikleri Geri Al" NAME = "Temizle">

		</FORM>

		</CENTER>

		<BR>

	</TD>

	</TR>

	</TABLE>

	</CENTER>

</BODY>

</HTML>
