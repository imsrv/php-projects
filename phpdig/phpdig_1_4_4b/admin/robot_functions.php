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

//=================================================
//converts an iso date to an mysql date
function http_to_sqldate($date)
{
global $month_names;
if (eregi('(([a-z]{3})\, ([0-9]{1,2}) ([a-z]+) ([0-9]{4}) ([0-9:]{8}) ([a-z]+))',$date,$regs))
    {
    $month = sprintf('%02d',$month_names[strtolower($regs[4])]);
    $year = sprintf('%04d',$regs[5]);
    $day = sprintf('%02d',$regs[3]);
    $hour = sprintf('%06d',str_replace(':','',$regs[6]));
    return "$year$month$day$hour";
    }
}

//=================================================
//advanced striptags function.
//returns text and title
function html_to_plain_text($text)
{
//htmlentities
global $spec;

//replace blank characters by spaces
$text = ereg_replace("[\r\n\t]+"," ",$text);
//extracts title
if ( eregi("<title *>([^<>]*)</title *>",$text,$regs) )
    $title = $regs[1];
else
    $title = "";
//delete content of head, script, and style tags
$text = eregi_replace("<head[^<>]*>.*</head>"," ",$text);
$text = eregi_replace("<script[^>]*>.*</script>"," ",$text);
$text = eregi_replace("<style[^>]*>.*</style>"," ",$text);
$text = eregi_replace("(<[a-z0-9 ]+>)","\\1 ",eregi_replace("(</[a-z0-9 ]+>)","\\1 ",$text));

//tries to replace htmlentities by ascii equivalent
reset ($spec);
while ($char = each($spec))
        {
        $text = eregi_replace ($char[0]."[;]?",$char[1],$text);
        $title = eregi_replace ($char[0]."[;]?",$char[1],$title);
        }
$text = ereg_replace('&#([0-9]+);',chr('\1').' ',$text);

//replace blank characters by spaces
$text = ereg_replace("[\r\n\t]+"," ",$text);
$text = eregi_replace("--|[{}();\"]+"," ",eregi_replace("</[a-z0-9]+>"," ",$text));

//replace any group of blank characters by an unique space
$text = ereg_replace("[[:blank:]]+"," ",strip_tags($text));
$retour['content'] = $text;
$retour['title'] = $title;
return $retour;
}

//=================================================
//purify urls from relative components like ./ or ../ and return an array
function url_purify($eval)
{
settype($eval,'string');
//delete special links
if (eregi("[/]?mailto:|[/]?javascript:|[/]?news:",$eval))
         return -1;

$url = @parse_url($eval);
$path = $url['path'];
while(ereg('[^/]*/\.{2}/',$path,$regs))
      {
      $path = ereg_replace('[^/]*/\.{2}/','',$path);
      }

$path = str_replace("./","",ereg_replace("^[.]/","",ereg_replace("^[.]{2}/.*",'NOMATCH',ereg_replace("[^/]*/[.]{2}/","",ereg_replace("^[.]/","",ereg_replace("/+","/",$path))))));

if (eregi('([^/]+)$',$path,$regs))
   {
   $file = $regs[1];
   $path = str_replace($file,"",$path);
   }
else
    {
    $file = '';
    }

$retour['path'] = ereg_replace('(.*[^/])/?$','\\1/',ereg_replace('^/(.*)','\\1',ereg_replace("/+","/",$path)));

if (isset($url['query']))
     {
     $file .= "?".$url['query'];
     $retour['as_query'] = 1;
     }

$retour['file'] = $file;

//path outside site tree
if ($retour['path'] == "NOMATCH" or ereg("^redir[.]php3.*",$file))
     {
     return array('path' => '', 'file' => '');
     }

return $retour;
}

//-------------HTTP FUNCTIONS
//Test presence and type of an url
function test_url($url,$mode='simple')
{
global $phpdig_version;
$components = parse_url($url);
$date = '';
$status = 'NOFILE';
$auth_string = '';

if (isset($components['host']))
    {
    $host = $components["host"];
    if (isset($components['user']) && isset($components['pass']) &&
        $components['user'] && $components['pass'])
        {
        $auth_string = 'Authorization: Basic '.base64_encode($components['user'].':'.$components['pass'])."\n";
        }
    }
else
    {
    $host = '';
    }

if (isset($components['port']))
    {
    $port = (int)$components["port"];
    }
else
    {
    $port = 80;
    }

if (isset($components['path']))
    {
    $path = $components["path"];
    }
else
    {
    $path = '';
    }

if (isset($components['query']))
    {
    $query = $components["query"];
    }
else
    {
    $query = '';
    }

$fp = fsockopen($host,$port);
if ($port)
     $port = ":".$port;
else
    $port = "";

if (!$fp) {
          //host domain not found
          $status = "NOHOST";
          }
else {

    if ($query)
          $path .= "?".$query;

//small get
/*$req =
"GET $path HTTP/1.1
Host: $host$port

";
*/
$req = "
";

//complete get
$request =
"GET $path HTTP/1.1
Host: $host$port
$auth_string
Accept: */*
Accept-Charset: iso-8859-1
Accept-Encoding: identity
User-Agent: PhpDig/$phpdig_version (PHP; MySql)

";
    fputs($fp,$request);
    $answer = fgets($fp,4096);

    //test return code
    while ($answer)
            {
            if (ereg("HTTP/[0-9.]+ (([0-9])[0-9]{2})", $answer,$regs))
                {
                if ($regs[2] == 2 || $regs[2] == 3)
                    $code = $regs[2];
                elseif ($regs[1] >= 401 && $regs[1] <= 403)
                    {
                    $status = "UNAUTH";
                    break;
                    }
                else
                    {
                    $status = "NOFILE";
                    break;
                    }
                }

            if (isset($req1) && $req1)
                {
                $cur_req = $req1;
                unset($req1);
                //close, and open a new conection
                //on the new location
                fclose($fp);
                $fp = fsockopen($host,$cport);
                if (!$fp) {
                           //host domain not found
                           $status = "NOHOST";
                           break;
                           }
                }
            else
                $cur_req = $req;


            fputs($fp,$cur_req);
            $answer = fgets($fp,4096);

            //debug
            //nl2br($cur_req);
            //echo $answer.'<br>';

            //parse header location
            if (ereg("Location: *(.*)",$answer,$regs) && $code == 3)
               {
               $redirs ++;
               if ($redirs > 4)
                    {
                    $answer = "";
                    $status = "LOOP";
                    }
               $newpath = trim($regs[1]);
               $newurl = parse_url($newpath);

               //search if relocation is absolute or relative
               if (!ereg('^/',$newurl["path"]))
                    {
                    $path = dirname($path).'/'.$newurl["path"];
                    }
               else
                   $path = $newurl["path"];

               if (!$newurl['host'] || $host == $newurl['host'])
               $req1 = "GET $path HTTP/1.1
Host: $host$port
Accept: */*
Accept-Charset: iso-8859-1
Accept-Encoding: identity
User-Agent: PhpDig/$phpdig_version (PHP; MySql)

";
               }
            //Parse content-type header
            elseif (eregi("Content-Type: *(text/[a-z]*)",$answer,$regs))
               {
               if ($regs[1] == "text/html")
                   {
                   $status = "HTML";
                   }
               elseif ($regs[1] == "text/")
                    {
                    $boucle = 0;
                    while($boucle < 3)
                           {
                           fputs($fp,$req);
                           $answer = fgets($fp,4096);
                           //test presence of <html> tag at the begining
                           if (eregi("<html",$answer))
                              {
                              $status = "HTML";
                              $boucle = 3;
                              }
                           $boucle++;
                           }
                    }
               elseif ($regs[1] == "text/plain")
                    {
                    eregi('\.([a-z0-9]{1,4})$',$path,$extregs);
                    // extension txt or other ?
                    if (is_array($extregs) && !eregi('txt',$extregs[1]))
                        $status = "TEXT";
                    else
                        $status = "PLAINTEXT";
                    }
               else
                    {
                    $status = "TEXT";
                    }
               }
             elseif (eregi('Last-Modified: *([a-z0-9,: ]+)',$answer,$regs))
                     {
                     //search last-modified header
                     $date = $regs[1];
                     }
      if (!eregi('[a-z0-9]+',$answer))
            $answer = "";
    }

fclose($fp);
}

//returns variable or array
if ($mode == 'date')
     {
     $return['status'] = $status;
     $return['lm_date'] = $date;
     return $return;
     }
else
    return $status;
}

//=================================================
//retrieve links from an url
function explore($tempfile,$url,$path="",$file ="")
{
$index = 0;

if (!is_file($tempfile))
     {
     return -1;
     }
else
    {
    $file_content = file($tempfile);
    }
if (!is_array($file_content))
     {
     return -1;
     }
else
    {
    $links = '';
    while (list($n,$eval) = each($file_content))
        {
         //search hrefs and frames src
         while (eregi("(<frame[^>]*src[[:blank:]]*=|href[[:blank:]]*=|http-equiv=['\"]refresh['\"] *content=['\"][0-9]+;url[[:blank:]]*=|window[.]location[[:blank:]]*=|window[.]open[[:blank:]]*[(])[[:blank:]]*[\'\"]?((([[a-z]{3,5}://)+(([.a-zA-Z0-9-])+(:[0-9]+)*))*([:%/?=&;\\,._a-zA-Z0-9-]*))(#[.a-zA-Z0-9-]*)?[\'\" ]?",$eval,$regs))
            {
             $eval = str_replace($regs[0],"",$eval);

             //test no host or same than site
             if ($regs[5] == "" || $url == 'http://'.$regs[5].'/')
             {
             if (substr($regs[8],0,1) == "/")
                  $links[$index] = url_purify($regs[8]);
             else
                  $links[$index] = url_purify($path.$regs[8]);
             if (is_array($links[$index]))
                $index++;
             else
                unset($links[$index]);
             }
            }
        }
    return $links;
    }
}

//=================================================
//test a link, search if is a file or dir, exclude robots.txt directives
function detect_dir_html($link,$exclude='')
{
$test = test_url($link['url'].$link['path'].$link['file']);

//file
if ($test == 'HTML' or $test == 'PLAINTEXT')
      $link['ok'] = 1;
//dir (avoid extensions)
elseif (!eregi('[.][a-z]{1,4}$',$link['path'].$link['file']) && test_url($link['url'].$link['path'].$link['file'].'/') == "HTML")
      {
      $link['path'] = ereg_replace ('/+$','/',$link['path'].$link['file'].'/');
      $link['file'] = "";
      $link['ok'] = 1;
      }
//none
else
      $link['ok'] = 0;

//test the exclude with robots.txt
if (test_robots($exclude,$link['path'].$link['file']) == 1 or isset($exclude['@ALL@']))
    $link['ok'] = 0;

return $link;
}

//=================================================
//search robots.txt for a site
function test_robots_txt($site)  //don't forget the end backslash
{
if (test_url($site.'robots.txt') == 'PLAINTEXT')
     {
     $robots = file($site.'robots.txt');
     while (list($id,$line) = each($robots))
            {
            if (ereg('^user-agent:[ ]*([a-z0-9*]+)',strtolower($line),$regs))
                $user_agent = $regs[1];
            if (eregi('[[:blank:]]*disallow:[[:blank:]]*(/([a-z0-9_/*+%.-]*))',$line,$regs))
                {
                if ($regs[1] == '/')
                     $exclude[$user_agent]['@ALL@'] = 1;
                else
                     {
                     $exclude[$user_agent][str_replace('*','.*',str_replace('+','\+',str_replace('.','\.',$regs[2])))] = 1;
                     }
                }
            }
     if (isset($exclude['phpdig']) && is_array($exclude['phpdig']))
         return $exclude['phpdig'];
     elseif (isset($exclude['*']) && is_array($exclude['*']))
         return $exclude['*'];
     }
$exclude['@NONE@'] = 1;
return $exclude;
}

//=================================================
function test_robots($exclude,$path)
{
   $result = 0;
   //echo '<b>test '.$path.'</b><br>';
   while (list($path_exclude) = each($exclude))
          {
          //echo $path_exclude.'<br>';
          if (ereg('^'.$path_exclude,$path))
              {
              $result = 1;
              //echo '<font color=red>EXCLUDE !</font><br>';
              }
          }
   return $result;
}

//=================================================
function test_robots_tags($tags)
{
if (is_array($tags))
{
while (list($id,$content) = each($tags))
       {
       if (eregi('robots',$id))
           {
           $directive = 0;

           if (eregi('nofollow',$content))
               $directive += 1;
           if (eregi('noindex',$content))
               $directive += 2;
           if (eregi('none',$content))
               $directive += 4;
           //test the bitwise return > 0 : & 5 nofollow, & 6 noindex.
           return $directive;
           }
       }
}
}

//=================================================

//retrieves an url and returns temp file parameters
function store_temp_html_file($uri,$result_test,$prefix='temp/',$suffix='.html')
{
$temp_filename = md5(time()+getmypid()).$suffix;
if (is_array($result_test) && ($result_test['status'] == 'HTML' || $result_test['status'] == 'PLAINTEXT'))
{
$file_content = file($uri);
$tempfile = $prefix.$temp_filename;
$f_handler = fopen($tempfile,'w');
if (is_array($file_content))
    {
    while (list($n,$line) = each($file_content))
           fputs($f_handler,trim($line)."\n");
    }
fclose($f_handler);
return $tempfile;
}
else
return 0;
}

function modify_spider_reccord($database,$id_connect,$site_id,$path,$file,$first_words,$upddate,$md5,$lastmodified,$num_words)
{
//retrieves the spider_id
$query_select = "SELECT spider_id FROM spider WHERE site_id='$site_id' AND path LIKE '$path' AND file LIKE '$file'";
$result_double = mysql_result_select($database,$id_connect,$query_select);

if (!is_array($result_double))
{
$requete = "INSERT INTO spider SET path='$path',file='$file',first_words='".addslashes($first_words)."',upddate='$upddate',md5='$md5',site_id='$site_id',num_words='$num_words',last_modified='$lastmodified'";
$result_insert = mysql_query($requete,$id_connect);
$spider_id = mysql_insert_id($id_connect);
}
else
{
//update reccord
$spider_id = $result_double[0]['spider_id'];
$query = "UPDATE spider SET first_words='".addslashes($first_words)."',upddate='$upddate',md5='$md5',num_words='$num_words',last_modified='$lastmodified' WHERE spider_id=".$spider_id;
$result_update = mysql_query($query,$id_connect);
}
return $spider_id;
}

//tests if the reccord of spider_id is a double.
function test_double($database,$id_connect,$site_id,$md5,$new_upddate,$last_modified)
{
//tests if there is a double an if yes, update the modifying date
$query_double = "SELECT spider_id FROM spider WHERE site_id='$site_id' AND md5 LIKE '$md5'";
$result_double = mysql_result_select($database,$id_connect,$query_double);
if (is_array($result_double))
     {
     $exists_spider_id = $result_double[0]['spider_id'];
     $query = "UPDATE spider SET upddate=$new_upddate,last_modified='$last_modified' WHERE spider_id=$exists_spider_id";
     $result_update = mysql_query($query,$id_connect);
     return $exists_spider_id;
     }
else
    return 0;
}

//indexe un fichier et renvoie un identifiant fiche
function index_file($database,$id_connect,$tempfile,$site_id,$origine,$localdomain,$path,$file,$content_type,$upddate,$last_modified,$tags,$ftp_id='')
{
//globals
global $limit_days,$small_words_size,$max_words_size,
       $title_weight,$chunk_size,$summary_length,$common_words,$banned,
       $relative_script_path,$s_yes,$s_no,$br,$ftp_id;


//current_date
$date = date("YmdHis",time());
settype($tempfile,'string');

if (!is_file($tempfile))
   return 0;

$page_desc = html_to_plain_text($tags['description']);
$page_keywords = html_to_plain_text($tags['keywords']);

$file_content = file($tempfile);
$textalts = "";

//verify the array $text is empty
$n_chunk = 0;
$n_cline = 0;
$text[0] = '';

while (list($num,$line) = each($file_content))
       {
        if ($line)
        {
        //extract alt attributes of images
        if (eregi("alt=[[:blank:]]*[\'\"][[:blank:]]*([ a-z0-9\xc8-\xcb]+)[[:blank:]]*[\'\"]",$line,$regs));
            $textalts .= $regs[1];
        //extract the domains names not local and not banned to add in keywords
        while (eregi("<a([^>]*href[[:blank:]]*=[[:blank:]]*[\'\"]?(((http://)+(([.a-zA-Z0-9-])+(:[0-9]+)*))*([:%/?=&;\\,._a-zA-Z0-9-]*))[#\'\" ]?)",$line,$regs))
            {
             $line = str_replace($regs[1],"",$line);
             if ($regs[5] && $regs[5] != $localdomain && !eregi($banned,$regs[5]) && ereg('[a-z]+',$regs[5]))
                   {
                   if (!isset($nbre_mots[$regs[5]]))
                       {
                       $nbre_mots[$regs[5]] = 1;
                       }
                   else
                       {
                       $nbre_mots[$regs[5]] ++;
                       }
                   }
            }

        $n_cline ++;
        //cut the text after $n_chunk characters
        if (strlen($text[$n_chunk]) > $chunk_size)
             {
             //cut only before an opening tag
             if ($content_type == 'PLAINTEXT' or eregi("^[[:blank:]]*<[a-z]+[^>]*>",$line))
                  {
                  $n_cline = 0;
                  $n_chunk ++;
                  $text[$n_chunk] = '';
                  }
             }
        $text[$n_chunk] .= trim($line)." ";
        }
       }
//store the number of chunks
$max_chunk = $n_chunk;
//free the array containing file content
unset($file_content);

$doc_title = "";

//purify from html tags and store the title
if (is_array($text) && $content_type != 'PLAINTEXT')
{
reset ($text);
while (list($n_chunk,$chunk) = each($text))
       {
       $chunk = html_to_plain_text($chunk);
       $text[$n_chunk] = $chunk['content'];
       $doc_title .= $chunk['title'];
       }
}

//set the title in order <title>, filename, or unknown
if (isset($doc_title) && $doc_title)
     $titre_resume = $doc_title;
elseif (isset($file) && $file)
    $titre_resume =  $file;
else
    $titre_resume = "Untitled";

//title and small description
$first_words = $titre_resume."\n".substr($page_desc['content'].$text[0],0,$summary_length);

//hashed string to detect doubles
$md5 = md5($titre_resume.$page_desc['content'].$text[$max_chunk]).'_'.filesize($tempfile);

//double test :
$test_double = test_double($database,$id_connect,$site_id,$md5,$upddate,$last_modified);

//if no double detected, continue indexing
if ($test_double == 0)
{
$text_title = "";

//weight of title and description is there
for ($itl = 0;$itl < $title_weight; $itl++)
      {
      $text_title .= $doc_title." ".$page_desc['content']." ";
      }
$text[] = $text_title.$textalts['content']." ".$page_keywords['content'];


//words list and occurence of each of them
reset ($text);
$total = 0;
while (list($n_chunk,$text2) = each($text))
{
$text2 = epure_text($text2,$small_words_size);

$separators = " ";
unset($token);
for ($token = strtok($text2, $separators); $token; $token = strtok($separators))
      {
      if (!isset($nbre_mots[$token]))
          $nbre_mots[$token] = 1;
      else
          $nbre_mots[$token]++;
      $total++;
      }
}


$distinct_words = @count($nbre_mots);

//modify the spider reccord
$spider_id = modify_spider_reccord($database,$id_connect,$site_id,$path,$file,$first_words,$upddate,$md5,$last_modified,$distinct_words);

//here store extract the textual content (return a new ftp_id in case of reconnection)
$ftp_id = store_text_content($relative_script_path,$spider_id,$text,$ftp_id);


//end of textual.

//delete old engine reccord
$query = "DELETE FROM engine WHERE spider_id=$spider_id";
mysql_query($query,$id_connect);

//database insert
$it = 0;
$sqlvalues = "";
while (list($key, $value) = @each($nbre_mots))
       {
        $key = trim($key);
        //no small words nor stop words
        if (strlen($key) > $small_words_size and strlen($key) <= $max_words_size and $common_words[$key] != 1)
        {
        //if keyword exists, retrieve id, else insert it
        $requete = "SELECT key_id FROM keywords WHERE keyword like '".addslashes($key)."'";
        $result_insert = mysql_query($requete,$id_connect);
        $num = mysql_num_rows($result_insert);
        if ($num == 0)
            {
            //inserts new keyword
            $requete = "INSERT INTO keywords (keyword,twoletters) VALUES  ('".addslashes($key)."','".addslashes(substr($key,0,2))."')";
            $result_insert = mysql_query($requete,$id_connect);
            $key_id = mysql_insert_id($id_connect);

            }
        else
            {
            //existing keyword
            $keyid = mysql_fetch_row($result_insert);
            mysql_free_result($result_insert);
            $key_id = $keyid[0];
            }
        //New index record
        if ($it == 0)
             {
             $sqlvalues .= "($spider_id,$key_id,$value)";
             $it = 1;
             }
        else
             $sqlvalues .= ",\n($spider_id,$key_id,$value)";

        }
       }

       unset($nbre_mots);

       //One query for the entire page
       $requete = "INSERT INTO engine (spider_id,key_id, weight) VALUES $sqlvalues\n";
       $result_insert = mysql_query($requete,$id_connect);
print $s_yes;
}
else
    {
    $spider_id = -1;
    print $s_no.msg('double').$br;
    }

return $spider_id;
}

//list a spider reccord
function read_spider_reccord($database,$id_connect,$site_id,$path,$file)
{
$requete = "SELECT spider_id,
                   file,
                   first_words,
                   spider.upddate,
                   md5,
                   sites.site_id,
                   path,
                   num_words,
                   last_modified
             FROM spider LEFT JOIN sites ON spider.site_id = sites.site_id
             WHERE spider.site_id='$site_id' AND spider.path like '$path' AND spider.file like '$file'";
$result = mysql_result_select($database,$id_connect,$requete);
if (is_array($result))
     {
     return $result[0];
     }
}

//metatags in lowercase
function format_meta_tags($file)
{
$tag = get_meta_tags($file);

if (is_array($tag))
    {
    //format type of metatags
    while (list($id,$value) = each($tag))
           $tag[strtolower($id)] = $tag[$id];

    settype($tag['robots'],'string');
    settype($tag['revisit-after'],'string');
    settype($tag['description'],'string');
    settype($tag['keywords'],'string');
    return $tag;
    }
}

//parse the revisit-after tag
function parse_revisit_after($revisit_after,$limit_days=0)
{
$delay = 0;
if (eregi('([0-9]+) *((day).*|(week).*|(month).*|(year).*)',$revisit_after,$regs))
    {
    $delay = 86400*$regs[1];
    if ($regs[4])
         $delay *= 7;
    if ($regs[5])
         $delay *= 30;
    if ($regs[6])
         $delay *= 365;
    }
//set default value
if (!$delay)
      $delay = 86400*$limit_days;

return($delay);
}

//delete a spider reccord and content file
function delete_spider_reccord($database,$id_connect,$spider_id,$ftp_id='')
{
global $relative_script_path,$ftp_id;
$query = "DELETE FROM engine WHERE spider_id=$spider_id";
$result_id = mysql_query($query,$id_connect);
$query = "DELETE FROM spider WHERE spider_id=$spider_id;";
$result_id = mysql_query($query,$id_connect);
delete_text_content($relative_script_path,$spider_id,$ftp_id);
}

//store a content_text from a spider_id
function store_text_content($relative_script_path,$spider_id,$text,$ftp_id='')
{
if (CONTENT_TEXT == 1)
    {

    $file_text_path = $relative_script_path.'/'.TEXT_CONTENT_PATH.$spider_id.'.txt';
    if ($f_handler = @fopen($file_text_path,'a'))
    {
     reset($text);
     while (list($n_chunk,$text_to_store) = each($text))
           fputs($f_handler,wordwrap($text_to_store));
     fclose($f_handler);
    //here the ftp case
    if (FTP_ENABLE)
        {
        $ftp_id = phpdig_ftp_keepalive($ftp_id);
        @ftp_delete($ftp_id,$spider_id.'.txt');
        ftp_put($ftp_id,$spider_id.'.txt',$file_text_path,FTP_ASCII);
        }
    }
    else
        print "Warning : Unable to create the content file $file_text_path ! $br";
    }
return $ftp_id;
}

//delete a content_text from a spider_id
function delete_text_content($relative_script_path,$spider_id,$ftp_id='')
{
if (CONTENT_TEXT == 1)
{
$file_text_path = $relative_script_path.'/'.TEXT_CONTENT_PATH.$spider_id.'.txt';
if (@is_file($file_text_path))
    @unlink($file_text_path);

//there delete the ftp file
if (FTP_ENABLE && $ftp_id)
    @ftp_delete($ftp_id,$spider_id.'.txt');
}
}

//connect to the ftp if the ftp is on and the connection ok.
//the content files are stored locally and could be uploaded
//manually later.
function phpdig_ftp_connect()
{
if (CONTENT_TEXT == 1 && FTP_ENABLE == 1)
    {
    //launch connect procedure
    if ($ftp_id = ftp_connect(FTP_HOST,FTP_PORT))
        {
        //login
        if (ftp_login ($ftp_id, FTP_USER, FTP_PASS))
            {
            ftp_pasv ($ftp_id, FTP_PASV);
            //echo ftp_pwd($ftp_id);
            //change to phpdig directory
            if (ftp_chdir ($ftp_id, FTP_PATH))
                {
                //if content_text doesnt exists, create it
                if (!@ftp_chdir ($ftp_id, FTP_TEXT_PATH))
                     {
                     ftp_mkdir ($ftp_id, FTP_TEXT_PATH);
                     ftp_chdir ($ftp_id, FTP_TEXT_PATH);
                     }
                return $ftp_id;
                }
            }
        }
    }
//else return empty string
}

//close the ftp if exists
function phpdig_ftp_close($ftp_id)
{
if ($ftp_id)
    ftp_quit($ftp_id);
}

//reconnect to ftp if the connexion fails or in case of timout
function phpdig_ftp_keepalive($ftp_id)
{
if (!$ftp_id)
   {
   return phpdig_ftp_connect();
   }
elseif (!@ftp_pwd($ftp_id))
        {
        @ftp_quit($ftp_id);
        return phpdig_ftp_connect();
        }
else
    {
    return $ftp_id;
    }
}
?>