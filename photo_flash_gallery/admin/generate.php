<?
session_start();
if (!session_is_registered("username")){
	if (isset($_POST["user"]) && isset($_POST["pass"])){
		include "../admin.php";
		if ($_POST["user"]==$login["username"] && $_POST["pass"] == $login["password"]){
			session_register("username");
			$_SESSION["username"] = $login["username"];
			header("Location: generate.php");
		}
	}
?>
<html>
<head>
	<title>Generate XML</title>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td align="center" valign="middle">
	<form action="generate.php" method="post">
	<table border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #cdcdcd" width="250" height="130">
	<tr>
		<td style="font-family: Verdana; font-size:12px" valign="bottom" height="25" align="center">Username: <input name="user" type="Text" maxlength="20" class="field" size="13"></td>
	</tr>
	<tr>
		<td style="font-family: Verdana; font-size:12px" valign="bottom" height="25" align="center">Password:&nbsp;<input name="pass" type="password" maxlength="10" class="field" size="13"></td>
	</tr>
	<tr>
		<td class="text" height="31" align="center" colspan="2"><input type="submit" value="Submit"></td>
	</tr>
       </table>
	</form>
	</td>
</tr>
</table>


</body>
</html>
<?
} else {

	include_once('../include/errors.php');
	include_once('../include/DirOperator.php');
	include_once('../include/XmlTags.php'); 
	include_once('../include/XmlStructure.php');
	
	$d = new DirOperator();
	
	$startingFolder = "../images";
	$d -> showDir();
	$x = $d -> output($startingFolder);
	$categories = array(); // arrayul cu toate categoriile
	$categoriesDirectPic = array(); // arrayul cu toate categoriile care au direct pic
	foreach($x as $p){
		if ($p[3]==1) array_push($categories, $p[0]); //p[3] indica folder
	}
	$idImg = 0;
	$subcategories = array(); // arrayul cu toate subcategoriile
	$subcategoriesCount = array(); // arrayul cu numarul pozelor din subcategorii
	$subcategoriesparent = array(); // arrayul cu tatal subcategoriilor
	$subcategoriesXML = array(); // arrayul cu pozele din subcategorii in format xml
	$categSubCount = array(); // array cu numarul de subcategorii
	$imgArray = array(); //array cu detaliile imaginii
	$categoriesEmpty = array(); //array cu categoriile goale
	foreach($categories as $p){
		$d -> reset();
		$d -> showDir();
		$subfold = $startingFolder."/".$p;
		$m = $d -> output($subfold);
		$hasDirectPics = 0;
		$categSubCount[$p] = 0;
		unset($imgArray);
		$imgArray = array(); //array cu detaliile imaginii
		foreach($m as $q){
			if (!$q[1]) {//subfolder
				$categSubCount[$p]++;
				array_push($subcategories,$q[0]);//bag subcategoria
				array_push($subcategoriesparent,$p);//retin care este parintele subcategoriei
			} elseif (extensionMatch($q[0])) { //poze directe
				$hasDirectPics ++;
				if ($hasDirectPics==1){
					array_push($subcategories,"~".$p);//bag in subcategorii categoria
					$thisCat = count($subcategories)-1;
					array_push($subcategoriesparent,$p);//retin care este parintele subcategoriei
					$newsubcatXML = '';
				}
				$url = 'th_'.$q[0];
				$urlBig = $q[0];
				$info = getInfo($startingFolder."/".$p."/".$urlBig);
				$newsubcatXML .= "\t"."\t"."\t".imageDetailTag($idImg++, $thisCat, $url, $urlBig, $q[0], $q[0], $info[0], $info[1], date("Y-m-d",$q[2]), round(convert_from_bytes($q[1],"KB")), 1);
			}
		}
		if ($hasDirectPics!=0) {
			array_push($categoriesDirectPic,$thisCat);
			$subcategoriesCount[$thisCat] = $hasDirectPics;
			$subcategoriesXML[$thisCat] = $newsubcatXML;
		}
		if (count($m)==0){
			array_push($categoriesEmpty,$p);
		}
	}
	foreach($subcategories as $key => $sc){
		$d -> reset();
		if (!$subcategoriesCount[$key]>0) {
			$subfold = $startingFolder."/".$subcategoriesparent[$key]."/".$sc;
			$subcategoriesXML[$key]  = '';
			$ss = $d -> output($subfold);
			$subcategoriesCount[$key] = 0;
			unset($imgArray);
			$imgArray = array(); //array cu detaliile imaginii
			foreach($ss as $q){
				if ($q[1] && extensionMatch($q[0])) {
					$subcategoriesCount[$key] ++;
					$url = 'th_'.$q[0];
					$urlBig = $q[0];
					$info = getInfo($startingFolder."/".$subcategoriesparent[$key].'/'.$sc.'/'.$urlBig);
					$subcategoriesXML[$key].= "\t"."\t"."\t".imageDetailTag($idImg++, $key, $url, $urlBig, $q[0], $q[0], $info[0], $info[1], date("Y-m-d",$q[2]), round(convert_from_bytes($q[1],"KB")), 0);
				}
			}
		}
	}
	
	//create first database
	$database_file = "../database.xml";
	$file = fopen ($database_file, "w");
	if ($file) {
		$header = '<?xml version="1.0" encoding="UTF-8"?>';
		fputs($file, $header."\n");
		fputs($file, '<cats imgCount="'.array_sum($subcategoriesCount).'">'."\n");
	
		if (count($subcategories)>0){
			$parent = -1;
			foreach($subcategories as $key => $sc){
				if ($parent == -1) {
					$parent = $subcategoriesparent[$key];
					fputs($file, "\t".catTag($subcategoriesparent[$key], $categSubCount[$subcategoriesparent[$key]]));
				} elseif ($parent != $subcategoriesparent[$key]) {
					fputs($file, "\t".catEndTag());
					fputs($file, "\t".catTag($subcategoriesparent[$key], $categSubCount[$subcategoriesparent[$key]]));
					$parent = $subcategoriesparent[$key];
				}
				fputs($file, "\t"."\t".subCatTag($key, $sc, $subcategoriesCount[$key], (int) in_array($key,$categoriesDirectPic)));
				fputs($file, $subcategoriesXML[$key]);
				fputs($file, "\t"."\t".subCatEndTag());
			}
			fputs($file, "\t".catEndTag());
			foreach($categoriesEmpty as $keyempty){
				fputs($file, "\t".catTag($keyempty, 0));
				fputs($file, "\t".catEndTag());
		
			}
		}
		fputs($file, '</cats>'."\n");
		fclose($file);
?>
<html>
<head>
	<title>Generate XML</title>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td align="center" valign="middle" style="font-family: Verdana; font-size:12px">Generation has been completed.<br><br>Now you can use the gallery.</td>
</tr>
</table>

</body>
</html>
<?
	} else {
		die("CANNOT CREATE XML FILE!!!");
	}
}