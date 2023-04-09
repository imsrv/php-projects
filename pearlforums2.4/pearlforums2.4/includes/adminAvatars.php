<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminAvatars.php - Process all actions related to 
//                  avatars in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminAvatars.php");
$Document[contentWidth]="80%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Avatar";
$exe();	

//  Update avatar
function updateAvatar(){
	global $Language,$Document,$GlobalSettings,$VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(is_uploaded_file($userfile)) { //if file uploaded
		$fileUpload=true;
		list($oldName,$oldExt)=preg_split("/\./",$fileName);		
		list($newName,$newExt)=preg_split("/\./",$userfile_name);
		$newExt=strtolower($newExt);  
		if (!in_array ($newExt, $Document[avatarTypes])){
    		$isError=true;
			$errorMsg .= $Language['Acceptableavatartypes']  . implode(",",$Document[avatarTypes]);
		}
		if ($userfile_size > $Document[avatarSize] ) { 
			$isError=true;
			$errorMsg .= $Language['Fileexceedssize']; 
		} 
	}
	if(trim($name)==""){
		$isError=true;
		$errorMsg .= "$Language[Name] $Language[isblank]";		
	}
	if($isError){
		$Document['msg'] = $errorMsg;
	}
	else{
		if($fileUpload){
			$file="$Global_avatarsPath/$oldName.$newExt";					
			copy($userfile, $file);		
			if(strcmp ($oldExt, $newExt)<>0){//remove previous file if different extension uploaded
				unlink("$Global_avatarsPath/$oldName.$oldExt");
				$addSql=", fileName=\"$oldName.$newExt\" ";
			}
			$Document['msg'] = "$Language[Recordupdated].";				
		}
		$name=htmlspecialchars($name);
		$sql="update {$Global_DBPrefix}Avatars set name=\"$name\" $addSql where avatarId=$VARS[avatarId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] .= "  $Language[Recordupdated].";	
	}
	editAvatar();
}//updateAvatar

//  Edit avatar
function editAvatar(){
	global $Document,$GlobalSettings,$VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="select avatarId, name, fileName,status from {$Global_DBPrefix}Avatars where avatarId=$VARS[avatarId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[avatarId]){
		$VARS=$dataSet;
		$Document['contents'] .= getAvatarFormHTML("$Language[Edit] $Language[Avatar]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("$Language[Edit] $Language[Avatar]",$AdminLanguage[Retrievingrecordfailed]);
	}		
}//editAvatar

//  Delete avatar
function deleteAvatar(){
	global $Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$sql="delete from {$Global_DBPrefix}Avatars where avatarId=$VARS[avatarId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	if(mysql_affected_rows()>0){
		$Document['msg']="Avatar deleted";
		$file="$Global_avatarsPath/$VARS[fileName]";	
		if(file_exists($file))unlink($file);
	}	
	else{
		$Document['msg']="Deleting failed.  Please try again.";	
	}
	listAvatar();
}//deleteAvatar

//  Create new avatar.  Avatars created by this function are common avatars and can be used by all members. 
function createAvatar(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($name)==""){
		$isError=true;
		$errorMsg="$Language[Name] $Language[isblank]";
	}
	if(is_uploaded_file($userfile)) { //if file uploaded
		$junks=preg_split("/\./",$userfile_name);
		$ext=strtolower(array_pop($junks));  
		if (!in_array ($ext, $Document['avatarTypes'])){
    		$isError=true;
			$errorMsg .= $Language['Acceptableavatartypes'] . implode(",",$Document[avatarTypes]);
		}
		if ($userfile_size > $Document[avatarSize] ) { 
			$isError=true;
			$errorMsg .= $Language['Fileexceedssize']; 
		} 
	}
	else{
		$isError=true;
		$errorMsg .=  $Language['Fileuploadfailed']; 
	}
	if($isError){
		$Document['msg'] = $errorMsg;
		$Document['contents'] .= getAvatarFormHTML("$AdminLanguage[CreateNewAvatar]","Create");	
	}
	else{
		$fileName=commonTimestamp() . "." . $ext; //unique file name
		$name=htmlspecialchars($name);
		$sql="insert into {$Global_DBPrefix}Avatars (name,fileName,memberId,status) VALUES (\"$name\",\"$fileName\",0,1)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$Document['msg']="$name created";
			$file="$Global_avatarsPath/$fileName";					
			copy($userfile, $file);			
			listAvatar();
		}
		else{
			$Document['msg'] = $Language[Insertfailed];
			$Document['contents'] .= getAvatarFormHTML("$AdminLanguage[CreateNewAvatar]","Create");			
		}
	}
}//createAvatar

//  Get new avatar form
function newAvatar(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage;		
	$Document['contents'] .= getAvatarFormHTML("$AdminLanguage[CreateNewAvatar]","Create");	
}//newAvatar

//  List all available avatars
function listAvatar(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$listLimit=5;
	$page=$VARS['page']==""?1:$VARS['page'];
	if(trim($Document['msg'])){
		$Document['contents'] .= commonEndMessage(0,$Document['msg']);
	}
	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	$addSql =trim($VARS[searchText])!=""?"where avatar.name like \"%$VARS[searchText]%\" ":"";
	
	$fromNumber=($page -1)* $listLimit;
	$sql="select avatar.avatarId,avatar.name,avatar.fileName,avatar.memberId,member.loginName from {$Global_DBPrefix}Avatars as avatar left join {$Global_DBPrefix}Members as member on (member.memberId=avatar.memberId) $addSql order by avatar.avatarId desc limit $fromNumber,$listLimit";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getAvatarRowHTML($dataSet);		
		$lastAlpha=$dataSet[name];
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0)
		$Document['contents'] .= $page>1?commonEndMessage(4,$Language['Endoflisting']):commonEndMessage(4,"$AdminLanguage[Noavatarsfound]");
	
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$listLimit){
		$page++;
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=avatars&action=list&page=$page&searchText=$VARS[searchText]\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext(0,$previous,$next);
	$Document['contents'] .= "<BR />";
}//listAvatar
 
?>