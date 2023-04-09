<?php
$digiAdsPath = '/path/to/digi-ads/ads.dat';
require '/path/to/digi-ads/ads.inc.php';

///////////////////////////////////////
// Don't Edit Anything Below This Line!
///////////////////////////////////////

class digiAds
{
    var $ad;
    function digiAds($max = 4, $width = 0, $height = 0)
    {
        global $ads, $digiAds, $digiAdsTime;
        $eligible = array();
        $found = 0;
        for ($i = 0; $i < count($ads); $i++) {
            $data = explode('||', $ads[$i]);
            if ($data[1] != 1) {
                continue;
            }
            if (($data[3] != '99999999') && ($data[3] < $digiAdsTime)) {
                continue;
            }
            if ($data[4] == 0) {
                continue;
            }
            if (($width != 0) && ($data[7] != $width)) {
                continue;
            }
            if (($height != 0) && ($data[8] != $height)) {
                continue;
            }
            for ($j = 0; $j < $data[2]; $j++) {
                    $eligible[] = $i;
            }
            $found++;
        }
        if ($found <= $max) {
            die();
        }
        srand((double) microtime() * 1000000);
        shuffle($eligible);
        for ($i = 0; $i < $max; $i++) {
            mt_srand((double) microtime() * 1000000);
            $theone = mt_rand(0, (count($eligible) - 1));
            $theone = $eligible[$theone];
            $data = explode('||', $ads[$theone]);
            $this->ad[] .= '<a href=' .$digiAds['url']. '?id=' .$data[0]. ' target=' .$digiAds['target']. '><img src=' .$data[10]. ' alt="' .$data[11]. '" width=' .$data[7]. ' height=' .$data[8]. ' border=' .$digiAds['border']. '></a>';
            if ($data[4] > 0) {
                $data[4]--;
            }
            $data[5]++;
            $ads[$theone] = join('||', $data);
            for ($j = 0; $j < count($eligible); $j++) {
                if ($eligible[$j] != $theone) {
                    $neligible[] = $eligible[$j];
                }
            }
            unset($eligible);
            $eligible = $neligible;
            unset($neligible);
        }
        writeads();
    }
}
?>