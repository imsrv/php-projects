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
include('../config.inc.php');
session_destroy();
//unset($_SESSION['auth']);
//unset($_SESSION['level']);
//unset($_SESSION['attempt']);
//unset($_SESSION['squitouser']);
//unset($_SESSION['squitoid']);
//unset($_SESSION['squitoemail']);
header('Location: http://'. $homeURL.$webimageroot.'/'.$mainfilename);
?>