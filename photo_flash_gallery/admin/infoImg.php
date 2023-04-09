<?php
//idImage
//title
//desc
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
		$images["name"][$idintern] = $_POST["title"];
		$images["desc"][$idintern] = $_POST["desc"];
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