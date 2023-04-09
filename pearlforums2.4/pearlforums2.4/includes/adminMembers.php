<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminMembers.php - Process all actions related to 
//                  members in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminMembers.php");
$Document[contentWidth]="95%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Member";
$exe();	

//  Lock|Unlock member
function accessMember(){	
	global $GlobalSettings,$Member,$Document,$VARS,$AdminLanguage;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	extract($VARS,EXTR_OVERWRITE);
	$sql="update {$Global_DBPrefix}Members set locked=$locked where memberId=$memberId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg'] = $locked?"$AdminLanguage[Memberaccountclosed].":"$AdminLanguage[Memberaccountopen].";
	listMember();
}//accessMember

//  Update member
function updateMember(){
	global $Language,$Document,$GlobalSettings,$VARS,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;

	if(trim($name=="")){ //full name is required
		$isError=true;
		$errorMsg = $Language['Name'] . " " .  $Language['isblank'];
	}
	if(!commonValidateEmail($email)){ //validate email
		$isError=true;
		$errorMsg .=  $AdminLanguage['InvalidEmail'];
		if(trim($email==""))
			$errorMsg .=  $AdminLanguage['Emailrequired'];
	}
	if(trim($passwd)!=""){ 
		if(strcmp ($passwd, $confirmPassword)<>0){ //passwords match?
			$isError=true;
			$errorMsg .= $Language['Password'] . " " . $Language['doesntmatch'];
		}		
		else{
			$passwd=commonEncryptPassword($passwd);
			$addSql = ", passwd=\"$passwd\" ";
		}
	}
	if($isError){
		$Document['msg'] = $errorMsg . " " . $AdminLanguage['Recordnotchanged'];
	}
	else{		
		$notifyAnnouncements=$notifyAnnouncements==""?0:$notifyAnnouncements;
		$hideEmail=$hideEmail==""?0:$hideEmail;
		$sql="update {$Global_DBPrefix}Members set name=\"$name\",groupId=$groupId, email=\"$email\",hideEmail=$hideEmail,accessLevelId=$accessLevelId, avatarId=$avatarId,url=\"$url\" $addSql where memberId=$memberId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] = "  $Language[Recordupdated].";
	}
	editMember();
}//updateMember

//  Edit member
function editMember(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select member.memberId, member.name, member.loginName, 
		member.accessLevelId,member.groupId,member.email,member.url,member.hideEmail,
		member.datejoined, member.lastLogin, member.notifyAnnouncements,member.ip,member.avatarId,member.totalPosts,member.locked, 
		groups.name as groupName, avatars.fileName from {$Global_DBPrefix}Members as member 
		left join {$Global_DBPrefix}Groups as groups on (groups.groupId=member.groupId) 
		left join {$Global_DBPrefix}Avatars as avatars on (avatars.avatarId=member.avatarId)
		where member.memberId=$VARS[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[memberId]){
		$VARS=$dataSet;
		$VARS['hideEmail']=$dataSet['hideEmail']?" CHECKED":"";
		$VARS['notifyAnnouncements']=$dataSet['notifyAnnouncements']?" CHECKED":"";
		$VARS['positionsListing'] = getPositionsListing($dataSet['accessLevelId']);
		$VARS['groupsListing']=getGroupsListing($dataSet['groupId']);
		$VARS['avatarsListing']=commonAvatarsListing($dataSet['memberId'],$dataSet['avatarId']);
		if($dataSet['locked']==1){
			$VARS['accessStatus']=0;
			$VARS['accessImage']="adminunlockmember.gif";
			$VARS['accessAlt']="$Language[UnlockAccount]";
		}
		else{
			$VARS['accessStatus']=1;
			$VARS['accessImage']="adminlockmember.gif";
			$VARS['accessAlt']="$Language[LockAccount]";		
		}

		$Document['contents'] .= getMemberFormHTML("$Language[Edit] $AdminLanguage[Member]",commonGetSubmitButton(false,"Update",""),$Document['msg']);	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $AdminLanguage[Member]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editMember

//  Delete member and related posts,topics, attachments and polls
function deleteMember(){
	global $Document,$GlobalSettings,$VARS,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	$posts=array();
	$affectedTopics=array();
	$affectedForums=array();
	$affectedPosts=array();	
	$savedData=array();
	$sql="delete from {$Global_DBPrefix}Members where memberId=$VARS[memberId]";
	$fetchedData=mysql_query($sql) or commmonLogError($sql);	
	if(mysql_affected_rows()){
		$sql="delete from {$Global_DBPrefix}Avatars where memberId=$VARS[memberId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		if(mysql_affected_rows()){
			foreach($Document['avatarTypes'] as $type){ //just in case more than one file type uploaded
				$file="$Global_avatarsPath/$VARS[memberId].$type";	
				if(file_exists($file)){
					unlink($file);
				}		
			}
		}
		
		//get post Ids, topic Ids and forum Ids
		$sql="select p.postId,p.firstPost,p.topicId,t.forumId,t.poll from {$Global_DBPrefix}Posts p, {$Global_DBPrefix}Topics t where p.memberId=$VARS[memberId] and p.topicId=t.topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		while($dataSet = mysql_fetch_array($fetchedData))
		{
			array_push($posts,$dataSet[postId]);				
			array_push($affectedTopics,$dataSet[topicId]);	
			array_push($affectedForums,$dataSet[forumId]);	
			$savedData[$dataSet[postId]]=$dataSet;
		}

		foreach($posts as $postId){
			$topicId=$savedData[$postId]['topicId'];
			if($savedData[$postId]['firstPost']){ //if it's a first post 
				$sql="select postId from {$Global_DBPrefix}Posts where topicId=$topicId";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
				while($dataSet = mysql_fetch_array($fetchedData))
				{
					array_push($affectedPosts,$dataSet[postId]);//get all other posts in the same topic	for removing attachments		
				}							
				$sql="delete from {$Global_DBPrefix}Posts where topicId=$topicId";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);	 
				$sql="delete from {$Global_DBPrefix}Topics where topicId=$topicId";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
				commonRemoveAttachment($affectedPosts,false);
				if($savedData[$postId]['poll'])//Delete if there's a poll 
					commonDeletePoll($topicId);				
			}
			else{
				$sql="delete from {$Global_DBPrefix}Posts where postId=$postId";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);				
				commonRemoveAttachment(array($postId),false);
			}
			$affectedPosts=array();
		}
		commonResetTopics($affectedTopics);
		commonResetForums($affectedForums);
		$Document['msg']="Member deleted";
	}	
	else{
		$Document['msg']="Deleting failed.  Please try again.";	
	}
	listMember();
}//deleteMember

function listMember(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	

	$listType=$listType==""?"recent":$listType;
	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['listingsPerPage'];	
	$baseSql="select member.memberId,member.name,member.loginName,member.groupId,member.accessLevelId,member.locked, groups.name as groupName from {$Global_DBPrefix}Members member left join {$Global_DBPrefix}Groups as groups on (groups.groupId=member.groupId)";
	switch ($listType){
	case "alpha":
		if(!$total){
			$sql="select count(*) as total from {$Global_DBPrefix}Members where name like '$alpha%'";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);
		$sql="$baseSql where member.name like '$alpha%' order by name limit $fromPostNumber, $Document[listingsPerPage]";	
		processListing($paging,$sql);
		break;

	case "recent":
		if(!$total){
			$sql="select count(*) as total from {$Global_DBPrefix}Members";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);
		$sql="$baseSql order by member.memberId desc limit $fromPostNumber, $Document[listingsPerPage]";	
		processListing($paging,$sql);
		break;

	case "search":
		if(!$total){
			$sql="select count(*) as total from {$Global_DBPrefix}Members where name like '%$searchText%'";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);
		$sql="$baseSql where member.name like '%$searchText%' order by member.name desc limit $fromPostNumber, $Document[listingsPerPage]";	
		processListing($paging,$sql);
		break;
		
	}

}

//  List members
function processListing($paging,$sql){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($VARS,EXTR_OVERWRITE);

	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$dataSet['position'] = $Language['MemberPositions'][$dataSet['accessLevelId']];
		
		if($dataSet['locked']==1){
			$dataSet['accessStatus']=0;
			$dataSet['accessAlt']="$Language[UnlockAccount]";
		}
		else{
			$dataSet['accessStatus']=1;
			$dataSet['accessAlt']="$Language[LockAccount]";		
		}
		
		$Document['contents'] .= getMemberRowHTML($dataSet);
		$lastAlpha=$dataSet[name];
	}
	$counts=mysql_num_rows($fetchedData);
	
	if($counts==0){
		if($page>1)
			$Document['contents'] .= commonEndMessage(4,$Language[Endoflisting]);		
		else if($case=="online")
			$Document['contents'] .= commonEndMessage(4,"$Language[None]");				
		else if($case=="alpha")
			$Document['contents'] .= commonEndMessage(4,"$Language[Nomembersunder] <STRONG>$alpha</STRONG>");				
		else if($case=="search")	
			$Document['contents'] .= commonEndMessage(4,"$Language[Norecordsfound] (<STRONG>$searchText</STRONG>)");						
	}

	$Document['contents'] .= commonTableFormatHTML("footer","","");

	$Document['contents'] .= commonPreviousNext($Document[contentWidth],$previous,$paging);
}//processListing
 
function buildPageList($page,$total){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		

	$Document[TotalPages]=$pages = ceil($total/$Document['listingsPerPage']);
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
		$pageList .=$p==$page?"[$p]&nbsp;":" <A HREF=\"$Document[mainScript]?mode=admin&case=members&action=list&listType=$listType&page=$p&total=$total&alpha=$VARS[alpha]\">$p</A>&nbsp;";		
	}
	
	$pageLabel=$pages>1?$Language[Pages]:$Language[Page];	
	if($total)
		$pageList= "$pages $pageLabel: $pageList";
	return $pageList;
}

 
//  Get groups listing
//  Paramemter: groupId(integer)
//  Return:  String(groups as select options)
function getGroupsListing($groupId){
	global $GlobalSettings,$Member,$Document,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$listing = "<OPTION VALUE=\"0\">[$Language[None]]</OPTION>";
	$sql="select groupId, name from {$Global_DBPrefix}Groups order by name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{		
		$selected=$dataSet[groupId]==$groupId?" selected":"";
		$listing .= "<OPTION VALUE=\"$dataSet[groupId]\"$selected>$dataSet[name]</OPTION>";
	}
	return $listing;
}//getGroupsListing

//  Get available positions such as admin,moderator etc.
//  Parameter: Current position(integer)
//  Return: String(positions as select options)
function getPositionsListing($chosen){
	global $GlobalSettings,$Member,$Document,$Language;		
	
	while(list($id,$name)= each ($Language['MemberPositions']))
	{		
		$selected=$id==$chosen?" selected":"";
		$listing .= "<OPTION VALUE=\"$id\"$selected>$name</OPTION>";
	}
	return $listing;
}//getPositionsListing

?>