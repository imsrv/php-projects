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


//Include header 
require_once ("inc/header.php"); 

$group_query = "SELECT * FROM banner_group";
$group_result = @mysql_query($group_query);
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
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="right"><a href="bannerman.php#HOWTOBAN"><strong><font ><em>How 
                    To View A Banner?</em></font></strong></a></div></td>
              </tr>
              <tr>
                <td><strong><u><font color="#000000">Please 
                  Enter Complete Banner Information:</font></u></strong></td>
              </tr>
            </table>
            <form name="addbanner" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#99CC99"> 
                  <td colspan="3"><strong><font color="#000000">Banner 
                    Name:</font></strong></td>
                </tr>
                <tr> 
                  <td colspan="3"> <div align="center"> 
                      <input name="name" type="text" id="name" value="<?php echo $_POST['name'];?>" size="60"  >
                  </div></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="3"><strong><font color="#000000">Banner 
                    Mouse Over Text:</font></strong></td>
                </tr>
                <tr> 
                  <td colspan="3"> <div align="center"> 
                      <input name="mouseover" type="text" id="mouseover2" value="<?php echo $_POST['mouseover'];?>" size="60"  >
                  </div></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="3"><strong><font color="#000000">Banner 
                    Location or HTTP Location:</font></strong></td>
                </tr>
                <tr> 
                  <td colspan="3"><div align="center"><font color="#000000"><strong> 
                      <?php if($_POST['locationtype'] == 'http' || $_POST['locationtype'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
                      <input name="locationtype" type="radio"  value="http" <?=$sel;?>>
Http Location
<?php if($_POST['locationtype'] == 'upload'){$sel = 'checked';}else{$sel=NULL;}?>
<input type="radio" name="locationtype" value="upload" <?=$sel;?>>
Upload File</strong></font></div></td>
                </tr>
                <tr> 
                  <td width="32%"><div align="center"><font color="#000000"><strong>URL 
                      </strong></font></div></td>
                  <td colspan="2"><input name="httploc" type="text"   id="httploc2" value="<?php echo $_POST['httploc'];?>" size="60"></td>
                </tr>
                <tr> 
                  <td><div align="center"><font color="#000000"><strong>File</strong></font></div></td>
                  <td colspan="2"><input name="filename" type="file" id="filename2" size="60"  ></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="3"><div align="left"><font color="#000000"><strong>Banner 
                  To Redirect To:</strong></font></div></td>
                </tr>
                <tr> 
                  <td colspan="3"> <div align="center"><font color="#000000"> 
                      <?php if($_POST['urlto'] == NULL){$_POST['urlto'] = 'http://';}?>
                      <input name="urlto" type="text"   id="urlto2" value="<?php echo $_POST['urlto'];?>" size="60" >
                      </font></div>
                    <div align="center"><font color="#000000"><strong>(Enter 
                  EMPTY To Disable Linking)</strong></font></div></td>
                </tr>
                <tr bgcolor="#99CC99"> 
                  <td colspan="3"><div align="left"><font color="#000000"><strong>Banner 
                  Set-up: </strong></font></div></td>
                </tr>
                <tr> 
                  <td colspan="3"><div align="center"><font color="#000000"><strong>When 
                      To Stop Banner Viewing: 
                      </strong></font><strong>
                      <?php if($_POST['stopit'] == 'ignore' || $_POST['stopit'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
                      <input name="stopit" type="radio"  value="ignore" <?=$sel;?>>
Ignore This Option, Leave Forever</strong></div></td>
                </tr>
                <tr> 
                  <td colspan="2">                    <table width="100%" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><font color="#000000"><strong> 
                          </strong></font><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif">
                          <?php if($_POST['stopit'] == 'hits' ){$sel = 'checked';}else{$sel=NULL;}?>
                          <input name="stopit" type="radio"  value="hits" <?=$sel;?>>
                          </font></strong></font><font color="#000000">&nbsp;<strong>After 
                          </strong></font><font face="Georgia, Times New Roman, Times, serif"><strong>
                          <input name="hits" type="text"  id="hits" value="<?php echo $_POST['hits'];?>" size="7">
                          </strong></font><font color="#000000"><strong> Hits </strong></font></td>
                        <td width="50%"><font color="#000000"><strong> 
                          </strong></font><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif">
                          <?php if($_POST['stopit'] == 'views' ){$sel = 'checked';}else{$sel=NULL;}?>
                          <input name="stopit" type="radio"  value="views" <?=$sel;?>>
                          </font></strong></font><font color="#000000"><strong>                          After 
                          </strong></font><font face="Georgia, Times New Roman, Times, serif"><strong>
                          <input name="views" type="text"  id="views2" value="<?php echo $_POST['views'];?>" size="7">
                          </strong></font><font color="#000000"><strong> Views</strong></font></td>
                      </tr>
                    </table>                    </td>
                  <td width="56%"><font color="#000000">&nbsp; 
                    </font><font face="Georgia, Times New Roman, Times, serif">
                    <?php if($_POST['stopit'] == 'date' ){$sel = 'checked';}else{$sel=NULL;}?>
                    <input name="stopit" type="radio"  value="date" <?=$sel;?>>
                    </font><font color="#000000"><strong>On This Date</strong>: 
                    <input name="id1" type="textarea" value="<?php echo $_POST['id1'];?>" size="7"/>
                    <input type="button"  title="View The CodeThat® Calender Easy Calender" onClick="c1.popup('id1');" style="background:url(images/cal.gif);width:22;"/>
                    </font></td>
                </tr>
                <tr> 
                  <td colspan="3"><div align="center"><strong><font color="#000000">Banner 
                      Size : </font></strong></div></td>
                </tr>
                <tr> 
                  <td colspan="3"><strong><font color="#000000"><strong> 
                    <font face="Georgia, Times New Roman, Times, serif"> <strong><font face="Georgia, Times New Roman, Times, serif">
                    <?php if($_POST['size'] == 'leave' || $_POST['size'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
                    <input name="size" type="radio"  value="leave" <?=$sel;?>>
                    </font></strong></font>                    </strong>Oringial Size ||<strong> 
                    <font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif">
                    <?php if($_POST['size'] == 'change' ){$sel = 'checked';}else{$sel=NULL;}?>
                    <input name="size" type="radio"  value="change" <?=$sel;?>>
                    </font></strong></font>                    </strong>Change Size To:<strong> Width : 
                    <font face="Georgia, Times New Roman, Times, serif"><strong>
                    <input name="width" type="text"  id="width" value="<?php echo $_POST['width'];?>" size="10">
                    </strong></font>                    Height: 
                    <font face="Georgia, Times New Roman, Times, serif"><strong>
                    <input name="height" type="text"  id="height" value="<?php echo $_POST['height'];?>" size="10">
                    </strong></font>                    </strong></font></strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <table width="100%" border="0" cellspacing="3" cellpadding="3">
                        <tr> 
                          <td><div align="center"><strong><font color="#000000">Javascript 
                              Status Bar Effect:</font></strong></div></td>
                        </tr>
                        <tr> 
                          <td><div align="center"><strong><font color="#000000"><strong> 
                              <strong>
                              <?php if($_POST['status'] == 'ON' || $_POST['status'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
                              <input name="status" type="radio"  value="ON" <?=$sel;?>>
                              </strong>On <strong>
                              <?php if($_POST['status'] == 'OFF' ){$sel = 'checked';}else{$sel=NULL;}?>
                              <input name="status" type="radio"  value="OFF" <?=$sel;?>>
                              </strong>Off</strong></font></strong></div></td>
                        </tr>
                      </table>
                    </div></td>
                  <td><div align="center"> 
                      <table width="100%" border="0" cellspacing="3" cellpadding="3">
                        <tr> 
                          <td><div align="center"><strong><font color="#000000">Open 
                              Banner Link In:</font></strong></div></td>
                        </tr>
                        <tr> 
                          <td><div align="center"><strong> 
                              <?php if($_POST['openin'] == 'new' || $_POST['openin'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
                              <input name="openin" type="radio"  value="new" <?=$sel;?>>
New Window
<?php if($_POST['openin'] == 'same' ){$sel = 'checked';}else{$sel=NULL;}?>
<input name="openin" type="radio"  value="same" <?=$sel;?>>
Same Window</strong></div></td>
                        </tr>
                      </table>
                    </div></td>
                </tr>
                <tr> 
                  <td colspan="2"><strong><font color="#000000">Banner 
                    Type :<strong> 
                    <font color="#000000"><strong><strong>
                    <?php if($_POST['isflash'] == 'ON' || $_POST['isflash'] == NULL){$sel = 'checked';}else{$sel=NULL;}?>
                    </strong></strong></font>
                    <input name="isflash" type="radio"  title="Choose This Option If The Banner Is A Flash Banner"  value="NO" <?=$sel;?>>
                    Image<font color="#000000"><strong><strong>
                    <?php if($_POST['isflash'] == 'YES' ){$sel = 'checked';}else{$sel=NULL;}?>
                    </strong></strong></font>                    <input name="isflash" type="radio"  title="Choose This Option If The Banner Is An Image Banner GIF/PNG/JPG/TIF/ etc.."  value="YES" <?=$sel;?>>
                    </strong>Flash</font></strong></td>
                  <td><strong><font color="#000000">Banner 
                    Group: 
                        <select name="group" id="group"  title="Choose The Group To Which The Banner Is Associated" >
                        <option value="" selected></option>
                        <? 
					  while($group_row = mysql_fetch_array($group_result)){
					  if($_POST['group'] == $group_row[0]){$sel='selected';}else{$sel=NULL;}
					  ?>
                        <option value="<? echo $group_row[0];?>" <?=$sel;?>><? echo $group_row[0];?></option>
                        <? }
					  ?>
                        </select>
                    </font></strong></td>
                </tr>
                <tr> 
                  <td colspan="3"><div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="3">
                      <input type="submit" name="Submit" value="Add Banner"  title="Make The Banner Now!" >
                    </div></td>
                </tr>
              </table>
</form>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
  <tr align="center"> 
    <td height="28" colspan="2">
      <? // get the footer
	  require_once('inc/footer.php');?>
    </td>
  </tr>
</table>
