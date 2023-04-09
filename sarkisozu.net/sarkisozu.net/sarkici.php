<?php require_once('Connections/lyrics.php'); ?>
<?php
session_start();
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_soneklenen = 10;
$pageNum_soneklenen = 0;
if (isset($_GET['pageNum_soneklenen'])) {
  $pageNum_soneklenen = $_GET['pageNum_soneklenen'];
}
$startRow_soneklenen = $pageNum_soneklenen * $maxRows_soneklenen;

mysql_select_db($database_lyrics, $lyrics);
$query_soneklenen = "SELECT id, sanatci, sarki FROM sarki ORDER BY id DESC";
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

$colname_sarkici = "1";
if (isset($_GET['sanatci'])) {
  $colname_sarkici = (get_magic_quotes_gpc()) ? $_GET['sanatci'] : addslashes($_GET['sanatci']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_sarkici = sprintf("SELECT sanatci FROM sarki WHERE sanatci = '%s'", $colname_sarkici);
$sarkici = mysql_query($query_sarkici, $lyrics) or die(mysql_error());
$row_sarkici = mysql_fetch_assoc($sarkici);
$totalRows_sarkici = mysql_num_rows($sarkici);

$maxRows_sarkilari = 30;
$pageNum_sarkilari = 0;
if (isset($_GET['pageNum_sarkilari'])) {
  $pageNum_sarkilari = $_GET['pageNum_sarkilari'];
}
$startRow_sarkilari = $pageNum_sarkilari * $maxRows_sarkilari;

$colname_sarkilari = "1";
if (isset($_GET['sanatci'])) {
  $colname_sarkilari = (get_magic_quotes_gpc()) ? $_GET['sanatci'] : addslashes($_GET['sanatci']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_sarkilari = sprintf("SELECT id, sanatci, sarki, album FROM sarki WHERE sanatci = '%s' ORDER BY sarki ASC", $colname_sarkilari);
$query_limit_sarkilari = sprintf("%s LIMIT %d, %d", $query_sarkilari, $startRow_sarkilari, $maxRows_sarkilari);
$sarkilari = mysql_query($query_limit_sarkilari, $lyrics) or die(mysql_error());
$row_sarkilari = mysql_fetch_assoc($sarkilari);

if (isset($_GET['totalRows_sarkilari'])) {
  $totalRows_sarkilari = $_GET['totalRows_sarkilari'];
} else {
  $all_sarkilari = mysql_query($query_sarkilari);
  $totalRows_sarkilari = mysql_num_rows($all_sarkilari);
}
$totalPages_sarkilari = ceil($totalRows_sarkilari/$maxRows_sarkilari)-1;

$queryString_sarkilari = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sarkilari") == false && 
        stristr($param, "totalRows_sarkilari") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sarkilari = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sarkilari = sprintf("&totalRows_sarkilari=%d%s", $totalRows_sarkilari, $queryString_sarkilari);
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<META NAME="TITLE" CONTENT="<?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?>">
<META NAME="DESCRIPTION" CONTENT="<?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sarki']; ?>">
<META NAME="KEYWORDS" CONTENT="<?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?> - <?php echo $row_sozler['sanatci']; ?>, yerli, türkçe, türkce, turkce, yabancý, yabanci, eminem, pink, avril lavigne, tiziano ferro, madonna, tarkan, sezen aksu, kýraç, mazhar alanson, haluk levent, haramiler, duman, diken, ibrahim tatlýses, müslüm gürses, iron maiden, metallica, megadeth, helloween, blind guardian, heavy metal, thrash metal, power metal, proggressive, þarkýsözü, sarkisozu, þarký, sarki, soz, söz, þarký sözü, sarki sozu">
<title>þarkýsözü.net - <?php echo $row_sarkici['sanatci']; ?> - <?php echo $row_sarkici['sanatci']; ?> - <?php echo $row_sarkici['sanatci']; ?> - <?php echo $row_sarkici['sanatci']; ?> - <?php echo $row_sarkici['sanatci']; ?> - <?php echo $row_sarkici['sanatci']; ?></title>
<?php include "css.php"; ?>
</head>

<body><center>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img width="330" height="70" src="images/header.jpg" alt="sarkisozu.net"><?php include "banner.php"; ?></td>
  </tr>
  <tr>
    <td width="18%" height="90" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Menü</b></center><br><?php include "menu.php"; ?></td>
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a> | <a href="sarkici.php?sanatci=<?php echo $row_sarkici['sanatci']; ?>"><?php echo $row_sarkici['sanatci']; ?></a><br><br><center><a href="listsayi.php?harf=9">#</a>&nbsp;<a href="list.php?harf=a">A</a>&nbsp;<a href="list.php?harf=b">B</a>&nbsp;<a href="list.php?harf=c">C-Ç</a>&nbsp;<a href="list.php?harf=d">D</a>&nbsp;<a href="list.php?harf=e">E</a>&nbsp;<a href="list.php?harf=f">F</a>&nbsp;<a href="list.php?harf=g">G</a>&nbsp;<a href="list.php?harf=h">H</a>&nbsp;<a href="list.php?harf=I">I</a>&nbsp;<a href="list.php?harf=Ý">Ý-Ü-Y</a>&nbsp;<a href="list.php?harf=j">J</a>&nbsp;<a href="list.php?harf=k">K</a>&nbsp;<a href="list.php?harf=l">L</a>&nbsp;<a href="list.php?harf=m">M</a>&nbsp;<a href="list.php?harf=n">N</a>&nbsp;<a href="list.php?harf=o">O</a>&nbsp;<a href="list.php?harf=ö">Ö</a>&nbsp;<a href="list.php?harf=p">P</a>&nbsp;<a href="list.php?harf=q">Q</a>&nbsp;<a href="list.php?harf=r">R</a>&nbsp;<a href="list.php?harf=s">S</a>&nbsp;<a href="list.php?harf=þ">Þ</a>&nbsp;<a href="list.php?harf=t">T</a>&nbsp;<a href="list.php?harf=u">U</a>&nbsp;<a href="list.php?harf=v">V</a>&nbsp;<a href="list.php?harf=w">W</a>&nbsp;<a href="list.php?harf=z">Z</a></center><br><center><b><a href="sarkici.php?sanatci=<?php echo $row_sarkici['sanatci']; ?>"><?php echo $row_sarkici['sanatci']; ?></a>'in þarkýlarý(<?php echo $totalRows_sarkilari ?>):</b>
    </center><br>
      <?php do { ?>
      <a href="sarki.php?id=<?php echo $row_sarkilari['id']; ?>"><?php echo $row_sarkilari['sarki']; ?></a> - <b>Albüm: </b><?php echo $row_sarkilari['album']; ?><br>
      <?php } while ($row_sarkilari = mysql_fetch_assoc($sarkilari)); ?><br>
      <center><?php if ($pageNum_sarkilari > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_sarkilari=%d%s", $currentPage, 0, $queryString_sarkilari); ?>"><<-Ýlk Sayfa</a>
      <?php } // Show if not first page ?>
      <?php if ($pageNum_sarkilari > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_sarkilari=%d%s", $currentPage, max(0, $pageNum_sarkilari - 1), $queryString_sarkilari); ?>">&nbsp;<-Önceki Sayfa</a>
      <?php } // Show if not first page ?>
      &nbsp;
      <?php if ($pageNum_sarkilari < $totalPages_sarkilari) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_sarkilari=%d%s", $currentPage, min($totalPages_sarkilari, $pageNum_sarkilari + 1), $queryString_sarkilari); ?>">Sonraki Sayfa-></a>
      <?php } // Show if not last page ?>
      &nbsp;
      <?php if ($pageNum_sarkilari < $totalPages_sarkilari) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_sarkilari=%d%s", $currentPage, $totalPages_sarkilari, $queryString_sarkilari); ?>">Son Sayfa->></a>
      <?php } // Show if not last page ?></center></td>
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

mysql_free_result($sarkici);

mysql_free_result($sarkilari);
?>
