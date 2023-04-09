<?

function Banned($Email, $ListID){

	global $TABLEPREFIX;

	$domain = "";

	@list(,$domain)=explode("@",$Email);
	if(@mysql_num_rows(Mysql_query("SELECT * FROM " . $TABLEPREFIX . "banned_emails WHERE (Email LIKE '$Email' OR Email LIKE '@$domain') && (ListID='$ListID' OR Global=1) && Status='1'"))){
		return 1;
	}else{
		return 0;
	}
	
}

function OnList($Email, $ListID){

	global $TABLEPREFIX;

	if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email LIKE '$Email' && ListID='$ListID'"))){
		return 1;
	}else{
		return 0;
	}
}

function returnmembers($ListID,$Email,$Status,$Confirmed,$Fields,$ClickedLink=0,$Format="ALL", $Limit=""){

	global $TABLEPREFIX;

	$x = "";
	$RM = array();

	if($Status!="ALL"){
		$x.=" AND Status='$Status'";
	}
	
	if($Confirmed!="ALL"){
		$x.=" AND Confirmed='$Confirmed'";
	}
	
	if($Format!="ALL"){
		if($Format==1){
			$x.=" AND Format='1'";
		}else{
			$x.=" AND Format='0'";		
		}
	}

	$res=mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email LIKE '%$Email%' AND ListID='$ListID' $x ORDER BY Email");

	while($r=mysql_fetch_array($res)){

		$Bad=0;
		$UserID=$r["MemberID"];

		//check they have clicked the link if any!
		if($ClickedLink>0){
			if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "link_clicks WHERE LinkID='$ClickedLink' && MemberID='".$r["MemberID"]."'"))<1){
				$Bad=1;
			}
		}
		//check that this user fits the other search criteria!
		$AFields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields");
		while($f=mysql_fetch_array($AFields)){
				$val=@$Fields[$f["FieldID"]];
			switch($f["FieldType"]){
				case "shorttext":
					if($val){
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE UserID='$UserID' && FieldID='".$f["FieldID"]."' && ListID='$ListID' && Value LIKE '%$val%'"))<1){
							$Bad=1;
						}
					}
				break;
				
				case "longtext":
					if($val){
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE UserID='$UserID' && FieldID='".$f["FieldID"]."' && ListID='$ListID' && Value LIKE '%$val%'"))<1){
							$Bad=1;
						}
					}
				break;
				
				case "dropdown":
					if($val){
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE UserID='$UserID' && FieldID='".$f["FieldID"]."' && ListID='$ListID' && Value LIKE '$val'"))<1){
							$Bad=1;
						}
					}
				break;
				
				case "checkbox":
					if($val!="all"){
						if($val=="n"){$val="";}else{$val="CHECKED";}
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE UserID='$UserID' && FieldID='".$f["FieldID"]."' && ListID='$ListID' && Value LIKE '$val'"))<1){
							$Bad=1;
						}
					}
				break;
			
			}			
		}
		
		if($Bad!=1){
			$RM[]=$UserID;
		}
		
	}
	
	
	return $RM;
}



?>