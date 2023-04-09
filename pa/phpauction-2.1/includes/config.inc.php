<?

/*

   Copyright (c), 1999, 2000 - phpauction.org                  
   

   This program is free software; you can redistribute it and/or modify 
   it under the terms of the GNU General Public License as published by 
   the Free Software Foundation (version 2 or later).                                  

   This program is distributed in the hope that it will be useful,      
   but WITHOUT ANY WARRANTY; without even the implied warranty of       
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        
   GNU General Public License for more details.                         

   You should have received a copy of the GNU General Public License    
   along with this program; if not, write to the Free Software          
   Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
   

*/

	$SESSION_NAME = "PHPAUCTION_SESSION";
	session_name($SESSION_NAME);
	session_start();

   //-- This is the directory where passwd.inc.php file resides - requires ending slash
  	
  	$include_path = "./includes/"; 
  	#$include_path = "C:\\some\\path\\to\\includes\\"; 


  	//-- This is the directory where users pictures will be uploaded - requires ending slash
  	//-- Under Windows use something like C:\\path\\to\\you\\uploaddir\\

  	$image_upload_path = "/home/www/phpauction/uploaded/"; 
  	#$image_upload_path = "C:\\some\\path\\to\\uploaded\\"; 
  	$uploaded_path = "uploaded/"; 
  	#$uploaded_path = "uploaded\\"; 
  

	//--
  	$MAX_UPLOAD_SIZE = 100000;

	
	
	//-- This string is added to passwords before generating the MD5 hash
	//-- Be sure to never change it after the firt set up or 
	//-- your users passwords will not work
	
	$MD5_PREFIX = "put_here_along_and_unpredictable_string";
	
	
  	/*
  		This is the log file generated by cron.php - insert the complete
  		file name (including the absolute path).
  		If you don't want to generate a log file for cron activity simply
  		leave this line commented.
  	*/

  	#$logFileName = "/var/www/auctions/logs/cron.log"; 
  	#$logFileName = "C:\\path\\to\cron.log"; 

	/*
		Set this to TRUE if you want cron to generates HTML output
		BESIDES the cron file declared above. cron.php cannot generates
		only HTML output.
	*/
  	$cronScriptHTMLOutput = FALSE;


  	$expireAuction = 60*60*24*30; // time of auction expiration (in seconds)

  /*======================================================================
   *																							  *																	
   * Don't edit the code below unless you really know what you are doing  *
   *																							  *          															
   ======================================================================*/	

	//--
  if(strpos($PHP_SELF,"admin/")){
  	$password_file = "../".$include_path."passwd.inc.php";
  }else{
  	$password_file = $include_path."passwd.inc.php";
  }
  	
  	
  include($password_file);

  //-- Database connection

  if(!mysql_connect($DbHost,$DbUser,$DbPassword))
  {
  	$NOTCONNECTED = TRUE;
  }
  if(!mysql_select_db($DbDatabase))
  {
  	$NOTCONNECTED = TRUE;
  }
  
  #// RETRIEVE SETTINGS AND CREATE SESSION VARIABLES FOR THEM
	if(strpos($PHP_SELF,"admin/"))
	{
		include "../includes/fonts.inc.php";
		include "../includes/fontcolor.inc.php";
		include "../includes/fontsize.inc.php";
	}
	else
	{
		include "includes/fonts.inc.php";
		include "includes/fontcolor.inc.php";
		include "includes/fontsize.inc.php";
	}
  	
  	$query = "select * from PHPAUCTION_settings";
  	$RES = @mysql_query($query);
  	if($RES)
  	{
  		$SETTINGS = mysql_fetch_array($RES);

  		$std_font = "<FONT FACE=".$FONTS[substr($SETTINGS[std_font],0,1)]." 
  					 SIZE=".$FONTSIZE[substr($SETTINGS[std_font],1,1)]." 
  					 COLOR=".$FONTCOLOR[substr($SETTINGS[std_font],2,1)].">";
  		if(substr($SETTINGS[std_font],3,1) == 1)
  		{
  			$std_font .= "<B>";
  		}
  		if(substr($SETTINGS[std_font],4,1) == 1)
  		{
  			$std_font .= "<I>";
  		}

  		$nav_font = "<FONT FACE=".$FONTS[substr($SETTINGS[nav_font],0,1)]." 
  					 SIZE=".$FONTSIZE[substr($SETTINGS[nav_font],1,1)]." 
  					 COLOR=".$FONTCOLOR[substr($SETTINGS[nav_font],2,1)].">";
  		if(substr($SETTINGS[nav_font],3,1) == 1)
  		{
  			$nav_font .= "<B>";
  		}
  		if(substr($SETTINGS[nav_font],4,1) == 1)
  		{
  			$nav_font .= "<I>";
  		}

  		$footer_font = "<FONT FACE=".$FONTS[substr($SETTINGS[footer_font],0,1)]." 
  					 SIZE=".$FONTSIZE[substr($SETTINGS[footer_font],1,1)]." 
  					 COLOR=".$FONTCOLOR[substr($SETTINGS[footer_font],2,1)].">";
  		if(substr($SETTINGS[footer_font],3,1) == 1)
  		{
  			$footer_font .= "<B>";
  		}
  		if(substr($SETTINGS[footer_font],4,1) == 1)
  		{
  			$footer_font .= "<I>";
  		}

  		$tlt_font = "<FONT FACE=".$FONTS[substr($SETTINGS[tlt_font],0,1)]." 
  					 SIZE=".$FONTSIZE[substr($SETTINGS[tlt_font],1,1)]." 
  					 COLOR=".$FONTCOLOR[substr($SETTINGS[tlt_font],2,1)].">";
  		if(substr($SETTINGS[tlt_font],3,1) == 1)
  		{
  			$tlt_font .= "<B>";
  		}
  		if(substr($SETTINGS[tlt_font],4,1) == 1)
  		{
  			$tlt_font .= "<I>";
  		}

  		$err_font = "<FONT FACE=".$FONTS[substr($SETTINGS[err_font],0,1)]." 
  					 SIZE=".$FONTSIZE[substr($SETTINGS[err_font],1,1)]." 
  					 COLOR=".$FONTCOLOR[substr($SETTINGS[err_font],2,1)].">";
  		if(substr($SETTINGS[err_font],3,1) == 1)
  		{
  			$err_font .= "<B>";
  		}
  		if(substr($SETTINGS[err_font],4,1) == 1)
  		{
  			$err_font .= "<I>";
  		}

  		$sml_font = "<FONT FACE=".$FONTS[substr($SETTINGS[sml_font],0,1)]." 
  					 SIZE=".$FONTSIZE[substr($SETTINGS[sml_font],1,1)]." 
  					 COLOR=".$FONTCOLOR[substr($SETTINGS[sml_font],2,1)].">";
  		if(substr($SETTINGS[sml_font],3,1) == 1)
  		{
  			$sml_font .= "<B>";
  		}
  		if(substr($SETTINGS[sml_font],4,1) == 1)
  		{
  			$sml_font .= "<I>";
  		}

  		session_name($SESSION_NAME);
  		session_register("SETTINGS","std_font");
  	}
  	
  	
  	#// PhpAdsNew includes
	if(strpos($PHP_SELF,"admin/"))
	{
		require("../phpAdsNew/config.inc.php"); 
 		require("../phpAdsNew/view.inc.php"); 
 		require("../phpAdsNew/acl.inc.php");  
 	}
 	else
 	{
		require("./phpAdsNew/config.inc.php"); 
 		require("./phpAdsNew/view.inc.php"); 
 		require("./phpAdsNew/acl.inc.php");  
 	}


  if(strpos($PHP_SELF,"admin/"))
  {
  	include("../includes/currency.inc.php");
  }
  else
  {
  	include("./includes/currency.inc.php");
  }

?>
