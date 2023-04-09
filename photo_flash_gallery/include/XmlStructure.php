<?
$file = 'database.xml';
$configfile = 'userconfig.xml';
function getComments(&$id, &$value, &$name, &$mail, $commentfile){
	$data = parseFile($commentfile);
	$xml = xml_parser_create();
	xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);	// lowercase tags
	xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);		// skip empty tags
	xml_parse_into_struct($xml,$data,$vals);
	xml_parser_free($xml);
	$id = array();
	$value = array();
	$name = array();
	$mail = array();
	if ($vals[0]["tag"] == "comments"){ //vad daca e tagul imgs
		for ($i=0; $i<count($vals); $i++){
			if ($vals[$i]["tag"] != "comments"){
				array_push($id,$vals[$i]["attributes"]["id"]);
				array_push($value,$vals[$i]["attributes"]["value"]);
				array_push($name,$vals[$i]["attributes"]["name"]);
				array_push($mail,$vals[$i]["attributes"]["mail"]);
			}
		}
	}
}
function thumbErrors($idimg, $thumbErrorsFile){
	function getImageName($idimage){
		getArrays($imgCount, $categories, $subcategories, $images, "../database.xml");
		$idintern = -1;
		foreach ($images["idimg"] as $imgkey => $imgvalue){
			if ($imgvalue == $idimage){
				$idintern = $imgkey;
			}
		}
		return $images["name"][$idintern];
	}
	$imgs = array();
	$names = array();

	if (is_file($thumbErrorsFile)){
		$data = parseFile($thumbErrorsFile);
		$xml = xml_parser_create();
		xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);	// lowercase tags
		xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);		// skip empty tags
		xml_parse_into_struct($xml,$data,$vals);
		xml_parser_free($xml);
		if ($vals[0]["tag"] == "imgs"){ //vad daca e tagul imgs
			for ($i=0; $i<count($vals); $i++){
				if ($vals[$i]["tag"] != "imgs"){
					array_push($imgs,$vals[$i]["attributes"]["idimg"]);
					array_push($names,$vals[$i]["attributes"]["name"]);
				}
			}
		}
	}
	$itisinerror = false;
	for($i=0; $i<count($imgs);$i++){
		if ($imgs[$i]==$idimg){
			$itisinerror = true;
		}
	}
	if (!$itisinerror) {
		array_push($imgs,$idimg);
		array_push($names,getImageName($idimg));
	}
	$file = fopen ($thumbErrorsFile, "w");
	if ($file) {
		$header = '<?xml version="1.0" encoding="UTF-8"?>';
		fputs($file, $header."\n");
		fputs($file, '<imgs>'."\n");
		for($i=0; $i<count($imgs);$i++){
			fputs($file, '<img idimg="'.$imgs[$i].'" name="'.$names[$i].'"/>'."\n");
		}
		fputs($file, '</imgs>'."\n");
		fclose($file);
	}
}
function parseFile($file) {
	$data = @file_get_contents($file) or die("Can't open file $file for reading!");
	return $data;
}
function getVersion(&$version, $file){
	$data = parseFile($file);
	$xml = xml_parser_create();
	xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);	// lowercase tags
	xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);		// skip empty tags
	xml_parse_into_struct($xml,$data,$vals);
	xml_parser_free($xml);
	if ($vals[0]["tag"] == "versions"){ //vad daca e tagul versions
		$version = array();
		for ($i=0; $i<count($vals); $i++){
			if ($vals[$i]["tag"] != "versions"){
				$version[$vals[$i]["attributes"]["name"]] = $vals[$i]["attributes"]["version"];
			}
		}
	}
}

function getConfig(&$config, $file){
	$data = parseFile($file);
	$xml = xml_parser_create();
	xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);	// lowercase tags
	xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);		// skip empty tags
	xml_parse_into_struct($xml,$data,$vals);
	xml_parser_free($xml);
	if ($vals[0]["tag"] == "userConfig"){ //vad daca e tagul userConfig
		$config = array();
		for ($i=0; $i<count($vals); $i++){
			if ($vals[$i]["tag"] != "userConfig"){
				$config[$vals[$i]["tag"]] = $vals[$i]["attributes"]["value"];
			}
		}
	}
}
function writeConfig($config, $filename){
	$file = fopen ($filename, "w");
	if ($file) {
		$header = '<?xml version="1.0" encoding="UTF-8"?>';
		fputs($file, $header."\n");
		fputs($file, '<userConfig>'."\n");
		foreach ($config as $configkey => $configvalue){
			fputs($file, '<'.$configkey.' value="'.htmlentities(stripslashes($configvalue)).'"/>'."\n");
		}
		fputs($file, '</userConfig>'."\n");
		fclose($file);
		return true;
	} else {
		return false;
	}
}
function getArrays(&$imgCount, &$categories, &$subcategories, &$images, $file){
	$categories = array();
	$categories["idcategory"] = array();
	$categories["name"] = array();
	$categories["count"] = array();
	
	$subcategories = array();
	$subcategories["idsubcategory"] = array();
	$subcategories["name"] = array();
	$subcategories["count"] = array();
	$subcategories["directimg"] = array();
	$subcategories["idcategory"] = array();
	
	$images = array();
	$images["idimg"] = array();
	$images["idsubcategory"] = array();
	$images["name"] = array();
	$images["url"] = array();
	$images["urlbig"] = array();
	$images["desc"] = array();
	$images["width"] = array();
	$images["height"] = array();
	$images["date"] = array();
	$images["kb"] = array();
	$images["directimg"] = array();
	
	$data = parseFile($file);
	$xml = xml_parser_create();
	xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);	// lowercase tags
	xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);		// skip empty tags
	xml_parse_into_struct($xml,$data,$vals);
	xml_parser_free($xml);
	if ($vals[0]["tag"] == "cats"){ //vad daca e tagul cats 
		$imgCount = $vals[0]["attributes"]["imgCount"];
		$nrcats = 0;
		for ($i=0; $i<count($vals); $i++){
			if ($vals[$i]["tag"] == "category" && ($vals[$i]["type"] == "open" || $vals[$i]["type"] == "complete")) {
				array_push($categories["idcategory"],$nrcats++);
				array_push($categories["name"],$vals[$i]["attributes"]["name"]);
				array_push($categories["count"],$vals[$i]["attributes"]["count"]);
			}
			if ($vals[$i]["tag"] == "subCategory" && ($vals[$i]["type"] == "open" || $vals[$i]["type"] == "complete")) {
				array_push($subcategories["idcategory"],$nrcats-1);
				array_push($subcategories["idsubcategory"],$vals[$i]["attributes"]["idSubcategory"]);
				array_push($subcategories["directimg"],$vals[$i]["attributes"]["directImg"]);
				array_push($subcategories["name"],$vals[$i]["attributes"]["name"]);
				array_push($subcategories["count"],$vals[$i]["attributes"]["count"]);
			}
			if ($vals[$i]["tag"] == "image" && $vals[$i]["type"] == "complete") {
				array_push($images["idsubcategory"],$vals[$i]["attributes"]["idSubcategory"]);
				array_push($images["directimg"],$vals[$i]["attributes"]["directImg"]);
				array_push($images["idimg"],$vals[$i]["attributes"]["idImg"]);
				array_push($images["url"],$vals[$i]["attributes"]["url"]);
				array_push($images["urlbig"],$vals[$i]["attributes"]["urlBig"]);
				array_push($images["name"],$vals[$i]["attributes"]["name"]);
				array_push($images["desc"],$vals[$i]["attributes"]["desc"]);
				array_push($images["width"],$vals[$i]["attributes"]["width"]);
				array_push($images["height"],$vals[$i]["attributes"]["height"]);
				array_push($images["date"],$vals[$i]["attributes"]["date"]);
				array_push($images["kb"],$vals[$i]["attributes"]["kb"]);
			}
		}
	}
	unset($vals);
}
function writeDatebase($imgCount, $categories, $subcategories, $images, $filename){
	$file = fopen ($filename, "w");
	if ($file) {
		$header = '<?xml version="1.0" encoding="UTF-8"?>';
		fputs($file, $header."\n");
		fputs($file, '<cats imgCount="'.$imgCount.'">'."\n");
		foreach ($categories["idcategory"] as $catkey => $catvalue){
			fputs($file, "\t".catTag($categories["name"][$catkey], $categories["count"][$catkey]));
			foreach ($subcategories["idcategory"] as $subcatkey => $subcatvalue){
				if ($subcatvalue==$catkey) {
					fputs($file, "\t"."\t".subCatTag($subcategories["idsubcategory"][$subcatkey], $subcategories["name"][$subcatkey], $subcategories["count"][$subcatkey], $subcategories["directimg"][$subcatkey]));
					foreach ($images["idsubcategory"] as $imgkey => $imgvalue){
						if ($subcategories["idsubcategory"][$subcatkey]==$imgvalue) {
							fputs($file, "\t"."\t"."\t".imageDetailTag($images["idimg"][$imgkey], $images["idsubcategory"][$imgkey], $images["url"][$imgkey], $images["urlbig"][$imgkey], $images["name"][$imgkey], $images["desc"][$imgkey], $images["width"][$imgkey], $images["height"][$imgkey], $images["date"][$imgkey], $images["kb"][$imgkey], $images["directimg"][$imgkey]));
						}
					}
					fputs($file, "\t"."\t".subCatEndTag());
				}
			}
			fputs($file, "\t".catEndTag());
		}

		fputs($file, '</cats>'."\n");
		fclose($file);
		return true;
	} else {
		return false;
	}
}
function deldir($file) {
	chmod($file,0777);
	if (is_dir($file)) {
		$handle = opendir($file); 
		while($filename = readdir($handle)) {
			if ($filename != "." && $filename != "..") {
				deldir($file."/".$filename);
			}
		}
		closedir($handle);
		rmdir($file);
	} else {
		unlink($file);
	}
}

function writeDatebase_backup($imgCount, $categories, $subcategories, $images, $filename){
	$file = fopen ($filename, "w");
	if ($file) {
		$header = '<?xml version="1.0" encoding="UTF-8"?>';
		fputs($file, $header."\n");
		fputs($file, '<cats imgCount="'.$imgCount.'">'."\n");
		foreach ($categories["idcategory"] as $catkey => $catvalue){
			fputs($file, "\t".catTag($categories["name"][$catvalue], $categories["count"][$catvalue]));
			foreach ($subcategories["idcategory"] as $subcatkey => $subcatvalue){
				if ($subcatvalue==$catvalue) {
					fputs($file, "\t"."\t".subCatTag($subcategories["idsubcategory"][$subcatkey], $subcategories["name"][$subcatkey], $subcategories["count"][$subcatkey], $subcategories["directimg"][$subcatkey]));
					foreach ($images["idsubcategory"] as $imgkey => $imgvalue){
						if ($subcategories["idsubcategory"][$subcatkey]==$imgvalue) {
							fputs($file, "\t"."\t"."\t".imageDetailTag($images["idimg"][$imgkey], $images["idsubcategory"][$imgkey], $images["url"][$imgkey], $images["urlbig"][$imgkey], $images["name"][$imgkey], $images["desc"][$imgkey], $images["width"][$imgkey], $images["height"][$imgkey], $images["date"][$imgkey], $images["kb"][$imgkey], $images["directimg"][$imgkey]));
						}
					}
					fputs($file, "\t"."\t".subCatEndTag());
				}
			}
			fputs($file, "\t".catEndTag());
		}

		fputs($file, '</cats>'."\n");
		fclose($file);
		return true;
	} else {
		return false;
	}
}
function nltobr($text){
	return ereg_replace("(\r\n)", "&lt;br&gt;", $text);
}
?>