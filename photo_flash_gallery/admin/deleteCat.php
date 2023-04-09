<?php
//catName
//chall = MD5(_root.ch+catName);
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
if ($_POST["chall"] == MD5($challenge.$_POST["catName"])){
	$folder = "../images/".$_POST["catName"];
	if (is_dir($folder)){
		deldir($folder);//delete the folder
		$file = '../database.xml'; 
		getArrays($imgCount, $categories, $subcategories, $images, $file);
		$idcat = -1;
		foreach ($categories["name"] as $catkey => $catvalue){
			if ($catvalue == $_POST["catName"]){
				$idcat = $catkey;
			}
		}
		$imgdeleted = 0;
		foreach ($subcategories["count"] as $subcatkey => $subcatvalue){
			if ($idcat == $subcategories["idcategory"][$subcatkey]){
				$imgdeleted += $subcatvalue;
			}
		}
		unset($categories["name"][$idcat]);
		unset($categories["idcategory"][$idcat]);
		unset($categories["count"][$idcat]);
		$imgCount -= $imgdeleted;
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
