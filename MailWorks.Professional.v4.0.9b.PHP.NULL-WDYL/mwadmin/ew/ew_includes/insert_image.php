<?php

	// ERROR_REPORTING(E_NONE);
	require_once("ew_lang/language.php");

	/*//////////////////////////////////////////////////////
	/                                                      /
	/ The $DOCUMENT_ROOT variable is used to specify the   /
	/ location of the image directory. If you are having   /
	/ problems uploading or deleting images, then you      /
	/ will need to change the variable below to the full   /
	/ path to your document root on your web server, such  /
	/ as /htdocs/www/jdoe                                  /
	/                                                      /
	//////////////////////////////////////////////////////*/

	$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

	// DO NOT MODIFY BELOW THIS LINE
	$validImageTypes = array("image/pjpeg", "image/jpeg", "image/gif", "image/x-png");
	$ImageDirectory = ereg_replace("/$", "", $_GET["imgDir"]);
	
	// echo $ImageDirectory;

	$URL = $_SERVER["HTTP_HOST"];
	$scriptName = dirname($_SERVER["SCRIPT_NAME"]) . "/ew/class.editworks.php";
	$HideWebImage = @$_GET["wi"];

	// Workout the location of class.editworks.php
	$url = $_SERVER["SERVER_NAME"];
	$scriptName = "class.editworks.php";
	$scriptDir = strrev(@$_SERVER["PATH_INFO"]);
	$slashPos = strpos($scriptDir, "/");
	$scriptDir = strrev(substr($scriptDir, $slashPos, strlen($scriptDir)));

	/*$URL = $_SERVER["HTTP_HOST"];
	$scriptName = dirname($_SERVER["SCRIPT_NAME"]) . "/ew/class.editworks.php";
	
	// Workout the location of class.editworks.php
	$url = $_SERVER["SERVER_NAME"];
	$scriptName = "class.editworks.php";
	$scriptDir = strrev($_SERVER["PATH_INFO"]);
	$slashPos = strpos($scriptDir, "/");
	$scriptDir = strrev(substr($scriptDir, $slashPos, strlen($scriptDir)));*/

	if(@$_GET["imgSrc"] != "")
	{
		// Delete the image
		$imgPath = $ImageDirectory . "/" . $_GET["imgSrc"];
		@unlink($DOCUMENT_ROOT . $imgPath);
	}

	if($_GET["ToDo"] == "UploadImage")
	{
		
		//Upload the image to the images directory
		$newFileName = $_FILES["upload"]["name"];
		$newFileType = $_FILES["upload"]["type"];
		$newFileLocation = $_FILES["upload"]["tmp_name"];
		$validFileType = false;
		$errorText = "";
		
		// Is this a valid file type?
		if(in_array($newFileType, $validImageTypes))
			$validFileType = true;
	
		if($validFileType == false)
		{
			// Invalid file type
			$statusText = sTxtImageErr;
		}
		else
		{
			$uploadSuccess = copy($newFileLocation, $DOCUMENT_ROOT . $ImageDirectory . "/" . $newFileName);
			$statusText = $newFileName . " " . sTxtImageSuccess . "!";
		}
	}

	$counter = 0;
	?>
		<title><?php echo sTxtInsertImage; ?></title>
		
		<script language=JavaScript>
		window.onload = this.focus

		function deleteImage(imgSrc)
		{
			var delImg = confirm("<?php echo sTxtImageDelete ?>?");

			if (delImg == true) {
				document.location.href = '<?php echo $_SERVER["PHP_SELF"]; ?>?ToDo=DeleteImage&imgDir=<?php echo $ImageDirectory; ?>&tn=<?php echo $_GET["tn"]; ?>&imgSrc='+imgSrc;
			}

		}

		function setBackground(imgSrc)
		{
			var setBg = confirm("<?php echo sTxtImageSetBackgd ?>?");

			if (setBg == true) {
				window.opener.setBackgd('<?php echo $HTTPStr; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>' + imgSrc);
				self.close();
			}
		}

		function viewImage(imgSrc)
		{
			var sWidth =  screen.availWidth;
			var sHeight = screen.availHeight;
			
			window.open(imgSrc, 'image', 'width=700, height=500,left='+(sWidth/2-350)+',top='+(sHeight/2-500));
		}

		function grey(tr) {
				tr.className = 'b4';
		}

		function ungrey(tr) {
				tr.className = '';
		}

		function insertImage(imgSrc) {
			error = 0

			var sel = window.opener.foo.document.selection;
			if (sel!=null) {
				var rng = sel.createRange();
			   	if (rng!=null) {

					// HTMLTextField = '<img src="<?php echo $HTTPStr; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/'+imgSrc+'">';
					HTMLTextField = '<img src="'+imgSrc+'">';
					rng.pasteHTML(HTMLTextField)
				} // End if
			} // End If

			if (error != 1) {
				window.opener.foo.focus();
				self.close();
			}
		} // End function

		function insertExtImage() {
		error = 0

		var sel = window.opener.foo.document.selection;
		if (sel!=null) {
			var rng = sel.createRange();
		   	if (rng!=null) {

				imgSrc = externalImage.value
				HTMLTextField = '<img src="'+imgSrc+'">';
				rng.pasteHTML(HTMLTextField)
			} // End if
		} // End If

		if (error != 1) {
			window.opener.foo.focus();
			self.close();
		}

		} // End function

		</script>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="15"><img src="_images/1x1.gif" width="15" height="1"></td>
		  <td class="heading1"><?php echo sTxtInsertImage; ?></td>
	  </tr>
		<tr>
			<form enctype="multipart/form-data" action="<?php echo $HTTPStr; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?><?php echo $_SERVER["PHP_SELF"]; ?>?ToDo=UploadImage&imgDir=<?php echo $ImageDirectory; ?>&wi=<?php echo $HideWebImage; ?>&tn=<?php echo $_GET["tn"]; ?>&dd=<?php echo $_GET["dd"]; ?>" method="post" id=form1 name=form1>
			<td>&nbsp;</td>
			  <td class="body"><?php echo sTxtInsertImageInst; ?><br>
				<?php echo sTxtCloseWin; ?>
				<br><br>
				<?php if(@$_GET["du"] != "1") { ?>
					<?php echo sTxtUploadImage; ?>: <input type="file" name="upload" class="Text220"> <input type="submit" value="Upload" class="Text50" id=submit1 name=submit1>
					<br><br><span class="err"><?php echo @$statusText; ?></span>
				<?php } ?>
			  </td>
			</form>
		</tr>
  <?php if($HideWebImage != "1") { ?>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
  		<tr>
		    <td>&nbsp;&nbsp;<?php echo sTxtExternalImage; ?></td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	<table class="bevel2" width="98%" cellpadding=10><tr><td class=body width=75><?php echo sTxtExternalImage; ?>:</td><td>
	
	<input type="text" name="externalImage" class="Text220" value="http://">&nbsp;<input type=button value=Insert class="Text50" onClick="insertExtImage()">
	
	</td></tr></table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="20"></td>
  </tr>
  <?php } ?>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
			  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
				<tr>
				    <td>&nbsp;&nbsp;<?php echo sTxtInternalImage; ?></td>
				</tr>
			  </table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="10"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="body">

			<?php if($_GET["tn"] == 1) { ?>
			    <table border="0" cellspacing="0" cellpadding="10" width="98%" class="bevel2">
			<?php } else { ?>
				<table border="0" cellspacing="0" cellpadding="3" width="98%" class="bevel2">
			<?php } ?>

		  <tr>

		<?php if(@$_GET["tn"] == 1) {
			$dirHandle = @opendir(realpath($DOCUMENT_ROOT . $ImageDirectory)) or die("Image directory has not been configured correctly");
			while(false !== ($file = readdir($dirHandle)))
			{
				if($file != "." && $file != "..")
				{
				?>
					<td width="25%">
						<span class="body"><?php echo $file; ?><br></span>
						<img align="left" src="<?php echo $ImageDirectory . "/" . $file; ?>" width="80" height="80" border=1>
						<br><a href="javascript:viewImage('<?php echo $ImageDirectory . "/" . $file; ?>')" class="imagelink"><?php echo sTxtImageView; ?></a><br>
						<a href="javascript:insertImage('<?php echo $ImageDirectory . "/" . $file; ?>')" class="imagelink"><?php echo sTxtImageInsert; ?></a><br>
						<?php if(@$_GET["dt"] != "0") { ?>
							<a href="javascript:setBackground('<?php echo $ImageDirectory . "/" . $file; ?>')" class="imagelink"><?php echo sTxtImageBackgd; ?></a><br>
						<?php } ?>
						<?php if(@$_GET["dd"] != "1") { ?>
							<a href="javascript:deleteImage('<?php echo URLEncode($file); ?>')" class="imagelink"><?php echo sTxtImageDel; ?></a><br>
						<?php } ?>
					</td>
				<?php
					$counter++;
				}
				
				if($counter % 4 == 0)
					echo "</tr><tr>";
			}
		}
		else
		{
		?>
			</tr>
			<tr>
				<td width="40%">
					<span class="body"><b>&nbsp;<?php echo sTxtImageName; ?></b></span>
				</td>
				<td width="20%">
					<span class="body"><b><?php echo sTxtFileSize; ?></b></span>
				</td>
				<td width="10%">
					<span class="body"><b><?php echo sTxtImageView; ?></b></span>
				</td>
				<td width="10%">
					<span class="body"><b><?php echo sTxtImageInsert; ?></b></span>
				</td>
				<?php if(@$_GET["dt"] != "0") { ?>
					<td width="10%">
						<span class="body"><b><?php echo sTxtImageBackgd; ?></b></span>
					</td>
				<?php } ?>
				<?php if(@$_GET["dd"] != "1") { ?>
					<td width="10%">
						<span class="body"><b><?php echo sTxtImageDel; ?></b></span>
					</td>
				<?php } ?>
			</tr>
		<?php

			$dirHandle = @opendir(realpath($DOCUMENT_ROOT . $ImageDirectory)) or die("Image directory has not been configured correctly");
			while(false !== ($file = readdir($dirHandle)))
			{
				if($file != "." && $file != "..")
				{
				?>
					<tr onmouseover="grey(this)" onmouseout="ungrey(this)">
						<td width="40%" class="body">
							&nbsp;<?php echo $file; ?>
						</td>
						<td width="20%"class="body">
							<?php echo filesize(ereg_replace("/$", "", $DOCUMENT_ROOT) . $ImageDirectory . "/" . $file); ?> Bytes
						</td>
						<td width="10%">
							<a href="javascript:viewImage('<?php echo $ImageDirectory . "/" . $file; ?>')" class="imagelink"><?php echo sTxtImageView; ?></a>
						</td>
						<td width="10%">
							<a href="javascript:insertImage('<?php echo $ImageDirectory . "/" . $file; ?>')" class="imagelink"><?php echo sTxtImageInsert; ?></a>
						</td>
						<?php if($_GET["dt"] != "0") { ?>
							<td width="10%">
								<a href="javascript:setBackground('<?php echo $ImageDirectory . "/" . $file; ?>')" class="imagelink"><?php echo sTxtImageBackgd; ?></a>
							</td>
						<?php } ?>
						<?php if($_GET["dd"] != "1") { ?>
							<td width="10%">
								<a href="javascript:deleteImage('<?php echo URLEncode($file); ?>')" class="imagelink"><?php echo sTxtImageDel; ?></a>
							</td>
						<?php } ?>
					</tr>
			<?php
			}
		}
	}
?>

</table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
  <td></td>
	<td>
	<input type="button" name="Submit" value="<?php echo sTxtCancel?>" class="Text50" onClick="javascript:window.close()">
	</td>
  </tr>
</table>	
