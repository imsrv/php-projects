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
#filename: angrymos_fns.inc.php
include('../config.inc.php');
function dbConnect()
{
  global $db_host, $db_user, $db_pass, $database;
  $db = MYSQL_CONNECT($db_host,$db_user,$db_pass);
  mysql_select_db($database, $db);
  return $db;
}
function user_exists($user, $db)
{
        $query = 'select count(username) from authorization where name = "'.$user.'"';
        $result = mysql_query($query, $db);
        $myrow = mysql_fetch_row($result);
        if ($myrow[0])
        return 1;
        else
        return 0;

}
function check_password($user, $pass, $db)
{
        if($user && $pass)
        {
                $query = 'select count(id) from authorization where name = "'.$user.'" and password = PASSWORD("'.$pass.'")';
                $result = mysql_query($query, $db);
                $myrow = mysql_fetch_row($result);
                if ($myrow[0])
                return 1;
                else return 0;

        }
        else return 0;
}
function authorize($user, $pass, $db)
{
        if(check_password($user, $pass, $db))
        {
                return 1;
        }
        else return 0;
}

function get_level($user, $db)
{
        $query = 'select access_level from authorization where name = "' . $user . '" limit 1';
        $result = mysql_query($query, $db);
        $myrow = mysql_fetch_row($result);
        return $myrow[0];
}
function request_login()
{

   $db = dbConnect();
   $sql = 'select * from authorization where name like "' . $_POST['form_name'] . '"';
   $result=MYSQL_QUERY($sql,$db);
   $myrow = mysql_fetch_array($result);
   if(!$myrow['name']&&$_POST['form_name']&&$_POST['form_password'])
   {
   if(is_uploaded_file($_FILES['form_file']['tmp_name']))
  $imagesql = ",'".$_POST['form_name'].".jpg'";
   else
   $imagesql = ",''";
   $sql = "INSERT INTO authorization (name,password,access_level,mug) VALUES ('".$_POST['form_name']."',password('".$_POST['form_password']."'),10$imagesql)";
   //echo $sql,'<br>';
   MYSQL_QUERY($sql,$db);
   $query = 'select id from authorization where name = "'.$_POST['form_name'].'"';
   //echo $query.'<br>';
   $result = mysql_query($query,$db);
   $newuser = mysql_fetch_array($result);

   $query = 'select * from profile_q order by id asc';
   $result = mysql_query($query,$db);
   while($myrow = mysql_fetch_array($result))
   {
    $query = 'insert into profile_a (u_id,q_id,answer) values ('.$newuser['id'].','.$myrow['id'].',"'.$_POST['form_q'][$myrow['id']][0].'")';
    //echo $query.'<br>';
    MYSQL_QUERY($query,$db);
   }
   MYSQL_CLOSE();
   $_SESSION['taken']=0;
   $_SESSION['attempt']=0;
   $_SESSION['usercreated'] = 1;
   //header('location: admin.php?menu=listall');
   }
   else{
   MYSQL_CLOSE();
   $_SESSION['taken']=1;
   //header('location: admin.php?menu=adduser');

   }


}
function admin_addquestion()
{
$db = dbConnect();
$query = 'insert into profile_q (question,type,cols,rows) values ("'.$_POST['form_question'].'","'.$_POST['form_type'].'","'.$_POST['form_cols'].'","'.$_POST['form_rows'].'")';
//echo $query;
mysql_query($query,$db);
mysql_close();
$_SESSION['addquestion'] =1;
}
function admin_adduser()
{

   $db = dbConnect();
   $sql = 'select * from authorization where name like "' . $_POST['form_name'] . '"';
   $result=MYSQL_QUERY($sql,$db);
   $myrow = mysql_fetch_array($result);
   if(!$myrow['name']&&$_POST['form_name']&&$_POST['form_password'])
   {
   $sql = "INSERT INTO authorization (name,password,access_level) VALUES ('".$_POST['form_name']."',password('".$_POST['form_password']."'),'".$_POST['form_access_level']."')";
   //echo $sql,'<br>';
   MYSQL_QUERY($sql,$db);
   $query = 'select id from authorization where name = "'.$_POST['form_name'].'"';
   //echo $query.'<br>';
   $result = mysql_query($query,$db);
   $newuser = mysql_fetch_array($result);

   $query = 'select * from profile_q order by id asc';
   $result = mysql_query($query,$db);
   while($myrow = mysql_fetch_array($result))
   {
    $query = 'insert into profile_a (u_id,q_id,answer) values ('.$newuser['id'].','.$myrow['id'].',"'.$_POST['form_q'][$myrow['id']][0].'")';
    //echo $query.'<br>';
    MYSQL_QUERY($query,$db);
   }
   MYSQL_CLOSE();
   $_SESSION['taken']=0;
   $_SESSION['attempt']=0;
   header('location: admin.php?menu=listall');
   }
   else{
   MYSQL_CLOSE();
   $_SESSION['taken']=1;
   header('location: admin.php?menu=adduser');

   }

}
function dateTime()

{

   return date("F j, Y, g:i a");

}

function update_user()

{


if($_POST['form_password']!=0 && $_POST['form_password']!="encrypted")
{
$password = ', password=password("'.$_POST['form_password'].'")';
}


 $db = dbConnect();

$q = $_POST['form_q'];
$db = dbConnect();
$query = 'select * from profile_q order by id asc';
$result = mysql_query($query, $db);
while($myrow= mysql_fetch_array($result))
{
$query = 'select q_id from profile_a where q_id = '.$myrow['id']. ' and u_id = '.$_POST['form_id'];
//echo $query.'<br>';
$qres= mysql_query($query,$db);

if(!mysql_num_rows($qres))
{
    $query = 'insert into profile_a (u_id,q_id,answer) values ('.$_POST['form_id'].','.$myrow['id'].',"'.$q[$myrow['id']][0].'")';
    //echo $query.'<br>';
    MYSQL_QUERY($query,$db);
}
else
{
$query = 'update profile_a set answer = "'.$q[$myrow['id']][0].'" where u_id = '.$_POST['form_id'].' and q_id = '.$myrow['id'];
//echo $query.'<br>';
MYSQL_QUERY($query,$db);
}
}

 $query = 'UPDATE authorization SET access_level="'.$_POST['form_access_level'].'"'.$password.' WHERE id=' . $_POST['form_id'];

 MYSQL_QUERY($query,$db);

 MYSQL_CLOSE();

}
function profile()

{

 $db = dbConnect();

 $query = 'UPDATE authorization SET  email="' . $_POST['form_email'] . '", AIM="' . $_POST['form_AIM'] . '" WHERE id=' . $_POST['form_id'];

 MYSQL_QUERY($query,$db);

 MYSQL_CLOSE();

}
function handleupload($uploadpath,$imagemagickpath)
{
        global $photoroot, $images, $thumbnails, $thumbsize, $useimagemagick, $usegd184, $usegd201;

        if (is_uploaded_file($_FILES['form_file']['tmp_name']))
        {
                $filename = $_FILES['form_file']['tmp_name'];
                //print "$filename was uploaded successfuly";
                $realname = $_POST['form_name'].'.jpg';
                //print "realname is $realname";
                //print "copying file to uploads dir";
                if($uploadpath)
                $uploadpath= $uploadpath.'/';

                copy($_FILES['form_file']['tmp_name'],$photoroot.$uploadpath .$realname);
                system($imagemagickpath."convert -geometry 400x400 \"$photoroot$uploadpath$realname\" +profile '*' \"$photoroot$uploadpath$realname\"");
                echo $imagemagickpath."convert -geometry 400x400 \"$photoroot$uploadpath$realname\" +profile '*' \"$photoroot$uploadpath$realname\"";

        }
        else
        {
                echo "Possible file upload attack: filename" . $_FILES['form_file']['name'] . ".";
        }
        return $realname;
}
function validate_upload($allowed_types,$registered_types) {

$the_file = $_FILES['form_file']['tmp_name'];
$the_file_type = $_FILES['form_file']['type'];

$start_error = "\n<b>Error:</b>\n<ul>";


        if (!in_array($the_file_type,$allowed_types))
                {
            $error .= "\n<li>The file that you uploaded was of a ".
                "type that is not allowed, you are only
                allowed to upload files of the type:\n<ul>";
            while ($type = current($allowed_types)) {
                $error .= "\n<li>" . $registered_types[$type] . " (" . $type . ")</li>";
                next($allowed_types);
            }

        }


        if ($error) {
            $error = $start_error . $error . "\n</ul>";
            return $error;
        } else {
            return false;
        }


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
$image_dir_file_location=$source_path.$userimagename;        // image location and file name
$image_dir_file_save=$destination_path.$userimagename;                // image save location and file name

$image_info=resize_img($image_dir_file_location,$new_size,$ver);
imagejpeg($image_info,$image_dir_file_save);
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
     $image_info = ImageCreate($width,$height);
         if($gdversion)
    imagecopyresized($image_info, $image_source, 0, 0, 0, 0,
        $width, $height, $actual_width, $actual_height);
                else
                imagecopyresampled($image_info, $image_source, 0, 0, 0, 0,
        $width, $height, $actual_width, $actual_height);

    return $image_info;
}

function form($error=false) {
?>
<table width="100%" cellpadding="5"><tr>
    <td bgcolor="#CCCCCC" align="center" class="sidebox"><B><font color="#FFFFFF">File Uplaods</font></b></td>
  </tr></table>
<?php
//global $lastpage, $squitouser, $squitoemail;

    if ($error) print $error . "<br><br>";

    print "\n<form ENCTYPE=\"multipart/form-data\"  action=\"userupload_file.php\" method=\"post\">";
   print "\n<INPUT TYPE=\"hidden\" name=\"form_userupload\" value=\"1\">";
   echo '<input type="hidden" name="form_imagedir" value="profiles">'."\n";
    print "\n<P>Upload a file";
    print "\n<br>Your Name: <INPUT NAME=\"form_name\" TYPE=\"text\" SIZE=\"35\">";
    print "\n<br>Email Address: <INPUT NAME=\"form_email\" TYPE=\"text\" SIZE=\"35\"><br>";
    echo '<input type="hidden" name="form_upload" value="1">';
        print "\n<br>Image Description:";
    print "\n<br><textarea NAME=\"form_description\" cols=\"50\"></TEXTAREA><br>";
    print "\n<BR>NOTE: Max file size is 2MB";

     print "\n<br><INPUT NAME=\"form_file\" TYPE=\"file\" SIZE=\"35\"><br>";
    print "\n<input type=\"submit\" name=\"userFileUpload\" Value=\"Upload\">";
    print "\n</form>";

}
?>