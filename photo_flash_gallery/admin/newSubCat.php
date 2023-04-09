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
if ($_POST["chall"] == MD5($challenge.$_POST["idsubcat"])){
		$subcatpath = "../images/".$_POST["catname"]."/".$_POST["subcatname"];
		$oldumask = umask(0);
		$created = mkdir($subcatpath,0777);//create new subcategory=subfolder
		umask($oldumask);
		if ($created){
			$file = '../database.xml'; 
			getArrays($imgCount, $categories, $subcategories, $images, $file);
			$idcat = -1;
			foreach($categories["name"] as $catkey => $catvalue){
				if ($catvalue == $_POST["catname"]) $idcat = $catkey;
			}
			$categories["count"][$idcat] ++;
			if ($idcat != -1){
				$getlastid = -1;
				foreach ($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
					$getlastid = max($getlastid, $subcatvalue);
				}
				$getlastid++;
				array_push($subcategories["idcategory"],$idcat);
				array_push($subcategories["name"],$_POST["subcatname"]);
				array_push($subcategories["count"],0);
				array_push($subcategories["directimg"],0);
				array_push($subcategories["idsubcategory"],$getlastid);
				if (isset($_POST["idsubcat"])){// insereaza inainte de idsubcat ultima inregistrare
					$arrayid = -1;
					foreach($subcategories["idsubcategory"] as $subcatkey => $subcatvalue){
						if ($_POST["idsubcat"]==$subcatvalue){
							$arrayid = $subcatkey;
						}
					}
					if ($arrayid != -1){
						if ($arrayid>0){
							$firsttemp = array_slice($subcategories["idsubcategory"],0,$arrayid);
							$lasttemp = array_slice($subcategories["idsubcategory"],$arrayid);
						} else {
							$firsttemp = array();
							$lasttemp = $subcategories["idsubcategory"];
						}
						array_push($firsttemp,$subcategories["idsubcategory"][count($subcategories["idsubcategory"])-1]);
						$subcategories["idsubcategory"] = array_merge($firsttemp, $lasttemp);
						array_pop($subcategories["idsubcategory"]);
						
						if ($arrayid>0){
							$firsttemp = array_slice($subcategories["name"],0,$arrayid);
							$lasttemp = array_slice($subcategories["name"],$arrayid);
						} else {
							$firsttemp = array();
							$lasttemp = $subcategories["name"];
						}
						array_push($firsttemp,$subcategories["name"][count($subcategories["name"])-1]);
						$subcategories["name"] = array_merge($firsttemp, $lasttemp);
						array_pop($subcategories["name"]);
						
						if ($arrayid>0){
							$firsttemp = array_slice($subcategories["count"],0,$arrayid);
							$lasttemp = array_slice($subcategories["count"],$arrayid);
						} else {
							$firsttemp = array();
							$lasttemp = $subcategories["count"];
						}
						array_push($firsttemp,$subcategories["count"][count($subcategories["count"])-1]);
						$subcategories["count"] = array_merge($firsttemp, $lasttemp);
						array_pop($subcategories["count"]);
						
						if ($arrayid>0){
							$firsttemp = array_slice($subcategories["directimg"],0,$arrayid);
							$lasttemp = array_slice($subcategories["directimg"],$arrayid);
						} else {
							$firsttemp = array();
							$lasttemp = $subcategories["directimg"];
						}
						array_push($firsttemp,$subcategories["directimg"][count($subcategories["directimg"])-1]);
						$subcategories["directimg"] = array_merge($firsttemp, $lasttemp);
						array_pop($subcategories["directimg"]);

						if ($arrayid>0){
							$firsttemp = array_slice($subcategories["idcategory"],0,$arrayid);
							$lasttemp = array_slice($subcategories["idcategory"],$arrayid);
						} else {
							$firsttemp = array();
							$lasttemp = $subcategories["idcategory"];
						}
						array_push($firsttemp,$subcategories["idcategory"][count($subcategories["idcategory"])-1]);
						$subcategories["idcategory"] = array_merge($firsttemp, $lasttemp);
						array_pop($subcategories["idcategory"]);

					}
				}
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