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
						<b>&nbsp;&nbsp;Sadece 7.99$/y�l!</b><br>&nbsp;&nbsp;Elmasg�ne�.Net sizi alan ad� sahibi yapmaya kararl�. Y�ll�k sadece 7.99 dolar �deyerek kendi alan ad�n�za sahip oluyorsunuz. F�rsat� ka��rmay�n, hemen bir alan ad� kay�t edin!<br><br>
						<b>&nbsp;&nbsp;Y�ll�k hosting �yeliklerinde alan ad� �cretsiz!</b><br>&nbsp;&nbsp;Elmasg�ne�.Net'ten alaca��n�z herhangi bir hosting paketinin �demesini y�ll�k olarak yaparsan�z, istedi�iniz bir alan ad�n� sizin ad�n�za kay�t ediyoruz. Hemde ek bir �cret �demeden!<br><br><br><br>
						<b>&nbsp;&nbsp;�stedi�iniz alan ad�n� kay�t ettirmek i�in l�tfen �nce alan ad�n� kontrol ediniz:</b><br>
						<center><form action="alan_adi.php" method="POST">
							www.<input name="domain" type="text" size="20" onFocus="this.value=''" value="" class="form" style="font-weight:normal;text-align:center">���
							<input name="gonder" type="submit" value="Tamam" class="buton" style="height:18px">
						</form></center>
						<br><br><b>&nbsp;&nbsp;Not:</b> Girece�iniz Alan Ad� <b>istediginizisim.com</b> (.net,.org v.b. de olabilir) �eklinde olmal�d�r.
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
<input type="hidden" name="urun" value="Alan Ad�">
<input type="hidden" name="paket" value="Alan Ad�">
<input type="submit" value="Bu Alan Ad� bo�! Sipari� vermek i�in t�klay�n" class="buton">
</form>
</center>
<?php
 }
 else
   echo "<center><font color=red>Bu Alan Ad� <b>Dolu</b>!</font><br>L�tfen Ba�ka Bir Alan Ad� Deneyiniz...<br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
 }
 else
   echo "<center><font color=red>Bu Alan Ad� <b>Ge�ersiz</b>!</font><br>L�tfen Ba�ka Bir Alan Ad� Deneyiniz...<br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
}

if ( !@include("sayfa_sonu.php") ){ require("hata.php"); exit(); }
?>