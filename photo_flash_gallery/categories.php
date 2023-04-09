<?
$file = 'database.xml'; 
include_once('include/errors.php');
include_once('include/XmlStructure.php');
include_once('include/XmlTags.php');
$header = '<?xml version="1.0" encoding="UTF-8"?>';
echo($header."\n");
getArrays($imgCount, $categories, $subcategories, $images, $file);
echo('<cats imgCount="'.$imgCount.'">'."\n");

foreach ($categories["idcategory"] as $catkey => $catvalue){
	echo("\t".catTag($categories["name"][$catkey], $categories["count"][$catkey]));
	foreach ($subcategories["idcategory"] as $subcatkey => $subcatvalue){
		if ($subcatvalue==$catvalue) {
			echo("\t"."\t".subCatTagEnd($subcategories["idsubcategory"][$subcatkey], $subcategories["name"][$subcatkey], $subcategories["count"][$subcatkey], $subcategories["directimg"][$subcatkey]));
		}
	}
	echo("\t".catEndTag());
}
echo('</cats>'."\n");
?>