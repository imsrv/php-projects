<?

	global $ROOTURL;
	global $ImageFileSizeLimit;

	$Action = @$_GET["Action"];
	$SubAction = @$_REQUEST["SubAction"];
	$Save = @$_REQUEST["Save"];
	$ImageID = @$_REQUEST["ImageID"];

	$alllists = "";
	$OUTPUT = "";
	$Error = "";
	$IsAdding = false;

	if($Action == "Add")
	{
		//upload new image box!
		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS[$req . "Image File"]="file|TextFileName";
		$HELP_ITEMS["TextFileName"]["Title"] = "Image File";
		$HELP_ITEMS["TextFileName"]["Content"] = "Click on the &quot;Browse...&quot; button to choose an image from your hard drive to upload. Then, when you\'re creating a newsletter, you can click on the &quot;Insert Custom Field&quot; popup to insert this image into your content.";

		$FORM_ITEMS[-1]="submit|Continue to Step 2:1-images";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="UploadImage";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("images?Action=Upload");
		$FORM->EXTRA='ENCTYPE="multipart/form-data"';
		$FORM->MakeForm("New Image Details");

		$FORM->output = "Complete the form below to upload an image.<br>Click on the \"Continue to Step 2\" button to continue." . $FORM->output;

		$OUTPUT.=MakeBox("Upload New Image (Step 1 of 2)",$FORM->output);

		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.TextFileName.value == "")
					{
						alert("Please choose an image to upload by clicking on the \'Browse\' button.");
						f.TextFileName.focus();
						return false;
					}
				}
			
			</script>
		';
	}

	if($Action=="Preview"){
		$POPOUTPUT=1;
		$image=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE ImageID='$ImageID'"));
		$imfile= $ROOTURL . "temp/images/".$ImageID.".".$image["ImageType"];
		
		header("Location: $imfile");
		die();
	}

	if($Action=="Upload"){
	 $IsAdding = true;
	 $userfile=@$_FILES['TextFileName']['tmp_name'];
	 $filename=@$_FILES['TextFileName']['name'];
	 $type=@$_FILES['TextFileName']['type'];

		if(substr($type,0,6)=="image/" OR !is_file($userfile)){
			if(@$_FILES['TextFileName']['size']>$ImageFileSizeLimit){
				$Error='The image that you uploaded is too big.';
			}else{
				$ext=substr($filename,-4);
				$ext=str_replace(".","",$ext);
				$filename=str_replace(".$ext","",$filename);
				mysql_query("INSERT INTO " . $TABLEPREFIX . "images SET ImageName='$filename', DateUploaded='$SYSTEMTIME', ImageType='$ext', AdminID='" . $CURRENTADMIN["AdminID"] . "'");
				$ImageID=mysql_insert_id();
				$imdir= "../temp/images";
				$imfile= $imdir . "/" . $ImageID . "." . $ext;
				@clearstatcache();

				// Can we get write access to the temp/images directory?
				if(!is_writable($imdir))
				{
					$Error="The '$imdir' folder does not have write permissions. Please CHMOD this folder to 777.";
				}
				else
				{
					// We can write to the file OK, move it
					@move_uploaded_file($userfile, $imfile);
					@chmod($imfile, "0777");
				}
			}
		}else{
			$Error="The file that you uploaded is not a valid image file.";
		}
		
		if($Error){
			$OUTPUT .= MakeErrorBox("Invalid Image", $Error);
		}else{
			$Action="EditImage";
		}

	}

	if($Action=="EditImage"){
		
		if($Save){
			mysql_query("UPDATE " . $TABLEPREFIX . "images SET ImageName='$ImageName' WHERE ImageID='$ImageID'");
			$OUTPUT .= MakeSuccessBox("Image Saved Successfully", "The selected image has been saved successfully.", MakeAdminLink("images?Action="));
		}else{
			$image=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE ImageID='$ImageID'"));

			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";		

			$FORM_ITEMS[$req . "Image Name"]="textfield|ImageName:100:44:".$image["ImageName"];
			$HELP_ITEMS["ImageName"]["Title"] = "Image Name";
			$HELP_ITEMS["ImageName"]["Content"] = "What would you like to call this image? The image name will be used in the control panel for your reference only, and your subscribers will not see this name.";

			$FORM_ITEMS[-1]="submit|Save Image:1-images";

			$FORM=new AdminForm;
			$FORM->title="EditImage";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("images?Action=EditImage&Save=Yes&ImageID=$ImageID");

			// Are we on step 2 of adding an image, or are we editing one?
			if($IsAdding == true)
			{
				$FORM->MakeForm("Image Details");
				$FORM->output = "Complete the form below to finish adding a image." . $FORM->output;
				$OUTPUT.=MakeBox("Upload New Image (Step 2 of 2)",$FORM->output);
			}
			else
			{
				$FORM->MakeForm("Image Details");
				$FORM->output = "Complete the form below to update this image." . $FORM->output;
				$OUTPUT.=MakeBox("Edit Image",$FORM->output);
			}

			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.ImageName.value == "")
						{
							alert("Please enter a name for this image.");
							f.ImageName.focus();
							return false;
						}
					}
				
				</script>
			';
		
		}
	}

	if($Action==""){

		if($SubAction=="Delete"){
			$image=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE ImageID='$ImageID'"));
			//$imfile=$ROOTDIR."temp".$DIRSLASH."images".$DIRSLASH.$ImageID.".".$image["ImageType"];
			$imfile="../temp".$DIRSLASH."images".$DIRSLASH.$ImageID.".".$image["ImageType"];

			unlink($imfile);
			mysql_query("DELETE FROM " . $TABLEPREFIX . "images WHERE ImageID='$ImageID'");
		}

		if($CURRENTADMIN["Manager"] == 1)
		{
			$Total = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "images ORDER BY ImageName ASC"));
			$images = mysql_query("SELECT * FROM " . $TABLEPREFIX . "images ORDER BY ImageName ASC");
		}
		else
		{
			$Total = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY ImageName ASC"));
			$images = mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY ImageName ASC");
		}

		if($Total > 0)
		{	
			$IO = '

					<script language="JavaScript">

					function selectOn(trObject)
					{
						for(i = 0; i <= 4; i++)
						{
							trObject.childNodes[i].className = "body bevel4 rowSelectOn";
						}
					}

					function selectOut(trObject, whichStyle)
					{
						for(i = 0; i <= 4; i++)
							trObject.childNodes[i].className = "body bevel4";
					}
				
				</script>

				Use the form below to preview, edit and delete your images.<br>
				To upload a new image, click on the "Upload Image" button below.<br><br>
				<input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("images?Action=Add") . '"\' value="Upload Image">
				<br><br>
				<table width=100% border=0 cellspacing=2 cellpadding=2>
				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=40%>
						Image Name
					</td>
					<td class="headbold bevel5" width=10%>
						Type
					</td>
					<td class="headbold bevel5" width=25%>
						Date Uploaded
					</td>
					<td class="headbold bevel5" width=21%>
						Action
					</td>
				</tr>

			';

			while($i=mysql_fetch_array($images))
			{
				$IO .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/image.gif" width="16" height="16">
						</td>
						<td class="body bevel4" width=40%>' . $i["ImageName"] . '</td>
						<td class="body bevel4" width=10%>' . strtoupper($i["ImageType"]) . '</td>
						<td class="body bevel4" width=25%>' . DisplayDate($i["DateUploaded"]) . '</td>
						<td class="body bevel4" width=21%>';

				$IO .= MakeLink("images?Action=EditImage&ImageID=".$i["ImageID"],"Edit");
				$IO .= "&nbsp;&nbsp;&nbsp;" . MakeLink("images?Action=&SubAction=Delete&ImageID=".$i["ImageID"],"Delete",1);
				$IO .= "&nbsp;&nbsp;&nbsp;" . MakeLink(MakePopup("images?Action=Preview&ImageID=".$i["ImageID"],500,500,"ImagePreview".$i["ImageID"]),"Preview",0,1);

				$IO .= '
					</tr>
				';
			}

			$IO.='</table>';
		}
		else
		{
			$IO = '
				No images have been uploaded. Click the "Upload Image" button below to upload an image.<br><br>
				<input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("images?Action=Add") . '"\' value="Upload Image">
				<br><br>';
		}

		$OUTPUT.=MakeBox("Image Manager",$IO);
	}

?>