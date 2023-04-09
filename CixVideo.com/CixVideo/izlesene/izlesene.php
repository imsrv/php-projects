<?
include('function.php');
$veri_id		= $_GET['id'] + 1;
$sonuc			= get_veri($veri_id);
$video_baslik	= trim($sonuc[0][1]);
$video_link		= trim($sonuc[0][2]);
$kategori_link	= trim($sonuc[0][4]);
$kategori_ad	= trim($sonuc[0][5]);
$flv_uzanti		= trim($sonuc[0][7]);
$video_bilgi	= trim($sonuc[0][9]);
$video_ad_link	= trim($sonuc[0][13]);
$resim_alt		= substr($video_link,0,-3);
if($resim_alt == '') {
	$resim_alt = 0;
}
$video_resim	= 'http://img.izlesene.com/data/videoshots/'.$resim_alt.'/'.$video_link.'-11.jpg';
echo '<meta http-equiv="refresh" content="0; URL=izlesene.php?id='.$veri_id.'">';
echo '<style>
body {
	background-color: #FFFFFF;
	color	:#333333;
	margin: 0px;
}
</style>';
echo '<center>';
echo '<div style="padding: 10px; background-color: #FFFFFF; font-size: 60px; font-family: Arial; color:#D8000000;">'.$veri_id.'</div><br><br>';
if($video_baslik != '' 
	AND $video_link != '' 
	AND $kategori_link != '' 
	AND $kategori_ad != '' 
	AND $flv_uzanti != '' 
	AND $video_ad_link != '')
{
	echo "<pre>
$resim_alt
$video_resim
$video_baslik
$video_link
$kategori_link
$kategori_ad
$flv_uzanti
$video_bilgi
$video_ad_link</pre>";

	@baglan();
	@kategori($kategori_link,$kategori_ad);
	@video($video_baslik,$kategori_link,$video_ad_link,$video_bilgi,$video_link,$flv_uzanti,$video_resim);
	@durdur();
} else {
	echo 'Boþ Geç';
}
echo '</center>';
?>

