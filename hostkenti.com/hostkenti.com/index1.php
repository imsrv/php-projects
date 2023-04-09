<?
include ("sources/global.php");
include ("sources/header.php");
//include ("sources/kur_guncelle.php");
//include ("sources/kur.php");
?><head>
	
<script language="JavaScript1.2">

var ie=document.all
var dom=document.getElementById
var ns4=document.layers
var calunits=document.layers? "" : "px"

var bouncelimit=64
var direction="up"

function initbox(){
if (!dom&&!ie&&!ns4)
return
crossobj=(dom)?document.getElementById("dropin").style : ie? document.all.dropin : document.dropin
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
crossobj.top=scroll_top-250+calunits
crossobj.visibility=(dom||ie)? "visible" : "show"
dropstart=setInterval("dropin()",50)
}

function dropin(){
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
if (parseInt(crossobj.top)<100+scroll_top)
crossobj.top=parseInt(crossobj.top)+40+calunits
else{
clearInterval(dropstart)
bouncestart=setInterval("bouncein()",50)
}
}

function bouncein(){
crossobj.top=parseInt(crossobj.top)-bouncelimit+calunits
if (bouncelimit<0)
bouncelimit+=8
bouncelimit=bouncelimit*-1
if (bouncelimit==0){
clearInterval(bouncestart)
}
}

function dismissbox(){
if (window.bouncestart) clearInterval(bouncestart)
crossobj.visibility="hidden"
}

function truebody(){
return (document.compatMode!="BackCompat")? document.documentElement : document.body
}


window.onload=initbox

</script>
</head>

<div id="dropin" style="position:absolute;visibility:hidden;left:200px;top:100px;width:500px;height:300px">

<div align="right">
<table style="border-collapse: collapse;" border="1" bordercolor="#AFAFAF" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#002DD4">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<TR>
		<TD width="90%"><B><font color="white">Kampanya</font></B></TD>
		<TD align="right" width="10%"><a class="w" href="#" onClick="dismissbox();return false"><IMG SRC="<? echo ($adress); ?>images/close.gif" WIDTH="14" HEIGHT="14" BORDER="0"></a></TD>
	</TR>
	</TABLE>
	</TD>
</TR>
<TR>
	<TD bgcolor="white"><TABLE>
	<TR>
		<TD><IMG SRC="<? echo ($adress); ?>images/dvd.jpg" WIDTH="140" HEIGHT="89" BORDER="0"></TD>
		<TD><B>Host100</B> ve üzeri hosting sipariþi yapan kullanýcýlarýmýza;<BR>Script ve Clipartlardan oluþan <B>müthiþ</B> dvd hediyemizdir.<BR><BR>Tek yapmanýz gereken sipariþ formuna gerçek adresinizi yazmanýz ve eke dvd istediðinizi belirtmenizdir.<BR><BR><font size="1">Kargo ücreti alýcýya aittir.</font><BR><BR><A HREF="<? echo ($adress); ?>kampanya">Tüm kampanyalarýmýzý görmek için týklayýnýz.</A></TD>
	</TR>
	</TABLE></TD>
</TR>
</TABLE>
</div>
</div>
<table class="line" align="center" border="0" cellpadding="0" cellspacing="0" width="775">
  <tbody><tr>
    <td><img src="<? echo ($adress); ?>images/sp.gif" alt="" height="12" width="1"></td>
  </tr>
</tbody></table>
<table class="border" align="center" border="0" cellpadding="0" cellspacing="0" width="775">
  <tbody><tr valign="top"> 
    <td bgcolor="#f7f3ea" width="552">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td background="<? echo ($adress); ?>images/rotate.jpg" valign="top"><img src="<? echo ($adress); ?>images/spc.gif" border="0" height="198" width="552"></td>
        </tr>
      </tbody></table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td class="here" valign="top"><img src="<? echo ($adress); ?>images/ar2.gif" alt="" height="11" width="11"> 
            Hostkenti'ne Hoþgeldiniz...</td>
        </tr>
      </tbody></table>
      <table border="0" cellpadding="0" cellspacing="0" width="548">
        <tbody><tr>
          <td class="plt" valign="top"><img src="<? echo ($adress); ?>images/spc.gif" alt="" height="38" width="1"></td>
        </tr>
        <tr>
          <td class="bgpl" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="548">
              <tbody><tr valign="top"> 
                <td class="pl1" width="34%"><img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> 
                  <strong>10mb</strong> Web Alaný <br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>100mb</strong> 
                  Aylýk Transfer<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>10 Adet</strong> 
                  eposta hesabý<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>1 Adet</strong> 
                  Veritabaný<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>Cpanel</strong> 
                  Kontrol Paneli<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7">  <strong>1 
                  </strong>Alan Adý Barýndýrma<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> Açýlýþ Ücreti <strong>Yok</strong></td>
                <td class="pl1" width="34%"><img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> 
                  <strong>1000mb</strong> Web Alaný <br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>10000mb</strong> 
                  Aylýk Transfer<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>50 Adet</strong> 
                  eposta hesabý<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>5 Adet</strong> 
                  Veritabaný<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>Cpanel</strong> 
                  Kontrol Paneli<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7">  <strong>1 
                  </strong>Alan Adý Barýndýrma<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> Açýlýþ Ücreti <strong>Yok</strong></td>
                <td class="pl2"><img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> 
                  <strong>1000mb</strong> Web Alaný <br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>10000mb</strong> 
                  Aylýk Transfer<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>Sýnýrsýz</strong> 
                  eposta hesabý<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>Sýnýrsýz</strong> 
                  Veritabaný<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> <strong>Cpanel</strong> 
                  Kontrol Paneli<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7">  <strong>Sýnýrsýz 
                  </strong>Alan Adý<br>
                  <img src="<? echo ($adress); ?>images/ar1.gif" alt="" height="7" width="7"> Açýlýþ Ücreti <strong>Yok</strong></td>
              </tr>
            </tbody></table></td>
        </tr>
        <tr>
          <td class="prices" valign="top"><img src="<? echo ($adress); ?>images/spc.gif" alt="" height="26" width="1"></td>
        </tr>
        <tr>
          <td class="min" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="548">
              <tbody><tr>
                <td width="185"> 
                  <div align="right"><a href="<? echo ($adress); ?>hosting" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('host1','','images/moreo.gif',1)"><img src="<? echo ($adress); ?>images/more.gif" name="host1" border="0" height="18" width="97"></a></div></td>
                <td width="183"> 
                  <div align="right"><a href="<? echo ($adress); ?>hosting" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('host2','','images/moreo.gif',1)"><img src="<? echo ($adress); ?>images/more.gif" name="host2" border="0" height="18" width="97"></a></div></td>
                <td><div align="right"><a href="<? echo ($adress); ?>hosting/bayii.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('host3','','images/moreo.gif',1)"><img src="<? echo ($adress); ?>images/more.gif" name="host3" border="0" height="18" width="97"></a></div></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table>
      <table border="0" cellpadding="0" cellspacing="0" width="548">
        <tbody><tr> 
          <td class="ssl"><img src="<? echo ($adress); ?>images/spc.gif" alt="" height="19" width="1"></td>
        </tr>
        <tr>
          <td height="5"><img src="<? echo ($adress); ?>images/spc.gif" alt="" height="1" width="1"></td>
        </tr>
        <tr> 
          <td><table class="bord" align="center" border="0" cellpadding="0" cellspacing="0" width="530">
              <tbody><tr> 
                <td valign="top"><img src="<? echo ($adress); ?>images/ssl2.gif" align="left" border="0" height="94" width="99">
                    <div style="padding-top: 10px; padding-right: 10px;" align="justify"><B>05.10.2006</B> - Hosting fiyatlarý %20 indirildi...<br><B>05.10.2006</B> - Host100 ve üzeri için DVD Kampanyamýz baþladý.<br><B>05.10.2006</B> - hostkenti.com sitesi yenilendi.<br><B>01.10.2006</B> - Sunucu aylýk genel bakýmýndan geçti.<br><B>01.09.2006</B> - Sunucu aylýk genel bakýmýndan geçti.
                    <br>
                </div></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table> </td>
    <td class="bgright"><table border="0" cellpadding="0" cellspacing="0" width="98%">
        <tbody><tr> 
          <td valign="top"><img src="<? echo ($adress); ?>images/t1.gif" alt="" height="26" width="200"></td>
        </tr>
        <tr> 
          <td class="pad" height="27" valign="top">Kendinize ait Alan adýný sadece<strong> $8.00</strong>'a yýllýk alabilirsiniz.</td>
        </tr>
        <tr> 
          <td valign="top"><form method="post" action="http://www.basket-bol.com/host/sources/whois_class.php" target="_self">
              <div align="left"> 
                <table class="gtext" align="center" border="0" cellpadding="0" cellspacing="0" width="198">
                  <tbody><tr> 
                    <td width="71%"> <div align="right"> 
                        <input name="domain" value="Alan Adýnýzý Buraya Yazýnýz" class="box1" size="20" maxlength="63" onblur="if(this.value=='') this.value='Alan Adýnýzý Buraya Yazýnýz';" onfocus="if(this.value=='Alan Adýnýzý Buraya Yazýnýz') this.value='';" type="text">
                      </div></td>
                    <td width="29%"> <div align="right"> 
                        <select name="tld_extension" class="box2"><option selected="selected">com</option><option>net</option><option>org</option><option>us</option><option>biz</option><option>info</option><option>name</option></select>
                      </div></td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="sub"> <div align="right"> 
                        <input name="submit" value="   " class="submit" type="submit">
                      </div></td>
                  </tr>
                </tbody></table>
              </div>
            </form></td>
        </tr>
      </tbody></table>

        
      <table class="bgw" border="0" cellpadding="0" cellspacing="0" width="99%">
        <tbody><tr> 
          <td valign="top"><img src="<? echo ($adress); ?>images/esp.gif" alt="" height="6" width="215"></td>
        </tr>
        <tr> 
          <td valign="top"><img src="<? echo ($adress); ?>images/t2.gif" alt="" height="22" width="206"></td>
        </tr>
        <tr> 
          <td class="pad" valign="top"><img src="<? echo ($adress); ?>images/cr.gif" alt="" align="right" height="47" width="93">Kullanýmý kolay, ucuz ve yeniden satýlabilen bayii paketlerimiz; Kazancýnýzý katlýyabilir... <br> 
          <a href="<? echo ($adress); ?>hosting/bayii.php">Daha Fazla Bilgi</a> <strong><font color="#ff6600">»</font></strong></td>
        </tr>
        <tr> 
          <td valign="top"><img src="<? echo ($adress); ?>images/esp.gif" alt="" height="6" width="215"></td>
        </tr>
        <tr> 
          <td><img src="<? echo ($adress); ?>images/t3.gif" alt="" height="22" width="206"></td>
        </tr>
        <tr> 
          <td valign="top"><div align="right"><img src="<? echo ($adress); ?>images/serv.gif" alt="" height="26" width="206"></div></td>
        </tr>
        <tr> 
          <td class="pad" valign="top">Geniþ Projeniz, Büyük siteniz veya bayii paketlerimiz size yetmiyorsa kiralýk sunucular sizin için en iyi seçim olucaktýr. Ayrýca ihtiyacýnýzdan fazla hýz ve güvenlik özellikleriyle sitenizi daha özel yapabilirsiniz.<BR><a href="<? echo ($adress); ?>sunucu">Daha Fazla Bilgi</a> <strong><font color="#ff6600">»</font></strong></td>
        </tr>
        <tr> 
          <td valign="top"><img src="<? echo ($adress); ?>images/esp.gif" alt="" height="6" width="215"></td>
        </tr>
        <tr> 
          <td class="help" valign="top"><strong><font color="#ff6600">»</font> 
            Döviz Kuru</strong><br>&nbsp;&nbsp;USD:1.45 YTL<BR><BR>
            <strong><font color="#ff6600">»</font>
            DNS Ayarlarý</strong><br>
            &nbsp;&nbsp;ankara.hostkenti.com<BR>
            &nbsp;&nbsp;istanbul.hostkenti.com<BR>
            </td>
        </tr>
      </tbody></table>
      <br>

    
    </td>
  </tr>
</tbody></table>
<?
include ("sources/footer.php");
?>