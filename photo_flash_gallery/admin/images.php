<?
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}

include_once('../include/errors.php');
include_once('../include/XmlTags.php');
include_once('../include/XmlStructure.php'); 
if (!isset($_GET["idSubcategory"]) || !isset($_GET["from"]) || !isset($_GET["to"])) die("You try to hack!!!");
$idSubcategory = $_GET["idSubcategory"];
$from = $_GET["from"];
$to = $_GET["to"];
$file = '../database.xml'; 
$header = '<?xml version="1.0" encoding="UTF-8"?>';
echo($header."\n");
getArrays($imgCount, $categories, $subcategories, $images, $file);
foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
	if ($subcatvalue == $_GET["idSubcategory"]) {
		echo("\t"."\t".subCatShortTag($subcategories["idsubcategory"][$subcatkey]));
		$nimgs = 0;
		foreach ($images["idsubcategory"] as $imgkey => $imgvalue){
			if ($subcategories["idsubcategory"][$subcatkey]==$imgvalue) {
				$nimgs++;
				if ($nimgs>$from && $nimgs<=$to) {
					if ($subcategories["directimg"][$subcatkey] == "1") $path = $categories["name"][$subcategories["idcategory"][$subcatkey]].'/';
					else $path = $categories["name"][$subcategories["idcategory"][$subcatkey]].'/'.$subcategories["name"][$subcatkey].'/';
					if (is_file("../images/".$path.$images["url"][$imgkey])){
						$url = "url";
					} else {
						$url = "urlbig";
					}
					echo("\t"."\t"."\t".imageDetailTag($images["idimg"][$imgkey], $images["idsubcategory"][$imgkey], $path.$images[$url][$imgkey], $path.$images["urlbig"][$imgkey], $images["name"][$imgkey], $images["desc"][$imgkey], $images["width"][$imgkey], $images["height"][$imgkey], $images["date"][$imgkey], $images["kb"][$imgkey], $images["directimg"][$imgkey]));
				}
			}
		}
		echo("\t"."\t".subCatEndShortTag());
	}
}
?>