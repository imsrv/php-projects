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


//Include header (which inturn include, page titles ands connect file)
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
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><div align="right"><a href="counterman.php#HOWTOCOUNT"><strong><font ><em>How 
                    To View A Counter?</em></font></strong></a></div></td>
              </tr>
              <tr> 
                <td><strong><u></u></strong></td>
              </tr>
            </table>
            <form name="makecounter" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onSubmit="return validate_counter_add(this)">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr> 
                  <td width="44%"><strong><font color="#000000">Choose 
                    A Name:</font></strong></td>
                  <td width="44%"><font color="#000000"><strong>
                    <input name="name" type="text" id="name" title="Please Give A Name For The Counter" value="<?php echo $_POST['name'];?>">
                    </strong></font></td>
                </tr>
                <tr>
                  <td width="44%"><strong><font color="#000000">Choose 
                    Counter Type:</font></strong></td>
                  <td><font color="#000000"><strong> 
				  <?php if($_POST['type'] == 'Text' || $_POST['type'] == NULL){$sel='checked';}else{$sel=NULL;}?>
                    <input name="type"  title="Choose This Option If The Counter Will Be Text Based" type="radio" value="Text" <?=$sel;?>>
                    Text 
					<?php if($_POST['type'] == 'Image' ){$sel='checked';}else{$sel=NULL;}?>
                    <input type="radio"  title="Choose This Option If The Counter Will Be Image Based" name="type" value="Image" <?=$sel;?>>
                    Image</strong></font></td>
                </tr>
                <tr> 
                  <td> <div align="left"><strong><font color="#000000">Counter 
                  Starts From:</font></strong> </div></td>
				  <?php if($_POST['start'] == NULL){$_POST['start'] = '0';}?>
                  <td><input name="start" type="text" id="start" title="The Number The Counter Should Start From" value="<?php echo $_POST['start'];?>" maxlength="9"></td>
                </tr>
                <tr> 
                  <td><strong><font color="#000000">Make 
                    Counter Viewable:</font></strong></td>
                  <td><font color="#000000"><strong> 
                    <font color="#000000"><strong>Make 
                    It</strong></font> 
                    <?php if($_POST['view'] == 'YES' || $_POST['type'] == NULL){$sel='checked';}else{$sel=NULL;}?>
                    <input name="view"  title="Choose This To Make This Counter Viewable To Clients" type="radio" value="YES" <?=$sel;?>>
                    Viewable 
                    <?php if($_POST['view'] == 'NO' ){$sel='checked';}else{$sel=NULL;}?>
                    <input type="radio"  title="Choose This To Make This Counter Hidden To Clients" name="view" value="NO" <?=$sel;?>>
                    Hidden </strong></font></td>
                </tr>
                <tr> 
                  <td><strong><font color="#000000">Counter 
                    Shows Unique or All Hits:</font></strong></td>
                  <td><font color="#000000"><strong> 
                    Show 
                          <?php if($_POST['unique'] == 'YES' || $_POST['unique'] == NULL){$sel='checked';}else{$sel=NULL;}?>
                    <input name="unique"  title="Choose This Option To Show Unique Hits For This Counter" type="radio" value="YES" <?=$sel;?>>
                    Unique Hits 
                    <?php if($_POST['unique'] == 'NO' ){$sel='checked';}else{$sel=NULL;}?>
                    <input type="radio"  title="Choose This Option To Show All Hits For This Counter" name="unique" value="NO" <?=$sel;?>>
                    All Hits</strong></font></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="9">
                      <input type="submit" name="Submit" value="Add Counter"  title="Make The Counter Now!" >
                    </div></td>
                </tr>
              </table>
            </form>
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