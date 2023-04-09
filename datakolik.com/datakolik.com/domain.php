<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="Desing" content="BY ROMEO">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<link rel="stylesheet" href="imagess/style.css">
<meta name="ProgId" content="FrontPage.Editor.Document">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 30px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

<title>DataKolik.Com WebHosting Linux Hosting Windows Hosting Radyo Hosting
</title>
<center>
  <table width="660" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><map name="FPMap0">
    <area href="index.php" shape="rect" coords="41, 111, 121, 129">
    <area href="hosting.php" shape="rect" coords="182, 110, 244, 129">
    <area href="domain.php" shape="rect" coords="280, 112, 351, 129">
    <area href="referans.php" shape="rect" coords="380, 111, 452, 130">
    <area target="_blank" href="http://www.datakolik.com/destek" shape="rect" coords="469, 112, 543, 130">
    <area href="irtibat.php" shape="rect" coords="565, 112, 618, 130">
    </map>
    <img border="0" src="imagess/ust.gif" width="660" height="131" usemap="#FPMap0" /></td>
    </tr>
  <tr>
    <td>
    <iframe style="width: 100%; height: 303" id="tabiframe" name="giris" src="d.php">
    </iframe></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
    <a target="_blank" href="http://www.datakolik.com">
    <img border="0" src="imagess/alt.gif" width="660" height="18"></a></td>
    </tr>
</table>
</center>





<p align="center" style="margin-top: 0; margin-bottom: 0">
<font style="font-size: 7pt"><b>Copyright © 2005 - 2006</b><br>
<img border="0" src="powered.gif" width="629" height="38"><a href="http://www.datakolik.com" </a><br>DataKolik.com Tasarým By Romeo<br><?php 
$ip = GETENV("REMOTE_ADDR"); 
echo "Ýp Kayýt Edildi: $ip"; 
?> 

<?php 
 

$file="count.txt"; 
$data_oggi=date("d/m/Y"); 


// Prima volta in assoluto che si accede alla pagina 
if (!(file_exists($file))) 
{ 
$crea_file=fopen($file,"w"); 
$inizio="1". $data_oggi. "1"; 
fputs($crea_file,$inizio); 
fclose($crea_file); 
} 

else{ 
// Estrazione dati 
$dati=file($file); 
$visite_tot=$dati[0]; 
$data=chop($dati[1]); 
$visite_oggi=$dati[2]; 

$visite_tot=$visite_tot+1; 

// Controllo delle visite odierne 
if ($data_oggi==$data) 
{ $visite_oggi=$visite_oggi+1; } 
else 
{ $visite_oggi=1; } 

// Scrittura dati su file 
$scrivi_file=fopen($file,"w+"); 
$dati=$visite_tot."\n".$data_oggi."\n".$visite_oggi; 
fputs($scrivi_file,$dati); 
fclose($scrivi_file); 

// Visualizzazione dati 

$tabella .="Bugun Hit: $visite_oggi<br/>"; 
$tabella .="Toplam Hit: $visite_tot"; 

echo $tabella; 
} 
?>

		</td>
	</tr>

</table>

</a>

<div>&nbsp;</div>

</div>

</td>


<td width="25%"></td>

</tr>
</table>

</body>
</html>

</font>

<!-- END: FOOTER -->