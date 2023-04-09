<?php
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
if ($_POST["chall"] == MD5($challenge.$_POST["deleteXML"])){
	@unlink('../thumberrors.xml');
}
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
		@unlink($path."/".$images["url"][$idintern]);
		@unlink($path."/".$images["urlbig"][$idintern]);
		
		$subcategories["count"][$idsubcat]--;
		$imgCount--;
		unset($images["idimg"][$idintern]);
		unset($images["idsubcategory"][$idintern]);
		unset($images["name"][$idintern]);
		unset($images["url"][$idintern]);
		unset($images["urlbig"][$idintern]);
		unset($images["desc"][$idintern]);
		unset($images["width"][$idintern]);
		unset($images["height"][$idintern]);
		unset($images["date"][$idintern]);
		unset($images["kb"][$idintern]);
		unset($images["directimg"][$idintern]);
		
	}
	if (writeDatebase($imgCount, $categories, $subcategories, $images, $file)){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>