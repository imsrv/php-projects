<?
include('inc/function.php');
@sql_baglan();
if($_GET['sayfa'] == 'izle') {
	$veri	= @video_bilgi();
	$title	= @txt_edit($veri['baslik'],155);
	$meta	= @txt_edit($veri['bilgi'],255);
}
elseif($_GET['sayfa'] == 'kategori') {
	$kadi	= @kategori_adi($_GET['kat']);
	$title	= @txt_edit($kadi,155);
	$meta	= @txt_edit($kadi,255);
	$meta	= $meta.' videolarý, '.$meta.' videolarý izle';
}
elseif($_GET['sayfa'] == 'ara') {
	$aranan	= @htmlspecialchars($_GET['ara']);
	$aranan	= @trim($aranan);
	$aranan	= @urlduzel($aranan);
	$title	= $aranan;
	$meta	= $aranan.' bedava videolar, '.$aranan.' video izle, '.$aranan.' bedava izle, '.$aranan.' izle, '.$aranan.' seyret, '.$aranan.' video seyret, '.$aranan.' vidyo';
}
else {
	$title	= '';
	$meta	= 'izle, izlesene, video izle, videolar, video indir, sýcak videolar, izle indir, bedava videolar, video izle, bedava izle, izle, seyret, video seyret, vidyo';
}
?>
<html>
<head>
<base href="http://www.cixvideo.com/">
<title><?=$title;?> video, <?=$title;?> izlesene, <?=$title;?> izle, <?=$title;?> videosu, <?=$title;?> videolarý, <?=$title;?> cixvideo, <?=$title;?> video izle, <?=$title;?> video seyret, <?=$title;?></title>
<META HTTP-EQUIV="Content-Language" CONTENT="tr">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<META NAME="abstract" CONTENT="<?=$meta;?>">
<META NAME="description" CONTENT="<?=$meta;?>">
<META NAME="keywords" CONTENT="<?=$meta;?>">
<link href="./img/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./img/ufo.js"></script>
<?
if($_GET['kat'] == 'sicak') {
	echo '<script language="Javascript" src="img/block.js"></script>';
}
?>
</head>
<body onLoad="">
<?
include('ads/reklam_kay.php');
?>
<div id="logobg"></div>
<div id="dis">
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr>
<td valign="top" id="blleft">
<?
@block_menu();
?>
</td>
<td valign="top" id="sagcis">
<div id="top">

<script>
// Bu javascript sonsesmuzik.com adresinden alýntýdýr.
// www.sonsesmuzik.com adresine teþekkür ederiz.
function gonder() {
	var urlyazisi  = document.getElementById("ara").value;
	window.location = "http://www.cixvideo.com/etiket/"+urlyazisi+"";
	return true;
}
</script>
Aradýðýnýz Kelimeyi Yazýn ve Videonuzu Seyredin;
<br>
<input value="<?=$aranan;?>" type="text" size="15" name="ara" id="ara" maxlength="20" style="font-size: 18px; font-family: Arial; color: #48afb8; width: 100%; border: 1px solid #48afb8; background: #ecf7f7">
<div align="center" style="width: 100%">
<input type="button" onClick="gonder();"style="font-size: 13px; font-family: Arial; color: #48afb8; font-weight: bold; border: 1px solid #48afb8; background: #ecf7f7" value="video ara"></div>
</div>

<div id="xas">
<?
@orta();
?>
</div>
</td>
</tr>
</table>
</div>
<div id="footer">
<table border="0" cellpadding="5" cellspacing="5" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
     <td width="20%">

	© cixvideo.com
	  </td>
    <td width="20%">
	</td>
    <td width="20%">
</td>
  </tr>
</table>
</div>



</body>
</html>
<?
@sql_durdur();
?>
