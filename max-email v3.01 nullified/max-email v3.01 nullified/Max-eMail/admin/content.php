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
include "../config.inc.php";


if($action){

			if(CanPerformAction("$action|content|$ContentCatID")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
		switch($action){
			case "create":
			ContentAdd();
			break;
			
			case "edit":
			ContentEdit();
			break;
			
			case "manage":
			ContentManage();
			//content category management!
			break;

		}
}else{
	ContentMain();
}

/////////////////////////////////////////////////////////////

function ContentEdit(){
	GLOBAL $create, $FULL_OUTPUT, $ContentCatID, $ContentID, $Delete, $Field, $save, $Reviewed, $ItemName;
	
		if($create){
			mysql_query("INSERT INTO content_items SET ContentCatID='$ContentCatID', ContentItemName='NewContent', DateAdded='".time()."'");
			$ContentID=mysql_insert_id();
		}
	
	if($save){
		$fields=mysql_query("SELECT * FROM content_fields WHERE ContentCatID='".$ContentCatID."'");
		mysql_query("UPDATE content_items SET Reviewed='$Reviewed', ContentItemName='$ItemName' WHERE ContentID='$ContentID'");
			mysql_query("DELETE FROM content_data WHERE ContentID='$ContentID'");
		while($f=mysql_fetch_array($fields)){
			mysql_query("INSERT INTO content_data SET Data='".$Field[$f[FieldID]]."', FieldID='".$f[FieldID]."', ContentID='$ContentID'");
		}
		ContentMain();
		FinishOutput();
	}
	
	if($Delete){
		mysql_query("DELETE FROM content_items WHERE ContentID='$ContentID'");
		mysql_query("DELETE FROM content_data WHERE ContentID='$ContentID'");
		ContentMain();
		FinishOutput();
	}
	
	$item=mysql_fetch_array(mysql_query("SELECT * FROM content_items WHERE ContentID='$ContentID' && ContentCatID='$ContentCatID'"));
	
	$fields=mysql_query("SELECT * FROM content_fields WHERE ContentCatID='".$item[ContentCatID]."'");
	
		while($f=mysql_fetch_array($fields)){
			$dat=mysql_fetch_array(mysql_query("SELECT * FROM content_data WHERE ContentID='$ContentID' && FieldID='".$f[FieldID]."'"));
			if($f[Type]=="smalltext"){
				$FORM_ITEMS[$f[FieldName]]="textfield|Field[".$f[FieldID]."]:1000:30:".str_replace(":", '$$COLON$$',$dat[Data]);
			}elseif($f[Type]=="longtext"){
				$FORM_ITEMS[$f[FieldName]]="textarea|Field[".$f[FieldID]."]:65:5:".str_replace(":", '$$COLON$$',$dat[Data]);		
			}
		}
		
		$FORM_ITEMS[-2]="spacer|&nbsp;";
		$FORM_ITEMS["Item Name"]="textfield|ItemName:40:30:".$item[ContentItemName];
		$FORM_ITEMS["Ready to publish"]="select|Reviewed:1:0->No;1->Yes:".$item[Reviewed];
		
		$FORM_ITEMS[-1]="submit|Save Changes";
	
		//make the form
			$FORM=new AdminForm;
			$FORM->title="EditContentCategory";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="content.php?action=edit&save=yes&ContentCatID=$ContentCatID&ContentID=$ContentID";
			$FORM->MakeForm();
	$BoxOut.=$FORM->output;
	$BoxOut.='<P>'.MakeLink("content.php", "Back to saved content main");
	
	$FULL_OUTPUT.=MakeBox("Edit content item", $BoxOut);
	
	

}

////////////////////////////////////////////////////////////

function ContentManage(){
	GLOBAL $FULL_OUTPUT, $Delete, $HTMLFormat, $TextFormat, $DeleteFieldID, $create, $FieldNumber, $ContentCatName, $ContentCatID, $save, $FieldName, $Required, $NewFieldRequired, $NewFieldName, $Type, $NewFieldType;
				
		if($Delete){
			mysql_query("DELETE FROM content_fields WHERE ContentCatID='$ContentCatID'");
			mysql_query("DELETE FROM content_cats WHERE ContentCatID='$ContentCatID'");
				$re=mysql_query("SELECT * FROM content_items WHERE ContentCatID='$ContentCatID'");
				while($f=mysql_fetch_array($re)){
					mysql_query("DELETE FROM content_data WHERE ContentID='".$f[ContentID]."'");				
				}
			
			mysql_query("DELETE FROM content_items WHERE ContentCatID='$ContentCatID'");
			ContentMain();
			FinishOutput();
		}
	
		if($DeleteFieldID){
			mysql_query("DELETE FROM content_fields WHERE FieldID='$DeleteFieldID'");
		}	
			
		if($create){
			mysql_query("INSERT INTO content_cats SET ContentCatName='$ContentCatName'");
			$ContentCatID=mysql_insert_id();
		}
		
		if($save){
			mysql_query("UPDATE content_cats SET HTMLFormat='$HTMLFormat', TextFormat='$TextFormat' WHERE ContentCatID='$ContentCatID'");
			if($FieldName){
				foreach($FieldName as $id=>$Name){
					mysql_query("UPDATE content_fields SET FieldName='$Name', Required='".$Required[$id]."', Type='".$Type[$id]."' WHERE FieldID='$id' && ContentCatID='$ContentCatID'");
				}
			}
			if($NewFieldName){
				foreach($NewFieldName as $id=>$Name){
					mysql_query("INSERT INTO content_fields SET FieldName='$Name', Required='".$NewFieldRequired[$id]."', Type='".$NewFieldType[$id]."', FieldID='$id', ContentCatID='$ContentCatID'");
				}
			}
		}
		
		//now the edit form!
			$current_fields=mysql_query("SELECT * FROM content_fields WHERE ContentCatID='$ContentCatID'");
			
			while($cf=mysql_fetch_array($current_fields)){
				$i++;
				$FORM_ITEMS["Field $i name"]="textfield|FieldName[".$cf[FieldID]."]:10:10:".$cf[FieldName];
				$FORM_ITEMS["Field $i Required"]="select|Required[".$cf[FieldID]."]:1:0->No;1->Yes:".$cf[Required];
				$FORM_ITEMS["Field $i Type"]="select|Type[".$cf[FieldID]."]:1:smalltext->SmallText;longtext->LongText:".$cf[Type];				
				$FORM_ITEMS[-$i]="spacer|".MakeLink("content.php?action=manage&ContentCatID=$ContentCatID&DeleteFieldID=".$cf[FieldID], "Delete Field");
				$FORM_ITEMS[-$i-10000]="spacer|&nbsp;";
				$x=$cf[FieldID];
			}
			
			for($b=1;$b<=$FieldNumber;$b++){
				$i++;
				$x++;
				$FORM_ITEMS["Field $i name"]="textfield|NewFieldName[$x]:10:10";
				$FORM_ITEMS["Field $i Required"]="select|NewFieldRequired[$x]:1:0->No;1->Yes";
				$FORM_ITEMS["Field $i Type"]="select|NewFieldType[$x]:1:smalltext->SmallText;longtext->LongText";	
			}
			
				$concat=mysql_fetch_array(mysql_query("SELECT * FROM content_cats WHERE ContentCatID='$ContentCatID'"));
					if(!$concat[HTMLFormat]){
						$fi=mysql_query("SELECT * FROM content_fields WHERE ContentCatID='$ContentCatID'");
						while($if=mysql_fetch_array($fi)){
							$concat[HTMLFormat].="%".$if[FieldName]."%\n<BR>\n";
						}
					}
					
					if(!$concat[TextFormat]){
						$fi=mysql_query("SELECT * FROM content_fields WHERE ContentCatID='$ContentCatID'");
						while($if=mysql_fetch_array($fi)){
							$concat[TextFormat].="%".$if[FieldName]."%\n\n";
						}
					}
				
				$FORM_ITEMS["HTML Format"]="textarea|HTMLFormat:45:5:".$concat[HTMLFormat];
				$FORM_ITEMS["Text Format"]="textarea|TextFormat:45:5:".$concat[TextFormat];
			
				$FORM_ITEMS[-1000]="submit|Save Changes";
					
					//make the form
					$FORM=new AdminForm;
					$FORM->title="EditContentCategory";
					$FORM->items=$FORM_ITEMS;
					$FORM->action="content.php?action=manage&save=yes&ContentCatID=$ContentCatID";
					$FORM->MakeForm();
		
		$FULL_OUTPUT.=MakeBox("Edit Content Category", $FORM->output.MakeLink("content.php?action=manage&ContentCatID=$ContentCatID&FieldNumber=1", "Add another field")." | ".MakeLink("content.php", "Saved Content Main")." | ".MakeLink("content.php?action=manage&Delete=yes&ContentCatID=$ContentCatID", "Delete content category",1));	
}

/////////////////////////////////////////////////////////////

function ContentMain(){
	GLOBAL $FULL_OUTPUT;
	
	$bo='<TABLE width=100%>';
	
	$content_cats=mysql_query("SELECT * FROM content_cats");
	while($cc=mysql_fetch_array($content_cats)){
		if(CanPerformAction("edit|content|".$cc[ContentCatID])==1){
			$bo.='<TR><td colspan="4"><span class="admintext"><B>Category '.$cc[ContentCatName].'</B></span></td></tr>';
			$bo.='<tr><td><span class="admintext">Item Name</span></td><td><span class="admintext">Source</span></td><td><span class="admintext">Status</span></td><td><span class="admintext">Options</span></td></tr>';
			$bo.='<TR bgcolor="#cccccc" height="1"><td colspan="4"></td></tr>';
			$items=mysql_query("SELECT * FROM content_items WHERE ContentCatID='".$cc[ContentCatID]."' ORDER BY Reviewed ASC");
				while($it=mysql_fetch_array($items)){
						if($it[Source]!="Admin"){
							list(,$formid)=explode(":", $it[Source]);
							$fo=FormInfo($formid);
							$source=$fo[Name];
						}else{
							$source="Admin";
						}
						
						if($it[Reviewed]==0){
							$status="Not Reviewed";
						}else{
							$status="Reviewed";
						}
					$bo.='<tr><td><span class="admintext">'.$it[ContentItemName].'</span></td><td><span class="admintext">'.$source.'</span></td><td><span class="admintext">'.$status.'</span></td><td><span class="admintext">'.MakeLink("content.php?action=edit&ContentCatID=".$cc[ContentCatID]."&ContentID=".$it[ContentID], "Edit").' | '.MakeLink("content.php?Delete=Yes&action=edit&ContentCatID=".$cc[ContentCatID]."&ContentID=".$it[ContentID], "Delete",1).'</span></td></tr>';
				}
			$bo.='<tr><td colspan="4"><BR>'.MakeLink("content.php?action=edit&create=yes&ContentCatID=".$cc[ContentCatID],"Add Content Item").'</td></tr>';
		}	
		
		
	}
	
	$bo.='</table>';
	
	
	$FULL_OUTPUT.=MakeBox("Edit content", $bo);
	
	
			if(CanPerformAction("manage|content|")==1){
						//edit content categories form!
						$cats=mysql_query("SELECT * FROM content_cats");
						while($c=mysql_fetch_array($cats)){
							$allcats.=$c[ContentCatID]."->".$c[ContentCatName].";";
						}
						
						$FORM_ITEMS2["Category"]="select|ContentCatID:1:$allcats";
						$FORM_ITEMS2[-1]="submit|Edit Now";
							//make the form
							$FORM2=new AdminForm;
							$FORM2->title="EditContentCategory";
							$FORM2->items=$FORM_ITEMS2;
							$FORM2->action="content.php?action=manage";
							$FORM2->MakeForm();
				
							$FULL_OUTPUT.=MakeBox("Edit Content Category", $FORM2->output);		
						
						
						//add new content category!
						$FORM_ITEMS["Category name"]="textfield|ContentCatName:30:30:NewContentCategory";
						$FORM_ITEMS["Number of fields"]="textfield|FieldNumber:10:10:3";
						$FORM_ITEMS[-1000]="submit|Continue";
					//make the form
					$FORM=new AdminForm;
					$FORM->title="AddContentCategory";
					$FORM->items=$FORM_ITEMS;
					$FORM->action="content.php?action=manage&create=yes";
					$FORM->MakeForm();
				
				$FULL_OUTPUT.=MakeBox("Add a new content category", $FORM->output);			
			}
	

}


FinishOutput();

?>