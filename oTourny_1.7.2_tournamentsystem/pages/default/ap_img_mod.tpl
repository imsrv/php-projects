<center>
 {IMG_NAME}
 <br>
 <img src="picture.php?id={IMG_ID}">
<center>
<form action="{LINK_SAVE}" enctype="multipart/form-data" method="POST">
 <center>
  Enter in the Name of Picture.
  <br>
  Name (Optional): <input type="text" maxlength="{FIELD_NAME_MAX}" size="45" name="{FIELD_NAME_NAME}" value="{FIELD_NAME_VALUE}">
  <br><br>
  <input type="hidden" name="{FIELD_MAX_NAME}" value="{FIELD_MAX_VALUE}">
  Picture: <input type="file" name="{FIELD_FILE_NAME}" size="70">
  <br><br>
  <input type="submit" name="submit" value="Upload">
 </center>
</form>