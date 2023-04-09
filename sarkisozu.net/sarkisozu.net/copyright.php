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
<META NAME="TITLE" CONTENT="þarký sözleri þarký sözleri þarký sözleri þarký sözleri þarký sözleri">
<META NAME="DESCRIPTION" CONTENT="þarký sözleri þarký sözleri þarký sözleri þarký sözleri">
<META NAME="KEYWORDS" CONTENT="yerli, türkçe, türkce, turkce, yabancý, yabanci, eminem, pink, avril lavigne, tiziano ferro, madonna, tarkan, sezen aksu, kýraç, mazhar alanson, haluk levent, haramiler, duman, diken, ibrahim tatlýses, müslüm gürses, iron maiden, metallica, megadeth, helloween, blind guardian, heavy metal, thrash metal, power metal, proggressive, þarkýsözü, sarkisozu, þarký, sarki, soz, söz, þarký sözü, sarki sozu">
</head>
<?php
mysql_free_result($copyright);
?>