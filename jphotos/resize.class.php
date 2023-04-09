<?
/*
autor: Jozef Mlich, http://joe.rar.cz
changed: 12.9.2005, ver 1.02
Licence: BSD

-------------------------------------------------------------------------------

Deployment:

// You have to include class and set input image
require_once("resize.class.php");
$thumb=new thumbnail("./input.jpg");			

// you have 5 options for set final size
$thumb->set_max(200);					// set the biggest width or height for thumbnail
$thumb->set_max_w(200);					// resize width (height in same ratio)
$thumb->set_max_h(200);					// resize height (width in same ratio)
$thumb->set_ratio(2);					// thumbnail should have half of width and half of height
$thumb->set_size(640,480);				// set exact width and height

// you can set quality for JPEG compression
$thumb->jpeg_quality(75);				// default = 75

// you can save thumbnail or save it to file
$thumb->process();					// show your thumbnail
$thumb->process("./output.jpg");			// save your thumbnail to file

-------------------------------------------------------------------------------

example code:
require_once("resize.class.php");
$thumb=new thumbnail("./input.jpg");			
$thumb->set_max(200);					// set the biggest width or height for thumbnail
$thumb->process("./output.jpg");			// save your thumbnail to file

-------------------------------------------------------------------------------

Note :
- GD must be Enabled
- If your GD not support 'ImageCreateTrueColor' function,
  change one line from 'ImageCreateTrueColor' to 'ImageCreate'
*/


class thumbnail {

var $srcfile, $destfile,
    $src, $dest,
    $size,                // [width, height, image type, mime type ,<img ...>]
    $t_width, $t_height,  // new size
    $quality;

var $notexists     = "file not exists !";
var $unknow_format = "unknown format !";
var $warning_icon  = "./images/warning.gif";

function thumbnail($srcfile) {
  $this->srcfile = $srcfile;
  if (!file_exists($srcfile)) {
    $this->size[0] = "220";
    $this->size[1] = "60";
    $this->size[2] = 2;
    $this->size["mime"] = "image/jpeg";
    $this->src = ImageCreate($this->size[0],$this->size[1]);

    /* inserting warning icon */
    $tmp_size = @getimagesize($this->warning_icon);
    $tmp_im = @ImageCreateFromGIF($this->warning_icon);
    ImageColorAllocate ($this->src, 255, 255, 255);
    @ImageCopyResampled ($this->src, $tmp_im, 10, 12, 0, 0, $tmp_size[0], $tmp_size[1], $tmp_size[0], $tmp_size[1]);

    /* writing warning text */
    ImageString ($this->src,6,55,20,$this->notexists,ImageColorAllocate ($this->src, 0, 0, 0));
    return;
  }

  $this->size = @getimagesize($srcfile);
  switch($this->size[2]) {
    case 1:
      $this->src = ImageCreateFromGIF($srcfile);
    break;
    case 2:
      $this->src = ImageCreateFromJPEG($srcfile);
    break;
    case 3:
      $this->src = ImageCreateFromPNG($srcfile);
    break;
    case 4:
      $this->src = ImageCreateFromSWF($srcfile);
    break;
    default:
      $this->size[0] = "220";
      $this->size[1] = "60";
      $this->size[2] = 2;
      $this->size["mime"] = "image/jpeg";
      $this->src = ImageCreate($this->size[0],$this->size[1]);

      /* inserting warning icon */
      $tmp_size = @getimagesize($this->warning_icon);
      $tmp_im = @ImageCreateFromGIF($this->warning_icon);
      ImageColorAllocate ($this->src, 255, 255, 255);
      @ImageCopyResampled ($this->src, $tmp_im, 10, 12, 0, 0, $tmp_size[0], $tmp_size[1], $tmp_size[0], $tmp_size[1]);

      /* writing warning text */
      ImageString ($this->src,8,55,20,$this->unknow_format,ImageColorAllocate ($this->src, 0, 0, 0));
    break;
  }
}

function set_max($new_size) {
  ($this->size[0] > $this->size[1]) ? ($this->set_ratio($this->size[0]/$new_size)) : ($this->set_ratio($this->size[1]/$new_size));
}

function set_max_h($h) {
  $this->set_ratio($this->size[0]/$h);
}

function set_max_w($w) {
  $this->set_ratio($this->size[1]/$w);
}

function set_size($h, $w) {
  $this->t_width = $w;
  $this->t_height = $h;
}

function set_ratio($koef) {
  $this->t_width = (integer)($this->size[1]/$koef);
  $this->t_height = (integer)($this->size[0]/$koef);
}

function jpeg_quality($quality=75) {
  if (!isset($this->quality)) {
    $this->quality = $quality;
  }
}

function process($thumbfile=NULL) {
  if(!isset($this->t_width)) {
   $this->set_ratio(2);
  }

  $this->dest = ImageCreateTrueColor($this->t_height, $this->t_width);
//  $this->dest = ImageCreate($this->t_height, $this->t_width);
  ImageCopyResampled ($this->dest, $this->src, 0, 0, 0, 0, $this->t_height, $this->t_width, $this->size[0], $this->size[1]);
// $this->dest = $this->src;

  if (!isset($thumbfile)) {
    Header("Content-Type: ".$this->size["mime"]);
  }


  $this->destfile = $thumbfile;

  switch ($this->size['2']) {
    case 1:
//      die("<a href=\"http:\\\\www.boutel.com\\gd\\\">check GIF support and uncomment me!</a>");
      ImageGIF($this->dest, $this->destfile);
    break;
    case 2:
      $this->jpeg_quality();
      ImageJPEG($this->dest, $this->destfile,$this->quality);
    break;
    case 3:
      ImagePNG($this->dest, $this->destfile);
    break;
    case 4:
      ImageSWF($this->dest, $this->destfile);
    break;
  }

}

} /* end of class */

?>
