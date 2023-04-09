<?
/* Nullified by WDYL-WTN */
	if ($_FILES['filename']['name']!=""){
		require("include/everything.php");
		session_register("UserID");
		mysql_connect( $Host, $User, $Password ) or die ( 'Unable to connect to server.' );
    	mysql_select_db( $Database )   or die ( 'Unable to select database.' );
		$tool1 = mktime();
		copy($_FILES['filename']['tmp_name'], "../temp/$tool1.txt") or die ("Can't upload image");
		$fp = @fopen("../temp/$tool1.txt", "r");
			$t = "";
		while ($dat = @fgets($fp,1024)){
			$dat = str_replace(" ","",$dat);
			$m = explode("|",$dat);
			$r = mysql_query("select * from subscribers where subscribers_email='$m[1]' and subscribers_user_id='$UserID'");
			if (mysql_numrows($r)==""){
				mysql_query("insert into subscribers values('','$m[0]','$m[1]','$UserID','0','$HTTP_REFERER','1',NOW())");
					
			}	
		}
	@fclose($fp);
	unlink("../temp/$tool1.txt");
	header("Location: prospects_active.php");
	}
	
	header("Location: prospects_active.php");
?>
