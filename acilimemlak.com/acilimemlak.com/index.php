<?php
/*
  Script-tr.Org
  -----------------------
  Türkiye'nin en büyük script sitesi
  http://www.script-tr.org
*/ 
?>
<?

<HTML>

<HEAD>

	<TITLE>Script-tr.Org Katkılarıyla /  Açılım Emlak</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-9">
</HEAD>

<BODY BACKGROUND = "backgrounds/marble.gif" TEXT = "#000000" LINK = "#000000" VLINK = "#000000">

	<BR>

	<CENTER>

	<TABLE WIDTH = "804" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">

	<TR HEIGHT = "1320" VALIGN = "Center">

	<TD WIDTH = "804" BGCOLOR = "#888888">

		<CENTER>

		<TABLE WIDTH = "800" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">

		<TR HEIGHT = "102" VALIGN = "Top">

		<TD COLSPAN = "2" BGCOLOR = "#888888">

			<CENTER><IMG SRC = "images/sadebanner.jpg"></CENTER>

		</TD>

		</TR>


		<TR HEIGHT = "30" VALIGN = "Center">

		<TD COLSPAN = "2" BGCOLOR = "#888888">

			<TABLE WIDTH = "800" BORDER = "0" CELLSPACING = "0" CELLPADDING = "0">

				<TR HEIGHT = "30" VALIGN = "Center">

				<TD WIDTH = "500" BGCOLOR = "#CCCCCC">

					<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">&nbsp;&nbsp;&nbsp;<A HREF = "mainright.php" TARGET = "mainright"><B>Ana Sayfa</B></A> :: <A HREF = "arama.php" TARGET = "mainright"><B>Arama</B></A></FONT></CENTER>

				</TD>


				<TD WIDTH = "280" BGCOLOR = "#CCCCCC" STYLE = "Text-Align: Right">

					<FONT FACE = "Verdana" SIZE = "-2" COLOR = "#000000">

					<?

						$today = getDate();

						$month = "";

						$day = "";


						if($today["mon"] == 1)
						{
							$month = "Ocak";
						}

						if($today["mon"] == 2)
						{
							$month = "Şubat";
						}

						if($today["mon"] == 3)
						{
							$month = "Mart";
						}

						if($today["mon"] == 4)
						{
							$month = "Nisan";
						}

						if($today["mon"] == 5)
						{
							$month = "Mayıs";
						}

						if($today["mon"] == 6)
						{
							$month = "Haziran";
						}

						if($today["mon"] == 7)
						{
							$month = "Temmuz";
						}

						if($today["mon"] == 8)
						{
							$month = "Ağustos";
						}

						if($today["mon"] == 9)
						{
							$month = "Eylül";
						}

						if($today["mon"] == 10)
						{
							$month = "Ekim";
						}

						if($today["mon"] == 11)
						{
							$month = "Kasım";
						}

						if($today["mon"] == 12)
						{
							$month = "Aralık";
						}


						if($today["wday"] == 1)
						{
							$day = "Pazartesi";
						}

						if($today["wday"] == 2)
						{
							$day = "Salı";
						}

						if($today["wday"] == 3)
						{
							$day = "Çarşamba";
						}

						if($today["wday"] == 4)
						{
							$day = "Perşembe";
						}

						if($today["wday"] == 5)
						{
							$day = "Cuma";
						}

						if($today["wday"] == 6)
						{
							$day = "Cumartesi";
						}

						if($today["wday"] == 7)
						{
							$day = "Pazar";
						}


						echo($today["mday"] ." " .$month ." " . $today["year"] .", " .$day);
					?>

					</FONT></CENTER>

				</TD>


				<TD WIDTH = "20" BGCOLOR = "#CCCCCC"></TD>

			</TR>

			</TABLE>

		</TD>

		</TR>


		<TR HEIGHT = "1184">

		<TD WIDTH = "200" BGCOLOR = "#FFFFFF">

			<IFRAME NAME = "mainleft" SRC = "mainleft.php" FRAMEBORDER = "0" HEIGHT = "1184" WIDTH = "200" MARGINHEIGHT = "0" MARGINWIDTH = "0" SCROLLING = "No"></IFRAME>

		</TD>


		<TD WIDTH = "600" BGCOLOR = "#FFFFFF">

			<IFRAME NAME = "mainright" SRC = "mainright.php" FRAMEBORDER = "0" HEIGHT = "1184" WIDTH = "600" MARGINHEIGHT = "0" MARGINWIDTH = "0" SCROLLING = "No"></IFRAME>

		</TD>

		</TR>

		</TABLE>

		</CENTER>

	</TD>

	</TR>

	</TABLE>

	<BR>

	</CENTER>

</BODY>

</HTML>
