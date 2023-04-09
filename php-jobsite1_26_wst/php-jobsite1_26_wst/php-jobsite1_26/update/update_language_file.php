<?php
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
if (file_exists(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/".$HTTP_GET_VARS['file'])) {
    //@include(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/".$HTTP_GET_VARS['file']);
    $fp=@fopen(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/".$HTTP_GET_VARS['file'],"r");
    $st=array();
    while (!feof($fp)) {
           $str=trim(fgets($fp, 20000));
           if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
              if (eregi("^define\(['](.*)['|.?],['|.?| ](.*)\)",$str,$regexp)) {
                  $st['h'][] = $regexp[1];
                  $st['v'][] = eregi_replace("'$", "", $regexp[2]);
              }
           }
    }     
    fclose($fp);
    if (file_exists(DIR_SERVER_ROOT."update/ver1_26/languages/".$HTTP_GET_VARS['lng']."/".$HTTP_GET_VARS['file'])) {
        write_config($st, DIR_SERVER_ROOT."update/ver1_26/languages/".$HTTP_GET_VARS['lng']."/".$HTTP_GET_VARS['file']);    
    }
}
unset($st);
?>