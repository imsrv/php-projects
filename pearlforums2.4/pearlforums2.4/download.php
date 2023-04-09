<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File: 	fetchimage.php - fetch spamguard image.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

	include("settings.php"); 
	include_once("$GlobalSettings[includesDirectory]/functions.php");
	list($fileName,$ext)=preg_split("/\./",$f);
	$folder=commonGetAttachmentFolder($id);

	if($case=='m'){
		$path=$GlobalSettings['messageAttachmentPath'];
	}
	else if($case=='r'){
		$path=$GlobalSettings['attachmentPath'];
		$f=$id . "." . $t;
	}

	$file= $path . "/$folder/" . $f;
	if(file_exists($file)){	
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$f");

		$fd = fopen ($file, "rb");
		fpassthru($fd);
		fclose ($fd);
		
		if($case=='r'){//update download count
			$dataConnection = mysql_connect($GlobalSettings[DBServer], $GlobalSettings[DBUser], $GlobalSettings[DBPassword]) or commonDisplayError("Databaseerror","Unable to connect");
			mysql_select_db($GlobalSettings[DBName]) or commonDisplayError("Databaseerror","Unable to connect");
			$sql="update {$GlobalSettings[DBPrefix]}Attachments set TimesDownload=TimesDownload + 1 where attachmentId=$aid";
			$fetchedData=mysql_query($sql);	
		}
	}
	else{
		print "<script>alert('File does not exist or removed.');history.back();</script>";
	}
?>
 