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
//If Form Submitted
if($_POST['submitid'] == 1){
	//Form validation
	if(strlen($_POST['name']) < 3){$message = 'Please enter a name for the banner';}
	if($_POST['locationtype'] == 'http' && strlen($_POST['httploc']) < 3 && $message == NULL){$message = 'Please enter location url.';}
	if($_POST['locationtype'] == 'upload' && $_FILES['filename']['name'] == NULL && $message == NULL){$message = 'Please enter a filename.';}
	if(strlen($_POST['urlto']) < 3 && $message == NULL){$message = 'Please enter a URL location (to direct to).';}
	if($_POST['stopit'] == 'hits' && !is_numeric($_POST['hits'])  && $message == NULL){ $message = 'Invalid Hit amount to stop on.';}
	if($_POST['stopit'] == 'views' && !is_numeric($_POST['views']) && $message == NULL){ $message = 'Invalid Views amount to stop on.';}
	if($_POST['stopit'] == 'date' && is_valid_date($_POST['id1']) == false && $message == NULL){ $message = 'Invalid date to stop on.';}
	if($_POST['size'] == 'change' && !is_numeric($_POST['width']) && !is_numeric($_POST['height']) && $message == NULL){$message = 'Invalid Width/height.';}
	
	if($message == NULL){
	//Variables that do not need checking, just leave them be
	$java_statusbar = $_POST['status'];	
	$name = $_POST['name'];
	$mouse_over = $_POST['mouseover'];
	$urlto = $_POST['urlto'];

	// Check Which Option Choose, Upload Banner or HTTP Link
	if($_POST['locationtype'] == 'upload'){
		$filename = $_FILES['filename']['name'];
		$currentdir = "images";
		
		$expload = explode(".",$filename);
		$ext = $expload[1];
			if(is_file('images/' . $_FILES['filename']['name'])){
				$filename = substr (md5(uniqid(rand(),1)), 3, 5) . '.' .  $ext;
			}
		
		move_uploaded_file($_FILES['filename']['tmp_name'],$currentdir.'/'. $filename);
		$location = DIRTOMANAGER.'images/' . $filename;
	
	} else {
		$location = $_POST['httploc'];
	}

// Check When To Stop The Banner From Appearing
	if($_POST['stopit'] == 'ignore'){
		$stopit = 'OFF';
	}
	if($_POST['stopit'] == 'hits'){
		$stopit = 'H,' . $_POST['hits'];
	}
	if($_POST['stopit'] == 'views'){
		$stopit = 'V,' . $_POST['views'];
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
	
	//Finally Add the banner to the database
	$insert_banner  = @mysql_query("INSERT INTO banners (`name`,`mouseover`,`location`,`urlto`,`stopit`,`java_status`,`openin`) VALUES ('$name','$mouse_over','$location','$urlto','$stopit','$java_statusbar','$openin')");
	// Check If Results Ok, if Yes Insert Stats information

	if($insert_banner){
		$made = date('m') . '/' . date('d') . '/' . date('Y');
		if($size == 'NORMAL'){
			$width = 'NA';
			$height = 'NA';
		} else {
			$width = $_POST['width'];
			$height = $_POST['height'];
		}
		$hits = 0;
		$uni_hits = 0;
		$views = 0;
		$uni_views = 0;
		$get_id = @mysql_fetch_array(@mysql_query("SELECT * FROM `banners` ORDER BY `id` DESC"));
		
		$insert_stat = @mysql_query("INSERT INTO stats (`id`,`made`,`file_location`,`width`,`length`,`hits`,`uni_hits`,`views`,`uni_views`) VALUES ('$get_id[0]','$made','$location','$width','$height','$hits','$uni_hits','$views','$uni_views')");

	}
	//If everything is complete give appropraite message
	if($insert_stat){
		$message = 'Banner: <font color="blue">' . $name . '</font>. Has Been Successfully Installed. The Banner ID is: <font color="blue">' . $get_id[0] . '</font>';
	} else {
		$message = 'An Error Occured While Processing Banner, Please Check Your Settings and Ensure that the Database is Setted up!';
	}
}
	
}
// ----------------------------------- END OF CODING --------------------------------------------------
//Include Page Header
include("header.php");
?>
<form name="addurl" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data">
  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" bgcolor="#CCCCCC">
    <tr bgcolor="#99CC99"> 
      <td colspan="3"><div align="center"><font size="4" face="Georgia, Times New Roman, Times, serif"><strong>Insert 
      A New Banner:</strong></font></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3"><strong><font face="Georgia, Times New Roman, Times, serif">Banner 
        Name:</font></strong></td>
    </tr>
    <tr> 
      <td colspan="3"> <div align="center"> 
          <input name="name" type="text" id="name" value="<?php echo $_POST['name'];?>" size="60"  >
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3"><strong><font face="Georgia, Times New Roman, Times, serif">Banner 
        Mouse Over Text:</font></strong></td>
    </tr>
    <tr> 
      <td colspan="3"> <div align="center"> 
          <input name="mouseover" type="text" id="mouseover" value="<?php echo $_POST['mouseover'];?>" size="60"  >
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3"><strong><font face="Georgia, Times New Roman, Times, serif">Banner 
        Location or HTTP Location:</font></strong></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center"><strong> 
	      <?php if($_POST['locationtype'] == 'http' || $_POST['locationtype'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
          <input name="locationtype" type="radio"  value="http" <?=$sel;?>>
          Http Location 
		  <?php if($_POST['locationtype'] == 'upload'){$sel = 'checked';}else{$sel=NULL;}?>
          <input type="radio" name="locationtype" value="upload" <?=$sel;?>>
          Upload File</strong></div></td>
    </tr>
    <tr> 
      <td width="32%"><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>URL 
          </strong></font></div></td>
      <td colspan="2"><input name="httploc" type="text"   id="httploc" value="<?php echo $_POST['httploc'];?>" size="60"></td>
    </tr>
    <tr> 
      <td><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>File</strong></font></div></td>
      <td colspan="2"><input name="filename" type="file" id="filename" size="60"  ></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3"><div align="left"><font face="Georgia, Times New Roman, Times, serif"><strong>Banner 
      To Redirect To:</strong></font></div></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center"> 
	  <?php if($_POST['urlto'] == NULL){$_POST['urlto'] = 'http://';}?>
          <input name="urlto" type="text"   id="urlto" value="<?php echo $_POST['urlto'];?>" size="60" >
          <font face="Verdana, Arial, Helvetica, sans-serif"><strong>(Enter <font color="#0000FF">EMPTY</font> 
          To Disable Linking)</strong></font></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3"><div align="left"><font face="Georgia, Times New Roman, Times, serif"><strong>Banner 
      Set-up: </strong></font></div></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>When 
          To Stop Banner Viewing:<font face="Georgia, Times New Roman, Times, serif"> 
		  <?php if($_POST['stopit'] == 'ignore' || $_POST['stopit'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
          <input name="stopit" type="radio"  value="ignore" <?=$sel;?>>
          Ignore This Option, Leave Forever</font></strong></font></div></td>
    </tr>
    <tr> 
      <td colspan="2"><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif"> 
        </font></strong></font>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif">
             <?php if($_POST['stopit'] == 'hits' ){$sel = 'checked';}else{$sel=NULL;}?>
			  <input name="stopit" type="radio"  value="hits" <?=$sel;?>>
              </font></strong>&nbsp;</font><font face="Georgia, Times New Roman, Times, serif"><strong>After 
              <input name="hits" type="text"  id="hits2" value="<?php echo $_POST['hits'];?>" size="7">
              Hits</strong></font><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif"> 
              </font></strong></font></td>
            <td width="50%"><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif">
             <?php if($_POST['stopit'] == 'views' ){$sel = 'checked';}else{$sel=NULL;}?>
			  <input name="stopit" type="radio"  value="views" <?=$sel;?>>
              </font>After 
              <input name="views" type="text"  id="views" value="<?php echo $_POST['views'];?>" size="7">
              Views</strong></font></td>
          </tr>
        </table>
        <font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif"> 
        </font></strong></font><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif"> 
        </font></strong></font></td>
      <td width="56%"><font face="Georgia, Times New Roman, Times, serif"> 
	  <?php if($_POST['stopit'] == 'date' ){$sel = 'checked';}else{$sel=NULL;}?>
        <input name="stopit" type="radio"  value="date" <?=$sel;?>>
        <strong>On This Date</strong></font>: 
        <input name="id1" type="textarea" value="<?php echo $_POST['id1'];?>" size="7"/> 
        <input type="button" onClick="c1.popup('id1');" style="background:url(images/cal.gif);width:22;"/> 
      </td>
    </tr>
    <tr> 
      <td colspan="3"><div align="left"><strong><font face="Georgia, Times New Roman, Times, serif">Resize 
          Banner: <strong><font face="Georgia, Times New Roman, Times, serif"> 
		  <?php if($_POST['size'] == 'leave' || $_POST['size'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
          <input name="size" type="radio"  value="leave" <?=$sel;?>>
          </font></strong>Oringial Size -------------------<strong><font face="Georgia, Times New Roman, Times, serif"> 
		  <?php if($_POST['size'] == 'change' ){$sel = 'checked';}else{$sel=NULL;}?>
          <input name="size" type="radio"  value="change" <?=$sel;?>>
          </font></strong>Change Size To:<strong> Width : 
          <input name="width" type="text"  id="width" value="<?php echo $_POST['width'];?>" size="10">
          Height: 
          <input name="height" type="text"  id="height" value="<?php echo $_POST['height'];?>" size="10">
          </strong></font></strong></div></td>
    </tr>
    <tr> 
      <td colspan="2"><strong><font face="Georgia, Times New Roman, Times, serif">Javascript 
        Status Bar Effect:<strong><font face="Georgia, Times New Roman, Times, serif"> 
		 <?php if($_POST['status'] == 'ON' || $_POST['status'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
        <input name="status" type="radio"  value="ON" <?=$sel;?>>
        </font></strong>On <strong><font face="Georgia, Times New Roman, Times, serif"> 
		 <?php if($_POST['status'] == 'OFF' ){$sel = 'checked';}else{$sel=NULL;}?>
        <input name="status" type="radio"  value="OFF" <?=$sel;?>>
        </font></strong>Off</font></strong></td>
      <td><strong><font face="Georgia, Times New Roman, Times, serif">Open In: 
	   <?php if($_POST['openin'] == 'new' || $_POST['openin'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
        <input name="openin" type="radio"  value="new" <?=$sel;?>>
        New Window 
		 <?php if($_POST['openin'] == 'same' ){$sel = 'checked';}else{$sel=NULL;}?>
        <input name="openin" type="radio"  value="same" <?=$sel;?>>
        Same Window</font></strong></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center"> 
          <input type="submit" name="Submit" value="Add Banner" >
          <input name="submitid" type="hidden" id="submitid" value="1">
      </div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<?
// Include Page Footer (please leave alone (it aint bothering you)
include("footer.php"); ?>
