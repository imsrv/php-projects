<? /*
    
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
$db = dbConnect();
$query = 'select default_uploads from prefs where id=1';
$result = mysql_query($query,$db);
$myrow= mysql_fetch_row($result);
$_SESSION['hasmessage']=$obj->check_messages($_SESSION['squitoid']);
//echo $_SESSION['hasmessage'];
//exit;
?>
<table width="535" cellpadding="0" cellspacing="0" align="center"><tr><td><form name="search" method="get" action="index.php"><input type="hidden" name="menu" value="search">Search: <input type="text" name="search" value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>"> <input type="submit" name="subSearch" value="Search"></form><form name="language_form" ACTION="" method="post"><a href="<?php echo $webimageroot;?>">Home</a> <a href="admin.php"><?php echo $lang['Administration Menu']; ?></a> &nbsp;<a href="index.php?menu=userupload&dir_id=<?php echo $myrow[0]; ?>"><?php echo $lang['Upload Image']; ?></a>  <select name="form_language" onChange="language_form.submit();"><option value="english">Choose Language</option><?php  echo "\n";
       $allfiles = read_in_dir($photoroot.'lang/','file');
      foreach($allfiles as $value)
       {
         $value = explode('.',$value);
         echo '<option value="'.$value[0].'">'.$value[0].'</option>'."\n";
       }
       //chdir(dirname($photoroot));
       ?>
       </select></form>
<?php
if(isset($_GET['menu'])) $menu = $_GET['menu'];
else
$menu = '';
switch($menu)
{
case 'userupload':
include($photoroot.'userupload.inc.php');
break;
case 'edit_profile':
include($photoroot.'edit_profile.inc.php');
break;
case 'signup':
include($photoroot.'signup.inc.php');
break;
case 'new_message':
$obj->set_lang($_SESSION['lang']);
if($_SESSION['msgerror']) echo $_SESSION['msgerror'];
$_SESSION['msgerror']='';
$obj->show_message_form();
break;
case 'search':
$obj->set_homeurl($homeURL);
$obj->set_display(0,0,0,0,0,$webimageroot,$images,$thumbnails,$photoroot,$imagemagickpath, $os, $lang, $thumbsize);
if(isset($_GET['search']))
{
if(!$_GET['search'])
{
echo 'You must enter a search string';
}
else
$obj->search($_GET['search']);
}
break;
case 'searchnew':
$obj->set_homeurl($homeURL);
$obj->set_display(0,0,0,0,0,$webimageroot,$images,$thumbnails,$photoroot,$imagemagickpath, $os, $lang, $thumbsize);

if(isset($_GET['file']))
$obj->get_newfiles($_SESSION['last_login']);
break;
default:
include($photoroot.'photolist.inc.php');
}
if(isset($_SESSION['auth']) && isset($_SESSION['squitoid']))
{
$auth = $_SESSION['auth'];
$squitoid = $_SESSION['squitoid'];
}
else 
{
$auth = '';
$squitoid ='';
}
echo '<table width="100%" class="imagebox"><tr><td>';

$sess_obj->get_whos_on();
if($auth && $squitoid)
{
include($photoroot.'usermenu.inc.php');

}
else
{
echo '</td><td align="right">';

echo '<form name="bottom_login" method="post" action="auth/auth.php">';
echo '<input type="hidden" name="form_refer" value="http://'.$homeURL.$_SERVER['REQUEST_URI'].'"><font size="1">';
if(!isset($_SESSION['attempt']))
$_SESSION['attempt']='';

if($_SESSION['attempt'] ==1) echo '<i>Invalid Username or Password</i></font><br>'; else echo '<br>';
$_SESSION['attempt'] ='';
if($_GET['menu']!='signup')
$_SESSION['redirect']= 'http://'.$homeURL.$_SERVER['REQUEST_URI'];
echo '<table><tr><td><font size="1">Username</font></td><td><font size="1">Password</font> </td></tr><tr><td><input type="text" name="user" size="10"></td><td><input type="password" name="pass" size="10"></td></tr></table><br><a href="index.php?menu=signup">'.$obj->lang['Don\'t have an account yet?'].'</a> <input type="submit" name="submit" value="login" ></form>';

}

echo '</td></tr></table>';
?>

<div align="center">
        <p>&copy; 2002 <a href="http://squitosoft.angrymosquito.com">Squitosoft
          </a> All Rights Reserved</p>
      </div>
	  <div id="massageallert" style="position:absolute; width:350; height:200; z-index:1; left: 380; top: 240; background-image: url(graphics/loginbg.jpg); layer-background-image: url(graphics/loginbg.jpg); border: 1px none #000000; overflow: hidden; visibility: <?php if($_SESSION['hasmessage']&& $_SESSION['auth']) {echo 'visible'; } else echo 'hidden';?>">
        <table width="350" border="0" cellspacing="0" cellpadding="3" height="200">
          <tr>
            <td valign="top" height="17">
              <a onClick="MM_showHideLayers('massageallert','','hide')"><img src="graphics/cancel.jpg" width="17" height="17" border="0"></a>
            </td>
          </tr><tr><td height="100%" valign="top"><table cellpadding="20"><tr><td><img src="graphics/spacer.gif" width="20" height="1"><?php $obj->show_message($_SESSION['hasmessage']); ?></td></tr></table>
          </td></tr>
        </table>
      </div>
