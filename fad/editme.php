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

//include database
include_once("inc/configure.php");

//Get Id Number
$id = $_GET['id'];
if($id == NULL){$id = $_POST['id'];}
$get_banner = @mysql_query("SELECT * FROM `banners` WHERE `id`='$id'");

//If no banner id exist, or was removed redirect to add banner page
if(@mysql_num_rows($get_banner) <= 0 ){
	header("Location: editbanner.php");
	exit();
}

//Get banner info
$banner_info = @mysql_fetch_array($get_banner);

$urlto = $banner_info[4];
$mouseover = $banner_info[2];

//Include header 
require_once ("inc/header.php"); 

$banner_stat = @mysql_query("SELECT * FROM `stats` WHERE `id`='$id'");
$banner_stat_info = @mysql_fetch_array($banner_stat);

// Start  Size Check
$size = $banner_stat_info[3];
if($banner_stat_info[3] == 'NA'){
	$size1 = 'Checked';
	$width = NULL;
	$length = NULL;
} else {
	$size2 = 'Checked';
	$width = $banner_stat_info[3];
	$length = $banner_stat_info[4];
}

//Get the Type Of Banner
if($banner_stat_info[9] == 'NO'){
	$typeb1 = 'Checked';
} else {
	$typeb2 = 'Checked';
}

//Get The Group Name
$groupname = $banner_stat_info[10];

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



?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="25%" valign="top">
      <?php // Get the side menu
	  require_once('inc/side.php');?>
    </td>
    <td width="90%" valign="top"> 
      <table width="100%" border="0" cellspacing="5" cellpadding="5">
        <tr>
          <td><table width="100%" border="1" cellpadding="0" cellspacing="3" bordercolor="#0000FF" >
              <tr> 
                <td><div align="center"><a href="addbanner.php" ><strong>Add 
                  Banner</strong></a></div></td>
                <td><div align="center"><a href="viewbanner.php" ><strong>View 
                  Banner</strong></a></div></td>
                <td><div align="center"><a href="editbanner.php" ><strong>Edit 
                  Banner</strong></a></div></td>
                <td><div align="center"><a href="removebanner.php" ><strong>Remove 
                  Banner</strong></a></div></td>
              </tr>
            </table>
            <p align="justify"><strong><u><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Editing 
              Banner <?php echo $banner_info[1]; ?>:</font></u></strong></p>

            
              <form name="doeditbanner" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><strong><font color="#000000">Current 
                  Banner Information:</font></strong></div></td>
                </tr>
                <tr> 
                  <td width="50%"> <div align="left"><font color="#000000"><strong>Banner 
                  Name: </strong></font></div></td>
                  <td width="50%"><input name="name" type="text"   id="name" value="<?php echo $banner_info[1];?>" size="40"> 
                    <input type="hidden" name="id"  id="id" value="<?php echo $banner_info[0];?>"></td>
                </tr>
                <tr> 
                  <td width="50%"><div align="left"><font color="#000000"><strong>Mouseover 
                      Text: </strong></font></div></td>
                  <td width="50%"><input name="mouseover" type="text"   title="The Mouseover Text Goes Here" id="mouseover" value="<?php echo $banner_info[2];?>" size="40"></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><p align="center"><font color="#000000"><strong>File/HTTP 
                  Location: </strong></font></p></td>
                </tr>
                <tr> 
                  <td colspan="2"><table width="100%" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="50%"><font color="#000000"><strong> 
                          <input name="locationtype" type="radio" title="Choose This If You Want The Banner To Screen From A URL" value="http" <?php echo $loc1;?>>
                          Http Location: </strong></font></td>
                        <td width="50%"><input name="httploc" type="text"   title="Please Enter The URL Location Here" id="httploc" value="<?php echo $loc1a;?>" size="40"></td>
                      </tr>
                      <tr> 
                        <td width="50%"><font color="#000000"><strong> 
                          <input type="radio" name="locationtype" title="Choose This If You Want To Upload The Image For The Banner" value="upload" <?php echo $loc2;?>>
                          Upload File </strong></font></td>
                        <td width="50%"><input name="filename" type="file" title="Please Enter or Browse For The URL Image" id="filename" size="40"   ></td>
                      </tr>
                      <tr> 
                        <?php if($loc2 != NULL){ ?>
                        <td colspan="2"><div align="center"><strong><font color="#000000">Current 
                            Stored image:<a href="<?php echo $loc2a;?>" target="_blank"><?php echo $loc2a;?></a></font></strong></div></td>
                        <input type="hidden" name="checkfile" value="<?php echo $loc2a;?>">
                      </tr>
                      <?php } ?>
                    </table></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><font color="#000000"><strong>URL(Site) 
                  Redirect To:</strong></font> </div></td>
                </tr>
                <tr> 
                  <td colspan="2"><table width="100%" border="0" cellspacing="3" cellpadding="3">
                      <tr> 
                        <td><div align="center"> 
                            <input name="urlto" type="text"   id="urlto4" title="The Link To When A Person Clicks On The Banner Goes" value="<?php echo $banner_info[4];?>" size="40" >
                            <strong><a href="<?php echo $banner_info[4];?>" target="_blank" onMouseOver="return visit()" onMouseOut="return clearit()" class="link">Go 
                            To link</a></strong></div></td>
                      </tr>
                    </table>
                    <div align="center"></div></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><font color="#000000"><strong>Banner 
                  Stop Date:</strong></font></div></td>
                </tr>
                <tr> 
                  <td colspan="2"><table width="100%" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><div align="center"><strong><font color="#000000"> 
                            <input name="stopit" type="radio" title="Choose This Option To Leave The Banner Forever" value="ignore" <?php echo $life1;?>>
                            Ignore</font></strong></div></td>
                      </tr>
                      <tr> 
                        <td><div align="center"><strong><font color="#000000"><strong> 
                            After : 
                            <input name="number" type="text"  title="Enter Hits or Views To Stop At Here" id="number" size="7" value="<?php echo $life2a;?>">
                                      <strong> 
                                      <input name="stopit" type="radio" title="Choose This Option To Stop The Banner After Certain Hits" value="hits" <?php echo $life2;?>>
                                      </strong> Hits</strong> <strong> 
                                      <input name="stopit" type="radio" title="Choose This Option To Stop The Banner After Certain Views" value="views" <?php echo $life3;?>>
                                      </strong>Views </font></strong></div></td>
                      </tr>
                      <tr> 
                        <td><div align="center"><font color="#000000"><strong> 
                            <input name="stopit" type="radio" title="Choose This Option To Stop The Banner On A Certain Date" value="date"  <?php echo $life4;?>>
                            <strong>On</strong>: 
                            <input name="id1" type="textarea" title="Enter The Date To Stop At Here" size="7" value="<?php echo $life3a;?>" />
                            <input name="button" type="button" title="View The CodeThat® Calender Easy Calender" style="background:url(images/cal.gif);width:22;" onClick="c1.popup('id1');"/>
                            </strong></font></div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><font color="#000000"><strong>Javascript 
                    Status Bar Effect:</strong></font></td>
                  <td width="50%"><strong><strong><font color="#000000"> 
                    <input name="status" type="radio" title="Enable Javascipr Status Message For This Banner"   value="ON" <?php echo $javaon;?>>
                    </font></strong><font color="#000000">On <strong> 
                    <input name="status" type="radio" title="Disable Javascipr Status Message For This Banner" value="OFF" <?php echo $javaoff;?>>
                    </strong>Off</font></strong></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><font color="#000000"><strong>Banner 
                  Size: </strong></font></div></td>
                </tr>
                <tr>
                  <td colspan="2"><div align="center">
                      <table width="100%" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><font color="#000000"><strong><strong> 
                            <input name="size" type="radio" title="Choose This Option To Leave Banner At Normal Sizs" value="leave" <?php echo $size1;?>>
                            </strong>Oringial Size</strong></font></td>
                        </tr>
                        <tr> 
                          <td><font color="#000000"><strong><strong> 
                            <input name="size" type="radio" title="Choose This Option To Change The Banner Size" value="change"  <?php echo $size2;?>>
                            </strong>Change Size To:<strong> Width : 
                            <input name="width" type="text"  title="Banner Width Goes Here"   id="width" value="<?php echo $width;?>" size="10">
                            Height: 
                            <input name="height" type="text"  title="Banner Heigth Goes Here" id="height" value="<?php echo $length;?>" size="10">
                            </strong></strong></font></td>
                        </tr>
                      </table>
                    </div></td>
                </tr>
                <tr> 
                  <td><font color="#000000"><strong>Opening 
                    Mode: </strong></font></td>
                  <td width="50%"><strong><font color="#000000"> 
                    <input name="openin" type="radio" value="new" <?php echo $newwin;?>>
                    New Window 
                    <input name="openin" type="radio" value="same" <?php echo $samewin;?>>
                    Same Window</font></strong></td>
                </tr>
                <tr> 
                  <td><font color="#000000"><strong>Banner 
                    Type: </strong></font></td>
                  <td width="50%"><strong><font color="#000000"><strong>
                    <input name="isflash" type="radio"  title="Choose This Option If The Banner Is A Flash Banner"  value="NO" <?php echo $typeb1;?>>
                    Image 
                    <input name="isflash" type="radio"  title="Choose This Option If The Banner Is An Image Banner GIF/PNG/JPG/TIF/ etc.."  value="YES" <?php echo $typeb2;?>>
                    </strong>Flash</font></strong></td>
                </tr>
                <tr> 
                  <td><font color="#000000"><strong>Group 
                    Name: </strong></font></td>
                  <td width="50%"><strong><font color="#000000">

				  <select name="group" id="select"  title="Choose The Group To Which The Banner Is Associated" class="listmenu">
                      <option value="" selected></option>
                      <?php 
					  $group_query = "SELECT * FROM banner_group";
					  $group_result = @mysql_query($group_query);
					  while($group_row = mysql_fetch_array($group_result, MYSQL_NUM)){ 
					  
					  if($group_row[0] == $groupname){ $groupcheck = 'selected'; $test = 'sdsf';} else { $groupcheck= NULL; } 
					   ?>
                      <option value="<?php echo $group_row[0];?>" <?php echo $groupcheck;?>><?php echo $group_row[0];?></option>
					    
                      <?php }
					  ?>
                    </select>

                    </font></strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center">
				  	<input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="5"> 
                      <input type="submit" name="Submit" title="Click Here To Save Changes"  value="Save Changes">
                    </div></td>
                </tr>
              </table>

			</form>
            <p>&nbsp;</p></td>
        </tr>
      </table>
      
    </td>
  </tr>
  <tr align="center"> 
    <td height="28" colspan="2">
      
    </td>
  </tr>
</table>
<?php // get the footer
	  require_once('inc/footer.php');?>