<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
/*
THIS LIBRARY IS VERY CRUCIAL TO MAX-EMAIL'S SECURE OPERATION!
UPON EDITING YOU ACCEPT THAT MAX-EMAIL's SECURITY MAY BE SERIOUSLY JEOPARDISED.
EDITING OF THIS LIBRARY IS NOT RECOMMENDED, UNLESS YOU FULLY UNDERSTAND IS FUNCTIONING!!!
*/


//this piece will be executed every single time a page in the Max-eMail admin is loaded!
//It checks that there is a login valid and if there isnt will present the user with a login form!

//check that we do have atleast one admin!
if(mysql_num_rows(mysql_query("SELECT * FROM admins WHERE Active='1'"))<1 && $QUERY_STRING!="NEWADMIN"){
	header("Location:index.php?NEWADMIN");
	exit;
}


if($QUERY_STRING=="LOGOUT"){
if($AdminAuthType=="htaccess"){
 			//ht type authentication..
    		echo 'You must close all browser windows to successfully logout of Max-eMail..';
 }else{
          	//retrieve the username and password.
          	     setcookie("username", "XX", time()-3600);
			     setcookie("password", "XX", time()-3600);
				 header("Location:index.php");
}
exit;
}


if($QUERY_STRING=="NEWADMIN"){
	include "../libraries/newadmin.inc.php";
	exit;
}

if($QUERY_STRING=="LOGINNOW"){
     setcookie("username", $username, time()+$AdminLoginTime);
	 $password=md5($password);
     setcookie("password", $password, time()+$AdminLoginTime);
	 header("Location:index.php");
exit;
}

if($AdminAuthType=="htaccess"){
 			//ht type authentication..
    		$username=$PHP_AUTH_USER;
    		$password=$PHP_AUTH_PW;
			$password=md5($password);
 }else{
          	//retrieve the username and password.
          	$username=$HTTP_COOKIE_VARS[username];
          	$password=$HTTP_COOKIE_VARS[password];
 
}

//now well check if its valid!
$AdminData=mysql_fetch_array($ai=mysql_query("SELECT * FROM admins WHERE AdminUsername='$username' && AdminPassword='$password'"));

if(mysql_num_rows($ai)>0){
	$AdminID=$AdminData[AdminID];
	//update last login!
		if($AdminData[LastLoggedIN]==0){
			mysql_query("UPDATE admins SET LastLoggedIN='".time()."' WHERE AdminID='$AdminID'");
			include "../libraries/firstlogin.inc.php";
			exit;
		}else{
			//check the login is not to old!
			$timelogged=time()-$AdminData[LastLoggedIN];
			if($timelogged>$AdminLoginTime){
				include '../libraries/login.inc.php';
			}
			mysql_query("UPDATE admins SET LastLoggedIN='".time()."' WHERE AdminID='$AdminID'");
		}
		

}else{
	include '../libraries/login.inc.php';
	exit;
}

//check that the account is active!
if($AdminData[Active]!=1){
echo 'Your admin account has been deactivated, please contact your system administrator to get your account reactivated. Thanks!';
exit;
}

//we now need to check if this admin needs to change their password!
			$ad_info=AdminInfo($AdminID);
			$gr_info=AdminGroupInfo($AdminID);
		
		//are they making a pword change!
		if($QUERY_STRING=="CHANGEPW"){
			if($ad_info[AdminPassword]==md5($oldpword) && $newp1==$newp2 && strlen($newp1)>=$MinPassLength && $newp1!=$oldpword){
				$newp=md5($newp1);
				mysql_query("UPDATE admins SET AdminPassword='$newp', LastChangedPassword='".time()."' WHERE AdminID='$AdminID'");
				header("Location: index.php");	
			}else{
				include '../libraries/changepw.inc.php';	
			}
		}
		
		//number of days since the pword was last changed!
		$timestampgap=time()-$ad_info[LastChangedPassword];
		$days=round($timestampgap/86400);
		//do they need to change it!		
		if($days>($gr_info[PasswordChangeGap]+1) || $ad_info[LastChangedPassword]==0){
			include '../libraries/changepw.inc.php';
			exit;
		}

//if the script is still executing its all sweet!


function AdminInfo($AdminID){
	$admin_info=mysql_fetch_array(mysql_query("SELECT * FROM admins WHERE AdminID='$AdminID'"));
	return $admin_info;
}


function AdminGroupInfo($AdminID){
	$AdminInfo=AdminInfo($AdminID);
	$GroupInfo=mysql_fetch_array(mysql_query("SELECT * FROM admin_groups WHERE AdminGroupID='".$AdminInfo[AdminGroupID]."'"));
	return $GroupInfo;
}



function CanPerformAction($action){
	GLOBAL $AdminID;
	$GroupInfo=AdminGroupInfo($AdminID);
	//check if the action is in this groups privelages!
	if(mysql_num_rows(mysql_query("SELECT * FROM admin_group_privelages WHERE AdminGroupID='".$GroupInfo[AdminGroupID]."' && Action='$action'")) || $GroupInfo[SuperUser]==1){
	return 1;
	}else{
	return 0;
	}
		
}



?>