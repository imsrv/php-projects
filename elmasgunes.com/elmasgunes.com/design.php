<?php
  $tiklama = $_GET["menu"];
  $paket = $_GET["paket"];
  if ( !$paket ) $paket = "ana";
  if ( !@include("sayfa_basi.php") )
  {
   require("hata.php");
    exit();
  }

  if( $paket == "ana" )
  {
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="576" valign="top"><br>
                                                <b>&nbsp;&nbsp;Neden internet?</b><br>&nbsp;&nbsp;Art�k internetin kap�lar�n� a�mak sand���n�z kadar zahmetli ve pahal� de�il! Elmasg�ne�.Net size en uygun siteyi yap�yor ve sizin istedi�iniz bir alan ad�nda yay�nl�yor.<br><br>
                        <b>&nbsp;&nbsp;Farkl� ihtiya�lar, farkl� paketler!</b><br>&nbsp;&nbsp;Elmasg�ne�.Net'te her ihtiyaca g�re bir paket bulunmaktad�r. Sizin yapman�z gereken bu paketlerden size en uygun olan� se�meniz ve bunu bize iletmeniz. �htiyac�n�za g�re bir paket yoksa da �z�lmeyin. ��nk� �zel paketimizle sadece size �zel bir plan haz�rlayabiliriz. Yeter ki bir internet sitesi yapt�rmak isteyin!<br><br>
                                                <b>&nbsp;&nbsp;Profesyonel kadro!</b><br>&nbsp;&nbsp;Elmasg�ne�.Net dallar�nda uzman ki�ilerden olu�turdu�u kadro ile t�m web design ihtiya�lar�n�za cevap veriyor. Sizin belirledi�iniz �l��tleri esas alarak h�zl� bir �ekilde sitenizi haz�rlayan kadromuz, gerekli incelemeleri yap�p sitenizi internette yay�nlamaya ba�l�yor.<br><br>
                                                <b>&nbsp;&nbsp;Siz isteyin biz yapal�m!</b><br>&nbsp;&nbsp;Kendinize en uygun paketi se�tikten sonra i�i bize b�rak�n. Biz sizden gerekli bilgileri al�p sitenizi en k�sa zamanda haz�rlayaca��z.<br><br>
                        </td>
                </tr>
                </table>

<?php
  }

  if( $paket == "kisisel" )
  {
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_design_kisisel.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_design_kisisel.gif" width="106" height="146" border="0" align="top"><br><br><img src="images/design_kisisel_ilk.gif" width="160" height="30" border="0" align="top"><br><img src="images/design_kisisel_yil.gif" width="160" height="30" border="0" align="top"><br>
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Ki�isel ihtiya�lara birebir!</b><br>&nbsp;&nbsp;Fiyat� ve �zellikleri bak�m�ndan bir internet sitesine sahip olmak isteyen herkes i�in kolay bir ��z�m yolu.<br><br>
                                                <b>&nbsp;&nbsp;Kolayl�k!</b><br>&nbsp;&nbsp;Bu pakette sipari� verdikten sonra yapman�z gereken tek �ey bilgilerinizi bize g�ndermeniz olacakt�r. Bundan sonras�n� bize b�rak�n! Biz sizin i�in en uygun tasar�m� yapaca��z ve bilgilerinizi adapte ettikten sonra internette yay�nlamaya ba�layaca��z.<br><br>
                                                <b>&nbsp;&nbsp;Ayr�cal�k!</b><br>&nbsp;&nbsp;Ek bir �cret �demeden isterseniz sitenize ziyaret�i defteri, saya� ve bunun gibi etkile�imli hizmetleri ekleyebiliriz.<br><br>
                                                <b>&nbsp;&nbsp;Tam size g�re!</b><br>&nbsp;&nbsp;Sizin i�in yapaca��m�z sitede sizden fikirler alarak isteklerinize uygun bir site ortaya ��karaca��z.<br><br>
                                                <b>&nbsp;&nbsp;Paketin i�eri�i:</b><ul style="position:relative; top: -16px" type="disc" class="liste"><li>1 + 3 Sayfa Tasar�m�<li>�ste�e ba�l� �zellikler:<br>&nbsp;&nbsp;- Ziyaret�i Defteri<br>&nbsp;&nbsp;- Saya�<br>&nbsp;&nbsp;- Anket<li>5 POP3 E-Mail Hesab�<li>E-Host K���k Paketi<li>�stedi�iniz alan ad� (www.ad�n�z.com v.b. �eklinde)</ul>
                        </td>
                </tr>
                </table>

<?php
  }

  if( $paket == "katalog" )
  {
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_design_katalog.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_design_katalog.gif" width="106" height="146" border="0" align="top"><br>
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Her firman�n bir sitesi olacak!</b><br>&nbsp;&nbsp;�r�nlerinizin resimlerini yay�nlay�p hizmetleriniz hakk�nda bilgi verecek bir internet sitesi isteyen firmalar! �stedi�iniz say�da �r�n�/hizmeti art�k internette yay�nlayabilirsiniz!<br><br>
                                                <b>&nbsp;&nbsp;Kolayl�k!</b><br>&nbsp;&nbsp;Bu pakette sipari� verdikten sonra yapman�z gereken tek �ey bilgilerinizi bize g�ndermeniz olacakt�r. Bundan sonras�n� bize b�rak�n! Biz sizin i�in en uygun tasar�m� yapaca��z ve bilgilerinizi adapte ettikten sonra internette yay�nlamaya ba�layaca��z.<br><br>
                                                <b>&nbsp;&nbsp;Ayr�cal�k!</b><br>&nbsp;&nbsp;Sadece �r�nlerinizi/hizmetlerinizi de�il, firman�z�n t�m bilgilerini de internete ta��yoruz. Firman�z� tan�tabilece�iniz "Hakk�m�zda" sayfas� ve sizinle irtibat kurmak isteyenler i�in "�leti�im" sayfas�n� da haz�rl�yoruz.<br><br>
                                                <b>&nbsp;&nbsp;Tam size g�re!</b><br>&nbsp;&nbsp;Sizin i�in yapaca��m�z sitede sizden fikirler alarak isteklerinize uygun bir site ortaya ��karaca��z.Ayr�ca �r�nlerinizin/hizmetleri-<br>nizin say�s�na g�re uygun fiyat avantajlar�m�z�nda bulundu�unu unutmay�n.<br><br>
                                                <b>&nbsp;&nbsp;Paketin i�eri�i:</b><ul style="position:relative; top: -16px" type="disc" class="liste"><li>�r�nlerinizin/hizmetlerinizin tan�t�lmas�<li>Firman�z� tan�taca��n�z "Hakk�m�zda" sayfas�<li>"�leti�im" sayfas�<li>E-Host K���k Paketi<li>�stedi�iniz alan ad� (www.firman�z.com �eklinde)</ul>
                        </td>
                </tr>
                </table>

<?php
  }

  if( $paket == "sirket" )
  {
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_design_sirket.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_design_sirket.gif" width="106" height="146" border="0" align="top"><bR>
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;�irketlere �zel!</b><br>&nbsp;&nbsp;�irketinize �zel bir internet sayfas� m� istiyorsunuz? Bu paketi inceleyin.<br><br>
                                                <b>&nbsp;&nbsp;Ayr�nt�l�!</b><br>&nbsp;&nbsp;�irketiniz i�in en uygun tasar�m� yaparak en ince ayr�nt�s�na kadar �irketinizi tan�t�yoruz.<br><br>
                                                <b>&nbsp;&nbsp;Ayr�cal�k!</b><br>&nbsp;&nbsp;Elmasg�ne�.Net'in uzman kadrosu taraf�ndan siteniz h�zl� �ekilde haz�rlanacakt�r. Bu s�re i�erisinde �irketiniz ziyaret edilecek ve sizden gerekli bilgiler al�nacakt�r. �irketiniz hakk�nda en ayr�nt�l� bilgiyi elde edip uygun bir tasar�m ile birle�tirece�iz ve bunu internet ortam�nda yay�nlamaya ba�layaca��z.<br><br>
                                                <b>&nbsp;&nbsp;Paketin i�eri�i:</b><ul style="position:relative; top: -16px" type="disc" class="liste"><li>�irketiniz hakk�nda detayl� bilgileri sunma<li>�irketinizi ziyaret ederek gerekli bilgileri alma<li>E-Host Midi Paketi<li>�stedi�iniz alan ad� (www.�irketiniz.com.tr �eklinde)</ul>
                        </td>
                </tr>
                </table>

<?php
  }

  if( $paket == "ozel" )
  {
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="186" valign="top"><img src="images/baslik_design_ozel.gif" width="186" height="9" border="0"><br><br><center><img src="images/ana_design_ozel.gif" width="106" height="146" border="0" align="top"><bR>
                          <form method="POST" action="siparis.php">
                          <input type="hidden" name="urun" value="<?php echo "$tiklama" ?>">
                          <input type="hidden" name="paket" value="<?php echo "$paket" ?>">
                          <input type="submit" name="siparis_ver" value="Sipari� Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Size �zel paket!</b><br>&nbsp;&nbsp;Bu paketimiz ile ihtiya�lar�n�za tam cevap verecek bir plan haz�rlayabilirsiniz.<br><br>
                                                <b>&nbsp;&nbsp;Sadece iletin!</b><br>&nbsp;&nbsp;Bize iletece�iniz bilgiler sayesinde size en uygun plan� haz�rlay�p sunuyoruz. Sitenin i�eri�inde neler olaca��n�, siteyi ne ama�la kullanaca��n�z bize g�ndermeniz yeterli olacakt�r.<br><br>
                                                <b>&nbsp;&nbsp;Avantajl�!</b><br>&nbsp;&nbsp;Size �zel bir plan olaca�� i�in hem siz kazanacaks�n�z, hem de sitenizde sadece g�rmek istedikleriniz olacak.<br><br>
                        </td>
                </tr>
                </table>

<?php
  }

  if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); }
?>