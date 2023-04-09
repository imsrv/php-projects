<?
$dosya="sayac.dat";

if(!file_exists($dosya)):
        $ilk=fopen($dosya,'w') or die("dosya açýlamýyor!!!");
        fwrite($ilk,"0");
        fclose($ilk);
endif;

$icerik=fopen($dosya,'r') or die("dosya açýlamýyor!!!");
$ilk_satir=(integer)fgets($icerik,1024);
fclose($icerik);
$ilk_satir++;
$ilk_satir=(string)($ilk_satir);

echo "<font style='font-size:8px'>";
for($x=0;$x<strlen($ilk_satir);$x++):
 print ("$ilk_satir[$x]");
endfor;
echo "</font>";

$yazmak=fopen($dosya,'w') or die("dosya açýlamýyor!!!");
fwrite($yazmak,$ilk_satir);
fclose($yazmak);
?>