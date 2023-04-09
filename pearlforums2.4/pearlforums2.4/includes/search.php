<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    search.php - Handle all searches.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$Document['title']=$Document['title'] . " - " .$Language[Search];
include_once("$GlobalSettings[templatesDirectory]/search.php");
$Document[contentWidth]="90%";	
$action=$VARS['action']==""?"display":$VARS['action'];
$exe="{$action}Search";

$exe();	

//  Perform actual search and return results
function searchSearch(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['postingsPerPage'];
	
	$Document['contents']=commonTableHeader(true,0,300,$Language['SearchResults']);
	$Document['contents'] .= getResultsHeaderHTML();
	if($case=="quick"){
		$sql="select post.postId,post.topicId,post.subject,post.postDate,member.name,member.loginName from {$Global_DBPrefix}Posts post, {$Global_DBPrefix}Members member where (post.subject like \"%$searchText%\" or post.message like \"%$searchText%\") and member.memberId=post.memberId order by post.postId limit $fromPostNumber, $Document[postingsPerPage]";		
	}
	else{
		if(trim($name)){
			$addSql = " and member.name like \"%$name%\" ";
		}
		if(trim($time)){
			$fromDate = time() - ($time * $timeSpan * 86400);
			$addSql .= " and post.postDate < $fromDate ";
		}
		if($forumId){
			$sql="select post.postId,post.topicId,post.subject,post.postDate,member.name,member.loginName from {$Global_DBPrefix}Posts post, {$Global_DBPrefix}Topics topic, {$Global_DBPrefix}Members member where post.topicId=topic.topicId and topic.forumId=$forumId and (post.subject like \"%$searchText%\" or post.message like \"%$searchText%\") and member.memberId=post.memberId $addSql order by post.postId limit $fromPostNumber, $Document[postingsPerPage]";						
		}
		else{
			$sql="select post.postId,post.topicId,post.subject,post.postDate,member.name,member.loginName from {$Global_DBPrefix}Posts post, {$Global_DBPrefix}Members member where (post.subject like \"%$searchText%\" or post.message like \"%$searchText%\") and member.memberId=post.memberId $addSql order by post.postId limit $fromPostNumber, $Document[postingsPerPage]";		
		}	
	}
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$fromPostNumber++;
		$dataSet[number]=$fromPostNumber;
		$Document['contents'] .= getResultRowHTML($dataSet);			
	}
	
	$counts=mysql_num_rows($fetchedData);
	if($counts==0){
		if($page>1)
			$Document['contents'] .= commonEndMessage(4,$Language[Endoflisting]);		
		else
			$Document['contents'] .= commonEndMessage(4,"$Language[Norecordsfound]: <STRONG>$searchText</STRONG>");				
	}
	$Document['contents'] .= commonTableFormatHTML("footer","","");

	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=search&action=search&page=$page&a=$a&case=$case&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document[contentWidth],$previous,$next);
	
	$Document['contents'] .= "<BR />";	
	$Document['contents'] .=commonTableFooter(true,0,"&nbsp;");

}//searchSearch

//  Display advanced search box
function displaySearch(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$sql="select forumId,name from {$Global_DBPrefix}Forums order by boardId, name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		$selected=$dataSet['forumId']==$chosen?"selected":"";
		$VARS['forumsList'] .= "<OPTION VALUE=\"$dataSet[forumId]\" $selected>$dataSet[name]</OPTION>";
	}
	
	$Document['contents'] = commonTableHeader(true,0,200,$Language['AdvancedSearch']);
	$Document['contents'] .= getSearchFormHTML();
	$Document['contents'] .= commonTableFooter(true,0," &nbsp; ");
}//displaySearch
?>