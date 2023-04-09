<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminPolls.php - Process all actions related to 
//                  polls in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminPolls.php");
$Document[contentWidth]="95%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Polls";
$exe();	

//  Delete poll
function deletePolls(){
	global $GlobalSettings,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	commonDeletePoll($VARS[topicId]);
	$sql="update {$Global_DBPrefix}Topics set poll=0 where topicId=$VARS[topicId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$Document[msg]="$Language[Recordremoved]";
	listPolls();
}//deletePolls

//  Get poll details including individual votes by each member
function detailsPolls(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	

	$Document['contents'] .= getSearchBoxHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getVoteLabelsHTML();
	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['listingsPerPage'];	

	$options=array("");
	
	//get poll details
	$sql="select pollId,topicId,question,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,
		voted1,voted2,voted3,voted4,voted5,voted6,voted7,voted8,voted9,voted10,startDate,endDate,status from {$Global_DBPrefix}Polls where topicId=$topicId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$pollDetails = mysql_fetch_array($fetchedData);
	$pollDetails[totalVotes]=0;

	for($i=1;$i<11;$i++){
		$option=$pollDetails["option{$i}"];
		if(trim($option)!=""){
			$pollDetails[options] .= $option . " (" .  $pollDetails["voted{$i}"] . " $Language[votes])<BR />";
			$pollDetails[totalVotes] += $pollDetails["voted{$i}"];
		}
	}	

	if(trim($searchText)!=""){
		$addSql = " and member.name like \"%$searchText%\" ";
	}

	//get votes by members
	$sql="select vote.voteId,vote.pollId,vote.memberId,vote.optionId,vote.votedDate,
		member.name,member.loginName from {$Global_DBPrefix}PollVotes as vote, {$Global_DBPrefix}Members as member where vote.memberId=member.memberId and vote.pollId=$pollDetails[pollId]
		$addSql order by vote.voteId desc limit $fromPostNumber, $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$dataSet['option']=$pollDetails["option$dataSet[optionId]"];
		$Document['contents'] .= getVoteRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0){
		$Document['contents'] .= commonEndMessage(3,$Language[Endoflisting]);		
	}
	$Document['contents'] .= commonTableFormatHTML("footer","","");
		
	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=polls&action=details&topicId=$topicId&page=$page&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document['contentWidth'],$previous,$next);
	
	$Document['contents'] .=getPollSummaryHTML($pollDetails);
}//detailsPolls

//  List polls
function listPolls(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	

	$Document['contents'] .= getSearchBoxHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['listingsPerPage'];	
	if(trim($searchText)!=""){
		$addSql = " and (member.name like \"%$searchText%\" or post.subject like \"%$searchText%\") ";
	}
	$sql="select  poll.pollId,poll.startDate,poll.endDate,poll.status,topic.topicId,post.subject,member.name,member.loginName
	 	from {$Global_DBPrefix}Polls as poll, {$Global_DBPrefix}Topics as topic, {$Global_DBPrefix}Posts as post, {$Global_DBPrefix}Members as member where poll.topicId=topic.topicId and topic.startPostId=post.postId and post.memberId=member.memberId and post.firstPost=1
	 	$addSql order by poll.pollId desc limit $fromPostNumber, $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getPollRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .=commonEndMessage(5,$Language[Endoflisting]);		
		
	$Document['contents'] .= commonTableFormatHTML("footer","","");
		
	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=polls&page=$page&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document['contentWidth'],$previous,$next);
	
}//listPolls
 
?>