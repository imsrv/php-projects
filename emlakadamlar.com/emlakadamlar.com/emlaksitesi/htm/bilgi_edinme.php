<?
	if($_POST[btnBilgiEdinme]){
		$stristek   = $_POST[txtistek];
		$strAdSoyad = $_POST[txtAdSoyad];
		$strUnvan   = $_POST[txtUnvan];
		$strTelefon = $_POST[txtTelefon];
		$strMail    = $_POST[txtMail];
		$strWeb     = $_POST[txtWeb];
		
		$strDate    =date("d.m.Y");
		$strText    ="<b>istek : </b>".$stristek."<br>".
					"<b>Ad Soyad : </b>".$strAdSoyad."<br>".
					"<b>Ünvan : </b>".$strUnvan."<br>".
					"<b>Telefon : </b>".$strTelefon."<br>".
					"<b>Mail : </b>".$strMail."<br>".
					"<b>Web : </b>".$strWeb."<br>";
		mysql_query("iNSERT iNTO tblForm(form_date,form_text) VALUES('$strDate','$strText')");
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

	<meta http-equiv="Content-Language" content="tr">
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
</head>

<body>
<?php include("main02.php"); ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="33%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="5%" valign="top"><img src="images/left_bar.gif" width="19" height="320"></td>
        <td width="95%"><table width="335"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="335" height="267"><p><span class="small_header">Sizin yanınızda oluruz</span><br>
                      <br>
                      <span class="text">Yabanc&#305;s&#305; oldu?unuz yer ve konularda bizimle ileti&#351;im kurabilirseniz; sizin yard&#305;mc&#305;n&#305;z oluruz </span></p>
                  <a href="index.php?module=bilgi_edinme" class="link">Hizmet i&ccedil;in t&#305;klay&#305;n</a>                  <p align="left"><span class="text"><br>
                    </span><span class="small_header">Sorular&#305;n&#305;za &ccedil;&ouml;z&uuml;m arayal&#305;m</span><span class="text"><br>
                    <br>
        Kiraya vermek yada satmak istiyorsaniz </span><span class="link"><a href="index.php?module=kiralik_satilik" class="link">t&#305;klay&#305;n</a></span><span class="text"><br>
        Tapu kadastro veraset ve intikal işlemleriniz i&ccedil;in </span><span class="link"><a href="index.php?module=bilgi_edinme" class="link">t&#305;klay&#305;n</a></span><br>
        <br>
        <span class="small_header">Ofislerimiz</span> <br>
        <br>
        <span class="text">&#304;stanbul - Etiler Merkez<br>
        Balikesir - Ak&ccedil;ay Ofis</span><br>
        <span class="text">&#304;stanbul - Mecidiyek&ouml;y Ofis</span> </p></td>
            </tr>
            <tr>
              <td><div align="right"><img src="images/sol_alt_resim_4.jpg"></div></td>
            </tr>
          </table></td>
      </tr>
    </table></td> 
    <td width="7%">&nbsp;</td> 
    <td width="60%" valign="top"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="739" class="header">Hukuksal Konularda Yan&#305;n&#305;zday&#305;z</td>
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
                <td valign="top" class="text">&#304;ste?iniz</td>
                <td><textarea name="txtistek" cols="40" rows="10" class="form" id="txtistek"></textarea>                </td>
              </tr>
              <tr>
                <td class="text">Ad&#305;n&#305;z / Soyad&#305;n&#305;z </td>
                <td><input name="txtAdSoyad" type="text" class="form" id="txtAdSoyad" size="30"></td>
              </tr>
              <tr>
                <td class="text">Ünvan&#305;n&#305;z</td>
                <td><input name="txtUnvan" type="text" class="form" id="txtUnvan" size="30"></td>
              </tr>
              <tr>
                <td class="text">Telefon Numaran&#305;z</td>
                <td><input name="txtTelefon" type="text" class="form" id="txtTelefon" size="30"></td>
              </tr>
              <tr>
                <td class="text">E-mail Adresiniz </td>
                <td><input name="txtMail" type="text" class="form" id="txtMail" size="30"></td>
              </tr>
              <tr>
                <td class="text">Web Adresiniz</td>
                <td><input name="txtWeb" type="text" class="form" id="txtWeb" size="30"></td>
              </tr>
              <tr>
                <td class="text">&nbsp;</td>
                <td><input name="btnBilgiEdinme" type="submit" class="buton" value="  Gönder  ">
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