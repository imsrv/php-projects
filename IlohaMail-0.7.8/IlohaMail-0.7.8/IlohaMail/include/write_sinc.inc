<?
/////////////////////////////////////////////////////////
//	
//	include/write_sinc.inc
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		Shell for write_sinc.backend.inc.
		Gets config from ../conf/conf.inc

********************************************************/        

include("../conf/conf.inc");

include("../include/write_sinc.".$backend.".inc");

/**** Backend agnostic code ***/
if (empty($error)){
	$uploadDir = "../uploads";
	if (!is_dir($uploadDir)) $error .= "Invalid uploads directory<br>\n";
	else{
		$uploadDir = $uploadDir."/".strtolower($user_name).".".strtolower($host);
		if (!is_dir($uploadDir)) mkdir($uploadDir, 0700);
	}
	if (!is_dir($uploadDir)) $error .= "Invalid uploads directory<br>\n";
}

?>
