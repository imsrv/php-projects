<?
session_start();
if(!session_is_registered("username")){
	header("Location: index.php");
	die;
}

include_once('../include/errors.php');
include_once('../include/DirOperator.php');
include_once('../include/XmlStructure.php');
$d = new DirOperator();
$startingFolder = "../images";
$d -> showDir();
$x = $d -> output($startingFolder);
unset($d);
getConfig($config, '../userconfig.xml');
echo '
<?xml version="1.0" encoding="UTF-8"?>
<bgimages>
';
foreach ($x as $q){
	if ($q[3]!=1) {
		echo '<bgImg name="images/'.$q[0].'" isSelected="'.(($config["setBgPicture"]=="images/".$q[0])?"1":"0").'"/>';
	}
}
echo '
</bgimages>
';
?>