<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    move.php - Handle moving of topics.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/move.php");	
$Document['forumNavigation']=commonTopicNavigation();

if(!commonVerifyAdmin())//only global moderators or administrators can move topic
	commonDisplayError($Language[Notify],$Language[Accessdenied]);

$Document['contents'] .= commonTableHeader(true,0,200,"$Language[Move] $Language[Topic]");

$action=$VARS['action']==""?"display":$VARS['action'];
$exe="{$action}Move";
$exe();	

$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");

// Display available forums for moving topic.  Closed boards or forums are not available for selection.
function displayMove(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$buttons=commonGetSubmitButton(false,$Language['Move'],$confirm);
	$sql="select forum.forumId,forum.boardId,forum.name, board.name as boardName from {$Global_DBPrefix}Forums forum left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) where board.status!=0 and forum.status!=0 order by board.displayOrder,forum.displayOrder";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$selected=$dataSet['forumId']==$Document[forumId]?"selected":"";
		$forumsListing .= "<OPTION VALUE=\"$dataSet[forumId]\" $selected>$dataSet[boardName]: $dataSet[name]</OPTION>";
	}			
	$sql="select t.topicId,p.subject from {$Global_DBPrefix}Topics as t, {$Global_DBPrefix}Posts as p where t.startPostId=p.postId and t.topicId=$VARS[topicId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$dataSet[forumsListing]=$forumsListing;
	$dataSet[preForumId]=$Document[forumId];
	$Document['contents'] .= getMoveFormHTML($dataSet,$buttons);
}//displayMove

//  Move topic
function moveMove(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	if($preForumId==$forumId){
		$Document['msg'] = $Language['Movetopicerror'];
		displayMove();
	}	
	else{
		$sql="update {$Global_DBPrefix}Topics set forumId=$forumId where topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
		commonResetForums(array($forumId,$preForumId));
		$Document['contents'] .= commonForwardTopic("$Language[Thankyou] $Language[Topicmoved].","?mode=topics&topicId=$topicId&nl=1",3);		
	}		
}//moveMove


?>