<?php
     /* Kontrol */
   function kontrol($isim, $deger, $deger2)
   {
    if ( !$isim )
    {
         htmlspecialchars($isim);
         echo "<center><font color=red>L�tfen <b>$deger</b> alan�na de�er giriniz!</font><br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
     if ( !@include("sayfa_sonu.php") ) require("hata.php");
     exit();
    }
    else
    {
    if ( $isim == "-" ) return "$deger <b>�stenmiyor</b>";
    if ( $isim == "*" ) return "<b>S�n�rs�z</b> $deger";
    else return "<b>$isim</b> $deger2";
    }
   }
    /* Gelen Bilgilerin Al�nmas� */
  $tiklama = $_GET["menu"];
  $paket = $_GET["paket"];
  if ( !$paket ) $paket = "ana";
  if ( !@include("sayfa_basi.php") )
  {
   require("hata.php");
    exit();
  }
    /* Paketlerin Sayfalar� */
  if( $paket == "ana" )
  {
?>

<style>
.sol {
color:#333333;padding:3px; border-bottom: 1px solid #666666;
border-left: 1px solid #000000;
}
.sol-alt {
color:#333333;padding:3px;
border-left: 1px solid #000000;border-bottom: 1px solid #9F9F9F;
}
.sol-au {
color:#333333;padding:3px;
border-left: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #9F9F9F;
}
.sol-sag {
color:#333333;padding:3px; border-bottom: 1px solid #666666;
border-right: 1px solid #000000;border-left:1px solid #000000;
}
</style>

<table cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr valign="top">
                <td align="left" width="178" height="20" valign="middle" style="background-color:#FFFFFF; border-bottom: 1px solid #9F9F9F"><b>�zellikler</b></td>
                <td align="center" width="90" class="sol-au" style="background-color:#FF9900;color:#FFFFFF"><a href="hosting.php?menu=hosting&paket=kucuk" style="color: #FFFFFF; font-weight: bold">E-Host K���k</a></td>
                <td align="center" width="90" class="sol-au" style="background-color:#FF9900;color:#FFFFFF"><a href="hosting.php?menu=hosting&paket=midi" style="color: #FFFFFF; font-weight: bold">E-Host Midi</a></td>
                <td align="center" width="90" class="sol-au" style="background-color:#FF9900;color:#FFFFFF"><a href="hosting.php?menu=hosting&paket=buyuk" style="color: #FFFFFF; font-weight: bold">E-Host B�y�k</a></td>
                <td align="center" width="90" style="background-color:#FF9900;color:#FFFFFF;border-right: 1px solid #000000;border-left:1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #9F9F9F;padding:3px; "><a href="hosting.php?menu=hosting&paket=pro" style="color: #FFFFFF; font-weight: bold">E-Host Pro</a></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">Web Alan�</td>
                <td align="center" class="sol"><b>25 MB</b></td>
                <td align="center" class="sol"><b>50 MB</b></td>
                <td align="center" class="sol"><b>150 MB</b></td>
                <td align="center" class="sol-sag"><b>500 MB</b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">Ayl�k Trafik</td>
                <td align="center" class="sol"><b>1 GB</b></td>
                <td align="center" class="sol"><b>2 GB</b></td>
                <td align="center" class="sol"><b>4 GB</b></td>
                <td align="center" class="sol-sag"><b>10 GB</b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">POP3 Mail</td>
                <td align="center" class="sol"><b>25</b></td>
                <td align="center" class="sol"><b>50</b></td>
                <td align="center" class="sol"><b>S�n�rs�z</b></td>
                <td align="center" class="sol-sag"><b>S�n�rs�z</b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">Subdomain</td>
                <td align="center" class="sol"><b>5</b></td>
                <td align="center" class="sol"><b>10</b></td>
                <td align="center" class="sol"><b>S�n�rs�z</b></td>
                <td align="center" class="sol-sag"><b>S�n�rs�z</b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">Domain Bar�nd�rma</td>
                <td align="center" class="sol"><b>1</b></td>
                <td align="center" class="sol"><b>2</b></td>
                <td align="center" class="sol"><b>5</b></td>
                <td align="center" class="sol-sag"><b>10</b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">E-Mail Listesi</td>
                <td align="center" class="sol"><b>1</b></td>
                <td align="center" class="sol"><b>5</b></td>
                <td align="center" class="sol"><b>S�n�rs�z</b></td>
                <td align="center" class="sol-sag"><b>S�n�rs�z</b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">POP3 ve Web Eri�imi</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">T�rk�e Aray�zl� WebMail</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">Catch-All Hesab�</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">E-Mail Y�nlendirme</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">Otomatik Cevaplay�c�lar</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">E-Mail Filtreleme</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">MySQL Veritaban�</td>
                <td align="center" class="sol"><b>1</b></td>
                <td align="center" class="sol"><b>5</b></td>
                <td align="center" class="sol"><b>S�n�rs�z</b></td>
                <td align="center" class="sol-sag"><b>S�n�rs�z</b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">PhpMyAdmin</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">PHP 4</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">Perl 5</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">CGI + Ki�isel CGI Klas�r�</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">FrontPage</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">S�n�rs�z FTP Eri�imi</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">Web Tabanl� Dosya Y�neticisi</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">�zel Hata Sayfalar�</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">Detayl� Web �statistikleri</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">Web & FTP G�nl��� Kay�t Etme</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">�ifreli Dizinler</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">T�rk�e Kontrol Paneli*</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#E5E5E5">
                <td align="left"  height="20" style="background-color:#F6F6F6" class="sol-alt">DNS Kontrol Paneli</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#F6F6F6">
                <td align="left"  height="20" style="background-color:#FFFFFF" class="sol-alt">Site Yedekleme</td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol"><b><img src="images/tablo_var.gif"></b></td>
                <td align="center" class="sol-sag"><b><img src="images/tablo_var.gif"></b></td>
        </tr>
        <tr valign="top" bgcolor="#CBF740">
                <td align="left"  height="20" style="background-color:#E7F3C7" class="sol-alt">Kurulum �creti</td>
                <td align="center" class="sol"><b>---</b></td>
                <td align="center" class="sol"><b>---</b></td>
                <td align="center" class="sol"><b>---</b></td>
                <td align="center" class="sol-sag"><b>---</b></td>
        </tr>
        <tr valign="top" bgcolor="#CBF740">
                <td align="left"  height="20" style="background-color:#E7F3C7" class="sol-alt">Ayl�k �deme</td>
                <td align="center" class="sol"><b>1.99 $</b></td>
                <td align="center" class="sol"><b>2.99 $</b></td>
                <td align="center" class="sol"><b>5.99 $</b></td>
                <td align="center" class="sol-sag"><b>9.99 $</b></td>
        </tr>
        <tr valign="top" bgcolor="#CBF740">
                <td align="left"  height="20" style="background-color:#E7F3C7" class="sol-alt">Y�ll�k �deme</td>
                <td align="center" class="sol"><b>19.9 $</b></td>
                <td align="center" class="sol"><b>29.9 $</b></td>
                <td align="center" class="sol"><b>59.9 $</b></td>
                <td align="center" class="sol-sag"><b>99.9 $</b></td>
        </tr>
        <tr valign="top">
                <td align="left" height="20" valign="middle" bgcolor="#FFFFFF" style="border: 0px"><table></table></td>
                <td align="center" class="sol-alt" style="background-color:#FF9900;color:#FFFFFF"><a href="hosting.php?menu=hosting&paket=kucuk" style="color: #FFFFFF; font-weight: bold">Sipari� Ver</a></td>
                <td align="center" class="sol-alt" style="background-color:#FF9900;color:#FFFFFF"><a href="hosting.php?menu=hosting&paket=midi" style="color: #FFFFFF; font-weight: bold">Sipari� Ver</a></td>
                <td align="center" class="sol-alt" style="background-color:#FF9900;color:#FFFFFF"><a href="hosting.php?menu=hosting&paket=buyuk" style="color: #FFFFFF; font-weight: bold">Sipari� Ver</a></td>
                <td align="center" style="background-color:#FF9900;color:#FFFFFF;border-right: 1px solid #000000;border-left:1px solid #000000;border-bottom: 1px solid #9F9F9F;padding:3px; "><a href="hosting.php?menu=hosting&paket=pro" style="color: #FFFFFF; font-weight: bold">Sipari� Ver</a></td>
        </tr>
</table>
<br>
*  T�m paketlerde yeni nesil hosting �irketlerinin tercihi DirectAdmin kontrol paneli bulunmaktad�r. Kullan�m� ve ho� aray�z� sayesinde herkesin ilgisini �eken, DirectAdmin'i <a href="http://deneme:elmasgunes@www.elmasgunes.net:2222">denemek i�in t�klay�n</a>... (Username: deneme - Password: elmasgunes)

<?php
  }

  if( $paket == "kucuk" )
  {
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_host_kucuk.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_host_kucuk.gif" width="106" height="146" border="0" align="top"><bR><bR><img src="images/host_kucuk_ay.gif" width="135" height="30" border="0" align="top"><bR><img src="images/host_kucuk_yil.gif" width="135" height="30" border="0" align="top">
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                        </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top">
                        <b>�ZELL�KLER:</b><bR>
                                                <ul type="disc" class="liste">
                                                <li><b>25 MB</b> Web Alan�
                                                <li><b>1 GB</b> Ayl�k Trafik
                                                <li><b>25</b> POP3 E-Mail Hesab�
                                                <li><b>5</b> Subdomain
                                                <li><b>1</b> Domain Bar�nd�rma
                                                <li><b>1</b> E-Mail Listesi
                                                <li>POP3 ve Web Eri�imi
                                                <li>T�rk�e Aray�zl� WebMail
                                                <li>Catch-All Hesab�
                                                <li>E-Mail Y�nlendirme
                                                <li>Otomatik Cevaplay�c�lar
                                                <li>E-Mail Filtreleme
                                                <li><b>1</b> MySQL Veritaban�
                                                <li>PhpMyAdmin
                                                <li>PHP 4
                                                <li>Perl 5
                                                <li>CGI + Ki�isel CGI Klas�r�
                                                <li>FrontPage
                                                <li>S�n�rs�z FTP Eri�imi
                                                <li>Web Tabanl� Dosya Y�neticisi
                                                <li>�zel Hata Sayfalar�
                                                <li>Detayl� Web �statistikleri
                                                <li>Web & FTP G�nl��� Kay�t Etme
                                                <li>�ifreli Dizinler
                                                <li>T�rk�e <b>DirectAdmin</b> Kontrol Paneli
                                                <li>DNS Kontrol Paneli
                                                <li>Site Yedekleme
                                                </ul>
                        </td>
                </tr>
                </table>

<?php
  }

    if( $paket == "midi" )
  {
?>
                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_host_midi.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_host_midi.gif" width="106" height="146" border="0" align="top"><bR><bR><img src="images/host_midi_ay.gif" width="135" height="30" border="0" align="top"><bR><img src="images/host_midi_yil.gif" width="135" height="30" border="0" align="top">
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                        </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top">
                        <b>�ZELL�KLER:</b><bR>
                                                <ul type="disc" class="liste">
                                                <li><b>50 MB</b> Web Alan�
                                                <li><b>2 GB</b> Ayl�k Trafik
                                                <li><b>50</b> POP3 E-Mail Hesab�
                                                <li><b>10</b> Subdomain
                                                <li><b>2</b> Domain Bar�nd�rma
                                                <li><b>5</b> E-Mail Listesi
                                                <li>POP3 ve Web Eri�imi
                                                <li>T�rk�e Aray�zl� WebMail
                                                <li>Catch-All Hesab�
                                                <li>E-Mail Y�nlendirme
                                                <li>Otomatik Cevaplay�c�lar
                                                <li>E-Mail Filtreleme
                                                <li><b>5</b> MySQL Veritaban�
                                                <li>PhpMyAdmin
                                                <li>PHP 4
                                                <li>Perl 5
                                                <li>CGI + Ki�isel CGI Klas�r�
                                                <li>FrontPage
                                                <li>S�n�rs�z FTP Eri�imi
                                                <li>Web Tabanl� Dosya Y�neticisi
                                                <li>�zel Hata Sayfalar�
                                                <li>Detayl� Web �statistikleri
                                                <li>Web & FTP G�nl��� Kay�t Etme
                                                <li>�ifreli Dizinler
                                                <li>T�rk�e <b>DirectAdmin</b> Kontrol Paneli
                                                <li>DNS Kontrol Paneli
                                                <li>Site Yedekleme
                                                </ul>
                        </td>
                </tr>
                </table>
<?php
  }

  if( $paket == "buyuk" )
  {
?>
                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_host_buyuk.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_host_buyuk.gif" width="106" height="146" border="0" align="top"><bR><bR><img src="images/host_buyuk_ay.gif" width="135" height="30" border="0" align="top"><bR><img src="images/host_buyuk_yil.gif" width="135" height="30" border="0" align="top">
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                        </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top">
                        <b>�ZELL�KLER:</b><bR>
                                                <ul type="disc" class="liste">
                                                <li><b>150 MB</b> Web Alan�
                                                <li><b>4 GB</b> Ayl�k Trafik
                                                <li><b>S�n�rs�z</b> POP3 E-Mail Hesab�
                                                <li><b>S�n�rs�z</b> Subdomain
                                                <li><b>5</b> Domain Bar�nd�rma
                                                <li><b>S�n�rs�z</b> E-Mail Listesi
                                                <li>POP3 ve Web Eri�imi
                                                <li>T�rk�e Aray�zl� WebMail
                                                <li>Catch-All Hesab�
                                                <li>E-Mail Y�nlendirme
                                                <li>Otomatik Cevaplay�c�lar
                                                <li>E-Mail Filtreleme
                                                <li><b>S�n�rs�z</b> MySQL Veritaban�
                                                <li>PhpMyAdmin
                                                <li>PHP 4
                                                <li>Perl 5
                                                <li>CGI + Ki�isel CGI Klas�r�
                                                <li>FrontPage
                                                <li>S�n�rs�z FTP Eri�imi
                                                <li>Web Tabanl� Dosya Y�neticisi
                                                <li>�zel Hata Sayfalar�
                                                <li>Detayl� Web �statistikleri
                                                <li>Web & FTP G�nl��� Kay�t Etme
                                                <li>�ifreli Dizinler
                                                <li>T�rk�e <b>DirectAdmin</b> Kontrol Paneli
                                                <li>DNS Kontrol Paneli
                                                <li>Site Yedekleme
                                                </ul>
                        </td>
                </tr>
                </table>
<?php
  }

  if( $paket == "pro" )
  {
?>
                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_host_pro.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_host_pro.gif" width="106" height="146" border="0" align="top"><bR><bR><img src="images/host_pro_ay.gif" width="135" height="30" border="0" align="top"><bR><img src="images/host_pro_yil.gif" width="135" height="30" border="0" align="top">
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                        </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top">
                        <b>�ZELL�KLER:</b><bR>
                                                <ul type="disc" class="liste">
                                                <li><b>500 MB</b> Web Alan�
                                                <li><b>10 GB</b> Ayl�k Trafik
                                                <li><b>S�n�rs�z</b> POP3 E-Mail Hesab�
                                                <li><b>S�n�rs�z</b> Subdomain
                                                <li><b>10</b> Domain Bar�nd�rma
                                                <li><b>S�n�rs�z</b> E-Mail Listesi
                                                <li>POP3 ve Web Eri�imi
                                                <li>T�rk�e Aray�zl� WebMail
                                                <li>Catch-All Hesab�
                                                <li>E-Mail Y�nlendirme
                                                <li>Otomatik Cevaplay�c�lar
                                                <li>E-Mail Filtreleme
                                                <li><b>S�n�rs�z</b> MySQL Veritaban�
                                                <li>PhpMyAdmin
                                                <li>PHP 4
                                                <li>Perl 5
                                                <li>CGI + Ki�isel CGI Klas�r�
                                                <li>FrontPage
                                                <li>S�n�rs�z FTP Eri�imi
                                                <li>Web Tabanl� Dosya Y�neticisi
                                                <li>�zel Hata Sayfalar�
                                                <li>Detayl� Web �statistikleri
                                                <li>Web & FTP G�nl��� Kay�t Etme
                                                <li>�ifreli Dizinler
                                                <li>T�rk�e <b>DirectAdmin</b> Kontrol Paneli
                                                <li>DNS Kontrol Paneli
                                                <li>Site Yedekleme
                                                </ul>
                        </td>
                </tr>
                </table>
<?php
  }

  if( $paket == "ozel" )
  {
  $gonder = $_POST["gonder"];
  if ( $gonder )
  {
  $web_alani = $_POST["web_alani"];
  $trafik = $_POST["trafik"];
  $pop3_mail = $_POST["pop3_mail"];
  $subdomain = $_POST["subdomain"];
  $domain_barindirma = $_POST["domain_barindirma"];
  $mail_listesi = $_POST["mail_listesi"];
  $mysql = $_POST["mysql"];
  $web_alani = kontrol($web_alani, "Web Alan�", "<b>MB</b> Web Alan�" );
  $trafik = kontrol($trafik, "Ayl�k Trafik", "<b>GB</b> Ayl�k Trafik" );
  $pop3_mail = kontrol($pop3_mail, "POP3 E-Mail Hesab�", "POP3 E-Mail Hesab�" );
  $subdomain = kontrol($subdomain, "Subdomain", "Subdomain" );
  $domain_barindirma = kontrol($domain_barindirma, "Domain Bar�nd�rma", "Domain Bar�nd�rma" );
  $mail_listesi = kontrol($mail_listesi, "E-Mail Listesi", "E-Mail Listesi" );
  $mysql = kontrol($mysql, "MySQL Veritaban�", "MySQL Veritaban�" );
  }
?>
                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_host_ozel.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_host_ozel.gif" width="106" height="146" border="0" align="top"><br>
                                                  <?php if ( $gonder ) {?>
                                                        <form method="POST" action="siparis.php">
                                                        <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                                                        <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                                                        <input type="hidden" name="web_alani" value="<?php echo "$web_alani" ?>">
                                                        <input type="hidden" name="trafik" value="<?php echo "$trafik" ?>">
                                                        <input type="hidden" name="pop3_mail" value="<?php echo "$pop3_mail" ?>">
                                                        <input type="hidden" name="subdomain" value="<?php echo "$subdomain" ?>">
                                                        <input type="hidden" name="domain_barindirma" value="<?php echo "$domain_barindirma" ?>">
                                                        <input type="hidden" name="mail_listesi" value="<?php echo "$mail_listesi" ?>">
                                                        <input type="hidden" name="mysql" value="<?php echo "$mysql" ?>">
                                                        <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                                                        </form>
                                                  <?php } ?>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top">
                        <?php if ( !$gonder ) {?><b>�ZELL�KLER:</b><bR>
                                                <form method="post" action="hosting.php?menu=hosting&paket=ozel">
                                                <ul type="disc" class="liste">
                                                <li><input type="text" name="web_alani" class="form" size="4"> <b>MB</b> Web Alan� (1 GB=1000 MB)
                                                <li><input type="text" name="trafik" class="form" size="4"> <b>GB</b> Ayl�k Trafik
                                                <li><input type="text" name="pop3_mail" class="form" size="4"> POP3 E-Mail Hesab�
                                                <li><input type="text" name="subdomain" class="form" size="4"> Subdomain
                                                <li><input type="text" name="domain_barindirma" class="form" size="4"> Domain Bar�nd�rma (En az 1)
                                                <li><input type="text" name="mail_listesi" class="form" size="4"> E-Mail Listesi
                                                <li>POP3 ve Web Eri�imi
                                                <li>T�rk�e Aray�zl� WebMail
                                                <li>Catch-All Hesab�
                                                <li>E-Mail Y�nlendirme
                                                <li>Otomatik Cevaplay�c�lar
                                                <li>E-Mail Filtreleme
                                                <li><input type="text" name="mysql" class="form" size="4"> MySQL Veritaban�
                                                <li>PhpMyAdmin
                                                <li>PHP 4
                                                <li>Perl 5
                                                <li>CGI + Ki�isel CGI Klas�r�
                                                <li>FrontPage
                                                <li>S�n�rs�z FTP Eri�imi
                                                <li>Web Tabanl� Dosya Y�neticisi
                                                <li>�zel Hata Sayfalar�
                                                <li>Detayl� Web �statistikleri
                                                <li>Web & FTP G�nl��� Kay�t Etme
                                                <li>�ifreli Dizinler
                                                <li>T�rk�e <b>DirectAdmin</b> Kontrol Paneli
                                                <li>DNS Kontrol Paneli
                                                <li>Site Yedekleme
                                                </ul>
                                                <center><input type="submit" name="gonder" value="G�nder" class="buton">&nbsp;&nbsp;<input type="reset" value="Temizle" class="buton"></form><br><br></center>
                                                <b>Not: S�n�rs�z istedi�iniz �zelli�e * koyunuz.<bR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�stemedi�iniz �zelli�e - giriniz.</b>
                       <?php
                       }
                       else if ( $gonder ){
                       ?>
                       <b>�STED���N�Z �ZELL�KLER:</b><bR>
                                                <ul type="disc" class="liste">
                                                <li><?php echo "$web_alani" ?>
                                                <li><?php echo "$trafik" ?>
                                                <li><?php echo "$pop3_mail" ?>
                                                <li><?php echo "$subdomain" ?>
                                                <li><?php echo "$domain_barindirma" ?>
                                                <li><?php echo "$mail_listesi" ?>
                                                <li>POP3 ve Web Eri�imi
                                                <li>T�rk�e Aray�zl� WebMail
                                                <li>Catch-All Hesab�
                                                <li>E-Mail Y�nlendirme
                                                <li>Otomatik Cevaplay�c�lar
                                                <li>E-Mail Filtreleme
                                                <li><?php echo "$mysql" ?>
                                                <li>PhpMyAdmin
                                                <li>PHP 4
                                                <li>Perl 5
                                                <li>CGI + Ki�isel CGI Klas�r�
                                                <li>FrontPage
                                                <li>S�n�rs�z FTP Eri�imi
                                                <li>Web Tabanl� Dosya Y�neticisi
                                                <li>�zel Hata Sayfalar�
                                                <li>Detayl� Web �statistikleri
                                                <li>Web & FTP G�nl��� Kay�t Etme
                                                <li>�ifreli Dizinler
                                                <li>T�rk�e <b>DirectAdmin</b> Kontrol Paneli
                                                <li>DNS Kontrol Paneli
                                                <li>Site Yedekleme
                                                </ul>
                       <?php } ?>
                        </td>
                </tr>
                </table>
<?php
  }



  if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); }
?>