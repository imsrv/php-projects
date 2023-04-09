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

$client=1;include "config.inc.php";


##################################################
# THIS FILE HANDLES ALL CLIENT SIDE FORM ACTIONS #
#   EDITING THIS FILE MAY CAUSE SERIOUS ISSUES   #
#  IF YOU WISH TO MODIFY WE SUGGEST YOU CONSULT  #
# 	      THE SITEOPTIONS DEVELOPERS FIRST!      #
##################################################



if(mysql_num_rows(mysql_query("SELECT * FROM forms WHERE FormID='$FormID'"))!=1){
	echo "Invalid Form Indetifier!";	
	exit;
}


function HandleResponse($Error){
GLOBAL $FormID, $DATA;
$resp=mysql_fetch_array(mysql_query("SELECT * FROM form_actions WHERE Response='$Error' && FormID='$FormID'"));

$dofields=array(SendEmailTo, EmailSubject,EmailBody,EmailFrom,DisplayURL,DisplayText);
foreach($dofields as $name){
	$fields=mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID' ORDER BY Weight DESC");
	while($f=mysql_fetch_array($fields)){
		$resp[$name]=str_replace("%".$f[FormFieldName]."%", $DATA[$f[FormFieldName]],$resp[$name]);
	}
}

if($resp[SendEmailTo]){
	//send an email!
	@mail($resp[SendEmailTo],$resp[EmailSubject],$resp[EmailBody],"From: ".$resp[EmailFrom]."\n");
}

if($resp[DisplayURL]){
	header("Location: ".$resp[DisplayURL]);
}

if($resp[DisplayText]){
	echo $resp[DisplayText];
}

exit;
}



if($DATA){
//looks like someone is submitting!

$form=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE FormID='$FormID'"));
$fields=mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID' ORDER BY Weight DESC");

while($f=mysql_fetch_array($fields)){
	if($f[FieldType]=="input"){
	//does this field need to be verified!
		if(function_exists($f[Verification])){
			if(!call_user_func($f[Verification],$DATA[$f[FormFieldName]],$FormID)){
				HandleResponse("Error:".$f[Verification]);
			}
		}
		$MEMBER_DATA[$f[ListField]]=$DATA[$f[FormFieldName]];
	}elseif($f[FieldType]=="date"){
		$MEMBER_DATA[$f[ListField]]=time();
	}elseif($f[FieldType]=="value"){
		$MEMBER_DATA[$f[ListField]]=$f[FieldData];
	}elseif($f[FieldType]=="unique"){
		//generate unique number!
			$length=4;
			$letters=range(0,9);
			while($xt!="yes"){
				$bad=0;
				for($i=0;$i<$length;$i++){
					srand ((double) microtime() * 1000000);
					$unique.=$letters[rand(0,sizeof($letters))];
				}
				//now check it!
					$Lists=explode(",",$form[Lists]);
				foreach($Lists as $ListID){
					if($ListID){
						if(!UniqueInList($unique,$ListID)){
							$bad=1;
						}
					}
				}
				if(!$bad){
					$xt="yes";
				}
			$length++;	
			}
		$MEMBER_DATA[$f[ListField]]=$unique;
	}

}

if($form[FormType]=="insert"){
	
$Lists=explode(",",$form[Lists]);
foreach($Lists as $ListID){
	if($ListID){
		add_member($ListID,$MEMBER_DATA, "Form:$FormID");
	}
}
}elseif($form[FormType]=="update"){
	$indexval=$DATA[$form[IndexField]];
	$indexname=$form[IndexField];
	$ii=mysql_fetch_array(mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID' && FormFieldName='$indexname'"));
	$indexfield=$ii[ListField];
	$Lists=explode(",",$form[Lists]);

	foreach($Lists as $ListID){
		if($ListID){
			$members_array2=filter_members(list_info($ListID),"$indexfield == $indexval", parse_member_list(list_info($ListID),get_list_members($ListID)));
			@$member=current($members_array2);
			$unique=$member["x-unique"];
			$li=list_info($ListID);
			$MEMBER_DATA[$li[UniqueField]]=$unique;
			edit_member($ListID,$MEMBER_DATA,"Form:$FormID",$list_info=0);
		}
	}

}elseif($form[FormType]=="delete"){
	$indexval=$DATA[$form[IndexField]];
	$indexname=$form[IndexField];
	$ii=mysql_fetch_array(mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID' && FormFieldName='$indexname'"));
	$indexfield=$ii[ListField];
	$Lists=explode(",",$form[Lists]);

	foreach($Lists as $ListID){
		if($ListID){
			$members_array2=filter_members(list_info($ListID),"$indexfield == $indexval", parse_member_list(list_info($ListID),get_list_members($ListID)));
			@$member=current($members_array2);
			$unique=$member["x-unique"];
			remove_member($ListID,$unique);
		}
	}

}

HandleResponse("success");

exit;
}


//build the form!

$fields=mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID' && FieldType='input' ORDER BY Weight DESC");

echo '<form method="post" action="'.$ROOT_URL.'/form.php?FormID='.$FormID.'"><table width=200>';

echo "\n\n";

while($f=mysql_fetch_array($fields)){
	echo '<TR><TD align="right">'.$f[FormFieldName].': </td><td><input type=text name="DATA['.$f[FormFieldName].']"</td></tr>';
	echo "\n\n";
}

echo '<tr><td colspan="2"><input type=submit value="Submit Now"></td></tr></table></form>';
























?>