<?php
require_once("include/vars.php");
require_once("include/db.php");
require_once("include/functions.php");


$qry="SELECT conf_value FROM ".$db->tb("configuration")." WHERE conf_name='AUTO_FILE_DELETE'";
$db->query($qry);
$row=$db->getrow();
if($row[0]=="Yes")
{
	$now=time();
	$qry="SELECT dir, file_name FROM ".$db->tb("fileinfo")." WHERE expire_time<$now";
	$db->query($qry);
	while($row=$db->getrow())
	{
		@unlink("uploads/".$row[1]."/".$row[2]);
		@rmdir("uploads/".$row[1]);
	}
	$qry="DELETE FROM ".$db->tb("fileinfo")." WHERE expire_time<$now";
	$db->query($qry);
}



$err=array();
if(count($_POST)>0)
{
	$media=$_REQUEST["media"];
	$upfile=$_FILES[$media]['name'];
	$upfile=trim($upfile);
	$emailto=trim($_REQUEST["emailto"]);
	$emailfrom=trim($_REQUEST["emailfrom"]);
	$message=trim($_REQUEST["message"]);
	if(empty($emailto)) $err[]="Recipient's emailid is not specified.";
	if(empty($upfile)) $err[]="Browse a file to upload.";
	
	if(count($err)==0)
	{
		$qry="SELECT conf_value FROM ".$db->tb("configuration")." WHERE conf_name='MAX_SIZE'";
		$db->query($qry);
		$row=$db->getrow();
		$sizelmt=((int)$row[0])*1000;
		
		
		$qry="SELECT conf_value FROM ".$db->tb("configuration")." WHERE conf_name='MIME_TYPES'";
		$db->query($qry);
		$row=$db->getrow();
		if($row[0]=="") $mimearr="";
		else $mimearr=explode(",",$row[0]);
		
		require_once("include/uploader.php");		
		
		do
		{
			$key=getRanID(20);
			$qry="SELECT COUNT(*) FROM ".$db->tb("fileinfo")." WHERE idkey='$key'";
			$db->query($qry);
			$row=$db->getrow();			
			
		}while($row[0]);
		
		do
		{
			$dirkey=getRanID(20);
			$qry="SELECT COUNT(*) FROM ".$db->tb("fileinfo")." WHERE dir='$dirkey'";
			$db->query($qry);
			$row=$db->getrow();			
		}while($row[0]);
		
		
		mkdir("uploads/$dirkey");
		chmod("uploads/$dirkey",0777);
		$uploader = new MediaUploader("uploads/$dirkey", $mimearr, $sizelmt);
		//$uploader->setTargetFileName($row[0].".jpg");
		if ($uploader->fetchMedia($media))
		{
			if(!$uploader->upload()) 
			{
				rmdir("uploads/$dirkey");	
				$err[] = $uploader->getErrors();
			}	
		}
		else 
		{
			rmdir("uploads/$dirkey");
			$err[]=sprintf("Failed fetching file '%s'", $upfile);			
		}
		
		if(count($err)==0)
		{	
			$qry="SELECT conf_optional, conf_value FROM ".$db->tb("configuration")." WHERE conf_name='MAX_TIME'";
			$db->query($qry);
			$row=$db->getrow();
			$maxtime=$row[0];
			$maxtimeval=$row[1];
		
		
			$qry="SELECT conf_optional, conf_value FROM ".$db->tb("configuration")." WHERE conf_name='MAX_COUNT'";
			$db->query($qry);
			$row=$db->getrow();
			$maxcount=$row[0];
			$maxcountval=$row[1];
			
			if(empty($emailfrom))
			{
				//$headers = "From: $email <$name>\nMIME-Version: 1.0\nContent-Type: text/html; charset=ISO-8859-1\nX-Mailer: PHP \n";
				$headers = "From: Delivery@".SITE_NAME.".com <Delivery@".SITE_NAME.".com>\nMIME-Version: 1.0\nContent-Type: text/html; charset=ISO-8859-1\nX-Mailer: PHP\n";
				$subject=SITE_NAME." Delivery Notification: ".$uploader->getSavedFileName();
				$msg="Hello from ".SITE.",<br>
				You've got a file called \"".$uploader->getSavedFileName()."\" (".sprintf("%.2f",($uploader->getMediaSize()/1024))." KB) 
				waiting for download.<br>You can click on the following link to retrieve your file.
				The link will expire in $maxtime and will be available for $maxcount 
				downloads.<br>	Regular link (for all web browsers):
				<a href=\"".HostURL()."download.php?id=$key\" target=\"_blank\">".HostURL()."download.php?id=$key</a><br>
				This email was automatically generated, please do not reply to it. For 
				any inquiries, feel free to email <a href=\"mailto: support@".SITE_NAME.".com\">support@".SITE_NAME.".com</a><br>
				The ".SITE_NAME." Team";		
				if(empty($message)) $msg.="<br>Additional Message:<br>$message";
				@mail($emailto, $subject, "<font face=Tahoma size=2>".$msg."</font>", $headers);		
			}
			else
			{
				$headers = "From: $emailfrom <$emailfrom>\nMIME-Version: 1.0\nContent-Type: text/html; charset=ISO-8859-1\nX-Mailer: PHP\n";
				$subject=SITE_NAME." Delivery Notification: ".$uploader->getSavedFileName();
				$msg="Hello from ".SITE.",<br>
				You've got a file called \"".$uploader->getSavedFileName()."\" (".sprintf("%.2f",($uploader->getMediaSize()/1024))." KB) 
				from $emailfrom waiting for download.<br>You can click on the following link to retrieve your file.
				The link will expire in $maxtime and will be available for $maxcount 
				downloads.<br>	Regular link (for all web browsers):
				<a href=\"".HostURL()."download.php?id=$key\" target=\"_blank\">".HostURL()."download.php?id=$key</a><br>
				This email was automatically generated, please do not reply to it. For 
				any inquiries, feel free to email <a href=\"mailto: support@".SITE_NAME.".com\">support@".SITE_NAME.".com</a><br>
				The ".SITE_NAME." Team";		
				if(empty($message)) $msg.="<br>Message from $emailfrom:<br>$message";
				@mail($emailto, $subject, "<font face=Tahoma size=2>".$msg."</font>", $headers);
				
				
				$headers = "From: Delivery@".SITE_NAME.".com<Delivery@".SITE_NAME.".com> \nMIME-Version: 1.0\nContent-Type: text/html; charset=ISO-8859-1\nX-Mailer: PHP\n";
				$subject=SITE_NAME." Notification Sent: ".$uploader->getSavedFileName();
				$msg="Hello from ".SITE.",<br>
				Your file called \"".$uploader->getSavedFileName()."\" (".sprintf("%.2f",($uploader->getMediaSize()/1024))." KB) 
				was sent to $emailto.<br>Please keep the following link for your records in case your recipient 
				misplaces it. The link will expire in $maxtime and will be available for 
				$maxcount downloads.<br>	Regular link (for all web browsers):
				<a href=\"".HostURL()."download.php?id=$key\" target=\"_blank\">".HostURL()."download.php?id=$key</a><br>
				This email was automatically generated, please do not reply to it. For 
				any inquiries, feel free to email <a href=\"mailto: support@".SITE_NAME.".com\">support@".SITE_NAME.".com</a><br>
				The ".SITE_NAME." Team";		
				if(empty($message)) $msg.="<br>Additional Message:<br>$message";
				@mail($emailfrom, $subject, "<font face=Tahoma size=2>".$msg."</font>", $headers);				
			}
			$qry="INSERT INTO ".$db->tb("fileinfo")."(idkey,dir,mime_type,file_name,size,upload_time,expire_time,max_dwnld,recipient,sender) VALUES('$key','$dirkey','".$uploader->getMediaType()."','".$uploader->getSavedFileName()."',".$uploader->getMediaSize().",".time().",".(time()+($maxtimeval*86400)).",".$maxcountval.",'$emailto','$emailfrom')";
			$db->query($qry);
			$newid=$db->get_insert_id();
			
			$qry="SELECT conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='DAILY_TRANSFER'";
			$db->query($qry);
			$row=$db->getrow();
			if($row[0]==date("d-m-Y"))
				$qry="UPDATE ".$db->tb("configuration")." SET conf_value=conf_value+".$uploader->getMediaSize()." WHERE conf_name='DAILY_TRANSFER'";
			else 
				$qry="UPDATE ".$db->tb("configuration")." SET conf_value=".$uploader->getMediaSize().", conf_optional='".date("d-m-Y")."' WHERE conf_name='DAILY_TRANSFER'";	
			$db->query($qry);
			
			//print date("Y-m-d H:i:s");
			redirect("success.php?id=$newid");
		}
	}
}

$qry="SELECT conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='MAX_SIZE'";
$db->query($qry);
$row=$db->getrow();
$maxsize=$row[0];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=SITE_NAME?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="script.js"></script>
</head>

<body>
<div align="center">
<table width="794" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #FFFFFF; ">
  <tr>
    <td width="792"><?php
	require_once("header.php");
	?></td>
  </tr>
  <tr>
    <td valign="center"><div align="center">
      <table width="60%" border="0">
        <tr>
          <td><div align="center">
            <table width="100%" border="0" align="center">
              <tr>
                <td><div id="table1" style="visibility: hidden; display: none">
                    <table width="100%" border="0" cellpadding="2" cellspacing="0">
                      <tr>
                        <td><H4 class="ltxt">
                            <?=SITE?>
                            <br>
                            <font size="2">Sending Your File. Please Stand By...</font></H4>
                        </td>
                      </tr>
                      <tr>
                        <td>                          <!-- <iframe src="progress.html"  frameborder="0" marginWidth=0 marginHeight=0 scrolling="auto" width="100%" height="5"></iframe> -->                          <img src="images/sending_progress.gif" width="150" height="5"></td>
                      </tr>
                      <tr>
                        <td class="ltxt"><font size="2"><B>Note:</B> Don't close 
						this page or browse away while the progress 
						bar is being displayed above. You'll see a confirmation 
						screen when your file has been successfully sent. Keep 
						in mind that a one megabyte (1MB) file can take 1 to 5 
						minutes to send depending on your connection speed.</font></td>
                      </tr>
                    </table>
                  </div>
                    <br>
                    <div id="table2SD"></div>
                    <div id="table2" style="visibility: visible; display: inline">
                      <div align="center">
                        <table width="95%" border="0" cellpadding="2" cellspacing="0" class="ltxt" id="table2">
                          <form action="" method="post" onSubmit="return isUpFormOk(this)" enctype="multipart/form-data">
                            <?php
					if(count($err)>0)
					{
				?>
                            <tr>
                              <td><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                                <?php 
				  		foreach($err as $errmsg)
						print "<li>$errmsg</li>";
						?>
                              </font></td>
                            </tr>
                            <?
					}
				?>
                            <tr>
                              <td><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
								Enter your recipient's email address, choose a 
								file to store on Our server, click on 
								Submit button to send a link. <a href="privacy.php">
								Your privacy</a> is guaranteed.</font></p>
                                <p>&nbsp;</p></td>
                            </tr>
                            <tr>
                              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
								<img border="0" src="images/step_1.gif">Recipient's 
								Email Address:<br>
                                    <input name="emailto" type="text" class="txtbox" id="emailto2" maxlength="50">
                              </font></td>
                            </tr>
                            <tr>
                              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
								<img border="0" src="images/step_2.gif">Select 
								File to Send (Up to
                                    <?=$maxsize?>
                  			): <br>
                  <input name="upfile" type="file" class="txtbox" id="upfile">
                              </font></td>
                            </tr>
                            <tr>
                              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
								Your Email Address (Optional):<br>
                                    <input name="emailfrom" type="text" class="txtbox" id="emailfrom" maxlength="50">
                              </font></td>
                            </tr>
                            <tr>
                              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
								Message to Recipient (Optional):<br>
                                    <textarea name="message" rows="4" class="txtarea" id="message"></textarea>
                              </font></td>
                            </tr>
                            <tr>
                              <td>
                                <div align="center">
                                  <img border="0" src="images/step_3.gif">
                                  <input name="Submit" type="submit" class="button" value="Send It!">
                                  <input name="media" type="hidden" id="media" value="upfile">
                                </div></td>
                            </tr>
                          </form>
                        </table>
                      </div>
                    </div>
                </td>
              </tr>
            </table>
          </div></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td>
      <?php
	require_once("footer.php");
	?>
    </td>
  </tr>
</table>
</body>
</html>
