<?
function baglan() {
	@mysql_connect("localhost","cixvideo","123456");
	@mysql_select_db("cixvideo");
}
function durdur() {
	@mysql_close();
}
function get_file($url) {
	$kaynak	= @file_get_contents($url);
	return($kaynak);
}
function get_veri($id) {
	$kaynak	= @get_file('http://www.izlesene.com/video/xx/'.$id.'/xx');
	$verim	= '/<b style="font-size:18px; font-family:Arial">(.*?)<\/b> <nobr><script language=javascript>var oyv_(.*?)=0;<\/script>(.*?)<a href="\/video\/(.*?)">(.*?)<\/a> kategorisi(.*?)<param name="movie" value="\/player.swf\?izle=(.*?)" \/>(.*?)<div style="line-height:16px; font-size:12px; margin-top:20px; margin-bottom:20px;">
			<b>Gönderenin yorumu:<\/b><br>
			(.*?)			<\/div>(.*)<input type="text" value="http:\/\/www.izlesene.com\/video\/(.*?)\/(.*?)\/(.*?)" style="width: 400px; margin-top:6px;" onClick/is';
	@preg_match_all($verim, $kaynak, $sonuc, PREG_SET_ORDER);
	return($sonuc);
}

function kategori($url,$ad) {
	$kontrol	= @kategori_kontrol($url);
	if($kontrol == 0) {
		@kategori_ekle($url,$ad);
	}
}
function kategori_kontrol($url) {
	$sorgu	= @mysql_query("SELECT * FROM kategoriler WHERE link='$url' LIMIT 1");
	$sayim	= @mysql_num_rows($sorgu);
	return($sayim);
}
function kategori_ekle($url,$ad) {
	@mysql_query("INSERT INTO kategoriler VALUES ('','$url','$ad')");
}
function video($baslik,$k_link,$v_link,$bilgi,$kod,$flv,$resim) {
	$kontrol	= @video_kontrol($kod);
	if($kontrol == 0) {
		@video_ekle($baslik,$k_link,$v_link,$bilgi,$kod,$flv,$resim);
	}
}
function video_kontrol($kod) {
	$sorgu	= @mysql_query("SELECT * FROM videolar WHERE kod='$kod' LIMIT 1");
	$sayim	= @mysql_num_rows($sorgu);
	return($sayim);
}
function video_ekle($baslik,$k_link,$v_link,$bilgi,$kod,$flv,$resim) {
	$hit	= rand(100,5000);
	@mysql_query("INSERT INTO videolar VALUES ('','$k_link','$v_link','$kod','$baslik','$resim','$bilgi','$flv','$hit')");
}
?>
