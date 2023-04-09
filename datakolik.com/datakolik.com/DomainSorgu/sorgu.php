


<center><form action="sorgu.php" method="POST">
							<img border="0" src="sorgu/banner[2].jpg" width="365" height="80"><p>
							<font face="Aniron"><b>WebMafia Domain Sorgu Scripti</b></font></p>
							<p>&nbsp;</p>
							<p>www.<input name="domain" type="text" size="20" onFocus="this.value=''" value="" class="form" style="font-weight:normal;text-align:center">   
							<input name="gonder" type="submit" value="Tamam" class="buton" style="height:18px">
							</p>
							<p><b>Sadece <font color="#FF0000">com</font>/<font color="#FF0000">net</font>/<font color="#FF0000">org</font></b></p>
							<p>&nbsp;
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
<font color="#FF0000" size="5">
<b>Bu alan Adý Boþ</b></font>
<?php
 }
 else
   echo "<center><font color=red>Bu Alan Adý <b>Dolu</b>!</font><br>Lütfen Baþka Bir Alan Adý Deneyiniz...<br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
 }
 else
   echo "<center><font color=red>Bu Alan Adý <b>Geçersiz</b>!</font><br>Lütfen Baþka Bir Alan Adý Deneyiniz...<br><br><a href='javascript:history.go(-1)'>Geri</a></center>";
}


?></p>
						</form></center>