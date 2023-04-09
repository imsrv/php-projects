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
            <a class="w" href="<? echo ($adress); ?>index.php"> Hostkenti</a> <font color="#ffff00">&#8226; 
            <font color="#ffffff">Ýletiþim Bilgileri</font></font></td>
        </tr>
      </tbody></table>
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="548">
        <tbody><tr> 
          <td height="5"><img src="images/spc.gif" alt="" height="1" width="1"></td>
        </tr>
        <tr> 
          <td class="content" valign="top"> <h2>Ýletiþim Bilgileri</h2>
           
            <br>

<? switch($posta)
{
 case 'gonder': $konu = ("Destek Formu"); echo("Mesajýnýz elimize ulaþmýþtýr en kýsa zamanda size cevap verilicektir.<br>ilginiz için teþekkür ederiz.<br>"); 
 mail($departman, $konu, $mesaj, 'From: '.$emailadd.''); break; }?>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1" colspan="2">
Hostkenti Ofis
	</TD>
</TR>
<TR>
	<TD width="30%" valign="top">Adres:</TD>
	<TD width="70%">Pembeay Sokak 45/5 Bakirkoy Ýstanbul<br>
</TD>
</TR>
<TR>

</TR>
<TR>

</TR>
</TABLE>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a>            </p><BR><BR>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1" colspan="2">
E-Posta Adreslerimiz
	</TD>
</TR>
<TR>
	<TD width="30%" valign="top">Satýþ Departmaný:</TD>
	<TD width="70%">satis@hostkenti.com</TD>
</TR>
<TR>
	<TD width="30%" valign="top">Destek Departmaný:</TD>
	<TD width="70%">destek@hostkenti.com</TD>
</TR>
</TABLE>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a>            </p><BR><BR>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="0" width="100%">
<TR>
	<TD bgcolor="#EDE4D1" colspan="2">
24 saat canlý destek hatlarý (MSN)
	</TD>
</TR>
<TR>
</TR>
<TR>
	<TD width="30%" valign="top">Destek Departmaný:</TD>
	<TD width="70%">support@hostkenti.com</TD>
</TR>
<TR>
	<TD width="30%" valign="top">Destek Departmaný:</TD>
	<TD width="70%">destek@hostkenti.com</TD>
</TR>
<TR>
	
</TR>
<TR>

</TR>
</TABLE>
            <p align="right"><br>
            <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a>            </p><BR><BR>

<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="1" width="100%"><tr height="25">
		<td colspan="2" bgcolor="#EDE4D1" width="100%">
		<p align="left"><font face="verdana" size="2"><b>Hýzlý E-Posta</b></font></p></td>
        	</tr>
<form method="get"><tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Eposta adresiniz:</font></p></td>

        	<td width="70%">
<input type="text" size="50" name="emailadd" value="">
			</td>
        	</tr>
        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Ýlgili Departman:</font></p></td>

        	<td width="70%">
<select name="departman" style="width:350px">
                      <option value="satis@hostkenti.com" selected>Satýþ Departmaný</option>
                      <option value="destek@hostkenti.com" >Destek Departmaný</option>
                      </select>
			</td>
        	</tr><tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Mesaj:</font></p></td>

        	<td width="70%">
<textarea name="mesaj" rows="2" cols="46"></textarea>
			</td>
        	</tr><tr>
        	<td colspan="2">
        	<center><input type="hidden" size="50" name="posta" value="gonder">
			<input type='submit' Value=' Yollayýn '></center></td>
        	</tr>
		</table>


</td>
        </tr>
      </tbody></table> </td>
    <td class="bgright"><table cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr> 
          <td class="subm" valign="top">Hakkýmýzda</td>
        </tr>
        <tr> 
          <td align="right" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
              <tbody>
              <tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hakkimizda/referanslar.php"> Referanslar
                  </a></td>
              </tr>
              <tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hakkimizda/iletisim.php"> Ýletiþim Bilgileri
                  </a></td>
              </tr>
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