<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminEmails.php - Process all actions related to 
//                  mass emailing and messaging in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminEmails.php");
$Document[contentWidth]=400;
$action=$VARS['action']==""?"entry":$VARS['action'];

$exe="{$action}Email";
$exe();	

//  Send mass email or message, to all members or a specific group
function sendEmail(){
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	if(trim($subject)==""){
		$isError=true;
		$Document['errorMsg'] .= "$Language[Subject] $Language[isblank].";		
	}
	if(trim($message)==""){
		$isError=true;
		$Document['errorMsg'] .= "$Language[Message] $Language[isblank].";		
	}
	if($isError){
		$Document['msg'] = $Language['Pleasetryagain'] . ": " . $Document['errorMsg'];
		entryEmail();
	}
	else{
		$addSql=$groupId?" where groupId=$groupId ":"";		
		$sql="select memberId,name,email from {$Global_DBPrefix}Members $addSql";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
		if(!$enableHTML){$message=nl2br($message);}
		while($dataSet = mysql_fetch_array($fetchedData)){
			if($sendAs=="emails"){
				commonSendEMail("$dataSet[name] <$dataSet[email]>",$subject,$message);
			}
			else{
				$time=time();
				$sql="insert into {$Global_DBPrefix}Messages (senderId,receiverId,subject,message,sendTime,status) values ($Member[memberId],$dataSet[memberId],\"$subject\",\"$message\",$time,1)";
				$status=mysql_query($sql) or commonLogError($sql,true);
			}
		}		
		$total=mysql_num_rows($fetchedData);
		$Document['contents'] .= commonEndMessage(0,"$Language[Thankyou] <BR /><BR /><BR />$AdminLanguage[Sent]: $total $sendAs.<BR /><BR /><BR />");
	}
}//sendEmail

//  Get entry form
function entryEmail(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$sql="select groupId,name from {$Global_DBPrefix}Groups where status!=0";	
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);		
	while($dataSet = mysql_fetch_array($fetchedData)){
		$selected=$groupId==$dataSet[groupId]?"selected":"";
		$listing .= "<OPTION VALUE=$dataSet[groupId]>$dataSet[name]</OPTION>";	
	}
	
	$Document['contents'] .= getFormHTML($listing);
}//entryEmail
 
?>