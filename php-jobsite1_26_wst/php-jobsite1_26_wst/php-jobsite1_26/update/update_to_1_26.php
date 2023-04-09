<?php
include ('../application_config_file.php');
$update_file="update-1_22-1_26.sql";
set_time_limit(30);
function write_config($cf, $filename)
{
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
                if (eregi("define\('".$cf['h'][$i]."'(.*)",$buffer,$regs)) {
                   if($cf['h'][$i] != "DIR_ADMIN") {
                       $buffer = eregi_replace("define\('".$cf['h'][$i]."'(.*)","define('".$cf['h'][$i]."','".$cf['v'][$i]."');\n",$buffer);
                   }
                   else {
                       $buffer = eregi_replace("define\('".$cf['h'][$i]."'(.*)","define('".$cf['h'][$i]."',".$cf['v'][$i]."');\n",$buffer);
                   }
            }
        }
        $to_write .= $buffer;
    }
    fclose($fp);
    $fp2 = fopen($filename, "w+");
    fwrite($fp2, $to_write);
    fclose($fp2);
} // end func
function write_email_config($filename, $cf)
{
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
                if (eregi("\\\$".$cf['h'][$i]."(.*)",$buffer,$regs)) {
                    $buffer = eregi_replace("\\\$".$cf['h'][$i]."(.*)","\$".$cf['h'][$i]." = \"".$cf['v'][$i]."\";\n",$buffer);
                }
        }
        $to_write .= $buffer;
    }
    fclose($fp);
    $fp2 = fopen($filename, "w+");
    fwrite($fp2, $to_write);
    fclose($fp2);
} // end func

function print_header(){
    ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="history" content="">
<meta name="author" content="Copyright © 2002-2003  BitmixSoft. All rights reserved.">
<title>Update Tool</title>
<style type="text/css" title="mini">
        input {font-size: 12px; color: #FF0000; font-weight: bold;}
        TD {font-size: 12px; color: #000000;}
        A:LINK, A:VISITED {color: #0E066D; font-family: Arial, Helvetica; font-size: 11px;}
        A:HOVER {color: #404040; font-size: 11px;}
</style>
</head>
<body>
<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
     <?php           
}
function print_footer(){
    echo "</table></body></html>";
}

if ($HTTP_POST_VARS['step']==3) {
        print_header();
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\">Updating configuration files...</td></tr>";
        $cf['h'][] = "HTTP_SERVER";
        $cf['v'][] = HTTP_SERVER;
        $cf['h'][] = "HTTPS_SERVER";
        $cf['v'][] = HTTPS_SERVER;
        $cf['h'][] = "HTTP_SERVER_ADMIN";
        $cf['v'][] = HTTP_SERVER_ADMIN;
        $cf['h'][] = "DIR_ADMIN";
        $cf['v'][] = "'".DIR_ADMIN;
        $cf['h'][] = "DIR_SERVER_ROOT";
        $cf['v'][] = DIR_SERVER_ROOT;
        $cf['h'][] = "DB_SERVER_TYPE";
        $cf['v'][] = DB_SERVER_TYPE;
        $cf['h'][] = "DB_SERVER";
        $cf['v'][] = DB_SERVER;
        $cf['h'][] = "DB_SERVER_USERNAME";
        $cf['v'][] = DB_SERVER_USERNAME;
        $cf['h'][] = "DB_SERVER_PASSWORD";
        $cf['v'][] = DB_SERVER_PASSWORD;
        $cf['h'][] = "DB_DATABASE";
        $cf['v'][] = DB_DATABASE;
        write_config($cf, DIR_SERVER_ROOT."update/ver1_26/application_config_file.php");
        echo "<tr><td align=\"center\">&nbsp;Config Updated!</td></tr>";
        flush();
        if(@include(DIR_SERVER_ROOT."application_settings.php")){
            $fp=@fopen(DIR_SERVER_ROOT."application_settings.php","r");
            while (!feof($fp)) {
                   $str=trim(fgets($fp, 20000));
                   if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
                      if (eregi("^define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
                          $st['h'][] = $regexp[1];
                          $st['v'][] = preg_replace("/(\015\012)|(\015)|(\012)/","'.\"\\n\".'",constant($regexp[1]));
                      }
                   }
             }     
            write_config($st, DIR_SERVER_ROOT."update/ver1_26/application_settings.php");
        }    
        echo "<tr><td align=\"center\">&nbsp;Settings Updated!</td></tr>";
        flush();
        if(@include(DIR_SERVER_ROOT."design_configuration.php")){
            $fp=@fopen(DIR_SERVER_ROOT."design_configuration.php","r");
            while (!feof($fp)) {
                   $str=trim(fgets($fp, 20000));
                   if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
                      if (eregi("^define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
                          $st['h'][] = $regexp[1];
                          $st['v'][] = constant($regexp[1]);
                      }
                   }
             }     
            write_config($st, DIR_SERVER_ROOT."update/ver1_26/design_configuration.php");
        }    
        echo "<tr><td align=\"center\">&nbsp;Layout Updated!</td></tr>";
        flush();
        if(@include(DIR_SERVER_ROOT."cc_payment_settings.php")){
            $fp=@fopen(DIR_SERVER_ROOT."cc_payment_settings.php","r");
            while (!feof($fp)) {
                   $str=trim(fgets($fp, 20000));
                   if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
                      if (eregi("^define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
                          $st['h'][] = $regexp[1];
                          $st['v'][] = constant($regexp[1]);
                      }
                   }
            }     
            write_config($st, DIR_SERVER_ROOT."update/ver1_26/cc_payment_settings.php");
        }
        echo "<tr><td align=\"center\">&nbsp;Payment Settings Updated!</td></tr>";
        flush();
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\"><form method=post action=\"update_to_1_26.php\"><input type=\"hidden\" name=\"step\" value=\"4\"><input type=\"submit\" name=\"go\" value=\"Next Step >>\"></form></td></tr>";
        print_footer();
}
elseif ($HTTP_POST_VARS['step']==4) {
        function bx_admin_error($error_message){
            echo "<tr><td>".$error_message."</td></tr>";
        }
        print_header();
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\">Updating Language files</td></tr>";
        echo "<tr><td align=\"center\"><b>Note: this can take from 1 to 10 minutes!</b></td></tr>";
        flush();
        $dirs = getFolders(DIR_LANGUAGES);
        for ($d=0; $d<count($dirs); $d++) {
           if (file_exists(DIR_LANGUAGES.$dirs[$d].".php")) {
                  if(file_exists(DIR_SERVER_ROOT."update/ver1_26/languages/".$dirs[$d].".php")){
                  }
                  else {
                          $lng_dir=DIR_SERVER_ROOT."update/ver1_26/languages/";
                          $image_dir=DIR_SERVER_ROOT."update/ver1_26/other/";
                          $lng = $dirs[$d];
                          $folders = "english";
                          $create=true;
                          if (($create) && (!mkdir($lng_dir.$lng, 0777)) ) {
                               bx_admin_error("Unable to create directory ".$lng_dir.$lng.".");
                               $create = false;
                          }
                          else {
                              @chmod($lng_dir.$lng, 0777);
                          }
                          if (($create) && (!mkdir($lng_dir.$lng."/mail", 0777)) ) {
                               bx_admin_error("Unable to create directory ".$lng_dir.$lng."/mail.");
                               $create = false;
                          }
                          else {
                             @chmod($lng_dir.$lng."/mail", 0777);
                          }
                          if (($create) && (!mkdir($lng_dir.$lng."/html", 0777)) ) {
                               bx_admin_error("Unable to create directory ".$lng_dir.$lng."/html.");
                               $create = false;
                          }
                          else {
                             @chmod($lng_dir.$lng."/html", 0777);
                          }
                          if (($create) && (!mkdir($image_dir.$lng, 0777)) ) {
                               bx_admin_error("Unable to create directory ".$image_dir.$lng.".");
                               $create = false;
                          }
                          else {
                             @chmod($image_dir.$lng, 0777);
                          }
                          if (($create) && (!copy($lng_dir.$folders.".php",$lng_dir.$lng.".php")) ) {
                               bx_admin_error("Unable to copy/create base language file ".$lng_dir.$lng.".php.");
                               $create = false;
                          }
                          if (($create) && (!chmod($lng_dir.$lng.".php", 0777))) {
                               bx_admin_error("Unable to change permissions for file ".$lng_dir.$lng.".php.");
                               $create = false;
                          }
                          if ($create) {
                               $files = getFiles($lng_dir.$folders);
                               for ($i=0; $i<count($files); $i++) {
                                     if (($create) && (!copy($lng_dir.$folders."/".$files[$i],$lng_dir.$lng."/".$files[$i]))) {
                                               bx_admin_error("Unable to copy/create base language file ".$lng_dir.$lng."/".$files[$i].".");
                                               $create = false;
                                     }
                                     else {
                                           @chmod($lng_dir.$lng."/".$files[$i], 0777);
                                     }
                               }
                          }
                          if ($create) {
                               $files = getFiles($lng_dir.$folders."/mail");
                               for ($i=0; $i<count($files); $i++) {
                                     if (($create) && (!copy($lng_dir.$folders."/mail/".$files[$i],$lng_dir.$lng."/mail/".$files[$i]))) {
                                               bx_admin_error("Unable to copy/create base language file ".$lng_dir.$lng."/mail/".$files[$i].".");
                                               $create = false;
                                     }
                                     else {
                                          @chmod($lng_dir.$lng."/mail/".$files[$i], 0777);
                                     }
                               }
                          }
                          if ($create) {
                               $files = getFiles($lng_dir.$folders."/html");
                               for ($i=0; $i<count($files); $i++) {
                                     if (($create) && (!copy($lng_dir.$folders."/html/".$files[$i],$lng_dir.$lng."/html/".$files[$i]))) {
                                               bx_admin_error("Unable to copy/create base language file ".$lng_dir.$lng."/html/".$files[$i].".");
                                               $create = false;
                                     }
                                     else {
                                              @chmod($lng_dir.$lng."/html/".$files[$i], 0777);
                                     }
                               }//end for
                          }
                          if ($create) {
                               $files = getFiles($image_dir.$folders);
                               for ($i=0; $i<count($files); $i++) {
                                     if (($create) && (!copy($image_dir.$folders."/".$files[$i],$image_dir.$lng."/".$files[$i]))) {
                                               bx_admin_error("Unable to copy/create language images ".$image_dir.$lng."/".$files[$i].".");
                                               $create = false;
                                     }
                                     else {
                                              @chmod($image_dir.$lng."/".$files[$i], 0777);
                                     }
                               }
                          }  
                  }
           }
        }
        flush();
        $dirs = getFolders(DIR_SERVER_ROOT."update/ver1_26/languages/");
        for ($d=0; $d<count($dirs); $d++) {
           if (file_exists(DIR_SERVER_ROOT."update/ver1_26/languages/".$dirs[$d].".php")) {
                  if(file_exists(DIR_LANGUAGES.$dirs[$d].".php")){
                      
                  }
                  else {
                      $folders = $dirs[$d]; 
                      $lng_dir=DIR_SERVER_ROOT."update/ver1_26/languages/";
                      $image_dir=DIR_SERVER_ROOT."update/ver1_26/other/";
                      $flag_dir=DIR_SERVER_ROOT."update/ver1_26/other/flags/";
                      $del=true;
                      if (!file_exists($lng_dir.$folders)) {
                           bx_admin_error("Language directory doesn't exists ".$lng_dir.$folders.".");
                           $del = false;
                      }
                      if (!file_exists($lng_dir.$folders."/mail")) {
                           bx_admin_error("Language mail directory doesn't exists ".$lng_dir.$folders."/mail.");
                           $del = false;
                      }
                      if (!file_exists($lng_dir.$folders."/html")) {
                           bx_admin_error("Language html directory doesn't exists ".$lng_dir.$folders."/html.");
                           $del = false;
                      }
                      if (!file_exists($image_dir.$folders)) {
                           bx_admin_error("Language image directory doesn't exists ".$image_dir.$folders.".");
                           $del = false;
                      }
                      if ($del) {
                           $files = getFiles($lng_dir.$folders."/mail");
                           for ($i=0; $i<count($files); $i++) {
                                 if (($del) && (!unlink($lng_dir.$folders."/mail/".$files[$i])) ) {
                                           bx_admin_error("Unable to delete language mail file ".$lng_dir.$folders."/mail/".$files[$i].".");
                                           $del = false;
                                 }
                           }
                      }
                      if (($del) && (!rmdir($lng_dir.$folders."/mail")) ) {
                           bx_admin_error("Unable to delete directory ".$lng_dir.$folders."/mail.");
                           $del = false;
                      }
                      if ($del) {
                           $files = getFiles($lng_dir.$folders."/html");
                           for ($i=0; $i<count($files); $i++) {
                                 if (($del) && (!unlink($lng_dir.$folders."/html/".$files[$i])) ) {
                                           bx_admin_error("Unable to delete language html file ".$lng_dir.$folders."/html/".$files[$i].".");
                                           $del = false;
                                 }
                           }
                      }
                      if (($del) && (!rmdir($lng_dir.$folders."/html")) ) {
                           bx_admin_error("Unable to delete directory ".$lng_dir.$folders."/html.");
                           $del = false;
                      }
                      if ($del) {
                           $files = getFiles($lng_dir.$folders);
                           for ($i=0; $i<count($files); $i++) {
                                 if (($del) && (!unlink($lng_dir.$folders."/".$files[$i])) ) {
                                           bx_admin_error("Unable to delete language file ".$lng_dir.$folders."/".$files[$i].".");
                                           $del = false;
                                 }
                           }
                      }
                      if (($del) && (!rmdir($lng_dir.$folders)) ) {
                           bx_admin_error("Unable to delete directory ".$lng_dir.$folders.".");
                           $del = false;
                      }
                      if ($del) {
                           $files = getFiles($image_dir.$folders);
                           for ($i=0; $i<count($files); $i++) {
                                 if (($del) && (!unlink($image_dir.$folders."/".$files[$i])) ) {
                                           bx_admin_error("Unable to delete language image file ".DIR_IMAGES.$folders."/".$files[$i].".");
                                           $del = false;
                                 }
                           }
                       }
                       if (($del) && (!rmdir($image_dir.$folders)) ) {
                           bx_admin_error("Unable to delete image directory ".$image_dir.$folders.".");
                           $del = false;
                       }
                       if (($del) && (!unlink($lng_dir.$folders.".php")) ) {
                           bx_admin_error("Unable to delete base language file ".$lng_dir.$folders.".php.");
                           $del = false;
                       }
                       if (file_exists($flag_dir.$folders.".gif")) {
                             if (($del) && (!unlink($flag_dir.$folders.".gif")) ) {
                                   bx_admin_error("Unable to delete flag image file ".$flag_dir.$folders.".gif");
                                   $del = false;
                             }
                       }
                       if (file_exists($flag_dir.$folders.".jpg")) {
                             if (($del) && (!unlink($flag_dir.$folders.".jpg")) ) {
                                   bx_admin_error("Unable to delete flag image file ".$flag_dir.$folders.".jpg");
                                   $del = false;
                             }
                       }
                       if (file_exists($flag_dir.$folders.".png")) {
                             if (($del) && (!unlink($flag_dir.$folders.".png")) ) {
                                   bx_admin_error("Unable to delete flag image file ".$flag_dir.$folders.".png");
                                   $del = false;
                             }
                       }
                  }
             }      
        } 
        
        $dirs = getFolders(DIR_LANGUAGES);
        $image_dir=DIR_SERVER_ROOT."update/ver1_26/other/";
        $flag_dir=DIR_SERVER_ROOT."update/ver1_26/other/flags/";
        for ($d=0; $d<count($dirs); $d++) {
           if (file_exists(DIR_LANGUAGES.$dirs[$d].".php")) {
               $files = getFiles(DIR_IMAGES.$dirs[$d]);
               for ($j=0; $j<count($files); $j++) {
                     @unlink($image_dir.$dirs[$d]."/".$files[$j]);
                     @copy(DIR_IMAGES.$dirs[$d]."/".$files[$j],$image_dir.$dirs[$d]."/".$files[$j]);
               }
               
               if (file_exists(DIR_FLAG.$dirs[$d].".gif")) {
                     @unlink($flag_dir.$dirs[$d].".gif");
                     @copy(DIR_FLAG.$dirs[$d].".gif",$flag_dir.$dirs[$d].".gif");
               }
               if (file_exists(DIR_FLAG.$dirs[$d].".jpg")) {
                     @unlink($flag_dir.$dirs[$d].".jpg");
                     @copy(DIR_FLAG.$dirs[$d].".jpg",$flag_dir.$dirs[$d].".jpg");
               }
               if (file_exists(DIR_FLAG.$dirs[$d].".png")) {
                     @unlink($flag_dir.$dirs[$d].".png");
                     @copy(DIR_FLAG.$dirs[$d].".png",$flag_dir.$dirs[$d].".png");
               }
           }
        }     
        flush();
        $dirs = getFolders(DIR_LANGUAGES);
        $lng_dir=DIR_SERVER_ROOT."update/ver1_26/languages/";
        for ($d=0; $d<count($dirs); $d++) {
           if (file_exists(DIR_LANGUAGES.$dirs[$d].".php")) {
               include(HTTP_SERVER."/update/update_language.php?lng=".$dirs[$d]);
               include(HTTP_SERVER."/update/update_language.php?lng=".$dirs[$d]."&type=main");
               $files = getFiles(DIR_LANGUAGES.$dirs[$d]."/mail/");
               for ($j=0; $j<count($files); $j++) {
                     if (eregi(".txt$",$files[$j])) {
                         @unlink($lng_dir.$dirs[$d]."/mail/".$files[$j]);
                         @copy(DIR_LANGUAGES.$dirs[$d]."/mail/".$files[$j],$lng_dir.$dirs[$d]."/mail/".$files[$j]);
                     }
                     else {
                            $cf=array();
                            include(DIR_LANGUAGES.$dirs[$d]."/mail/".$files[$j]);
                            $cf['h'][] = "file_mail_subject";
                            $cf['v'][] = addslashes($file_mail_subject);
                            $cf['h'][] = "html_mail";
                            $cf['v'][] = $html_mail;
                            $cf['h'][] = "add_mail_signature";
                            $cf['v'][] = $add_mail_signature;
                            write_email_config($lng_dir.$dirs[$d]."/mail/".$files[$j] , $cf);
                     }
               }
               $files = getFiles(DIR_LANGUAGES.$dirs[$d]."/html/");
               for ($j=0; $j<count($files); $j++) {
                     if (!eregi(".php",$dirs[$i])) {
                         if (file_exists(DIR_LANGUAGES.$dirs[$d]."/html/".$files[$j].".cfg.php")) {
                            $template = fread(fopen(DIR_LANGUAGES.$dirs[$d]."/html/".$files[$j],"r"),filesize(DIR_LANGUAGES.$dirs[$d]."/html/".$files[$j]));
                            @include($lng_dir.$dirs[$d]."/html/".$files[$j].".cfg.php");
                            reset($fields);
                            while (list($h, $v) = each($fields)) {
                                     $template = eregi_replace($v[0],$v[3],$template);
                            }  
                            if (file_exists($lng_dir.$dirs[$d]."/html/".(eregi_replace("\.(html|htm)",".php",$files[$j])))) {
                                 $fp=@fopen($lng_dir.$dirs[$d]."/html/".(eregi_replace("\.(html|htm)",".php",$files[$j])), "w+");
                                 fwrite($fp, $template);
                                 fclose($fp);
                             }    
                             @unlink($lng_dir.$dirs[$d]."/html/".$files[$j]);
                             @copy(DIR_LANGUAGES.$dirs[$d]."/html/".$files[$j],$lng_dir.$dirs[$d]."/html/".$files[$j]);
                         }
                         else {
                             @unlink($lng_dir.$dirs[$d]."/html/".$files[$j]);
                             @copy(DIR_LANGUAGES.$dirs[$d]."/html/".$files[$j],$lng_dir.$dirs[$d]."/html/".$files[$j]);
                         }
                     }
               }
               echo "<tr><td align=\"center\">Updated language: ".$dirs[$d]."</td></tr>";
               flush();
           }
        }     
        
        $files = getFiles(DIR_LOGO);
        for ($j=0; $j<count($files); $j++) {
             @copy(DIR_LOGO.$files[$j],DIR_SERVER_ROOT."update/ver1_26/logo/".$files[$j]);
        }
        
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\"><form method=post action=\"update_to_1_26.php\"><input type=\"hidden\" name=\"step\" value=\"5\"><input type=\"submit\" name=\"go\" value=\"Next Step >>\"></form></td></tr>";
        print_footer();
}
elseif ($HTTP_POST_VARS['step']==5) {
        print_header();
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\">Updating DONE!</td></tr>";
        echo "<tr><td>What you have to do next:</td></tr>";
        echo "<tr><td>1. Move the <b>update</b> directory from the server to your home PC or somewhere else!:</td></tr>";
        echo "<tr><td>2. Move the new script files, overwriting the old ones, or even better deleting the old files, directories and copy the new ones! - Do not copy the update directory again</td></tr>";
        echo "<tr><td>3. Move the files/directories from the <b>\"update/ver1_26\"</b> directory from step 2) overwriting the new script files, this files was created during update, collecting your old modifications, configuration!:</td></tr>";
        echo "<tr><td>4. Try the new script by pointing the browser to <a href=\"".HTTP_SERVER."\">".HTTP_SERVER."</a>!:</td></tr>";
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        print_footer();
}
elseif($HTTP_POST_VARS['step']==2) {
        function split_sql(&$ret, $sql)
        {
            $sql          = trim($sql);
            $sql_len      = strlen($sql);
            $char         = '';
            $string_start = '';
            $in_string    = FALSE;
            $time0        = time();
            for ($i = 0; $i < $sql_len; ++$i) {
                $char = $sql[$i];
                // We are in a string, check for not escaped end of strings except for
                // backquotes that can't be escaped
                if ($in_string) {
                    for (;;) {
                        $i = strpos($sql, $string_start, $i);
                        // No end of string found -> add the current substring to the
                        // returned array
                        if (!$i) {
                            $ret[] = $sql;
                            return TRUE;
                        }
                        // Backquotes or no backslashes before quotes: it's indeed the
                        // end of the string -> exit the loop
                        else if ($string_start == '`' || $sql[$i-1] != '\\') {
                            $string_start      = '';
                            $in_string         = FALSE;
                            break;
                        }
                        // one or more Backslashes before the presumed end of string...
                        else {
                            // ... first checks for escaped backslashes
                            $j                     = 2;
                            $escaped_backslash     = FALSE;
                            while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                                $escaped_backslash = !$escaped_backslash;
                                $j++;
                            }
                            // ... if escaped backslashes: it's really the end of the
                            // string -> exit the loop
                            if ($escaped_backslash) {
                                $string_start  = '';
                                $in_string     = FALSE;
                                break;
                            }
                            // ... else loop
                            else {
                                $i++;
                            }
                        } // end if...elseif...else
                    } // end for
                } // end if (in string)
                // We are not in a string, first check for delimiter...
                else if ($char == ';') {
                    // if delimiter found, add the parsed part to the returned array
                    $ret[]      = substr($sql, 0, $i);
                    $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
                    $sql_len    = strlen($sql);
                    if ($sql_len) {
                        $i      = -1;
                    } else {
                        // The submited statement(s) end(s) here
                        return TRUE;
                    }
                } // end else if (is delimiter)
        
                // ... then check for start of a string,...
                else if (($char == '"') || ($char == '\'') || ($char == '`')) {
                    $in_string    = TRUE;
                    $string_start = $char;
                } // end else if (is start of string)
        
                // ... for start of a comment (and remove this comment if found)...
                else if ($char == '#'
                         || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
                    // starting position of the comment depends on the comment type
                    $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
                    // if no "\n" exits in the remaining string, checks for "\r"
                    // (Mac eol style)
                    $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                                      ? strpos(' ' . $sql, "\012", $i+2)
                                      : strpos(' ' . $sql, "\015", $i+2);
                    if (!$end_of_comment) {
                        // no eol found after '#', add the parsed part to the returned
                        // array if required and exit
                        if ($start_of_comment > 0) {
                            $ret[]    = trim(substr($sql, 0, $start_of_comment));
                        }
                        return TRUE;
                    } else {
                        $sql          = substr($sql, 0, $start_of_comment)
                                      . ltrim(substr($sql, $end_of_comment));
                        $sql_len      = strlen($sql);
                        $i--;
                    } // end if...else
                } // end else if (is comment)
              
            } // end for
        
            // add any rest to the returned array
            if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
                $ret[] = $sql;
            }
            return $ret;
        }
        print_header();
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\">Updating database tables...</td></tr>";
        if (file_exists($update_file)) {
            $sql_query = fread(fopen($update_file, "r"), filesize($update_file));
            $my_pieces  = split_sql($pieces, $sql_query);
            $pieces[]="ALTER TABLE `phpjob_pricing` RENAME phpjob_pricing_".substr(DEFAULT_LANGUAGE,0,2)."";
            $dirs = getFolders(DIR_LANGUAGES);
            for ($i=0; $i<count($dirs); $i++) {
               if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                     if ($dirs[$i]!=DEFAULT_LANGUAGE) {
                           $pieces[]="CREATE TABLE `phpjob_pricing_".substr($dirs[$i],0,2)."` ( `pricing_id` mediumint( 3 ) NOT NULL default '0', `pricing_title` varchar( 50 ) NOT NULL default '', `pricing_avjobs` mediumint( 3 ) NOT NULL default '0', `pricing_avsearch` mediumint( 3 ) NOT NULL default '0', `pricing_fjobs` mediumint( 3 ) NOT NULL default '0', `pricing_fcompany` char( 3 ) NOT NULL default '0', `pricing_period` mediumint( 2 ) NOT NULL default '0', `pricing_price` float( 10, 2 ) NOT NULL default '0.00', `pricing_currency` char( 3 ) NOT NULL default '', `pricing_default` tinyint( 4 ) NOT NULL default '0', PRIMARY KEY ( `pricing_id` ))";
                           $pieces[]="INSERT INTO `phpjob_pricing_ge` SELECT * FROM `phpjob_pricing_en`";
                     }                     
               }
            }
            
            if (count($pieces) == 1 && !empty($pieces[0])) {
                $pieces[0] = trim($pieces[0]);
                $result = @mysql_query ($pieces[0]);
                if (mysql_error()) {
                    echo mysql_error();
                }
            }
            else {
                for ($i=0; $i<count($pieces); $i++)
                {
                    $pieces[$i] = trim($pieces[$i]);
                    if(!empty($pieces[$i]) && $pieces[$i] != "#") {
                        $result = @mysql_query ($pieces[$i]);
                        if (mysql_error()) {
                            echo "<tr><td><b>Error:</b> <font color=red>".mysql_error()."</font>  <b>Ignore</b> (Already altered from a previous update or install)</td></tr>";
                        }
                        else {
                            echo "<tr><td>Sql query success:".$pieces[$i]."</td></tr>";
                        }
                    }
                }
            }
            echo "<tr><td align=\"center\"><b>Success...</b></td></tr>";
        }
        else {
            echo "<tr><td><b>Error:</b> <font color=red>sql update file <b>".$update_file."</b> doesn't exists!</font></td></tr>";
        }
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\"><form method=post action=\"update_to_1_26.php\"><input type=\"hidden\" name=\"step\" value=\"3\"><input type=\"submit\" name=\"go\" value=\"Next Step >>\"></form></td></tr>";
        print_footer();
}
elseif($HTTP_POST_VARS['step']==1) {
        print_header();
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\">Backuping script files..";
        if ($HTTP_POST_VARS['backup']=="yes") {
                $error_file = false;
                $tar_file = DIR_SERVER_ROOT."/update/backup/backup_".date('Y-m-d');
                $er = exec("tar -zcvf ".$tar_file.".tgz ".DIR_SERVER_ROOT,$strin);
                if($strin) {
                    echo "<b>OK</b>";
                    $error_file = false;
                }
                else {
                    echo "<br><b><font color=\"FF0000\">Can make tgz file form the scriptfiles ....<br>Please make your own backup of the files<br>Only then go to the next Step!</font></b>";
                    $error_file = true;
                }
        }
        else {
             echo "Skipped!";
        }        
        echo "</td></tr>";
        echo "<tr><td align=\"center\">Backuping database...";
        if ($HTTP_POST_VARS['backup_db']=="yes") {
                include("backup_db.php");
                $error_db = false;
                if (file_exists(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql") and filesize(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql")>0) {
                    echo "<B>OK</b> </td></tr>";
                    $error_db = false;
                }
                else {
                    echo "<br><b><font color=\"FF0000\">Can make database backup file ....<br>Please make your own backup of the database<br>Only then go to the next Step!</font></b>";
                    echo "</td></tr>";
                    $error_db = true;
                }
                if (!$error_file && !$error_db) {
                    echo "<tr><td align=\"center\">You can find the file and database backup in the <b>\"/update/backup\"</b> directory</td></tr>";
                }
        }        
        else {
             echo "Skipped!";
             echo "</td></tr>";
        }        
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\"><form method=post action=\"update_to_1_26.php\"><input type=\"hidden\" name=\"step\" value=\"2\"><input type=\"submit\" name=\"go\" value=\"Next Step >>\"></form></td></tr>";
        print_footer();
}   
else {
        print_header();
        echo "<form method=post action=\"update_to_1_26.php\"><tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\">Backup script files..<input type=\"radio\" name=\"backup\" value=\"yes\" checked> Yes&nbsp;&nbsp;<input type=\"radio\" name=\"backup\" value=\"no\"> No";
        echo "</td></tr>";
        echo "<tr><td align=\"center\">Backuping database...<input type=\"radio\" name=\"backup_db\" value=\"yes\" checked> Yes&nbsp;&nbsp;<input type=\"radio\" name=\"backup_db\" value=\"no\"> No";
        echo "</td></tr>";
        echo "<tr><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr><td align=\"center\"><input type=\"hidden\" name=\"step\" value=\"1\"><input type=\"submit\" name=\"go\" value=\"Next Step >>\"></td></tr></form>";
        print_footer();
}
?>