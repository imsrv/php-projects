<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    messages.php - Process all actions related to messages.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

if(!$Member['memberId'] && $case !="login") commonDisplayError($Language[Messages],$Language[Accessdenied]);
$Document['contentWidth']="90%";
$Document['title']=$Language[Messages];
$action=$VARS['action']==''?"entry":$VARS['action'];
$exe="{$action}Message";

include_once("$GlobalSettings[templatesDirectory]/messages.php");

$Document['contents'] = getTopMessagesHTML();
$exe();	
$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");

//  Delete message and attachment, if any
function deleteMessage(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$sql="delete from {$Global_DBPrefix}Messages where receiverId=$Member[memberId] and messageId=$messageId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);

	$sql="select attachmentId,fileName from {$Global_DBPrefix}MessageAttachments where messageId=$messageId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[attachmentId]){
		$file=$Global_messageAttachmentPath . "/" . commonGetAttachmentFolder($messageId) . "/" . $dataSet[fileName];
		if(file_exists($file))
			unlink($file);
	}
	$Document['msg'] = "$Language[Messagedeleted].";
	entryMessage();
}//deleteMessage

//  View and mark message as read
function viewMessage(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$sql="select message.messageId,message.senderId,message.subject,message.message,message.sendTime, message.status,
		sender.memberId,sender.loginName,sender.name,attachment.attachmentId,attachment.fileName,attachment.fileSize from {$Global_DBPrefix}Messages as message 
		left join {$Global_DBPrefix}Members as sender on (sender.memberId=message.senderId) 
		left join {$Global_DBPrefix}MessageAttachments as attachment on (attachment.messageId=message.messageId)
		where message.messageId=$messageId and message.receiverId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData); 
	$dataSet[sendTime] = commonTimeFormat(false,$dataSet[sendTime]); 
	$dataSet[attachment] = isset($dataSet[attachmentId])?commonFormatMessageAttachment($dataSet):"";	
	$Document['contents'] .= getViewMessageHTML($dataSet);	
	$sql="update {$Global_DBPrefix}Messages set status=2 where messageId=$messageId and receiverId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,false);
	
}//viewMessage

//  Send message
function sendMessage(){
	global $GlobalSettings,$DOCUMENT_ROOT,$Member,$Document,$VARS,$Language,$userfile,$userfile_name,$userfile_size;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($subject)==""){
		$isError=true;
		$Document['errorMsg'] .= "$Language[Subject] $Language[isblank].";		
	}
	if(trim($message)==""){
		$isError=true;
		$Document['errorMsg'] .= "$Language[Message] $Language[isblank].";		
	}
	if(is_uploaded_file($userfile)) { //if attachment uploaded
		$fileUpload=true;
		//check if exceeds total allowable size
		$sql="select sum(a.fileSize) as totalSize from {$Global_DBPrefix}MessageAttachments a, {$Global_DBPrefix}Messages b  where a.messageId=b.messageId and  b.receiverId=$receiverId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);
		if (($userfile_size + $dataSet[totalSize]) > $Document[maxMessageAttachment] ) { 
			$isError=true;
			$Document['errorMsg'] .= $Language['MessageAttachmentOver']; 
		} 
		list($fileName,$ext)=preg_split("/\./",$userfile_name);
		$ext=strtolower($ext);  
		if (in_array ($ext, $Document[disallowAttachmentTypes])){
   			$isError=true;
			$Document['errorMsg'] .= $Language['Filetypenotallowed'] . ": $userfile_name";
		}
	}	
	if($isError){
		$Document['msg'] = $Language['Pleasetryagain'] . ": " . $Document['errorMsg'];
		if($replyMessageId)
			replyMessage($VARS);
		else
			newMessage($VARS);
	}
	else{	
		$subject=htmlspecialchars($subject);
		$message=$disableHTML?htmlspecialchars($message):commonStripTags($message);
		$sendTime=time();
		$sql="insert into {$Global_DBPrefix}Messages (senderId,receiverId,subject,message,sendTime,status) values
			($Member[memberId],$receiverId,\"$subject\",\"$message\",$sendTime,1)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$sql="select max(messageId) as messageId from {$Global_DBPrefix}Messages where senderId=$Member[memberId]";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			if($fileUpload){
				$fileName=commonRandomString($Member[memberId],10) . "." . $ext;
				$folder=$GlobalSettings['messageAttachmentPath'] . "/" . commonGetAttachmentFolder($messageId);
				if(!file_exists($folder)){
					mkdir($folder,0754);
					//copy blank index file to disable directory listing
					copy("$Global_templatesDirectory/index.html","$folder/index.html");
				}
				copy($userfile,"$folder/$fileName");
				$fileSize=$userfile_size/1024;
				$sql="insert into {$Global_DBPrefix}MessageAttachments (messageId,fileName,fileSize,status) values ($dataSet[messageId],\"$fileName\",$fileSize,1)";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);			
			}
			if($replyMessageId){
				$sql="update {$Global_DBPrefix}Messages set status=3 where messageId=$replyMessageId and receiverId=$Member[memberId]";
				$fetchedData=mysql_query($sql) or commonLogError($sql,false);
			}
			$Document['msg'] = "Message sent to <A HREF=\"$Document[mainScript]?mode=profile&loginName=$loginName\">$name</A>";
			entryMessage($VARS);
		
		}
		else{
			commonDisplayError($Languge['Messaging'],$Language['Insertfailed']);
		}
	}
}//sendMessage

//  Reply message
function replyMessage(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$buttons = commonGetSubmitButton(false,$Language['Send'],$confirm);
	
	$sql="select member.memberId,member.name,member.loginName,message.messageId,message.sendTime,message.subject,message.message from {$Global_DBPrefix}Members member, {$Global_DBPrefix}Messages message where member.memberId=message.senderId and message.messageId=$VARS[messageId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$memberDetails = mysql_fetch_array($fetchedData);
	$memberDetails[replyMessageId]=$VARS[messageId];

	$passes=0;
	$oldMessage = split("\n",$memberDetails[message]);
	foreach ($oldMessage as $line){// include the original message, not exceeding 3 replies
	 	if(ereg("----- $Language[OriginalMessage] -----",$line))$passes++;
		if($passes>3){reset($oldMessage);}
		else{$trimmedContents .= $line;}
	}
	$memberDetails[message]=$trimmedContents;

	$sql="select count(*) as total from {$Global_DBPrefix}Messages where receiverId=$memberDetails[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	
	if($dataSet[total] < $Document['maxMemberMessages']){		
		$Document['contents'].=getMessageFormHTML($memberDetails,$buttons);
	}
	else{
		$Document['contents'].=commonEndMessage(false,"$memberDetails[name]'s $Language[Messageboxisfull].");	
	}
}//replyMessage

//  Get new message form
function newMessage(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$buttons = commonGetSubmitButton(false,$Language['Send'],$confirm);
	
	$sql="select memberId,name,loginName from {$Global_DBPrefix}Members where loginName=\"$VARS[loginName]\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$memberDetails = mysql_fetch_array($fetchedData);

	$sql="select count(*) as total from {$Global_DBPrefix}Messages where receiverId=$memberDetails[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	
	if($dataSet[total] < $Document['maxMemberMessages']){
		$Document['contents'].=getMessageFormHTML($memberDetails,$buttons);
	}
	else{
		$Document['contents'].=commonEndMessage(false,"$memberDetails[name]'s $Language[Messageboxisfull].");	
	}
}//newMessage

//  List messages
function entryMessage(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$Document['contents'] .= getSearchBoxHTML();	
	$Document['contents'] .= commonTableFormatHTML("header",$Document['contentWidth'],"");
	$Document['contents'] .= getTitleMessagesHTML();

	$page=$page==""?1:$page;

	$fromPostNumber=($page -1)* $Document['listingsPerPage'];
	$addSQL = trim($searchText)!=""?" and (message.subject like \"%$searchText%\" or sender.name like \"%$searchText%\") ":"";

	$sql="select message.messageId,message.senderId,message.subject,message.sendTime,message.status,sender.name,sender.loginName,sender.memberId,attachment.attachmentId
			from {$Global_DBPrefix}Messages as message
			left join {$Global_DBPrefix}Members as sender on (sender.memberId=message.senderId)
			left join {$Global_DBPrefix}MessageAttachments as attachment on (attachment.messageId=message.messageId) where message.receiverId=$Member[memberId] $addSQL order by message.messageId desc limit $fromPostNumber,$Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$dataSet[sendTime]=commonTimeFormat(true,$dataSet[sendTime]);
		$dataSet[attachment]=$dataSet[attachmentId]?commonGetIconImage("attachmentsgrey",$Language[attachment]):"";
		$Document['contents'] .= getMessageRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0){
		$Document['contents'] .= commonEndMessage(6,"<BR /><BR />$Language[Youhavenomessages]<BR /><BR />");
	}
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=messages&page=$page&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document['contentWidth'],$previous,$next);

}//entryMessage

?>