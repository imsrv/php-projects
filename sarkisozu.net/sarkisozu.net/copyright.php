<?php
mysql_select_db($database_lyrics, $lyrics);
$query_copyright = "SELECT * FROM copyright";
$copyright = mysql_query($query_copyright, $lyrics) or die(mysql_error());
$row_copyright = mysql_fetch_assoc($copyright);
$totalRows_copyright = mysql_num_rows($copyright);
?>
<?php echo $row_copyright['copyright']; ?>
<head>
<meta http-equiv=Content-Language content=tr>
<META NAME="TITLE" CONTENT="�ark� s�zleri �ark� s�zleri �ark� s�zleri �ark� s�zleri �ark� s�zleri">
<META NAME="DESCRIPTION" CONTENT="�ark� s�zleri �ark� s�zleri �ark� s�zleri �ark� s�zleri">
<META NAME="KEYWORDS" CONTENT="yerli, t�rk�e, t�rkce, turkce, yabanc�, yabanci, eminem, pink, avril lavigne, tiziano ferro, madonna, tarkan, sezen aksu, k�ra�, mazhar alanson, haluk levent, haramiler, duman, diken, ibrahim tatl�ses, m�sl�m g�rses, iron maiden, metallica, megadeth, helloween, blind guardian, heavy metal, thrash metal, power metal, proggressive, �ark�s�z�, sarkisozu, �ark�, sarki, soz, s�z, �ark� s�z�, sarki sozu">
</head>
<?php
mysql_free_result($copyright);
?>