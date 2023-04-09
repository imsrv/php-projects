<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }
include("include/minimizer.php");
$picture = $_GET["picture"];
$picture_path = "images/".$picture;
$bfm_picture_path = "images/bfm_".$picture;
if (!file_exists($bfm_picture_path) || filemtime($picture_path)>filemtime($bfm_picture_path)){
	if (filesize($picture_path)>800000) $picture_path = "na.jpg";
	$picsize = GetImageSize($picture_path);
	$w = $_GET["w"];
	$h = $_GET["h"];
	if (!isset($w)) $w = '*';
	if (!isset($h)) $h = '*';
	$size = minimizer($picsize[0],$picsize[1],$w,$h);
	$src_img = imagecreatefromjpeg ($picture_path);
	$dst_img = imagecreatetruecolor($size["w"],$size["h"]);
	imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $size["w"], $size["h"], $picsize[0], $picsize[1]);
	$pic = md5(uniqid(rand(),1));
	imagejpeg($dst_img, $bfm_picture_path, 70);
	header('Content-type: image/jpeg');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', $timestamp).' GMT'); 
//	header('Content-Length: '.filesize($bfm_picture_path));
	imagejpeg($dst_img, "", 70);
	imagedestroy($dst_img);
} else {
	header('Content-type: image/jpeg');
//	header('Content-Length: '.filesize($bfm_picture_path));
	readfile($bfm_picture_path);
}
?>