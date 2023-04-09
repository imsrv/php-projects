<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    functions.php -  Contain all common functions that are 
//                  being called more than one instance to avoid duplicates  
//                  and maintain consistencies.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////


//  Get avatars listing.  Only common avatars and that of the user will be displayed
//  Parameters:  MemberId(integer), CurrentChosenAvatar(integer)
//  Return: String(avatars' listing options)
function commonAvatarsListing($memberId,$chosen){
	global $GlobalSettings,$Language,$Document;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select avatarId,name,fileName from {$Global_DBPrefix}Avatars where memberId=$memberId or memberId=0 order by memberId desc,name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		$selected=$dataSet['avatarId']==$chosen?"selected":"";
		$contents .= "<OPTION VALUE=\"$dataSet[avatarId]\" $selected>$dataSet[name]</OPTION>";
		$avatarFiles .= "\"$dataSet[fileName]\",";
	}
	$Document[sampleAvatars]=substr($avatarFiles, 0, strlen($avatarFiles)-1);
	return $contents;
}//commonAvatarsListing

// Remove expired entries
function commonClearSpamGuard(){
	global $GlobalSettings,$Member,$Document,$VARS,$_REQUEST;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	
	$currentTime = time();
	$validTime = $currentTime - 900; //15mins expired

	$sql="select sessionId from {$Global_DBPrefix}SpamGuard where accessTime < $validTime";
	$fetchedData=mysql_query($sql);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$guardFile=$GlobalSettings[SpamGuardFolder]. "/" . substr($dataSet[sessionId],10,10);
		if(file_exists($guardFile))
			unlink($guardFile);	
	}	
	if(mysql_num_rows($fetchedData)){
		$sql="delete from {$Global_DBPrefix}SpamGuard where accessTime < $validTime";
		$fetchedData=mysql_query($sql);
	}

}//commonClearSpamGuard

//  Format a popup dialogue for confirmation on delete actions
//  Parameter: ConfirmationText(string)
//  Return: String(onclick attribute)
function commonDeleteConfirmation($confirm){
	 return "onclick=\"if (confirm('$confirm')) return true; else return false;\"";
}//commonDeleteConfirmation

//  Delete poll and its votes 
//  Parameter: TopicId(integer)
function commonDeletePoll($topicId){
	global $GlobalSettings,$Language,$Member,$Document,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$affectedVotes=array();
	$sql="select pollId from {$Global_DBPrefix}Polls where topicId=$topicId";	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[pollId]){
		$sql="delete from {$Global_DBPrefix}PollVotes where pollId=$dataSet[pollId]";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$sql="delete from {$Global_DBPrefix}Polls where topicId=$topicId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
}//commonDeletePoll

//  Display error message and exit program all together
//  Parameter: Title(string), Message(string)
//  Return: String(Error message)
function commonDisplayError($title,$message){
	global $GlobalSettings,$Document;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$Document['contents'] = commonTableHeader(true,0,300,$title);
	$Document['contents'] .= <<<EOF
		<TABLE ALIGN="CENTER">
		<TR>
			<TD CLASS="Error">
				<BR />$message <BR /><BR />		
			</TD>
		</TR>
		</TABLE>
EOF;
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");		
	include_once("{$Global_templatesDirectory}/master.php");
	exit;
}//commonDisplayError

//  Encrypt password, using md5
//  Parameter: Password(string)
//  Return: encrypted password
function commonEncryptPassword($password){	
	$newPassword= md5($password); //or use your own 
	return $newPassword;
}//funcEncryptPassword

//  Format end messages in listings, confirmation after actions etc.
//  Parameter: HasColumnSpans?(integer), Message(string)
//  Return: String(formatted message)
function commonEndMessage($colspan,$message){
	global $Document,$GlobalSettings,$Language;
	if($colspan){
		$contents = <<<EOF
		<TR>
			<TD COLSPAN="$colspan" CLASS="TDStyle"> <BR /><BR />
				$message
				 <BR /><BR />
			</TD>
		</TR>	
EOF;
	}
	else{
		$contents = <<<EOF
		<TABLE ALIGN="CENTER">
		<TR>
			<TD CLASS="TDPlain"> <BR />
				$message
				 <BR />
			</TD>
		</TR>	
		</TABLE>
EOF;
	}
	return $contents;
}//commonEndMessage

//  Get template's footer links, add help page if member logged in
//  Return: String(footer links)
function commonFooterLinks(){
	global $Member,$Language,$Document;
	$spacer="&nbsp; &nbsp;";
	$buttons  = commonLanguageButton("latestposts",$Language[LatestPosts],"?mode=latest","") . $spacer;
	$buttons .= commonLanguageButton("currentlyonline",$Language[CurrentlyOnline],"?mode=members&case=online","") . $spacer;
	$buttons .= commonLanguageButton("memberslisting","$Language[MembersListing]","?mode=members","") . $spacer;
	$buttons .= commonLanguageButton("setlocaltime",$Language[Setlocaltime],"?mode=locale","") . $spacer;
	$buttons .= commonLanguageButton("advancedsearch",$Language[AdvancedSearch],"?mode=search&case=advanced","") . $spacer;
	if($Member['memberId'])
		$buttons .= commonLanguageButton("help",$Language[Help],"?mode=help","");
	
	$contents = <<<EOF
	<TABLE WIDTH="$Document[width]" ALIGN="CENTER">
	<TR>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$buttons			
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;		
}//commonFooterLinks

//  Format contents for display
//  Parameter: Contents(string)
//  Return: String(formatted contents)
function commonFormatContents($contents){
	global $GlobalSettings,$Language,$Document,$VARS;
//	$contents = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", "<a href=\"\\0\">\\0</a>", $contents);	//auto format links
	return nl2br($contents);
}//commonFormatContents

//  Format attachment for downloads, for use in messaging, add display tags for known file types
//  Parameter: MultipleValues(string array)
//  Return: String(formatted attachment in HTML)
function commonFormatMessageAttachment($attachment){
	global $GlobalSettings,$Language;
	$file= "download.php?case=m&id=$attachment[messageId]&aid=$attachment[attachmentId]&f=$attachment[fileName]";
	$image= "displayImage.php?case=m&id=$attachment[messageId]&aid=$attachment[attachmentId]&f=$attachment[fileName]";
	list($fileName,$ext)=preg_split("/\./",$attachment[fileName]);
	$fileType=strtoupper($ext);

	$content = <<<EOF
	<BR /><BR />
	<TABLE CLASS="TableStyle" WIDTH="100%">
	<TR>
		<TD>
		<STRONG><U>$Language[Attachment]</U></STRONG>: $attachment[fileSize]KB - $fileType 
		<A HREF="$file"><IMG SRC="images/attachments.gif" BORDER="0" ALT="$Language[Download]" /></A>
		</TD>
	</TR>
	</TABLE>
EOF;
	
	switch ($ext){
		case "jpg":
		case "gif":
				$content .= "<BR /><IMG SRC=\"$image\" />";
				break;
	}
	return $content;
}//commonFormatMessageAttachment

//  Format attachment for downloads, add display tags for known file types
//  Parameter: MultipleValues(string array)
//  Return: String(formatted attachment in HTML)
function commonFormatAttachment($attachment){
	global $GlobalSettings,$Language,$Document,$VARS;
	$file= "download.php?case=r&id=$attachment[postId]&aid=$attachment[attachmentId]&t=$attachment[fileType]";
	$image= "displayImage.php?case=r&id=$attachment[postId]&aid=$attachment[attachmentId]&t=$attachment[fileType]";
	$fileType=strtoupper($attachment[fileType]);
	if($attachment[removedBy]){
		$attachment[deleteAttachment]="";
		$download="[$Language[Attachmentremovedbyadmin]]";
	}
	else{
		if($attachment[deleteAttachment]){
			$attachment[deleteAttachment]=commonLanguageButton("deleteattachment","$Language[Delete] $Language[Attachment]","?mode=post&action=deleteAttachment&topicId=$attachment[topicId]&postId=$attachment[postId]&page=$VARS[page]","");
		}
		$download="<A HREF=\"$file\"><IMG SRC=\"$Document[languagePreference]/images/downloadattachment.gif\" BORDER=\"0\" ALT=\"$Language[Download]\"></A>";

		switch ($attachment[fileType]){
			case "jpg":
			case "gif":
			case "png":
				$attachmentView = "<BR /><IMG SRC=\"$image\" />";
				break;
		}	
	}
	$attachment[timesDownload]=$attachment[timesDownload]==''?0:$attachment[timesDownload];

	$content = <<<EOF
	<BR /><BR />
	<TABLE CLASS="TableStyle" WIDTH="100%">
	<TR>
		<TD CLASS="TDStyle">			
			<STRONG>$fileType - $attachment[fileSize]KB ($Language[Downloaded] $attachment[timesDownload] $Language[times])</STRONG>
		</TD>
		<TD CLASS="TDStyle">			
			$download		
		</TD>				
		<TD CLASS="TDStyle">			
			$attachment[deleteAttachment]			
		</TD>
	</TR>
	</TABLE>
	$attachmentView
EOF;
	return $content;
}//commonFormatAttachment


//  Format HTML Forward to desinated topic
//  Parameters: Message(string), URL(string), AutoRedirectTime(integer)
//  Return:  String(forward HTML)
function commonForwardTopic($msg,$url,$redirectTime){
	Global $Document;
	$redirectTime=$redirectTime * 1000;
	$url=$Document[mainScript] . $url;
	$contents= <<<EOF
	<TABLE>
	<TR>
		<TD ALIGN="CENTER" CLASS="TDStyle"><BR /><BR /><BR />		
		<script language='javascript'>
			setTimeout("forward()",$redirectTime);
			function forward(){
				location = '$url';
			}
		</script>		
		$msg
		<BR /><BR /><BR />
		<A HREF="$url">$Document[topicSubject]</A>
		<BR /><BR /><BR />
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//commonForwardTopic

//  Get attachment folder
//  Parameter: PostID(integer)
//  Return: Integer(folder number)
function commonGetAttachmentFolder($postId){
	return floor($postId/1000);
}//commonGetAttachmentFolder

//  Get IP Address, or hostname if possible
//  Return: String(ip/hostname)
function commonGetIPAddress(){
	$ip = getenv('REMOTE_HOST')?getenv('REMOTE_HOST'): getenv('REMOTE_ADDR');
	if($ip)
		$ip = @GetHostByAddr($ip);	
	return $ip;
}//commonGetIPAddress

//  Get SpamGuard
//  Parameters: session id, type id (1=registration, 2=login)
//  Return: file name(string)
function commonGetSpamGuard($sessionId,$typeId){
	global $GlobalSettings,$Member,$Document,$VARS,$_REQUEST;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);	
	
	$sessionId= $_REQUEST["PHPSESSID"];
	if($sessionId==""){
		session_start();
		$sessionId = session_id();
	}

	$code=strtoupper(commonRandomString("",7));//no prefix, 7 random chars
	$fileName=substr($sessionId,10,10);
	$accessTime=time();
	$sql="replace into {$Global_DBPrefix}SpamGuard (SessionId,Code,AccessTime,TypeId) values ('$sessionId','$code',$accessTime,$typeId)";
	$fetchedData=mysql_query($sql);
	
	$securtiyPlate=imageCreateFromGIF("images/securityplate.gif");
	imagestring ($securtiyPlate, 4, 9, 1,"$code", 0);
	$codeFile="$Global_SpamGuardFolder/$fileName";
	imagejpeg($securtiyPlate,$codeFile,60);

	return $fileName;
}

//  Format image link button, language dependent
//  Parameter: FileName(string), MouseoverAltText(string), Link(string), DeleteConfirmation(string)
//  Return: String(linked image)
function commonLanguageButton($image,$alt,$action,$confirmation){
	global $Document;
	if($Document[graphicButtons])
		return "<A HREF=\"$Document[mainScript]$action\" $confirmation><IMG SRC=\"$Document[languagePreference]/images/$image.gif\" ALT=\"$alt\" HEIGHT=\"15\" BORDER=\"0\"></A>";
	else
		return "<A HREF=\"$Document[mainScript]$action\" $confirmation>$alt</A>";
}//commonLanguageButton

//  Format icon link button in images folder
//  Parameter: FileName(string), MouseOverAltText(string), Link(string), DeleteConfirmation(string)
//  Return: String(image link)
function commonGetIconButton($image,$alt,$action,$confirmation){
	global $Document;
	if($Document[graphicButtons])
		return "<A HREF=\"$Document[mainScript]$action\" $confirmation><IMG SRC=\"images/$image.gif\" ALT=\"$alt\" BORDER=\"0\"></A>";
	else
		return "<A HREF=\"$Document[mainScript]$action\" $confirmation>$alt</A>";			
}//commonGetIconButton

//  Format icon image in images folder
//  Parameter: ImageName(string), MouseoverTitle(string)
//  Return: String(icon image)
function commonGetIconImage($image,$title){
	global $Document;
	if($Document[graphicButtons])
		return "<IMG SRC=\"images/$image.gif\" TITLE=\"$title\" BORDER=\"0\">";
	else
		return $title;
}//commonGetIconImage

//  Get member details
//  Parameter: LoginName(string)
//  Return: String array(member details)
function commonGetMemberDetails($loginName){
	global $GlobalSettings,$Document,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	
	$sql="select memberId,groupId,accessLevelId,name,loginName,email,locked from {$Global_DBPrefix}Members where loginName=\"$loginName\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$dataSet[adminPosition]= $dataSet[accessLevelId]<4?"[" . $Language['MemberPositions'][$dataSet[accessLevelId]] . "]":"";
	return $dataSet;
}//funcGetMemberDetails

//  Format submit button
//  Parameter: Action(string), DisplayValue(string), ConfirmationOnDelete(string)
//  Return: String(submit button)
function commonGetSubmitButton($action,$value,$confirm){
	$name=$action?"NAME=\"action\"":"";
	return "<INPUT TYPE=\"SUBMIT\" $name VALUE=\"$value\" CLASS=\"SubmitButtons\">";
}//commonGetSubmitButton

//  Log SQL error, with action line and other possible parameters
//  Parameter: SqlLine(string), Exit(boolean)
function commonLogError($errorSql,$exit){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;			
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$errorMsg=htmlspecialchars(mysql_error());
	$time=time();
	$scriptName=$Document['scriptName'] . "?mode=$VARS[mode]&action=$VARS[action]&case=$VARS[case]";
	$errorSql=htmlspecialchars($errorSql);
	$sql="insert into {$Global_DBPrefix}ErrorLogs (MemberId,ScriptName,Sql,ErrorMessage,LogTime) values ($Member[memberId],\"$scriptName\",\"$errorSql\",\"$errorMsg\",$time)";
	$fetchedData=mysql_query($sql);	
	if($exit)
		commonDisplayError($Language['SqlError'],$Language[SqlErrorMessage]);
		
}//commonLogError

//  Log member's login time, ip details
function commonLogMemberDetails(){
	global $GlobalSettings,$Member,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$ip = getenv('REMOTE_ADDR');
	$now=time();
	$sql="update {$Global_DBPrefix}Members set ip=\"$ip\", lastLogin=$now where memberId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
}//commonLogMemberDetails()

//  Register viewer online/remove offlines
function commonLogOnline(){
	global $Document,$Member,$GlobalSettings,$VARS;	
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");

	$mode=$VARS[mode];
	$memberId=$Member[memberId]?$Member[memberId]:str_replace(".","0",getenv('REMOTE_ADDR'));
	$now=time();
	$interval=600; //10 minutes	

	if($mode=="login"){
		$ip=str_replace(".","0",getenv('REMOTE_ADDR'));
		$sql="update {$Global_DBPrefix}Online set memberId=$memberId,hitTime=$now where memberId=$ip";
	}
	else if($mode=="logout"){
		$sql="delete from {$Global_DBPrefix}Online where memberId=$memberId";
	}	
	else{
		$sql="replace into {$Global_DBPrefix}Online (MemberId,HitTime)	values ($memberId,$now)";
	}
	$fetchedData=mysql_query($sql);					

	$sql="delete from {$Global_DBPrefix}Online where hitTime + $interval < $now";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);			

}//commonLogOnline

//  Log forum as viewed
//  Parameter: ForumId(integer)
function commonLogViewedForum($forumId){
	global $GlobalSettings,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$time=time();
	$sql="update {$Global_DBPrefix}ViewedForums set logTime=$time where forumId=$forumId and memberId=$Member[memberId]";	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	if(mysql_affected_rows()==0){
		$sql="insert into {$Global_DBPrefix}ViewedForums (memberId,forumId,logTime) values ($Member[memberId],$forumId,$time)";			
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
}//commonLogViewForum

//  Log topic as viewed
//  Paramemter: TopicId(integer)
function commonLogViewedTopic($topicId){
	global $GlobalSettings,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$time=time();

	$sql="update {$Global_DBPrefix}ViewedTopics set logTime=$time where topicId=$topicId and memberId=$Member[memberId]";	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	if(mysql_affected_rows()==0){
		$sql="insert into {$Global_DBPrefix}ViewedTopics (memberId,topicId,logTime) values ($Member[memberId],$topicId,$time)";			
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
}//commonLogViewedTopic


//  Set top navigation for logged in members, additional links if administrator
function commonMemberNavigation(){
	global $Document,$Member,$Language;		
	$space="&nbsp;&nbsp;";		
	$Document['navigation']="";
	if($Member['accessLevelId']==1)
		$Document['navigation'] = commonLanguageButton("admin",$Language['AdministratorAccess'],"?mode=admin","") . $space;	
	$Document['navigation'] .= commonLanguageButton("home",$Language['Home'],"","") . $space;
	$Document['navigation'] .= commonLanguageButton("profile",$Language['Profile'],"?mode=profile&action=edit","") . $space;
	$Document['navigation'] .= commonLanguageButton("messages",$Language['Messages'],"?mode=messages","") . $space;
	$Document['navigation'] .= commonLanguageButton("addressbook",$Language['AddressBook'],"?mode=addressbook","") . $space;
	if($Document['allowNotify'])
		$Document['navigation'] .= commonLanguageButton("notifications","$Language[Notifications] $Language[List]","?mode=notify","") . $space;
	$Document['navigation'] .= commonLanguageButton("logout",$Language['Logout'],"?mode=logout","");
}//funcMemberNavigation

//  Get previous/next links
//  Parameter: TableWidth(integer), PreviousLink(string), NextLink(string)
//  Return: String(previous/next links) 
function commonPreviousNext($width,$previous,$next){
	global $Document,$Language;
	$width=$width==0?$Document[contentWidth]:$width;
	$previous=$previous==""?"<A HREF=\"javascript:history.back()\">$Language[previous]</A>":$previous;
	$contents= <<<EOF
	<TABLE WIDTH="$width" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0">
	<TR>
		<TD CLASS="TDStyle">
			<SPAN CLASS="GreyText">&laquo;</SPAN>$previous
		</TD>
		<TD CLASS="TDStyle" ALIGN="RIGHT">
			$next<SPAN CLASS="GreyText">&raquo;</SPAN>
		</TD>
	</TR>
	</TABLE><BR />
EOF;
	return $contents;
}//commonPreviousNext

//  Set top navigation for guests
function commonPublicNavigation(){
	global $GlobalSettings,$Document,$Member,$Language;			
	
	$space="&nbsp;&nbsp;";
	$Document['navigation'] = commonLanguageButton("home",$Language['Home'],"","") . $space;
	$Document['navigation'] .= commonLanguageButton("register",$Language['Register'],"?mode=register","") . $space;
	$Document['navigation'] .= commonLanguageButton("login",$Language['Login'],"?mode=login","");

}//commonPublicNavigation	

//  Get quick search box
//  Return: String(quick search box)
function commonQuickSearch(){
	global $Document,$Language,$HTTP_GET_VARS;
	$contents = <<<EOF
	<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0"><FORM ACTION="$Document[mainScript]" METHOD="GET"><INPUT TYPE="HIDDEN" NAME="mode" VALUE="search"><INPUT TYPE="HIDDEN" NAME="action" VALUE="search"><INPUT TYPE="HIDDEN" NAME="case" VALUE="quick"><TR><TD>
	$Language[Keywords]:<INPUT TYPE="TEXT" NAME="searchText" VALUE="$HTTP_GET_VARS[searchText]" SIZE="12" /><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="BigGoButton" TITLE="$Language[Search]" /></TD></TR></FORM></TABLE>
EOF;
	return $contents;
}//commonQuickSearch

		
//  Generate random string
//  Parameter: Prefix(String), Length(integer)
//  Return: String
function commonRandomString($prefix,$length){
	return $prefix . substr(md5(time()),0,$length);
}//commonRandomString

//  Remove file attachments in postings.  Leave record as is in Attachment table if attachment is removed by administrator and keep admin id for reference/disputes etc.
//  Parameter: PostIDs(Array[integer]), ByAdministrator?(true|false)
function commonRemoveAttachment($posts,$byAdmin){
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$posts=array_unique($posts);
	
	foreach($posts as $postId){
		$sql="select attachmentId,postId,fileType from {$Global_DBPrefix}Attachments where postId=$postId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		if(mysql_num_rows($fetchedData)){
			$file=$Global_attachmentPath . "/" .commonGetAttachmentFolder($postId) . "/$postId.$dataSet[fileType]";
			if(file_exists($file))
				unlink("$file");
			
			if($byAdmin)
				$sql="update {$Global_DBPrefix}Attachments set removedBy=$Member[memberId] where postId=$postId";				
			else
				$sql="delete from {$Global_DBPrefix}Attachments where postId=$postId";				
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		}			
	}
}//commonRemoveAttachment

//  Update topics with latest post counts
//  Parameter: TopicIDs(Array[integer])
function commonResetTopics($topics){
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$topics=array_unique($topics);
	
	foreach($topics as $topicId){		
		$sql="select max(postId) as postId from {$Global_DBPrefix}Posts  where topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$postId=$dataSet[postId];

		$sql="select count(*) as totalPosts from {$Global_DBPrefix}Posts where topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$totalPosts=$dataSet[totalPosts];
		
		$addsql .= $postId?", latestPostId=$postId ":"";
		$totalPosts=$totalPosts?$totalPosts:1;
		$sql="update {$Global_DBPrefix}Topics set replies=$totalPosts-1 $addsql where topicId=$topicId";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	}
}//commonResetTopics

//  Update forums with latest topic/posts counts
//  Parameter: ForumIDs(Array[integer])
function commonResetForums($forums){
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$forums=array_unique($forums);
	foreach($forums as $forumId){
		$sql="select max(p.postId) as postId from {$Global_DBPrefix}Posts p, {$Global_DBPrefix}Topics t where p.topicId=t.topicId and t.forumId=$forumId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$postId=$dataSet[postId]?$dataSet[postId]:0;

		$sql="select count(*) as totalTopics from {$Global_DBPrefix}Topics where forumId=$forumId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$totalTopics=$dataSet[totalTopics];

		$sql="select count(*) as totalPosts from {$Global_DBPrefix}Posts p, {$Global_DBPrefix}Topics t  where t.forumId=$forumId and p.topicId=t.topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$totalPosts=$dataSet[totalPosts];

		$sql="update {$Global_DBPrefix}Forums set latestPostId=$postId, posts=$totalPosts, topics=$totalTopics where forumId=$forumId";								
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$postId=0;
		$totalTopics=0;
		$totalPosts=0;
	}
}//commonResetForums


//  Get quick login panel with login/password box and default session duration
//  Parameter: spamguard image(string)
//  Return: string(simple login panel)
function commonQuickLoginPanel($image){
	global $Member,$Document,$Language,$HTTP_COOKIE_VARS,$VARS;
	
	if(trim($image)){
		$spamGuard=<<<EOF
<TR>
	<TD CLASS="TDPlain">		
		$Language[Verify]:	
	</TD>
	<TD>
		<IMG SRC="fetchimage.php?$image" VSPACE="0">		
	</TD>
	<TD>
		<INPUT TYPE=TEXT SIZE="10" CLASS="InputForms" NAME="code" VALUE="$code">
	</TD>
</TR>
EOF;
	}			
	$HTTP_COOKIE_VARS[loginName]=$HTTP_COOKIE_VARS[loginName]==""?$VARS[loginName]:$HTTP_COOKIE_VARS[loginName];
	$contents=<<<EOF
	<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0"><FORM NAME="login" ACTION="$Document[mainScript]" METHOD="POST">
	$spamGuard
	<TR>
		<TD CLASS="TDPlain"><INPUT TYPE="HIDDEN" NAME="mode" VALUE="login"><INPUT TYPE="HIDDEN" NAME="case" VALUE="login" /><INPUT TYPE="HIDDEN" NAME="sessionDuration" VALUE="$Document[sessionDuration]" /><INPUT TYPE="HIDDEN" NAME="forumId" VALUE="$VARS[forumId]" /><INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$VARS[topicId]" /><INPUT TYPE="HIDDEN" NAME="page" VALUE="$VARS[page]" />		
			$Language[Login]:
		</TD>
		<TD>
		<INPUT TYPE="TEXT" NAME="loginName" VALUE="$HTTP_COOKIE_VARS[loginName]" SIZE="10" CLASS="InputForms" />
		</TD>
		<TD>
		<INPUT TYPE="PASSWORD" NAME="passwd" VALUE="$VARS[passwd]" SIZE="10" CLASS="InputForms" /><INPUT TYPE="SUBMIT" VALUE="$Language[Login]" CLASS="GoButton" />
		</TD>
	</TR>
	</FORM>
	</TABLE>				
EOF;
		return $contents;
}//commonQuickLoginPanel

//  Send email in html format.
//  Parameter: ReceiverEmail(string),Subject(string),Message(string)
//  Return: SendStatus(true|false)
function commonSendEMail($receiver,$subject,$message){
	global $GlobalSettings,$Language;
	
	$header = <<<EOF
Content-type:text/html
From: $GlobalSettings[WebmasterEmail]
Errors-to: $GlobalSettings[WebmasterEmail]
EOF;
	return mail($receiver,$subject,$message,$header);

}//commonSendEMail

//  Replace sensored words or check if word is sensored
//  Parameter: String(unsensored text)
//  Return: String(sensored text|true|false)
function commonSensorWords($message,$replace){
	global $GlobalSettings,$Language,$Document;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$badwords=$substitutes=array();

	$sql="select word,substitute,wholeWord from {$Global_DBPrefix}SensoredWords order by word";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		if($replace){
			$message = ($dataSet['wholeWord'])?preg_replace("/\b$dataSet[word]\b/i", $dataSet[substitute], $message):preg_replace("/$dataSet[word]/i", $dataSet[substitute], $message);
		}	
		else if(preg_match("/$dataSet[word]/i",$message))
			return 1;			
	}
	return $replace?$message:0;	
}//commonSensorWords

//  Strip unknown/forbidden html tags.  Allowable html tags can be modified in admin settings
//  Parameter: String(contents)
//  Return: String(stripped tags)
function commonStripTags($message){
	global $Document;
	$message=strip_tags($message,$Document[allowableTags]);
	return preg_replace('/<(.*?)>/ie', "'<'.removeTagAttributes('\\1').'>'", $message);
}//commonStripTags

//  Strip unknown/forbidden html tag attributes.  Allowable attributes can be modified in admin settings
//  Parameter: String(tags to be stripped off attributes)
//  Return: String(stripped tags)
function removeTagAttributes($tag)
{
    Global $Document;
	return stripslashes(preg_replace("/$Document[badAttributes]/i", 'ignored', $tag));
}//removeTagAttributes

//  Get available smileys as select options' list
//  Parameter: integer[id of current value]
//  Return: string(select options)
function commonSmileyListing($chosen){
	global $GlobalSettings,$Language,$Document;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select smileyId,name,fileName from {$Global_DBPrefix}Smileys order by name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		$selected=$dataSet['smileyId']==$chosen?"selected":"";
		$listing .= "<OPTION VALUE=\"$dataSet[smileyId]\" $selected>$dataSet[name]</OPTION>";
		$smileyFiles .= "\"$dataSet[fileName]\",";
	}
	$Document[sampleSmileys]=substr($smileyFiles, 0, strlen($smileyFiles)-1);
	return $listing;
}//commonSmileyListing

//  Format openning|closing table tags.
//  Parameters: Type(header|footer), width(integer), alignment(center|...)
//  Return: string(open|close table tags)
function commonTableFormatHTML($type,$width,$align){ 
	$WIDTH = $width?"WIDTH=\"$width\"":"";
	$ALIGN = $align!=""?"ALIGN=\"$align\"":"";
	if($type=="header"){
		$contents = <<<EOF
<TABLE CLASS="OuterTableStyle" $WIDTH $ALIGN CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR>
	<TD>
		<TABLE CLASS="OuterTableStyle" WIDTH="100%" CELLSPACING="1" CELLPADDING="5" BORDER="0">

EOF;
	}
	else if($type=="footer"){
		$contents = <<<EOF
		</TABLE>
	</TD>
</TR>
</TABLE>
EOF;
	}
	return $contents;
}//funcCommonTableFormat

//  Format table header
//  Parameters: OpenTDTag(true|false), ColumnSpan(integer), InnerWhiteBoxWidth(integer), HeaderData(string)
//  Return: String(openning talbe tags)
function commonTableHeader($openTD,$colspan,$whiteBoxWidth,$headerData){
	global $Document;
	$colspan=$colspan?" COLSPAN=\"$colspan\"":"";
	if($openTD){
		$openTD=<<<EOF
			<TR>
				<TD CLASS="TDStyle" ALIGN="CENTER"$colspan>	
EOF;
	}
	if($whiteBoxWidth){
		$headerData = <<<EOF
				<TABLE CLASS="OuterTableStyle" WIDTH="$whiteBoxWidth" CELLSPACING="1" CELLPADDING="5" BORDER="0">
				<TR>
					<TD CLASS="TDStyle" ALIGN="CENTER">
						$headerData
					</TD>
				</TR>
				</TABLE>
EOF;
	}
	
	$contents = <<<EOF
	<TABLE CLASS="OuterTableStyle" Width="100%" ALIGN="CENTER" CELLSPACING="0" CELLPADDING="0" BORDER="0">
	<TR>
		<TD>
			<TABLE CLASS="OuterTableStyle" WIDTH="100%" CELLSPACING="1" CELLPADDING="5" BORDER="0">	
			<TR>
				<TD CLASS="MainTR" ALIGN="CENTER"$colspan>
					$headerData
				</TD>
			</TR>
			$openTD
EOF;
	return $contents;
}//commonTableHeader

//  Format table footer
//  Parameters: CloseTDTag(true|false), ColumnSpan(integer), FooterData(string)
//  Return: String(closing table tags)
function commonTableFooter($closeTD,$colspan,$footerData){
	$colspan=$colspan?" COLSPAN=\"$colspan\"":"";
	if($closeTD){
		$closeTD="</TD></TR>";
	}
	if($footerData){
		$footerData=<<<EOF
			<TR>
				<TD CLASS="MainTR"$colspan>$footerData</TD>
			</TR>
EOF;
	}
	$contents = <<<EOF
			$closeTD
			$footerData
			</TABLE>
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//commonTableFooter

//  Format time, with localization(local time offset) if set by user
//  Parameters: DisplayShortFormat(true|false), TimestampValue(integer)
//  Return: string
function commonTimeFormat($shortFormat,$dateString){
	Global $HTTP_COOKIE_VARS;
	$timeOffset = trim($HTTP_COOKIE_VARS["TimeOffset"])?$HTTP_COOKIE_VARS["TimeOffset"] * 3600:0;

	$format=$shortFormat?"M d, h:i a":"M j, Y, g:i a";
	return date($format,$dateString + $timeOffset);
}//commonTimeFormat

//  Get current time
//  Return: string(current)
function commonTimestamp(){	
	return date("YmdHis");
}//commonTimestamp

//  Format topic navigation, verify viewer accessibility and set variables to appropriate values
//  Return: string(contents of topic navigation)
function commonTopicNavigation(){
	global $GlobalSettings,$Language,$Document,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select post.subject,post.memberId, topic.startpostId,topic.views,topic.replies,topic.locked,topic.sticky,topic.poll,forum.forumId,forum.name,forum.moderators,forum.announcement,forum.status,board.name as boardName,board.boardId,board.accessibleGroups, board.status as boardStatus
		from {$Global_DBPrefix}Posts as post
		left join {$Global_DBPrefix}Topics as topic on (topic.startPostId=post.postId) 		
		left join {$Global_DBPrefix}Forums as forum on (forum.forumId=topic.forumId) 
		left join {$Global_DBPrefix}Boards as board on (board.boardId=forum.boardId) 
		WHERE topic.topicId=$VARS[topicId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
	$dataSet = mysql_fetch_array($fetchedData);
	commonVerifyAccess($dataSet);

	$Document['title']=$dataSet['subject'];
	$contents = <<<EOF
	<A HREF="$Document[mainScript]?boardId=$dataSet[boardId]">$dataSet[boardName]</A> <IMG SRC="images/separator.gif" WIDTH="7" HEIGHT="7">
	<A HREF="$Document[mainScript]?mode=forums&forumId=$dataSet[forumId]">$dataSet[name]</A> <IMG SRC="images/separator.gif" WIDTH="7" HEIGHT="7">
	$dataSet[subject]
EOF;
	$Document['forumId']=$dataSet['forumId'];
	$Document['forumName']=$dataSet['name'];	
	$Document['announcement']=$dataSet['announcement'];		
	$Document['boardId']=$dataSet['boardId'];
	$Document['boardName']=$dataSet['boardName'];	
	$Document['topicOwnerId']=$dataSet['memberId'];
	$Document['topicSubject']=$dataSet['subject'];
	$Document['topicViews']=$dataSet['views'];
	$Document['topicReplies']=$dataSet['replies'];
	$Document['topicSticky']=$dataSet['sticky'];
	$Document['topicStartPostId']=$dataSet['startPostId'];
	$Document['topicLock']=$dataSet['locked'];
	$Document['topicPoll']=$dataSet['poll'];

	$Document['previousNextNavigation'] = <<<EOF
	<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=topics&topicId=$VARS[topicId]&forumId=$Document[forumId]&action=previous" TITLE="$Language[PreviousTopic]">$Language[PreviousTopic]</A>
	<IMG SRC="images/separatorpn.gif" WIDTH="8" HEIGHT="8">
	<A HREF="$Document[mainScript]?mode=topics&topicId=$VARS[topicId]&forumId=$Document[forumId]&action=next" TITLE="$Language[NextTopic]">$Language[NextTopic]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
EOF;
	return $contents;
}//commonTopicNavigation

//  Format an inner white box for table header
//  Parameters: BoxWidth(integer), BoxContents(string)
//  Return: String(formatted white box)
function commonWhiteTableBoxHTML($width,$content){
	$contents = <<<EOF
<TABLE CLASS="OuterTableStyle" WIDTH="$width" CELLSPACING="1" CELLPADDING="5" BORDER="0">
<TR>
	<TD CLASS="TDStyle" ALIGN="CENTER">
		<NOBR>$content</NOB>
	</TD>
	</TR>
</TABLE>
EOF;
	return $contents;
}//commonWhiteTableBoxHTML
				
//  Check if email is in valid format
//  Parameters: String(email)
//  Return: boolean(true|false)
function commonValidateEmail($email){
	return ereg( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email) ;
}//funcValidateEmail

//  Verify if member is administrator or global moderator
//  Parameters: Array(multiple values)
//  Return: boolean(true|false)
function commonVerifyAdmin(){
	global $Member;
	if($Member[accessLevelId]==1 || $Member[accessLevelId] ==2) // if administrator global moderator
		return true;
	else
		return false;
}//commonVerifyAdmin

//  Verify if member has access to current board/forum and set variables to appropriate values, including room moderator
//  Parameters: Array(multiple)
function commonVerifyAccess($dataSet){
	global $GLobalSettings,$Language,$Document,$Member;
	if($Member[memberId]){
		if(($dataSet['status']==0 || $dataSet['boardStatus']==0) && $Member['accessLevelId'] != 1){
			//closed boards and forums can be accessed from admin only
			commonDisplayError("$dataSet[name]","$Language[Board]/$Language[Forum] $Language[closed]");
		}
		if(trim($dataSet['accessibleGroups']) && $Member[accessLevelId]>2){//admin, global moderators or specific group access only
			$accessibleGroups=split(" ",$dataSet['accessibleGroups']);
			if(!in_array($Member['groupId'],$accessibleGroups)){
				commonDisplayError("$dataSet[name]","$Language[Board]/$Language[Forumnotaccessible].");
			}				
		}
		if(trim($dataSet[moderators])){
			$moderators=explode(" ",trim($dataSet[moderators]));
			if(in_array($Member[loginName],$moderators)){
				$Member[moderator]=true;
				$Member[accessLevelId]=3;
				$Member[adminPosition] = "[$Language[Moderator]]";
			}
			$Document['moderators']=$moderators;
		}
	}
}

//  Get options listing for yes/no values
//  Parameter: CurrentSelectedValue(integer)
//  Return: string
function commonYesNoOptions($chosen){
	global $Language;
	$chosen?$yes="selected":$no="selected";
	$contents=<<<EOF
	<OPTION VALUE="0" $no>$Language[No]</OPTION>
	<OPTION VALUE="1" $yes>$Language[Yes]</OPTION>
EOF;
	return $contents;
}//commonYesNoOptions

?>