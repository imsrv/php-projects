<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

include("connect.php");

//Function to check date format
function is_valid_date($date){
	list($month,$day,$year) = explode("/",$date);
	if($month > 12 || $month < 01 || strlen($month) != 2 || !is_numeric($month)){return false;}
	if($day > 31 || $day < 1|| strlen($day) != 2 || !is_numeric($day)){return false;}
	if(strlen($year) != 4 || !is_numeric($year)){ return false;}
	return true;
}

//Get Id Number
if($_POST['id'] == NULL){
	$id = $_GET['id'];
} else {
	$id = $_POST['id'];
}
$get_banner = @mysql_query("SELECT * FROM banners WHERE `id`='$id'");

//If no banner id exist, or was removed redirect to add banner page
if(@mysql_num_rows($get_banner) <= 0 ){
	header("Location: add.php");
	exit();
}

//Check if form submitted
if($_POST['submitid'] == 2){
	//Form validation
	if(strlen($_POST['name']) < 3){$message = 'Please enter a name for the banner';}
	if($_POST['locationtype'] == 'http' && strlen($_POST['httploc']) < 3 && $message == NULL){$message = 'Please enter location url.';}
	if($_POST['locationtype'] == 'upload' && $_FILES['filename']['name'] == NULL && $message == NULL){$message = 'Please enter a filename.';}
	if(strlen($_POST['urlto']) < 3 && $message == NULL){$message = 'Please enter a URL location (to direct to).';}
	if($_POST['stopit'] == 'hits' && !is_numeric($_POST['number'])  && $message == NULL){ $message = 'Invalid Hit amount to stop on.';}
	if($_POST['stopit'] == 'views' && !is_numeric($_POST['number']) && $message == NULL){ $message = 'Invalid Views amount to stop on.';}
	if($_POST['stopit'] == 'date' && is_valid_date($_POST['id1']) == false && $message == NULL){ $message = 'Invalid date to stop on.';}
	if($_POST['size'] == 'change' && !is_numeric($_POST['width']) && !is_numeric($_POST['height']) && $message == NULL){$message = 'Invalid Width/height.';}
	
	if($message == NULL){
	//Variables that do not need checking, just leave them b
	$java_statusbar = $_POST['status'];	
	$name = $_POST['name'];
	$mouse_over = $_POST['mouseover'];
	$urlto = $_POST['urlto'];

	// Check Which Option Choose, Upload Banner or HTTP Link
	if($_POST['locationtype'] == 'upload'){
		$filename = $_FILES['filename']['name'];
		if($filename !=NULL){
		
			$currentdir = "images";
			$expload = explode(".",$filename);
			$ext = $expload[1];
			if(is_file('images/' . $_FILES['filename']['name'])){
				$filename = substr (md5(uniqid(rand(),1)), 3, 5) . '.' .  $ext;
			}
		
		move_uploaded_file($_FILES['filename']['tmp_name'],$currentdir.'/'. $filename);
		$location = 'images/' . $filename;
		}
	} else {
		if($_POST['httploc'] != NULL){
			$location = $_POST['httploc'];
		}
	}

// Check When To Stop The Banner From Appearing
	if($_POST['stopit'] == 'ignore'){
		$stopit = 'OFF';
	}
	if($_POST['stopit'] == 'hits'){
		$stopit = 'H,' . $_POST['number'];
	}
	if($_POST['stopit'] == 'views'){
		$stopit = 'V,' . $_POST['number'];
	}
	if($_POST['stopit'] == 'date'){
		$stopit = 'D,' . $_POST['id1'];
	}
// Check the prefereed Size of the Banner
	if($_POST['size'] == 'leave'){
		$size = 'NORMAL';
	}

// Check Window Openeing mode
	if($_POST['openin'] == 'new'){
		$openin = '_blank';
	} else {
		$openin = '_parent';
	}

//Update the banner (check first if we have changed the location)

if($location != NULL){
	$update  = @mysql_query("UPDATE banners SET `name`='$name' , `mouseover`='$mouse_over', `location`='$location',`urlto`='$urlto',`stopit`='$stopit',`java_status`='$java_statusbar',`openin`='$openin' WHERE `id`='$id'");
} else {
	$update  = @mysql_query("UPDATE banners SET `name`='$name' , `mouseover`='$mouse_over', `urlto`='$urlto',`stopit`='$stopit',`java_status`='$java_statusbar',`openin`='$openin' WHERE `id`='$id'");
}
	if($update){
		$made = date('m') . '/' . date('d') . '/' . date('Y');
		if($size == 'NORMAL'){
			$width = 'NA';
			$height = 'NA';
		} else {
			$width = $_POST['width'];
			$height = $_POST['height'];
		}
		
		$stat = @mysql_fetch_array(@mysql_query("SELECT * FROM stats WHERE id='$id'"));
		
		$hits = $stat[5];
		$uni_hits = $stat[6];
		$views = $stat[7];
		$uni_views = $stat[8];

		if($location != NULL){
			$update = @mysql_query("UPDATE stats SET `made`='$made',`file_location`='$location',`width`='$width',`length`='$height',`hits`='$hits',`uni_hits`='$hits',`views`='$views',`uni_views`='$uni_views' WHERE `id`='$id'");
		} else {
			$update = @mysql_query("UPDATE stats SET `made`='$made',`width`='$width',`length`='$height',`hits`='$hits',`uni_hits`='$hits',`views`='$views',`uni_views`='$uni_views' WHERE `id`='$id'");
		}	
	}
	
//If everything is complete give appropraite message
	if($update){
		$message = 'Banner: <font color="blue">' . $name . '</font>. Has Been Successfully EDITED.';
	} else {
		$message = 'An Error Occured While Processing Banner, Please Check Your Settings and Ensure that the Database is Setted up!';
	}
}

}

// ----------------------------------- END OF CODING --------------------------------------------------
//Include Page Header
include("header.php");

?>
<form name="editbanner" id="editbanner" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" style="display:inline;">
  <?php
$banner_info = @mysql_fetch_array($get_banner);

// Start To Check Whether its image is located inside the folder or linking it
$loc= explode('/',$banner_info[3]);
if($loc[0] != 'images'){
	$loc1 = 'Checked';
	$loc1a = $banner_info[3];
} else {
	$loc2 = 'Checked';
	$loc2a = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $banner_info[3];
}

//Check The Length of the Banner Life

if($banner_info[5] == 'OFF'){
	$life1 = 'Checked';
}

if($life != 'OFF'){
	$whatis = explode(',',$banner_info[5]);
	
	if($whatis[0] == 'H'){
		
		$life2 = 'Checked';
		$life2a = $whatis[1];
	}
	if($whatis[0] == 'V'){
		$life3 = 'Checked';
		$life2a = $whatis[1];
	}
	if($whatis[0] == 'D'){
		$life4 = 'Checked';
		$life3a = $whatis[1];
	}
	
}
// Check The JavaScript Option
if($banner_info[6] == 'ON'){
	$javaon = 'Checked';
} else {
	$javaoff = 'Checked';
}

//Check The Window Open Mode
if($banner_info[7] == '_blank'){
	$newwin = 'Checked';
} else {
	$samewin = 'Checked';
}

$queryf = "SELECT * FROM stats WHERE `id`='$id'";
$resultf = @mysql_query($queryf);
$banner_infom = @mysql_fetch_array($resultf);

// Start  Size Check
$size = $banner_infom[3];
if($banner_infom[3] == 'NA'){
	$size1 = 'Checked';
	$width = NULL;
	$length = NULL;
} else {
	$size2 = 'Checked';
	$width = $banner_infom[3];
	$length = $banner_infom[4];
}

?>
  <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25"><div align="center"><a href="edit.php" style="text-DECORATION:NONE;">&lt;&lt;&lt; 
          Back To Banner List </a></div></td>
    </tr>
  </table>
  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" bgcolor="#CCCCCC">
    <tr bgcolor="#99CC99"> 
      <td colspan="2"><div align="center"><font size="4"><strong>Editing 
          Banner: <?php echo $banner_info[1];?></strong></font></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2"><strong>Banner 
        Options:</strong></td>
    </tr>
    <tr> 
      <td width="27%"> <div align="left"><strong>Banner 
      Name: </strong></div></td>
      <td width="73%"><input name="name" type="text"  class="input" id="name" value="<?php echo $banner_info[1];?>" size="60">
        <input type="hidden" name="id"  id="id" value="<?php echo $banner_info[0];?>"></td>
    </tr>
    <tr> 
      <td><strong>Mouseover 
        Text:</strong></td>
      <td><input name="mouseover" type="text"  class="input" id="mouseover" value="<?php echo $banner_info[2];?>" size="60"></td>
    </tr>
    <tr> 
      <td><strong>File/HTTP 
        Location:</strong></td>
      <td>
	  <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="26%"><strong> 
              <input name="locationtype" type="radio" class="radio" value="http" <?php echo $loc1;?>>
              Http Location: </strong></td>
            <td width="74%"><input name="httploc" type="text"  class="input" id="httploc" value="<?php echo $loc1a;?>" size="60"></td>
          </tr>
          <tr> 
            <td><strong> 
              <input type="radio" name="locationtype" value="upload" class="radio" <?php echo $loc2;?>>
              Upload File </strong></td>
            <td><input name="filename" type="file" id="filename" size="60"   class="input"></td>
          </tr>
          <tr> 
		  <?php if($loc2 != NULL){ ?>
            <td colspan="2"><div align="center"><strong>Current 
                Stored image:<a href="<?php echo $loc2a;?>" target="_blank"><?php echo $loc2a;?></a></strong></div></td>
				<input type="hidden" name="checkfile" value="<?php echo $loc2a;?>">
          </tr>
		  <?php } ?>
        </table>
      </td>
    </tr>
    <tr> 
      <td><strong>URL To Redirect 
        To:</strong></td>
      <td><input name="urlto" type="text"  class="input" id="urlto" value="<?php echo $banner_info[4];?>" size="60" >
        <strong><a href="<?php echo $banner_info[4];?>" target="_blank" style="text-DECORATION:NONE;">Go To link</a></strong></td>
    </tr>
    <tr> 
      <td><strong>Banner To 
        Stop After:</strong></td>
      <td>        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><strong> 
              <input name="stopit" type="radio" class="radio" value="ignore" <?php echo $life1;?>>
              Ignore</strong></td>
          </tr>
          <tr> 
            <td><strong><strong> 
              After : 
              <input name="number" type="text" class="input" id="hits2" size="7" value="<?php echo $life2a;?>">
                    <strong> 
                    <input name="stopit" type="radio" class="radio" value="hits" <?php echo $life2;?>>
                    </strong> Hits</strong> <strong> 
                    <input name="stopit" type="radio" class="radio" value="views" <?php echo $life3;?>>
                    </strong>Views </strong></td>
          </tr>
          <tr> 
            <td><strong> 
              <input name="stopit" type="radio" class="radio" value="date"  <?php echo $life4;?>>
              <strong>On</strong>: 
              <input name="id1" type="textarea" size="7" value="<?php echo $life3a;?>" />
              <input name="button" type="button" style="background:url(images/cal.gif);width:22;" onClick="c1.popup('id1');"/>
              </strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td><strong>Javascript 
        Status Bar Effect:</strong></td>
      <td><strong><strong> 
        <input name="status" type="radio" class="radio" value="ON" <?php echo $javaon;?>>
        </strong>On <strong> 
        <input name="status" type="radio" class="radio" value="OFF" <?php echo $javaoff;?>>
        </strong>Off</strong></td>
    </tr>
    <tr> 
      <td><strong>Banner Size:</strong></td>
      <td>        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><strong><strong> 
              <input name="size" type="radio" class="radio" value="leave" <?php echo $size1;?>>
              </strong>Oringial Size</strong></td>
          </tr>
          <tr> 
            <td><strong><strong> 
              <input name="size" type="radio" class="radio" value="change"  <?php echo $size2;?>>
              </strong>Change Size To:<strong> Width : 
              <input name="width" type="text" class="input" id="width" value="<?php echo $width;?>" size="10">
              Height: 
              <input name="height" type="text" class="input" id="height" value="<?php echo $length;?>" size="10">
              </strong></strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td><strong>Opening 
        Mode:</strong></td>
      <td><strong>
        <input name="openin" type="radio" class="radio" value="new" <?php echo $newwin;?>>
        New Window 
        <input name="openin" type="radio" class="radio" value="same" <?php echo $samewin;?>>
        Same Window</strong></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"> 
          <input type="submit" name="Submit" value="Save Changes" class="button">
          <input name="submitid" type="hidden" id="submitid" value="2">
      </div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<?php include("footer.php"); ?>
