<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    topics.php - Process all actions related to topics.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/topics.php");	
$Document['forumNavigation']=commonTopicNavigation();
$action=$VARS['action']==""?"display":$VARS['action'];

$exe="{$action}Topic";
$exe();	

//  Display topic at the correct page number based on specified topicId & postId (href from Latest Posts and Search results)
function forwardTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	
	$index=1;
	$sql="select postId from {$Global_DBPrefix}Posts where topicId=$topicId order by postId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		if($postId==$dataSet[postId])
			break;			
		$index++;
	}
	if($index)
		$VARS[page]=ceil($index/$Document[postingsPerPage]);
	displayTopic();
}//forwardTopic

//  Display next topic based on given current topicId
function nextTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$VARS[forumId] and topicId < $VARS[topicId] order by topicId desc limit 1";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[topicId]){//if next topic Id is found
		$nextTopicId=$dataSet[topicId];		
	}
	else{//else get first topic in forum
		$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$VARS[forumId] order by topicId desc limit 1";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);	
		$nextTopicId = $dataSet[topicId];		
	}
	if($nextTopicId){
		$VARS[topicId]=$nextTopicId;
		$Document['forumNavigation']=commonTopicNavigation();
		displayTopic();
	}
	else{//forum has no topic, move to forum listing of all topics.  Common in case of deleting the only topic in forum	
		forwardForumHTML(1);
	}
}//nextTopic

//  Display previous topic based on given current topicId
function previousTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$VARS[forumId] and topicId > $VARS[topicId] limit 1";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[topicId]){//previous topic found
		$previousTopicId=$dataSet[topicId];		
	}
	else{//find last topic in forum
		$sql="select topicId from {$Global_DBPrefix}Topics where forumId=$VARS[forumId] order by topicId limit 1";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);	
		$previousTopicId=$dataSet[topicId];		
	}
	if($previousTopicId){
		$VARS[topicId]=$previousTopicId;
		$Document['forumNavigation']=commonTopicNavigation();
		displayTopic();
	}
	else{//forum has no topic, move to next forum.  Common in case of deleting the only topic in forum	
		forwardForumHTML(1);
	}	
}

//  Lock topic.  Reply button will be available to admin & moderators only
function lockTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	if(commonVerifyAdmin() || $Member[moderator]){ //action reserved for moderators or admins only
		$sql="update {$Global_DBPrefix}Topics set locked=1 where topicId=$VARS[topicId]";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	$Document['contents'] = commonTableHeader(true,0,0,"&nbsp;");	
	$Document['contents'] .= commonForwardTopic("$Language[TopicLocked]","?mode=topics&topicId=$VARS[topicId]&nl=1",3);
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");
}//lockTopic

//  Unlock topic for replies
function unlockTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	if(commonVerifyAdmin() || $Member[moderator]){//action reserved for moderators or admins only
		$sql="update {$Global_DBPrefix}Topics set locked=0 where topicId=$VARS[topicId]";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	$Document['contents'] = commonTableHeader(true,0,0,"&nbsp;");	
	$Document['contents'] .= commonForwardTopic("$Language[TopicUnlocked]","?mode=topics&topicId=$VARS[topicId]&nl=1",3);
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");
}//unlockTopic

//  Make topic sticky, always on top of listing
function stickyTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	if(commonVerifyAdmin() || $Member[moderator]){//action reserved for moderators or admins only
		$sql="update {$Global_DBPrefix}Topics set sticky=1 where topicId=$VARS[topicId]";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	$Document['contents'] = commonTableHeader(true,0,0,"&nbsp;");	
	$Document['contents'] .= commonForwardTopic("$Language[Thankyou]","?mode=topics&topicId=$VARS[topicId]&nl=1",3);
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");	
}//stickyTopic

//  Remove sticky from topic.  
function unstickyTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	if(commonVerifyAdmin() || $Member[moderator]){//action reserved for moderators or admins only
		$sql="update {$Global_DBPrefix}Topics set sticky=0 where topicId=$VARS[topicId]";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	$Document['contents'] = commonTableHeader(true,0,0,"&nbsp;");	
	$Document['contents'] .= commonForwardTopic("$Language[Thankyou]","?mode=topics&topicId=$VARS[topicId]&nl=1",3);
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");	
}//unstickyTopic

//  Delete topic and related posts, attachments, polls
function deleteTopic(){ 
	global $GlobalSettings,$Language,$Member,$Document,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$affectedPosts=array();
	$topicId=$VARS[topicId];
	if(commonVerifyAdmin() || $Member[moderator] || ($Member[memberId]==$Document[topicOwnerId] && $Document[topicReplies]==0)){			
		$sql="select post.postId from {$Global_DBPrefix}Posts as post, {$Global_DBPrefix}Attachments as attachment where post.topicId=$topicId and post.postId=attachment.postId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		while($dataSet = mysql_fetch_array($fetchedData))
		{
			array_push($affectedPosts,$dataSet[postId]);				
		}							

		$sql="delete from {$Global_DBPrefix}Posts where topicId=$topicId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$sql="delete from {$Global_DBPrefix}Topics where topicId=$topicId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		if(count($affectedPosts)){
			commonRemoveAttachment($affectedPosts,false);
		}
		if($Document['topicPoll']){
			commonDeletePoll($topicId);
		}
		
		commonResetForums(array($Document[forumId]));	
		nextTopic();
	}	
	else{
		$Document[contents] = commonDisplayError($Language['Topic'],$Language[Accessdenied]);
	}			
}//deleteTopic

//  Display posts in topic	
function displayTopic(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$display=false;		
	$topicId=$VARS['topicId'];
	if($Member['memberId'])
		extract($Member,EXTR_PREFIX_ALL,"Member");
	
	//build paging
	$Document[TotalPages]=$pages = ceil(($Document['topicReplies'] +1)/$Document['postingsPerPage']);
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
	$Document['pageList']=$start>1 && $pages > $Document[MaxPagingLinks]?"<A HREF=\"$Document[mainScript]?mode=topics&topicId=$topicId&page=1\">&laquo;$Language[First]</A>&nbsp;":"";
	for($p=$start;$p<=$maxLoops;$p++){
		$Document['pageList'] .=$p==$page?"[$p]&nbsp;":" <A HREF=\"$Document[mainScript]?mode=topics&topicId=$topicId&page=$p\">$p</A>&nbsp;";		
	}
	$Document['pageList'] .= $pages>$maxLoops?"<A HREF=\"$Document[mainScript]?mode=topics&topicId=$topicId&page=x\">$Language[Last]&raquo;</A>":"";	
	
	$topicButtons  = commonLanguageButton("print","$Language[Print]","?mode=topics&action=print&topicId=$topicId","").  $Document['spacer'];	

	if($Member['memberId']){
		//topic control buttons		
		if(commonVerifyAdmin()){ //administrators or global moderators have full control		
			$topicButtons  .= commonLanguageButton("notify","$Language[Notify]","?mode=notify&action=display&topicId=$topicId&forumId=$Document[forumId]","").  $Document['spacer'];	
			$replyButton  = commonLanguageButton("reply","$Language[Reply]","?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]","").  $Document['spacer'];	

			$topicControls = $Document['topicSticky']?commonLanguageButton("unsticky","$Language[UnstickyTopic]","?mode=topics&action=unsticky&topicId=$topicId","") . $Document['spacer']:commonLanguageButton("sticky","$Language[StickyTopic]","?mode=topics&action=sticky&topicId=$topicId","") . $Document['spacer'];	
			$topicControls .= $Document['topicLock']?commonLanguageButton("unlock","$Language[UnlockTopic]","?mode=topics&action=unlock&topicId=$topicId",""). $Document['spacer']:commonLanguageButton("lock","$Language[LockTopic]","?mode=topics&action=lock&topicId=$topicId","") . $Document['spacer'];	
			$topicControls .= commonLanguageButton("move","$Language[Move] $Language[Topic]","?mode=move&topicId=$topicId&forumId=$Document[forumId]","") . $Document['spacer'];
			$topicControls .= $pollId?"":commonLanguageButton("merge","$Language[Merge] $Language[Topic]","?mode=merge&topicId=$topicId&forumId=$Document[forumId]","") . $Document['spacer'];
			$topicControls .= commonLanguageButton("delete","$Language[Delete] $Language[Topic]","?mode=topics&action=delete&topicId=$topicId&forumId=$Document[forumId]",commonDeleteConfirmation("$Language[Topicdeleteconfirm]"));	
			$newTopicButtons = commonLanguageButton("newpoll","$Language[NewPoll]","?mode=post&action=new&poll=1&forumId=$Document[forumId]","") . $Document['spacer'];
			$newTopicButtons .= commonLanguageButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$Document[forumId]","") . $Document['spacer'];
		}
		else if($Member['moderator']){ //forum moderators, with most of controls except Moving topic to another forum
			$topicButtons  .= commonLanguageButton("notify","$Language[Notify]","?mode=notify&action=display&topicId=$topicId&forumId=$Document[forumId]","").  $Document['spacer'];	
			$replyButton  = commonLanguageButton("reply","$Language[Reply]","?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]","").  $Document['spacer'];	

			$topicControls = $Document['topicSticky']?commonLanguageButton("unsticky","$Language[UnstickyTopic]","?mode=topics&action=unsticky&topicId=$topicId","") . $Document['spacer']:commonLanguageButton("sticky","$Language[StickyTopic]","?mode=topics&action=sticky&topicId=$topicId","") . $Document['spacer'];	
			$topicControls .= $Document['topicLock']?commonLanguageButton("unlock","$Language[UnlockTopic]","?mode=topics&action=unlock&topicId=$topicId",""). $Document['spacer']:commonLanguageButton("lock","$Language[LockTopic]","?mode=topics&action=lock&topicId=$topicId","") . $Document['spacer'];	
			$topicControls .= $pollId?"":commonLanguageButton("merge","$Language[Merge] $Language[Topic]","?mode=merge&topicId=$topicId&forumId=$Document[forumId]","") . $Document['spacer'];
			$topicControls .= commonLanguageButton("delete","$Language[Delete] $Language[Topic]","?mode=topics&action=delete&topicId=$topicId&forumId=$Document[forumId]",commonDeleteConfirmation("$Language[Topicdeleteconfirm]"));	
			$newTopicButtons = commonLanguageButton("newpoll","$Language[NewPoll]","?mode=post&action=new&poll=1&forumId=$Document[forumId]","") . $Document['spacer'];
			$newTopicButtons .= commonLanguageButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$Document[forumId]","") . $Document['spacer'];

		}
		else{ // regular members, based on particular settings, might have: notify,reply and new topic buttons
			$topicButtons .= $Document['allowNotify']?commonLanguageButton("notify","$Language[Notify]","?mode=notify&action=display&topicId=$topicId&forumId=$Document[forumId]","") .  $Document['spacer']:"";	
			$replyButton = $Document['topicLock']==1?"":commonLanguageButton("reply","$Language[Reply]","?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]","") . $Document['spacer'];			
			$newTopicButtons =$Document[announcement]?"":commonLanguageButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$Document[forumId]","") . $Document['spacer'];	
		}	
		$newTopicButtons .= $replyButton;
		$topicButtons .= $replyButton;
	}
	else if($Document[allowGuestPosting]){
		$newTopicButtons = $Document[announcement]?"":commonLanguageButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$Document[forumId]","") . $Document['spacer'];	
		$newTopicButtons .= $Document['topicLock']==1?"":commonLanguageButton("reply","$Language[Reply]","?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]","") . $Document['spacer'];
		$topicButtons .= $Document['topicLock']==1?"":commonLanguageButton("reply","$Language[Reply]","?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]","") . $Document['spacer'];
	}
	$Document['contents'] = commonTableHeader(false,0,0,getTopTopicNavigationHTML($topicButtons,$Document['pageList']));
	$Document['contents'] .= getTopicTitleRowHTML($topicControls);
	
	//get details of each posting
	$fromPostNumber=($page -1)* $Document['postingsPerPage'];
	$sql ="select post.memberId,post.topicId,post.postId,post.subject,post.message,post.ip,post.firstPost,post.postDate,post.modifiedDate,post.modifiedBy,attachment.attachmentId,attachment.fileSize,attachment.fileType,attachment.removedBy,attachment.timesDownload,member.name,member.accessLevelId,member.loginName,member.ip as memberIp,online.hitTime as online,avatar.fileName as avatar,avatar.avatarId,smiley.fileName as smiley,modifier.name as modifierName,modifier.loginName as modifierLoginName
				from {$Global_DBPrefix}Posts as post
				left join {$Global_DBPrefix}Members as member on (member.memberId=post.memberId)
				left join {$Global_DBPrefix}Members as modifier on (modifier.memberId=post.modifiedBy)
				left join {$Global_DBPrefix}Attachments as attachment on (attachment.postId=post.postId)
				left join {$Global_DBPrefix}Online as online on (online.memberId=member.memberId)
				left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId)
				left join {$Global_DBPrefix}Smileys as smiley on (smiley.smileyId=post.smileyId)
				where post.topicId=$topicId order by post.postId limit $fromPostNumber,$Document[postingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);

	while($dataSet = mysql_fetch_array($fetchedData))
	{
		if($Document['topicPoll'] && $dataSet[firstPost]){//display poll if has one
			include_once("$Global_templatesDirectory/poll.php");
			$dataSet[poll]=getPollDisplayHTML($topicId);
		}else{$dataSet[poll]="";}
		
		$dataSet[accessLevelId]=in_array($dataSet[loginName],$Document['moderators'])?3:$dataSet[accessLevelId];
		$dataSet[adminPosition]= $dataSet[accessLevelId]<4?"<BR/><SPAN CLASS=GreyText>". $Language['MemberPositions'][$dataSet[accessLevelId]] . "</SPAN>":"";
		if($Member['memberId']){
			if(commonVerifyAdmin() || $Member[moderator]){//admins & moderators have full control in each posting
				$dataSet['postControls'] = $dataSet[firstPost]? "":commonLanguageButton("split","$Language[Split]","?mode=split&topicId=$topicId&postId=$dataSet[postId]","");			
				$dataSet['postControls'] .= $dataSet[firstPost]? $Document['spacer'] . commonLanguageButton("deletepost","$Language[Delete] $Language[Topic]","?mode=topics&action=delete&topicId=$topicId&forumId=$Document[forumId]",commonDeleteConfirmation($Language[Topicdeleteconfirm])): $Document['spacer'] . commonLanguageButton("deletepost","$Language[Delete]","?mode=post&action=delete&topicId=$topicId&postId=$dataSet[postId]&page=$page","");
				$dataSet['postControls'] .= $Document['spacer'] . commonLanguageButton("edit","$Language[Edit]","?mode=post&action=edit&topicId=$topicId&postId=$dataSet[postId]&page=$page","") . $Document['spacer'];	
				$dataSet['deleteAttachment'] = true;
				$dataSet['postControls'] .=  commonLanguageButton("quote",$Language['Quote'],"?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]&q=$dataSet[postId]","");	
			}		
			else if($dataSet['memberId']==$Member['memberId']){ //owner's control buttons in each posting
				$dataSet['postControls'] = $dataSet[firstPost] && $Document[topicReplies]?"":commonLanguageButton("deletepost","$Language[Delete]","?mode=post&action=delete&topicId=$topicId&postId=$dataSet[postId]&page=$page","");
				$dataSet['postControls'] .=  $Document['spacer'] . commonLanguageButton("edit","$Language[Edit]","?mode=post&action=edit&topicId=$topicId&postId=$dataSet[postId]&page=$page","") . $Document['spacer'];	
				if($Document['topicLock']==0)
					$dataSet['postControls'] .=  commonLanguageButton("quote",$Language['Quote'],"?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]&q=$dataSet[postId]","");	

				$dataSet['deleteAttachment'] = true;
			}					
			$dataSet['messageButton'] = "<BR/><BR/>" .  commonGetIconButton("sendmessage",$Language['Sendmessage'],"?mode=messages&action=new&loginName=$dataSet[loginName]","");	
		}
		else if($Document['allowGuestPosting'])
			$dataSet['postControls'] .=  commonLanguageButton("quote",$Language['Quote'],"?mode=post&action=reply&topicId=$topicId&forumId=$Document[forumId]&q=$dataSet[postId]","");	
		
		if(isset($dataSet[attachmentId])){
			$dataSet[attachment] = commonFormatAttachment($dataSet);
		}
		$dataSet[online]=$dataSet[online]?1:0;
		$Document['contents'] .= getPostingRowHTML($dataSet);					
	}
	if(mysql_num_rows($fetchedData)==0 && $page>1){
		$Document['contents'] .= getForwardHTML($topicId);
	}
	else{
		if(($Member['memberId'] || $Document['allowGuestPosting']) && !$Document['topicLock'])
			$Document['contents'] .= getQuickReplyHTML();
	} 
	
	$Document['contents'] .= commonTableFooter(false,0,getBottomTopicNavigationHTML($newTopicButtons));
	
	if(!$VARS['nl'])logTopicCount($topicId);
	if($Member['memberId']){
		commonLogViewedTopic($topicId);
		if($VARS[page]=="x")
			commonLogViewedForum($Document['forumId']);
	}

}//displayTopic
 
//  Log topic count
function logTopicCount(){
	global $GlobalSettings,$Language,$Document,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="update {$Global_DBPrefix}Topics set views=views+1 WHERE topicId=$VARS[topicId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
}//logTopicCount

//  Display topic in printer friendly format
function printTopic(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	include_once("$Global_templatesDirectory/topics.php");	
	$Document['width']=600;
	$Document['contents'] .= commonTableFormatHTML("header","100%","CENTER");

	$sql ="select post.memberId,post.topicId,post.postId,post.subject,post.message,post.ip,post.firstPost,post.postDate,post.modifiedDate, member.name,poll.pollId
			from {$Global_DBPrefix}Posts as post
			left join {$Global_DBPrefix}Members as member on (member.memberId=post.memberId)
			left join {$Global_DBPrefix}Polls as poll on (poll.topicId=post.topicId)			
			where post.topicId=$VARS[topicId] order by post.postId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);

	while($dataSet = mysql_fetch_array($fetchedData))
	{
		if($dataSet['pollId'] && $dataSet[firstPost]){
			include_once("$Global_templatesDirectory/poll.php");
			$dataSet[poll]=getPollDisplayHTML($VARS[topicId]);
		}else{$dataSet[poll]="";}

		$dataSet['postDate'] = commonTimeFormat(false,$dataSet['postDate']);
		$Member['name']=$Document['previousNextNavigation']=$Document['navigation']=$Document['footerLinks']=$Member[adminPosition]="";
		$Document['contents'] .= printHTML($dataSet);
	}
	$Document['contents'] .= commonTableFormatHTML("footer","","");
}//printTopic
?>