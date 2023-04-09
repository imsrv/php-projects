<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Mirko Giese                                    **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */
include "defaults_inc.php"

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//AdvaSoft//DTD HTML 3.2 extended 961018//EN">

<HTML>
<HEAD>
 <TITLE>Gaestebuch warten</TITLE>
</HEAD>

<BODY>
<?
/*------hier kann das Password geaendert werden------------*/;
$password="war!ung";

/*	securevar("name");
	securevar("vorname");
	securevar("email");
	securevar("homepage");
	securevar("kommentar");
*/	
	$result=mysql_query("select NAME, VORNAME, NUMMER from chat_forum",$db_handle);
	$treffer=mysql_num_rows($result);
	
?>
Liste aller Eintragungen:<BR>



<TABLE CELLPADDING="10"><TR><TD>
<? 
	$i=0;
	while($i<$treffer):
	echo "<a href=\"wartung.php?ping="; echo mysql_result($result,$i,"NUMMER");echo "\">";
	if($ping==(mysql_result($result,$i,"NUMMER"))): 
		echo "<strong>"; 
		echo "<FONT SIZE=\"+1\" COLOR=\"red\">";
	endif;
	echo "$i) ";
	echo mysql_result($result,$i,"VORNAME");
	echo " ";
	echo mysql_result($result,$i,"NAME");
	echo "</font>";
	echo "</strong>";
	echo "</a>";
	echo "<BR>";
	
	if($ping==(mysql_result($result,$i,"NUMMER"))):
		echo "</font>" ;echo "</strong>"; echo "</a>";
	endif;
		$i++;
	endwhile;
	if ($control=="1"):

		if ($pw=="$password" && $del!="1"):
			$result_=mysql_query("update chat_forum set VORNAME='$vorname',NAME='$name', EMAIL='$email', HOMEPAGE='$homepage', KOMMENTAR='$kommentar' where NUMMER=$ping",$db_handle);
			echo "<b>Eintrag akualisiert</b>";
		elseif ($pw=="$password" && $del=="1"):
			$mmhh=mysql_query("delete from chat_forum where NUMMER=$ping",$db_handle);
			echo "Eintrag geloescht...";
		else:	
			echo "<b>falsches Kennwort, bitte noch einmal eintragen</b>";
		endif;
	elseif (isset($control)):
		echo "<b>Bitte ein Kennwort eingeben</b>";
	endif;
	if (isset($ping)):
		echo "<TD BGCOLOR=\"#CC9377\">";
		$ausgabe=mysql_query("select * from chat_forum where Nummer='$ping'",$db_handle);
		echo "<FORM METHOD=POST>";
		echo "<b>Datum des Eintrag: </b>"; echo  mysql_result($ausgabe,0,"DATE");echo "<BR>";
		echo "<b>Vorname: </b>"; echo  "<input name=\"vorname\" value=\"";echo mysql_result($ausgabe,0,"VORNAME");echo "\">";echo "<BR>";
		echo "<b>Nachname: </b>";echo  "<input name=\"name\" value=\""; echo mysql_result($ausgabe,0,"NAME");echo "\">";echo "<BR>";
		echo "<B>EMAIL: </b>";echo  "<input name=\"email\" size=\"30\" value=\""; echo mysql_result($ausgabe,0,"EMAIL"); echo "\">"; echo "<BR>";
		echo "<b>Homepage:</b> ";echo  "<input name=\"homepage\" size=\"30\" value=\""; echo mysql_result($ausgabe,0,"HOMEPAGE"); echo "\">";echo "<BR>";
		echo "<B>Kommentar: </b>";echo  "<textarea name=\"kommentar\" COLS=50 ROWS=10 wrap=virtual >"; echo mysql_result($ausgabe,0,"KOMMENTAR");echo "</textarea><BR>";
		echo "Wartungskennwort: <input type=password name=\"pw\"> ";
		echo "<input type=hidden name=\"control\" value=\"1\">";
		echo "<input type=hidden name=\"ping\" value=$ping";
                echo "<input type=checkbox name=\"del\" value=\"1\">zum Loeschen des Eintrags hier aktivieren";
		echo " <input type=submit value=\"Eintrag absenden\">";
		echo "</form>";
	endif;	
	
			
?>
</tr>
</TABLE>
</BODY>
</HTML>
