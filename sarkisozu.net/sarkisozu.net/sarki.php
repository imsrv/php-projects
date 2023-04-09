<?php require_once('Connections/lyrics.php'); ?>
<?php
session_start();
$maxRows_soneklenen = 10;
$pageNum_soneklenen = 0;
if (isset($_GET['pageNum_soneklenen'])) {
  $pageNum_soneklenen = $_GET['pageNum_soneklenen'];
}
$startRow_soneklenen = $pageNum_soneklenen * $maxRows_soneklenen;

mysql_select_db($database_lyrics, $lyrics);
$query_soneklenen = "SELECT * FROM sarki ORDER BY id DESC";
$query_limit_soneklenen = sprintf("%s LIMIT %d, %d", $query_soneklenen, $startRow_soneklenen, $maxRows_soneklenen);
$soneklenen = mysql_query($query_limit_soneklenen, $lyrics) or die(mysql_error());
$row_soneklenen = mysql_fetch_assoc($soneklenen);

if (isset($_GET['totalRows_soneklenen'])) {
  $totalRows_soneklenen = $_GET['totalRows_soneklenen'];
} else {
  $all_soneklenen = mysql_query($query_soneklenen);
  $totalRows_soneklenen = mysql_num_rows($all_soneklenen);
}
$totalPages_soneklenen = ceil($totalRows_soneklenen/$maxRows_soneklenen)-1;

$colname_sozler = "1";
if (isset($_GET['id'])) {
  $colname_sozler = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_sozler = sprintf("SELECT * FROM sarki WHERE id = %s", $colname_sozler);
$sozler = mysql_query($query_sozler, $lyrics) or die(mysql_error());
$row_sozler = mysql_fetch_assoc($sozler);
$totalRows_sozler = mysql_num_rows($sozler);
?>
<?php
$sarkidegeri = sprintf("sarkisozunet%s", $row_sozler['id']);
if($_COOKIE[$sarkidegeri] == '1'){ 
} else {
$cook = $_COOKIE[$sarkidegeri] + 1; 
setcookie("$sarkidegeri", "$cook", time()+1000);
include("sarkisay/sayiekle.php");
}
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<meta http-equiv=Content-Language content=tr>
<META NAME="TITLE" CONTENT="<?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?>">
<META NAME="DESCRIPTION" CONTENT="<?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?>">
<META NAME="KEYWORDS" CONTENT="<?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?>, yerli, türkçe, türkce, turkce, yabancý, yabanci, eminem, pink, avril lavigne, tiziano ferro, madonna, tarkan, sezen aksu, kýraç, mazhar alanson, haluk levent, haramiler, duman, diken, ibrahim tatlýses, müslüm gürses, iron maiden, metallica, megadeth, helloween, blind guardian, heavy metal, thrash metal, power metal, proggressive, þarkýsözü, sarkisozu, þarký, sarki, soz, söz, þarký sözü, sarki sozu">
<title>þarkýsözü.net - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?></title>
<?php include "css.php"; ?>
</head>

<body><center>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img width="330" height="70" src="images/header.jpg" alt="sarkisozu.net"><?php include "banner.php"; ?></td>
  </tr>
  <tr>
    <td width="18%" height="90" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Menü</b></center><br><?php include "menu.php"; ?></td>
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a> | <a href="sarkici.php?sanatci=<?php echo $row_sozler['sanatci']; ?>"><?php echo $row_sozler['sanatci']; ?></a> | <a href="sarki.php?id=<?php echo $row_sozler['id']; ?>"><?php echo $row_sozler['sarki']; ?></a><br><br><center><a href="listsayi.php?harf=9">#</a>&nbsp;<a href="list.php?harf=a">A</a>&nbsp;<a href="list.php?harf=b">B</a>&nbsp;<a href="list.php?harf=c">C-Ç</a>&nbsp;<a href="list.php?harf=d">D</a>&nbsp;<a href="list.php?harf=e">E</a>&nbsp;<a href="list.php?harf=f">F</a>&nbsp;<a href="list.php?harf=g">G</a>&nbsp;<a href="list.php?harf=h">H</a>&nbsp;<a href="list.php?harf=I">I</a>&nbsp;<a href="list.php?harf=Ý">Ý-Ü-Y</a>&nbsp;<a href="list.php?harf=j">J</a>&nbsp;<a href="list.php?harf=k">K</a>&nbsp;<a href="list.php?harf=l">L</a>&nbsp;<a href="list.php?harf=m">M</a>&nbsp;<a href="list.php?harf=n">N</a>&nbsp;<a href="list.php?harf=o">O</a>&nbsp;<a href="list.php?harf=ö">Ö</a>&nbsp;<a href="list.php?harf=p">P</a>&nbsp;<a href="list.php?harf=q">Q</a>&nbsp;<a href="list.php?harf=r">R</a>&nbsp;<a href="list.php?harf=s">S</a>&nbsp;<a href="list.php?harf=þ">Þ</a>&nbsp;<a href="list.php?harf=t">T</a>&nbsp;<a href="list.php?harf=u">U</a>&nbsp;<a href="list.php?harf=v">V</a>&nbsp;<a href="list.php?harf=w">W</a>&nbsp;<a href="list.php?harf=z">Z</a></center><br><center><b><?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?></b><br><b>Albüm: </b><?php echo $row_sozler['album']; ?><br>Bu þarký sözü toplam <b><?php include("sarkisay/sayial.php"); ?></b> kez görüntülenmiþ.</center><br>
<center><textarea name="sozler" rows="23" cols="60" readonly><?php echo $row_sozler['soz']; ?></textarea><br>
<br><a href="iletisim.php?islem=hatalisoz&id=<?php echo $row_sozler['id']; ?>">Bu sözlerin yanlýþ olduðunu düþünüyorsanýz týklayýn.</a><br><br>
      <br><br>
<?php
if ($MM_UserGroup == 10) { ?>
<a href="mod/duzenle_2.php?id=<?php echo $row_sozler['id']; ?>">düzenle</a>
<?php
} 
else if ($MM_UserGroup == 5) { ?>
<a href="mod/duzenle_2.php?id=<?php echo $row_sozler['id']; ?>">düzenle</a>
<?php } ?>
      </center></td>
    <td width="22%" style="border-left:1px solid black; border-bottom:1px solid black; border-top:1px solid black;" height="90"><center><b>Arama</b><?php include "aramablok.php"; ?></center></td>
  </tr>
  <tr>
    <td width="18%" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Destekleyenler</b></center><br><?php include "destek.php"; ?></center></td>
    <td style="border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Son Eklenenler</b><br><br><?php if ($totalRows_soneklenen > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <a href="sarkici.php?sanatci=<?php echo $row_soneklenen['sanatci']; ?>"><?php echo $row_soneklenen['sanatci']; ?></a> - <a href="sarki.php?id=<?php echo $row_soneklenen['id']; ?>"><?php echo $row_soneklenen['sarki']; ?></a><br>
      <?php } while ($row_soneklenen = mysql_fetch_assoc($soneklenen)); ?>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_soneklenen == 0) { // Show if recordset empty ?>
      sitede hiç þarký sözü yok!!
      <?php } // Show if recordset empty ?>
    </center></td>
  </tr>
  <tr><td colspan="3" height="5" style="border-top:1px solid black;"><?php include "copyright.php"; ?></td></tr>
<tr><td colspan="3" height="5" style="border-top:1px solid black;"><center><?php include "toplist.php"; ?></center></td></tr>
</table></center>
</body>
</html>
<?php
mysql_free_result($soneklenen);

mysql_free_result($sozler);
?>
