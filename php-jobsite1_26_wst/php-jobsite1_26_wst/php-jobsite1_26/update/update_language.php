<?php 
if ($HTTP_GET_VARS['type']=="main") {
   $HTTP_GET_VARS['language']=$HTTP_GET_VARS['lng'];
   $language = $HTTP_GET_VARS['lng'];
}
define('DB_CONNECT','no');
include("../application_config_file.php");
set_time_limit(0);
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

if ($HTTP_GET_VARS['type']=="main") {
        $i=1;
        while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
               unset(${TEXT_LANGUAGE_KNOWN_OPT.$i});
               $i++;
        }
        $i=1;
        while (${TEXT_DEGREE_OPT.$i}) {
               unset(${TEXT_DEGREE_OPT.$i});
               $i++;
        }
        $i=1;
        while (${TEXT_CCTYPE_OPT.$i}) {
               unset(${TEXT_CCTYPE_OPT.$i});
               $i++;
        }
        $i=1;
        while (${TEXT_PAYMENT_OPT.$i}) {
               unset(${TEXT_PAYMENT_OPT.$i});
               $i++;
        }
        $i=1;
        while (${TEXT_JOBMAIL_OPT.$i}) {
               unset(${TEXT_JOBMAIL_OPT.$i});
               $i++;
        }
        include(DIR_LANGUAGES.$HTTP_GET_VARS['lng'].".php");
        $fp=fopen(DIR_LANGUAGES.$HTTP_GET_VARS['lng'].".php","r");
        $st=array();
        while (!feof($fp)) {
               $str=trim(fgets($fp, 20000));
               if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
                  if (eregi("^define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
                      $st['h'][] = $regexp[1];
                      $st['v'][] = preg_replace("/(\015\012)|(\015)|(\012)/","'.\"\\n\".'",eregi_replace("'", "\\'", constant($regexp[1])));
                  }
               }
        }     
        fclose($fp);
        write_config($st, DIR_SERVER_ROOT."update/ver1_26/languages/".$HTTP_GET_VARS['lng'].".php");    
        unset($st);
        $langfile=file(DIR_SERVER_ROOT."update/ver1_26/languages/".$HTTP_GET_VARS['lng'].".php");
        for ($j=0;$j<sizeof($langfile);$j++) {
                $found = false;
                $i=1;
                while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".$i,$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".$i."='".${TEXT_LANGUAGE_KNOWN_OPT.$i}."';\n";
                        $found =true;
                    }
                    $i++;
                }
                for ( $y=$i; $y<15;$y++ ) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".$y,$langfile[$j],$regs)) {
                        $found=true;
                    }
                }
                $i=1;
                while (${TEXT_DEGREE_OPT.$i}) {
                    if (eregi("TEXT_DEGREE_OPT".$i,$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_DEGREE_OPT".$i."='".${TEXT_DEGREE_OPT.$i}."';\n";
                        $found =true;
                    }
                    $i++;
                }
                for ( $y=$i; $y<15;$y++ ) {
                    if (eregi("TEXT_DEGREE_OPT".$y,$langfile[$j],$regs)) {
                        $found=true;
                    }
                }
                $i=1;
                while (${TEXT_CCTYPE_OPT.$i}) {
                    if (eregi("TEXT_CCTYPE_OPT".$i,$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_CCTYPE_OPT".$i."='".${TEXT_CCTYPE_OPT.$i}."';\n";
                        $found =true;
                    }
                    $i++;
                }
                for ( $y=$i; $y<15;$y++ ) {
                    if (eregi("TEXT_CCTYPE_OPT".$y,$langfile[$j],$regs)) {
                        $found=true;
                    }
                }
                $i=1;
                while (${TEXT_PAYMENT_OPT.$i}) {
                    if (eregi("TEXT_PAYMENT_OPT".$i,$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_PAYMENT_OPT".$i."='".${TEXT_PAYMENT_OPT.$i}."';\n";
                        $found =true;
                    }
                    $i++;
                }
                for ( $y=$i; $y<15;$y++ ) {
                    if (eregi("TEXT_PAYMENT_OPT".$y,$langfile[$j],$regs)) {
                        $found=true;
                    }
                }
                $i=1;
                while (${TEXT_JOBMAIL_OPT.$i}) {
                    if (eregi("TEXT_JOBMAIL_OPT".$i,$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_JOBMAIL_OPT".$i."='".${TEXT_JOBMAIL_OPT.$i}."';\n";
                        $found =true;
                    }
                    $i++;
                }
                if (eregi("CHARSET_OPTION",$langfile[$j],$regs)) {
                      $newlangfile[] = "\$CHARSET_OPTION='".$CHARSET_OPTION."';\n";
                      $found =true;
                }
                if (eregi("DATE_FORMAT",$langfile[$j],$regs)) {
                      if (!$DATE_FORMAT) {
                            if (DATE_FORMAT) {
                                $DATE_FORMAT=DATE_FORMAT;
                            }
                            else {
                                $DATE_FORMAT="mm/dd/YYYY";
                            }
                      }                      
                      $newlangfile[] = "\$DATE_FORMAT='".$DATE_FORMAT."';\n";
                      $found =true;
                }
                if (eregi("PRICE_FORMAT",$langfile[$j],$regs)) {
                      if (!$PRICE_FORMAT) {
                            if (PRICE_FORMAT) {
                                $PRICE_FORMAT=PRICE_FORMAT;
                            }
                            else {
                                $PRICE_FORMAT="1,234.56";
                            }
                      }     
                      $newlangfile[] = "\$PRICE_FORMAT='".$PRICE_FORMAT."';\n";
                      $found =true;
                }
                if (!$found) {
                    $newlangfile[] = $langfile[$j];
                }
        }
        $fp = fopen(DIR_SERVER_ROOT."update/ver1_26/languages/".$HTTP_GET_VARS['lng'].".php", "w");
        for ($j=0;$j<sizeof($newlangfile);$j++) {
              fwrite($fp, $newlangfile[$j]);
        }            
        fclose($fp);
}
else {
        $files = getFiles(DIR_LANGUAGES.$HTTP_GET_VARS['lng']);
        for ($j=0; $j<count($files); $j++) {
                if ($files[$j]!="index.html" && $files[$j]!="index.htm") {
                    include(HTTP_SERVER."/update/update_language_file.php?lng=".$HTTP_GET_VARS['lng']."&file=".$files[$j]);
                    flush();
                }
        }
}        
?>       