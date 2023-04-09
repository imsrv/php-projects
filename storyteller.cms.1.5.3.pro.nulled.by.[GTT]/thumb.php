<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    if (phpversion() >= "4.1.0")
    {
        $img = $_GET["img"];
        $action = $_GET["action"];
        $section = $_GET["section"];
    }

    if (!$section)
    {
        $section = "review";
    }

    if (!preg_match("/review|news|faq|downloads/i",$section)) exit;
    if ((preg_match("/\//i", $img)) or (preg_match("/\//i", $section))) exit;

    if ($action == "full")
    {
        $insert[thumb] = "images/$section/$img";
        echo GetTemplate("site_thumb");
        exit;
    }

    if (file_exists("images/$section/thumbs/$img"))
    {
        header("Location: images/$section/thumbs/$img");
    }

    $imgdat = explode(".", $img);

    if ($imgdat[1] == "png")
    {
        header("Content-type: image/png");
        $source = imagecreatefrompng("images/$section/$img");
    }

    if ($imgdat[1] == "gif")
    {
        header("Content-type: image/gif");
        $source = imagecreatefromgif("images/$section/$img");
    }

    if (($imgdat[1] == "jpeg") or ($imgdat[1] == "jpg"))
    {
        header("Content-type: image/jpeg");
        $source = imagecreatefromjpeg("images/$section/$img");
    }

    if (!$configs[13])
    {
        $configs[13] = 3;
    }

    $size = getimagesize("images/$section/$img");
    $width = (int)abs($size[0] / $configs[13]);
    $height = (int)abs($size[1] / $configs[13]);
    $thumb = imagecreate($width, $height);

    imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

    if ($imgdat[1] == "png")
    {
        imagepng($thumb, "images/$section/thumbs/$img");
        @chmod ("images/$section/thumbs/$img", 0777);
    }
    if ($imgdat[1] == "gif")
    {
        imagegif($thumb, "images/$section/thumbs/$img");
        @chmod ("images/$section/thumbs/$img", 0777);
    }
    if (($imgdat[1] == "jpg") or ($imgdat[1] == "jpeg"))
    {
        imagejpeg($thumb, "images/$section/thumbs/$img");
        @chmod ("images/$section/thumbs/$img", 0777);
    }

?>
