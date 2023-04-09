<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/
$relative_script_path = '..';
include "$relative_script_path/includes/config.php";
include "$relative_script_path/libs/auth.php";
include "$relative_script_path/admin/robot_functions.php";

settype($path,'string');
settype($sup,'integer');
settype($exp,'integer');
settype($username,'string');
settype($password,'string');

set_time_limit(3600);
srand(time());
if ($path)
     {
     $andpath = "AND path like '".str_replace('%','\%',$path)."%'";
     }
else
    {
    $andpath = '';
    }

settype ($site_id,"integer");
if ($site_id == 0)
    {
    header ("location:index.php");
    }

elseif ($sup)
    {
    $query = "SELECT spider_id FROM spider WHERE site_id=$site_id $andpath";
    $result_id = mysql_query($query,$id_connect);

    if ( mysql_num_rows($result_id) > 0)
        {
        $ftp_id = phpdig_ftp_connect();
        $in = "IN (0";
        while (list($spider_id) = mysql_fetch_row($result_id))
               {
               delete_text_content($relative_script_path,$spider_id,$ftp_id);
               $in .= ",$spider_id";
               }
        $in .= ")";
        phpdig_ftp_close($ftp_id);

        $query = "DELETE FROM engine WHERE spider_id $in";
        $result_id = mysql_query($query,$id_connect);

        $query = "DELETE FROM spider WHERE site_id=$site_id $andpath";
        $result_id = mysql_query($query,$id_connect);
        }
    }

elseif ($exp)
    {
    $query = "DELETE FROM tempspider WHERE site_id=$site_id and indexed = 1";
    mysql_query($query,$id_connect);
    $query = "INSERT INTO tempspider (site_id,file,path) SELECT site_id,file,path FROM spider WHERE site_id=$site_id $andpath";
    mysql_query($query,$id_connect);

    header ("location:spider.php?site_id=$site_id&mode=small");
    }
?>
<html>
</head>
<title>PhpDig : <? pmsg('update') ?> </title>
<?
include "$relative_script_path/includes/style.php";

$query = "SELECT site_id,site_url,username,password,port FROM sites WHERE site_id=$site_id";
$result_id = mysql_query($query,$id_connect);
$num = mysql_num_rows($result_id);
if ($num < 1)
    {
    mysql_free_result($result_id);
    print "INVALID SITE ID";
    }
else
    {
    $a_result = mysql_fetch_array($result_id,MYSQL_ASSOC);
    extract($a_result);
    mysql_free_result($result_id);
    }

$query = "SELECT path,spider_id FROM spider WHERE site_id=$site_id GROUP BY path ORDER by path";
$result_id = mysql_query($query,$id_connect);
$num = mysql_num_rows($result_id);
if ($num < 1)
    mysql_free_result($result_id);
?>
</head>
<body bgcolor="white">
<a name="AAA" >
<img src="../phpdiglogo.gif" width="246" height="77" alt="PhpDig <? print $phpdig_version ?>"><br>
<? pmsg('update_mess') ?>
<hr>
<?
//change the user/pass for an existing site
if ($new_username && $new_password && $site_id)
    {
    $query = "UPDATE sites SET username='$new_username',password='$new_password' WHERE site_id=$site_id";
    mysql_query($query,$id_connect);
    if (mysql_affected_rows($id_connect) > 0)
        print "<font color='red'><b>User/Password changed !</b></font><br>\n";
    }

if ($port)
    {
    $site_url = ereg_replace('/$',":$port/",$site_url);
    }
?>
<form method='post' action='update.php'>
<input type='hidden' name='site_id' value='<? print $site_id ?>'>
<b>URI : <? print $site_url ?></b><br>
<i>User :</i><input type='text' size='12' name='new_username'>
<i>Pass :</i><input type='password' size='12' name='new_password'>
<input type='submit' name='change' value='Change'>
</form>
<h3><? pmsg('tree_found') ?> : </h3>
<P style='background-color:#CCDDFF;'>
<? pmsg('update_help') ?><br>
<B><? pmsg('warning') ?> </B><? pmsg('update_warn') ?>
</P>
<P>
<?
$aname = "AAA";
$previous_dir = explode('/','///////////////');

for ($n = 0; $n<$num; $n++)
    {
    $aname2 = $aname;
    list($path_name,$aname)=mysql_fetch_row($result_id);
    print "<A NAME='$aname'>\n";
    $paths = explode('/',rawurldecode($path_name));

    $num_levels = count($paths);

    $path_name_aff = '';
    while(list($id,$dir) = each($paths))
          {
          if ($dir != $previous_dir[$id])
              {
              $path_name_aff .= substr('/'.$dir,0,20);
              if ($id == 0)
                  {
                  $path_name_aff = '<b>'.$path_name_aff.'</b>';
                  }
              $previous_dir[$id] = $dir;
              }
          else if ($dir)
              {
              if (($id+4) > $num_levels)
                  {
                  $start_char = '+';
                  $space_char = '-';
                  }
              else
                  {
                  $start_char = '§';
                  $space_char = '§';
                  }
              $path_name_aff .= str_replace('§','&nbsp;',substr($start_char.ereg_replace('.{1}',$space_char,$dir),0,20));
              }
          }

    print "<A HREF='update.php?site_id=$site_id&path=".urlencode($path_name)."&sup=1#$aname2'  target='_self'><img src='no.gif' width='10' height='10' border='0' align='middle' alt='".msg('delete')."'></A>&nbsp;\n";
    print "<A HREF='update.php?path=".urlencode($path_name)."&site_id=$site_id&exp=1' target='_top' ><img src='yes.gif' width='10' height='10' border='0' align='middle' alt='".msg('reindex')."'></A>&nbsp;\n";
    if ($path_name == "")
          $path_name_aff = "<I><B style='color:red;'>Racine</B></I>";
    print '<code>'.$path_name_aff."</code>&nbsp;<A HREF='files.php?path=".urlencode($path_name)."&site_id=$site_id' target='files' ><img src='details.gif' width='10' height='10' border='0' align='middle' alt='".msg('files')."'></A><BR>\n";
    }
?>
</P>
<hr>
<A href="index.php" target="_top">[<? pmsg('back') ?>]</A> <? pmsg('to_admin') ?>.
</body>
</html>