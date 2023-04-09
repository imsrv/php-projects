<?
$veri	= @video_bilgi();
$kad	= @kategori_adi($veri['k_link']);
?>
<link href="./img/oylar.css" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript" SRC="./img/rating.js"></SCRIPT>
<table width="100%" border="0">
<tr>
<td valign="top">
<div id="bilg">
<b><?=$veri['baslik'];?></b>
<br>
<?
include('ads/reklam_ust.php');
?>
</div>
</td>
</tr>
<tr>
<td valign="top" width="580">
<div id="player">
<script type="text/javascript">
	var flv= '<?=$veri['flv'];?>';
	var FO = {	movie:"player.swf",width:"571",height:"300",majorversion:"7",build:"0",bgcolor:"#000000",
	flashvars:"file="+flv+"&repeat=false&autostart=true" };
	UFO.create(	FO, "player");
</script>
</div>
</td>
</tr>
<tr>
<td valign="top">





<div id="bilg">
<table width="100%" border="0">
<tr>
<td width="125" valign="top">
<div id="bilg">
<?include('ads/reklam_ic.php');?>
</div>
</td>
<td width="250" valign="top">
<div id="bilg">
<?include('ads/reklam_ic_alt.php');?>
<br>
<b>Kategori	: </b><br>
<a class="ktgr" href="./kategori/<?=$veri['k_link'];?>.html"><u><?=$kad;?></u></a> kategorisine baðlý.<br>
<b>Ýzlenme	: </b><br>
bu video <u><?=$veri['hit']?></u> kere izlendi.<br>
<b>Gönderenin Yorumu : </b><br>
<?
if($veri['bilgi'] == '') {
	echo 'Açýklama Yok';
	$etiket = tag_yap($veri['baslik']);
} else {
	echo $veri['bilgi'].'<br>';
	$etiket = tag_yap($veri['bilgi']);
}
$emb	= '<iframe src="http://www.cixvideo.com/wm/'.$veri['k_link'].'/'.$veri['v_link'].'/'.$veri['kod'].'>.html" name="frame" scrolling="No" width="400" height="300" marginwidth=0 marginheight=0 frameborder="No"></iframe>';
?>
</div>
</td>
</tr>
</table>




</td>
</tr>
<tr>
<td valign="top">
<div id="bilg">
<b>Sayfa Linki :</b><br>
<input onfocus="this.select();" name="lnk" type="text" style="width: 570;color: #555555; font-size: 10px; font-family: Verdana; border: 1px solid #DDDDDD;"
	value="http://www.izleonu.com/izle/<?=$veri['k_link'];?>/<?=$veri['v_link'];?>/<?=$veri['kod'];?>.html"><!--<br>
<b>Embed Kodu :</b><br>
<input onfocus="this.select();" name="emb" type="text" style="width: 570;color: #555555; font-size: 10px; font-family: Verdana; border: 1px solid #DDDDDD;"
	value="<?=htmlspecialchars($emb);?>">-->
</div>
</td>
</tr>
<tr>
<td valign="top">
<div id="bilg">
<table border="0" width="98%"><tr>
<td width="10%"><img src="img/etiketler.gif"></td>
<td width="90%">
<?
echo ' <span class="etiket">'.$etiket.'</span>';
@mysql_query("UPDATE videolar SET hit=(hit+1) WHERE id='$veri[id]'");
?>
</td>
</tr></table>
</div>
</td>
</tr>
</table>
