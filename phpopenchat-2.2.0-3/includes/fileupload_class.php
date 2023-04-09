<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.1              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

class uploader {

  var $file;
  var $errors;
  var $accepted;
  var $new_file;
  var $max_filesize;
  var $max_image_width;
  var $max_image_height;
  
  function max_filesize($size){
    $this->max_filesize = $size;
  }
  
  function max_image_size($width, $height){
    $this->max_image_width = $width;
    $this->max_image_height = $height;
  }
  
  function save_name($save_name){
    $this->save_name = $save_name;
  }
  
  function upload($filename, $accept_type, $extention) {
    // get all the properties of the file
    $accept_types = explode(",", $accept_type);
    
    $index = array("file", "name", "size", "type");
    for($i = 0; $i < 4; $i++) {
      $file_var = '$' . $filename . (($index[$i] != "file") ? "_" . $index[$i] : "");
      eval('global ' . $file_var . ';');
      eval('$this->file[$index[$i]] = ' . $file_var . ';');
    }
    
    if ($this->save_name) {
      ereg("^([^\.]*)\.(.*)$",$this->file["name"],$split);
      $real_ext = $split[2];
      $this->file["name"] = "$this->save_name.$real_ext";
    }
    
    if ($img != "") {
      ereg("^([^\.]*)\.(.*)$",$new_name,$split);
      
      $new_name = $split[1];
      $site .= "<img src='$PATH$img' border=0>";
    }
    
    if($this->file["file"] && $this->file["file"] != "none") {
      //test max size
      if($this->max_filesize && $this->file["size"] > $this->max_filesize) {
	$this->errors[1] = '[KB_ERROR]' . $this->max_filesize/1000 . 'KB';
	return false;
      }
      if(ereg("image", $this->file["type"])) {
	$image = getimagesize($this->file["file"]);
	$this->file["width"] = $image[0];
	$this->file["height"] = $image[1];
	
	// test max image size
	if(($this->max_image_width || $this->max_image_height) && (($this->file["width"] > $this->max_image_width) || ($this->file["height"] > $this->max_image_height))) {
	  $this->errors[2] = '[FS_ERROR]' . $this->file["width"] . ' x ' . $this->file["height"] . ' px';
	  return false;
	}	
	switch($image[2]) {
	case 1:
	  $this->file["extention"] = ".gif";
	  break;
	case 2:
	  $this->file["extention"] = ".jpg";
	  break;
	case 3:
	  $this->file["extention"] = ".png";
	  break;
	default:
	  $this->file["extention"] = $extention;
	  break;
	}
      }
      else if(!ereg("(\.)([a-z0-9]{3,5})$", $this->file["name"]) && !$extention) {
	// add new mime types here
	switch($this->file["type"]) {
	case "text/plain":
	  $this->file["extention"] = ".txt";
	  break;
	default:
	  break;
	}			
      }
      else {
	$this->file["extention"] = $extention;
      }
      
      $incomming_typ = $this->file["type"];		
      // check to see if the file is of type specified
      if($accept_type) {
	$i = count($accept_types) - 1;
	while ( $i >= 0 ) {
	  if(ereg($accept_types[$i], $this->file["type"])) { 
	    $this->accepted = True; 
	  }
	  $i--;
	}
	if ($this->accepted != True) { $this->errors[3] = "[MIME_ERROR] $incomming_typ"; return false;}
      }
      else { $this->accepted = True; }
    }
    else { $this->errors[0] = "No file was uploaded"; }
    return $this->accepted;
  }
  
  function save_file($path, $mode){
    global $NEW_NAME;
    
    if($this->accepted) {
      // very strict naming of file.. only lowercase letters, numbers and underscores
      $new_name = ereg_replace("[^a-z0-9._ßäüöÄÜÖé]", "", ereg_replace(" ", "_", ereg_replace("%20", "_", strtolower($this->file["name"]))));
      
      // check for extention and remove
      if(ereg("(\.)([a-z0-9]{3,5})$", $new_name)) {
	$pos = strrpos($new_name, ".");
	if(!$this->file["extention"]) { $this->file["extention"] = substr($new_name, $pos, strlen($new_name)); }
	$new_name = substr($new_name, 0, $pos);
	
      }
      
      
      $this->new_file = $path . $new_name . $this->file["extention"];
      $NEW_NAME = $new_name . $this->file["extention"];
      
      switch($mode) {
      case 1: // overwrite mode
	$aok = copy($this->file["file"], $this->new_file);
	break;
      case 2: // create new with incremental extention
	while(file_exists($path . $new_name . $copy . $this->file["extention"])) {
	  $copy = "_copy" . $n;
	  $n++;
	}
	$this->new_file = $path . $new_name . $copy . $this->file["extention"];
	$aok = copy($this->file["file"], $this->new_file);
	break;
      case 3: // do nothing if exists, highest protection
	if(file_exists($this->new_file)){
	  $this->errors[4] = "File &quot" . $this->new_file . "&quot already exists";
	}
	else {
	  $aok = rename($this->file["file"], $this->new_file);
	}
	break;
      default:
	break;
      }
      if(!$aok) { unset($this->new_file); }
      return $aok;
    }
  }
}
?>
