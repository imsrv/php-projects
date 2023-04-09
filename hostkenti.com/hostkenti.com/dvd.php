<?
include ("../sources/global.php");
include ("../sources/header.php");
if(isset($HTTP_GET_VARS['posta']))
{
 $posta = $HTTP_GET_VARS['posta'];
}
else
{
 $posta = '0';
}
?>
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
          <td valign="top"><img src="<? echo ($adress); ?>images/inpic3n.jpg" alt="" height="119" width="552"></td>
        </tr>
      </tbody></table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td class="here" valign="top"><img src="<? echo ($adress); ?>images/ar2.gif" alt="" height="11" width="11"> 
            <a class="w" href="<? echo ($adress); ?>index.htm"> Hostevim</a> <font color="#ffff00">&#8226; 
            <font color="#ffffff">Kampanyalar : DVD Kampanyasý</font></font></td>
        </tr>
      </tbody></table>
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="548">
        <tbody><tr> 
          <td height="5"><img src="images/spc.gif" alt="" height="1" width="1"></td>
        </tr>
        <tr> 
          <td class="content" valign="top"> <h2>DVD Kampanyasý.</h2>
           
            <br><p class="gtext">
<? 
switch($posta)
{
case 'gonder':

$subject = 'DVD Kampanyasý';
$emailadd = 'satis@hostevim.com';

$today = date("m.d.y G:i:s T");

$text = "
Domain				: ".$domain."
Kullanýcý E-Postasý	: ".$email."
Alýcý Adi			: ".$isim."
Alýcý Adresi		: ".$adres."
Alýcý ili			: ".$sehir."
Alýcý Ülkesi		: ".$ulke."
Alýcý Telefonu		: ".$telefon."

### SÝPARÝ BÝLGÝLERÝ ###
Gönderim Tarihi		: ".$today."
Gönderen IPsi		: ".$_SERVER['REMOTE_ADDR']."
Gönderen Tarayýcýsý	: ".$_SERVER['HTTP_USER_AGENT']."
";       
mail($emailadd, $subject, $text, 'From: '.$email.'');
echo ("<font color='red'><CENTER><B>DVD isteðiniz elimize ulaþmýþtýr, domain ve eposta kombinasyonu kontrol edilip; En kýsa zamanda DVDniz gönderilicektir.<br>Ýlginiz için teþekkür ederiz.</B><br></CENTER></font><BR><BR>");
break; }
?>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1">
<B>DVD Ýçeriði ve Detaylarý</B>
	</TD>
</TR>
<TR>
	<TD>
<B>1.</B> 700mb boyutunda internet scriptleri arþivi (ASP*, PHP, CGI, PERL).<BR>
<B>2.</B> 3gb boyutunda grafikleren (Resim, clipart vb.) oluþan dev arþiv.<BR>
<B>3.</B> Özel DVD kutusunda eve teslim.<BR>
	</TD>
</TR>
</TABLE>
<CENTER><font size="1">* ASP Scriptler sunucularýmýzda çalýþmamaktadýr.</font></CENTER>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a><BR>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1">
<B>DVD Kampanyasý Koþularý</B>
	</TD>
</TR>
<TR>
	<TD>
<B>1.</B> Eski ve yeni tümkullanýcýlarýmýz bu kampanyadan yararlanabilirler.<BR>
<B>2.</B> Kampanya Host100 ve üzeri hosting paketi veya bayii paketlerinden herhangi birine sahip olan kullanýcýlarýmýziçin geçerlidir.<BR>
<B>3.</B> DVDniz Aras veya UPS kargo ile gönderilicektir. Kargo ücreti Alýcýya aittir.<BR>
<B>4.</B> Eðer DVD Kampanyamýzdan yararlanmak istiyorsanýz, aþaðýdaki formu doldurunuz.<BR>
<B>5.</B> DVDyi eðer evinize istemiyorsanýz size yakýn Aras veya UPS Kargoya ait þube adýný yazýnýz.<BR>
	</TD>
</TR>
</TABLE>
</p>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="1" width="100%">
<form method="get"><tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Domaininiz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="domain" value="">
			</td>
        	</tr><tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Eposta adresiniz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="email" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Adýnýz, Soyadiniz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="isim" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Açýk Adresiniz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="adres" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Ýl:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="sehir" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Ülke:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="ulke" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Telefon Numaranýz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="telefon" value="">
			</td>
        	</tr>
			<tr>
        	<td colspan="2">
        	<center><input type="hidden" size="50" name="posta" value="gonder">
			<input type='submit' Value=' Yollayýn '></center></td>
        	</tr>
		</table>
 <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a>            </p></td>
        </tr>
      </tbody></table> </td>
    <td class="bgright"><table cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr> 
          <td class="subm" valign="top">Kampanyalar</td>
        </tr>
        <tr> 
          <td align="right" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
              <tbody>
              <? include ("menu.php");?>
            </tbody></table></td>
        </tr>
      </tbody></table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td><img src="<? echo ($adress); ?>images/esp.gif" alt="" height="6" width="215"></td>
        </tr>
      </tbody></table>
      <br>

      <br>
    </td>
  </tr>
</tbody></table>
<?
include ("../sources/footer.php");
?>