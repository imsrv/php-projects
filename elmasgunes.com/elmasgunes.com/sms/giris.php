<?
 session_name('smssistemleri');
 session_start();

 mysql_connect("localhost","guneselmas_sms","smssistemleri") or die ("bağlantı hatası");
 mysql_select_db("guneselmas_sms") or die ("veritabanı hatası");
?>
<?
$kullaniciadi = $_POST["kullaniciadi"];
$sifre = $_POST["sifre"];

$sql = mysql_query("SELECT * FROM firmalar WHERE kullaniciadi='$kullaniciadi' AND sifre='$sifre'");

if( mysql_num_rows($sql) ){
 $firma = mysql_fetch_object($sql);

 $ad = $firma->ad;
 $gonderen = $firma->gonderen;
 $klasor = $firma->klasor;

 $_SESSION["ad"] = $ad;
 $_SESSION["gonderen"] = $gonderen;
 $_SESSION["klasor"] = $klasor;
?>
<html>
<head>
<title>SMS Sistemleri</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="stylesheet" type="text/css" href="_gerekli/style.css">
</head>
<body bgcolor="#FFFFFF" background="_image/back.gif" style="margin: 0px; cursor:default" onMouseOver="window.defaultStatus='SMS Sistemleri'; return true" onLoad="window.defaultStatus='SMS Sistemleri'">
<script language='JavaScript' type="text/javascript">
<!--
 function yenipencere(){
  window.open('panel/<? echo $klasor ?>','smssistemleri','width=400,height=500,resizable=no,scrollbars=yes');
 }

 yenipencere();
//-->
</script>
<div align="center">
<TABLE bgcolor="#FFFFFF" align="center" border="0" cellpadding="0" cellspacing="0" width="374" height="100%" style="border: 2px dotted #666666; border-top: 0px; border-bottom: 0px">
 <TR>
  <TD width="374" height="150" align="center" valign="bottom">
   <img src="_logo/180-70.gif" width="180" height="70" border="0">
  </TD>
 </TR>
 <TR>
  <TD height="100" align="center" valign="middle">
   <font class="baslik">Giriş yapıldı: <? echo $ad ?></font>
  </TD>
 </TR>
 <TR>
  <TD height="100%" align="center" valign="top">
   <b>Başarılı bir şekilde giriş yapıldı.</b><br><br>
   Tüm SMS işlemlerinizi yapabileceğiniz panelimiz,<br>yeni pencerede açılacaktır.<br><br>
   <a href="javascript:yenipencere()" class="bilgi">Pencereyi yeniden aç</a>  |  <a href="cikis.php" class="bilgi">Çıkış yap</a>
  </TD>
 </TR>
</TABLE>
</div>
</body>
</html>
<?
}
else header("Location: index.php?hata=Kullanıcı adı ve/veya şifre hatalı!");
?>
