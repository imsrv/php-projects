<?
function sql_baglan() {
	@mysql_connect("localhost","cixvideo","123456");
	@mysql_select_db("cixvideo");
}
function sql_durdur() {
	@mysql_close();
}
function txt_edit($q,$s) {
	$veri	= @strip_tags($q);
	$veri	= @substr($veri,0,$s);
	$veri	= @strtolower($veri);
	$bul	= array('ý','ç','þ','ð','ü','ö','Ý','Ç','Þ','Ð','Ü','Ö');
	$yaz	= array('i','c','s','g','u','o','i','c','s','g','u','o');
	$veri	= @str_replace($bul,$yaz,$veri);
	$veri	= @strtolower($veri);
	return($veri);
}
function urlduzel($q) {
	$bul	= array('Ä±','Ã§','ÅŸ','ÄŸ','Ã¼','Ã¶','Ä°','Ã‡','Åž','Äž','Ãœ','Ã');
	$yaz	= array('ý','ç','þ','ð','ü','ö','Ý','Ç','Þ','Ð','Ü','Ö');
	$son	= @str_replace($bul,$yaz,$q);
	return($son);
}
function kategori_adi($q) {
	$sorgu	= @mysql_query("SELECT * FROM kategoriler WHERE link='$q' LIMIT 1");
	$veri	= @mysql_fetch_array($sorgu);
	$kat	= $veri['ad'];
	return($kat);
}
function block_menu() {
	echo '<a href="./" class="ktgr"><b>Ana Sayfa</b></a> - <br>'."\n";
	echo '<a href="./izle/izlesene.html" class="ktgr"><b>Þansýmý Dene</b></a> - <br><br>'."\n";
	echo '<span class="kbas">Kategoriler</span> - <br>'."\n";
	$sorgu	= @mysql_query("SELECT * FROM kategoriler ORDER BY ad ASC LIMIT 20");
	while($veri	= @mysql_fetch_array($sorgu)) {
		if($_GET['kat'] == $veri['link']) {
			$class	= 'ktgr1';
		} else {
			$class	= 'ktgr';
		}
		echo '<a href="./kategori/'.$veri['link'].'.html" class="'.$class.'">'.$veri['ad'].'</a> - <br>'."\n";
	}
	echo '<br><span class="kbas">Linkler</span> - <br>'."\n";
	echo '<a href="http://www.fixdiyet.com" target="_blank" class="ktgr">Diyet</a> - <br>'."\n";
	echo '<a href="http://www.board.gen.tr" target="_blank" class="ktgr">Forum</a> - <br>'."\n";
	echo '<a href="http://www.limitsiz.net" target="_blank" class="ktgr">Güzel Sözler</a> - <br>'."\n";
	
	echo '<br><a href="http://www.limitsiz.net/iletisim.php" target="_blank" class="ktgr">Ýletiþim</a> - <br>'."\n";
}
function orta() {
	if($_GET['sayfa'] == 'kategori') {
		@index();
	}
	elseif($_GET['sayfa'] == 'izle') {
		@izle();
	}
	else {
		@index();
	}
}
function index() {
	include('inc/orta.php');
}
function izle() {
	include('inc/izle.php');
}
function video_bilgi() {
	$kate	= $_GET['kat'];
	$vidi	= $_GET['video'];
	$kodu	= $_GET['kod'];
	if($kodu == 'salla') {
		$sorgu	= @mysql_query("SELECT * FROM videolar ORDER BY rand() LIMIT 1");
	} else {
		$sorgu	= @mysql_query("SELECT * FROM videolar WHERE k_link='$kate' AND v_link='$vidi' AND kod='$kodu' LIMIT 1");
	}
	$veri	= @mysql_fetch_array($sorgu);
	return($veri);
}
function tag_yap($q) {
	$veri	= @strip_tags($q);
	$bul	= array('.','!','\'','"','^','#','$','+','½','%','&','{','/','[','(',')',']','}','=','?','*','\\','-','_','|','@','€','¨','~','æ','ß','é','´','£',':',',',';','`','“','”','•');
	$yaz	= '';
	$veri	= @str_replace($bul,$yaz,$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @str_replace("  "," ",$veri);
	$veri	= @explode(" ",$veri);
	$sayi	= @count($veri) - 1;
	$son	= '';
	for($x = 0; $x <= $sayi; ++$x) {
		$kelime	= @txt_edit($veri[$x],15);
		$son =  $son.'<a class="etiket" href="etiket/'.$veri[$x].'">'.$kelime.'</a> ';
	}
	return($son);
}
function sayfala($lt) {
	$liste	= $_GET['kat'];
	$sayfa	= $_GET['page'];
	if($sayfa == '') {
		$sayfa = 1;
	}
	$sorgu	= @mysql_query("SELECT id,k_link FROM videolar WHERE k_link='$liste'");
	$toplam	= @mysql_num_rows($sorgu);
	$toplam	= @ceil(($toplam / $lt));
	$son	= $toplam;
	if($sayfa <= 5) {
		$sira	= 5;
		if($sira > $son) {
			$sira	= $son - 1;
		}
		for($x = 0; $x <= $sira; ++$x) {
			$s	= $x + 1;
			if($s == $sayfa) {
				echo '[ '.$s.' ] ';
			} else {
				echo '[ <a class="sayfala" href="kategori/'.$liste.'/'.$s.'.htm">'.$s.'</a> ] ';
			}
		}
		if($toplam >= 6) {
			echo ' .... [ <a class="sayfala1" href="kategori/'.$liste.'/'.$son.'.htm">'.$son.'</a> ]';
		}
	} else {
		echo '[ <a class="sayfala1" href="kategori/'.$liste.'/1.htm">1</a> ] ';
		echo '[ <a class="sayfala1" href="kategori/'.$liste.'/2.htm">2</a> ] ';
		echo '[ <a class="sayfala1" href="kategori/'.$liste.'/3.htm">3</a> ] .... ';
		$b		= $sayfa - 4;
		$t		= $b + 5;
		$v		= $toplam - 4;
		for($x = $b; $x <= $t; ++$x) {
			$s	= $x + 1;
			if($s <= $son) {
				if($s == $sayfa) {
					echo '[ '.$s.' ] ';
				} else {
					echo '[ <a class="sayfala" href="kategori/'.$liste.'/'.$s.'.htm">'.$s.'</a> ] ';
				}
			}
		}
		if($sayfa <= $v) {
			echo ' .... [ <a class="sayfala1" href="kategori/'.$liste.'/'.$son.'.htm">'.$son.'</a> ]';
		}
	}
}
?>
