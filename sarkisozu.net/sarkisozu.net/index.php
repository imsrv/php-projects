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
?>
<html>
<head>
<title>�ark�s�z�.net - �ark� s�zleri portal�</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<?php include "css.php"; ?>
</head>
<body><center>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img src="images/header.jpg" alt="sarkisozu.net" width="330" height="70"><?php include "banner.php"; ?></td>
  </tr>
  <tr>
    <td width="18%" height="90" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center><b>Men�</b></center><br><?php include "menu.php"; ?></td>
    <td width="60%" rowspan="2"><a href="index.php">Anasayfa</a><br><br><center><a href="listsayi.php?harf=9">#</a>&nbsp;<a href="list.php?harf=a">A</a>&nbsp;<a href="list.php?harf=b">B</a>&nbsp;<a href="list.php?harf=c">C-�</a>&nbsp;<a href="list.php?harf=d">D</a>&nbsp;<a href="list.php?harf=e">E</a>&nbsp;<a href="list.php?harf=f">F</a>&nbsp;<a href="list.php?harf=g">G</a>&nbsp;<a href="list.php?harf=h">H</a>&nbsp;<a href="list.php?harf=I">I</a>&nbsp;<a href="list.php?harf=�">�-�-Y</a>&nbsp;<a href="list.php?harf=j">J</a>&nbsp;<a href="list.php?harf=k">K</a>&nbsp;<a href="list.php?harf=l">L</a>&nbsp;<a href="list.php?harf=m">M</a>&nbsp;<a href="list.php?harf=n">N</a>&nbsp;<a href="list.php?harf=o">O</a>&nbsp;<a href="list.php?harf=�">�</a>&nbsp;<a href="list.php?harf=p">P</a>&nbsp;<a href="list.php?harf=q">Q</a>&nbsp;<a href="list.php?harf=r">R</a>&nbsp;<a href="list.php?harf=s">S</a>&nbsp;<a href="list.php?harf=�">�</a>&nbsp;<a href="list.php?harf=t">T</a>&nbsp;<a href="list.php?harf=u">U</a>&nbsp;<a href="list.php?harf=v">V</a>&nbsp;<a href="list.php?harf=w">W</a>&nbsp;<a href="list.php?harf=z">Z</a></center><br>
<br>
<center><b>Duyurular</b></center><b>�nemli:</b> Arama yaparken, arayaca��n�z kelimenin tamam�n� b�y�k harfle yazmay�n�z, aksi taktirde yapt���n�z arama sonu� vermeyebilir.<center><table style="width:85%; border: 1px solid black;"><tr><td style="border-bottom:1px solid black;"><b>k�sa ara</b> | 17.07.2006</td></tr><tr><td>Alan ad�m�z� tescil ettirdi�miz yerle ��kan bir sorundan dolay� alan ad�n� transfer etmek zorunda kald�k, bu s�re i�inde de sitemiz kapal� kald�. Bu y�zden �z�r dileriz.</td></tr></table><table style="width:85%; border: 1px solid black;"><tr><td style="border-bottom:1px solid black;"><b>ileti�im men�s�</b> | 02.05.2006</td></tr><tr><td>Sitemizin ileti�im b�l�m�ndeki bir hatadan dolay� ileti�im k�sm� �al��m�yordu, bu sorun halledildi. Bu durum y�z�nden �z�r dileriz, art�k ileti�im linki �al���r durumdad�r.</td></tr></table>
<b>Not: Sitemizde bulaca��n�z �ark� s�zlerinin i�erdi�i/i�erebilece�i argo/kaba s�zc�klerden sitemiz hi�bir �ekilde sorumlu tutulamaz.<br><br></center>
<center>
<br>
</center>
</td>
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
      sitede hi� �ark� s�z� yok!!
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
?>