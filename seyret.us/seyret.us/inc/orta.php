<table border="0" width="1">
<tr>
<?
$pg		= $_GET['page'];
if($pg == '') {
	$pg = 1;
}
$pg	= ($pg - 1) * 20;
$sira	= 0;
if($_GET['sayfa'] == 'kategori') {
	$sorgu	= @mysql_query("SELECT * FROM videolar WHERE k_link='$_GET[kat]' ORDER BY hit DESC LIMIT $pg,20");
}
elseif($_GET['sayfa'] == 'ara') {
	$aranan	= @htmlspecialchars($_GET['ara']);
	$aranan	= @trim($aranan);
	$aranan	= @urlduzel($aranan);
	$sorgu	= @mysql_query("SELECT * FROM videolar WHERE baslik like '%$aranan%' OR bilgi like '%$aranan%'  ORDER BY hit DESC LIMIT 50");
}
else {
	$sorgu	= @mysql_query("SELECT * FROM videolar ORDER BY rand() LIMIT $pg,20");
}

	while($veri	= @mysql_fetch_array($sorgu)) {
		$resim	= $veri['resim'];
		$baslik	= @txt_edit($veri['baslik'],18);
		$hit	= $veri['hit'];
		$kate	= @kategori_adi($veri['k_link']);
		$link	= 'izle/'.$veri['k_link'].'/'.$veri['v_link'].'/'.$veri['kod'].'.html';
?>
<td id="liste"><a href="<?=$link;?>" class="vlink">
	<div id="ic" onmouseover="this.style.backgroundColor='#FBFBFB';this.style.border='1px solid #000000'" onmouseout="this.style.backgroundColor='';this.style.border='1px solid #DDDDDD'">
		<div id="vresim"><img border="0" src="<?=$resim;?>" width="120" height="90" /></div>
		<span class="vbaslik"><?=$baslik;?></span><br />
		<span class="vhit"><u><?=$hit;?></u> kez izlendi</span><br />
		<span class="vkat"><u><?=$kate;?></u> kategorisi</span><br />
	</div></a>
</td>
<?
		$sira++;
	if($sira == 4) {
		echo '</tr><tr>';
		$sira = 0;
	}
}
?>
</tr>
<?
if($_GET['sayfa'] == 'kategori') {
	echo '<tr><td colspan="4" id="sayfax"><div id="icx">';
	@sayfala(20);
	echo '</div></td></tr>';
}
?>
</table>