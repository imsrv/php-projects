<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    locale.php - Set local time offset.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////
	
include_once("$GlobalSettings[templatesDirectory]/locale.php");
$Document[contentWidth]=450;
$action=$VARS['action']==""?"entry":$VARS['action'];

$Document['contents'] = commonTableHeader(true,0,300,$Language[Localtime]);
$exe="{$action}Localization";
$exe();	
$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");
	
//  Get entry form
function entryLocalization(){	
	global $Document,$Language,$VARS;		
	extract($VARS,EXTR_OVERWRITE);

	$Document['contents'] .= getFormHTML(commonGetSubmitButton(false,"  $Language[Set]  ",""));
}//entryLocalization

//  Set local time
function setLocalization(){
	global $Document,$VARS;		
	extract($VARS,EXTR_OVERWRITE);

	$TimeOffset=$offset  . $hours;
	setcookie ("TimeOffset", $TimeOffset,time()+60*60*24*9365);	
	$Document['contents'] .= getDoneHTML($TimeOffset);
}//setLocalization
?>