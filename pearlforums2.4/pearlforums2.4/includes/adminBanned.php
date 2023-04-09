<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminBanned.php - Process all actions related to 
//                  Banned IPs in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminBanned.php");
$Document[contentWidth]="95%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Banned";
$exe();	

//  Update banned record
function updateBanned(){
	global $Language,$Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($ip)==""){
		$isError=true;
		$errorMsg .= "IP $Language[isblank]";		
	}
	if($isError){
		$Document['msg'] = $errorMsg;
	}
	else{
		$fetchedData=mysql_query("update {$Global_DBPrefix}BannedIPs set ip=\"$ip\",notes=\"$notes\" $addSql where bannedId=$VARS[bannedId]");	
		$Document['msg'] .= "  $Language[Recordupdated].";
	
	}
	editBanned();
}//updateBanned

//  Edit banned record
function editBanned(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select bannedId, ip, notes from {$Global_DBPrefix}BannedIPs where bannedId=$VARS[bannedId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[bannedId]){
		$VARS=$dataSet;
		$Document['contents'] .= getBannedFormHTML("$Language[Edit] $Language[BannedIP]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $Language[BannedIP]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editBanned

//  Delete banned record.  
function deleteBanned(){
	global $Document,$GlobalSettings,$VARS,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="delete from {$Global_DBPrefix}BannedIPs where bannedId=$VARS[bannedId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg']=mysql_affected_rows()>0?$Language[Recordremoved]:$Language['Dataqueryerror'];
	listBanned();
}//deleteBanned

//  Create banned record
function createBanned(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($ip)==""){
		$isError=true;
		$Document['msg']="IP $Language[isblank]";
	}
	if($isError){
		$Document['contents'] .= getBannedFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
	}
	else{
		$sql="insert into {$Global_DBPrefix}BannedIPs (ip,notes) VALUES (\"$ip\",\"$notes\")";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$Document['msg']="$AdminLanguage[Recordcreated]";
			listBanned();
		}
		else{
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getBannedFormHTML("$AdminLanguage[CreateNewEntry]","Create");			
		}
	}
}//createBanned

//  Get new banned form
function newBanned(){	
	global $Member,$Document,$AdminLanguage;		
	$Document['contents'] .= getBannedFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
}//newBanned

//  List banned records
function listBanned(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$listLimit=5;
	$page=$VARS['page']==""?1:$VARS['page'];
	if(trim($Document['msg'])){
		$Document['contents'] .= commonEndMessage(0,$Document['msg']);
	}
	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$addSql =trim($VARS[searchText])!=""?"where ip like \"%$VARS[searchText]%\" ":"";
	
	$fromNumber=($page -1)* $listLimit;
	$sql="select bannedId,ip,notes from {$Global_DBPrefix}BannedIPs $addSql order by ip desc limit $fromNumber,$listLimit";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getBannedRowHTML($dataSet);		
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .= $page>1?commonEndMessage(4,$Language['Endoflisting']):commonEndMessage(4,"$Language[Norecordsfound]");
	
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$listLimit){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=banned&action=list&page=$page&searchText=$VARS[searchText]\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext(0,$previous,$next);
	$Document['contents'] .= "<BR />";
}//listBanned
 
?>