<?
include_once('include/errors.php');
include_once('include/XmlTags.php');
include_once('include/XmlStructure.php');
if (!isset($_GET["idSubcategory"]) || !isset($_GET["from"]) || !isset($_GET["to"])) die("You try to hack!!!");
$idSubcategory = $_GET["idSubcategory"];
$from = $_GET["from"];
$to = $_GET["to"];
$file = 'database.xml'; 
$header = '<?xml version="1.0" encoding="UTF-8"?>';
echo($header."\n");
getArrays($imgCount, $categories, $subcategories, $images, $file);
foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
	if ($subcatvalue == $_GET["idSubcategory"]) {
		echo("\t"."\t".subCatShortTag($subcategories["idsubcategory"][$subcatkey]));
		$nimgs = 0;
		foreach ($images["idsubcategory"] as $imgkey => $imgvalue){
			if ($subcategories["idsubcategory"][$subcatkey]==$imgvalue) {
				$nimgs++;
				if ($nimgs>$from && $nimgs<=$to) {
					if ($subcategories["directimg"][$subcatkey] == "1") $path = $categories["name"][$subcategories["idcategory"][$subcatkey]].'/';
					else $path = $categories["name"][$subcategories["idcategory"][$subcatkey]].'/'.$subcategories["name"][$subcatkey].'/';
					$path_th_url = $path.$images["url"][$imgkey];
					if ($_GET["checkImages"] == "yes" && $_GET["automaticthumbs"] != "yes"){
						if (!is_file("images/".$path_th_url)){
							$path_th_url = "../admin/thumb.jpg";
						}
					}
					if ($_GET["automaticthumbs"] == "yes"){
						if (!is_file("images/".$path_th_url)){
							$thumb = "images/".$path_th_url;
							$big = "images/".$path.$images["urlbig"][$imgkey];
							$quality = 80;
							$resized = true;
							if (!is_file($big)){
								$resized = false;
							} else {
								$size = @getimagesize($big);
								$w = $size[0];
								$h = $size[1];
								$ww = 125;
								$hh = 94;
								$destination = imagecreatetruecolor($ww,$hh);
								switch ($size[2]){
									case 1: //GIF
									$source = @imagecreatefromgif($big);
									break;
									case 2: //JPG
									$source = @imagecreatefromjpeg($big);
									break;
									case 3: //PNG
									$source = @imagecreatefrompng($big);
									break;
								}
								if (!$source) {
									$resized = false;
								} else {
									if ($w*$hh == $h*$ww) {
										imagecopyresampled($destination, $source, 0, 0, 0, 0, $ww, $hh, $w, $h);
									} else {
										if ($w*$hh < $h*$ww) {
											$dh = $hh*$w/($ww>0?$ww:1);
											$diff = (int) (($h-$dh)/2);
											imagecopyresampled($destination, $source, 0, 0, 0, $diff, $ww, $hh, $w, $h-2*$diff);
										} else {
											$dw = $ww*$h/($hh>0?$hh:1);
											$diff = (int) (($w-$dw)/2);
											imagecopyresampled($destination, $source, 0, 0, $diff, 0, $ww, $hh, $w-2*$diff, $h);
										}
									}
									$resized = $resized && imagejpeg($destination, $thumb, $quality);
								}
							}
							if (!$resized) $path_th_url = "../admin/thumb.jpg";
						} 
					}
					echo("\t"."\t"."\t".imageDetailTag($images["idimg"][$imgkey], $images["idsubcategory"][$imgkey], $path_th_url, $path.$images["urlbig"][$imgkey], $images["name"][$imgkey], $images["desc"][$imgkey], $images["width"][$imgkey], $images["height"][$imgkey], $images["date"][$imgkey], $images["kb"][$imgkey], $images["directimg"][$imgkey]));
				}
			}
		}
		echo("\t"."\t".subCatEndShortTag());
	}
}
?>