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

$get_counter = @mysql_query("SELECT * FROM counter_list");

if(@mysql_num_rows($get_counter) > 0){
	$showviews = 'Please Select A Banner To View Its Stats:';
} else {
	$showviews = 'There are currently No Banners To View!';
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
                <td><div align="right"><a href="counterman.php#HOWTOCOUNT"><strong><font ><em>How 
                    To View A Counter?</em></font></strong></a></div></td>
              </tr>
              <tr> 
                <td><strong><u><font color="#000000"><?php echo $showviews;?></font></u></strong></td>
              </tr>
            </table>
            <p align="justify">
              <?php 	if(@mysql_num_rows($get_counter) > 0){?>
            </p>
            <form name="viewcounter" id="viewcounter" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:inline;" >
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#666666"> 
                  <td width="88%" bgcolor="#99CC99"><strong bordercolor="#00CCFF"><font color="#000000">Banner 
                    List:</font></strong></td>
                </tr>
                <?php  $garnum =0; //Make sure at least one item is selected
					$issel = NULL;
					while($each_counter = @mysql_fetch_array($get_counter)){ 
						if($garnum == 0){ $issel = 'checked'; } else { $issel =NULL;}
							$garnum = $garnum+1; ?>
                <tr> 
                  <td><div align="left"><strong><font color="#000000"> 
                      <input name="viewme" type="radio" title="Select This Counter To View" value="<?php echo $each_counter[0];?>" <?php echo $issel;?>>
                      <?php					   
						   echo $each_counter[1];
					  ?>
                      </font></strong></div></td>
                </tr>
                <?php } ?>
                <tr> 
                  <td> <div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="reason" type="hidden" value="view">
                      <input name="submitid" type="hidden" value="10">
                      <input type="submit" name="Submit" value="View Counter Stats"  title="View Counter Stats!" >
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