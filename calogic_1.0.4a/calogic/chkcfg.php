<?php

// try to get config info

echo "Checking MySQL Version, this must be >= 3.23.47<br><br>";
echo "MySQL Version: ".mysql_get_client_info()."<br><br><br>";
echo "Checking PHP Version, this must be >= 4.1.1<br><br>";
echo "PHP Version: ".PHP_VERSION."<br><br><br>";
//echo "PHP version test: ".version_compare("4.1.1", PHP_VERSION)."<br><br>";
echo "Getting Path Info. This is the path to your Root Directory.<br>
Use this info to set the path to the settings.php file.<br><br>";
echo "Path Info: ".$HTTP_SERVER_VARS["DOCUMENT_ROOT"]."<br><br><br>";

//echo "PHP Config File Path: ".get_cfg_var("cfg_file_path")."<br><br>";
//echo "PHP magic_quotes_gpc: ".get_magic_quotes_gpc()."<br><br>";
//echo "PHP path info: ".$PATH_INFO."<br><br>"; 
//echo "PHP Path Info: ".$PATH_TRANSLATED."<br><br>";
//echo "script: ".$SCRIPT_NAME."<br><br>";


//echo "PHP Logo: ".php_logo_guid()."<br><br>";

//$iniar = ini_get_all();

//foreach($iniar as $k1 => $v1) {
//    echo $k1. " = ".$v1."<br><br>";
//}

//phpinfo()

?>