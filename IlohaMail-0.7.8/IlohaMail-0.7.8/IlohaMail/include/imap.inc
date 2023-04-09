<?
/////////////////////////////////////////////////////////
//	
//	Iloha IMAP Library (IIL)
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	FILE: include/imap.inc
	PURPOSE:
		Provide alternative IMAP library that doesn't rely on the standard 
		C-Client based version.  This allows IlohaMail to function regardless
		of whether or not the PHP build it's running on has IMAP functionality
		built-in.
	USEAGE:
		Function containing "_C_" in name require connection handler to be
		passed as one of the parameters.  To obtain connection handler, use
		iil_Connect()

********************************************************/

include_once("../include/utf7.inc");

$iil_error;
$iil_errornum;
$iil_selected;

class iilConnection{
	var $fp;
	var $error;
	var $errorNum;
	var $selected;
	var $message;
}

class iilBasicHeader{
	var $id;
	var $uid;
	var $subject;
	var $from;
	var $to;
	var $cc;
	var $replyto;
	var $date;
	var $messageID;
	var $size;
	var $encoding;
	var $flags;
	var $timestamp;
	var $seen;
	var $deleted;
	var $recent;
	var $answered;
}

function iil_xor($string, $string2){
    $result = "";
    $size = strlen($string);
    for ($i=0; $i<$size; $i++) $result .= chr(ord($string[$i]) ^ ord($string2[$i]));
        
    return $result;
}

function iil_ReadLine($fp, $size){
	$line="";
	if ($fp){
		do{
			$buffer = fgets($fp, 1024);
			$endID = strlen($buffer) - 1;
			$end = ($buffer[$endID] == "\n");
			$line.=$buffer;
		}while(!$end);
	}
	return $line;
}

function iil_ReadReply($fp){
	do{
		$line = chop(trim(iil_ReadLine($fp, 1024)));
	}while($line[0]=="*");
	
	return $line;
}

function iil_ParseResult($string){
	$a=explode(" ", $string);
	if (count($a) > 2){
		if (strcasecmp($a[1], "OK")==0) return 0;
		else if (strcasecmp($a[1], "NO")) return -1;
		else if (strcasecmp($a[1], "BAD")) return -2;
	}else return -3;
}

// check if $string starts with $match
function iil_StartsWith($string, $match){
	if ($string[0]==$match[0]){
		$pos=strpos($string, $match);
		if ( $pos === false) return false;
		else if ( $pos == 0) return true;
		else return false;
	}else{
		return false;
	}
}

function iil_C_Authenticate(&$conn, $user, $pass, $encChallenge){
    
    // initialize ipad, opad
    for ($i=0;$i<64;$i++){
        $ipad.=chr(0x36);
        $opad.=chr(0x5C);
    }
    // pad $pass so it's 64 bytes
    $padLen = 64 - strlen($pass);
    for ($i=0;$i<$padLen;$i++) $pass .= chr(0);
    // generate hash
    $hash = md5(iil_xor($pass,$opad).pack("H*",md5(iil_xor($pass, $ipad).base64_decode($encChallenge))));
    // generate reply
    $reply = base64_encode($user." ".$hash);
    
    // send result, get reply
    fputs($conn->fp, $reply."\r\n");
    $line = iil_ReadLine($conn->fp, 1024);
    
    // process result
    if (iil_ParseResult($line)==0){
        $conn->error = "";
        $conn->errorNum = 0;
        return $conn->fp;
    }else{
        $conn->error = "Authentication failed (AUTH): <br>\"".$line."\"";
        $conn->errorNum = -2;
        return false;
    }
}

function iil_C_Login(&$conn, $user, $password){

    fputs($conn->fp, "a001 LOGIN $user \"$password\"\r\n");
		
    $line = iil_ReadReply($conn->fp);
    $a=explode(" ", $line);
    if (strcmp($a[1],"OK")==0){
        $result=$conn->fp;
        $conn->error="";
        $conn->errorNum = 0;
    }else{
        $result=false;
        fclose($conn->fp);
        $conn->error = "Authentication failed (LOGIN):<br>\"".$line."\"";
        $conn->errorNum = -2;
    }
    return $result;
}

function iil_Connect($host, $user, $password){	
    global $iil_error, $iil_errornum;
	
	//set auth method
	$auth = "plain";
	if (func_num_args() >= 4){
		$auth = func_get_arg(3);
		if (empty($auth)) $auth = "plain";
	}
		
	$result = false;
	
	//initialize connection
	$conn = new iilConnection;
	$conn->error="";
	$conn->errorNum=0;
	$conn->selected="";
	
	//check input
	if (empty($host)) $iil_error .= "Invalid host<br>\n";
	if (empty($user)) $iil_error .= "Invalid user<br>\n";
	if (empty($password)) $iil_error .= "Invalid password<br>\n";
	if (!empty($iil_error)) return false;
	
	//open socket connection
	$conn->fp=fsockopen($host, 143);
	if ($conn->fp){
		$iil_error.="Socket connection established\r\n";
		$line=iil_ReadLine($conn->fp, 300);
		
		if (strcasecmp($auth_method, "check")==0){
			//check for supported auth methods
			
			//default to plain text auth
			$auth_method = "plain";
			
			//check for CRAM-MD5
			fputs($conn->fp, "cp01 CAPABILITY\r\n");
			$line = trim(chop(iil_ReadLine($conn->fp, 100)));
			$a = explode(" ", $line);
			while ( list($k, $w) = each($a) ){
				if (strcasecmp($w, "AUTH=CRAM_MD5")==0) $auth_method = "auth";
			}
		}

		if (strcasecmp($auth_method, "auth")==0){
			//do CRAM-MD5 authentication
			fputs($conn->fp, "a000 AUTHENTICATE CRAM-MD5\r\n");
			$line = trim(chop(iil_ReadLine($conn->fp, 1024)));
			if ($line[0]=="+"){
				//got a challenge string, try CRAM-5
				$result = iil_C_Authenticate($conn, $user, $password, substr($line,2));
			}else{
				$auth = "plain";
			}
		}
		
		if ((!$result)||(strcasecmp($auth, "plain")==0)){
            //do plain text auth
            $result = iil_C_Login($conn, $user, $password);
        }
		
		$conn->message = $auth;
		
		if (!$result){
			$iil_error = $conn->error;
			$iil_errornum = $conn->errorNum;
		}
    }else{
        $iil_error = "Could not connect to $host at port 143";
        $iil_errornum = -1;
		return false;
	}
	
	if ($result) return $conn;
	else return false;
}

function iil_Close(&$conn){
	if (fputs($conn->fp, "I LOGOUT\r\n")){
		fgets($conn->fp, 1024);
		fclose($conn->fp);
	}
}

function iil_ClearCache($user, $host){
}

function iil_ExplodeQuotedString($delimiter, $string){
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

function iil_CheckForRecent($host, $user, $password, $mailbox){
	if (empty($mailbox)) $mailbox="INBOX";
	
	$conn=iil_Connect($host, $user, $password, "plain");
	$fp = $conn->fp;
	if ($fp){
		fputs($fp, "a002 EXAMINE \"".UTF7EncodeString($mailbox)."\"\r\n");
		do{
			$line=chop(fgets($fp, 300));
			$a=explode(" ", $line);
			if (($a[0]=="*") && (strcasecmp($a[2], "RECENT")==0))  $result=(int)$a[1];
		}while (!iil_StartsWith($a[0],"a002"));

		fputs($fp, "a003 LOGOUT\r\n");
		fclose($fp);
	}else $result=-2;
	
	return $result;
}

function iil_C_Select(&$conn, $mailbox){
	$fp = $conn->fp;
	
	if (strcmp($conn->selected, $mailbox)==0) return true;
	
	if (fputs($fp, "sel1 SELECT \"".UTF7EncodeString($mailbox)."\"\r\n")){
		do{
			$line=chop(fgets($fp, 300));
		}while (!iil_StartsWith($line, "sel1"));

		$a=explode(" ", $line);

		if (strcasecmp($a[1],"OK")==0){
			$conn->selected = $mailbox;
			return true;
		}else return false;
	}else{
		return false;
	}
}

function iil_C_CountMessages(&$conn, $mailbox){
	$num=-1;
	$fp = $conn->fp;
		
	if (fputs($fp, "cm1 SELECT \"".UTF7EncodeString($mailbox)."\"\r\n")){
		do{
			$line=chop(fgets($fp, 300));
			$a=explode(" ", $line);
			if ((count($a) == 3) && (strcasecmp($a[2], "EXISTS")==0)) $num=(int)$a[1];
		}while (!iil_StartsWith($a[0],"cm1"));
	}
	
	return $num;
}

function iil_SplitHeaderLine($string){
	$pos=strpos($string, ":");
	if ($pos>0){
		$res[0]=substr($string, 0, $pos);
		$res[1]=trim(substr($string, $pos+1));
		return $res;
	}else{
		return $string;
	}
}

function iil_StrToTime($str){
	$pos=strpos($str, ",");
	if ($pos > 0) $str = trim(substr($str, $pos+1));

	$a=explode(" ",$str);
	$month_a=array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12);
	$month_str=$a[1];
	$month=$month_a[$month_str];
	$day=$a[0];
	$year=$a[2];
	$time=$a[3];
	$tz_str = $a[4];
	$tz = substr($tz_str, 0, 3);
	$ta=explode(":",$time);
	$hour=(int)$ta[0]-(int)$tz;
	$minute=$ta[1];
	$second=$ta[2];

	return mktime($hour, $minute, $second, $month, $day, $year);
}

function iil_C_FetchHeaderIndex(&$conn, $mailbox, $message_set, $index_field){
	$c=0;
	$result=array();
	$fp = $conn->fp;
	
	if (empty($index_field)) $index_field="DATE";
	$index_field = strtoupper($index_field);
	
	$fields_a=array(
								"DATE"=>1,
								"FROM"=>1,
								"TO"=>1,
								"SUBJECT"=>1,
								"UID"=>2,
								"SIZE"=>2,
								"SEEN"=>3,
								"RECENT"=>4,
								"DELETED"=>5
							);
	
	$mode=$fields_a[$index_field];
	if (!($mode > 0)) return false;

	/*  Do "SELECT" command */
	if (!iil_C_Select($conn, $mailbox)) return false;
	
	/* FETCH date,from,subject headers */
	if ($mode==1){
		$key="fhi".($c++);
		$request=$key." FETCH $message_set (BODY.PEEK[HEADER.FIELDS ($index_field)])\r\n";
		if (!fputs($fp, $request)) return false;
		do{
			$line=chop(fgets($fp, 200));
			$a=explode(" ", $line);
			if ($line[0]=="*"){
				$id=$a[1];

				$str=$line=chop(fgets($fp, 300));

				while($line[0]!=")"){					//caution, this line works only in this particular case
					$line=chop(fgets($fp, 300));
					if ($line[0]!=")"){
						if (ord($line[0]) <= 32){			//continuation from previous header line
							$str.=" ".trim($line);
						}
						if ((ord($line[0]) > 32) || (strlen($line[0]) == 0)){
							list($field, $string) = iil_SplitHeaderLine($str);
							if (strcasecmp($field, "date")==0){
								$result[$id]=iil_StrToTime($string);
							}else{
								$result[$id]=strtoupper(str_replace("\"", "", $string));
							}
							$str=$line;
						}
					}
				}
			}
		}while(!iil_StartsWith($a[0], $key));
	}else{
		if ($mode >= 3) $field_name="FLAGS";
		else if ($index_field=="SIZE") $field_name="RFC822.SIZE";
		else $field_name=$index_field;

		/* 			FETCH uid, size, flags		*/
		$key="fhi".($c++);
		$request=$key." FETCH $message_set ($field_name)\r\n";
		if (!fputs($fp, $request)) return false;
		do{
			$line=chop(fgets($fp, 200));
			if ($line[0]=="*"){
				$line=str_replace("(", "", $line);
				$line=str_replace(")", "", $line);
				$a=explode(" ", $line);
			
				/*  Caution, bad assumptions, next several lines */
				$id=$a[1];
				if ($mode==2) $result[$id]=$a[4];
				else{
					$haystack=strtoupper($line);
					$result[$id]=(strpos($haystack, $index_field) > 0 ? "F" : "N");
				}
			}
		}while(!iil_StartsWith($line, $key));
	}
	return $result;	

}

function iil_C_FetchHeaders(&$conn, $mailbox, $message_set){
	$c=0;
	$result=array();
	$fp = $conn->fp;
	
	/*  Do "SELECT" command */
	if (!iil_C_Select($conn, $mailbox)) return false;

	/* FETCH date,from,subject headers */
	$key="fh".($c++);
	$request=$key." FETCH $message_set (BODY.PEEK[HEADER.FIELDS (DATE FROM TO SUBJECT REPLY-TO CC CONTENT-TRANSFER-ENCODING MESSAGE-ID)])\r\n";
	
	if (!fputs($fp, $request)) return false;
	do{
		$line=chop(fgets($fp, 200));
		$a=explode(" ", $line);
		if ($line[0]=="*"){
			$id=$a[1];
			$result[$id]=new iilBasicHeader;
			$result[$id]->id = $id;
			$result[$id]->subject = "";
			/*
				Start parsing headers.  The problem is, some header "lines" take up multiple lines.
				So, we'll read ahead, and if the one we're reading now is a valid header, we'll
				process the previous line.  Otherwise, we'll keep adding the strings until we come
				to the next valid header line.
			*/
			$i = 0;
			$lines = array();
			do{
				$line = chop(fgets($fp, 300));
				if (ord($line[0])<=32) $lines[$i].=(empty($lines[$i])?"":"\n").trim(chop($line));
				else{
					$i++;
					$lines[$i] = trim(chop($line));
				}
			}while($line[0]!=")");
			
			//process header, fill iilBasicHeader obj.
			//	initialize
			if (is_array($headers)){
				reset($headers);
				while ( list($k, $bar) = each($headers) ) $headers[$k] = "";
			}

			//	create array with header field:data
			$headers = array();
			while ( list($lines_key, $str) = each($lines) ){
				list($field, $string) = iil_SplitHeaderLine($str);
				$field = strtolower($field);
				$headers[$field] = $string;
			}
			$result[$id]->date = $headers["date"];
			$result[$id]->timestamp = iil_StrToTime($headers["date"]);
			$result[$id]->from = $headers["from"];
			$result[$id]->to = str_replace("\n", " ", $headers["to"]);
			$result[$id]->subject = str_replace("\n", " ", $headers["subject"]);
			$result[$id]->replyto = str_replace("\n", " ", $headers["reply-to"]);
			$result[$id]->cc = str_replace("\n", " ", $headers["cc"]);
			$result[$id]->encoding = str_replace("\n", " ", $headers["content-transfer-encoding"]);
			$messageID = $headers["message-id"];
			$result[$id]->messageID = substr(substr($messageID, 1), 0, strlen($messageID)-2);
		}
	}while(strcmp($a[0], $key)!=0);
	
	/* 
		FETCH uid, size, flags
		Sample reply line: "* 3 FETCH (UID 2417 RFC822.SIZE 2730 FLAGS (\Seen \Deleted))"
	*/
	$command_key="fh".($c++);
	$request= $command_key." FETCH $message_set (UID RFC822.SIZE FLAGS)\r\n";
	if (!fputs($fp, $request)) return false;
	do{
		$line=chop(fgets($fp, 200));
		if ($line[0]=="*"){
			// split up line
			$pos=strpos($line,"(");
			$pre=substr($line, 0, $pos);
			$post=substr($line, $pos+1);
			$post=substr($post, 0, strlen($post)-1);

			// first get message ID
			$pre_a = explode(" ", $pre);
			$id = $pre_a[1];

			// isolate flags
			$open_pos=strpos($post,"(")+1;
			$close_pos=strpos($post,")");
			$flags = str_replace("\\","", substr($post, $open_pos, ($close_pos-$open_pos)));

			// process flags
			$flags_a = explode(" ", $flags);
			$result[$id]->seen = false;
			$result[$id]->recent = false;
			$result[$id]->deleted = false;
			$result[$id]->answered = false;
			if (is_array($flags_a)){
				reset($flags_a);
				while (list($key,$val)=each($flags_a)){
					if (strcasecmp($val,"Seen")==0) $result[$id]->seen = true;
					else if (strcasecmp($val, "Deleted")==0) $result[$id]->deleted=true;
					else if (strcasecmp($val, "Recent")==0) $result[$id]->recent = true;
					else if (strcasecmp($val, "Answered")==0) $result[$id]->answered = true;
				}
				$result[$id]->flags=$flags;
			}

			// go through rest for size and UID
			$post_a = explode(" ", $post);
			if (is_array($post_a)){
				reset($post_a);
				while (list($key,$val)=each($post_a)){
					if (strcasecmp($val,"UID")==0) $result[$id]->uid=$post_a[$key+1];
					else if (strcasecmp($val, "RFC822.SIZE")==0) $result[$id]->size=$post_a[$key+1];
				}
			}
		}
	}while(strpos($line, $command_key)===false);
	
	return $result;
}


function iil_C_FetchHeader(&$conn, $mailbox, $id){
	$fp = $conn->fp;
	$a=iil_C_FetchHeaders($conn, $mailbox, $id);
	if (is_array($a)) return $a[$id];
	else return false;
}


function iil_SortHeaders($a, $field, $flag){
	if (empty($field)) $field="uid";
	$field=strtolower($field);
	if ($field=="date") $field="timestamp";
	if (empty($flag)) $flag="ASC";
	$flag=strtoupper($flag);
	
	$c=count($a);
	if ($c>0){
		/*
			Strategy:
			First, we'll create an "index" array.
			Then, we'll use sort() on that array, 
			and use that to sort the main array.
		*/
                
                // create "index" array
		$index=array();
		reset($a);
		while (list($key, $val)=each($a)){
			$data=$a[$key]->$field;
			if (is_string($data)) $data=strtoupper(str_replace("\"", "", $data));
			$index[$key]=$data;
		}
		
		// sort index
		$i=0;
		if ($flag=="ASC") asort($index);
		else arsort($index);
		
		// form new array based on index 
		$result=array();
		reset($index);
		while (list($key, $val)=each($index)){
			$result[$i]=$a[$key];
			$i++;
		}
	}
	
	return $result;
}

function iil_C_Expunge(&$conn, $mailbox){
	$fp = $conn->fp;
	if (iil_C_Select($conn, $mailbox)){
		$c=0;
		fputs($fp, "exp1 EXPUNGE\r\n");
		do{
			$line=chop(fgets($fp, 100));
			if ($line[0]=="*") $c++;
		}while (!iil_StartsWith($line, "exp1"));
		
		if (iil_ParseResult($line) == 0) return $c;
		else{
			$conn->error = $line;
			return -1;
		}
	}
	
	return -1;
}

function iil_C_Flag(&$conn, $mailbox, $messages, $flag){
	$fp = $conn->fp;
	$flags=array(
                    "SEEN"=>"\\Seen",
                    "DELETED"=>"\\DELETED",
                    "RECENT"=>"\\RECENT",
                    "ANSWERED"=>"\\Answered",
                    "DRAFT"=>"\\Draft"
                    );
	$flag=strtoupper($flag);
	$flag=$flags[$flag];
	if (iil_C_Select($conn, $mailbox)){
		$c=0;
		fputs($fp, "del1 STORE $messages +FLAGS (".$flag.")\r\n");
		do{
			$line=chop(fgets($fp, 100));
			if ($line[0]=="*") $c++;
		}while (!iil_StartsWith($line, "del1"));
		
		if (iil_ParseResult($line) == 0) return $c;
		else{
			$conn->error = $line;
			return -1;
		}
	}else{
		$conn->error = "Select failed";
		return -1;
	}
}

function iil_C_Delete(&$conn, $mailbox, $messages){
	$fp = $conn->fp;
	if (iil_C_Select($conn, $mailbox)){
		$c=0;
		fputs($fp, "del1 STORE $messages +FLAGS (\\Deleted)\r\n");
		do{
			$line=chop(fgets($fp, 100));
			if ($line[0]=="*") $c++;
		}while (!iil_StartsWith($line, "del1"));
		
		if (iil_ParseResult($line) == 0) return $c;
		else return -1;
	}else{
		return -1;
	}
}

function iil_C_Undelete(&$conn, $mailbox, $messages){
	$fp = $conn->fp;
	if (iil_C_Select($conn, $mailbox)){
		$c=0;
		fputs($fp, "del1 STORE $messages -FLAGS (\\Deleted)\r\n");
		do{
			$line=chop(fgets($fp, 100));
			if ($line[0]=="*") $c++;
		}while (!iil_StartsWith($line, "del1"));
		
		if (iil_ParseResult($line) == 0) return $c;
		else return -1;
	}else{
		return -1;
	}
}


function iil_C_Unseen(&$conn, $mailbox, $message){
	$fp = $conn->fp;
	if (iil_C_Select($conn, $mailbox)){
		$c=0;
		$command = "uns1 STORE $message -FLAGS (\\Seen)\r\n";
		fputs($fp, $command);
		do{
			$line=chop(fgets($fp, 100));
			if ($line[0]=="*") $c++;
		}while (!iil_StartsWith($line, "uns1"));
		
		if (iil_ParseResult($line) == 0) return $c;
		else{
			$conn->error = $command."-".$line;
			return -1;
		}
	}else{
		return -1;
	}
}


function iil_C_Copy(&$conn, $messages, $from, $to){
	$fp = $conn->fp;
	if (iil_C_Select($conn, $from)){
		$c=0;
		
		fputs($fp, "cpy1 COPY $messages \"".UTF7EncodeString($to)."\"\r\n");
		$line=iil_ReadReply($fp);
		return iil_ParseResult($line);
	}else{
		return -1;
	}
}

function iil_FormatSearchDate($month, $day, $year){
	$months=array(
			1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 
			5=>"May", 6=>"Jun", 7=>"Jul", 8=>"Aug", 
			9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec"
			);
	return $day."-".$months[$month]."-".$year;
}

function iil_C_Search(&$conn, $folder, $criteria){
	$fp = $conn->fp;
	if (iil_C_Select($conn, $folder)){
		$c=0;
		
		$query = "srch1 SEARCH ".chop($criteria)."\n";
		fputs($fp, $query);
		do{
			$line=trim(chop(fgets($fp, 10000)));
			if ($line[0]=="*"){
				$str=trim(substr($line, 8));		//cut off "* SEARCH "
				$messages=explode(" ", $str);
			}
		}while(!iil_StartsWith($line, "srch1"));
		
		$result_code=iil_ParseResult($line);
		if ($result_code==0) return $messages;
		else{
			echo "iil_C_Search: ".$line."<br>\n";
			return false;
		}
		
	}else{
		echo "iil_C_Search: Couldn't select $folder <br>\n";
		return false;
	}
}

function iil_C_Move(&$conn, $messages, $from, $to){
	$fp = $conn->fp;
	$r=iil_C_Copy($conn, $messages, $from,$to);
	if ($r==0){
		return iil_C_Delete($conn, $from, $messages);
		/*
		if (iil_C_Delete($conn, $from, $messages) >= 0){
			return iil_C_Expunge($conn, $from);
		}else{
			return -10;
		}
		*/
	}else{
		return $r;
	}
}

function iil_C_GetHierarchyDelimiter(&$conn){
	$fp = $conn->fp;
	$delimiter = false;
	if (!fputs($fp, "ghd LIST \"\" \"\"\r\n")) return false;
	do{
		$line=fgets($fp, 500);
		if ($line[0]=="*"){
			$line = rtrim($line);
			$a=iil_ExplodeQuotedString(" ", $line);
			if ($a[0]=="*") $delimiter = str_replace("\"", "", $a[count($a)-2]);
		}
	}while (!iil_StartsWith($line, "ghd"));

	return $delimiter;
}

function iil_C_ListMailboxes(&$conn, $ref, $mailbox){
	$fp = $conn->fp;
	if (empty($mailbox)) $mailbox="*";
    // send command
	if (!fputs($fp, "lmb LIST \"".$ref."\" \"".UTF7EncodeString($mailbox)."\"\r\n")) return false;
	$i=0;
    // get folder list
	do{
		$line=fgets($fp, 500);
		if ($line[0]=="*"){
			$line = rtrim($line);
            // split one line
			$a=iil_ExplodeQuotedString(" ", $line);
            // last string is folder name
            $folders[$i] = UTF7DecodeString(str_replace("\"", "", $a[count($a)-1]));
            // second from last is delimiter
            $delim = str_replace("\"", "", $a[count($a)-2]);
            // is it a container?
            $i++;
		}
	}while (!iil_StartsWith($line, "lmb"));

	if (is_array($folders)){
        if (!empty($ref)){
            // if rootdir was specified, make sure it's the first element
            // some IMAP servers (i.e. Courier) won't return it
            if ($ref[strlen($ref)-1]==$delim) $ref = substr($ref, 0, strlen($ref)-1);
            if ($folders[0]!=$ref) array_unshift($folders, $ref);
        }
        return $folders;
	}else return false;
}

function iil_C_FetchPartHeader(&$conn, $mailbox, $id, $part){
	$fp = $conn->fp;
	$result=false;
	if (($part==0)||(empty($part))) $part="HEADER";
	else $part.=".MIME";
	
	if (iil_C_Select($conn, $mailbox)){
		$key="fh".($c++);
		$request=$key." FETCH $id (BODY.PEEK[$part])\r\n";
		if (!fputs($fp, $request)) return false;
		do{
			$line=chop(fgets($fp, 200));
			$a=explode(" ", $line);
			if (($line[0]=="*") && ($line[strlen($line)-1]!=")")){
				$line=fgets($fp, 300);
				while(chop($line)!=")"){
					$result.=$line;
					$line=fgets($fp, 300);
				}
			}
		}while(strcmp($a[0], $key)!=0);
	}
	
	return $result;
}

function iil_C_HandlePartBody(&$conn, $mailbox, $id, $part, $mode){
    /* modes:
        1: return string
        2: print
        3: base64 and print
    */
	$fp = $conn->fp;
	$result=false;
	if (($part==0)||(empty($part))) $part="TEXT";
	
	if (iil_C_Select($conn, $mailbox)){
        $reply_key="* ".$id;
        // format request
		$key="ftch".($c++)." ";
		$request=$key."FETCH $id (BODY.PEEK[$part])\r\n";
        // send request
		if (!fputs($fp, $request)) return false;
        // receive reply line
        do{
            $line = chop(iil_ReadLine($fp, 1000));
            $a = explode(" ", $line);
        }while ($a[2]!="FETCH");
        $len = strlen($line);
        if ($line[$len-1] == ")"){
            //one line response, get everything between first and last quotes
            $from = strpos($line, "\"") + 1;
            $to = strrpos($line, "\"");
            $len = $to - $from;
            if ($mode==1) $result = substr($line, $from, $len);
            else if ($mode==2) echo substr($line, $from, $len);
            else if ($mode==3) echo base64_decode(substr($line, $from, $len));
        }else if ($line[$len-1] == "}"){
            //multi-line request, find sizes of content and receive that many bytes
            $from = strpos($line, "{") + 1;
            $to = strrpos($line, "}");
            $len = $to - $from;
            $sizeStr = substr($line, $from, $len);
            $bytes = (int)$sizeStr;
            $received = 0;
            while ($received < $bytes){
                $remaining = $bytes - $received;
                $line = iil_ReadLine($fp, 1024);
                $len = strlen($line);
                if ($len > $remaining) substr($line, 0, $remaining);
                $received += strlen($line);
                if ($mode==1) $result .= chop($line)."\n";
                else if ($mode==2){ echo chop($line)."\n"; flush(); }
                else if ($mode==3){ echo base64_decode($line); flush(); }
            }
        }
        // read in anything up until 'til last line
		do{
            $line = iil_ReadLine($fp, 1024);
		}while(!iil_StartsWith($line, $key));
        
        // flag as "seen"
        if ($result){
            iil_C_Flag($conn, $mailbox, $id, "SEEN");
            return substr($result, 0, strlen($result)-1);
        }else return false;
	}else{
		echo "Select failed.";
	}
    
    if ($mode==1) return $result;
    else return $received;
}

function iil_C_FetchPartBody(&$conn, $mailbox, $id, $part){
    return iil_C_HandlePartBody($conn, $mailbox, $id, $part, 1);
}

function iil_C_PrintPartBody(&$conn, $mailbox, $id, $part){
    iil_C_HandlePartBody($conn, $mailbox, $id, $part, 2);
}

function iil_C_PrintBase64Body(&$conn, $mailbox, $id, $part){
    iil_C_HandlePartBody($conn, $mailbox, $id, $part, 3);
}

function iil_C_CreateFolder(&$conn, $folder){
	$fp = $conn->fp;
	if (fputs($fp, "c CREATE \"".UTF7EncodeString($folder)."\"\r\n")){
		do{
			$line=fgets($fp, 300);
		}while($line[0]!="c");
        $conn->error = $line;
		return (iil_ParseResult($line)==0);
	}else{
		return false;
	}
}

function iil_C_RenameFolder(&$conn, $from, $to){
	$fp = $conn->fp;
	if (fputs($fp, "r RENAME \"".UTF7EncodeString($from)."\" \"".UTF7EncodeString($to)."\"\r\n")){
		do{
			$line=fgets($fp, 300);
		}while($line[0]!="r");
		return (iil_ParseResult($line)==0);
	}else{
		return false;
	}	
}

function iil_C_DeleteFolder(&$conn, $folder){
	$fp = $conn->fp;
	if (fputs($fp, "d DELETE \"".UTF7EncodeString($folder)."\"\r\n")){
		do{
			$line=fgets($fp, 300);
		}while($line[0]!="d");
		return (iil_ParseResult($line)==0);
	}else{
		return false;
	}
}

function iil_C_Append(&$conn, $folder, $message){
	$fp = $conn->fp;
	$len = strlen($message);
	$request="A APPEND \"".UTF7EncodeString($folder)."\" (\\Seen) {".$len."}\r\n";
	if (fputs($fp, $request)){
		$line=fgets($fp, 100);
		$sent = fwrite($fp, $message."\r\n");
		flush();
		do{
			$line=fgets($fp, 1000);
		}while($line[0]!="A");
	
		return (iil_ParseResult($line)==0);
	
	}else{
		return false;
	}
}


function iil_C_AppendFromFile(&$conn, $folder, $path){
	//open message file
	$in_fp = false;				
	if (file_exists($path)) $in_fp = fopen($path, "r");
	if (!$in_fp){ 
		echo "Couldn't open $path for reading<br>\n";
		return false;
	}
	
	$fp = $conn->fp;
	$len = filesize($path);
	
	//send APPEND command
	$request="A APPEND \"".UTF7EncodeString($folder)."\" (\\Seen) {".$len."}\r\n";
	$bytes_sent = 0;
	if (fputs($fp, $request)){
		$line=fgets($fp, 100);
		
		//send file
		while(!feof($in_fp)){
			$buffer = fgets($in_fp, 4096);
			$bytes_sent += strlen($buffer);
			fputs($fp, $buffer);
		}
		fclose($in_fp);
		fputs($fp, "\r\n");

		//read response
		do{
			$line=fgets($fp, 1000);
		}while($line[0]!="A");
			
		return (iil_ParseResult($line)==0);
	
	}else{
		return false;
	}
}


function iil_C_FetchStructureString(&$conn, $folder, $id){
	$fp = $conn->fp;
	$result=false;
	if (iil_C_Select($conn, $folder)){
		if (fputs($fp, "F FETCH $id (BODYSTRUCTURE)\r\n")){
			do{
				$line=chop(iil_ReadLine($fp, 5000));
				if ($line[0]=="*"){
					list($pre, $post) = explode("BODYSTRUCTURE ", $line);
					$result = substr($post, 0, strlen($post)-1);		//truncate last ')' and return
				}
			}while ($line[0]!="F");
		}
	}
	return $result;
}

function iil_C_PrintSource(&$conn, $folder, $id, $part){
	echo iil_C_FetchPartHeader($conn, $folder, $id, $part);
	echo iil_C_PrintPartBody($conn, $folder, $id, $part);
}
?>
