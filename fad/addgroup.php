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
                <td width="50%"><div align="center"><a href="addgroup.php" ><strong>Add 
                  Group</strong></a></div></td>
                <td width="50%"><div align="center"><a href="removegroup.php"><strong>Remove 
                  Group</strong></a></div></td>
              </tr>
            </table>
            <p><font color="#00000" ><strong><u>Please 
              Enter A New Group Name:</u></strong></font></p>
            <form name="addgroup" id="addgroup" method="post" action="<? echo $_SERVER['PHP_SELF'];?>">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><strong>New 
                  Group:</strong></div></td>
                </tr>
                <tr> 
                  <td width="50%"> <div align="left"><strong>Name:</strong></div></td>
                  <td width="50%"><strong>
                    <input type="text"  name="groupname" id="groupname" title="Enter New Group Name To Add Here">
                    </strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center">
				  	  <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="7">
                      <input type="submit" name="Submit" title="Procced With Group Addition" value="Add Banner Group" >
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