<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    forums.php - Process all actions related to 
//                  forums.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////
	
$Document['forumNavigation'] = getForumNavigation($VARS['forumId']);
$action=$VARS['action']==""?"display":$VARS['action'];

$exe="{$action}Forum";
$exe();	
	
//  Display forum's topics listing 
function displayForum(){	
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	include_once("$Global_templatesDirectory/forums.php");

	$topics=array();
	$savedData=array();
	$forumId=$VARS['forumId'];
	
	//build paging

	$Document[TotalPages]=$pages = ceil(($Document['topics'])/$Document['listingsPerPage']);
	$page=$VARS['page']=="x"?$pages:$VARS['page'];
	$start=$page=$page==""?1:$page;

	if($pages>$Document['MaxPagingLinks']){
		$span=$pages - $Document['MaxPagingLinks'];
		$median=floor($Document['MaxPagingLinks']/2);
		$start=$page > $span?$span:$page;
		$start=$start>($page - $median)?($page - $median):$start;
		$start=$start<1?1:$start;
		$maxLoops=$start + $Document['MaxPagingLinks'];
	}
	else{
		$start=1;
		$maxLoops = $pages;
	}
	
	for($p=$start;$p<=$maxLoops;$p++){
		$Document['pageList'] .=$p==$page?"[$p]&nbsp;":" <A HREF=\"$Document[mainScript]?mode=forums&forumId=$forumId&page=$p\">$p</A>&nbsp;";		
	}
	
	if(commonVerifyAdmin() || $Member[moderator]){// Only admin or moderators can start polls
		$newTopicButtons = commonLanguageButton("newpoll","$Language[NewPoll]","?mode=post&action=new&poll=1&forumId=$Document[forumId]","") . $Document['spacer'];
		$newTopicButtons .= commonLanguageButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$Document[forumId]","");		
	}
	else if($Member['memberId'] || $Document['allowGuestPosting']){//regular users cannot start a new topic in forums mark for Announcements only
		$newTopicButtons = $Document[announcement]?"":commonLanguageButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$Document[forumId]","");	
	}

	$Document['contents'] = commonTableHeader(false,6,0,getTopForumNavigationHTML($newTopicButtons,$Document['pageList']));
	if(trim($Document['showForumInfo'])){//this option can be changed in admin settings
		if(count($Document[moderators]) && $Document[showModerators]){
			$Document['moderatorsList']="$Language[Moderatedby]:";
			$addSql = "'" . implode("','",$Document['moderators']) . "'";
			$sql="select name,loginName from {$Global_DBPrefix}Members where loginName in ($addSql)";
			$fetchedData=mysql_query($sql) or commonLogError($sql,false);	
			while($dataSet = mysql_fetch_array($fetchedData)){
				$Document['moderatorsList'] .= " <A HREF=\"$Document[mainScript]?mode=profile&loginName=$dataSet[loginName]\">$dataSet[name]</A>,";
			}
			$Document['moderatorsList'] = substr($Document['moderatorsList'], 0, strlen($Document['moderatorsList'])-1) . "<BR>";
			$hasInfo=true;
		}
		if(trim($Document['forumDescription']))
			$hasInfo=true;
		if($hasInfo)
			$Document['contents'] .= getDescriptionHTML();
	}	
	$Document['contents'] .= getTopicLabelsHTML();

	$fromPostNumber=($page -1)* $Document['listingsPerPage'];		
	$sql ="select distinct startPost.subject,startPost.postDate,latestPost.postDate as latestPostDate,topic.topicId,topic.replies,topic.views,topic.sticky,topic.poll,topic.locked,
			startMember.name as startMemberName,startMember.loginName as startMemberLoginName,
			latestMember.name as latestMemberName,latestMember.loginName as latestMemberLoginName,smileys.fileName
			from {$Global_DBPrefix}Topics as topic
			left join {$Global_DBPrefix}Posts as startPost on (startPost.postId=topic.startPostId)
			left join {$Global_DBPrefix}Posts as latestPost on (latestPost.postId=topic.latestPostId)
			left join {$Global_DBPrefix}Members as startMember on (startMember.memberId=startPost.memberId)
			left join {$Global_DBPrefix}Members as latestMember on (latestMember.memberId=latestPost.memberId)
			left join {$Global_DBPrefix}Smileys as smileys on (smileys.smileyId=startPost.smileyId)
			where topic.forumId=$forumId  order by topic.sticky desc,topic.latestPostId desc limit $fromPostNumber,$Document[listingsPerPage]";

	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	

	while($dataSet = mysql_fetch_array($fetchedData))
	{
		array_push($savedData,$dataSet);	//accummulate all data for later processing
		array_push($topics,$dataSet[topicId]);		
	}
	
	if($Member['memberId'] && count($topics)){ //get viewed log for current page's topics
		$viewedLog=getViewedTopicsLog($forumId,$topics);
	}
	foreach($savedData as $dataSet){
		if($dataSet['replies']){
			$latestTime=commonTimeFormat(true,$dataSet[latestPostDate]);
			$dataSet['latestDetails']=$dataSet[latestMemberName]==""?"<NOBR>$latestTime</NOBR> - $Language[Guest]":"<NOBR>$latestTime</NOBR> - <NOBR><A HREF=\"$Document[mainScript]?mode=profile&loginName=$dataSet[latestMemberLoginName]\">$dataSet[latestMemberName]</A></NOBR>";
		}		
		else{
			$postTime=commonTimeFormat(true,$dataSet[postDate]);
			$dataSet['latestDetails']="<NOBR>$postTime</NOBR>";
		}
		$dataSet['startedBy']=$dataSet[startMemberName]?"<A HREF=\"$Document[mainScript]?mode=profile&loginName=$dataSet[startMemberLoginName]\">$dataSet[startMemberName]</A>":$Language['Guest'];
		
		$dataSet['sticky']=$dataSet['sticky']?commonGetIconImage("sticky","$Language[StickyTopic]"):"";
		$dataSet['locked']=$dataSet['locked']?commonGetIconImage("topiclocked","$Language[TopicLocked]"):"";

		$dataSet[fileName]=$dataSet[poll]?"poll.gif":$dataSet[fileName];
		$dataSet[unread]=$viewedLog[$dataSet[topicId]] < $dataSet[latestPostDate] && $Member['memberId']?"<IMG SRC=images/new.gif>":"";
		$Document['contents'] .= getTopicRowHTML($dataSet);	
	}
	if(count($topics)==0){
		$Document[msg] = $VARS[page]?$Language[Endoflisting]:$Language[Norecordsfound];
		$Document['contents'] .= commonEndMessage(6,$Document[msg]);
	}
	$Document['contents'] .= commonTableFooter(false,6,getBottomForumNavigationHTML());
		
	if($Member['memberId']){
		commonLogViewedForum($forumId);		
	}
}//displayForum
 
//  Get topics' last viewed time from log
//  Parameter: ForumId(integer), TopicIds(integer array)
//  Return: Integer array(topicId and viewed time)
function getViewedTopicsLog($forumId,$topics){
	global $GlobalSettings,$Member,$Document;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	

	$topicsList = implode(", ",$topics);
	$viewedLog=array();
	$sql="select topicId,logTime from {$Global_DBPrefix}ViewedTopics where memberId=$Member[memberId] and topicId in ($topicsList)";
	$fetchedData=mysql_query($sql) or commonLogError($sql,false);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$viewedLog[$dataSet[topicId]] = $dataSet[logTime];
	}	
	return $viewedLog;	
}//getViewedTopicsLog

//  Mark forum as read
function markreadForum(){
	global $GlobalSettings,$Member,$Document,$VARS;	
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$topics=array();
	$page=$VARS['page']==""?1:$VARS['page'];
	$forumId=$VARS['forumId'];

	$fromPostNumber=($page -1)* $Document['listingsPerPage'];	

	$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$forumId order by latestPostId desc limit $fromPostNumber,$Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		array_push($topics,$dataSet[topicId]);
	}	
	foreach($topics as $topicId){
		commonLogViewedTopic($topicId);
	}
	displayForum();
	
}//markTopicsRead

//  Get navigation and set global variables to appropriate values
function getForumNavigation($forumId){
	global $GlobalSettings,$Language,$Document,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select forum.forumId,forum.name,forum.description,forum.topics,forum.moderators,forum.announcement,forum.status,board.name as boardName,board.boardId, board.accessibleGroups, board.status as boardStatus from {$Global_DBPrefix}Forums as forum left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) WHERE forum.forumId=$forumId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$Document['title']=$dataSet['name'];
	commonVerifyAccess($dataSet);
	$announcement=$dataSet[announcement]?commonGetIconImage("announcement",$Language['Announcementforum']):"";
	$contents = <<<EOF
	<A HREF="$Document[mainScript]?boardId=$dataSet[boardId]">$dataSet[boardName]</A> <IMG SRC="images/separator.gif" WIDTH="7" HEIGHT="7">
	$dataSet[name]$announcement
EOF;
	$Document['forumId']=$dataSet['forumId'];
	$Document['forumDescription']=$dataSet['description'];
	$Document['boardId']=$dataSet['boardId'];
	$Document['topics']=$dataSet['topics'];
	$Document['announcement']=$dataSet['announcement'];

	return $contents;
}//getForumNavigation

?>