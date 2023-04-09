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
                        if($_SESSION['auth'] && $_SESSION['level']==200 && $_SESSION['progcode']=='squitogallery')
                        {



    $obj = new Photo();
	$obj->set_lang($lang);
    $obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
    $obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['formAction']))
{
if($_POST['form_file_action']=='delete')
{
    if(is_array($_POST['form_move']))
    {
      foreach($_POST['form_move'] as $value)
        $obj->delete_file($value);
    }
    else
    $_SESSION['error'] = 'No files selected';


}
else if($_POST['form_file_action']=='move')
{
    if($_POST['form_move_dest']=='')
    $_SESSION['error'].='No Destination selected'.'<br>';

    if(is_array($_POST['form_move'])&&!$_SESSION['error'])
    {
           foreach($_POST['form_move'] as $value)
           $obj->move_file($value, $_POST['form_move_dest']);
    }
    else
    $_SESSION['error'] .= 'No files selected';
}

}


    $obj->show_admin_file_list($_GET['dir_id']);

         }
         ?>