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
                <td width="50%"><div align="center"><a href="removegroup.php" ><strong>Remove 
                  Group</strong></a></div></td>
              </tr>
            </table>
            <p align="justify"><strong><font color="#000000">Group 
              Manager allows you to add and remove groups. Banners should be assigned 
              to groups based on their stats,types,and/or sizes options. </font></strong></p>
            <p align="justify"><font color="#000000"><strong>Proceed with 
              adding or removing a group. Remember to add a banner a group must 
              already be intact (we start you off with a General one). Before removing a group it must not be associated 
              with a banner. There can not exist two groups with the same name.</strong></font></p>
            <p align="justify"><font color="#000000"><strong>To 
              View A Banner Group Use This Line Of PHP Code:</strong></font></p>
            <p align="center"><strong><font color="#FF0000">&lt;?php</font><font color="#000000"> 
              <font color="#339933">include(</font><font color="#FF0000">&quot;<?php echo $FAD_DIR;?>viewit.php?group=XXX&quot;</font><font color="#339933">);</font> 
              <font color="#FF0000">?&gt;</font></font></strong></p>
            <p align="justify"><strong><font color="#000000">Where 
              <font color="#FF0000">XXX</font> represents the group name.</font></strong></p>
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