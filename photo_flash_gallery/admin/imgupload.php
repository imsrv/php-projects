<?php
//catName
//dirImg
//idSubCat
//chall =  MD5(_root.ch+catName);
//totalImgs
//img0 ....
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
if (true || $_POST["chall"] == MD5($challenge.$_POST["catName"])){
	$file = '../database.xml'; 
	getArrays($imgCount, $categories, $subcategories, $images, $file);
	if ($_POST["dirImg"] == "0") {
		$idsubcat = -1;
		foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
			if ($subcatvalue == $_POST["idSubCat"]){
				$idsubcat = $subcatkey;
			}
		}
		$path = "../images/".$_POST["catName"]."/".$subcategories["name"][$idsubcat];
	} else {
		$path = "../images/".$_POST["catName"];
	}
/*	echo "<pre>";
	print_r($subcategories);*/
	if (is_dir($path)){
		for ($i=0;$i<$_POST["totalImgs"];$i++){
			$uploaded = false;
			$filename = $_POST["img".$i];
			if (extensionMatch($filename)) {
				$uploaded = is_file("../tmp/".$filename) && rename("../tmp/".$filename, $path."/".$filename);
				if ($uploaded){
					$imgCount++;
					$info = getInfo($path."/".$filename);
					$size = filesize($path."/".$filename);
					$time = filemtime($path."/".$filename);
					$getlatestid = -1;
					foreach ($images["idimg"] as $imgkey => $imgval){
						$getlatestid = max($getlatestid,$imgval);
					}
					$getlatestid++;
					if ($_POST["dirImg"] == "0") {
						array_push($images["idsubcategory"],$_POST["idSubCat"]);
						$idsubcat = -1;
						foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
							if ($subcatvalue == $_POST["idSubCat"]){
								$idsubcat = $subcatkey;
							}
						}
						$subcategories["count"][$idsubcat]++;
					} else {
						$idcat = -1;
						foreach($categories["name"] as $catkey => $catvalue){
							if ($catvalue == $_POST["catName"]) $idcat = $catkey;
						}
						$idsubcat = -1;
						foreach ($subcategories["directimg"] as $subcatkey => $subcatvalue){
							if ($subcategories["idcategory"][$subcatkey] == $idcat && $subcatvalue=="1"){
								$idsubcat = $subcatkey;
							}
						}
						if ($idsubcat==-1) {
							$getlastid = -1;
							foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
								$getlastid = max($getlastid, $subcatvalue);
							}
							$getlastid++;
							array_push($subcategories["idcategory"],$idcat);
							array_push($subcategories["name"],"~".$categories["name"][$subcategories["idcategory"][$idsubcat]]);
							array_push($subcategories["count"],0);
							array_push($subcategories["directimg"],1);
							array_push($subcategories["idsubcategory"],$getlastid);
							$idsubcat = $getlastid;
						}
						array_push($images["idsubcategory"],$subcategories["idsubcategory"][$idsubcat]);
						$subcategories["count"][$idsubcat]++;
					}
					array_push($images["directimg"],$_POST["dirImg"]);
					array_push($images["idimg"],$getlatestid);
					array_push($images["url"],"th_".$filename);
					array_push($images["urlbig"],$filename);
					array_push($images["name"],$filename);
					array_push($images["desc"],$filename);
					array_push($images["width"],$info[0]);
					array_push($images["height"],$info[1]);
					array_push($images["date"],date("Y-m-d",$time));
					array_push($images["kb"],round(convert_from_bytes($size,"KB")));
				} 
			}
		}
	}
//	print_r($subcategories);
	if (writeDatebase($imgCount, $categories, $subcategories, $images, $file)){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>
