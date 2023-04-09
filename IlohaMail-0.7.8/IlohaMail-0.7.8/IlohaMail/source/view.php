<?
/////////////////////////////////////////////////////////
//	
//	source/view.php
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	FILE: view.php
	PURPOSE:
		Display message part data (whether it be text, images, or whatever).  Decode as necessary.
		Sets HTTP "Content-Type" header as appropriate, so that the browser will (hopefully) know
		what to do with the data.
	PRE-CONDITIONS:
		$user - Session ID
		$folder - Folder in which message to open is in
		$id - Message ID (not UID)
		$part - IMAP (or MIME?) part code to view.

********************************************************/

include_once("../include/super2global.inc");
include_once("../include/nocache.inc");

if ((isset($user))&&(isset($folder))){
	include_once("../include/session_auth.inc");
	include_once("../include/icl.inc");
	
	$view_conn=iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if ($iil_errornum==-11){
		for ($i=0; (($i<10)&&(!$view_conn)); $i++){
			sleep(1);
			$view_conn=iil_Connect($host, $loginID, $password, $AUTH_MODE);
		}
	}
	if (!$view_conn){
		echo "failed\n".$iil_error;
		flush();
	}else{
		if (isset($source)){
			header("Content-Type: text/plain");
			iil_C_PrintSource(&$view_conn, $folder, $id, $part);
			//echo iil_C_FetchPartHeader($view_conn, $folder, $id, $part);
			//echo iil_C_PrintPartBody($view_conn, $folder, $id, $part);
		}else if ($show_header){
			header("Content-Type: text/plain");
			echo iil_C_FetchPartHeader($view_conn, $folder, $id, $part);
		}else{
				include("../include/mime.inc");
				
                // fetch relevant data (i.e. MIME structure, type codes, etc)
				$structure_str=iil_C_FetchStructureString($view_conn, $folder, $id);
				$structure=iml_GetRawStructureArray($structure_str);
				$type=iml_GetPartTypeCode($structure, $part);
				
				// structure string
				if ($show_struct){
					echo $structure_str;
					exit;
				}
				
                // format and send HTTP header
				if ($type==3){
      				header("Content-type: ".iml_GetPartTypeString($structure, $part)."; name=".iml_GetPartName($structure, $part));
					header("Content-Disposition: attachment; filename=".str_replace("/",".",iml_GetPartName($structure, $part)));
				}else if ($type==2){
					header("Content-Type: text/plain\n");
				}else if ($type!=-1){
					$charset=iml_GetPartCharset($structure, $part);
					$name=str_replace("/",".", iml_GetPartName($structure, $part));
					$header="Content-type: ".iml_GetPartTypeString($structure, $part);
					if (!empty($charset)) $header.="; charset=\"".$charset."\"";
					if (!empty($name)) $header.="; name=\"".$name."\"";
					header($header);
				}else{
                    if ($debug) echo "Invalid type code!\n";
                }
                if ($debug) echo "Type code = $type ;\n";

                // send actual output
				if ($print){
                    // straight output, no processing
					iil_C_PrintPartBody($view_conn, $folder, $id, $part);
					if ($debug) echo $view_conn->error;
				}else{
                    // process as necessary, based on encoding
					$encoding=iml_GetPartEncodingCode($structure, $part);
                    if ($debug) echo "Part code = $encoding;\n";

					if ($raw){
						iil_C_PrintPartBody($view_conn, $folder, $id, $part);
					}else if ($encoding==3){
                        // base 64
						if ($debug) echo "Calling iil_C_PrintBase64Body\n"; flush();
						iil_C_PrintBase64Body($view_conn, $folder, $id, $part);
					}else if ($encoding == 4){
                        // quoted printable
						$body = iil_C_FetchPartBody($view_conn, $folder, $id, $part);
                        if ($debug) echo "Read ".strlen($body)." bytes\n";
						$body=quoted_printable_decode(str_replace("=\r\n","",$body));
						echo $body;
					}else{
                        // otherwise, just dump it out
						iil_C_PrintPartBody($view_conn, $folder, $id, $part);
					}
					if ($debug) echo $view_conn->error;
				}
		}
		iil_Close($view_conn);

	}
}
?>