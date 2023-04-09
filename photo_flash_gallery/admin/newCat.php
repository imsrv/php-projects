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
echo 'message=';
$inserted = false;
if ($_POST["chall"] == MD5($challenge.$_POST["currentCatName"])){
	$catpath = "../images/".$_POST["newNameCat"];
	$oldumask = umask(0);
	$created = mkdir($catpath,0777);//create new category=folder
	umask($oldumask);
	if ($created){
		$file = '../database.xml'; 
		getArrays($imgCount, $categories, $subcategories, $images, $file);
		$pos = count($categories["idcategory"]);
		array_push($categories["idcategory"],$pos);
		array_push($categories["name"],$_POST["newNameCat"]);
		array_push($categories["count"],0);
		$idcat = -1;
		foreach($categories["name"] as $catkey => $catvalue){
			if ($catvalue == $_POST["currentCatName"]) $idcat = $catkey;
		}
		$idcat++;
		if ($idcat>0){
			$firsttemp = array_slice($categories["name"],0,$idcat);
			$lasttemp = array_slice($categories["name"],$idcat);
		} else {
			$firsttemp = array();
			$lasttemp = $categories["name"];
		}
		array_push($firsttemp,$categories["name"][count($categories["name"])-1]);
		$categories["name"] = array_merge($firsttemp, $lasttemp);
		array_pop($categories["name"]);

		if ($idcat>0){
			$firsttemp = array_slice($categories["count"],0,$idcat);
			$lasttemp = array_slice($categories["count"],$idcat);
		} else {
			$firsttemp = array();
			$lasttemp = $categories["count"];
		}
		array_push($firsttemp,$categories["count"][count($categories["count"])-1]);
		$categories["count"] = array_merge($firsttemp, $lasttemp);
		array_pop($categories["count"]);
		foreach ($subcategories["idcategory"] as $subcatkey => $subcatvalue){
			if ($subcatvalue>=$idcat) $subcategories["idcategory"][$subcatkey]++;
		}
	}
	if ($created && writeDatebase($imgCount, $categories, $subcategories, $images, $file)){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>
