<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    members.php -  List members.  For editing members' records
//                  please see profile.php, or adminMembers.php.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/members.php");
$Document['contentWidth']=550;
$Document['title']="$Language[MembersListing]";

extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
$case=$case==""?"recent":$case;
$page=$page==""?1:$page;
$fromPostNumber=($page -1)* $Document['listingsPerPage'];	

switch ($case){
	case "online":
		$currentTime = time();
		$validTime = $currentTime - 900; //15mins
		if(!$total){
			$sql="select count(*) as total from {$Global_DBPrefix}Online where hitTime > $validTime";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);	
		$sql="select online.hitTime as online,member.memberId,member.name,member.loginName,member.groupId,member.accessLevelId,member.ip from {$Global_DBPrefix}Online as online 
		left join {$Global_DBPrefix}Members as member on (member.memberId=online.memberId) where hitTime > $validTime order by hitTime desc";
		listMember($paging,$sql);
		$Document['title']=$Language[CurrentlyOnline];
		break;

	case "alpha":
		if(!$total){		
			$sql="select count(*) as total from {$Global_DBPrefix}Members where name like '$alpha%'";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);
		$sql="select member.memberId,member.name,member.loginName,member.groupId,member.accessLevelId,member.ip,online.hitTime as online from {$Global_DBPrefix}Members as member
		left join {$Global_DBPrefix}Online as online on (online.memberId=member.memberId)
		where name like '$alpha%' order by name limit $fromPostNumber, $Document[listingsPerPage]";	
		listMember($paging,$sql);
		break;

	case "recent":
		if(!$total){		
			$sql="select count(*) as total from {$Global_DBPrefix}Members";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);
		$sql="select member.memberId,member.name,member.loginName,member.groupId,member.accessLevelId,member.ip,online.hitTime as online from {$Global_DBPrefix}Members as member
		left join {$Global_DBPrefix}Online as online on (online.memberId=member.memberId)
		order by member.memberId desc limit $fromPostNumber, $Document[listingsPerPage]";	
		listMember($paging,$sql);
		break;

	case "search":
		if(!$total){
			$sql="select count(*) as total from {$Global_DBPrefix}Members where name like '%$searchText%'";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);
			$dataSet = mysql_fetch_array($fetchedData);
			$total=$dataSet[total];
		}
		$paging=buildPageList($page,$total);
		$sql="select member.memberId,member.name,member.loginName,member.groupId,member.accessLevelId,member.ip,online.hitTime as online from {$Global_DBPrefix}Members as member
		left join {$Global_DBPrefix}Online as online on (online.memberId=member.memberId)
		where member.name like '%$searchText%' order by member.name desc limit $fromPostNumber, $Document[listingsPerPage]";	
		listMember($paging,$sql);
		break;
		
}



//  List members
function listMember($paging,$sql){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($VARS,EXTR_OVERWRITE);

	$Document['contents'] = commonTableHeader(true,0,300,$Document['title']);
	$Document['contents'] .= getTopHTML();

	$guests=0;
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$dataSet['position'] = $Language['MemberPositions'][$dataSet['accessLevelId']];
		$dataSet[online]=$dataSet[online]?1:0;
		if($case=="online" && $dataSet[name]=="")
			$guests++;
		if($dataSet[name])
			$Document['contents'] .= getMemberRowHTML($dataSet);
		$lastAlpha=$dataSet[name];
	}
	$counts=mysql_num_rows($fetchedData);
	if($guests)
		$Document['contents'] .= getGuestRowHTML($guests);		
	
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

	$Document['contents'] .= getBottomHTML();
	
	$Document['contents'] .= commonPreviousNext($Document[contentWidth],$previous,$paging);
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");
}//listMember
 
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
		$pageList .=$p==$page?"[$p]&nbsp;":" <A HREF=\"$Document[mainScript]?mode=members&case=$VARS[case]&page=$p&total=$total&alpha=$VARS[alpha]\">$p</A>&nbsp;";		
	}
	
	$pageLabel=$pages>1?$Language[Pages]:$Language[Page];	
	if($total)
		$pageList= "$pages $pageLabel: $pageList";
	return $pageList;
}

?>