<?
$not_include_header=true;
include("../config_file.php");?>
<html><head><title>Upload Banner Image</title><link rel="stylesheet" href="css.css"></head><body>
<?
if ($todo == "upload") {
     if(!empty($toupload) && $toupload != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($toupload)) && (in_array($toupload_type,array ("image/gif","image/pjpeg","image/jpeg","image/x-png"))))
     {
         $image_location = DIR_BANNERS.$toupload_name;
         if (file_exists($iamge_location)) {
                @unlink($image_location);
         }//end if (file_exists($flag_location))
         if (copy($toupload, $image_location)) {
         unlink($toupload);
         ?>
         <center>
			 <p class="bigtext">Image Uploaded Successfully...</p>
			 <p><img src="<?=HTTP_BANNERS.$toupload_name?>"></p>
			 <a href="javascript:window.close();">Close this window</a>
		 </center>
         <?
		 }
      }
      else {
	?>
	    <center>
			 <p class="bigtext">Image Uploaded Fail...</p>
			 <a href="javascript:window.close();">Close this window</a>
		 </center>
     <?
      }
}
else {
?>
<form action="admin_upload.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="todo" value="upload">
<center><p class="bigtext">Select Image To Upload:</p>
<input type="file" class="button" name="toupload"><br><br>
<input type="submit" class="button" name="go" value="Upload">
</form>
</center>
<?}?>
</body></html>