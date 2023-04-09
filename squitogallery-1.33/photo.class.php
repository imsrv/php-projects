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
   var $host, $user, $pass, $db, $table, $per_row, $per_col, $photo_per_row, $photo_per_col,$webroot, $photoroot, $imagedir, $thumbdir, $page, $filetype, $homeurl, $dbconnection;


function set_db($host, $user, $pass, $db, $table)
{
  $this->host = $host;
  $this->user = $user;
  $this->pass = $pass;
  $this->db = $db;
  $this->table = $table;


}
function echo_vars()
{
  echo $this->page.'<br>';
  echo $this->per_row.'<br>';
  echo $this->per_col.'<br>';
  echo $this->photo_per_row.'<br>';
  echo $this->photo_per_col.'<br>';

  echo $this->webroot.'<br>';
  echo $this->imagedir.'<br>';
  echo $this->thumbdir.'<br>';
  echo $this->photoroot.'<br>';
}
function set_homeurl($url)
{
 $this->homeurl = $url;
}
function set_lang($lang)
{
$this->lang = $lang;
}
function set_display($page, $per_row, $per_col, $photo_per_row, $photo_per_col, $webroot, $imagedir, $thumbdir, $photoroot, $image_magick_path, $os,$lang,$thumbsize)
{
  $this->lang			  = $_SESSION['lang'];
  if(isset($_GET['dirpage']))
  $this->dirpage          = $_GET['dirpage'];
  else $this->dirpage = 1;
  $this->page             = $page;
  $this->os               = $os;
  $this->per_row          = $per_row;
  $this->per_col          = $per_col;
  $this->photo_per_row    = $photo_per_row;
  $this->photo_per_col    = $photo_per_col;
  $this->webroot          = $webroot;
  $this->imagedir         = $imagedir;
  $this->thumbdir         = $thumbdir;
  $this->thumbsize        = $thumbsize;
  $this->imagemagickpath  = $image_magick_path;
  $this->photoroot        = $photoroot;
  $this->registered_types = array(
    "application/x-gzip-compressed"        => ".tar.gz, .tgz",
    "application/x-zip-compressed"         => ".zip",
    "application/x-tar"                    => ".tar",
    "text/plain"                           => ".html, .php, .txt, .inc (etc)",
    "image/bmp"                            => ".bmp, .ico",
    "image/gif"                            => ".gif",
    "image/pjpeg"                          => ".jpg, .jpeg",
    "image/jpeg"                           => ".jpg, .jpeg",
    "application/x-shockwave-flash"        => ".swf",
    "application/msword"                   => ".doc",
    "application/vnd.ms-excel"             => ".xls",
    "application/octet-stream"             => ".exe, .fla (etc)"
);
  $this->allowed_types    = array("image/bmp","image/gif","image/pjpeg","image/jpeg");

 }

function show_per_dir_per_page()
{
$myrow = $this->get_defaults();
?>
<form name="albumform" action="?menu=photos&dir_id=<?php echo $_GET['dir_id'];?>" method="post">
<select name="form_albumperpage" onChange="albumform.submit();"><option><?php echo $this->lang['Albums Per Page'];?></option>
<option value="<?php echo (($myrow['per_col']* $myrow['per_row'])/$myrow['per_col']);?>"><?php echo $this->lang['Albums Per Page'];?> (Default)</option>
<option value="<?php echo (($myrow['per_col']* $myrow['per_col'])/$myrow['per_col']);?>"><?php  echo $this->lang['Albums Per Page']; ?> (<?php echo (($myrow['per_col']* $myrow['per_col']));?>)</option>
<option value="<?php echo (($myrow['per_col']* ($myrow['per_col']*4))/$myrow['per_col']);?>"><?php  echo $this->lang['Albums Per Page']; ?> (<?php echo ($myrow['per_col']*($myrow['per_col']*4));?>)</option>
<option value="<?php echo (($myrow['per_col']* ($myrow['per_col']*6))/$myrow['per_col']);?>"><?php  echo $this->lang['Albums Per Page']; ?> (<?php echo ($myrow['per_col']*($myrow['per_col']*6));?>)</option>
<option value="<?php echo (($myrow['per_col']* ($myrow['per_col']*8))/$myrow['per_col']);?>"><?php  echo $this->lang['Albums Per Page']; ?> (<?php echo ($myrow['per_col']*($myrow['per_col']*8));?>)</option>
<option value="<?php echo (($myrow['per_col']* ($myrow['per_col']*10))/$myrow['per_col']);?>"><?php  echo $this->lang['Albums Per Page']; ?> (<?php echo ($myrow['per_col']*($myrow['per_col']*10));?>)</option>
<option value="<?php echo (($myrow['per_col']* ($myrow['per_col']*12))/$myrow['per_col']);?>"><?php  echo $this->lang['Albums Per Page']; ?> (<?php echo ($myrow['per_col']*($myrow['per_col']*12));?>)</option>
</select>
<input type="hidden" name="albumpage" value="1">
<input type="hidden" name="submitAlbumPerPage" value="1">
</form>
<?php

}
function check_messages($user_id)
{
$query = 'select message_id from message where to_id = "'.$user_id.'" and status = 0 limit 1' ;
$result = $this->query($query);
$row = mysql_fetch_row($result);
return $row[0];
}
//******************************************************show_message_form
function show_message_form()
{

echo '<table width="100%" cellpadding="5"><tr>
    <td class="signup" align="center" class="sidebox"><B><font color="#FFFFFF">'.$this->lang['Send a Personal Message'].'</font></b></td>
  </tr></table><form action="" method="post"><table><tr><td>'.$this->lang['To'].': </td><td><select name="to">';
$query = 'select id,name from authorization order by name asc';
$result = $this->query($query);
while($row=mysql_fetch_array($result))
{
echo '<option value="'.$row['id'].'"';
if($row['id'] == $_POST['to']) echo ' selected';
echo '>'.$row['name'].'</option>';
}
echo '</select></td><tr>';
echo '<tr><td>'.$this->lang['Subject'].':</td><td><input type="text" name="subject" size="45" value="'.$_POST['subject'].'"></td></tr>';
echo '<tr><td>'.$this->lang['Body'].':</td><td><textarea name="body" cols="45" rows="7">'.$_POST['body'].'</textarea></td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" name="subSendMessage" value="Send"></td></tr>';
echo '</table>';
echo '<input type="hidden" name="from" value="'.$_SESSION['squitoid'].'">';
echo '</form>';

}
function show_message($message_id)
{
$query = 'select * from message where message_id = "'.$message_id.'" limit 1';
//echo $query;
$result = $this->query($query);
$row = mysql_fetch_array($result);
echo '<table class="newmessage">';
echo '<tr><td>To:</td><td>';
echo $this->get_username($row['to_id']);
echo '</td></tr>';
echo '<tr><td>From:</td><td>';
echo $this->get_username($row['from_id']);
echo '</td></tr>';
echo '<tr><td>Date:</td><td>';
echo date("F j, Y, g:i a",$row['date']);
echo '</td></tr>';
echo '<tr><td>Subject:</td><td>';
echo htmlspecialchars(stripslashes($row['subject']));
echo '</td></tr>';
echo '<tr><td colspan="2">';
echo nl2br(htmlspecialchars(stripslashes($row['body'])));
echo '</td></tr>';
echo '</table>';
$query = 'update message set status=1 where message_id = "'.$message_id.'"';
$this->query($query);
}
function get_username($user_id)
{
$query = 'select name from authorization where id = "'.$user_id.'"';
$result = $this->query($query);
$row=mysql_fetch_row($result);
return $row[0];
}
//******************************************************show_message_form
//******************************************************send message
function send_message($to,$from,$subject,$body)
{
if(!$subject) $_SESSION['msgerror'] = $this->lang['Cannot leave subject blank'].'<br>';
if(!$body) $_SESSION['msgerror'] .= $this->lang['Cannot leave body blank'];

if(!$_SESSION['msgerror'])
{
$query = 'insert into message (to_id,from_id,subject,body,date) values ("'.$to.'","'.$from.'","'.$subject.'","'.$body.'","'.time().'")';
$this->query($query);
header('Location: http://'.$this->homeurl.$this->webroot.'/');
}


}


//******************************************************send message

function get_defaults()
{
$query = 'select * from prefs limit 1';
$result=$this->query($query);
return mysql_fetch_array($result);
}
function show_per_file_per_page()
{
$myrow = $this->get_defaults();
?>

<form name="photoform" action="?menu=photos&dir_id=<?php echo $_GET['dir_id'];?>" method="post">
<select name="form_photoperpage" onChange="photoform.submit();"><option><?php echo $this->lang['Photos Per Page'];?></option>
<option value="<?php echo (($myrow['photo_per_col']* $myrow['photo_per_row'])/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page'];?> (Default)</option>
<option value="<?php echo (($myrow['photo_per_col']* $myrow['photo_per_col'])/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page']; ?> (<?php echo (($myrow['photo_per_col']* $myrow['photo_per_col']));?>)</option>
<option value="<?php echo (($myrow['photo_per_col']* ($myrow['photo_per_col']*4))/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page']; ?> (<?php echo ($myrow['photo_per_col']*($myrow['photo_per_col']*4));?>)</option>
<option value="<?php echo (($myrow['photo_per_col']* ($myrow['photo_per_col']*6))/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page']; ?> (<?php echo ($myrow['photo_per_col']*($myrow['photo_per_col']*6));?>)</option>
<option value="<?php echo (($myrow['photo_per_col']* ($myrow['photo_per_col']*8))/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page']; ?> (<?php echo ($myrow['photo_per_col']*($myrow['photo_per_col']*8));?>)</option>
<option value="<?php echo (($myrow['photo_per_col']* ($myrow['photo_per_col']*10))/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page']; ?> (<?php echo ($myrow['photo_per_col']*($myrow['photo_per_col']*10));?>)</option>
<option value="<?php echo (($myrow['photo_per_col']* ($myrow['photo_per_col']*12))/$myrow['photo_per_col']);?>"><?php echo $this->lang['Photos Per Page']; ?> (<?php echo ($myrow['photo_per_col']*($myrow['photo_per_col']*12));?>)</option>
</select>
<input type="hidden" name="photopage" value="1">
<input type="hidden" name="submitPhotoPerPage" value="1">
</form>
<?php

}

function validate_upload($the_file,$the_file_type)
{


        $start_error = "\n<b>Error:</b>\n<ul>";
        $query = 'select * from fileinfo_q where required = 1';
        $result=$this->query($query);
        while($myrow=mysql_fetch_array($result))
        {
           foreach($_POST['form_input'] as $key=>$value)
           if($myrow['id']==$key)
           if(!$value[0]){
           
		   $error .= "\n<li>".$this->lang['You must supply'].' '.$myrow['question']."!</li>";
		   }

        }

         if(isset($error))
         return $start_error.$error;
          

         if ($the_file == "none")
         {
		            
	
               $error = "\n<li>'.$this->lang['You did not upload anything!'].'</li>";
                return $start_error.$error;

         }
        else
        { # check if we are allowed to upload this file_type

            if (!in_array($the_file_type,$this->allowed_types))
              {
		       		  
                   $error .= "\n<li>".$this->lang['wrong_type'].":\n<ul>";
                 while ($type = current($this->allowed_types))
                 {
                   $error .= "\n<li>" . $this->registered_types[$type] . " (" . $type . ")</li>";
                   next($this->allowed_types);
                 }
               
               
			     
				 $error .= "\n</ul><br><BR>".$lang['Try again']." ";
               }
        }


        if ($error)
        {
            $error = $start_error . $error . "\n</ul>";
            return $error;
        }
        else
        {
            return false;
        }


}

function upload_file($id,$tempname, $realname, $input,$gfxtype,$filetype)
{
   $query = 'insert into photofile (dir_id,time_uploaded) values ("'.$id.'","'.time().'")';
   $this->query($query);

   $query = 'select id from photofile order by id desc limit 1';
   $result = $this->query($query);
   $myrow= mysql_fetch_row($result);
   $query = 'update photofile set filename = "'.$myrow[0].'.'.end(explode('.',$realname)).'" where id = "'.$myrow[0].'"';
   $this->query($query);
   $this->handleupload($id, $tempname, $myrow[0].'.'.end(explode('.',$realname)),$gfxtype,$filetype);
   $this->flush_photofile_index();
   $query = 'select id from photofile order by id desc limit 1';
   $result = $this->query($query);
   $myrow = mysql_fetch_row($result);
   $this->flush_photofile_index();
   foreach($input as $key=>$value)
   {
     $query= 'insert into fileinfo_a (photo_id, q_id, answer) values ("'.$myrow[0].'","'.$key.'","'.$value[0].'")';
     $this->query($query);

   }
}
function handleupload($id, $filename, $realname, $gfxtype,$filetype)
{
if($gfxtype==1)
$useimagemagick=1;
if($gfxtype==2)
$usegd184=1;
if($gfxtype==3)
$usegd201=1;


        if (is_uploaded_file($filename))
        {
         //echo $filename;
                  $dir = $this->recursive_path($id);
                 
                if($this->os=='1')
                {
                 $fullimage = str_replace('/','\\',$this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname);
                 $thumbimage = str_replace('/','\\',$this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.$realname);
                                 }
                else
                {

                 $fullimage = $this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname;
                 $thumbimage = $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.$realname;
  //               echo $fullimage.'<br>';
                }
                $size = getimagesize($filename);

                if($useimagemagick)
                {
                  if($size[0]<500 && $size[1]<500)
                  copy($filename,$this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.$realname);
                  else
                  system($this->imagemagickpath."convert -geometry 500x500 \"$filename\" +profile '*' \"$fullimage\"");
//                  echo $this->imagemagickpath."convert -geometry 500x500 \"$filename\" +profile '*' \"$fullimage\"".'<br>';
                  system($this->imagemagickpath."convert -geometry ".$this->thumbsize."x".$this->thumbsize." \"$filename\" +profile '*' \"$thumbimage\"");

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
                  $this->makethumb($realname, $filename, $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/', $this->thumbsize,1);
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
                   $this->makethumb($realname, $filename, $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/', $this->thumbsize,0);
                   else
                   copy($filename,$this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.$realname);

                }

                //echo $imagemagickpath."convert -geometry 500 \"$photoroot$images$uploadpath$realname\" +profile '*' \"$photoroot$images$uploadpath$realname\"\n";
                //echo $imagemagickpath."convert -geometry $thumbsize \"$photoroot$images$uploadpath$realname\" +profile '*' \"$photoroot$thumbnails$uploadpath$realname\"\n";
        }
        else
        {
                echo "Possible file upload attack: filename" . $_FILES['form_file']['name'] . ".";
        }
        //return $realname;
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





function set_per_cols($col)
{
   $this->per_col = $col;
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
echo '<font size="4">'.$this->lang['User Comments'].':</font><hr><table width="100%">';
if(mysql_num_rows($result))
{
while($myrow = mysql_fetch_array($result))
{
?>
<tr><td><?php echo $this->lang['Name']; ;?>: </td><td width="100%"><?php echo $myrow['name'];?></tD></tr>
<tr><td><?php echo $this->lang['Email']; ;?>: </td><td><?php echo $myrow['email'];?></td></tr>
<tr><td valign="top" nowrap><?php echo $this->lang['Comment']; ?>: </td><td><?php echo htmlspecialchars($myrow['comments']);?></td></tr>
<tr><td colspan="2"><hr></td></tr>
<?php

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
$query = 'insert into imagecomments (photo_id,name,email,comments,ip) values ("'.$id.'","'.$name.'","'.$email.'","'.htmlspecialchars($comment).'","'.$_SERVER['REMOTE_ADDR'].'")';
$this->query($query);
}



function get_next_photo_vote($id)
{
$query = 'select orderid,dir_id from photofile where id = "'.$id.'" order by orderid asc';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
$dir_id = $myrow[1];
$query = 'select * from photofile where orderid = "'.($myrow[0]+1).'" and dir_id = "'.$myrow[1].'"';
//echo $query;
$result = $this->query($query);
$myrow= mysql_fetch_array($result);
if($myrow['filename'])
return '<script language="javascript">window.location.href="?menu=photos&photo_id='.$myrow['id'].'";</script>';
else
return '<script language="javascript">window.location.href="?menu=photos&dir_id='.$dir_id.'"</script>';
}





function get_next_photo($id)
{
$query = 'select orderid,dir_id from photofile where id = "'.$id.'" order by orderid asc';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
$query = 'select * from photofile where orderid = "'.($myrow[0]+1).'" and dir_id = "'.$myrow[1].'"';
$result = $this->query($query);
if(mysql_num_rows($result))
{
$myrow= mysql_fetch_array($result);
$dir = $this->recursive_path($myrow['dir_id']);
$file = $this->webroot.'/' . $this->thumbdir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'];
return '<a href="?photo_id='.$myrow['id'].'"><img src="'.$file.'" border="0"><br>'.$this->lang['Next'].'</a>';
}
}

function get_previous_photo($id)
{
$query = 'select orderid,dir_id from photofile where id = "'.$id.'" order by orderid asc';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
$query = 'select * from photofile where orderid = "'.($myrow[0]-1).'" and dir_id = "'.$myrow[1].'"';
$result = $this->query($query);
if(mysql_num_rows($result))
{
$myrow= mysql_fetch_array($result);
$dir = $this->recursive_path($myrow['dir_id']);
$file = $this->webroot.'/' . $this->thumbdir;

$file .=$dir;
$file.=$this->get_name($myrow['dir_id']).'/'.$myrow['filename'];
return '<a href="?photo_id='.$myrow['id'].'"><img src="'.$file.'" border="0"><br>'.$this->lang['Previous'].'</a>';
}
}
function flush_photofile_index()
{
$query = 'select id from photodir order by id asc';
$result = $this->query($query);

while($myrow=mysql_fetch_array($result))
{
$query = 'select id, dir_id from photofile where dir_id = "'.$myrow[0].'"';
$res = $this->query($query);
$i=0;
while($row = mysql_fetch_array($res))
{

$query = 'update photofile set orderid = "'.$i.'" where id = "'.$row['id'].'" and dir_id ="'.$row['dir_id'].'"';
//echo $query;
$this->query($query);
$i++;

}
}
}
function show_next_previous($id)
{
?>
<table width="100%"><tr><td align="left"><?php echo $this->get_previous_photo($id);?></td><td align="right"><?php echo $this->get_next_photo($id);?></td></tr></table>
<?php


}
function show_comment_form($id)
{
$query = 'select anonymous_comments from prefs limit 1';
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
if($myrow[0])
{
echo '<a name="addcomment"></a>'.$this->lang['Add Comment'].'</a>';
if($_SESSION['auth']&&$_SESSION['squitouser'])
{
?>
<form action="" method="post"><input type="hidden" name="form_photo_id" value="<?php echo $id;?>">
<table><tr><td><?php echo $this->lang['Name'];?>: </td><td><input type="hidden" name="form_name" value="<?php echo $_SESSION['squitouser'];?>"><?php echo $_SESSION['squitouser'];?></td></tr>
<tr><td><?php echo $this->lang['Email'];?>: </td><td><input type="hidden" name="form_email" value="<?php echo $_SESSION['squitoemail'];?>"><?php echo $_SESSION['squitoemail'];?></td></tr>
<tr><td valign="top"><?php echo $this->lang['Comment'];?>: </td><td><textarea name="form_comment" maxlength="200" cols="75" rows="5"></textarea></td></tr>
</table>
<input type="submit" name="submitComment" value="save">
</form>
<?php
}
else
{
?>
<form action="" method="post"><input type="hidden" name="form_photo_id" value="<?php echo $id;?>">
<table><tr><td><?php echo $this->lang['Name'];?>: </td><td><input type="text" name="form_name"  maxlength="50" size="50"></td></tr>
<tr><td><?php echo $this->lang['Email'];?>: </td><td><input type="text" name="form_email" maxlength="50" size="50"></td></tr>
<tr><td valign="top"><?php echo $this->lang['Comment'];?>: </td><td><textarea name="form_comment" maxlength="200" cols="75" rows="5"></textarea></td></tr>
</table>
<input type="submit" name="submitComment" value="save">
</form>
<?php
}
}
else if(isset($_SESSION['auth'])&&isset($_SESSION['squitouser']))
{?>
<form action="" method="post"><input type="hidden" name="form_photo_id" value="<?php echo $id;?>">
<table><tr><td><?php echo $this->lang['Name'];?>: </td><td><input type="hidden" name="form_name" value="<?php echo $_SESSION['squitouser'];?>"><?php echo $_SESSION['squitouser'];?></td></tr>
<tr><td><?php echo $this->lang['Email'];?>: </td><td><input type="hidden" name="form_email" value="<?php echo $_SESSION['squitoemail'];?>"><?php echo $_SESSION['squitoemail'];?></td></tr>
<tr><td valign="top"><?php echo $this->lang['Comment'];?>: </td><td><textarea name="form_comment" maxlength="200" cols="75" rows="5"></textarea></td></tr>
</table>
<input type="submit" name="submitComment" value="save">
</form>

<?php
}
else
{
echo '<div align="center"><table cellpadding="5" cellspacing="0" class="imagebox" align="center"><tr><td>'; 
echo $this->lang['Please login to leave a comment'];
$this->login_form($_SERVER['REQUEST_URI']);
$_SESSION['redirect']= 'http://'.$this->homeurl.$_SERVER['REQUEST_URI'];
echo '<a href="index.php?menu=signup">'.$this->lang['Don\'t have an account yet?'].'</a>';
echo '</td></tr></table></div>';
}



}
function login_form($redirect)
{

?>
  <form name="login_form" method="post" action="<?php echo $this->webroot;?>/auth/auth.php">
<?php 
//if(!isset($_SESSION['attempt']))  $_SESSION['attempt']='';
if($_SESSION['attempt']==1)
{
echo "invalid username or password please try again!";
$_SESSION['attempt'] =0;
}

?>
        <p>
          <?php echo $this->lang['Username'];?>:
          <input type="text" name="user">
          <br>
          <?php echo $this->lang['Password'];?>:
          <input type="password" name="pass">
          <br>
          <br>
                 <input type="hidden" name="form_refer" value="<?php echo $redirect;?>">
          <input type="submit" name="Login" value="Login">

        </p>
        </form>

<?php
}

function update_imagetrack($id)
{
$query = 'update imagetrack set views = views+1 where photo_id = "'.$id.'"';
$this->query($query);
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
                show_fileinfo($id);

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
				if($this->lang[$arr[$myrow['q_id']]]) $must = $this->lang[$arr[$myrow['q_id']]]; else $must = $arr[$myrow['q_id']];
                  echo '<tr><td>'.$must.': '.htmlspecialchars($myrow['answer']).'</td></tr>';
                }
                echo '</table>';
                }
                else
                $this->add_fileinfo($id);

}
function is_vote_enabled()
{
$query = 'select voting from prefs limit 1';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];


}
function add_vote($id,$vote)
{
$query = 'insert into photovote (photo_id,vote) values ("'.$id.'","'.$vote.'")';
$this->query($query);
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


function show_vote_form($id)
{
?>
<form name="photovote" method="post" action="" >
<table width="100%" cellspacing = "0">
  <tr>
    <td class="vote_bg" colspan="2">
      <input type="hidden" name="form_photo_id" value="<?php echo $id; ?>">
      Photo Vote</td></tr>
  <tr>
    <td class="vote_center" align="center" colspan="2">
     <?php
	 for($x=1; $x<=10; $x++)
	 echo $x.' <input type="radio" name="form_photovote" value="'.$x.'" onClick="photovote.submit()" class="radio">';
      ?>
	  </td></tr>
  <tr>
    <td class="vote_bg" align="left"><?php echo $this->lang['Bad']; ?></td>
    <td class="vote_bg" align="right"><?php echo $this->lang['Good'];?></td></tr>
</table>
<input type="hidden" name="submitPhotoVote" value="1">
</form>
Total Votes: <?php echo $this->get_totalvotes($id);?>
<?php
echo '<br>';
echo $this->lang['Avg Vote'];
echo ': <font size="2"><b>'.number_format($this->get_vote_avg($id),1).'</b></font><br><br>';


}


function recursive_path($id)
{
    $dir ='';
   $arr = $this->get_ancestors($id);

   for ($x=0; $x<sizeof($arr); $x++)
        {
                $dir.=  $arr[$x]["name"].'/';
        }
   return $dir;
   
}


//**show_dir_list ***************************************************************
  function show_dir_list($id = 0)
{

   if(!$this->dirpage) $this->dirpage=1;

   $arr = $this->get_ancestors($id);
   echo '<table><tr><td><a href="?menu=photos&dir_id=0">Home</a>';
   for ($x=0; $x<sizeof($arr); $x++)
        {
                echo ' | <a href="?menu=photo&dir_id='. $arr[$x]["id"].'">' . $arr[$x]["name"].'</a>';
        }
   echo ' | '.$this->get_name($id);
   echo '</td></tr></table>';
   $count=1;
  if(!$this->dirpage) $this->dirpage=1;
$query = 'select count(photodir.id) from photodir,access where photodir.id = access.dir_id and photodir.parentid = "'.$id. '" and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
$totalfiles = $myrow[0];
$query = 'select photodir.* from photodir,access where photodir.id = access.dir_id and photodir.parentid = "'.$id. '" and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" order by name asc limit '.(($this->dirpage-1)*($this->per_col*$this->per_row)).','.$this->per_col*$this->per_row;
//echo $query;
$result = $this->query($query);
$count=1;
   $total_pages = ($totalfiles/($this->per_col*$this->per_row));
   //echo $total_pages;
   if($total_pages>0&&$totalfiles<=($this->per_col*$this->per_row))
   {
   echo '<table width="100%"><tr><td class="box" align="center">';
   $this->show_per_dir_per_page();
   echo '</td></tr></table>';
   }
   if($total_pages>1)
   {
   echo '<table width="100%"><tr><td class="box" align="center">';
   $this->show_per_dir_per_page();

    if($this->dirpage>1)
    echo '<a href="?menu=photos&dir_id='.$id.'&dirpage='.($this->dirpage-1).'">'.$this->lang['Previous'].'</a> ';
   for($x=0; $x<$total_pages; $x++)
   {
     if($this->dirpage == $x+1)
     echo ($x+1).' ';
     else
     echo '<a href="?menu=photos&dir_id='.$id.'&dirpage='.($x+1).'">'.($x+1).'</a> ';
   }
    if(($this->dirpage)<=$total_pages)
    echo '<a href="?menu=photos&dir_id='.$id.'&dirpage='.($this->dirpage+1).'">'.$this->lang['Next'].'</a> ';

    echo '</td></tr></table>'."\n\n\n";
   }
if(mysql_num_rows($result))
{
echo "\n\n\n".'<table width="100%" cellpadding="5" class="imagebox"><tr><td colspan="'.$this->per_col.'">Albums</td></tr><tr>'."\n";


$dir = $this->recursive_path($id);
	while($myrow = mysql_fetch_array($result))
{
$icon_query =$this->get_icon($myrow['id']);
				if($icon_query[1])
				$icon = $this->webroot.'/'.$this->thumbdir.$dir.$this->get_name($id).'/'.$this->get_image_dirname($icon_query[2]).'/'.$this->get_imagename($icon_query[2]);
				else
				$icon = $this->webroot.'/icons/'.$icon_query[0];





echo '<td align="center" width="'.(int)((1/$this->per_col)*100).'%" ><a href="index.php?menu=photos&dir_id='.$myrow['id'].'"><img src="'.$icon.'" border="0" ><br>'.$this->get_name($myrow['id']).'</a><br>'.$this->get_photocount($myrow['id']).' ';
if($this->lang['Photos']) echo $this->lang['Photos']; else echo 'Photos';
echo '<br>'.stripslashes($myrow['description']).'</td>'."\n";

if($this->per_col<=$count)
{
echo '</tR><tr>'."\n\n";
$count=0;
}
$count++;
}
while($count<=$this->per_col)
{
echo '<td width="'.(int)((1/$this->per_col)*100).'%"></td>';
$count++;
}
echo '</tr></table></div>'."\n\n\n";
}
   //$this->show_per_file_per_page();
   if($total_pages>1)
   {
   echo '<table width="100%"><tr><td class="box" align="center">';
    
	if($this->dirpage>1)
    echo '<a href="?menu=photos&dir_id='.$id.'&dirpage='.($this->dirpage-1).'">'.$this->lang['Previous'].'</a> ';
   for($x=0; $x<$total_pages; $x++)
   {
     if($this->dirpage == $x+1)
     echo ($x+1).' ';
     else
     echo '<a href="?menu=photos&dir_id='.$id.'&dirpage='.($x+1).'">'.($x+1).'</a> ';
   }


   if($this->dirpage<=$total_pages)
    echo '<a href="?menu=photos&dir_id='.$id.'&dirpage='.($this->dirpage+1).'">'.$this->lang['Next'].'</a> ';
    echo '</td></tr></table>';
    }
   return $id;
}

// show file ************************show file ************************show file ************************show file ************************show file ************************
function show_file($id=0)
{
$query = 'select photofile.filename,photofile.dir_id from photofile,access where photofile.id = "'.$id.'" and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" limit 1';
$request = $this->query($query);
if(mysql_num_rows($request))
{
$myrow = mysql_fetch_array($request);
$arr = $this->get_ancestors($myrow['dir_id']);
   echo '<table><tr><td><a href="?dir_id=0">Home</a>';
   for ($x=0; $x<sizeof($arr); $x++)
        {
                echo ' | <a href="?menu=photos&dir_id='. $arr[$x]["id"].'">' . $arr[$x]["name"].'</a>';
        }
   echo ' | <a href="?menu=photos&dir_id='.$myrow['dir_id'].'">'.$this->get_name($myrow['dir_id']).'</a>';
   echo ' | '.$myrow['filename'];
   echo '</td></tr></table>';
$dir = $this->recursive_path($myrow['dir_id']);
$arr = $this->get_dimensions($id);
echo '<table width="100%"><tr><td align="center"><img src="'.$this->webroot.'/' . $this->imagedir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'] . '" class="imagebox" width="'.$arr[0].'" height="'.$arr[1].'"><br><a href="#addcomment">';
echo $this->lang['add comment'];
echo '</a></td></tr></table>';
//return $this->webroot.'/'.$this->imagedir.$this->get_name($myrow['dir_id']).$dir;
//return $myrow['dir_id'];
//return $query;
}
else
echo $this->lang['Invalid filename please try again!']; 

}
function check_photo_permission($photo_id)
{
$query = 'select photofile.filename,photofile.dir_id from photofile,access where photofile.id = "'.$photo_id.'" and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" limit 1';
$result = $this->query($query);
if(mysql_num_rows($result))
return 1;
else
return 0;
}
function check_album_permission($dir_id)
{
$query = 'select photodir.id from photodir,access where photodir.id = "'.$dir_id.'" and photodir.id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" limit 1';
$result = $this->query($query);
if(mysql_num_rows($result))
return 1;
else
return 0;
}

//****show_file_list*******************************show_file_list**************show_file_list**************show_file_list**************show_file_list***********************************
function show_file_list($id=0)
{

$dir = $this->recursive_path($id);
if(!$this->page) $this->page=1;
$query = 'select count(photofile.id) from photofile,access where photofile.dir_id = "'.$id. '" and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
$totalfiles = $myrow[0];
$query = 'select photofile.id, photofile.filename from photofile, access where photofile.dir_id = "'.$id. '" and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" order by orderid asc limit '.(($this->page-1)*($this->photo_per_col*$this->photo_per_row)).','.$this->photo_per_col*$this->photo_per_row;
$result = $this->query($query);
$count=1;
   $total_pages = ($totalfiles/($this->photo_per_col*$this->photo_per_row));
   //echo $total_pages;
   if($total_pages>0&&$totalfiles<=($this->photo_per_col*$this->photo_per_row))
   {
   echo '<table width="100%"><tr><td class="box" align="center">';
   $this->show_per_file_per_page();
   echo '</td></tr></table>';
   }
   if($total_pages>1)
   {

   echo '<table width="100%"><tr><td class="box" align="center">';
   $this->show_per_file_per_page();

    if($this->page>1)
    echo '<a href="?menu=photos&dir_id='.$id.'&page='.($this->page-1).'">'.$this->lang['Previous'].'</a> ';
   for($x=0; $x<$total_pages; $x++)
   {
     if($this->page == $x+1)
     echo ($x+1).' ';
     else
     echo '<a href="?menu=photos&dir_id='.$id.'&page='.($x+1).'">'.($x+1).'</a> ';
   }
   
    if(($this->page)<=$total_pages)
    echo '<a href="?menu=photos&dir_id='.$id.'&page='.($this->page+1).'">'.$this->lang['Next'].'</a> ';

    echo '</td></tr></table>'."\n\n\n";
   }
if(mysql_num_rows($result))
{
echo "\n\n\n".'<div align="center"><table width="100%" cellpadding="5" class="imagebox"><tr><td colspan="'.$this->photo_per_col.'">'.$this->lang['Photos'].'</td></td><tr>'."\n";





if(!isset($dir)) $dir = '';
while($myrow = mysql_fetch_array($result))
{
echo '<td align="center" width="'.(int)((1/$this->photo_per_col)*100).'%" ><a href="index.php?menu=photos&photo_id='.$myrow['id'].'" title="'.$this->lang['Filename'].': '.$myrow['filename']."\n".$this->lang['Views'].": ".$this->get_views($myrow['id'])."\n".$this->lang['Total Votes'].": ".$this->get_totalvotes($myrow['id'])."\n".$this->lang['Avg Vote'].": ".number_format($this->get_vote_avg($myrow['id']),1)."\n".$this->lang['Number of Comments'].": ".$this->get_comment_count($myrow['id']).'"><img class="imagebox" src="'.$this->webroot.'/'.$this->thumbdir.$dir.$this->get_name($id).'/'.$myrow['filename'].'" border="0" ><br><div align="center"></a></div></td>'."\n";
if($this->photo_per_col<=$count)
{
echo '</tR><tr>'."\n\n";
$count=0;
}
$count++;
}
while($count<=$this->photo_per_col)
{
echo '<td width="'.(int)((1/$this->photo_per_col)*100).'%"></td>';
$count++;
}
echo '</tr></table></div>'."\n\n\n";
}
   //$this->show_per_file_per_page();
   if($total_pages>1)
   {
   echo '<table width="100%"><tr><td class="box" align="center">';
   
    if($this->page>1)
    echo '<a href="?menu=photos&dir_id='.$id.'&page='.($this->page-1).'">'.$this->lang['Previous'].'</a> ';
   for($x=0; $x<$total_pages; $x++)
   {
     if($this->page == $x+1)
     echo ($x+1).' ';
     else
     echo '<a href="?menu=photos&dir_id='.$id.'&page='.($x+1).'">'.($x+1).'</a> ';
   }

   if($this->page<=$total_pages)
    echo '<a href="?menu=photos&dir_id='.$id.'&page='.($this->page+1).'">'.$this->lang['Next'].'</a> ';
    echo '</td></tr></table>';
    }
}
function get_photocount($id)
{
$query = 'select id from photofile where dir_id ="'.$id.'"';
$result = $this->query($query);
return mysql_num_rows($result);

}


function get_filesize($id)
{
$query = 'select filename,dir_id from photofile where id = "'.$id.'" limit 1';
$request = $this->query($query);
$myrow = mysql_fetch_array($request);
$arr = $this->get_ancestors($myrow['dir_id']);
for($x=0; $x<sizeof($arr); $x++)
{
$dir .= $arr[$x]['name'].'/';
}

$arr[0] = round(filesize($this->photoroot.$this->imagedir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'])/1000);
$arr[1] = round(filesize($this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow['dir_id']).'/'.$myrow['filename'])/1000);
return $arr;

}



function get_dimensions($id=0)
{
$query = 'select dir_id,filename from photofile where id = "'.$id.'"';
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
$dir = $this->recursive_path($dest_dir_id);

$destination_full = $this->photoroot.$this->imagedir.$dir.$this->get_name($dest_dir_id).'/'.$myrow['filename'];
$destination_thumb = $this->photoroot.$this->thumbdir.$dir.$this->get_name($dest_dir_id).'/'.$myrow['filename'];
//echo $source_full.'<br>'.$destination_full.'<br>';
//echo $source_full.'<br>'.$destination_full;
if(copy($source_full,$destination_full)&&copy($source_thumb,$destination_thumb))
{
unlink($source_full);
unlink($source_thumb);
}
$this->flush_photofile_index();
}
function delete_file($id)
{
$query = 'select dir_id,filename from photofile where id = "'.$id.'"';
//echo $query;
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
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
$dir = $this->recursive_path($myrow['dir_id']);
//echo $this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename'];
unlink($this->photoroot.$this->imagesdir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename']);
unlink($this->photoroot.$this->thumbdir.$dir.$this->get_name($myrow[0]).'/'.$myrow['filename']);
$this->flush_photofile_index();
}
function add_dir($id=0,$newdir)
{
$dir = $this->recursive_path($id);

$createdir =  $this->photoroot.$this->imagedir.$dir.$this->get_name($id). '/' . trim($newdir,'/');

$createthumbdir =  $this->photoroot.$this->thumbdir.$dir.$this->get_name($id).'/'.trim($newdir,'/');


//echo $createdir;
//echo $this->photoroot.$this->imagedir.$dir.$this->get_name($id).'/'.trim($newdir,'/')."<br>\n";
if(mkdir($createdir,0777) && mkdir($createthumbdir,0777))
{
echo 'directories created';
$this->query('insert into photodir (name, parentid) values ("'.$newdir.'","'.$id.'")');
$query = 'select name,parentid,id from photodir where name = "'.$newdir.'" and parentid = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_array($result);
$this->query('insert into access (user_id,dir_id,r) values ("0","'.$myrow['id'].'","1")');
}
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
         return $children;
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
                $query = "SELECT name FROM $this->table WHERE id = '$id'";
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
                $query = "SELECT icon,inlist,icon_id FROM $this->table WHERE id = '$id'";
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
        function get_ancester_droplist($id=0)
{
                $result = $this->get_children($id);
                for ($x=0; $x<sizeof($result); $x++)
                {
       $ancesters = $this->recursive_path($result[$x]['id']);
      
                        echo '</option><option value="'.$result[$x]["id"].'">root/'.$ancesters.$result[$x]["name"] .'/'."\n";

                        $this->get_ancester_droplist($result[$x]["id"]);
                }
                //return $dir;

}
function get_imagename($id)
{
$query = 'select filename from photofile where id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];
}
function check_anonymous_uploads($user_id,$dir_id)
{
$query = 'select photodir.anonymous_uploads, access.r from photodir,access where photodir.id = access.dir_id and photodir.id = "'.$dir_id.'" and access.user_id = "'.$user_id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
if($myrow[0]&&$myrow[1])
return 1;
else
return 0;

}
function get_has_upload_access($user_id,$dir_id)
{
$query = 'select r,u from access where dir_id = "'.$dir_id.'" and user_id = "'.$user_id.'"';
//echo $query;
$result = $this->query($query);
$has_access = array();
$myrow=mysql_fetch_row($result);
if($myrow[0]&&$myrow[1])
return 1;
else
return 0;
}
function show_upload_form($user_id=0,$dir_id)
{
if($this->get_has_upload_access($user_id,$dir_id)||$this->check_anonymous_uploads($user_id,$dir_id))
{
?>
<table width="100%" cellpadding="5"><tr>
    <td class="file_uploads_box" align="center" class="sidebox"><B><font color="#FFFFFF">File Uplaods</font></b></td>
  </tr></table>
<?php
//global $lastpage, $squitouser, $squitoemail;

    echo $_SESSION['upload_error'] . "<br><br>";
    $_SESSION['upload_error'] ='';

    print "\n<form ENCTYPE=\"multipart/form-data\"  action=\"userupload_file.php\" method=\"post\">";
   print "\n<INPUT TYPE=\"hidden\" name=\"form_dir_id\" value=\"".$dir_id."\">";
   echo '<input type="hidden" name="form_imagedir" value="Useruploads">'."\n";
    print "\n<P>Upload a file<br><br>";
    $db= dbConnect();
                    $query = 'select * from fileinfo_q order by id';
                     //echo $query;
					   $result = mysql_query($query, $db);
                       while($myrow = mysql_fetch_array($result))
                       {
					   if($this->lang[$myrow['question']]) $must = $this->lang[$myrow['question']]; else $must = $myrow['question']; 
                        if($myrow['type']==1)
                        echo $must.': <input type="text" name="form_input['.$myrow['id'].'][]" size="'.$myrow['cols'].'"><br>';
                        if($myrow['type']==2)
                        echo $must.': <textarea name="form_input['.$myrow['id'].'][]" cols="'.$myrow['cols'].'" rows="'.$myrow['rows'].'"></textarea><br>';

                       }
    print "\n<BR>NOTE: Max file size is 2MB";

     print "\n<br><INPUT NAME=\"form_file\" TYPE=\"file\" SIZE=\"35\"><br>";
    print "\n<input type=\"submit\" name=\"userFileUpload\" Value=\"Upload\">";
    print "\n</form>";

 }
 else
 echo 'You do not have access to upload files into this album. <a href="index.php?dir_id='.$dir_id.'">Go Back</a>';


}
function search($search)
{

$query = 'create temporary table tmp'.$_COOKIE['PHPSESSID'].' select id,photo_id from fileinfo_a where id="0"';
$this->query($query);

  $arr = explode(' ',$search);
  for($x=0; $x<sizeof($arr); $x++)
  {
  if($x==0) $search_string = 'answer like "%'.$arr[$x].'%"';
  else
  $search_string .= ' or answer like "%'.$arr[$x].'%"';
  
  }
  $query = 'insert into tmp'.$_COOKIE['PHPSESSID'].' select fileinfo_a.id,fileinfo_a.photo_id from fileinfo_a, access, photofile where '.$search_string.' and fileinfo_a.photo_id = photofile.id and photofile.dir_id = access.dir_id and photofile.dir_id = photofile.dir_id  and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" group by photo_id order by id asc';
  $result = $this->query($query);
  for($x=0; $x<sizeof($arr); $x++)
  {
  if($x==0) $search_string = 'comments like "%'.$arr[$x].'%" or name like "%'.$arr[$x].'%" or email like "%'.$arr[$x].'%"';
  else
  $search_string .= ' or comments like "%'.$arr[$x].'%" or name like "%'.$arr[$x].'%" or email like "%'.$arr[$x].'%"';
  
  }

  $query = 'insert into tmp'.$_COOKIE['PHPSESSID'].' select imagecomments.id,imagecomments.photo_id from imagecomments, access, photofile where '.$search_string.' and imagecomments.photo_id = photofile.id and photofile.dir_id = access.dir_id and photofile.dir_id = photofile.dir_id and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1" group by photo_id order by id asc';
  $result = $this->query($query);
  $query = 'select photo_id from tmp'.$_COOKIE['PHPSESSID'].' group by photo_id order by id asc';
  $result = $this->query($query);
  $query = 'drop table tmp'.$_COOKIE['PHPSESSID'];
  echo '<b><i>'.mysql_num_rows($result).'</i></b> Search Results from Search String <b><i>'.$_GET['search'].'</i></b><hr>';
  if(!mysql_num_rows($result)) echo 'No results found';
  else echo '<table width="100%">';
  while($myrow=mysql_fetch_array($result))
  {
    echo '<tr><td width="1" valign="top">'."\n";
	echo $this->get_search_icon($myrow['photo_id'])."\n";
	echo '</td><td valign="top">'."\n";
	$query = 'select * from fileinfo_a where photo_id = "'.$myrow['photo_id'].'" order by q_id asc';
    $res = $this->query($query);
	echo '<table><tr><td>Filename: '.$this->get_imagename($myrow['photo_id']).'<br>'."\n";
    while($row = mysql_fetch_array($res))
    {  
      echo $this->get_fileinfo_question($row['q_id']).': ';
      for($x=0; $x<sizeof($arr); $x++)
	  $row['answer'] = str_replace(htmlspecialchars($arr[$x]),'<b>'.htmlspecialchars($arr[$x]).'</b>',htmlspecialchars($row['answer']));
	  echo $row['answer'].'<br>'."\n";
    }
	echo '</td></tr></table>';
	
  for($x=0; $x<sizeof($arr); $x++)
  {
  if($x==0) $search_string = 'comments like "%'.$arr[$x].'%" or name like "%'.$arr[$x].'%" or email like "%'.$arr[$x].'%"';
  else
  $search_string .= ' or comments like "%'.$arr[$x].'%" or name like "%'.$arr[$x].'%" or email like "%'.$arr[$x].'%"';
  
  }

  $query = 'select * from imagecomments where '.$search_string.' order by id asc';
  $res = $this->query($query);
  $count=0;
  echo '<table cellspacing="0" cellpadding="5" width="100%"><tr><td bgcolor="#CCCCCC">'.$this->lang['Comment'].'</td></tr>';
  while($row=mysql_fetch_array($res))
  {
  for($x=0; $x<sizeof($arr); $x++)
  {
  $row['comments'] = str_replace(htmlspecialchars($arr[$x]),'<b>'.htmlspecialchars($arr[$x]).'</b>',htmlspecialchars($row['comments']));
    $row['name'] = str_replace(htmlspecialchars($arr[$x]),'<b>'.htmlspecialchars($arr[$x]).'</b>',htmlspecialchars($row['name']));
	  $row['email'] = str_replace(htmlspecialchars($arr[$x]),'<b>'.htmlspecialchars($arr[$x]).'</b>',htmlspecialchars($row['email']));
  }

  if($myrow['photo_id'] == $row['photo_id'])
{
    if($count==0)
  {
  $color = "#F0F0F0";
  $count =1;
  }
  else
  if($count==1)
  {
  $color = "#E0E0E0";
  $count =0;
  }
  
  echo '<tr><td bgcolor="'.$color.'">'.$this->lang['Name'].': '.$row['name'].'<br>'.$this->lang['Email'].': '.$row['email'].'<br>'.$this->lang['Comment'].': '.$row['comments']."</td></tr>\n";
 }
  //else echo'</td></tr><tr><td>'."\n";
  }
  
    echo '</table>';
	echo '</td></tr><tr><td height="2" bgcolor="#B9ABC5" colspan="2"></td></tr>'."\n";
  }
echo '</table>'."\n";
 
}
function get_fileinfo_question($id)
{
$query = 'select question from fileinfo_q where id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];
}
function get_search_icon($id)
{
echo '<a href="index.php?photo_id='.$id.'"><img src="'.$this->webroot.'/'.$this->thumbdir.$this->recursive_path($this->get_image_dirid($id)).$this->get_image_dirname($id).'/'.get_imagename($id).'" border="0"></a>';
}
function get_image_dirname($id)
{
$query = 'select dir_id from photofile where id = "'.$id.'" limit 1';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $this->get_name($myrow[0]);

}
function get_image_dirid($id)
{
$query = 'select dir_id from photofile where id = "'.$id.'" limit 1';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];

}  
  
function get_laston($id)
{
$query = 'select last_login from authorization where id = "'.$id.'"';
$result = $this->query($query);
$myrow = mysql_fetch_row($result);
return $myrow[0];

}  
function get_newfiles($time)
{
$query = 'select photofile.id from photofile,access where photofile.time_uploaded > "'.$time.'" and photofile.dir_id = access.dir_id and photofile.dir_id = photofile.dir_id  and photofile.dir_id = access.dir_id and access.user_id = "'.$_SESSION['squitoid'].'" and access.r = "1"';
$result = $this->query($query);
echo '<table width="100%"><tr><td colspan="2">New Files</td></tr><tr><td height="2" colspan="2" bgcolor="#000000"></td></tr>';
$count=0;
if(!mysql_num_rows($result)) echo '<tr><td colspan="2"><i>No new files</i></td></tr>';
while($row = mysql_fetch_array($result))
{
echo '<tr><td width="1">';
echo $this->get_search_icon($row['id']);
echo '</td><td valign="top">'."\n";
$query = 'select * from fileinfo_a where photo_id = "'.$row['id'].'" order by id asc';
$res = $this->query($query);
while($myrow = mysql_fetch_array($res))
{
echo $this->get_fileinfo_question($myrow['q_id']) .': '.htmlspecialchars($myrow['answer']).'<br>'."\n";
}
echo '</td></tr><tr><td height="2" bgcolor="#000000" colspan="2"></td></tr>'."\n";


}
echo '</table>';
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