<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Gerçek Nakliye Tic. Ltd. Şti.</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3F82EB">
  <tr>
    <td align="left" valign="top" style="background-image:url(imgs/gercek_03.jpg); background-repeat:repeat-x; background-position:top;">
	<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="792" height="203">
          <param name="movie" value="imgs/swf/banner.swf">
          <param name="quality" value="high">
          <embed src="imgs/swf/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="792" height="203"></embed>
        </object></td>
      </tr>
    </table>
	<table width="792" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td style="background-image:url(imgs/gercek_05.jpg); background-repeat:repeat-y; background-position:top;" width="16" align="left" valign="top"></td>
        <td width="760" align="left" valign="top" style="background-image:url(imgs/gercek_09.jpg); background-repeat:repeat-y; background-position:top;"><table width="758" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="10" align="left" valign="top" style="height:10px;"></td>
            <td width="177" align="left" valign="top"></td>
            <td width="10" align="left" valign="top"></td>
            <td width="551" align="left" valign="top"></td>
            <td width="10" align="left" valign="top"></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><table width="177" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><img src="imgs/box/insan_kaynaklari_01.jpg" width="177" height="163"></td>
              </tr>
              <tr>
                <td align="left" valign="top" style="height:8px;"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><a href="iletisim.php"><img src="imgs/box/hakkimizda_02.jpg" width="177" height="86" border="0"></a></td>
              </tr>
            </table></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="551" valign="middle" bgcolor="#326FDA" style="height:25px;"><span class="navbeyaz"><b>&nbsp;&nbsp;İnsan Kaynakları</b></span></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				
				
<br>				
<!-- Cv Buraya -->

<table width="549" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
  <tr>
    <td align="left" valign="top">
<?php
$ay[0] = "Ocak";
$ay[1] = "Şubat";
$ay[2] = "Mart";
$ay[3] = "Nisan";
$ay[4] = "Mayıs";
$ay[5] = "Haziran";
$ay[6] = "Temmuz";
$ay[7] = "Ağustos";
$ay[8] = "Eylül";
$ay[9] = "Ekim";
$ay[10] = "Kasım";
$ay[11] = "Aralık";

$cinsiyet[0] = "Bay";
$cinsiyet[1] = "Bayan";

$askerlik[0] = "Yaptım";
$askerlik[1] = "Muaf";
$askerlik[2] = "Tecilli";

$ehliyet[0] = "Yok";
$ehliyet[1] = "A1";
$ehliyet[2] = "A2";
$ehliyet[3] = "B";
$ehliyet[4] = "C";
$ehliyet[5] = "D";
$ehliyet[6] = "E";
$ehliyet[7] = "F";
$ehliyet[8] = "H";

$stime = (date('Y') - 66);
$xtime = (date('Y') - 17);
$ftime = (date('Y') + 1 );
if(isset($_POST["yolla"])){
	/*Bölüm 1*/
	$b1_ad       = addslashes($_POST["b1_ad"]);
	$b1_dogum    = addslashes($_POST["b1_dogum"]);
	$b1_dogum_1  = addslashes($_POST["b1_dogum_1"]);
	$b1_dogum_2  = addslashes($_POST["b1_dogum_2"]);
	$b1_dogum_3  = addslashes($_POST["b1_dogum_3"]);
	$b1_cinsiyet = addslashes($_POST["b1_cinsiyet"]);
	$b1_askerlik = addslashes($_POST["b1_askerlik"]);
	$b1_ehliyet  = addslashes($_POST["b1_ehliyet"]);
	/*Bölüm 2*/
	$b2_adres    = addslashes($_POST["b2_adres"]);
	$b2_evtel    = addslashes($_POST["b2_evtel"]);
	$b2_ceptel   = addslashes($_POST["b2_ceptel"]);
	$b2_email    = addslashes($_POST["b2_email"]);
	/*Bölüm 3*/
	$b3_a1       = addslashes($_POST["b3_a1"]);
	$b3_a2       = addslashes($_POST["b3_a2"]);
	$b3_a3       = addslashes($_POST["b3_a3"]);
	$b3_a4       = addslashes($_POST["b3_a4"]);
	$b3_b1       = addslashes($_POST["b3_b1"]);
	$b3_b2       = addslashes($_POST["b3_b2"]);
	$b3_b3       = addslashes($_POST["b3_b3"]);
	$b3_b4       = addslashes($_POST["b3_b4"]);
	$b3_c1       = addslashes($_POST["b3_c1"]);
	$b3_c2       = addslashes($_POST["b3_c2"]);
	$b3_c3       = addslashes($_POST["b3_c3"]);
	$b3_c4       = addslashes($_POST["b3_c4"]);
	/*Bölüm 4*/
	$b4_pc_word	 = addslashes($_POST["b4_pc_word"]);
	$b4_pc_excel = addslashes($_POST["b4_pc_excel"]);
	$b4_pc_access= addslashes($_POST["b4_pc_access"]);
	$b4_pc_point = addslashes($_POST["b4_pc_point"]);
	$b4_diger	 = addslashes($_POST["b4_diger"]);
	/*Bölüm 5*/
	$b5_a1 		 = addslashes($_POST["b5_a1"]);
	$b5_a2 		 = addslashes($_POST["b5_a2"]);
	$b5_a3 		 = addslashes($_POST["b5_a3"]);
	$b5_a4 		 = addslashes($_POST["b5_a4"]);
	$b5_b1 		 = addslashes($_POST["b5_b1"]);
	$b5_b2 		 = addslashes($_POST["b5_b2"]);
	$b5_b3 		 = addslashes($_POST["b5_b3"]);
	$b5_b4 		 = addslashes($_POST["b5_b4"]);
	$b5_c1 		 = addslashes($_POST["b5_c1"]);
	$b5_c2 		 = addslashes($_POST["b5_c2"]);
	$b5_c3 		 = addslashes($_POST["b5_c3"]);
	$b5_c4 		 = addslashes($_POST["b5_c4"]);
	$b5_d1 		 = addslashes($_POST["b5_d1"]);
	$b5_d2 		 = addslashes($_POST["b5_d2"]);
	$b5_d3 		 = addslashes($_POST["b5_d3"]);
	$b5_d4 		 = addslashes($_POST["b5_d4"]);
	/*Bölüm 1 Kontrol*/
	if(strlen($b1_ad)<5){ $b1_ad_hata = "Ad-Soyad bölümü hatalı."; }else{ $b1_ad_hata = null ; }
	if(strlen($b1_dogum)<3){ $b1_dogum_hata = "Doğum yeri bölümü hatalı."; }else{ $b1_dogum_hata = null ; }
	/*Bölüm 2 Kontrol*/
	if(strlen($b2_adres)<10){ $b2_adres_hata = "Adres bölümü hatalı."; }else{ $b2_adres_hata = null ; }
	if(strlen($b2_evtel)<11){ $b2_evtel_hata = "Telefon bölümü hatalı."; }else{ $b2_evtel_hata = null ; }
	
	if(strlen($b2_evtel)>0){
		if(strlen($b2_evtel)<11){
			$b2_evtel_hata = "Ev telefonu kısmı hatalı.(Lütfen Alan Kodu ile Birlikte Giriniz. Örn: 03622552256)";
		}else{
			$b2_evtel_hata = null ;
		}
	}else{
		$b2_evtel_hata = null ;
	}
	
	if(strlen($b2_ceptel)>0){
		if(strlen($b2_ceptel)<11){
			$b2_ceptel_hata = "Cep telefonu kısmı hatalı.(Lütfen Alan Kodu ile Birlikte Giriniz. Örn: 05442552256)";
		}else{
			$b2_ceptel_hata = null ;
		}
	}else{
		$b2_ceptel_hata = null ;
	}
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $b2_email)){
		$b2_email_hata = "E-posta Adresiniz hatalı.";
	}else{
		$b2_email_hata = null ;
	}
	
	/*Hata Dökümü*/
	if($b1_ad_hata == null and
	   $b1_dogum_hata == null and
	   $b2_adres_hata == null and
	   $b2_evtel_hata == null and
	   $b2_ceptel_hata == null and
	   $b2_email_hata == null ){
	   /*Hata yok mail yolla*/
	   $alici  = "iletisim@gerceknakliye.com.tr";
	   // Mime type
	   $mailbaslik = "CV yollandı(".$b1_ad.")";
	   $baslik  = "MIME-Version: 1.0" . "\r\n";
	   $baslik .= "Content-type: text/html; charset=iso-8859-9" . "\r\n";
	   $baslik .= "To: Gerçek Nakliye Tic. Ltd. Şti. <iletisim@gerceknakliye.com.tr>". "\r\n";
	   $baslik .= 'From: Gerçek Nakliye Cv Formu <iletisim@gerceknakliye.com.tr>' . "\r\n";
	   # veri başlıyor
	   $veri = "";
	   /*Bölüm 1 Html */
		$veri .= "<table width=\"549\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"border:#BD1212 1px solid;\">\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td colspan=\"3\" ><strong><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Kimlik Bilgileri</font></strong></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td width=\"151\" align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Ad Soyad</font></td>\n";
		$veri .= "    <td width=\"2\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td width=\"549\" align=\"left\" valign=\"middle\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b1_ad."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Doğum Yeri / Tarihi</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b1_dogum."/".$b1_dogum_1."-".$ay[$b1_dogum_2]."-".$b1_dogum_3."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Cinsiyet</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$cinsiyet[$b1_cinsiyet]."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Askerlik durumu</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$askerlik[$b1_askerlik]."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Sürücü belgesi</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$ehliyet[$b1_ehliyet]."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "</table>";
        $veri .="<table width=\"549\" style=\"height:18px;\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>&nbsp;</td></tr></table>";
		/*Bölüm 2 Html*/
		$veri .= "<table width=\"549\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"border:#BD1212 1px solid;\">\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td colspan=\"3\" ><strong><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Adres Bilgileri</font></strong></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td width=\"151\" align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Adres</font></td>\n";
		$veri .= "    <td width=\"2\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td width=\"549\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b2_adres."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Telefon No</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b2_evtel."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Cep Telefonunuz</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b2_ceptel."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"middle\" ><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">E-Posta Adresiniz</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">:</font></td>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b2_email."</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "</table>";
        $veri .="<table width=\"549\" style=\"height:18px;\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>&nbsp;</td></tr></table>";
		/*Bölüm 3 Html*/
		$veri .= "<table width=\"549\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"border:#BD1212 1px solid;\">\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td colspan=\"3\"><strong><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Eğitim, Mesleğiniz veya Özel İhtisas Alanınız</font></strong></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td width=\"153\"><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Lise / Meslek Lisesi</font></td>\n";
		$veri .= "    <td width=\"183\"><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Üniversite / Y.Okul</font></td>\n";
		$veri .= "    <td width=\"177\"><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Master / Doktora</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"top\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b3_a1."<br>".$b3_a2."<br>".$b3_a3."-".$b3_a4." yılları arası<br></font></td>\n";
		$veri .= "    <td align=\"left\" valign=\"top\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b3_b1."<br>".$b3_b2."<br>".$b3_b3."-".$b3_b4." yılları arası<br></font></td>\n";
		$veri .= "    <td align=\"left\" valign=\"top\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$b3_c1."<br>".$b3_c2."<br>".$b3_c3."-".$b3_c4." yılları arası<br></font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "</table>";
        $veri .="<table width=\"549\" style=\"height:18px;\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>&nbsp;</td></tr></table>";
		/*Bölüm 4 Html*/
		$veri .= "<table width=\"549\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"border:#BD1212 1px solid;\">\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td><strong><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">Bildiginiz Bilgisayar Programlari</font></strong></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">";
		if($b4_pc_word == "on"){
			$veri .= "Word<br>";
		}
		if($b4_pc_excel == "on"){
			$veri .= "Excel<br>";
		}
		if($b4_pc_access == "on"){
			$veri .= "Access<br>";
		}
		if($b4_pc_point == "on"){
			$veri .= "Powerpoint<br>";
		}
		if (strlen($b4_diger)>0) {
			$veri .= "Diğer Programlar:".$b4_diger."<br>";
		}
		$veri .= "</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "</table>";
        $veri .="<table width=\"549\" style=\"height:18px;\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>&nbsp;</td></tr></table>";
		/*Bölüm 5 Html*/
		$veri .= "<table width=\"549\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"border:#BD1212 1px solid;\">\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td><font color=\"#BD1212\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Is Deneyimleri</strong></font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "  <tr>\n";
		$veri .= "    <td align=\"left\" valign=\"top\"><font color=\"#333333\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">";
		if (strlen($b5_a1)>0) {
			$veri .= $b5_a1."<br>";
			$veri .= $b5_a2."<br>";
			$veri .= $b5_a3."-".$b5_a4."  Yılları arası<br><br>";
		}
		if (strlen($b5_b1)>0) {
			$veri .= $b5_b1."<br>";
			$veri .= $b5_b2."<br>";
			$veri .= $b5_b3."-".$b5_b4."  Yılları arası<br><br>";
		}
		if (strlen($b5_c1)>0) {
			$veri .= $b5_c1."<br>";
			$veri .= $b5_c2."<br>";
			$veri .= $b5_c3."-".$b5_c4."  Yılları arası<br><br>";
		}
		if (strlen($b5_d1)>0) {
			$veri .= $b5_d1."<br>";
			$veri .= $b5_d2."<br>";
			$veri .= $b5_d3."-".$b5_d4."  Yılları arası<br><br>";
		}
		$veri .="</font></td>\n";
		$veri .= "  </tr>\n";
		$veri .= "</table>";
	   # veri bitiyor
	   /*Maili yolla*/
	   if(mail($alici, $mailbaslik, $veri, $baslik)){
		   /*Mail Yollandı.*/
			echo "<table width=\"549\" style=\"border:#009900 1px solid;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			echo  "<tr>";
			echo    "<td style=\"padding:5px;\">";
			echo      "<span class=\"yesil\">";
			echo      "Özgeçmişiniz başarıyla gönderildi. Özgeçmişiniz incelenecektir. Teşekkürler.";
			echo      "</span>";
			echo	"</td>";
			echo   "</tr>";
			echo "</table><br>";
		   /*Mail Yollandı.*/
	   }else{
		   /*Mail Yollama Hatası var ekrana yazdır.*/
			echo "<table width=\"549\" style=\"border:#FF0000 1px solid;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			echo  "<tr>";
			echo    "<td style=\"padding:5px;\">";
			echo      "<span class=\"kirmizi\">Özgeçmişinizin gönderilmesi esnasında bir sorun oluştu. Lütfen daha sonra yeniden deneyiniz.";
			echo      "</span>";
			echo	"</td>";
			echo   "</tr>";
			echo "</table><br>";
		   /*Mail Yollama Hatası var ekrana yazdır.*/
	   }
	}else{
	   /*Hata var ekrana yazdır.*/
	  	echo "<table width=\"549\" style=\"border:#FF0000 1px solid;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo  "<tr>";
		echo    "<td style=\"padding:5px;\">";
		echo      "<span class=\"kirmizi\">";
		if($b1_ad_hata != null){ echo $b1_ad_hata."<br>"; }
		if($b1_dogum_hata != null){ echo $b1_dogum_hata."<br>"; }
		if($b2_adres_hata != null){ echo $b2_adres_hata."<br>"; }
		if($b2_evtel_hata != null){ echo $b2_evtel_hata."<br>"; }
		if($b2_ceptel_hata != null){ echo $b2_ceptel_hata."<br>"; }
		if(b2_email_hata != null){ echo $b2_email_hata."<br>"; }
		echo      "</span>";
		echo	"</td>";
		echo   "</tr>";
		echo "</table><br>";
	   /*Hata var ekrana yazdır.*/
	}
	/*Hata Dökümü*/
}else{
		echo "<table width=\"549\" style=\"border:#3F82EB 1px solid;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo  "<tr>";
		echo    "<td style=\"padding:5px;\">";
		echo      "<span class=\"bordob\">";
		echo      "Gerçek Nakliye İş Olanaklarından Yararlanın.<br>Lütfen Özgeçmişinizi eksiksiz olarak doldurunuz. Özgeçmişiniz incelenip uygun<br>görüldüğünüz taktirde  sizinle iletişime geçilecektir.<br>";
		echo      "</span>";
		echo	"</td>";
		echo   "</tr>";
		echo "</table><br>";
}
?>
	<table style="border:#3F82EB 1px solid;" width="549" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td colspan="3" ><span class="bordob"><b>Kimlik Bilgileriniz</b></span></td>
        </tr>
      <tr>
        <td width="152" align="left" valign="middle" ><span class="metin">Ad Soyad</span></td>
        <td width="6"><span class="metin">:</span></td>
        <td width="369" align="left" valign="middle">
		<input name="b1_ad" type="text" id="b1_ad" style="border:1px solid
		  <?php
		  if($b1_ad_hata == null){
			echo "#3679AE";
		  }else{
			echo "#BD1212";
		  }
		  ?>;
		  font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if($b1_ad_hata == null){
			echo "value=\"".$b1_ad."\"";
		  }
		  ?>
		  >		 </td>
      </tr>
      <tr>
        <td align="left" valign="middle" ><span class="metin">Doğum Yeri / Tarihi</span></td>
        <td><span class="metin">:</span></td>
        <td align="left" valign="middle"><table width="369" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="160" align="left" valign="middle"><input name="b1_dogum" type="text" id="b1_dogum"
			style="border:1px solid
		  <?php
		  if($b1_dogum_hata == null){
			echo "#3679AE";
		  }else{
			echo "#BD1212";
		  }
		  ?>;
		  font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if($b1_dogum_hata == null){
			echo "value=\"".$b1_dogum."\"";
		  }
		  ?>
			></td>
            <td width="51">
			<select name="b1_dogum_1" id="b1_dogum_1">
  			<?php
			if(isset($_POST["yolla"])){
				for($i=1;$i<32;$i++){
					if($i == $b1_dogum_1){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option value=\"".$i."\">".$i."</option>";
					}
				}
			}else{
				for($i=1;$i<32;$i++){
					echo "<option value=\"".$i."\">".$i."</option>";
				}
			}
			?>
            </select></td>
            <td width="87">
			<select name="b1_dogum_2" id="b1_dogum_2">
			<?php
			if(isset($_POST["yolla"])){
				for($i=0;$i<12;$i++){
					if($b1_dogum_2 == $i){
						echo "<option value=\"".$i."\" selected>".$ay[$i]."</option>";
					}else{
						echo "<option value=\"".$i."\">".$ay[$i]."</option>";
					}
				}
			}else{
				for($i=0;$i<12;$i++){
						echo "<option value=\"".$i."\">".$ay[$i]."</option>";
				}
			}
			?>
            </select>			</td>
            <td width="65">
			<select name="b1_dogum_3" id="b1_dogum_3">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $xtime; $i++){
					if($b1_dogum_3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $xtime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select>			  </td>
            <td width="22">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="middle" ><span class="metin">Cinsiyet</span></td>
        <td><span class="metin">:</span></td>
        <td align="left" valign="middle">
		<select name="b1_cinsiyet" id="b1_cinsiyet" style="width:95px;">
			<?php
			if(isset($_POST["yolla"])){
				for($i=0;$i<2;$i++){
					if($b1_cinsiyet == $i){
						echo "<option value=\"".$i."\" selected>".$cinsiyet[$i]."</option>";
					}else{
						echo "<option value=\"".$i."\">".$cinsiyet[$i]."</option>";
					}
				}
			}else{
				for($i=0;$i<2;$i++){
						echo "<option value=\"".$i."\">".$cinsiyet[$i]."</option>";
				}
			}
			?>
          </select>		  </td>
      </tr>
      <tr>
        <td align="left" valign="middle" ><span class="metin">Askerlik durumu</span></td>
        <td><span class="metin">:</span></td>
        <td align="left" valign="middle"><select name="b1_askerlik" id="b1_askerlik" style="width:95px;">
			<?php
			if(isset($_POST["yolla"])){
				for($i=0;$i<3;$i++){
					if($b1_askerlik == $i){
						echo "<option value=\"".$i."\" selected>".$askerlik[$i]."</option>";
					}else{
						echo "<option value=\"".$i."\">".$askerlik[$i]."</option>";
					}
				}
			}else{
				for($i=0;$i<3;$i++){
						echo "<option value=\"".$i."\">".$askerlik[$i]."</option>";
				}
			}
			?>
        </select></td>
      </tr>
      <tr>
        <td align="left" valign="middle" ><span class="metin">Sürücü belgesi</span></td>
        <td><span class="metin">:</span></td>
        <td align="left" valign="middle"><select name="b1_ehliyet" id="b1_ehliyet" style="width:95px;">
			<?php
			if(isset($_POST["yolla"])){
				for($i=0;$i<9;$i++){
					if($b1_ehliyet == $i){
						echo "<option value=\"".$i."\" selected>".$ehliyet[$i]."</option>";
					}else{
						echo "<option value=\"".$i."\">".$ehliyet[$i]."</option>";
					}
				}
			}else{
				for($i=0;$i<9;$i++){
						echo "<option value=\"".$i."\">".$ehliyet[$i]."</option>";
				}
			}
			?>
        </select>        </td>
      </tr>
    </table>
      <br>
      <table style="border:#3F82EB 1px solid;" width="549" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td colspan="3" ><span class="bordob"><b>Adres Bilgileriniz</b></span></td>
        </tr>
        <tr>
          <td width="152" align="left" valign="middle" ><span class="metin">Adres</span></td>
          <td width="6" valign="middle"><span class="metin">:</span></td>
          <td width="368">
		  <input name="b2_adres" type="text" id="b2_adres" style=" width:370px; border:1px solid
		  <?php
		  if($b2_adres_hata == null){
			echo "#3679AE";
		  }else{
			echo "#BD1212";
		  }
		  ?>;
		  font-family: Verdana; font-size:10pt; height:16px; color:#333333;"
		  <?php
		  if($b2_adres_hata == null){
			echo "value=\"".$b2_adres."\"";
		  }
		  ?>
		  ></td>
        </tr>
        <tr>
          <td align="left" valign="middle" ><span class="metin">Telefon No</span></td>
          <td><span class="metin">:</span></td>
          <td align="left" valign="middle"><input name="b2_evtel" type="text" id="b2_evtel" style="border:1px solid
		  <?php
		  if($b2_evtel_hata == null){
			echo "#3679AE";
		  }else{
			echo "#BD1212";
		  }
		  ?>;
		  font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if($b2_evtel_hata == null){
			echo "value=\"".$b2_evtel."\"";
		  }
		  ?>
		  ></td>
        </tr>
        <tr>
          <td align="left" valign="middle" ><span class="metin">Cep Telefonunuz</span></td>
          <td><span class="metin">:</span></td>
          <td align="left" valign="middle"><input name="b2_ceptel" type="text" id="b2_ceptel" style="border:1px solid
		  <?php
		  if($b2_ceptel_hata == null){
			echo "#3679AE";
		  }else{
			echo "#BD1212";
		  }
		  ?>;
		  font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if($b2_ceptel_hata == null){
			echo "value=\"".$b2_ceptel."\"";
		  }
		  ?>
		  >          </td>
        </tr>
        <tr>
          <td align="left" valign="middle" ><span class="metin">E-Posta Adresiniz</span></td>
          <td><span class="metin">:</span></td>
          <td align="left" valign="middle"><input name="b2_email" type="text" id="b2_email" style="border:1px solid
		  <?php
		  if($b2_email_hata == null){
			echo "#3679AE";
		  }else{
			echo "#BD1212";
		  }
		  ?>;
		  font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if($b2_email_hata == null){
			echo "value=\"".$b2_email."\"";
		  }
		  ?>
		  >		   </td>
        </tr>
      </table>
      <br>
	  <table style="border:#3F82EB 1px solid;" width="549" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td colspan="2"><span class="bordob"><b>Eğitim, Mesleğiniz veya Özel İhtisas Alanınız</b></span></td>
          </tr>
        <tr>
          <td width="144"><span class="bordob">Lise / Meslek Lisesi</span></td>
          <td width="389">&nbsp;</td>
        </tr>
        <tr>
          <td><span class="metin">Okul Adı</span></td>
          <td><input name="b3_c1" type="text" id="b3_c1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b3_c1)){
		  	echo "value=\"".$b3_c1."\"";
		  }
		  ?>
		   ></td>
        </tr>
        <tr>
          <td><span class="metin">Yer / Bölüm</span></td>
          <td><input name="b3_c2" type="text" id="b3_c2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b3_c2)){
		  	echo "value=\"".$b3_c2."\"";
		  }
		  ?>		  
		  ></td>
        </tr>
        <tr>
          <td><span class="metin">Yıl Aralığı</span></td>
          <td><table width="188" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="65"><select name="b3_c3" id="b3_c3">
                      <?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b3_c3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
                  </select></td>
                  <td width="10" align="center" valign="middle">-</td>
                  <td width="65"><select name="b3_c4" id="b3_c4">
                      <?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b3_c4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
                  </select></td>
                  <td width="220">&nbsp;&nbsp;<span class="metin">Arası</span></td>
                </tr>
              </table></td>
        </tr>
        <tr>
          <td><span class="bordob">Üniversite / Y.Okul</span></td>
          <td></td>
        </tr>
        <tr>
          <td><span class="metin">Okul Adı</span></td>
          <td><input name="b3_b1" type="text" id="b3_b1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b3_b1)){
		  	echo "value=\"".$b3_b1."\"";
		  }
		  ?>		  
		  ></td>
        </tr>
        <tr>
          <td><span class="metin">Yer / Bölüm</span></td>
          <td><input name="b3_b2" type="text" id="b3_b2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b3_b2)){
		  	echo "value=\"".$b3_b2."\"";
		  }
		  ?>
		  ></td>
        </tr>
        <tr>
          <td><span class="metin">Yıl Aralığı</span></td>
          <td><table width="188" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="65"><select name="b3_b3" id="b3_b3">
                      <?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b3_b3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
                  </select></td>
                  <td width="10" align="center" valign="middle">-</td>
                  <td width="65"><select name="b3_b4" id="b3_b4">
                      <?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b3_b4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
                  </select></td>
                  <td width="220">&nbsp;&nbsp;<span class="metin">Arası</span></td>
                </tr>
              </table></td>
        </tr>
        <tr>
          <td><span class="bordob">Master / Doktora</span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="metin">Okul Adı</span></td>
          <td><input name="b3_a1" type="text" id="b3_a1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b3_a1)){
		  	echo "value=\"".$b3_a1."\"";
		  }
		  ?>
		   ></td>
        </tr>
        <tr>
          <td><span class="metin">Yer / Bölüm</span></td>
          <td><input name="b3_a2" type="text" id="b3_a2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b3_a2)){
		  	echo "value=\"".$b3_a2."\"";
		  }
		  ?>		  
		  ></td>
        </tr>
        <tr>
          <td><span class="metin">Yıl Aralığı</span></td>
          <td><table width="188" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="65"><select name="b3_a3" id="b3_a3">
                  <?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b3_a3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
                </select>              </td>
              <td width="10" align="center" valign="middle">-</td>
              <td width="65"><select name="b3_a4" id="b3_a4">
                  <?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b3_a4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="220">&nbsp;&nbsp;<span class="metin">Arası</span></td>
            </tr>
          </table></td>
        </tr>
      </table>
	  <br>
      <table style="border:#3F82EB 1px solid;" width="549" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td colspan="8"><span class="bordob"><b>Bildiğiniz Bilgisayar Programları</b></span></td>
        </tr>
        <tr>
          <td width="20"><input name="b4_pc_word" type="checkbox" id="b4_pc_word"
		  <?php
		  if(isset($_POST["yolla"])){
		  	if($b4_pc_word == "on"){
				echo "checked";
			}
		  }
		  ?>
		  ></td>
          <td width="42"><span class="metin">Word</span></td>
          <td width="20"><input name="b4_pc_excel" type="checkbox" id="b4_pc_excel"
		  <?php
		  if(isset($_POST["yolla"])){
		  	if($b4_pc_excel == "on"){
				echo "checked";
			}
		  }
		  ?>
		  ></td>
          <td width="48"><span class="metin">Excel</span></td>
          <td width="20"><input name="b4_pc_access" type="checkbox" id="b4_pc_access"
		  <?php
		  if(isset($_POST["yolla"])){
		  	if($b4_pc_access == "on"){
				echo "checked";
			}
		  }
		  ?>
		  ></td>
          <td width="52"><span class="metin">Access</span></td>
          <td width="20"><input name="b4_pc_point" type="checkbox" id="b4_pc_point"
		  <?php
		  if(isset($_POST["yolla"])){
		  	if($b4_pc_point == "on"){
				echo "checked";
			}
		  }
		  ?>
		  ></td>
          <td width="275"><span class="metin">Powerpoint</span></td>
        </tr>
        <tr>
          <td colspan="2"><span class="metin">Diğer</span></td>
          <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="5"><span class="metin">:</span></td>
              <td align="left" valign="middle"><input name="b4_diger" type="text" id="b4_diger" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b4_diger)){
		  	echo "value=\"".$b4_diger."\"";
		  }
		  ?>			  
			  ></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <br>
      <table style="border:#3F82EB 1px solid;" width="549" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td colspan="4" ><span class="bordob"><b>İş Deneyimleriniz</b></span></td>
        </tr>
        <tr>
          <td width="12" >&nbsp;</td>
          <td width="157"><span class="metin">Şirket Adı</span></td>
          <td width="159"><span class="metin">Göreviniz</span></td>
          <td width="380"><span class="metin">Çalışma Tarihi</span></td>
        </tr>
        <tr>
          <td ><span class="metin">1</span></td>
          <td><input name="b5_a1" type="text" id="b5_a1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_a1)){
		  	echo "value=\"".$b5_a1."\"";
		  }
		  ?>		  
		  ></td>
          <td><input name="b5_a2" type="text" id="b5_a2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_a2)){
		  	echo "value=\"".$b5_a2."\"";
		  }
		  ?>		  
		  ></td>
          <td><table width="192" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="65"><select name="b5_a3" id="b5_a3">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_a3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="10" align="center" valign="middle">-</td>
              <td width="65"><select name="b5_a4" id="b5_a4">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_a4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="52">&nbsp;&nbsp;<span class="metin">Arası</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td ><span class="metin">2</span></td>
          <td><input name="b5_b1" type="text" id="b5_b1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_b1)){
		  	echo "value=\"".$b5_b1."\"";
		  }
		  ?>		  
		  ></td>
          <td><input name="b5_b2" type="text" id="b5_b2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_b2)){
		  	echo "value=\"".$b5_b2."\"";
		  }
		  ?>		  
		  ></td>
          <td><table width="192" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="65"><select name="b5_b3" id="b5_b3">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_b3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="10" align="center" valign="middle">-</td>
              <td width="65"><select name="b5_b4" id="b5_b4">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_b4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="51">&nbsp;&nbsp;<span class="metin">Arası</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td ><span class="metin">3</span></td>
          <td><input name="b5_c1" type="text" id="b5_c1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_c1)){
		  	echo "value=\"".$b5_c1."\"";
		  }
		  ?>		  
		  ></td>
          <td><input name="b5_c2" type="text" id="b5_c2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_c2)){
		  	echo "value=\"".$b5_c2."\"";
		  }
		  ?>		  
		  ></td>
          <td><table width="192" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="65"><select name="b5_c3" id="b5_c3">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_c3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="10" align="center" valign="middle">-</td>
              <td width="65"><select name="b5_c4" id="b5_c4">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_c4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="50">&nbsp;&nbsp;<span class="metin">Arası</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td ><span class="metin">4</span></td>
          <td><input name="b5_d1" type="text" id="b5_d1" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_d1)){
		  	echo "value=\"".$b5_d1."\"";
		  }
		  ?>		  
		  ></td>
          <td><input name="b5_d2" type="text" id="b5_d2" style="border:1px solid #3679AE; font-family: Verdana; font-size:10pt; height:16px; width:150px; color:#333333;"
		  <?php
		  if(isset($b5_d2)){
		  	echo "value=\"".$b5_d2."\"";
		  }
		  ?>		  
		  ></td>
          <td><table width="192" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="65"><select name="b5_d3" id="b5_d3">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_d3 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="10" align="center" valign="middle">-</td>
              <td width="65"><select name="b5_d4" id="b5_d4">
			<?php
			if(isset($_POST["yolla"])){
				for($i=$stime;$i < $ftime; $i++){
					if($b5_d4 == $i){
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}else{
						echo "<option>".$i."</option>";
					}
				}
			}else{
				for($i=$stime;$i < $ftime; $i++){
					echo "<option>".$i."</option>";
				}
			}
			?>
              </select></td>
              <td width="52">&nbsp;&nbsp;<span class="metin">Arası</span></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <br>
      <table style="border:#3F82EB 1px solid;" width="549" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="15" align="left" valign="middle"><input type="hidden" name="yolla" value="evet"></td>
          <td width="707" align="left" valign="middle"><input onclick="this.disabled = true; this.form.submit();"  style="border:1px solid #3F82EB; font-family: Verdana; font-size:10pt; font-weight:bold; background-color:#FFFFFF; color:#3F82EB" name="Submit" type="submit" id="Submit" value="  Özgeçmişimi gönder  " ></td>
        </tr>
      </table>	 </td>
    </tr>
</form>
</table>
<!-- Cv Bitiyor -->
				
				
              </tr>
            </table>
              <br></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table></td>
        <td style="background-image:url(imgs/gercek_07.jpg); background-repeat:repeat-y; background-position:top;" width="16" align="left" valign="top"></td>
      </tr>
      <tr>
        <td style="background-image:url(imgs/gercek_05.jpg); background-repeat:repeat-y; background-position:top;" align="left" valign="top"></td>
        <td align="right" valign="top" style="background-image:url(imgs/gercek_09.jpg); background-repeat:repeat-y; background-position:top;"><img src="imgs/gercek_11.jpg" width="200" height="16"></td>
        <td style="background-image:url(imgs/gercek_07.jpg); background-repeat:repeat-y; background-position:top;" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="background-image:url(imgs/gercek_13.jpg); background-repeat:no-repeat;  background-position:top;"></td>
        <td align="left" valign="top"><table width="760" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="137" align="left" valign="top" style=" height:37px; background-image:url(imgs/gercek_24.jpg); background-repeat:no-repeat;  background-position:top;"></td>
            <td width="490" align="center" valign="middle" style="background-image:url(imgs/gercek_26.jpg); background-repeat:repeat-x;  background-position:left;"><span class="copybeyaz">Copyright ©  2006 Gerçek Nakliye Tic. Ltd. Şti. Tüm hakları saklıdır.</span></td>
            <td width="133" align="left" valign="top" style="background-image:url(imgs/gercek_25.jpg); background-repeat:no-repeat;  background-position:top;"></td>
          </tr>
        </table></td>
        <td align="left" valign="top" style="background-image:url(imgs/gercek_17.jpg); background-repeat:no-repeat;  background-position:top;"></td>
      </tr>
      <tr>
        <td width="16" align="left" valign="top" style="background-image:url(imgs/gercek_16.jpg); background-repeat:no-repeat;  background-position:top;"></td>
        <td align="left" valign="top"><table width="760" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="35" style=" height:19px; background-image:url(imgs/gercek_20.jpg); background-repeat:no-repeat;  background-position:top;"></td>
            <td width="690" style="background-image:url(imgs/gercek_21.jpg); background-repeat:repeat-x;  background-position:left;"></td>
            <td width="35" style="background-image:url(imgs/gercek_23.jpg); background-repeat:no-repeat;  background-position:top;"></td>
          </tr>
        </table></td>
        <td align="left" valign="top" style="background-image:url(imgs/gercek_18.jpg); background-repeat:no-repeat;  background-position:top;"></td>
      </tr>
    </table>
	<table width="792" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="677"></td>
        <td width="115">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
