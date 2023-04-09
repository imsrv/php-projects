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

		$written = 1;
		
		$commentfile = $path."/".$_POST["idimg"].".xml";
		@unlink($commentfile);
		$commentfile = $path."/un_".$_POST["idimg"].".xml";
		@unlink($commentfile);
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