<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminErrorlogs.php - Process all actions related to 
//                  Error Logs in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminErrorlogs.php");
$Document[contentWidth]="95%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Errorlogs";
$exe();	

//  Delete all error logs or by specific Id.
function deleteErrorlogs(){
	global $Document,$GlobalSettings,$VARS,$AdminLanguage,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	
	$addSql=$VARS[logId]?"where logId=$VARS[logId]":"";
	$sql="delete from {$Global_DBPrefix}ErrorLogs $addSql";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$Document['msg']="$Language[Recordremoved]";
	listErrorlogs();
}//deleteErrorlogs

//  List error logs
function listErrorlogs(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);	

	$Document['contents'] .= getSearchBoxHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$page=$page==""?1:$page;
	$fromPostNumber=($page -1)* $Document['listingsPerPage'];	
	if(trim($searchText)!=""){
		$addSql = " where sql like \"%$searchText%\" or errorMessage like \"%$searchText%\") ";
	}
	$sql="select  errorlog.logId,errorlog.scriptName,errorlog.sql,errorlog.errorMessage,errorlog.logTime,
			member.name,member.loginName from {$Global_DBPrefix}ErrorLogs as errorlog, {$Global_DBPrefix}Members as member where errorlog.memberId=member.memberId
	 		$addSql order by errorlog.logId desc limit $fromPostNumber, $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getErrorlogRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .=commonEndMessage(7,$Language[Endoflisting]);		
		
	$Document['contents'] .= commonTableFormatHTML("footer","","");
		
	if($counts==$Document[listingsPerPage]){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=errorlogs&page=$page&searchText=$searchText\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document['contentWidth'],$previous,$next);
	
}//listErrorlogs
 
?>