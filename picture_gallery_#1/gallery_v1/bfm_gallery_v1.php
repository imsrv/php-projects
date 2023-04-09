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
$filename = "admin/files/gallery.php";
$lines = file($filename);
array_splice($lines,0,1);
array_splice($lines,count($lines)-1);
$total = count($lines)-1;
foreach ($lines as $line_num => $line) {
	if ($line_num == 0) {
		$fparser = array();
		$fparser = split("~",$line);
		$mainColor = $fparser[0];
		$secondColor = $fparser[1];
		$thirdColor = $fparser[2];
		$fourthColor = $fparser[3];
		$lbl_GalleryMessage = $fparser[4];
		$lbl_GalleryText = $fparser[5];
		$lbl_txNext = $fparser[6];
		$lbl_txPrevious = $fparser[7];
		$lbl_txDescr = $fparser[8];
		$lbl_txPicture = $fparser[9];

		$firstline = 'mainColor='.$mainColor.'&secondColor='.$secondColor.'&thirdColor='.$thirdColor.'&fourthColor='.$fourthColor.'&lbl_Picture='.replaceAndencode($lbl_txPicture).'&lbl_Previous='.replaceAndencode($lbl_txPrevious).'&lbl_Next='.replaceAndencode($lbl_txNext).'&lbl_GalleryMessage='.replaceAndencode($lbl_GalleryMessage).'&lbl_GalleryText='.replaceAndencode($lbl_GalleryText).'&lbl_txDescrs='.replaceAndencode($lbl_txDescr);
	} elseif ($line_num>0) {
		$parser = array();
	    $parser = split("~",$line);
	    $id = $parser[0];
	    $name = $parser[1];
		
	    $descr = $parser[2];
		$filele = "images/img".($id).".jpg";
		$date = is_file($filele)?date("d-m-Y",filemtime ($filele)):"-";
		
		$imageTitle .= '&imageTitle'.($line_num-1).'='.replaceAndencode($name);
		$imageData .= '&imageData'.($line_num-1).'='.replaceAndencode($date);
		$imageDescription .= '&imageDescription'.($line_num-1).'='.replaceAndencode($descr);
		$imageName .= '&image'.($line_num-1).'=img'.$id;
	}
}
function replaceAndencode($str){
	return preg_replace("/\r\n|\r/", "", str_replace ("+", urlencode("+"), str_replace ("&", urlencode("&"), utf8_encode($str))));
}
$content = $firstline . $imageTitle . $imageData . $imageDescription . $imageName . '&lbl_TotalPictures=' . $total . '&dataLoaded=1';
echo $content;
?>