<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    boards.php - Process all actions related to boards.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$Document['quickLogin']=$Member['memberId']?$Document['quickLogin']:commonQuickLoginPanel($Document[SpamGuardImage]);
$action=$VARS['action']==''?"entry":$VARS['action'];
$exe="{$action}Boards";

$exe($boardId);

//  list all boards or single board based on given board Id
//  Parameter:  BoardId(integer|blank)
function entryBoards($boardId){	
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	include_once("$Global_templatesDirectory/boards.php");
	$display=true;		
	$Document['contents'] = commonTableHeader(false,6,0,getTopBoardHTML());
	$Document['contents'] .= getForumLabelsHTML();

	if($Member['memberId']){
		extract($Member,EXTR_PREFIX_ALL,"Member");
		$viewedLog=getViewedForumsLog();
	}
	
	$addSql = $Member[accessLevelId]==1?"":" where forum.status=1 and board.status=1 "; //closed forums and boards are visible by admin only
	if($boardId)
		$addSql .= trim($addSql)==""?" where board.boardId=$boardId ":" and board.boardId=$boardId ";

	$sql ="select distinct board.boardId, board.name as boardName, board.accessibleGroups, board.description,board.status as boardStatus,forum.forumId,forum.name as forumName, forum.topics, forum.posts, forum.latestPostId,forum.announcement,forum.status as forumStatus,post.topicId,post.subject,post.postDate, member.name as latestMemberName,member.loginName as latestMemberLoginName
				from {$Global_DBPrefix}Boards as board
				left join {$Global_DBPrefix}Forums as forum on (board.boardId=forum.boardId)
				left join {$Global_DBPrefix}Posts as post on (post.postId=forum.latestPostId)
				left join {$Global_DBPrefix}Members as member on (member.memberId=post.memberId)
				$addSql order by board.displayOrder, forum.displayOrder";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$accessibleGroups=trim($dataSet['accessibleGroups']);
		if($accessibleGroups){
			if(!commonVerifyAdmin()){// if board is group specific and not administrator/global moderator
				$accessibleGroups=split(" ",$dataSet['accessibleGroups']);
				$display=in_array($Member_groupId,$accessibleGroups)?true:false; // set display mode for that specific board
			}
			$dataSet[groupNames]=getGroupNames($dataSet['accessibleGroups']);
		}		
			
		if($display){	
			if($dataSet['boardId'] !=$lastBoardId){	
				$Document['contents'] .= getBoardRowHTML($dataSet);
				if($boardId == $dataSet['boardId'])
					$Document['title'] = $dataSet['boardName'];					

			}
			if($dataSet['forumId']){
				if(isset($dataSet[postDate])){
					$dataSet[latestPostDate] = commonTimeFormat(true,$dataSet[postDate]);									
					$dataSet[latestMemberName] = $dataSet[latestMemberName]==""?$Language['Guest']:$dataSet[latestMemberName];
					$dataSet[latestMemberName] = "- $dataSet[latestMemberName]";
				}
				else{
					$dataSet[postDate]=0;					
				}	
				//check viewed log
				if($Member['memberId']){									
					$dataSet[forumRead]=$viewedLog[$dataSet[forumId]] >= $dataSet[postDate]?"off":"on";
				}
				else{
					$dataSet[forumRead]="off";
				}
				$dataSet[announcement]=$dataSet[announcement]?commonGetIconImage("announcement",$Language['Announcementforum']):"";
				$Document['contents'] .= getForumRowHTML($dataSet);
			}
		}
		$lastBoardId=$dataSet['boardId'];
		$display=true;
	}
	$Document['contents'] .= commonTableFooter(false,6,getBottomBoardHTML());
}//entryBoards

//  Mark all or specific board as read 
//  Parameter: BoardId(integer|null)
function markreadBoards($boardId){
	global $GlobalSettings,$Member,$Document;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$forums=array();

	$addSql=$boardId>0?" where boardId=$boardId":"";
	$sql="select forumId from {$Global_DBPrefix}Forums $addSql order by forumId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		array_push($forums,$dataSet[forumId]);
	}
	foreach($forums as $forumId){
		commonLogViewedForum($forumId);
	}
	entryBoards($boardId);
}//markreadBoards
 
//  Get viewed forum Ids & time
//  Return: Array
function getViewedForumsLog(){
	global $GlobalSettings,$Member,$Document;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$viewedLog=array();
	$sql="select forumId,logTime from {$Global_DBPrefix}ViewedForums where memberId=$Member[memberId] order by forumId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,false);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$viewedLog[$dataSet[forumId]] = $dataSet[logTime];
	}
	return $viewedLog;	
}//getViewedForumsLog

//  Get group names
//  Parameter: GroupIds (string)
//  Return: String
function getGroupNames($groupNames){
	global $GlobalSettings,$Member,$Document;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$groupNames=str_replace(" ", ",",$groupNames);
	$names=array();
	$sql="select name from {$Global_DBPrefix}Groups where groupId in ($groupNames)";
	$fetchedData=mysql_query($sql) or commonLogError($sql,false);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		array_push ($names,$dataSet[name]);
	}
	return implode(", ", $names);		
}//getGroupNames
?>