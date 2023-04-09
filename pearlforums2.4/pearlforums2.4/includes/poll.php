<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    poll.php - Process all actions related to polls.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/poll.php");
$Document['forumNavigation']=commonTopicNavigation();
$action=$VARS['action'];

if(!$Member['memberId'])
	commonDisplayError($Language[Posting],$Language[Accessdenied]);

$exe="{$action}Poll";
$exe();	

//  Close poll
function closePoll(){
	global $Document,$Language,$VARS,$GlobalSettings,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$now=time();
	if(commonVerifyAdmin() || $Member[moderator]){//action available to moderators and admin only
		$sql="update {$Global_DBPrefix}Polls set status=0, endDate=$now where topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	}
	$Document['contents'] .= getVotedHTML($topicId,"$Language[Pollclosed]",3);	
}//closePoll

//  Open poll
function openPoll(){
	global $Document,$Language,$VARS,$GlobalSettings,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	if(commonVerifyAdmin() || $Member[moderator]){//action available to moderators and admin only
		$sql="update {$Global_DBPrefix}Polls set status=1 where topicId=$topicId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	}
	$Document['contents'] .= getVotedHTML($topicId,$Language[Thankyou],3);	
}//openPoll

//  Register vote
function votePoll(){
	global $Document,$Language,$VARS,$GlobalSettings,$Member;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	if($option){
		$sql="select optionId from {$Global_DBPrefix}PollVotes where memberId=$Member[memberId] and pollId=$pollId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		//$dataSet=mysql_fetch_array($fetchedData);
		if(mysql_num_rows($fetchedData)){//just in case of cheaters 		
			$Document['contents'] = commonTableHeader(true,0,0,"&nbsp;");	
			$Document['contents'] .= commonForwardTopic($Language['Youhavevoted'],"?mode=topics&topicId=$topicId&nl=1",3);
			$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");			
		}
		else{
			$now=time();
			$sql="update {$Global_DBPrefix}Polls set voted$option=voted$option + 1 where pollId=$pollId";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$sql="insert into {$Global_DBPrefix}PollVotes (pollId,memberId,optionId,votedDate) values ($pollId,$Member[memberId],$option,$now)";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);			
			$Document['contents'] .= getVotedHTML($topicId,$Language[Thankyou],3);
		}
	}
	else{
		$Document['contents'] = commonTableHeader(true,0,0,"&nbsp;");	
		$Document['contents'] .= commonForwardTopic($Language['Nooptionselected'],"?mode=topics&topicId=$topicId&nl=1",3);
		$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");
	}	
	
}//votePoll

?>