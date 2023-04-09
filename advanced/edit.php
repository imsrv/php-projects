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

//Check if form submitted
if($_POST['Submit']){
	$id = $_POST['editme'];
	header("Location: editme.php?id=" . $id);
	exit();
}

// ----------------------------------- END OF CODING --------------------------------------------------
//Include Page Header
include("header.php");

?>
<form name="removebanner" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  >
<?php
$get_banners = @mysql_query("SELECT * FROM banners");

if(@mysql_num_rows($get_banners) > 0){

?>
  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" bgcolor="#CCCCCC">
    <tr bgcolor="#9933CC"> 
      <td width="102%" bgcolor="#99CC99"><div align="center"><font size="4" face="Georgia, Times New Roman, Times, serif"><strong>Choose 
      Banner To Edit:</strong></font></div></td>
    </tr>
    <tr bgcolor="#333333"> 
      <td bgcolor="#FFFFFF"><strong>Banner 
        List </strong></td>
    </tr>
    <tr> 
	<?php $garnum =0; //Make sure at least one item is selected
		$issel = NULL;
	while($each_banner = @mysql_fetch_array($get_banners)){
	if($garnum == 0){ $issel = 'checked'; } else { $issel =NULL;}
	$garnum = $garnum+1;
	?>    <td> <div align="left"><strong> 
          <input name="editme" type="radio"  value="<?php echo $each_banner[0];?>" <?php echo $issel;?>>
          <?php echo $each_banner[1];?></strong></div></td>
    </tr>
	<?php } ?>
    <tr> 
      <td height="32"><div align="center"> 
          <input type="submit" name="Submit" value="Edit Banner" >
        </div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<?php } else { ?>
<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" bgcolor="#CCCCCC">
  <tr bgcolor="#9933CC"> 
    <td width="102%" bgcolor="#99CC99"><div align="center"><font size="4" face="Georgia, Times New Roman, Times, serif"><strong>There 
    are currently no Banners to Display!</strong></font></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php } ?>
<?php include("footer.php"); ?>
