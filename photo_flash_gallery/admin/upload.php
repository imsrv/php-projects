<?
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}
include_once('../include/errors.php');
include_once('../include/XmlStructure.php');
include_once('../include/XmlTags.php');
$path = "../tmp";
if (is_dir($path)){
	$filename = $_FILES['Filedata']['name'];
	if (extensionMatch($filename)) {
		if (is_uploaded_file($_FILES['Filedata']['tmp_name'])) $uploaded = move_uploaded_file($_FILES['Filedata']['tmp_name'], $path."/".$filename);
	}
}
?>
