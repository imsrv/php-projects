<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminGroups.php - Process all actions related to 
//                  groups in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminGroups.php");
$Document[contentWidth]="80%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Group";
$exe();	

//  Update group
function updateGroup(){
	global $Language,$Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	$VARS[name]=htmlspecialchars($VARS[name]);	
	$VARS[description]=htmlspecialchars($VARS[description]);	
	$sql="update {$Global_DBPrefix}Groups set name=\"$VARS[name]\", description=\"$VARS[description]\" where groupId=$VARS[groupId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg']="Group updated";
	editGroup();
}//updateGroup

//  Edit group
function editGroup(){
	global $Document,$GlobalSettings,$VARS,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select groupId, name, description,status from {$Global_DBPrefix}Groups where groupId=$VARS[groupId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[groupId]){
		$VARS=$dataSet;
		$Document['contents'] .= getGroupFormHTML("$Language[Edit] $Language[Group]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("Editing Group","Retrieving record failed.");
	}		
}//editGroup

//  Delete group
function deleteGroup(){
	global $Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="delete from {$Global_DBPrefix}Groups where groupId=$VARS[groupId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg']=mysql_affected_rows()>0?"Group deleted":"Deleting failed.  Please try again.";	
	listGroup();
}//deleteGroup

//  Create new group
function createGroup(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS;	
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$isError=false;
	if(trim($name)==""){
		$isError=true;
		$Document['msg']="$Language[Name] $Language[isblank]";
	}
	if($isError){
		$Document['contents'] .= getGroupFormHTML("$AdminLanguage[CreateNewGroup]","Create");	
	}
	else{
		$name=htmlspecialchars($name);	
		$description=htmlspecialchars($description);	
		$sql="insert into {$Global_DBPrefix}Groups (name,description,status) VALUES (\"$name\",\"$description\",1)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$Document['msg']="$name created";
			listGroup();
		}
		else{
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getGroupFormHTML("$AdminLanguage[CreateNewGroup]","Create");			
		}
	}
}//createGroup

//  Get new group form
function newGroup(){	
	global $Member,$Document,$AdminLanguage;		
	$Document['contents'] .= getGroupFormHTML("$AdminLanguage[CreateNewGroup]","Create");	
}//newGroup

//  List groups
function listGroup(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$listLimit=20;
	$page=$VARS['page']==""?1:$VARS['page'];

	if(trim($Document['msg'])){
		$Document['contents'] .= commonEndMessage(0,$Document['msg']);
	}
	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();

	$fromNumber=($page -1)* $listLimit;
	$sql="select groupId,name from {$Global_DBPrefix}Groups order by name limit $fromNumber,$listLimit";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getGroupRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .=$page>1?commonEndMessage(3,"$Language[Endoflisting]"):commonEndMessage(3,"$Language[Norecordsfound]");
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$listLimit){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=groups&action=list&page=$page\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext(0,$previous,$next);
	$Document['contents'] .= "<BR />";
}//listGroup
 
?>