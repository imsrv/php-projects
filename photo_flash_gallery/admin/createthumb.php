<?
//idImage
//chall = MD5(_root.ch+idImage);
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}

include_once('../include/errors.php');
include_once('../include/XmlStructure.php');
include_once('../include/XmlTags.php');
$challenge = MD5(session_id());
echo 'message=';
if ($_POST["chall"] == MD5($challenge.$_POST["idImage"])){
	$file = '../database.xml'; 
	getArrays($imgCount, $categories, $subcategories, $images, $file);
	$idintern = -1;
	foreach ($images["idimg"] as $imgkey => $imgvalue){
		if ($imgvalue == $_POST["idImage"]){
			$idintern = $imgkey;
		}
	}
	if ($idintern != -1){
		$idsubcat = -1;
		foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
			if ($subcatvalue == $images["idsubcategory"][$idintern]){
				$idsubcat = $subcatkey;
			}
		}
		foreach ($categories["idcategory"] as $catkey => $catvalue){
			if ($catvalue == $subcategories["idcategory"][$idsubcat]){
				$idcat = $catkey;
			}
		}
		$catname = $categories["name"][$idcat];
		
		if ($subcategories["directimg"][$idsubcat] == "1"){
			$path = "../images/" . $catname;
		} else {
			$path = "../images/" . $catname . "/" . $subcategories["name"][$idsubcat];
		}
		
		$thumb = $path."/".$images["url"][$idintern];
		$big = $path."/".$images["urlbig"][$idintern];
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
			//$destination = ImageCreate($ww,$hh);
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
	}
	if ($resized){
		echo MD5($challenge."OK");
	} else {
		thumbErrors($_POST["idImage"], '../thumberrors.xml');
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>