<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminReserved.php - Process all actions related to 
//                  reserved login names in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminReserved.php");
$Document[contentWidth]="95%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Reserved";
$exe();	

//  Update reserved usenames
function updateReserved(){
	global $Language,$Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($username)==""){
		$isError=true;
		$errorMsg .= "$AdminLanguage[Username] $Language[isblank]";	
	}
	if($isError){
		$Document['msg'] = $errorMsg;
	}
	else{
		$sql="update {$Global_DBPrefix}ReservedUsernames set username=\"$username\",notes=\"$notes\" $addSql where reservedId=$VARS[reservedId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] .= "  $Language[Recordupdated].";
	
	}
	editReserved();
}//updateReserved

//  Edit reserved username
function editReserved(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select reservedId, username, notes from {$Global_DBPrefix}ReservedUsernames where reservedId=$VARS[reservedId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[reservedId]){
		$VARS=$dataSet;
		$Document['contents'] .= getReservedFormHTML("$Language[Edit] $Language[ReservedIP]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $Language[ReservedIP]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editReserved

//  Delete reserved username
function deleteReserved(){
	global $Document,$Language,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="delete from {$Global_DBPrefix}ReservedUsernames where reservedId=$VARS[reservedId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg']=mysql_affected_rows()>0?"$Language[Recordremoved]":"$Language[Deletingfailed]";
	listReserved();
}//deleteReserved

//  Create reserved username
function createReserved(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($username)==""){
		$isError=true;
		$Document[msg]="$AdminLanguage[Username] $Language[isblank]";
	}
	if($isError){
		$Document['contents'] .= getReservedFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
	}
	else{
		$sql="insert into {$Global_DBPrefix}ReservedUsernames (username,notes) VALUES (\"$username\",\"$notes\")";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$Document['msg']="$AdminLanguage[Recordcreated]";
			listReserved();
		}
		else{
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getReservedFormHTML("$AdminLanguage[CreateNewEntry]","Create");
		}
	}
}//createReserved

//  Get reserve username form
function newReserved(){	
	global $Member,$Document,$AdminLanguage;		
	$Document['contents'] .= getReservedFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
}//newReserved

//  List reserved usernames
function listReserved(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$listLimit=5;
	$page=$VARS['page']==""?1:$VARS['page'];
	if(trim($Document['msg'])){
		$Document['contents'] .= commonEndMessage(0,$Document['msg']);
	}
	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$addSql =trim($VARS[searchText])!=""?"where username like \"%$VARS[searchText]%\" ":"";
	
	$fromNumber=($page -1)* $listLimit;
	$sql="select reservedId,username,notes from {$Global_DBPrefix}ReservedUsernames $addSql order by username desc limit $fromNumber,$listLimit";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getReservedRowHTML($dataSet);		
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .= $page>1?commonEndMessage(4,$Language['Endoflisting']):commonEndMessage(4,"$Language[Norecordsfound]");
	
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$listLimit){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=reserved&action=list&page=$page&searchText=$VARS[searchText]\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext(0,$previous,$next);
	$Document['contents'] .= "<BR />";
}//listReserved
 
?>