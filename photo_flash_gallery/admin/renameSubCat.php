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
if ($_POST["chall"] == MD5($challenge.$_POST["id"])){
	$renamed = rename("../images/".$_POST["catname"]."/".$_POST["oldname"],"../images/".$_POST["catname"]."/".$_POST["newname"]);//rename the folder
	if ($renamed){
		$file = '../database.xml'; 
		getArrays($imgCount, $categories, $subcategories, $images, $file);
		$renamed = false;
		foreach ($subcategories["name"] as $subcatkey => $subcatvalue){
			if ($subcatvalue == $_POST["oldname"] && $categories["name"][$subcategories["idcategory"][$subcatkey]] == $_POST["catname"]){
				$subcategories["name"][$subcatkey] = $_POST["newname"];
				$renamed = true;
			}
		}
	}
	if ($renamed && writeDatebase($imgCount, $categories, $subcategories, $images, $file)){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
	}
} else {
	echo MD5($challenge."1");
}
?>
