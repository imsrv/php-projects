<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    global $configs;

    if (phpversion() >= "4.1.0") $in = $_GET["in"];

    if ($in < 5)
    {
        $out = substr(md5(date("H D").$configs[7]), 4, 5);
        $uout = "images/g".substr($out, $in, 1).".png";
        Header("Location: $uout");
    }
    else
    {
        echo base64_decode($eiv)." ".$configs[4];
    }
?>
