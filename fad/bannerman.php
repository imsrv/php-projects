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
          <td><table width="100%" border="1" cellpadding="0" cellspacing="3" bordercolor="#0000FF">
              <tr> 
                <td><div align="center"><a href="addbanner.php" ><strong>Add 
                  Banner</strong></a></div></td>
                <td><div align="center"><a href="viewbanner.php" ><strong>View 
                  Banner</strong></a></div></td>
                <td><div align="center"><a href="editbanner.php" ><strong>Edit 
                  Banner</strong></a></div></td>
                <td><div align="center"><a href="removebanner.php" ><strong>Remove 
                  Banner</strong></a></div></td>
              </tr>
            </table>
            <p align="justify"><strong><font color="#000000">FAD&reg; Site Manager offers complete Banner Manager. Image or Flash banners 
              can be combined into different unique groups. Banners have many 
              options to when to stop viewing them. Hits, Unique Hits, Views, 
              Unique Views, or on a certain date. The banner manager is very easy 
              to use. To start off a General Group is already installed, you can 
              add, remove, edit , or view banner groups from the side menu.</font></strong></p>
            <p align="justify"><strong><font color="#000000">To 
              start off with the Banner Manager, please select your options from 
              the top menu.</font></strong></p>
            <p align="justify"><font color="#000000"><strong>To 
              View A Banner Group Use This Line Of PHP Code:</strong></font></p>
            <p align="center"><strong><font color="#FF0000"><a name="HOWTOBAN"></a>&lt;?php</font><font color="#000000"> 
              <font color="#339933">include(</font><font color="#FF0000">&quot;<? echo $FAD_DIR;?>viewit.php?group=XXX&quot;</font><font color="#339933">);</font> 
              <font color="#FF0000">?&gt;</font></font></strong></p>
            <p align="justify"><strong><font color="#000000">Where 
              <font color="#FF0000">XXX</font> represents the group name.</font></strong></p>
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
<?php include_once("inc/footer.php");?>