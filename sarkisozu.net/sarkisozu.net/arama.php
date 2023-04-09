<?php require_once('Connections/lyrics.php'); ?>
<?php
session_start();
$currentPage = $_SERVER["PHP_SELF"];
if ($_GET['sarki'] == '') {
$_GET['sarki'] = "asdasd";
}
if ($_GET['dil'] == 'tr') {
$kelime = $_GET['sarki'];
$kelime = str_replace("  ", " ", $kelime); 
$kelime = str_replace("  ", " ", $kelime);
$kelime = str_replace("  ", " ", $kelime);

   $kelime[0] = strtr($kelime, 
   "abcdefghýijklmnopqrstuvwxyz".
   "\x9C\x9A\xE0\xE1\xE2\xE3".
   "\xE4\xE5\xE6\xE7\xE8\xE9".
   "\xEA\xEB\xEC\xED\xEE\xEF".
   "\xF0\xF1\xF2\xF3\xF4\xF5".
   "\xF6\xF8\xF9\xFA\xFB\xFC".
   "\xFE\xFF", 
   "ABCDEFGHIÝJKLMNOPQRSTUVWXYZ".
   "\x8C\x8A\xC0\xC1\xC2\xC3\xC4".
   "\xC5\xC6\xC7\xC8\xC9\xCA\xCB".
   "\xCC\xCD\xCE\xCF\xD0\xD1\xD2".
   "\xD3\xD4\xD5\xD6\xD8\xD9\xDA".
   "\xDB\xDC\xDE\x9F");

$_GET['sarki'] = $kelime;
}
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

$maxRows_aramasonuc = 10;
$pageNum_aramasonuc = 0;
if (isset($_GET['pageNum_aramasonuc'])) {
  $pageNum_aramasonuc = $_GET['pageNum_aramasonuc'];
}
$startRow_aramasonuc = $pageNum_aramasonuc * $maxRows_aramasonuc;

$colname_aramasonuc = "1";
if (isset($_GET['sarki'])) {
  $colname_aramasonuc = (get_magic_quotes_gpc()) ? $_GET['sarki'] : addslashes($_GET['sarki']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_aramasonuc = sprintf("SELECT * FROM sarki WHERE sarki LIKE '%%%s%%' ORDER BY sarki ASC, sanatci ASC, album ASC", $colname_aramasonuc);
$query_limit_aramasonuc = sprintf("%s LIMIT %d, %d", $query_aramasonuc, $startRow_aramasonuc, $maxRows_aramasonuc);
$aramasonuc = mysql_query($query_limit_aramasonuc, $lyrics) or die(mysql_error());
$row_aramasonuc = mysql_fetch_assoc($aramasonuc);

if (isset($_GET['totalRows_aramasonuc'])) {
  $totalRows_aramasonuc = $_GET['totalRows_aramasonuc'];
} else {
  $all_aramasonuc = mysql_query($query_aramasonuc);
  $totalRows_aramasonuc = mysql_num_rows($all_aramasonuc);
}
$totalPages_aramasonuc = ceil($totalRows_aramasonuc/$maxRows_aramasonuc)-1;

$maxRows_aramasonucsanatci = 10;
$pageNum_aramasonucsanatci = 0;
if (isset($_GET['pageNum_aramasonucsanatci'])) {
  $pageNum_aramasonucsanatci = $_GET['pageNum_aramasonucsanatci'];
}
$startRow_aramasonucsanatci = $pageNum_aramasonucsanatci * $maxRows_aramasonucsanatci;

$colname_aramasonucsanatci = "1";
if (isset($_GET['sarki'])) {
  $colname_aramasonucsanatci = (get_magic_quotes_gpc()) ? $_GET['sarki'] : addslashes($_GET['sarki']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_aramasonucsanatci = sprintf("SELECT * FROM sarki WHERE sanatci LIKE '%%%s%%' ORDER BY sanatci ASC, sarki ASC, album ASC", $colname_aramasonucsanatci);
$query_limit_aramasonucsanatci = sprintf("%s LIMIT %d, %d", $query_aramasonucsanatci, $startRow_aramasonucsanatci, $maxRows_aramasonucsanatci);
$aramasonucsanatci = mysql_query($query_limit_aramasonucsanatci, $lyrics) or die(mysql_error());
$row_aramasonucsanatci = mysql_fetch_assoc($aramasonucsanatci);

if (isset($_GET['totalRows_aramasonucsanatci'])) {
  $totalRows_aramasonucsanatci = $_GET['totalRows_aramasonucsanatci'];
} else {
  $all_aramasonucsanatci = mysql_query($query_aramasonucsanatci);
  $totalRows_aramasonucsanatci = mysql_num_rows($all_aramasonucsanatci);
}
$totalPages_aramasonucsanatci = ceil($totalRows_aramasonucsanatci/$maxRows_aramasonucsanatci)-1;

$maxRows_aramasonucalbum = 10;
$pageNum_aramasonucalbum = 0;
if (isset($_GET['pageNum_aramasonucalbum'])) {
  $pageNum_aramasonucalbum = $_GET['pageNum_aramasonucalbum'];
}
$startRow_aramasonucalbum = $pageNum_aramasonucalbum * $maxRows_aramasonucalbum;

$colname_aramasonucalbum = "1";
if (isset($_GET['sarki'])) {
  $colname_aramasonucalbum = (get_magic_quotes_gpc()) ? $_GET['sarki'] : addslashes($_GET['sarki']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_aramasonucalbum = sprintf("SELECT * FROM sarki WHERE album LIKE '%%%s%%' ORDER BY album ASC, sanatci ASC, sarki ASC", $colname_aramasonucalbum);
$query_limit_aramasonucalbum = sprintf("%s LIMIT %d, %d", $query_aramasonucalbum, $startRow_aramasonucalbum, $maxRows_aramasonucalbum);
$aramasonucalbum = mysql_query($query_limit_aramasonucalbum, $lyrics) or die(mysql_error());
$row_aramasonucalbum = mysql_fetch_assoc($aramasonucalbum);

if (isset($_GET['totalRows_aramasonucalbum'])) {
  $totalRows_aramasonucalbum = $_GET['totalRows_aramasonucalbum'];
} else {
  $all_aramasonucalbum = mysql_query($query_aramasonucalbum);
  $totalRows_aramasonucalbum = mysql_num_rows($all_aramasonucalbum);
}
$totalPages_aramasonucalbum = ceil($totalRows_aramasonucalbum/$maxRows_aramasonucalbum)-1;

$queryString_aramasonuc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_aramasonuc") == false && 
        stristr($param, "totalRows_aramasonuc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_aramasonuc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_aramasonuc = sprintf("&totalRows_aramasonuc=%d%s", $totalRows_aramasonuc, $queryString_aramasonuc);

$queryString_aramasonucsanatci = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_aramasonucsanatci") == false && 
        stristr($param, "totalRows_aramasonucsanatci") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_aramasonucsanatci = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_aramasonucsanatci = sprintf("&totalRows_aramasonucsanatci=%d%s", $totalRows_aramasonucsanatci, $queryString_aramasonucsanatci);

$queryString_aramasonucalbum = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_aramasonucalbum") == false && 
        stristr($param, "totalRows_aramasonucalbum") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_aramasonucalbum = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_aramasonucalbum = sprintf("&totalRows_aramasonucalbum=%d%s", $totalRows_aramasonucalbum, $queryString_aramasonucalbum);
?>
<html>
<head>
<title>þarkýsözü.net - arama sonuçlarý</title>
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
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a> | Arama Sonuçlarý<br><br><center><a href="listsayi.php?harf=9">#</a>&nbsp;<a href="list.php?harf=a">A</a>&nbsp;<a href="list.php?harf=b">B</a>&nbsp;<a href="list.php?harf=c">C-Ç</a>&nbsp;<a href="list.php?harf=d">D</a>&nbsp;<a href="list.php?harf=e">E</a>&nbsp;<a href="list.php?harf=f">F</a>&nbsp;<a href="list.php?harf=g">G</a>&nbsp;<a href="list.php?harf=h">H</a>&nbsp;<a href="list.php?harf=I">I</a>&nbsp;<a href="list.php?harf=Ý">Ý-Ü-Y</a>&nbsp;<a href="list.php?harf=j">J</a>&nbsp;<a href="list.php?harf=k">K</a>&nbsp;<a href="list.php?harf=l">L</a>&nbsp;<a href="list.php?harf=m">M</a>&nbsp;<a href="list.php?harf=n">N</a>&nbsp;<a href="list.php?harf=o">O</a>&nbsp;<a href="list.php?harf=ö">Ö</a>&nbsp;<a href="list.php?harf=p">P</a>&nbsp;<a href="list.php?harf=q">Q</a>&nbsp;<a href="list.php?harf=r">R</a>&nbsp;<a href="list.php?harf=s">S</a>&nbsp;<a href="list.php?harf=þ">Þ</a>&nbsp;<a href="list.php?harf=t">T</a>&nbsp;<a href="list.php?harf=u">U</a>&nbsp;<a href="list.php?harf=v">V</a>&nbsp;<a href="list.php?harf=w">W</a>&nbsp;<a href="list.php?harf=z">Z</a></center><br><center><b>Arama Sonuçlarý:</b></center><br><br><b>Þarký adýna göre:</b><br>
      <?php if ($totalRows_aramasonuc > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <a href="sarki.php?id=<?php echo $row_aramasonuc['id']; ?>"><?php echo $row_aramasonuc['sarki']; ?></a> - <a href="sarkici.php?sanatci=<?php echo $row_aramasonuc['sanatci']; ?>"><?php echo $row_aramasonuc['sanatci']; ?></a> - <b>Albüm: </b><?php echo $row_aramasonuc['album']; ?><br>
      <?php } while ($row_aramasonuc = mysql_fetch_assoc($aramasonuc)); ?>
      <?php } // Show if recordset not empty ?><br><center>
        <?php if ($pageNum_aramasonuc > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_aramasonuc=%d%s", $currentPage, 0, $queryString_aramasonuc); ?>"><<-Ýlk Sayfa</a>
        <?php } // Show if not first page ?>
        &nbsp;
        <?php if ($pageNum_aramasonuc > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_aramasonuc=%d%s", $currentPage, max(0, $pageNum_aramasonuc - 1), $queryString_aramasonuc); ?>"><-Önceki Sayfa</a>
        <?php } // Show if not first page ?>
&nbsp;
<?php if ($pageNum_aramasonuc < $totalPages_aramasonuc) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_aramasonuc=%d%s", $currentPage, min($totalPages_aramasonuc, $pageNum_aramasonuc + 1), $queryString_aramasonuc); ?>">Sonraki Sayfa -></a>
<?php } // Show if not last page ?>
&nbsp;
<?php if ($pageNum_aramasonuc < $totalPages_aramasonuc) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_aramasonuc=%d%s", $currentPage, $totalPages_aramasonuc, $queryString_aramasonuc); ?>">Son Sayfa ->></a>
<?php } // Show if not last page ?>
      </center>
      <?php if ($totalRows_aramasonuc == 0) { // Show if recordset empty ?>
      Aradýðýnýz kelimeye uygun bir þarký bulunamadý.<br>
      <?php } // Show if recordset empty ?><br><b>Þarkýcý adýna göre:</b><br>
	  <?php if ($totalRows_aramasonucsanatci > 0) { // Show if recordset not empty ?>
	  <?php do { ?>
	   <a href="sarkici.php?sanatci=<?php echo $row_aramasonucsanatci['sanatci']; ?>"><?php echo $row_aramasonucsanatci['sanatci']; ?></a> - <a href="sarki.php?id=<?php echo $row_aramasonucsanatci['id']; ?>"><?php echo $row_aramasonucsanatci['sarki']; ?></a> - <b>Albüm: </b><?php echo $row_aramasonucsanatci['album']; ?><br>
	  <?php } while ($row_aramasonucsanatci = mysql_fetch_assoc($aramasonucsanatci)); ?>
	  <?php } // Show if recordset not empty ?><br><center>
	    <?php if ($pageNum_aramasonucsanatci > 0) { // Show if not first page ?>
	    <a href="<?php printf("%s?pageNum_aramasonucsanatci=%d%s", $currentPage, 0, $queryString_aramasonucsanatci); ?>"><<- Ýlk Sayfa</a>
	    <?php } // Show if not first page ?>
	    &nbsp;
	    <?php if ($pageNum_aramasonucsanatci > 0) { // Show if not first page ?>
	    <a href="<?php printf("%s?pageNum_aramasonucsanatci=%d%s", $currentPage, max(0, $pageNum_aramasonucsanatci - 1), $queryString_aramasonucsanatci); ?>"><-Önceki Sayfa</a>
	    <?php } // Show if not first page ?>
	    &nbsp;
	    <?php if ($pageNum_aramasonucsanatci < $totalPages_aramasonucsanatci) { // Show if not last page ?>
	    <a href="<?php printf("%s?pageNum_aramasonucsanatci=%d%s", $currentPage, min($totalPages_aramasonucsanatci, $pageNum_aramasonucsanatci + 1), $queryString_aramasonucsanatci); ?>">Sonraki Sayfa-></a>
	    <?php } // Show if not last page ?>
	    &nbsp;
	    <?php if ($pageNum_aramasonucsanatci < $totalPages_aramasonucsanatci) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_aramasonucsanatci=%d%s", $currentPage, $totalPages_aramasonucsanatci, $queryString_aramasonucsanatci); ?>">Son Sayfa->></a>
        <?php } // Show if not last page ?>
      </center>
	  <?php if ($totalRows_aramasonucsanatci == 0) { // Show if recordset empty ?>
	  Aradýðýnýz kelimeye uygun bir þarkýcý bulunamadý.<br>
	  <?php } // Show if recordset empty ?><br><b>Albüm adýna göre:</b><br>
	  <?php if ($totalRows_aramasonucalbum > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <b>Albüm: </b><?php echo $row_aramasonucalbum['album']; ?> - <a href="sarkici.php?sanatci=<?php echo $row_aramasonucalbum['sanatci']; ?>"><?php echo $row_aramasonucalbum['sanatci']; ?></a> - <a href="sarki.php?id=<?php echo $row_aramasonucalbum['id']; ?>"><?php echo $row_aramasonucalbum['sarki']; ?></a><br>
      <?php } while ($row_aramasonucalbum = mysql_fetch_assoc($aramasonucalbum)); ?>
<?php } // Show if recordset not empty ?><br><center>
  <?php if ($pageNum_aramasonucalbum > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_aramasonucalbum=%d%s", $currentPage, 0, $queryString_aramasonucalbum); ?>"><<-Ýlk Sayfa</a>
  <?php } // Show if not first page ?>
  &nbsp;
  <?php if ($pageNum_aramasonucalbum > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_aramasonucalbum=%d%s", $currentPage, max(0, $pageNum_aramasonucalbum - 1), $queryString_aramasonucalbum); ?>"><-Önceki Sayfa</a>
  <?php } // Show if not first page ?>
  &nbsp;
  <?php if ($pageNum_aramasonucalbum < $totalPages_aramasonucalbum) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_aramasonucalbum=%d%s", $currentPage, min($totalPages_aramasonucalbum, $pageNum_aramasonucalbum + 1), $queryString_aramasonucalbum); ?>">Sonraki Sayfa-></a>
  <?php } // Show if not last page ?>
  &nbsp;
  <?php if ($pageNum_aramasonucalbum < $totalPages_aramasonucalbum) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_aramasonucalbum=%d%s", $currentPage, $totalPages_aramasonucalbum, $queryString_aramasonucalbum); ?>">Son Sayfa->></a>
  <?php } // Show if not last page ?>
</center>
	  <?php if ($totalRows_aramasonucalbum == 0) { // Show if recordset empty ?>
Aradýðýnýz kelimeye uygun bir albüm bulunamadý.<br>
<?php } // Show if recordset empty ?><br><br><font size="3"><b>Önemli Not:</b></font>&nbsp; Eðer aramanýz sonuç vermediyse mutlaka okuyun:<br>Arama yaparken þarký, þarkýcý veya albüm isimlerinden yalnýzca birini yazmalýsýnýz. Örneðin, tarkan love speak yazarsanýz arama sonuç vermeyecektir ancak love speak veya tarkan yazarak arama yaparsanýz sonuçlarý görüntüleyebilirsiniz.<br><br>Ayrýca, arama sistemimizin saðlýklý sonuç vermesi için tamamý büyük harfle yazýlmýþ kelimeler girmeyiniz.</td>
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

mysql_free_result($aramasonuc);

mysql_free_result($aramasonucsanatci);

mysql_free_result($aramasonucalbum);
?>
