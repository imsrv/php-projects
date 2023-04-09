<?
/////////////////////////////////////////////////////////
//	
//	source/login.php
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
	FILE: source/login.php
	PURPOSE:
		Contrary to what the name suggests, this file is loaded at logoff time.
		Includes include/session_close.inc to clean up session data.
	PRE-CONDITIONS:
		$user - Sessiono ID;
	POST-CONDITIONS:
		Should clean all session specific information from records, including cached password.
	COMMENTS:
		For alternate data back-ends, modify include/session_close.inc instead of this file.
********************************************************/
?>
<HTML>
<BODY>
<?
include("../include/super2global.inc");
if ($logout==1){
		echo "<center><p><br><br><font size=+1><b>Log Out...</b></font></center>";
		$do_not_die = true;
		include("../include/session_auth.inc");
		include("../include/icl.inc");
		
		//clean up cache on POP3
		iil_ClearCache($loginID, $host);
		
		//delete any undeleted attachments
		$uploadDir = "../uploads/".$loginID.".".$host;

		if (is_dir($uploadDir)){
			if ($handle = opendir($uploadDir)) {
				while (false !== ($file = readdir($handle))) { 
					if ($file != "." && $file != "..") { 
						$file_path = $uploadDir."/".$file;
						//echo $file_path."<br>\n";
						unlink($file_path);
					} 
				}
				closedir($handle); 
			}
		}	
		
		
		//log entry
		$log_action = "log out";
		$user_name = $loginID;
		include("../include/log.inc");
		
		//close session
		include("../include/session_close.inc");
        
        include("../conf/login.inc");
        if (empty($logout_url)) $logout_url = "index.php";
		?>
		<script>
			parent.location="<?=$logout_url?>";
		</script>
		<?
}

?>
</BODY></HTML>
