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

$get_ref = @mysql_query("SELECT * FROM `referrals`");

if(@mysql_num_rows($get_ref) > 0){
	$showviews = 'Please Select A Referral To View:';
} else {
	$showviews = 'There are currently No Referrals To View!';
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
            <p align="justify"><strong><u><font color="#00000" ><?php echo $showviews;?></font></u></strong></p>
            <?php 		if(@mysql_num_rows($get_ref) > 0){ ?>
			<form name="viewreferral" id="viewreferral" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:inline;">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#666666"> 
                  <td width="88%" bgcolor="#99CC99"><strong>Referral 
                    List:</strong></td>
                </tr>
                <?php  $garnum =0; //Make sure at least one item is selected
					$issel = NULL;
					while($each_ref = @mysql_fetch_array($get_ref)){ 
						if($garnum == 0){ $issel = 'checked'; } else { $issel =NULL;}
							$garnum = $garnum+1; ?>
                <tr> 
                  <td><div align="left"><strong> 
                      <input name="viewme" type="radio" title="Select This Referral To View"  value="<?php echo $each_ref[0];?>" <?php echo $issel;?>>
                      <?php					   
						   echo $each_ref[1];
					  ?>
                      </strong></div></td>
                </tr>
                <?php } ?>
                <tr> 
                  <td> <div align="center">
                    
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="reason" type="hidden" value="view">
                      <input name="submitid" type="hidden" value="14">
                      <input type="submit" name="Submit" value="View Selected Referral"  title="View Selected Counter" >
                  </div></td>
                </tr>
              </table>
            </form>
			<?php } ?>
            <p align="justify">&nbsp;</p>
            
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