<?php
//catName
//idSubCat
//chall = MD5(_root.ch+idSubCat);
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
if ($_POST["chall"] == MD5($challenge.$_POST["idSubCat"])){
	$file = '../database.xml'; 
	getArrays($imgCount, $categories, $subcategories, $images, $file);
	$idSubCat = -1;
	foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
		if ($_POST["idSubCat"] == $subcatvalue){
			$idSubCat = $subcatkey;
		}
	}
	$folder = "../images/".$_POST["catName"]."/".$subcategories["name"][$idSubCat];
	if (is_dir($folder)){
		deldir($folder);//delete the folder
		$imgCount -= $subcategories["count"][$idSubCat];
		$categories["count"][$subcategories["idcategory"][$idSubCat]] --;
		unset($subcategories["name"][$idSubCat]);
		unset($subcategories["idcategory"][$idSubCat]);
		unset($subcategories["count"][$idSubCat]);
		unset($subcategories["directimg"][$idSubCat]);
		unset($subcategories["idsubcategory"][$idSubCat]);
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