<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    post.php - Process all actions related posting.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/post.php");
$Document['forumNavigation'] = getPostNavigation($VARS['forumId'],$VARS['topicId']);
$action=$VARS['action'];

if(!$Member['memberId'] && !$Document['allowGuestPosting'])//members only or guest posting, no edit or delete by guests
	commonDisplayError($Language[Posting],$Language[Accessdenied]);

$exe="{$action}Post";
$exe();	

//  Delete post
function deletePost(){ 
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$postId=$VARS[postId];
	$topicId=$VARS[topicId];
	if(commonVerifyAdmin() || $Member[moderator]) //admin and moderators can delete others' posts
		$sql="delete from {$Global_DBPrefix}Posts where postId=$postId";	
	else
		$sql="delete from {$Global_DBPrefix}Posts where postId=$postId and memberId=$Member[memberId]";	
	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	if(mysql_affected_rows()){		
		commonResetTopics(array($topicId));
		commonResetForums(array($Document[forumId]));
		commonRemoveAttachment(array($postId),false);		
	}
	$Document['contents']=displayMessageHTML("$Language[Postingremoved]",3);				
}//deletePost

//  Update post
function updatePost(){
	global $Document,$Language,$VARS,$GlobalSettings,$Member,$userfile;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);			
	
	$subject=htmlspecialchars($subject);
	$message=$disableHTML?htmlspecialchars($message):commonStripTags($message);
	$ip=commonGetIPAddress();			

	if(is_uploaded_file($userfile)) {
		$hasFile=true;
		$isError=checkFileUpload();
	}
	if(trim($subject)==""){
		$isError=true;
		$Document['errorMsg'] .= "<BR />$Language[Subject] $Language[isblank].";		
	}
	if(trim($message)==""){
		$isError=true;
		$Document['errorMsg'] .= "<BR />$Language[Message] $Language[isblank].";		
	}
	if($poll){
		if(trim($question)==""){
			$isError=true;
			$Document['errorMsg'] .= "<BR />$Language[Question] $Language[isblank]";					
		}
		if(trim($option1)=="" || trim($option2)==""){
			$isError=true;
			$Document['errorMsg'] .= "<BR />$Language[Atleast2options]";					
		}		
	}

	if($isError){
		$Document['msg'] = $Document['errorMsg'];
		editPost();
	}
	else{
		$modifiedDate=time();
		if($Document[checkSensoredWords]){
			$subject=commonSensorWords($subject,true);
			$message=commonSensorWords($message,true);
		}

		$addSQL =commonVerifyAdmin() || $Member[moderator]?"": "and memberId=$Member[memberId]";				
		$sql="update {$Global_DBPrefix}Posts set subject=\"$subject\",message=\"$message\",smileyId=$smileyId,modifiedDate=$modifiedDate, modifiedBy=$Member[memberId] where postId=$postId $addSQL";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);									
		if($poll){
			$question=htmlspecialchars($question);
			$option1=htmlspecialchars($option1);
			$option2=htmlspecialchars($option2);
			$option3=htmlspecialchars($option3);
			$option4=htmlspecialchars($option4);
			$option5=htmlspecialchars($option5);
			$option6=htmlspecialchars($option6);
			$option7=htmlspecialchars($option7);
			$option8=htmlspecialchars($option8);
			$option9=htmlspecialchars($option8);
			$option10=htmlspecialchars($option10);
			$sql="update {$Global_DBPrefix}Polls set question=\"$question\",option1=\"$option1\",option2=\"$option2\",option3=\"$option3\",option4=\"$option4\",option5=\"$option5\",option6=\"$option6\",option7=\"$option7\",option8=\"$option8\",option9=\"$option9\",option10=\"$option10\" where topicId=$topicId";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);											
		}
		if($hasFile){
			saveFileUpload($postId);
		}
		$Document['contents'] .= displayMessageHTML("$Language[Recordupdated]",2);				
	}
}//updatePost

//  Insert post
function postPost(){
	global $Document,$Language,$VARS,$GlobalSettings,$Member,$userfile;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$topicId=$topicId==""?0:$topicId;
	$firstPost=$topicId?0:1;
	$subject=htmlspecialchars($subject);
	$message=$disableHTML?htmlspecialchars($message):commonStripTags($message);
	$sticky=$stick==""?0:$sticky;
	$locked=$locked==""?0:$locked;		
	$poll=$poll==""?0:$poll;	
	$ip=commonGetIPAddress();			

	if($Document[topicLock]==1 && !(commonVerifyAdmin() || $Member[moderator]) ){
		commonDisplayError($Language['Accessdenied'] ,$Language['TopicLocked']);
	}	
	if(is_uploaded_file($userfile) && $Document['allowAttachments']) {
		$hasFile=true;
		$isError=checkFileUpload();
	}
	if(trim($subject)==""){
		$isError=true;
		$Document['errorMsg'] .= "<BR />$Language[Subject] $Language[isblank]";		
	}
	if(trim($message)==""  && $poll==0){
		$isError=true;
		$Document['errorMsg'] .= "<BR />$Language[Message] $Language[isblank]";		
	}
	if($poll){
		if(trim($question)==""){
			$isError=true;
			$Document['errorMsg'] .= "<BR />$Language[Question] $Language[isblank]";					
		}
		if(trim($option1)=="" || trim($option2)==""){
			$isError=true;
			$Document['errorMsg'] .= "<BR />$Language[Atleast2options]";					
		}		
	}	
	if($isError){
		$Document['msg'] = $Document['errorMsg'];
		$topicId?replyPost():newPost();
	}
	else{
		$postDate=time();
		if($Document[checkSensoredWords]){
			$subject=commonSensorWords($subject,true);
			$message=commonSensorWords($message,true);
		}
		if(!$Member['memberId'] && $Document['allowGuestPosting']){//guest posting
			$Member['memberId']=0;
		}
		$sql="insert into {$Global_DBPrefix}Posts (topicId,memberId,subject,message,smileyId,ip,postDate,modifiedDate,modifiedBy,firstPost)	values ($topicId,$Member[memberId],\"$subject\",\"$message\",$smileyId,\"$ip\",$postDate,$postDate,0,$firstPost)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);			
		if(mysql_affected_rows()> 0){	
			if($Member['memberId'])
				$sql="select max(postId) as postId from {$Global_DBPrefix}Posts where memberId=$Member[memberId]";
			else
				$sql="select max(postId) as postId from {$Global_DBPrefix}Posts where ip=\"$ip\"";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			$dataSet = mysql_fetch_array($fetchedData);
			$postId=$dataSet['postId'];		
			if($topicId){//reply
				notifyPost();
			}	
			else{//new post
				$sql="insert into {$Global_DBPrefix}Topics (forumId,startPostId,latestPostId,replies,views,sticky,locked,poll)
					values ($forumId,$postId,$postId,0,0,$sticky,$locked,$poll)";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);
				$sql="select max(topicId) as topicId from {$Global_DBPrefix}Topics where startPostId=$postId";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
				$dataSet = mysql_fetch_array($fetchedData);
				$topicId=$dataSet['topicId'];					
				$VARS[topicId]=$topicId;
				$sql="update {$Global_DBPrefix}Posts set topicId=$topicId where postId=$postId";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
			}		
			commonResetTopics(array($topicId));
			commonResetForums(array($forumId));
			
			if($hasFile){
				saveFileUpload($postId);
			}
			if($poll){
				$question=htmlspecialchars($question);
				$option1=htmlspecialchars($option1);
				$option2=htmlspecialchars($option2);
				$option3=htmlspecialchars($option3);
				$option4=htmlspecialchars($option4);
				$option5=htmlspecialchars($option5);
				$option6=htmlspecialchars($option6);
				$option7=htmlspecialchars($option7);
				$option8=htmlspecialchars($option8);
				$option9=htmlspecialchars($option8);
				$option10=htmlspecialchars($option10);
				$now=time();
				$sql="insert into {$Global_DBPrefix}Polls (topicId,question,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,voted1,voted2,voted3,voted4,voted5,voted6,voted7,voted8,voted9,voted10,startDate,endDate,status) values ($topicId,\"$question\",\"$option1\",\"$option2\",\"$option3\",\"$option4\",\"$option5\",\"$option6\",\"$option7\",\"$option8\",\"$option9\",\"$option10\",0,0,0,0,0,0,0,0,0,0,$now,$now,1)";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);						
			}
			if($Document['announcement'] && $firstPost)notifyAnnouncement($topicId);
			$Document['contents']=displayMessageHTML("$Language[Messageposted]",3);				
			if($Member['memberId']){
				$sql="update {$Global_DBPrefix}Members set totalPosts=totalPosts +1 where memberId=$Member[memberId]";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);						
			}
		}
		else{//insert error
			commonDisplayError($Languge['Posting'],$Language['Insertfailed']);
		}
	}
}//postPost

//  Retrieve record for editing
function editPost(){
	global $Document,$Language,$VARS,$GlobalSettings;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	
	$sql="select post.subject,post.message,post.firstPost,post.smileyId,attachment.fileType,poll.pollId,poll.question,poll.option1,poll.option2,poll.option3,poll.option4,poll.option5,poll.option6,poll.option7,poll.option8,poll.option9,poll.option10,poll.voted1,poll.voted2,poll.voted3,poll.voted4,poll.voted5,poll.voted6,poll.voted7,poll.voted8,poll.voted9,poll.voted10,poll.startDate,poll.endDate,poll.status from {$Global_DBPrefix}Posts as post left join {$Global_DBPrefix}Attachments as attachment on (attachment.postId=post.postId) left join {$Global_DBPrefix}Polls as poll on (poll.topicId=post.topicId) where post.postId=$VARS[postId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet=mysql_fetch_array($fetchedData);
	if($dataSet[pollId] && $dataSet[firstPost]){
		$pollLabel="[$Language[Poll]]";
		$VARS[poll]=1;
	}
	$VARS = array_merge($dataSet,$VARS);
	$Document['contents']=getPostFormHTML("$Language[EditPost] $pollLabel","Update");
 
}//editPost

//  Get reply form
function replyPost(){
	global $GlobalSettings,$Document,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");

	if($VARS[q]){
		$sql="select subject,message from {$Global_DBPrefix}Posts where postId=$VARS[q]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$VARS[message]=quoteHTML($dataSet[message]);
		$Document[subject]=$dataSet[subject];
	}
	$Document['contents']=getPostFormHTML("$Language[PostReply]","Post");
}//replyPost

//  Get new post form
function newPost(){
	global $Document,$Language,$VARS;

	$pollLabel=$VARS[poll]?"[$Language[Poll]]":"";
	$Document['contents']=getPostFormHTML("$Language[NewTopic] $pollLabel ","Post");
}//newPost

function deleteAttachmentPost(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	

	//query first to see if being removed by owner or moderator/admin
	$sql="select memberId,postId from {$Global_DBPrefix}Posts where postId=$VARS[postId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[memberId]==$Member[memberId])
		commonRemoveAttachment(array($VARS[postId]),false);
	else if( $Member[moderator] || commonVerifyAdmin())
		commonRemoveAttachment(array($VARS[postId]),true);
	else
		commonDisplayError($Language[Attachment],$Language[Accessdenied]);
	$Document['contents'] .= displayMessageHTML("$Language[Attachmentremoved]",3);				
}//deleteAttachmentPost

//  Get navigation, verify access and set global variables to appropriate values
function getPostNavigation($forumId,$topicId){
	global $GlobalSettings,$Language,$Document,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	
	if($topicId){
		$sql="select forum.forumId,forum.name,forum.status,forum.moderators,forum.announcement,board.name as boardName,
			board.boardId, board.accessibleGroups, board.status as boardStatus, topic.topicId,topic.locked,post.subject
			from {$Global_DBPrefix}Forums as forum 
			left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) 
			left join {$Global_DBPrefix}Topics as topic on (topic.forumId=forum.forumId) 
			left join {$Global_DBPrefix}Posts as post on (post.postId=topic.startPostId) 		
			WHERE topic.topicId=$topicId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	else{	
		$sql="select forum.forumId,forum.name,forum.moderators,forum.announcement,forum.status,board.name as boardName,board.boardId, board.accessibleGroups, board.status as boardStatus from {$Global_DBPrefix}Forums as forum left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) WHERE forum.forumId=$forumId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
	$dataSet = mysql_fetch_array($fetchedData);
	commonVerifyAccess($dataSet);		
	$Document['title']=$dataSet['name'];
	$Document['topicLock']=$dataSet['locked'];

	if(($dataSet['status']==0 || $dataSet['boardStatus']==0) && $Member['accessLevelId'] != 1){
		//closed boards/forums can be accessed from admin only
		commonDisplayError("$dataSet[name]","$Language[Board]/$Language[Forum] $Language[closed]");
	}
	if(trim($dataSet['accessibleGroups']) && !commonVerifyAdmin()){//admin, global moderators or specific group access only
		$accessibleGroups=split(" ",$dataSet['accessibleGroups']);
		if(!in_array($Member['groupId'],$accessibleGroups)){
			commonDisplayError("$dataSet[name]","$Language[Board]/$Language[Forumnotaccessible].");
		}				
	}
	if($dataSet[subject]){
		$subject= " <IMG SRC=\"images/separator.gif\" WIDTH=\"7\" HEIGHT=\"7\"> " . $dataSet['subject'];
	}
	$contents = <<<EOF
	<A HREF="$Document[mainScript]?boardId=$dataSet[boardId]">$dataSet[boardName]</A> <IMG SRC="images/separator.gif" WIDTH="7" HEIGHT="7">
	<A HREF="$Document[mainScript]?mode=forums&forumId=$dataSet[forumId]">$dataSet[name]</A> $subject
EOF;
	$Document['forumId']=$dataSet['forumId'];
	$Document['boardId']=$dataSet['boardId'];
	$Document['subject']=$dataSet['subject'];
	$Document['announcement']=$dataSet['announcement'];
	return $contents;
}//getPostNavigation

//  Notify members of post
function notifyPost(){
	global $GlobalSettings,$Language,$Document,$Member,$VARS,$HTTP_HOST;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	include_once("$Document[languagePreference]/notifyMessage.php");
	$details['url']="http://" . $HTTP_HOST . $Document[mainScript] . "?mode=topics&topicId=$topicId";
	$details[repliedBy]=$Member[name];
	$details[subject]=$Document[subject];
	$details[organization]=$Global_organization;
	
	$sql="select member.memberId,member.name,member.email,notify.notifyId from {$Global_DBPrefix}Members as member, {$Global_DBPrefix}Notify as notify where member.memberId=notify.memberId and notify.topicId=$topicId and notify.memberId!=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$dataSet[disableurl]= "http://" . $HTTP_HOST . $Document[mainScript] . "?mode=notify&i=$dataSet[notifyId]&c=$dataSet[code]";
		$dataSet=array_merge($dataSet,$details);
		commonSendEMail("$dataSet[name] <$dataSet[email]>","$Document[subject] - $Language[Notifications]",getNotifyMessage($dataSet));	
	}
}//notifyPost

//  Notify members if posting is an announcement
function notifyAnnouncement($topicId){
	global $GlobalSettings,$Language,$Document,$Member,$VARS,$HTTP_HOST;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	include_once("$Document[languagePreference]/notifyAnnouncement.php");
	$details['url']="http://" . $HTTP_HOST . $Document[mainScript] . "?mode=topics&topicId=$topicId";
	$details[postedBy]=$Member[name];
	$details[subject]=$VARS[subject];
	$details[organization]=$Global_organization;
	
	$sql="select name,email from {$Global_DBPrefix}Members where notifyAnnouncements=1 and locked=0 and memberId!=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$dataSet=array_merge($dataSet,$details);
		commonSendEMail("$dataSet[name] <$dataSet[email]>","$Language[AnnouncementNotifications]: $details[subject]",getNotifyAnnouncement($dataSet));	
	}
}//notifyAnnouncement

//  Save attachment
function saveFileUpload($postId){
	global $GlobalSettings,$Language,$userfile,$userfile_name,$userfile_size,$HTTP_POST_VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	list($fileName,$ext)=preg_split("/\./",$userfile_name);
	$ext=strtolower($ext);
	$fileSize=floor($userfile_size/1024);
	$oldExt=trim($HTTP_POST_VARS[oldExt]);
	$folder=commonGetAttachmentFolder($postId);
	$path="$Global_attachmentPath/$folder";
	if(!file_exists("$path")){
		mkdir ($path,0755);
	}
	$file="$path/$postId.$ext";					
	copy($userfile, $file);		
	if($oldExt !=""){
		if(strcmp ($oldExt, $ext)<>0){//if different extension uploaded
			if(file_exists("$path/$postId.$oldExt")){
				unlink("$path/$postId.$oldExt");
			}
		}
		$sql="update {$Global_DBPrefix}Attachments set fileSize=$fileSize,fileType=\"$ext\" where postId=$postId";
	}
	else{
		$sql="insert into {$Global_DBPrefix}Attachments (postId,fileSize,fileType,removedBy,timesDownload) values ($postId,$fileSize,\"$ext\",0,0)";
	}
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);		

}//saveFileUpload

//  Check if file uploaded is valid
//  Return boolean(true|false)
function checkFileUpload(){
	global $GlobalSettings,$Document,$Language,$HTTP_POST_VARS,$userfile,$userfile_name;
	$isError=false;
	list($fileName,$ext)=preg_split("/\./",$userfile_name);
	$ext=strtolower($ext);  
	if (in_array ($ext, $Document[disallowAttachmentTypes])){
   		$isError=true;
		$Document['errorMsg'] .= $Language['Filetypenotallowed'] . ": $userfile_name";
	}
	if ($userfile_size > $Document[attachmentSize] ) { 
		$isError=true;
		$Document['errorMsg'] .= $Language['Fileexceedssize']; 
	} 		
	return $isError;		
}//checkFileUpload

?>