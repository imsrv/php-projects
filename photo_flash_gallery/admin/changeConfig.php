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
if ($_POST["chall"] == MD5($challenge.$_POST["total"])){
	$file = '../userconfig.xml'; 
	getConfig($config, $file);
	for ($i=0;$i<$_POST["total"];$i++){
		if (isset($config[$_POST["key".$i]])){
			$config[$_POST["key".$i]] = $_POST["value".$i];
		}
	}
	if (writeConfig($config, $file)){
		echo MD5($challenge."OK");
	} else {
		echo MD5($challenge."2");
		}
} else {
	echo MD5($challenge."1");
}
?>