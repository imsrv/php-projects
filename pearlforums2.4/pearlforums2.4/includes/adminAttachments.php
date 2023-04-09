<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminAttachment.php - Process all actions related to 
//                  attachments in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminAttachments.php");
$Document[contentWidth]="95%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Attachments";
$exe();	

//  Delete attachment files and mark multiple attachments records as deleted, based on selected criteria by admin. 
function MassDeleteAttachments(){
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	
	$posts=array();
	if($type=="size"){
		$sql="select postId from {$Global_DBPrefix}Attachments where fileSize > $fileSize and removedBy=0";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	}
	else if($type=="date"){
		$fromDate = time() - (($months)* 2592000);
		$sql="select post.postId,post.subject,post.postDate from {$Global_DBPrefix}Posts as post, {$Global_DBPrefix}Attachments as attachment where post.postId=attachment.postId and post.postDate < $fromDate and attachment.removedBy=0";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	}
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		array_push($posts,$dataSet[postId]);
		commonRemoveAttachment($posts,true);
	}
	$Document['msg']= mysql_num_rows($fetchedData) . " $Language[Recordremoved]";
	listAttachments();	
}//MassDeleteAttachments

//  Delete single attachment based on specific postId.  Delete file, mark record as deleted by admin.
function deleteAttachments(){
	global $VARS,$Document,$Language;
	commonRemoveAttachment(array($VARS[postId]),true);
	$Document['msg']="$Language[Recordremoved]";
	listAttachments();
}//deleteAttachments

//  Physically removed all attachment records previously marked as deleted by admin.
function purgeAttachments(){
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	
	$sql="delete from {$Global_DBPrefix}Attachments where removedBy > 0";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	
	$Document[msg]=mysql_affected_rows() . " " . $AdminLanguage['Recordspurged'];
	listAttachments();
}//purgeAttachments

//  List attachment records, current or removed by admin.
function listAttachments(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	

	$Document['contents'] .= getSearchBoxHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['listingsPerPage'];	
	if(trim($searchText)!=""){
		$addSql = " where member.name like \"%$searchText%\" or post.subject like \"%$searchText%\"";
	}
	$sql="select attachment.attachmentId,attachment.postId,attachment.fileSize,attachment.fileType,attachment.removedBy,post.topicId,post.subject,post.postDate,member.name,member.loginName,admin.name as adminName from {$Global_DBPrefix}Attachments attachment
 	 	  left join {$Global_DBPrefix}Members as admin on (admin.memberId=attachment.removedBy) 
	 	  left join {$Global_DBPrefix}Posts as post on (post.postId=attachment.postId) 
	 	  left join {$Global_DBPrefix}Members as member on (member.memberId=post.memberId)
	 	  $addSql order by removedBy, attachment.fileSize desc limit  $fromPostNumber, $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getAttachmentRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)$Document['contents'] .= commonEndMessage(6,$Language[Endoflisting]);		
	
	$Document['contents'] .= commonTableFormatHTML("footer","","");
		
	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=attachments&page=$page&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document['contentWidth'],$previous,$next);
	$Document['contents'] .= getAttachmentOptions();
}//listAttachments
 
?>