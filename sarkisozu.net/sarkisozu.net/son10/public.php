<?php require_once('../Connections/lyrics.php'); ?>
<?php
$maxRows_verial = 10;
$pageNum_verial = 0;
if (isset($_GET['pageNum_verial'])) {
  $pageNum_verial = $_GET['pageNum_verial'];
}
$startRow_verial = $pageNum_verial * $maxRows_verial;

mysql_select_db($database_lyrics, $lyrics);
$query_verial = "SELECT id, sanatci, sarki, sayac FROM sarki ORDER BY sayac DESC";
$query_limit_verial = sprintf("%s LIMIT %d, %d", $query_verial, $startRow_verial, $maxRows_verial);
$verial = mysql_query($query_limit_verial, $lyrics) or die(mysql_error());
$row_verial = mysql_fetch_assoc($verial);

if (isset($_GET['totalRows_verial'])) {
  $totalRows_verial = $_GET['totalRows_verial'];
} else {
  $all_verial = mysql_query($query_verial);
  $totalRows_verial = mysql_num_rows($all_verial);
}
$totalPages_verial = ceil($totalRows_verial/$maxRows_verial)-1;
?>
<http>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>şarkısözü.net - en popüler 10</title>
<style>
body {color: black; background-color: #ffffff; font-family: Verdana,Arial,Sans-serif; font-weight: normal; font-size: 11px; margin: 1px; overflow:scroll; overflow-x:hidden;}
*  {scrollbar-face-color: #ece9d8; scrollbar-arrow-color: #000000; scrollbar-track-color: #ffffff; scrollbar-shadow-color: #ffffff; scrollbar-highlight-color: #ffffff; scrollbar-3dlight-color: #000000; scrollbar-darkshadow-Color: #000000;}
table {margin: 30; padding: 5; font-size: small; background-color:#FFFFFF;}
table td {font-size: 11px; padding: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}
a {font-family: Tahoma, Arial; color: #ff6633; text-decoration: none; font-weight: bold; background-color: transparent;}
a:hover {color: #990066;}
li { margin-left: 2px; list-style: square inside; color: #2F5376;}
th {color: #404040;	font-family: Tahoma, Arial;	padding : 2px; vertical-align : middle;	background-color: #DED9BC;}
input, formfield, select {border: 1px solid #8699b5; background-color : #eeecdd; color : #000000; font-family : Tahoma, Arial; font-size : 11px; text-indent : 2px;}
textarea {border: 1px solid #8699B5; font: 11px verdana, arial, helvetica, sans-serif; background-color: #EEECDD;}
</style>
</head>
<body>

  <table width="190" border="0">
    <tr>
      <td colspan="3" style="border:1px solid black;"><div align="center"><b>En Popüler Şarkı Sözleri</b></div></td>
    </tr>
    <?php do { ?>
    <tr>
      <td width="49%" align="right" style="border-left:1px solid black;"><?php echo $row_verial['sanatci']; ?></td>
      <td width="4%"><b>-</b></td>
      <td width="47%" style="border-right:1px solid black;"><a href="http://www.sarkisozu.net/sarki.php?id=<?php echo $row_verial['id']; ?>&gond=public" target="_blank"><?php echo $row_verial['sarki']; ?></a></td>
    </tr>
    <?php } while ($row_verial = mysql_fetch_assoc($verial)); ?>

    <tr>
      <td colspan="3" align="center" style="border:1px solid black;">powered by <a href="http://www.sarkisozu.net/index.php?gond=public" target="_blank">sarkisozu.net</a></td>
    </tr>
  </table>
</body>
<?php
mysql_free_result($verial);
?>
