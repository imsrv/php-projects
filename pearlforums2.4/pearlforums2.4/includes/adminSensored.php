<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminSensored.php - Process all actions related to 
//                  sensored words in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminSensored.php");
$Document[contentWidth]="80%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Sensored";
$exe();	

//  Update sensored word
function updateSensored(){
	global $Language,$Document,$GlobalSettings,$VARS,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($word)==""){
		$isError=true;
		$errorMsg .= "$AdminLanguage[Word] $Language[isblank]";		
	}
	if($isError){
		$Document['msg'] = $errorMsg;
	}
	else{
		$sql="update {$Global_DBPrefix}SensoredWords set word=\"$word\",substitute=\"$substitute\",wholeWord=$wholeWord $addSql where sensoredId=$VARS[sensoredId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] .= "  $Language[Recordupdated].";
	
	}
	editSensored();
}//updateSensored

//  Edit sensored word
function editSensored(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select sensoredId, word, substitute,wholeWord from {$Global_DBPrefix}SensoredWords where sensoredId=$VARS[sensoredId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[sensoredId]){
		$VARS=$dataSet;
		$Document['contents'] .= getSensoredFormHTML("$Language[Edit] $Language[SensoredWord]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $Language[SensoredWord]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editSensored

//  Delete sensored word
function deleteSensored(){
	global $Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="delete from {$Global_DBPrefix}SensoredWords where sensoredId=$VARS[sensoredId]";	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$Document['msg']=mysql_affected_rows()>0?"$Language[Recordremoved]":$Language['Dataqueryerror'];
	listSensored();
}//deleteSensored

//  Create sensored word
function createSensored(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($word)==""){
		$isError=true;
		$Document['msg']="$AdminLanguage[Word] $Language[isblank]";
	}
	if($isError){
		$Document['contents'] .= getSensoredFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
	}
	else{
		$sql="insert into {$Global_DBPrefix}SensoredWords (word,substitute,wholeWord) VALUES (\"$word\",\"$substitute\",$wholeWord)";
		$fetchedData=mysql_query($sql);
		if(mysql_affected_rows()){
			$Document['msg']="$AdminLanguage[Recordcreated]";
			listSensored();
		}
		else{
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getSensoredFormHTML("$AdminLanguage[CreateNewEntry]","Create");			
		}
	}
}//createSensored

//  Get new sensor word form
function newSensored(){	
	global $Document,$AdminLanguage;		
	$Document['contents'] .= getSensoredFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
}//newSensored

//  List sensored words
function listSensored(){	
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
	$addSql =trim($VARS[searchText])!=""?"where word like \"%$VARS[searchText]%\" ":"";
	
	$fromNumber=($page -1)* $listLimit;
	$sql="select sensoredId,word,substitute from {$Global_DBPrefix}SensoredWords $addSql order by word desc limit $fromNumber,$listLimit";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getSensoredRowHTML($dataSet);		
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .= $page>1?commonEndMessage(4,$Language['Endoflisting']):commonEndMessage(4,"$Language[Norecordsfound]");
	
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$listLimit){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=sensored&action=list&page=$page&searchText=$VARS[searchText]\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext(0,$previous,$next);
	$Document['contents'] .= "<BR />";
}//listSensored
 
?>