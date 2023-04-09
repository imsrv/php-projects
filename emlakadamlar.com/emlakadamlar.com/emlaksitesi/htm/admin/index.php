<?
	require_once("config.php");
	if($_GET[module]=='logout'){setcookie("user",null,time()-3600);goTo("index.php");}

	if (($_GET[module] != "login") && (!$_COOKIE[user])) 
		header("Location: index.php?module=login");

	if($_POST[btnSetPassword]){
		getSetPassword($_POST[txtOldPassword],$_POST[txtNewPassword1],$_POST[txtNewPassword2]);
	}

	if($_POST[btnLogin]) {
		if($_POST[txtUserName] && $_POST[txtPassword]) {
			if (getLoginCheck($_POST[txtUserName],$_POST[txtPassword])) {
				if (getUserActive($_POST[txtUserName])) {
					setUser($_POST[txtUserName]);

					$query = "UPDATE tblAdminUser SET user_lastip='.getIp().',user_lastlogindate='.getDates().' WHERE user_user='.getUser().'";
					$results = mysql_query($query);
					
					showMessage("Hoþgeldiniz");
					goTo("index.php?module=main");
				} else showMessage("Panel haklarýnýz geçici olarak kapatýlmýþtýr. Lütfen site yöneticinize baþvurunuz.");
			} else showMessage("Kullanýcý Adý / Þifre bilgilerinizi kontrol ediniz.");
		}else{
			goTo("index.php?module=login");
		}
	}

	$DuzSatir1 = " class=\"DuzTabloSatir1\"";
	$DuzSatir2 = " class=\"DuzTabloSatir2\"";
	$SecSatir1 = " class=\"SecTabloSatir1\" onmouseover=\"this.className='TabloSatirOver';\" onmouseout=\"this.className='SecTabloSatir1';\" onmousedown=\"this.className='TabloSatirDown';\" onmouseup=\"this.className='TabloSatirOver';\"";
	$SecSatir2 = " class=\"SecTabloSatir2\" onmouseover=\"this.className='TabloSatirOver';\" onmouseout=\"this.className='SecTabloSatir2';\" onmousedown=\"this.className='TabloSatirDown';\" onmouseup=\"this.className='TabloSatirOver';\"";
?>
<html>
<head>
<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-9">
<LINK REL="stylesheet" type="text/css" href="admin.css" >
<title>Emlak Adamlar - Yönetim Paneli</title>
<script type="text/javascript" language="JavaScript">
	function ress(resname,ressize){
		var h1,w1;
		myImage1 = new Image(); 
		myImage1.src = document.getElementById(resname).src;
		h1 = myImage1.height;w1 = myImage1.width;
		document.getElementById(resname).src = myImage1.src;
		if( h1>w1 ){document.getElementById(resname).height=ressize;}
		else{document.getElementById(resname).width=ressize;}
		}
</script>
	<script>
		function areYouSure(sureLink) {
			getSure = confirm('Are you sure?');
			if (getSure) {
				window.location.href=sureLink;
			} else {
				window.location.href='#';
			}
			
		}
	</script>
    <style type="text/css">
<!--
.style1 {
	font-size: 12pt;
	font-weight: bold;
}
-->
    </style>
</head>
<body topmargin="0" leftmargin="0">
<table height="100%" cellSpacing="0" cellPadding="0" width="100%" border="1" bgcolor="#EFEFEF" style="border-collapse: collapse" bordercolor="#111111">
  <tr>
    <td vAlign="top">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt; color: #333333" bordercolor="#FFFFFF" width="100%" id="AutoNumber1" bgcolor="#FFFFFF">
  <tr>
    <td width="100%" colspan="2" align="center" style="border-top-style: solid; border-top-width: 1">
    <p style="margin-top: 5; margin-bottom: 5"><span class="style1">Emlak Adamlar</span>    
    <p style="margin-top: 5; margin-bottom: 5">
    <font color="#994800" style="font-size: 16pt"><b>Yönetim Paneli</b></font></td>
  </tr>
  <tr>
    <td width="20%" valign="top" bgcolor="#F0F0F0" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size: 10pt" bordercolor="#111111" width="100%" id="AutoNumber2">
      <tr>
        <td width="100%" bgcolor="#E2E2E2" style="border-top-style: solid; border-top-width: 1">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5">        </td>
      </tr>
	  <?
	  	if ($_COOKIE[user]) {
	  ?>
      <tr>
        <td nowrap width="100%" bgcolor="#F0F0F0">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5">
        <font size="1"><b><?=getUser()?>[<a href="index.php?module=logout" style="text-decoration: none"><font color="#333333">X</font></a>]</b></font></td>
      </tr>
	  <?
	  	} else {
	  ?>
      <tr>
        <td nowrap width="100%" bgcolor="#F0F0F0">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5">
        <font size="1"><b>Lütfen giriþ yapýnýz. »</b></font></td>
      </tr>
	  <?
	  	}
	  ?>
	  <?
	  	if ($_COOKIE[user]) {
	  ?>
      <tr>
        <td width="100%" bgcolor="#E2E2E2" style="border-bottom-style: none; border-bottom-width: medium; padding-left: 0; padding-right: 4; padding-top: 1; padding-bottom: 1">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5"><b>» </b>
        <a href="index.php?module=main" style="text-decoration: none">
        <font color="#333333">Ana Sayfa</font></a></td>
      </tr>
      <tr>
        <td nowrap width="100%" bgcolor="#F0F0F0">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5"><b>» </b>
        <a href="index.php?module=setpassword" style="text-decoration: none">
        <font color="#333333">Þifre Deðiþtir </font></a></td>
      </tr>
      <tr>
        <td nowrap width="100%" bgcolor="#E2E2E2">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5"><b>» </b>
        <a href="index.php?module=realty" style="text-decoration: none">
        <font color="#333333">Emlaklar</font></a></td>
      </tr>
      <tr>
        <td nowrap width="100%" bgcolor="#F0F0F0">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5"><b>» </b>
        <a href="index.php?module=city" style="text-decoration: none">
        <font color="#333333">Þehirler</font></a></td>
      </tr>
      <tr>
        <td nowrap width="100%" bgcolor="#E2E2E2">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5"><b>» </b>
        <a href="index.php?module=realtytype" style="text-decoration: none">
        <font color="#333333">Emlak Tipleri</font></a></td>
      </tr>
      <tr>
        <td nowrap width="100%" bgcolor="#F0F0F0">
        <p style="margin-left: 10; margin-top: 5; margin-bottom: 5"><b>» </b>
        <a href="index.php?module=form" style="text-decoration: none">
        <font color="#333333">Form Verileri</font></a></td>
      </tr>
	  <?
	  	}
	  ?>
      </table>
    </td>
    <td width="80%" valign="top" style="border-left:medium none #666666; border-right:medium none #666666; border-top:1px solid #666666; border-bottom:medium none #666666; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">
	<?
		if ($_GET["module"] == "login") require_once("login.php");
		elseif ($_GET["module"] == "setpassword") require_once("setpassword.php");

		elseif ($_GET["module"] == "realtytype") require_once("realtytype.php");
		elseif ($_GET["module"] == "realty") require_once("realty.php");
		elseif ($_GET["module"] == "city") require_once("city.php");
		elseif ($_GET["module"] == "form") require_once("form.php");
		else require_once("main.php");
	?>
		</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="right" bgcolor="#F0F0F0">
    <p style="margin-top: 5; margin-bottom: 5"><font size="1">| Designed by
    </font>
    <a href="http://www.hazarajans.com" target="_blank" style="text-decoration: none; font-weight: 700">
    <font size="1" color="#333333">Hazar Ajans</font></a></td>
  </tr>
</table>
    </td>
  </tr>
</table>
</body>
</html>
<?
	mysql_close($connection);
?>