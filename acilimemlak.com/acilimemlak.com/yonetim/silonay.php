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

	<TITLE>Script-tr.Org Katkýlarýyla /Açýlým Emlak - Gayrimenkul Kaydý Silme</TITLE>

</HEAD>

<BODY BACKGROUND = "../backgrounds/marble.gif">

	<CENTER>

	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "50" VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<FONT FACE = "Times New Roman" SIZE = "+1" COLOR = "DarkRed"><CENTER><B><U>GAYRÝMENKUL KAYDI SÝLME ONAYI</U></B></CENTER></FONT>

	</TD>

	</TR>

	</TABLE>


	<BR>


	<TABLE WIDTH = "550" BORDER = "2" BORDERCOLOR = "DarkRed" CELLSPACING = "0" CELLPADDING = "0">

	<TR VALIGN = "Center">

	<TD BGCOLOR = "#FFFFFF">

		<CENTER>

		<BR><BR>

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

		<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

		<B><? echo(mysql_result($sonuc, 0, "id")) ?></B> numaralý kaydý silmek istediðinize emin misiniz ?

		<BR><BR><BR>


		<TABLE WIDTH = "550" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">

		<TR HEIGHT = "40" VALIGN = "Center">

			<TD WIDTH = "200"></TD>

			<TD WIDTH = "60">

				<CENTER>

				<FORM ACTION = "sil.php" METHOD = "Post" NAME = "Sil">

				<INPUT TYPE = "Hidden" NAME = "id" <? echo("VALUE = \"" .mysql_result($sonuc, 0, "id") ."\">"); ?>

				<INPUT TYPE = "Submit" VALUE = "Evet" NAME = "Yes">

				</FORM>

				</CENTER>

			</TD>

			<TD WIDTH = "30"></TD>

			<TD WIDTH = "60">

				<CENTER>

				<FORM ACTION = "listele.php" METHOD = "Post" NAME = "Sil">

				<INPUT TYPE = "Submit" VALUE = "Hayýr" NAME = "No">

				</FORM>

				</CENTER>

			</TD>

			<TD WIDTH = "200"></TD>

		</TR>

		</TABLE>


		</FORM>

		</CENTER>

		<BR>

	</TD>

	</TR>

	</TABLE>

	</CENTER>

</BODY>

</HTML>
