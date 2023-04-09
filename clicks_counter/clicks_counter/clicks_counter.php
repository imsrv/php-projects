<?php
// En: Begin PHP Code / Fr: Debut code PHP
/******************************************************************************\
* PHP Clicks Counter                           Version 1.0                     *
* Copyright 2000 Frederic TYNDIUK (FTLS)       All Rights Reserved.            *
* E-Mail: tyndiuk@ftls.org                     Script License: GPL             *
* Created  02/28/2000                          Last Modified 02/28/2000        *
* Scripts Archive at:                          http://www.ftls.org/php/        *
*******************************************************************************/
// Necessary Variables:

$COUNT_FILE = "clicks_counter_data.txt";
	// En: Absolute path and name to count data file.
	// Fr: Chemin absolu (complet) et Nom du fichier compteur.

// End  Necessary Variables section
/******************************************************************************/

function error ($error_message) {
	echo $error_message."<BR>";
	exit;
}

$url = urldecode($QUERY_STRING);

if (! file_exists($COUNT_FILE))
	error("Can't find file, check '\$COUNT_FILE' var...");

if ((! $url) || (! preg_match("/http:/", $url))) error ("Invalid url, you chould add url ex: <A HREF=\"http://$SERVER_NAME$PHP_SELF?http://www.ftls.org/\">http://$SERVER_NAME$PHP_SELF?http://www.ftls.org/</A>");

$file_arry = file($COUNT_FILE); //or error("Can not open \$COUNT_FILE");
        
while (list($key, $val) = each($file_arry)) {
	if ($val != "") {
		list($file_url, $nb) = preg_split("/\t|\n/", $val);
		if ($file_url == $url) { 
			$nb++; $file_arry[$key] = "$file_url\t$nb\n"; $find = 1;
		}
	}
}

$file = join ("", $file_arry);
if (! $find) $file .= "$url\t1\n";

$fp = fopen("$COUNT_FILE", "w"); //or error("Can not open \$COUNT_FILE");
flock($fp, 1);
fputs($fp, $file);                                                     
flock($fp, 3);
fclose($fp);
header("Location: $url");

?>