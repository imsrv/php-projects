<?php

/**
 * Use this script to batch generate all main and preview thumbnails for all 
 * galleries. Galleries which contain sub-galleries are skipped as are hidden 
 * galleries.
 *
 * Currently this is a bit of a hack. Hopefully a later version of the script 
 * will be built more robustly using the singapore class to greater advantage.
 * 
 * @author Tamlyn Rhodes <tam at zenology dot co dot uk>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 * @copyright (c)2004 Tamlyn Rhodes
 * @version 0.1
 */

//relative path to the singapore base installation
$basePath = '../';

//remove the built in time limit
set_time_limit(0);

// require main class
require_once $basePath."includes/singapore.class.php";

//create singapore object
$sg = new Singapore($basePath);

function showAllThumbnails($sg, $galleryId)
{
  $dir = $sg->getListing($sg->config->base_path.$sg->config->pathto_galleries.$galleryId.'/',"images");
  
  //if($sg->config->loadConfig($sg->config->base_path.$sg->config->pathto_galleries.$galleryId."/gallery.ini"))
  // $sg->config->loadConfig($sg->config->base_path.$sg->config->pathto_templates.$sg->config->default_template."/template.ini");
  
  echo "Entering <code>$galleryId</code><br />\n";
  
  //if contains subgalleries, recurse
  if(!empty($dir->dirs))
    foreach($dir->dirs as $subgal)
      showAllThumbnails($sg, $galleryId.'/'.$subgal);
  //otherwise display thumbnails
  else
    foreach($dir->files as $image) {
      if($sg->config->full_image_resize) 
        echo $ret  = "<img src=\"".$sg->thumbnailURL(rawurlencode($galleryId), rawurlencode($image),
                                          $sg->config->thumb_width_image,
                                          $sg->config->thumb_height_image,
                                          $sg->config->thumb_force_size_image).'" alt="" />'."\n";
      echo $ret  = "<img src=\"".$sg->thumbnailURL(rawurlencode($galleryId), rawurlencode($image),
                                          $sg->config->thumb_width_album,
                                          $sg->config->thumb_height_album,
                                          $sg->config->thumb_force_size_album).'" alt="" />'."\n";
      echo $ret  = "<img src=\"".$sg->thumbnailURL(rawurlencode($galleryId), rawurlencode($image),
                                          $sg->config->thumb_width_preview,
                                          $sg->config->thumb_height_preview,
                                          $sg->config->thumb_force_size_preview).'" alt="" />'."\n";
      echo "<br />\n";
      
      //trying to generate all thumbnails effectively simultaneously can cause problems
      //this function call pauses execution for a number of microseconds after each image 
      usleep(5000);
      flush();
    }
  echo "Exiting <code>$galleryId</code><br />\n";
  
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Batch thumbnail generator</title>
<!-- 
  This page was generated by singapore <http://singapore.sourceforge.net>
  singapore is free software licensed under the terms of the GNU GPL.
-->
</head>

<body>

<?php
  //start recursive thumbnail generation 
  showAllThumbnails($sg, ".");
?>
</body>
</html>