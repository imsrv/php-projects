<?php

//SQL Ba�lant�s�
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Dosya �ndir</title>
</head>

<body>
#ICERIK
</body>
</html>';

$tablo = '<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="120">Dosya Ad�: </td>
    <td>#DOSYA_ADI</td>
  </tr>
  <tr>
    <td>A��klama:</td>
    <td>#ACIKLAMA</td>
  </tr>
  <tr>
    <td>Eklenme Tarihi: </td>
    <td>#EKLENME_TARIHI</td>
  </tr>
  <tr>
    <td>Saya�:</td>
    <td>#SAYAC</td>
  </tr>
  <tr>
    <td colspan="2"><a href="' . $_SERVER['PHP_SELF'] . '?indir=1&amp;id=#ID">Dosyay� �ndirmek ��in T�klay�n</a></td>
  </tr>
</table>';

if ( isset($_GET['id']) && is_numeric($_GET['id']) ) $id = $_GET['id'];
else die(str_replace('#ICERIK', 'Dosya ID\'si girilmemi�', $html));

$result = mysql_query('SELECT * FROM `dosyalar` WHERE `id` = ' . $id . ' LIMIT 1');
$row = mysql_fetch_assoc($result);
if ( !$row['adi'] ) echo str_replace('#ICERIK', 'Arad���n�z dosya veritaban�nda bulunamam��t�r', $html);
else if ( !isset($_GET['indir']) ) echo str_replace('#ICERIK', str_replace(array('#DOSYA_ADI', '#ACIKLAMA', '#EKLENME_TARIHI', '#SAYAC', '#ID'), array($row['adi'], $row['aciklama'], date('d.m.Y H:i', $row['eklenme_tarihi']), $row['sayac'], $id), $tablo), $html);
else {
	//Sayac artt�r�l�yor
	$row['sayac']++;
	mysql_query('UPDATE `dosyalar` SET `sayac` = ' . $row['sayac'] . ' WHERE `id` = ' . $id . ' LIMIT 1');
	header('location: ' . $row['url']);
}
?>