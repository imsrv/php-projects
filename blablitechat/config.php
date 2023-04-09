<?php 
error_reporting(1);
if(function_exists('import_request_variables')){import_request_variables("gpc");$REMOTE_ADDR=$HTTP_SERVER_VARS['REMOTE_ADDR'];$PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];}
error_reporting(8);

$version='2.2 [2005-04-08]';             // version number

$time_format='M d, H:i';                 // set time format using proper attributes. details: http://www.php.net/date
$default_zone=0;                         // default timezone, 0=GMT
$refresh_rate='6:12:24:48:60';           // refresh rates (sec, 5 entries)
$default_rate=12;                        // default refresh rate (sec) [an Apache server with default settings closes the socket in 15 sec. With refresh rate 12 sec the socket will be reused.]
$password_field='text';                  // ['text' or 'password'] - 'password' would display ****
$no_cache=0;                             // use random numbers in the address bar to prevent caching (1=yes, 0=no)
$check_space=0;                          // check free disk space before writing to a file (1=yes, 0=no, might cause problems on some servers)
$gzip=1;                                 // use gzip compression (1=yes, 0=no) [try to turn this option on (1). if it works, the size of an ordinary chat page is less than 1kB]
$clear_chat=0;                           // clear each chatroom when the last user leaves (1=yes, 0=no)
$secret_word='blabla';                   // secret word (whatever you wish, but it is ESSENTIAL 'blabla' to be changed!)

include 'incl/lang-en.inc';              // set a language file
$skin_dir='s-blue';                      // skin directory (no trailing slashes)
$data_dir='data';                        // data directory (no trailing slashes)

$bad_words=array('fuck','bitch');        // words which are not acceptable

$users_per_room=10;                      // users per room
$chat_lines=10;                          // lines in chat
$keep_lines=150;                         // history lines
$username_length=10;                     // set greater values (at least current*5) for Chinese, Japanese etc
$words_length=80;                        // -||- -||-
$entry_length=200;                       // -||- -||-
$full_length=600;                        // entry length + additional html tags (smilies etc)

$room_name='BlaB! Lite';             // name of the room


/*---------------------------------------------------------------------------*/

include "$skin_dir/skin.inc";
set_magic_quotes_runtime(0);

$log_file=$data_dir.'/room';
$usr_file=$data_dir.'/user';
$timestamp=time();
$random=mt_rand(1,999999);

function time_to_run(){$time=microtime();$time=explode(" ",$time);return $time[1]+$time[0];}$start_time=time_to_run();
$row_bg='a';function change_row_color(){global $row_bg;if($row_bg=='a'){$row_bg='b';}else{$row_bg='a';}}
function check_space(){$s=true;global $check_space;if(function_exists('disk_free_space')&&$check_space==1){$a=disk_free_space("/");if(is_int($a)&&$a<204800){$s=false;}}return $s;}
function show_pic($q,$a){$q=explode("|",$q);if(isset($q[0])&&isset($q[1])&&isset($q[2])&&isset($q[3])){global $skin_dir;print "<img src=\"$skin_dir/$q[0]\" width=\"$q[1]\" height=\"$q[2]\" border=\"0\" alt=\"$q[3]\" ";if(isset($q[4])&&strlen($q[4])>4){print "onmouseover=\"this.src='$skin_dir/$q[4]'\" onmouseout=\"this.src='$skin_dir/$q[0]'\"";}if(isset($a)&&strlen($a)>3){print " $a";}if(isset($q[5])&&strlen($q[5])>4){print " $q[5]";}print " />";}else{$q=implode(":",$q);print $q;}}if(!is_file('info.php')||filesize('info.php')!=1392){die('?');}
function open_file($q,$a){$fd=fopen($q,"r") or die('..');$fs=fread($fd,filesize($q));fclose($fd);if($a!=0){$fs=explode("\n",$fs);}return $fs;}
function save_file($q,$a,$o){if(check_space()){$a=trim($a);$a=str_replace("\n\n","\n",$a);if($a==''){$a=' ';}$m=0;do{$fd=fopen($q,"w") or die($o);$fout=fwrite($fd,$a);fclose($fd);$m++;}while(filesize($q)<1&&$m<5);}}
function clean_entry($q){$q=trim($q);$q=stripslashes($q);$q=str_replace("<","",$q);$q=str_replace(">","",$q);$q=str_replace("\r\n","",$q);$q=str_replace("\r","",$q);$q=str_replace("\n","",$q);$q=str_replace(":|:","",$q);return $q;}
function check_user(){global $name,$xpas,$secret_word;if(md5($name.$secret_word)!=$xpas){die("</head><body onload=\"parent.location='index.php?name=0'\"></body></html>");}}
function show_time($s){global $time_format,$time_offset;return gmdate($time_format,$s+$time_offset*3600);}
function refresh_online($n,$s){global $data_dir,$timestamp,$refresh_rate,$usr_file;$x=explode(':',$refresh_rate);$y=$x[count($x)-1];$y+=10;$j=0;$online=array();$fs=open_file($usr_file,1);for($i=0;$i<count($fs);$i++){if(isset($fs[$i])&&strlen($fs[$i])>9){$row=explode(":|:",$fs[$i]);settype($row[1],"integer");if(strtolower($n)!=strtolower($row[0])&&($timestamp-$row[1])<$y){$online[$j]=$fs[$i];$j++;}}}if($s!=0){$sf=implode("\n",$online);save_file($usr_file,$sf,0);}return $online;}
function remove_bad_words($w){global $bad_words;for($i=0;$i<count($bad_words);$i++){$w=eregi_replace($bad_words[$i],'***',$w);}return $w;}

if(isset($time_offset)){$time_offset=(int)$time_offset;}elseif(isset($blabtime)){$time_offset=(int)$blabtime;}else{$time_offset=$default_zone;}
$local_time=gmdate('H:i',time()+$time_offset*3600);

if(!is_writeable($log_file)){save_file($log_file,'','CHMOD /data to 777!');}
if(!is_writeable($usr_file)){save_file($usr_file,'','CHMOD /data to 777!');}

if(isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])){$browser=$HTTP_SERVER_VARS['HTTP_USER_AGENT'];}else{$browser='';}

if(stristr($browser,'msie')&&!stristr($browser,'opera')){
if(function_exists('ob_gzhandler')&&$gzip==1&&(stristr($PHP_SELF,'chat')||stristr($PHP_SELF,'admin')||stristr($PHP_SELF,'history'))){ob_start("ob_gzhandler");}
else{
if(!stristr($PHP_SELF,'smilies')&&!stristr($PHP_SELF,'top')&&!stristr($PHP_SELF,'bottom')){
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");}}}

else{
if(function_exists('ob_gzhandler')&&$gzip==1){ob_start("ob_gzhandler");}
if(!stristr($PHP_SELF,'smilies')&&!stristr($PHP_SELF,'top')&&!stristr($PHP_SELF,'bottom')){
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");}}
?>