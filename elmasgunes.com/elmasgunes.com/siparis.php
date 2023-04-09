<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
$urun = ucwords($_POST["urun"]);
$paket = ucwords($_POST["paket"]);
$siparis = $_POST["siparis"];
if ( (!$urun) or (!$paket) ) header("Location:index.php");
function kontrol($isim, $deger)
{
 if ( !$isim )
 {
  htmlspecialchars($isim);
  echo "<center><font color=red><b>$deger</b> alan�n� bo� b�rakamazs�n�z!</font><br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
  if ( !@include("sayfa_sonu.php") ) require("hata.php");
  exit();
 }
}
if ( !@include("sayfa_basi.php") ){ require("hata.php"); exit(); }

if ( !$siparis )
{
 if ( $urun == "Hosting" )
 {

  if($paket == "Kucuk") $paket = "K���k";
  if($paket == "Midi") $paket = "Midi";
  if($paket == "Buyuk") $paket = "B�y�k";
  if($paket == "Pro") $paket = "Pro";

  if ($paket == "ozel" )
  {
  $web_alani = strip_tags($_POST["web_alani"]);
  $trafik = strip_tags($_POST["trafik"]);
  $pop3_mail = strip_tags($_POST["pop3_mail"]);
  $subdomain = strip_tags($_POST["subdomain"]);
  $domain_barindirma = strip_tags($_POST["domain_barindirma"]);
  $mail_listesi = strip_tags($_POST["mail_listesi"]);
  $mysql = strip_tags($_POST["mysql"]);
?>
<table border="0" cellpadding="0" cellspacing="0">
 <tr height="92" valign="middle">
  <td width="186" valign="top"><img src="images/baslik_siparis.gif" width="186" height="9" border="0"><br><br><div align="justify">&nbsp;&nbsp;&nbsp;G�nderece�iniz sipari�e en k�sa s�rede e-mail yoluyla cevap verilecektir.</div></td>
  <td width="9" background="images/tasarim_ara_dikey.gif"></td>
  <td width="381" valign="top"><b>Alaca��n�z �r�n:</b> Web Hosting | E-Host �zel<br><br><br><b>Ki�isel Bilgileriniz:</b><br>
  <form action="siparis.php" method="POST">
   <table border="0" cellpadding="1" cellspacing="2">
    <tr>
     <td align="left" valign="middle">Ad: </td><td><input type="text" name="ad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Soyad: </td><td><input type="text" name="soyad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Telefon: </td><td><input type="text" name="telefon" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Adres: </td><td><textarea name="adres" cols="32" rows="5" class="form"></textarea></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Semt(�l�e)/�ehir: </td><td><input type="text" name="sehir" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">E-Mail: </td><td><input type="text" name="mail" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">�deme T�r�: </td><td><input type="radio" checked name="odeme" value="Ayl�k">Ayl�k&nbsp;&nbsp;<input type="radio" name="odeme" value="Y�ll�k">Y�ll�k (Alan Ad� �cretsiz)</td>
    </tr>
    <tr>
     <td align="left" valign="top">Eklemek<br> �stedikleriniz: </td><td><textarea name="istek" cols="32" rows="5" class="form"></textarea></td>
    </tr>
   </table>
   <input type="hidden" name="urun" value="<?php echo "$urun" ?>">
   <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
   <input type="hidden" name="web_alani" value="<?php echo "$web_alani" ?>">
   <input type="hidden" name="trafik" value="<?php echo "$trafik" ?>">
   <input type="hidden" name="pop3_mail" value="<?php echo "$pop3_mail" ?>">
   <input type="hidden" name="subdomain" value="<?php echo "$subdomain" ?>">
   <input type="hidden" name="domain_barindirma" value="<?php echo "$domain_barindirma" ?>">
   <input type="hidden" name="mail_listesi" value="<?php echo "$mail_listesi" ?>">
   <input type="hidden" name="mysql" value="<?php echo "$mysql" ?>">
   <center><input type="submit" value="G�nder" name="siparis" class="buton">&nbsp;&nbsp;<input type="reset" value="Temizle" class="buton"></center>
  </form>
  </td>
 </tr>
</table>
<?php
  }
  else
  {
?>
<table border="0" cellpadding="0" cellspacing="0">
 <tr height="92" valign="middle">
  <td width="186" valign="top"><img src="images/baslik_siparis.gif" width="186" height="9" border="0"><br><br><div align="justify">&nbsp;&nbsp;&nbsp;G�nderece�iniz sipari�e en k�sa s�rede e-mail yoluyla cevap verilecektir.</div></td>
  <td width="9" background="images/tasarim_ara_dikey.gif"></td>
  <td width="381" valign="top"><b>Alaca��n�z �r�n:</b> Web Hosting | E-Host <?php echo "$paket" ?><br><br><br><b>Ki�isel Bilgileriniz:</b><br>
  <form action="siparis.php" method="POST">
   <table border="0" cellpadding="1" cellspacing="2">
    <tr>
     <td align="left" valign="middle">Ad: </td><td><input type="text" name="ad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Soyad: </td><td><input type="text" name="soyad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Telefon: </td><td><input type="text" name="telefon" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Adres: </td><td><textarea name="adres" cols="32" rows="5" class="form"></textarea></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Semt(�l�e)/�ehir: </td><td><input type="text" name="sehir" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">E-Mail: </td><td><input type="text" name="mail" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">�deme T�r�: </td><td><input type="radio" checked name="odeme" value="Ayl�k">Ayl�k&nbsp;&nbsp;<input type="radio" name="odeme" value="Y�ll�k">Y�ll�k (Alan Ad� �cretsiz)</td>
    </tr>
    <tr>
     <td align="left" valign="top">Eklemek<br>&nbsp;&nbsp;&nbsp;�stedikleriniz: </td><td><textarea name="istek" cols="32" rows="5" class="form"></textarea></td>
    </tr>
   </table>
   <input type="hidden" name="urun" value="<?php echo "$urun" ?>">
   <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
   <center><input type="submit" value="G�nder" name="siparis" class="buton">&nbsp;&nbsp;<input type="reset" value="Temizle" class="buton"></center>
  </form>
  </td>
 </tr>
</table>
<?php
  }
 }
 if( $urun == "Design" )
 {
  if( $paket == "Kisisel" )
  {
?>
<table border="0" cellpadding="0" cellspacing="0">
 <tr height="92" valign="middle">
  <td width="186" valign="top"><img src="images/baslik_siparis.gif" width="186" height="9" border="0"><br><br><div align="justify">&nbsp;&nbsp;&nbsp;G�nderece�iniz sipari�e en k�sa s�rede e-mail yoluyla cevap verilecektir.</div></td>
  <td width="9" background="images/tasarim_ara_dikey.gif"></td>
  <td width="381" valign="top"><b>Alaca��n�z �r�n:</b> Web Hosting | E-Design Ki�isel<br><br><br><b>Ki�isel Bilgileriniz:</b><br>
  <form action="siparis.php" method="POST">
   <table border="0" cellpadding="1" cellspacing="2">
    <tr>
     <td align="left" valign="middle">Ad: </td><td><input type="text" name="ad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Soyad: </td><td><input type="text" name="soyad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Telefon: </td><td><input type="text" name="telefon" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Adres: </td><td><textarea name="adres" cols="32" rows="5" class="form"></textarea></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Semt(�l�e)/�ehir: </td><td><input type="text" name="sehir" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">E-Mail: </td><td><input type="text" name="mail" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Eklemek<br> �stedikleriniz: </td><td><textarea name="istek" cols="32" rows="5" class="form"></textarea></td>
    </tr>
   </table>
   <input type="hidden" name="urun" value="<?php echo "$urun" ?>">
   <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
   <center><input type="submit" value="G�nder" name="siparis" class="buton">&nbsp;&nbsp;<input type="reset" value="Temizle" class="buton"></center>
  </form>
  </td>
 </tr>
</table>
<?php
   }
   else
   {
?>
<table border="0" cellpadding="0" cellspacing="0">
 <tr height="92" valign="middle">
  <td width="186" valign="top"><img src="images/baslik_siparis.gif" width="186" height="9" border="0"><br><br><div align="justify">&nbsp;&nbsp;&nbsp;G�nderece�iniz sipari�e en k�sa s�rede e-mail yoluyla cevap verilecektir.</div></td>
  <td width="9" background="images/tasarim_ara_dikey.gif"></td>
  <td width="381" valign="top"><b>Alaca��n�z �r�n:</b> Web Hosting | E-Design <?php echo "$paket" ?><br><br><br><b>Bilgileriniz:</b><br>
  <form action="siparis.php" method="POST">
   <table border="0" cellpadding="1" cellspacing="2">
    <tr>
     <td align="left" valign="middle">�irket Ad�: </td><td><input type="text" name="sirket" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Ad: </td><td><input type="text" name="ad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Soyad: </td><td><input type="text" name="soyad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Telefon: </td><td><input type="text" name="telefon" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Adres: </td><td><textarea name="adres" cols="32" rows="5" class="form"></textarea></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Semt(�l�e)/�ehir: </td><td><input type="text" name="sehir" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">E-Mail: </td><td><input type="text" name="mail" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Eklemek<br> �stedikleriniz: </td><td><textarea name="istek" cols="32" rows="5" class="form"></textarea></td>
    </tr>
   </table>
   <input type="hidden" name="urun" value="<?php echo "$urun" ?>">
   <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
   <center><input type="submit" value="G�nder" name="siparis" class="buton">&nbsp;&nbsp;<input type="reset" value="Temizle" class="buton"></center>
  </form>
  </td>
 </tr>
</table>
<?php
  }
 }
 if ( $urun == "Alan Ad�" )
 {
 $domain_name = $_POST["domain"];
?>


<table border="0" cellpadding="0" cellspacing="0">
 <tr height="92" valign="middle">
  <td width="186" valign="top"><img src="images/baslik_siparis.gif" width="186" height="9" border="0"><br><br><div align="justify">&nbsp;&nbsp;&nbsp;G�nderece�iniz sipari�e en k�sa s�rede e-mail yoluyla cevap verilecektir.</div></td>
  <td width="9" background="images/tasarim_ara_dikey.gif"></td>
  <td width="381" valign="top"><b>Alaca��n�z �r�n:</b> Alan Ad� | www.<?php echo "$domain_name" ?><br><br><br><b>Bilgileriniz:</b><br>
  <form action="siparis.php" method="POST">
   <table border="0" cellpadding="1" cellspacing="2">
    <tr>
     <td align="left" valign="middle">Ad: </td><td><input type="text" name="ad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Soyad: </td><td><input type="text" name="soyad" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Telefon: </td><td><input type="text" name="telefon" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Adres: </td><td><textarea name="adres" cols="32" rows="5" class="form"></textarea></td>
    </tr>
    <tr>
     <td align="left" valign="middle">Semt(�l�e)/�ehir: </td><td><input type="text" name="sehir" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="middle">E-Mail: </td><td><input type="text" name="mail" size="32" class="form"></td>
    </tr>
    <tr>
     <td align="left" valign="top">Eklemek<br>&nbsp;&nbsp;&nbsp;�stedikleriniz: </td><td><textarea name="istek" cols="32" rows="5" class="form"></textarea></td>
    </tr>
   </table>
   <input type="hidden" name="urun" value="<?php echo "$urun" ?>">
   <input type="hidden" name="paket" value="<?php echo "$domain_name" ?>">
   <center><input type="submit" value="G�nder" name="siparis" class="buton">&nbsp;&nbsp;<input type="reset" value="Temizle" class="buton"></center>
  </form>
  </td>
 </tr>
</table>

<?php
 }
}

if ( $siparis )
{
$sirket = $_POST["sirket"];
$ad = $_POST["ad"];
$soyad = $_POST["soyad"];
$telefon = $_POST["telefon"];
$adres = $_POST["adres"];
$sehir = $_POST["sehir"];
$mail = $_POST["mail"];
$odeme = $_POST["odeme"];
$istek = $_POST["istek"];
if( $sirket ) $sirket = "<br>�irket Ad�: $sirket";
kontrol($ad, "Ad");
kontrol($soyad, "Soyad");
kontrol($telefon, "Telefon");
kontrol($adres, "Adres");
kontrol($sehir, "Semt(�l�e)/�ehir");
 if ( !(substr_count($telefon, "0") > 0) )
 {
  echo "<center><font color=red><b>Telefon</b> Yanl��! L�tfen Tekrar Giriniz.</font><br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
  if ( !@include("sayfa_sonu.php") ) require("hata.php");
  exit();
 }
 if( !(substr_count($mail,"@") == 1) or !(substr_count($mail,".") > 0) )
 {
  echo "<center><font color=red><b>E-Mail Adresi</b> Yanl��! L�tfen Tekrar Giriniz.</font><br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
  if ( !@include("sayfa_sonu.php") ) require("hata.php");
  exit();
 }
if( $odeme ) $odeme = "<br>�deme T�r�: $odeme";
$konu = "$urun | ". ucwords($paket) ." sipari�i";
 if ( $urun == "Hosting" && $paket == "Ozel" )
 {
  $web_alani = $_POST["web_alani"];
  $trafik = $_POST["trafik"];
  $pop3_mail = $_POST["pop3_mail"];
  $subdomain = $_POST["subdomain"];
  $domain_barindirma = $_POST["domain_barindirma"];
  $mail_listesi = $_POST["mail_listesi"];
  $mysql = $_POST["mysql"];
  $mesaj = "$urun | ". ucwords($paket) ." sipari�i<br><br><font style='font-family:Verdana;font-size:9pt;color:#666666;'><b>Sipari� Veren:</b><br>Ad: $ad<br>Soyad: $soyad<br>Telefon: $telefon<br>Adres: $adres<br>�ehir: $sehir<br>E-mail: $mail<br>�deme T�r�: $odeme<br>�stek: $istek<br><br><br><b>�zellikler:</b><br>$web_alani<br>$trafik<br>$pop3_mail<br>$subdomain<br>$domain_barindirma<br>$mail_listesi<br>$mysql<br></font>";
 }
 else if ( $urun == "Alan Ad�" )
 {
 $konu = "$urun | ". strtolower($paket) ." sipari�i";
 $mesaj = "$urun | ". strtolower($paket) ." sipari�i<br><br>Sipari� Veren:<br>Ad: $ad<br>Soyad: $soyad<br>Telefon: $telefon<br>Adres: $adres<br>�ehir: $sehir<br>E-mail: $mail <br>�stek: $istek<br>";
 }
else $mesaj = "$urun | ". ucwords($paket) ." sipari�i<br><br>Sipari� Veren:$sirket<br>Ad: $ad<br>Soyad: $soyad<br>Telefon: $telefon<br>Adres: $adres<br>�ehir: $sehir<br>E-mail: $mail $odeme<br>�stek: $istek<br>";
if (!@mail("siparis@elmasgunes.net",$konu,$mesaj,"MIME-Version:1.0\nContent-Type:text/html;charset=iso-8859-9\n"))  echo "<center><br><font color=red><b>HATA!</b> </font>�u Anda Sipari�iniz G�nderilemiyor. L�tfen Telefon ile Bildirmeyi Deneyiniz...<br><br>( Telefon : <b>0 535 71 71 101</b> )<br></center>";
else echo "<center><font color=red><b>�ste�iniz �letilmi�tir!</b><br> �ste�inize En K�sa S�rede Cevap Verilecektir.</font></center>";
}

if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); }
?>