<?
include_once('include/errors.php');
include_once('include/XmlStructure.php');
include_once('include/XmlTags.php');
$written = 0;
if (isset($_POST["idimg"]) && isset($_POST["Name"]) && isset($_POST["Mail"]) && isset($_POST["Comment"]) && isset($_POST["chall"]) && $_POST["chall"]==MD5($_POST["Mail"])){
	$file = 'database.xml'; 
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
			$path = "images/" . $catname;
		} else {
			$path = "images/" . $catname . "/" . $subcategories["name"][$idsubcat];
		}
		
		$commentids = array();
		$commentvalues = array();
		$commentnames = array();
		$commentmails = array();
		$commentfile = $path."/un_".$_POST["idimg"].".xml";
		if (is_file($commentfile)) {
			getComments($commentids, $commentvalues, $commentnames, $commentmails, $commentfile);
		}
		$handle = fopen($commentfile, "w");
		if ($handle>0) $written = 1;
		fputs($handle, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fputs($handle, '<comments>'."\n");
		$maxid = 0;
		if (count($commentids)>0){
			$maxid = (max($commentids)+1);
		}
		fputs($handle, '<comment id="'.$maxid.'" value="'.htmlentities(nltobr($_POST["Comment"])).'" name="'.htmlentities($_POST["Name"]).'" mail="'.htmlentities($_POST["Mail"]).'"/>'."\n");
		if (count($commentids)>0){
			foreach($commentids as $idkey=>$idvalue){
				fputs($handle, '<comment id="'.$idvalue.'" value="'.htmlentities($commentvalues[$idkey]).'" name="'.htmlentities($commentnames[$idkey]).'" mail="'.htmlentities($commentmails[$idkey]).'"/>'."\n");
			}
		}
		fputs($handle, '</comments>'."\n");
		fclose($handle);
	}
}
	if ($written == 1){
		echo "message=OK";
	} else {
		echo "message=0";
	}

?>