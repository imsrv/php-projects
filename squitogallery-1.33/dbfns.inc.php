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
$version = "v1.33";
function dbConnect()

{

  global $db_host, $db_user, $db_pass, $database;

  $db = MYSQL_CONNECT($db_host,$db_user,$db_pass);

  mysql_select_db($database, $db);

  return $db;

}

function dateTime()

{

   return date("F j, Y, g:i a");

}

function get_imagename($id)
{
$db=dbConnect();
$query = 'select filename from photofile where id = "'.$id.'"';
$result = mysql_query($query,$db);
$myrow = mysql_fetch_row($result);
return $myrow[0];
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
function login_form($redirect)
{
global $webimageroot, $lang;
?>
  <form name="login_form" method="post" action="<?php echo $webimageroot;?>/auth/auth.php">
<?php 
if(!isset($_SESSION['attempt'])) $_SESSION['attempt']='';
if($_SESSION['attempt']==1)
{
echo "invalid username or password please try again!";
$_SESSION['attempt'] =0;
}
if(!isset($_SESSION['usercreated'])) $_SESSION['usercreated']='';
if($_SESSION['usercreated']==1)
{
echo "<b>".$lang['User created. Please login to your new account.']."</b>";
$_SESSION['usercreated'] =0;
}
?>
        <p>
          <?php echo $lang['Username'];?>:
          <input type="text" name="user">
          <br>
          <?php echo $lang['Password'];?>:
          <input type="password" name="pass">
          <br>
          <br>
                 <input type="hidden" name="form_refer" value="<?php echo $redirect;?>">
          <input type="submit" name="Login" value="Login">

        </p>
        </form>

<?php
}
function change_dir_read($thedir)
{
global $countphotos;
$filearray = read_in_dir($thedir, 'file' );
if(is_array($filearray))
foreach($filearray as $value)
{
$countphotos++;
//echo $countphotos.': '.$value,'<br>';

}
$dirarray[$i] = read_in_dir($thedir, 'dir');
if(is_array($dirarray[$i]))
{
foreach($dirarray[$i] as $value)
{
//echo '<b>'.$value.'</b><br>';
change_dir_read($thedir.$value);
$i++;
}
}
return $countphotos;
}
function check_permissions()
{
     global $images, $lang;
     $db = dbConnect();
     $len = strlen($images);
     $query = 'select * from photodir where name = "'.basename($_GET['imagedir']).'"';
     //echo $query.'<br>';
     $result = mysql_query($query, $db);
     $myrow = mysql_fetch_array($result);
     //echo $_SESSION['squitoid'];
     //echo $myrow['private'];
     if(!$_SESSION['squitoid'] && $myrow['private']==1)
     {
     echo '<table width="500"><tr><td>';
         if($lang['Private Album'])
         {
           echo $lang['Private Album'];
         }
         else
         {
           echo 'This is a private album that you do not have access to.';
          }
     echo '</td></tr></table>';
     return 0;
     }
     else
     {
     return 1;
     }
}
function update_profile()

{


if($_POST['form_password'] && $_POST['form_password'] == $_POST['form_password_verify'])
{
$password = ', password=password("'.$_POST['form_password'].'")';
}
else $password ='';


$db = dbConnect();

$q = $_POST['form_q'];

$query = 'select * from profile_q order by id asc';
$result = mysql_query($query, $db);
while($myrow= mysql_fetch_array($result))
{
$query = 'select q_id from profile_a where q_id = '.$myrow['id']. ' and u_id = '.$_SESSION['squitoid'];
//echo $query.'<br>';
$qres= mysql_query($query,$db);
//echo $q[$myrow['id']][0].'<br>';
if(!mysql_num_rows($qres))
{
    $query = 'insert into profile_a (u_id,q_id,answer) values ("'.$_SESSION['squitoid'].'","'.$myrow['id'].'","'.$q[$myrow['id']][0].'")';
    //echo $query.'<br>';
    MYSQL_QUERY($query,$db);
}
else
{
$query = 'update profile_a set answer = "'.$q[$myrow['id']][0].'" where u_id = '.$_SESSION['squitoid'].' and q_id = '.$myrow['id'];
//echo $query.'<br>';
MYSQL_QUERY($query,$db);
}
}

 $query = 'UPDATE authorization SET email = "'.$_POST['email'].'"'.$password.' WHERE id=' . $_SESSION['squitoid'];
 MYSQL_QUERY($query,$db);

 MYSQL_CLOSE();
$_SESSION['squitoemail'] = $_POST['email'];
}

?>