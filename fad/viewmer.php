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

include_once("inc/configure.php");

//Get Id Number
$id = $_GET['id'];
$check_id = @mysql_query("SELECT * FROM `referrals` WHERE `id`='$id'");

//If no counter id exist, or was removed redirect to add counter page
if(@mysql_num_rows($check_id) <= 0 ){
	header("Location: editref.php");
	exit();
}
//Include header (which inturn include, page titles )
require_once ("inc/header.php"); 

$ref_stat_rows = @mysql_fetch_array($check_id);
	
if($ref_stat_rows[2]  == 'Main'){
	$urlto = $SITE_DIR;
} else {
	$urlto = $ref_stat_rows[2];
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
            <p align="justify"><strong><u><font face="Verdana, Arial, Helvetica, sans-serif">Viewing 
              Referral Stats for <?php echo $ref_stat_rows[1]; ?>:</font></u></strong></p>
              
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font >Referral 
                Stat:</font></strong></div></td>
              </tr>
              <tr> 
                <td width="50%"><div align="left"><strong><font >Counter 
                    Id: </font></strong></div></td>
                <td width="50%"><strong><font ><?php echo $ref_stat_rows[0];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font >Name:</font></strong></td>
                <td width="50%"><strong><font ><?php echo $ref_stat_rows[1];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font >Start 
                  Date: </font></strong></td>
                <td width="50%"><strong><font ><?php echo $ref_stat_rows[5];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font >Clicks 
                  From link:</font></strong></td>
                <td width="50%"><strong><font ><?php echo $ref_stat_rows[3];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font >Credits:</font></strong></td>
                <td width="50%"><strong><font ><?php echo $ref_stat_rows[4];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font >Banner 
                  Redirects To:</font></strong></td>
                <td width="50%"><strong><font ><?php echo $urlto;?></font></strong></td>
              </tr>
              <tr> 
                <td colspan="2"><table width="100%" border="0" cellspacing="3" cellpadding="3">
                    <tr>
                      <td><div align="center"><strong>Referral 
                          Link To Use:</strong></div></td>
                    </tr>
                    <tr>
                      <td><div align="center"><strong><?php echo $SITE_DIR . $FAD_DIR . 'ctchrefscr.php?sessionid=' . $id;?></strong></div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
 
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