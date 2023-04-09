<?php
//******************************************* pentru CAT
//catName
//action --"up" sau "down"
//chall = MD5(_root.ch+catName);
//******************************************* pentru SUB_CAT
//idSubCat
//action --"up" sau "down"
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
if (isset($_POST["catName"])) {
	if (true || $_POST["chall"] == MD5($challenge.$_POST["catName"])){
		$file = '../database.xml'; 
		getArrays($imgCount, $categories, $subcategories, $images, $file);
		$idcat1 = -1;
			foreach ($categories["name"] as $catkey => $catvalue){
				if ($catvalue == $_POST["catName"]){
					$idcat1 = $catkey;
				}
		}
		if ($_POST["action"] == "up"){
			$idcat2 = $idcat1;
			$idcat1 = $idcat1 - 1;
		} elseif ($_POST["action"] == "down"){
			$idcat2  = $idcat1 + 1;
		}
		if ($idcat1>=0 && $idcat2>0 && $idcat1<count($categories["name"]) && $idcat2<count($categories["name"])){
			$arraynames = array("name","count","idcategory");
			foreach($arraynames as $keynames){
				$tmpval = $categories["$keynames"][$idcat2];
				$categories["$keynames"][$idcat2] = $categories["$keynames"][$idcat1];
				$categories["$keynames"][$idcat1] = $tmpval;
				//array_splice($categories["$keynames"],$idcat1, 2, array($categories["$keynames"][$idcat2], $categories["$keynames"][$idcat1]));
			}
			$ids1 = array();
			$ids2 = array();
			foreach ($subcategories["idcategory"] as $catkey=>$catval){
				if ($catval == $idcat1) array_push($ids1,$catkey);
				if ($catval == $idcat2) array_push($ids2,$catkey);
			}
			foreach ($ids1 as $id_){
				$subcategories["idcategory"][$id_] = $idcat2;
			}
			foreach ($ids2 as $id_){
				$subcategories["idcategory"][$id_] = $idcat1;
			}
		}
		if (writeDatebase($imgCount, $categories, $subcategories, $images, $file)){
			echo MD5($challenge."OK");
		} else {
			echo MD5($challenge."2");
		}
	} else {
		echo MD5($challenge."1");
	}
} elseif (isset($_POST["idSubCat"])) {
	if (true || $_POST["chall"] == MD5($challenge.$_POST["idSubCat"])){
		$file = '../database.xml'; 
		getArrays($imgCount, $categories, $subcategories, $images, $file);
	 	//cauta id-ul subcategoriei din care face parte idSubCat
		$idsubcat1 = -1;
		$idsubcat2 = -1;
		foreach ($subcategories["idsubcategory"] as $catkey => $catvalue){
			if ($catvalue == $_POST["idSubCat"]){
				$idsubcat1 = $catkey;
			}
		}
		
		$idcat = $subcategories["idcategory"][$idsubcat1];// id-ul categoriei
		$neighbourid = array();
		$neighbouridval = array();
		foreach ($subcategories["idcategory"] as $catkey => $catvalue){
			if ($catvalue == $idcat && $subcategories["directimg"][$catkey]!=1){
				array_push($neighbourid, $subcategories["idsubcategory"][$catkey]);
				array_push($neighbouridval, $catkey);
			}
		}
		$ii = -1;
		for ($i=0;$i<count($neighbourid);$i++){
			if ($neighbourid[$i] == $_POST["idSubCat"]) {
				$ii = $i;
			}
		}
		$idsubcat1 = -1;
		$idsubcat2 = -1;
		if ($_POST["action"] == "up"){
			if ($ii != -1 && $ii>0) {
				$idsubcat2 = $neighbouridval[$ii-1];
			}
		} elseif ($_POST["action"] == "down"){
			if ($ii != -1 && $ii<count($neighbourid)-1) {
				$idsubcat2 = $neighbouridval[$ii+1];
			}
		}
		$idsubcat1 = $neighbouridval[$ii];
		if ($idsubcat1 != -1 && $idsubcat2 != -1){
			$arraynames = array("name","count","idcategory","idsubcategory","directimg");
			foreach($arraynames as $keynames){
				$tmpval = $subcategories["$keynames"][$idsubcat2];
				$subcategories["$keynames"][$idsubcat2] = $subcategories["$keynames"][$idsubcat1];
				$subcategories["$keynames"][$idsubcat1] = $tmpval;
			}
		}
		if (writeDatebase($imgCount, $categories, $subcategories, $images, $file)){
			echo MD5($challenge."OK");
		} else {
			echo MD5($challenge."2");
		}
	} else {
		echo MD5($challenge."1");
	}
} else {
	echo MD5($challenge."1");
}
?>