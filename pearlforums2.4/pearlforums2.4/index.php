<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File: 	index.php - Load settings, preferences and direct
//                  requests to other appropriate files through inclusion.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

	error_reporting (E_ALL ^ E_NOTICE); //report all, except for E_NOTICE
	
	include("settings.php"); 
	if($GlobalSettings['DBName']==''){header('location:install.php');}

	include("$Document[languagePreference]/lang.php");	
	
	extract ($GlobalSettings,EXTR_OVERWRITE);
	include_once("$includesDirectory/functions.php");
	include("$includesDirectory/initialize.php");

	$mode=$VARS['mode']==""?"boards":$VARS['mode'];
	include("$includesDirectory/$mode.php"); //Process request.  Filename corresponds to mode's value
	
	commonLogOnline();	
	
	include("$templatesDirectory/master.php"); //Master template
	
?>