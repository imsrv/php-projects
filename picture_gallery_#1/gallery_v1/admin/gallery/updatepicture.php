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
session_start();
if(!session_is_registered("auth"))
	header ("Location: ../index.php");
$urlpage = '../';
include("../config.php");
include($urlpage."include/modules/files.php");
$filename = "../files/gallery.php";

if (isset($op))
{
	if ($op == 1)
	{
		$image = $_FILES["image"];
		$img = (isset($image) && is_uploaded_file($image["tmp_name"]) && move_uploaded_file($image["tmp_name"], "../../images/img" . ($lid+1) . ".jpg"));

		$newdata = (int)($lid+1).'~'.$name.'~'.preg_replace("/\r\n|\r/", "<br>", $descr)."\r\n";
		if (is_writable($filename)) {
		
		$lines = file($filename);
		array_splice($lines,0,1);
		array_splice($lines,count($lines)-1);
		
	    $handle = fopen($filename, 'w');
    	fputs($handle, "<?\r\n");
		for ($i=0;$i<count($lines);$i++){
	    	fputs($handle, $lines[$i]);
		}
    	fputs($handle, $newdata);
    	fputs($handle, '?>');
	    fclose($handle);
		
		} else {
		    print "The file $filename is not writable";
			$er = 1;
		}
		if ($er != 1)
		{
			$info_err  = " Operation was successful";
		}else
		{
			$info_err  = " Operation was not successful";
		}
		session_register("info_err");
	}else if ($op == 2)
	{
		if (isset($id)){
			$imageName = $_FILES["imageName"];
			if (isset($imageName) && is_uploaded_file($imageName["tmp_name"]) && move_uploaded_file($imageName["tmp_name"], "../../images/img" . (int)($id) . ".jpg")) {}
			$lines = file($filename);
			$i = 0;
			$data = "";
			foreach ($lines as $line_num => $line) {
				if ($line_num == 0) $nl[$i++] = ereg_replace("(\r\n|\n|\r)", "", $line);
				if ($line_num>0) {
					$parser = array();
		    		$parser = split("~",$line);
		    		$idgallery = $parser[0];
					if ($idgallery != $id) {
						$nl[$i++] = ereg_replace("(\r\n|\n|\r)", "", $line);
					} else {
						$nl[$i++] = $id.'~'.$name.'~'.preg_replace("/\r\n|\r/", "<br>", $descr);
					}
				}
			}
			$data = implode("\r\n",$nl);
			}
		if (write_file($filename,$data))
		{
			$info_err  = " Operation was successful";
		}else
		{
			$info_err  = " Operation was not successful";
		}
		session_register("info_err");
	}else if ($op == 3)
	{
		if (isset($id))
		{
			$lines = file($filename);
			$i = 0;
			$data = "";
			foreach ($lines as $line_num => $line) {
				if ($line_num == 0) $nl[$i++] = ereg_replace("(\r\n|\n|\r)", "", $line);
				if ($line_num>0) {
					$parser = array();
		    		$parser = split("~",$line);
		    		$idgallery = $parser[0];
					if ($idgallery != $id) {
						$nl[$i++] = ereg_replace("(\r\n|\n|\r)", "", $line);
					}
				}
			}
			$data = implode("\r\n",$nl);
			if (write_file($filename,$data)) {
				@unlink("../../images/img" . (int)($id). ".jpg");
				$info_err  = " Operation was successful";
			}else
			{
				$info_err  = " Operation was not successful";
			}
			session_register("info_err");
		}
	}else if ($op == 4)
	{
		$lines = file($filename);
		
		array_splice($lines,0,1);
		array_splice($lines,count($lines)-1);
		
		$i = 0;
		$data = "";
		
		foreach ($lines as $line_num => $line) {
			if ($line_num == 0) {
				$nl[$i++] = $mainColor.'~'.$secondColor.'~'.$thirdColor.'~'.$fourthColor.'~'.$lbl_GalleryMessage.'~'.$lbl_GalleryText.'~'.$lbl_txNext.'~'.$lbl_txPrevious.'~'.$lbl_txDescr.'~'.$lbl_txPicture;
			}
			if ($line_num>0) {
				$parser = array();
	    		$parser = split("~",$line);
	    		$idgallery = $parser[0];
				if ($idgallery != $id) {
					$nl[$i++] = ereg_replace("(\r\n|\n|\r)", "", $line);
				}
			}
		}
		$data = '<?
'.implode("\r\n",$nl).'
?>';
		if (write_file($filename,$data)) {
			$info_err  = " Operation was successful";
		}else
		{
			$info_err  = " Operation was not successful";
		}
		session_register("info_err");
	}
	header("Location: index.php");die;
}else
{
	header("Location: ../index.php");die;
}
?>