<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    login.php - Handle members' login.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//extract($HTTP_POST_VARS,EXTR_OVERWRITE);
extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
if($VARS['case']=="login"){//login	 
	$isError=false;
	if($GlobalSettings[LoginSpamGuard]){
		$sessionId= $_REQUEST["PHPSESSID"];
		if($sessionId==""){
			session_start();
			$sessionId = session_id();
		}	
		$sql="select sessionId from {$Global_DBPrefix}SpamGuard where sessionId='$sessionId' and code='$VARS[code]'";	
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_num_rows($fetchedData)==0){
			$isError=true;
			$fileName=commonGetSpamGuard(session_Id(),1);
			$Document[invalidCodeMsg]=$Language['Verifycode'];
			$Document['SpamGuardImage']=commonGetSpamGuard(session_Id(),2);
		}
	}

	if($isError){	
		include_once("$GlobalSettings[templatesDirectory]/login.php");
		include_once("$GlobalSettings[templatesDirectory]/password.php");
		$Document['contents'] = getLoginFormHTML(true,$Document[SpamGuardImage]);
	}
	else{
		$passwd=commonEncryptPassword($HTTP_POST_VARS[passwd]);
		$sql="select memberId, email,lastLogin,ip from {$Global_DBPrefix}Members where loginName=\"$HTTP_POST_VARS[loginName]\" and passwd=\"$passwd\"";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);
		if($dataSet['memberId']){	
			$lastLogin=commonTimeFormat(true,$dataSet['lastLogin']);	
			$ip=$dataSet['ip'];
			$Member = commonGetMemberDetails($HTTP_POST_VARS[loginName]);
			if($Member[locked]){//account locked?
				commonDisplayError($Language['AccountLocked'],$Language['AccountLockedMessage']);						
			}
			else{
				if($Document[checkBannedIPs])//is member banned?
					checkBannedIP()?commonDisplayError($Language['BannedIP'],$Language['Bannedexplained']):$g=1;	
				$expire = time() +  $sessionDuration;
				setCookie("loginName", $HTTP_POST_VARS[loginName], $expire);
				setCookie("passwd", $passwd, $expire);
		
 				commonMemberNavigation();
				commonLogMemberDetails();			

				if($topicId){ //if forums is for members only and access through an href
					include_once("$GlobalSettings[includesDirectory]/topics.php");
				}
				else if($forumId){ //if forums is for members only and access through an href
					include_once("$GlobalSettings[includesDirectory]/forums.php");			
				}
				else if(newMessages($Member)==1){ //go to messages if user's latest message is unread
					$Document['msg'] = trim($ip)?"$Language[Lastlogin]: $lastLogin - $ip":$Language['Firsttimelogin'];
					include("$GlobalSettings[includesDirectory]/messages.php");	
				}
				else{
					$Document['quickLogin'] = trim($ip)?"$Language[Lastlogin]: $lastLogin - $ip":$Language['Firsttimelogin'];
					include("$GlobalSettings[includesDirectory]/boards.php");	
				}
			}	
			if($GlobalSettings[LoginSpamGuard]){
				$fileName=$GlobalSettings[SpamGuardFolder] . "/" . substr($sessionId,10,10);
				if(file_exists($fileName))
					unlink($fileName);
				$sql="delete from {$Global_DBPrefix}SpamGuard where sessionId ='$sessionId'";
				$fetchedData=mysql_query($sql);

				commonClearSpamGuard();
			}
					
		}		
		else{// display advanced login screen
			if($GlobalSettings[LoginSpamGuard])
				$Document['SpamGuardImage']=commonGetSpamGuard(session_Id(),2);
			include_once("$GlobalSettings[templatesDirectory]/login.php");
			include_once("$GlobalSettings[templatesDirectory]/password.php");
			$Document['contents'] = getLoginFormHTML(true,$Document[SpamGuardImage]);
		}
	}
}
else{
	include_once("$GlobalSettings[templatesDirectory]/login.php");
	include_once("$GlobalSettings[templatesDirectory]/password.php");
	$Document['contents'] = getLoginFormHTML(false,$Document[SpamGuardImage]);
}

//  Get possible session duration time listing as select options
//  Parameter: CurrentSessionTime(integer)
//  Return: String(session lengths listing)
function durationListing($chosen){
	global $Language;
	$durations=array(3600=>"$Language[onehour]",86400=>"$Language[oneday]",604800=>"$Language[oneweek]",2592000=>"$Language[onemonth]");
	while (list ($id, $desc) = each ($durations)) {
		$selected=$id==$chosen?" SELECTED":"";
    	$listing .="<OPTION VALUE=\"$id\"$selected>$desc</OPTION>";		
	}
	return $listing;
}//durationListing

//  Check if user's ip is in the banned list
//  Return:  Integer(user banned?)
function checkBannedIP(){
	global $GlobalSettings,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$ips = explode(".",getenv('REMOTE_ADDR'));
	$sql="select bannedId from {$Global_DBPrefix}BannedIPs where ip='$ips[0].$ips[1].$ips[2].$ips[3]' or ip='$ips[0].$ips[1].$ips[2].*' or ip='$ips[0].$ips[1].*'";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	return mysql_num_rows($fetchedData);
}//checkBannedIP
	
//  Check is the latest message is unread
//  Parameter: Array(Member details)
//  Return: Integer(Number of new,unread messages)
function newMessages($Member){
	global $GlobalSettings,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select status from {$Global_DBPrefix}Messages where ReceiverId=$Member[memberId] order by messageId desc limit 1";
	$fetchedData=mysql_query($sql) or commonLogError($sql,false);
	$dataSet = mysql_fetch_array($fetchedData);
	return $dataSet[status];
}//checkBannedIP


?>