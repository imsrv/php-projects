<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////


error_reporting(0);
/////////////////////////////////////////////////////////////////////////////////////////

function members_from_mysql($list_info){
	list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$list_info[ListSource]);
	mysql_close();
	$MySQLLink=@mysql_connect("$server:$port",$user,$pass);
	if(mysql_select_db($database,$MySQLLink)){
		//find out what fields we have!
		@$fields = mysql_list_fields($database, $table, $MySQLLink);
		@$columns = mysql_num_fields($fields);
		for ($i = 0; $i < $columns; $i++) {
  			$the_fields[]=mysql_field_name($fields, $i);
		}
		//we need to grab the data from the database now and put it into a multi-dimensional arrays!
		$results=mysql_query("SELECT * FROM $table");
			while($result=mysql_fetch_array($results)){
					$rn++;
				foreach($the_fields as $field){
					$members[$rn][$field]=$result[$field];
				}

			
			}
			mysql_close($MySQLLink);
			global $MySQLServer,$MySQLUser,$MySQLPass,$MySQLDatabase;
		//connect to the db!
		mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
		mysql_select_db($MySQLDatabase);

			mysql_select_db($MySQLDatabase);
				if($members){foreach($members as $rn=>$member){			
				$extra_info=retrieve_extra_user_info($list_info,$members[$rn][$list_info["UniqueField"]]);

				if($extra_info){foreach($extra_info as $field=>$value){
					$members[$rn][$field]=$value;
				}}
				}}
			
			return $members;
	}else{
		HandleError("Error202",1);	
	}
	
	
}

/////////////////////////////////////////////////////////////////////////////////////////

function members_from_textfile($list_info){
	list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
	if(@$f=fopen($filename,"r")){
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		fclose($f);
		//split up the file into records!
		$record_delim=str_replace('NEWLINE', "\n", $record_delim);
		$records=explode($record_delim,$data);
		
		if($headers==1){
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($field_delim, $the_headers);
		}else{
			$fields=explode(",", $headers);
		}
				
		foreach($records as $record){
			$i=0;
			$rn++;
			$datafields=explode($field_delim,$record);
			foreach($fields as $field){
				$members[$rn][$field]=$datafields[$i];
				$i++;
			}

			$extra_info=retrieve_extra_user_info($list_info,$members[$rn][$list_info["UniqueField"]]);

			if($extra_info){foreach($extra_info as $field=>$value){
				$members[$rn][$field]=$value;
			}}
		}
		
		
	}else{
	  HandleError("Error203",1);
	}
	
	return $members;

}

/////////////////////////////////////////////////////////////////////////////////////////

function get_list_members($ListID){
	
	if($list_info=list_info($ListID)){
		if($list_info[ListSourceType]=="mysqldatabase"){
			$members_array=members_from_mysql($list_info);
		}elseif($list_info[ListSourceType]=="textfile"){
			$members_array=members_from_textfile($list_info);		
		}	 
		return $members_array;	
	}else{
		HandleError("Error101",1);
	}
	
}

/////////////////////////////////////////////////////////////////////////////////////////

function retrieve_extra_user_info($list_info,$user_unique){
	$data=mysql_query("SELECT * FROM extra_data WHERE ListID='".$list_info[ListID]."' && UniqueFieldValue='$user_unique'");
	
	while($item=mysql_fetch_array($data)){
		$extra_data[$item[DataFieldName]]=$item[DataFieldValue];
	}
	return $extra_data;
}

/////////////////////////////////////////////////////////////////////////////////////////

function parse_member_list($list_info, $members_array){
		$email_field=$list_info[EmailField];
		$format_field=$list_info[FormatField];
		$receiving_field=$list_info[ReceivingField];		
		$unique_field=$list_info[UniqueField];	
				
		if($members_array){foreach($members_array as $mkey=>$member){
			$members_array[$mkey]["x-listid"]=$list_info[ListID];
			$members_array[$mkey]["x-listname"]=$list_info[ListName];
			foreach($member as $field=>$value){
				if($field==$email_field){
					//parse email field!
					$members_array[$mkey]["x-email"]=$member[$email_field];
				}
				
				if($field==$unique_field){
					//parse format field!
							$members_array[$mkey]["x-unique"]=$member[$unique_field];							
				}
				
				if($field==$format_field){
					//parse format field!
					list($htmlval,$textval)=explode("/", $list_info["FormatValues"]);
					    if($member[$field]==$htmlval){
							$members_array[$mkey]["x-format"]="html";											
						}elseif($member[$field]==$textval){
							$members_array[$mkey]["x-format"]="text";	
						}else{
							$members_array[$mkey]["x-format"]=$list_info[DefaultFormat];							
						}
				}
				
				if($field==$receiving_field){
					//parse receiving field!
					list($recval,$nrecval)=explode("/", $list_info["ReceivingValues"]);
					    if($member[$field]==$recval){
							$members_array[$mkey]["x-receiving"]="yes";											
						}elseif($member[$field]==$nrecval){
							$members_array[$mkey]["x-receiving"]="no";	
						}else{
							$members_array[$mkey]["x-receiving"]=$list_info[DefaultReceiving];							
						}
				}
			}
		}}
return $members_array;
}

/////////////////////////////////////////////////////////////////////////////////////////

function filter_members($list_info,$filter_string,$members){
//function will either only keep records with a particular field value or delete all those with a particuler field value.

if($members){
foreach($members as $rn=>$member){

	//now analyse this member for its compliance with the filter_string
	$filter_statements=explode(" OR ",$filter_string);
	
	foreach($filter_statements as $statement){
			$bad=1;		
			$args=explode(" && ", $statement);
			foreach($args as $arg){
				//split it into the three sections!

				if($arg){
				list($field,$comarg,$value)=explode(" ",$arg);
				

					if($comarg=="=="){
						if($member[$field]!=$value){
							$bad=0;
						}
					}elseif($comarg=="!="){
						if($member[$field]==$value){
							$bad=0;
						}					
					}elseif($comarg==">"){
						if($member[$field]<$value){
							$bad=0;
						}					
					}elseif($comarg=="<"){
						if($member[$field]>$value){
							$bad=0;
						}					
					}
					
				}
				
			}
			
					if($bad){
						$members[$rn][allgood]=1;
					}
	}
	
	if($members[$rn][allgood]==1){
		$good_members[$rn]=$member;
	}
	
}
}

return $good_members;
}

/////////////////////////////////////////////////////////////////////////////////////////


function merge_lists($lists){
	foreach($lists as $list){
		$members_array=parse_member_list(list_info($list), get_list_members($list));
			foreach($members_array as $member){
				$all_members[]=$member;
			}
	}
return $all_members;
}

/////////////////////////////////////////////////////////////////////////////////////////

function add_member($ListID,$member_data, $collection_source){

//validation routines!
$list_info=list_info($ListID);
if($list_info[Active]==0){
   HandleError("Error401",0);
   return 0;
}


if($list_info[ListSourceType]=="textfile"){
	//check that we can write to the data file!
	list(,,,,$allowedits)=explode("/#", $list_info[ListSource]);
	if($allowedits<1){
   		HandleError("Error401");	
		return 0;
	}
}


if($list_info[ListSourceType]=="textfile"){
	list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
			//grab the unique field value!
			$unique=$member_data[$list_info[UniqueField]];
			
	if(@$f=fopen($filename,"a+")){
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		//split up the file into records!
		$record_delim=str_replace('NEWLINE', "\n", $record_delim);
		$records=explode($record_delim,$data);
		
		if($headers==1){
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($field_delim, $the_headers);
		}else{
			$fields=explode(",", $headers);
		}
		
		$the_line="";
		foreach($fields as $field){
			$the_line.=$member_data[$field].',';
			$member_data[$field]="XXXXXX########";
		}
		$fr=strlen($the_line);
		$the_line=substr($the_line,0,$fr-1);

		fputs($f,"\n$the_line");
		fclose($f);


	}else{
		HandleError("Error203",0);
	}
}elseif($list_info[ListSourceType]=="mysqldatabase"){
	list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$list_info[ListSource]);
	mysql_close();
	$MySQLLink=@mysql_connect("$server:$port",$user,$pass);
	
			//do we already have a unique id
		$unique=$member_data[$list_info[UniqueField]];
	
	if(mysql_select_db($database,$MySQLLink)){
		//find out what fields we have!
		$fields = mysql_list_fields($database, $table, $MySQLLink);
		$columns = mysql_num_fields($fields);
		for ($i = 0; $i < $columns; $i++) {
  			$the_fields[]=mysql_field_name($fields, $i);
		}
		
		foreach($the_fields as $field){
			$query.="$field='".$member_data[$field]."',";
			$member_data[$field]="XXXXXX########";
		}
		
		$fr=strlen($query);
		$query=substr($query,0,$fr-1);
		
		$query="INSERT INTO $table SET $query";
		mysql_query($query, $MySQLLink);
		if(!$unique){
		$unique=mysql_insert_id($MySQLLink);
		}

	}else{
		HandleError("Error202",1);	
	}

	
	mysql_close($MySQLLink);
		global $MySQLServer,$MySQLUser,$MySQLPass,$MySQLDatabase;
		//connect to the db!
		mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
		mysql_select_db($MySQLDatabase);

	mysql_select_db($MySQLDatabase);
}

	foreach($member_data as $fieldname=>$value){
		if($value!="XXXXXX########"){
					if(!$unique){
						HandleError("Error204",1);				
					}else{		
			//we need to insert this as an extra data field!
				mysql_query("INSERT INTO extra_data SET ListID='$ListID', UniqueFieldValue='$unique', DataFieldName='$fieldname', DataFieldValue='$value', CollectedFrom='$collection_source', DataDate='".time()."'");
					}	
		}
	
	}



}

/////////////////////////////////////////////////////////////////////////////////////////

function edit_member($ListID,$member_data,$collection_source,$list_info=0){

//validation routines!
if(!$list_info){
	$list_info=list_info($ListID);
}


if($list_info[Active]==0){
   return HandleError("Error401",2);
   return 0;
}


if($list_info[ListSourceType]=="textfile"){
	//check that we can write to the data file!
	list(,,,,$allowedits)=explode("/#", $list_info[ListSource]);
	if($allowedits<1){
   		return HandleError("Error401",2);	
		return 0;
	}
}


if($list_info[ListSourceType]=="textfile"){
	list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
			//grab the unique field value!
			$unique=$member_data[$list_info[UniqueField]];
			$memdat2=$member_data;
			
			if(!$unique){
					return HandleError("Error204",2);	
			}
			
	if(@$f=fopen($filename,"r+")){
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		//split up the file into records!
		$record_delim=str_replace('NEWLINE', "\n", $record_delim);
		$records=explode($record_delim,$data);
		
		if($headers==1){
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($field_delim, $the_headers);
		}else{
			$fields=explode(",", $headers);
		}
		
		$the_line="";
		$gt=0;
		foreach($fields as $field){
							if($field==$list_info[UniqueField]){
								$unique_num=$gt;
							}
							$gt++;
			$the_line.=$member_data[$field].',';
			$member_data[$field]="XXXXXX########";
		}
		$fr=strlen($the_line);
		$the_line=substr($the_line,0,$fr-1);
		
		//now that we have the line that needs replaced, we can loop through and find the old line!	
						//first we need to work out which field is the unique
						
				$records=explode($record_delim,$data);
				foreach($records as $record){
					$bits=explode($field_delim,$record);
					  if($bits[$unique_num]==$memdat2[$list_info[UniqueField]]){
						$record=$the_line;
					  }
					  $all_data.=$record."\n";
				}
					if(@$f=fopen($filename,"w")){
						fputs($f,$all_data);
					}
			
		


	}else{
		return HandleError("Error203",2);
	}
}elseif($list_info[ListSourceType]=="mysqldatabase"){
	list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$list_info[ListSource]);
	mysql_close();
	$MySQLLink=@mysql_connect("$server:$port",$user,$pass);
	
			//do we already have a unique id
		$unique=$member_data[$list_info[UniqueField]];
		
			if(!$unique){
					return HandleError("Error204",2);	
			}
		
	if(mysql_select_db($database,$MySQLLink)){
		//find out what fields we have!
		$fields = mysql_list_fields($database, $table, $MySQLLink);
		$columns = mysql_num_fields($fields);
		for ($i = 0; $i < $columns; $i++) {
  			$the_fields[]=mysql_field_name($fields, $i);
		}
		
		foreach($the_fields as $field){
			$query.="$field='".$member_data[$field]."',";
			$member_data[$field]="XXXXXX########";
		}
		
		$fr=strlen($query);
		$query=substr($query,0,$fr-1);
		
		$query="UPDATE $table SET $query WHERE ".$list_info[UniqueField]."='$unique'";
		mysql_query($query, $MySQLLink);
		if(!$unique){
		$unique=mysql_insert_id($MySQLLink);
		}

	}else{
		HandleError("Error202",1);	
	}

	
	mysql_close($MySQLLink);
			global $MySQLServer,$MySQLUser,$MySQLPass,$MySQLDatabase;
		//connect to the db!
		mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
		mysql_select_db($MySQLDatabase);

	mysql_select_db($MySQLDatabase);
}

///////////

	foreach($member_data as $fieldname=>$value){
		if($value!="XXXXXX########"){
					if(!$unique){
						HandleError("Error204",0);				
					}else{		
			//we need to insert this as an extra data field!
						if(mysql_num_rows(mysql_query("SELECT * FROM extra_data WHERE ListID='$ListID' && UniqueFieldValue='$unique' && DataFieldName='$fieldname'"))){
							mysql_query("UPDATE extra_data SET DataFieldValue='$value', CollectedFrom='$collection_source', DataDate='".time()."' WHERE ListID='$ListID' && UniqueFieldValue='$unique' && DataFieldName='$fieldname'");
						}else{
							mysql_query("INSERT INTO extra_data SET ListID='$ListID', UniqueFieldValue='$unique', DataFieldName='$fieldname', DataFieldValue='$value', CollectedFrom='$collection_source', DataDate='".time()."'");
						}
					}	
		}
	
	}



}
/////////////////////////////////////////////////////////////////////////////////////////

function remove_member($ListID,$UniqueKey){
	$list_info=list_info($ListID);

if($list_info[Active]==0){
   return HandleError("Error401",2);
   return 0;
}


if($list_info[ListSourceType]=="textfile"){
	//check that we can write to the data file!
	list(,,,,$allowedits)=explode("/#", $list_info[ListSource]);
	if($allowedits<1){
   		return HandleError("Error401",2);	
		return 0;
	}
}

if($list_info[ListSourceType]=="textfile"){
	list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
			//grab the unique field value!

	if(@$f=fopen($filename,"r+")){
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		//split up the file into records!
		$record_delim=str_replace('NEWLINE', "\n", $record_delim);
		$records=explode($record_delim,$data);
		
		if($headers==1){
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($field_delim, $the_headers);
		}else{
			$fields=explode(",", $headers);
		}
		
						
			foreach($fields as $field){
							if($field==$list_info[UniqueField]){
								$unique_num=$gt;
							}
							$gt++;
		}
						
						
				$records=explode($record_delim,$data);
				foreach($records as $record){
					$bits=explode($field_delim,$record);
					  if($bits[$unique_num]==$UniqueKey){
					 	 $all_data.="";
					  }else{
					 	 $all_data.=$record."\n";
					  }

				}
					if(@$f=fopen($filename,"w")){
						fputs($f,$all_data);
					}
	}else{
		return HandleError("Error203",2);
	}
}elseif($list_info[ListSourceType]=="mysqldatabase"){
	list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$list_info[ListSource]);
	mysql_close();
	$MySQLLink=@mysql_connect("$server:$port",$user,$pass);

		
	if(mysql_select_db($database,$MySQLLink)){

		$query="DELETE FROM $table WHERE ".$list_info[UniqueField]."='$UniqueKey'";
		mysql_query($query, $MySQLLink);

	}else{
		HandleError("Error202",1);	
	}

	
	mysql_close($MySQLLink);
			global $MySQLServer,$MySQLUser,$MySQLPass,$MySQLDatabase;
		//connect to the db!
		mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
		mysql_select_db($MySQLDatabase);

	mysql_select_db($MySQLDatabase);
}

///////////

	//now remove the extra data!
	mysql_query("DELETE FROM extra_data WHERE ListID='$ListID' && UniqueFieldValue='$UniqueKey'");



}

/////////////////////////////////////////////////////////////////////////////////////////  
					                                                                                              
function audit_list($ListID){
	$list_info=list_info($ListID);
	$list_info[ListSourceType];
		if(trim($list_info[ListSourceType])=="textfile"){
					list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
				if(@$f=fopen($filename,"r+")){
			//grab file contents!
			while(!feof($f)){
				$data=fread($f,1024);
			}
					$record_delim=str_replace('NEWLINE', "\n", $record_delim);
					$records=explode($record_delim,$data);	
				
			if($headers==1){
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($field_delim, $the_headers);
			}else{
			$fields=explode(",", $headers);
			}
				
				//check if we actually have a unique field!
				if(!in_array($list_info[UniqueField],$fields)){
					$no_unique=1;
				}
				
						$gt=0;
			foreach($fields as $field){
							if($field==$list_info[UniqueField]){
								$unique_num=$gt;
							}
							$gt++;
			}
				$unique_vals[]="";
				foreach($records as $record){
						$datainrecord=explode($field_delim,$record);
						$unique_val=$datainrecord[$unique_num];
						//check if the unique val is duplicated!
						if($unique_val && sizeof($datainrecord)>0){
							if(in_array($unique_val,$unique_vals)){
								$duplications[$unique_val]++;
							}
						}
						$unique_vals[]=$unique_val;
						
						
				}

			}else{
				$datasourceerror=1;
			}
			
		
		}elseif($list_info[ListSourceType]=="mysqldatabase"){
				list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$list_info[ListSource]);
				mysql_close();
				$MySQLLink=@mysql_connect("$server:$port",$user,$pass);
	
				if(mysql_select_db($database,$MySQLLink)){
				//find out what fields we have!
					$fields = mysql_list_fields($database, $table, $MySQLLink);
					$columns = mysql_num_fields($fields);
					for ($i = 0; $i < $columns; $i++) {
  						$the_fields[]=mysql_field_name($fields, $i);
					}
					
				}else{
					$datasourceerror=1;
				}
				
				//do we have a unique field to work with?!	
				if(!in_array($list_info[UniqueField],$the_fields)){
					$no_unique=1;
				}	
				
				$res=mysql_query("SELECT * FROM $table",$MySQLLink);
					
					$unique_vals[]="";
					while($r=mysql_fetch_array($res)){
						$xb=$list_info[UniqueField];
						$unique_val=$r[$xb];
						//check if the unique val is duplicated!
						if($unique_val && sizeof($r)>0){
							if(in_array($unique_val,$unique_vals)){
								$duplications[$unique_val]++;
							}
						}
						$unique_vals[]=$unique_val;
					}
				mysql_close($MySQLLink);
						global $MySQLServer,$MySQLUser,$MySQLPass,$MySQLDatabase;
		//connect to the db!
		mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
		mysql_select_db($MySQLDatabase);

				mysql_select_db($MySQLDatabase);
		}
		
		if($datasourceerror==1){
			$errors[datasource]="Unavailable";
			
		}else{
		
			//now evaluate the lists duplication issues!
			if($no_unique!=1 && $duplications){
				$errors[duplications]=$duplications;
			}elseif($no_unique==1){
				$errors[nounique]="None";
			}
		}
		
		return $errors;
}

/////////////////////////////////////////////////////////////////////////////////////////

		/*
		*      $ListID=2;
	$members_array=parse_member_list(list_info($ListID),get_list_members($ListID)); 
			//now print a list of the members...
		foreach($members_array as $member_key=>$member){
			foreach($member as $field=>$value){
			echo "$field: $value<BR>";
			}
			echo "<BR><BR>";
		} 
		

audit_list(1);


//////
$add_member_data[email]="mail@mail.ru";
$add_member_data[name]="mail";
$add_member_data[car_make]="nissan";
$add_member_data[id]="1";
$add_member_data[car_model]="skyline";
$add_member_data[car_year]="2002";
$add_member_data[receiving]="yes";
$add_member_data[ordernumber]="000000000000001";

edit_member(1,$add_member_data,"Form:001");		



/////

		
$ListID[]=1;
$ListID[]=2;



$members_array=filter_members(list_info($ListID),"id > 14 && name != sdfdsf OR id == OR name == BOB",$members_array);


		
*/		

?>