<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    initialize.php - Make data connection and initialize 
//                  members' session values if logged in.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

$VARS=array_merge($HTTP_POST_VARS,$HTTP_GET_VARS);
if($PHP_SELF==""){//Registered global variables are turned off by web server.
	while(list($name, $value)=each($VARS))
    	$$name=$value;
  	$Document['mainScript'] = $HTTP_SERVER_VARS['PHP_SELF'];
	$GlobalSettings['boardPath'] = str_replace("/" . basename($HTTP_SERVER_VARS['PHP_SELF']),"",$HTTP_SERVER_VARS['PHP_SELF']);
	$GlobalSettings['serverName']= $HTTP_SERVER_VARS['SERVER_NAME'];
}

$dataConnection = mysql_connect($DBServer, $DBUser, $DBPassword) or commonDisplayError($Language['Databaseerror'],$Language[Unabletoconnect]);
mysql_select_db($DBName) or commonDisplayError($Language['Databaseerror'],$Language[Unabletoconnect]);

if($HTTP_COOKIE_VARS['loginName'] && $HTTP_COOKIE_VARS['passwd']){
	$Member = commonGetMemberDetails($HTTP_COOKIE_VARS['loginName']);
	commonMemberNavigation();
}
else{
	if($GlobalSettings[LoginSpamGuard] && $VARS['case']!="login"){
		$Document['SpamGuardImage']=commonGetSpamGuard(session_Id(),2);
	}
	if($Document[membersOnly]){
		$inaction=array("login","register","");
		if($VARS['mode'] =="logout"){
			//redirect to your own exit page
		}
		else if(!in_array($VARS[mode],$inaction)){
			commonPublicNavigation();	
			$Document[contents]=commonDisplayError($Language[Accessdenied], $Language[Youmustlogin] . "<BR><BR><BR>" . commonQuickLoginPanel($Document[SpamGuardImage]));
			include_once("$GlobalSettings[templatesDirectory]/master.php");
			exit;
		}
	}
	$Member['name']="<SPAN CLASS=GreyText>[$Language[Guest]]</SPAN>";
	commonPublicNavigation();		
}

$Document['footerLinks']=commonFooterLinks();


?>