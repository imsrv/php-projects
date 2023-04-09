<?
$mtime1 = explode(" ", microtime());
$starttime = $mtime1[1] + $mtime1[0];
?>
<HTML>
<HEAD>
<LINK TYPE="text/css" REL="stylesheet" HREF="style.css">
<META HTTP-EQUIV="content-type" CONTENT="text/html;charset=iso-8859-1">
<TITLE><? echo $top_name?></TITLE>
</HEAD>

<BODY onLoad="if (self != top) top.location = self.location; <? if (strstr($PHP_SELF,"index.php") || strstr($PHP_SELF,"last.php")) echo " getCamImage()";?>">
<table align=center width=600 border=0>
<tr>
	<td>