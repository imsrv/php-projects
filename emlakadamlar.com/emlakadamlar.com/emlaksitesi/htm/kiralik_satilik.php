<?
	if($_POST[btnKiralikSatilik]){
		$strIstek   = $_POST[txtIstek];
		$strAdSoyad = $_POST[txtAdSoyad];
		$strUnvan   = $_POST[txtUnvan];
		$strTelefon = $_POST[txtTelefon];
		$strMail    = $_POST[txtMail];
		$strWeb     = $_POST[txtWeb];

		$strType    = $_POST[txtType];
		$strAdSoyad = $_POST[txtAdSoyad];
		$strUnvan   = $_POST[txtUnvan];
		$strTelefon = $_POST[txtTelefon];
		$strMail    = $_POST[txtMail];
		$strWeb     = $_POST[txtWeb];
		$strFiyat   = $_POST[txtFiyat];
		$strDepozito= $_POST[txtDepozito];
		$strIl      = $_POST[txtIl];
		$strIlce    = $_POST[txtIlce];
		$strSemt    = $_POST[txtSemt];
		$strMahalle = $_POST[txtMahalle];
		$strMevki   = $_POST[txtMevki];
		$strOzellik = $_POST[txtOzellik];
		$strIstek   = $_POST[txtIstek];
		$strSecenek1= $_POST[txtSecenek1];
		$strSecenek2= $_POST[txtSecenek2];
		$strSecenek3= $_POST[txtSecenek3];
		$strSecenek4= $_POST[txtSecenek4];

		
		$strDate    =date("d.m.Y");
		$strText    ="<b>Tip : </b>".$strType."<br>".
					"<b>Ad Soyad : </b>".$strAdSoyad."<br>".
					"<b>Ünvan : </b>".$strUnvan."<br>".
					"<b>Telefon : </b>".$strTelefon."<br>".
					"<b>Mail : </b>".$strMail."<br>".
					"<b>Web : </b>".$strWeb."<br>".
					"<b>Fiyat : </b>".$strFiyat."<br>".
					"<b>Depozito : </b>".$strDepozito."<br>".
					"<b>Il : </b>".$strIl."<br>".
					"<b>Ilçe : </b>".$strIlce."<br>".
					"<b>Semt : </b>".$strSemt."<br>".
					"<b>Mahalle : </b>".$strMahalle."<br>".
					"<b>Mevki : </b>".$strMevki."<br>".
					"<b>Özellik : </b>".$strOzellik."<br>".
					"<b>Istek : </b>".$strIstek."<br>".
					"<b>Seçenek : </b>".$strSecenek1.",".$strSecenek2.",".$strSecenek3.",".$strSecenek4."";
		mysql_query("INSERT INTO tblForm(form_date,form_text) VALUES('$strDate','$strText')");
	}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="emlakadamlar_css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 12px}
a:link {
	color: #000000;
}
a:visited {
	color: #000000;
}
a:hover {
	color: #000000;
}
a:active {
	color: #000000;
}
-->
</style>

	<meta http-equiv="Content-Language" content="tr">
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
	
</head>

<body>
<?php include("main02.php"); ?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="5%" valign="top"><img src="images/left_bar.gif" width="19" height="320"></td>
          <td width="95%"><table width="335"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="335" height="267"><p><span class="small_header">Sizin yanýnýzda oluruz</span><br>
                      <br>
                      <span class="text">Yabancisi oldugunuz yer ve konularda bizimle iletisim kurabilirseniz; sizin yardimciniz oluruz </span></p>
                  <a href="index.php?module=bilgi_edinme" class="link">Hizmet i&ccedil;in tiklayin</a>
                  <p align="left"><span class="text"><br>
                    </span><span class="small_header">Sorularýnýza &ccedil;&ouml;z&uuml;m arayalým</span><span class="text"><br>
                    <br>
        Kiraya vermek yada satmak istiyorsaniz </span><span class="link"><a href="index.php?module=kiralik_satilik" class="link">tiklayin</a></span><span class="text"><br>
        Tapu kadastro veraset ve intikal islemleriniz i&ccedil;in </span><span class="link"><a href="index.php?module=bilgi_edinme" class="link">tiklayin</a></span><br>
        <br>
        <span class="small_header">Ofislerimiz</span> <br>
        <br>
        <span class="text">Istanbul - Etiler Merkez<br>
        Balikesir - Ak&ccedil;ay Ofis</span><br>
        <span class="text">Istanbul - Mecidiyek&ouml;y Ofis</span> </p></td>
            </tr>
            <tr>
              <td><div align="right">
                <p>&nbsp;</p>
                <p><img src="images/sol_alt_resim_2.gif"></p>
              </div></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
    <td width="7%">&nbsp;</td>
    <td width="60%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="739" class="header">Kiralýk yada Satýlýk Arýyorsanýz</td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="23%">&nbsp;</td>
                <td width="77%">&nbsp;</td>
              </tr>
			  <form name="form1" action="" method="post">
              <tr>
                <td class="text">&nbsp;</td>
                <td class="arial11">Kiralýk
                  <input name="txtType" type="radio" value="Kiralik">
                  Satýlýk
                  <input name="txtType" type="radio" value="Satilik" checked></td>
              </tr>
              <tr>
                <td class="text">Adýnýz  / Soyadýnýz</td>
                <td><input name="txtAdSoyad" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Ünvanýnýz</td>
                <td><input name="txtUnvan" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Telefon Numaranýz </td>
                <td><input name="txtTelefon" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">E-mail Adresiniz</td>
                <td><input name="txtMail" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Web Adresiniz</td>
                <td><input name="txtWeb" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Fiyat</td>
                <td><input name="txtFiyat" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Depozito</td>
                <td><input name="txtDepozito" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">ýl</td>
                <td><input name="txtIl" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">ýlçe</td>
                <td><input name="txtIlce" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Semt</td>
                <td><input name="txtSemt" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Mahalle</td>
                <td><input name="txtMahalle" type="text" class="form" size="30"></td>
              </tr>
              <tr>
                <td class="text">Mevki</td>
                <td><input name="txtMevki" type="text" class="form" size="30">
                </td>
              </tr>
              <tr>
                <td valign="top" class="text">Özellikler</td>
                <td><textarea name="txtOzellik" cols="40" rows="10" class="form"></textarea></td>
              </tr>
              <tr>
                <td valign="top" class="text">ýste?iniz</td>
                <td><textarea name="txtIstek" cols="40" rows="10" class="form"></textarea></td>
              </tr>
              <tr>
                <td class="text">&nbsp;</td>
                <td><table width="80%"  border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td width="7%">&nbsp;</td>
                      <td width="93%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="txtSecenek1" value="Emlakadamlar afi?i asilsýn"></td>
                      <td class="arial11"> Emlakadamlar afi?i asilsýn </td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="txtSecenek2" value="Gazete ve dergilere ilan verilsin"></td>
                      <td class="arial11"> Gazete ve dergilere ilan verilsin </td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="ctxtSecenek3" value="ýnternet sitelerine resimli ilan girilsin"></td>
                      <td class="arial11"> ýnternet sitelerine resimli ilan girilsin </td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="txtSecenek4" value="Sözle?meli Çalý?mak istiyorum"></td>
                      <td class="arial11"> Sözle?meli Çalý?mak istiyorum </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="arial11">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td class="text">&nbsp;</td>
                <td><input name="btnKiralikSatilik" type="submit" class="buton" value="  Gönder  ">
                    <input name="Submit2" type="reset" class="buton" value="    Sil      ">
                </td>
              </tr>
			  </form>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>