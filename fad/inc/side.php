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
?>
<p>&nbsp;</p>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" background="<? echo $IMAGEFOLDER;?>/xp4.gif">
  <tr> 
    <td align="left"><p><a href="bannerman.php" ><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Banner 
        Manager</strong></font></a></p></td>
  </tr>
  <tr> 
    <td align="left"><a href="gbannerman.php"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Banner 
      Group Manager</strong></font></a></td>
  </tr>
  <tr> 
    <td align="left"><a href="counterman.php" ><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Counter 
      Manager</strong></font></a></td>
  </tr>
  <tr> 
    <td align="left"><a href="referralman.php" ><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Referral 
      Manager</strong></font></a></td>
  </tr>
  <tr> 
    <td align="left"><a href="secureman.php" ><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Security 
      Manager</strong></font></a></td>
  </tr>
  <tr> 
    <td align="left"><a href="vul.php" ><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Very 
      Useful Link</strong></font></a></td>
  </tr>
</table>
<?php
if($is_logged == true) { ?>
<table width="25%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><form name="logoff" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:inline;">
        <div align="center">
          <input type="submit" name="Submit" value="Log-Off" title="Click Here To Log-Off System" >
		  <input type="hidden" name="issubmitted" value="yesis">
          <input type="hidden" name="submitid" value="2">
        </div>
      </form></td>
  </tr>
</table>
<?php } ?>