<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminBoards.php - Process all actions related to 
//                  boards in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$action=$VARS['action']==''?"list":$VARS['action'];
$Document[contentWidth]="80%";
include_once("$GlobalSettings[templatesDirectory]/adminBoards.php");

$exe="{$action}Board";
$exe();	

//  move board's display order down by one 
function movedownBoard(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	extract($VARS,EXTR_OVERWRITE);
	$sql="select max(displayOrder) as displayOrder from {$Global_DBPrefix}Boards";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);		
	$newDO=$displayOrder +1;
	if($dataSet['displayOrder']==$displayOrder){
		$sql="update {$Global_DBPrefix}Boards set displayOrder=displayOrder+1";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$sql="update {$Global_DBPrefix}Boards set displayOrder=1 where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	else{
		$sql="update {$Global_DBPrefix}Boards set displayOrder=$displayOrder where displayOrder=$newDO";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
		$sql="update {$Global_DBPrefix}Boards set displayOrder=$newDO where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
	}
	listBoard();
}//movedownBoard

//  move board's display order up by one 
function moveupBoard(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	extract($VARS,EXTR_OVERWRITE);
	$newDO=$displayOrder -1;
	if($newDO >0){
		$sql="update {$Global_DBPrefix}Boards set displayOrder=$displayOrder where displayOrder=$newDO";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$sql="update {$Global_DBPrefix}Boards set displayOrder=$newDO where boardId=$boardId";		
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	else{
		$sql="update {$Global_DBPrefix}Boards set displayOrder=displayOrder - 1";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$sql="select max(displayOrder) as displayOrder from {$Global_DBPrefix}Boards";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);		
		$sql="update {$Global_DBPrefix}Boards set displayOrder=$dataSet[displayOrder] + 1 where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	listBoard();
}//moveupBoard

//  Reset boards' display orders to be alphabetically.
function resetOrderBoard(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select boardId from {$Global_DBPrefix}Boards order by name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$displayOrder=1;
	while($dataSet=mysql_fetch_array($fetchedData)){
		mysql_query("update {$Global_DBPrefix}Boards set displayOrder=$displayOrder where boardId=$dataSet[boardId]");			
		$displayOrder++;
	}
	listBoard();
}//resetOrderBoard

//  Update boards as accessible|inaccessible
function accessBoard(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language,$AdminLanguage;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="update {$Global_DBPrefix}Boards set status=$VARS[status] where boardId=$VARS[boardId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg'] = $VARS[status]?"$AdminLanguage[Boardopen].":"$AdminLanguage[Boardclosed].";
	listBoard();
}//accessBoard

//  Get new board form
function newBoard(){	
	global $Member,$Document,$VARS,$AdminLanguage;		
	$Document['groupsSelected'] = getGroupsListing("");	
	$Document['contents'] .= getBoardFormHTML("$AdminLanguage[CreateNewBoard]","Create");	
}//newBoard

//  Edit board
function editBoard(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select boardId, name, description,accessibleGroups,status from {$Global_DBPrefix}Boards where boardId=$VARS[boardId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[boardId]){
		$VARS=$dataSet;
		$Document['groupsSelected']=getGroupsListing($dataSet[accessibleGroups]);
		$Document['contents'] .= getBoardFormHTML("$Language[Edit] $Language[Board]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $Language[Board]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editBoard

// Update board
function updateBoard(){
	global $Language,$Document,$GlobalSettings,$VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($name)==""){
		$isError=true;
		$errorMsg="$Language[Name] $Language[isblank]";
	}
	if($isError){
		$Document['msg'] = $errorMsg;		
	}	
	else{
		if(count($groupsSelected)){
			$accessibleGroups = implode(" ",$groupsSelected);
		}
		$VARS[name]=htmlspecialchars($VARS[name]);
		$VARS[description]=htmlspecialchars($VARS[description]);
		$sql="update {$Global_DBPrefix}Boards set name=\"$VARS[name]\", description=\"$VARS[description]\", accessibleGroups=\"$accessibleGroups\" where boardId=$VARS[boardId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] = "  $Language[Recordupdated].";
		$Document['groupsSelected']=getGroupsListing($accessibleGroups);
	}
	editBoard();
}//updateBoard

//  Delete board and related forums,topics,posts, attachments,polls
function deleteBoard(){
	global $Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$topics=array();
	$forums=array();
	$affectedPosts=array();
	$sql="select forumId from {$Global_DBPrefix}Forums where boardId=$VARS[boardId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		array_push($forums,$dataSet[forumId]);
	}
	foreach($forums as $forumId){
		$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$forumId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		while($dataSet = mysql_fetch_array($fetchedData)){
			array_push($topics,$dataSet[topicId]);
		}
		foreach($topics as $topicId){
			$sql="select postId from {$Global_DBPrefix}Posts where topicId=$topicId";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			while($dataSet = mysql_fetch_array($fetchedData))
			{
				array_push($affectedPosts,$dataSet[postId]);				
			}							
			$sql="delete from {$Global_DBPrefix}Posts where topicId=$topicId";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			$sql="delete from {$Global_DBPrefix}Topics where topicId=$topicId";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			$sql="delete from {$Global_DBPrefix}Notify where topicId=$topicId";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			commonDeletePoll($topicId);
			commonRemoveAttachment($affectedPosts,false);
		}
	}
	$sql="delete from {$Global_DBPrefix}Boards where boardId=$VARS[boardId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$sql="update {$Global_DBPrefix}Boards set displayOrder=displayOrder - 1 where displayOrder > $VARS[displayOrder]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);			
	$Document['msg']="Board deleted";		

	listBoard();
}//deleteBoard

//  Create new board
function createBoard(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	if(count($groupsSelected)){
		$accessibleGroups = implode(" ",$groupsSelected);
	}
	$isError=false;
	if(trim($name)==""){
		$isError=true;
		$Document['msg']="$Language[Name] $Language[isblank]";
	}
	if($isError){
		$Document['groupsSelected'] = getGroupsListing("$accessibleGroups");	
		$Document['contents'] .= getBoardFormHTML("$AdminLanguage[CreateNewBoard]","Create");	
	}
	else{
		//get lowest displayOrder
		$sql="select max(displayOrder) as displayOrder from {$Global_DBPrefix}Boards";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);		
		$displayOrder=$dataSet['displayOrder'] + 1;
		$status=1; //default is visible, 0 is closed board
		$name = htmlspecialchars($name);
		$description = htmlspecialchars($description);		
		$sql="insert into {$Global_DBPrefix}Boards (name,description,accessibleGroups,displayOrder,status) VALUES (\"$name\",\"$description\",\"$accessibleGroups\",$displayOrder,$status)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$Document['msg']="$name created";
		}
		else{
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getBoardFormHTML("$AdminLanguage[CreateNewBoard]","Create");			
		}
		listBoard();
	}
}//createBoard

//  List boards
function listBoard(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	
	$page=$VARS['page']==""?1:$VARS['page'];

	if(trim($Document['msg'])){
		$Document['contents'] .= commonEndMessage(0,$Document['msg']);
	}
	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$fromNumber=($page -1)* $Document['listingsPerPage'];
	$sql="select boardId,name,displayOrder,status from {$Global_DBPrefix}Boards $addSql order by displayOrder limit $fromNumber, $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getBoardRowHTML($dataSet);
		$lastAlpha=$dataSet[name];
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .= $page?commonEndMessage(5,$Language[Endoflisting]):commonEndMessage(5,"$Language[Norecordsfound]");

	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$Document['listingsPerPage']){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=boards&action=list&page=$page\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document[contentWidth],$previous,$next);
	$Document['contents'] .= "<BR />";
	$Document['adminFooterNavigation']=commonLanguageButton("adminresetordering","$AdminLanguage[Resetdisplayorder]","?mode=admin&case=boards&action=resetOrder","");
}//listBoard

function getGroupsListing($groups){
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	if(trim($groups)){
		$groupsArray = explode(" ",$groups);
	}
	$listing = "<OPTION VALUE=\"\">[$Language[None]]</OPTION>";
	$sql="select groupId, name from {$Global_DBPrefix}Groups order by name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		if(count($groupsArray)){
			$selected=in_array($dataSet[groupId],$groupsArray)?" selected":"";
		}
		else{
			$selected="";
		}
		$listing .= "<OPTION VALUE=\"$dataSet[groupId]\"$selected>$dataSet[name]</OPTION>";
	}
	return $listing;
}//getGroupsListing
?>