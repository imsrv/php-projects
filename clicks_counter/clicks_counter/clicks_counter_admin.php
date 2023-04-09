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

$LOGIN = "ftls";
$PASSWORD = "demo";
	// En: Private Login / password
	// Fr: Login / mot de passe

// End  Necessary Variables section
/******************************************************************************/


function error ($error_message) {
	echo $error_message."<BR>";
	exit;
}
if ( (!isset($PHP_AUTH_USER)) || ! (($PHP_AUTH_USER == $LOGIN) && ( $PHP_AUTH_PW == "$PASSWORD" )) ) {
	header("WWW-Authenticate: Basic entrer=\"Form2txt admin\"");
	header("HTTP/1.0 401 Unauthorized");
	error("Unauthorized access...");
}
?> 

<HTML><HEAD><TITLE>PHP Clicks Counter</TITLE></HEAD>
<BODY BGCOLOR="white">
<BR><BR><P ALIGN="Center"><FONT FACE="Arial, helvetica" SIZE="+2" COLOR="#336699"><STRONG><EM>PHP Clic Counter</EM></STRONG></FONT></P><BR>

<?php

if (! file_exists($COUNT_FILE))
	error("Can't find file, check '\$COUNT_FILE' var...");

$file_arry = file($COUNT_FILE) or error("Can not open \$COUNT_FILE");

echo "<TABLE Border=\"1\" WIDTH=\"50%\" ALIGN=\"CENTER\"><TR><TH>URL</TH><TH>Clics</TH></TR>";

while (list($key, $val) = each($file_arry)) {
	if ($val != "") {
		list($file_url, $nb) = preg_split("/\t|\n/", $val);
		echo "<TR><TD><A HREF=\"$file_url\">$file_url</A></TD><TH>$nb</TH></TR>";
	}
}
echo "</TABLE>";
?>

<CENTER><BR><BR>
	<FONT FACE="Arial" SIZE=-2>
	<EM>&copy Copyright 2000 <A HREF="http://www.ftls.org/">FTLS</A> (Tyndiuk Fr&eacute;d&eacute;ric). All rights reserved.
	<BR>FTLS's PHP Scripts Archive : <A HREF="http://www.ftls.org/php/">http://www.ftls.org/php/</A></EM></FONT>
</CENTER></BODY></HTML>


