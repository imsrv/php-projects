<?
include_once('include/errors.php');
include_once('include/XmlStructure.php');
include_once('include/XmlTags.php');
if (isset($_GET["idimg"])){
	$file = 'database.xml'; 
	getArrays($imgCount, $categories, $subcategories, $images, $file);
	$idintern = -1;
	foreach ($images["idimg"] as $imgkey => $imgvalue){
		if ($imgvalue == $_GET["idimg"]){
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
		
		$commentfile = $path."/un_".$_GET["idimg"].".xml";
		if (is_file($commentfile)){
			$handle = fopen($commentfile, 'r');
			fpassthru($handle);
			fclose($handle);
		} else {
			echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
			echo '<comments>'."\n";
			echo '</comments>'."\n";
		}
	}
}
?>