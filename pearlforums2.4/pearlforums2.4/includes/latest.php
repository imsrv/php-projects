<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    latest.php - List latest postings.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$Document['title']="$Language[LatestPosts]";	
latestPosts();

//  Display latest posts
function latestPosts(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	include_once("$Global_templatesDirectory/latest.php");
	$Document['contents'] = commonTableHeader(false,0,300,"$Language[LatestPosts]");
	
	//get postings
	$sql ="select post.memberId,post.topicId,post.postId,post.subject,post.message,post.ip,post.firstPost,post.postDate,post.modifiedDate,topic.poll,topic.locked,attachment.attachmentId,attachment.fileSize,attachment.fileType,attachment.timesDownload,member.name,member.loginName,avatar.fileName as avatar,avatar.avatarId,smiley.fileName as smiley,online.hitTime as online,
				forum.forumId, forum.name as forumName,forum.moderators,forum.status,board.boardId, board.name as boardName,board.accessibleGroups, board.status as boardStatus
				from {$Global_DBPrefix}Posts as post
				left join {$Global_DBPrefix}Topics as topic on (topic.topicId=post.topicId) 		
				left join {$Global_DBPrefix}Forums as forum on (forum.forumId=topic.forumId) 
				left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) 
				left join {$Global_DBPrefix}Members as member on (member.memberId=post.memberId)
				left join {$Global_DBPrefix}Attachments as attachment on (attachment.postId=post.postId)
				left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId)
				left join {$Global_DBPrefix}Smileys as smiley on (smiley.smileyId=post.smileyId)
				left join {$Global_DBPrefix}Online as online on (online.memberId=post.memberId)
				order by post.postId desc limit 10";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$display=true;
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		//closed boards/forums can be accessed from admin only
		if(($dataSet['status']==0 || $dataSet['boardStatus']==0) && $Member[accessLevelId]!=1){			
			$display=false;
		}
		
		//Admin, global moderators or specific group access only
		if(trim($dataSet['accessibleGroups']) && $Member[accessLevelId]>2){
			$accessibleGroups=split(" ",$dataSet['accessibleGroups']);
			if(!in_array($Member['groupId'],$accessibleGroups)){
				$display=false;
			}				
		}
		if($display){				
			$dataSet['postDate'] = commonTimeFormat(false,$dataSet['postDate']);
			if($Member[memberId]){
				//Build controll buttons
				if(commonVerifyAdmin() || $Member[moderator] || $dataSet['memberId']==$Member['memberId']){
					$dataSet['postControls'] = commonLanguageButton("edit","$Language[Edit]","?mode=post&action=edit&topicId=$dataSet[topicId]&postId=$dataSet[postId]","");	
					$dataSet['postControls'] .= " &nbsp; " . commonLanguageButton("quote","$Language[Quote]","?mode=post&action=reply&topicId=$dataSet[topicId]&forumId=$dataSet[forumId]&q=$dataSet[postId]","");	
				}		
				else{
					if($dataSet[locked]==0)
						$dataSet['postControls'] .= " &nbsp; " . commonLanguageButton("quote","$Language[Quote]","?mode=post&action=reply&topicId=$dataSet[topicId]&forumId=$dataSet[forumId]&q=$dataSet[postId]","");						
				}
				$dataSet['messageButton'] = "<BR/>" . commonGetIconButton("sendmessage",$Language['Sendmessage'],"?mode=messages&action=new&loginName=$dataSet[loginName]","") . "<BR/>";	
			}
			else if($Document['allowGuestPosting'] && $dataSet[locked]==0){
				$dataSet['postControls'] = commonLanguageButton("quote","$Language[Quote]","?mode=post&action=reply&topicId=$dataSet[topicId]&forumId=$dataSet[forumId]&q=$dataSet[postId]","");				
			}

			if(isset($dataSet[attachmentId])){
				$dataSet[attachment] = commonFormatAttachment($dataSet);
			}
			if($dataSet[poll] && $dataSet[firstPost]){
				include_once("$Global_templatesDirectory/poll.php");
				$dataSet[poll]=getPollDisplayHTML($dataSet[topicId]);
			}else{$dataSet[poll]="";}

			$dataSet['fsubject']=ereg_replace("^Re:", "", $dataSet['subject']);							
			$dataSet[online]=$dataSet[online]?1:0;
			$Document['contents'] .= getPostingRowHTML($dataSet);			
		}
		$display=true;
	}
	$Document['contents'] .= commonTableFooter(false,0,commonQuickSearch());
	
}//latestPosts
 
?>