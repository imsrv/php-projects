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
?>

<TABLE WIDTH=150 BORDER=0 CELLPADDING=0 CELLSPACING=0>
    <tr>


    <td nowrap>
      <?php
        $db=dbConnect();
        $query = 'select imagecomments.* from imagecomments , access, photofile where imagecomments.photo_id = photofile.id and access.dir_id = photofile.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r ="1" order by imagecomments.id desc limit 10';
        $result = mysql_query($query,$db);
        while($myrow = mysql_fetch_array($result))
        {
        echo '<a href="index.php?menu=photos&photo_id='.$myrow['photo_id'].'">'.get_imagename($myrow['photo_id']).'</a> <font color="#000000">Comment by: '.$myrow['name'].'</font><br>'."\n";
        }
        ?>
    </td>

        </tr>



  </TABLE>