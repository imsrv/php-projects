<?
/////////////////////////////////////////////////////////
//	
//	Iloha MIME Library (IML)
//
//	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
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

function stripQuotes($a){
    if (is_array($a)){
        reset($a);
        while ( list($key, $val) = each($a) ) $a[$key] = str_replace("\"", "", $val);
    }else{
        $a=array();
    }
    return $a;
}

function iml_ExplodeQuotedString($delimiter, $string){
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

function CleanArray($a){
	$i=0;

	while (list($key, $line) = each ($a)){
		if (!empty($line)){
			$result[$i]=$line;
			$i++;
		}
	}
	
	return $result;
}

function iml_ParseNestedString($str){
	/**
		
		$str: String returned from "FETCH BODYSTRUCTURE" command.
        e.g. (("TEXT" "HTML" ("CHARSET" "US-ASCII") NIL NIL "7BIT" 98 1 NIL NIL NIL)("IMAGE" "JPEG" ("NAME" "iCard.jpg" "X-MAC-TYPE" "4A504547" "X-MAC-CREATOR" "4D655361") NIL NIL "BASE64" 41300 NIL ("INLINE" ("FILENAME" "iCard.jpg")) NIL)("TEXT" "HTML" ("CHARSET" "US-ASCII") NIL NIL "7BIT" 245 0 NIL NIL NIL) "MIXED" ("BOUNDARY" "WO_ATTACHMENT_MAILER_XeLA") NIL NIL)
		in other words, it's a bitch
        
		Here's how the parser works:
		
		We disassemble the string into multiple lines, so each line either begins with "(" or ends with ")", or neither
		The string is then exploded into an array, with each line being it's own element.
		We then reassemble lines so a line would begin with one "(" and end with one ")".
		Such lines are exploded into an array and placed into a master array list, and that line is replaced by a place holder.
		This repeated until only one line remains (the last line is the root level).
		Finally, the place holders in the master array list are replaced with actual references to the array they refer to.
		
		-OR-
		
		It simply works.  Trust me.
	*/
	
	$str=str_replace(")(", ") (", $str);
	$str=str_replace("(", "\n(", $str);
	$str=str_replace(")", ")\n", $str);
	//$str=str_replace("\"", "", $str);		
	$lines=explode("\n", $str);
	reset($lines);
    $lines=CleanArray($lines);
    
	$a=array();
	$i=0;
	do{
		// parse complete lines into array and place in master array
        // replace with place holder
		reset($lines);
		while (list($key, $line) = each ($lines)){
			$line=str_replace("\n", "", $line);
			$len=strlen($line);
			if (($line[0]=="(") && ($line[$len-1]==")")){
				$line=substr($line, 1, $len-2);
				$a[$i]=stripQuotes(iml_ExplodeQuotedString(" ", $line));
				$lines[$key]="*array-".$i;
				$i++;
			}
		}
		
		// clear empty lines
		reset($lines);
		$lines=CleanArray($lines);

		// reassemble lines if possible
		do{
			reset($lines);
			$prev=count($lines);
			
			while (list($key, $line) = each ($lines)){
				$len=strlen($line);
				if ($key > 0){
                    // get previous line
					$last_line=$lines[$key-1];
                    // get length of previous line (so we can find the end)
					$last_len=strlen($last_line);
                    
                    //if current line ends with ")" but doesn't begin with '('
                    //	and last line didn't end with ")"
					if (($line[0]!="(") && ($line[$len-1]==")") && ($last_line[$last_len-1]!=")")){
                        //attach this line to previous, 
						$lines[$key-1]=$lines[$key-1].$line;
                        //and make this line empty
						$lines[$key]="";
					}
				}
			}
			
            // remove blank lines
			reset($lines);
			$lines=CleanArray($lines);
			
            // see if last round of processing did anything
			$post=count($lines);
			$diff=$post-$prev;
		}while($diff!=0); //we repeat until we've done all that we could (i.e. number of lines isn't changing)
		
	}while(count($lines) > 1); //repeat until one line is left (this is the root node array)
	
    // remove opening and closing parens
    $line=$lines[0];
    if ($line[0]!="*") $line=substr($line, 1, strlen($line) - 2);
    
    // explode into array
	$a[$i]=stripQuotes(iml_ExplodeQuotedString(" ", $line));
    
    // go through each item in master array linking place holders with respective arrays
    // I know, you're thinking "How do you take a single dimension array and turn it into a nested structure?"
    // Trust me, it works
	reset($a);
	while( list($key, $val) = each ($a)){
		while ( list( $key2, $val) = each($a[$key])){
			if (strpos($val, "array") == 1){
				list($junk, $id) = explode("-", $val);
				$a[$key][$key2]=$a[$id];
			}
		}
	}

	return $a[$i];
}


function iml_GetRawStructureArray($str){
    $len = strlen($str);
    $level=0;
    $max_level=0;
    for ($i=0;$i<$len;$i++){
        if ($str[$i]=="(") $level++;
        else if ($str[$i]==")") $level--;
        if ($level > $max_level) $max_level = $level;
    }
    
    if ($max_level==1){
         $line=substr($str, 1, strlen($str) - 2);
         return stripQuotes(iml_ExplodeQuotedString(" ", $line));
    }else{
        return iml_ParseNestedString($str);
    }
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
			if (is_array($part_a[2])){
				$name="";
				while ( list($key, $val) = each ($part_a[2])) if (strcasecmp($val, "NAME")==0) $name=$part_a[2][$key+1];
				return $name;
			}
			else return "";
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