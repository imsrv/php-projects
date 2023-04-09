<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminForums.php - Process all actions related to 
//                  forums in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$action=$VARS['action']==''?"list":$VARS['action'];
$Document[contentWidth]="95%";
include_once("$GlobalSettings[templatesDirectory]/adminForums.php");

$exe="{$action}Forum";
$exe();	

//  Move forum's display order down by one
function movedownForum(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	extract($VARS,EXTR_OVERWRITE);
	$sql="select max(displayOrder) as displayOrder from {$Global_DBPrefix}Forums where boardId=$boardId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);		
	$newDO=$displayOrder +1;
	if($dataSet['displayOrder']==$displayOrder){
		$sql="update {$Global_DBPrefix}Forums set displayOrder=displayOrder+1 where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$sql="update {$Global_DBPrefix}Forums set displayOrder=1 where forumId=$forumId";		
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	else{
		$sql="update {$Global_DBPrefix}Forums set displayOrder=$displayOrder where displayOrder=$newDO and boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$sql="update {$Global_DBPrefix}Forums set displayOrder=$newDO where forumId=$forumId";		
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	listForum();
}//movedownForum

//  Move forum's display order up by one
function moveupForum(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	extract($VARS,EXTR_OVERWRITE);
	$newDO=$displayOrder -1;
	if($newDO >0){
		$sql="update {$Global_DBPrefix}Forums set displayOrder=$displayOrder where boardId=$boardId and displayOrder=$newDO";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$sql="update {$Global_DBPrefix}Forums set displayOrder=$newDO where boardId=$boardId and forumId=$forumId";		
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	else{
		$sql="update {$Global_DBPrefix}Forums set displayOrder=displayOrder - 1 where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);				
		$sql="select max(displayOrder) as displayOrder from {$Global_DBPrefix}Forums where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);		
		$sql="update {$Global_DBPrefix}Forums set displayOrder=$dataSet[displayOrder] + 1 where boardId=$boardId and forumId=$forumId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	listForum();
}//moveupForum

//  Reset forums' display orders to be alphabetically
function resetOrderForum(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select forumId from {$Global_DBPrefix}Forums where boardId=$VARS[boardId] order by name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$displayOrder=1;
	while($dataSet=mysql_fetch_array($fetchedData)){
		$sql="update {$Global_DBPrefix}Forums set displayOrder=$displayOrder where boardId=$VARS[boardId] and forumId=$dataSet[forumId]";
		mysql_query($sql) or commonLogError($sql,true);			
		$displayOrder++;
	}
	listForum();
}//resetOrderForum

//  Update forum as accessible|inaccessible
function accessForum(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language,$AdminLanguage;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="update {$Global_DBPrefix}Forums set status=$VARS[status] where forumId=$VARS[forumId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	

	$msg = $VARS[status]?"$AdminLanguage[Forumisopen].":"$AdminLanguage[Forumisclosed].";
	
	$Document['contents'] .=commonEndMessage(0,$msg);
	listForum();
}//accessForum

//  Delete forum and related topics,posts, attachments and polls
function deleteForum(){
	global $Document,$GlobalSettings,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$topics=array();
	$affectedPosts=array();
	$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$VARS[forumId]";
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
	$sql="delete from {$Global_DBPrefix}Forums where forumId=$VARS[forumId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$sql="update {$Global_DBPrefix}Forums set displayOrder=displayOrder - 1 where boardId=$VARS[boardId] and displayOrder > $VARS[displayOrder]";	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);			
	$Document['msg']="$Language[Forum] deleted";		
		
	listForum();
}//deleteForum

//  Create new forum
function createForum(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	if(count($moderatorsSelected)){
		$moderators = implode(" ",$moderatorsSelected);
	}
	$isError=false;
	if(trim($name)==""){
		$isError=true;
		$errorMsg="$Language[Name] $Language[isblank]";
	}
	if($isError){
		$Document['boardsListing']=getBoardsListing($boardId);
		$Document['msg'] = $errorMsg;
		$Document['contents'] .= getForumFormHTML("$AdminLanguage[CreateNewForum]","Create");	
	}
	else{
		//get lowest displayOrder
		$sql="select max(displayOrder) as displayOrder from {$Global_DBPrefix}Forums where boardId=$boardId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);		
		$displayOrder=$dataSet['displayOrder'] + 1;
		$status=1; //default is visible, 0 is closed forum
		$announcement=$announcement==""?0:$announcement;
		$name=htmlspecialchars($name);
		$description=htmlspecialchars($description);
		$sql="insert into {$Global_DBPrefix}Forums (boardId,name,description,displayOrder,topics,
			  posts,latestPostId,moderators,announcement,status) VALUES ($boardId,\"$name\",\"$description\",$displayOrder,0,0,0,\"$moderators\",$announcement,$status)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);

		if(mysql_affected_rows()>0){
			$Document['contents'] .= commonEndMessage(0,"$name $AdminLanguage[created]");
			listForum();
		}
		else{		
			$Document['boardsListing']=getBoardsListing($boardId);	
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getForumFormHTML("$Language[CreateNewForum]","Create");			
		}		
	}
}//createForum

//  Edit forum
function editForum(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select forumId, boardId, name, description,topics,
		  posts,moderators,announcement,status from {$Global_DBPrefix}Forums where forumId=$VARS[forumId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[forumId]){
		$VARS=$dataSet;
		$Document['boardsListing']=getBoardsListing($dataSet[boardId]);
		$Document['contents'] .= getForumFormHTML("$Language[Edit] $Language[Forum]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $Language[Board]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editForum

//  Update forum
function updateForum(){
	global $Language,$Document,$GlobalSettings,$VARS;
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
		$announcement=$announcement==""?0:$announcement;
		$name = htmlspecialchars($name);
		$description = htmlspecialchars($description);		
		$sql="update {$Global_DBPrefix}Forums set boardId=$boardId, name=\"$name\", description=\"$description\", moderators=\"$moderators\",announcement=$announcement where forumId=$VARS[forumId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] = "  $Language[Recordupdated].";		
		$Document['boardsListing']=getBoardsListing($boardId);
	}
	editForum();
}//updateForum

//  Get new forum form
function newForum(){	
	global $GlobalSettings,$Member,$Document,$VARS,$AdminLanguage;		
	$Document['boardsListing'] = getBoardsListing("");	
	if($Document['boardsListing']=="")
		commonDisplayError("$AdminLanguage[CreateNewForum]","$AdminLanguage[Createboardfirst]");
	
	$Document['contents'] .= getForumFormHTML("$AdminLanguage[CreateNewForum]","Create");	
}//newForum

//  List forums
function listForum(){	
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$Document['contents'] .= getNewLinksHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$sql ="select forum.forumId,forum.name,forum.displayOrder,forum.topics,forum.posts,forum.status, board.boardId, board.name as boardName, board.accessibleGroups
				from {$Global_DBPrefix}Forums as forum
				left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId)
				order by board.displayOrder, forum.displayOrder";		
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		if($dataSet['boardId'] !=$lastBoardId)
			$Document['contents'] .= getBoardRowHTML($dataSet);
		if($dataSet['status']==1){
			$dataSet['accessStatus']=0;
			$dataSet['accessImage']="adminhide.gif";
			$dataSet['accessAlt']="$AdminLanguage[Closethisforum]";
		}
		else{
			$dataSet['accessStatus']=1;
			$dataSet['accessImage']="adminopen.gif";
			$dataSet['accessAlt']="$AdminLanguage[Openthisforum]";		
		}		
		$Document['contents'] .= getForumRowHTML($dataSet);
		$lastBoardId=$dataSet['boardId'];		
	}
	if(mysql_num_rows($fetchedData)==0){
		$Document['contents'] .= commonEndMessage(7,"$Language[Norecordsfound]");
	}	
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	$Document['contents'] .= getLegendHTML();			
}//listForum
 
//  Get boards' listing as select options 
function getBoardsListing($chosen){
	global $GlobalSettings;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select boardId, name from {$Global_DBPrefix}Boards order by displayOrder";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$selected=$dataSet['boardId']==$chosen?" selected":"";
		$listing .= "<OPTION VALUE=\"$dataSet[boardId]\"$selected>$dataSet[name]</OPTION>";
	}
	return $listing;
}//getBoardsListing
 
?>