<?php
#$Id: swedish_xcode.inc.php,v 1.3 2003/10/20 14:59:48 ryan Exp $
$xTitle[] = "Vad �r XCode?";
$bodyText[] = "XCode �r en variation av HTML-taggar som du kanske redan �r bekant med. Kort sagt ger det dig m�jlighet att l�gga till funktioner eller stil p� din text som normalt skulle kr�va HTML. Du kan anv�nda XCode �ven om HTML �r avst�ngt i forumen. Du kan ocks� anv�nda XCode �ven om HTML �r till�tet, eftersom det kr�vs mindre kodning f�r det, och du kommer aldrig f�rst�ra layouten p� sidorna du tittar p�.";

$xTitle[] = "Webadresser och e-postl�nkar";
$bodyText[] = "Xcode, unlike some other bulletin board codes, does not require you to specify links (URL) and email links.  However, you can specify URL's if you wish. <br><br>To create a link, just enter the URL, with either ftp://, telnet://, http:// or https:// before the link and PHPX will automatically turn it into a link.  Email does the same, just put in the email address and when you save your post, PHPX will create an email link.<br><br>If you wish to specify a URL link, or create a link on text or image you may use the <font color=red>[url=][/url]</font> tags.<br><br>Linking an Image:<br><font color=red>[url=http://www.phpx.org/][img=http://www.phpx.org/images/someimage.jpg][/url]</font> will create a link to www.phpx.org using the image specified.";


$xTitle[] = "Fet, understruken och kursiv stil";
$bodyText[] = "F�r att skapa kursiv, fet eller understruken text omringa den del av texten du vill formatera med [b] [/b] f�r fetstil, [u] [/u] f�r understruken eller [i] [/i] f�r kursiv stil.<br><br><font color=red>[b]</FONT>fet text</Font color=red>[/b]</font blir <b>fet text</B> och s� vidare. Du kan ocks� kombinera de olika alternativen med varandra: <font color=red>[b][u][i]</font>Fet understruken kursiv text<font color=red>[/B][/U][/I]</font> blir <b><u><i>Fet understruken kursiv text</B></I></U>";

$xTitle[] = "Textposition";
$bodyText[] = "Text kan positioneras hur du vill med hj�lp av ett flertal taggar: [left], [right], [center] och [block].<br><br>V�nsterst�lld text:<br><font color=red>[left]</font>V�nsterst�lld text<font color=red>[/left]</font> blir <div align=left>V�nsterst�lld text</div><br><br>H�gerst�lld text:<br><font color=red>[right]</font>H�gerst�lld text<font color=red>[/right]</font> blir <div align=right>H�gerst�lld text</div><br><br>Centrerad text:<br><font color=red>[center]</font>Centerad text<font color=red>[/center]</font> blir <div align=center>Centrerad text</div><br><br>Likst�lld text:<br><font color=red>[block]</font>Likst�lld text<font color=red>[/block]</font> blir <blockquote>Likst�lld text</blockquote><br><br>";

$xTitle[] = "Annan textformatering";
$bodyText[] = "Det finns tre andra attribut som �ndras med XCode: Textstorlek, teckensnitt och f�rg<br><br>Textstorlek:<br>Textstorlek kan st�llas allt mellan 1 (ol�slig och 24 (j�ttestor).<br><font color=red>[size=18]</font>stor text<font color=red>[/size]</font> blir <span style=font-size:18px>Stor text</span><br><br>Typsnitt (font):<br>Du kan anv�nda flera olika typsnitt i din text med hj�lp av Xcode. Dessa kan dock bara vara standardtypsnitt!<br><font color=red>[font=times]</font>Times New Roman<font color=red>[/font]</font> blir <span style=font-family:times>Times New Roman</span><br><br>Textf�rg:<br>Text kan ocks� s�ttat till valfri f�rg. Du kan anv�nda b�de f�rgens engelska namn och hexkod.<br><font color=red>[color=blue]</font>Bl� text<font color=red>[/color]</font> blir <font color=blue>bl� text</font>.<br><font color=red>[color=#0000FF]</font>bl� text<font color=red>[/color]</font> blir <span style=color:#0000FF>bl� text</span>";

$xTitle[] = "Linjer";
$bodyText[] = "F�r att s�tta in en linje i din text anv�nder du [line]-taggen.<br><br><font color=red>[line]</font> blir <hr width=100% border=2>";

$xTitle[] = "Listor";
$bodyText[] = "Du kan skapa punktlistor eller listor i bokstavs eller sifferordning<br><br>Oordnad punktlista:<b><font color=red>[list]</Font><br><font color=red>[*]</font>Punkt 1<br><font color=red>[*]</font>Punkt 2<br><font color=red>[/list]</font><br>Ger: <ul><li>Punkt 1</LI><LI>Punkt 2</LI></UL><br>Observera att du m�ste avsluta med en [/list] f�r att din lista ska fungera!<br><br>Det �r precis lika enkelt att anv�nda ornade listor. L�gg bara till [list A], [list a], [list 1], [list I] eller [list i]. A skapar en alfabetisk lista med kapil�rer fr�n A-Z. a skapar en lista fr�n a-z med gementer. 1 skapar en numerisk lista, I skapar en lista med romerska siffror i kapil�rer och i skapar en lista med romerska siffror i gemener. H�r �r ett exempel:<br><font color=red>[list A]</font><br><font color=red>[*]</font>Punkt 1<br><font color=red>[*]</font>Punkt 2<br><font color=red>[/list]</font><br>Resulatet blir:<ol type=A><li>Punkt 1</li><li>Punkt 2</LI>";

$xTitle[] = "Bilder";
$bodyText[] = "F�r att l�gga in grafik i bilder anv�nder du en webl�nk och omringar den som visas i exemplet:<br><br><font color=red>[img]</font>http://www.yoururl.com/images/hot.jpg<font color=red>[/img]</font><br>I exemplet ovan g�r XCode automatiskt om koden till den bild som finns p� bildl�nken. OBS! \"http://\"-delen av l�nken M�STE vara med f�r att [img]-taggen ska fungera. Notera ocks� att vissa forumadmininistrat�rer st�nger av denna funktion f�r att hindra ol�mpliga bilder fr�n att visas!";

$xTitle[] = "Citera (quotea) andra meddelanden;
$bodyText[] = "F�r att referera n�got speciellt som n�gon har postat, kopiera bara texten och klistra in den enligt exemplet nedan:<br><br><font color=red>[quote]</font>Detta �r ett citat.<font color=red>[/quote]</font> blir: <blockquote><div class=small><i>quote:</i><hr width=100% align=center>Detta �r ett citat.<hr width=100% align==center></blockquote></div>";

$xTitle[] = "Posta kod";
$bodyText[] = "Fungerar ungef�r som [quote]-taggen, och �r bra f�r att visa programkod eller HTML till exempel.<br><br><font color=red>[code]</font>#!/usr/bin/perl<br><br>print \"Content-type: text/html\n\n\";<br>print \"Hello World!\"; <font color=red>[/code]</font> blir <font color=green><blockquote>#!/usr/bin/perl<br><br>print \"Content-type: text/html\n\n\";<br>print \"Hello World!\"; </blockquote></font>";

$xTitle[] = "�vrigt";
$bodyText[] = "Xcode kan bli �ndrad f�r att passa det speciella forumets behov d�rf�r kanske en del funktioner inte fungerar som de �r beskrivna h�r, efterom forumadministrat�ren kan ha �ndrat dem.";





