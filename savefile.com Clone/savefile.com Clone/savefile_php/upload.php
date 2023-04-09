<?
	include("include/common.php");
	include("include/header.php");
	if($loggedin){
		include("include/accmenu.php");
	}
	if( $_POST['submit'] && $_FILES['attached']['name'] ){
		$ok_filetypes = explode("|",$att_filetypes);
		if (!$_FILES['attached']['error'] && $_FILES['attached']['size'] > $att_max_size*1024){
			errform('<CENTER>Sorry, but the attached file is too large. Please reduce the size of it\'s contents.</CENTER><BR><BR>'); // #err
			$step = 1;
		}
		$filename = (!$_FILES['attached']['error'] ? substr( basename($_FILES['attached']['name']), -30 ) : '');
		$x = strtolower( substr($_FILES['attached']['name'], -3));
		if($filename && !in_array($x, $ok_filetypes) ){
			errform('<CENTER>Sorry, the filetype you have tried to upload is not allowed.</CENTER><BR><BR>');
			$step = 1;
		}
		if(!$posterr){
			if(!isset($_GET["ipaddress"]) || ($_GET["ipaddress"] == "")) {
				$ipaddress = $_SERVER['REMOTE_ADDR'];
				$local = 1;
			} else {
				$ipaddress = $_GET["ipaddress"];
				$local = 0;
			}
			$uniq = substr( md5(uniqid (rand())), 0, 10 );
			$ext = strtolower( substr($_FILES['attached']['name'], -3));
			move_uploaded_file($_FILES['attached']['tmp_name'], $att_path."/".$uniq.".".$ext );
			$strQuery  = "INSERT INTO images25 SET ";
			$strQuery .= "filename='".$uniq.".".$ext."',";
			$strQuery .= "ipaddress='{$ipaddress}',";
			$strQuery .= "date='".time()."',";
			$strQuery .= "pkey='{$uniq}',";
			if($myuid){
				$strQuery .= "user='{$myuid}',";
			}
			$strQuery .= "status='1'";
			$result = mysql_query($strQuery) or die( mysql_error() );
			$aid = mysql_insert_id();
			if($aid){
				$filen = $siteurl."/".str_replace('./', '', $att_path)."/".$uniq.".".$ext;
				$filen = str_replace('http://','%%',$filen);
				$filen = str_replace('//','/',$filen);
				$filen = str_replace('%%','http://',$filen);

				
				//ITS AN IMAGE
				if($x=="jpg" or $x=="jpeg" or $x=="gif" or $x=="png" or $x=="jif" or $x=="jfif")
				{
					$filenx=$filen;
				}
				else
				{
					include("include/const.inc.php");
					$filenx = $siteurl."/icons/".$Icons[$ext];
				}


				$step = 2;
			}else{
				$step = 1;
			}
		}
	}else{
		$step = 1;
	}
	if($step == 1){
?>
		<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<div align=center>
				<form ENCTYPE="multipart/form-data" method="post" name="form1">
					<INPUT NAME="attached" TYPE="file"  size="50"><br>
					File extensions allowed: <b><?=implode("</b>, <b>",explode("|",$att_filetypes))?></b><br>
					File size limit: <b><?=$att_max_size?>KB</b>
					<br><br>
					<input type="submit" name="submit" value="Upload File">
				</form>
				</div>
			</td>
		</tr>
		</table>
<?
	}else{	?>
<div align="center"><b>Your file has been successfully uploaded!</b><br>
  <br>
</div>
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td><div align="center"><img src="<?=$filenx?>"></div></td>
		</tr>
		<tr>
			<td><div align="center"><br>
				To insert this File in a message board post copy and paste the following
				code:<br>
				<textarea name="textarea" cols="100" wrap="soft" rows="3">[url=<?=$siteurl?>][img]<?=$filen?>[/img][/url]</textarea>
			</div></td>
		</tr>
		<tr>
			<td><div align="center"><br>
				To send this File to friends and family, copy and paste this code: <br>
        <textarea name="textarea2" cols="100" rows="4"><?=$filen?></textarea>
      </div></td>
		</tr>
		<tr>
			<td><div align="center"><br>
				To insert this File using HTML, copy and paste the following
				code:<br>
				<textarea name="textarea3" cols="100" wrap="soft" rows="3"><a href="<?=$filen?>" target="_blank"><img alt="File Hosted by <?=$sitename?>" src="<?=$filenx?>" /></a></textarea>
			</div></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		</table>
<?	}	?>
<?
	include("include/footer.php");
?>