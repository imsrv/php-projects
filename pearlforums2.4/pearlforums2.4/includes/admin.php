<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    admin.php - Load Admin template and links, direct requests 
//                  to other appropriate files through inclusion.  Administrators
//                  only and not accessible to global moderators or moderators.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

if($Member['accessLevelId'] !="1"){ //admin only
	commonDisplayError("Administration","Access denied.");
	exit;
}
include_once("$templatesDirectory/admin.php");
include_once("$Document[languagePreference]/adminLang.php");	

$case=$VARS['case']==''?"Main":ucfirst($VARS['case']);
$titles=array("Main"=>$AdminLanguage[Administration],"Settings"=>$AdminLanguage[Settings],"Boards"=>$Language[Boards],"Forums"=>$Language[Forums],"Members"=>$Language[Members],"Groups"=>$AdminLanguage[Groups],"Attachments"=>$Language[Attachments],"Polls"=>$AdminLanguage[Polls],"Avatars"=>$AdminLanguage[Avatars],"Smileys"=>$AdminLanguage[Smileys],"Emails"=>$AdminLanguage[EmailUtility],"Banned"=>$AdminLanguage[BannedIPs],"Sensored"=>$AdminLanguage[SensoredWords],"Reserved"=>$AdminLanguage[ReservedLoginNames],"Errorlogs"=>$AdminLanguage[ErrorLogs],"Backgrounds"=>$AdminLanguage[BackgroundImages],"Documentation"=>$AdminLanguage[Documentation],"Backupdatabase"=>$AdminLanguage[BackupDatabase]);
$case=="Settings"?"":$Document['title']=$titles[$case]; //leave document title as is if settings is called

$Document['contents'] = commonTableHeader(true,0,0,getAdminOpenTemplateHTML($Document['title']));

$case=="Main"?displayAdminMain():include_once("$includesDirectory/admin$case.php");

$Document['contents'] .= commonTableFooter(true,0,"<A HREF=$Document[mainScript]?mode=admin&case=documentation#$case>$Language[Help]</A>");

//  Admin entry page.  Get stats and check for file permissions on desinated writable folders
function displayAdminMain(){
	global $GlobalSettings,$Member,$Document,$AdminLanguage;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");

	if(file_exists("install.php")){
		$stat[removeInstall] = "<BR><STRONG>You should remove the install.php file if this forum is in production</STRONG><BR><BR>";
	}

	if(!is_writable($Global_attachmentPath)){
		$stat[msg] = "<BR>" . $Global_attachmentPath;
	}
	if(!is_writable("$Global_attachmentPath/messages")){
		$stat[msg] .= "<BR>" . $Global_attachmentPath . "/messages";
	}	
	if(!is_writable($Global_avatarsPath)){
		$stat[msg] .= "<BR>" . $Global_avatarsPath;
	}
	if(!is_writable($Global_smileysPath)){
		$stat[msg] .= "<BR>" . $Global_smileysPath;
	}
	if(trim($stat[msg])){
		$stat[msg]= $AdminLanguage[permissionalert] . $stat[msg];
	}
	
	$sql="select count(*) as membersCount from {$Global_DBPrefix}Members";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$stat[membersCount]=$dataSet[membersCount];

	$sql="select count(*) as topicsCount from {$Global_DBPrefix}Topics";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$stat[topicsCount]=$dataSet[topicsCount];

	$sql="select count(*) as postsCount from {$Global_DBPrefix}Posts";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	$stat[postsCount]=$dataSet[postsCount];

	//database size
	$sql="show table status from $Global_DBName";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		if (stristr(substr($dataSet[Name], 0, strlen($Global_DBPrefix)), $Global_DBPrefix))
			$stat[dbSize] += $dataSet[Data_length] + $dataSet[Index_length];		
	}
	$stat[dbSize] = number_format($stat[dbSize]/1024,1);
	
	$stat[phpVersion]=phpversion();
	$stat[mySQLVersion]=mysql_get_client_info();
	$Document['contents'] .= getAdminIndexHTML($stat);
}//displayAdminMain

?>