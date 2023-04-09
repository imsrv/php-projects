<?
 session_name('smssistemleri');
 session_start();

 // Bu oturum için geçerli deðerler
 $gecerliklasor = "elmasgunes.net";
 $kullaniciadi = "elmasgunesss";
 $sifre = "qwer4321";
 $yazilimid = "214604";
 // -->

 $ad = $_SESSION["ad"];
 $gonderen = $_SESSION["gonderen"];
 $klasor = $_SESSION["klasor"];

 If ( $klasor != $gecerliklasor ){
  header("Location: ../yetkisiz.php");
 }

 $s = $_GET["s"];
 if ( !$s ) $sayfa = "anasayfa"; else $sayfa = $s;

 include("../mesajayarlari.elm");

 $oturumid = $_SESSION["oturumid"];

 If ( !$oturumid ){
  $yetkikontroladres = "$sunucu/http/auth?user=$kullaniciadi&password=$sifre&api_id=$yazilimid";
  $kontrolediyoruz = @file($yetkikontroladres);
  $yetkikontroldurumu = split(":",$kontrolediyoruz[0]);

  if ($yetkikontroldurumu[0] == "OK") {
   $_SESSION["oturumid"] = trim($yetkikontroldurumu[1]);
   $oturumid = $_SESSION["oturumid"];
  }
  else {
   $hata = "Oturum açma sýrasýnda hata oluþtu:<br>".hata($yetkikontroldurumu[1]);
  }
 }
 else {
  $oturumkontroladres = "$sunucu/http/ping?session_id=$oturumid";
  $kontrolediyoruz = @file($oturumkontroladres);
  $oturumkontroldurumu = split(":",$kontrolediyoruz[0]);

  if ($oturumkontroldurumu[0] == "OK") {
   // hem oturum açýk, hem de oturum hala geçerli :)
  }
  else {
   $hata = "Oturum kontrolü sýrasýnda hata oluþtu:<br>".hata($oturumkontroldurumu[1]);
  }
 }
    
?>
<html>
<head>
<title>SMS Sistemleri</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="stylesheet" type="text/css" href="<? echo $dizin ?>_gerekli/style.css">
<script language="JavaScript" src="<? echo $dizin ?>_gerekli/bilgi.js"></script>
<? if ( $sayfa == "anasayfa" ) { ?><script>self.moveTo((screen.availWidth - 410) / 2,(screen.availHeight - 528) / 2);</script><? } ?>
<script language="JavaScript">
<!--
function menuleriyukle() {
  if (window.menu) return;
      window.menu_1_1 = new Menu("Bilgilendirme",113,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
      menu_1_1.addMenuItem("Kredi&nbsp;&amp;&nbsp;Mesaj ücretleri","location='?s=kredi_ucretler'");
      menu_1_1.addMenuItem("Numara&nbsp;sorgulama","location='?s=kredi_sorgulama'");
      menu_1_1.addMenuItem("Y&uuml;kleme&nbsp;ge&ccedil;miþi","location='?s=kredi_gecmis_yukleme'");
      menu_1_1.addMenuItem("Harcama&nbsp;ge&ccedil;miþi","location='?s=kredi_gecmis_harcama'");
    window.menu_1 = new Menu("Kredi&nbsp;iþlemleri",93,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
    menu_1.addMenuItem("Y&uuml;kl&uuml;&nbsp;krediniz","location='?s=kredi_yukluler'");
    menu_1.addMenuItem("Kredi&nbsp;satýn&nbsp;al","location='?s=kredi_satinal'");
    menu_1.addMenuItem("Kredi&nbsp;y&uuml;kle","location='?s=kredi_yukle'");
    menu_1.addMenuItem(menu_1_1);

      window.menu_2_1 = new Menu("Mesaj&nbsp;g&ouml;nder",78,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
      menu_2_1.addMenuItem("Tekli&nbsp;mesaj","location='?s=mesajgonder_tekli'");
      menu_2_1.addMenuItem("&Ccedil;oklu&nbsp;mesaj","location='?s=mesajgonder_coklu'");
      menu_2_1.addMenuItem("Flash&nbsp;SMS","location='?s=mesajgonder_flash'");
    window.menu_2 = new Menu("Mesaj",103,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
    menu_2.addMenuItem(menu_2_1);
    menu_2.addMenuItem("Gelen&nbsp;mesajlar","location='?s=mesajlar_gelen'");
    menu_2.addMenuItem("G&ouml;nderilen&nbsp;mesajlar","location='?s=mesajlar_gonderilen'");

    window.menu_3 = new Menu("Ayarlar",88,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
    menu_3.addMenuItem("Mesaj&nbsp;ayarlarý","location='?s=ayarlar_mesaj'");
    menu_3.addMenuItem("Giriþ&nbsp;ayarlarý","location='?s=ayarlar_giris'");

    window.menu_4 = new Menu("Yardým",103,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
    menu_4.addMenuItem("Yardým&nbsp;d&ouml;k&uuml;maný","location='?s=yardim_dokumani'");
    menu_4.addMenuItem("Yardým&nbsp;talebi","location='?s=yardim_talebi'");
    menu_4.addMenuItem("Ek&nbsp;&ouml;zellik&nbsp;isteði","location='?s=yardim_ozellikistegi'");

  window.menu = new Menu("root",93,17,"Tahoma",11,"#000000","#ffffff","#ffffff","#006699","left","middle",3,0,500,-60,11,true,true,true,0,false,true);
  menu.addMenuItem("Ana&nbsp;sayfa","location='?'");
  menu.addMenuItem(menu_1);
  menu.addMenuItem(menu_2);
  menu.addMenuItem(menu_3);
  menu.addMenuItem(menu_4);

  menu.writeMenus();
}

//-->
</script>
<script language="JavaScript1.2" src="<? echo $dizin ?>_gerekli/menu.js"></script>
</head>
<body bgcolor="#FFFFFF" style="margin: 0px; cursor:default" onMouseOver="window.defaultStatus='SMS Sistemleri'; return true" onLoad="window.defaultStatus='SMS Sistemleri'">
<script language="JavaScript1.2">menuleriyukle();</script>
<div align="center">
<TABLE align="center" border="0" cellpadding="0" cellspacing="0" width="374" height="100%">
 <TR>
  <TD width="374">
   <table border="0" cellpadding="0" cellspacing="0" width="100%" height="70">
    <tr height="50">
     <td style="padding: 10px" valign="middle">
      <img src="<? echo $dizin ?>_logo/120-50.gif" width="120" height="50" border="0" bilgi="© 2004 SMS Sistemleri">
     </td>
     <td align="right" valign="middle">
      <a href="#" name="menu" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.menu,-84,7,null,'menu');">Menü</a>  |  <a href="../cikis.php" onclick="opener.location='<? echo $dizin ?>cikis.php'">Çýkýþ yap</a><br><br>
      <font class="not"><? echo $ad ?></font>
     </td>
    </tr>
   </table>
   <hr style="border: 1px dotted #666666" size="1">
  </TD>
 </TR>
 <TR>
  <TD height="100%" align="center" valign="top">
<?php
if ( !$hata ) {
 if (file_exists("_".$sayfa.".elm")) { include("_".$sayfa.".elm"); }
 else { echo '<br><br><b>Sistemde bir hata oluþtu.<br><br>Lütfen yöneticiye durumu bildiriniz.</b>'; }
}
else{
 echo $hata;
}
?>
  </TD>
 </TR>
</TABLE>
</div>
</body>
</html>