<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >
include("config.php");
$idlink = $_GET["idlink"];
$lang = $_GET["lang"];
$row = getPageTranslated($lang, $idlink);
$html = $row["source"];
echo $html;
?>
