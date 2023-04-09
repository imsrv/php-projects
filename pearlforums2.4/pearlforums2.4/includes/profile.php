<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    profile.php - Process actions related to members' own profiles.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/profile.php");
$action=$VARS['action']==''?"view":$VARS['action'];
$exe="{$action}Profile";

$exe();	

//  Update member's profile
function updateProfile(){
	global $Document,$GlobalSettings,$Member,$VARS,$HTTP_COOKIE_VARS,$Language,$userfile,$userfile_name,$userfile_size;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	
	if(!$Member['memberId'])
		commonDisplayError($Language[Profile],$Language[Accessdenied]);
		
	$passwd=commonEncryptPassword($passwd);
	if(strcmp ($passwd, $HTTP_COOKIE_VARS['passwd'])<>0){ //verify password
		$isError=true;
		$errorFields['passwd']= "&laquo; " . $Language['Wrongpassword'];
	}		

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
	if(trim($newPassword)!=""){ //changing password
		if(strcmp ($newPassword, $confirmPassword)<>0){ //passwords match?
			$isError=true;
			$errorFields['confirmPassword']= "&laquo; " . $Language['doesntmatch'];
		}		
		if(strlen($newPassword) < 3 || strlen($newPassword) > 20){ //password length 20<>3 chars
			$isError=true;
			$errorFields['confirmPassword'] = "&laquo; " . $Language[invalid] . ". " . $Language['Allowablelength'];
		}	
		$newPassword = commonEncryptPassword($newPassword);
		$addSql = ", passwd=\"$newPassword\" "; 	
	}
	if(is_uploaded_file($userfile)) { //if photo/avatar uploaded
		$fileUpload=true;
		list($newName,$newExt)=preg_split("/\./",$userfile_name);
		$newExt=strtolower($newExt);  
		if (!in_array ($newExt, $Document[avatarTypes])){
    		$isError=true;
			$errorMsg .= $Language['Acceptableavatartypes'] . implode(",",$Document[avatarTypes]) . ". ";
		}
		if ($userfile_size > $Document[avatarSize] ) { 
			$isError=true;
			$errorMsg .= $Language['Fileexceedssize']; 
		} 
	}
	if($isError){
		$Document['msg'] = $Language['fieldsincomplete'] . " <BR /> " . $errorMsg . "<BR /><BR />";
		$VARS['avatarListing']=commonAvatarsListing($Member[memberId],$VARS['avatarId']);
		$Document['contents'] = commonTableHeader(true,0,300,"$Language[Profile]");
		$Document['contents'] .= getEditProfileHTML($VARS,$errorFields);
		$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");	
	}
	else{
		if($fileUpload){
			$sql="select avatarId, fileName from {$Global_DBPrefix}Avatars where memberId=$Member[memberId]";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			$dataSet = mysql_fetch_array($fetchedData);
			if(mysql_num_rows($fetchedData) >0){ //member's avatar exists
				if(file_exists("$Global_avatarsPath/$dataSet[fileName]"))
					unlink("$Global_avatarsPath/$dataSet[fileName]");
				$addSql .= ", avatarId=$dataSet[avatarId]";
				$sql="update {$Global_DBPrefix}Avatars set fileName=\"$Member[memberId].$newExt\" where memberId=$Member[memberId]";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);					
			}
			else{ // new avatar/photo
				$sql="insert into {$Global_DBPrefix}Avatars (name,fileName,memberId,status) values
					(\"$Member[name]\",\"$Member[memberId].$newExt\",$Member[memberId],1)";
				$fetchedData=mysql_query($sql) or commonLogError($sql,true);			
				$dbStatus=mysql_affected_rows();
				if(!$dbStatus){
					commonDisplayError("$Language[Avatar]",	$Language['Savingavatarfailed']);
				}
				else{
					$sql="select avatarId, fileName from {$Global_DBPrefix}Avatars where memberId=$Member[memberId]";
					$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
					$dataSet = mysql_fetch_array($fetchedData);
					$addSql .= ", avatarId=$dataSet[avatarId]";
				}
			}
			$file="$Global_avatarsPath/$Member[memberId].$newExt";					
			copy($userfile, $file);		
		}
		else{
			$addSql .= ", avatarId=$avatarId";
		}
		$name=htmlspecialchars($name);
		$email=htmlspecialchars($email);
		$url=htmlspecialchars($url);
		$bio=htmlspecialchars($bio);		
		$notifyAnnouncements=$notifyAnnouncements==""?0:$notifyAnnouncements;
		$hideEmail=$hideEmail==""?0:$hideEmail;
		
		$sql="update {$Global_DBPrefix}Members set name=\"$name\", email=\"$email\",url=\"$url\",hideEmail=$hideEmail,notifyAnnouncements=$notifyAnnouncements,bio=\"$bio\" $addSql where memberId=$Member[memberId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document[msg]=$Language[Recordupdated];
		viewProfile();
	}	
}//updateProfile

//  Display member's profile.  Administrators will see the lock/unlock and edit links from here
function viewProfile(){
	global $Document,$GlobalSettings,$Member,$Language,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$Document['contents'] = commonTableHeader(true,0,200,"$Language[Profile]");
	$loginName=$loginName==''?$Member['loginName']:$loginName;

	$sql="select member.memberId,member.GroupId,member.name,member.loginName,member.accessLevelId,member.email,member.bio,member.url,member.hideEmail,member.locked,
		member.dateJoined,member.lastLogin,member.notifyAnnouncements,member.ip,member.avatarId,member.totalPosts,
		avatar.fileName	from {$Global_DBPrefix}Members as member
		left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId) where loginName=\"$loginName\"";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	$Document['title']	= $dataSet[name];
	if($Member['accessLevelId']==1){//viewer is administrator
		$dataSet['lockLink'] =$dataSet['locked']?commonLanguageButton("adminunlockaccount","$Language[UnlockAccount]","?mode=admin&case=members&action=access&memberId=$dataSet[memberId]&locked=0",""):commonLanguageButton("adminlockaccount","$Language[LockAccount]","?mode=admin&case=members&action=access&memberId=$dataSet[memberId]&locked=1","");			
		$dataSet['editLink'] =commonLanguageButton("edit","$Language[Edit]","?mode=admin&case=members&action=edit&memberId=$dataSet[memberId]","");
	}
	$dataSet[adminPosition]= $dataSet[accessLevelId]<4?"<SPAN CLASS=GreyText>". $Language['MemberPositions'][$dataSet[accessLevelId]] . "</SPAN><BR />":"";	
	$dataSet['email']=$dataSet['hideEmail'] && $Member['accessLevelId']!=1?"":$dataSet['email'];
	$dataSet['editLink']=$Member['memberId']==$dataSet['memberId']?commonLanguageButton("edit","$Language[Edit]","?mode=profile&action=edit",""):$dataSet[editLink];
	$Document['contents'] .=getViewProfileHTML($dataSet);	
	$Document['contents'] .=commonTableFooter(true,0,"&nbsp;");	
}//viewProfile

//  Retrieve profile for editing, solely by the owner. 
function editProfile(){
	global $Document,$GlobalSettings,$Member,$Language;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$Document['contents'] = commonTableHeader(true,0,300,"$Language[Edit] $Language[Profile]");
	$Document['title'] = " $Language[Edit] $Language[Profile]";
	
	$sql="select member.memberId,member.groupId,member.name,member.loginName,member.bio,member.email,member.url,member.hideEmail,
		member.dateJoined,member.lastLogin,member.notifyAnnouncements,member.ip,member.avatarId,member.totalPosts, 
		avatar.fileName, avatar.memberId as avatarMemberId, groups.name as groupName from {$Global_DBPrefix}Members as member
		left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId)
		left join {$Global_DBPrefix}Groups as groups on (groups.groupId=member.groupId) 	
		where member.memberId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	if(mysql_num_rows($fetchedData)==0)
		commondisplayError($Language[Profile],$Language[Accessdenied]);
	$dataSet['avatarListing']=commonAvatarsListing($dataSet['memberId'],$dataSet['avatarId']);
	$Document['contents'] .= getEditProfileHTML($dataSet,$errorFields);	
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");	
}//editProfile
	
?>