<?php
$tiklama = $_GET["menu"];
if ( !@include("sayfa_basi.php") ){ require("hata.php"); exit(); }
$domain_name = $_POST["domain"];
if ( !$domain_name )
{
?>

                <table border="0" cellpadding="0" cellspacing="0" height="100%">
                <tr height="92" valign="middle">
                        <td width="576" valign="top"><br>
						<b>&nbsp;&nbsp;Sadece 7.99$/yýl!</b><br>&nbsp;&nbsp;Elmasgüneþ.Net sizi alan adý sahibi yapmaya kararlý. Yýllýk sadece 7.99 dolar ödeyerek kendi alan adýnýza sahip oluyorsunuz. Fýrsatý kaçýrmayýn, hemen bir alan adý kayýt edin!<br><br>
						<b>&nbsp;&nbsp;Yýllýk hosting üyeliklerinde alan adý ücretsiz!</b><br>&nbsp;&nbsp;Elmasgüneþ.Net'ten alacaðýnýz herhangi bir hosting paketinin ödemesini yýllýk olarak yaparsanýz, istediðiniz bir alan adýný sizin adýnýza kayýt ediyoruz. Hemde ek bir ücret ödemeden!<br><br><br><br>
						<b>&nbsp;&nbsp;Ýstediðiniz alan adýný kayýt ettirmek için lütfen önce alan adýný kontrol ediniz:</b><br>
						<center><form action="alan_adi.php" method="POST">
							www.<input name="domain" type="text" size="20" onFocus="this.value=''" value="" class="form" style="font-weight:normal;text-align:center">   
							<input name="gonder" type="submit" value="Tamam" class="buton" style="height:18px">
						</form></center>
						<br><br><b>&nbsp;&nbsp;Not:</b> Gireceðiniz Alan Adý <b>istediginizisim.com</b> (.net,.org v.b. de olabilir) þeklinde olmalýdýr.
                        </td>
                </tr>
                </table>

<?php
}
else
{
 $domain_name=$_POST["domain"];
 if ( substr_count($domain_name,".") > 0)
 {
 include( "alan_adi/main.whois");

 $whois = new Whois($domain_name);
 $result = $whois->Lookup();

 if(empty($result["regyinfo"]))
 {
?>
<center>
<form action="siparis.php" method="POST">
<input type="hidden" name="domain" value="<?php echo "$domain_name" ?>">
<input type="hidden" name="urun" value="Alan Adý">
<input type="hidden" name="paket" value="Alan Adý">
<input type="submit" value="Bu Alan Adý boþ! Sipariþ vermek için týklayýn" class="buton">
</form>
</center>
<?php
 }
 else
   echo "<center><font color=red>Bu Alan Adý <b>Dolu</b>!</font><br>Lütfen Baþka Bir Alan Adý Deneyiniz...<br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
 }
 else
   echo "<center><font color=red>Bu Alan Adý <b>Geçersiz</b>!</font><br>Lütfen Baþka Bir Alan Adý Deneyiniz...<br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
}

if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); }
?>