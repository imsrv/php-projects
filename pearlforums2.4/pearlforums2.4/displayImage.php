<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File: 	fetchimage.php - fetch spamguard image.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

	include("settings.php"); 
	include_once("$GlobalSettings[includesDirectory]/functions.php");
	list($fileName,$ext)=preg_split("/\./",$f);
	$folder=commonGetAttachmentFolder($id);
	
	if($case=='m'){
		$path= $GlobalSettings['messageAttachmentPath'];
		list($name,$t)=preg_split("/\./",$f);
	}
	else if($case=='r'){
		$path= $GlobalSettings['attachmentPath'];
		$f=$id . "." . $t;
	}
	$imageFile= $path . "/$folder/" . $f;

	switch ($t){
		case "jpg":
			header("Content-type: image/jpeg");
			$image=imageCreateFromJPEG($imageFile);
			imagejpeg($image);
			break;
			
		case "gif":
			header("Content-type: image/gif");
			$image=imageCreateFromGIF($imageFile);
			if(function_exists('imagegif'))
				imagegif($image); 
			else
				imagejpeg($image);			
			break;
			
		case "png":
			header("Content-type: image/png");
			$image=imagecreatefrompng($imageFile);
			imagepng($image);
			break;			
	}	

?>
