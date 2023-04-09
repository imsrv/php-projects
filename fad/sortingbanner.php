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
<p><strong><font color="#000000">
<form name="sortbanner" id="sortbanner" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  View Banners of Group: 
  <?php	 $get_banners_show = @mysql_query("SELECT * FROM `banner_group`"); ?>
  <select name="group" id="group"  title="Choose The Group To Which The Banner Is Associated" >
    <option value="" >All Banners</option>
    <?php 
		 while($each_group = mysql_fetch_array($get_banners_show)){ 
		 if($each_group[0] == $_POST['group']){$sel='selected';}else{$se=NULL;}
		 ?>
    		<option value="<?php echo $each_group[0];?>" <?=$sel;?>><?php echo $each_group[0];?></option>
    <?php } ?>
  </select>
  <input type="submit" name="Submit" value="Update">
</form>