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
                                                <b>&nbsp;&nbsp;Neden internet?</b><br>&nbsp;&nbsp;Artýk internetin kapýlarýný açmak sandýðýnýz kadar zahmetli ve pahalý deðil! Elmasgüneþ.Net size en uygun siteyi yapýyor ve sizin istediðiniz bir alan adýnda yayýnlýyor.<br><br>
                        <b>&nbsp;&nbsp;Farklý ihtiyaçlar, farklý paketler!</b><br>&nbsp;&nbsp;Elmasgüneþ.Net'te her ihtiyaca göre bir paket bulunmaktadýr. Sizin yapmanýz gereken bu paketlerden size en uygun olaný seçmeniz ve bunu bize iletmeniz. Ýhtiyacýnýza göre bir paket yoksa da üzülmeyin. Çünkü özel paketimizle sadece size özel bir plan hazýrlayabiliriz. Yeter ki bir internet sitesi yaptýrmak isteyin!<br><br>
                                                <b>&nbsp;&nbsp;Profesyonel kadro!</b><br>&nbsp;&nbsp;Elmasgüneþ.Net dallarýnda uzman kiþilerden oluþturduðu kadro ile tüm web design ihtiyaçlarýnýza cevap veriyor. Sizin belirlediðiniz ölçütleri esas alarak hýzlý bir þekilde sitenizi hazýrlayan kadromuz, gerekli incelemeleri yapýp sitenizi internette yayýnlamaya baþlýyor.<br><br>
                                                <b>&nbsp;&nbsp;Siz isteyin biz yapalým!</b><br>&nbsp;&nbsp;Kendinize en uygun paketi seçtikten sonra iþi bize býrakýn. Biz sizden gerekli bilgileri alýp sitenizi en kýsa zamanda hazýrlayacaðýz.<br><br>
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
                          <input type="submit" name="siparis_ver" value="Sipariþ Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Kiþisel ihtiyaçlara birebir!</b><br>&nbsp;&nbsp;Fiyatý ve özellikleri bakýmýndan bir internet sitesine sahip olmak isteyen herkes için kolay bir çözüm yolu.<br><br>
                                                <b>&nbsp;&nbsp;Kolaylýk!</b><br>&nbsp;&nbsp;Bu pakette sipariþ verdikten sonra yapmanýz gereken tek þey bilgilerinizi bize göndermeniz olacaktýr. Bundan sonrasýný bize býrakýn! Biz sizin için en uygun tasarýmý yapacaðýz ve bilgilerinizi adapte ettikten sonra internette yayýnlamaya baþlayacaðýz.<br><br>
                                                <b>&nbsp;&nbsp;Ayrýcalýk!</b><br>&nbsp;&nbsp;Ek bir ücret ödemeden isterseniz sitenize ziyaretçi defteri, sayaç ve bunun gibi etkileþimli hizmetleri ekleyebiliriz.<br><br>
                                                <b>&nbsp;&nbsp;Tam size göre!</b><br>&nbsp;&nbsp;Sizin için yapacaðýmýz sitede sizden fikirler alarak isteklerinize uygun bir site ortaya çýkaracaðýz.<br><br>
                                                <b>&nbsp;&nbsp;Paketin içeriði:</b><ul style="position:relative; top: -16px" type="disc" class="liste"><li>1 + 3 Sayfa Tasarýmý<li>Ýsteðe baðlý özellikler:<br>&nbsp;&nbsp;- Ziyaretçi Defteri<br>&nbsp;&nbsp;- Sayaç<br>&nbsp;&nbsp;- Anket<li>5 POP3 E-Mail Hesabý<li>E-Host Küçük Paketi<li>Ýstediðiniz alan adý (www.adýnýz.com v.b. þeklinde)</ul>
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
                          <input type="submit" name="siparis_ver" value="Sipariþ Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Her firmanýn bir sitesi olacak!</b><br>&nbsp;&nbsp;Ürünlerinizin resimlerini yayýnlayýp hizmetleriniz hakkýnda bilgi verecek bir internet sitesi isteyen firmalar! Ýstediðiniz sayýda ürünü/hizmeti artýk internette yayýnlayabilirsiniz!<br><br>
                                                <b>&nbsp;&nbsp;Kolaylýk!</b><br>&nbsp;&nbsp;Bu pakette sipariþ verdikten sonra yapmanýz gereken tek þey bilgilerinizi bize göndermeniz olacaktýr. Bundan sonrasýný bize býrakýn! Biz sizin için en uygun tasarýmý yapacaðýz ve bilgilerinizi adapte ettikten sonra internette yayýnlamaya baþlayacaðýz.<br><br>
                                                <b>&nbsp;&nbsp;Ayrýcalýk!</b><br>&nbsp;&nbsp;Sadece ürünlerinizi/hizmetlerinizi deðil, firmanýzýn tüm bilgilerini de internete taþýyoruz. Firmanýzý tanýtabileceðiniz "Hakkýmýzda" sayfasý ve sizinle irtibat kurmak isteyenler için "Ýletiþim" sayfasýný da hazýrlýyoruz.<br><br>
                                                <b>&nbsp;&nbsp;Tam size göre!</b><br>&nbsp;&nbsp;Sizin için yapacaðýmýz sitede sizden fikirler alarak isteklerinize uygun bir site ortaya çýkaracaðýz.Ayrýca ürünlerinizin/hizmetleri-<br>nizin sayýsýna göre uygun fiyat avantajlarýmýzýnda bulunduðunu unutmayýn.<br><br>
                                                <b>&nbsp;&nbsp;Paketin içeriði:</b><ul style="position:relative; top: -16px" type="disc" class="liste"><li>Ürünlerinizin/hizmetlerinizin tanýtýlmasý<li>Firmanýzý tanýtacaðýnýz "Hakkýmýzda" sayfasý<li>"Ýletiþim" sayfasý<li>E-Host Küçük Paketi<li>Ýstediðiniz alan adý (www.firmanýz.com þeklinde)</ul>
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
                          <input type="submit" name="siparis_ver" value="Sipariþ Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Þirketlere özel!</b><br>&nbsp;&nbsp;Þirketinize özel bir internet sayfasý mý istiyorsunuz? Bu paketi inceleyin.<br><br>
                                                <b>&nbsp;&nbsp;Ayrýntýlý!</b><br>&nbsp;&nbsp;Þirketiniz için en uygun tasarýmý yaparak en ince ayrýntýsýna kadar þirketinizi tanýtýyoruz.<br><br>
                                                <b>&nbsp;&nbsp;Ayrýcalýk!</b><br>&nbsp;&nbsp;Elmasgüneþ.Net'in uzman kadrosu tarafýndan siteniz hýzlý þekilde hazýrlanacaktýr. Bu süre içerisinde þirketiniz ziyaret edilecek ve sizden gerekli bilgiler alýnacaktýr. Þirketiniz hakkýnda en ayrýntýlý bilgiyi elde edip uygun bir tasarým ile birleþtireceðiz ve bunu internet ortamýnda yayýnlamaya baþlayacaðýz.<br><br>
                                                <b>&nbsp;&nbsp;Paketin içeriði:</b><ul style="position:relative; top: -16px" type="disc" class="liste"><li>Þirketiniz hakkýnda detaylý bilgileri sunma<li>Þirketinizi ziyaret ederek gerekli bilgileri alma<li>E-Host Midi Paketi<li>Ýstediðiniz alan adý (www.þirketiniz.com.tr þeklinde)</ul>
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
                          <input type="submit" name="siparis_ver" value="Sipariþ Ver" class="buton">
                          </form>
                                                </center></td>
                        <td width="9" background="images/tasarim_ara_dikey.gif"></td>
                        <td width="381" valign="top"><br>
                        <b>&nbsp;&nbsp;Size özel paket!</b><br>&nbsp;&nbsp;Bu paketimiz ile ihtiyaçlarýnýza tam cevap verecek bir plan hazýrlayabilirsiniz.<br><br>
                                                <b>&nbsp;&nbsp;Sadece iletin!</b><br>&nbsp;&nbsp;Bize ileteceðiniz bilgiler sayesinde size en uygun planý hazýrlayýp sunuyoruz. Sitenin içeriðinde neler olacaðýný, siteyi ne amaçla kullanacaðýnýz bize göndermeniz yeterli olacaktýr.<br><br>
                                                <b>&nbsp;&nbsp;Avantajlý!</b><br>&nbsp;&nbsp;Size özel bir plan olacaðý için hem siz kazanacaksýnýz, hem de sitenizde sadece görmek istedikleriniz olacak.<br><br>
                        </td>
                </tr>
                </table>

<?php
  }

  if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); }
?>