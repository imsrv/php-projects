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

include("connect.php");


//Get Id Number
$id = $_GET['id'];
$get_banner = @mysql_query("SELECT * FROM banners WHERE `id`='$id'");

//If no banner id exist, or was removed redirect to add banner page
if(@mysql_num_rows($get_banner) <= 0 ){
	header("Location: add.php");
	exit();
}

$banner_info = @mysql_fetch_array(@mysql_query("SELECT * FROM banners WHERE `id`='$id'"));
$name = $banner_info[1];
$urlto = $banner_info[4];
$mouseover = $banner_info[2];
$get_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM stats WHERE `id`='$id'"));
// ----------------------------------- END OF CODING --------------------------------------------------
//Include Page Header
include("header.php");
?>
  <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25"><div align="center"><a href="view.php" style="text-DECORATION:NONE;">&lt;&lt;&lt; 
          Back To Banner List </a></div></td>
    </tr>
  </table>
  
<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
  <tr bgcolor="#99CC99"> 
    <td colspan="2"><div align="center"><font size="4" face="Georgia, Times New Roman, Times, serif"><strong>Viewing 
        Banner Stats For: <?php echo $name;?></strong></font></div></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#000000" face="Georgia, Times New Roman, Times, serif">Banner 
      Stats:</font></strong></td>
  </tr>
  <tr> 
    <td width="29%"> <div align="left"> 
        <p><font face="Georgia, Times New Roman, Times, serif"><strong>Banner 
          Start Date:</strong></font></p>
      </div></td>
    <td width="71%"><strong><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $get_stat[1];?></font></strong></td>
  </tr>
  <tr> 
    <td><font face="Georgia, Times New Roman, Times, serif"><strong> Hits:</strong></font></td>
    <td><strong><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $get_stat[5];?></font></strong></td>
  </tr>
  <tr> 
    <td><p><font face="Georgia, Times New Roman, Times, serif"><strong>Unique 
        Hits:</strong></font></p></td>
    <td><strong><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $get_stat[6];?></font></strong></td>
  </tr>
  <tr> 
    <td><font face="Georgia, Times New Roman, Times, serif"><strong>Views:</strong></font></td>
    <td><strong><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $get_stat[7];?></font></strong></td>
  </tr>
  <tr> 
    <td><font face="Georgia, Times New Roman, Times, serif"><strong>Unique Views:</strong></font></td>
    <td><strong><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $get_stat[8];?></font></strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font face="Georgia, Times New Roman, Times, serif">Sample 
      View: </font></strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> <td colspan="2">
<?php if($get_stat[3] == 'NA' || $get_stat[4] == 'NA'){ ?>
<a href="<?php echo $urlto;?>" target="_blank"><div align="center"><img src="<?php echo $get_stat[2];?>" border="1" alt="<?php echo $mouseover;?>"></div></a>
<?php } else { ?>
<a href="<?php echo $urlto;?>" target="_blank"><div align="center"><img src="<?php echo $get_stat[2];?>" width="<?php echo $get_stat[3];?>" height="<?php echo $get_stat[4];?>" border="1" alt="<?php echo $mouseover;?>"></div></a>
<?php } ?>
    </td>
  </tr>
</table>

<p>&nbsp;</p>
<?php include("footer.php"); ?>