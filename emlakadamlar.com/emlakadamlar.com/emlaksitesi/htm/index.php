<?
	session_start();
	require_once("admin/config.php");
	$connection = mysql_connect($dbhost,$dbuser,$dbpass);
	if ($connection) {
		mysql_select_db($dbname);

		$res = mysql_query("SELECT DISTINCT session FROM tblCounter");
		$rows = mysql_num_rows($res);
		$intCounter1=$rows+1354;

		$res = mysql_query("SELECT DISTINCT counter_id FROM tblCounter");
		$rows = mysql_num_rows($res);
		$intCounter2=$rows+6158;
	}
?>
<html>
<head>
<title>Emlak Adamlar</title>
<script language="JavaScript" src="repop.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
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
.style1 {font-weight: bold}
-->
</style>
</head>
<body>
<?php include("top.php"); ?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33%" background="images/blue_bg.gif"><div align="right"><img src="images/main_img.jpg" width="285"></div></td>
    <td width="7%" background="images/blue_bg_r.gif"><br>
      <br></td>
    <td background="images/blue_bg_r.gif"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="46%" valign="top"><span class="header">Hoşgeldiniz</span><br>
            <br>
            <A class=link 
                  href="index.php?module=resimli">Kiralık - Satılık Emlaklar ( Resimli ) <img src="images/yeni.gif" border="0"> </A><br>
            <SPAN class=text><A class=link 
                  href="index.php?module=hakkinda">Hakkında</A></SPAN><br>
            <SPAN class=text><A class=link 
                  href="index.php?module=avantaj">Avantajları</A></SPAN><br>
            <SPAN class=text><A class=link 
                  href="index.php?module=calisma_sistemi">Çalışma Sistemleri</A></SPAN></td>
          <td width="54%" valign="top"><SPAN class=header>Gayrimenkul Sahiplerinin İlgisine </SPAN><BR>
            <SPAN class=text><STRONG><br>
            Kontrat Hazırlayacaksanız...<BR>
            </STRONG>Aşağıdaki linkten görüntüleyeceğiniz kontrat formatını örnek olarak uygulayabilirsiniz.<BR>
            <BR>
            <A class=link 
      href="javascript:%20popImage('images/kira.jpg','%20:%20:%20Emlak%20Adamlar%20...%20Örnek%20Kira%20Şözleşmesi%20:%20:%20')">Kira Sözleşmesi</A> | <A class=link 
      href="kontrat.zip">Örnek İndirin</A></SPAN></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><div align="right"><img src="images/main_img_bott.jpg" width="285"></div></td>
    <td>&nbsp;</td>
    <td><TABLE width="600" border="0" cellpadding="0" cellspacing="0" align="right">
        <TBODY>
          <TR class=arial11>
            <TD height="5"></TD>
            <TD></TD>
            <TD></TD>
            <TD></TD>
            <TD></TD>
          </TR>
          <TR class=arial11>
            <FORM name="form1" action="index.php" method="get">
              <INPUT type=hidden 
          value=resimli name=module>
              <TD width="29%" height="24"><div align="left">
                  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr class="arial11">
                      <td width="50%" nowrap><INPUT type=radio value="1" name="type"<?if($_GET[type]==1){echo " checked";}?>>
                        Kiralik </td>
                      <td width="50%" nowrap><INPUT 
            type=radio value="2" name="type" <?if(($_GET[type]==2)or($_GET[type]=="")){echo " checked";}?>>
                        Satilik</td>
                    </tr>
                  </table>
                </div></TD>
              <TD width="32%"><div align="left">
                  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr class="arial11">
                      <td width="51%" nowrap><div align="center">Fiyat Araligi </div></td>
                      <td width="49%" nowrap><INPUT style="WIDTH: 30px" name="price1" value="<?=$_GET[price1];?>">
                        -
                        <INPUT style="WIDTH: 30px" name="price2" value="<?=$_GET[price2];?>"></td>
                    </tr>
                  </table>
                </div></TD>
              <TD width="27%"><div align="center">
                  <SELECT name="district">
                    <option selected value="">Yer (Hepsi)</option>
                    <?
	$res = mysql_query("SELECT * FROM tblDistrict WHERE district_city in (1,2) ORDER BY district_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intId   = mysql_result($res,$f,"district_id");
			$strName = mysql_result($res,$f,"district_name");
?>
                    <option value="<?=$intId?>"<?if($_GET[district]==$intId){echo " selected";}?>>
                    <?=$strName?>
                    </option>
                    <?
		}
	}
?>
                  </SELECT>
                </div></TD>
              <TD width="12%"><SELECT name="type2">
                  <option selected value="">Emlak Tipi (Hepsi)</option>
                  <?
	$res = mysql_query("SELECT * FROM tblType WHERE 1 ORDER BY type_name ASC");
	$rows = mysql_num_rows($res);
	$rowselect=1;
	if ($rows) {
	    for ($f=0 ; $f<$rows ; $f++) {
			$intId   = mysql_result($res,$f,"type_id");
			$strName = mysql_result($res,$f,"type_name");
?>
                  <option value="<?=$intId?>"<?if($_GET[type2]==$intId){echo " selected";}?>>
                  <?=$strName?>
                  </option>
                  <?
		}
	}
?>
                </SELECT></TD>
				<td>&nbsp;&nbsp;&nbsp;</td>
              <TD width="12%"><div align="left">
                  <input type="submit" value=" Ara ">
                </div></TD>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </FORM>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
</table>
<?	if($_GET[module]=='hakkinda'){
		require_once("hakkinda.php");
	}elseif($_GET[module]=='avantaj'){
		require_once("avantaj.php");
	}elseif($_GET[module]=='calisma_sistemi'){
		require_once("calisma_sistemi.php");
	}elseif($_GET[module]=='bilgi_edinme'){
		require_once("bilgi_edinme.php");
	}elseif($_GET[module]=='kiralik_satilik'){
		require_once("kiralik_satilik.php");
	}elseif($_GET[module]=='resimli'){
		require_once("resimli.php");
	}elseif($_GET[module]=='tavsiye'){
		require_once("tavsiye_et.php");
	}elseif($_GET[module]=='site_harita'){
		require_once("site_harita.php");
	}else{
		require_once("main.php");
	}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="0%" align="center" class="text_11">&nbsp;</td>
    <td width="99%" height="34" align="center" valign="bottom" class="text_11"><div align="right"><b>Toplam Ziyaretçi Sayısı : </b>
        <?=$intCounter1?>
        <b>&nbsp;&nbsp;Toplam Gezilen Sayfa : </b>
        <?=$intCounter2?>
      </div></td>
    <td width="1%" align="center" valign="bottom" class="text_11">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" valign="top" background="images/bott_bg.gif" class="black_arial11">&nbsp;</td>
    <td width="31%" valign="top" background="images/bott_bg.gif" class="black_arial11">&nbsp;</td>
    <td width="34%" valign="top" background="images/bott_bg.gif" class="black_arial11">&nbsp;</td>
    <td width="20%" height="84" valign="top" background="images/bott_bg.gif" class="black_arial11"><p><br>
        <br>
        ©2006 Emlak Yönetim<br>
        <a href="mailto:info@megteknosan.com" class="link_small">info@megteknosan.com</a><br>
      </p>
      <p></td>
    <td width="14%" valign="top" background="images/bott_bg.gif" class="black_arial11"><br>
      <br>
      Created by <a href="http://www.megteknosan.com" target="_blank" class="link_small">Meg Teknosan </a> </td>
  </tr>
</table>
</body>
</html>
<?
	mysql_close($connection);
?>
