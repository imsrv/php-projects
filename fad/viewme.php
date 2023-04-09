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

//include database
include_once("inc/configure.php");

//Get Id Number
$id = $_GET['id'];
$get_banner = @mysql_query("SELECT * FROM `banners` WHERE `id`='$id'");

//If no banner id exist, or was removed redirect to add banner page
if(@mysql_num_rows($get_banner) <= 0 ){
	header("Location: viewbanner.php");
	exit();
}

//Get banner info
$banner_info = @mysql_fetch_array($get_banner);

$urlto = $banner_info[4];
$mouseover = $banner_info[2];

//Include header 
require_once ("inc/header.php"); 

$banner_stat = @mysql_query("SELECT * FROM `stats` WHERE `id`='$id'");
$banner_stat_info = @mysql_fetch_array($banner_stat);

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
            <p align="justify"><strong><u><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Viewing 
              Banner Stats for <?php echo $banner_info[1]; ?>:</font></u></strong></p>
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font color="#000000" face="Georgia, Times New Roman, Times, serif">Banner 
                Stats: </font></strong></div></td>
              </tr>
              <tr> 
                <td width="50%"> <div align="left"><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Banner 
                    Start Date:</strong></font> </div></td>
                <td width="50%"><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $banner_stat_info[1];?></font></strong></font></td>
              </tr>
              <tr> 
                <td width="50%"><div align="left"><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
                    Hits:</strong></font></div></td>
                <td width="50%"><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $banner_stat_info[5];?></font></strong></font></td>
              </tr>
              <tr> 
                <td width="50%"><p align="left"><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Unique 
                    Hits:</strong></font></p></td>
                <td width="50%"><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $banner_stat_info[6];?></font></strong></font></td>
              </tr>
              <tr> 
                <td width="50%"><div align="left"><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Views:</strong></font></div></td>
                <td width="50%"><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $banner_stat_info[7];?></font></strong></font></td>
              </tr>
              <tr> 
                <td width="50%"><div align="left"><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Unique 
                    Views:</strong></font></div></td>
                <td width="50%"><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#FF00FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $banner_stat_info[8];?></font></strong></font></td>
              </tr>
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font color="#000000" face="Georgia, Times New Roman, Times, serif">Actual 
                View: </font></strong></div></td>
              </tr>
              <tr> 
                <td colspan="2"><?php
			// IF SELECTED BANNER IS NOT A FLASH TYPE	
			if($banner_stat_info[9] == 'NO'){
				if($banner_stat_info[3] == 'NA' || $banner_stat_info[4] == 'NA'){ ?>
					<div align="center"><a href="<?php echo $urlto;?>" target="_blank"><img src="<?php echo $banner_stat_info[2];?>" border="1" alt="<?php echo $mouseover;?>"></a></div>
				<?php } else { ?>
					<div align="center"><a href="<?php echo $urlto;?>" target="_blank"><img src="<?php echo $banner_stat_info[2];?>" width="<?php echo $banner_stat_info[3];?>" height="<?php echo $row[4];?>" border="1" alt="<?php echo $mouseover;?>"></a></div>
				<?php } 
			} else {
			//IF SELECTED BANNER IS A FLASH TYPE
				if($banner_stat_info[3] == 'NA' || $banner_stat_info[4] == 'NA'){ ?>
					<div align="center"><a href="<?php echo $urlto;?>"  title="<?php echo $mouseover;?>" target="_blank"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" >
					<param name="movie" value="<?php echo $banner_stat_info[2];?>">
					<param name="quality" value="high">
					<embed src="<?php echo $banner_stat_info[2];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" ></embed></object>
  					<param name="quality" value="high"><param name="SCALE" value="exactfit"></a></div> 
				<?php } else { ?>
				<div align="center"><a href="<?php echo $urlto;?>"  title="<?php echo $mouseover;?>" target="_blank"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?php echo $banner_stat_info[3];?>" height="<?php echo $row[4];?>">
					<param name="movie" value="<?php echo $banner_stat_info[2];?>">
					<param name="quality" value="high">
					<embed src="<?php echo $banner_stat_info[2];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $banner_stat_info[3];?>" height="<?php echo $row[4];?>"></embed></object></a></div>
  				<?php }
			}				
				
				?>				</td>
              </tr>
            </table>


            <p>&nbsp;</p></td>
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