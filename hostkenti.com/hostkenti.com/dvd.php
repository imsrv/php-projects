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
            <font color="#ffffff">Kampanyalar : DVD Kampanyas�</font></font></td>
        </tr>
      </tbody></table>
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="548">
        <tbody><tr> 
          <td height="5"><img src="images/spc.gif" alt="" height="1" width="1"></td>
        </tr>
        <tr> 
          <td class="content" valign="top"> <h2>DVD Kampanyas�.</h2>
           
            <br><p class="gtext">
<? 
switch($posta)
{
case 'gonder':

$subject = 'DVD Kampanyas�';
$emailadd = 'satis@hostevim.com';

$today = date("m.d.y G:i:s T");

$text = "
Domain				: ".$domain."
Kullan�c� E-Postas�	: ".$email."
Al�c� Adi			: ".$isim."
Al�c� Adresi		: ".$adres."
Al�c� ili			: ".$sehir."
Al�c� �lkesi		: ".$ulke."
Al�c� Telefonu		: ".$telefon."

### S�PAR� B�LG�LER� ###
G�nderim Tarihi		: ".$today."
G�nderen IPsi		: ".$_SERVER['REMOTE_ADDR']."
G�nderen Taray�c�s�	: ".$_SERVER['HTTP_USER_AGENT']."
";       
mail($emailadd, $subject, $text, 'From: '.$email.'');
echo ("<font color='red'><CENTER><B>DVD iste�iniz elimize ula�m��t�r, domain ve eposta kombinasyonu kontrol edilip; En k�sa zamanda DVDniz g�nderilicektir.<br>�lginiz i�in te�ekk�r ederiz.</B><br></CENTER></font><BR><BR>");
break; }
?>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1">
<B>DVD ��eri�i ve Detaylar�</B>
	</TD>
</TR>
<TR>
	<TD>
<B>1.</B> 700mb boyutunda internet scriptleri ar�ivi (ASP*, PHP, CGI, PERL).<BR>
<B>2.</B> 3gb boyutunda grafikleren (Resim, clipart vb.) olu�an dev ar�iv.<BR>
<B>3.</B> �zel DVD kutusunda eve teslim.<BR>
	</TD>
</TR>
</TABLE>
<CENTER><font size="1">* ASP Scriptler sunucular�m�zda �al��mamaktad�r.</font></CENTER>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Ba��</a><BR>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1">
<B>DVD Kampanyas� Ko�ular�</B>
	</TD>
</TR>
<TR>
	<TD>
<B>1.</B> Eski ve yeni t�mkullan�c�lar�m�z bu kampanyadan yararlanabilirler.<BR>
<B>2.</B> Kampanya Host100 ve �zeri hosting paketi veya bayii paketlerinden herhangi birine sahip olan kullan�c�lar�m�zi�in ge�erlidir.<BR>
<B>3.</B> DVDniz Aras veya UPS kargo ile g�nderilicektir. Kargo �creti Al�c�ya aittir.<BR>
<B>4.</B> E�er DVD Kampanyam�zdan yararlanmak istiyorsan�z, a�a��daki formu doldurunuz.<BR>
<B>5.</B> DVDyi e�er evinize istemiyorsan�z size yak�n Aras veya UPS Kargoya ait �ube ad�n� yaz�n�z.<BR>
	</TD>
</TR>
</TABLE>
</p>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Ba��</a>
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
        	<p align="left"><font face="verdana" size="2">Ad�n�z, Soyadiniz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="isim" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">A��k Adresiniz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="adres" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">�l:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="sehir" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">�lke:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="ulke" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Telefon Numaran�z:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="telefon" value="">
			</td>
        	</tr>
			<tr>
        	<td colspan="2">
        	<center><input type="hidden" size="50" name="posta" value="gonder">
			<input type='submit' Value=' Yollay�n '></center></td>
        	</tr>
		</table>
 <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Ba��</a>            </p></td>
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