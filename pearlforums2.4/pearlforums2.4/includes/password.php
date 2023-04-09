<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    password.php - Process all actions related to passwords.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$Document['title']="$Language[Retrieve] $Language[Password]";
include_once("$GlobalSettings[templatesDirectory]/password.php");
include_once("$Document[languagePreference]/passwordMessages.php");	

$action=$VARS['action']==''?"entry":$VARS['action'];
$exe="{$action}Password";

$Document['contents'] = commonTableHeader(true,0,300,$Document['title']);
$exe();	
$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");			

//  Update new password
function updatePassword(){
	global $Document,$GlobalSettings,$Member,$VARS,$HTTP_COOKIE_VARS,$Language,$userfile,$userfile_name,$userfile_size;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	if(trim($securityCode)=="")
		commonDisplayError($Document['title'],"$Language[SecurityCode] $Language[isrequired]");

	$sql="select memberId,name, email,loginName,securityCode from {$Global_DBPrefix}Members where loginName=\"$loginName\" and securityCode=\"$securityCode\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if(mysql_num_rows($fetchedData)>0){ 
		if(strcmp ($passwd, $confirmPassword)<>0){ //passwords match?
			$isError=true;
			$errorFields['confirmPassword']= "&laquo; " . $Language['doesntmatch'];
		}		
		if(strlen($passwd) < 3 || strlen($newPassword) > 20){ //password length 20<>3 chars
			$isError=true;
			$errorFields['newPassword'] = "&laquo; " . $Language[invalid] . ". " . $Language['Allowablelength'];
		}	
		
		if($isError){
			$errorFields[name]=$dataSet[name];
			$Document['contents'] .= resetFormHTML($errorFields);			
		}
		else{
			$newPassword = commonEncryptPassword($passwd);
			$sql="update {$Global_DBPrefix}Members set passwd=\"$newPassword\", securityCode=\"\" where memberId=\"$dataSet[memberId]\"";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			$Document['contents'] .= getAutoLoginHTML();								
		}
	}
	else{
		commonDisplayError($Document['title'],"$Language[SecurityCode]/$Language[LoginName] $Language[doesntmatch].  $Language[Pleasetryagain]");
	}	
}//updatePassword

//  Process retrieve request:  Generate security code and send out email 
function retrievePassword(){
	global $Document,$GlobalSettings,$Member,$VARS,$HTTP_COOKIE_VARS,$Language,$userfile,$userfile_name,$userfile_size;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$sql="select memberId,name,email,loginName,securityCode from {$Global_DBPrefix}Members where email=\"$email\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if(mysql_num_rows($fetchedData)>0){ 
		if(trim($dataSet[securityCode])==""){ //Generate new code if blank.  Leave as is if previous request has not been processed.  
			$dataSet['securityCode']=commonRandomString("",20); //generate new security code, no prefix, 20 random chars.
			$sql="update {$Global_DBPrefix}Members set securityCode=\"$dataSet[securityCode]\" where memberId=$dataSet[memberId]";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		}
		commonSendEMail("$dataSet[name] <$dataSet[email]>","$Document[title] - Global_organization",getSecurityCodeEmailMessage($dataSet));
	
		$Document['contents'] .= getSecurityCodeSentMessage($dataSet[name]);						
	}
	else{
		$Document['msg']="<BR/>$Language[Emailnotfound].  $Language[Pleasetryagain]<BR/><BR/>";
		$Document['contents'] .= retrieveFormHTML();	
	}	
}//retrievePassword

//  Display password reset form 
function resetPassword(){
	global $Document,$GlobalSettings,$Member,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$sql="select memberId,name, email,loginName,securityCode from {$Global_DBPrefix}Members where loginName=\"$loginName\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if(trim($dataSet[securityCode])==""){ //Request has already been processed.  
		$Document['contents'] .= getRequestAlreadyProcessedMessage($dataSet[name]);
		$Document['contents'] .= retrieveFormHTML();
	}
	else{
		if($securityCode != $dataSet[securityCode]){
			commonDisplayError($Document['title'],"$Language[SecurityCode]/$Language[LoginName] $Language[doesntmatch].  $Language[Pleasetryagain]");
		}
		$Document['contents'] .= resetFormHTML($dataSet);	
	}
}//resetPassword

//  Display password retrieve form
function entryPassword(){
	global $Document,$GlobalSettings,$Member,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$Document['contents'] .= retrieveFormHTML();	
}//entryPassword
	
?>