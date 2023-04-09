<?
  # Baslýk býlgýsý
  session_start();
  header ("Content-type: image/png");
  srand((double)microtime() * 1000000);

  # Guvenlýk kodu
  $kod   = substr(md5(uniqid(rand())),0,5);
  $_SESSION["kod"] = $kod; // Kodu oturuma kaydet

  # Fontlar ..
  $font  = array(
     "tahoma.ttf",
     "verdana.ttf",
     "marydale.ttf",
     );

  # Resmý hazýrla
  $resim = @imagecreate((strlen($kod)*20)+20,50);
  $zemin = imagecreatefrompng('zemin.png');
  $metin = imagecolorallocate ($resim, 0, 0, 0);

  imagesettile($resim,$zemin);
  imagefilledrectangle($resim,0,0,(strlen($kod)*20)+20,50,IMG_COLOR_TILED);

  # Kodu bas ..
  for($i=0; $i < strlen($kod); $i++){
     shuffle($font);
     imagettftext($resim, 20, 0, 10+($i*20),35, $metin, "Font/".current($font),$kod[$i]);
     }

  # Resmi cýkart
  imagepng($resim);
  imagedestroy($resim);
?>


<p align="center" style="margin-top: 0; margin-bottom: 0">
<font style="font-size: 7pt">Copyright © 2005 - 2006<br><a href="http://www.weblebihost.com" </a><br>WeblebiHost.Com Tasarým By Romeo<br><?php 
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

<div></a></div>

</div>

</td>


<td width="25%"></td>

</tr>
</table>

</body>
</html>

<!-- END: FOOTER -->


