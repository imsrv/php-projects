<?php
#########################################################
# Simple Gallery                                        #
#########################################################
#                                                       #
# Created by: Doni Ronquillo                            #
#                                                       #
# This script and all included functions, images,       #
# and documentation are copyright 2003                  #
# free-php.net (http://free-php.net) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
#########################################################

$usernam		     = "";				// MySQL username
$pass			     = "";				// MySQL Password
$db			         = "FreePhpNet";				// MySQL database

$thumbquality        =  100;                		// Thumbnail image quality, range 0 - 100
$im_convert          = "D:/ImageMagick/convert"; 		// Path to the Imagemagick "convert" program

$thumb_width         = 100;
$thumb_height        = 100;

$preview_width       = 400;
$preview_height      = 400;

$gallery_title 		 = "FreePhp Gallery";				// Title of your Gallery
$gallery_description = "description";				// Your Galleries Description
$gallery_keywords 	 = "keywords";					// Your Galleries Keywords

$gallery_bgcolor 	 = "ffffff";						// Your Galleries Background Color
$gallery_text 	  	 = "000000";						// Your Galleries Text Color
$gallery_link  		 = "0000ff";						// Your Galleries Link Color
$gallery_vlink 		 = "0000ff";						// Your Galleries Visited Link Color

$base_dir 		     = "D:/LocalWeb/scripts/SimpleGallery";	// Path to Image Gallery Directory - chmod 777



#################################
# NO CONFIGURATION NEEDED BELOW #
#################################



$conn = mysql_connect("localhost", "$usernam", "$pass") or die("Invalid server or user."); 	// Connects to MySQL Database
mysql_select_db("$db", $conn);

// Print Categories

function print_cat() {

   $do = mysql_query("SELECT * from freephp_gallery_category where parent=0 ORDER by title");

   while($trow = mysql_fetch_array($do)) {

      $res = mysql_query("select * from freephp_gallery where category='$trow[id]'");
      $cnt=mysql_num_rows($res);

      print "<TR><TD><A HREF='gallery.php?cid=$trow[id]'>$trow[title] ($cnt)</A></TD></tR>";
   }
}

// Print Items

function gallery_disp($cid) {

	GLOBAL $username;
	GLOBAL $password;

	$sql="select * from freephp_gallery  where category='$cid' ORDER BY id DESC";
	$query = mysql_query($sql);

	while ($result=mysql_fetch_assoc($query)){


    	echo "

    	<A HREF='preview.php?id=$result[id]'><IMG SRC='images/thumbs/$result[id].jpg' border=0></A><BR>

    	";

    	$r = mysql_query("SELECT username FROM freephp_gallery_admin WHERE username='$username' AND password='$password'");

        if(mysql_num_rows($r) != 0) {

    		echo "
    			<div align=center>
    			<A HREF='item-mod.php?id=$result[id]' class=small> ( Modify Item ) </A><BR>
    			<A HREF='item-del.php?id=$result[id]' class=small> ( Delete Item ) </A><BR>
    			</DIV>


    		";

		} else {

           echo "";

		}
	}
}


?>

