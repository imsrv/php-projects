<?
/////////////////////////////////////////////////////////
//	
//	Iloha MIME Library (IML)
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	FILE: include/mime.inc
	PURPOSE:
		Provide functions for handling mime messages.
	USAGE:
		Use iil_C_FetchStructureString to get IMAP structure stirng, then pass that through
		iml_GetRawStructureArray() to get root node to a nested data structure.
		Pass root node to the iml_GetPart*() functions to retreive individual bits of info.

********************************************************/

function iml_ClosingParenPos($str, $start){
    $level=0;
    $len = strlen($str);
    $in_quote = 0;
    for ($i=$start;$i<$len;$i++){
    	if ($str[$i]=="\"") $in_quote = ($in_quote + 1) % 2;
    	if (!$in_quote){
        	if ($str[$i]=="(") $level++;
        	else if (($level > 0) && ($str[$i]==")")) $level--;
        	else if (($level == 0) && ($str[$i]==")")) return $i;
    	}
    }
}

function iml_ParseBSString($str){	
    
    $id = 0;
    $a = array();
    $len = strlen($str);
    
    $in_quote = 0;
    for ($i=0; $i<$len; $i++){
        if ($str[$i] == "\"") $in_quote = ($in_quote + 1) % 2;
        else if (!$in_quote){
            if ($str[$i] == " ") $id++; //space means new element
            else if ($str[$i]=="("){ //new part
                $i++;
                $endPos = iml_ClosingParenPos($str, $i);
                $partLen = $endPos - $i;
                $part = substr($str, $i, $partLen);
                $a[$id] = iml_ParseBSString($part); //send part string
                if ($verbose) echo "{>".$endPos."}"; flush();
                $i = $endPos;
            }else $a[$id].=$str[$i]; //add to current element in array
        }else if ($in_quote){
            if ($str[$i]=="\\") $i++; //escape backslashes
            else $a[$id].=$str[$i]; //add to current element in array
        }
    }
        
    reset($a);
    return $a;
}

function iml_GetRawStructureArray($str){
    $line=substr($str, 1, strlen($str) - 2);
    $line = str_replace(")(", ") (", $line);
        
    return iml_ParseBSString($line);
}

function iml_GetPartArray($a, $part){
	if (!is_array($a)) return false;
	if (strpos($part, ".") > 0){
		$parts=explode(".", $part);
		$part=$parts[0];
		$new_part="";
		for ($i=1;$i<count($parts);$i++) $rest=($rest==""?"":".").$parts[$i];
		return iml_GetPartArray($a[$part-1], $rest);
	}else if ($part>0){
		if (is_array($a[$part-1])) return $a[$part-1];
		else return false;
	}else if (($part==0) || (empty($part))){
		return $a;
	}
}

function iml_GetNumParts($a, $part){
	if (is_array($a)){
		$parent=iml_GetPartArray($a, $part);
		
		$is_array=true;
		$c=0;
		while (( list ($key, $val) = each ($parent) )&&($is_array)){
			$is_array=is_array($parent[$key]);
			if ($is_array) $c++;
		}
		return $c;
	}
	
	return false;
}

function iml_GetPartTypeString($a, $part){
	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return "MULTIPART/".$part_a[count($part_a)-4];
		else return $part_a[0]."/".$part_a[1];
	}else return false;
}

function iml_GetFirstTextPart($structure,$part){
    if ($part==0) $part="";
    $typeCode = -1;
    while ($typeCode!=0){
        $typeCode = iml_GetPartTypeCode($structure, $part);
        if ($typeCode == 1){
            $part .= (empty($part)?"":".")."1";
        }else if ($typeCode > 0){
            $parts_a = explode(".", $part);
            $lastPart = count($parts_a) - 1;
            $parts_a[$lastPart] = (int)$parts_a[$lastPart] + 1;
            $part = implode(".", $parts_a);
        }else if ($typeCode == -1){
            return "";
        }
    }
    
    return $part;
}

function iml_GetPartTypeCode($a, $part){
	$types=array(0=>"text",1=>"multipart",2=>"message",3=>"application",4=>"audio",5=>"image",6=>"video",7=>"other");

	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) $str="multipart";
		else $str=$part_a[0];

		$code=7;
		while ( list($key, $val) = each($types)) if (strcasecmp($val, $str)==0) $code=$key;
		return $code;
	}else return -1;
}

function iml_GetPartEncodingCode($a, $part){
	$encodings=array("7BIT", "8BIT", "BINARY", "BASE64", "QUOTED-PRINTABLE", "OTHER");

	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return -1;
		else $str=$part_a[5];

		$code=5;
		while ( list($key, $val) = each($encodings)) if (strcasecmp($val, $str)==0) $code=$key;

		return $code;

	}else return -1;
}

function iml_GetPartEncodingString($a, $part){
	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return -1;
		else return $part_a[5];
	}else return -1;
}

function iml_GetPartSize($a, $part){
	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return -1;
		else return $part_a[6];
	}else return -1;
}

function iml_GetPartDisposition($a, $part){
	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return -1;
		else{
            $id = count($part_a) - 2;
			if (is_array($part_a[$id])) return $part_a[$id][0];
			else return "";
		}
	}else return "";
}

function iml_GetPartName($a, $part){
	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return -1;
		else{
            $name = "";
			if (is_array($part_a[2])){
                //first look in content type
				$name="";
				while ( list($key, $val) = each ($part_a[2])){
                    if ((strcasecmp($val, "NAME")==0)||(strcasecmp($val, "FILENAME")==0)) 
                        $name=$part_a[2][$key+1];
                }
			}
            if (empty($name)){
                //check in content disposition
                $id = count($part_a) - 2;
                if ((is_array($part_a[$id])) && (is_array($part_a[$id][1]))){
                    $array = $part_a[$id][1];
                    while ( list($key, $val) = each($array)){
                        if ((strcasecmp($val, "NAME")==0)||(strcasecmp($val, "FILENAME")==0)) 
                            $name=$array[$key+1];
                    }
                }
            }
			return $name;
		}
	}else return "";
}


function iml_GetPartCharset($a, $part){
	$part_a=iml_GetPartArray($a, $part);
	if ($part_a){
		if (is_array($part_a[0])) return -1;
		else{
			if (is_array($part_a[2])){
				$name="";
				while ( list($key, $val) = each ($part_a[2])) if (strcasecmp($val, "charset")==0) $name=$part_a[2][$key+1];
				return $name;
			}
			else return "";
		}
	}else return "";
}
?>
