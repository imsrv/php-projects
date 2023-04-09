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
class Photo
{
   var $host, $user, $pass, $db, $default_uploads, $table, $per_row, $per_col, $webroot, $photoroot, $imagedir, $thumbdir, $dbconnection;


function set_db($host, $user, $pass, $db, $table)
{
  $this->host = $host;
  $this->user = $user;
  $this->pass = $pass;
  $this->db = $db;
  $this->table = $table;


}
function set_lang($lang)
{
 $this->lang = $lang;
}
function get_default_uploads()
{
 $query = 'select default_uploads from prefs where id=1';
 $result = $this->query($query);
 $myrow = mysql_fetch_array($result);
 $this->default_uploads = $myrow[0];
}
function get_defaults()
{
$query = 'select * from prefs limit 1';
$result=$this->query($query);
return mysql_fetch_array($result);
}

function read_in_dir($changedir, $file_or_dir)
{
     //echo $changedir;
         chdir($changedir);
                        if ($dir = opendir("."))
                        {

                                //$count = 0;
                                //$countto = 3;
                                $i=0;
								$fileArray = array();
								$dirArray = array();
                                while($file = readdir($dir))
                                {

                                        if($file!=".." && $file!=".")
                                        {
                                                if(!(is_dir("$file")))
                                                {

                                                $fileArray[count($fileArray)] = $file;

                                                }
                                                else
                                                {
                                                $dirArray[count($dirArray)] = $file;
                                                }
                                       }
                                       $i++;
                                 }
                                closedir($dir);
                                                }
                                                                if($file_or_dir == 'file')
                                                                return $fileArray;
                                                                if($file_or_dir == 'dir')
                                                                return $dirArray;

}
function upload_icon_form($id)
{
?>
    <form action="" method="post" name="uploadIcon" ENCTYPE="multipart/form-data">
    Upload Icon: <input type="file" name="form_file"> <input type="submit" name="subUploadicon" value="upload"></form><br>
<?php

}
function update_description($id,$description)
{
$query = 'update photodir set description = "'.addslashes($description).'" where id ="'.$id.'"';
$this->query($query);

}
function show_change_icon_form($id,$file_in_dir)
{
$dir = $this->recursive_path($id);
$query = 'select icon,inlist,icon_id from photodir where id = "'.$id.'"';
$result = $this->query($query);
$myrow=mysql_fetch_array($result);
if(!isset($file_in_dir))
if($myrow['inlist']) $file_in_dir = $myrow['inlist'];
echo '<form name="changeIcon" action="" method="post"><table cellpadding="5" cellspacing="0">';
$icons = $this->read_in_dir($this->photoroot.'icons/','file');
if($file_in_dir)
{
$query = 'select id,filename from photofile where dir_id = "'.$id.'"';
$result = $this->query($query);
if(!mysql_num_rows($result)) echo '<i>No files in album</i>';
else echo '<input type="hidden" name="inlist" value="1">';
while($row=mysql_fetch_array($result))
{
?>
<tr><td><input type="radio" name="form_icon" value="<?php echo $row['id'];?>"<?php if($myrow['icon_id']==$row['id']) echo 'checked';?>></td><td><img src="<?php echo $this->webroot.'/'.$this->thumbdir.$dir.$this->get_image_dirname($row['id']).$this->get_imagename($row['id']);?>"></td><td valign="top"></td></tr>
<?php
echo '<tr><td height="1" bgcolor="#000000" colspan="3"></td></tr>';
}
}
else
{
for($x=0; $x<sizeof($icons); $x++)
{
?>
<tr><td><input type="radio" name="form_icon" value="<?php echo $icons[$x];?>"<?php if($icons[$x]==$myrow['icon']) echo 'checked';?>></td><td><img src="<?php echo $this->webroot.'/icons/'.$icons[$x];?>"></td><td valign="top"><?php echo $icons[$x];?></td></tr><?php
echo '<tr><td height="1" bgcolor="#000000" colspan="3"></td></tr>';
}
}
echo '</table><br><input type="submit" name="submit" value="Save"></form>';
if($file_in_dir==0) echo '<a href="'.$_SERVER['PHP_SELF'].'?dir_id='.$id.'&inlist=1">Select from from album</a>';
else echo '<a href="'.$_SERVER['PHP_SELF'].'?dir_id='.$id.'&inlist=0">Select generic icon</a>';
}
function show_edit_description_form()
{

?>
  <form name="edit_description" ACTION="" method="post">
  <table><tr><td colspan="2"><?php echo $this->lang['Album'];?>: <?php echo $this->get_name($_GET['dir_id']);?><hr></td></tr>
    <tr><td><?php echo $this->lang['Description']; ?>:</td><td><textarea cols="30" rows="5" name="form_description"><?php echo $this->get_description($_GET['dir_id']);?></textarea></td></tr>
  </table>
  <input type="submit" name="submit" value="save">
  </form>
<?php

}
function get_comment_count($id)
{
$query = 'select count(id) from imagecomments where photo_id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];

}
function show_comments($id)
{
$query = 'select name,email,comments from imagecomments where photo_id = "'.$id.'"';
$result = $this->query($query);
echo '<font size="4">User Comments:</font><hr><table width="100%">';
if(mysql_num_rows($result))
{
while($myrow = mysql_fetch_array($result))
{
echo '<tr><td>'.$this->lang['Name'].': </td><td width="100%">'.$myrow['name'].'</tD></tr>';
echo '<tr><td>Email: </td><td>'.$myrow['email'].'</td></tr>';
echo '<tr><td valign="top">Comment: </td><td>'.$myrow['comments'].'</td></tr>';
echo '<tr><td colspan="2"><hr></td></tr>';

}
echo '</table>';
}
else
{

echo $this->lang['No comments posted'].'<hr>';
}
}
function add_comment($id,$name,$email,$comment)
{
$query = 'insert into imagecomments (photo_id,name,email,comments) values ("'.$id.'","'.$name.'","'.$email.'","'.$comment.'")';
$this->query($query);
}

function flush_photofile_index()
{
$query = 'select id from photofile';
$result = $this->query($query);
$count = mysql_num_rows($result);
$i=0;
while($myrow=mysql_fetch_array($result))
{
$query = 'update photofile set orderid = "'.$i.'" where id = "'.$myrow['id'].'"';
//echo $query;
$this->query($query);
$i++;

}

}
function show_comment_form($id)
{
$query = 'select anonymous from photofile where id ="'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
if($myrow[0])
{
echo '<a name="addcomment"></a><font size="4">Add comment</a>';
if($_SESSION['auth']&&$_SESSION['squitouser'])
{
?>
<form action="" method="post"><input type="hidden" name="form_photo_id" value="<?php echo $id;?>">
<table><tr><td><?php echo $this->lang['Name'];?>: <input type="hidden" name="form_name" value="<?php echo $_SESSION['squitouser'];?>"><?php echo $_SESSION['squitouser'];?></td></tr>
<tr><td><?php $this->lang['Email'];?>: <input type="hidden" name="form_email" value="<?php echo $_SESSION['squitoemail'];?>"><?php echo $_SESSION['squitoemail'];?></td></tr>
<tr><td><?php $this->lang['Comment'];?>: <textarea name="form_comment" maxlength="200" cols="75" rows="5"></textarea></td></tr>
</table>
<input type="submit" name="submitComment" value="save">
</form>
<?php
}
else
{
?>
<form action="" method="post"><input type="hidden" name="form_photo_id" value="<?php echo $id;?>">
<table><tr><td><?php $this->lang['Name'];?>: </td><td><input type="text" name="form_name"  maxlength="50" size="50"></td></tr>
<tr><td><?php $this->lang['Email'];?>: </td><td><input type="text" name="form_email" maxlength="50" size="50"></td></tr>
<tr><td><?php $this->lang['Comment'];?>: </td><td><textarea name="form_comment" maxlength="200" cols="75" rows="5"></textarea></td></tr>
</table>
<input type="submit" name="submitComment" value="save">
</form>
<?php
}
}


}

function get_views($id)
{
$query = 'select views from imagetrack where photo_id ="'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];
}

function add_imagetrack($id)
{
$query = 'insert into imagetrack (photo_id) values ("'.$id.'")';
$this->query($query);
}

function check_imagetrack($id)
{
$query = 'select views from imagetrack where photo_id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
if($myrow[0])
{
//echo $myrow[0];
$this->update_imagetrack($id);
}
else
{
$this->add_imagetrack($id);
}
}
function get_fileinfo_q()
{
$query = 'select id,question from fileinfo_q';
//echo $query;
$result = $this->query($query);
while($myrow = mysql_fetch_array($result))
{
 $arr[$myrow['id']]=$myrow['question'];
}
return $arr;
}

function add_fileinfo($id)
{
                $arr = $this->get_fileinfo_q();

                foreach($arr as $key => $value)
                {
                $query = 'insert into fileinfo_a (photo_id,q_id) values ("'.$id.'","'.$key.'")';
                //echo $query;
                $this->query($query);
                }
                //show_fileinfo($id);

}

function show_fileinfo($id)
{
//echo 'test';
                $arr = $this->get_fileinfo_q();
                $query = 'select * from fileinfo_a where photo_id ="'.$id.'"';
                //echo $query;
                $result = $this->query($query);
                if(mysql_num_rows($result))
                {
                echo '<table>';
                while($myrow = mysql_fetch_array($result))
                {
			echo '<tr><td>';
			if($this->lang[$arr[$myrow['q_id']]]) echo $this->lang[$arr[$myrow['q_id']]]; else echo $arr[$myrow['q_id']];
                  echo ': '.$myrow['answer'].'</td></tr>';
                }
                echo '</table>';
                }
                else
                $this->add_fileinfo($id);

}


function get_totalvotes($id)
{
$query = 'select * from photovote where photo_id = "'.$id.'"';
$result = $this->query($query);
return mysql_num_rows($result);
}



function get_vote_avg($id)
{
$query = 'select avg(vote) from photovote where photo_id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];
}


function set_display($per_row, $per_col, $webroot, $imagedir, $thumbdir, $photoroot)
{
  $this->per_row = $per_row;
  $this->per_col = $per_col;
  $this->webroot = $webroot;
  $this->imagedir = $imagedir;
  $this->thumbdir = $thumbdir;
  $this->photoroot = $photoroot;
  }

function recursive_path($id)
{
unset($this->ancestors);
   $dir = '';
   $arr = $this->get_ancestors($id);

   for ($m=0; $m<sizeof($arr); $m++)
        {
                $dir.=  $arr[$m]["name"].'/';
        }
   return $dir;

}


function get_filesize($id)
{
$query = 'select filename,dir_id from photofile where id = "'.$id.'" limit 1';
$request = $this->query($query);
$myrow = mysql_fetch_array($request);
$dir = $this->recursive_path($myrow['dir_id']);
$arr[0] = round(filesize($this->photoroot.$this->imagedir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'])/1000);
$arr[1] = round(filesize($this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'])/1000);
return $arr;

}



function get_dimensions($id=0)
{
$query = 'select dir_id,filename from photofile where id = "'.$id.'"';
//echo $query;
$result = $this->query($query);
$myrow = mysql_fetch_array($result);

//echo $this->recursive_path(3);

$query = 'select dir_id,filename from photofile where id = "'.$id.'"';
//echo $query;
$result = $this->query($query);
$myrow = mysql_fetch_array($result);

$dir = $this->recursive_path($myrow['dir_id']);
//echo $this->photoroot.$this->imagedir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'];
$array = getimagesize($this->photoroot.$this->imagedir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename']);
$add = getimagesize($this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename']);
$array[2] = $add[0];
$array[3] = $add[1];
return $array;
  //*/
}
//funciton add_image($id,)
function grant_anonymous($id)
{
  //$this->flush_anonymous($id);
  $query = 'update access set u = 1 where dir_id = "'.$id.'" and user_id ="0"';
  $this->query($query);
  $query = 'update photodir set anonymous_uploads = 1 where id = "'.$id.'"';
  $this->query($query);


}
function revoke_anonymous($id)
{
  $query = 'update access set u = 0 where dir_id = "'.$id.'" and user_id ="0"';
  //echo $query;
  $this->query($query);
    $query = 'update photodir set anonymous_uploads = 0 where id = "'.$id.'"';
  $this->query($query);

}
function move_file($id, $dest_dir_id)
{

$query = 'select dir_id,filename from photofile where id = "'.$id.'"';
//echo $query;
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
$query = 'update photofile set dir_id = "'.$dest_dir_id .'" where id = "'.$id.'"';
$this->query($query);


$dir = $this->recursive_path($myrow['dir_id']);
$source_full =  $this->photoroot.$this->imagedir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename'];
$source_thumb =  $this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename'];
$dir='';
unset($this->ancestors);
$dir = $this->recursive_path($dest_dir_id);
$destination_full = $this->photoroot.$this->imagedir.$dir.$this->get_name($dest_dir_id).'/'.$myrow['filename'];
$destination_thumb = $this->photoroot.$this->thumbdir.$dir.$this->get_name($dest_dir_id).'/'.$myrow['filename'];
//echo $source_full.'<br>'.$destination_full.'<br>';
//echo $source_full.'<br>'.$destination_full;
copy($source_full,$destination_full);
copy($source_thumb,$destination_thumb);

if(file_exists($destination_full))
unlink($source_full);
if(file_exists($destination_thumb))
unlink($source_thumb);

$this->flush_photofile_index();
}
function get_photocount($id)
{
$query = 'select id from photofile where dir_id ="'.$id.'"';
$result = $this->query($query);
return mysql_num_rows($result);

}
function delete_folder($id)
{
 $dir = $this->recursive_path($id);
  rmdir($this->photoroot.$this->imagedir.$dir.$this->get_name($id));
 rmdir($this->photoroot.$this->thumbdir.$dir.$this->get_name($id));
  $query = 'delete from photodir where id ="'.$id.'"';
 $this->query($query);
  $query = 'delete from access where dir_id ="'.$id.'"';
 $this->query($query);



 }
function delete_file($id)
{
$query = 'select dir_id,filename from photofile where id = "'.$id.'"';
//echo $query;
$result = $this->query($query);
$myrow = mysql_fetch_array($result);

$dir = $this->recursive_path($myrow['dir_id']);
unlink($this->photoroot.$this->imagedir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename']);
unlink($this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename']);


$query = 'delete from imagetrack where photo_id = "'.$id.'"';
$this->query($query);
$query = 'delete from photovote where photo_id = "'.$id.'"';
$this->query($query);
$query = 'delete from imagecomments where photo_id = "'.$id.'"';
$this->query($query);
$query = 'delete from fileinfo_a where photo_id = "'.$id.'"';
$this->query($query);
$query = 'delete from photofile where id = "'.$id.'"';
$this->query($query);

//echo $this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename'];
$this->flush_photofile_index();
}
//***************************** admin file list **********************************************************
function show_admin_file_list($id=0)
{
    unset($this->ancestors);
   $arr = $this->get_ancestors($id);
   echo '<table><tr><td><a href="?menu=addremalbums&dir_id=0">Home</a>';
   for ($x=0; $x<sizeof($arr); $x++)
        {
                echo ' | <a href="?menu=addremalbums&dir_id='. $arr[$x]["id"].'">' . $arr[$x]["name"].'</a>';
        }
   echo ' | '.$this->get_name($id);
   echo '</td></tr></table>';

                ?>
<script language="JavaScript">
   <!--
   function CheckAll()
   {
      for (var i=0;i<document.moveform.elements.length;i++)
      {
         var e = document.moveform.elements[i];
         if (e.name != "allbox")
            e.checked = document.moveform.allbox.checked;
      }
   }


   //-->
</script>
<form name="moveform" action="" method="post">
<br><a href="" onClick="window.open('import_images.php?dir_id=<?php echo $id;?>','importWindow','location=no,status=1,scrollbars=yes,resizable=yes,width=300,height=400'); return false"><?php echo $this->lang['Import Images'];?></a><br>
<div align="right">
<?php echo $this->lang['Action'];
 if($_SESSION['error']) echo '<li>'.$_SESSION['error'];
 $_SESSION['error'] ='';

 ?><br><select name="form_file_action"><option value="move"><?php echo $this->lang['Move'];?></option><option value="delete"><?php echo $this->lang['Delete'];?></option></select>
<?php

 echo '<select name="form_move_dest"><option value="">'.$this->lang['Move to'].'(Select Destination)</option>'."\n";
echo $this->get_ancester_droplist(0);
echo '</option></select>';

 ?>

 <input type="submit" name="formAction" value="<?php echo $this->lang['Submit'];?>"><br>
   </div>

                <table bgcolor="#000000" cellspacing="1" cellpadding="5" width="100%">
                   <tr bgcolor="#EEEEEE">
                   <td><?php echo $this->lang['Filename'];?></td>
                   <td><?php echo $this->lang['Full Dimensions'];?></td>
                   <td><?php echo $this->lang['Filesize'];?></td>
                   <td><?php echo $this->lang['Thumbnail Dimensions'];?></td>
                   <td><?php echo $this->lang['Thumbnail Filesize'];?></td>
                   <td><?php echo $this->lang['Number of Views'];?></td>
                   <td><?php echo $this->lang['Number of Comments'];?></td>
                   <td><B>All:<input name="allbox" type="checkbox" value="1"
   onClick="CheckAll();"></B></td><td></td>
                  </tr>
<?php
$query = 'select id, filename from photofile where dir_id = "'.$id. '" order by filename asc';
$result = $this->query($query);
while($myrow = mysql_fetch_array($result))
{
//   echo '<tr><td>'.$this->recursive_path($id).'</td></tr>';
   $c=0;
   $filesize = $this->get_filesize($myrow['id']);
   $dim = $this->get_dimensions($myrow['id']);
              if($c)
                {
                $color = "#DDDDDD";
                $c=0;
                }
                else
                {
                $color = "#CCCCCC";
                $c=1;
                }
echo '<tR bgcolor="'.$color.'"><td>'.$myrow['filename'].'</td><td>'.$dim[0].'x'.$dim[1].'</td><td>'.$filesize[0].'kb</td><td>'.$dim[2].'x'.$dim[3].'</td><td>'.$filesize[1].'kb</td>';
echo '<td>'.$this->get_views($myrow['id']);
$comment_count=$this->get_comment_count($myrow['id']);
if($comment_count)
{
?><td><a href="" onClick="window.open('viewcomment.php?photo_id=<?php echo $myrow['id'];?>','commentWindow','location=no,scrollbars=yes,resizable=yes,width=300,height=400'); return false"><?php echo $comment_count;?></a></td>
<?php
}
else
echo '<td>'.$comment_count.'</td>'."\n";
echo '<td><input type="checkbox" name = "form_move[]" value="'.$myrow['id'].'"></td>'."\n";
?><td><a href="" onClick="window.open('viewfileinfo.php?photo_id=<?php echo $myrow['id']; ?>','fileinfoWindow','location=no,scrollbars=yes,resizable=yes,width=300,height=400'); return false"><?php echo $this->lang['More Info']; ?></a></td>
</tr>
<?php

}
echo '</table></form>';

}
function add_dir($id=0,$newdir, $private, $owner)
{
$dir = $this->recursive_path($id);
$createdir =  $this->photoroot.$this->imagedir.$dir.$this->get_name($id). '/' . trim($newdir,'/');

$createthumbdir =  $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.trim($newdir,'/');


//echo $createdir;
//echo $this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.trim($newdir,'/')."<br>\n";
if(mkdir($createdir,0777) && mkdir($createthumbdir,0777))
{
echo 'directories created';
$this->query('insert into photodir (name, parentid, private, owner) values ("'.$newdir.'","'.$id.'","'.$private.'","'.$owner.'")');
$query = 'select name,parentid,id, private from photodir where name = "'.$newdir.'" and parentid = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
if(!$private)
$this->query('insert into access (user_id,dir_id,r) values ("0","'.$myrow['id'].'","1")');
else
$this->query('insert into access (user_id,dir_id,r) values ("0","'.$myrow['id'].'","0")');
$query = 'select id from authorization';
$result = $this->query($query);
while($row = mysql_fetch_row($result))
{
if(!$private)
$this->query('insert into access (user_id,dir_id,r) values ("'.$row[0].'","'.$myrow['id'].'","1")');
else
$this->query('insert into access (user_id,dir_id,r) values ("'.$row[0].'","'.$myrow['id'].'","0")');
}
$this->query('update access set r=1, u=1, d=1, e=1 where user_id = "'.$owner.'" and dir_id ="'.$myrow['id'].'"');
}

}
function show_admin_dir_list($id=0)
{
     $arr = $this->get_ancestors($id);
   echo '<table><tr><td><a href="?menu=addremalbums&dir_id=0">Home</a>';
   for ($x=0; $x<sizeof($arr); $x++)
        {
                echo ' | <a href="?menu=addremalbums&dir_id='. $arr[$x]["id"].'">' . $arr[$x]["name"].'</a>';
        }
   echo ' | '.$this->get_name($id);
   echo '</td></tr></table>';
if(!isset($_SESSION['createerror'])) $_SESSION['createerror']='';
                if($_SESSION['createerror']) echo $_SESSION['createerror'];
                $_SESSION['createerror']='';
                  ?>
                <form ACTION="" method="post">

                 <?php echo $this->lang['Create New Album'];?> <input type="text" name="form_dir"> <?php echo $this->lang['in'];?> <?php
                echo '<select name="form_dir_id"><option value="0">root</option>';
echo $this->get_ancester_droplist(0);
echo '</option></select>';
?> Private <input type="checkbox" value="1" name="form_private"><input type="hidden" name="form_owner" value="<?php echo $_SESSION['squitoid'];?>"> <input type="submit" name="newDirSubmit" value="Create New Dir"></form>
<script language="JavaScript">
   <!--
function deleteFolder_empty(folder,folderName)
{
if(confirm("<?php echo $this->lang['Are you sure you want to delete'];?> \""+folderName+"\"?"))
{
document.delFolder.submit();
}
}
function deleteFolder_not_empty(folder, folderName)
{
alert("<?php echo $this->lang['Confirm Delete'];?>" );

}

   //-->
</script>

<form name="delFolder" ACTION="" method="post">
<table bgcolor="#000000" cellspacing="1" cellpadding="5" width="100%">
                  <tr bgcolor="#EEEEEE">
                   <td><?php echo $this->lang['Icon'];?></td>
                   <td><?php echo $this->lang['Title'];?></td>
                   <td><?php echo $this->lang['Description'];?></td>
                   <td><?php echo $this->lang['# of Photos'];?></td>
                   <td></td>
                   <td><?php echo $this->lang['Anonymous Uploads'];?></td><td></td>
                  </tr>
                <?php
				$c=0;
				$dir = $this->recursive_path($id);
				$result = $this->get_children($id);
                for($x=0; $x<sizeof($result); $x++)
                {
                if($c)
                {
                $color = "#DDDDDD";
                $c=0;
                }
                else
                {
                $color = "#CCCCCC";
                $c=1;
                }
				$icon_query =$this->get_icon($result[$x]['id']);
				if($icon_query[1])
				$icon = $this->webroot.'/'.$this->thumbdir.$dir.$this->get_name($id).'/'.$this->get_image_dirname($icon_query[2]).$this->get_imagename($icon_query[2]);
				else
				$icon = $this->webroot.'/icons/'.$icon_query[0];
                echo '<tr bgcolor="'.$color.'"><td><img src="'.$icon.'" border="0">';
                ?><br><a href="" onClick="window.open('change_dir_icon.php?dir_id=<?php echo $result[$x]['id']; ?>','change_dir_iconWindow','location=no,scrollbars=yes,resizable=yes,width=300,height=400'); return false"><?php echo $this->lang['Change Icon']; ?></a><?php
                echo '</td>';
                if($this->get_type($result[$x]['id']))
                echo '<td><a href="?menu=addremalbums&dir_id='.$result[$x]['id'].'">'.$result[$x]['name'].'</a></td>';
                else echo ' <td>'.$result[$x]['name'].'</td>';
                        echo '<td>'.$this->get_description($result[$x]['id']).'<br>';?><a href="" onClick="window.open('edit_description.php?dir_id=<?php echo $result[$x]['id']; ?>','edit_descriptionWindow','location=no,scrollbars=yes,resizable=yes,width=300,height=400'); return false"><?php echo ($this->lang['Edit Description'])? $this->lang['Edit Description']:  'Edit Description'; ?></a></td>
                      <?php 
					  
					  echo '<td>'.$this->get_photocount($result[$x]['id']).'<br><a href="?menu=images&dir_id='.$result[$x]['id'].'">'.$this->lang['Manage Images'].'</a></td>';
                      ?><td><a href="" onClick="window.open('change_permissions.php?dir_id=<?php echo $result[$x]['id']; ?>','fileinfoWindow','status=yes,location=no,scrollbars=yes,resizable=yes,width=300,height=400'); return false"><?php echo $this->lang['Change Permissions']; ?></a></td>
                      <?php
					  $yes = $this->lang['Yes'];
                      $no =  $this->lang['No'];
					  echo '<td>'; echo ($this->check_anonymous_uploads($result[$x]['id']))?$yes:$no;  echo '</td>';
                      ?>
                      <td><a href="" onClick="folder.value='<?php echo $result[$x]['id'];?>'; subDeleteFolder.value='1'; <?php if(sizeof($this->get_children($result[$x]['id'])) || $this->get_photocount($result[$x]['id'])) echo "deleteFolder_not_empty(".$result[$x]['id'].",'".$result[$x]['name']."')"; else echo "deleteFolder_empty(".$result[$x]['id'].",'".$result[$x]['name']."')";?>; return false"><?php echo ($this->lang['Delete Folder'])?$this->lang['Delete Folder']: 'Delete Folder'; ?></a></td>
                      <?php
                      echo '</tr>';
                }
                echo '</table><input type="hidden" name="folder"><input type="hidden" name="subDeleteFolder"></form>';

}
function get_image_dirname($id)
{

$query = 'select dir_id from photofile where id = "'.$id.'" limit 1';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
if(mysql_num_rows($result))
return  $this->get_name($myrow[0]).'/';
else 
return;
}  
function show_permissions_form($id)
{
echo '<form name="change_permissions" action="" method="post">';
?>
<script language="JavaScript">
function check_private()
{
if(change_permissions.private.checked == true)
{
change_permissions.users.disabled = false
change_permissions.elements['has_access[]'].disabled = false
change_permissions.add.disabled = false
change_permissions.remove.disabled = false

}
else
{
change_permissions.users.disabled = true
change_permissions.elements['has_access[]'].disabled = true
change_permissions.add.disabled = true
change_permissions.remove.disabled = true

}
}
function goodcheck(fbox)  { 
     for(var i=0; i<fbox.options.length; i++)  { 
          if(fbox.options[i].selected
                    && fbox.options[i].value == "0") { 
               fbox.options[i].selected=false;
               return false;
          }
      }
     return true;
} 

function move(fbox,tbox,owner) { 
     for(var i=0; i<fbox.options.length; i++) { 
          if(fbox.options[i].selected && fbox.options[i].value != "" && fbox.options[i].value != owner) { 
               var no = new Option(); 
               no.value = fbox.options[i].value; 
               no.text = fbox.options[i].text; 
               tbox.options[tbox.options.length] = no; 
               fbox.options[i].value = ""; 
               fbox.options[i].text = ""; 
               fbox.options[i].selected=false;
               //tbox.options[tbox.options.length-1].selected=true;
          }
     }
     BumpUp(fbox); 
     SortD(tbox); 
     if(fbox.length > 0)
	 {
	 fbox.options[0].selected=true;
	 fbox.disabled = false;
	 }
	 
	 
}

function BumpUp(box)  { 
     for(var i=0; i<box.options.length; i++) { 
          if(box.options[i].value == "")  { 
               for(var j=i; j<box.options.length-1; j++)  { 
                    box.options[j].value = box.options[j+1].value; 
                    box.options[j].text = box.options[j+1].text; 
               }
               var ln = i;
               break;
          }
     }
     if(ln < box.options.length)  { 
          box.options.length -= 1; 
          BumpUp(box); 
     }
}

function SortD(box)  { 
     var temptxt = '';
     var tempval = '';
     var tempsel = false;

     for(var x=0; x < box.options.length-1; x++)  {
          for(var y=(x+1); y < box.options.length; y++)  {
               if(box.options[x].text > box.options[y].text)  { 
                    temptxt = box.options[x].text; 
                    tempval = box.options[x].value;
                    tempsel = box.options[x].selected;

                    box.options[x].text = box.options[y].text; 
                    box.options[x].value = box.options[y].value; 
                    box.options[x].selected = box.options[y].selected;

                    box.options[y].text = temptxt;
                    box.options[y].value = tempval;
                    box.options[y].selected = tempsel;
               }
          }
     }
} 
function select_all(box)
{
sellength = box.length;
for(x=0; x<sellength; x++)
box.options[x].selected = true;
}

</script>
<table><tR><td><?php echo $this->lang['Allow Anonymous Uploads'];?></td><td><input type="checkbox" name="form_anonymous" value"1" <?php if($this->check_anonymous_uploads($id)) echo 'checked';?>> </td></tr>
<tr><td>Private</td><td ><input type="checkbox" name="private" onclick="check_private();" value="1" <?php if($this->is_private($id)) echo 'checked';?>> </td></tr>
<tr><td colspan="2"><table><tr><td>Users<br><select name="users" multiple <?php if(!$this->is_private($id)) echo 'disabled';?>>
<?php
$sql='';
if($this->is_private($id)) $sql = 'and access.r != 1';
$query = 'select authorization.id,authorization.name from authorization,access where authorization.id = access.user_id and authorization.id != "'.$this->get_owner($id).'" and access.dir_id = "'.$id.'"'.$sql.' order by authorization.name asc';
$result = $this->query($query);
while($users = mysql_fetch_row($result))
echo '<option value="'.$users[0].'">'.$users[1].'</option>'."\n";
?>
</select></td>
<td><input type="button" name="add" value=">>" onClick="if (goodcheck(this.form.users)) move(this.form.users,this.form.elements['has_access[]'],<?php echo $this->get_owner($id);?>);" <?php if(!$this->is_private($id)) echo 'disabled';?>><br><BR><input type="button" name="remove" value="<<" onClick="if (goodcheck(this.form.elements['has_access[]'])) move(this.form.elements['has_access[]'],this.form.users,<?php echo $this->get_owner($id);?>);" <?php if(!$this->is_private($id)) echo 'disabled';?>></td>
<td>Has Access<br><select name="has_access[]" multiple <?php if(!$this->is_private($id)) echo 'disabled';?>>
<?php
$query = 'select id,name from authorization where id = "'.$this->get_owner($id).'"';
$result = $this->query($query);
while($users = mysql_fetch_row($result))
echo '<option value="'.$users[0].'">'.$users[1].'</option>'."\n";
if($this->is_private($id)) 
{
$query = 'select authorization.id,authorization.name from authorization,access where authorization.id = access.user_id and authorization.id != "'.$this->get_owner($id).'" and access.r = 1 and access.dir_id ="'.$id.'"';
$res = $this->query($query);
while($ausers = mysql_fetch_row($res))
echo '<option value="'.$ausers[0].'">'.$ausers[1].'</option>'."\n";
}
echo '</select></td>';
?>

</tr></table></td></tr>




</table><input type="submit" name="subPerPage" onclick="select_all(change_permissions.elements['has_access[]'])" value="<?php echo $this->lang['Save'] ;?>"></form>
<?php
}
function get_owner($id)
{
$query = 'select owner from photodir where id = "'.$id.'"';
$result = $this->query($query);
$row = mysql_fetch_row($result);
return $row[0];
}
function set_private($id,$access)
{
$owner = $this->get_owner($id);
$query = 'update photodir set private = "1" where id = "'.$id.'"';
$this->query($query);
$size = sizeof($access);
$sql='';
$sql2='';
for($x=0; $x<$size; $x++)
{
if($owner != $access[$x])
{ 
$sql .= ' and user_id != "'.$access[$x].'"';
$query = 'update access set r=1 where user_id = "'.$access[$x].'" and dir_id = "'.$id.'"';
$this->query($query);
}
}
$query = 'update access set r=0 where user_id != "'.$owner.'"'.$sql.' and dir_id = "'.$id.'"';
//echo $query;
$this->query($query);
//echo $query;
//exit;
}
function set_notprivate($id)
{
$query = 'update photodir set private = "0" where id = "'.$id.'"';
$this->query($query);
$query = 'select id from authorization';
$result = $this->query($query);
while($myrow = mysql_fetch_row($result))
{
$query = 'update access set r=1 where dir_id = "'.$id.'"';
$this->query($query);
}
}

function is_private($id)
{
$query = 'select private from photodir where id = "'.$id.'"';
$result = $this->query($query);
$row = mysql_fetch_row($result);
return $row[0];
}
function check_anonymous_uploads($id)
{
$query = 'select anonymous_uploads from photodir where id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];

}

function get_parent($id)
{

$query = 'select parentid from '.$this->table .' where id = "'.$id.'" order by name asc';
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
return $myrow['parentid'];

}
function is_root($id)
{
   if($this->get_parent($id) == 0)
   {
     return 1;
   }
   else
   {
     return 0;
   }
}

function get_children($id)
{
        $query = "SELECT id, name FROM $this->table WHERE parentid = '$id' order by name asc";
        $result = $this->query($query);
        $count = 0;
        while ($row = mysql_fetch_array($result))
        {
               $children[$count]["id"] = $row["id"];
               $children[$count]["name"] = $row["name"];
               $count++;
       }
	   if(isset($children))
         return $children;
		 else return;
}
function get_type($id)
{
       if($this->get_children($id)        )
         {
                 return 1;
        }
        else
       {
               return 0;
       }
}
function get_name($id)
        {
                $query = "SELECT name FROM photodir WHERE id = '$id'";
                $result = $this->query($query);
                $row = mysql_fetch_row($result);
                return $row[0];
        }
function get_description($id)
        {
                $query = "SELECT description FROM $this->table WHERE id = '$id'";
                $result = $this->query($query);
                $row = mysql_fetch_row($result);
                return $row[0];
        }
function get_icon($id)
        {
                $query = "SELECT icon,inlist,icon_id FROM photodir WHERE id = '$id'";
                $result = $this->query($query);
                $row = mysql_fetch_row($result);
                return $row;
        }

 function get_ancestors($id, $count = 0)
        {
                // get parent of this node
                $parent = $this->get_parent($id);
                // if not at the root, add to $ancestors[] array
                if($parent)
                {
                $this->ancestors[$count]["id"] = $parent;
                $this->ancestors[$count]["name"] = $this->get_name($parent);
                // recurse to get the parent of this parent
                $this->get_ancestors($this->ancestors[$count]["id"], $count+1);
                // all done? at this stage the array contains a list in bottom-up order
                // reverse the array and return
                return array_reverse($this->ancestors);
                }
        }


function query($query)
{
     if(!isset($this->dbconnection))
     $this->dbconnection = mysql_connect($this->host, $this->user, $this->pass)
         or die ("Cannot connect to database");
        // run query
      $ret = mysql_db_query($this->db, $query, $this->dbconnection)
         or die ("Error in query: $query");
        // return result identifier
      return $ret;

}
function print_menu_tree($id = 0)
        {
                $result = $this->get_children($id);
                echo "<ul>";
                for ($x=0; $x<sizeof($result); $x++)
                {
                        //if($this->get_type($result[$x]["id"]))
                        echo '<a href="">'. $result[$x]["name"] .'</a>';
                        //else
                        //echo "<li>" . $result[$x]["name"] . "[" . $result[$x]["id"] . "]";
                        $this->print_menu_tree($result[$x]["id"]);
                }
                echo "</ul>";
        }
function get_ancester_droplist_prefs($id=0)
{
                $result = $this->get_children($id);
                for ($x=0; $x<sizeof($result); $x++)
                {
       $ancesters = $this->recursive_path($result[$x]['id']);
                        echo '<option value="'.$result[$x]["id"].'"';
						
						if($this->default_uploads==$result[$x]['id']) echo ' selected';
						
						echo '>'.$ancesters.$result[$x]["name"] .' | </option>'."\n";
                        unset($this->ancestors);
                        $this->get_ancester_droplist($result[$x]["id"]);
                }
                unset($this->ancestors);

}

        function get_ancester_droplist($id=0)
{
                $result = $this->get_children($id);
                for ($x=0; $x<sizeof($result); $x++)
                {
       $ancesters = $this->recursive_path($result[$x]['id']);
      
                        echo '</option><option value="'.$result[$x]["id"].'">'.$ancesters.$result[$x]["name"] .'/'."\n";
                        unset($this->ancestors);
                        $this->get_ancester_droplist($result[$x]["id"]);
                }
                unset($this->ancestors);

}
function get_imagename($id)
{
$query = 'select filename from photofile where id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];
}
function import_images($sourcefile,$id, $thumbsize, $imagemagickpath, $gfxtype)
{
if($gfxtype==1)
$useimagemagick=1;
if($gfxtype==2)
$usegd184=1;
if($gfxtype==3)
$usegd201=1;
//echo 'importing';
$filename=$sourcefile;
unset($this->ancestors);
$dir = $this->recursive_path($id);
$uploadpath = $dir.$this->get_name($id).'/';
$realname = $sourcefile;
$query = 'insert into photofile (filename,dir_id,time_uploaded) values ("'.$realname.'","'.$id.'","'.time().'")';
$this->query($query);

$query = 'select id from photofile where filename = "'.$realname.'" and dir_id = "'.$id.'" order by id desc limit 1';
$result = $this->query($query);
$myrow=mysql_fetch_row($result);
$this->add_fileinfo($myrow[0]);
$realname = $myrow[0].'.'.end(explode('.',$realname));
$query = 'update photofile set filename = "'.$realname.'" where id = "'.$myrow[0].'"';
$this->query($query);
//echo '<br>'.$realname;
                $size = getimagesize($filename);

                if($useimagemagick)
                {
                    if($os=='1')
                     {
                      $fullimage = str_replace('/','\\',$this->photoroot.$this->imagedir.$uploadpath.$realname);
                      $thumbimage = str_replace('/','\\',$this->photoroot.$this->thumbdir.$uploadpath.$realname);
                     }
                else
                    {
                       $fullimage = $this->photoroot.$this->imagedir.$uploadpath.$realname;
                       $thumbimage = $this->photoroot.$this->thumbdir.$uploadpath.$realname;
                }



                if($size[0]<500 && $size[1]<500)
                copy($filename,$this->photoroot.$this->imagedir.$uploadpath.$realname);
                else
                //{
                //echo $fullimage.'<bR>';
                //}
                system($imagemagickpath."convert -geometry 500x500 \"$filename\" +profile '*' \"$fullimage\"");
                //echo $imagemagickpath."convert -geometry 500 \"$filename\" +profile '*' \"$fullimage\"\n";
                system($imagemagickpath."convert -geometry $thumbsize"."x"."$thumbsize \"$filename\" +profile '*' \"$thumbimage\"");
                //echo $imagemagickpath."convert -geometry $thumbsize \"$filename\" +profile '*' \"$thumbimage\"\n";
                }
                else
                if($usegd184)
                {
                   if($size[0]<500 && $size[1]<500)
                  {
                      copy($filename,$this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname);
                  }
                  else
                  {
                   if($filetype != 'image/gif')
                   $this->makethumb($realname, $filename, $this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/', 500,1);
                   else
                   copy($filename,$this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname);
                  }
                   if($filetype != 'image/gif')
                  $this->makethumb($realname, $filename, $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/', $thumbsize,1);
                   else
                   copy($filename,$this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.$realname);
                }
                else
                if($usegd201)
                {
                    if($size[0]<500 && $size[1]<500)
                   {
                    copy($filename,$this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname);
                   }
                   else
                    {
                    if($filetype != 'image/gif')
                    $this->makethumb($realname, $filename, $this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/', 500,0);
                   else
                   copy($filename,$this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname);

                    }
                    if($filetype != 'image/gif')
                   $this->makethumb($realname, $filename, $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/', $thumbsize,0);
                   else
                   copy($filename,$this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.$realname);

                }

                //echo $imagemagickpath."convert -geometry 500 \"$photoroot$images$uploadpath$realname\" +profile '*' \"$photoroot$images$uploadpath$realname\"\n";
                //echo $imagemagickpath."convert -geometry $thumbsize \"$photoroot$images$uploadpath$realname\" +profile '*' \"$photoroot$thumbnails$uploadpath$realname\"\n";


}

function makethumb($userimagename, $source_path, $destination_path, $new_size, $ver)
{

/*
*      In this example I use JPG file format
*      to create PNG file format:
*      change these lines by replacing:
*       => imagejpeg ***WITH*** imagepng
*        => Header("Content-Type: image/jpeg") ***WITH***
*            Header("Content-Type: image/png")
*       => ImageCreateFromjpeg ***WITH*** ImageCreateFrompng
*
*    NOW EDIT THE FOLLOWING LINES.
*   You can also use input text boxes for user input.
*/
$image_dir_file_location=$source_path;        // image location and file name
$image_dir_file_save=$destination_path.$userimagename;                // image save location and file name

$image_info=$this->resize_img($image_dir_file_location,$new_size,$ver);
imagejpeg($image_info,$image_dir_file_save);
}
function ImageCopyResampleBicubic ($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) 
/* 
port to PHP by John Jensen July 10 2001 -- original code (in C, for the PHP GD Module) by jernberg@fairytale.se 
*/ 
{ 
for ($i = 0; $i < 256; $i++) { // get pallete. Is this algoritm correct? 
$colors = ImageColorsForIndex ($src_img, $i); 
ImageColorAllocate ($dst_img, $colors['red'], $colors['green'], $colors['blue']); 
} 

$scaleX = ($src_w - 1) / $dst_w; 
$scaleY = ($src_h - 1) / $dst_h; 

$scaleX2 = $scaleX / 2.0; 
$scaleY2 = $scaleY / 2.0; 

for ($j = $src_y; $j < $dst_h; $j++) { 
$sY = $j * $scaleY; 

for ($i = $src_x; $i < $dst_w; $i++) { 
$sX = $i * $scaleX; 

$c1 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX, (int) $sY + $scaleY2)); 
$c2 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX, (int) $sY)); 
$c3 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX + $scaleX2, (int) $sY + $scaleY2)); 
$c4 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX + $scaleX2, (int) $sY)); 

$red = (int) (($c1['red'] + $c2['red'] + $c3['red'] + $c4['red']) / 4); 
$green = (int) (($c1['green'] + $c2['green'] + $c3['green'] + $c4['green']) / 4); 
$blue = (int) (($c1['blue'] + $c2['blue'] + $c3['blue'] + $c4['blue']) / 4); 

$color = ImageColorClosest ($dst_img, $red, $green, $blue); 
ImageSetPixel ($dst_img, $i + $dst_x, $j + $dst_y, $color); 
} 
} 
}
function resize_img($image_name,$new_size,$gdversion)
{
    //Header("Content-Type: image/jpeg");
    $image_source = ImageCreateFromjpeg ($image_name);
    $actual_width = imagesx($image_source);
    $actual_height = imagesy($image_source);
    if ($actual_width>=$actual_height)
    {
        $width=$new_size;
        $height = ($width/$actual_width)*$actual_height;
     }
      else
     {
        $height=$new_size;
        $width = ($height/$actual_height)*$actual_width;
     }
     
         if($gdversion)
		 {
    $image_info = ImageCreate($width,$height);
	imagecopyresamplebicubic($image_info, $image_source, 0, 0, 0, 0,
        $width, $height, $actual_width, $actual_height);
          }
		        else
           {
$image_info = imagecreatetruecolor($width,$height);
		        imagecopyresampled($image_info, $image_source, 0, 0, 0, 0,
        $width, $height, $actual_width, $actual_height);
}
    return $image_info;
}



        }
/*
        include('config.inc.php');
include('dbfns.inc.php');
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
$obj->recursive_path(3);
//$obj->print_menu_tree(0);
//echo '<select><option value="0">root</option>';
//echo $obj->get_ancester_droplist(0);
//echo '</option></select>';
  */
?>