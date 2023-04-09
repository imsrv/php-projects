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

$check_counter = @mysql_query("SELECT * FROM counter_list WHERE `id`='$id'");

if(@mysql_num_rows($check_counter) <= 0){
	header("Location: viewbanner.php");
	exit();
}

$counter_info = @mysql_fetch_array($check_counter);

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
            <p align="justify"><strong><u><font color="#000000">Viewing 
              Counter Stats for <?php echo $check_counter[1]; ?>:</font></u></strong></p>
              
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font color="#000000">Counter 
                Stat:</font></strong></div></td>
              </tr>
               <tr> 
                <td width="50%"><div align="left"><strong><font color="#000000">Counter 
                    Id: </font></strong></div></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[0];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Name:</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[1];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Counter 
                  Type: </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[2];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Is 
                  It Viewable To Visitor's:</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[3];?></font></strong></td>
              </tr>
          
              <tr> 
                <td width="50%"><strong><font color="#000000">Does 
                  It Count User's Uniquely:</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[4];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Unique 
                  Hits: </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[5];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">All 
                  Hits:</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $counter_info[6];?></font></strong></td>
              </tr>
            </table>
 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
			<?php
			//Retreieve System List
			$get_systems = @mysql_fetch_array(@mysql_query("SELECT * FROM `counter_system` WHERE `id`='$id'"));
			?>
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font color="#000000">Counter 
                System Stat:</font></strong></div></td>
              </tr>
              <tr> 
                <td width="50%"><div align="left"><strong><font color="#000000">Windows 
                    3.1</font></strong></div></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[1];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Windows 
                  3.5 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[2];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Windows 
                  3.51 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[3];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Windows 
                  95 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[4];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Windows 
                  98 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[5];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Windows 
                  ME </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[6];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Windows 
                  2000</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[7];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Windows 
                  NT 4.0</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[8];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Windows 
                  XP </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[9];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Linux</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[10];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Macintosh</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[11];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Sun</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[12];?></font></strong></td>
              </tr>
              <tr> 
                <td height="31"><strong><font color="#000000">All 
                  Others</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_systems[13];?></font></strong></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td>&nbsp;</td>
              </tr>
            </table>
			<?php
			//Retreieve browser List
			$get_browser = @mysql_fetch_array(@mysql_query("SELECT * FROM `counter_browser` WHERE `id`='$id'"));
			?>
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font color="#000000">Counter 
                Browser Stat:</font></strong></div></td>
              </tr>
              <tr> 
                <td width="50%"><div align="left"><strong><font color="#000000">Internet 
                    Explorer 4.0</font></strong></div></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[1];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Internet 
                  Explorer 5.0</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[2];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Internet 
                  Explorer 5.5</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[3];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Internet 
                  Explorer 6.0</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[4];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Netscape 
                  4.5</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[5];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Netscape 
                  4.6</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[6];?></font></strong></td>
              </tr>
              <tr> 
                <td width="50%"><strong><font color="#000000">Netscape 
                  4.7</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[7];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Netscape 
                  6.0 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[8];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Netscape 
                  7.0 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[9];?></font></strong></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Mozilla 
                  1.4 </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[10];?></font></strong></td>
              </tr>
              <tr> 
                <td height="13"><strong><font color="#000000">Mozilla 
                  1.5</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[11];?></font></strong></td>
              </tr>
              <tr> 
                <td height="13"><strong><font color="#000000">Mozilla 
                  1.55</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[12];?></font></strong></td>
              </tr>
              <tr> 
                <td height="13"><strong><font color="#000000">Galeon</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[13];?></font></strong></td>
              </tr>
              <tr> 
                <td height="13"><strong><font color="#000000">Konqueror</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[14];?></font></strong></td>
              </tr>
              <tr> 
                <td height="31"><strong><font color="#000000">Opera</font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[15];?></font></strong></td>
              </tr>
              <tr> 
                <td height="31"><strong><font color="#000000">All 
                  Other </font></strong></td>
                <td width="50%"><strong><font color="#FF00FF"><?php echo $get_browser[16];?></font></strong></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td>&nbsp;</td>
              </tr>
            </table>
			<?php
			//Retreieve country List
			$get_countries = @mysql_fetch_array(@mysql_query("SELECT * FROM `counters_countries` WHERE `id`='$id'"));
			?>
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
              <tr bgcolor="#99CC99"> 
                <td colspan="2"><div align="center"><strong><font color="#000000">Counter 
                Country Stat:</font></strong></div></td>
              </tr>
			  <?php
			  $x=0;
			 	foreach ( $get_countries as $key => $value){
					if(($x%2) != 0 && $key != 'id'){
	            	 ?><tr> 
               	 	 <td width="50%"><font color="#000000"><strong><?php echo $key;?></strong></font></td>
               		  <td width="50%"><font color="#FF00FF"><strong><?php echo $value;?></strong></font></td>
                	 </tr>
		     	   <?php }
				   $x++;
				}
				if($x == 0){
			   ?>
			  	<td colspan="2"><div align="center"><strong><font color="#000000"> 
                    There Isn't Any Countries To Display.</font></strong></div></td>
			  
			  <?php }  ?>
            </table>
            
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