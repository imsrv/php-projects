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
                <td width="50%" height="21"><div align="center"><a href="addgroup.php" ><strong>Add 
                  Group</strong></a></div></td>
                <td width="50%"><div align="center"><a href="removegroup.php" ><strong>Remove 
                  Group</strong></a></div></td>
              </tr>
            </table>
            <p><font color="#000000"><strong><u>Please 
              Select A Group To Remove:</u></strong></font></p>
            <form name="removegroup" id="removegroup" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr> 
                  <td width="50%"> <div align="left"><strong>Group 
                  Name: </strong></div></td>
                  <td width="50%"><strong> 
				  <?php  
				  	 $get_groups = @mysql_query("SELECT * FROM `banner_group`");
					 if(@mysql_num_rows($get_groups) <= 0){
					 	echo "You have no groups yet!.";
					} else {
					?>
					 <select name="group" id="group"  title="Choose Banner To Remove" >
	                    <?php 
					 while($each_group = mysql_fetch_array($get_groups)){ ?>
		    	        <option value="<?php echo $each_group[0];?>" ><?php echo $each_group[0];?></option>
		                <?php } ?>
			        </select>
					<?php } ?>
                    </strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="8">
                      <input type="submit" name="Submit" title="Procced With Group Addition" value="Remove Selected Group" class="loginbuton">
                    </div></td>
                </tr>
              </table>
            </form>
            <p align="justify">&nbsp;</p>
            <p align="justify">&nbsp;</p></td>
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