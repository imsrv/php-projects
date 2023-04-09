<?php @error_reporting (E_ALL ^ E_NOTICE);

/**
 * 
 * PHP Photo Gallery
 * 
 * Copyright 2003, 2005 Dave Tufts <http://davetufts.com>
 * 
 * @version:      2.1
 * @last_update:  2005-04-05
 * @description:  Simple, easy to use online image gallery
 * @requires:	  PHP 4.1 or higher
 * 
 * @changes:      v2.1  - Converted old markup to CSS standards-based, added previous image link
 * @changes:      v2.0  - Added function to read all files in image directory, added variable check to work with Error Notice reporting
 * @changes:      v1.0  - Initial release
 * 
 * 
 */



/* --------------------------------------------------------------- *
 * USER SETTINGS
 * --------------------------------------------------------------- */

	/* 
	** PAGE TITLE (text string)
	** 
	** will appear at the top of the page
	**
	**/
	$page_title    = "My Photos";
	
	
	/*
	** LEFT CONTENT (text string)
	**
	** Link, description, graphic, etc - will appear in upper left
	**
	**/
	$left_content  = "<a href=\"http://dave.imarc.net/php/\">My Home Page</a>";
	
	
	/*
	** RIGHT CONTENT (text string)
	**
	** Link, description, graphic, etc - will appear in upper right
	**
	**/
	//$right_content = "";
	
		
	/*
	** IMAGE SOURCE (text string)
	**
	** VIRTUAL PATH to the photo gallery images - NO trailing slash
	** Images in this directory must be GIF and JPG files with lowercase '.gif' or '.jpg' extensions
	**
	*/
	$image_dir     = "images";
	
	
	/*
	** NEXT/PREV PHOTO (text string)
	**
	** Defines what will be used as the "Next Photo". Can be image or text
	** $next_photo = "Next"; will suffice, or get fancy with a custom graphic (and img tag)
	**
	*/
	$next_photo    = "Next Photo &gt;";
	$prev_photo    = "&lt; Previous Photo";
	
	
	/* USE_GIFS (bool)
	**
	** If 'use_gifs' is set to 'TRUE', thumnail images will be displayed
	** below the large JPEG image
	**
	** NOTE: Except for their extension, gif files must be named IDENTICAL to JPGs.
	*/
	$use_gifs      = true;
	
	
	/*
	** COLUMNS (integer)
	**
	** below the large photo, is a grid of all other images in the photo
	** gallery - $columns defines how many columns this grid will have
	**
	*/
	$columns       = 5;
	
	
	/* 
	** IMAGES (array)   [OPTIONAL]
	**
	** Array of all image names in the photo gallery. For each
	** item in this array, there should be a jpg and - if $use_gifs is true
	** above - a gif.
	** 
	** There are a couple ways to do this...
	** 
	** [1] Manually create an array (without extensions)
	**     This is the least amount of work for PHP, and a little more work for you:
	** 			$image = array( "image_1", "image_2", "image_3");
	**
	** [2] Manually create an array by copying contents of the directory
	**     A little more work for PHP, easier for you:
	** 			$image = array(	"image_1.gif", "image_1.jpg", 
	** 							"image_2.gif", "image_2.jpg", 
	** 							"image_3.gif", "image_3.jpg");
	**
	** [3] Automatically read your image directory
	** 	   Most work for PHP - easiest for you:
	**			LEAVE $image undefined (comment it out or delete it)
	**
	** Gif and jpg files must be named with ".gif" and ".jpg" extenstion (with lower case extenstion names)
	**
	**/
	//$image = array( "image_1", "image_2", "image_3");


	/* STYLE SHEETS
	**
	** Edit these to control display (see inline comments)
	**
	*/	
	?>

	<style type="text/css" media="all">
	<!--
		.phppgtitleband { /* table, holds $page_title, $left_content, $right_content */
			margin:10px auto 0 auto; 
			padding:0; 
			background-color: #EEE; 
			border: 1px solid #CCC; 
			width: 100%;
			font-size: 90%; 
			}
			.phppgtitleband td {
				width:33%;
				padding: 5px;
				}
		.phppgmainbox { /* holds next/prev links and main image */
			margin:10px auto 0 auto; 
			padding:0; 
			min-height:400px;
			}
		.phppgnextbox { /* holds next and previous links */
			margin-bottom:5px; 
			padding:0;
			text-align:center; 
			}
		.phppgimagebox { /* table, holds main image */
			margin:0 auto 0 auto;
			padding:0;
			}
		.phppgimageframe { /* frame around main image */
			width: auto; 
			border: 1px solid #CCC; 
			background-color: #EEE; 
			padding: 15px 15px 40px 15px;
			}
		.phppgimagetag { /* main image's img tag style */
			border: 1px solid #CCC;
			}
		.phppggifbox { /* table style that holds gif thumbnail's */
			margin:10px auto 0 auto; 
			padding:0; 
			border-collapse:collapse;
			}
			.phppggifbox td {
				padding: 5px; 
				border:1px solid #999;
				border-collapse:collapse;
				text-align:center;
				vertical-align:middle;
				}
	-->
	</style>
	
	<?php




/* --------------------------------------------------------------- *
 * DO NOT EDIT BELOW THIS LINE
 * --------------------------------------------------------------- */	
	
	if (!headers_sent()) {
		print("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\n");
		print("  \"http://www.w3.org/TR/html4/loose.dtd\">\n");
		print("<html>\n");
		print("<head>\n");
		print("  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">\n");
		print("  <title>PHP Photo Gallery</title>\n");
		print("</head>\n");
		print("<body>\n");
		$print_footer = TRUE;
	} else {
		$print_footer = FALSE;
	}



	/* --------------------------------------------------------------- *
	 * SETUP, DEFAULTS, and CHECK SETTINGS
	 * --------------------------------------------------------------- */
	$view       = (isset($_REQUEST['view'])) ? $_REQUEST['view'] : "";
	
	// Check Setup
	if (!isset($image_dir) || !$image_dir) {
		die("Setup Error:<br>The variable <b>\$image_dir</b> (in the 'USER SETTING' section) is not set.");
	}
	if (($image_dir[strlen($image_dir) - 1] == "/") || ($image_dir[strlen($image_dir) - 1] == "\\")) {
		die("Setup Error:<br>The variable <b>\$image_dir</b> (in the 'USER SETTING' section) should <b>not</b> end with a slash");
	}
	if (!is_dir($image_dir)) {
		die("Setup Error:<br>The variable <b>\$image_dir</b> (in the 'USER SETTING' section) must be a directory.");
	}
	
	// Read all files in $image_dir
	if (!isset($image)) {
		$image = phppg_recursive_listdir($image_dir);
	} else {
		array_walk ($image, 'phppg_add_image_dir');
	}
	
	if (!is_array($image) || !count($image)) {
		die("Setup Error:<br>There are no files in the image directory. You specify this direcory in the 'USER SETTINGS' secion as \$image_dir.");
	}
	
	// SECURITY CHECK 
	// Requested $view must contain the REAL PATH of '$image_dir'
	if ($view) {
		$image_dir_path = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . $image_dir); // REALPATH to user specified image directory
		$view_dir_path  = dirname(realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . $view . ".jpg")); // REALPATH to the file we're supposed to be viewing
		if (!$image_dir_path || !$view_dir_path || !stristr($view_dir_path, $image_dir_path)) {
			die("BAD REQUEST<br>Please <a href=\"" . $_SERVER['PHP_SELF'] . "\">go back</a> and request another image");
		}
	}
	
	// Remove ".gif" and ".jpg" extensions - only show unique images
	array_walk ($image, 'phppg_remove_extension');
	$temp_image = array_unique($image);
	$image      = array();
	$i          = 0;
	foreach ($temp_image as $v) { /* reset array keys */
		$image[$i] = $v;
		$i++;
	}
	
	// Defaults 
	if (!isset($columns)    || !(int) $columns) $columns    = 4; 
	if (!isset($view)       || !$view)          $view       = $image[0];
	if (!isset($next_photo) || !$next_photo)    $next_photo = "Next Photo";
	if (!isset($page_title))    $page_title    = "";
	if (!isset($left_content))  $left_content  = "";
	if (!isset($right_content)) $right_content = "";
	if (!isset($use_gifs))      $use_gifs      = false;
	
	
	
	
	
	/* --------------------------------------------------------------- *
	 * TOP NAV AND TITLE
	 * --------------------------------------------------------------- */
	if ($page_title || $left_content || $right_content) {
		?>
		<table class="phppgtitleband">
			<tr>
				<td style="text-align:left;"><?php echo $left_content; ?></td>
				<td style="text-align:center;"><?php echo $page_title; ?></td>
				<td style="text-align:right;"><?php echo $right_content; ?></td>
			</tr>
		</table>
		<?php
	}
	
	
	
	
	
	/* --------------------------------------------------------------- *
	 * DISPLAY - large JPEG IMAGE
	 * --------------------------------------------------------------- */
	//if ($view && (file_exists($image_path . $view . ".jpg"))) {
	if ($view && (file_exists($view . ".jpg"))) {
		$currKey = array_keys ($image, $view);
		$nextKey = $currKey[0] + 1;
		$prevKey = $currKey[0] - 1;
		if (!array_key_exists($nextKey, $image)) $nextKey = 0;
		if (!array_key_exists($prevKey, $image)) $prevKey = (count($image) - 1);
		?>
		
		<div class="phppgmainbox">
			
			<!-- NEXT / PREV LINKS -->
			<?php if ($prev_photo || $next_photo) { ?>
			<div class="phppgnextbox">
				<?php if ($prev_photo) { ?>
					<a href="<?php echo $_SERVER['PHP_SELF'] . "?view=" . $image[$prevKey]; ?>"><?php echo $prev_photo; ?></a>
					&nbsp;&nbsp;
				<?php } ?>
				<?php if ($next_photo) { ?>
					<a href="<?php echo $_SERVER['PHP_SELF'] . "?view=" . $image[$nextKey]; ?>"><?php echo $next_photo; ?></a>
				<?php } ?>
			</div>
			<?php } ?>
			
			
			<!-- MAIN PHOTO -->
			<table class="phppgimagebox"><tr><td>
				<div class="phppgimageframe">
					<img src="<?php echo $view; ?>.jpg" alt="" class="phppgimagetag">
				</div>
			</td></tr></table>
		
		</div>
		<?php
	}
	
	
	
	
	
	/* --------------------------------------------------------------- *
	 * DISPLAY - thumnail GIFs
	 * --------------------------------------------------------------- */
	if ($use_gifs) {
		?>
		<table class="phppggifbox">
			<tr>
				<?php
					$i = 0;
					if (!((int) $columns)) {
						$columns = 4;
					}
					foreach($image as $v) {
						($i % $columns) ? $row = FALSE : $row = TRUE;
						
						if ($i && $row) {
							print("\t</tr>\n");
							print("\t<tr>\n");
						}
						?>
						
						<td><a href="<?php echo $_SERVER['PHP_SELF'] . "?view=" . $v ?>"><img src="<?php echo $v ?>.gif" alt="" border="1"></a></td>
						
						<?php
						$i++;
					}
				?>
			</tr>
		</table>
		<?php
	}

	/* --------------------------------------------------------------- *
	 * FUNCTIONS
	 * --------------------------------------------------------------- */
	
	/**
	** void phppg_remove_extension( (string) value, (string) key)
	** 
	** Used by php function array_walk() to remove ".gif" and ".jpg" 
	** from array values
	** 
	** @param value  (string) array value passed by reference
	** @param key    (string) array key
	** 
	*/
	function phppg_remove_extension(&$value, $key) {
		$value = preg_replace(array("/.gif/i", "/.jpg/i"), "", $value);
	} 

	/**
	** void phppg_add_image_dir( (string) value, (string) key)
	** 
	** Used by php function array_walk() to add the image_dir to all file names
	** Only called if the user manually set up $image array (instead of reading
	** the $image_dir directory with phppg_recursive_listdir()
	** 
	** @param value  (string) array value passed by reference
	** @param key    (string) array key
	** 
	*/
	function phppg_add_image_dir(&$value, $key) {
		global $image_dir;
		$value = $image_dir . "/" . $value;
	} 

	/**
	** array phppg_recursive_listdir( (string) base)
	** 
	** Recursively looks through a directory and returns all items as an array
	** 
	** @param base  (string) base
	** 
	*/
	function phppg_recursive_listdir($base) {
		static $filelist = array();
		static $dirlist  = array();
	
		if(is_dir($base)) {
			$dh = opendir($base);
			while (false !== ($dir = readdir($dh))) {
				if (is_dir($base ."/". $dir) && $dir !== '.' && $dir !== '..') {
					$subbase = $base ."/". $dir;
					$dirlist[] = $subbase;
					$subdirlist = phppg_recursive_listdir($subbase);
				} elseif(is_file($base ."/". $dir) && $dir !== '.' && $dir !== '..') {
					$filelist[] = $base ."/". $dir;
					//$filelist[] = $dir;
				}
			}
			closedir($dh);
		}
		@sort($dirlist);
		@sort($filelist);
		
		$array['dirs'] = $dirlist;
		$array['files'] = $filelist;
		//return $array;
		return $filelist;
	}
	
	if ($print_footer) {
		print("</body>\n");
		print("</html>\n");
	}



/**
<license>

	Copyright (c) 2005 David Tufts
	All rights reserved.
	
	Redistribution and use in source and binary forms, with or without 
	modification, are permitted provided that the following conditions 
	are met:
	
	*	Redistributions of source code must retain the above copyright 
	    notice, this list of conditions and the following disclaimer.
	*	Redistributions in binary form must reproduce the above 
	    copyright notice, this list of conditions and the following 
	    disclaimer in the documentation and/or other materials 
	    provided with the distribution.
	*	Neither the name of iMarc LLC nor the names of its 
	    contributors may be used to endorse or promote products 
	    derived from this software without specific prior 
	    written permission.
	
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND 
	CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
	INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF 
	MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
	DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS 
	BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, 
	EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED 
	TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, 
	DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON 
	ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
	OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY 
	OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
	POSSIBILITY OF SUCH DAMAGE.

</license>
*/
?>