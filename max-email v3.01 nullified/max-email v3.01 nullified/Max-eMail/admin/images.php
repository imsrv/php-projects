<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
include "../config.inc.php";

if($action){

			if(CanPerformAction("$action|images|$ImageGroupID")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "manage":
		ManageImages();
		break;
		
		case "groups";
		ImageGroups();
		break;
			
	}
}else{
	ImagesMain();
}

/////////////////////////////////////////////////////////////

function ImageGroups(){
	GLOBAL $DeleteGroupID, $FULL_OUTPUT, $AddNew, $ImageGroupID, $ImageGroupName, $MaximumImages, $FileSizeLimit, $TotalSizeLimit;
	
	if($DeleteGroupID){
		mysql_query("DELETE FROM images WHERE ImageGroupID='$DeleteGroupID'");
		mysql_query("DELETE FROM image_groups WHERE ImageGroupID='$DeleteGroupID'");
		ImagesMain();
	}
	
	if($AddNew){
		mysql_query("INSERT INTO image_groups SET ImageGroupName='NewImageGroup', MaximumImages='10', FileSizeLimit='102400', TotalSizeLimit='102400'");
		$ImageGroupID=mysql_insert_id();
	}
	
	if($ImageGroupName){
		//save changes!
		$FileSizeLimit=$FileSizeLimit*1024;
		$TotalSizeLimit=$TotalSizeLimit*1024;
		mysql_query("UPDATE image_groups SET ImageGroupName='$ImageGroupName', MaximumImages='$MaximumImages', FileSizeLimit='$FileSizeLimit', TotalSizeLimit='$TotalSizeLimit' WHERE ImageGroupID='$ImageGroupID'");
		$FULL_OUTPUT.=MakeBox("Changes saved!", 'Your changes to the group were saved!');
	}
	
		$g=mysql_fetch_array(mysql_query("SELECT * FROM image_groups WHERE ImageGroupID='$ImageGroupID'"));
		$FORM_ITEMS["Group Name"]="textfield|ImageGroupName:30:30:".$g[ImageGroupName];		
		$FORM_ITEMS["Maximum Images"]="textfield|MaximumImages:10:10:".$g[MaximumImages];
		$FORM_ITEMS["File Size Limit(Kb)"]="textfield|FileSizeLimit:20:20:".round($g[FileSizeLimit]/1024);
		$FORM_ITEMS["Total Size Limit(Kb)"]="textfield|TotalSizeLimit:20:20:".round($g[TotalSizeLimit]/1024);
		$FORM_ITEMS[-4]="hidden|ImageGroupID:$ImageGroupID";
		$FORM_ITEMS[-1]="submit|Save Changes";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="ImageGroupManagement";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="images.php?action=groups";
		$FORM->MakeForm();
		
		$FULL_OUTPUT.=MakeBox("Manage Image Group", $FORM->output.'<P>'.MakeLink("images.php", "Back to images main").' | '.MakeLink("images.php?action=groups&DeleteGroupID=".$g[ImageGroupID], "Delete Image Group",1));
	
	
}

/////////////////////////////////////////////////////////////

function ManageImages(){
GLOBAL $FULL_OUTPUT, $ImageGroupID, $HTTP_POST_FILES, $ImageName, $AllowedImageTypes, $DeleteID, $PreviewID;

$g=mysql_fetch_array(mysql_query("SELECT * FROM image_groups WHERE ImageGroupID='$ImageGroupID'"));

if($DeleteID){
	mysql_query("DELETE FROM images WHERE ImageID='$DeleteID' && ImageGroupID='$ImageGroupID'");
	$FULL_OUTPUT.=MakeBox("Image Deleted", "The image was deleted successfully!");
}

if($PreviewID){
	$ImageID=$PreviewID;
	$FULL_OUTPUT.=MakeBox("Image Preview", '<CENTER><img src="../view_image.php?ImageID='.$PreviewID.'"></CENTER>');
}

$totalimages=mysql_num_rows($i=mysql_query("SELECT * FROM images WHERE ImageGroupID='$ImageGroupID'"));
		while($ai=mysql_fetch_array($i)){
			$totalsize=$totalsize+$ai[FileSize];
		}

//has an image just been uploaded!
 $userfile=$HTTP_POST_FILES['ImageFile']['tmp_name'];
 $filename=$HTTP_POST_FILES['ImageFile']['name'];
 $imagetype=$HTTP_POST_FILES['ImageFile']['type'];
 if($userfile && $userfile!="none"){
	//check if the file is to big!
	$imsize=filesize($userfile);
	if($imsize>$g[FileSizeLimit]){
		$UploadOut.='Sorry the image is to big, it exceedes the filesize limit for this Image Group.';
	}elseif($imsize+$totalsize>$g[TotalSizeLimit]){
		$UploadOut.='Sorry the image is to big, it will put the total size of images in this group over the groups limit.';	
	}elseif($totalimages+1>$g[MaximumImages]){
		$UploadOut.='This Image Group already contains its maximum number of images.';
	}elseif(!isset($AllowedImageTypes[$imagetype])){
		$UploadOut.='That image type is not allowed, sorry!';
	}elseif(mysql_num_rows(mysql_query("SELECT * FROM images WHERE FileName LIKE '$ImageName'"))>0){
		$UploadOut.='There is already an image with that name.';	
	}else{
		//we can upload the file!
		$f=fopen($userfile, "rb");
		$contents=fread($f, filesize($userfile));

		$contents=addslashes($contents);
		//echo $contents;
		mysql_query("INSERT INTO images SET ImageGroupID='$ImageGroupID', FileName='$ImageName', ImageData='$contents', FileSize='$imsize', ImageType='$imagetype'");
		$UploadOut.='The image '.$FileName.' was uploaded successfully!';
	}
 	$FULL_OUTPUT.=MakeBox("Image upload..", $UploadOut);	
 }

//display current images in group!
$BoxOut.='<TABLE width="80%">
<TR><TD width="10"><span class="admintext"></span></td><TD><span class="admintext">File Name</span></td><TD><span class="admintext">Size</span></td><TD><span class="admintext">Type</span></td><TD><span class="admintext"></span></td></TR>
<TR height="1" bgcolor="#cccccc"><td colspan="5"></td></TR>';
$images=mysql_query("SELECT * FROM images WHERE ImageGroupID='$ImageGroupID'");
 while($i=mysql_fetch_array($images)){
 	$ig++;
	$totalsizes=$totalsizes+$i[FileSize];
 	$BoxOut.='<TR><TD width="10"><span class="admintext">'.$ig.':</span></td><TD><span class="admintext">'.$i[FileName].'</span></td><TD><span class="admintext">'.round($i[FileSize]/1024).'Kb</span></td><TD><span class="admintext">'.$AllowedImageTypes[$i[ImageType]].'</span></td><TD><span class="admintext">'.MakeLink("images.php?action=manage&ImageGroupID=$ImageGroupID&DeleteID=".$i[ImageID],"Delete",1).' | '.MakeLink("images.php?action=manage&ImageGroupID=$ImageGroupID&PreviewID=".$i[ImageID], "Preview").'</span></td></TR>';
 }
 $BoxOut.='<TR><TD></TD><TD><span class="admintext"><B>Totals</B></span></td><TD><span class="admintext"><B>'.round($totalsizes/1024).'Kb</B></span></td></tr></TABLE>';
 $BoxOut.='<P>
 Currently using '.round($totalsizes/1024).'Kb of '.round($g[TotalSizeLimit]/1024).'Kb ('.round(($totalsizes/$g[TotalSizeLimit])*100).'%). '.$ig.' of maximum '.$g[MaximumImages].' files uploaded.<P>';
 $BoxOut.=MakeLink("images.php", "Back to images main");
 $FULL_OUTPUT.=MakeBox("Current images in group",$BoxOut);

//add image box!
		$FORM_ITEMS["File"]="file|ImageFile";		
		$FORM_ITEMS["File name"]="textfield|ImageName:30:30:NewImage";
		$FORM_ITEMS[-4]="hidden|ImageGroupID:$ImageGroupID";
		$FORM_ITEMS[-1]="submit|Upload image now";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="ImageUpload";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="images.php?action=manage";
		$FORM->EXTRA='ENCTYPE="multipart/form-data"';
		$FORM->MakeForm();
		
		$FULL_OUTPUT.=MakeBox("Upload another image!",$FORM->output."<P>Maximum file size is: ".round($g[FileSizeLimit]/1024)."Kb");
}

/////////////////////////////////////////////////////////////

function ImagesMain(){
GLOBAL $FULL_OUTPUT;

	//print a box with info on groups this admin can manage!
	$gi=mysql_query("SELECT * FROM image_groups");
	while($g=mysql_fetch_array($gi)){
			if(CanPerformAction("manage|images|".$g[ImageGroupID])==1){	
				$BoxOut.="<P><B>".$g[ImageGroupName].'</B><BR>';
					$totalimages=mysql_num_rows($i=mysql_query("SELECT * FROM images WHERE ImageGroupID='".$g[ImageGroupID]."'"));
						while($ai=mysql_fetch_array($i)){
							$totalsize=$totalsize+$ai[FileSize];
						}
				$BoxOut.='Images: '.$totalimages.' out of '.$g[MaximumImages].' maximum<BR>';
				$BoxOut.='File Space: '.round($totalsize/1024).'Kb out of '.round($g[TotalSizeLimit]/1024).'kB maximum ('.round(($totalsize/$g[TotalSizeLimit])*100).'%)<BR>';
				$BoxOut.=MakeLink("images.php?action=manage&ImageGroupID=".$g[ImageGroupID],"Manage this group");
			}
	}

	$FULL_OUTPUT.=MakeBox("Image groups you are able to manage..", $BoxOut);
	
	if(CanPerformAction("groups|images|1")==1){
				$ig=mysql_query("SELECT * FROM image_groups");
					while($i=mysql_fetch_array($ig)){
						$allgroups.=$i[ImageGroupID]."->".$i[ImageGroupName].";";
					}
				$FORM_ITEMS["List"]="select|ImageGroupID:1:$allgroups:";
				$FORM_ITEMS[-1]="submit|Edit Group";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="ManageImageGroups";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="images.php?action=groups";
				$FORM->MakeForm();
		$FULL_OUTPUT.=MakeBox("Manage Groups",$FORM->output.'<P>'.MakeLink("images.php?action=groups&AddNew=1","Add new image group"));
	}
	
}


FinishOutput();


?>