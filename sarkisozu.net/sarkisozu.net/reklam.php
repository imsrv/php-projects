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

$maxRows_sarkicilar = 20;
$pageNum_sarkicilar = 0;
if (isset($_GET['pageNum_sarkicilar'])) {
  $pageNum_sarkicilar = $_GET['pageNum_sarkicilar'];
}
$startRow_sarkicilar = $pageNum_sarkicilar * $maxRows_sarkicilar;

mysql_select_db($database_lyrics, $lyrics);
$query_sarkicilar = "SELECT id, sanatci, sarki FROM sarki ORDER BY sanatci ASC, sarki ASC";
$query_limit_sarkicilar = sprintf("%s LIMIT %d, %d", $query_sarkicilar, $startRow_sarkicilar, $maxRows_sarkicilar);
$sarkicilar = mysql_query($query_limit_sarkicilar, $lyrics) or die(mysql_error());
$row_sarkicilar = mysql_fetch_assoc($sarkicilar);

if (isset($_GET['totalRows_sarkicilar'])) {
  $totalRows_sarkicilar = $_GET['totalRows_sarkicilar'];
} else {
  $all_sarkicilar = mysql_query($query_sarkicilar);
  $totalRows_sarkicilar = mysql_num_rows($all_sarkicilar);
}
$totalPages_sarkicilar = ceil($totalRows_sarkicilar/$maxRows_sarkicilar)-1;

$queryString_sarkicilar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sarkicilar") == false && 
        stristr($param, "totalRows_sarkicilar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sarkicilar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sarkicilar = sprintf("&totalRows_sarkicilar=%d%s", $totalRows_sarkicilar, $queryString_sarkicilar);
?>
<html>
<head>
<title>þarkýsözü.net - þarký sözleri portalý</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<?php include "css.php"; ?>
</head>

<body><center>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img width="330" height="70" src="images/header.jpg" alt="sarkisozu.net"><?php include "banner.php"; ?></td>
  </tr>
  <tr>
    <td width="18%" height="90" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Menü</b></center><br><?php include "menu.php"; ?></td>
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a> | <a href="reklam.php">Reklam</a><br><br><center><a href="listsayi.php?harf=9">#</a>&nbsp;<a href="list.php?harf=a">A</a>&nbsp;<a href="list.php?harf=b">B</a>&nbsp;<a href="list.php?harf=c">C-Ç</a>&nbsp;<a href="list.php?harf=d">D</a>&nbsp;<a href="list.php?harf=e">E</a>&nbsp;<a href="list.php?harf=f">F</a>&nbsp;<a href="list.php?harf=g">G</a>&nbsp;<a href="list.php?harf=h">H</a>&nbsp;<a href="list.php?harf=I">I</a>&nbsp;<a href="list.php?harf=Ý">Ý-Ü-Y</a>&nbsp;<a href="list.php?harf=j">J</a>&nbsp;<a href="list.php?harf=k">K</a>&nbsp;<a href="list.php?harf=l">L</a>&nbsp;<a href="list.php?harf=m">M</a>&nbsp;<a href="list.php?harf=n">N</a>&nbsp;<a href="list.php?harf=o">O</a>&nbsp;<a href="list.php?harf=ö">Ö</a>&nbsp;<a href="list.php?harf=p">P</a>&nbsp;<a href="list.php?harf=q">Q</a>&nbsp;<a href="list.php?harf=r">R</a>&nbsp;<a href="list.php?harf=s">S</a>&nbsp;<a href="list.php?harf=þ">Þ</a>&nbsp;<a href="list.php?harf=t">T</a>&nbsp;<a href="list.php?harf=u">U</a>&nbsp;<a href="list.php?harf=v">V</a>&nbsp;<a href="list.php?harf=w">W</a>&nbsp;<a href="list.php?harf=z">Z</a></center><br>
	<center><b>Reklam Seçeneklerimiz</b></center><br>sarkisozu.net sitenize gerçek ziyaretçi yollar, etkili reklam seçenekleri sunar:<br><table style="border:1px solid black;"><tr><td style="border-bottom:1px solid black;"><b>Üst Banner</b>(Bütün sayfalarda yer alýr.):</td><td style="border-bottom:1px solid black;">30YTL/ay</td><td style="border-bottom:1px solid black; vertical-align:middle;"><img src="images/a.gif"></td></tr><tr><td style="border-bottom:1px solid black;"><b>Anasayfa Alt Banner</b>(Anasayfada, duyurularýn alt tarafý):</td><td style="border-bottom:1px solid black;">20YTL/ay</td><td style="border-bottom:1px solid black; vertical-align:middle;"><img src="images/a.gif"></td></tr><tr><td style="border-bottom:1px solid black;"><b>Anasayfa Üst Banner</b>(Anasayfada, alfabe harflerinin hemen altýnda):</td><td style="border-bottom:1px solid black;">30YTL/ay</td><td style="border-bottom:1px solid black; vertical-align:middle;"><img src="images/a.gif"></td></tr><tr><td style="border-bottom:1px solid black;"><b>Link Reklam</b>(Bütün sayfalarda destekleyenler bölümünde gösterilir):</td><td style="border-bottom:1px solid black;">10YTL/2ay</td><td style="border-bottom:1px solid black; vertical-align:middle;"><img src="images/a.gif"></td></tr><tr><td><b>Söz görüntüleme sayfasýna pop-up</b>(Bütün sözlerde, söz görüntüleneceði sayfa açýlýrken pop-up açýlýr):</td><td>50YTL/ay</td><td style="vertical-align:middle;"><img src="images/a.gif"></td></tr></table><center><img src="images/a.gif">: Reklam alaný boþ. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/na.gif">: Reklam alaný dolu.<br><br>Reklam vermeye karar verirseniz <a href="mailto:admin@sarkisozu.net">admin@sarkisozu.net</a> adresine mail atabilir veya soldaki iletiþim linkini kullanabilirsiniz. Eðer reklam vermek istediðiniz alan doluysa, bize ulaþarak ayný alana bir sonraki reklam veren siz olabilirsiniz.</center></td>
    <td width="22%" style="border-left:1px solid black; border-bottom:1px solid black; border-top:1px solid black;" height="90"><center><b>Arama</b><?php include "aramablok.php"; ?></center></td>
  </tr>
  <tr>
    <td width="18%" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Destekleyenler</b></center><br><?php include "destek.php"; ?></td>
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

mysql_free_result($sarkicilar);
?>
