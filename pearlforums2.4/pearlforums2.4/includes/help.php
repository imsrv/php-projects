<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    help.php - Display members' help topics.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////
	$Document['title'] = $Language[Help];
	include_once("$Document[languagePreference]/help.php");	
	
	$Document['contents'] =commonTableHeader(true,0,300,$Language[Help]);
	$Document['contents'] .=getHelpContents();
	$Document['contents'] .=commonTableFooter(true,0,"&nbsp;");
?>