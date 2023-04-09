<?
/////////////////////////////
//	common.inc
//	(C)2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//		
//		Description:
//			Charset agnostic functions related
//			to the lang/charset.inc libraries.
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
////////////////////////////

function LangDecodeMimeString($str, $charset){
	$a=explode("?", $str);
	$count = count($a);
	if ($count >= 3){			//should be in format "charset?encoding?base64_string"
		for ($i=2; $i<$count; $i++) $rest.=$a[$i];
		
		if (($a[1]=="B")||($a[1]=="b")) return LangConvert(base64_decode($rest), $charset);
		else if (($a[1]=="Q")||($a[1]=="q")) return LangConvert(quoted_printable_decode($rest), $charset);
	}else{
		return $str;		//we dont' know what to do with this
	}
}

function LangDecodeSubject($input, $charset){
	$out = "";
	//echo "Received: $input <br>\n";
	$pos = strpos($input, "=?");
	if ($pos !== false){
		$out = substr($input, 0, $pos);

		$end_cs_pos = strpos($input, "?", $pos+2);
		$end_en_pos = strpos($input, "?", $end_cs_pos+1);
		$end_pos = strpos($input, "?=", $end_en_pos+1);

		$encstr = substr($input, $pos+2, ($end_pos-$pos-2));
		//echo "encstr: $encstr <br>\n";
		$rest = substr($input, $end_pos+2);
		//echo "rest: $rest <br>\n";
		$out.=LangDecodeMimeString($encstr, $charset);
		$out.=LangDecodeSubject($rest, $charset);
		//echo "returning: $out <br>\n";
		return $out;
	}else{
		return LangConvert($input, $charset);
	}
}

function LangFormAddressHTML($user, $name, $address, $charset){
	if (empty($name)) $name=$address;
	$res="";
	$res.="<a href=\"compose.php?user=".$user."&to=".$address."\" target=\"_blank\">";
	$res.=LangDecodeSubject($name, $charset)."</a>";
	$res.="[<a href=\"edit_contact.php?user=$user&name=".urlencode(LangDecodeSubject($name, $charset))."&email=".urlencode($address)."&edit=-1\">+</a>]";
	return $res;
}

function LangExplodeQuotedString($delimiter, $string){
	$quotes=explode("\"", $string);
	while ( list($key, $val) = each($quotes))
		if (($key % 2) == 1) 
			$quotes[$key] = str_replace($delimiter, "_!@!_", $quotes[$key]);
	$string=implode("\"", $quotes);
	
	$result=explode($delimiter, $string);
	while ( list($key, $val) = each($result) )
		$result[$key] = str_replace("_!@!_", $delimiter, $result[$key]);
	
	return $result;
}

function LangParseAddressList($str){
	$a=LangExplodeQuotedString(",", $str);
	$result=array();
	reset($a);
	while( list($key, $val) = each($a) ){
		$sub_a=LangExplodeQuotedString(" ", $val);
		reset($sub_a);
		while ( list($k, $v) = each($sub_a) ){
			if ((strpos($v, "@") > 0) && (strpos($v, ".") > 0)) 
				$result[$key]["address"] = str_replace("<", "", str_replace(">", "", $v));
			else $result[$key]["name"] .= (empty($result[$key]["name"])?"":" ").str_replace("\"","",stripslashes($v));
		}
		if (empty($result[$key]["name"])) $result[$key]["name"] = $result[$key]["address"];
	}
	
	return $result;
}

function LangEncodeAddressList($str, $charset){
	$str = str_replace(", ", ",", $str);
	$str = str_replace("," , ", ", $str);
	$str = str_replace("; ", ";", $str);
	$str = str_replace(";", "; ", $str);
	
	$a = LangExplodeQuotedString(" ", $str);
	if (is_array($a)){
		$c = count($a);
		for ($i=0;$i<$c;$i++){
			if ((strpos($a[$i],"@") > 0) && (strpos($a[$i], ".") > 0)){
				//probably an email address, leave it alone
			}else{
				//some string, encode
				$word = stripslashes($a[$i]);
				$len = strlen($word);
				$enc = LangEncodeSubject(str_replace("\"", "", $word), $charset);
				if (($word[0]=="\"")&&($word[$len-1]=="\"")) $enc = "\"".$enc."\"";
				$a[$i] = $enc;
			}
		}
		return implode(" ", $a);
	}else{
		return $str;
	}
}

function LangDecodeAddressList($str, $charset, $user){
	$a=LangParseAddressList($str);
	if (is_array($a)){
		$c=count($a);
        $j=0;
		reset($a);
		while( list($i, $val) = each($a) ){
            $j++;
			$address=$a[$i]["address"];
			$name=str_replace("\"", "", $a[$i]["name"]);
			$res.=LangFormAddressHTML($user, $name, $address, $charset);
			$res.=(($c>1)&&($j<$c)?",<br>&nbsp;&nbsp;&nbsp;":"");
		}
	}
	
	return $res;
}

function LangFormatDate($timestamp, $format){
	$date = getdate($timestamp);
	
	$result = $format;
	$result = str_replace("%d", $date["mday"], $result);
	$result = str_replace("%m", $date["mon"], $result);
	$result = str_replace("%y", $date["year"], $result);
	$result = str_replace("%t", $date["hour"].":".$date["minutes"], $result);
	
	return $result;
}


?>