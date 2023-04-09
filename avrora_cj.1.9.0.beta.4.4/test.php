<?php
print "1. PHP Version ".phpversion(). "... ";
if (-1 == version_compare(phpversion(),'4.1.0')) {
    print "failed. <br>";
} else {print "passed. <br>";}

if (file_exists($_SERVER['DOCUMENT_ROOT'].'/sys_log') == false) {
    print "Directory <i>sys_log</i> not exists. Test 2,3 skipping.";
}else {
    print "2. Checking directory permission ... ";
    $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/sys_log/test_file_1.dat','w');
    if (!$fp) {
        print "failed. <br>";
    }
    fwrite($fp,'test');
    fclose($fp);
    print "passed. <br>";
    
    print "3. Checking directory listing ... ";
    $dp = opendir($_SERVER['DOCUMENT_ROOT'].'/sys_log');
    if (!$dp) {
        print "failed. Cannot open dir. <br>";
    } else {
        $dir = array();
        while (($file = readdir($dp)) !== false) {
            $dir[] = $file;
        }
        if (in_array('test_file_1.dat',$dir)) {
            print "passed .<br>";
        } else {
            print "failed. Cannot list directory.<br>";
        }
        closedir($dp);
    }
}

@unlink('./sys_log/test_file_1.dat');
phpinfo();
?>
