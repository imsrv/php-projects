<?php
$ads = array();
$digiAds = array();
$digiAdsTime = time();
$lines = file($digiAdsPath) or die();
foreach ($lines as $line) {
    $line = chop($line);
    if (($line != '') or (!ereg('^#', $line))) {
        if (ereg('^[0-9]', $line)) {
            $ads[] = $line;
        } else {
            list ($key, $val) = split('=', $line);
            $digiAds[$key] = $val;
        }
    }
}
function writeads()
{
    global $digiAdsPath, $ads, $digiAds;
    $data = fopen($digiAdsPath, 'w') or die();
    flock($data, 2) or die();
    fputs($data, @join("\n", $ads)."\n");
    while (list ($key, $val) = each ($digiAds)) {
        if (($key != '') && ($val != '')) {
            fputs($data, $key.'='.$val."\n");
        }
    } 
    fclose($data);
}
?>