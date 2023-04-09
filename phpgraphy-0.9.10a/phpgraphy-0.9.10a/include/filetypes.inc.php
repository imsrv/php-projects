<?php
/*
*  Copyright (C) 2000 Christophe Thibault
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
*  $Id: filetypes.inc.php 77 2005-05-27 14:32:47Z jim $
*
*/

// Some filetypes. Feel free to add your own there.

$filetypes=array(

// video filetypes
  array("ext"=>"mov", "mime"=>"video/quicktime", "icon"=>"movie.gif"),
  array("ext"=>"avi", "mime"=>"video/x-msvideo", "icon"=>"movie.gif"),
  array("ext"=>"mpe?g", "mime"=>"video/mpeg", "icon"=>"movie.gif"),
  array("ext"=>"wmv", "mime"=>"video/x-ms-wmv", "icon"=>"movie.gif"),

// sound filetypes
  array("ext"=>"wav", "mime"=>"audio/x-wav", "icon"=>"sound.gif"),
  array("ext"=>"mp3", "mime"=>"audio/mp3", "icon"=>"sound.gif"),

// text filetypes
  array("ext"=>"txt", "mime"=>"text/plain", "icon"=>"text.gif"),
  array("ext"=>"plan", "mime"=>"text/plain", "icon"=>"text.gif"),

// others
  array("ext"=>"eps", "mime"=>"application/postscript", "icon"=>"text.gif"),
  array("ext"=>"ai", "mime"=>"application/postscript", "icon"=>"text.gif"),
  array("ext"=>"ico", "mime"=>"image/x-icon", "icon"=>"text.gif"),
  array("ext"=>"ttf", "mime"=>"application/binary", "icon"=>"text.gif"),
  array("ext"=>"zip", "mime"=>"application/x-zip-compressed", "icon"=>"text.gif"),
  array("ext"=>"gz", "mime"=>"application/x-gzip", "icon"=>"text.gif"),
  array("ext"=>"tar", "mime"=>"application/x-tar", "icon"=>"text.gif"),

);

function is_filetype($name) {
  global $filetypes;
  for($i=0;$i<sizeof($filetypes);$i++) {
    if(eregi($filetypes[$i]["ext"]."$",$name))
      return $filetypes[$i];
  }
  return false;
}

?>
