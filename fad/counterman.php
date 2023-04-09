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
            <p align="justify"><strong><font color="#000000">FAD&reg; Site Manager offers complete counter manager. You can make counters hidden or show them to users (either text or image). You can alter the start count, and make it show page hits (unique) or impressions (all hits). Counters display user's systems, browsers and countries. </font></strong></p>
            <p align="justify"><strong><font color="#000000">To 
            View A Counter Put This Code Portion On Top Of The Page:<font color="#FF0000"><a name="HOWTOCOUNT"></a></font></font></strong></p>
            <table width="100%" border="0" cellspacing="3" cellpadding="3">
              <tr>
                <td><div align="center"><strong><font color="#000000">Then 
                    Put This Line Where You Want To Include The Counter:</font></strong></div></td>
              </tr>
              <tr> 
                <td><div align="center"><strong><font color="#FF0000">&lt;?php</font><font color="#000000"> 
                    <font color="#339933">include(</font><font color="#FF0000">&quot;<?php echo $FAD_DIR;?>counter.php?id=<font color="#00CCFF">XXX</font>&quot;</font><font color="#339933">);</font> <font color="#FF0000">?&gt;</font></font> 
                    </strong></div></td>
              </tr>
            </table>
            <p align="center">&nbsp;</p>
            <p align="justify"><strong><font color="#000000">You 
              Will Need To Only Change <font color="#00CCFF">XXX</font> Which 
              Represents the counter ID.</font></strong></p>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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