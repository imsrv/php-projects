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

$get_counters = @mysql_query("SELECT * FROM `counter_list`");

if(@mysql_num_rows($get_counters) > 0){
	$showviews = 'Please Select A Banner To Edit:';
} else {
	$showviews = 'There are currently No Banners To Edit!';
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
                <td><div align="center"><a href="addcounter.php" ><strong>Add 
                  Counter</strong></a></div></td>
                <td><div align="center"><a href="viewcounter.php" ><strong>View 
                  Counter</strong></a></div></td>
                <td><div align="center"><a href="editcounter.php" ><strong>Edit 
                  Counter</strong></a></div></td>
                <td><div align="center"><a href="removecounter.php" ><strong>Remove 
                  Counter</strong></a></div></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><div align="right"><a href="counterman.php#HOWTOCOUNT"><strong><em>How 
                    To View A Counter?</em></strong></a></div></td>
              </tr>
              <tr> 
                <td><strong><u><font><?php echo $showviews;?></font></u></strong></td>
              </tr>
            </table>
            <p align="justify">
              <?php 		if(@mysql_num_rows($get_counters) > 0){?>
            </p>
            <form name="editcounter" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#666666"> 
                  <td width="88%" bgcolor="#99CC99"><strong>Banner 
                    List:</strong></td>
                </tr>
                <?php  $garnum =0; //Make sure at least one item is selected
					$issel = NULL;
					while($each_counter = @mysql_fetch_array($get_counters)){ 
						if($garnum == 0){ $issel = 'checked'; } else { $issel =NULL;}
							$garnum = $garnum+1; ?>
                <tr> 
                  <td><div align="left"><strong> 
                      <input name="editme" type="radio" title="Select This Counter To Edit" value="<?php echo $each_counter[0];?>" <?php echo $issel;?>>
                      <?php					   
						   echo $each_counter[1];
					  ?>
                      </strong></div></td>
                </tr>
                <?php } ?>
                <tr> 
                  <td> <div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="reason" type="hidden" value="edit">
                      <input name="submitid" type="hidden" value="10">
                      <input type="submit" name="Submit" value="Edit Selected Counter"  title="Edit Selected Counter" >
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