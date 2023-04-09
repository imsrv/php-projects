<?php
//doviz kurunuda alalim
$dosya="http://www.tcmb.gov.tr/kurlar/today.html"; 
 $oku=file($dosya); 
 $i=0; 
 foreach($oku as $yaz) 
 if($sonuc=eregi("^[(try/usd)]+([[:space:]]+)1([[:space:]]+)",$yaz) AND ($i<2)) 
 { 
 $sonuc1[$i]=explode(" ",$yaz); 
 $j=0; 
 foreach($sonuc1[$i] as $_sonuc1) 
 { 
 if($_sonuc1!="") 
 { 
 $sonuc2[$i][$j]=$_sonuc1; 
 $j++; 
 } 
 } 
 $i++; 
 } 
 //birlestirip yazalim
 $yazdeftere="<?php \$kur = ('".$sonuc2[0][7]."') ?>";

$fp = fopen( "kur.php","w+");
if (flock($fp, 2)) { 
fwrite($fp, $yazdeftere, 100); }
echo ("$yazdeftere");
fclose( $fp ); 
?>