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

include_once("inc/configure.php");

//Get Id Number

if($_GET['id'] != NULL){
	$id = $_GET['id'];
} else {
	$id = $_POST['id'];
}

$check_id = @mysql_query("SELECT * FROM `referrals` WHERE `id`='$id'");

//If no counter id exist, or was removed redirect to add counter page
if(@mysql_num_rows($check_id) <= 0 ){
	header("Location: editref.php");
	exit();
}
//Include header (which inturn include, page titles )
require_once ("inc/header.php"); 

$editme_stat_rows = @mysql_fetch_array($check_id);

// get the information
if($editme_stat_rows[2] == 'Main'){
	$urlto = $SITE_DIR;
} else {
	$urlto = $editme_stat_rows[2];
}
$name = $editme_stat_rows[1];
$hits = $editme_stat_rows[3];
$credits = $editme_stat_rows[4];
$make = $editme_stat_rows[5];


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
          <td> <table width="100%" border="1" cellpadding="0" cellspacing="3" bordercolor="#0000FF" >
              <tr> 
                <td width="25%"><div align="center"><a href="addref.php" ><strong>Add 
                  Referral</strong></a></div></td>
                <td width="25%"><div align="center"><a href="editref.php" ><strong>Edit 
                  Referral</strong></a></div></td>
                <td width="25%"><div align="center"><a href="viewref.php" ><strong> 
                  Referral Stat</strong></a></div></td>
                <td width="25%"><div align="center"><a href="removeref.php" ><strong>Remove 
                  Referral</strong></a></div></td>
              </tr>
            </table> 
            <p align="justify"><strong><u>Editing 
              Referral <?php echo $editme_stat_rows[1]; ?>:</u></strong></p>

            
              <form name="doeditref" id="doeditref" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display:inline;">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><strong>Current 
                      Referral Information: 
                      <input type="hidden" name="id"  id="id" value="<?php echo $editme_stat_rows[0];?>">
                      </strong></div></td>
                </tr>
   
                <tr> 
                  <td width="50%"> <div align="left"><strong>Counter 
                  ID: </strong></div></td>
                  <td width="50%"><strong><?php echo $editme_stat_rows[0];?> 
                    </strong> </td>
                </tr>
                <tr> 
                  <td width="50%"><div align="left"><strong>Counter 
                      Name: </strong></div></td>
                  <td width="50%"><strong>
                    <input name="name" type="text" class="textboxes" id="name" title="Please Give A Name For The Referral" value="<?php echo $name;?>">
                    </strong></td>
                </tr>
                <tr> 
                  <td><strong>Counter 
                    Directs To: </strong></td>
                  <td width="50%"><strong> 
                    <input name="urlto" type="text" class="textboxes" id="urlto" title="Referral Link Directs To" value="<?php echo $urlto;?>">
                    </strong></td>
                </tr>
                <tr> 
                  <td><strong>Total 
                    Hits: </strong></td>
                  <td width="50%"><strong>
                    <input name="hits" type="text" class="textboxes" id="hits" title="Total Referral Hits" value="<?php echo $hits;?>">
                    </strong></td>
                </tr>
                <tr> 
                  <td><strong>Total 
                    Credits: </strong></td>
                  <td width="50%"><strong>
                    <input name="credits" type="text" class="textboxes" id="credits" title="Total Referral Credits" value="<?php echo $credits;?>">
                    </strong></td>
                </tr>
                <tr> 
                  <td><strong>Start 
                    Date: </strong></td>
                  <td width="50%"><strong>
                    <input name="make" type="text" class="textboxes" id="make" title="Referral Make Date" value="<?php echo $make;?>">
                    </strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="15">
                      <input type="submit" name="Submit" title="Click Here To Save Changes" value="Save Changes">
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