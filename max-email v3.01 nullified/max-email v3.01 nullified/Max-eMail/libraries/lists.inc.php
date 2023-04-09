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

function AllListsInList($format,$checkadminprivs=0){
	$lists=mysql_query("SELECT * FROM lists");
	GLOBAL $AdminID;
	$GroupInfo=AdminGroupInfo($AdminID);
	while($list=mysql_fetch_array($lists)){
			if(mysql_num_rows(mysql_query("SELECT * FROM admin_group_privelages WHERE AdminGroupID='".$GroupInfo[AdminGroupID]."' && Action LIKE '$checkadminprivs|members|".$list[ListID]."'")) || $GroupInfo[SuperUser]==1 || !$checkadminprivs){
				$alllist.=$format;
				$alllist=str_replace("ListID",$list[ListID], $alllist);
				$alllist=str_replace("ListName",$list[ListName], $alllist);
			}
	}
	return $alllist;
}


function list_info($ListID, $param="all"){
	$list_info=mysql_fetch_array(mysql_query("SELECT * FROM lists WHERE ListID='$ListID'"));
		if($param=="all"){
			return $list_info;
		}else{
			return $list_info[$param];
		}
}

function list_fields($ListID){
	$list_info=list_info($ListID);
		if(trim($list_info[ListSourceType])=="textfile"){
			list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
			if(@$f=fopen($filename,"r")){
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
			return $fields;
		}
	}elseif($list_info[ListSourceType]=="mysqldatabase"){

		list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$list_info[ListSource]);
		mysql_close();
		$MySQLLink=@mysql_connect("$server:$port",trim($user),trim($pass));
		if(mysql_select_db($database,$MySQLLink)){
		//find out what fields we have!
		$fields = mysql_list_fields($database, $table, $MySQLLink);
		$columns = mysql_num_fields($fields);
		for ($i = 0; $i < $columns; $i++) {
  			$the_fields[]=mysql_field_name($fields, $i);
		}
		mysql_close($MySQLLink);
		global $MySQLServer,$MySQLUser,$MySQLPass,$MySQLDatabase;
		//connect to the db!
		mysql_connect($MySQLServer,$MySQLUser,$MySQLPass);
		mysql_select_db($MySQLDatabase);

		return $the_fields;
		
		}
	}

}

function IsUniqueEmail($Email,$ListID){
	$members=get_list_members($ListID);
	$list_info=list_info($ListID);
	$Email=trim($Email);
	if($members){foreach($members as $member2){
	$UniqueField=$member2[$list_info[EmailField]];
		if($UniqueField==$Email && isset($UniqueField)){
			$RepeatedUniques=1;
		}

	}}
	
	if($RepeatedUniques){
		return 0;
	}else{
		return 1;
	}

}

function UniqueInList($Unique,$ListID){
	$members=get_list_members($ListID);
	$list_info=list_info($ListID);

	if($members){foreach($members as $member2){
	$UniqueField=$member2[$list_info[UniqueField]];
		if($UniqueField==$Unique && $UniqueField && isset($Unique)){
			$RepeatedUniques=1;
		}

	}}
	
	if($RepeatedUniques){
		return 0;
	}else{
		return 1;
	}

}

?>