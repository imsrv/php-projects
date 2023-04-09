<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    notify.php - Process all actions related to  topic notification.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/notify.php");	
$action=$VARS['action']==""?"list":$VARS['action'];
if(!$Member['memberId'])
	commonDisplayError($Language[Notify],$Language[Accessdenied]);

$Document['contents'] = commonTableHeader(true,0,200,$Language[Notifications]);
$Document['contents'] .= ($action!="display" && $action !="Notify" && $action != "Remove" )?getSearchFormHTML():"";

if($action=="list"){
	listNotify();
}
else{
	$Document['forumNavigation']=commonTopicNavigation();
	$exe="{$action}Notify";
	$exe();	
}

$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");

//  List topics currently on notify list
function listNotify(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['listingsPerPage'];
	
	$addSQL = trim($searchText)!=""?" and post.subject like \"%$searchText%\" ":"";
	$Document['contents'] .=commonTableFormatHTML("header","80%","");
	$Document['contents'] .=getTitleRowHTML();
	$sql ="select notify.notifyId,notify.topicId,post.subject,member.name,member.loginName
				from {$Global_DBPrefix}Notify as notify
				left join {$Global_DBPrefix}Topics as topic on (topic.topicId=notify.topicId)
				left join {$Global_DBPrefix}Posts as post on (topic.startPostId=post.postId)
				left join {$Global_DBPrefix}Members as member on (member.memberId=post.memberId)
				where notify.memberId=$Member[memberId] $addSQL order by notify.notifyId desc limit $fromPostNumber,$Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{	
		$Document['contents'] .= getNotifyRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0){
		$Document['contents'] .= commonEndMessage(3,"$Language[Norecordsfound]");
	}
	$Document['contents'] .=commonTableFormatHTML("footer","","");

	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=notify&page=$page&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext("80%",$previous,$next);
	$Document['contents'] .= "<BR />";

}//listNotify

//  Display notify form
function displayNotify(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	if($Document['allowNotify'] || commonVerifyAdmin() || $Member[moderator]){
		$sql="select notifyId from {$Global_DBPrefix}Notify where topicId=$topicId and memberId=$Member[memberId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$Document['contents'] .= getNotifyFormHTML(mysql_num_rows($fetchedData));
	}
	else{
		commonDisplayError($Language[Accessdenied],"$Language[Notificationsclosed]");
	}
}//displayNotify

//  Put topic into notify list
function notifyNotify(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	if($Document['allowNotify'] || commonVerifyAdmin() || $Member[moderator]){
		$sql="insert into {$Global_DBPrefix}Notify (MemberId,TopicId) values ($Member[memberId],$topicId)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$Document['contents'] .= commonForwardTopic("$Language[Thankyou]","?mode=topics&topicId=$topicId&page=x&nl=1",3);
	}
	else{
		commonDisplayError($Language[Accessdenied],"$Language[Notificationsclosed]");
	}
}//notifyNotify

//  Remove topic from notify list
function removeNotify(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$sql="delete from {$Global_DBPrefix}Notify where topicId=$topicId and memberId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg'] = $Language[Thankyou];
	if($case=="list"){
		$Document['forumNavigation']= $Document['previousNextNavigation']="";
		listNotify();
	}
	else{
		$Document['contents'] .= commonForwardTopic($Language['Thankyou'],"?mode=topics&topicId=$topicId&page=x&nl=1",3);
	}
}//removeNotify

?>