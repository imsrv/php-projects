<?php
require_once("include/vars.php");
require_once("include/db.php");
require_once("include/functions.php");
$err=array();
session_start();
if(!isset($_SESSION["valid"])) $err[]="Sorry! Link expired...";
else
{
	$key=isset($_REQUEST["id"])?$_REQUEST["id"]:0;
	$qry="SELECT file_name, size, dir, mime_type,no_of_dwnld, expire_time, max_dwnld FROM ".$db->tb("fileinfo")." WHERE idkey='$key' AND link_status=1";
	$db->query($qry);
	//ob_start();
	if($db->getrownum()==0) $err[]="Link suspended or does not exists.";
	else
	{
		$myfile=$db->getrow();
		if($myfile[5]<time()) $err[]="File download time expired.";
		if($myfile[4]>=$myfile[6]) $err[]="File download for ".$myfile[4]." times. It can't be downloaded anymore";
	}
}
if(count($err)==0)
{
	$qry="UPDATE ".$db->tb("fileinfo")." SET no_of_dwnld=no_of_dwnld+1 WHERE idkey='$key'";
	$db->query($qry);
	$filetype = $myfile[3];
	if ($filetype == "" ) $filetype = "application/octet-stream";	
	

	//$dl_path=HostPath()."uploads/".$myfile[2]."/".$myfile[0];
	$dl_path="uploads/".$myfile[2]."/".$myfile[0];
	$fh = fopen( $dl_path, 'rb' );
	if ($myfile[1] && PARTIAL_TRANSFER && isset($_SERVER['HTTP_RANGE'])) 
	{
		// Support for partial transfers enabled and browser requested a partial transfer
		header("HTTP/1.1 206 Partial content\n");
		$start = preg_replace(array("/(\040*|)bytes(\040*|)=(\040*|)/","/(\040*|)\-.*$/"),array("",""),$_SERVER['HTTP_RANGE']);
		if ($myfile[1] < $start) 
		{
				header("HTTP/1.1 411 Length Required\n");
				echo "Trying to download past the end of the file. You have probably requested the wrong file. Please try again.";
		}
		$transfer_size = $myfile[1] - $start;
		header("Accept-Ranges: bytes");
		header("Content-Range: bytes ".$transfer_size."-".($myfile[1]-1)."/".$myfile[1]);
		header("Content-Length:".$transfer_size."\n");
		fseek($fh,$startat_byte);
	}
	else
	{
		header("HTTP/1.1 200 OK\n");
		if ( $myfile[1] )
			header("Content-Length: ".(string)($myfile[1]) );
	}
	
	//Print the http header
	header("Cache-control: private\n"); // fix for IE to correctly download files
	header("Pragma: no-cache\n");       // fix for http/1.0
	header("Content-Type: ".$filetype);
	header("Content-Disposition: attachment; filename=".$myfile[0]);
	header("Content-Transfer-Encoding: binary");
	if (NO_PASS_THRU)
	{
		if (SPEED_LIMIT != 0) 
		{
			$chunk = SPEED_LIMIT * 1024;
			while(!feof($fh)) 
			{
				echo fread($fh, $chunk);
				flush();
				sleep(1);
			}
		} 
		else 
		{
			while(!feof($fh)) 
			{
				echo fread($fh, 4096);
			}
		}
	} 
	else 
	{
		fpassthru($fh);
	}
	fclose($fh);
	
	//print ob_get_contents();
	//ob_end_clean();
}
else 
{
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
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #999999">
  <tr>
    <td><?php
	require_once("header.php");
	?></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td><table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td align="center" class="ltxt"> <h4><strong>File Transfer: Download 
                    Now</strong></h4>
                  <hr> </td>
              </tr>
              <?php
		  	if(count($err)>0)
			{
		  ?>
              <tr> 
                <td class="ltxt"><font color="#FF0000"> 
                  <?php 
				  		foreach($err as $errmsg)
						print "<li>$errmsg</li>";
						?>
                  </font></td>
              </tr>
              <?php
			}
			?>
              <tr> 
                <td class="ltxt"><strong><a href="index.php" class="ltxt">Home</a></strong></td>
              </tr>
            </table>
            <p>&nbsp;</p></td>
        </tr>
      </table>
    </td>
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
<?
}
?>