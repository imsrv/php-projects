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
$relative_script_path = '.';

//init variables
settype($option,'string');
settype($refine,'integer');
settype($refine_url,'string');
settype($lim_start,'integer');
settype($limite,'integer');
settype($browse,'integer');
settype($maxweight,'integer');
settype($site,'integer');
settype($path,'string');
settype($query_string,'string');

$ignore = '';
$ignore_common = '';
$wheresite = '';
$wherepath = '';
$table_results = '';
$final_result = '';

$mtime = explode(' ',microtime());
$start_time = $mtime[0]+$mtime[1];
include "./includes/config.php";
include "./admin/debug_functions.php";

if (!$option)
     $option = 'start';

if ($query_string)
{
$common_words = common_words("$relative_script_path/includes/common_words.txt");

$like_start = array( "start" => "",
                     "any" => "%",
                     "exact" => ""
                     );
$like_end = array( "start" => "%",
                     "any" => "%",
                     "exact" => ""
                     );
$like_operator = array( "start" => "like",
                     "any" => "like",
                     "exact" => "="
                     );

if ($refine)
     {
     $query_string = urldecode($query_string);
     $wheresite = "AND spider.site_id = $site ";
     if ($path)
          $wherepath = "AND spider.path like '$path' ";
     $refine_url = "&refine=1&site=$site&path=$path";
     }
if ($browse)
     {
     $query_string = urldecode($query_string);
     }

if ($limite)
     settype ($limite,"integer");
else
    $limite = $search_default_limit;

settype ($lim_start,"integer");
if ($lim_start < 0)
     $lim_start = 0;

$n_words = count(explode(" ",$query_string));
$ncrit = 0;
$tin = "0";

$query_to_parse = $query_string;
$query_to_parse = ereg_replace('["%]',"",$query_to_parse);
$query_to_parse = stripaccents(strtolower(ereg_replace("[\"']+"," ",$query_to_parse)));
$query_to_parse = ereg_replace("([^ ])-([^ ])","\\1 \\2",$query_to_parse);
$query_to_parse = str_replace('_','\_',$query_to_parse);
$query_to_parse = trim(ereg_replace(" +"," ",$query_to_parse));

$test_short = $query_to_parse;

while (ereg(' ([^ ]{1,'.$small_words_size.'}) | ([^ ]{1,'.$small_words_size.'})$|^([^ ]{1,'.$small_words_size.'}) ',$test_short,$regs))
    {
     for ($n=1; $n <=3; $n++)
      {
        if ($regs[$n])
        {
        $ignore .= "\"".$regs[$n]."\", ";
        $test_short = trim(str_replace($regs[$n],"",$test_short));
        }
      }
    }
if ($ignore)
    $ignore_message = $ignore.' '.msg('w_short');

while (ereg("(-)?([^ ]{".($small_words_size+1).",}).*",$query_to_parse,$regs))
        {
        $query_to_parse = trim(str_replace($regs[2],"",$query_to_parse));
        if (!isset($common_words[$regs[2]]))
             {
             $spider_in = "";
             if ($regs[1] == '-')
                 $exclude[$ncrit] = 1;
             else
                 $strings[$ncrit] = $regs[2];

             $query = "SELECT key_id FROM keywords WHERE";
             if ($option != 'any')
                 $query .= " twoletters = '".substr(str_replace('\\','',$regs[2]),0,2)."' AND";
             $query .= " keyword ".$like_operator[$option]." '".$like_start[$option].$regs[2].$like_end[$option]."'";

             $tempresult = mysql_query($query,$id_connect);
             if (mysql_num_rows($tempresult) > 0)
                 {
                 $in[$ncrit] = '';
                 while (list($key_id)=mysql_fetch_row($tempresult))
                   {
                   $in[$ncrit] .= "$key_id,";
                   }
                 }
             else
                 $in[$ncrit] = 0;

             $in[$ncrit] = ereg_replace('^,?(.*),$',"\\1",$in[$ncrit]);
             $ncrit++;
             }
        else
            {
            $ignore_common .= "\"".$regs[2]."\", ";
            }
        }

if ($ignore_common)
    $ignore_common_message = $ignore_common.' '.msg('w_common');

$spiders = "";

if ($ncrit && is_array($strings))
{
     $query = "SET OPTION SQL_BIG_SELECTS = 1";
     mysql_query($query,$id_connect);

     for ($n = 0; $n < $ncrit; $n++)
           {
           $query = "SELECT spider.spider_id,sum(weight) as weight, spider.site_id
           FROM engine,spider
           WHERE engine.key_id IN(".$in[$n].")
           AND engine.spider_id = spider.spider_id $wheresite $wherepath
           GROUP BY spider.spider_id";
           $result = mysql_query($query,$id_connect);
           $num_res_temp = mysql_num_rows($result);
           "$num_res_temp<br>";
           if ($num_res_temp > 0)
               {
               if (!isset($exclude[$n]))
               {
               $num_res[$n] = $num_res_temp;
               while (list($spider_id,$weight) = mysql_fetch_array($result))
                       {
                       $s_weight[$n][$spider_id] = $weight;
                       }
               }
               else
               {
               $num_exclude[$n] = $num_res_temp;
               while (list($spider_id,$weight) = mysql_fetch_array($result))
                       {
                       $s_exclude[$n][$spider_id] = 1;
                       }
               mysql_free_result($result);
               }
               }
               elseif (!isset($exclude[$n]))
                   {
                   $num_res[$n] = 0;
                   $s_weight[$n][0] = 0;
                   }
           }

     if (is_array($num_res))
           {
           asort ($num_res);
           list($id_most) = each($num_res);
           reset ($s_weight[$id_most]);
           while (list($spider_id,$weight) = each($s_weight[$id_most]))
                  {
                  $weight_tot = 1;
                  reset ($num_res);
                  while(list($n) = each($num_res))
                        {
                        settype($s_weight[$n][$spider_id],'integer');
                        $weight_tot *= $s_weight[$n][$spider_id];
                        }
                  if ($weight_tot > 0)
                       $final_result[$spider_id]=$weight_tot;
                  }
           }

    if (isset($num_exclude) && is_array($num_exclude))
           {
           while (list($id) = each($num_exclude))
                  {
                  while(list($spider_id) = each($s_exclude[$id]))
                        {
                        unset($final_result[$spider_id]);
                        }
                  }
           }

}

if (is_array($final_result))
    {
    $num_tot = count($final_result);
    arsort($final_result);
    $n_start = $lim_start+1;

    if ($n_start+$limite-1 < $num_tot)
           {
           $n_end = ($lim_start+$limite);
           $more_results = 1;
           }
    else
          {
          $n_end = $num_tot;
          $more_results = 0;
          }

    //fill the results table
    $reg_strings = str_replace('xyzzyx','|',preg_quote(str_replace('\\','',implode('xyzzyx',$strings))));
    $strings = explode('|',$reg_strings);

    reset($final_result);
    for ($n = 1; $n <= $num_tot; $n++)
        {
        list($spider_id,$s_weight) = each($final_result);
        if (!$maxweight)
                   $maxweight = $s_weight;
        if ($n >= $n_start && $n <= $n_end)
             {
             $query = "SELECT sites.site_url, sites.port, spider.path,spider.file,spider.first_words,sites.site_id,spider.spider_id,spider.last_modified,spider.md5 FROM spider,sites WHERE spider.spider_id=$spider_id AND sites.site_id = spider.site_id";
             $result = mysql_query($query,$id_connect);
             $content = mysql_fetch_array($result,MYSQL_ASSOC);
             mysql_free_result($result);
             if ($content['port'])
                 {
                 $content['site_url'] = ereg_replace('/$',':'.$content['port'].'/',$content['site_url']);
                 }
             $weight = sprintf ("%01.2f", (100*$s_weight)/$maxweight);
             $url = eregi_replace("([a-z0-9])[/]+","\\1/",$content['site_url'].$content['path'].$content['file']);
             $l_site = "<a style='font-size:10;' href='".SEARCH_PAGE."?refine=1&query_string=".urlencode($query_string)."&site=".$content['site_id']."&limite=$limite&option=$option'>".$content['site_url']."</A>";
             if ($content['path'])
                  $l_path = ", ".msg('this_path')." : <a style='font-size:10;' href='".SEARCH_PAGE."?refine=1&query_string=".urlencode($query_string)."&site=".$content['site_id']."&path=".$content['path']."&limite=$limite&option=$option' >".$content['path']."</A>";
             else
                  $l_path="";

             $first_words = $content['first_words'];
             $first_words = htmlentities($first_words);

             //Try to retrieve matching lines if the content-text is set to 1
             if (CONTENT_TEXT == 1)
                 {
                 $extract = "";
                 $content_file = $relative_script_path.'/'.TEXT_CONTENT_PATH.$content['spider_id'].'.txt';
                 if (is_file($content_file))
                     {
                     $num_extracts = 0;
                     $f_handler = fopen($content_file,'r');
                     while($num_extracts < 5 && $extract_content = fgets($f_handler,1024))
                           {
                           if(eregi($reg_strings,$extract_content))
                              {
                              $extract .= ' ...'.trim($extract_content).'... ';
                              $num_extracts++;
                              }
                           }
                     fclose($f_handler);
                     }
                 }

             reset ($strings);
             while (list($key, $value) = each($strings))
                   {
                   $first_words = highlight($value,$first_words);
                   if ($extract)
                       $extract = highlight($value,$extract);
                   }


             list($title,$text) = explode("\n",$first_words);
             $table_results[$n]['weight'] = $weight;
             $img_width = ceil(WEIGHT_WIDTH*$weight/100);
             $table_results[$n]['img_tag'] = '<IMG BORDER="0" SRC="'.WEIGHT_IMGSRC.'" WIDTH="'.$img_width.'" HEIGHT="'.WEIGHT_HEIGHT.'">';
             $table_results[$n]['page_link'] = "<A HREF='$url' target='_blank' >$title</A>";
             $table_results[$n]['limit_links'] = msg('limit_to')." ".$l_site.$l_path;
             $table_results[$n]['filesize'] = sprintf('%.1f',(ereg_replace('.*_([0-9]+)$','\1',$content['md5']))/1024);
             $table_results[$n]['update_date'] = ereg_replace('^([0-9]{4})([0-9]{2})([0-9]{2}).*','\1-\2-\3',$content['last_modified']);
             $table_results[$n]['complete_path'] = $url;
             if ($extract)
                 $table_results[$n]['text'] = $extract;
             else
                 $table_results[$n]['text'] = $text;
             }
        }

    $nav_bar = '';
    $pages_bar = '';
    if ($lim_start > 0)
        {
        $previous_link = SEARCH_PAGE."?browse=1&query_string=".urlencode($query_string)."$refine_url&lim_start=".($lim_start-$limite)."&limite=$limite&option=$option";
        $nav_bar .= "<a href='$previous_link' >&lt;&lt;".msg('previous')."</a>&nbsp;&nbsp;&nbsp; \n";
        }
    $tot_pages = ceil($num_tot/$limite);
    $actual_page = $lim_start/$limite + 1;
    $page_inf = max(1,$actual_page - 4);
    $page_sup = min($tot_pages,max($actual_page+5,10));
    for ($page = $page_inf; $page <= $page_sup; $page++)
      {
      if ($page == $actual_page)
           {
           $nav_bar .= " <b style='background-color:#000066;color:white'>$page</b> \n";
           $pages_bar .= " <b style='background-color:#000066;color:white'>$page</b> \n";
           $link_actual =  SEARCH_PAGE."?browse=1&query_string=".urlencode($query_string)."$refine_url&lim_start=".(($page-1)*$limite)."&limite=$limite&option=$option";
           }
      else
          {
          $nav_bar .= " <a href='".SEARCH_PAGE."?browse=1&query_string=".urlencode($query_string)."$refine_url&lim_start=".(($page-1)*$limite)."&limite=$limite&option=$option' >$page</a> \n";
          $pages_bar .= " <a href='".SEARCH_PAGE."?browse=1&query_string=".urlencode($query_string)."$refine_url&lim_start=".(($page-1)*$limite)."&limite=$limite&option=$option' >$page</a> \n";
          }
      }

    if ($more_results == 1)
        {
        $next_link = SEARCH_PAGE."?browse=1&query_string=".urlencode($query_string)."$refine_url&lim_start=".($lim_start+$limite)."&limite=$limite&option=$option";
        $nav_bar .= " &nbsp;&nbsp;&nbsp;<a href='$next_link' >".msg('next')."&gt;&gt;</a>\n";
        }

    $mtime = explode(' ',microtime());
    $search_time = sprintf('%01.2f',$mtime[0]+$mtime[1]-$start_time);
    $result_message = stripslashes(ucfirst(msg('results'))." $n_start-$n_end, $num_tot ".msg('total').", ".msg('on')." \"$query_string\" ($search_time ".msg('seconds').")");
    }
else
    {
    $num_tot = 0;
    $result_message = 'No results';
    }

if ($tempresult)
   mysql_free_result($tempresult);

$title_message = msg('s_results');
}
else
{
$title_message = 'PhpDig '.$phpdig_version;
$result_message = msg('no_query').'.';
}

if (is_file($template))
    {
    $t_mstrings = compact('title_message','phpdig_version','result_message','nav_bar','ignore_message','ignore_common_message','pages_bar','previous_link','next_link');
    $t_fstrings = phpdig_form($query_string,$option,$limite,SEARCH_PAGE,$site,$path,'template');
    $t_strings = array_merge($t_mstrings,$t_fstrings);
    parse_phpdig_template($template,$t_strings,$table_results);
    }
else
    {
?>
<html>
</head>
<title><? print $title_message ?></title>
<?
include "$relative_script_path/includes/style.php";
?>
</head>
<body bgcolor="white">
<div align="center">
<img src="phpdiglogo.gif" width="246" height="77" alt="phpdig <? print $phpdig_version ?>" border="0">
<BR>
<?
phpdig_form($query_string,$option,$limite,"index.php",$site,$path);
?>
<h3><b style='background-color:#000066;color:white'><? print $result_message ?></b>
<br><? print $ignore_message ?>
<br><? print $ignore_common_message ?>
</h3>
</div>
<?
if (is_array($table_results))
       {
       while (list($n,$t_result) = each($table_results))
             {
             print "<P style='background-color:#CCDDFF;'>\n";
             print "<B>$n. <FONT style='font-size:10;'>[".$t_result['weight']." %]</font>&nbsp;&nbsp;".$t_result['page_link']."</B>\n<br>\n";
             print "<FONT style='font-size:10;background-color:#BBCCEE;'>".$t_result['limit_links']."</font>\n<br>\n";
             print "</P>\n";
             print "<BLOCKQUOTE style='background-color:#EEEEEE;font-size:10;'>\n";
             print $t_result['text'];
             print "</BLOCKQUOTE>\n";
             }
        }
print "<P style='text-align:center;background-color:#CCDDFF;font-weight:bold'>\n";
print $nav_bar;
print "</P>\n";
?>
<hr>
<div align="center">
<?
if ($query_string)
    phpdig_form($query_string,$option,$limite,"index.php",$site,$path);
?>
</div>
<div align='center'>
<A href='http://phpdig.toiletoine.net/' target='_blank'>
<img src='phpdigpowered.gif' width='88' height='28' border='0' alt='PhpDig powered'>
</a>
</div>
</body>
</html>
<?
}
?>