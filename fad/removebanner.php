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

if($_POST['group'] == NULL){
	$get_banners = @mysql_query("SELECT * FROM `banners`");
} else {
	$get_banners = @mysql_query("SELECT * FROM `stats` WHERE `group`='$_POST[group]'");
}

if(@mysql_num_rows($get_banners) > 0){
	if($_POST['group'] == NULL){
		$showviews = 'Please Select A Banner To Remove:';
	} else {
		$showviews = 'Viewing Banners Only To (' . $_POST['group'] . ') group:';
	}
} else {
	$showviews = 'There are currently No Banners To Remove!';
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
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><div align="right"><a href="bannerman.php#HOWTOBAN"><strong><em>How 
                    To View A Banner?</em></strong></a></div></td>
              </tr>
              <tr> 
                <td><strong><u><font color="#000000" ><?php echo $showviews;?></font></u></strong></td>
              </tr>
            </table>
            <p align="justify">
              <?php 		if(@mysql_num_rows($get_banners) > 0){
			include("sortingbanner.php"); ?>
            </p>
            <p></p>
            <form name="viewbanner" id="viewbanner" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:inline;">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#666666">
                  <td width="88%" bgcolor="#99CC99"><strong><font color="#000000">Banner List:</font></strong></td>
                </tr>
                <?php  $garnum =0; //Make sure at least one item is selected
					$issel = NULL;
					while($each_banner = @mysql_fetch_array($get_banners)){ 
						if($garnum == 0){ $issel = 'checked'; } else { $issel =NULL;}
							$garnum = $garnum+1; ?>
                <tr>
                  <td><div align="left"><strong><font color="#000000">
                      <input name="removeme" type="radio" title="Select This Banner To View" value="<? echo $each_banner[0];?>" <? echo $issel;?>>
                      <?php
					   if($_POST['group'] == NULL){
						   echo $each_banner[1];
						  } else {
						  	$get_banner_g = @mysql_query("SELECT * FROM `banners` WHERE `id`='$each_banner[0]'");
							$fetch_name = @mysql_fetch_array($get_banner_g);
							echo $fetch_name[1];
						  }
					   
					   ?>
                  </font></strong></div></td>
                </tr>
                <?php } ?>
                <tr>
                  <td>
                    <div align="center">
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="6">
                      <input type="submit" name="Submit" value="Remove selected banner"  title="View Banner Stats!" >
                  </div></td>
                </tr>
              </table>
            </form>
            <?php } ?>
          </td>
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