<?PHP
	session_start();
	$string = $_SESSION['noautomationcode'];
	if(!$string){
		for($i=0; $i<5;$i++){
			$string = $string.rand(0,9);
		}
		$_SESSION['noautomationcode'] = $string;
	}
	$circles=5;
	$width=100;
	$height=40;
	$font=100;

	$im = ImageCreateFromJpeg("backgroundimage.jpg");
	$img_size	= getimagesize("backgroundimage.jpg");

	$fontwidth = ImageFontWidth($font) * strlen($string);
	$fontheight = ImageFontHeight($font);

	$x = ($img_size[0] - strlen($string) * $fontwidth )/2;
	$x = $x + 100;
	$y = ($img_size[1] - $fontheight) / 2; // middle of the code string will be in middle of the background image

//	$im = @imagecreate ($width,$height);
	$background_color = imagecolorallocate ($im, 255, 255, 255);
	$text_color = imagecolorallocate ($im, rand(0,100), rand(0,100),rand(0,100)); // Random Text
	$text_color = "000000";
	imagerectangle($im,0,0,$width-1,$height-1,$text_color);
	imagestring ($im, $font, $x,$y,  $string, $text_color);
	DistortImage($im,$width-1,$height-1);
	header ("Content-type: image/jpeg");
	imagejpeg ($im,'',80);

	function DistortImage($dist_img, $w, $h){
		// a random piece of ellipse
		$color = ImageColorAllocate( $dist_img, rand(0,255), rand(0,255), rand(0,255) );
		$color = "000000";
		ImageArc($dist_img, rand(0,	$w), rand(0, $h), rand($w / 2, $w) ,rand($h / 2, $h), 0,360, $color);
		//and rectangle
		$color = ImageColorAllocate($dist_img, rand(0,255), rand(0,255), rand(0,255));
		$color = "000000";
		ImageRectangle($dist_img, rand(0, $w/2 ), rand(0, $h/2 ), rand($w / 2, $w), rand($h / 2, $h), $color);
		//starry night
		$cnt = $w * $h / 10;
		for($i=0;$i<$cnt;$i++){
			$color = ImageColorAllocate($dist_img, rand(0,255), rand(0,255), rand(0,255));
			ImageSetPixel($dist_img, rand(0,$w), rand(0,$h), $color);
		}
		return $dist_img;
	}
?>