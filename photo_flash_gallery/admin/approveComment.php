<?
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}

include_once('../include/errors.php');
include_once('../include/XmlStructure.php');
include_once('../include/XmlTags.php');
$challenge = MD5(session_id());
$written = 0;
//idimg - id-ul imaginii
//idcomment - id-ul comentariului
echo 'message=';
if ($_POST["chall"] == MD5($challenge.$_POST["idimg"])){
	$file = '../database.xml'; 
	getArrays($imgCount, $categories, $subcategories, $images, $file);
	$idintern = -1;
	foreach ($images["idimg"] as $imgkey => $imgvalue){
		if ($imgvalue == $_POST["idimg"]){
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
		
		$commentfile = $path."/".$_POST["idimg"].".xml";
		$uncommentfile = $path."/un_".$_POST["idimg"].".xml";
		if (is_file($uncommentfile)) {
			getComments($commentids, $commentvalues, $commentnames, $commentmails, $uncommentfile);
			$handle = fopen($uncommentfile, "w");
			if ($handle>0) $written = 1;
			fputs($handle, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
			fputs($handle, '<comments>'."\n");
			if (count($commentids)>0){
				foreach($commentids as $idkey=>$idvalue){
					if ($_POST["idcomment"] != $idvalue){
						fputs($handle, '<comment id="'.$idvalue.'" value="'.htmlentities($commentvalues[$idkey]).'" name="'.htmlentities($commentnames[$idkey]).'" mail="'.htmlentities($commentmails[$idkey]).'"/>'."\n");
					} else {
						$val = $commentvalues[$idkey];
						$mail = $commentmails[$idkey];
						$name = $commentnames[$idkey];
					}
				}
			}
			fputs($handle, '</comments>'."\n");
			fclose($handle);
			unset($commentids);
			unset($handle);
			if (isset($val)){
				if (is_file($commentfile)) {
					getComments($commentids, $commentvalues, $commentnames, $commentmails, $commentfile);
				}
				$handle = fopen($commentfile, "w");
				if ($handle>0) $written = 1;
				else $written = 0;
				fputs($handle, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
				fputs($handle, '<comments>'."\n");
				$maxid = 0;
				if (count($commentids)>0){
					$maxid = (max($commentids)+1);
				}
				fputs($handle, '<comment id="'.$maxid.'" value="'.htmlentities(nltobr($val)).'" name="'.htmlentities($name).'" mail="'.htmlentities($mail).'"/>'."\n");
				if (count($commentids)>0){
					foreach($commentids as $idkey=>$idvalue){
						fputs($handle, '<comment id="'.$idvalue.'" value="'.htmlentities($commentvalues[$idkey]).'" name="'.htmlentities($commentnames[$idkey]).'" mail="'.htmlentities($commentmails[$idkey]).'"/>'."\n");
					}
				}
				fputs($handle, '</comments>'."\n");
				fclose($handle);
			}
		}
	}
	if ($written == 1){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>