<?php
/*
    
	Squito Gallery 1.33
    Copyright (C) 2002-2003  SquitoSoft and Tim Stauffer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
session_start();
include('squitofns.inc.php');
$registered_types = array(
    "application/x-gzip-compressed"     => ".tar.gz, .tgz",
    "application/x-zip-compressed"         => ".zip",
    "application/x-tar"            => ".tar",
    "text/plain"                => ".html, .php, .txt, .inc (etc)",
    "image/bmp"                 => ".bmp, .ico",
    "image/gif"                 => ".gif",
    "image/pjpeg"                => ".jpg, .jpeg",
    "image/jpeg"                => ".jpg, .jpeg",
    "application/x-shockwave-flash"     => ".swf",
    "application/msword"            => ".doc",
    "application/vnd.ms-excel"        => ".xls",
    "application/octet-stream"        => ".exe, .fla (etc)"
);
$allowed_types = array("image/bmp","image/gif","image/pjpeg","image/jpeg");
  $_SESSION['error'] = validate_upload($allowed_types,$registered_types);
if(!$_SESSION['error'])
{
$uploaded_file =handleupload($_POST['form_imagedir'],$imagemagickpath,1);
header("location: $homeURL");
}
else
header("location: ".$_SESSION['lastpage']);