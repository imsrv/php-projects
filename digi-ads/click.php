<?php
$digiAdsPath = '/path/to/digi-ads/ads.dat';
require '/path/to/digi-ads/ads.inc.php';

///////////////////////////////////////
// Don't Edit Anything Below This Line!
///////////////////////////////////////

for ($i = 0; $i < count($ads); $i++) {
    if(ereg("^$id\|\|", $ads[$i])) {
        $data = explode('||', $ads[$i]);
        $data[6]++;
        $ads[$i] = join('||', $data);
        break;
    }
}
if (!$data[9]) {
    die();
}
writeads();
Header("Location: $data[9]");
exit;
?>