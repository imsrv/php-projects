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
/*	Date: 03.05.01		Version: Add File 1.14		*/
/*	Ge�ndert am: 25.07.01					*/
/*								*/
/* ------------------------------------------------------------	*/

require("../config.php");
require("./show_cats.php");
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


if($sec) {
   switch($sec) {

    case 'add_check':
	
include("./layout_top.php");

if ($file_url == '')
	{
	Echo "<B>Fehler!</B><BR> Sie m�ssen die Adresse zu dem gew�nschten File eingeben!<P>";
	Echo "[ <A HREF=javascript:history.back()>Zur�ck</A> ]";
	exit;
	} 
if ($file_name == '')
	{
	Echo "<B>Fehler!</B><BR> Sie m�ssen deinen Dateinamen eingeben!<P>";
	Echo "[ <A HREF=javascript:history.back()>Zur�ck</A> ]";
	exit;
	} 
if ($cat == -1)
	{
	Echo "<B>Fehler!</B><BR> Sie m�ssen eine Kategorie ausw�hlen, dem das File zugeordnet werden soll!<P>";
	Echo "[ <A HREF=javascript:history.back()>Zur�ck</A> ]";
	exit;
	} 

$result = mysql_query("SELECT * FROM dl_files");
while ($db=mysql_fetch_array($result))
{
	$new_file = "".$db['file_name']."";
	if ($file_name == $new_file)
	{
	Echo "<B>Fehler!</B><BR> Eine Datei mit diesem Namen ist bereits in der Datenbank vorhanden! Bitte w�hlen Sie einen anderen Namen.<P>";
	Echo "[ <A HREF=javascript:history.back()>Zur�ck</A> ]";
	exit;
	}
}

$date_added = date( "d.m.Y" );
$hits = "0";

$upfiles = mysql_query("INSERT INTO dl_files (file_url, mirror, file_name, file_description, file_size, autor, autor_contact, cat, hits, date_added, image1, image2, image3, image4, image5) VALUES ('$file_url', '$mirror', '$file_name', '$file_description', '$file_size', '$autor', '$autor_contact', '$cat', '$hits', '$date_added', '$image1', '$image2', '$image3', '$image4', '$image5')");

echo "Das File wurde erfolgreich in die Datenbank eingef�gt...";

include("./layout_down.php");
	
	exit;
	break;
	}
}

include("./layout_top.php");


$result = mysql_query("SELECT EID, cat_names FROM dl_categories ORDER BY EID");
	
	$cats = mysql_fetch_array($result);
		
	if (!$cats)
	{
	Echo "<B>Fehler!</B><BR> Es sind keine Kategorien vorhanden! Um ein File zum Downloaden anbieten zu k�nnen, m�ssen Sie mindestens eine Kategorie einrichten!<P>";
	Echo "[ <A HREF=javascript:history.back()>Zur�ck</A> ]";
	}
	else
{


?>

Bitte geben Sie die ben�tigten Informationen ein, um das File in die Datenbank einzuf�gen.
<P>


<FORM METHOD="POST" ACTION="<?php echo $PHP_SELF ?>">

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
<TR>
<TD WIDTH=110 CLASS=file>
File URL:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=file_url SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Mirror URL:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=mirror SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Screenshot 1:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=image1 SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Screenshot 2:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=image2 SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Screenshot 3:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=image3 SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Screenshot 4:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=image4 SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Screenshot 5:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=image5 SIZE=40>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
File Name:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=file_name SIZE=20>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Autor:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=autor SIZE=20>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Autor eMail/URL:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=autor_contact SIZE=20>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
File Gr��e:
</TD>
<TD CLASS=file>
<INPUT TYPE=text NAME=file_size SIZE=10>
</TD>
</TR>
<TR>
<TD WIDTH=110 CLASS=file>
Kategorie:
</TD>
<TD CLASS=file>
<?php

cat_dropdown();

?>
</TD>
</TR>
<TR>
<TD WIDTH=110 VALIGN=top CLASS=file>
<BR>
Beschreibung:
</TD>
<TD CLASS=file>
<TEXTAREA NAME=file_description ROWS=7 COLS=30>
</TEXTAREA>
</TD>
</TR>
<TR>
<TD WIDTH=110 VALIGN=top CLASS=file>
</TD>
<TD CLASS=file>
<BR>


<INPUT TYPE=hidden NAME=sec VALUE="add_check">
<INPUT TYPE="submit" VALUE="Eintrag speichern">

</TD>
</TR>
</TABLE>
</FORM>



<?php

}

include("./layout_down.php");

}
}
}

?>