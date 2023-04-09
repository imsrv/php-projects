<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    register.php - Handle users' registration.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/register.php");
$Document['title'] = $Language['Registration'];	
extract($VARS,EXTR_OVERWRITE);
extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
if($action=="final"){
	$isError=false;
	if(trim($name=="")){ //full name is required
		$isError=true;
		$errorFields['name']= "&laquo; " . $Language['required'];
	}
	if(!commonValidateEmail($email)){ //validate email
		$isError=true;
		$errorFields['email']= "&laquo; " . $Language['invalid'];
		if(trim($email==""))
			$errorFields['email']= "&laquo; " . $Language['required'];
	}
	
	if(!validateLoginName($loginName)){//validate login name
		$isError=true;
		$errorFields['loginName']= "&laquo; " . $Language['invalid'];
		if(trim($loginName==""))
			$errorFields['loginName']= "&laquo; " . $Language['required'];
	}
	else{
		if(commonSensorWords($loginName,false)){		
			$isError=true;
			$errorFields['loginName']= "&laquo; " . $Language['SensoredWord'];
		}
	}
	//verify if email or login name is already in use
	$sql="select loginName, email from {$Global_DBPrefix}Members where loginName=\"$loginName\" or email=\"$email\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData)){
		if(strcasecmp ($loginName, $dataSet['loginName'])==0){
			$isError=true;
			$errorFields['loginName']= "&laquo; " . $Language['alreadytaken'];
		}
		if(strcasecmp ($email, $dataSet['email'])==0){
			$isError=true;
			$errorFields['email']= "&laquo; " . $Language['alreadyexist'];
		}
	}
	
	$sql="select username from {$Global_DBPrefix}ReservedUsernames where username=\"$loginName\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	if(strcmp ($loginName, $dataSet['username'])==0){
		$isError=true;
		$errorFields['loginName']= "&laquo; " . $Language['Reserved'];
	}
	if($GlobalSettings[RegistrationSpamGuard]){
		$sessionId= $_REQUEST["PHPSESSID"];
		if($sessionId==""){
			session_start();
			$sessionId = session_id();
		}	
		$sql="select sessionId from {$Global_DBPrefix}SpamGuard where sessionId='$sessionId' and code='$code'";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_num_rows($fetchedData)==0){
			$isError=true;
			$errorFields['code']= "&laquo; " . $Language['Verifycode'];
			$Language['Verify7digitcode']='';
		}
	}
	If($IAgree==""){ //must agree to terms of use
		$isError=true;
		$errorFields['IAgree'] = $Language['Mustagree'] . " &raquo;";
	}
		
	if($isError){ //return to registration form if error encountered
		$errorFields['fieldsincomplete'] = $Language['fieldsincomplete'] . "<BR /><BR />";
		if($GlobalSettings[RegistrationSpamGuard]){
			$image=commonGetSpamGuard(session_Id(),1);
		}
		$Document['contents']=getRegisterFormHTML($errorFields,$image);						
	}
	else{ //no errors, proceed
		$password=commonRandomString("",8);//no prefix, 8 random chars
		$encryptedPassword=commonEncryptPassword($password); 
		$groupId=0; //default to none
		$accessLevelId=4; //default to regular members (1=administrators, 2=global moderators)
		$avatarId=1; //default blank photo
		$now=time();
		$sql="insert into {$Global_DBPrefix}Members (groupId,accessLevelId,name,loginName,passwd,securityCode,email,url,hideEmail,dateJoined,lastLogin,notifyAnnouncements,ip,avatarId,totalPosts,locked) values ($groupId,$accessLevelId,\"$name\",\"$loginName\",\"$encryptedPassword\",\"$securityCode\",\"$email\",\"\",0,$now,$now,0,\"\",$avatarId,0,0)";
		$resultData=mysql_query($sql) or commonLogError($sql,true);
		$status=mysql_affected_rows();
		
		if($status > 0){							
			include_once("$Document[languagePreference]/registrationMessages.php");	
			$details[name]=$name;
			$details[email]=$email;
			$details[loginName]=$loginName;
			$details[password]=$password;
			$details[securityCode]=$securityCode;
			commonSendEMail("$name <$email>","$Language[Registration] - $Global_organization",getRegistrationEmailMessage($details));

			$Document['contents'] = commonTableHeader(true,0,200,$Language['Thankyou']);
			$Document['contents'] .= commonEndMessage(false,getRegistrationMessage());			
			$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");	
		}
		else{
			$Document['contents']=commonDisplayError($Language[Registration],$Language[Registrationfailed]); //global function
		}
		
		if($GlobalSettings[RegistrationSpamGuard]){
			$fileName=$GlobalSettings[SpamGuardFolder] . "/" . substr($sessionId,10,10);
			if(file_exists($fileName))
				unlink($fileName);
			$sql="delete from {$Global_DBPrefix}SpamGuard where sessionId ='$sessionId'";
			$fetchedData=mysql_query($sql);

			commonClearSpamGuard();
		}
	}
}
else{
	if($GlobalSettings[RegistrationSpamGuard]){
		$image=commonGetSpamGuard(session_Id(),1);
	}
	$Document['contents']=getRegisterFormHTML($errorFields,$image);				
}



//  Check if login name is in valid format
//  Parameter: LoginName(string)
//  Return:  boolean(true|false)
function validateLoginName($loginName){
	if(!ereg("^[a-z,A-Z,0-9]*$", $loginName) || strlen($loginName) > 20 || strlen($loginName)<3)
		return false;
	else
		return true;
}//validateLoginName

?>