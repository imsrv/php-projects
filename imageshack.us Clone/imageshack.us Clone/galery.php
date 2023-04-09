<?php

// SETTINGS AREA ------------------------------------------------------------------------------------------------------
define("THUMBNAIL_DIRECTORY","thumbs");                               // name of thumbnail directory
define("GALLERY_TITLE","galéria");                             // uAlbum title (right top corner position)
define("TITLE","");                                                   // actual gallery title
define("LOADING_TEXT","Betöltés, várj...");                                  // loading text (showed during image loading)
define("SUBDIRECTORY_THUMBNAIL_DESCRIPTION_FILE","images");           // number of images title
define("SUBDIRECTORY_THUMBNAIL_DESCRIPTION_DATE","date");             // date of directory title
define("SUBDIRECTORY_THUMBNAIL_DESCRIPTION_DATE_FORMAT","d.m.Y");     // date format (PHP) of directory date
define("SLIDESHOW_INTERVAL",5000);                                    // slideshow interval (ms)
define("THUMBNAIL_DIRECTORY_CHMOD",0777);                              // CHMOD used for thumbnail directory
// file sorting
$sort_by_date = false;                                                // enables date/time sorting (default sorting is by name)
$older_first = true;                                                  // older files are showed first (works with names too)

// image sizes (experimental, do not change)
define("LANDSCAPE_X",600);
define("LANDSCAPE_Y",450);
define("VERTICAL_X",337);
define("VERTICAL_Y",450);

define("DIRECTORY_PERMISSION_PROBLEM_TEXT",
       "<strong>uAlbum could not create thumbnail directory</strong>
       <br />Set permissons using CHMOD(777) or contact your server admin");
define("FILE_PERMISSION_PROBLEM_TEXT",
       "<strong>uAlbum could not write thumbnails</strong>
       <br />Set permissons using CHMOD(777) or contact your server admin");
define("GDLIB_PNG_PROBLEM_TEXT",
       "<strong>Warning:</strong> You have not installed GD library or PNG file type is not supported");       
define("GDLIB_GIF_PROBLEM_TEXT",
       "<strong>Warning:</strong> You have not installed GD library or GIF file type is not supported");       
define("GDLIB_JPEG_PROBLEM_TEXT",
       "<strong>Warning:</strong> You have not installed GD library or JPEG file type is not supported");

// SCRIPT AREA ------------------------------------------------------------------------------------------------------

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

// --- FUNCTIONS ---
function generateThumbnail($source,$destination)
{
  $thumbnail=imagecreatetruecolor(90,90); //thumbnail creating
  
  $path_parts = pathinfo($source); // file recognize process
  $extension=$path_parts["extension"];
  $extension = strtolower($extension);

  switch ($extension) 
  {
    case "png":
      if (!function_exists("ImageCreateFromPNG") or !function_exists("ImagePNG")) die (GDLIB_PNG_PROBLEM_TEXT);
      $img=ImageCreateFromPNG($source);
      imageCopyResampled($thumbnail,$img,0,0,0,0,90,90,ImageSX($img),ImageSY($img));
      if (!@ImagePNG($thumbnail,$destination)) die(FILE_PERMISSION_PROBLEM_TEXT);
      break;
    case "gif":
      if (!function_exists("ImageCreateFromGIF") or !function_exists("ImageGIF")) die (GDLIB_GIF_PROBLEM_TEXT);
      $img=ImageCreateFromGIF($source);
      imageCopyResampled($thumbnail,$img,0,0,0,0,90,90,ImageSX($img),ImageSY($img));
      if (!@ImageGIF($thumbnail,$destination)) die(FILE_PERMISSION_PROBLEM_TEXT);;
      break;
    default:
      if (!function_exists("ImageCreateFromJPEG") or !function_exists("ImageJPEG")) die (GDLIB_JPEG_PROBLEM_TEXT);
      $img=ImageCreateFromJPEG($source);
      imageCopyResampled($thumbnail,$img,0,0,0,0,90,90,ImageSX($img),ImageSY($img));
      if (!@ImageJPEG($thumbnail,$destination)) die(FILE_PERMISSION_PROBLEM_TEXT);;    
      break;
  }
}

function dateSortDesc($a, $b)
{
  return (@filemtime($b) - @filemtime($a)); 
}

function dateSortAsc($a, $b)
{
  return (@filemtime($a) - @filemtime($b)); 
}

function readDirectory($dir)
{
  $dir = OpenDir($dir); // open script (.) directory
  $directories = Array(); // initializing directories array
  $files = Array(); // initializing files array
  while ($file = ReadDir($dir)) // loading all files in the script directory
  {
    $path_parts = pathinfo($file); // file recognize process
    $extension=$path_parts["extension"];
    $extension = strtolower($extension);
    if (!Is_Dir($file)) 
    { // testing if file(founded object) is directory
      if ($extension=="jpg" or $extension=="jpeg" or $extension=="png" or $extension=="gif")
      {
        $files[] = $file; // add file into array
      }      
    }
    elseif($file!="." and $file!=".." and $file!=THUMBNAIL_DIRECTORY)
    { // object is directory and we dont want show thumbnail, . or .. directories
      $directories[] = $file; // add directory into array
    }  
  }
  CloseDir($dir); // closing directory
  $output['directories'] = $directories;
  $output['files'] = $files;
  return $output;
}

// --- SCRIPT ---

  $directory_info = readDirectory('.');
  $directories = $directory_info['directories'];
  $files = $directory_info['files'];
  
  // creating thumbnail directory  
  if (!@OpenDir(THUMBNAIL_DIRECTORY)){
    if (!@mkdir(THUMBNAIL_DIRECTORY,THUMBNAIL_DIRECTORY_CHMOD)) die (DIRECTORY_PERMISSION_PROBLEM_TEXT);                                       
  }
  
  // sorting
  if ($sort_by_date==true)
  {
    if ($older_first)
    {
      usort($files, "dateSortAsc");
      usort($directories, "dateSortAsc");
    } 
    else
    { 
      usort($files, "dateSortDesc");
      usort($directories, "dateSortDesc");
    }
  }
  else
  {
    natsort($files);        
    sort($directories);
  }
  reset($files);
  reset($directories);

// --- FILE OPERATIONS ---

  $file_list=""; // string varibale contains filenames
  $thumbnail_list=""; // string variable contains  <a><img></a> construction of thumbnails list (left panel)
  $file_list_size=""; // string variable contains image orientation
  $i=0;
  
  //file array iterateing and generating thumbnails (if doesnt exist) and JS arrays
  foreach ($files as $file)
  {
    if (!file_exists(THUMBNAIL_DIRECTORY."/".$file)) generateThumbnail($file,THUMBNAIL_DIRECTORY."/".$file);
    if ($i!=0 && $i%2==0) $thumbnail_list.="<span class=\"thumb_space\"></span>"; // generating IE space after every two thumbnails
    $thumbnail_list.="<a href=\"#\" class=\"thumb_link\" onclick=\"return setImage(".$i++.");\" onfocus=\"this.blur()\" ><img class=\"thumb_img\" src=\"".THUMBNAIL_DIRECTORY."/".$file."\" alt=\"".$file."\" title=\"".$file."\" height=\"90\" width=\"90\" /></a>\n";
    $resolution=GetImageSize($file); // image resolution detection
    $file_list_size.="'".(integer)($resolution[0]>$resolution[1])."',"; // generating image orientation array (orientation depends on resolution)
    $file_list.="'".$file."',";  // generating array of filenames
  }
  //last dash removing
  $file_list=substr($file_list, 0, -1); 
  $file_list_size=substr($file_list_size, 0, -1); 
  
// --- DIRECTORY OPERATIONS ---
  
  $directory_list = Array();
  foreach ($directories as $directory)
  { 
    $subdirectory_info = readDirectory($directory);
    $subdirectory_files_count = count($subdirectory_info['files']); //number of image files in subdirectory
    if ($subdirectory_files_count!=0) // some image files was founded in subdirectory
    {
      // sorting files in subdirectory
      if ($sort_by_date==true)
      {
        if ($older_first)
        {
          usort($subdirectory_info['files'], "dateSortAsc");
        } 
        else
        { 
          usort($subdirectory_info['files'], "dateSortDesc");
        }
      }
      else
      {    
        natsort($subdirectory_info['files']);
      }
      $subdirectory_date = date(SUBDIRECTORY_THUMBNAIL_DESCRIPTION_DATE_FORMAT,@filemtime($directory));
      $subdirectory_name = str_replace("_"," ",$directory);
      $path_parts = pathinfo($subdirectory_info['files'][0]); // file recognize process
      $extension=strtolower($path_parts["extension"]);
      // generating subdirectory thumbnail
      if (!file_exists(THUMBNAIL_DIRECTORY."/".$directory.".".$extension)) generateThumbnail($directory."/".$subdirectory_info['files'][0],THUMBNAIL_DIRECTORY."/".$directory.".".$extension);
      $directory_list[]= "<div class=\"thumb_folder\">
                            <a href=\"$directory/\" onfocus=\"this.blur()\">
                              <img src=\"".THUMBNAIL_DIRECTORY."/".$directory.".".$extension."\" alt=\"".$directory.".".$extension."\" title=\"".$subdirectory_name."\" height=\"90\" width=\"90\" />
                            </a> 
                            <span class=\"thumb_folder_title\">
                             ".$subdirectory_name."
                            </span>
                            <span class=\"thumb_folder_description\">
                              &nbsp;".SUBDIRECTORY_THUMBNAIL_DESCRIPTION_FILE.": ".$subdirectory_files_count."<br />
                              &nbsp;".SUBDIRECTORY_THUMBNAIL_DESCRIPTION_DATE.": ".$subdirectory_date."
                            </span>
                          </div>";
    }
    else
    {
      $directory_list[]="<a href=\"".$directory."/\" class=\"folder\">
                          <span class=\"title\">".$directory."</span>
                         </a>
                         "; 
    }
  }
  
  // actual directory name detecting and setting gallery name
  $script_name = pathinfo($_SERVER["PHP_SELF"]); 
  $pcs = explode("/", $script_name['dirname']);
  $title = TITLE=="" ? ($pcs[count($pcs)-1] =="" ? "Root directory" : $pcs[count($pcs)-1]) : TITLE;

  // image absolute path detection 
  $script_name_img = pathinfo("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); 
  $imgPath = $script_name_img['dirname'];
  
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta name="description" content="uAlbum - simple one file PHP web gallery by Crempa" />
  <meta name="robots" content="index,follow" />
  <meta name="author" content="Pavel Mica - Crempa" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="PSPad editor, www.pspad.com" />
  <meta name="googlebot" content="snippet,archive" />
  <title>uAlbum</title>
  <!-- gallery css style section-->
  <style type="text/css">
    body{font:0.84em arial, helvetica, sans-serif;margin:0;padding:0;}
    #main{height:100%;min-height:550px;min-width:900px;position:absolute;width:100%;}
    #content{height:540px;left:50%;position:absolute;top:50%;width:900px;margin:-295px 0 0 -450px;padding:0;}
    #content_matroska{border:1px solid #9b9b9b;padding:0;}
    #supplemental{height:550px;visibility:hidden;width:900px;}
    .thumbs{border-right:1px solid #9b9b9b;float:left;height:515px;margin-right:20px;overflow:auto;padding-left:5px;padding-right:0;padding-top:10px;position:relative;width:235px;}
    #canvas{clear:right;height:509px;overflow:auto;margin:0;padding:20px 0 0;}
    h2{float:left;font-size:1em;font-weight:700;width:700px;margin:0;padding:5px 0 5px 8px;}
    h1{background:#9b9b9b;color:#FFF;font-size:1em;font-weight:700;text-align:right;margin:0;padding:5px 5px 5px 0;}
    #title_footer{clear:both;margin:0;padding:0;}
    #canvas a{border:0;color:#9b9b9b;text-decoration:none;margin:0;padding:0;}
    #img_canvas{border:0;min-height:465px;width:1px;z-index:0;margin:0;padding:0;}
    #canvas img{border:1px solid #9b9b9b;margin:0;padding:5px;}
    .thumb_img{border:1px solid #9b9b9b;margin:1px;padding:2px;}
    #menu{font-weight:700;position:relative;top:-5px;}
    #menu_left{display:inline;}
    #signature a{color:#9b9b9b;text-decoration:none;}
    #signature a:hover{color:#4f4f4f;}
    .thumb_space{display:block;line-height:2px;width:200px;}
    .thumbs .folder{border:1px solid #9b9b9b;color:#000;display:block;height:2em;left:-4px;line-height:2em;position:relative;text-decoration:none;width:196px;}
    .thumbs a{border:0;padding:0;}
    .folder .title{background:#FFF;border-left:1px solid #9b9b9b;display:block;font-size:85%;margin:0 0 0 5px;padding:0 0 0 5px;}
    .thumbs .folder:link,.thumbs .folder:visited,.thumbs .folder:active{margin:5px;padding:0;}
    .thumbs .folder:hover{background:#9b9b9b;}
    #no_file_content{border-left:1px solid #9b9b9b;height:520px;}
    h2 .path{font-size:70%;}
    #loader{background:#FFF;border:1px solid #9b9b9b;left:13px;position:relative;top:-450px;width:65px;z-index:1;padding:5px;}
    .none{visibility:hidden;}
    .visible{visibility:visible;}
    #signature{color:#9b9b9b;font-size:80%;text-align:center;margin:0;padding:0;}
    #canvas #slideshow a:link,#canvas #slideshow a:visited,#canvas #slideshow a:active,#canvas #menu_left a:link,#canvas #menu_left a:visited,#canvas #menu_left a:active,#canvas #menu_right a:link,#canvas #menu_right a:visited,#canvas #menu_right a:active{padding:2px;}
    #canvas #slideshow a:hover,#canvas #menu_left a:hover,#canvas #menu_right a:hover{color:#000;padding:2px;}
    #menu_right,#slideshow{display:inline;padding-left:210px;}
    .thumb_folder{width:196px;border:1px solid #9b9b9b;left:1px;position:relative;line-height:12px;margin-bottom:4px;min-height:90px;background:#ececec;padding:2px 0;}
    .thumb_folder a{border:0;text-decoration:none;font-size:85%;color:#000;margin:0;padding:0;}
    .thumbs .thumb_folder a img{text-decoration:none;}
    .thumb_folder a:hover{color:#5b5b5b;text-decoration:underline;}
    .thumb_folder img{float:left;border:0;margin:0 2px;}
    .thumb_folder_description{text-align:left;font-size:85%;}
    .thumb_folder_title{text-align:center;display:block;border-bottom:1px solid #9b9b9b;font-size:0.9em;margin:0 0 5px 94px;padding:2px 0;}
  </style>
 <!--[if IE]> 
  <style type="text/css">
    .thumb_folder{width:198px;margin-bottom:6px;height:96px;}
    #img_canvas{border:1px solid #9b9b9b;padding:5px 5px 2px;}
    .thumbs .thumb_link{border:1px solid #9b9b9b;padding:2px;}
    .thumb_img{border:0;}
    .thumbs .folder{width:198px;}
    #canvas img{border:0;padding:0;}
    .thumbs a{padding-top:5px;}
    #canvas{height:530px;}
    .thumbs{height:527px;}
    .thumb_folder img{margin:0 2px;}
  </style>
  <![endif]-->
  </head>
  <body<?php echo $expresion = count($files)==0 ? "" : " onload=\"setImage(0);\""; ?>>
  <div id="main">
  <div id="supplemental"></div>  
    <div id="content">
    <div id="content_matroska">
    <h2><?php echo $title." <span class=\"path\">[".$script_name['dirname']."]</span>"; ?></h2>
    <h1><?php echo GALLERY_TITLE; ?></h1>
    <div id="title_footer"></div>
    <?php
      // if actual directory doesnt contain relevant files we show all directories in extended mode (full window)
      if (count($files)==0)
      {    
        $col1=Array(); // temp variables for directory index creating
        $col2=Array();
        $col3=Array();
        $i=0;
        foreach ($directory_list as $dir_list)
        {
          $i++;
          switch ($i) {
            case 1: $col1[]=$dir_list;
            break;
            case 2: $col2[]=$dir_list;
            break;
            case 3: $col3[]=$dir_list;
                    $i=0;
            break;
          }
        }
        ?>
          <div class="thumbs">          
            <?
              foreach ($col1 as $col) { // generating directories in first column
                echo $col;
              }
            ?>
          </div>
          <div class="thumbs">          
            <?
              foreach ($col2 as $col) {
                echo $col;
              }
            ?>
          </div>
          <div class="thumbs">          
            <?
              foreach ($col3 as $col) {
                echo $col;
              }
            ?>
          </div>
           <div id="canvas">&nbsp;</div>
            </div><!-- content_matroska end -->
              <div id="signature"> <!-- podpis -->
                <a href="http://ualbum.crempa.net">uAlbum</a>1.3
            </div>
            </div><!-- content end -->
          </div><!-- main end -->
         </body>
        </html>      
        <?
        exit(); // end of script (after generating extended directory index)
      }
      ?>
      <div class="thumbs">
      <a href=".." class="folder"><!-- up directory -->
        <span class="title">&lt;&lt;..</span>
      </a>
         <? // directory index generating
            foreach ($directory_list as $dir_list) {
              echo $dir_list;
            }
          ?>
        <?php
        // including thumbnails
        echo $thumbnail_list;
        ?>
      </div>
      <div id="canvas"><!-- image showing part -->     
          <div id="img_canvas">

            <a id="canvas_link" href="" onfocus="this.blur()" onclick="return!window.open(this.href);">
              <img  src="" id="canvas_img" alt="" title="" height="450" width="600" /> <!-- showed image -->
            </a>
          </div>
        <div id="loader">
          <?php echo LOADING_TEXT; ?>
        </div> 
          <div id="menu">
           
              <div id="menu_left" > <!-- button << -->
                 <a href="#" onclick="return PrevImg();" onfocus="this.blur()"> &lt;Prev  </a>
              </div>  
                             
              <div id="slideshow">
                 <a id="slideshow_link" href="#" onclick="return showSlideshow();" onfocus="this.blur()">start slideshow</a>
              </div>
              
              <div id="menu_right" > <!-- button >> -->
                 <a href="#" onclick="return NextImg();" onfocus="this.blur()">nexT&gt; </a>
              </div> 
              
          </div>
        </div>
           
      </div><!-- content_matroska end -->
      <div id="signature"> <!-- signature -->
        <a href="http://ualbum.crempa.net">uAlbum</a>1.3
    </div>
    </div><!-- content end -->
  </div><!-- main end -->
  
  <script type="text/javascript">
  /* <![CDATA[ */
  var obr = document.getElementById('canvas_img');               // DOM link to image img tag
  var link = document.getElementById('canvas_link');             // DOM link to image link
  
  var Images = new Array (<?php echo $file_list; ?>);            // image filename array (generated by PHP)
  var ImageSizes = new Array (<?php echo $file_list_size; ?>);   // image orientation array (generated by PHP)
  
  var Counter=0;                                                 // counter 
  var numPhotos=<?php echo count($files); ?>;                    // number of images (generated by PHP)
  
  var timerId;                                                   // timer variable
  var slideshow=false;
  var slideshowInterval=<?php echo SLIDESHOW_INTERVAL; ?>;
  obr.onload=setImageSize;
  
  var imgPath="<?php echo $imgPath; ?>"
  myImg = new Image();                                           // virtual image
  var index_id;                                                  // temp variable for image index
  
  function NextImg() {                                           // next image
    Counter++;
    if (Counter<numPhotos){
       setImage(Counter);
    }else{
      if (slideshow==true){
        Counter=0;
        setImage(Counter);
      }
      else{
        Counter=numPhotos;
        window.alert("That's all");
      }
    }
  return false;
  }
  
  function PrevImg() {                                           // previous image
    Counter--;
    if (Counter>-1){
      setImage(Counter);                                         // new image setting
    }else{
      Counter=0;                                                 // counter reset
      window.alert("That's all");                                // allert
    }
  return false;
  }
  
  function ImageChange(){
    document.getElementById("loader").className="none";          // loading text off
    obr.src=myImg.src;                                           // copying virtual image into real image
    Counter=index_id;                                            // actual counter updating
    link.href=Images[index_id];                                  // real image link setting
  }
  
  function setImageSize(){                                       // setting actual image size
    if (ImageSizes[index_id]==1){                                
      obr.width="<?php echo LANDSCAPE_X; ?>";
      obr.height="<?php echo LANDSCAPE_Y; ?>";
    }else{
      obr.width="<?php echo VERTICAL_X; ?>";
      obr.height="<?php echo VERTICAL_Y; ?>";
    }
  }
  
  function setImage(index){                                      // new image setting function
    index_id=index;
    document.getElementById("loader").className="visible";       // loading text on
    myUrl = imgPath+"/"+Images[index_id];                        // new image path setting  
    myImg.src = myUrl;                                           // loading picture into variable
    myImg.onload = ImageChange;                                  // after loading we show image in browsew (ImageChange function)
    return false;  
  }
  
  function showSlideshow(){
    if (slideshow==false){
      timerId = window.setInterval("NextImg()",slideshowInterval);
      document.getElementById("slideshow_link").firstChild.nodeValue="stop slideshow";
      document.getElementById("menu_left").className="none";
      document.getElementById("menu_right").className="none";
      slideshow=true;
    }
    else{
      window.clearInterval(timerId);
      slideshow=false;
      document.getElementById("slideshow_link").firstChild.nodeValue="start slideshow";
      document.getElementById("menu_left").className="visible";
      document.getElementById("menu_right").className="visible";
    }
  }
  setImage(0);
  /* ]]> */
  </script>
  </body>
</html>
