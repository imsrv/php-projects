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
            <p><strong><u>Create 
              A New Referral Account:</u></strong></p>
            <form name="addref" id="addref" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:inline;">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><strong>New 
                      Account:</strong></div></td>
                </tr>
                <tr> 
                  <td width="50%"> <div align="left"><strong>Referral 
                  Name: </strong></div></td>
                  <td width="50%"><strong> 
                    <input  name="name" type="text" id="name" title="Enter New Referral Name To Add Here" value="<?php echo $_POST['name'];?>">
                    </strong></td>
                </tr>
                <tr> 
                  <td width="50%" rowspan="2"><strong>End 
                    Users Get Directed To:</strong></td>
                  <td width="50%"><strong>
                    <input name="urlkind" type="radio" value="main" checked>
                    To: <?php echo $SITE_DIR;?></strong></td>
                </tr>
                <tr>
                  <td width="50%"><strong>
                    <input name="urlkind" type="radio" value="other">
                    or To: 
                    <input type="text"  name="urlto" id="urlto" title="Leave This Blank To Redirect To Main Site, Else Type The Adderss To Redirect To Here">
                    </strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="13">
                      <input type="submit" name="Submit" title="Procced With Referral Addition" value="Add Referral" >
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