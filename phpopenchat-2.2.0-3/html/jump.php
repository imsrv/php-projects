<?
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

/**
 * Include default values
 */
include ("defaults_inc.php");

$url=str_replace($INSTALL_DIR."/jump.".$FILE_EXTENSION."?url=","",$REQUEST_URI);
if ((strtolower(substr($url,0,4))!="http")&&(strtolower(substr($url,0,3))!="ftp")){
  $url="http://".$url;
}

echo"
 <HTML><HEAD>
  <META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=$url\">
 </HEAD>
  <BODY>
   <A HREF=\"$url\">$url</A><BR>
  </BODY>
 </HTML>
"?>
