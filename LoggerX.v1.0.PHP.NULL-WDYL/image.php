<?

	function convertColor($color) {
		$red = hexdec(substr($color,0,2));
		$green = hexdec(substr($color,2,2));
		$blue = hexdec(substr($color,4,2));
		return array($red,$green,$blue);;
	}

	function getPostColors($HTTP_GET_VARS) {
		$colors = array();
		while (list($key,$value) = each($HTTP_GET_VARS)) {
			if (substr($key,0,1) == 'c') {
				array_push($colors,$value);
			}
		}
		return ($colors);
	}

	function getPostNumbers($HTTP_GET_VARS) {
		$numbers = array();
		while (list($key,$value) = each($HTTP_GET_VARS)) {
			if (substr($key,0,1) == 'n') {
				array_push($numbers,$value);
			}
		}
		return ($numbers);
	}

	$bgcolorname = $HTTP_GET_VARS["bgc"];
	$colors = getPostColors($HTTP_GET_VARS);
	$numbers = getPostNumbers($HTTP_GET_VARS);
	$hradius = 900;
	$vradius = 700;
	$cx = 1000;
	$cy = 1000;
	$ex = $hradius / $vradius;
	$xe = $vradius / $hradius;

	Header("Content-type: image/png");
	$im = ImageCreate(2000,2000);
	list($red,$green,$blue) = convertColor($bgcolorname);
	$bgcolor = ImageColorAllocate($im,$red,$green,$blue);
	list($red,$green,$blue) = convertColor("#333333");
	$bordercolor = ImageColorAllocate($im,$red,$green,$blue);
	ImageArc($im,$cx,$cy,2 * $hradius,2 * $vradius,0,360,$bordercolor);
	ImageArc($im,$cx + 5,$cy + 35,2 * $hradius + 70,2 * $vradius + 130,0,360,$bordercolor);
	ImageFillToBorder($im,$cx,$cy + $vradius + 2,$bordercolor,$bordercolor);

	$degree = pi;
	reset($numbers);
	reset($colors);
	do {
		list($red,$green,$blue) = convertColor(current($colors));
		$color = ImageColorAllocate($im,$red,$green,$blue);
		ImageLine($im,$cx,$cy,$cx + $hradius * sin($degree),$cy - $vradius * cos($degree),$bordercolor);
	 	ImageFillToBorder($im,$cx + $hradius * sin($degree + 0.01)/2,$cy - $vradius * cos($degree + 0.01)/2,$bordercolor,$color);
		$degree = current($numbers) * 3.14 / 50 + $degree;
		next($colors);
	} while (next($numbers));
	$degree = pi;
	$i = 0;
	reset($numbers);
	reset($colors);
	$im1 = ImageCreate(200,150);
	list($red,$green,$blue) = convertColor($bgcolorname);
	$color = ImageColorAllocate($im1,$red,$green,$blue);
	list($red,$green,$blue) = convertColor("#000000");
	$bordercolor = ImageColorAllocate($im1,$red,$green,$blue);
	do {
		list($red,$green,$blue) = convertColor(current($colors));
		$color = ImageColorAllocate($im,$red,$green,$blue);
		ImageLine($im,$cx,$cy,$cx + $hradius * sin($degree),$cy - $vradius * cos($degree),$color);
		$color = ImageColorAllocate($im1,$red,$green,$blue);
		ImageFilledRectangle($im1,180,++$i*20,190,$i*20 + 10,$color);
		ImageRectangle($im1,179,$i*20 - 1,191,$i*20 + 11,$bordercolor);
		$degree = current($numbers) * 3.14 / 50 + $degree; 
		next($colors);
	} while (next($numbers));

	ImageCopyResized($im1,$im,0,0,0,0,150,150,2000,2000);
	ImageJPEG($im1,'',100);

?>