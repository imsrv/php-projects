<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    merge.php - Handle merging of topics.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/merge.php");	
$Document['forumNavigation']=commonTopicNavigation();

if(commonVerifyAdmin() || $Member[moderator])//action limited to admin & mderators only
	$Document['contents'] .= commonTableHeader(true,0,200,"$Language[Merge] $Language[Topic]");
else
	commonDisplayError($Language[Notify],$Language[Accessdenied]);


$action=$VARS['action']==""?"display":$VARS['action'];
$exe="{$action}Merge";
$exe();	

$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");

//  Select available forums for merging.  Closed boards or forums are not available for selection.
function displayMerge(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	if($Member[moderator]){//forum moderators can only merge to topics within the current forum
		$VARS[newForumId]=$forumId;	
		selectMerge();			
	}
	else if(commonVerifyAdmin()){//admin or global moderators can merge current topic with other forums's topics
		$sql="select forum.forumId,forum.boardId,forum.name, board.name as boardName from {$Global_DBPrefix}Forums forum left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) where board.status!=0 and forum.status!=0 order by board.displayOrder,forum.displayOrder";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		while($dataSet = mysql_fetch_array($fetchedData)){
			$selected=$dataSet['forumId']==$Document[forumId]?"selected":"";
			$forumsListing .= "<OPTION VALUE=\"$dataSet[forumId]\" $selected>$dataSet[boardName]: $dataSet[name]</OPTION>";
		}			
		$sql="select t.topicId,t.forumId,p.subject from {$Global_DBPrefix}Topics as t, {$Global_DBPrefix}Posts as p where t.startPostId=p.postId and t.topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$dataSet[forumsListing]=$forumsListing;
		$dataSet[preForumId]=$Document[forumId];
		$Document['msg']= $Language[Choosenewforum];
		$Document['contents'] .= getPreMergeHTML($dataSet,commonGetSubmitButton(false,$Language['Continue'],$confirm));
	}						

}//displayMerge

//  Display available topics for merging based on selected forum
function selectMerge(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$sql="select t.topicId, p.subject,f.name from {$Global_DBPrefix}Topics as t, {$Global_DBPrefix}Posts as p, {$Global_DBPrefix}Forums as f where t.startPostId=p.postId and t.forumId=f.forumId and t.forumId=$newForumId order by p.subject";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$selected=$dataSet['topicId']==$VARS[topicId]?"selected":"";
		$topicsListing .= "<OPTION VALUE=\"$dataSet[topicId]\" $selected>$dataSet[subject]</OPTION>";
		$newForumName=$dataSet[name];
	}		
	$availableTopics=mysql_num_rows($fetchedData);//Pass this flag in case forum has no topics for merging
	$sql="select t.topicId,t.forumId,p.subject from {$Global_DBPrefix}Topics as t, {$Global_DBPrefix}Posts as p where t.startPostId=p.postId and t.topicId=$VARS[topicId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	
	$dataSet[topicsListing]=$topicsListing;
	$dataSet[newForumId]=$newForumId;
	$dataSet[newForumName]=$newForumName;
	$dataSet[availableTopics]=$availableTopics;
	$Document['contents'] .= getMergeFormHTML($dataSet,commonGetSubmitButton(false,$Language['Merge'],$confirm));		
}//selectMerge

//  Merge topic with new selected topic
function mergeMerge(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$sql="update {$Global_DBPrefix}Notify set topicId=$newTopicId where topicId=$topicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	//change notify's topicId	
	if($Document['topicPoll']){//move poll
		$addSql=", poll=1"; 
		$sql="update {$Global_DBPrefix}Polls set topicId=$newTopicId where topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
	}

	//Update all posts from old to new topic 
	$sql="update {$Global_DBPrefix}Posts set topicId=$newTopicId where topicId=$topicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);		

	$sql="delete from {$Global_DBPrefix}Topics where topicId=$topicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);		

	//update all posts in new topic as replies(firstpost=0)
	$sql="update {$Global_DBPrefix}Posts  set firstPost=0 where topicId=$newTopicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);

	//get oldest postid from new topic
	$sql="select min(postId) as startPostId from {$Global_DBPrefix}Posts  where topicId=$newTopicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	$startPostId=$dataSet[startPostId];

	//set oldest post as the starting post in new topic
	$sql="update {$Global_DBPrefix}Posts  set firstPost=1 where topicId=$newTopicId and postId=$startPostId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$addSql=$Document['topicPoll']?", poll=1":"";
	
	$sql="update {$Global_DBPrefix}Topics set startPostId=$startPostId $addSql where topicId=$newTopicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	

	commonResetTopics(array($newTopicId));
	commonResetForums(array($forumId,$newForumId));
	$Document['contents'] .= commonForwardTopic("$Language[Thankyou] $Language[Topicmerged].","?mode=topics&topicId=$newTopicId&nl=1",5);		
}//mergeTopic

?>