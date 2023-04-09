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


//counter Id
include_once("inc/configure.php");

//Get Id Number
$id = $_GET['id'];
if($id == NULL){$id = $_POST['id'];}

$check_counter = @mysql_query("SELECT * FROM `counter_list` WHERE `id`='$id'");

if(@mysql_num_rows($check_counter) <= 0){
	header("Location: editcounter.php");
	exit();
}

$counter_info = @mysql_fetch_array($check_counter);

//Include header 
require_once ("inc/header.php"); 

// get the information
$name = $counter_info[1];


if($counter_info[2] == 'Text'){
	$type1 = 'Checked';
} else {
	$type2 = 'Checked';
}

if($counter_info[3] == 'YES'){
	$viewable1 = 'Checked';
} else {
	$viewable2 = 'Checked';
}

if($counter_info[4] == 'YES'){
	$unique1 = 'Checked';
} else {
	$unique2 = 'Checked';
}

$u_hits = $counter_info[5];
$all_hits = $counter_info[6];

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
            <p align="justify"><strong><u><font face="Verdana, Arial, Helvetica, sans-serif">Editing 
              Counter <?php echo $counter_info[1]; ?>:</font></u></strong></p>

            
              <form name="doeditcounter" id="doeditcounter" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display:inline;">
              <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr bgcolor="#99CC99"> 
                  <td colspan="2"><div align="center"><strong>Current 
                      Counter Information:                       
                      <input type="hidden" name="id"  id="id" value="<?php echo $counter_info[0];?>">
                  </strong></div></td>
                </tr>

                <tr> 
                  <td width="50%"> <div align="left"><strong>Counter 
                  ID: </strong></div></td>
                  <td width="50%"><strong><?php echo $counter_info[0];?> </strong> 
                  </td>
                </tr>
                <tr> 
                  <td width="50%"><div align="left"><strong>Counter 
                  Type: </strong></div></td>
                  <td width="50%"><strong>
                    <input name="type"  title="Choose This Option If The Counter Will Be Text Based" type="radio"  value="Text" <?php echo $type1;?>>
                    Text 
                    <input type="radio"  title="Choose This Option If The Counter Will Be Image Based" name="type" value="Image" <?php echo $type2;?>>
                  Image </strong></td>
                </tr>
                <tr> 
                  <td><strong>Counter 
                    Name: </strong></td>
                  <td width="50%"><strong>
                    <input name="name" type="text"  id="name" title="Please Give A Name For The Counter" value="<?php echo $name;?>">
                  </strong></td>
                </tr>
                <tr> 
                  <td><strong>Counter 
                    Unique Hits: </strong></td>
                  <td width="50%"><input name="u_hits" type="text"  id="u_hits" title="The Number The Counter Should Start From" value="<?php echo $u_hits;?>"></td>
                </tr>
                <tr> 
                  <td><strong>Counter 
                    All Hits: </strong></td>
                  <td width="50%"><input name="all_hits" type="text"  id="all_hits" title="The Number The Counter Should Start From" value="<?php echo $all_hits;?>"></td>
                </tr>
                <tr> 
                  <td><strong>Make 
                    Counter Viewable: </strong></td>
                  <td width="50%"><strong><strong>Make 
                    It</strong> 
                    <input name="view"  title="Choose This To Make This Counter Viewable To Clients" type="radio"  value="YES" <?php echo $viewable1;?>>
                    Viewable 
                    <input type="radio"  title="Choose This To Make This Counter Hidden To Clients" name="view" value="NO"  <?php echo $viewable2;?>>
                  Hidden </strong></td>
                </tr>
                <tr> 
                  <td><strong>Counter 
                    Shows Unique or All Hits:</strong></td>
                  <td width="50%"><strong>Show 
                    <input name="unique"  title="Choose This Option To Show Unique Hits For This Counter" type="radio"  value="YES" <?php echo $unique1;?>>
                    Unique Hits 
                    <input type="radio"  title="Choose This Option To Show All Hits For This Counter" name="unique" value="NO"  <?php echo $unique2;?>>
                  All Hits</strong></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <input name="issubmitted" type="hidden" value="yesis">
                      <input name="submitid" type="hidden" value="12">
                      <input type="submit" name="Submit" title="Click Here To Save Changes" value="Save Changes">
                  </div></td>
                </tr>
              </table>

			</form>
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