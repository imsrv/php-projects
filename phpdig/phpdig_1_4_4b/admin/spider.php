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

//---------------spider script.
//---------------operates both indexing and spidering
$debut = time();
$relative_script_path = '..';

include "$relative_script_path/includes/config.php";
include "$relative_script_path/admin/robot_functions.php";
include "$relative_script_path/admin/debug_functions.php";

$common_words = common_words("$relative_script_path/includes/common_words.txt");

set_time_limit(86400); // 1 full day
$date = date("YmdHis",time());
$progress = 1;
settype($respider_mode,'string');
settype($mode,'string');
settype($origine,'string');
settype($localdomain,'string');
settype($force_first_reindex,'integer');

//test on cgi or http
//set string messages (shell or browser)
if (!$REMOTE_ADDR)
    {
    //low priority if allowed
    print @exec('renice 18 '.getmypid()).$br;
    $run_mode = 'cgi';
    $br = "\n";
    $s_yes = "+";
    $s_no  = "X";
    $s_link = "@url";
    //here parse the parameters for the the reindexing...
    if ($argc > 1)
        {
        if ($argv[1] == 'all')
            {
            $respider_mode = 'all';
            }
        elseif ($argv[1] == 'forceall')
            {
            $respider_mode = 'reindex_all';
            }
        else
            {
            $url = $argv[1];
            $respider_mode = 'site';
            }
        }
    else
        {
        print "Usage = php -f spider.php all|forceall|[an url as http://something]".$br;
        die;
        }
    }
else
    {
    //include "$relative_script_path/libs/auth.php";
    $run_mode = 'http';
    $br = "<BR>\n";
    $s_yes = "<img src='yes.gif' width='10' height='10' border='0' align='middle'>";
    $s_no  = "<img src='no.gif' width='10' height='10' border='0' align='middle'>";
    $s_link = " <A HREF='@url' Target='_blank'>@url</A> ";
    }

//connect to distant ftp for text content (if constants are defined)
$ftp_id = phpdig_ftp_connect();

//mode url : test new or existing site
if (isset($url) && $url != 'http://' && (!$respider_mode || $respider_mode == 'site'))
{
    //format url
    $pu = parse_url($url);
    if (!isset($pu['scheme']))
      {
      $pu['scheme'] = "http";
      }
    if (!isset($pu['host']))
      {
      echo 'Specify a valid host ! ';
      die;
      }

    settype($pu['path'],'string');
    settype($pu['file'],'string');
    settype($pu['user'],'string');
    settype($pu['pass'],'string');
    settype($pu['port'],'integer');
    if ($pu['port'] == 0 || $pu['port'] == 80)
         {
         $pu['port'] = '';
         }
    else
         {
         settype($pu['port'],'integer');
         }

    $url = $pu['scheme']."://".$pu['host']."/";

    //build a complet url with user/pass and port
    $full_url = $pu['scheme']."://";
    if ($pu['user'] && $pu['pass'])
        {
        $full_url .= $pu['user'].':'.$pu['pass'].'@';
        }
    $full_url .= $pu['host'];
    if ($pu['port'])
        {
        $full_url .= ':'.$pu['port'];
        }
    $full_url .= '/';

    $subpu = url_purify($pu['path'].$pu['file']);

if (!$pu['port'])
     {
     $where_port = "and port IS NULL";
     }
else
    {
    $where_port = "and port='".$pu['port']."'";
    }
$query = "SELECT site_id FROM sites WHERE site_url = '$url' $where_port";
$result = mysql_query($query,$id_connect);
if (mysql_num_rows($result) > 0)
    {
    //existing site
    list($site_id) = mysql_fetch_row($result);
    mysql_free_result($result);

    $query_tempspider = "INSERT INTO tempspider (site_id,file,path) VALUES ('$site_id','".$subpu['file']."','".$subpu['path']."')";
    mysql_query($query_tempspider,$id_connect);
    }
else
    {
    //new site
    $query = "INSERT INTO sites SET site_url='$url',upddate=NOW(),username='".$pu['user']."',password='".$pu['pass']."',port='".$pu['port']."'";
    mysql_query($query,$id_connect);
    $site_id = mysql_insert_id($id_connect);
    $new_site = 1;

     //new spidering = insert first row in tempspider
     $subpu['url'] = $url;

     $exclude = test_robots_txt($url);

     $subpu = detect_dir_html($subpu,$exclude);
     if ($subpu['ok'] == 1)
         {
         set_time_limit(0);
         $query = "INSERT INTO tempspider SET file='".$subpu['file']."',path='".$subpu['path']."',level=0,site_id='$site_id'";
         mysql_query($query,$id_connect);
         }
    }
}

//retrieve list of urls
if ($site_id)
    $where_site =  "WHERE site_id=$site_id";

$query= "SELECT site_id,site_url,username as user,password as pass,port FROM sites $where_site";
$list_sites = mysql_result_select($database,$id_connect,$query);

if ($run_mode == 'http')
{
?>
<html>
<head>
<?
include "$relative_script_path/includes/style.php";
?>
</head>
<body bgcolor="white">
<img src="../phpdiglogo.gif" width="246" height="77" alt="phpdig <? print $phpdig_version ?>"><br>
<h3><? pmsg('spidering'); ?></h3>
<?
}
else
{
pmsg('spidering');
}

if (!isset($limit) or (int)$limit > $spider_max_limit)
      $limit = $respider_limit;

//retrives sites
if (is_array($list_sites))
{
while(list($useless,$site_datas) = each($list_sites))
{
$site_id = $site_datas['site_id'];
$url = $site_datas['site_url'];

//set a complete url for basic authentification and other ports than 80
$full_url = '';
if ($site_datas['user'] && $site_datas['pass'])
    {
    $full_url = 'http://'.$site_datas['user'].':'.$site_datas['pass'].'@'.ereg_replace('^http://(.*)','\1',$url);
    }
else
    {
    $full_url = $url;
    }
if ($site_datas['port'])
    {
    $full_url = ereg_replace('/$',':'.$site_datas['port'].'/',$full_url);
    }

//just keep the reccords not indexed before
$query = "DELETE FROM tempspider WHERE site_id = '$site_id' and (indexed = 1 or error = 1)";
mysql_query($query,$id_connect);

//refill the tempspider with not expired spiders reccords, eventually refined
switch($respider_mode)
       {
       case "reindex_all":
       $andmore_tempspider = '';
       $force_first_reindex = 1;
       break;

       default:
       $andmore_tempspider = 'AND upddate < now()';
       }

if ($mode != 'small')
{
$query_tempspider = "INSERT INTO tempspider (site_id,file,path) SELECT site_id,file,path FROM spider WHERE site_id=$site_id $andmore_tempspider";
mysql_query($query_tempspider,$id_connect);
}
else
{
$force_first_reindex = 1;
}

//first level
$level = 0;
//store robots.txt datas
$exclude = test_robots_txt($full_url);

print "SITE : $url$br";
$n_links = 0;
while($level <= $limit)
      {
      //retrieve list of links from this level
      $query = "SELECT id,path,file,indexed FROM tempspider WHERE level = $level AND indexed = 0 AND site_id=$site_id AND error = 0 limit 1";
      $result_id = mysql_query($query,$id_connect);
      $n_links = mysql_num_rows($result_id);
      if ($n_links > 0)
           {
           while ($new_links = mysql_fetch_array($result_id))
                   {
                   //keep alive the ftp connection (if exists)
                   if (FTP_ENABLE)
                       $ftp_id = phpdig_ftp_keepalive($ftp_id);

                   //indexing this page
                   $temp_path = $new_links['path'];
                   $temp_file = $new_links['file'];
                   $already_indexed = $new_links['indexed'];
                   $tempspider_id = $new_links['id'];

                   //reset variables
                   $spider_id = 0;
                   $nomodif = 0;
                   $ok_for_spider = 0;
                   $ok_for_index = 0;
                   $tag = '';

                   //Retrieve dates if page is already in database
                   $test_exists = read_spider_reccord($database,$id_connect,$site_id,$temp_path,$temp_file);
                   if (is_array($test_exists))
                       {
                       settype($test_exists['spider_id'],'integer');
                       settype($test_exists['upddate'],'string');
                       settype($test_exists['last_modified'],'string');

                       $exists_spider_id = $test_exists['spider_id'];
                       $upddate = $test_exists['upddate'];
                       $last_modif_old = $test_exists['last_modified'];
                       }
                   else
                       {
                        $exists_spider_id = 0;
                        }

                   $url_indexing = $full_url.$temp_path.$temp_file;
                   $url_print = $url.$temp_path.$temp_file;

                   //verify if 'revisit-after' date is expired or if page doesn't exists, or force is on.
                   if ($exists_spider_id == 0 || $upddate < $date || ($force_first_reindex == 1 && ($level==0 || $already_indexed==0)))
                   {
                   //test content-type of this page if not excluded
                   if (!test_robots($exclude,$temp_path) && !eregi('\.tar\.gz$|\.tar\.z$|\.tar$|\.zip$',$temp_file))
                        {
                        $result_test_http = test_url($url_indexing,'date');
                        }

                   if (is_array($result_test_http) && ereg('HTML|TEXT|PLAINTEXT',$result_test_http['status']))
                   {
                   $last_modified = $result_test_http['lm_date']; //last_modified, content_type
                   $content_type =  $result_test_http['status'];
                   if ($last_modified)
                           $last_modified = http_to_sqldate($last_modified);
                   else
                           $last_modified = date("YmdHis",time());

                   //if the saved last-modified date is sup or equal than the corresponding
                   //header, set $nomodif to 1
                   if ($exists_spider_id > 0 && $last_modif_old >= $last_modified)
                       {
                        $nomodif = 1;
                        }
                   else
                       {
                       //continue...
                       $nomodif = 0;
                       $tempfile = store_temp_html_file($url_indexing,$result_test_http,'temp/');

                       //Retrieve meta-tags for this page
                       if ($content_type == 'HTML')
                           {
                           if (is_file($tempfile))
                               $tag = format_meta_tags($tempfile);
                           }

                       if (is_array($tag))
                           {
                           //biwise operation on robots tags for noindex
                           $noindex = 6 & test_robots_tags($tag);
                           $nofollow = 5 & test_robots_tags($tag);
                           $revisit_after = $tag['revisit-after'];
                           }

                       //parse next update date with "revist-after" content
                       $new_upddate = date("YmdHis",time()+parse_revisit_after($revisit_after,$limit_days));

                       //load the file in an Array if all is ok
                       if ($nomodif == 1)
                       {
                       $ok_for_spider = $force_first_reindex; //spider if force_first_reindex on
                       $ok_for_index = 0;
                       print "No modified : ";
                       //set the next revisit date
                       $query = "UPDATE spider SET upddate='$new_upddate' WHERE spider_id = '$exists_spider_id'";
                       mysql_query($query,$id_connect);
                       }

                       elseif ($noindex > 0 || $already_indexed == 1)
                       {
                       print "Meta Robots = NoIndex, or already indexed : ";
                       $ok_for_spider = 1;
                       $ok_for_index = 0;
                       }
                       else
                       {
                       $ok_for_index = 1;
                       $ok_for_spider = 1;
                       }
                   }

                   //let's go for indexing the content
                   if ($ok_for_index == 1)
                   {
                   $spider_id = index_file($database,$id_connect,$tempfile,$site_id,$origine,$localdomain,$temp_path,$temp_file,$content_type,$new_upddate,$last_modified,$tag,$ftp_id);
                   }
                   else if ($nomodif == 1)
                   {
                   print 'File date unchanged'.$br;
                   }
                   else
                   {
                   print msg('no_toindex').$br;
                   }
                   print ($progress++).':'.$url_print.$br;
                   }
                   else
                       {
                       //none stored
                       if ($exists_spider_id)
                           {
                           //delete the existing spider_id
                           print $s_no.msg('error').' 404'.$br;
                           delete_spider_reccord($database,$id_connect,$exists_spider_id);
                           }
                       //mark the tempspider reccord as error
                       $query = "UPDATE tempspider SET error = 1 WHERE id = $tempspider_id";
                       mysql_query($query,$id_connect);
                       }
                   }
                   else
                   {
                   print $s_no.($progress++).":".str_replace('@url',$url_indexing,$s_link).msg('id_recent').$br;
                   }
                   //display progress indicator
                   print "(".msg('time')." : ".gmdate("H:i:s",time()-$debut).")".$br;

                   //update temp table with 'indexed' flag
                   $requete = "UPDATE tempspider SET indexed=1 WHERE site_id=$site_id and path = '$temp_path' and file = '$temp_file'";
                   $result_update = mysql_query($requete,$id_connect);


                   //explore each page to find new links
                   if ((($spider_id > 0 || $ok_for_spider) || $force_first_reindex == 1) && $nofollow == 0 && $level < $limit)
                       $urls = explore ($tempfile,$url,$new_links['path'],$new_links['file']);

                   //DELETE TEMPFILE
                   if (isset($tempfile) && is_file($tempfile))
                   {
                   unlink($tempfile);
                   unset($tempfile);
                   }

                   //DEBUG
                   /*
                   print "<hr>";
                   echo "<b>$url".$new_links['path'].$new_links['file']." : </b><br>";
                   dsp_table_datas($urls);
                   print "<hr>";
                   */
                   //GUBED

                   if (isset($urls) && is_array($urls))
                       {
                       while ($liens = each($urls))
                               {
                               //not an apache fancy index (with sorts by columns)
                               if (!isset($apache_indexes[$liens[1]['file']]))
                               {
                               $exists = 0;
                               $exists_temp_spider = 0;
                               //is this link already in temp table ?
                               $query = "SELECT count(*) as num FROM tempspider WHERE path like '".str_replace("'",'',$liens[1]['path'])."' AND file like '".str_replace("'",'',$liens[1]['file'])."' AND site_id='$site_id'";
                               $test_id = mysql_query($query,$id_connect);
                               if (mysql_num_rows($test_id) > 0)
                                   {
                                   $exist_results = mysql_fetch_array($test_id);
                                   $exists += $exist_results['num'];
                                   $exists_temp_spider = $exists;
                                   mysql_free_result($test_id);
                                   }

                               if (isset($spider_root_id) && $spider_root_id)
                                    $andmore = " AND spider_id <> '$spider_root_id' ";
                               else
                                   $andmore = '';
                               //is this link already in spider ?
                               $query = "SELECT count(*) as num FROM spider WHERE path like '".str_replace("'",'',$liens[1]['path'])."' AND file like '".str_replace("'",'',$liens[1]['file'])."' AND site_id='$site_id' $andmore";
                               $test_id = mysql_query($query,$id_connect);
                               if (mysql_num_rows($test_id) > 0)
                                   {
                                   $exist_results = mysql_fetch_array($test_id);
                                   $exists += $exist_results['num'];
                                   mysql_free_result($test_id);
                                   }
                               $liens[1]['url'] = $full_url;

                               //test validity of the new link
                               if ($exists < 1)
                                   {
                                   $cur_link = detect_dir_html($liens[1],$exclude);
                                   }
                               else
                                   $cur_link['ok'] = 0;

                               if ($cur_link['ok'] == 1)
                                    {
                                    $s_error = 0;
                                    print '+ ';
                                    }
                               else
                                   $s_error = 1;

                               //insert in temp table for next level
                               if ($exists_temp_spider < 1)
                               {
                               settype($cur_link['path'],'string');
                               settype($cur_link['file'],'string');
                               $values =  "('".$cur_link['path']."', '".$cur_link['file']."',".($level+1).",$site_id,$s_error)";
                               $query = "INSERT INTO tempspider (path, file, level, site_id, error) VALUES $values";
                               mysql_query($query,$id_connect);
                               }

                               //display something to avoid browser-side timeout
                               flush();
                               }
                               }
                        echo $br;
                        }
                   }
            $force_first_reindex = 0;
            print $br."temps : ".gmdate("H:i:s",time()-$debut).$br;
           }
      else
          {
          print pmsg('no_temp').$br;
          break;
          }
      mysql_free_result($result_id);
      $query = "SELECT id FROM tempspider WHERE level = $level AND indexed = 0 AND site_id=$site_id AND error = 0 limit 1";
      $result_id = mysql_query($query,$id_connect);
      $n_links = mysql_num_rows($result_id);
      mysql_free_result($result_id);
      if ($n_links == 0)
          {
          $level++;
          print msg('level')." $level...".$br;
          }
      }
if ($run_mode == 'http')
{
//results-in-http-mode-----------------
$query = "SELECT DISTINCT path,file FROM tempspider WHERE site_id=$site_id AND error = 0 AND indexed = 1 ORDER by path,file";
$result_id = mysql_query($query,$id_connect);
$n_links = mysql_num_rows($result_id);

print "<hr><h3>".msg('links_found')." : $n_links</h3>";

while ($liens = mysql_fetch_row($result_id))
        {
        print "<a href=\"$url".$liens[0].$liens[1]."\" target=\"_blank\" >".urldecode($liens[0].$liens[1])."</a><br>\n";
        }
}
else
    {
    print msg('links_found')." : ".$n_links.$br;
    }

}
}
//display end of indexing
pmsg('id_end');
phpdig_ftp_close($ftp_id);

//clean the tempspider table
$query = "DELETE FROM tempspider WHERE site_id=$site_id AND (error = 1 OR indexed = 1)";
mysql_query($query,$id_connect);

if ($run_mode == 'http')
{ ?>
<hr>
<A href="index.php" >[<? pmsg('back') ?>]</A> <? pmsg('to_admin') ?>.
</body>
</html>
<? } ?>