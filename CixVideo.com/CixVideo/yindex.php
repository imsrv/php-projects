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
<base href="http://www.Video-izle.com/">
<title><?=$title;?> video, <?=$title;?> izlesene, <?=$title;?> izle, <?=$title;?> videosu, <?=$title;?> videolarý, <?=$title;?> izlesene, <?=$title;?> video izle, <?=$title;?> video seyret, <?=$title;?> vidyo izle, izlesene.com, izlesene</title>
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
<body>
<table width="100%" border="0">
  <tr>
    <td width="93%"><?
include('ads/reklam_kay.php');
?>
      <div id="logobg"></div>
      <div id="dis">
        <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" id="blleft"><?
@block_menu();
?>
            </td>
            <td valign="top" id="sagcis"><div id="top">
                <script>
// Bu javascript sonsesmuzik.com adresinden alýntýdýr.
// www.sonsesmuzik.com adresine teþekkür ederiz.
function gonder() {
	var urlyazisi  = document.getElementById("ara").value;
	window.location = "http://www.Video-izle.com/etiket/"+urlyazisi+"";
	return true;
}
      </script>
              Aradýðýnýz Kelimeyi Yazýn ve Videonuzu Seyredin; <br>
              <input value="<?=$aranan;?>" type="text" size="15" name="ara" id="ara" maxlength="20" style="font-size: 18px; font-family: Arial; color: #48afb8; width: 100%; border: 1px solid #48afb8; background: #ecf7f7">
              <div align="center" style="width: 100%">
                <input name="button" type="button"style="font-size: 13px; font-family: Arial; color: #48afb8; font-weight: bold; border: 1px solid #48afb8; background: #ecf7f7" onClick="gonder();" value="video ara">
                <br>
                <a href="http://www.kirmizishop.com" target="_blank"><img src="468x60_1.gif" alt="kirmizi" width="468" height="60" border="0"></a></div>
            </div>
                <div id="xas">
                  <?
@orta();
?>
              </div></td>
          </tr>
        </table>
      </div>
      <div id="footer"> © Video-izle.com<br>
        Soru ve sorunlarýnýz için hayalperestruh@hotmail.com
        <div id="eXTReMe"><a href="http://extremetracking.com/open?login=vdzlcm"> <img src="http://t1.extreme-dm.com/i.gif" style="border: 0;"
height="38" width="41" id="EXim" alt="eXTReMe Tracker" /></a>
        <script type="text/javascript"><!--
var EXlogin='vdzlcm' // Login
var EXvsrv='s9' // VServer
EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
EXb=EXs.colorDepth:EXb=EXs.pixelDepth;
navigator.javaEnabled()==1?EXjv="y":EXjv="n";
EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
EXd.write("<img src=http://e0.extreme-dm.com",
"/"+EXvsrv+".g?login="+EXlogin+"&amp;",
"jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
"l="+escape(EXd.referrer)+" height=1 width=1>");//-->
    </script>
          <noscript>
            <div id="neXTReMe"><img height="1" width="1" alt=""
src="http://e0.extreme-dm.com/s9.g?login=vdzlcm&amp;j=n&amp;jv=n" /> </div>
          </noscript>
        </div>
        <!-- Prorehber.Com Toplist Kodu Baþlangýcý-->
    <script language="javascript"> var  wuser="videoizle";</script>
    <script language="javascript" src="http://www.prorehber.com/banner.js">
  </script>
    <!-- Prorehber.Com Toplist Kodu Sonu-->
    <!-- Webservis Kod Baslangici -->
    <!-- Webservis Reklam Baslangici-->
    <span id=wbsbn><a href="http://www.webservis.com.tr/"  target="_blank"> <img src=http://logo.webservis.gen.tr/logo/v.gif alt="Hosting Hizmetleri" border="0"> </a>
    <!-- Webservis Reklam Sonu -->
    <div style="DISPLAY: none"> <a href="http://www.video-izle.com/link/links.php">Exchange Links</a><a href="http://www.video-izle.com/link/1.php">Resources</a><a href="http://www.video-izle.com/link/2.php">Resources</a><a href="http://www.video-izle.com/link/3.php">Resources</a><a href="http://www.video-izle.com/link/4.php">Resources</a><a href="http://www.video-izle.com/link/5.php">Resources</a><a href="http://www.video-izle.com/link/6.php">Resources</a><a href="http://www.video-izle.com/link/7.php">Resources</a><a href="http://www.video-izle.com/link/8.php">Resources</a><a href="http://www.video-izle.com/link/9.php">Resources</a><a href="http://www.video-izle.com/link/10.php">Resources</a><a href="http://www.video-izle.com/link/links.php">Exchange Links</a> </div>
    </div></td>
    <td width="7%"><p>
    <script src="http://affy.kalbimde.com/AC_RunActiveContent.js" language="javascript"></script>
<script type="text/javascript">
<!--
// Show Banner.
AC_FL_RunContent
(
    'width', '120',
    'height', '600',
    'src', 'http://affy.kalbimde.com/banners/120_600_1',
    'FlashVars', 'color=FF0000&link=http://affy.sevgilimol.com/?ref=videoizle'
);
//-->
</script></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </td>
  </tr>
</table>
</body>
</html>
<?
@sql_durdur();
?>
