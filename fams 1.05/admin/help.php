<?php

/* ------------------------------------------------------------ */
/*								*/
/*	File Area Management System (FAMS)			*/
/*								*/
/*	Copyright (c) 2001 by Bastian 'Buddy' Grimm		*/
/*	Autor: Bastian Grimm					*/
/*	Publisher: [ BG-Studios ]				*/
/*	eMail: bastian@bg-studios.de				*/
/*	WebSite: http://www.bg-studios.de			*/
/*	Date: 06.05.01		Version: FAQs 1.02		*/
/*	Ge�ndert am: 25.07.01					*/
/*								*/
/* ------------------------------------------------------------	*/

require("../config.php");

require("./lang.php");

if(!$nick)
{
include("layout_top_e.php");
echo $loginfailed;
include("layout_down_e.php");
exit;
}
else
{
	if(!$passwort)
	{
	include("layout_top_e.php");
	echo $loginfailed;
	include("layout_down_e.php");
	exit;
	}
	else
	{

	$logon = mysql_query("SELECT * FROM dl_users WHERE (user_name = '$nick') && (user_pwd = '$passwort')");
	$loggedon=mysql_fetch_array($logon);	
	if (!$loggedon)
	{
	include("layout_top_e.php");
	echo $loginfailed;
	include("layout_down_e.php");
	exit;		
	}
	else
	{



$pagetyp = "admin";

include("./layout_top.php");

?>

Im weiteren finden Sie eine �bersicht, die Ihnen einen Gesamteindruck �ber das FAMS vermitteln und die Ihnen bei Fragen und Problemen
als erste Anlaufstelle dienen soll.
<P>

<UL TYPE=disc>
<LI><A HREF="#docs">Dateien und Kategorien verwalten / Lizenz</A><BR>
<LI><A HREF="#cats1">Was sind Kategorien?</A><BR>
<LI><A HREF="#cats2">Warum werden Kategorien ben�tigt?</A><BR>
<LI><A HREF="#delcats">Information - Kategorien l�schen</A><BR>
<LI><A HREF="#addfile">Information - Dateien hinzuf�gen</A><BR>
<LI><A HREF="#addfile">Information - Dateien bearbeiten</A><BR>
<LI><A HREF="#moreusers">Mehrere User einrichten?</A><BR>
<LI><A HREF="#screens">Mehrere Screenshots pro Download?</A><BR>
<LI><A HREF="#kommentare">Kommentare zu Download-Files</A><BR>
<LI><A HREF="#wertung">Download-Files bewerten</A><BR>
<LI><A HREF="#contact">Der direkte Kontakt zu uns</A><BR>
</UL>
<P><BR>


<A NAME="docs"></A>
<B>Dateien und Kategorien verwalten</B><BR><DIV ALIGN=justify>
F�r eine �bersicht, wie man Datei und Kategorien korrekt verwaltet, lesen Sie bitte die beigef�gte Datei "README.txt", die im Hauptverzeichnis zu finden ist.
<P>
Dort finden Sie auch die Nutzungsbedingungen f�r diese Programm!
</DIV><P><BR>

<A NAME="cats1"></A>
<B>Was sind Kategorien?</B><BR><DIV ALIGN=justify>
�ber die Kategorien erfolgt ein wesentlicher Teil der Steuerung des Systemes. Man kann diese �ber das linke Men� verwalten. Dort gibt es die
M�glichkeit, vorhandene Kategorien zu �ndern, zu l�schen oder auch, neue Kategorien hinzuzuf�gen.
</DIV><P><BR>

<A NAME="cats2"></A>
<B>Warum werden Kategorien ben�tigt?</B><BR><DIV ALIGN=justify>
Es wird mindestens 1 Kategorie vom System ben�tigt, um die Ausgabe des Datenbank zu steuern. Gedacht ist es, dass man mehrere Kategorien anlegen kann und jedem Download eine entsprechende 
Kategorie zuweisen kann. Im Endeffekt hat das zur Folge, dass man bei bestimmten Kategorien bestimmte Files angezeigt bekommt, was dem Benutzer einen hohen Anteil von �bersicht schafft
und eine wesentlich einfachere Navigation innerhalb des Downloadbereiches erm�glicht.
</DIV><P><BR>

<A NAME="delcats"></A>
<B>Information - Kategorien l�schen</B><BR><DIV ALIGN=justify>
Wenn Sie eine Kategorie aus dem System entfernt haben und diese Kategorie Downloads hatte, die ihr zugeordnet waren, so sind diese Dateien nat�rlich nicht mit gel�scht worden!<BR>
Sie m�ssen nur jedem File der gel�schten Kategorie eine neue zuweisen, da es sonst nicht mehr angezeigt wird.
</DIV><P><BR>

<A NAME="addfile"></A>
<B>Information - Dateien hinzuf�gen</B><BR><DIV ALIGN=justify>
Um ein File korrekt zum Download anbieten zu k�nnen, sind eigentlich nur wenige wichtige Punkte zu beachten. Zum einen m�ssen auf jeden Fall m�ssen folgende Pflichtfelder
ausgef�llt werden: File URL, File Name und es muss dem File eine Kategorie zugewiesen werden. Bei kleinen Download-Systemen reicht es, wenn man am Anfang eine Kategorie einrichtet
und allen Files die selbe Kategorie zuweist. <BR>
Dennoch ist es sicherlich wichtig, dem Benutzer eine schnelle Navigation zu erm�glichen und somit sinnvolle Kategorie Einteilungen vorzunehmen.
</DIV><P><BR>

<A NAME="editfile"></A>
<B>Information - Dateien bearbeiten</B><BR><DIV ALIGN=justify>
Wenn Sie einen Datenbank Eintrag bearbeiten, ist wieder unbedingt darauf zu achten, dass dem File eine g�lte URL sowie ein Name zugewiesen bleibt. Sollte es erforderlich sein,
kann auch die File-Kategorie ge�ndert werden. Dort einfach entsprechend im Dropdown die gew�nschte Kategorie ausw�hlen.
</DIV><P><BR>

<A NAME="moreusers"></A>
<B>Mehrere User einrichten?</B><BR><DIV ALIGN=justify>
Ab Version 1.05 ist es endlich m�glich, mehreren User mit unterschiedlichen User-Namen und Passw�rtern einzurichten. Diese M�glichkeit hat nur der Administrator. Im folgenden ein �bersicht der Benutzerrechte:
<P>
<B>Userlevel 1:</B> Der Benutzer kann Files hinzuf�gen und editieren.
<P>
<B>Userlevel 2:</B> Der Benutzer kann Files hinzuf�gen, editieren und l�schen. Weiterhin kann er das Kommentar System verwalten und dort
entsprechend editieren oder l�schen.
<P>
<B>Userlevel 3:</B> Der Administrator hat Zugriff auf alle Einstellungen. Er kann neue User und Kategorien einrichten, editieren und l�schen sowie alle anderen Funktionen
des System nutzen.
</DIV><P><BR>

<A NAME="screens"></A>
<B>Mehrere Screenshots pro File?</B><BR><DIV ALIGN=justify>
Ab Version 1.05 ist es m�glich, bis zu 5 Screenshots pro File zu verwalten. Jedes File hat einen eigenen Hitcounter, der sichtbar wird, sobald man bei dem File auf den ensprechenden Link klickt. Dann
�ffnet sich ein Fester in der Gr��e des Bildes und darunter ist der Counter sichtbar. 
</DIV><P><BR>

<A NAME="kommentare"></A>
<B>Kommentar System</B><BR><DIV ALIGN=justify>
Ab Version 1.05 ist es m�glich, jedes File, dass zum Download angeboten wird, zu kommentieren. Dazu klickt man einfach unter dem Download File (dort ist die Anzahl der vorhandenen Kommentare sichtbar) auf "Kommentare".
<BR>Dieses Kommentarsystem kann von Benutzern ab Level 2 verwaltet werden, d.h. es k�nnen Kommentare editiert oder gel�scht werden. 
</DIV><P><BR>

<A NAME="wertung"></A>
<B>Download Files bewerten</B><BR><DIV ALIGN=justify>
Weiterhin ist es ab Version 1.05 ist es m�glich, jedes File, zu bewerten. Dabei gibt es eine Skala von 1 bis 10 und das System errechnet ja nach Anzahl der Stimmen den Durchschnittswert.
</DIV><P><BR>

<A NAME="contact"></A>
<B>Der direkte Kontakt zu uns</B><BR><DIV ALIGN=justify>
Sollten hiermit Ihre Fragen nicht beantwortet sein, so k�nnen sie uns gerne kontaktieren. Schreiben Sie dazu einfach an <A HREF=mailto:info@bg-studios.de>info@bg-studios.de</A>
und wir werden uns umgehend mit Ihnen in Verbindung setzten.
</DIV><P><BR>

<?php

include("./layout_down.php");

}
}
}

?>
