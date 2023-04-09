<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    split.php - Handle spliting of topics.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/split.php");	
$Document['forumNavigation']=commonTopicNavigation();

if(commonVerifyAdmin() || $Member[moderator])//action limited to admin & mderators only
	$Document['contents'] = commonTableHeader(true,0,200,"$Language[SplitTopic]");
else
	commonDisplayError("$Language[SplitTopic]",$Language[Accessdenied]);

$action=$VARS['action']==""?"display":$VARS['action'];
$exe="{$action}Split";
$exe();	

$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");

//  Display available forums for topic spliting.  Closed boards or forums are not available for selection.
function displaySplit(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$buttons=commonGetSubmitButton(false,$Language['Split'],$confirm);
	if(commonVerifyAdmin()){//admin & global moderators can split to other forums
		$sql="select forum.forumId,forum.boardId,forum.name, board.name as boardName from {$Global_DBPrefix}Forums forum left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) where board.status!=0 and forum.status!=0 order by board.displayOrder,forum.displayOrder";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		while($dataSet = mysql_fetch_array($fetchedData)){
			$selected=$dataSet['forumId']==$Document[forumId]?"selected":"";
			$forumsListing .= "<OPTION VALUE=\"$dataSet[forumId]\" $selected>$dataSet[boardName]: $dataSet[name]</OPTION>";
		}			
	}
	else{//forum moderator can only spit to current forum
		$forumsListing .= "<OPTION VALUE=\"$Document[forumId]\">$Document[boardName]: $Document[forumName]</OPTION>";		
	}
	$sql="select p.topicId,p.postId,p.subject,p.message,m.name from {$Global_DBPrefix}Posts as p, {$Global_DBPrefix}Members as m where m.memberId=p.memberId and p.postId=$VARS[postId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$dataSet[forumsListing]=$forumsListing;
	$dataSet[preForumId]=$Document[forumId];
	$Document['contents'] .= getSplitFormHTML($dataSet,$buttons);	
}//displaySplit

//  Split post as new topic to selected forum
function splitSplit(){
	global $Document,$Language,$VARS,$GlobalSettings,$Member,$userfile;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);			

	$subject=htmlspecialchars($subject);
	$sql="insert into {$Global_DBPrefix}Topics (forumId,startPostId,latestPostId,replies,views,sticky,locked,poll)
				values ($forumId,$postId,$postId,0,0,0,0,0)";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$sql="select max(topicId) as newTopicId from {$Global_DBPrefix}Topics where startPostId=$postId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$newTopicId=$dataSet['newTopicId'];					
	$VARS[topicId]=$newTopicId;
	$sql="update {$Global_DBPrefix}Posts set topicId=$newTopicId, subject=\"$subject\", firstPost=1 where postId=$postId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);										
					
	commonResetTopics(array($topicId));
	commonResetForums(array($forumId,$preForumId));
	$Document['contents'] .= commonForwardTopic($Language['Thankyou'],"?mode=topics&topicId=$newTopicId&nl=1",3);		
}//splitSplit

?>